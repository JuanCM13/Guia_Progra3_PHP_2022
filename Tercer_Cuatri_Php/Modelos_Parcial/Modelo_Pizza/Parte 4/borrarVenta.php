<?php

include "./Parte 4/Venta.php";

parse_str(file_get_contents("php://input"),$put_vars);

if(!empty($put_vars['id']))
{
    try
    {
        switch(Venta::borrarRegistroVenta_BD($put_vars['id']))
        {
            case 0:
                echo "Venta eliminada con exito";
                break;
            case -1:
                echo "Algo salio mal, reintente";
                break;
            case -2:
                echo "No tenemos registro de esa venta, reingrese";
                break;
            case -3:
                echo "No pudimos eliminar la venta, reintente";
                break;
        }
    }
    catch(Exception $ex)
    {
        echo $ex->getMessage();
    }    
}
else
{
    echo "Error, campo id vino vacio";
}
?>