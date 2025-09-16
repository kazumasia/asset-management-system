<?php

namespace App\Controllers;

use App\Models\AssetModel;
use CodeIgniter\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AssetController extends BaseController
{
    public function __construct()
    {
        $this->assetModel = new AssetModel();
    }
    public function create()
    {
        $assetPlanModel = new \App\Models\AssetPlanModel();
        $data['approvedPlans'] = $assetPlanModel->getApprovedPlans();

        return view('admin/create_listAset', $data);
    }
    public function edit($id)
    {
        $assetModel = new AssetModel();
        $asset = $assetModel->find($id);

        if (!$asset) {
            return redirect()->to('/assets')->with('error', 'Aset tidak ditemukan!');
        }

        return view('admin/edit_ListAsset', ['asset' => $asset]);
    }
    public function update($id)
    {
        $assetModel = new AssetModel();

        $data = $this->request->getPost();

        $assetModel->update($id, $data);
        return redirect()->to('/admin/assets')->with('success', 'Aset berhasil diperbarui!');
    }

    public function store()
    {
        $assetModel = new AssetModel();

        $data = [
            'jenis_bmn' => $this->request->getPost('jenis_bmn'),
            'kode_barang' => $this->request->getPost('kode_barang'),
            'kode_satker' => $this->request->getPost('kode_satker'),
            'nama_satker' => $this->request->getPost('nama_satker'),
            'nup' => $this->request->getPost('nup'),
            'nama_barang' => $this->request->getPost('nama_barang'),
            'merk' => $this->request->getPost('merk'),
            'tipe' => $this->request->getPost('tipe'),
            'kondisi' => $this->request->getPost('kondisi'),
            'umur_aset' => $this->request->getPost('umur_aset'),
            'intra_extra' => $this->request->getPost('intra_extra'),
            'tanggal_perolehan' => $this->request->getPost('tanggal_perolehan'),
            'nilai_perolehan' => $this->request->getPost('nilai_perolehan'),
            'nilai_penyusutan' => $this->request->getPost('nilai_penyusutan'),
            'nilai_buku' => $this->request->getPost('nilai_buku'),
            'status_penggunaan' => $this->request->getPost('status_penggunaan'),
            'no_psp' => $this->request->getPost('no_psp'),
            'tanggal_psp' => $this->request->getPost('tanggal_psp'),
        ];

        $this->assetModel->insert($data);
        return redirect()->to('/admin/assets')->with('success', ' aset berhasil disimpan.');

    }
    public function delete($id)
    {
        $this->assetModel->delete($id);
        return redirect()->to('/admin/assets')->with('success', 'Rencana aset berhasil dihapus.');

    }
    public function getAssetsData()
    {
        $model = new AssetModel();

        $assets = $model->whereIn('kondisi', ['Rusak', 'Rusak Ringan', 'Rusak Berat'])->findAll();

        $result = [];
        $total = 0;

        foreach ($assets as $asset) {
            $jenis = $asset['nama_barang'];
            $kondisi = $asset['kondisi'];

            if (!isset($result[$jenis])) {
                $result[$jenis] = [
                    'Rusak Ringan' => 0,
                    'Rusak Berat' => 0,
                    'Total' => 0
                ];
            }

            $result[$jenis][$kondisi]++;
            $result[$jenis]['Total']++;
            $total++;
        }

        $data = [];
        foreach ($result as $jenis => $jumlah) {
            $data[] = [
                'jenis_aset' => $jenis,
                'rusak_ringan' => $jumlah['Rusak Ringan'],
                'rusak_berat' => $jumlah['Rusak Berat'],
                'total' => $jumlah['Total']
            ];
        }

        return $this->response->setJSON([
            'data' => $data,
            'total' => $total
        ]);
    }
    public function getAssetList()
    {
        $model = new AssetModel();
        $assets = $model->getAllAssets();
        return $this->response->setJSON($assets);
    }



    public function exportAssets()
    {
        $assets = $this->assetModel->getAllAssets();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Aset');

        $sheet->fromArray([
            'No',
            'Jenis BMN',
            'Kode Satker',
            'Nama Satker',
            'Kode Barang',
            'NUP',
            'Nama Barang',
            'Merk',
            'Tipe',
            'Kondisi',
            'Umur Aset',
            'Intra/Extra',
            'Nama',
            'Tanggal Buku Pertama',
            'Tanggal Perolehan',
            'Nilai Perolehan',
            'Nilai Penyusutan',
            'Nilai Buku',
            'Status Penggunaan',
            'No. PSP',
            'Tanggal PSP'
        ], NULL, 'A1');

        $row = 2;
        foreach ($assets as $index => $asset) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $asset['jenis_bmn']);
            $sheet->setCellValue('C' . $row, $asset['kode_satker']);
            $sheet->setCellValue('D' . $row, $asset['nama_satker']);
            $sheet->setCellValue('E' . $row, $asset['kode_barang']);
            $sheet->setCellValue('F' . $row, $asset['nup']);
            $sheet->setCellValue('G' . $row, $asset['nama_barang']);
            $sheet->setCellValue('H' . $row, $asset['merk']);
            $sheet->setCellValue('I' . $row, $asset['tipe']);
            $sheet->setCellValue('J' . $row, $asset['kondisi']);
            $sheet->setCellValue('K' . $row, $asset['umur_aset']);
            $sheet->setCellValue('L' . $row, $asset['intra_extra']);
            $sheet->setCellValue('M' . $row, $asset['nama']);
            $sheet->setCellValue('N' . $row, $asset['tanggal_buku_pertama']);
            $sheet->setCellValue('O' . $row, $asset['tanggal_perolehan']);
            $sheet->setCellValue('P' . $row, $asset['nilai_perolehan']);
            $sheet->setCellValue('Q' . $row, $asset['nilai_penyusutan']);
            $sheet->setCellValue('R' . $row, $asset['nilai_buku']);
            $sheet->setCellValue('S' . $row, $asset['status_penggunaan']);
            $sheet->setCellValue('T' . $row, $asset['no_psp']);
            $sheet->setCellValue('U' . $row, $asset['tanggal_psp']);
            $row++;
        }

        // Output file
        $fileName = 'Data_Aset.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

}
