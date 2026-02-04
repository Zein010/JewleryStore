<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPhoneAndCountryToOrders extends Migration
{
    public function up()
    {
        $fields = [
            'country' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'after'      => 'customer_email',
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'after'      => 'country',
            ],
        ];

        $this->forge->addColumn('orders', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('orders', 'country');
        $this->forge->dropColumn('orders', 'phone');
    }
}
