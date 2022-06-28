<?php

namespace App\Models;

use CodeIgniter\Model;

class StockBarangModel extends Model
{
    protected $table = "stock_barang";
    protected $primaryKey = "id";
    protected $returnType = "object";
    protected $useTimestamps = false;
    protected $allowedFields = ['id','id_barang','id_jenis_barang','qty','created_at','deleted_at','updated_at'];

}
