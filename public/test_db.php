<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Checking users in database...\n<br>";

try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=inventory_management", "laravel", "password123");
    echo "Connected!\n<br>";
    
    // Check if test user exists
    $stmt = $pdo->prepare("SELECT id, name, email FROM users WHERE email = ?");
    $stmt->execute(['test@example.com']);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        echo "Found demo user: " . json_encode($user) . "\n<br>";
    } else {
        echo "Demo user test@example.com not found!\n<br>";
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n<br>";
}
