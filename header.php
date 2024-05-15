<?php
  require 'funciones.php';
  $auth=estaAutenticado() ;
  if(!$auth){
    header('Location: login.php');
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Formación En Guillem</title>
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/media.css" />
  </head>
  <body>
    <header>
      <h1 class="titulo">Guillem Mateu <span>formación</span></h1>
    </header>
    <div class="nav-bg">
      <nav class="navegacion-principal contenedor">
        <a href="index.php">Home</a>
        <a href="tutoriales.php">Tutoriales</a>
        <a href="contacto.php">Contacto</a>
        <a href="readcontacts.php">Mensajes</a>
        <?php
          if($auth):
            ?>
          <a class="logout" href="logout.php">Salir</a>

        <?php
          endif;
        ?>
      </nav>
    </div>
