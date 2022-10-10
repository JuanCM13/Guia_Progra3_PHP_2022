<?php

include "./Parte 2/AccesoDatos.php";
include "./Parte 2/Pizza.php";

class Venta
{
    public $id;
    public $email;
    public $fecha;
    public $sabor;
    public $tipo;
    public $cantidad;

    public function __construct($id = -1, $email,$fecha,$sabor,$tipo,$cantidad)
    {
        $this->setId($id);
        $this->setEmail($email);
        $this->setFecha($fecha);
        $this->setSaborVenta($sabor);
        $this->setTipoVenta($tipo);
        $this->setCantidadVenta($cantidad);
    }

    //------------------------------------------------------------------------------------------------------------
    //SETTERS

    public function setId($idV)
    {
        if(!is_null($idV) && is_numeric($idV))
        {
            $this->id = $idV;
        }
    }

    public function setEmail($emailV)
    {
        if(!is_null($emailV) && gettype($emailV) == "string")
        {
            $this->email = $emailV;
        }
        else
        {
            throw new Exception("Error, email invalido");
        }
    }

    public function setFecha($fechaV)
    {
        if(!is_null($fechaV))
        {
            $this->fecha = $fechaV;
        }
        else
        {
            throw new Exception("Error, fecha invalido");
        }
    }

    public function setSaborVenta($saborV)
    {
        if(!is_null($saborV) && gettype($saborV) == "string")
        {
            $this->sabor = $saborV;
        }
        else
        {
            throw new Exception("Error, sabor invalido");
        }
    }

    public function setTipoVenta($tipoV)
    {
        if(!is_null($tipoV) && gettype($tipoV) == "string")
        {
            $this->tipo = $tipoV;
        }
        else
        {
            throw new Exception("Error, tipo invalido");
        }
    }

    public function setCantidadVenta($cantidadV)
    {
        if(!is_null($cantidadV) && is_numeric($cantidadV))
        {
            $this->cantidad = $cantidadV;
        }
        else
        {
            throw new Exception("Error, cantidad invalida");
        }
    }

    //------------------------------------------------------------------------------------------------------------
    //GETTERS

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function getSaborVenta()
    {
        return $this->sabor;
    }

    public function getTipoVenta()
    {
        return $this->tipo;
    }

    public function getCantidadVenta()
    {
        return $this->cantidad;
    }

    //---------------------------------------------------------------------------------------------

    public static function getSell_fromPizza($pizza , $email)
    {
        $venta = null;
        if(!is_null($pizza) && get_class($pizza) == "Pizza" && !is_null($email))
        {
            $fecha = date('Y-m-d');
            $venta = new Venta(-1,$email,$fecha,$pizza->getSabor(),$pizza->getTipo(),$pizza->getCantidad());
        }
        return $venta;
    }

    public function pushTo_BD()
    {
        try
        {
            $objPDO = AccesoDatos::dameUnObjetoAcceso();
            if(!is_null($objPDO))
            {
                $query = $objPDO->RetornarConsulta("INSERT INTO ventas_pizzas (email,fecha,sabor,tipo,cantidad)
                        VALUES (:ema , :fec , :sab , :tip , :cant)");
                $query->bindValue(":ema",$this->getEmail());
                $query->bindValue(":fec",$this->getFecha());
                $query->bindValue(":sab",$this->getSaborVenta());
                $query->bindValue(":tip",$this->getTipoVenta());
                $query->bindValue(":cant",$this->getCantidadVenta());
                
                $query->execute();
                if($query->rowCount() > 0)
                {
                    return true;
                }
            }
        }    
        catch(Exception $ex)
        {
            echo $ex->getMessage();
        }    
        return false;
    }
}



?>