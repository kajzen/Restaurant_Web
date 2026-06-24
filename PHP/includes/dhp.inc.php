<?php
/* $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); - */

if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1' || $_SERVER['REMOTE_ADDR'] === '::1') {
    $host = 'localhost';
    $dbname = 'admin';
    $dbuser = 'root';
    $dbpass = '23072007';
} else {
    $host = 'localhost';
    $dbname = 'sydormyk';
    $dbuser = 'sydormyk';
    $dbpass = 'webove aplikace';
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
