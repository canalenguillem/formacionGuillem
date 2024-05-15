<?php
function estaAutenticado() : bool{
    session_start();
    $auth=$_SESSION['login'];
    if($auth){
        return true;
    }

    return false;
}

function logOut(){
    session_start();
    $_SESSION["usuario"]="";
    $_SESSION['login']=false;
}