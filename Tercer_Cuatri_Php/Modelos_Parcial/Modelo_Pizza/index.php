<?php

    $requestType = $_SERVER['REQUEST_METHOD'];
    //echo "Tipo request: " . $requestType;

    switch($requestType)
    {
        case "GET":
                switch($_GET['accion'])
                {
                    case "Cargar":
                        include "./Parte 1/PizzaCarga.php";
                        break;
                }
            break;
        case "POST":
                switch($_GET['accion'])
                {
                    case "Consultar":
                        include "./Parte 1/PizzaConsultar.php";
                        break;
                    case "Comprar":
                        include "./Parte 2/AltaVenta.php";
                        break;
                    case "InfoVenta":
                        include "./Parte 3/ConsultasVentas.php";
                        break;
                    }
            break;
        default:
            echo "Petision incorrecta..";
            break;
        case "PUT":
            include "./Parte 4/ModificarVenta.php";
            break;
        case "DELETE":
                include "./Parte 4/borrarVenta.php";
                break;
    }



?>