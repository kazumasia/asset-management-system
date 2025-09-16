<?php

namespace App\Controllers;
use Myth\Auth\Authorization\GroupModel;
use Myth\Auth\Models\UserModel;
use App\Models\AssetAcquisitionModel;
use App\Models\AssetPlanModel;
helper('auth'); // 🔹 Tambahkan ini!


class AssetAcquisitionController extends BaseController
{
    protected $assetAcquisitionModel;

    public function __construct()
    {
        $this->assetAcquisitionModel = new AssetAcquisitionModel();
        $this->assetPlanModel = new AssetPlanModel();
    }

    public function index()
    {
        $search = $this->request->getGet('search');
        $month = $this->request->getGet('month');
        $year = $this->request->getGet('year');

        $query = $this->assetAcquisitionModel->orderBy('created_at', 'DESC');

        if ($search) {
            $query->like('nama_aset', $search);
        }

        if ($month && $year) {
            $query->where('MONTH(created_at)', $month)->where('YEAR(created_at)', $year);
        } elseif ($year) {
            $query->where('YEAR(created_at)', $year);
        }

        $data = [
            'acquisitions' => $query->findAll(),
            'search' => $search,
            'month' => $month,
            'year' => $year,
        ];

        return view('admin/asset_acquisition/index', $data);
    }

    public function create()
    {
        helper('auth');
        $groupModel = new \Myth\Auth\Authorization\GroupModel();
        $userGroups = $groupModel->getGroupsForUser(user_id());
        $userGroupNames = array_column($userGroups, 'name');
        $assetPlanModel = new \App\Models\AssetPlanModel();
        $data['approvedPlans'] = $assetPlanModel->getApprovedPlans();

        if (!in_array('Tata Usaha', $userGroupNames)) {
            return redirect()->to('/admin/asset_acquisition')->with('error', 'Anda tidak memiliki izin untuk mengajukan akuisisi aset.');
        }

        return view('admin/asset_acquisition/create', $data);
    }

    public function store()
    {
        helper('auth');
        $groupModel = new \Myth\Auth\Authorization\GroupModel();
        $userGroups = $groupModel->getGroupsForUser(user_id());
        $userGroupNames = array_column($userGroups, 'name');

        if (!in_array('Tata Usaha', $userGroupNames)) {
            return redirect()->to('/admin/asset_acquisition')->with('error', 'Anda tidak memiliki izin untuk mengajukan akuisisi aset.');
        }

        $validationRules = [
            'plan_id' => 'required|numeric',
            'jenis_bmn' => 'required',
            'kode_barang' => 'required',
            'kode_satker' => 'required',
            'nama_satker' => 'required',
            'nup' => 'required',
            'nama_barang' => 'required',
            'merk' => 'required',
            'tipe' => 'required',
            'kondisi' => 'required',
            'umur_aset' => 'required|numeric',
            'intra_extra' => 'required',
            'tanggal_perolehan' => 'required|valid_date',
            'nilai_perolehan' => 'required|numeric',
            'nilai_penyusutan' => 'required|numeric',
            'nilai_buku' => 'required|numeric',
            'status_penggunaan' => 'required',
            'no_psp' => 'required',
            'tanggal_psp' => 'required|valid_date',
            'estimasi_biaya' => 'required|numeric',
            'vendor' => 'required',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->request->getPost();
        $data['status'] = 'Menunggu Persetujuan';

        $this->assetAcquisitionModel->insert($data);

        return redirect()->to('/admin/asset_acquisition')->with('success', 'Akuisisi aset berhasil diajukan.');
    }


    public function approve($id)
    {
        helper('auth');
        $groupModel = new GroupModel();
        $userGroups = $groupModel->getGroupsForUser(user_id());
        $userGroupNames = array_column($userGroups, 'name');

        // Cek apakah user termasuk dalam role pimpinan atau superadmin
        if (!in_array('pimpinan', $userGroupNames) && !in_array('superadmin', $userGroupNames)) {
            return redirect()->to('/admin/asset_acquisition')->with('error', 'Anda tidak memiliki izin untuk menyetujui aset.');
        }

        $acquisition = $this->assetAcquisitionModel->find($id);

        if (!$acquisition) {
            return redirect()->to('/admin/asset_acquisition')->with('error', 'Akuisisi aset tidak ditemukan.');
        }

        // Perbarui status akuisisi menjadi "Disetujui"
        $this->assetAcquisitionModel->update($id, ['status' => 'Disetujui']);

        // Load AssetModel
        $assetModel = new \App\Models\AssetModel();

        // Simpan aset ke tabel `assets`
        $newAsset = [
            'jenis_bmn' => $acquisition['jenis_bmn'],
            'kode_satker' => $acquisition['kode_satker'],
            'nama_satker' => $acquisition['nama_satker'],
            'kode_barang' => $acquisition['kode_barang'],
            'nup' => $acquisition['nup'],
            'nama_barang' => $acquisition['nama_aset'],
            'merk' => $acquisition['merk'],
            'tipe' => $acquisition['tipe'],
            'kondisi' => $acquisition['kondisi'],
            'umur_aset' => $acquisition['umur_aset'],
            'intra_extra' => $acquisition['intra_extra'],
            'tanggal_perolehan' => $acquisition['tanggal_perolehan'],
            'nilai_perolehan' => $acquisition['nilai_perolehan'],
            'nilai_penyusutan' => $acquisition['nilai_penyusutan'],
            'nilai_buku' => $acquisition['nilai_buku'],
            'status_penggunaan' => $acquisition['status_penggunaan'],
            'no_psp' => $acquisition['no_psp'],
            'tanggal_psp' => $acquisition['tanggal_psp'],
        ];

        $assetModel->insert($newAsset);

        return redirect()->to('/admin/asset_acquisition')->with('success', 'Akuisisi aset telah disetujui dan aset telah ditambahkan ke daftar aset aktif.');
    }

    public function reject($id)
    {
        helper('auth');
        $groupModel = new \Myth\Auth\Authorization\GroupModel();
        $userGroups = $groupModel->getGroupsForUser(user_id());
        $userGroupNames = array_column($userGroups, 'name');

        if (!in_array('pimpinan', $userGroupNames) && !in_array('superadmin', $userGroupNames)) {
            return redirect()->to('/admin/asset_acquisition')->with('error', 'Anda tidak memiliki izin untuk menolak aset.');
        }

        $this->assetAcquisitionModel->update($id, ['status' => 'Ditolak']);
        return redirect()->to('/admin/asset_acquisition')->with('success', 'Akuisisi aset telah ditolak.');
    }


    public function loadData()
    {
        $search = trim(strtolower($this->request->getGet('search'))); // Hilangkan spasi & ubah ke lowercase
        $month = $this->request->getGet('month');
        $year = $this->request->getGet('year');

        $query = $this->assetAcquisitionModel->orderBy('created_at', 'DESC');

        // Ambil semua data untuk pengecekan typo
        $dataAll = $this->assetAcquisitionModel->findAll();

        // Mapping nama bulan Indonesia ke bahasa Inggris (MySQL default)
        $bulanIndoToEng = [
            'januari' => 'January',
            'februari' => 'February',
            'maret' => 'March',
            'april' => 'April',
            'mei' => 'May',
            'juni' => 'June',
            'juli' => 'July',
            'agustus' => 'August',
            'september' => 'September',
            'oktober' => 'October',
            'november' => 'November',
            'desember' => 'December'
        ];

        if (!empty($search)) {
            $bestMatch = null;
            $shortestDistance = PHP_INT_MAX;
            $highestSimilarity = 0;

            foreach ($dataAll as $row) {
                foreach ($row as $key => $value) {
                    if (!is_string($value))
                        continue;

                    $levDist = levenshtein($search, strtolower($value));
                    similar_text($search, strtolower($value), $similarity);

                    if ($levDist < $shortestDistance) {
                        $bestMatch = $value;
                        $shortestDistance = $levDist;
                    }

                    if ($similarity > $highestSimilarity) {
                        $bestMatch = $value;
                        $highestSimilarity = $similarity;
                    }
                }
            }

            // Jika ditemukan kata yang mirip dengan selisih maksimal 2 huruf atau kemiripan lebih dari 70%
            if ($shortestDistance <= 2 || $highestSimilarity > 70) {
                $search = $bestMatch;
            }

            // Jika pencarian adalah nama bulan Indonesia, konversi ke format MySQL
            if (isset($bulanIndoToEng[$search])) {
                $search = $bulanIndoToEng[$search];
            }

            // Pencarian di semua kolom
            $query->groupStart()
                ->orLike('nama_aset', $search)
                ->orLike('merk', $search)
                ->orLike('estimasi_biaya', $search)
                ->orLike('vendor', $search)
                ->orLike('status', $search)
                ->orWhere("DATE_FORMAT(created_at, '%M')", $search) // Mencari nama bulan dalam format MySQL
                ->groupEnd();
        }

        // Filter berdasarkan bulan & tahun jika ada
        if (!empty($month) && !empty($year)) {
            $query->where('MONTH(created_at)', $month)->where('YEAR(created_at)', $year);
        } elseif (!empty($year)) {
            $query->where('YEAR(created_at)', $year);
        }

        // Ambil semua data yang sudah difilter
        $data = $query->findAll();
        $totalBiaya = array_sum(array_column($data, 'estimasi_biaya')); // Hitung total biaya

        return $this->response->setJSON(['data' => $data, 'totalBiaya' => $totalBiaya]);
    }


    public function approvePlan($id)
    {
        $assetPlanModel = new \App\Models\AssetPlanModel();
        $assetAcquisitionModel = new \App\Models\AssetAcquisitionModel();

        $assetPlanModel->update($id, ['status' => 'Approved']);

        $plan = $assetPlanModel->find($id);

        $data = [
            'nama_aset' => $plan['nama_aset'],
            'jenis_aset' => $plan['jenis_aset'],
            'jumlah' => $plan['jumlah'],
            'estimasi_biaya' => $plan['estimasi_biaya'],
            'vendor' => $plan['vendor'],
            'status' => 'Menunggu Persetujuan',
        ];

        $assetAcquisitionModel->insert($data);

        return redirect()->to('/admin/asset-plan')->with('success', 'Rencana aset disetujui dan diajukan untuk akuisisi.');
    }


}