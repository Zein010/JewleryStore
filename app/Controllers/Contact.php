<?php

namespace App\Controllers;

class Contact extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Contact Us'
        ];

        return view('templates/header', $data)
             . view('templates/navbar')
             . view('contact/index', $data)
             . view('templates/footer');
    }

    public function send()
    {
        $rules = [
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'subject' => 'required|min_length[3]',
            'message' => 'required|min_length[10]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Please check your input.');
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'subject' => $this->request->getPost('subject'),
            'message' => $this->request->getPost('message')
        ];

        // 1. Save to Database
        $model = new \App\Models\ContactMessageModel();
        $model->save($data);

        // 2. Send Emails
        $this->sendContactEmails($data);

        return redirect()->back()->with('success', 'Message sent! We will get back to you soon.');
    }

    private function sendContactEmails($data)
    {
        $settingsModel = new \App\Models\SettingsModel();
        $settings = $settingsModel->getSettings();
        
        if (empty($settings['smtp_host'])) {
            return; // SMTP not configured
        }

        $email = \Config\Services::email();

        $config = [
            'protocol' => 'smtp',
            'SMTPHost' => $settings['smtp_host'],
            'SMTPUser' => $settings['smtp_user'],
            'SMTPPass' => $settings['smtp_pass'],
            'SMTPPort' => (int)($settings['smtp_port'] ?? 587),
            'SMTPCrypto' => $settings['smtp_crypto'] ?? 'tls',
            'mailType' => 'html',
            'charset'  => 'utf-8',
            'newline'  => "\r\n"
        ];
        
        $email->initialize($config);

        // A. Send to Admin
        if (!empty($settings['admin_email_notify'])) {
            $email->setFrom($settings['smtp_user'], 'Website Contact Form');
            $email->setTo($settings['admin_email_notify']);
            $email->setSubject("New Contact Inquiry: " . $data['subject']);
            $msg = "<h3>New Message from " . esc($data['name']) . "</h3>";
            $msg .= "<p><strong>Email:</strong> " . esc($data['email']) . "</p>";
            $msg .= "<p><strong>Subject:</strong> " . esc($data['subject']) . "</p>";
            $msg .= "<p><strong>Message:</strong><br>" . nl2br(esc($data['message'])) . "</p>";
            $email->setMessage($msg);
            $email->send();
        }

        // B. Send to User (Confirmation)
        $email->clear();
        $email->setFrom($settings['smtp_user'], $settings['company_name'] ?? 'Luxe & Co');
        $email->setTo($data['email']);
        $email->setSubject("We received your message - " . ($settings['company_name'] ?? 'Luxe & Co'));
        $msg = "<p>Dear " . esc($data['name']) . ",</p>";
        $msg .= "<p>Thank you for contacting us. We have received your message regarding <strong>" . esc($data['subject']) . "</strong> and will get back to you shortly.</p>";
        $msg .= "<p>Best regards,<br>" . ($settings['company_name'] ?? 'Luxe & Co') . "</p>";
        $email->setMessage($msg);
        $email->send();
    }
}
