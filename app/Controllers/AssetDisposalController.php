<?php

namespace App\Controllers;

use App\Models\AssetDisposalModel;
use App\Models\AssetUsageModel;
use App\Models\AssetMaintenanceModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\AssetModel;
use CodeIgniter\Controller;

class AssetDisposalController extends Controller
{
    protected $db;

    protected $assetDisposalModel;
    protected $assetModel;
    protected $assetUsageModel;
    protected $assetMaintenanceModel;

    public function __construct()
    {
        $this->assetDisposalModel = new AssetDisposalModel();
        $this->assetModel = new AssetModel();
        $this->assetUssageModel = new AssetUsageModel();
        $this->assetMaintenanceModel = new AssetMaintenanceModel();
        $this->db = \Config\Database::connect(); // **Inisialisasi koneksi database**

    }

    public function index()
    {
        $data['disposals'] = $this->assetDisposalModel
            ->select('asset_disposal.*, assets.kode_barang, assets.nup, assets.nama_barang, assets.merk')
            ->join('assets', 'assets.id = asset_disposal.asset_id', 'left')
            ->orderBy('asset_disposal.created_at', 'DESC')
            ->findAll();

        return view('admin/asset_disposal/index', $data);
    }
    // Menampilkan form permohonan penghapusan
    public function create()
    {
        $data = ['assets' => $this->assetModel->getAllAssets()];  // Mengambil semua aset
        return view('admin/asset_disposal/create', $data);
    }

    // Menyimpan permohonan penghapusan aset
    public function store()
    {
        $validationRules = [
            'asset_id' => 'required|numeric',
            'alasan' => 'required|min_length[5]',
            'nilai_residu' => 'required|decimal',
            'metode' => 'required|in_list[Jual,Hibah,Daur Ulang,Musnahkan]',
            'dokumen_pendukung' => 'uploaded[dokumen_pendukung]|max_size[dokumen_pendukung,2048]|ext_in[dokumen_pendukung,pdf]'
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $dokumen = $this->request->getFile('dokumen_pendukung');

        // **Gunakan nama asli + timestamp agar unik**
        $originalName = pathinfo($dokumen->getClientName(), PATHINFO_FILENAME);
        $timestamp = time();
        $extension = $dokumen->getClientExtension();
        $dokumenName = $originalName . '_' . $timestamp . '.' . $extension;

        $dokumen->move('uploads/dokumen_disposal', $dokumenName);

        $this->assetDisposalModel->save([
            'asset_id' => $this->request->getPost('asset_id'),
            'alasan' => $this->request->getPost('alasan'),
            'nilai_residu' => $this->request->getPost('nilai_residu'),
            'metode' => $this->request->getPost('metode'),
            'status' => 'Menunggu Persetujuan',
            'dokumen_pendukung' => $dokumenName
        ]);

        return redirect()->to('/admin/asset_disposal')->with('success', 'Permohonan penghapusan aset diajukan.');
    }


    // Method show, approve, reject tetap sama dengan integrasi AssetModel di atas


    // Menampilkan detail permohonan penghapusan
    public function show($id)
    {
        $data['disposal'] = $this->assetDisposalModel->getDisposalById($id);
        return view('admin/asset_disposal/show', $data);
    }
    public function terasa($id)
    {
        helper('auth');
        $groupModel = new \Myth\Auth\Authorization\GroupModel();
        $userGroups = $groupModel->getGroupsForUser(user_id());
        $userGroupNames = array_column($userGroups, 'name');

        if (!in_array('iPDS', $userGroupNames)) {
            return $this->response->setJSON(['error' => 'Anda tidak memiliki izin untuk menyetujui penghapusan aset.'], 403);
        }

        $disposal = $this->assetDisposalModel->find($id);
        if (!$disposal) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Permohonan tidak ditemukan']);
        }

        $this->assetDisposalModel->update($id, ['status' => 'Disetujui']);
        return $this->response->setJSON(['success' => true, 'message' => 'Permohonan disetujui dan aset telah dihapus']);
    }

    public function teras($id)
    {
        helper('auth');
        $groupModel = new \Myth\Auth\Authorization\GroupModel();
        $userGroups = $groupModel->getGroupsForUser(user_id());
        $userGroupNames = array_column($userGroups, 'name');

        if (!in_array('iPDS', $userGroupNames)) {
            return $this->response->setJSON(['error' => 'Anda tidak memiliki izin untuk menolak penghapusan aset.'], 403);
        }

        $this->assetDisposalModel->update($id, ['status' => 'Ditolak']);
        return $this->response->setJSON(['success' => true, 'message' => 'Permohonan penghapusan aset ditolak']);
    }

    // Menyetujui penghapusan aset
    public function approve($id)
    {
        $disposal = $this->assetDisposalModel->find($id);
        if (!$disposal) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Permohonan tidak ditemukan']);
        }

        // Cek apakah aset masih digunakan atau dalam pemeliharaan
        $assetUsage = $this->db->table('asset_usage')
            ->where('asset_id', $disposal['asset_id'])
            ->where('status', 'Digunakan')
            ->countAllResults();

        $assetMaintenance = $this->db->table('asset_maintenance')
            ->where('asset_id', $disposal['asset_id'])
            ->where('status !=', 'Selesai')
            ->countAllResults();

        if ($assetUsage > 0 || $assetMaintenance > 0) {
            return $this->response->setJSON(['error' => 'Aset masih digunakan atau dalam pemeliharaan.']);
        }

        // Update status permohonan penghapusan aset
        $this->assetDisposalModel->update($id, ['status' => 'Disetujui']);

        // Hapus aset dari daftar aset aktif (misalnya, ubah statusnya di tabel assets)
        $this->db->table('assets')
            ->where('id', $disposal['asset_id'])
            ->update(['status_penggunaan' => 'Dihapus']);

        // Ambil semua pengaduan terkait aset ini
        $pengaduanTerkait = $this->db->table('asset_maintenance')
            ->select('pengaduan_id')
            ->where('asset_id', $disposal['asset_id'])
            ->where('pengaduan_id IS NOT NULL')
            ->get()
            ->getResultArray();

        $pengaduanIds = array_column($pengaduanTerkait, 'pengaduan_id');

        if (!empty($pengaduanIds)) {
            // Update semua pengaduan terkait dengan status "Selesai" dan tambahkan tanggal selesai
            $this->db->table('pengaduan')
                ->whereIn('id', $pengaduanIds)
                ->update([
                    'status' => 'Selesai',
                    'tanggal_selesai' => date('Y-m-d')
                ]);

            log_message('debug', 'Pengaduan yang diperbarui: ' . json_encode($pengaduanIds));
        }

        return $this->response->setJSON(['success' => true, 'message' => 'Permohonan disetujui dan aset telah dihapus']);
    }



    // Menolak penghapusan aset
    public function reject($id)
    {
        $this->assetDisposalModel->update($id, ['status' => 'Ditolak']);
        return redirect()->to('/admin/asset_disposal')->with('success', 'Permohonan penghapusan aset ditolak.');
    }

    public function delete($id)
    {
        $disposal = $this->assetDisposalModel->find($id);
        if (!$disposal) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Permohonan tidak ditemukan']);
        }

        $this->assetDisposalModel->delete($id);

        return $this->response->setJSON(['success' => true, 'message' => 'Permohonan telah dihapus']);
    }
    public function getDetail($id)
    {
        $disposal = $this->assetDisposalModel
            ->select('asset_disposal.*, assets.kode_barang, assets.nup, assets.nama_barang, assets.merk')
            ->join('assets', 'assets.id = asset_disposal.asset_id', 'left')
            ->where('asset_disposal.id', $id)
            ->first();

        if (!$disposal) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Permohonan tidak ditemukan']);
        }

        return $this->response->setJSON(['success' => true, 'disposal' => $disposal]);
    }

    public function export()
    {
        $disposals = $this->assetDisposalModel
            ->select('
                asset_disposal.*, 
                assets.nama_barang
            ')
            ->join('assets', 'assets.id = asset_disposal.asset_id')
            ->orderBy('asset_disposal.created_at', 'DESC')
            ->findAll();

        // Buat file Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Penghapusan Aset');

        // Header kolom
        $sheet->fromArray([
            'No',
            'Nama Aset',
            'Alasan',
            'Nilai Residu',
            'Metode Penghapusan',
            'Status',
            'Tanggal Permohonan',
            'Dokumen Pendukung'
        ], NULL, 'A1');

        $row = 2;
        foreach ($disposals as $index => $d) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $d['nama_barang']);
            $sheet->setCellValue('C' . $row, $d['alasan']);
            $sheet->setCellValue('D' . $row, $d['nilai_residu']);
            $sheet->setCellValue('E' . $row, $d['metode']);
            $sheet->setCellValue('F' . $row, $d['status']);
            $sheet->setCellValue('G' . $row, $d['created_at']);

            // Dokumen Pendukung - dengan hyperlink
            if (!empty($d['dokumen_pendukung'])) {
                $fileUrl = base_url('uploads/dokumen_disposal/' . $d['dokumen_pendukung']); // sesuaikan path upload
                $sheet->setCellValue('H' . $row, 'Download');
                $sheet->getCell('H' . $row)->getHyperlink()->setUrl($fileUrl);
            } else {
                $sheet->setCellValue('H' . $row, '-');
            }

            $row++;
        }

        // Output file
        $fileName = 'Penghapusan_Aset.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }


}
