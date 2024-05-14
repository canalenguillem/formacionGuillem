<?php 
require "db.php";
$errores=[];
$email="";
if($_SERVER['REQUEST_METHOD']==="POST"){
    ?>
    <pre>
        <!-- <?=var_dump($_POST)?> -->
        <?php
    $email=mysqli_real_escape_string($conn,filter_var($_POST['email'],FILTER_VALIDATE_EMAIL));
    // var_dump($email);
    $password=mysqli_real_escape_string($conn,$_POST['password']);
    // var_dump($password);
    
    if(!$email){
        $errores[]="El correo es obligatorio o no es válido";
    }
    if(!$password){
        $errores[]= "El password es obligatorio";
    }
    // var_dump($errores);
    if(empty($errores)){
        //revisar si el usuario existe
        $query="SELECT * FROM usuarios WHERE email='$email'";
        $resultado=mysqli_query($conn,$query);
        var_dump($resultado);
        if($resultado->num_rows){
            echo "usuario finded<br>";
        }else{
            $errores[]= "El Usuario no existe";
        }
    }
    ?>
    </pre>

    <?php
    
    
}


include 'header.php'; ?>

<h1>Iniciar sesión</h1>
<?php foreach($errores as $error):?>
    <div class="alerta error">
        <?=$error?>
    </div>
<?php endforeach; ?>
<main>
    <form class="formulario" method="POST" novalidate>
        <fieldset>
            <legend>Email y password</legend>
            <div class="contenedor-campos">
                <div class="campo">
                    <label for="correo">Email</label>
                    <input class="input-text" type="email" name="email" placeholder="Tu Email" required />
                </div>
                <div class="campo">
                    <label for="">Password:</label>
                    <input class="input-text" type="password" name="password" placeholder="Tu Password" required />
                </div>
                <div>
                    <input class="boton w-sm-100 flex alinear-derecha" type="submit" value="Entrar" />
            </div>
        </fieldset>
    </form>
    </section>
</main>
<?php include 'footer.php'; ?>