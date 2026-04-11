<?php

namespace App\Controllers;

class Story extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Our Story'
        ];

        return view('templates/header', $data)
             . view('templates/navbar')
             . view('story/index', $data) // 👈 your new page
             . view('templates/footer');
    }
}