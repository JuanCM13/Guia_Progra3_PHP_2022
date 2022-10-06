<?php

/*
Aplicación No 31 (RealizarVenta BD )
Archivo: RealizarVenta.php
método:POST
Recibe los datos del producto(código de barra), del usuario (el id )y la cantidad de ítems ,por
POST .
Verificar que el usuario y el producto exista y tenga stock.
Retorna un :
“venta realizada”Se hizo una venta
“no se pudo hacer“si no se pudo hacer
Hacer los métodos necesarios en las clases
*/

include "../Ejercicio_28/Venta.php";
$requestType = $_SERVER['REQUEST_METHOD'];
$expectedRequest = "POST";

//generete_pushSell_DB
if($requestType == $expectedRequest)
{ 
    if(!empty($_POST['codigo_barras']) && !empty($_POST['idUsuario']) && !empty($_POST['cantidad']))
    {
        if(Venta::generete_pushSell_DB($_POST['idUsuario'],$_POST['codigo_barras'],$_POST['cantidad']))
        {
            $retorno = "Venta realizada";
        }
        else
        {
            $retorno = "No se pudo realizar la venta";
        }
        echo $retorno;
    }
}
else
{
    echo "Error, se esperaba una petision por POST";
}

?>