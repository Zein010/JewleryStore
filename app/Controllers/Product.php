<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Product extends BaseController
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function index($slug)
    {
        $product = $this->productModel->select('products.*, product_images.image as image')
                                      ->join('product_images', 'product_images.product_id = products.id AND product_images.is_main = 1', 'left')
                                      ->where('slug', $slug)
                                      ->first();
        
        // Fetch all images for the slider
        $productImages = [];
        if ($product) {
            $imageModel = new \App\Models\ProductImageModel();
            $productImages = $imageModel->where('product_id', $product['id'])->findAll();
        }

        // Fallback demo data if DB is empty or product not found
        if (!$product) {
             $product = [
                'name' => 'Ribbon Gold Ring',
                'price' => 1850,
                'description' => 'A timeless piece of elegance.',
                'image' => '1.png',
                'slug' => 'ribbon-gold-ring'
             ];
        }

        $data = [
            'title' => $product['name'],
            'product' => $product,
            'images' => $productImages
        ];

        return view('templates/header', $data)
             . view('templates/navbar')
             . view('shop/product', $data)
             . view('templates/footer');
    }
}
