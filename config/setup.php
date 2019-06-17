<?php
include_once 'database.php';

try {
    $conn = new PDO("mysql:host=$DB_DNS;port=$DB_PORT", $DB_USER, $DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("CREATE DATABASE IF NOT EXISTS $DB_NAME");
    $conn->exec("USE $DB_NAME");

    $conn->exec("CREATE TABLE IF NOT EXISTS users (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(30) NOT NULL,
        passwd VARCHAR(255) NOT NULL,
        email VARCHAR(50) NOT NULL,
        `hash` VARCHAR(32) NOT NULL,
        verification BOOLEAN NOT NULL default 0,
        noti BOOLEAN NOT NULL default 1
    );");
    $conn->exec("CREATE TABLE IF NOT EXISTS posts (
        id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
        img_path VARCHAR(255) NOT NULL,
        username VARCHAR(30) NOT NULL,
        post_date DATETIME NOT NULL
    );");
    
    $conn->exec("CREATE TABLE IF NOT EXISTS likes (
        id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
        img_path VARCHAR(255) NOT NULL,
        username VARCHAR(30) NOT NULL
    );");
    $conn->exec("CREATE TABLE IF NOT EXISTS comments (
        id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
        img_path VARCHAR(255) NOT NULL,
        username VARCHAR(30) NOT NULL,
        comment LONGTEXT NOT NULL
    );");
     // set the PDO error mode to exception
    }
catch(PDOException $e)
{
echo "Connection failed: " . $e->getMessage();
}
?>

