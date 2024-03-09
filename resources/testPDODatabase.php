<?php
$user = 'root';
$password = '[CSQ*UkLvNVH2m90';
$database = 'chesswebsite';

try {
    $pdo = new PDO("mysql:host=localhost;charset=utf8mb4;dbname=$database", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}
?>
