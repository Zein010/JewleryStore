<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'name' => 'Admin User',
            'email'    => 'admin@example.com',
            'password' => password_hash('password123', PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Simple check to avoid duplicates
        $exists = $this->db->table('admins')->where('email', $data['email'])->get()->getRow();
        if (!$exists) {
            $this->db->table('admins')->insert($data);
        }
    }
}
