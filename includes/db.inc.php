<?php
require_once('config.inc.php');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;", $user, $pass);//mysql_i
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('SET NAMES "utf8"');
} catch (PDOException $e) {
    $output = 'Unable to connect to the database server. ' . $e->getMessage();
    include 'error.html.php';
    exit();
}