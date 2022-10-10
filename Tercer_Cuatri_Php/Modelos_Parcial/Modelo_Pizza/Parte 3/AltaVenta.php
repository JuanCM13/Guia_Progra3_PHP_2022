<?php

/*a- (1 pts.) AltaVenta.php: (por POST)se recibe el email del usuario y el sabor,tipo y cantidad ,si el ítem existe en
Pizza.json, y hay stock guardar en la base de datos( con la fecha, número de pedido y id autoincremental ) y se
debe descontar la cantidad vendida del stock .*/

    include "./Parte 3/Venta.php";
    if(!empty($_POST['email']) && !empty($_POST['sabor']) && !empty($_POST['tipo']) && !empty($_POST['cantidad']))
    {
        try
        {
            $pizzaAbuscar = new Pizza(-1,$_POST['sabor'],$_POST['tipo'],1,$_POST['cantidad']);
            $venta = Venta::getSell_fromPizza($pizzaAbuscar,$_POST['email']);
            if(!is_null($venta))
            {
                switch(Pizza::generarVenta($pizzaAbuscar))
                {
                    case 0:
                        if($venta->pushTo_BD())
                        {
                            echo "Venta concretada con exito";
                        }
                        else
                        {
                            echo "Error, no pudo cargarse la venta en la base de datos";
                        }
                        break;
                    case -1:    
                        echo "Algun dato vino erroneo..";
                        break;
                    case -2:    
                        echo "El producto no existe actualmente..";
                        break;
                    case -3:    
                        echo "No hay suficiente stock para generar la venta..";
                        break;
                }
            }
        }
        catch(Exception $ex)
        {
            echo $ex->getMessage();
        }
    }
    else
    {
        echo "Error, alguno de los datos vino vacio..."; 
    } 
?>