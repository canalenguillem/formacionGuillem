<?php
include 'db.php'; // Asegúrate de incluir el archivo de conexión a la base de datos
include 'header.php';

// Comprobar si se ha pasado el ID por GET y que no está vacío
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Preparar la consulta para obtener los datos del contacto
    $sql = "SELECT nombre, telefono, correo, mensaje FROM contactos WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (false === $stmt) {
        echo "Error al preparar la consulta: " . $conn->error;
        exit;
    }

    // Vincular el ID al parámetro de la consulta y ejecutar
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Obtener los resultados
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        // Obtener los datos como un array asociativo
        $row = $result->fetch_assoc();
    } else {
        echo "No se encontró un contacto con ese ID.";
        exit;
    }

    $stmt->close();
} else {
    echo "No se proporcionó un ID válido.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Contacto</title>
</head>
<body>
    <h1>Editar Contacto</h1>
    <form action="saveupdatecontact.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        <div>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($row['nombre']); ?>" required>
        </div>
        <div>
            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" id="telefono" value="<?php echo htmlspecialchars($row['telefono']); ?>">
        </div>
        <div>
            <label for="correo">Correo:</label>
            <input type="email" name="correo" id="correo" value="<?php echo htmlspecialchars($row['correo']); ?>" required>
        </div>
        <div>
            <label for="mensaje">Mensaje:</label>
            <textarea name="mensaje" id="mensaje" required><?php echo htmlspecialchars($row['mensaje']); ?></textarea>
        </div>
        <div>
            <button type="submit">Actualizar Contacto</button>
        </div>
    </form>
</body>
</html>

<?php include('footer.php');?>
