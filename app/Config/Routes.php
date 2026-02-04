<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/shop', 'Shop::index');
$routes->get('/shop/category/(:segment)', 'Shop::category/$1');
$routes->get('/product/(:segment)', 'Product::index/$1');
$routes->get('/contact', 'Contact::index');
$routes->post('/contact/send', 'Contact::send');


// Cart Routes
$routes->get('cart', 'Cart::index');
$routes->post('cart/add', 'Cart::add');
$routes->post('cart/update', 'Cart::update');
$routes->get('cart/remove/(:any)', 'Cart::remove/$1');
$routes->get('cart/clear', 'Cart::clear');

// Checkout Routes
$routes->get('checkout', 'Checkout::index');
$routes->post('checkout/process', 'Checkout::process');
$routes->get('checkout/success', 'Checkout::success');

// Admin Routes
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
    // Auth (Public)
    $routes->get('login', 'Auth::index');
    $routes->post('login', 'Auth::login');
    $routes->get('logout', 'Auth::logout');

    // Protected Routes
    $routes->group('', ['filter' => 'adminAuth'], function ($routes) {
        $routes->get('/', 'Dashboard::index');
        $routes->get('dashboard', 'Dashboard::index');

        // Categories
        $routes->get('categories', 'Categories::index');
        $routes->get('categories/create', 'Categories::create');
        $routes->post('categories/store', 'Categories::store');
        $routes->get('categories/edit/(:num)', 'Categories::edit/$1');
        $routes->post('categories/update/(:num)', 'Categories::update/$1');
        $routes->get('categories/delete/(:num)', 'Categories::delete/$1');

        // Products
        $routes->get('products', 'Products::index');
        $routes->get('products/create', 'Products::create');
        $routes->post('products/store', 'Products::store');
        $routes->get('products/edit/(:num)', 'Products::edit/$1');
        $routes->post('products/update/(:num)', 'Products::update/$1');
        $routes->get('products/delete/(:num)', 'Products::delete/$1');
        $routes->get('products/delete-image/(:num)', 'Products::deleteImage/$1');

        // Orders Routes
        $routes->get('orders', 'Orders::index');
        $routes->get('orders/show/(:num)', 'Orders::show/$1');

        // Settings Routes
        $routes->get('settings', 'Settings::index');
        $routes->post('settings/update', 'Settings::update');

        // Contact Messages
        $routes->get('messages', 'ContactMessages::index');
        $routes->get('messages/show/(:num)', 'ContactMessages::show/$1');
        $routes->get('messages/delete/(:num)', 'ContactMessages::delete/$1');

        // Data Fixer (Temporary)
        $routes->get('fix-data/preview', 'DataFixer::preview');
        $routes->get('fix-data/apply', 'DataFixer::apply');
    });
});
