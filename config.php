<?php
$conn = 'mysql:host=localhost;dbname=curso_pdo1';

try {
    $db = new PDO($conn, 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    if($e->getCode() == 1049){
        echo "Banco de dado está errado!";
    } else {
        echo $e->getMessage();
    }
}