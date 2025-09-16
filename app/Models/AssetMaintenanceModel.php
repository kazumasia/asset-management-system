<?php

namespace App\Models;

use CodeIgniter\Model;

class AssetMaintenanceModel extends Model
{
    protected $table = 'asset_maintenance';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'asset_id',
        'pengaduan_id',
        'jadwal_pemeliharaan',
        'teknisi',
        'biaya',
        'status',
        'catatan',
        'created_at',
        'updated_at'
    ];

    public function getUnreadNotifications()
    {
        return $this->where('status', 'unread')->orderBy('created_at', 'DESC')->findAll();
    }
}
