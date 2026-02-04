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
        // Get All Filter Params
        $filters = $this->request->getGet();
        if (!is_array($filters)) {
            $filters = [];
        }

        // Get Dynamic Filters & Price Ranges
        $dynamicData = $this->productModel->getDynamicFilters(null);

        // Filter Products
        $products = $this->productModel->filterProducts(null, $filters);

        $data = [
            'title' => 'Shop All',
            'category_name' => 'All Collections',
            'products' => $products,
            'current_filters' => $filters,
            'dynamic_filters' => $dynamicData['filters'],
            'price_ranges' => $dynamicData['price_ranges'],
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

        // Get All Filter Params
        $filters = $this->request->getGet();
        if (!is_array($filters)) {
            $filters = [];
        }

        // Get Dynamic Filters & Price Ranges for this Category
        $dynamicData = $this->productModel->getDynamicFilters($categoryId);

        // Filter Products
        $products = $this->productModel->filterProducts($categoryId, $filters);

        $data = [
            'title' => $categoryName,
            'category_name' => $categoryName,
            'products' => $products,
            'current_filters' => $filters, // Pass back to view to keep state
            'dynamic_filters' => $dynamicData['filters'],
            'price_ranges' => $dynamicData['price_ranges'],
            'current_slug' => $slug
        ];

        return view('templates/header', $data)
             . view('templates/navbar')
             . view('shop/index', $data)
             . view('templates/footer');
    }
}
