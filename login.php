<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/media.css" />
</head>
<body>
<?php 
require "db.php";
$errores=[];
$email="";
$password="";
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
        if($resultado->num_rows){
            //el usuario existe
            $usuario=mysqli_fetch_assoc($resultado);
            echo "usuario finded<br>";
            //verificar password
            $auth=password_verify($password,$usuario["password"]);
            var_dump($auth);
            if($auth){
                //el usuario está autenticado
                session_start();
                $_SESSION["usuario"]=$usuario["email"];
                $_SESSION["login"]=true;
                $_SESSION["id"]=$usuario["id"];
                // var_dump($_SESSION);
                header('Location: index.php');

            }else{
                $errores[]="El Password es incorrecto";
            }
        }else{
            $errores[]= "El Usuario no existe";
        }
    }
    ?>
    </pre>

    <?php
    
    
}


?>

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
    
</body>
</html>