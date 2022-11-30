<?php
    function conex(){
        $conex = new mysqli('localhost',"root","","wordle");
        return $conex;
    
    }
    function leeSolucion($dia){
        $conex = conex();
        $sentencia = "SELECT palabra FROM soluciones
                      WHERE DATE(fecha) = '".$dia."'";
        $palabra = $conex->query($sentencia);
        $palabra = $palabra->fetch_array();
        $conex->close();
        return $palabra[0];
    }
    function color($letra,$posicion,$palabra){
        if($letra == $palabra[$posicion]){
            //Letra y posición coinciden;
            return 'green';
        }
        for($i=0;$i<strlen($palabra);$i++){
            if($letra == $palabra[$i]){
                //Letra está, pero en otra posicion;
                return 'orange';
            }
        }
        //La letra no está
        return "white";
    }
    function acertado($palabra){
        $conex = conex();
        $fecha = date("Y-m-d");
        $sentencia = "SELECT palabra FROM soluciones
                      WHERE DATE(fecha) = '".$fecha."'";
        $hoy = $conex->query($sentencia);
        $hoy = $hoy->fetch_array();
        $conex->close();
        if($palabra == $hoy[0]){
            return true;
        }else{
            return false;
        }             
    }
    function imprime($array){
        $conex = conex();
        $fecha = date("Y-m-d");
        $sentencia = "SELECT palabra FROM soluciones
                      WHERE DATE(fecha) = '".$fecha."'";
        $hoy = $conex->query($sentencia);
        $hoy = $hoy->fetch_array();
        $respuesta ="<table border=1>";
        for($i=0;$i<count($array);$i++){
            $respuesta.= "<tr>";
            for($a=0;$a<strlen($array[$i]);$a++){
                $bgC = color($array[$i][$a],$a,$hoy[0]);
                $respuesta.="<td bgcolor=".$bgC.">".$array[$i][$a]."</td>";
            }
            $respuesta.= "</tr>";
        } 
        $respuesta.="</table>";
        echo $respuesta;
    }
    function nuevaPalabra($palabra){
        $array = unserialize($_COOKIE['palabras']);
        array_push($array,$palabra);
        setcookie("palabras",serialize($array),time()+24*60*60);
    }

    function quePalabras(){
        if(!empty($_COOKIE['palabras'])){
            return unserialize($_COOKIE['palabras']);
        }

    }
    function puedeJugar(){
        if(empty($_COOKIE['intentos'])){
            setcookie("intentos",1,time()+24*60*60);
            $palabras = array();
            setcookie("palabras",serialize($palabras),time()+24*60*60);
            return true;
        }else if($_COOKIE['intentos']<6){
            $intentos = $_COOKIE['intentos'];
            $intentos++;
            setcookie("intentos",$intentos,time()+24*60*60);
            return true;
        }else{
            return false;
        }
    }
?>