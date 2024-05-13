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
    <form class="formulario" action="saveupdatecontact.php" method="post">
        <fieldset>
            <legend>Editar contacto</legend>
            <div class="contenedor-campos">

                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                <div class="campo">
                    <label for="nombre">Nombre:</label>
                    <input class="input-text" type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($row['nombre']); ?>" required>
                </div>
                <div  class="campo">
                    <label for="telefono">Teléfono:</label>
                    <input class="input-text" type="text" name="telefono" id="telefono" value="<?php echo htmlspecialchars($row['telefono']); ?>">
                </div>
                <div  class="campo">
                    <label for="correo">Correo:</label>
                    <input class="input-text" type="email" name="correo" id="correo" value="<?php echo htmlspecialchars($row['correo']); ?>" required>
                </div>
                <div  class="campo">
                    <label for="mensaje">Mensaje:</label>
                    <textarea class="input-text" name="mensaje" id="mensaje" required><?php echo htmlspecialchars($row['mensaje']); ?></textarea>
                </div>
            </div>
            <div>
                <button class="boton w-sm-100 flex alinear-derecha" type="submit">Actualizar Contacto</button>
            </div>
        </fieldset>
    </form>
</body>
</html>

<?php include('footer.php');?>
