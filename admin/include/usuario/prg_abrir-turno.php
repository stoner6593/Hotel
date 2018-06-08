<?php
session_start();
include "../../config.php";
include "../functions.php";

//*****************************************************
$TblMax = $mysqli->query("select max(idturno) from ingresosturno");
$Contador = $TblMax->fetch_row();

$xidturno = $Contador['0'] + 1 ;
$xidusuario = $_GET['idusuario'];
$xturno = $_POST['txtturno'];

$xfechaapertura = date('Y-m-d- H:i:s');
$xestadoturno = 1;

$consulta = "insert ingresosturno(
	idturno,
	idusuario,
	fechaapertura,
	estadoturno,
	turno

	) values (
	'$xidturno',
	'$xidusuario',
	'$xfechaapertura',
	'$xestadoturno',
	'$xturno'
	
	)";
	
	if($mysqli->query($consulta)){
			$_SESSION['estadomenu'] = 1;
			$_SESSION['idturno'] = $xidturno;
			
			//Actualizar Saldos en productos
			$consultapro="update producto set
				inicialturno = cantidad,
				vendidoturno = 0,
				compradoturno = 0
				";
			if($mysqli->query($consultapro)){}		
			//$Men = "Los datos fueron guardados satisfactoriamente.";
	}else{
			//$Men = "Ha fallado, los datos no han sido registrados.";
	}
	
$TblMax->free();	
$mysqli->close();
$_SESSION['msgerror'] = $Men;
header("Location: ../../control-habitaciones.php"); exit;
//************************************************************
?>