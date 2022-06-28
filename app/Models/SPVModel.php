<?php
 
namespace App\Models;
 
use CodeIgniter\Model;
 
class SPVModel extends Model
{
    protected $table = "spv";
    protected $primaryKey = "nik";
    protected $returnType = "object";
    protected $useTimestamps = true;
    protected $allowedFields = ['password', 'name','role','nik'];
}