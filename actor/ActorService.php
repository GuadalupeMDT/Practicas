<?php

    switch($_SERVER['REQUEST_METHOD'])
    {
        case 'GET':
            {
            echo "Peticion GET";
            echo $_GET['param'];

            }
        break;
        case 'POST':
            echo "Peticion POST";
        break;
        case 'PUT':
            echo "Peticion PUT";
        break;
        case 'DELETE':
            echo "Peticion DELETE";
        break;
        default:
        echo "Peticion inexistente";
        break;
    }
?>