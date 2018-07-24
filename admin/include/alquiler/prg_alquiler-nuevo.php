<?php
	session_start();
	include "../../config.php";
	include "../functions.php";
	date_default_timezone_set('America/Lima');
	
	
	$xidturno = $_SESSION['idturno'];
	$idusuario = $_SESSION['xyzidusuario'];
	
	//--------------------------------------------------------------
	$TblMax = $mysqli->query("select max(idalquiler) from alquilerhabitacion");
	$Contador = $TblMax->fetch_row();
	$xidprimario = $Contador['0'] + 1 ;
	
	//Generar Numero
	$TblMaxo = $mysqli->query("select max(nroorden) from alquilerhabitacion");
	$cont = $TblMaxo->fetch_row();
	$txtnumero = $cont['0'];
	
	if($txtnumero == 0){
		$txtnumero = 1000 + 1;
	}else{
		$txtnumero = $txtnumero + 1;
	}

	$xtxthuesped = $_POST['txtidcliente'];
	$xtxtidhabitacion = $_POST['txtidhabitacion'];
	$xtxtnrohabitacion = $_POST['txtnrohabitacion'];
	
	$xtxttipoalquiler = $_POST['txttipoalquiler'];
	$xformapago = $_POST['txtformadepago'];
	$txttipooperacion = $_POST['txttipooperacion']; //1-VENTA / 2-CORTESIA
	
	$xtotal = $_POST['txtcostototal'];
	$xtotalhabitacion = $_POST['txtcostototalhabitacion']; //
	$xtotalproducto = $_POST['txtcostototalproducto']; //

	$descuento = $_POST['descuentoglobal']; //
	if($descuento =="" || $descuento==0){
		$descuento=0;
	}else{
		$descuento=$descuento;
	}
	echo $descuento;
	
	if($xformapago == 1){
		$montoefectivo = $xtotal;
		$montovisa = 0;
		
	}else if($xformapago == 2){
		$montoefectivo = 0;
		$montovisa = $xtotal;
		
	}else if($xformapago == 3){
		$montoefectivo = $_POST['txtmontoefectivo'];
		$montovisa = $_POST['txtmontovisa'];
	}
	
	//GRABAR INFORMACION DE ALQUILER
	
	$consulta="insert alquilerhabitacion (
		idalquiler,
		idhuesped,
		idhabitacion,
		nrohabitacion,
		tipooperacion,
		totalefectivo,
		totalvisa,
		total,
		idturno,
		idusuario,
		nroorden,
		descuento
		
		) values (
		
		'$xidprimario',
		'$xtxthuesped',
		'$xtxtidhabitacion',
		'$xtxtnrohabitacion',
		'$txttipooperacion',
		'$montoefectivo',
		'$montovisa ',
		'$xtotal',
		'$xidturno',
		'$idusuario',
		'$txtnumero',
		'$descuento'
		
		)";
		
	if($mysqli->query($consulta)){
	
		//GRABAR DETALLE ALQUILER HABITACION
		$sqltmp = $mysqli->query("select
			idtmp,
			tipoalquiler,
			fechadesde,
			fechahasta,
			nrohoras,
			nrodias,
			costohora,
			costodia,
			formapago,
			totalefectivo,
			totalvisa,
			estadopago,
			costoingresoanticipado,
			horaadicional,
			costohoraadicional,
			huespedadicional,
			costohuespedadicional,
			preciounitario,
			cantidad,
			total
			
			from alquilerhabitacion_detalle_tmp order by idtmp asc ");
	
			while ($aFila = $sqltmp->fetch_row()){
				
				$TblMax = $mysqli->query("select max(idalquilerdetalle) from alquilerhabitacion_detalle");
				$Contador = $TblMax->fetch_row();
				$xidprimariodetalle = $Contador['0'] + 1 ;
				
				$tipoalquiler = $aFila['1'];
				$fechadesde = $aFila['2'];
				$fechahasta = $aFila['3'];
				$nrohoras = $aFila['4'];
				$nrodias = $aFila['5'];
				$costohora = $aFila['6'];
				$costodia = $aFila['7'];
				$formapago = $aFila['8'];
				$totalefectivo = $aFila['9'];
				$totalvisa = $aFila['10'];
				$estadopago = 1;
				$costoingresoanticipado = $aFila['12'];
				$horaadicional = $aFila['13'];
				$costohoraadicional = $aFila['14'];
				$huespedadicional = $aFila['15'];
				$costohuespedadicional = $aFila['16'];
				$preciounitario = $aFila['17'];
				$cantidad = $aFila['18'];
				$total = $aFila['19'];
		
				$sqlconsultadetalle = "insert alquilerhabitacion_detalle (
				
				idalquilerdetalle,	
				idalquiler,	
				tipoalquiler,	
				fechadesde,	
				fechahasta,	
				nrohoras,	
				nrodias,	
				costohora,	
				costodia,	
				formapago,	
				totalefectivo,	
				totalvisa,
				estadopago,	
				costoingresoanticipado,	
				horaadicional,	
				costohoraadicional,	
				huespedadicional,	
				costohuespedadicional,	
				preciounitario,	
				cantidad,	
				total,	
				idturno,	
				idusuario
				
				)values(
				
				'$xidprimariodetalle',
				'$xidprimario',
				'$tipoalquiler',
				'$fechadesde',
				'$fechahasta',
				'$nrohoras',
				'$nrodias',
				'$costohora',
				'$costodia',
				'$formapago',
				'$totalefectivo',
				'$totalvisa',
				'$estadopago',
				'$costoingresoanticipado',
				'$horaadicional',
				'$costohoraadicional',
				'$huespedadicional',
				'$costohuespedadicional',
				'$preciounitario',
				'$cantidad',
				'$total',
				'$xidturno',
				'$idusuario'
				
				)";
				if($tipoalquiler == 1 || $tipoalquiler == 2  || $tipoalquiler == 6){
					// Actualizar Fecha Fin 		
					$consultaact="update alquilerhabitacion set
					fechafin = '$fechahasta'
					where idalquiler = '$xidprimario'";
					if($mysqli->query($consultaact)){}
				}
				if($mysqli->query($sqlconsultadetalle)){}
				
			}//Fin de While
			
			//Eliminando Temporal de Alquiler
			$sSQL = "delete from alquilerhabitacion_detalle_tmp";
			if($mysqli->query($sSQL)){}
	
		//Actualizar Estado de Habitacion
		$consultaupdate = "update habitacion set
		idestado = 2,
		idalquiler = '$xidprimario'
		where idhabitacion = '$xtxtidhabitacion'";
		if($mysqli->query($consultaupdate)){}
		
		
		//GUARDAR PRODUCTOS DE HABITACION
		if($_POST['txtnumeroproducto'] > 0){
		//Generar ID
		$TblMaxv = $mysqli->query("select max(idventa) from venta");
		$Contador = $TblMaxv->fetch_row();
		$xidprimariov = $Contador['0'] + 1 ;
		
		//Generar Numero
		$TblMax = $mysqli->query("select max(numero) from venta");
		$cont = $TblMax->fetch_row();
		$txtnumero = $cont['0'];
		
		if($txtnumero == 0){
			$txtnumero = 1000 + 1;
		}else{
			$txtnumero = $txtnumero + 1;
		}
		
		$txtcliente = $_POST['txtcliente'];
		$txtfecha = date("Y-m-d");
		$xhora = date('H:i:s');
		$txttotal = str_replace(',','',$_POST['txttotalproducto']);
		
		$tipooperacion = 1; //$_POST['tipooperacion']; //(1:venta/0:cortesia)
		$txtformadepago = 1; //$_POST['txtformadepago']; //(1:efectivo/2:visa)
		
		$estado = 1; // (1:pagado/0:anulado)
		$estadoturno = 1; // (1:abierto/0:cerrado)
		$idusuario = $_SESSION['xyzidusuario'];
		
		$xidcliente = $_POST['txtidcliente'];
		
		$consultav = "insert venta (
			
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
		
			'$xidprimariov',
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
			'$xidprimario'
					
			)";
			
		if($mysqli->query($consultav)){
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
					'$xidprimariov',
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
						vendidoturno = vendidoturno + '$xcantidad'		
						where idproducto = '$xidproducto'";
					if($mysqli->query($sqlrestarcantidad)){}
					
					
				}
			}		
			//Eliminando Temporales
			$sSQL="delete from ventas_tmp";
			if($mysqli->query($sSQL)){}
		}
		}
	
	}
	
	$consultaturno = "update ingresosturno set
		totalhabitacion = (totalhabitacion + $xtotalhabitacion) ,
		totalproducto =  totalproducto + $xtotalproducto,
		totalefectivo = (totalefectivo + $montoefectivo) ,
		totalvisa = totalvisa + $montovisa,
		totaldescuento = totaldescuento + $descuento
		where idturno = '$xidturno'";
		if($mysqli->query($consultaturno)){}
		
	$mysqli->close();	
	$_SESSION['msgerror'] = $Men;
	header("Location: ../../alquilar-detalle.php?idhabitacion=$xtxtidhabitacion&idalquiler=$xidprimario"); exit; 
	/*
	
	// TipoAlquiler - Hora
	if($xtxttipoalquiler==1){
		$xfechadesde = date('Y-m-d H:i:s'); //fecha de Hoy
		$xfechahasta = sumarhoraafecha(6,$xfechadesde); //Fecha hasta adicionando 6 horas
		
		$xnrohoras = 6;	
		$xnrodias = 0;	
		$xcostohoras = $_POST['txtcostohoras']; //PrecioHora
		
		$nrohuesadicional = $_POST['txtocupantesadicionaleshoras']; //Nro Adicional
		$xcostohuespedadicional = $_POST['txtprecioadicionalhora']; //Costo Huesped Adicional por Hora
		//Nuevos
		$xcostoadicional = $nrohuesadicional * $xcostohuespedadicional; // Costo Huesped Adicional Total
		
		$xsubtotal = $xcostohoras;
		//$xtotal = $xsubtotal + ($xcostohuespedadicional * $nrohuesadicional);
		
		//Sumar pagos divididos
		$txtmontoefectivo = $_POST['txtmontoefectivo'];
		$txtmontovisa = $_POST['txtmontovisa'];
		
		if ($xformapago == 1){
			$totalefectivo = $xsubtotal;
			$totalvisa = 0;
		}elseif($xformapago == 2){
			$totalefectivo = 0;
			$totalvisa = $xsubtotal;
		}elseif($xformapago == 3){
			$totalefectivo = $txtmontoefectivo;
			$totalvisa = $txtmontovisa;
		}
		//Fin Sumar pagos divididos
			
	}else if($xtxttipoalquiler==2){ //Alquiler por Dia
		
		$xfechadesde = date('Y-m-d H:i:s'); //fecha de Hoy
		$xfechahasta = Cfecha($_POST['txtfechahasta']).' '.'12:00:00'; //Fecha hasta 
			
		//$xnrohoras = 6;	
		$xnrodias = $_POST['txtnrodias'];	
		$xcostodia = $_POST['txtcostodiario'];
		
		$xsubtotal = $_POST['txtcostototal'];
		$xtotal  = $_POST['txtcostototal'];
		
		//Sumar pagos divididos
		$txtmontoefectivo = $_POST['txtmontoefectivo'];
		$txtmontovisa = $_POST['txtmontovisa'];
		
		if ($xformapago == 1){
			$totalefectivo = $xtotal;
			$totalvisa = 0;
		}elseif($xformapago == 2){
			$totalefectivo = 0;
			$totalvisa = $xtotal;
		}elseif($xformapago == 3){
			$totalefectivo = $txtmontoefectivo;
			$totalvisa = $txtmontovisa;
		}
		//Fin Sumar pagos divididos
	}
	
	
	
	if($txttipooperacion==2){
		$totalefectivo = 0;
		$totalvisa = 0;
		$xtotal = 0;
	}
	
	//$xcostohuespedadicional = $_POST['txtprecioadicionalhora'];
	$txtnroocupantes = $_POST['txtnroocupantes'];
	$xestadopago = 1;
	$xcomentarios = $_POST['txtcomentarios'];
	//$xestadoturno = 1;
	
	$xestadoalquiler = 1;
	
	//$xidturno = $_SESSION['idturno'];
	//*****************************************************
	$txttotal = 0;
	
	$consulta="insert alquiler (
		
		idalquiler,
		idhuesped,
		idhabitacion,	
		nrohabitacion,	
		tipoalquiler,
		
		fechadesde,
		fechahasta,
			
		nrohoras,
		nrodias,
		
		costohora,
		costodia,
		
		total,
		
		estadopago,
		comentarios,	
		estadoturno,
		idusuario,
		
		nroorden,
		estadoalquiler,
		
		formapago,
		
		totalefectivo,
		totalvisa,
		
		tipooperacion,
		idturno
			
	) values (
	
		'$xidprimario',
		'$xtxthuesped',
		'$xtxtidhabitacion',
		'$xtxthrohabitacion',
		'$xtxttipoalquiler',
		
		'$xfechadesde',
		'$xfechahasta',
		
		'$xnrohoras',
		'$xnrodias',
		
		'$xcostohoras',
		'$xcostodia',
		
		'$xtotal',
		
		'$xestadopago',
		'$xcomentarios',	
		'$xestadoturno',
		'$idusuario',
		
		'$txtnumero',
		
		'$xestadoalquiler',
		
		'$xformapago',
		
		'$totalefectivo',
		'$totalvisa',
		
		'$txttipooperacion',
		'$xidturno'
		
		)";
		
	if($mysqli->query($consulta)){
		$Men = "Los datos fueron guardados satisfactoriamente.";
		//Actualizar Turno
		
	
		//Actualizar Estado de Habitacion
		$consultaupdate = "update habitacion set
		idestado = 2,
		idalquiler = '$xidprimario'
		where idhabitacion = '$xtxtidhabitacion'";
		if($mysqli->query($consultaupdate)){}
		
		//$xidturno = $_SESSION['idturno'];
		
		
		
		//Guardar Adicionales
		if($nrohuesadicional > 0){
			$TblMaxa = $mysqli->query("select max(idadicional) from alquiler_adicional");
			$Contador = $TblMaxa->fetch_row();
			$xidadicional = $Contador['0'] + 1 ;
			
			$consultaadicional = "insert alquiler_adicional (
				idadicional,
				idalquiler,
				idtipo,
				nroadicional,
				costoadicional,
				total,
				estadopago,
				idturno,
				idusuario
				
				
				)values(
				
				'$xidadicional',
				'$xidprimario',
				'1',
				'$nrohuesadicional',
				'$xcostohuespedadicional',
				'$xcostoadicional',
				'1',
				'$xidturno',
				'$idusuario' ) ";
				
				if($mysqli->query($consultaadicional)){
				}
			}
			
	//*************************************************************************************************		
		//GUARDAR PRODUCTOS DE HABITACION
		if($_POST['txtnumeroproducto'] > 0){
		//Generar ID
		$TblMaxv = $mysqli->query("select max(idventa) from venta");
		$Contador = $TblMaxv->fetch_row();
		$xidprimariov = $Contador['0'] + 1 ;
		
		//Generar Numero
		$TblMax = $mysqli->query("select max(numero) from venta");
		$cont = $TblMax->fetch_row();
		$txtnumero = $cont['0'];
		
		if($txtnumero == 0){
			$txtnumero = 1000 + 1;
		}else{
			$txtnumero = $txtnumero + 1;
		}
		
		$txtcliente = $_POST['txtcliente'];
		$txtfecha = date("Y-m-d");
		$xhora = date('H:i:s');
		$txttotal = str_replace(',','',$_POST['txttotalproducto']);
		
		$tipooperacion = 1; //$_POST['tipooperacion']; //(1:venta/0:cortesia)
		$txtformadepago = 1; //$_POST['txtformadepago']; //(1:efectivo/2:visa)
		
		$estado = 1; // (1:pagado/0:anulado)
		$estadoturno = 1; // (1:abierto/0:cerrado)
		$idusuario = $_SESSION['xyzidusuario'];
		
		$xidcliente = $_POST['txtidcliente'];
		
		$consultav = "insert venta (
			
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
		
			'$xidprimariov',
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
			'$xidprimario'
					
			)";
			
		if($mysqli->query($consultav)){
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
					'$xidprimariov',
					'$xidproducto',
					'$xnombre',
					'$xcantidad',
					'$xprecio',
					'$ximporte'
					)";
				if($mysqli->query($consultatmp)){
					//Descontar Stock de Producto
					$sqlrestarcantidad = "update producto set
						cantidad = 	cantidad - '$xcantidad' 			
						where idproducto = '$xidproducto'";
					if($mysqli->query($sqlrestarcantidad)){}
					
					
				}
			}		
			//Eliminando Temporales
			$sSQL="delete from ventas_tmp";
			if($mysqli->query($sSQL)){}
		}
		}
	//*************************************************************************************************		
		$consultaturno = "update ingresosturno set
		totalhabitacion = totalhabitacion + $xsubtotal,
		totaladicional = totaladicional + $xcostoadicional,
		totalproducto =  totalproducto + $txttotal,
		totalefectivo = totalefectivo + $totalefectivo,
		totalvisa = totalvisa + $totalvisa
		where idturno = '$xidturno'";
		if($mysqli->query($consultaturno)){}
		
	}else{
		$Men = "Ha fallado, los datos no han sido registrados.";
	}
	
		
	
	$mysqli->close();	
	$_SESSION['msgerror'] = $Men;
	header("Location: ../../alquilar-detalle.php?idhabitacion=$xtxtidhabitacion&idalquiler=$xidprimario"); exit; 
*/
?>