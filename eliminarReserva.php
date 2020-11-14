<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
 * Insertar un nuevo usuario en la base de datos
 */
require 'Database.php';
require 'Reserva.php';

// Insertar usuario
    $retorno = Reserva::delete($_GET['id']);

    if ($retorno) {
        // Código de éxito
        echo json_encode(
            array(
                'estado' => '1',
                'mensaje' => 'Creación exitosa')
        );
    } else {
        // Código de falla
        echo json_encode(
            array(
                'estado' => '2',
                'mensaje' => 'Creación fallida')
        );
    }