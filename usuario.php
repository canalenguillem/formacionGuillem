<?php

/*
CREATE TABLE usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(50) NOT NULL,
    password CHAR(60) NOT NULL
);

CORREO UNICO
CREATE TABLE usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(50) NOT NULL UNIQUE,
    password CHAR(60) NOT NULL
);


*/

//importar connexion
require "db.php";
//crear email y password
$email="correo@correo.com";
$password="123456";

$query = "INSERT INTO usuarios (email,password) VALUES ('${email}','${password}');";
echo "${query}";
mysqli_query($conn,$query);
