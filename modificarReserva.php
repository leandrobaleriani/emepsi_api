<?php
/**
 * Insertar un nuevo plato en la base de datos
 */
 ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'Database.php';
require 'Plato.php';
require 'datosFTP.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	$categoria = $_POST['selectCategoria'];
	$titulo = $_POST['inputTitulo'];
	$precio = $_POST['inputPrecio'];
	$idPlato = $_POST['idPlato'];
    // Insertar plato
    $retorno = Plato::update(
        $idPlato,
		$titulo,
        $categoria,
        $precio);

    if ($retorno) {
        // Código de éxito
        print json_encode(
            array(
                'estado' => '1',
                'mensaje' => 'Creación exitosa')
        );
    } else {
        // Código de falla
        print json_encode(
            array(
                'estado' => '2',
                'mensaje' => 'Creación fallida')
        );
    }
}