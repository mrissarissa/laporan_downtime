<?php

namespace App\Models;

use CodeIgniter\Model;

class PengembalianBarangModel extends Model
{
    protected $table = "pengembalian_barang";
    protected $primaryKey = "id";
    protected $returnType = "object";
    protected $useTimestamps = false;
    protected $allowedFields = ['id','nik_gl','line','nik_spv','tgl_pengembalian','id_stock','qty',
                        'status','created_at','deleted_at','kondisi_barang','keterangan_kondisi','status_app_admin'];
}
