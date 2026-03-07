<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderItemModel;

class Checkout extends BaseController
{
    public function index()
    {
        $session = session();
        $cart = $session->get('cart') ?? [];

        if (empty($cart)) {
            return redirect()->to('/cart');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $data = [
            'title' => 'Checkout',
            'cart' => $cart,
            'total' => $total
        ];

        return view('templates/header', $data)
             . view('templates/navbar')
             . view('checkout/index', $data)
             . view('templates/footer');
    }

    public function process()
    {
        $session = session();
        $cart = $session->get('cart') ?? [];

        if (empty($cart)) {
            return redirect()->to('/cart');
        }

        // Validation
        $rules = [
            'firstName' => 'required|min_length[2]',
            'lastName'  => 'required|min_length[2]',
            'email'     => 'required|valid_email',
            'phone'     => 'required|min_length[8]',
            'country'   => 'required',
            'address'   => 'required|min_length[5]',
            'city'      => 'required',
            'zip'       => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Calculate Total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Create Order
        $orderModel = new OrderModel();
        $customerName = $this->request->getPost('firstName') . ' ' . $this->request->getPost('lastName');
        $shippingAddress = $this->request->getPost('address') . ', ' . $this->request->getPost('city') . ' ' . $this->request->getPost('zip'); // Simplified

        $orderId = $orderModel->insert([
            'customer_name' => $customerName,
            'customer_email' => $this->request->getPost('email'),
            'country' => $this->request->getPost('country'),
            'phone' => $this->request->getPost('phone'),
            'shipping_address' => $shippingAddress,
            'customer_note' => $this->request->getPost('customer_note'),
            'total_amount' => $total,
            'status' => 'pending'
        ]);

        if ($orderId) {
            // Create Order Items
            $orderItemModel = new OrderItemModel();
            foreach ($cart as $item) {
                $orderItemModel->insert([
                    'order_id' => $orderId,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'customization_text' => $item['customization_text'] ?? null
                ]);
            }

            // Clear Cart
            $session->remove('cart');
            
            // Send Emails
            $this->sendOrderEmails($orderId, [
                'name' => $customerName,
                'email' => $this->request->getPost('email'),
                'phone' => $this->request->getPost('phone'),
                'country' => $this->request->getPost('country'),
                'shipping_address' => $shippingAddress,
                'customer_note' => $this->request->getPost('customer_note'),
                'total' => $total,
                'id' => $orderId
            ], $cart);

            return redirect()->to('/checkout/success');
        } else {
             return redirect()->back()->with('error', 'Failed to create order. Please try again.');
        }
    }

    private function sendOrderEmails($orderId, $orderData, $items)
    {
        $settingsModel = new \App\Models\SettingsModel();
        $settings = $settingsModel->getSettings();
        
        // Check if SMTP is configured (basic check)
        if (empty($settings['smtp_host'])) {
            return; // SMTP not configured, skip email
        }

        $email = \Config\Services::email();

        $config = [
            'protocol' => 'smtp',
            'SMTPHost' => $settings['smtp_host'],
            'SMTPUser' => $settings['smtp_user'],
            'SMTPPass' => $settings['smtp_pass'],
            'SMTPPort' => (int)($settings['smtp_port'] ?? 587),
            'SMTPCrypto' => $settings['smtp_crypto'] ?? 'tls',
            'mailType' => 'html',
            'charset'  => 'utf-8',
            'newline'  => "\r\n"
        ];
        
        $email->initialize($config);

        // Prepare Email Content
        $subject = "Order Confirmation #" . $orderId . " - " . ($settings['company_name'] ?? 'Luxe & Co');
        
        // Basic HTML Template
        $tableRows = '';
        foreach ($items as $item) {
            $customization = !empty($item['customization_text']) ? "<br><small>Customization: " . esc($item['customization_text']) . "</small>" : "";
            $tableRows .= "
                <tr>
                    <td style='padding: 10px; border-bottom: 1px solid #ddd;'>
                        <strong>" . esc($item['name']) . "</strong>
                        $customization
                    </td>
                    <td style='padding: 10px; border-bottom: 1px solid #ddd;'>x" . $item['quantity'] . "</td>
                    <td style='padding: 10px; border-bottom: 1px solid #ddd;'>$" . number_format($item['price'] * $item['quantity'], 2) . "</td>
                </tr>
            ";
        }

        $message = "
            <h2>Thank you for your order, " . esc($orderData['name']) . "!</h2>
            <p>Your order <strong>#" . $orderId . "</strong> has been received.</p>
            <p><strong>Shipping to:</strong><br>" . nl2br(esc($orderData['shipping_address'])) . "</p>
            
            <table style='width: 100%; border-collapse: collapse; margin-top: 20px;'>
                <thead>
                    <tr style='background-color: #f8f9fa;'>
                        <th style='padding: 10px; text-align: left;'>Product</th>
                        <th style='padding: 10px; text-align: left;'>Qty</th>
                        <th style='padding: 10px; text-align: left;'>Total</th>
                    </tr>
                </thead>
                <tbody>
                    $tableRows
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan='2' style='padding: 10px; text-align: right;'><strong>Total:</strong></td>
                        <td style='padding: 10px;'><strong>$" . number_format($orderData['total'], 2) . "</strong></td>
                    </tr>
                </tfoot>
            </table>
            <br>
            <p>If you have any questions, please contact us.</p>
        ";

        // Send to Customer
        $email->setFrom($settings['smtp_user'], $settings['company_name'] ?? 'Luxe & Co');
        $email->setTo($orderData['email']);
        $email->setSubject($subject);
        $email->setMessage($message);
        $email->send();

        // Send to Admin
        if (!empty($settings['admin_email_notify'])) {
            $adminLink = base_url('admin/orders/show/' . $orderId);
            $adminMessage = "
                <h3>New Order Received!</h3>
                <p><strong>Order ID:</strong> #" . $orderId . "</p>
                <p><strong>Customer Name:</strong> " . esc($orderData['name']) . "</p>
                <p><strong>Customer Email:</strong> " . esc($orderData['email']) . "</p>
                <p><strong>Phone:</strong> " . esc($orderData['phone'] ?? 'N/A') . "</p>
                <p><strong>Country:</strong> " . esc($orderData['country'] ?? 'N/A') . "</p>
                <p><strong>Shipping Address:</strong><br>" . nl2br(esc($orderData['shipping_address'])) . "</p>
                <p><strong>Customer Note:</strong><br>" . nl2br(esc($orderData['customer_note'] ?? 'None')) . "</p>
                <br>
                <p><a href='" . $adminLink . "' style='display: inline-block; padding: 10px 20px; background-color: #222; color: #fff; text-decoration: none; border-radius: 4px; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;'>View Order in Admin Panel</a></p>
                <hr style='margin: 30px 0;'>
                <h4>Order Summary:</h4>
            ";

            $email->clear();
            $email->setFrom($settings['smtp_user'], $settings['company_name'] ?? 'Luxe & Co');
            $email->setTo($settings['admin_email_notify']);
            $email->setSubject("New Order Received #" . $orderId);
            $email->setMessage($adminMessage . $message);
            $email->send();
        }
    }

    public function success()
    {
        $data = [
            'title' => 'Order Confirmed'
        ];

        return view('templates/header', $data)
             . view('templates/navbar')
             . view('checkout/success', $data)
             . view('templates/footer');
    }
}
