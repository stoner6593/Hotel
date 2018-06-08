<?php
session_start();
include "../../config.php";
include "../functions.php";
date_default_timezone_set('America/Lima');

//--------------------------------------------------------------
$TblMax = $mysqli->query("select max(idgasto) from gasto");
$Contador = $TblMax->fetch_row();
$xidprimario = $Contador['0'] + 1 ;

//Identificacion
$txtidproducto = $_POST['txtproducto'];

$txtproductoopcion = $_POST['txtproductoopcion'];
if($txtproductoopcion==1){
	//Compras
	$sqlprod = $mysqli->query("select idproducto, nombre from producto where idproducto = '$txtidproducto'");
	$pFila = $sqlprod->fetch_row();
	$txtnombre = $pFila['1'];
	$xtipoperacion = 1;
}else{
	//Gastos
	$txtnombre = mayuscula($_POST['txtservicio']);
	$xtipoperacion = 2;
}

$txtcantidad = $_POST['txtcantidad'];
$txtmonto = str_replace(',','',$_POST['txtmonto']);
$txtdescripcion = mayuscula($_POST['txtdescripcion']);
$txtfechayhora = date('Y-m-d H:i:s');

$xestadoturno = 1;
$xusuario = $_SESSION['xyzidusuario'];
//*****************************************************

$xidturno = $_SESSION['idturno'];

$consulta = "insert gasto (
	idgasto,
	idproducto,
	nombre,
	cantidad,
	monto,
	descripcion,
	fechayhora,
	estadoturno,
	usuario,
	tipooperacion,
	idturno
		
) values (

	'$xidprimario',
	'$txtidproducto',
	'$txtnombre',
	'$txtcantidad',
	'$txtmonto',
	'$txtdescripcion',
	'$txtfechayhora',
	'$xestadoturno',
	'$xusuario',
	'$xtipoperacion',
	'$xidturno'	
	)";
	
if($mysqli->query($consulta)){
	$Men = "Los datos fueron guardados satisfactoriamente.";
	//Actualizar Stock de Producto
	
	if($txtproductoopcion==1){
		$consultaprod="update producto set
		cantidad = cantidad + '$txtcantidad',
		compradoturno = compradoturno + '$txtcantidad'
		where idproducto = '$txtidproducto'";
		if($mysqli->query($consultaprod)){}
	}
	
}else{
	$Men = "Ha fallado, los datos no han sido registrados.";
}

$mysqli->close();	
$_SESSION['msgerror'] = $Men;
header("Location: ../../compra-gastos.php"); exit;
//--------------------------------------------------------------
?>