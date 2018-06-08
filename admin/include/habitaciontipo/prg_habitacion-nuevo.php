<?php
session_start();
include "../../config.php";
include "../functions.php";

//--------------------------------------------------------------
$TblMax = $mysqli->query("select max(idhabitacion) from habitacion");
$Contador = $TblMax->fetch_row();
$xidprimario = $Contador['0'] + 1 ;

$xtxtpiso = $_POST['txtpiso'];
$xtxtnumero = $_POST['txtnumero'];
$xtxttipo = $_POST['txttipo'];
$xtxtestado = 1; //$_POST['txtestado'];
$xtxtpreciodiario = $_POST['txtpreciodiario'];
$xtxtpreciohoras = $_POST['txtpreciohoras'];

$xtxtnrohuespedes = $_POST['txtnrohuespedes'];
$xtxtnroadicional = $_POST['txtnroadicional'];

$xtxtcaracteristicas = mayuscula($_POST['txtcaracteristicas']);

$txtubicacion = $_POST['txtubicacion'];

$txtpreciodiariodj = str_replace(',','',$_POST['txtpreciodiariodj']);
$txtpreciohorasdj = str_replace(',','',$_POST['txtpreciohorasdj']);
$txtpreciodiariovs = str_replace(',','',$_POST['txtpreciodiariovs']);
$txtpreciohorasvs = str_replace(',','',$_POST['txtpreciohorasvs']);

$txtpreciohoraadicional = str_replace(',','',$_POST['txtpreciohoraadicional']);
$txtpreciopersonaadicional = str_replace(',','',$_POST['txtpreciopersonaadicional']);


//Verificar Numero *******************************************
$sqlnumero = $mysqli->query("select idhabitacion, numero from habitacion where numero = '$xtxtnumero'");
$num = $sqlnumero->num_rows;
if($num != 0){
	$_SESSION['msgerror'] = 'El número de habitación ya existe.';
	echo "<script type=\"text/javascript\">
           history.go(-1);
       </script>";
	exit;
}
//****

$consulta="insert habitacion (
	
	idhabitacion,
	piso,
	numero,
	idtipo,
	
	nrohuespedes,
	nroadicional,
	caracteristicas,
	idestado,
	ubicacion,
	
	preciodiariodj,
	preciohorasdj,
	preciodiariovs,
	preciohorasvs,
	
	costopersonaadicional,
	costohoraadicional
			
) values (

	'$xidprimario',
	'$xtxtpiso',
	'$xtxtnumero',
	'$xtxttipo',

	'$xtxtnrohuespedes',
	'$xtxtnroadicional',
	'$xtxtcaracteristicas',
	'$xtxtestado',
	'$txtubicacion',
	
	'$txtpreciodiariodj',
	'$txtpreciohorasdj',
	'$txtpreciodiariovs',
	'$txtpreciohorasvs',
	
	'$txtpreciohoraadicional',
	'$txtpreciopersonaadicional'
	
	)";
	
if($mysqli->query($consulta)){
	$Men = "Los datos fueron guardados satisfactoriamente.";
}else{
	$Men = "Ha fallado, los datos no han sido registrados.";
}

$mysqli->close();	
$_SESSION['msgerror'] = $Men;
header("Location: ../../habitaciones.php"); exit;
//--------------------------------------------------------------
?>