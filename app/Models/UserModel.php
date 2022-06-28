<?php
 
namespace App\Models;
 
use CodeIgniter\Model;
 
class UserModel extends Model
{
    protected $table = "users";
    protected $primaryKey = "nik";
    protected $returnType = "object";
    protected $useTimestamps = true;
    protected $allowedFields = ['password', 'name','role','nik','line'];
}