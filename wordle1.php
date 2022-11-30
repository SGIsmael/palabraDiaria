<?php
    include "funciones.php";
    if(empty($_COOKIE['victoria'])){
        if(puedeJugar()){
            $palabra =  leeSolucion('2022-11-30');
            if(!empty(quePalabras())){
                echo imprime(quePalabras());
            }
            echo "INTRODUCE UNA PALABRA: <form action=wordle2.php method=post><input type=text name=respuesta>";
            echo "<input type=submit></form>";
        }else{
            echo "se acabó";
        }        
    }else{
        echo "<h1>HAS GANADO!</h1>";
    }

?>