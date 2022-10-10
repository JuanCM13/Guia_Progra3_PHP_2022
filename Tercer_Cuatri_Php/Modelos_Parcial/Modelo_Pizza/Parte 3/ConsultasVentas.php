<?php

/*4- (3 pts.)ConsultasVentas.php: necesito saber :
a- la cantidad de pizzas vendidas
b- el listado de ventas entre dos fechas ordenado por sabor.
c- el listado de ventas de un usuario ingresado
d- el listado de ventas de un sabor ingresado*/

include "./Parte 3/Venta.php";
try
{
    switch($_GET['consultaPor'])
    {
        case 'fecha':
            if(!empty($_POST['desde']) && !empty($_POST['hasta']))
            {
                $arRetornado = Venta::ventasOrdenadasPorSabor_EntreFechas($_POST['desde'], $_POST['hasta']);
                if(!is_null($arRetornado))
                {
                    if(count($arRetornado) > 0)
                    {
                        foreach($arRetornado as $venta)
                        {
                            echo $venta->mostrarVenta();
                        }
                    }
                    else
                    {
                        echo "No se encontraron ventas entre esas fechas..";
                    }
                }
            }
            else
            {
                echo "Error, algun dato vino incompleto..";
            }
        break;
        case 'cantidadVentas':
            $cantVentas = Venta::cantidadVentas_BD();
            if($cantVentas == -1)
            {
                $cantVentas = "Rompi todo";
            }
            echo "Cantidad de ventas: " .$cantVentas . "\n";
        break;
        case 'ventasPorUsuario':
            //el listado de ventas de un usuario ingresado
            if(!empty($_POST['mail']))
            {
                $arRetornado = Venta::ventasPorParam_BD($_POST['mail']);                
                if(!is_null($arRetornado))
                {
                    if(count($arRetornado) < 1)
                    {
                        echo "Error, no se encontraron ventas de ese usuario";
                    }

                    foreach($arRetornado as $venta)
                    {
                        echo $venta->mostrarVenta();
                    }
                }
                else
                {
                    echo "Error, algo fallo";
                }
            }   
            else
            {
                echo "Error, tiene que especificar el mail del usuario para filtrar..";
            }
        break;
        case 'ventasPorSabor':
        //el listado de ventas de un sabor ingresado
        if(!empty($_POST['sabor']))
        {
            $arRetornado = Venta::ventasPorParam_BD($_POST['sabor'],1);                
            if(!is_null($arRetornado))
            {              
                if(count($arRetornado) < 1)
                {
                    echo "Error, no se encontraron ventas de ese sabor";
                }

                foreach($arRetornado as $venta)
                {
                    echo $venta->mostrarVenta();
                }
            }
            else
            {
                echo "Error, algo fallo";
            }
        }   
        else
        {
            echo "Error, tiene que especificar el sabor para filtrar..";
        }
    break;
    }
}
catch(Exception $ex)
{
    echo "Error: " . $ex->getMessage();
}

?>