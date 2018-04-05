<?php

try {
    $pdo = new PDO('mysql:host=localhost;dbname=global', 'emikhachev', 'neto1668');
    $pdo->exec("SET NAMES utf8;");

} catch (PDOException $e) {
    print "Achtung!: " . $e->getMessage() . "<br/>";
    die();
}

?>