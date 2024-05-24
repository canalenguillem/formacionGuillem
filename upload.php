<?php include 'header.php';
include 'db.php';

$username = $_SESSION["usuario"];
$id = $_SESSION["id"];
$targetDir = "";
$targetFilePath = "";
$fileName = "";
if (isset($_POST["submit"]) && !empty($_FILES["fileToUpload"]["name"])) {
    $targetDir = "uploads/";
    $fileName = basename($_FILES["fileToUpload"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);


    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
    if (in_array($fileType, $allowTypes)) {
        // Verificar si hay errores en la subida
        if ($_FILES["fileToUpload"]["error"] == 0) {
            // Subir archivo al servidor

            // Generar nombre de archivo hash SHA-256 basado en la fecha en milisegundos
            $milliseconds = round(microtime(true) * 1000);
            $hash = hash('sha256', $milliseconds);
            $newFileName = $hash . '.' . $fileType;
            $targetFilePath = $targetDir . $newFileName;

            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFilePath)) {
                // Insertar información de la imagen en la base de datos
                $userId = $_POST['userId']; // Asegúrate de que este valor se maneja de manera segura
                $insert = $conn->query("INSERT INTO imagenes (usuario_id, ruta_imagen) VALUES ('" . $id . "','" . $targetFilePath . "')");

                if ($insert) {
                    // Redirigir a otra página o la misma para evitar el reenvío del formulario
                    header("Location: upload.php?msg=uploaded&fileName=$fileName");
                    exit;
                } else {
                    $statusMsg = "La subida falló, por favor intente nuevamente.";
                }
            } else {
                $statusMsg = "Lo sentimos, hubo un error al subir tu archivo.";
            }
        } else {
            $statusMsg = "Error al cargar el archivo: " . $_FILES["fileToUpload"]["error"];

        }

    }


} else if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
    $fileName = $_GET['fileName'];
    ?>
        <h3>resultado: <?= $msg ?> file: <?= $fileName ?></h3>
    <?php
}


?>

<h1>Upload images</h1>
<form class="formulario" enctype="multipart/form-data" action="upload.php" method="post">
    Seleccione imagen para subir:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="hidden" name="userId" value="1"> <!-- Asegúrate de reemplazar '1' con el ID del usuario real. -->
    <input type="submit" value="Subir Imagen" name="submit">
</form>
<?php
$sql = "SELECT * FROM imagenes where usuario_id=?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('MySQL prepare error: ' . $conn->error);
}
// Vincular parámetros a la declaración preparada
$stmt->bind_param("i", $id);

// Ejecutar la declaración preparada
$stmt->execute();

// Obtener los resultados
$result = $stmt->get_result();
// Comprobar y mostrar los datos recuperados
if ($result->num_rows > 0) {?>
    <div class="contenedor gallery">
    <?php
    while ($row = $result->fetch_assoc()) {
        $ruta=$row["ruta_imagen"];
        ?>
        <img src="<?=$ruta?>" alt="">
        <?php
    }
    ?>
    </div>

    <?php
} else {
    echo "No se encontraron imágenes para el usuario.";
}

?>


<?php include 'footer.php'; ?>