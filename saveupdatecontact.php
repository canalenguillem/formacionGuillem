<?php
include 'db.php'; // Incluye el archivo de conexión a la base de datos

// Comprobar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Asignar variables y verificar que no estén vacías
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
    $correo = isset($_POST['correo']) ? trim($_POST['correo']) : '';
    $mensaje = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : '';

    // Verificar que ningún campo obligatorio esté vacío
    if (empty($id) || empty($nombre) || empty($correo) || empty($mensaje)) {
        echo "Por favor, completa todos los campos requeridos.";
        exit;
    }

    // Preparar el comando SQL para actualizar los datos
    $sql = "UPDATE contactos SET nombre=?, telefono=?, correo=?, mensaje=? WHERE id=?";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo "Error al preparar la consulta: " . $conn->error;
        exit;
    }

    // Vincular los parámetros a la consulta
    $stmt->bind_param("ssssi", $nombre, $telefono, $correo, $mensaje, $id);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        $msg= "Datos actualizados con éxito.";
        header("Location: readcontacts.php?status=success&msg=".$msg);

    } else {
        echo "Error al actualizar los datos: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Acceso inválido al archivo.";
}

$conn->close();
?>
