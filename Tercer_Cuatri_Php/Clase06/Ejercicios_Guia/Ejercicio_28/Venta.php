<?php

include "../Ejercicio_28/AccesoDatos_Ventas.php";
include_once("../Ejercicio_28/Producto.php");
include_once("../Ejercicio_27/Usuario.php");

class Venta
{
    private $id_producto;
    private $id_usuario;
    private $cantidad;
    private $fecha_de_venta;

    public function __construct($idProd,$idUsuario,$cantidad,$fecha = -1)
    {
        
        if(!is_numeric($idProd))
        {
            return null;
        }
        $this->id_producto = $idProd;

        if(!is_numeric($idUsuario))
        {
            return null;
        }
        $this->id_usuario = $idUsuario;

        $auxCant = $cantidad;
        if($auxCant < 0)
        {
            $auxCant = 0;
        }
        $this->cantidad = $cantidad;

        $auxDate = $fecha;
        if($auxDate == -1)
        {
            $auxDate = date('Y-m-d');
        }
        $this->fecha_de_venta = $auxDate;
    }

    public function printSell_Data()
    {
        return "Venta: \nId Producto: " . $this->id_producto . "\nId Usuario: " . $this->id_usuario . "\nFecha: " . $this->fecha_de_venta . 
        "\nCantidad: " . $this->cantidad . "\n";
    }

    public static function getAllSells_BD()
    {
        $objPDO = AccesoDatos_Ventas::dameUnObjetoAcceso();
        if(!is_null($objPDO))
        {
            try
            {
                $query = $objPDO->RetornarConsulta("SELECT id_producto AS idProducto , id_usuario AS idUsuario , cantidad , 
                fecha_de_venta AS fecha FROM ventas");
                $query->execute();
                //Acordarse de pasar el array de atributosde la clase a parsear, sino si le dejas el constructor
                //rompe, sino tambien, sin el constructor funca, pero limita el uso de toda la clase..
                //ESTA PORQUERIA NO FUNCIONA, NOMAS PUDE HACERLO ANDAR CON EL ASSOC Y CREAR OBJETOS A MANOPLA
                $arrRet = $query->fetchAll(PDO::FETCH_ASSOC);
                //var_dump($arrRet);

                $listadoVentas = array();
                foreach($arrRet as $venta)
                { 
                    array_push($listadoVentas,new Venta($venta['idProducto'],$venta['idUsuario'],$venta['cantidad'],$venta['fecha']));
                }

                /*foreach($listadoVentas as $item)
                {
                    echo "ID Producto:" . $item->id_producto . "\nID usuario: " . $item->id_usuario . "\ncantidad: " . $item->cantidad . "\nFecha: " . $item->fecha_de_venta;
                }*/

                return $listadoVentas;
            }
            catch(Exception $ex)
            {
                echo $ex->getMessage();
            }
        }
        return "Rompi todo";
    }

    /*Se ingresa datos para realizar una venta, se chequea que el usuario y el producto existan,
    se trae el producto para extraer la data y actualizarlo. Se chequea que se pueda realizar la venta,
    si se puede realizar se crea registro de venta, si se registra bien, se actualiza el producto.
    */
    public static function generete_pushSell_DB($idUser , $productCode , $amount)
    {
        if(is_numeric($idUser) && is_numeric($productCode) && is_numeric($amount) && $amount > 0)
        {
            $auxProduct = Producto::productExist_BD($productCode);
            if(!is_null($auxProduct) && !is_null(Usuario::userExist_BD($idUser)))
            {
                if($auxProduct->sellProduct($amount))
                {                    
                    $newSell = new Venta($auxProduct->id,$idUser,$amount);
                    if(!is_null($newSell))
                    {
                        $objPDO = AccesoDatos_Productos::dameUnObjetoAcceso();
                        if(!is_null($objPDO))
                        {
                            $query = $objPDO->RetornarConsulta("INSERT INTO ventas (id_producto , id_usuario , cantidad , fecha_de_venta) 
                                                VALUES (:idP , :idU , :can , :fecha)");
                            $query->bindValue(":idP",$newSell->id_producto);
                            $query->bindValue(":idU",$newSell->id_usuario);
                            $query->bindValue(":can",$newSell->cantidad);
                            $query->bindValue(":fecha",$newSell->fecha_de_venta);
                            $query->execute();

                            if($query->rowCount() > 0)
                            {
                                if(Producto::insertOrUpdate_Product_BD($auxProduct,true) === "Actualizado")
                                {
                                    return true;
                                }
                            }
                        }
                    }
                }
            }
            return false;
        }
    }
}


?>