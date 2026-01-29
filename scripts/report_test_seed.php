<?php
// Menjalankan SQL seed test menggunakan konfigurasi .env
require __DIR__ . '/../vendor/autoload.php';

$dotEnvPath = realpath(__DIR__ . '/..');
if (file_exists($dotEnvPath . '/.env')) {
    Dotenv\Dotenv::createImmutable($dotEnvPath)->safeLoad();
}

$host = $_ENV['DB_HOST'] ?? '127.0.0.1';
$port = $_ENV['DB_PORT'] ?? '3306';
$db = $_ENV['DB_DATABASE'] ?? '';
$user = $_ENV['DB_USERNAME'] ?? '';
$pass = $_ENV['DB_PASSWORD'] ?? '';

$dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";
try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $sql = file_get_contents(__DIR__ . '/../database/sql/report_test_seed.sql');
    $pdo->exec($sql);
    echo "Test seed executed successfully.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
