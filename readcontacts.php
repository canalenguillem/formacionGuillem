<?php
include 'db.php';
include 'header.php';

$sql = "SELECT id, nombre, telefono, correo, mensaje, fecha_registro FROM contactos";
$result = $conn->query($sql);
?>

<?php
    if(isset($_GET['status'])){
        $status=$_GET['status'];
        $msg=$_GET['msg'];

        ?>
        <div class="contenedor result-save">
            <div class="msg <?=$status?>"><?=$msg?></div>
        </div>
        <?php
    }
?>

<div class="contenedor listado">
    <?php
    if ($result->num_rows > 0) {?>
        <div class="fila cabecera">
            <div class="campoCabecera">
                id
            </div>
            <div class="campoCabecera">
                Nombre
            </div>
            <div class="campoCabecera">
                Teléfono
            </div>
            <div class="campoCabecera">
                Correo
            </div>
            <div class="campoCabecera">
                Mensaje
            </div>
            <div class="campoCabecera">
                Acción
            </div>
        </div>
        <?php
        $num=0;
        while($row = $result->fetch_assoc()):
            $num++;
            $paridadd="impar";
            if($num % 2 == 0){
                $paridadd="par";
            }
    ?>
            <div class="fila <?=$paridadd?>">
                <div class="campo text-center">
                    <?=$row["id"]?> 
                </div>
                <div class="campo">
                    <?=$row["nombre"]?> 
                </div>
                <div class="campo text-center">
                    <?=$row["telefono"]?>
                </div>
                <div class="campo">
                    <?=$row["correo"]?>
                </div>
                <div class="campo">
                    <?=substr($row["mensaje"],0,51)?>...
                </div>
                <div class="btn-delete text-center">
                    <a href="deletecontact.php?id=<?=$row['id']?>">
                        <img width="25" src="img/delete.webp" alt="" srcset="">
                    </a>
                    <a href="updatecontact.php?id=<?=$row['id']?>">
                        <img width="25" src="img/edit.webp" alt="" srcset="">
                    </a>
                    <a href="read.php?id=<?=$row['id']?>">
                        <img width="25" src="img/read.webp" alt="" srcset="">
                    </a>
                </div>
            </div>
        <?php
        endwhile;
    } else {
        echo "0 resultados";
    }
?>
</div>

<?php
$conn->close();
?>

<?php include 'footer.php'; ?>

