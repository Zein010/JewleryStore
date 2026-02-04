<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SettingsModel;
use App\Models\CategoryModel;

class Settings extends BaseController
{
    protected $settingsModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->settingsModel = new SettingsModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $data = [
            'title' => 'General Settings',
            'settings' => $this->settingsModel->getSettings(),
            'categories' => $this->categoryModel->findAll()
        ];

        return view('admin/layout/header', $data)
             . view('admin/layout/sidebar')
             . view('admin/settings/index', $data)
             . view('admin/layout/footer');
    }

    public function update()
    {
        $postData = $this->request->getPost();
        
        // Handle Logo Upload
        $logo = $this->request->getFile('company_logo');
        if ($logo && $logo->isValid() && !$logo->hasMoved()) {
            if (!is_dir(FCPATH . 'uploads/settings')) {
                mkdir(FCPATH . 'uploads/settings', 0777, true);
            }
            $newName = $logo->getRandomName();
            $logo->move(FCPATH . 'uploads/settings', $newName);
            
            // Delete old logo if exists (optional logic here)
            
            $this->settingsModel->updateSetting('company_logo', $newName);
        }

        // Update other text settings
        $keys = [
            'company_name', 'contact_email', 'contact_phone', 'contact_address',
            'facebook_link', 'instagram_link', 'pinterest_link',
            'smtp_host', 'smtp_user', 'smtp_pass', 'smtp_port', 'smtp_crypto', 'admin_email_notify',
            'header_category_id'
        ];

        foreach ($keys as $key) {
            if (isset($postData[$key])) {
                $this->settingsModel->updateSetting($key, $postData[$key]);
            }
        }

        return redirect()->to('admin/settings')->with('success', 'Settings updated successfully.');
    }
}
