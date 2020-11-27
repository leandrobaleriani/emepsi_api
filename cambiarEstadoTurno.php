<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
 * Insertar un nuevo menu en la base de datos
 */
require 'Database.php';
require 'Turno.php';
require 'FCM.php';
require 'Dispositivo.php';

header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

	$id = $_GET['id'];
	$estado = $_GET['estado'];
	
	$retorno = Turno::updateEstado($id,$estado);
	
	if($retorno){

		$turno = Turno::getById($id);

		if ($turno) {

			$deviceId = $turno['device_id'];

			$dispositivo = Dispositivo::getByDeviceId($deviceId);

			if ($dispositivo) {

				$regId = $dispositivo['dis_firebase_token'];

				$notification = array();
				$arrNotification= array();
				$arrData = array();
				$arrNotification["body"] ="Su turno fue ". $estado . 
					". En breve nos estaremos comunicando al número de telefono ingresado.";
				$arrNotification["title"] = "Estado de su Solicitud";
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