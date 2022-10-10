<?php

class Pizza{
    public $id;
    public $sabor;
    public $precio;
    public $tipo;
    public $cantidad;

    public function __construct($id , $sabor = "" , $tipo = "" , $precio = -1 , $cantidad = -1)
    {
        $this->setID($id);
        $this->setSabor($sabor);
        $this->setPrecio($precio);
        $this->setTipo($tipo);
        $this->setCantidad($cantidad);
    }

    //---------------------------------------------------------------------------------
    //SETTERS


    public function setID($idP)
    {
        if(!is_null($idP) && is_numeric($idP))
        {
            $this->id = $idP;
        }
        else
        {
            throw new Exception("Error, id invalido");
        }
    }

    public function setSabor($saborP)
    {
        if(!is_null($saborP) && gettype($saborP) == "string")
        {
            $this->sabor = $saborP;
        }
        else
        {
            throw new Exception("Error, sabor invalido");
        }
    }

    public function setTipo($tipoP)
    {
        if(!is_null($tipoP) && gettype($tipoP) == "string" &&
            ($tipoP == "piedra" || $tipoP == "molde"))
        {
            $this->tipo = $tipoP;
        }
        else
        {
            throw new Exception("Error, tipo invalido");
        }
    }

    public function setCantidad($cantidadP)
    {
        if(!is_null($cantidadP) && is_numeric($cantidadP))
        {
            $this->cantidad = $cantidadP > 0 ? $cantidadP : 0;
        }
        else
        {
            throw new Exception("Error, cantidad invalida");
        }
    }

    public function setPrecio($precioP)
    {
        if(!is_null($precioP) && is_numeric($precioP))
        {
            $this->precio = $precioP > 0 ? $precioP : 0;
        }
        else
        {
            throw new Exception("Error, precio invalido");
        }
    }

    //---------------------------------------------------------------------------------
    //GETTERS

    public function getId()
    {
        return $this->id;
    }

    public function getSabor()
    {
        return $this->sabor;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    //---------------------------------------------------------------------------------
    //METODOS

    public function equals($pizza)
    {
        return (get_class($pizza) == "Pizza" && $pizza->getSabor() == $this->getSabor() &&
                                                $pizza->getTipo() == $this->getTipo());
    }

    public function mostrarDataPizza()
    {
        return "Pizza Sabor: " . $this->sabor . "\nTipo: " . $this->tipo . "\nPrecio: " . $this->precio . "\n";
    
    }

    //---------------------------------------------------------------------------------
    //METODOS MANEJO ARRAY

    //si esta retorna el indice, sino retorna -1
    public function estaEnArray($arrayPizzas)
    {
        $ret = -1;
        if(!is_null($arrayPizzas) && is_array($arrayPizzas))
        {
            $counter = 0;
            foreach($arrayPizzas as $pizza)
            {
                if($this->equals($pizza))
                {
                    $ret = $counter;
                    break;
                }
                $counter++;
            }
        }   
        return $ret;
    }

    public static function encontrarPizza_SaborTipo_Array($array,$pizzaAux)
    {
        $retornoPizza = "Algun dato vino erroneo";
        if(!is_null($array) && count($array) > 0 && get_class($pizzaAux) == "Pizza")
        {
            $retornoPizza = "No hay";
            $flagSabor = false;
            $flagTipo = false;
            foreach($array as $item)
            {
                if($item->getSabor() == $pizzaAux->getSabor())
                {
                    $flagSabor = true;
                }
                if($item->getTipo() == $pizzaAux->getTipo())
                {
                    $flagTipo = true;
                }
            }

            if($flagSabor && $flagTipo)
            {
                $retornoPizza = "Si hay";
            }
            else
            {
                if($flagSabor)
                {
                    $retornoPizza = "Hay sabor: " . $pizzaAux->getSabor() . "  pero no el tipo: " . $pizzaAux->getTipo() . "\n";
                }
                else
                {
                    if($flagTipo)
                    {
                        $retornoPizza = "Hay tipo: " . $pizzaAux->getTipo() . "  pero no el sabor: " . $pizzaAux->getSabor() . "\n";
                    }
                }
            }
        }
        return $retornoPizza;
    }


    public static function agregar_modificarPizza($pizza)
    {
//        echo "Entre 3";
        $ret = "No se pudo agregar..";
        if(get_class($pizza) == "Pizza")
        {
            $arrayPizzas = Pizza::retornarArrayPizza_Json();
            $index = $pizza->estaEnArray($arrayPizzas);
            if($index == -1)
            {
                //lo agrego
                array_push($arrayPizzas,$pizza);
                $ret = "Agregado.";
            }
            else
            {
                $arrayPizzas[$index]->setCantidad($arrayPizzas[$index]->getCantidad() + $pizza->getCantidad());
                $arrayPizzas[$index]->setPrecio($pizza->getPrecio());
                $ret = "Actualizado"; 
            }
            Pizza::guardarArrayPizza_Json($arrayPizzas);                
        }
        return $ret;
    }

    public static function guardarArrayPizza_Json($pizzas , $ruta = "Pizzas.json")
    {
        if(!is_null($pizzas) && is_array($pizzas))
        {
            try
            {
                $file = fopen($ruta,'w');
                if($file != false)
                {
                    $_pJson = json_encode($pizzas, JSON_PRETTY_PRINT);
                    fwrite($file,$_pJson);
                    return true;
                }
            }    
            catch(Exception $ex)
            {
                echo "Error: " . $ex->getMessage();
            }    
            finally
            {
                fclose($file);
            }                
        }
        return false;
    }

    public static function retornarArrayPizza_Json($ruta = "Pizzas.json")
    {
        $arrayRet = array();
        if(!is_null($ruta) && gettype($ruta) == "string")
        {
            if(file_exists($ruta))
            {
                try
                {
                    $file = fopen($ruta,'r');
                    if($file != false)
                    {
                        $_pJson = fread($file, filesize($ruta));
                        $pizzasJsonDeserilizadas = json_decode($_pJson,true);
    
                        foreach($pizzasJsonDeserilizadas as $pizza)
                        {
                            array_push($arrayRet,new Pizza(
                                            $pizza['id'],
                                            $pizza['sabor'],
                                            $pizza['tipo'],
                                            $pizza['precio'],
                                            $pizza['cantidad']
                                        ));
                        }
                    }                
                }
                catch(Exception $ex)
                {
                    echo "Error: " . $ex->getMessage();
                }
                finally
                {
                    fclose($file);
                    return $arrayRet;                    
                }
            }
        }
        return $arrayRet;   
    }
}

?>