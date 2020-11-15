<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * Obtiene todas las metas de la base de datos
 */
require 'Database.php';
require 'Profesional.php';

header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
//if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $listado = Profesional::getAll();

    if ($listado) {
        echo json_encode($listado);
    } else {
        echo json_encode(array(
			"estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
//}