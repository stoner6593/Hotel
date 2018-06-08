<?php
session_start();
include "../../config.php";
include "../functions.php";

//--------------------------------------------------------------
$TblMax = $mysqli->query("select max(idtipo) from habitaciontipo");
$Contador = $TblMax->fetch_row();
$xidprimario = $Contador['0'] + 1 ;

$txtnombre = $_POST['txtnombre'];
$txtpreciodiariouno = $_POST['txtpreciodiariouno'];
$txtpreciohorauno = $_POST['txtpreciohorauno'];
$txtpreciohoraadicionaluno = $_POST['txtpreciohoraadicionaluno'];
$txtpreciohuespedadicionaluno = $_POST['txtpreciohuespedadicionaluno'];

$txtpreciodiariodos = $_POST['txtpreciodiariodos'];
$txtpreciohorados = $_POST['txtpreciohorados'];
$txtpreciohoraadicionaldos = $_POST['txtpreciohoraadicionaldos'];
$txtpreciohuespedadicionaldos = $_POST['txtpreciohuespedadicionaldos'];




//*****************************************************

$consulta="insert habitaciontipo (
	
	idtipo,
	nombre,
	
	preciodiariouno,
	preciohorauno,
	preciohoraadicionaluno,
	preciohuespedadicionaluno,
	
	preciodiariodos,
	preciohorados,
	preciohoraadicionaldos,
	preciohuespedadicionaldos

		
) values (

	'$xidprimario',
	'$txtnombre',
	
	'$txtpreciodiariouno',
	'$txtpreciohorauno',
	'$txtpreciohoraadicionaluno',
	'$txtpreciohuespedadicionaluno',
	
	'$txtpreciodiariodos',
	'$txtpreciohorados',
	'$txtpreciohoraadicionaldos',
	'$txtpreciohuespedadicionaldos'
		
	)";
	
if($mysqli->query($consulta)){
	$Men = "Los datos fueron guardados satisfactoriamente.";
}else{
	$Men = "Ha fallado, los datos no han sido registrados.";
}

$mysqli->close();	
$_SESSION['msgerror'] = $Men;
header("Location: ../../habitaciones-tipo.php"); exit;
//--------------------------------------------------------------
?>