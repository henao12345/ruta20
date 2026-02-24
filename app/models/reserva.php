<?php
include("config/conexion.php");

// Recibir datos
$paquete_id = $_POST['paquete_id'];
$ciudad = $_POST['ciudad'];
$personas = $_POST['personas'];
$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];
$total = $_POST['total'];

// Insertar en DB
$sql = "INSERT INTO reservas (paquete_id, ciudad, personas, nombres, apellidos, telefono, correo, total)
        VALUES ('$paquete_id', '$ciudad', '$personas', '$nombres', '$apellidos', '$telefono', '$correo', '$total')";

if($conexion->query($sql)) {
    echo json_encode(["status" => "ok", "message" => "Reserva guardada"]);
} else {
    echo json_encode(["status" => "error", "message" => $conexion->error]);
}
?>