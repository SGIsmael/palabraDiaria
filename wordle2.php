<?php
    include "funciones.php";
    $palabra = $_POST['respuesta'];
    echo $palabra;
    if(strlen($palabra) !=5){
        header("location:wordle1.php");
    }else{
        if(acertado($palabra)){
            setcookie("victoria","HAS GANADO",time()+2*60);
            header("location:wordle1.php");
        }else{
            nuevaPalabra($palabra);
            header("location:wordle1.php");
        }
    }
?>