<?php

namespace App\Models;

use CodeIgniter\Model;

class AssetDisposalModel extends Model
{
    protected $table = 'asset_disposal';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'asset_id',
        'alasan',
        'nilai_residu',
        'metode',
        'status',
        'dokumen_pendukung',
        'created_at',
        'updated_at'
    ];


    protected $useTimestamps = true;

    // Mengambil semua penghapusan yang menunggu persetujuan
    public function getPendingDisposals()
    {
        return $this->where('status', 'Menunggu Persetujuan')->findAll();
    }
}
