<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'Database.php';
require 'Turno.php';

header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
  $json = file_get_contents('php://input');
 
  $params = json_decode($json);
 
    // Insertar menu
	$fecha = date_create($params->tur_fecha);
    $retorno = Turno::insert(
        date_format($fecha, "Y-m-d"),
        $params->tur_hora,
		$params->tur_nombre,
        $params->tur_detalle,
		$params->tur_tipo,
        $params->tur_estado,
		$params->device_id);
	
    if($retorno){
			// Código de éxito
			print json_encode(
				array(
					'estado' => '1',
					'mensaje' => 'Creación exitosa')
			);
		} else{
			// Código de falla
			print json_encode(
				array(
					'estado' => '2',
					'mensaje' => 'Creación fallida')
			);
		}
}