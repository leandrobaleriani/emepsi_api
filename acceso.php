<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'Database.php';

header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

$link = mysqli_init();
$db = mysqli_real_connect($link, HOSTNAME, USERNAME, PASSWORD, DATABASE) or die(mysqli_connect_error());

$json = file_get_contents('php://input');

$params = json_decode($json);
  
$SQL = "SELECT * FROM usu_usuarios WHERE usu_nombre = '".$params->usu_nombre."' AND usu_pass = '".$params->usu_pass."'";
$rec = mysqli_query($link, $SQL) or die(mysqli_error($link));
$count = 0; 
while($row = mysqli_fetch_array($rec)) 
{ 
	$count++; 
	$result = $row;
} 
if($count == 1) 
{ 
	echo "1"; 
} 
else 
{ 
	echo "0"; 
} 
?>