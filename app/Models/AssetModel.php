<?php

namespace App\Models;

use CodeIgniter\Model;

class AssetModel extends Model
{
    protected $table = 'assets';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'jenis_bmn',
        'kode_satker',
        'nama_satker',
        'kode_barang',
        'nup',
        'nama_barang',
        'merk',
        'tipe',
        'kondisi',
        'umur_aset',
        'intra_extra',
        'nama',
        'tanggal_buku_pertama',
        'tanggal_perolehan',
        'nilai_perolehan',
        'nilai_penyusutan',
        'nilai_buku',
        'status_penggunaan',
        'no_psp',
        'tanggal_psp'
    ];

    public function getAllAssets()
    {
        return $this->findAll();
    }

    public function getAssetById($id)
    {
        return $this->find($id);
    }
}