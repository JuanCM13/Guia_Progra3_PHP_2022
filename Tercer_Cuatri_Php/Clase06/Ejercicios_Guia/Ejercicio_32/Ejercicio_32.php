<?php

/*
Aplicación No 32(Modificacion BD)
Archivo: ModificacionUsuario.php
método:POST
Recibe los datos del usuario(nombre, clavenueva, clavevieja,mail )por POST ,
crear un objeto y utilizar sus métodos para poder hacer la modificación,
guardando los datos la base de datos
retorna si se pudo agregar o no.
Solo pueden cambiar la clave
*/

include_once("../Ejercicio_27/Usuario.php");
$requestType = $_SERVER['REQUEST_METHOD'];
$expectedRequest = "POST";

//generete_pushSell_DB
if($requestType == $expectedRequest)
{ 
    if(!empty($_POST['nombre']) && !empty($_POST['claveVieja']) && !empty($_POST['claveNueva']))
    {
        switch(Usuario::updatePassword($_POST['nombre'],$_POST['claveVieja'],$_POST['claveNueva']))
        {
            case 0:
                echo "Clave actualizada con exito";
                break;
            case -1:
                echo "Error, el usuario y la clave no coinciden, revise..";
                break;
            case -2:
                echo "Error, la clave tiene que ser distinta a la anterior..";
                break;
        }        
    }
    else
    {
        echo "Algun param del Post vino vacio, revise";
    }
}
else
{
    echo "Error, se esperaba una petision por POST";
}

?>