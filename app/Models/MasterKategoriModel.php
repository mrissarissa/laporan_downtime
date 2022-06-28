<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterKategoriModel extends Model
{
    protected $table = "downtime_kategori";
    protected $primaryKey = "id";
    protected $returnType = "object";
    protected $useTimestamps = false;
    protected $allowedFields = ['id','downtime_kategori','created_at','deleted_at'];
}
