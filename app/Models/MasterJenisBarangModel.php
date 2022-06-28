<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterJenisBarangModel extends Model
{
    protected $table = "master_jenis_barang";
    protected $primaryKey = "id";
    protected $returnType = "object";
    protected $useTimestamps = false;
    protected $allowedFields = ['id','jenis_barang','created_at','deleted_at','create_by'];

}
