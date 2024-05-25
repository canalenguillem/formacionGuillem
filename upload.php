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


    $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'webp');
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
                // $insert = $conn->query("INSERT INTO imagenes (usuario_id, ruta_imagen) VALUES ('" . $id . "','" . $targetFilePath . "')");

                $stmt = $conn->prepare("INSERT INTO imagenes (usuario_id, ruta_imagen) VALUES (?, ?)");
                if ($stmt === false) {
                    die('MySQL prepare error: ' . $conn->error);
                }
                $stmt->bind_param("is", $id, $targetFilePath);
                $insert = $stmt->execute();

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
} else if (isset($_GET['foto_id'])){
    $foto_id = intval($_GET['foto_id']);

    // Primero, obtener la ruta del archivo de la base de datos
    $stmt = $conn->prepare("SELECT ruta_imagen FROM imagenes WHERE id = ?");
    $stmt->bind_param("i", $foto_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $file = $result->fetch_assoc();

    if ($file) {
        $filePath = $file['ruta_imagen'];
        $fileName = basename($filePath);


        // Ahora, eliminar el registro de la base de datos
        $stmt = $conn->prepare("DELETE FROM imagenes WHERE id = ?");
        $stmt->bind_param("i", $foto_id);
        $delete = $stmt->execute();

        if ($delete) {
            // Intentar eliminar el archivo físico
            if (file_exists($filePath)) {
                if (unlink($filePath)) {
                    header("Location: upload.php?msg=deleted&fileName=$fileName");
                    exit;
                } else {
                    $statusMsg = "Error al eliminar el archivo físico.";
                }
            } else {
                $statusMsg = "Archivo no encontrado.";
            }
        } else {
            $statusMsg = "La eliminación falló en la base de datos, por favor intente nuevamente.";
        }
    } else {
        $statusMsg = "No se encontró el archivo en la base de datos.";
    }

    echo $statusMsg; // Mostrar mensaje de error


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
if ($result->num_rows > 0) { ?>
    <div class="contenedor gallery">
        <?php
        while ($row = $result->fetch_assoc()) {
            $ruta = $row["ruta_imagen"];
            ?>
            <div class="card">
                <a href="<?=$ruta?>" data-lightbox="gallery">
                    <img src="<?= $ruta ?>" alt="">
                </a>
                <div class="card-content">
                    <a href="upload.php?foto_id=<?=$row['id']?>">X</a>
                </div>
            </div>
            <?php
        }
        ?>
    </div>

    <?php
} else {
    ?>
    <div class="contenedor gallery">

        <p>No se encontraron imágenes para el usuario.</p>
    </div>

    <?php
}

?>


<?php include 'footer.php'; ?>