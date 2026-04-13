<?php

namespace App\Controllers;

class Warranty extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Warranty'
        ];

        return view('templates/header', $data)
             . view('templates/navbar')
             . view('warranty/index', $data) // 👈 your new page
             . view('templates/footer');
    }
}