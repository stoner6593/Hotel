<?php
include "../validar.php";
include "../config.php";
include "../include/functions.php";
date_default_timezone_set('America/Lima');


$xidventa = $_GET['xidventa'];
$xguardado = $_GET['guardado'];

$detalle = $_GET['detalle'];

//Recuperar Datos para Mostrar
$sqlventa = $mysqli->query("select
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
	anotaciones
	
	from venta where idventa = '$xidventa'");
	$vFila = $sqlventa->fetch_row();
	
	$sqldetalle = $mysqli->query("select idventadetalle, idventa, idproducto, nombre, cantidad, precio, importe from ventadetalle where idventa = '$xidventa' order by idventadetalle asc");
	
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>

<style>
	.textoContenido{
	font-family: Arial, sans-serif;
	font-size: 14px;
	color: #000000;
	text-align:left;
}
</style>

<script type="text/javascript">
	function imprimir() {
		if (window.print) {
			window.print();
		} else {
			alert("La función de impresion no esta soportada por su navegador.");
		}
	}
</script>

</head>

<body onload="imprimir();">
<table width="260" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td height="20" colspan="2" align="center"><span class="textoContenido"><strong>HOTEL CENTURY-INN</strong></span></td>
    </tr>
    <tr>
      <td height="20" colspan="2" align="center"><span class="textoContenido">Jr. Bernardo Alcedo 147 - Lince</span></td>
    </tr>
    <tr>
      <td height="20" colspan="2" align="center"><span class="textoContenido">Lima  - Lima / T. (01) 455-6349</span></td>
    </tr>
    <tr>
      <td height="20" colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td height="20" colspan="2"><strong><span class="textoContenido">ORDEN DE PRODUCTO # 1001</span></strong></td>
    </tr>
    <tr>
      <td height="20" colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td height="20" colspan="2"><span class="textoContenido">CLIENTE: <strong><?php echo $vFila['2'];?></strong></span></td>
    </tr>
    <tr>
      <td height="20" colspan="2"><span class="textoContenido">-------------PRODUCTOS--------------------</span></td>
    </tr>
     <?php $xtotal = 0; while($tmpFila = $sqldetalle->fetch_row()){?>
    <tr>
      <td width="181" height="20"><span class="textoContenido"><?php echo $tmpFila['3']; ?><span class="textoContenido"> (<?php echo $tmpFila['4']; ?>) </span></span></td>
      <td width="79" class="textoContenido">S/ <?php echo number_format($tmpFila['6'],2); ?></td>
    </tr>
    <?php $xtotal = $xtotal + $tmpFila['5']; } ?>
    <tr>
      <td height="20" colspan="2"><span class="textoContenido"><strong> TOTAL: S/ <?php echo number_format($vFila['5'],2);?></strong></span></td>
    </tr>
    <tr>
      <td height="20" colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td height="20" colspan="2"><span class="textoContenido">Operación: <?php echo tipoOperacion($vFila['6']);?></span></td>
    </tr>
    <tr>
      <td height="20" colspan="2"><span class="textoContenido">Forma de Pago: <?php echo formaPago($vFila['7']);?> </span></td>
    </tr>
    <tr>
      <td height="20" colspan="2"><span class="textoContenido">Fecha y Hora:  <?php echo Cfecha($vFila['3']);?>  - <?php echo $vFila['4'];?></span></td>
    </tr>
    <tr>
      <td height="20" colspan="2"><span class="textoContenido">------------------------------------------------</span></td>
    </tr>
    <tr>
      <td height="20" colspan="2"><span class="textoContenido">Este documento no es un Comprobante de Pago, al finalizar su tiempo reclame su Factura o Boleta de Venta.</span></td>
    </tr>
    <tr>
      <td height="20" colspan="2"><span class="textoContenido">------------------------------------------------</span></td>
    </tr>
    <tr>
      <td height="20" colspan="2"><span class="textoContenido">USUARIO: <?php echo $_SESSION['xyzusuario'];?></span></td>
    </tr>
    <tr>
      <td height="20" colspan="2"><span class="textoContenido"><?php echo Cfecha(date("Y-m-d")).' - '.date("H:i")?></span></td>
    </tr>
    <tr>
      <td height="20" colspan="2">&nbsp;</td>
    </tr>
  </tbody>
</table>
</body>
</html>