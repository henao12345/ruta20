<?php
include("config/conexion.php");
if(isset($_GET['id'])){
    $id = intval($_GET['id']);
    $conexion->query("DELETE FROM paquetes WHERE id=$id");
}
header("Location: admin_dashboard.php");
?>