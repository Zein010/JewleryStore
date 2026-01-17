<?php
// fix_db_raw.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "luxe_co_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully\n";

// SQL to create table
$sql = "CREATE TABLE IF NOT EXISTS settings (
    id INT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `key` VARCHAR(191) NOT NULL UNIQUE,
    `value` TEXT,
    created_at DATETIME,
    updated_at DATETIME
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'settings' created successfully\n";
} else {
    echo "Error creating table: " . $conn->error . "\n";
}

// Seed data
$now = date('Y-m-d H:i:s');
$data = [
    ['company_name', 'Luxe & Co.'],
    ['company_logo', ''],
    ['contact_email', 'info@luxeandco.com'],
    ['contact_phone', '+961 1 123 456'],
    ['contact_address', 'Beirut, Lebanon'],
    ['facebook_link', '#'],
    ['instagram_link', '#'],
    ['pinterest_link', '#']
];

$stmt = $conn->prepare("INSERT IGNORE INTO settings (`key`, `value`, created_at) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $key, $value, $now);

foreach ($data as $row) {
    $key = $row[0];
    $value = $row[1];
    $stmt->execute();
}

echo "Seeding complete.\n";

$conn->close();
?>
