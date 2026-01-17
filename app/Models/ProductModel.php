<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['category_id', 'name', 'slug', 'price', 'description', 'image', 'featured', 'details'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getFeatured()
    {
        return $this->select('products.*, product_images.image as image')
                    ->join('product_images', 'product_images.product_id = products.id AND product_images.is_main = 1', 'left')
                    ->where('featured', true)
                    ->findAll(3);
    }

    public function getByCategory($categoryId)
    {
        return $this->select('products.*, product_images.image as image')
                    ->join('product_images', 'product_images.product_id = products.id AND product_images.is_main = 1', 'left')
                    ->where('category_id', $categoryId)
                    ->findAll();
    }

    public function filterProducts($categoryId, $filters = [])
    {
        $builder = $this->select('products.*, product_images.image as image')
                        ->join('product_images', 'product_images.product_id = products.id AND product_images.is_main = 1', 'left');
        
        if ($categoryId) {
            $builder->where('category_id', $categoryId);
        }

        // Price Filter
        if (!empty($filters['min_price'])) {
            $builder->where('price >=', $filters['min_price']);
        }
        if (!empty($filters['max_price'])) {
            $builder->where('price <=', $filters['max_price']);
        }

        // Material Filter (JSON Search)
        if (!empty($filters['material'])) {
            // Simple LIKE search for JSON structure
            // We search for key "Material" and the specific value
            // Note: Use addslashes/escaping carefully or native JSON functions if available
            // For wide compatibility with text columns:
            $material = $this->db->escapeLikeString($filters['material']);
            // Looking for "Material":"InputValue" pattern roughly
            $builder->like('details', '"Material":"' . $material . '"');
        }

        // Sort
        if (!empty($filters['sort'])) {
            switch ($filters['sort']) {
                case 'price_low':
                    $builder->orderBy('price', 'ASC');
                    break;
                case 'price_high':
                    $builder->orderBy('price', 'DESC');
                    break;
                case 'newest':
                default:
                    $builder->orderBy('created_at', 'DESC');
                    break;
            }
        } else {
            $builder->orderBy('created_at', 'DESC');
        }

        return $builder->findAll();
    }
}
