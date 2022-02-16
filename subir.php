<?php

require_once './Conexion.php';
error_reporting(0);
header("Content-Type: application/json; charset=UTF-8");
$objeto = json_decode($_POST["objeto"], false);
$longitud = $objeto->lng;
$latitud = $objeto->lat;
$bdo = Conexion::conectar();
$bdo->beginTransaction();
$stmt = $bdo->prepare("INSERT INTO puntos VALUES (:id,:latitud,:longitud)"); // Conexion a BBDD
$stmt->bindValue("id", 0);
$stmt->bindValue("longitud", $longitud);
$stmt->bindValue("latitud", $latitud);
$todo_bien = $stmt->execute();
if ($todo_bien == true) {
    $bdo->commit();
} else {
    unset($bdo);
}



