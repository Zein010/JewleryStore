<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderItemModel;

class Orders extends BaseController
{
    protected $orderModel;
    protected $orderItemModel;
    protected $orderStatusLogModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->orderStatusLogModel = new \App\Models\OrderStatusLogModel();
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
                                      
        // Fetch Status Logs
        $logs = $this->orderStatusLogModel->where('order_id', $id)->orderBy('created_at', 'ASC')->findAll();

        $data = [
            'title' => 'Order Details #' . $order['id'],
            'order' => $order,
            'items' => $items,
            'logs'  => $logs
        ];

        return view('admin/layout/header', $data)
             . view('admin/layout/sidebar')
             . view('admin/orders/show', $data)
             . view('admin/layout/footer');
    }

    public function updateNote($id)
    {
        $order = $this->orderModel->find($id);

        if (!$order) {
            return redirect()->to('/admin/orders')->with('error', 'Order not found');
        }

        $adminNote = $this->request->getPost('admin_note');

        $this->orderModel->update($id, [
            'admin_note' => $adminNote
        ]);

        return redirect()->back()->with('success', 'Admin note updated successfully.');
    }

    public function updateStatus($id)
    {
        $order = $this->orderModel->find($id);

        if (!$order) {
            return redirect()->to('/admin/orders')->with('error', 'Order not found');
        }

        $newStatus = $this->request->getPost('status');
        $oldStatus = $order['status'];

        if ($newStatus && $newStatus !== $oldStatus) {
            // Update order status
            $this->orderModel->update($id, [
                'status' => $newStatus
            ]);

            // Log the change
            $adminName = session()->get('name') ?? 'Admin';
            $this->orderStatusLogModel->insert([
                'order_id'   => $id,
                'admin_name' => $adminName,
                'old_status' => $oldStatus,
                'new_status' => $newStatus
            ]);
            
            return redirect()->back()->with('success', 'Order status updated successfully.');
        }

        return redirect()->back();
    }
}
