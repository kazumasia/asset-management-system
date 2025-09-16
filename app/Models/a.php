<?php

namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model
{
    protected $table = 'complaint';
    protected $primaryKey = 'id';

    protected $allowedFields = ['nama', 'nomor_aset', 'jenis_aset', 'deskripsi', 'lokasi', 'created_at', 'status', 'tanggal_selesai'];


    // Add this method to fetch all data
    public function getAllData()
    {
        return $this->findAll();
    }

    public function insertData($data)
    {
        $this->db->table($this->table)->insert($data);
    }
    public function edit($id)
    {
        $data['pengunjung'] = $this->yourModel->find($id);

        // Load view untuk halaman edit
        return view('edit', $data);
    }

    public function GetLaporan()
    {
        return $this->whereIn('status', ['Dalam Proses', 'selesai'])->findAll();

    }
    public function selesaikanLaporan($laporanId)
    {
        $data = [
            'status' => 'Selesai',
            'tanggal_selesai' => date('Y-m-d H:i:s')
        ];

        $this->where('id', $laporanId)->set($data)->update();
    }
    // public function getLaporanByDate($selected_date)
    // {
    //     return $this->db->table('complaint')
    //         ->where('DATE(created_at)', $selected_date)
    //         ->get()
    //         ->getResultArray();
    // }
    public function getLaporanByDateRange($start_date, $end_date)
    {
        return $this->db->table('complaint')
            ->where('DATE(created_at) >=', $start_date)
            ->where('DATE(created_at) <=', $end_date)
            ->get()
            ->getResultArray();
    }


    public function searchLaporan($search_query)
    {
        return $this->db->table('complaint')
            ->like('nama', $search_query)
            ->orLike('nomor_aset', $search_query)
            ->orLike('jenis_aset', $search_query)
            ->orLike('deskripsi', $search_query)
            ->orLike('lokasi', $search_query)
            ->orLike('created_at', $search_query)
            ->orLike('status', $search_query)
            ->orLike('tanggal_selesai', $search_query)
            // Add more fields as needed
            ->get()
            ->getResultArray();
    }
    public function getAllLaporan($start_date = null, $end_date = null)
    {
        $builder = $this->db->table('complaint');

        if ($start_date && $end_date) {
            $builder->where('created_at >=', $start_date)
                ->where('tanggal_selesai <=', $end_date);
        }

        return $builder->select("id, nama, nomor_aset, jenis_aset, deskripsi, lokasi, DATE_FORMAT(created_at, '%d-%m-%Y %H:%i:%s') as created_at, status, DATE_FORMAT(tanggal_selesai, '%d-%m-%Y %H:%i:%s') as tanggal_selesai")
            ->get()
            ->getResultArray();
    }


    public function countInProgress()
    {
        return $this->where('status', 'Dalam Proses')->countAllResults();
    }
    public function countInDone()
    {
        return $this->where('status', 'Selesai')->countAllResults();
    }
    public function countAllReports()
    {
        return $this->countAllResults();
    }

    public function getMonthlyReports()
    {
        return $this->select("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as total_reports")
            ->groupBy("DATE_FORMAT(created_at, '%Y-%m')")
            ->get()
            ->getResult();
    }

    public function getMonthlyReportsByYear($year)
    {
        return $this->select("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as total_reports")
            ->where("YEAR(created_at)", $year)
            ->groupBy("DATE_FORMAT(created_at, '%Y-%m')")
            ->get()
            ->getResult();
    }




    public function getLaporanStats($year = null)
    {
        $builder = $this->db->table('complaint');
        $builder->select("MONTH(created_at) as month, COUNT(status) as total, GROUP_CONCAT(jenis_aset) as barang_terbanyak");
        $builder->groupBy("MONTH(created_at)");

        if ($year) {
            $builder->where("YEAR(created_at)", $year);
        }

        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getJenisAsetStats($year = null)
    {
        $builder = $this->db->table('complaint');
        $builder->select("jenis_aset, COUNT(*) as total");
        $builder->groupBy("jenis_aset");

        if ($year) {
            $builder->where("YEAR(created_at)", $year);
        }

        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getAssetsData($year = null)
    {
        $builder = $this->db->table('complaint');
        $builder->select('jenis_aset, COUNT(jenis_aset) as total');
        $builder->groupBy('jenis_aset');

        if ($year) {
            $builder->where("YEAR(created_at)", $year);
        }

        $query = $builder->get();

        $data = $query->getResultArray();

        // Calculate overall total
        $total = array_sum(array_column($data, 'total'));

        return ['data' => $data, 'total' => $total];
    }



    public function getPosts($perPage, $offset)
    {
        return $this->orderBy('created_at', 'DESC')->findAll($perPage, $offset);
    }

    // Fungsi untuk menghitung jumlah total data
    public function getTotalPosts()
    {
        return $this->countAll();
    }


    public function getDataByDateRange($startDate, $endDate)
    {
        return $this->where('created_at >=', $startDate)
            ->where('created_at <=', $endDate)
            ->findAll();
    }


}
