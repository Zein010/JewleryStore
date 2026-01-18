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
        
        $matches = [];
        
        echo "<h1>Data Fixer Preview</h1>";
        echo "<p>Checking " . count($products) . " products...</p>";
        echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
        echo "<tr><th>ID</th><th>Name</th><th>Current Details (Raw)</th><th>Proposed JSON</th><th>Status</th></tr>";
        
        foreach ($products as $product) {
            $details = $product['details'];
            
            // Skip empty or already JSON
            if (empty($details)) continue;
            
            // basic check if it looks like JSON
            if (strpos(trim($details), '{') === 0) {
                 // echo "<tr><td>{$product['id']}</td><td>{$product['name']}</td><td>Hash</td><td>-</td><td>Skipped (Already JSON)</td></tr>";
                 continue;
            }

            // Regex refined for "Values Grams : Value Karat"
            // Added 's' modifier to handle potential newlines
            if (preg_match('/^(.+?Grams?)\s*:\s*(.+?Karat.*)$/is', trim($details), $m)) {
                $weight = trim($m[1]);
                $material = trim($m[2]);
                
                $newJson = json_encode([
                    'Weight' => $weight,
                    'Material' => $material
                ], JSON_PRETTY_PRINT);
                
                echo "<tr>";
                echo "<td>{$product['id']}</td>";
                echo "<td>{$product['name']}</td>";
                echo "<td>" . htmlspecialchars($details) . "</td>";
                echo "<td><pre>" . htmlspecialchars($newJson) . "</pre></td>";
                echo "<td style='color: green;'>Match Found</td>";
                echo "</tr>";
            } else {
                 echo "<tr>";
                 echo "<td>{$product['id']}</td>";
                 echo "<td>{$product['name']}</td>";
                 echo "<td>" . htmlspecialchars($details) . "</td>";
                 echo "<td>-</td>";
                 echo "<td style='color: orange;'>No Regex Match</td>";
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
            if (strpos(trim($details), '{') === 0) continue;

            if (preg_match('/^(.+?Grams?)\s*:\s*(.+)$/i', trim($details), $m)) {
                $weight = trim($m[1]);
                $material = trim($m[2]);
                
                $newJson = json_encode([
                    'Weight' => $weight,
                    'Material' => $material
                ]);
                
                $model->update($product['id'], ['details' => $newJson]);
                $count++;
            }
        }
        
        echo "<h1>Fix Applied</h1>";
        echo "<p>Updated $count products successfully.</p>";
        echo "<a href='" . base_url('admin/products') . "'>Back to Products</a>";
    }
}
