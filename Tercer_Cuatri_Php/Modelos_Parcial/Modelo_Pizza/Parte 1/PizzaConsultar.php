<?php

include "../Pizza.php";
/*(1pt.) PizzaConsultar.php: (por POST)Se ingresa Sabor,Tipo, si coincide con algún registro del archivo Pizza.json,
retornar “Si Hay”. De lo contrario informar si no existe el tipo o el sabor.*/

if(!empty($_POST['sabor']) && !empty($_POST['tipo']))
{
    try
    {
        $pizzaAbuscar = new Pizza(-1,$_POST['sabor'],$_POST['tipo'],1,1);
        echo Pizza::encontrarPizza_SaborTipo_Array(Pizza::retornarArrayPizza_Json(),$pizzaAbuscar);
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