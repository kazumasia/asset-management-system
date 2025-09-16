<?php

namespace App\Controllers;
use Myth\Auth\Authorization\GroupModel;
use Myth\Auth\Models\UserModel;
use App\Models\AssetPlanModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
helper('auth');

class AssetPlanController extends BaseController
{
    protected $assetPlanModel;

    public function __construct()
    {
        $this->assetPlanModel = new AssetPlanModel();
    }

    public function create()
    {
        helper('auth');
        $groupModel = new \Myth\Auth\Authorization\GroupModel();
        $userGroups = $groupModel->getGroupsForUser(user_id());
        $userGroupNames = array_column($userGroups, 'name');

        if (!in_array('Tata Usaha', $userGroupNames)) {
            return redirect()->to('/admin/asset-plan')->with('error', 'Anda tidak memiliki izin untuk membuat perencanaan aset.');
        }

        return view('admin/asset_plan/create');
    }

    public function store()
    {
        helper('auth');
        $groupModel = new \Myth\Auth\Authorization\GroupModel();
        $userGroups = $groupModel->getGroupsForUser(user_id());
        $userGroupNames = array_column($userGroups, 'name');

        if (!in_array('Tata Usaha', $userGroupNames)) {
            return redirect()->to('/admin/asset-plan')->with('error', 'Anda tidak memiliki izin untuk menambahkan perencanaan aset.');
        }

        $validationRules = [
            'nama_aset' => 'required|min_length[3]',
            'merk' => 'required',
            'estimasi_biaya' => 'required|numeric|greater_than[0]',
            'vendor' => 'required',
            'deskripsi_risiko' => 'required',
            'kategori_risiko' => 'required|in_list[Rendah,Sedang,Tinggi]',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama_aset' => $this->request->getPost('nama_aset'),
            'merk' => $this->request->getPost('merk'),
            'estimasi_biaya' => $this->request->getPost('estimasi_biaya'),
            'vendor' => $this->request->getPost('vendor'),
            'kategori_risiko' => $this->request->getPost('kategori_risiko'),
            'deskripsi_risiko' => $this->request->getPost('deskripsi_risiko'),
            'status' => 'Draft',
        ];

        $this->assetPlanModel->insert($data);

        return redirect()->to('/admin/asset-plan')->with('success', 'Rencana aset berhasil disimpan.');
    }

    // public function create()
    // {
    //     return view('admin/asset_plan/create');
    // }

    // public function store()
    // {
    //     $validationRules = [
    //         'nama_aset' => 'required|min_length[3]',
    //         'merk' => 'required',
    //         'estimasi_biaya' => 'required|numeric|greater_than[0]',
    //         'vendor' => 'required',
    //         'deskripsi_risiko' => 'required',
    //         'kategori_risiko' => 'required|in_list[Rendah,Sedang,Tinggi]',
    //     ];

    //     if (!$this->validate($validationRules)) {
    //         return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    //     }

    //     $data = [
    //         'nama_aset' => $this->request->getPost('nama_aset'),
    //         'merk' => $this->request->getPost('merk'),
    //         'estimasi_biaya' => $this->request->getPost('estimasi_biaya'),
    //         'vendor' => $this->request->getPost('vendor'),
    //         'kategori_risiko' => $this->request->getPost('kategori_risiko'),
    //         'deskripsi_risiko' => $this->request->getPost('deskripsi_risiko'),
    //         'status' => 'Draft', // Default status
    //     ];

    //     $this->assetPlanModel->insert($data);

    //     return redirect()->to('/admin/asset-plan')->with('success', 'Rencana aset berhasil disimpan.');
    // }

    // Tampilkan daftar rencana aset
    public function index()
    {
        $data['plans'] = $this->assetPlanModel->findAll();
        $data['totalAnggaran'] = $this->assetPlanModel->selectSum('estimasi_biaya')->get()->getRow()->estimasi_biaya;

        return view('admin/asset_plan/index', $data);
    }

    // Tampilkan form edit
    public function edit($id)
    {
        $data['plan'] = $this->assetPlanModel->find($id);
        return view('admin/asset_plan/edit', $data);
    }

    // Update data rencana aset
    public function update($id)
    {
        $validationRules = [
            'nama_aset' => 'required|min_length[3]',
            'merk' => 'required',
            'estimasi_biaya' => 'required|numeric|greater_than[0]',
            'vendor' => 'required',
            'deskripsi_risiko' => 'required',
            'kategori_risiko' => 'required|in_list[Rendah,Sedang,Tinggi]',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama_aset' => $this->request->getPost('nama_aset'),
            'merk' => $this->request->getPost('merk'),
            'estimasi_biaya' => $this->request->getPost('estimasi_biaya'),
            'vendor' => $this->request->getPost('vendor'),
            'deskripsi_risiko' => 'required',
            'kategori_risiko' => $this->request->getPost('kategori_risiko'),
        ];

        $this->assetPlanModel->update($id, $data);

        return redirect()->to('/admin/asset-plan')->with('success', 'Rencana aset berhasil diperbarui.');
    }

    // Hapus data rencana aset
    public function delete($id)
    {
        $this->assetPlanModel->delete($id);
        return redirect()->to('/admin/asset-plan')->with('success', 'Rencana aset berhasil dihapus.');

    }


    // public function filterByMonth()
    // {
    //     $month = $this->request->getGet('month');
    //     $year = $this->request->getGet('year');

    //     // Validasi input
    //     if (empty($month) || empty($year)) {
    //         return redirect()->to('/admin/asset-plan')->with('error', 'Bulan dan tahun harus diisi.');
    //     }

    //     // Ambil data berdasarkan bulan dan tahun
    //     $data['plans'] = $this->assetPlanModel
    //         ->where('MONTH(created_at)', $month)
    //         ->where('YEAR(created_at)', $year)
    //         ->findAll();

    //     // Hitung total anggaran per bulan
    //     $data['totalAnggaran'] = $this->assetPlanModel
    //         ->selectSum('estimasi_biaya')
    //         ->where('MONTH(created_at)', $month)
    //         ->where('YEAR(created_at)', $year)
    //         ->get()
    //         ->getRow()->estimasi_biaya;

    //     // Tampilkan view dengan data yang sudah difilter
    //     return view('admin/asset_plan/index', $data);
    // }

    public function getData()
    {
        if ($this->request->isAJAX()) {
            try {
                $search = $this->request->getGet('search');
                $month = $this->request->getGet('month');
                $year = $this->request->getGet('year');

                // Ambil data berdasarkan filter & pencarian
                $data = $this->assetPlanModel->getAllPlans($search, $month, $year);
                $data = $this->assetPlanModel->searchAll($search, $month, $year);

                // Ambil total anggaran berdasarkan filter yang sama
                $totalAnggaran = $this->assetPlanModel->getTotalAnggaran($search, $month, $year);

                return $this->response->setJSON([
                    'success' => true,
                    'data' => $data,
                    'totalAnggaran' => $totalAnggaran
                ]);
            } catch (\Exception $e) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }
        }

        return $this->response->setStatusCode(403)->setJSON(['success' => false, 'message' => 'Forbidden']);
    }



    public function filterByMonth()
    {
        $month = $this->request->getGet('month');
        $year = $this->request->getGet('year');

        $data = $this->assetPlanModel->getPlansByMonthYear($month, $year); // Filter data
        $totalAnggaran = $this->assetPlanModel->getTotalAnggaranByMonthYear($month, $year); // Ambil total anggaran berdasarkan filter
        return $this->response->setJSON([
            'data' => $data,
            'totalAnggaran' => $totalAnggaran
        ]);
    }

    // public function updateStatus($id)
    // {
    //     if (!$this->request->isAJAX()) {
    //         return $this->response->setStatusCode(403)->setJSON(['error' => 'Akses ditolak']);
    //     }

    //     // **Baca JSON dari body request**
    //     $json = $this->request->getBody();
    //     $data = json_decode($json, true);

    //     if (!$data || !isset($data['status'])) {
    //         return $this->response->setStatusCode(400)->setJSON(['error' => 'Request tidak valid']);
    //     }

    //     $status = $data['status'];

    //     if (!in_array($status, ['Draft', 'Pending Approval', 'Approved'])) {
    //         return $this->response->setStatusCode(400)->setJSON(['error' => 'Status tidak valid']);
    //     }

    //     $plan = $this->assetPlanModel->find($id);
    //     if (!$plan) {
    //         return $this->response->setStatusCode(404)->setJSON(['error' => 'Data tidak ditemukan']);
    //     }

    //     try {
    //         $this->assetPlanModel->update($id, ['status' => $status]);

    //         // **Kirim CSRF token baru agar request berikutnya tidak error**
    //         return $this->response->setJSON([
    //             'success' => true,
    //             'message' => 'Status berhasil diperbarui',
    //             'csrfToken' => csrf_hash()
    //         ]);
    //     } catch (\Exception $e) {
    //         return $this->response->setStatusCode(500)->setJSON(['error' => 'Terjadi kesalahan saat memperbarui status.']);
    //     }
    // }
    public function updateStatus($id)
    {
        if (!logged_in()) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Anda harus login untuk melakukan ini']);
        }

        $user = user(); // 🔹 Ambil data user yang login
        $groupModel = new GroupModel();
        $userGroups = $groupModel->getGroupsForUser($user->id);
        $userGroupNames = array_column($userGroups, 'name');

        if (!in_array('pimpinan', $userGroupNames) && !in_array('superadmin', $userGroupNames)) {
            return $this->response->setStatusCode(403)->setJSON(['error' => 'Anda tidak memiliki izin!']);
        }

        // Ambil data JSON dari request
        $json = $this->request->getBody();
        $data = json_decode($json, true);

        if (!$data || !isset($data['status'])) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Request tidak valid']);
        }

        $model = new AssetPlanModel();
        if ($model->update($id, ['status' => $data['status']])) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Status berhasil diperbarui',
                'csrfToken' => csrf_hash()
            ]);
        } else {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Gagal memperbarui status']);
        }
    }


    public function export()
    {
        $search = $this->request->getGet('search');
        $month = $this->request->getGet('month');
        $year = $this->request->getGet('year');

        // Ambil data sesuai filter
        $plans = $this->assetPlanModel->searchAll($search, $month, $year);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Rencana Aset');

        // Header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Tanggal');
        $sheet->setCellValue('C1', 'Nama Aset');
        $sheet->setCellValue('D1', 'Merk');
        $sheet->setCellValue('E1', 'Estimasi Biaya');
        $sheet->setCellValue('F1', 'Vendor');
        $sheet->setCellValue('G1', 'Kategori Risiko');
        $sheet->setCellValue('H1', 'Deskripsi Risiko');
        $sheet->setCellValue('I1', 'Status');

        // Isi data
        $rowIndex = 2;
        foreach ($plans as $index => $plan) {
            $sheet->setCellValue('A' . $rowIndex, $index + 1);
            $sheet->setCellValue('B' . $rowIndex, date('d-m-Y', strtotime($plan['created_at'])));
            $sheet->setCellValue('C' . $rowIndex, $plan['nama_aset']);
            $sheet->setCellValue('D' . $rowIndex, $plan['merk']);
            $sheet->setCellValue('E' . $rowIndex, $plan['estimasi_biaya']);
            $sheet->setCellValue('F' . $rowIndex, $plan['vendor']);
            $sheet->setCellValue('G' . $rowIndex, $plan['kategori_risiko']);
            $sheet->setCellValue('H' . $rowIndex, $plan['deskripsi_risiko']);
            $sheet->setCellValue('I' . $rowIndex, $plan['status']);
            $rowIndex++;
        }

        // Export langsung ke browser
        $fileName = 'Export-Rencana-Aset.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

}