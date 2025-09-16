<?php

namespace App\Controllers;

use App\Models\AssetUsageModel;
use App\Models\AssetModel;
use CodeIgniter\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AssetUsageController extends Controller
{
    protected $assetUsageModel;
    protected $assetModel;

    public function __construct()
    {
        $this->assetUsageModel = new AssetUsageModel();
        $this->assetModel = new AssetModel();
    }

    public function index()
    {
        return view('admin/asset_usage/index');
    }

    public function loadData()
    {
        $search = trim(strtolower($this->request->getGet('search')));
        $month = $this->request->getGet('month');
        $year = $this->request->getGet('year');

        $query = $this->assetUsageModel
            ->select('asset_usage.*, 
                asset_usage.tanggal_selesai,
                  assets.kode_barang, 
                  assets.nup, 
                  assets.nama_barang, 
                  assets.merk')
            ->join('assets', 'assets.id = asset_usage.asset_id')
            ->orderBy('asset_usage.created_at', 'DESC');

        // Jika ada pencarian
        if (!empty($search)) {
            $query->groupStart()
                ->orLike('assets.kode_barang', $search)
                ->orLike('assets.nup', $search)
                ->orLike('assets.nama_barang', $search)
                ->orLike('assets.merk', $search)
                ->orLike('asset_usage.pegawai', $search)
                ->orLike('asset_usage.tujuan', $search)
                ->orLike('asset_usage.status', $search)
                ->groupEnd();
        }

        // Filter bulan & tahun jika ada
        if (!empty($month) && !empty($year)) {
            $query->where('MONTH(asset_usage.tanggal_mulai)', $month)
                ->where('YEAR(asset_usage.tanggal_mulai)', $year);
        } elseif (!empty($year)) {
            $query->where('YEAR(asset_usage.tanggal_mulai)', $year);
        }

        $data = $query->findAll();
        return $this->response->setJSON(['data' => $data]);
    }




    public function create()
    {
        helper('auth');
        $groupModel = new \Myth\Auth\Authorization\GroupModel();
        $userGroups = $groupModel->getGroupsForUser(user_id());
        $userGroupNames = array_column($userGroups, 'name');

        // Cek apakah user memiliki role iPDS
        if (!in_array('IPDS', $userGroupNames)) {
            return redirect()->to('/admin/asset_usage')->with('error', 'Anda tidak memiliki izin untuk membuat penggunaan aset.');
        }

        $db = \Config\Database::connect();

        // Ambil aset yang kondisinya baik, belum digunakan, dan tidak dihapus
        $query = "SELECT * FROM assets 
              WHERE kondisi = 'Baik' 
              AND status_penggunaan != 'Dihapus'
              AND id NOT IN (SELECT asset_id FROM asset_usage WHERE status = 'Digunakan')";

        $data['assets'] = $db->query($query)->getResultArray();

        return view('admin/asset_usage/create', $data);
    }



    public function store()
    {
        $assetId = $this->request->getPost('asset_id');

        // Cek apakah aset tersedia
        $asset = $this->assetModel->find($assetId);
        if (!$asset) {
            return redirect()->back()->with('error', 'Aset tidak ditemukan.');
        }

        if ($asset['status_penggunaan'] === 'Dihapus') {
            return redirect()->back()->with('error', 'Aset ini telah dihapus dan tidak bisa digunakan.');
        }

        $isUsed = $this->assetUsageModel->where('asset_id', $assetId)
            ->where('status', 'Digunakan')
            ->countAllResults();

        if ($isUsed > 0) {
            return redirect()->back()->with('error', 'Aset ini sedang digunakan oleh orang lain.');
        }

        // Simpan data penggunaan aset
        $this->assetUsageModel->insert([
            'asset_id' => $assetId,
            'pegawai' => $this->request->getPost('pegawai'),
            'tujuan' => $this->request->getPost('tujuan'),
            'tanggal_mulai' => $this->request->getPost('tanggal_mulai'),
            'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
            'status' => 'Digunakan',
            'keterangan' => $this->request->getPost('keterangan'),
        ]);

        // **Update status aset di tabel assets**
        $this->assetModel->update($assetId, ['status_penggunaan' => 'Digunakan']);

        return redirect()->to('/admin/asset_usage')->with('success', 'Penggunaan aset berhasil dicatat.');
    }



    public function edit($id)
    {
        $usage = $this->assetUsageModel
            ->select('asset_usage.*, assets.kode_barang, assets.nup, assets.nama_barang')
            ->join('assets', 'assets.id = asset_usage.asset_id')
            ->where('asset_usage.id', $id)
            ->first();

        if (!$usage) {
            return redirect()->to('admin/asset_usage')->with('error', 'Data tidak ditemukan.');
        }

        return view('admin/asset_usage/edit', ['usage' => $usage]);
    }


    public function update($id)
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->back()->with('error', 'Metode tidak diizinkan.');
        }

        $data = [
            'pegawai' => $this->request->getPost('pegawai'),
            'tujuan' => $this->request->getPost('tujuan'),
            'tanggal_mulai' => $this->request->getPost('tanggal_mulai'),
            'status' => $this->request->getPost('status'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($data['status'] === 'Dikembalikan') {
            $data['tanggal_selesai'] = date('Y-m-d'); // Jika aset dikembalikan, atur tanggal selesai
        }

        $this->assetUsageModel->update($id, $data);

        return redirect()->to('admin/asset_usage')->with('success', 'Penggunaan aset berhasil diperbarui.');
    }


    public function selesai($id)
    {
        $usage = $this->assetUsageModel->find($id);
        if (!$usage) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Penggunaan aset tidak ditemukan.']);
        }

        // Update status penggunaan aset ke "Dikembalikan"
        $this->assetUsageModel->update($id, [
            'status' => 'Dikembalikan',
            'tanggal_selesai' => date('Y-m-d'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        // **Update status aset ke "Tersedia" di tabel assets**
        $this->assetModel->update($usage['asset_id'], ['status_penggunaan' => 'Tersedia']);

        return $this->response->setJSON(['success' => 'Penggunaan aset berhasil diselesaikan.']);
    }


    public function delete($id)
    {
        if ($this->request->getMethod() !== 'post') {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Akses ditolak!']);
        }

        $usage = $this->assetUsageModel->find($id);
        if (!$usage) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Data tidak ditemukan!']);
        }

        try {
            $this->assetUsageModel->delete($id);
            return $this->response->setJSON(['success' => 'Penggunaan aset berhasil dihapus.']);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Terjadi kesalahan saat menghapus data.']);
        }
    }



    public function export()
    {
        $search = trim(strtolower($this->request->getGet('search')));
        $month = $this->request->getGet('month');
        $year = $this->request->getGet('year');

        $query = $this->assetUsageModel
            ->select('asset_usage.*, assets.kode_barang, assets.nup, assets.nama_barang, assets.merk')
            ->join('assets', 'assets.id = asset_usage.asset_id')
            ->orderBy('asset_usage.created_at', 'DESC');

        if (!empty($search)) {
            $query->groupStart()
                ->orLike('assets.kode_barang', $search)
                ->orLike('assets.nup', $search)
                ->orLike('assets.nama_barang', $search)
                ->orLike('assets.merk', $search)
                ->orLike('asset_usage.pegawai', $search)
                ->orLike('asset_usage.tujuan', $search)
                ->orLike('asset_usage.status', $search)
                ->groupEnd();
        }

        if (!empty($month)) {
            $query->where('MONTH(asset_usage.tanggal_mulai)', $month);
        }

        if (!empty($year)) {
            $query->where('YEAR(asset_usage.tanggal_mulai)', $year);
        }

        $data = $query->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Penggunaan Aset');

        $sheet->fromArray([
            'No',
            'Kode Barang',
            'NUP',
            'Nama Aset',
            'Merk',
            'Pegawai',
            'Tujuan',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Status',
        ], NULL, 'A1');

        $i = 2;
        foreach ($data as $index => $row) {
            $sheet->setCellValue('A' . $i, $index + 1);
            $sheet->setCellValue('B' . $i, $row['kode_barang']);
            $sheet->setCellValue('C' . $i, $row['nup']);
            $sheet->setCellValue('D' . $i, $row['nama_barang']);
            $sheet->setCellValue('E' . $i, $row['merk']);
            $sheet->setCellValue('F' . $i, $row['pegawai']);
            $sheet->setCellValue('G' . $i, $row['tujuan']);
            $sheet->setCellValue('H' . $i, $row['tanggal_mulai']);
            $sheet->setCellValue('I' . $i, $row['tanggal_selesai']);
            $sheet->setCellValue('J' . $i, $row['status']);
            $i++;
        }

        $fileName = 'Penggunaan_Aset.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

}
