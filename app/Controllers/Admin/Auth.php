<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;

class Auth extends BaseController
{
    public function index()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/admin/dashboard');
        }
        return view('admin/auth/login');
    }

    public function login()
    {
        $session = session();
        $model = new AdminModel();

        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $data = $model->where('email', $email)->first();

        if ($data) {
            $pass = $data['password'];
            $verify_pass = password_verify($password, $pass);
            if ($verify_pass) {
                $ses_data = [
                    'id'       => $data['id'],
                    'name'     => $data['name'],
                    'email'    => $data['email'],
                    'isLoggedIn' => true
                ];
                $session->set($ses_data);

                // Log the login event
                $loginLogModel = new \App\Models\AdminLoginLogModel();
                $loginLogModel->insert([
                    'admin_id'   => $data['id'],
                    'ip_address' => $this->request->getIPAddress(),
                    'user_agent' => substr((string) $this->request->getUserAgent(), 0, 255)
                ]);

                return redirect()->to('/admin/dashboard');
            } else {
                $session->setFlashdata('error', 'Wrong Password');
                return redirect()->to('/admin/login');
            }
        } else {
            $session->setFlashdata('error', 'Email not found');
            return redirect()->to('/admin/login');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/admin/login');
    }
}
