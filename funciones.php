<?php
$host = "localhost";
$usuario = "root";
$contrasena = ""; // Cambia si tu MySQL tiene contraseña
$bd = "01_calif"; // Asegúrate que sea el nombre correcto de tu BD

$conn = new mysqli($host, $usuario, $contrasena, $bd);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
