<?php
session_start();
include "../config.php";
include "../include/functions.php";
date_default_timezone_set('America/Lima');

$xidturno = $_GET['idturno'];

$sqlusuarioturno = $mysqli->query("select 
	idturno,
	idusuario
	from ingresosturno where idturno = '$xidturno'");
	$xuFila = $sqlusuarioturno->fetch_row();
	
	$xidusuario = $xuFila["1"]; //Usuario de Turno

//RESUMEN DE PRODUCTOS
//$xidusuario = $_SESSION['xyzidusuario'];


//INGRESO HABITACION
$sqlturno = $mysqli->query("select
	idturno,
	totalhabitacion,
	totaladicional,
	totalproducto,
	
	totalefectivo,
	totalvisa,
	
	idusuario,
	estadoturno,
	fechaapertura,
	fechacierre,
	
	turno
	
	from ingresosturno where idturno = '$xidturno'	");

	$hFila = $sqlturno->fetch_row();
	
	//Habitacion
	$xhabitacion = $hFila['1'];

	//Producto
	$xproducto = $hFila['3'];
	
	//Visa/Efectivo
	$xefectivo = $hFila['4'];
	$xvisa = $hFila['5'];
	
	
	//Turno
	$xturno = $hFila['10'];
	//$xsumatotal = $hFila['6'];
	
	//TOTAL INGRESOS DE TURNO
	
	$xfechaapertura = $hFila['8'];

	$xcierre = date("Y-m-d H:i:s");

//EGRESO O GASTOS
$sqlgastos = $mysqli->query("select
	idgasto,
	monto,
	estadoturno,
	usuario,
	tipooperacion
	from gasto 
	where idturno = '$xidturno' and usuario = '$xidusuario'");
	
	$xcompra = 0;
	$xgasto = 0;
	$xsumaegreso = 0;
	while($gFila = $sqlgastos->fetch_row()){
		if ($gFila['4']==1){ //Compras
			$xcompra = $xcompra + $gFila['1'];//total
		}elseif($gFila['4']==2){ //Gastos
			$xgasto = $xgasto + $gFila['1'];//total
		}
		$xsumaegreso = $xsumaegreso + $gFila['1'];
	}

$sqlhab = $mysqli->query("select idhabitacion, idalquiler from habitacion order by idalquiler asc");
$xocupados = 0;
$xlibres = 0;
while($xnhFila = $sqlhab->fetch_row()){
	$alquiler = $xnhFila['1'];
	if($alquiler==0){
		$xlibres++;
	}else{
		$xocupados++;
	}
}	

$sqlnumeroalquiler = $mysqli->query("select idalquiler, idturno from alquilerhabitacion where idturno = '$xidturno'");
$xnumeroalquiler = $sqlnumeroalquiler->num_rows;

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title></title>
<link rel="stylesheet" type="text/css" href="../opera.css">

<script type="text/javascript">
	function imprimir() {
		if (window.print) {
			window.print();
		} else {
			alert("La función de impresion no esta soportada por su navegador.");
		}
	}
</script>

<style>
	.textoContenido{
	font-family: Arial, sans-serif;
	font-size: 14px;
	color: #000000;
	text-align:left;
}
.textoContenido1 {	font-family: Arial, sans-serif;
	font-size: 14px;
	color: #000000;
	text-align:left;
}
.textoContenidoMenor {	font-family: Arial, sans-serif;
	font-size: 11px;
	color: #000000;
	text-align:left;
}
</style>

</head>

<body onload="imprimir();">
<table width="260" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td width="260" height="22" align="center"><span class="textoContenido"><strong>HOTEL CENTURY-INN </strong></span></td>
    </tr>
    <tr>
      <td height="22" align="center"><span class="textoContenido">Jr. Bernardo Alcedo 147 - Lince</span></td>
    </tr>
    <tr>
      <td height="22" align="center"><span class="textoContenido">Lima  - Lima / T. (01) 455-6349</span></td>
    </tr>
    <tr>
      <td height="22" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td height="22" align="center"> <span class="textoContenido">Recepción:<strong> <?php echo $_SESSION['xyznombre'];?></strong></span></td>
    </tr>
    <tr>
      <td height="22" align="center"><span class="textoContenido1" style="text-align:center;">Dia:<strong> <?php echo nombrededia($xfechaapertura);?></strong> - Turno: <strong> <?php echo turnoNombre($xturno);?></strong></span></td>
    </tr>
    <tr>
      <td height="22" align="center" ><span class="textoContenido"> Apertura: <?php echo Cfecha($xfechaapertura).' - '.date('H:i',strtotime($xfechaapertura));?> </span></td>
    </tr>
    <tr>
      <td height="22" align="center"><span class="textoContenido">Cierre: <?php echo Cfecha($xcierre).' - '.date('H:i',strtotime($xcierre));;?></span> </td>
    </tr>
    <tr>
      <td height="22">&nbsp;</td>
    </tr>
    <tr>
      <td height="22" align="center"><span class="textoContenido"><strong>RESUMEN DE INGRESO TURNO</strong></span></td>
    </tr>
    <tr>
      <td height="22" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td height="22" align="center"><span class="textoContenido">------------- HABITACION -----------------</span></td>
    </tr>
    <tr>
      <td height="22" align="center"><span class="textoContenido">Total: S/ <?php echo number_format($xhabitacion,2);?></span></td>
    </tr>
    <tr>
      <td height="22">&nbsp;</td>
    </tr>
    <tr>
      <td height="22" align="center"><span class="textoContenido">------------- PRODUCTOS -----------------</span></td>
    </tr>
    <tr>
      <td height="22" align="center"><span class="textoContenido">Total: S/ <?php echo number_format($xproducto,2);?></span></td>
    </tr>
    <tr>
      <td height="22">&nbsp;</td>
    </tr>
    <tr>
      <td height="22" align="center"><span class="textoContenido">TOTAL INGRESOS DE TURNO</span></td>
    </tr>
    <tr>
      <td height="22" align="center"><span class="textoContenido">Efectivo: S/ <?php echo number_format($xefectivo,2);?></span></td>
    </tr>
    <tr>
      <td height="22" align="center"><span class="textoContenido">Visa: S/ <?php echo number_format($xvisa,2);?></span></td>
    </tr>
    <tr>
      <td height="22" align="center"><span class="textoContenido"><strong> Total Ingreso: S/ <?php echo number_format($xhabitacion+$xproducto,2);?></strong></span></td>
    </tr>
    <tr>
      <td height="22" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td height="22" align="center"><span class="textoContenido"> EGRESOS DE TURNO ----------</span></td>
    </tr>
    <tr>
      <td height="22" align="center"><span class="textoContenido">Compras: <?php echo number_format($xcompra,2);?></span></td>
    </tr>
    <tr>
      <td height="22" align="center"><span class="textoContenido">Gastos: <?php echo number_format($xgasto,2);?></span></td>
    </tr>
    <tr>
      <td height="22" align="center"><span class="textoContenido"><strong> Total Egreso: S/ <?php echo number_format($xsumaegreso,2);?></strong></span></td>
    </tr>
    <tr>
      <td height="22" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td height="22" align="center"><span class="textoContenido"><strong>Efectivo Turno (Ingreso-Egreso):</strong></span></td>
    </tr>
    <tr>
      <td height="22" align="center"><span class="textoContenido"><strong>S/ <?php echo number_format($xefectivo-$xsumaegreso,2);?></strong></span></td>
    </tr>
    <tr>
      <td height="22" align="center"><span class="textoContenido1">------------------------------------------------</span></td>
    </tr>
    <tr>
      <td height="22" align="center"><span class="textoContenido1">Hab. Alquiladas: <?php echo $xnumeroalquiler;?></span></td>
    </tr>
    <tr>
      <td height="22" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td height="22" align="center"><span class="textoContenido1">Hab. Ocupadas: <?php echo $xocupados;?></span></td>
    </tr>
    <tr>
      <td height="22" align="center"><span class="textoContenido1">Hab. Libres: <?php echo $xlibres;?></span></td>
    </tr>
    <tr>
      <td height="22" align="center">-</td>
    </tr>
  </tbody>
</table>
</body>
</html>