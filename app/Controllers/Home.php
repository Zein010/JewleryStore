<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Home extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();
        $categoryModel = new \App\Models\CategoryModel();
        
        $data = [
            'title' => 'Home',
            'featured_products' => $productModel->getFeatured(),
            'categories' => $categoryModel->where('is_featured', 1)->findAll(5) // Fetch top 5 featured for the layout
        ];

        return view('templates/header', $data)
             . view('templates/navbar')
             . view('home', $data)
             . view('templates/footer');
    }
}
