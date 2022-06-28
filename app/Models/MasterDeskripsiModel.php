<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterDeskripsiModel extends Model
{
    protected $table = "master_downtime_deskripsi";
    protected $primaryKey = "id";
    protected $returnType = "object";
    protected $useTimestamps = false;
    protected $allowedFields = ['id','downtime_deskripsi','created_at','deleted_at','downtime_kategori_id'];
}
