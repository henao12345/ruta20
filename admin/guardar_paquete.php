<?php
session_start();
include("../config/conexion.php");

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

$titulo = $_POST['titulo'];
$ciudad = $_POST['ciudad'];
$precio = $_POST['precio'];
$descripcion = $_POST['descripcion'];
$destacado = isset($_POST['destacado']) ? 1 : 0;

// Manejo de imagen
$imagen = $_FILES['imagen']['name'];
$ruta = "../uploads/" . $imagen;

move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta);

$sql = "INSERT INTO paquetes (titulo, ciudad, precio, descripcion, imagen, destacado)
        VALUES ('$titulo', '$ciudad', '$precio', '$descripcion', '$imagen', '$destacado')";

$conexion->query($sql);

header("Location: dashboard.php");
exit;
?>