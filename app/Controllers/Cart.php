<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Cart extends BaseController
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $session = session();
        $cart = $session->get('cart') ?? [];
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $data = [
            'title' => 'Shopping Cart',
            'cart' => $cart,
            'total' => $total
        ];

        return view('templates/header', $data)
             . view('templates/navbar')
             . view('cart/index', $data)
             . view('templates/footer');
    }

    public function add()
    {
        $session = session();
        $cart = $session->get('cart') ?? [];
        
        $productId = $this->request->getPost('product_id');
        $quantity = (int) $this->request->getPost('quantity');
        $customizationText = $this->request->getPost('customization_text');
        
        if ($quantity <= 0) $quantity = 1;

        $product = $this->productModel->find($productId);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found');
        }

        // Get Main Image
        $imageModel = new \App\Models\ProductImageModel();
        $mainImage = $imageModel->where('product_id', $product['id'])->where('is_main', 1)->first();
        $imagePath = $mainImage ? $mainImage['image'] : ($product['image'] ?? '1.png');

        if (is_array($customizationText)) {
            foreach ($customizationText as $text) {
                $itemKey = $productId . '_' . md5($text ?? '');
                
                if (isset($cart[$itemKey])) {
                    $cart[$itemKey]['quantity'] += 1;
                } else {
                    $cart[$itemKey] = [
                        'id' => $product['id'],
                        'name' => $product['name'],
                        'price' => $product['price'],
                        'image' => $imagePath,
                        'slug' => $product['slug'],
                        'quantity' => 1,
                        'customization_text' => $text
                    ];
                }
            }
        } else {
            $itemKey = $productId . '_' . md5($customizationText ?? '');
        
            if (isset($cart[$itemKey])) {
                $cart[$itemKey]['quantity'] += $quantity;
            } else {
                $cart[$itemKey] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'image' => $imagePath,
                    'slug' => $product['slug'],
                    'quantity' => $quantity,
                    'customization_text' => $customizationText
                ];
            }
        }

        $session->set('cart', $cart);

        return redirect()->to('/cart')->with('success', 'Product added to cart!');
    }

    public function update()
    {
        $session = session();
        $cart = $session->get('cart') ?? [];
        
        $productId = $this->request->getPost('product_id');
        $quantity = (int) $this->request->getPost('quantity');
        
        if (isset($cart[$productId])) {
            if ($quantity <= 0) {
                unset($cart[$productId]);
            } else {
                $cart[$productId]['quantity'] = $quantity;
            }
            $session->set('cart', $cart);
        }

        return redirect()->to('/cart')->with('success', 'Cart updated');
    }

    public function remove($productId)
    {
        $session = session();
        $cart = $session->get('cart') ?? [];
        
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            $session->set('cart', $cart);
        }

        return redirect()->to('/cart')->with('success', 'Item removed from cart');
    }

    public function clear()
    {
        $session = session();
        $session->remove('cart');
        return redirect()->to('/cart')->with('success', 'Cart cleared');
    }
}
