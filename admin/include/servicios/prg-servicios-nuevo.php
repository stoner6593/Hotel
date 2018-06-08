<?php
session_start();
include "../../config.php";
include "../functions.php";

//--------------------------------------------------------------
$TblMax = $mysqli->query("select max(idservicios) from servicios");
$Contador = $TblMax->fetch_row();
$xidprimario = $Contador['0'] + 1 ;
$txtprecioventa = $_POST['txtprecioventa'];
$txtdescripcion = mayuscula($_POST['txtdescripcion']);
$xestado = 1;





//*****************************************************

$consulta="insert into servicios (
	
	
	descripcion,
	costo,
	estado
		
) values (

	
	'$txtdescripcion',
	'$txtprecioventa',	
	'$xestado'
		
	)";
	
if($mysqli->query($consulta)){
	$Men = "Los datos fueron guardados satisfactoriamente.";
}else{
	$Men = "Ha fallado, los datos no han sido registrados.";
}

$mysqli->close();	
$_SESSION['msgerror'] = $Men;
header("Location: ../../servicios.php"); exit;
//

//--------------------------------------------------------------
?>