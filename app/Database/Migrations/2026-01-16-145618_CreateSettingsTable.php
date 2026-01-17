<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'key' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'unique'     => true,
            ],
            'value' => [
                'type' => 'TEXT',
                'null' => true,
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
        $this->forge->createTable('settings');

        // Seed default settings
        $data = [
            ['key' => 'company_name',    'value' => 'Luxe & Co.', 'created_at' => date('Y-m-d H:i:s')],
            ['key' => 'company_logo',    'value' => '', 'created_at' => date('Y-m-d H:i:s')], // Upload path
            ['key' => 'contact_email',   'value' => 'info@luxeandco.com', 'created_at' => date('Y-m-d H:i:s')],
            ['key' => 'contact_phone',   'value' => '+961 1 123 456', 'created_at' => date('Y-m-d H:i:s')],
            ['key' => 'contact_address', 'value' => 'Beirut, Lebanon', 'created_at' => date('Y-m-d H:i:s')],
            ['key' => 'facebook_link',   'value' => '#', 'created_at' => date('Y-m-d H:i:s')],
            ['key' => 'instagram_link',  'value' => '#', 'created_at' => date('Y-m-d H:i:s')],
            ['key' => 'pinterest_link',  'value' => '#', 'created_at' => date('Y-m-d H:i:s')],
        ];
        $this->db->table('settings')->insertBatch($data);
    }

    public function down()
    {
        $this->forge->dropTable('settings');
    }
}
