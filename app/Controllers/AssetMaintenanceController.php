<?php

namespace App\Controllers;

use App\Models\AssetMaintenanceModel;
use App\Models\AssetModel;
use App\Models\PostModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AssetMaintenanceController extends BaseController
{
    protected $maintenanceModel;
    protected $assetModel;
    protected $postModel;

    public function __construct()
    {
        $this->maintenanceModel = new AssetMaintenanceModel();
        $this->assetModel = new AssetModel();
        $this->postModel = new PostModel();
    }

    // Menampilkan daftar pemeliharaan aset
    public function index()
    {
        $data['maintenance'] = $this->maintenanceModel
            ->select('
            asset_maintenance.*, 
            assets.kode_barang, 
            assets.nup, 
            assets.nama_barang, 
            assets.merk, 
            assets.kondisi
        ')
            ->join('assets', 'assets.id = asset_maintenance.asset_id')
            ->orderBy('asset_maintenance.jadwal_pemeliharaan', 'DESC')
            ->findAll();

        // Format tanggal ke "12 Februari 2024"
        foreach ($data['maintenance'] as &$m) {
            $m['jadwal_pemeliharaan'] = $this->formatTanggal($m['jadwal_pemeliharaan']);
            if ($m['updated_at']) {
                $m['updated_at'] = $this->formatTanggal($m['updated_at']);
            }
        }

        return view('admin/asset_maintenance/index', $data);
    }

    // Fungsi untuk mengubah tanggal ke format "12 Februari 2024"
    private function formatTanggal($date)
    {
        if (!$date)
            return '-';
        $bulanIndo = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];
        $tanggal = date('d', strtotime($date));
        $bulan = $bulanIndo[(int) date('m', strtotime($date)) - 1];
        $tahun = date('Y', strtotime($date));
        return "$tanggal $bulan $tahun";
    }


    // Form tambah pemeliharaan
    public function create()
    {
        $data['assets'] = $this->assetModel
            ->select('
            assets.id, 
            assets.kode_barang, 
            assets.nup, 
            assets.nama_barang, 
            assets.merk, 
            COALESCE(complaint.kondisi_aset, assets.kondisi) AS kondisi_barang, 
            COALESCE(complaint.deskripsi, "Tanpa Keluhan") AS deskripsi_pengaduan, 
            complaint.id AS pengaduan_id  
        ')
            ->join('complaint', 'complaint.nomor_aset = assets.kode_barang AND complaint.nup = assets.nup', 'left') // 🔥 Ubah `kode_barang` ke `nomor_aset`
            ->groupBy('assets.id, assets.kode_barang, assets.nup, assets.nama_barang, assets.merk, assets.kondisi, complaint.id, complaint.deskripsi, complaint.kondisi_aset')
            ->orderBy('assets.kode_barang', 'ASC')
            ->orderBy('assets.nup', 'ASC')
            ->findAll();

        // 🔥 Sesuaikan pengambilan data dari tabel `pengaduan`
        $data['pengaduan'] = $this->postModel
            ->select('id, nomor_aset AS kode_barang, nup, status') // 🔥 Ubah `nomor_aset` menjadi `kode_barang` untuk keseragaman
            ->where('status !=', 'Selesai')
            ->findAll();

        return view('admin/asset_maintenance/create', $data);
    }




    public function updateStatus($id)
    {
        $newStatus = $this->request->getPost('status');
        if (!in_array($newStatus, ['Dijadwalkan', 'Dalam Proses', 'Selesai'])) {
            return $this->response->setJSON(['error' => 'Status tidak valid']);
        }

        $maintenance = $this->maintenanceModel->find($id);
        if (!$maintenance) {
            return $this->response->setJSON(['error' => 'Pemeliharaan tidak ditemukan']);
        }

        // Data yang akan diperbarui
        $updateData = ['status' => $newStatus];

        // Jika status menjadi "Selesai", tambahkan tanggal selesai
        if ($newStatus === 'Selesai') {
            $updateData['tanggal_selesai'] = date('Y-m-d'); // Format YYYY-MM-DD
        }

        // **Update status pemeliharaan di database**
        $this->maintenanceModel->update($id, $updateData);

        // **Update semua pengaduan yang terkait**
        if ($newStatus === 'Selesai' && !empty($maintenance['pengaduan_id'])) {
            // Pecah pengaduan_id menjadi array
            $pengaduanIds = explode(',', $maintenance['pengaduan_id']);

            if (!empty($pengaduanIds)) {
                // **Update semua pengaduan yang terkait**
                $this->postModel->whereIn('id', $pengaduanIds)->set([
                    'status' => 'Selesai',
                    'tanggal_selesai' => date('Y-m-d')
                ])->update();
            }
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Status pemeliharaan dan semua pengaduan terkait diperbarui.'
        ]);
    }









    // Simpan pemeliharaan baru
    // public function store()
    // {
    //     $data = [
    //         'asset_id' => $this->request->getPost('asset_id'),
    //         'pengaduan_id' => $this->request->getPost('pengaduan_id'),
    //         'jadwal_pemeliharaan' => $this->request->getPost('jadwal_pemeliharaan'),
    //         'teknisi' => $this->request->getPost('teknisi'),
    //         'biaya' => $this->request->getPost('biaya'),
    //         'status' => 'Dijadwalkan',
    //         'catatan' => $this->request->getPost('catatan'),
    //     ];

    //     $this->maintenanceModel->insert($data);

    //     // Kirim notifikasi ke admin tentang pemeliharaan baru
    //     $socketData = [
    //         'message' => "🔧 Pemeliharaan aset ID {$data['asset_id']} dijadwalkan pada {$data['jadwal_pemeliharaan']}"
    //     ];

    //     $this->sendSocketNotification('maintenance-reminder', $socketData);

    //     return redirect()->to('/admin/asset_maintenance')->with('success', 'Pemeliharaan aset berhasil ditambahkan.');
    // }

    // public function store()
    // {
    //     // Ambil input dari form
    //     $asset_id = $this->request->getPost('asset_id');
    //     $pengaduan_id = $this->request->getPost('pengaduan_id'); // Ambil pengaduan_id

    //     $data = [
    //         'asset_id' => $asset_id,
    //         'pengaduan_id' => !empty($pengaduan_id) ? $pengaduan_id : null, // Pastikan pengaduan_id bisa null jika tidak ada
    //         'jadwal_pemeliharaan' => $this->request->getPost('jadwal_pemeliharaan'),
    //         'teknisi' => $this->request->getPost('teknisi'),
    //         'biaya' => $this->request->getPost('biaya'),
    //         'status' => 'Dalam Pemeliharaan',
    //         'catatan' => $this->request->getPost('catatan'),
    //     ];

    //     // Simpan data ke tabel asset_maintenance
    //     if ($this->maintenanceModel->insert($data)) {
    //         $maintenance_id = $this->maintenanceModel->insertID(); // Ambil ID terakhir

    //         // Pastikan data tersimpan
    //         if (!$maintenance_id) {
    //             log_message('error', 'Gagal menyimpan data pemeliharaan.');
    //             return redirect()->back()->with('error', 'Gagal menyimpan pemeliharaan.');
    //         }

    //         // Jika ada pengaduan terkait, update status pengaduan menjadi "Dalam Pemeliharaan"
    //         if (!empty($pengaduan_id)) {
    //             $updated = $this->postModel->update($pengaduan_id, ['status' => 'Dalam Pemeliharaan']);

    //             if (!$updated) {
    //                 log_message('error', "Gagal mengupdate status pengaduan ID: $pengaduan_id");
    //             }
    //         }

    //         return redirect()->to('/admin/asset_maintenance')->with('success', 'Pemeliharaan aset berhasil ditambahkan.');
    //     } else {
    //         return redirect()->back()->with('error', 'Gagal menyimpan pemeliharaan.');
    //     }
    // }

    public function store()
    {
        if (
            !$this->validate([
                'asset_id' => 'required',
                'jadwal_pemeliharaan' => 'required|valid_date',
                'teknisi' => 'required|min_length[3]',
                'biaya' => 'required|numeric'
            ])
        ) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $asset_id = $this->request->getPost('asset_id');
        $jadwalPemeliharaan = $this->request->getPost('jadwal_pemeliharaan');
        $teknisi = $this->request->getPost('teknisi');
        $biaya = $this->request->getPost('biaya');
        $catatan = $this->request->getPost('catatan');

        // Ambil kode_barang & NUP berdasarkan asset_id
        $asset = $this->assetModel->find($asset_id);
        if (!$asset) {
            return redirect()->back()->with('error', 'Aset tidak ditemukan.');
        }

        $kodeBarang = $asset['kode_barang'];
        $nup = $asset['nup'];

        // Ambil semua pengaduan yang memiliki nomor_aset & NUP yang sama yang belum selesai
        $pengaduanList = $this->postModel
            ->where('nomor_aset', $kodeBarang)
            ->where('nup', $nup)
            ->where('status !=', 'Selesai')
            ->findAll();

        // Ambil semua ID pengaduan yang terkait
        $pengaduanIds = !empty($pengaduanList) ? array_column($pengaduanList, 'id') : [];
        $pengaduanIdsString = !empty($pengaduanIds) ? implode(',', $pengaduanIds) : null;

        log_message('debug', 'Pengaduan yang masuk ke pemeliharaan: ' . print_r($pengaduanIds, true));

        // Cek apakah sudah ada pemeliharaan untuk aset ini yang belum selesai
        $existingMaintenance = $this->maintenanceModel
            ->where('asset_id', $asset_id)
            ->where('status !=', 'Selesai')
            ->first();

        if ($existingMaintenance) {
            return redirect()->to('/admin/asset_maintenance')->with('warning', 'Pemeliharaan untuk aset ini sudah ada.');
        }

        // Simpan satu pemeliharaan untuk semua pengaduan terkait
        $this->maintenanceModel->insert([
            'asset_id' => $asset_id,
            'pengaduan_id' => $pengaduanIdsString, // Simpan semua pengaduan dalam satu pemeliharaan
            'jadwal_pemeliharaan' => $jadwalPemeliharaan,
            'teknisi' => $teknisi,
            'biaya' => $biaya,
            'status' => 'Dijadwalkan',
            'catatan' => $catatan
        ]);

        // Jika ada pengaduan terkait, update statusnya ke "Dalam Pemeliharaan"
        if (!empty($pengaduanIds)) {
            $this->postModel->whereIn('id', $pengaduanIds)->set(['status' => 'Dalam Pemeliharaan'])->update();
        }

        return redirect()->to('/admin/asset_maintenance')->with('success', 'Pemeliharaan aset berhasil ditambahkan.');
    }





    // Form edit pemeliharaan
    public function edit($id)
    {
        $data['maintenance'] = $this->maintenanceModel->find($id);
        return view('admin/asset_maintenance/edit', $data);
    }

    // Update data pemeliharaan
    public function update($id)
    {
        $data = [
            'jadwal_pemeliharaan' => $this->request->getPost('jadwal_pemeliharaan'),
            'teknisi' => $this->request->getPost('teknisi'),
            'biaya' => $this->request->getPost('biaya'),
            'status' => $this->request->getPost('status'),
            'catatan' => $this->request->getPost('catatan'),
        ];

        $this->maintenanceModel->update($id, $data);

        // Jika pemeliharaan selesai, update aset & pengaduan
        if ($data['status'] == 'Selesai') {
            $maintenance = $this->maintenanceModel->find($id);
            $this->assetModel->update($maintenance['asset_id'], ['kondisi' => 'Baik']);

            if ($maintenance['pengaduan_id']) {
                $this->postModel->update($maintenance['pengaduan_id'], ['status' => 'Selesai']);
            }
        }

        return redirect()->to('/admin/asset_maintenance')->with('success', 'Data pemeliharaan diperbarui.');
    }

    // Hapus pemeliharaan
    public function delete($id)
    {
        $this->maintenanceModel->delete($id);
        return redirect()->to('/admin/asset_maintenance')->with('success', 'Pemeliharaan dihapus.');
    }

    // Cek aset yang harus dipelihara dalam 7 hari ke depan
    public function checkUpcomingMaintenance()
    {
        $sevenDaysLater = date('Y-m-d', strtotime('+7 days'));

        $upcomingMaintenance = $this->maintenanceModel
            ->where('jadwal_pemeliharaan <=', $sevenDaysLater)
            ->where('status', 'Dijadwalkan')
            ->findAll();

        if (!empty($upcomingMaintenance)) {
            $notifModel = new \App\Models\NotificationModel();

            foreach ($upcomingMaintenance as $maintenance) {
                $notifModel->insert([
                    'user_id' => 1, // ID Admin/teknisi
                    'message' => "Reminder: Pemeliharaan aset ID {$maintenance['asset_id']} dijadwalkan pada {$maintenance['jadwal_pemeliharaan']}",
                    'status' => 'unread',
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
    }
    public function export()
    {
        $search = $this->request->getGet('search');
        $month = $this->request->getGet('month');
        $year = $this->request->getGet('year');

        // Ambil data pemeliharaan dengan join ke tabel aset
        $query = $this->maintenanceModel
            ->select('
                asset_maintenance.*, 
                assets.kode_barang, 
                assets.nup, 
                assets.nama_barang, 
                assets.merk, 
                assets.kondisi
            ')
            ->join('assets', 'assets.id = asset_maintenance.asset_id');

        // Filter pencarian
        if (!empty($search)) {
            $query->groupStart()
                ->like('assets.nama_barang', $search)
                ->orLike('assets.kode_barang', $search)
                ->orLike('assets.nup', $search)
                ->orLike('asset_maintenance.teknisi', $search)
                ->orLike('asset_maintenance.status', $search)
                ->groupEnd();
        }

        if (!empty($month)) {
            $query->where('MONTH(asset_maintenance.jadwal_pemeliharaan)', $month);
        }

        if (!empty($year)) {
            $query->where('YEAR(asset_maintenance.jadwal_pemeliharaan)', $year);
        }

        $data = $query->orderBy('asset_maintenance.jadwal_pemeliharaan', 'DESC')->findAll();

        // Buat file Excel
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Pemeliharaan Aset');

        // Header
        $sheet->fromArray([
            'No',
            'Kode Barang',
            'NUP',
            'Nama Barang',
            'Merk',
            'Kondisi',
            'Jadwal Pemeliharaan',
            'Teknisi',
            'Biaya',
            'Status',
            'Catatan'
        ], NULL, 'A1');

        // Isi data
        $row = 2;
        foreach ($data as $index => $m) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $m['kode_barang']);
            $sheet->setCellValue('C' . $row, $m['nup']);
            $sheet->setCellValue('D' . $row, $m['nama_barang']);
            $sheet->setCellValue('E' . $row, $m['merk']);
            $sheet->setCellValue('F' . $row, $m['kondisi']);
            $sheet->setCellValue('G' . $row, $m['jadwal_pemeliharaan']);
            $sheet->setCellValue('H' . $row, $m['teknisi']);
            $sheet->setCellValue('I' . $row, $m['biaya']);
            $sheet->setCellValue('J' . $row, $m['status']);
            $sheet->setCellValue('K' . $row, $m['catatan']);
            $row++;
        }

        // Output file
        $fileName = 'Pemeliharaan_Aset.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
