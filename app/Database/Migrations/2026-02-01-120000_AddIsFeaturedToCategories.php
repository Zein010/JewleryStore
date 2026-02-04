<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsFeaturedToCategories extends Migration
{
    public function up()
    {
        $fields = [
            'is_featured' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
                'after'      => 'image',
            ],
        ];

        $this->forge->addColumn('categories', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('categories', 'is_featured');
    }
}
