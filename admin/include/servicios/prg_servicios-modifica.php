<?php
session_start();
include "../../config.php";
include "../functions.php";

//--------------------------------------------------------------
$xidprimario = $_POST['txtidprimario'];
$txtprecioventa = $_POST['txtprecioventa'];
$txtdescripcion = mayuscula($_POST['txtdescripcion']);
//*****************************************************

	
$consulta="update servicios set
	
	
	descripcion = '$txtdescripcion',
	costo = '$txtprecioventa'

	where idservicios = '$xidprimario'";


if($mysqli->query($consulta)){
		$Men = "Los datos fueron guardados satisfactoriamente.";
}else{
		$Men = "Ha fallado, los datos no han sido actualizados.";
}
$mysqli->close();	
$_SESSION['msgerror'] = $Men;
header("Location: ../../servicios.php"); exit;
//************************************************************
?>