<?php
session_start();
include "../../config.php";
include "../functions.php";
date_default_timezone_set('America/Lima');

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

$xtxttipoalquiler = $_GET['idtipo'];
$xidalquiler = $_GET['idalquiler'];
$xidhabitacion = $_GET['idhabitacion'];

//--------------------------------------------------------------
$TblMax = $mysqli->query("select max(idalquilerdetalle) from alquilerhabitacion_detalle");
$Contador = $TblMax->fetch_row();
$xidprimario = $Contador['0'] + 1 ;



//1. ALQUILER POR HORAS *********************************************************************************
if($xtxttipoalquiler == 1){
	$xcostohoras = $_POST['txtprecioporhora'];
	$xnrohoras = 6;
	
	//FECHA SACAR DE ULTIMA FECHA
	$sqlconsulta = $mysqli->query("select idalquiler, fechafin from alquilerhabitacion where idalquiler = '$xidalquiler'");
	$aFila = $sqlconsulta->fetch_row();
	$xfechadesde = $aFila['1'];
	
	$xfechahasta = sumarhoraafecha(6,$xfechadesde); //Fecha hasta adicionando 6 horas
	$xtotal = $xcostohoras;
	
	
	$consultadet = "insert alquilerhabitacion_detalle (
		idalquilerdetalle,
		idalquiler,
		tipoalquiler,
		fechadesde,
		fechahasta,
		nrohoras,
		costohora,
		preciounitario,
		cantidad,
		total
		
		)values(
		
		'$xidprimario',
		'$xidalquiler',
		'$xtxttipoalquiler',
		'$xfechadesde',
		'$xfechahasta',
		'$xnrohoras',
		'$xcostohoras',
		'$xcostohoras',
		'$xnrohoras',
		'$xtotal' 	
		)";
		
		if($mysqli->query($consultadet)){
			//$Men = "Grabado";
			
			// Actualizar Fecha Fin 		
			$consultaact="update alquilerhabitacion set
			fechafin = '$xfechahasta'
			where idalquiler = '$xidalquiler'";
			if($mysqli->query($consultaact)){}
			
			//echo "Hola";
		}

		$mysqli->close();	
		//$_SESSION['msgerror'] = $Men; 
		header("Location: ../../alquilar-detalle.php?idhabitacion=$xidhabitacion&idalquiler=$xidalquiler"); 
		exit; 
}

//2. ALQUILER POR DIA  *********************************************************************************
if($xtxttipoalquiler == 2){
	$txtcostodiario = $_POST['txtpreciopordia'];
	$txtnrodias = $_POST['txtnrodias'];
	//Si viene vacio
	if($txtnrodias == 0){
	$_SESSION['msgerror'] = 'Seleccione el número de días.';
	echo "<script type=\"text/javascript\">
           history.go(-1);
       </script>";
	exit;
	}
	
	//FECHA SACAR DE ULTIMA FECHA
	$sqlconsulta = $mysqli->query("select idalquiler, fechafin from alquilerhabitacion where idalquiler = '$xidalquiler'");
	$aFila = $sqlconsulta->fetch_row();
	$xfechadesde = $aFila['1'];
	$xfechahasta = date("Y-m-d", strtotime("$xfechadesde + $txtnrodias day"));
	
	
	$xfechahasta = $xfechahasta.' '.'12:00:00'; //Fecha hasta 
	
	$xtotal = $txtcostodiario * $txtnrodias;
	
	$consulta="insert alquilerhabitacion_detalle (
		idalquilerdetalle,
		idalquiler,
		
		tipoalquiler,
		fechadesde,
		fechahasta,
		nrodias,
		costodia,
		preciounitario,
		cantidad,
		total
		
		)values(
		
		'$xidprimario',
		'$xidalquiler',
		
		'$xtxttipoalquiler',
		'$xfechadesde',
		'$xfechahasta',
		'$txtnrodias',
		'$txtcostodiario',
		'$txtcostodiario',
		'$txtnrodias',
		'$xtotal'
		
		)";
		if($mysqli->query($consulta)){
			$Men = "Grabado";
			// Actualizar Fecha Fin 		
			$consultaact="update alquilerhabitacion set
			fechafin = '$xfechahasta'
			where idalquiler = '$xidalquiler'";
			if($mysqli->query($consultaact)){}
		}
		$mysqli->close();	
		$_SESSION['msgerror'] = $Men;
		header("Location: ../../alquilar-detalle.php?idhabitacion=$xidhabitacion&idalquiler=$xidalquiler");
		exit;
}





//4. HUESPED ADICIONAL
if($xtxttipoalquiler == 4){
	$txtprecioadicionalhora = $_POST['txtprecioocupanteadicional'];
	$txtocupantesadicionaleshoras = $_POST['txtnrocupanteadicional'];
	$xtotal = $txtprecioadicionalhora * $txtocupantesadicionaleshoras;
	
	//Si viene vacio
	if($txtocupantesadicionaleshoras == 0){
	$_SESSION['msgerror'] = 'Seleccione el número de Huéspedes adicionales.';
	echo "<script type=\"text/javascript\">
           history.go(-1);
       </script>";
	exit;
	}
	
	
	$consulta="insert alquilerhabitacion_detalle (
		idalquilerdetalle,
		idalquiler,
		
		tipoalquiler,
		huespedadicional,
		costohuespedadicional,
		preciounitario,
		cantidad,
		total
		
		)values(
		
		'$xidprimario',
		'$xidalquiler',
		
		'$xtxttipoalquiler',
		'$txtocupantesadicionaleshoras',
		'$txtprecioadicionalhora',
		'$txtprecioadicionalhora',
		'$txtocupantesadicionaleshoras',
		'$xtotal'
		
		)";
		if($mysqli->query($consulta)){
			$Men = "Grabado"	;
		}
		$mysqli->close();	
		$_SESSION['msgerror'] = $Men;
		header("Location: ../../alquilar-detalle.php?idhabitacion=$xidhabitacion&idalquiler=$xidalquiler");
		exit; 
	
}

//3. HORA ADICIONAL
if ($xtxttipoalquiler == 3){
	
	$costohoraadicional = $_POST['txtpreciohoraadicional'];
	$nrohoraadicional = $_POST['txtnrohoraadicional'];
	$xtotal = $costohoraadicional * $nrohoraadicional;
	
	//Si viene vacio
	if($nrohoraadicional == 0){
	$_SESSION['msgerror'] = 'Seleccione el número de horas adicionales.';
	echo "<script type=\"text/javascript\">
           history.go(-1);
       </script>";
	exit;
	}
	
	//FECHA SACAR DE ULTIMA FECHA
	$sqlconsulta = $mysqli->query("select idalquiler, fechafin from alquilerhabitacion where idalquiler = '$xidalquiler'");
	$aFila = $sqlconsulta->fetch_row();
	$xfechadesde = $aFila['1'];
	$xfechahasta = sumarhoraafecha($nrohoraadicional,$xfechadesde);
	
	
	
	$consulta="insert alquilerhabitacion_detalle(
		idalquilerdetalle,
		idalquiler,
		
		fechadesde,
		fechahasta,
		
		tipoalquiler,
		horaadicional,
		costohoraadicional,
		preciounitario,
		cantidad,
		total
		
		)values(
		
		'$xidprimario',
		'$xidalquiler',
		
		'$xfechadesde',
		'$xfechahasta',
		
		'$xtxttipoalquiler',
		'$nrohoraadicional',
		'$costohoraadicional',
		'$costohoraadicional',
		'$nrohoraadicional',
		'$xtotal'
		
		)";
		if($mysqli->query($consulta)){
			$Men = "Grabado";
			// Actualizar Fecha Fin 		
			$consultaact="update alquilerhabitacion set
			fechafin = '$xfechahasta'
			where idalquiler = '$xidalquiler'";
			if($mysqli->query($consultaact)){}
		}
		$mysqli->close();	
		$_SESSION['msgerror'] = $Men;
		header("Location: ../../alquilar-detalle.php?idhabitacion=$xidhabitacion&idalquiler=$xidalquiler");
		exit; 
}

?>