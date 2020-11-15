<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'Database.php';
require 'Profesional.php';

header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
  $json = file_get_contents('php://input');
 
  $params = json_decode($json);
 
    $retorno = Profesional::insert(
        $params->pro_nombre,
		$params->pro_direccion,
        $params->pro_telefono);
	
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