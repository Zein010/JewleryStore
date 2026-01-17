<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDetailsToProducts extends Migration
{
    public function up()
    {
        $this->forge->addColumn('products', [
            'details' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('products', 'details');
    }
}
