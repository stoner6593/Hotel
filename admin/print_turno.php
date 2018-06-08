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
	fechacierre
	
	from ingresosturno where idturno = '$xidturno'	");

$hFila = $sqlturno->fetch_row();
	
	//Habitacion
	$xhabitacion = $hFila['1'];

	//Producto
	$xproducto = $hFila['3'];
	
	//Visa/Efectivo
	$xefectivo = $hFila['4'];
	$xvisa = $hFila['5'];
	
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
	where estadoturno = 1 and usuario = '$xidusuario'");
	
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
</style>

</head>

<body onload="imprimir();">
<table width="260" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td width="260" height="22" align="center"><span class="textoContenido">HOTEL PALACE </span></td>
    </tr>
    <tr>
      <td height="22" align="center"><span class="textoContenido">Calle Manuel del Pino 116 Santa Beatriz</span></td>
    </tr>
    <tr>
      <td height="22" align="center"><span class="textoContenido">Lima  - Lima / T. (01) 471-1546</span></td>
    </tr>
    <tr>
      <td height="22">&nbsp;</td>
    </tr>
    <tr>
      <td height="22" align="center"><span class="textoContenido"><strong>RESUMEN DE INGRESO TURNO</strong></span></td>
    </tr>
    <tr>
      <td height="22">&nbsp;</td>
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
      <td height="22" align="center"><span class="textoContenido">------------------------------------------------</span></td>
    </tr>
    <tr>
      <td height="22" align="center"><span class="textoContenido">USUARIO: <?php echo $_SESSION['xyznombre'];?> HOLA </span></td>
    </tr>
    <tr>
      <td height="22" align="center" ><span class="textoContenido"> Apertura: <?php echo $xfechaapertura;?> </span></td>
    </tr>
    <tr>
      <td height="22" align="center"><span class="textoContenido">Cierre: <?php echo $xcierre;?></span></td>
    </tr>
  </tbody>
</table>
</body>
</html>