
<?php
    include "./Parte 4/Venta.php";

    parse_str(file_get_contents("php://input"),$put_vars);

    if(!empty($put_vars['mail']) && !empty($put_vars['sabor']) && !empty($put_vars['tipo']) && !empty((int)$put_vars['cantidad']
            && !empty($put_vars['id'])))
    {
        try
        {
            $ventaAmodificar = new Venta(
                $put_vars['id'],
                $put_vars['mail'],
                "1900-01-01",
                $put_vars['sabor'],
                $put_vars['tipo'],
                $put_vars['cantidad']
            );
            if(!is_null($ventaAmodificar))
            {
                switch(Venta::modificarVenta($ventaAmodificar))
                {
                    case 0:
                        echo "Venta modificada con exito";
                        break;
                    case -1:
                        echo "Algo salio mal, reintente";
                        break;
                    case -2:
                        echo "No tenemos registro de esa venta, reingrese";
                        break;
                    case -3:
                        echo "No pudimos modificar la venta, reintente";
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
        echo "Error, algun campo vino vacio";
    }


?>