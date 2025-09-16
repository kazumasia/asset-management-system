<?php

namespace App\Controllers;

use App\Models\PostModel;

class Admin extends BaseController
{
    protected $PostModel;

    protected $db, $builder;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('users');
        $this->PostModel = new PostModel();

    }
    public function index()
    {

        $this->builder = $this->db->table('users');
        $this->builder->select('users.id as userid, username, email, name');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $query = $this->builder->get();
        $count['users'] = $query->getResult();


        $count['title'] = 'User List';

        $postModel = new PostModel();


        $count['inProgressCount'] = $postModel->countInProgress() ?? 0;
        $count['inDoneCount'] = $postModel->countInDone() ?? 0;
        $count['allReportsCount'] = $postModel->countAllReports() ?? 0;




        $monthlyReports = $postModel->getMonthlyReports();

        $formattedMonthlyReports = $this->formatMonthlyReports($monthlyReports);
        $count['monthlyReports'] = json_encode($formattedMonthlyReports);
        return view('admin/index', $count);
    }

    private function formatMonthlyReports($monthlyReports)
    {
        $formattedReports = [];

        foreach ($monthlyReports as $report) {
            $formattedReports[] = [
                'label' => date('F Y', strtotime($report->month)),
                'total_reports' => $report->total_reports,
            ];
        }

        return $formattedReports;
    }


    public function detail($id = 0)
    {
        $data['title'] = 'User Detail';


        $this->builder->select('users.id as userid, username, email,fullname,user_image, name');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $this->builder->where('users.id', $id);
        $query = $this->builder->get();
        $data['user'] = $query->getRow();

        if (empty($data['user'])) {
            return redirect()->to('/admin');
        }
        return view('admin/detail', $data);
    }
    public function list()
    {
        $data['title'] = 'List Pengaduan User';

        $laporan = new PostModel();

        $data['laporan'] = $laporan->getAllData();

        return view('admin/list', $data);
    }
    public function edit($id)
    {
        $data['pengunjung'] = $this->PostModel->find($id);

        return view('admin/edit', $data);
    }

    public function update($id = 0)
    {
        $dataToUpdate = [
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'no_telp' => $this->request->getPost('no_telp'),
            'instansi' => $this->request->getPost('instansi'),
            'keperluan' => $this->request->getPost('keperluan'),
            'jenis_data' => $this->request->getPost('jenis_data'),
        ];

        $this->PostModel->update($this->request->getPost('id'), $dataToUpdate);

        return redirect()->to('admin/list');
    }
    public function delete($id)
    {
        $pengunjungModel = new PostModel();

        $pengunjungModel->delete($id);

        return redirect()->to('/admin/list');
    }
    public function wait(): string
    {
        return view('user/wait');
    }
    public function pst()
    {
        $data['title'] = 'Silahkan Ke PST';
        return view('pst_page', $data);
    }

    public function ruangtunggu()
    {
        $data['title'] = 'Silahkan Menunggu di Ruang Tunggu';
        return view('ruangtunggu_page', $data);
    }
    public function store()
    {
        $postModel = new PostModel();

        $timestamp = date('Y-m-d H:i:s');

        $data = [
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'no_telp' => $this->request->getPost('no_telp'),
            'instansi' => $this->request->getPost('instansi'),
            'keperluan' => $this->request->getPost('keperluan'),
            'jenis_data' => $this->request->getPost('jenis_data'),
            'created_at' => $timestamp, // Add the timestamp field
            // Add more fields as needed
        ];

        // Call the model method to insert data into the database
        $postModel->insertData($data);

        $data['pengunjung'] = $postModel->getAllData();
        $keperluan = $this->request->getPost('keperluan');


        // Periksa nilai keperluan
        if ($keperluan === 'PST') {
            // Jika keperluan adalah PST, arahkan ke halaman "Silahkan Ke PST"
            return redirect()->to('user/wait');
        } else {
            // Jika bukan PST, arahkan ke halaman "Silahkan Menunggu di Ruang Tunggu"
            return redirect()->to('user/tunggu');
        }
    }

    public function getChartData()
    {
        $postModel = new PostModel();

        // Ambil data dari database
        $posts = $postModel->findAll();

        // Inisialisasi array untuk menyimpan data bulan
        $dataPerMonth = [];

        // Inisialisasi array untuk menyimpan jumlah posting per bulan
        $postsPerMonth = [];

        // Hitung jumlah posting per bulan
        foreach ($posts as $post) {
            $month = date('F', strtotime($post['created_at']));
            if (!array_key_exists($month, $dataPerMonth)) {
                $dataPerMonth[$month] = $month;
                $postsPerMonth[$month] = 1;
            } else {
                $postsPerMonth[$month]++;
            }
        }

        // Data untuk dikirimkan ke view
        $data['months'] = array_values($dataPerMonth);
        $data['postsPerMonth'] = array_values($postsPerMonth);

        return view('admin/index', $data);
    }

    public function detailLaporan()
    {
        $PostModel = new PostModel();

        // Ambil data total per bulan dari database
        $total = $PostModel->getTotalPerBulan();

        // Mengirim data ke view
        $data['total'] = $total;
        return view('admin/index', $data);
    }

}
