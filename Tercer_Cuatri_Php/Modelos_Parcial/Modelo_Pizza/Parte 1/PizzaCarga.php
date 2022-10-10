<?php

include "../Pizza.php";

    if(!empty($_GET['sabor']) && !empty($_GET['tipo']) && !empty($_GET['precio']) && !empty($_GET['cantidad']))
    {
        try
        {
            $pedidoPizza = new Pizza(rand(1,9999999), $_GET['sabor'],$_GET['tipo'],$_GET['precio'],$_GET['cantidad']);
            if(!is_null($pedidoPizza))
            {
                echo Pizza::agregar_modificarPizza($pedidoPizza);
            } 
            else
            {
                echo "Error, algun dato vino incorrecto";
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