<?php

namespace App\Models;

use CodeIgniter\Model;

class PermintaanBarangModel extends Model
{
    protected $table = "permintaan_barang";
    protected $primaryKey = "id";
    protected $returnType = "object";
    protected $useTimestamps = false;
    protected $allowedFields = ['id','nik_gl','line','nik_spv','tgl_permintaan','id_stock','qty',
                        'status','created_at','deleted_at','tgl_pengeluaran_barang','user_keluar_barang','qty_keluar_barang'];
}
