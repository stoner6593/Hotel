<?php
session_start();
include "../../config.php";
include "../functions.php";

//--------------------------------------------------------------
$xidprimario = $_POST['txtidprimario'];

$xtxtnombre = mayuscula($_POST['txtnombre']);
$xtxtnacimiento = Cfecha($_POST['txtnacimiento']);
$xtxtdocumento = $_POST['txtdocumento'];
$xtxtestadocivil = $_POST['txtestadocivil'];
$xtxtciudad = mayuscula($_POST['txtciudad']);
$xtxtpais = mayuscula($_POST['txtpais']);
$xtxtprocedencia = mayuscula($_POST['txtprocedencia']);
$xtxtdestino = mayuscula($_POST['txtdestino']);
$xtxtcomentarios = mayuscula($_POST['txtcomentarios']);
$tipo_documento=$_POST['tipo_documento'];
$txtnograta = $_POST["txtnograta"];
//*****************************************************

	
$consulta="update huesped set
	
	nombre = '$xtxtnombre',
	nacimiento = '$xtxtnacimiento',
	documento = '$xtxtdocumento',
	idestadocivil = '$xtxtestadocivil',
	ciudad = '$xtxtciudad',
	pais = '$xtxtpais',
	procedencia = '$xtxtprocedencia',
	destino = '$xtxtdestino',
	comentarios = '$xtxtcomentarios',
	nograto = '$txtnograta',
	tipo_documento='$tipo_documento'

	where idhuesped = '$xidprimario'";

if($mysqli->query($consulta)){
		$Men = "Los datos fueron guardados satisfactoriamente.";
}else{
		$Men = "Ha fallado, los datos no han sido registrados.";
}
$mysqli->close();	
$_SESSION['msgerror'] = $Men;
header("Location: ../../huespedes.php"); exit;
//************************************************************
?>