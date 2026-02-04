<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;

class Categories extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $data['categories'] = $this->categoryModel->findAll();
        return view('admin/categories/index', $data);
    }

    public function create()
    {
        return view('admin/categories/create');
    }

    public function store()
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'slug' => 'required|min_length[3]|max_length[100]|is_unique[categories.slug]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $image = $this->request->getFile('image');
        $imageName = null;

        if ($image && $image->isValid() && !$image->hasMoved()) {
            $imageName = $image->getRandomName();
            $image->move('uploads/categories', $imageName);
        }

        $this->categoryModel->save([
            'name'  => $this->request->getPost('name'),
            'slug'  => $this->request->getPost('slug'),
            'image' => $imageName,
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
        ]);

        return redirect()->to('/admin/categories')->with('success', 'Category created successfully');
    }

    public function edit($id)
    {
        $data['category'] = $this->categoryModel->find($id);

        if (empty($data['category'])) {
            return redirect()->to('/admin/categories')->with('error', 'Category not found');
        }

        return view('admin/categories/edit', $data);
    }

    public function update($id)
    {
        $category = $this->categoryModel->find($id);
        
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'slug' => "required|min_length[3]|max_length[100]|is_unique[categories.slug,id,{$id}]",
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id'    => $id,
            'name'  => $this->request->getPost('name'),
            'slug'  => $this->request->getPost('slug'),
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
        ];

        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $imageName = $image->getRandomName();
            $image->move('uploads/categories', $imageName);
            $data['image'] = $imageName;
        }

        $this->categoryModel->save($data);

        return redirect()->to('/admin/categories')->with('success', 'Category updated successfully');
    }

    public function delete($id)
    {
        $this->categoryModel->delete($id);
        return redirect()->to('/admin/categories')->with('success', 'Category deleted successfully');
    }
}
