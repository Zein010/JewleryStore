<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;

class Users extends BaseController
{
    protected $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Admin Users',
            'users' => $this->adminModel->findAll()
        ];

        return view('admin/layout/header', $data)
             . view('admin/layout/sidebar')
             . view('admin/users/index', $data)
             . view('admin/layout/footer');
    }

    public function create()
    {
        if (session()->get('id') != 1) {
            return redirect()->to('/admin/users')->with('error', 'You do not have permission to create new admins.');
        }

        $data = [
            'title' => 'Add New Admin',
            'user'  => null // Null indicates creation mode for the shared form
        ];

        return view('admin/layout/header', $data)
             . view('admin/layout/sidebar')
             . view('admin/users/form', $data)
             . view('admin/layout/footer');
    }

    public function store()
    {
        if (session()->get('id') != 1) {
            return redirect()->to('/admin/users')->with('error', 'You do not have permission to create new admins.');
        }

        $rules = [
            'name'     => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[admins.email]',
            'password' => 'required|min_length[8]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->adminModel->save([
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
        ]);

        return redirect()->to('/admin/users')->with('success', 'Admin user created successfully.');
    }

    public function edit($id)
    {
        if (session()->get('id') != 1 && $id != session()->get('id')) {
            return redirect()->to('/admin/users')->with('error', 'You can only edit your own account.');
        }

        $user = $this->adminModel->find($id);

        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'Admin user not found.');
        }

        $data = [
            'title' => 'Edit Admin User',
            'user'  => $user
        ];

        return view('admin/layout/header', $data)
             . view('admin/layout/sidebar')
             . view('admin/users/form', $data)
             . view('admin/layout/footer');
    }

    public function update($id)
    {
        if (session()->get('id') != 1 && $id != session()->get('id')) {
            return redirect()->to('/admin/users')->with('error', 'You can only edit your own account.');
        }

        $user = $this->adminModel->find($id);

        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'Admin user not found.');
        }

        // Skip unique email validation if the email hasn't changed
        $emailRule = 'required|valid_email';
        if ($this->request->getPost('email') !== $user['email']) {
            $emailRule .= '|is_unique[admins.email]';
        }

        $rules = [
            'name'  => 'required|min_length[3]',
            'email' => $emailRule
        ];

        // Only validate password if the user typed something in
        $newPassword = $this->request->getPost('password');
        if (!empty($newPassword)) {
            $rules['password'] = 'min_length[8]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $dataToUpdate = [
            'name'  => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
        ];

        // Hash and include new password if provided
        if (!empty($newPassword)) {
            $dataToUpdate['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        $this->adminModel->update($id, $dataToUpdate);

        return redirect()->to('/admin/users')->with('success', 'Admin user updated successfully.');
    }

    public function delete($id)
    {
        if ($id == 1) {
            return redirect()->to('/admin/users')->with('error', 'The original admin user cannot be deleted.');
        }

        if (session()->get('id') != 1) {
            return redirect()->to('/admin/users')->with('error', 'You do not have permission to delete admin accounts.');
        }

        $user = $this->adminModel->find($id);

        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'Admin user not found.');
        }

        // Prevent admin from deleting themselves
        if ($id == session()->get('id')) {
            return redirect()->to('/admin/users')->with('error', 'You cannot delete your own active account.');
        }

        $this->adminModel->delete($id);

        return redirect()->to('/admin/users')->with('success', 'Admin user deleted successfully.');
    }
}
