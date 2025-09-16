<?php

namespace App\Controllers;

use App\Models\PostModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\NotificationModel;
use CodeIgniter\Pager\PagerRenderer;
use App\Models\AssetModel;



class PostController extends BaseController
{
    protected $PostModel; // Tambahkan properti model
    public function __construct()
    {
        $this->PostModel = new PostModel(); // Muat model di konstruktor
    }
    // public function store()
    // {
    //     log_message('info', 'Fungsi store dipanggil.');

    //     $postModel = new PostModel();
    //     $timestamp = date('Y-m-d H:i:s');

    //     $jenis_aset_lainnya = $this->request->getPost('jenis_aset_lainnya');
    //     $combinedAsset = $jenis_aset_lainnya ? $jenis_aset_lainnya : $this->request->getPost('jenis_aset');

    //     $kondisi_aset_lainnya = $this->request->getPost('kondisi_aset_lainnya');
    //     $combinedKondisiAsset = $kondisi_aset_lainnya ? $kondisi_aset_lainnya : $this->request->getPost('kondisi_aset');

    //     $data = [
    //         'nama' => $this->request->getPost('nama'),
    //         'nomor_aset' => $this->request->getPost('nomor_aset'),
    //         'jenis_aset' => $combinedAsset,
    //         'merk' => $this->request->getPost('merk'),
    //         'nup' => $this->request->getPost('nup'),
    //         'kondisi_aset' => $combinedKondisiAsset,
    //         'deskripsi' => $this->request->getPost('deskripsi'),
    //         'lokasi' => $this->request->getPost('lokasi'),
    //         'created_at' => $timestamp,
    //         'status' => 'Dalam Proses',
    //     ];

    //     if ($postModel->insert($data)) {
    //         $this->sendEmailNotification($data);//ngebuat berat jadi ntar di optimasi
    //         $adminMessage = 'Laporan baru diterima dari ' . $data['nama'] . ' ' . $data['jenis_aset'] . ' ' . $data['merk'] . ' ' . $data['nomor_aset'] . ' ' . $data['kondisi_aset'] . ' ' . $data['deskripsi'];
    //         $this->sendRealtimeNotification($adminMessage);

    //     } else {
    //         return redirect()->back()->with('error', 'Data gagal disimpan.');
    //     }
    //     log_message('info', 'Fungsi store dipanggil dengan data: ' . json_encode($this->request->getPost()));

    //     return redirect()->to('user')->with('success', 'Data berhasil disimpan.');
    // }

    public function store()
    {
        log_message('info', 'Fungsi store dipanggil.');

        $postModel = new PostModel();
        $notificationModel = new NotificationModel(); // Tambahkan model notifikasi
        $assetModel = new AssetModel(); // Tambahkan AssetModel
        $timestamp = date('Y-m-d H:i:s');

        $jenis_aset_lainnya = $this->request->getPost('jenis_aset_lainnya');
        $combinedAsset = $jenis_aset_lainnya ? $jenis_aset_lainnya : $this->request->getPost('jenis_aset');

        $kondisi_aset_lainnya = $this->request->getPost('kondisi_aset_lainnya');
        $combinedKondisiAsset = $kondisi_aset_lainnya ? $kondisi_aset_lainnya : $this->request->getPost('kondisi_aset');

        $assetModel = new AssetModel();
        $assetExists = $assetModel->where('nup', $this->request->getPost('nup'))->first();

        if (!$assetExists) {
            return redirect()->back()->withInput()->with('error', 'NUP tidak ditemukan di database.');
        }
        $nomor_aset = $this->request->getPost('nomor_aset');

        $data = [
            'nama' => $this->request->getPost('nama'),
            'nomor_aset' => $nomor_aset,
            'jenis_aset' => $combinedAsset,
            'nup' => $this->request->getPost('nup'),
            'merk' => $this->request->getPost('merk'),
            'kondisi_aset' => $combinedKondisiAsset,
            'deskripsi' => $this->request->getPost('deskripsi'),
            'lokasi' => $this->request->getPost('lokasi'),
            'created_at' => $timestamp,
            'status' => 'Dalam Proses',
        ];

        if ($postModel->insert($data)) {
            // **Cari aset di database berdasarkan nomor aset**
            $aset = $assetModel->where('kode_barang', $nomor_aset)->first();
            $notificationModel->insert([
                'message' => 'Pengaduan baru dari ' . $data['nama'] . ' untuk aset ' . $data['nomor_aset'],
                'status' => 'unread',
                'created_at' => date('Y-m-d H:i:s')
            ]);
            if ($aset) {
                // **Update kondisi aset di tabel assets**
                $assetModel->update($aset['id'], ['kondisi' => $combinedKondisiAsset]);
                log_message('info', 'Kondisi aset diperbarui di database.');

                // // $this->sendEmailNotification($data);
                // $adminMessage = 'Laporan baru diterima dari ' . $data['nama'] . ' ' . $data['jenis_aset'] . ' ' . $data['merk'] . ' ' . $data['nomor_aset'] . ' ' . $data['kondisi_aset'] . ' ' . $data['deskripsi'];
                // $this->sendRealtimeNotification($adminMessage);
            } else {
                log_message('warning', 'Aset tidak ditemukan di database. Pengaduan tetap disimpan.');
            }

            return redirect()->to('user')->with('success', 'Data berhasil disimpan.');
        } else {
            return redirect()->back()->with('error', 'Data gagal disimpan.');
        }
    }

    public function adminIndex()
    {
        $pengaduanBaru = $this->PostModel->getPengaduanBaru();
        log_message('info', 'Data pengaduan baru: ' . print_r($pengaduanBaru, true)); // Log untuk debugging

        // Jika pengaduanBaru kosong
        if (empty($pengaduanBaru)) {
            log_message('info', 'Tidak ada pengaduan baru.');
        }

        return view('admin/index', ['pengaduanBaru' => $pengaduanBaru]);
    }



    private function sendEmailNotification($data)
    {
        $email = \Config\Services::email();

        $email->setFrom('broalok009@gmail.com', 'Sistem Pengaduan');
        $email->setTo('gataumales009@gmail.com'); // Email admin
        $email->setSubject('Pengaduan Baru Masuk');
        $email->setMessage("
            <h3>Pengaduan Baru</h3>
            <p><strong>Nama:</strong> {$data['nama']}</p>
            <p><strong>Nomor Aset:</strong> {$data['nomor_aset']}</p>
            <p><strong>Jenis Aset:</strong> {$data['jenis_aset']}</p>
            <p><strong>NUP Aset:</strong> {$data['nup']}</p>
            <p><strong>Merk Aset:</strong> {$data['merk']}</p>
            <p><strong>Kondisi Aset:</strong> {$data['kondisi_aset']}</p>
            <p><strong>Deskripsi:</strong> {$data['deskripsi']}</p>
            <p>Status: {$data['status']}</p>
        ");
        log_message('info', 'Query send email dijalankan.');

        if (!$email->send()) {
            log_message('error', 'Email gagal dikirim: ' . $email->printDebugger(['headers']));
        } else {
            log_message('info', 'Email berhasil dikirim.');
        }

    }


    public function filter()
    {
        $selected_date = $this->request->getPost('selected_date');
        $PostModel = new PostModel();

        $data['laporan'] = $PostModel->getLaporanByDate($selected_date);

        // Get the pager instance
        $pager = $PostModel->pager;

        // Pass the data and pager to the view
        $data['pager'] = $pager;

        return view('user/index', $data);
    }
    // public function filterAdmin()
    // {
    //     $selected_date = $this->request->getPost('selected_date');

    //     // Cek apakah tanggal yang dipilih tidak kosong
    //     if ($selected_date) {
    //         $data['laporan'] = $this->PostModel->getLaporanByDate($selected_date);
    //     } else {
    //         // Tanggal yang dipilih kosong, mungkin tampilkan pesan atau lakukan tindakan lain
    //         $data['laporan'] = [];
    //     }

    //     return view('admin/list', $data);
    // }
    public function filterAdmin()
    {
        $start_date = $this->request->getPost('start_date');
        $end_date = $this->request->getPost('end_date');

        // Cek apakah kedua tanggal tidak kosong
        if ($start_date && $end_date) {
            $data['laporan'] = $this->PostModel->getLaporanByDateRange($start_date, $end_date);
        } else {
            // Jika salah satu tanggal kosong, tampilkan array kosong atau lakukan tindakan lain
            $data['laporan'] = [];
        }

        return view('admin/list', $data);
    }


    public function search()
    {
        $PostModel = new PostModel();

        $search_query = $this->request->getPost('search_query');

        if ($search_query) {
            $data['laporan'] = $this->PostModel->searchLaporan($search_query);
        } else {
            $data['laporan'] = $this->PostModel->getAllLaporan();
        }
        $pager = $PostModel->pager;


        // Pass the data and pager to the view
        $data['pager'] = $pager;

        return view('user/index', $data);
    }
    // public function searchAdmin()
    // {
    //     $search_query = $this->request->getPost('search_query');

    //     if ($search_query) {
    //         $data['laporan'] = $this->PostModel->searchLaporan($search_query);
    //     } else {
    //         // Load all visitors if no search query is provided
    //         $data['laporan'] = $this->PostModel->getAllLaporan();
    //     }

    //     return view('admin/list', $data);
    // }

    public function searchAdmin()
    {
        $search_query = $this->request->getPost('search_query');
        $data = [];

        if ($search_query) {
            $data['laporan'] = $this->PostModel->searchLaporan($search_query);
            $data['search_query'] = $search_query; // Simpan search query ke data untuk view
        } else {
            $data['laporan'] = $this->PostModel->getAllLaporan();
            $data['search_query'] = ''; // Set ke kosong jika tidak ada pencarian
        }

        return view('admin/list', $data);
    }

    public function edit($id)
    {
        $postModel = new PostModel();
        $laporan = $postModel->find($id);

        if (!$laporan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Laporan tidak ditemukan');
        }

        return view('admin/edit_laporan', ['laporan' => $laporan]);
    }

    public function update()
    {
        $id = $this->request->getPost('id');
        $data = [
            'nama' => $this->request->getPost('nama'),
            'nomor_aset' => $this->request->getPost('nomor_aset'),
            'jenis_aset' => $this->request->getPost('jenis_aset'),
            'kondisi_aset' => $this->request->getPost('kondisi_aset'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'lokasi' => $this->request->getPost('lokasi'),
            'status' => $this->request->getPost('status'),
            'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
        ];

        $postModel = new PostModel();
        if ($postModel->update($id, $data)) {
            return redirect()->to('/admin/list')->with('success', 'Laporan berhasil diperbarui');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui laporan');
        }
    }




    public function selesaikanLaporan($laporanId)
    {
        $model = new PostModel();
        $model->selesaikanLaporan($laporanId);

        // Redirect ke halaman utama atau halaman yang sesuai
        return redirect()->to(site_url('admin/list'));
    }

    public function delete($id)
    {
        // Load PengunjungModel
        $laporan = new PostModel();

        // Panggil method model untuk melakukan delete
        $laporan->delete($id);

        // Redirect ke halaman list atau halaman lain setelah delete
        return redirect()->to('/admin/list');
    }




    // public function export()
    // {
    //     $data = $this->PostModel->getAllData();

    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->setTitle('Table List Pengaduan');

    //     $sheet->setCellValue('A1', 'No');
    //     $sheet->setCellValue('B1', 'Nama');
    //     $sheet->setCellValue('C1', 'Nomor Aset');
    //     $sheet->setCellValue('D1', 'Jenis Aset');
    //     $sheet->setCellValue('E1', 'Deskripsi Kerusakan');
    //     $sheet->setCellValue('F1', 'Tanggal Pembuatan Laporan');
    //     $sheet->setCellValue('G1', 'Status');
    //     $sheet->setCellValue('H1', 'Tanggal Selesai Laporan');


    //     $i = 2;
    //     foreach ($data as $row) {
    //         $sheet->setCellValue('A' . $i, $i - 1);
    //         $sheet->setCellValue('B' . $i, $row['nama']);
    //         $sheet->setCellValue('C' . $i, $row['nomor_aset']);
    //         $sheet->setCellValue('D' . $i, $row['jenis_aset']);
    //         $sheet->setCellValue('E' . $i, $row['deskripsi']);
    //         $sheet->setCellValue('F' . $i, $row['lokasi']);
    //         $sheet->setCellValue('G' . $i, $row['created_at']);
    //         $sheet->setCellValue('H' . $i, $row['status']);
    //         $sheet->setCellValue('I' . $i, $row['tanggal_selesai']);
    //         $i++;
    //     }

    //     $writer = new Xlsx($spreadsheet);
    //     $fileName = 'List-Pengaduan-Aset.xlsx';
    //     $writer->save($fileName);
    //     // ...
    //     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //     header('Content-Disposition: attachment; filename="' . $fileName . '"');
    //     header('Content-Transfer-Encoding: binary');
    //     header('Expires: 0');
    //     header('Cache-Control: must-revalidate');
    //     header('Pragma: public');
    //     header('Content-Length: ' . filesize($fileName));

    //     ob_clean();  // Membersihkan buffer output sebelum mengirim file
    //     flush();  // Memastikan semua data buffer terkirim

    //     readfile($fileName);
    //     exit;

    // }

    // public function export()
    // {
    //     // Ambil parameter tanggal dari URL
    //     $start_date = $this->request->getGet('start_date');
    //     $end_date = $this->request->getGet('end_date');

    //     // Cek apakah rentang tanggal diberikan untuk memfilter data
    //     if ($start_date && $end_date) {
    //         $data = $this->PostModel->getLaporanByDateRange($start_date, $end_date);
    //     } else {
    //         $data = $this->PostModel->getAllData();
    //     }

    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $sheet->setTitle('Table List Pengaduan');

    //     // Header kolom
    //     $sheet->setCellValue('A1', 'No');
    //     $sheet->setCellValue('B1', 'Nama');
    //     $sheet->setCellValue('C1', 'Nomor Aset');
    //     $sheet->setCellValue('D1', 'Jenis Aset');
    //     $sheet->setCellValue('E1', 'Jenis Aset');
    //     $sheet->setCellValue('F1', 'Deskripsi Kerusakan');
    //     $sheet->setCellValue('G1', 'Tanggal Pembuatan Laporan');
    //     $sheet->setCellValue('H1', 'Status');
    //     $sheet->setCellValue('I1', 'Tanggal Selesai Laporan');

    //     // Isi data
    //     $i = 2;
    //     foreach ($data as $row) {
    //         $sheet->setCellValue('A' . $i, $i - 1);
    //         $sheet->setCellValue('B' . $i, $row['nama']);
    //         $sheet->setCellValue('C' . $i, $row['nomor_aset']);
    //         $sheet->setCellValue('D' . $i, $row['jenis_aset']);
    //         $sheet->setCellValue('E' . $i, $row['kondisi_aset']);
    //         $sheet->setCellValue('F' . $i, $row['deskripsi']);
    //         $sheet->setCellValue('G' . $i, $row['created_at']);
    //         $sheet->setCellValue('H' . $i, $row['status']);
    //         $sheet->setCellValue('I' . $i, $row['tanggal_selesai']);
    //         $i++;
    //     }

    //     // Proses ekspor
    //     $writer = new Xlsx($spreadsheet);
    //     $fileName = 'List-Pengaduan-Aset.xlsx';
    //     $writer->save($fileName);

    //     // Header untuk download file
    //     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //     header('Content-Disposition: attachment; filename="' . $fileName . '"');
    //     header('Content-Transfer-Encoding: binary');
    //     header('Expires: 0');
    //     header('Cache-Control: must-revalidate');
    //     header('Pragma: public');
    //     header('Content-Length: ' . filesize($fileName));

    //     ob_clean();  // Bersihkan buffer output
    //     flush();     // Pastikan buffer dikirim
    //     readfile($fileName);
    //     exit;
    // }

    public function export()
    {
        // Ambil parameter tanggal dan search_query dari URL
        $start_date = $this->request->getGet('start_date');
        $end_date = $this->request->getGet('end_date');
        $search_query = $this->request->getGet('search_query');

        // Cek apakah ada search query untuk memfilter data
        if ($search_query) {
            $data = $this->PostModel->searchLaporan($search_query);
        } elseif ($start_date && $end_date) {
            $data = $this->PostModel->getLaporanByDateRange($start_date, $end_date);
        } else {
            $data = $this->PostModel->getAllData();
        }


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Table List Pengaduan');

        // Header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Nomor Aset');
        $sheet->setCellValue('D1', 'NUP Aset');
        $sheet->setCellValue('E1', 'Jenis Aset');
        $sheet->setCellValue('F1', 'Merk Aset');
        $sheet->setCellValue('G1', 'Kondisi Aset');
        $sheet->setCellValue('H1', 'Deskripsi Kerusakan');
        $sheet->setCellValue('I1', 'Tanggal Pembuatan Laporan');
        $sheet->setCellValue('J1', 'Status');
        $sheet->setCellValue('K1', 'Tanggal Selesai Laporan');

        // Isi data
        $i = 2;
        foreach ($data as $row) {
            $sheet->setCellValue('A' . $i, $i - 1);
            $sheet->setCellValue('B' . $i, $row['nama']);
            $sheet->setCellValue('C' . $i, $row['nomor_aset']);
            $sheet->setCellValue('D' . $i, $row['NUP']);
            $sheet->setCellValue('E' . $i, $row['jenis_aset']);
            $sheet->setCellValue('F' . $i, $row['merk']);
            $sheet->setCellValue('G' . $i, $row['kondisi_aset']);
            $sheet->setCellValue('H' . $i, $row['deskripsi']);
            $sheet->setCellValue('I' . $i, $row['created_at']);
            $sheet->setCellValue('J' . $i, $row['status']);
            $sheet->setCellValue('K' . $i, $row['tanggal_selesai']);
            $i++;
        }

        // Proses ekspor 
        $writer = new Xlsx($spreadsheet);
        $fileName = 'List-Pengaduan-Aset.xlsx';
        $writer->save($fileName);

        // Header untuk download file
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($fileName));

        ob_clean();
        flush();
        readfile($fileName);
        exit;
    }


    public function index()
    {
        // Inisialisasi model
        $postModel = new PostModel();

        // Data pengguna dengan pagination
        $data = [
            'users' => $postModel->paginate(5),
            'pager' => $postModel->pager,
        ];

        // Data laporan
        $laporan = $postModel->getLapor();
        $data['laporan'] = $laporan;

        // Data pengaduan baru
        $pengaduanBaru = $postModel->getPengaduanBaru();
        $data['pengaduanBaru'] = $pengaduanBaru;

        return view('user/index', $data);
    }

    public function getLaporanStats()
    {
        $year = $this->request->getGet('year');
        $bulan = $this->PostModel->getLaporanStats($year);
        return $this->response->setJSON($bulan);
    }

    public function GetAssetsData()
    {
        $year = $this->request->getGet('year');
        $assetsData = $this->PostModel->getAssetsData($year);

        return $this->response->setJSON($assetsData);
    }



    public function testEmail()
    {
        $data = [
            'nama' => 'nigga User',
            'nomor_aset' => '123456',
            'jenis_aset' => 'Laptop',
            'kondisi_aset' => 'Rusak',
            'deskripsi' => 'Layar pecah',
            'status' => 'Dalam Proses',
        ];

        $this->sendEmailNotification($data);
        echo "Email test telah dikirim.";
        log_message('info', 'Query Testemail dijalankan.');

    }


    private function sendRealtimeNotification($message)
    {
        $url = 'http://localhost:3001/send-notification';
        $data = json_encode(['message' => $message]);

        $options = [
            'http' => [
                'header' => "Content-Type: application/json\r\n",
                'method' => 'POST',
                'content' => $data,
            ],
        ];
        $context = stream_context_create($options);
        file_get_contents($url, false, $context);
    }


    public function ListAsset()
    {
        $model = new AssetModel();
        $data['assets'] = $model->getAllAssets();
        return view('admin/list_aset', $data);
    }


    public function checkNup()
    {
        $nup = $this->request->getPost('nup');
        $kode_barang = $this->request->getPost('kode_barang');
        $assetModel = new AssetModel();

        // Mengecek apakah NUP ditemukan
        $asetByNup = $assetModel->where('nup', $nup)->first();

        // Mengecek apakah Kode Barang ditemukan
        $asetByKodeBarang = $assetModel->where('kode_barang', $kode_barang)->first();

        // Mengembalikan respons JSON, mengecek apakah NUP dan Kode Barang ditemukan
        return $this->response->setJSON([
            'nupFound' => $asetByNup ? true : false,
            'kodeBarangFound' => $asetByKodeBarang ? true : false
        ]);
    }


}
