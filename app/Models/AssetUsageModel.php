<?php

namespace App\Models;

use CodeIgniter\Model;

class AssetUsageModel extends Model
{
    protected $table = 'asset_usage';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'asset_id',
        'pegawai',
        'tujuan',
        'status',
        'tanggal_mulai',
        'tanggal_selesai',
        'keterangan',
        'created_at',
        'updated_at'
    ];

    public function getUsageWithAssets()
    {
        return $this->select('asset_usage.*, assets.nama_barang, assets.kondisi')
            ->join('assets', 'assets.id = asset_usage.asset_id')
            ->orderBy('asset_usage.created_at', 'DESC')
            ->findAll();
    }
}
