<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
 * Insertar un nuevo menu en la base de datos
 */
require 'Database.php';
require 'Turno.php';
	
header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

	$id = $_GET['id'];
	$estado = $_GET['estado'];
	
	$retorno = Turno::updateEstado($id,$estado);
	
	if($retorno){
			// Código de éxito
			echo "1";
		} else{
			// Código de falla
			echo "2";
		}