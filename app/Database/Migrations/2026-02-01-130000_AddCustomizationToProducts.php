<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCustomizationToProducts extends Migration
{
    public function up()
    {
        // Add fields to Products table
        $productFields = [
            'customization_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'none', // none, text
                'after'      => 'details',
            ],
            'character_limit' => [
                'type'       => 'INT',
                'constraint' => 5,
                'null'       => true,
                'after'      => 'customization_type',
            ],
            'limit_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'none', // none, exact, upto
                'after'      => 'character_limit',
            ],
        ];
        $this->forge->addColumn('products', $productFields);

        // Add fields to Order Items table
        $orderItemFields = [
            'customization_text' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'price',
            ],
        ];
        $this->forge->addColumn('order_items', $orderItemFields);
    }

    public function down()
    {
        $this->forge->dropColumn('products', ['customization_type', 'character_limit', 'limit_type']);
        $this->forge->dropColumn('order_items', 'customization_text');
    }
}
