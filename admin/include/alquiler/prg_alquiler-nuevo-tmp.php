<?php
session_start();
include "../../config.php";
include "../functions.php";
date_default_timezone_set('America/Lima');




//--------------------------------------------------------------
$TblMax = $mysqli->query("select max(idtmp) from alquilerhabitacion_detalle_tmp");
$Contador = $TblMax->fetch_row();
$xidprimario = $Contador['0'] + 1 ;

//Generar Numero
/*$TblMaxo = $mysqli->query("select max(nroorden) from alquilerhabitacion");
$cont = $TblMaxo->fetch_row();
$txtnumero = $cont['0']; */

$xtxthuesped = $_POST['txtidcliente'];
$xtxtcliente = $_POST['txtcliente'];

$xtxtidhabitacion = $_POST['txtidhabitacion'];
$xtxthrohabitacion = $_POST['txtnrohabitacion'];
$xtipohabitacion = $_POST['txtidtipohabitacion'];

$xtxttipoalquiler = $_GET['idtipo'];

$txttipooperacion = $_GET['txttipooperacion']; //1. Venta - 2. Cortesia

$_SESSION['xidcliente'] = $_POST['txtidcliente'];
$_SESSION['xcliente'] = $_POST['txtcliente'];

//1. ALQUILER POR HORAS *********************************************************************************
if($xtxttipoalquiler == 1){
	$xcostohoras = $_POST['txtcostohoras'];
	$xnrohoras = 6;
	$xfechadesde = date('Y-m-d H:i:s'); //fecha de Hoy
	$xfechahasta = sumarhoraafecha(6,$xfechadesde); //Fecha hasta adicionando 6 horas
	
	$xtotal = $xcostohoras;
	
	$txtcortesiahoras = $_POST['txtcortesiahoras']; //Si es cortesia el Alquiler
	if($txtcortesiahoras == 1){
		$xtotal = 0;
	}
	
	
	$consulta="insert alquilerhabitacion_detalle_tmp(
		idtmp,
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
		'$xtxttipoalquiler',
		'$xfechadesde',
		'$xfechahasta',
		'$xnrohoras',
		'$xcostohoras',
		'$xcostohoras',
		'$xnrohoras',
		'$xtotal'
		
		)";
		if($mysqli->query($consulta)){
			$Men = "Grabado"	;
		}
		$mysqli->close();	
		$_SESSION['msgerror'] = $Men;
		header("Location: ../../alquilar.php?idhabitacion=$xtxtidhabitacion&nrohabitacion=$xtxthrohabitacion&idtipohab=$xtipohabitacion&desdeactualizando=si"); 
		exit; 
}

//2. ALQUILER POR DIA  *********************************************************************************
if($xtxttipoalquiler == 2){
	$txtcostodiario = $_POST['txtcostodiario'];
	$txtfechadesde = $_POST['txtfechadesde'];
	$txtfechahasta = $_POST['txtfechahasta'];
	$txtnrodias = $_POST['txtnrodias'];
	
	$xfechadesde = Cfecha($txtfechadesde).' '.'12:00:00'; //fecha de Hoy
	
	$xfechahasta = Cfecha($_POST['txtfechahasta']).' '.'12:00:00'; //Fecha hasta 
	//$xtotal = $txtcostodiario * $txtnrodias;
	
	//Obtener Precios
	$sqlhabitacionprecio = $mysqli->query("select
		idhabitacion,
		piso,
		numero,
		idtipo,
		
		preciodiariodj,
		preciohorasdj,
		preciodiariovs,	
		preciohorasvs,
		
		nrohuespedes,
		nroadicional,	
		
		costopersonaadicional,
		costohoraadicional,
		
		caracteristicas,
		idestado,
		idalquiler,
		ubicacion
		from habitacion where idhabitacion = $xtxtidhabitacion");
		$haFila = $sqlhabitacionprecio->fetch_row();
	
	//Calcular si Es fin de semana o Entresemana//
	$fecha = $xfechadesde;
	$tarifauno = 0;
	$tarifados = 0;
	
	for ($i = 1; $i <= $txtnrodias; $i++) {
    	
		$dia = date('w', strtotime($fecha));
		$hora = date('H:i',strtotime($fecha));
		$horamedia = date('H:i', strtotime('08:00'));
		
		//Uso de Switch Case
		switch ($dia) {
		case 0:
			if($i == 1){
				if($hora > $horamedia){
					//echo "Tarifa 2 - Viernes";
					$xpreciodiario = $haFila['6'];
				 	$xtotal = $xtotal + $xpreciodiario;
				}else{
					//echo "Tarifa 1 :: Domingo - Jueves ";
					$xpreciodiario = $haFila['4'];
					$xtotal = $xtotal + $xpreciodiario;
				}
			}else{
				//echo "Tarifa 2 - Viernes";
				$xpreciodiario = $haFila['6'];
				$xtotal = $xtotal + $xpreciodiario;
			}
			break;
		case 1:
		case 2:
		case 3:
		case 4:
			//echo "Tarifa 1 :: Domingo - Jueves ";
			$xpreciodiario = $haFila['4'];
			$xtotal = $xtotal + $xpreciodiario;
			break;
		case 5:
			//echo $fecha.'/'.$dia.'/'.$hora.'/'.$horamedia;
			if($i == 1){
				if($hora > $horamedia){
					//echo "Tarifa 1 :: Domingo - Jueves ";
					$xpreciodiario = $haFila['6'];
					$xtotal = $xtotal + $xpreciodiario;
				}else{
					//echo "Tarifa 2 - Viernes";
					$xpreciodiario = $haFila['4'];
					$xtotal = $xtotal + $xpreciodiario;
				}
			}else{
				//echo "Tarifa 2 - Viernes";
				$xpreciodiario = $haFila['6'];
				$xtotal = $xtotal + $xpreciodiario;
			}
			break;
		case 6:
			//echo "Tarifa 2 - Viernes";
			$xpreciodiario = $haFila['6'];
			$xtotal = $xtotal + $xpreciodiario;
			break;
		}
		/*
		echo "Total: ".$xtotal."<br>";
		echo "Dia: ".$dia."<br>";
		echo "Fecha: ".$fecha."<br>";
		*/
		$fecha = date("Y-m-d H:i:s", strtotime("$fecha + 1 day")); //Aumente en un dia
	} // Fin de For
	
	//$comentarios = 'T1: '.$tarifauno.' - T2: '.$tarifados;
	
	
	
	$txtcortesiadias = $_POST['txtcortesiadias']; //Si es cortesia el Alquiler
	if($txtcortesiadias == 1){
		$xtotal = 0;
	}
	
	$consulta="insert alquilerhabitacion_detalle_tmp (
		idtmp,
		tipoalquiler,
		fechadesde,
		fechahasta,
		nrodias,
		costodia,
		preciounitario,
		cantidad,
		total,
		comentarios
		
		)values(
		
		'$xidprimario',
		'$xtxttipoalquiler',
		'$xfechadesde',
		'$xfechahasta',
		'$txtnrodias',
		'$txtcostodiario',
		'$txtcostodiario',
		'$txtnrodias',
		'$xtotal',
		'$comentarios'
		
		)";
		if($mysqli->query($consulta)){
			$Men = "Grabado"	;
		}
		$mysqli->close();	
		$_SESSION['msgerror'] = $Men;
		header("Location: ../../alquilar.php?idhabitacion=$xtxtidhabitacion&nrohabitacion=$xtxthrohabitacion&idtipohab=$xtipohabitacion&desdeactualizando=si"); 
		exit; 
	
}


//3. HORA ADICIONAL


//4. HUESPED ADICIONAL
if($xtxttipoalquiler == 4){
	$txtprecioadicionalhora = $_POST['txtprecioadicionalhora'];
	$txtocupantesadicionaleshoras = $_POST['txtocupantesadicionaleshoras'];
	$xtotal = $txtprecioadicionalhora * $txtocupantesadicionaleshoras;
	
	$consulta="insert alquilerhabitacion_detalle_tmp(
		idtmp,
		tipoalquiler,
		huespedadicional,
		costohuespedadicional,
		preciounitario,
		cantidad,
		total
		
		)values(
		
		'$xidprimario',
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
		header("Location: ../../alquilar.php?idhabitacion=$xtxtidhabitacion&nrohabitacion=$xtxthrohabitacion&idtipohab=$xtipohabitacion&desdeactualizando=si"); 
		exit; 
	
}

//5. INGRESO ANTICIPADO
if ($xtxttipoalquiler == 5){
	
	$costoingresoanticipado = $_POST['txtcostoingresoanticipado'];
	$cant = $_POST['txtnrohoras'];
	$xtotal = $costoingresoanticipado * $cant;
	
	
	$consulta="insert alquilerhabitacion_detalle_tmp(
		idtmp,
		tipoalquiler,
		costoingresoanticipado,
		preciounitario,
		cantidad,
		total
		
		)values(
		
		'$xidprimario',
		'$xtxttipoalquiler',
		'$costoingresoanticipado',
		'$costoingresoanticipado',
		'$cant',
		'$xtotal'
		
		)";
		if($mysqli->query($consulta)){
			$Men = "Grabado"	;
		}
		$mysqli->close();	
		$_SESSION['msgerror'] = $Men;
		header("Location: ../../alquilar.php?idhabitacion=$xtxtidhabitacion&nrohabitacion=$xtxthrohabitacion&idtipohab=$xtipohabitacion&desdeactualizando=si"); 
		exit; 
}

//12. ALQUILER POR 12 HORAS *********************************************************************************
/*if($xtxttipoalquiler == 6){
	$xcostohoras = $_POST['txtcostohoras12'];
	$xnrohoras = 12;
	$xfechadesde = date('Y-m-d H:i:s'); //fecha de Hoy
	$xfechahasta = sumarhoraafecha(12,$xfechadesde); //Fecha hasta adicionando 6 horas
	
	$xtotal = $xcostohoras;
	
	$txtcortesiahoras = $_POST['txtcortesiahoras']; //Si es cortesia el Alquiler
	if($txtcortesiahoras == 1){
		$xtotal = 0;
	}
	
	
	$consulta="insert alquilerhabitacion_detalle_tmp(
		idtmp,
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
		'$xtxttipoalquiler',
		'$xfechadesde',
		'$xfechahasta',
		'$xnrohoras',
		'$xcostohoras',
		'$xcostohoras',
		'$xnrohoras',
		'$xtotal'
		
		)";
		if($mysqli->query($consulta)){
			$Men = "Grabado"	;
		}
		$mysqli->close();	
		$_SESSION['msgerror'] = $Men;
		header("Location: ../../alquilar.php?idhabitacion=$xtxtidhabitacion&nrohabitacion=$xtxthrohabitacion&idtipohab=$xtipohabitacion&desdeactualizando=si"); 
		exit; 
}*/


/*PRUEBA ALQUILER 12 HORAS*/

//2. ALQUILER POR DIA  *********************************************************************************
if($xtxttipoalquiler == 6){
	$txtcostodiario = $_POST['txtcostohoras12'];
	$xnrohoras = 12;
	$txtfechadesde = date('Y-m-d H:i:s'); //fecha de Hoy
	$txtfechahasta = sumarhoraafecha(12,$txtfechadesde); //Fecha hasta adicionando 12 horas


	//$txtnrodias = $_POST['txtnrodias'];
	
	$xfechadesde = ($txtfechadesde); //fecha de Hoy
	
	$xfechahasta = $txtfechahasta; //Fecha hasta 
	//$xtotal = $txtcostodiario * $txtnrodias;
	
	//Obtener Precios
	$sqlhabitacionprecio = $mysqli->query("select
		idhabitacion,
		piso,
		numero,
		idtipo,
		
		precio12,
		preciohorasdj,
		precio12vs,	
		preciohorasvs,
		
		nrohuespedes,
		nroadicional,	
		
		costopersonaadicional,
		costohoraadicional,
		
		caracteristicas,
		idestado,
		idalquiler,
		ubicacion
		from habitacion where idhabitacion = $xtxtidhabitacion");
		$haFila = $sqlhabitacionprecio->fetch_row();
	
	//Calcular si Es fin de semana o Entresemana//
	$fecha = $xfechadesde;
	$tarifauno = 0;
	$tarifados = 0;
	
	for ($i = 1; $i <= 1; $i++) {
    	
		$dia = date('w', strtotime($fecha));
		$hora = date('H:i',strtotime($fecha));
		$horamedia = date('H:i', strtotime('08:00'));
		//echo $dia;
		//Uso de Switch Case
		switch ($dia) {
		case 0:
			if($i == 1){
				if($hora > $horamedia){
					//echo "Tarifa 2 - Viernes";
					$xpreciodiario = $haFila['6'];
				 	$xtotal = $xtotal + $xpreciodiario;
				}else{
					//echo "Tarifa 1 :: Domingo - Jueves ";
					$xpreciodiario = $haFila['4'];
					$xtotal = $xtotal + $xpreciodiario;
				}
			}else{
				//echo "Tarifa 2 - Viernes";
				$xpreciodiario = $haFila['6'];
				$xtotal = $xtotal + $xpreciodiario;
			}
			break;
		case 1:
		case 2:
		case 3:
		case 4:
			//echo "Tarifa 1 :: Domingo - Jueves ";
			$xpreciodiario = $haFila['4'];
			$xtotal = $xtotal + $xpreciodiario;
			break;
		case 5:
			//echo $fecha.'/'.$dia.'/'.$hora.'/'.$horamedia;
			if($i == 1){
				if($hora > $horamedia){
					//echo "Tarifa 1 :: Domingo - Jueves ";
					$xpreciodiario = $haFila['6'];
					$xtotal = $xtotal + $xpreciodiario;
				}else{
					//echo "Tarifa 2 - Viernes";
					$xpreciodiario = $haFila['4'];
					$xtotal = $xtotal + $xpreciodiario;
				}
			}else{
				//echo "Tarifa 2 - Viernes";
				$xpreciodiario = $haFila['6'];
				$xtotal = $xtotal + $xpreciodiario;
			}
			break;
		case 6:
			if($i == 1){
				echo $hora ."-". $horamedia;
				if($hora > $horamedia){
					//echo "Tarifa 2 - Viernes";
					$xpreciodiario = $haFila['6'];
				 	$xtotal = $xtotal + $xpreciodiario;
				}else{
					//echo "Tarifa 1 :: Domingo - Jueves ";
					$xpreciodiario = $haFila['4'];
					$xtotal = $xtotal + $xpreciodiario;
				}
			}else{
				//echo "Tarifa 2 - Viernes";
				$xpreciodiario = $haFila['6'];
				$xtotal = $xtotal + $xpreciodiario;
			}
			break;
		}
		/*
		echo "Total: ".$xtotal."<br>";
		echo "Dia: ".$dia."<br>";
		echo "Fecha: ".$fecha."<br>";
		*/
		$fecha = date("Y-m-d H:i:s", strtotime("$fecha + 1 day")); //Aumente en un dia
	} // Fin de For
	
	//$comentarios = 'T1: '.$tarifauno.' - T2: '.$tarifados;
	
	
	
	$txtcortesiadias = $_POST['txtcortesiadias']; //Si es cortesia el Alquiler
	if($txtcortesiadias == 1){
		$xtotal = 0;
	}
	
	
	$consulta="insert alquilerhabitacion_detalle_tmp (
		idtmp,
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
		'$xtxttipoalquiler',
		'$xfechadesde',
		'$xfechahasta',
		'$xnrohoras',
		'$txtcostodiario',
		'$txtcostodiario',
		'$xnrohoras',
		'$xtotal'
		
		)";
		if($mysqli->query($consulta)){
			$Men = "Grabado"	;
		}
		$mysqli->close();	
		$_SESSION['msgerror'] = $Men;
		header("Location: ../../alquilar.php?idhabitacion=$xtxtidhabitacion&nrohabitacion=$xtxthrohabitacion&idtipohab=$xtipohabitacion&desdeactualizando=si"); 
		exit; 
	
}

?>