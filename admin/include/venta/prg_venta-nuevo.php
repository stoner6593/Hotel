<?php
session_start();
include "../../config.php";
include "../functions.php";
date_default_timezone_set('America/Lima');

//Generar ID
$TblMax = $mysqli->query("select max(idventa) from venta");
$Contador = $TblMax->fetch_row();
$xidprimario = $Contador['0'] + 1 ;

//Generar Numero
$TblMax = $mysqli->query("select max(numero) from venta");
$cont = $TblMax->fetch_row();
$txtnumero = $cont['0'];

if($txtnumero == 0){
	$txtnumero = 1000 + 1;
}else{
	$txtnumero = $txtnumero + 1;
}

$txtidalquiler = $_POST['txtidalquiler'];
$txtidhabitacion = $_POST['txtidhabitacion'];


$txtcliente = $_POST['txtcliente'];
$txtfecha = Cfecha($_POST['txtfecha']);
$xhora = date('H:i:s');
$txttotal = str_replace(',','',$_POST['txttotal']);

$tipooperacion = $_POST['tipooperacion']; //(1:venta/0:cortesia)
$txtformadepago = $_POST['txtformadepago']; //(1:efectivo/2:visa)

$estado = 1; // (1:pagado/0:anulado)
$estadoturno = 1; // (1:abierto/0:cerrado)
$idusuario = $_SESSION['xyzidusuario'];

$xidcliente = $_POST['txtidcliente'];

$xidturno = $_SESSION['idturno'];

$consulta="insert venta (
	
	idventa,
	numero,
	cliente,
	fecha,
	hora,
	total,
	operacion,
	formapago,
	estado,
	estadoturno,
	idusuario,
	idcliente,
	idturno,
	idalquiler
		
	) values (

	'$xidprimario',
	'$txtnumero',
	'$txtcliente',
	'$txtfecha',
	'$xhora',
	'$txttotal',
	'$tipooperacion',
	'$txtformadepago',
	'$estado',
	'$estadoturno',
	'$idusuario',
	'$xidcliente',
	'$xidturno',
	'$txtidalquiler'
			
	)";
	
if($mysqli->query($consulta)){
	$Men = "Los datos fueron guardados satisfactoriamente.";
	//Guardar Detalle Venta
	$sqltmp = $mysqli->query("select id, idproducto, nombre, cantidad, precio, importe from ventas_tmp order by id asc");
	
	while($tmpFila = $sqltmp->fetch_row()){
		//Generar ID Venta Detalle
		$TblMaxDetalle = $mysqli->query("select max(idventadetalle) from ventadetalle");
		$ContaD = $TblMaxDetalle->fetch_row();
		$xidventadetalle = $ContaD['0'] + 1 ;

		$xidproducto = $tmpFila['1'];
		$xnombre = $tmpFila['2'];
		$xcantidad = $tmpFila['3'];
		$xprecio = $tmpFila['4'];
		$ximporte = $tmpFila['5'];
		
		$consultatmp = "insert ventadetalle (
			idventadetalle,
			idventa,
			idproducto,
			nombre,
			cantidad,
			precio,
			importe
			
			) values (
			
			'$xidventadetalle',
			'$xidprimario',
			'$xidproducto',
			'$xnombre',
			'$xcantidad',
			'$xprecio',
			'$ximporte'
			)";
		if($mysqli->query($consultatmp)){
			//Descontar Stock de Producto
			$sqlrestarcantidad = "update producto set
				cantidad = 	cantidad - '$xcantidad',
				vendidoturno = vendidoturno + $xcantidad		
				where idproducto = '$xidproducto'";
			if($mysqli->query($sqlrestarcantidad)){}
		}
	}
	//Eliminando Temporales
	$sSQL="delete from ventas_tmp";
	if($mysqli->query($sSQL)){}
	
	//Actualizar Turno
	if($txtformadepago == 1){
		$importeefectivo = $txttotal;
	}else{
		$importevisa = $txttotal;
	}
	$xtotalturno =  $importeefectivo + $importevisa;
	
	
	$xidturno = $_SESSION['idturno'];
	$xtotalturno = $importevisa + $importeefectivo;
	$consultaturno = "update ingresosturno set
		totalproducto = totalproducto + '$txttotal',
		totalefectivo = totalefectivo + '$importeefectivo',	
		totalvisa = totalvisa + '$importevisa'
		
		where idturno = '$xidturno'";
	if($mysqli->query($consultaturno)){}
	
	
}else{
	$Men = "Ha fallado, los datos no han sido registrados.";
}

$mysqli->close();	
$_SESSION['msgerror'] = $Men;


header("Location: ../../venta-completada.php?xidventa=$xidprimario&guardado=1&idalquiler=$txtidalquiler&idhabitacion=$txtidhabitacion"); exit;

//--------------------------------------------------------------
?>