<?php

namespace App\Models;

use CodeIgniter\Model;

class PengunjungModel extends Model
{
    protected $table = 'pengunjung';
    protected $allowedFields = ['nama', 'email', 'no_telp', 'instansi', 'keperluan', 'jenis_data', 'created_at'];

    public function getAllData()
    {
        return $this->findAll();
    }
}
