<?php
namespace App\Models;

use CodeIgniter\Model;

class AssetAcquisitionModel extends Model
{
    protected $table = 'asset_acquisition';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'plan_id',
        'jenis_bmn',
        'nup',
        'kode_barang',
        'nama_barang',
        'kode_satker',
        'nama_satker',
        'nama_aset',
        'jenis_aset',
        'jumlah',
        'estimasi_biaya',
        'vendor',
        'merk',
        'tipe',
        'kondisi',
        'umur_aset',
        'tanggal_perolehan',
        'nilai_perolehan',
        'nilai_buku',
        'nilai_penyusutan',
        'status_penggunaan',
        'status',
        'tanggal_psp',
        'no_psp',
        'created_at',
        'updated_at'
    ];
}
