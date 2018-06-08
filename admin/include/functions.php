<?php
date_default_timezone_set('America/Lima');
//Convertir fecha para MySQL: 01/01/2000 a 2000/01/01

function nombrededia($xfecha){
	$fecha = $xfecha; //5 agosto de 2004 por ejemplo  
	$fechats = strtotime($fecha); //a timestamp 
	
	//el parametro w en la funcion date indica que queremos el dia de la semana 
	//lo devuelve en numero 0 domingo, 1 lunes,.... 
	switch (date('w', $fechats)){ 
		case 0: $dia = "DOMINGO"; break; 
		case 1: $dia = "LUNES"; break; 
		case 2: $dia = "MARTES"; break; 
		case 3: $dia = "MIERCOLES"; break; 
		case 4: $dia = "JUEVES"; break; 
		case 5: $dia = "VIERNES"; break; 
		case 6: $dia = "SABADO"; break; 
	} 
	return $dia;
}
	
function sumarhoraafecha($nrohoras,$xfechahora){
	//($fecha=time(); Actual) 
	/*
	$fecha = strtotime('2017-06-12 13:35:00'); 
	$horas = +6; 
	$fecha += ($horas * 60 * 60);
	$fecha = date("Y-m-d H:i:s", $fecha ); 
	*/
	$fecha  = strtotime("$xfechahora"); /*FechaHora*/ $horas = +$nrohoras; /*NroHoras +-*/ $fecha += ($horas * 60 * 60);
	return $fecha = date("Y-m-d H:i:s", $fecha ); 
}

	
function mayuscula($dato)
{
	$xresultado = mb_strtoupper($dato,"utf-8");
	return $xresultado;
}

/*
	$date = strtotime("2003-12-14");
	echo date("Y", $date); // Year (2003)
	echo date("m", $date); // Month (12)
	echo date("d", $date); // day (14)
*/
function colorestado($xestado){
	if($xestado==1){
		$xcolores =	'00A230';
	}else{
		$xcolores =	'E1583E';
	}
	return $xcolores;
}

function turnoNombre($xturno){
	if($xturno==1){
		$xrpta =	"DIA";
	}else{
		$xrpta =	"NOCHE";
	}
	return $xrpta;
}

function habitacionIcono($xtipo){
	$xval = intval($xtipo);
	if($xval==1){
		$xicono = "<i class='fa fa-hotel'></i>";
	}elseif($xval==2){
		$xicono =	"<i class='fa fa-bookmark'></i>";
	}elseif($xval==3){
		$xicono = "<i class='fa fa-sun-o'></i>";
	}elseif($xval==4){
		$xicono = "<i class='fa fa-hotel'></i> <i class='fa fa-hotel'></i>";
	}
	return $xicono;
}

function habitacionUbicacion($xubi){
	$xval = intval($xubi);
	if($xval == 1){
		$xubica = "<i class='fa fa-th-large fa-lg'></i>";
	}elseif($xval == 0){
		$xubica = "";
	}
	return $xubica;
}

function edad($xedad){
	$xdate = strtotime($xedad); 
	$anio = date('Y', $xdate);
	$aniohoy = date('Y');
	$edad = ($aniohoy - $anio);
	return $edad;
}


function estado($xdato){ //Activo / Desativo
	if($xdato == 1){
		$xcolor = "00A230";
	}else{
		$xcolor = "E1583E";
	}
	return $xcolor;
}


function Cfecha($fec)
{
$cua = substr($fec,0,4);
if(ereg("/",$cua)){$fecha=substr($fec,6,4)."-".substr($fec,3,2)."-".substr($fec,0,2);}
else{$fecha=substr($fec,8,2)."/".substr($fec,5,2)."/".substr($fec,0,4);}
return $fecha;
}

function formaPago($forma)
{	
	$f = intval($forma);
	if ($f == 1){
		$rpta = "Efectivo";
	}elseif ($f == 2){
		$rpta = "Visa";
	}elseif($f == 3){
		$rpta = "Efectivo y Visa";
	}
	return $rpta;
}


function tipoAlquiler($tipo)
{	
	$f = intval($tipo);
	if ($f == 1){
		//$rpta = "Alquiler por Horas";
		$rpta = "Alquiler";
	}elseif ($f == 2){
		$rpta = "Aquiler";
	}elseif ($f == 3){
		$rpta = "Hora Adicional";
	}elseif ($f == 4){
		$rpta = "Huesped Adicional";
	}elseif ($f == 5){
		$rpta = "Ingreso Anticipado";
	
	}elseif ($f == 6){
		$rpta = "Alquiler";
	}
	return $rpta;
}


function tipoOperacion($tipo)
{	
	$f = intval($tipo);
	if ($f == 1){
		$rpta = "Venta";
	}else if ($f == 2){
		$rpta = "Cortesia";
	}else{
		$rpta = "No definido";
	}
	return $rpta;
}


function estadoPago($tipo)
{	
	$f = intval($tipo);
	if ($f == 1){
		$rpta = "<span style='color:#00A230;'> Pagado </span>";
	}else if ($f == 0){
		$rpta = "<span style='color:#E1583E;'> Pendiente </span>";
	}else if ($f == 2){
		$rpta = "<span style='color:#999999;'> Anulado </span>";
	}
	return $rpta;
}

function fechadesdehasta($fechauno,$fechados)
{	
	$fecha = strtotime($fechauno);
  	$fechadesde = Cfecha(date("Y-m-d",$fecha));
  	$horadesde = date("H:i",$fecha);
	
	$fecha = strtotime($fechados);
  	$fechahasta = Cfecha(date("Y-m-d",$fecha));
  	$horahasta = date("H:i",$fecha);
	
  	//return '<br>De: '.$fechadesde.' ('.$horadesde.') '.'  - Hasta: '.$fechahasta.' ('.$horahasta.')';
	return '<br>'.$fechadesde.' ('.$horadesde.') '.'  - '.$fechahasta.' ('.$horahasta.')';
}



//Funcion que suma o resta N dias a una fecha
function DiasFecha($fecha,$dias,$operacion){
  Switch($operacion){
    case "sumar":
    $varFecha = date("Y-m-d", strtotime("$fecha + $dias day"));
    return $varFecha;
    break;
    case "restar":
    $varFecha = date("Y-m-d", strtotime("$fecha - $dias day"));
    return $varFecha;
    break;
    default:
    $varFecha = date("Y-m-d", strtotime("$fecha + $dias day"));
    break;
  }
}



//Diferencia de dias en tre dos fechas
function dias_transcurridos($fecha_i,$fecha_f)
{
	$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
	$dias 	= abs($dias); $dias = floor($dias);
	
	if($fecha_i > $fecha_f){
		$signo = "-";
		return $signo.$dias;
	}else{
		return $dias;
	}
}
// Ejemplo de uso:
//echo dias_transcurridos('2012-07-01','2012-07-18');
// Salida : 17 
?>
