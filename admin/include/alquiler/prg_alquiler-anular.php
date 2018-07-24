<?php
session_start();
include "../../config.php";
include "../functions.php";

//--------------------------------------------------------------
$xidturno = $_SESSION['idturno'];
$idusuario = $_SESSION['xyzidusuario'];
$xidalquiler = $_GET['idalquiler'];
$xidhabitacion = $_GET['idhabitacion'];

//estadoalquiler: 1=Activo - 0=Anulado
$xestadoalquiler = 0;
$xmotivoanulacion = $_POST['txtmotivoanulacion'];

//Actualizar Alquiler
$consulta="update alquiler set
	estadoalquiler = '$xestadoalquiler',
	motivoanulacion = '$xmotivoanulacion'
	where idalquiler = '$xidalquiler' and idhabitacion = '$xidhabitacion'";
if($mysqli->query($consulta)){}

//Actualizar Habitacion
$consultahabitacion = "update habitacion set
	idalquiler = 0,
	idestado = 1
	where idhabitacion = '$xidhabitacion'";

//Actualiza Ingreso
/*$consultahabitacion = "update ingresosturno set
	estadoturno = 0,
	totalhabitacion = 0,
	totaladicional=0,
	totalproducto=0,
	totalefectivo=0,
	totalvisa=0
	where idhabitacion = '$xidhabitacion'";*/

	$TotalAlquiler=0; $MontoVisa=0; $Descuento=0; $TotalProductos=0;
	$sqlalquiler = $mysqli->query("select
			alquilerhabitacion.idalquiler,
			alquilerhabitacion.idhuesped,
			alquilerhabitacion.idhabitacion,
			alquilerhabitacion.nrohabitacion,
			alquilerhabitacion.tipooperacion,
			alquilerhabitacion.total,
			
			huesped.idhuesped,
			huesped.nombre,
			huesped.ciudad,
			huesped.tipo_documento,
			huesped.documento,
			
			alquilerhabitacion.comentarios,
			alquilerhabitacion.nroorden,
			alquilerhabitacion.fecharegistro,
			alquilerhabitacion.totalefectivo,
			alquilerhabitacion.totalvisa,
			alquilerhabitacion.descuento
			
			from alquilerhabitacion inner join huesped on huesped.idhuesped = alquilerhabitacion.idhuesped
			where alquilerhabitacion.idalquiler = '$xidalquiler' 
			");		
			$xaFila = $sqlalquiler->fetch_row();
			

	$MontoVisa=	$xaFila[15];
	$Descuento=	$xaFila[16];

	//Detalle Aquiler
	$sqldetalle = $mysqli->query("select
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
		
		from alquilerhabitacion_detalle 
		where idalquiler = '$xidalquiler'   and estadopago!=2 order by idalquilerdetalle asc
		");
	
	while ($tmpFila = $sqldetalle->fetch_row()){ $num++; 

		$TotalAlquiler+=$tmpFila[20];
		
	}
	//FIN DETALLE ALQUILER


	//INICIO DETALLE VENTAS
	$sqlventa = $mysqli->query("select
	venta.idventa,
	venta.idalquiler,
	ventadetalle.idventadetalle,
	ventadetalle.idventa,
	ventadetalle.nombre,
	ventadetalle.cantidad,
	ventadetalle.precio,
	ventadetalle.importe
	
	from venta left join ventadetalle on ventadetalle.idventa = venta.idventa
	where venta.idalquiler = '$xidalquiler'  order by ventadetalle.idventadetalle asc");


	while($vFila = $sqlventa->fetch_row()){

							
		$TotalProductos+=($vFila[6] * $vFila[5]);

		

	}
	
	$consultaturno = "update ingresosturno set
		totalhabitacion = (totalhabitacion - $TotalAlquiler) ,
		totalproducto =  totalproducto - $TotalProductos,
		totalefectivo = (totalefectivo - ($TotalAlquiler + $TotalProductos)) ,
		totalvisa = totalvisa - $MontoVisa,
		totaldescuento = totaldescuento - $Descuento
		where idturno = '$xidturno'";
		if($mysqli->query($consultaturno)){}

if($mysqli->query($consultahabitacion)){}



			
$mysqli->close();	
//$_SESSION['msgerror'] = $Men;
header("Location: ../../control-habitaciones.php"); exit;
//************************************************************
?>