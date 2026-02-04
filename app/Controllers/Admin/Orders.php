<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderItemModel;

class Orders extends BaseController
{
    protected $orderModel;
    protected $orderItemModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manage Orders',
            'orders' => $this->orderModel->orderBy('created_at', 'DESC')->findAll()
        ];

        return view('admin/layout/header', $data)
             . view('admin/layout/sidebar')
             . view('admin/orders/index', $data)
             . view('admin/layout/footer');
    }

    public function show($id)
    {
        $order = $this->orderModel->find($id);

        if (!$order) {
            return redirect()->to('/admin/orders')->with('error', 'Order not found');
        }

        // Fetch Order Items with Product Details
        $items = $this->orderItemModel->select('order_items.*, products.name as product_name, products.image as product_image, products.slug as product_slug')
                                      ->join('products', 'products.id = order_items.product_id', 'left')
                                      ->where('order_id', $id)
                                      ->findAll();

        $data = [
            'title' => 'Order Details #' . $order['id'],
            'order' => $order,
            'items' => $items
        ];

        return view('admin/layout/header', $data)
             . view('admin/layout/sidebar')
             . view('admin/orders/show', $data)
             . view('admin/layout/footer');
    }
}
