<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\ProductImageModel;

class Products extends BaseController
{
    protected $productModel;
    protected $categoryModel;
    protected $productImageModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->productImageModel = new ProductImageModel();
    }

    public function index()
    {
        $products = $this->productModel
            ->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->findAll();

        // Attach main image to each product
        foreach ($products as &$product) {
            $mainImage = $this->productImageModel
                ->where('product_id', $product['id'])
                ->where('is_main', true)
                ->first();
            
            // Fallback to any image if no main image is set
            if (!$mainImage) {
                $mainImage = $this->productImageModel
                    ->where('product_id', $product['id'])
                    ->first();
            }

            $product['image'] = $mainImage ? $mainImage['image'] : null;
        }

        $data['products'] = $products;
        return view('admin/products/index', $data);
    }

    public function create()
    {
        $data['categories'] = $this->categoryModel->findAll();
        return view('admin/products/create', $data);
    }

    public function store()
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[150]',
            'slug' => 'required|min_length[3]|max_length[150]|is_unique[products.slug]',
            'category_id' => 'required|integer',
            'price' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Process Details
        $details = [];
        $keys = $this->request->getPost('details_keys');
        $values = $this->request->getPost('details_values');

        if ($keys && $values) {
            foreach ($keys as $index => $key) {
                if (!empty($key) && isset($values[$index])) {
                    $details[$key] = $values[$index];
                }
            }
        }

        // Save Product details first
        $productId = $this->productModel->insert([
            'category_id' => $this->request->getPost('category_id'),
            'name'        => $this->request->getPost('name'),
            'slug'        => $this->request->getPost('slug'),
            'price'       => $this->request->getPost('price'),
            'description' => $this->request->getPost('description'),
            'featured'    => $this->request->getPost('featured') ? 1 : 0,
            'details'     => json_encode($details),
            'customization_type' => $this->request->getPost('customization_type'),
            'character_limit'    => $this->request->getPost('character_limit'),
            'limit_type'         => $this->request->getPost('limit_type'),
        ]);

        // Handle Image Uploads
        $images = $this->request->getFiles();
        if ($images) {
            $isFirst = true;
            foreach ($images['images'] as $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    $newName = $img->getRandomName();
                    // Change extension to webp
                    $newName = pathinfo($newName, PATHINFO_FILENAME) . '.webp';
                    
                    // Convert and Save
                    \Config\Services::image()
                        ->withFile($img)
                        ->convert(IMAGETYPE_WEBP)
                        ->save(FCPATH . 'uploads/products/' . $newName);

                    $this->productImageModel->insert([
                        'product_id' => $productId,
                        'image'      => $newName,
                        'is_main'    => $isFirst // First image is main by default
                    ]);
                    $isFirst = false;
                }
            }
        }

        return redirect()->to('/admin/products')->with('success', 'Product created successfully');
    }

    public function edit($id)
    {
        $data['product'] = $this->productModel->find($id);
        $data['categories'] = $this->categoryModel->findAll();
        $data['images'] = $this->productImageModel->where('product_id', $id)->findAll();

        if (empty($data['product'])) {
            return redirect()->to('/admin/products')->with('error', 'Product not found');
        }

        return view('admin/products/edit', $data);
    }

    public function update($id)
    {
        $product = $this->productModel->find($id);
        
        $rules = [
            'name' => 'required|min_length[3]|max_length[150]',
            'slug' => "required|min_length[3]|max_length[150]|is_unique[products.slug,id,{$id}]",
            'category_id' => 'required|integer',
            'price' => 'required|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Process Details
        $details = [];
        $keys = $this->request->getPost('details_keys');
        $values = $this->request->getPost('details_values');

        if ($keys && $values) {
            foreach ($keys as $index => $key) {
                if (!empty($key) && isset($values[$index])) {
                    $details[$key] = $values[$index];
                }
            }
        }

        $this->productModel->save([
            'id'          => $id,
            'category_id' => $this->request->getPost('category_id'),
            'name'        => $this->request->getPost('name'),
            'slug'        => $this->request->getPost('slug'),
            'price'       => $this->request->getPost('price'),
            'description' => $this->request->getPost('description'),
            'featured'    => $this->request->getPost('featured') ? 1 : 0,
            'details'     => json_encode($details),
            'customization_type' => $this->request->getPost('customization_type'),
            'character_limit'    => $this->request->getPost('character_limit'),
            'limit_type'         => $this->request->getPost('limit_type'),
        ]);

        // Handle New Image Uploads
        $images = $this->request->getFiles();
        if ($images) {
            foreach ($images['images'] as $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    $newName = $img->getRandomName();
                    $newName = pathinfo($newName, PATHINFO_FILENAME) . '.webp';
                    
                    \Config\Services::image()
                        ->withFile($img)
                        ->convert(IMAGETYPE_WEBP)
                        ->save(FCPATH . 'uploads/products/' . $newName);

                    // Check if there are any existing images to set main
                    $hasMain = $this->productImageModel->where('product_id', $id)->where('is_main', true)->countAllResults() > 0;

                    $this->productImageModel->insert([
                        'product_id' => $id,
                        'image'      => $newName,
                        'is_main'    => !$hasMain
                    ]);
                }
            }
        }

        // Update Main Image Selection (if provided via radio button)
        $mainImageId = $this->request->getPost('main_image');
        if ($mainImageId) {
            // Reset all to false
            $this->productImageModel->where('product_id', $id)->set(['is_main' => false])->update();
            // Set new main
            $this->productImageModel->update($mainImageId, ['is_main' => true]);
        }

        return redirect()->to('/admin/products')->with('success', 'Product updated successfully');
    }

    public function delete($id)
    {
        // Delete images first
        $images = $this->productImageModel->where('product_id', $id)->findAll();
        foreach ($images as $img) {
            if (file_exists(FCPATH . 'uploads/products/' . $img['image'])) {
                unlink(FCPATH . 'uploads/products/' . $img['image']);
            }
        }
        $this->productImageModel->where('product_id', $id)->delete();
        $this->productModel->delete($id);
        
        return redirect()->to('/admin/products')->with('success', 'Product deleted successfully');
    }

    public function deleteImage($id)
    {
        $image = $this->productImageModel->find($id);
        if ($image) {
            if (file_exists(FCPATH . 'uploads/products/' . $image['image'])) {
                unlink(FCPATH . 'uploads/products/' . $image['image']);
            }
            $this->productImageModel->delete($id);
            
            // If it was main, set another one as main
            if ($image['is_main']) {
                $nextImage = $this->productImageModel->where('product_id', $image['product_id'])->first();
                if ($nextImage) {
                    $this->productImageModel->update($nextImage['id'], ['is_main' => true]);
                }
            }
        }
        return redirect()->back()->with('success', 'Image deleted');
    }
}
