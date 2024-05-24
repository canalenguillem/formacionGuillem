<?php include 'header.php'; 
include 'db.php';

$username=$_SESSION["usuario"];
$id=$_SESSION["id"];
echo "$id<br>";
$targetDir="";
$targetFilePath="";
$fileName="";
if(isset($_POST["submit"]) && !empty($_FILES["fileToUpload"]["name"])) {
    $targetDir = "uploads/";
    $fileName = basename($_FILES["fileToUpload"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    echo "<pre>";
    var_dump($targetDir);
    var_dump($fileName);
    var_dump($targetFilePath);
    var_dump($fileType);
    echo "</pre>";

    $allowTypes = array('jpg','png','jpeg','gif');
    echo "$fileType<br>";
    if(in_array($fileType, $allowTypes)){
        echo "file is good<br>";
        // Verificar si hay errores en la subida
        if($_FILES["fileToUpload"]["error"] == 0){
            // Subir archivo al servidor
            echo "subir archivo<br>";
            if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFilePath)){
                // Insertar información de la imagen en la base de datos
                $userId = $_POST['userId']; // Asegúrate de que este valor se maneja de manera segura
                $insert = $conn->query("INSERT INTO imagenes (usuario_id, ruta_imagen) VALUES ('".$userId."','".$targetFilePath."')");
                
                if($insert){
                    $statusMsg = "La imagen ".$fileName. " ha sido subida correctamente.";
                }else{
                    $statusMsg = "La subida falló, por favor intente nuevamente.";
                } 
            }else{
                $statusMsg = "Lo sentimos, hubo un error al subir tu archivo.";
            }
        }else{
            $statusMsg = "Error al cargar el archivo: " . $_FILES["fileToUpload"]["error"];

        }

    }


}


?>

<h1>Upload images</h1>
<form class="formulario" enctype="multipart/form-data" action="upload.php" method="post">
Seleccione imagen para subir:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="hidden" name="userId" value="1"> <!-- Asegúrate de reemplazar '1' con el ID del usuario real. -->
    <input type="submit" value="Subir Imagen" name="submit">
</form>
<?php include 'footer.php'; ?>
