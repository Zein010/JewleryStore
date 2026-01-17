<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;

class Shop extends BaseController
{
    protected $categoryModel;
    protected $productModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        // Get Filter Params
        $filters = [
            'min_price' => $this->request->getGet('min_price'),
            'max_price' => $this->request->getGet('max_price'),
            'material'  => $this->request->getGet('material'),
            'sort'      => $this->request->getGet('sort')
        ];

        // Use filterProducts with null categoryId for all products
        $products = $this->productModel->filterProducts(null, $filters);

        $data = [
            'title' => 'Shop All',
            'category_name' => 'All Collections',
            'products' => $products,
            'current_filters' => $filters,
            'current_slug' => '' // Empty slug for main shop page
        ];

        return view('templates/header', $data)
             . view('templates/navbar')
             . view('shop/index', $data)
             . view('templates/footer');
    }

    public function category($slug)
    {
        $category = $this->categoryModel->where('slug', $slug)->first();
        
        $categoryName = $category ? $category['name'] : ucfirst($slug);
        $categoryId = $category ? $category['id'] : null;

        // Get Filter Params
        $filters = [
            'min_price' => $this->request->getGet('min_price'),
            'max_price' => $this->request->getGet('max_price'),
            'material'  => $this->request->getGet('material'),
            'sort'      => $this->request->getGet('sort')
        ];

        // Use filterProducts instead of basic query
        $products = $this->productModel->filterProducts($categoryId, $filters);

        $data = [
            'title' => $categoryName,
            'category_name' => $categoryName,
            'products' => $products,
            'current_filters' => $filters, // Pass back to view to keep state
            'current_slug' => $slug
        ];

        return view('templates/header', $data)
             . view('templates/navbar')
             . view('shop/index', $data)
             . view('templates/footer');
    }
}
