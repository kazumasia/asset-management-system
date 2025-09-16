<?php

namespace App\Models;

use CodeIgniter\Model;

class AssetPlanModel extends Model
{
    protected $table = 'asset_plan';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_aset', 'merk', 'estimasi_biaya', 'vendor', 'kategori_risiko', 'kategori_risiko', 'status', 'created_at', 'updated_at'];

    public function getAllPlans($search = null, $month = null, $year = null)
    {
        $query = $this->select('*');

        if (!empty($search)) {
            $query->like('nama_aset', $search);
        }

        if (!empty($month)) {
            $query->where('MONTH(created_at)', $month);
        }

        if (!empty($year)) {
            $query->where('YEAR(created_at)', $year);
        }

        return $query->findAll();
    }


    public function searchAll($search = null, $month = null, $year = null)
    {
        $query = $this->select('*');

        if (!empty($search)) {
            // Pencarian di semua kolom
            $query->groupStart()
                ->like('nama_aset', $search)
                ->orLike('merk', $search)
                ->orLike('jumlah', $search)
                ->orLike('estimasi_biaya', $search)
                ->orLike('vendor', $search)
                ->orLike('kategori_risiko', $search)
                ->orLike('deskripsi_risiko', $search)
                ->orLike('status', $search)
                ->orLike("DATE_FORMAT(created_at, '%M %Y')", $search) // Cari berdasarkan nama bulan dan tahun
                ->groupEnd();
        }

        if (!empty($month)) {
            $query->where('MONTH(created_at)', $month);
        }

        if (!empty($year)) {
            $query->where('YEAR(created_at)', $year);
        }

        return $query->findAll();
    }

    public function getTotalAnggaran($search = null, $month = null, $year = null)
    {
        $query = $this->selectSum('estimasi_biaya');

        if (!empty($search)) {
            $query->groupStart()
                ->like('nama_aset', $search)
                ->orLike('merk', $search)
                ->orLike('jumlah', $search)
                ->orLike('estimasi_biaya', $search)
                ->orLike('vendor', $search)
                ->orLike('kategori_risiko', $search)
                ->orLike('deskripsi_risiko', $search)
                ->orLike('status', $search)
                ->orLike("DATE_FORMAT(created_at, '%M %Y')", $search)
                ->groupEnd();
        }

        if (!empty($month)) {
            $query->where('MONTH(created_at)', $month);
        }

        if (!empty($year)) {
            $query->where('YEAR(created_at)', $year);
        }

        $result = $query->first();
        return $result ? $result['estimasi_biaya'] : 0;
    }

    public function getApprovedPlans()
    {
        return $this->where('status', 'Approved')->findAll();
    }



}