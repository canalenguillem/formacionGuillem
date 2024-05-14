<?php
include 'db.php'; // Incluye la conexión a la base de datos
include "header.php";

// Comprobar si se ha pasado el ID por GET y que no está vacío
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Preparar la consulta para obtener los datos del contacto
    $sql = "SELECT id, nombre, telefono, correo, mensaje FROM contactos WHERE id = ?";
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
    if ($row = $result->fetch_assoc()) {
        // Aquí se muestra la información, el código HTML sigue después de este bloque PHP
        $stmt->close();
    } else {
        echo "No se encontró un contacto con ese ID.";
        $conn->close();
        exit;
    }
} else {
    echo "No se proporcionó un ID válido o no es un número.";
    exit;
}
?>

<main class="contenedor">
    <h1>Detalles del Contacto</h1>
    <div>
        <p><strong>Nombre:</strong> <?php echo htmlspecialchars($row['nombre']); ?></p>
        <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($row['telefono']); ?></p>
        <p><strong>Correo:</strong> <?php echo htmlspecialchars($row['correo']); ?></p>
        <p><strong>Mensaje:</strong> <?php echo htmlspecialchars($row['mensaje']); ?></p>
    </div>
    <a href="updatecontact.php?id=<?php echo $row['id']; ?>">Editar Contacto</a>
</main>


<?php include("footer.php");?>
