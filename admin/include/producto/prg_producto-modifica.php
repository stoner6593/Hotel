<?php
session_start();
include "../../config.php";
include "../functions.php";

//--------------------------------------------------------------
$xidprimario = $_POST['txtidprimario'];

$txtcodigo = mayuscula($_POST['txtcodigo']);
$txtnombre = mayuscula($_POST['txtnombre']);
$txtcantidad = $_POST['txtcantidad'];
$txtcantidadminima = $_POST['txtcantidadminima'];
$txtprecio = $_POST['txtprecio'];
$txtprecioventa = $_POST['txtprecioventa'];
$txtdescripcion = mayuscula($_POST['txtdescripcion']);
//*****************************************************

	
$consulta="update producto set
	
	codigo = '$txtcodigo',
	nombre = '$txtnombre',
	cantidad = '$txtcantidad',
	cantidadminima = '$txtcantidadminima',
	precio = '$txtprecio',
	precioventa = '$txtprecioventa',
	descripcion = '$txtdescripcion'

	where idproducto = '$xidprimario'";

if($mysqli->query($consulta)){
		$Men = "Los datos fueron guardados satisfactoriamente.";
}else{
		$Men = "Ha fallado, los datos no han sido actualizados.";
}
$mysqli->close();	
$_SESSION['msgerror'] = $Men;
header("Location: ../../productos.php"); exit;
//************************************************************
?>