<?php
session_start();
include "../../config.php";
include "../functions.php";

//*****************************************************
$xidturno = $_SESSION['idturno'];

$_SESSION['estadomenu'] = 0;

$xfechacierre = date("Y-m-d H:i:s");

$consulta="update ingresosturno set
	estadoturno = 0,
	fechacierre = '$xfechacierre'
	where idturno = '$xidturno'";
	if($mysqli->query($consulta)){}

$consultapro="update producto set
	inicialturno = 0,
	vendidoturno = 0,
	compradoturno = 0
	";
	if($mysqli->query($consultapro)){}
	
/*
$consultaalquiler = "update alquiler set
	estadoturno = 0
	where idturno = '$idturno'";
	if($mysqli->query($consultaalquiler)){}


$consultaventa = "update venta set
	estadoturno = 0
	where idturno = '$idturno'";
	if($mysqli->query($consultaventa)){}
	
$consultagasto = "update gasto set
	estadoturno = 0
	where idturno = '$idturno'";
	if($mysqli->query($consultagasto)){}

*/
	
$mysqli->close();
$_SESSION['msgerror'] = $Men;
header("Location: ../../salir.php"); exit;
//************************************************************
?>