<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Home extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        
        // For now, since we have no data, we will just pass empty or mock data if needed
        // But ideally we display featured products
        $data = [
            'title' => 'Home',
            'featured_products' => $productModel->getFeatured()
        ];

        return view('templates/header', $data)
             . view('templates/navbar')
             . view('home', $data)
             . view('templates/footer');
    }
}
