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
    protected $allowedFields    = ['category_id', 'name', 'slug', 'price', 'description', 'image', 'featured', 'details', 'customization_type', 'character_limit', 'limit_type'];

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

    public function getDynamicFilters($categoryId = null)
    {
        $builder = $this->builder();
        
        if ($categoryId) {
            $builder->where('category_id', $categoryId);
        }

        $products = $builder->get()->getResultArray();

        $dynamicFilters = [];
        $prices = [];
        
        foreach ($products as $product) {
            if (!empty($product['price'])) {
                $prices[] = $product['price'];
            }

            if (!empty($product['details'])) {
                $details = json_decode($product['details'], true);
                if (is_array($details)) {
                    foreach ($details as $key => $value) {
                         // Normalize Key
                         $key = ucwords(str_replace('_', ' ', $key));
                         
                         if (!isset($dynamicFilters[$key])) {
                             $dynamicFilters[$key] = [];
                         }
                         if (!in_array($value, $dynamicFilters[$key])) {
                             $dynamicFilters[$key][] = $value;
                         }
                    }
                }
            }
        }

        // Calculate Price Ranges
        $priceRanges = [];
        if (!empty($prices)) {
             $minPrice = floor(min($prices) / 1000) * 1000;
             $maxPrice = ceil(max($prices) / 1000) * 1000;

             for ($i = $minPrice; $i < $maxPrice; $i += 1000) {
                 $end = $i + 1000;
                 $priceRanges[] = [
                     'min' => $i,
                     'max' => $end,
                     'label' => '$' . number_format($i) . ' - $' . number_format($end)
                 ];
             }
        }

        return [
            'filters' => $dynamicFilters,
            'price_ranges' => $priceRanges
        ];
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

        // Dynamic Filters (JSON Search)
        foreach ($filters as $key => $value) {
            // Skip standard filters
            if (in_array($key, ['min_price', 'max_price', 'sort', 'page', 'per_page'])) {
                continue;
            }

            if (!empty($value)) {
                // Safe JSON search using LIKE
                // Matches "Key": "Value" pattern
                $key = $this->db->escapeLikeString($key);
                $value = $this->db->escapeLikeString($value);
                
                // Allow for slight variations in JSON spacing if needed, but standard is "Key": "Value"
                $builder->groupStart()
                        ->like('details', '"' . $key . '": "' . $value . '"')
                        ->orLike('details', '"' . $key . '":"' . $value . '"')
                        ->groupEnd();
            }
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
