<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class LoginHistory extends BaseController
{
    public function index()
    {
        $logModel = new \App\Models\AdminLoginLogModel();
        $adminId = session()->get('id');

        // Apply RBAC
        if ($adminId == 1) {
            // Root admin sees all logs with names
            $logs = $logModel->select('admin_login_logs.*, admins.name as admin_name')
                             ->join('admins', 'admins.id = admin_login_logs.admin_id', 'left')
                             ->orderBy('admin_login_logs.created_at', 'DESC')
                             ->findAll();
        } else {
            // Secondary admins only see their own
            $logs = $logModel->select('admin_login_logs.*, admins.name as admin_name')
                             ->join('admins', 'admins.id = admin_login_logs.admin_id', 'left')
                             ->where('admin_login_logs.admin_id', $adminId)
                             ->orderBy('admin_login_logs.created_at', 'DESC')
                             ->findAll();
        }

        $data = [
            'title' => 'Login History',
            'logs'  => $logs,
            'isRoot' => ($adminId == 1)
        ];

        return view('admin/layout/header', $data)
             . view('admin/layout/sidebar')
             . view('admin/login_history/index', $data)
             . view('admin/layout/footer');
    }
}
