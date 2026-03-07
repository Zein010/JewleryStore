<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Favorites extends BaseController
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $session = session();
        $favoritesIds = $session->get('favorites') ?? [];
        
        $favorites = [];
        if (!empty($favoritesIds)) {
            $favorites = $this->productModel->whereIn('id', $favoritesIds)->findAll();
            
            // Fetch main images for these products
            $imageModel = new \App\Models\ProductImageModel();
            foreach ($favorites as &$product) {
                 $mainImage = $imageModel->where('product_id', $product['id'])->where('is_main', 1)->first();
                 $product['image_path'] = $mainImage ? $mainImage['image'] : ($product['image'] ?? '1.png');
            }
        }

        $data = [
            'title' => 'My Favorites',
            'favorites' => $favorites,
        ];

        return view('templates/header', $data)
             . view('templates/navbar')
             . view('favorites/index', $data)
             . view('templates/footer');
    }

    public function toggle()
    {
        $session = session();
        $favorites = $session->get('favorites') ?? [];
        
        $productId = $this->request->getPost('product_id');
        
        if (!$productId) {
            return redirect()->back()->with('error', 'Invalid product ID.');
        }

        // Check if product exists
        $product = $this->productModel->find($productId);
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        if (in_array($productId, $favorites)) {
            // Remove it
            $favorites = array_diff($favorites, [$productId]);
            $session->set('favorites', $favorites);
            return redirect()->back()->with('success', 'Product removed from favorites.');
        } else {
            // Add it
            $favorites[] = $productId;
            $session->set('favorites', $favorites);
            return redirect()->back()->with('success', 'Product added to favorites!');
        }
    }
}
