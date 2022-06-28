<?php
 
namespace App\Models;
 
use CodeIgniter\Model;
 
class LaporanModel extends Model
{
    protected $table = "laporan";
    protected $primaryKey = "id";
    protected $returnType = "object";
    protected $useTimestamps = true;
    protected $allowedFields = ['id','nik_gl','line','nik_spv','tgl_laporan',
                            'created_at','updated_at','deleted_at','status','id_barang','style'
                            ,'problem','lossting','problem_deskripsi','problem_kategori'];

    public function get_data($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        }

        return $this->getWhere(['id' => $id]);
    }
}