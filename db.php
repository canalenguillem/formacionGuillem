<?php
// Parámetros de conexión
$servername = "localhost"; // El servidor de base de datos, localhost si es en el mismo servidor
$username = "guillem"; // El usuario de la base de datos
$password = "tu_contraseña"; // La contraseña del usuario de la base de datos
$dbname = "formacion"; // El nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Si la conexión es exitosa, no se imprime nada, simplemente el script continúa
?>
