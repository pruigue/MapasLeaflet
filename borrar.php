<?php
require_once './Conexion.php';
error_reporting(0);
header("Content-Type: application/json; charset=UTF-8");
$objeto = json_decode($_POST["objeto"], false);
$longitud = $objeto->lng;
$latitud = $objeto->lat;
$bdo = Conexion::conectar();
$bdo->beginTransaction();
$stmt = $bdo->prepare("DELETE from puntos where latitud=:latitud and longitud=:longitud"); // Conexion a BBDD
$stmt->bindValue("latitud", $latitud);
$stmt->bindValue("longitud", $longitud);
$todo_bien = $stmt->execute();
echo $todo_bien;
if ($todo_bien == true) {
    $bdo->commit();
} else {
    unset($bdo);
}