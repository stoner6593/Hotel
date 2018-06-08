<?php
session_start();
include "../../config.php";
include "../functions.php";

//--------------------------------------------------------------
$TblMax = $mysqli->query("select max(idproducto) from producto");
$Contador = $TblMax->fetch_row();
$xidprimario = $Contador['0'] + 1 ;

$txtcodigo = mayuscula($_POST['txtcodigo']);
$txtnombre = mayuscula($_POST['txtnombre']);
$txtcantidad = $_POST['txtcantidad'];
$txtcantidadminima = $_POST['txtcantidadminima'];
$txtprecio = $_POST['txtprecio'];
$txtprecioventa = $_POST['txtprecioventa'];
$txtdescripcion = mayuscula($_POST['txtdescripcion']);
$xestado = 1;





//*****************************************************

$consulta="insert producto (
	
	idproducto,
	codigo,
	nombre,
	cantidad,
	cantidadminima,
	precio,
	precioventa,
	descripcion,
	estado
		
) values (

	'$xidprimario',
	'$txtcodigo',
	'$txtnombre',
	'$txtcantidad',
	'$txtcantidadminima',
	'$txtprecio',
	'$txtprecioventa',
	'$txtdescripcion',
	'$xestado'
		
	)";
	
if($mysqli->query($consulta)){
	$Men = "Los datos fueron guardados satisfactoriamente.";
}else{
	$Men = "Ha fallado, los datos no han sido registrados.";
}

$mysqli->close();	
$_SESSION['msgerror'] = $Men;
header("Location: ../../productos.php"); exit;
//--------------------------------------------------------------
?>