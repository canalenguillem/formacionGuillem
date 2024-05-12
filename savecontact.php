<?php
include 'db.php'; // Incluye la conexión a la base de datos

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Asignar variables y verificar que no estén vacías
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
    $correo = isset($_POST['correo']) ? trim($_POST['correo']) : '';
    $mensaje = isset($_POST['Mensaje']) ? trim($_POST['Mensaje']) : '';

    // Verificar que ningún campo obligatorio esté vacío
    if (empty($nombre) || empty($correo) || empty($mensaje)) {
        // Algún campo obligatorio está vacío, redireccionar con error
        $conn->close();
        header("Location: contacto.php?status=error&msg=Campos Vacíos");
        exit;
    }


    // Preparar el comando SQL para insertar los datos
    $sql = "INSERT INTO contactos (nombre, telefono, correo, mensaje) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (false === $stmt) {
        // Manejar error de preparación
        error_log('mysqli prepare() failed: ');
        error_log("Errormessage: " . $conn->error);
        $conn->close();
        header("Location: contacto.php?status=error&msg=Fallo en insert");
        exit;
    }

    // Vincular parámetros y ejecutar
    $stmt->bind_param("ssss", $nombre, $telefono, $correo, $mensaje);
    $result = $stmt->execute();

    if ($result) {
        $stmt->close();
        $conn->close();
        // Redirigir a contacto.php con un parámetro de consulta de éxito
        header("Location: contacto.php?status=success&msg=Mensaje Guardado!");
        exit; // Asegúrate de llamar a exit después de header para detener la ejecución del script
    } else {
        $stmt->close();
        $conn->close();
        // Redirigir a contacto.php con un parámetro de consulta de error
        header("Location: contacto.php?status=error&msg=Error Guardando");
        exit;
    }
} else {
    // Acceso directo a este archivo sin POST
    header("Location: contacto.php?status=error&msg=Petición post inválida");
    exit;
}
?>
