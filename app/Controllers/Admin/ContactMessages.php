<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ContactMessageModel;

class ContactMessages extends BaseController
{
    protected $messageModel;

    public function __construct()
    {
        $this->messageModel = new ContactMessageModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Contact Messages',
            'messages' => $this->messageModel->orderBy('created_at', 'DESC')->findAll()
        ];

        return view('admin/layout/header', $data)
             . view('admin/layout/sidebar')
             . view('admin/contact_messages/index', $data)
             . view('admin/layout/footer');
    }

    public function show($id)
    {
        $message = $this->messageModel->find($id);

        if (!$message) {
            return redirect()->to('/admin/messages')->with('error', 'Message not found');
        }

        $data = [
            'title' => 'View Message',
            'message' => $message
        ];

        return view('admin/layout/header', $data)
             . view('admin/layout/sidebar')
             . view('admin/contact_messages/show', $data)
             . view('admin/layout/footer');
    }

    public function delete($id)
    {
        $this->messageModel->delete($id);
        return redirect()->to('/admin/messages')->with('success', 'Message deleted successfully');
    }
}
