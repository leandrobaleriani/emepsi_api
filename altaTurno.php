<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'Database.php';
require 'Turno.php';
require 'Profesional.php';
require 'FCM_Web.php';

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
		$params->device_id,
		$params->tur_telefono);
	
		if($retorno){

			$profesionales = Profesional::getAll();

			if ($profesionales) {
				foreach ($profesionales as $pro) {
					$regId = $pro['pro_token'];
	
					$notification = array();
					$arrNotification= array();
					$arrData = array();
					
					$arrNotification["body"] ="Se ha registrado un turno del tipo ". $params->tur_tipo . 
						".\nDatos ingresados: \nNombre: ". $params->tur_nombre 
						."\nTelefono: ". $params->tur_telefono
						."\nDetalle: ". $params->tur_detalle;
					
					$arrNotification["title"] = "Solicitud de Turno";
					$arrNotification["sound"] = "default";
					$arrNotification["type"] = 1;
					
					$fcm = new FCM();
					$result = $fcm->send_notification($regId, $arrNotification,"");
				}
	
			}
				// Código de éxito
				echo "1";
			} else{
				// Código de falla
				echo "2";
			}		
		}