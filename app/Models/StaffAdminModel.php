<?php
 
namespace App\Models;
 
use CodeIgniter\Model;
 
class StaffAdminModel extends Model
{
    protected $table = "staff_admin";
    protected $primaryKey = "nik";
    protected $returnType = "object";
    protected $useTimestamps = true;
    protected $allowedFields = ['password', 'name','role','nik'];
}