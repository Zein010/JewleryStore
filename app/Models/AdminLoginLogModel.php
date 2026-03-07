<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminLoginLogModel extends Model
{
    protected $table            = 'admin_login_logs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['admin_id', 'ip_address', 'user_agent'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
}
