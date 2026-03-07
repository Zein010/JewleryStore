<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderStatusLogModel extends Model
{
    protected $table            = 'order_status_logs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['order_id', 'admin_name', 'old_status', 'new_status'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
