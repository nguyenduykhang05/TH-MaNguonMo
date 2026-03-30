<?php
require_once 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$key = "test_key";
$payload = ['data' => 'test_data'];

try {
    $jwt = JWT::encode($payload, $key, 'HS256');
    echo "Encoding successful: $jwt\n";
    $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
    echo "Decoding successful: " . $decoded->data . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
