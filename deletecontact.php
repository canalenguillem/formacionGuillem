<?php
include 'db.php'; // Asegúrate de que este archivo contiene la conexión correcta a tu base de datos

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Comprobar que se ha enviado el ID y no está vacío
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];

        // Preparar la consulta SQL para eliminar el registro
        $sql = "DELETE FROM contactos WHERE id = ?";
        $stmt = $conn->prepare($sql);

        if (false === $stmt) {
            $msg= "Error al preparar la consulta: " . $conn->error;
            header("Location: readcontacts.php?status=error&msg=".$msg);

            exit;
        }

        // Vincular el parámetro y ejecutar la declaración
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $msg= "Registro eliminado con éxito.";
            $stmt->close();
            header("Location: readcontacts.php?status=success&msg=".$msg);
        } else {
            $msg= "Error al eliminar el registro: " . $stmt->error;
            $stmt->close();
            header("Location: readcontacts.php?status=error&msg=".$msg);
        }

    } else {
        $msg="Error: No se proporcionó ningún ID válido.";
        $conn->close();
        header("Location: readcontacts.php?status=error&msg=Error al eliminar el registro");

    }
} else {
    // No se accedió al archivo mediante un POST
    $msg="Solicitud no válida.";
    $conn->close();
    header("Location: readcontacts.php?status=error&msg=".msg);

}

?>
