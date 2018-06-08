<?php
session_start();
include "../../config.php";
include "../functions.php";

//--------------------------------------------------------------
$TblMax = $mysqli->query("select max(idhuesped) from huesped");
$Contador = $TblMax->fetch_row();
$xidprimario = $Contador['0'] + 1 ;

$xtxtnombre = mayuscula($_POST['txtnombre']);
$xtxtnacimiento = Cfecha($_POST['txtnacimiento']);
$xtxtdocumento = $_POST['txtdocumento'];
$xtxtestadocivil = $_POST['txtestadocivil'];
$xtxtciudad = mayuscula($_POST['txtciudad']);
$xtxtpais = mayuscula($_POST['txtpais']);
$xtxtprocedencia = mayuscula($_POST['txtprocedencia']);
$xtxtdestino = mayuscula($_POST['txtdestino']);
$xtxtcomentarios = mayuscula($_POST['txtcomentarios']);
$xestado = 1;
$tipo_documento=$_POST['tipo_documento'];

$sqlbusqueda = $mysqli->query("select idhuesped, documento from huesped where documento = '$xtxtdocumento'");
$num = $sqlbusqueda->num_rows;
if($num > 0){
	$_SESSION['msgerror'] = "Hay un huesped con el mismo número de documento.";
	 echo "<script type=\"text/javascript\">
           history.go(-1);
       	   </script>";
	exit;	
}
if($xtxtdocumento==""){
	$_SESSION['msgerror'] = "Documento no válido, debe ingresar el número de DNI, CE o Pasaporte.";
	 echo "<script type=\"text/javascript\">
           history.go(-1);
       	   </script>";
	exit;	
}
//*****************************************************

$consulta="insert huesped (
	
	idhuesped,
	nombre,
	nacimiento,
	documento,
	idestadocivil,
	ciudad,
	pais,
	procedencia,
	destino,
	comentarios,
	estado,
	tipo_documento
		
) values (

	'$xidprimario',
	'$xtxtnombre',
	'$xtxtnacimiento',
	'$xtxtdocumento',
	'$xtxtestadocivil',
	'$xtxtciudad',
	'$xtxtpais',
	'$xtxtprocedencia',
	'$xtxtdestino',
	'$xtxtcomentarios',
	'$xestado',
	'$tipo_documento'
		
	)";
	//echo $consulta;
if($mysqli->query($consulta)){
	$Men = "Los datos fueron guardados satisfactoriamente.";
}else{
	$Men = "Ha fallado, los datos no han sido registrados.";
}
//echo("Error description: " . mysqli_error());
$mysqli->close();	
$_SESSION['msgerror'] = $Men;

$xdesdealquiler = $_POST['txtdesdealquiler'];
$idhabitacion = $_POST['idhabitacion'];
$nrohabitacion = $_POST['nrohabitacion'];
$xestado = $_POST['xestado'];
$idtipohab = $_POST['idtipohab'];


if($xdesdealquiler==1){
	$_SESSION['msgerror'] == "";
	header("Location: ../../alquilar.php?idhabitacion=$idhabitacion&nrohabitacion=$nrohabitacion&xestado=$xestado&idtipohab=$idtipohab&desdeactualizando=si"); exit;
}else{
	header("Location: ../../huespedes.php"); exit;
}
//--------------------------------------------------------------
?>