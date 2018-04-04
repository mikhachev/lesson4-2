<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'lesson41');

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
    $pdo->exec("SET NAMES utf8;");

} catch (PDOException $e) {
    print "Achtung!: " . $e->getMessage() . "<br/>";
    die();
}

?>