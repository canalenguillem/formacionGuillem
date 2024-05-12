<?php
include 'db.php';

$sql = "SELECT id, nombre, telefono, correo, mensaje, fecha_registro FROM contactos";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Nombre: " . $row["nombre"]. " - Teléfono: " . $row["telefono"]. " - Correo: " . $row["correo"]. " - Mensaje: " . $row["mensaje"]. " - Registrado: " . $row["fecha_registro"]. "<br>";
    }
} else {
    echo "0 resultados";
}
$conn->close();
?>
