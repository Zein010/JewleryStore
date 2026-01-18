<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;

class DataFixer extends BaseController
{
    public function preview()
    {
        $model = new ProductModel();
        $products = $model->findAll();
        
        echo "<h1>Data Fixer Preview</h1>";
        echo "<p>Checking " . count($products) . " products...</p>";
        echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
        echo "<tr><th>ID</th><th>Name</th><th>Current Details</th><th>Proposed JSON</th><th>Status</th></tr>";
        
        foreach ($products as $product) {
            $details = $product['details'];
            if (empty($details)) continue;
            
            $matchFound = false;
            $newJson = '';
            
            // Case 1: JSON Format like {"X Grams": "Y Karat"}
            $decoded = json_decode($details, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                
                // If it already has Weight/Material keys, skip it or mark as Good
                if (isset($decoded['Weight']) || isset($decoded['Material'])) {
                     continue; 
                }

                // Logic: Found a JSON without standard keys. 
                // Check if any KEY contains "Gram". If so, that Key is the Weight, and Value is Material.
                foreach ($decoded as $key => $val) {
                    if (strpos($key, 'Gram') !== false) {
                        $newJson = json_encode([
                            'Weight' => trim($key),
                            'Material' => trim($val)
                        ], JSON_PRETTY_PRINT);
                        $matchFound = true;
                        break; 
                    }
                }
            } 
            // Case 2: Raw String "X Grams : Y Karat"
            elseif (preg_match('/^(.+?Grams?)\s*:\s*(.+?Karat.*)$/is', trim($details), $m)) {
                $weight = trim($m[1]);
                $material = trim($m[2]);
                
                $newJson = json_encode([
                    'Weight' => $weight,
                    'Material' => $material
                ], JSON_PRETTY_PRINT);
                $matchFound = true;
            }

            if ($matchFound) {
                echo "<tr>";
                echo "<td>{$product['id']}</td>";
                echo "<td>{$product['name']}</td>";
                echo "<td>" . htmlspecialchars($details) . "</td>";
                echo "<td><pre>" . htmlspecialchars($newJson) . "</pre></td>";
                echo "<td style='color: green;'>Fix Available</td>";
                echo "</tr>";
            } else {
                 echo "<tr>";
                 echo "<td>{$product['id']}</td>";
                 echo "<td>{$product['name']}</td>";
                 echo "<td>" . htmlspecialchars($details) . "</td>";
                 echo "<td>-</td>";
                 echo "<td style='color: gray;'>Skipped / No Match</td>";
                 echo "</tr>";
            }
        }
        echo "</table>";
        echo "<br><br><a href='" . base_url('admin/fix-data/apply') . "' style='padding: 10px 20px; background: red; color: white; text-decoration: none;'>APPLY FIXES</a>";
    }

    public function apply()
    {
        $model = new ProductModel();
        $products = $model->findAll();
        $count = 0;
        
        foreach ($products as $product) {
            $details = $product['details'];
            if (empty($details)) continue;
            
            $newDetails = null;

            // Case 1: JSON
            $decoded = json_decode($details, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                // If valid structure, skip
                if (isset($decoded['Weight']) || isset($decoded['Material'])) continue;
                
                // Fix {"Key Grams": "Val Karat"}
                foreach ($decoded as $key => $val) {
                    if (strpos($key, 'Gram') !== false) {
                        $newDetails = json_encode([
                            'Weight' => trim($key), 
                            'Material' => trim($val)
                        ]);
                        break;
                    }
                }
            }
            // Case 2: Regex
            elseif (preg_match('/^(.+?Grams?)\s*:\s*(.+?Karat.*)$/is', trim($details), $m)) {
                $newDetails = json_encode([
                    'Weight' => trim($m[1]),
                    'Material' => trim($m[2])
                ]);
            }

            if ($newDetails) {
                $model->update($product['id'], ['details' => $newDetails]);
                $count++;
            }
        }
        
        echo "<h1>Fix Applied</h1>";
        echo "<p>Updated $count products successfully.</p>";
        echo "<a href='" . base_url('admin/products') . "'>Back to Products</a>";
    }
}
