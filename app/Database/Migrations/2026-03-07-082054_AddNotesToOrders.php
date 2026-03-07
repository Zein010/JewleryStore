<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNotesToOrders extends Migration
{
    public function up()
    {
        $fields = [];
        
        if (!$this->db->fieldExists('customer_note', 'orders')) {
            $fields['customer_note'] = [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'shipping_address',
            ];
        }

        if (!$this->db->fieldExists('admin_note', 'orders')) {
            $fields['admin_note'] = [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'customer_note',
            ];
        }

        if (!empty($fields)) {
            $this->forge->addColumn('orders', $fields);
        }
    }

    public function down()
    {
        $this->forge->dropColumn('orders', 'customer_note');
        $this->forge->dropColumn('orders', 'admin_note');
    }
}
