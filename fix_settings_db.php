<?php

// Valid PHP CLI script to bootstrap CI4 and run code
// Based on public/index.php logic

$minPHPVersion = '7.4';
if (phpversion() < $minPHPVersion) {
    die("Your PHP version must be {$minPHPVersion} or higher to run CodeIgniter. Current version: " . phpversion());
}

// Path to the front controller (this file)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);

// Location of the Paths config file.
// This is the line that might need to be changed, depending on your
// public folder location.
$pathsPath = FCPATH . '../app/Config/Paths.php';

// ^^^ Change this if you move your application folder
require FCPATH . '../app/Config/Paths.php';
$paths = new \Config\Paths();

// Location of the framework bootstrap file.
require rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';

// Load the framework constants
if (file_exists(FCPATH . '../app/Config/Constants.php')) {
    require_once FCPATH . '../app/Config/Constants.php';
}

// Define the common functions
require_once rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'Common.php';

// --- Custom Logic ---

use Config\Database;

echo "Starting Manual Migration Fix...\n";

$db = Database::connect();
$forge = \Config\Database::forge();

// 1. Create Table if not exists
if (!$db->tableExists('settings')) {
    echo "Creating 'settings' table...\n";
    
    $fields = [
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
    ];

    $forge->addField($fields);
    $forge->addKey('id', true);
    $forge->createTable('settings', true); // TRUE adds 'IF NOT EXISTS'
    
    echo "Table 'settings' created.\n";

    // 2. Seed Data
    echo "Seeding default data...\n";
    $data = [
        ['key' => 'company_name',    'value' => 'Luxe & Co.', 'created_at' => date('Y-m-d H:i:s')],
        ['key' => 'company_logo',    'value' => '', 'created_at' => date('Y-m-d H:i:s')], 
        ['key' => 'contact_email',   'value' => 'info@luxeandco.com', 'created_at' => date('Y-m-d H:i:s')],
        ['key' => 'contact_phone',   'value' => '+961 1 123 456', 'created_at' => date('Y-m-d H:i:s')],
        ['key' => 'contact_address', 'value' => 'Beirut, Lebanon', 'created_at' => date('Y-m-d H:i:s')],
        ['key' => 'facebook_link',   'value' => '#', 'created_at' => date('Y-m-d H:i:s')],
        ['key' => 'instagram_link',  'value' => '#', 'created_at' => date('Y-m-d H:i:s')],
        ['key' => 'pinterest_link',  'value' => '#', 'created_at' => date('Y-m-d H:i:s')],
    ];

    $builder = $db->table('settings');
    // Ensure we don't duplicate
    foreach ($data as $row) {
        if ($builder->where('key', $row['key'])->countAllResults() == 0) {
            $builder->insert($row);
        }
    }
    echo "Seeding complete.\n";

} else {
    echo "Table 'settings' already exists.\n";
}

echo "Done.\n";
