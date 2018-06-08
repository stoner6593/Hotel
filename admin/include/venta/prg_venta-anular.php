<?php
session_start();
include "../../config.php";
include "../functions.php";

//--------------------------------------------------------------
$xidprimario = $_POST['txtidventa'];
$txtanotaciones = mayuscula($_POST['txtmotivo']).' / Anulado en: '.Cfecha(date('Y-m-d')).' - '.date('H:i:s');
//*****************************************************

$consulta="update venta set
	estado = 0,
	anotaciones = '$txtanotaciones'
	where idventa = '$xidprimario'";

if($mysqli->query($consulta)){
	$Men = "Los datos fueron guardados satisfactoriamente.";
	
	//Devolver Stock Producto
	$sqldetalleventa = $mysqli->query("select  idventadetalle, idventa, idproducto, cantidad from ventadetalle where idventa = '$xidprimario' order by idventadetalle asc");
	
	while($pFila = $sqldetalleventa->fetch_row()){
		$xidproducto = $pFila['2'];
		$xcantidad = $pFila['3'];
		
		$sqlrestarcantidad = "update producto set
			cantidad = 	cantidad + '$xcantidad' 			
			where idproducto = '$xidproducto'";
		if($mysqli->query($sqlrestarcantidad)){}
	}
	
}else{
	$Men = "Ha fallado, los datos no han sido actualizados.";
}

$mysqli->close();	
$_SESSION['msgerror'] = $Men;
header("Location: ../../venta-listado.php"); exit;
//************************************************************
?>