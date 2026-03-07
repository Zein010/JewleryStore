<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrderStatusLogsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'order_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'admin_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'old_status' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'new_status' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('order_id', 'orders', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('order_status_logs');
    }

    public function down()
    {
        $this->forge->dropTable('order_status_logs');
    }
}
