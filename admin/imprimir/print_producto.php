<?php
session_start();
include "../config.php";
include "../include/functions.php";
date_default_timezone_set('America/Lima');

$xidturno = $_GET['idturno'];

$sqlproducto = $mysqli->query("select
	idproducto,
	nombre,
	precioventa,
	cantidad,
	estado,
	
	inicialturno,
	vendidoturno,
	compradoturno
	
	from producto order by orden asc");

//INGRESO HABITACION
$sqlturno = $mysqli->query("select
	idturno,
	idusuario,
	estadoturno,
	fechaapertura,
	fechacierre,
	turno
	from ingresosturno where idturno = '$xidturno'	");
	$tFila = $sqlturno->fetch_row();
	
	$xfechaapertura = $tFila['3'];
	$xcierre = date("Y-m-d H:i:s");
	$xturno = 	$tFila['5'];
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title></title>

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
	.textoContenido {
	font-family: Arial, sans-serif;
	font-size: 15px;
	color: #000000;
	text-align:left;
}
.textoContenido1 {	font-family: Arial, sans-serif;
	font-size: 16px;
	color: #000000;
	text-align:left;
}
.textoContenidoMenor {	font-family: Arial, sans-serif;
	font-size: 14px;
	color: #000000;
	text-align:left;
}
</style>

</head>

<body onload="imprimir();">
<table width="305" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td height="22" colspan="5" align="center"><span class="textoContenido"><strong>HOTEL CENTURY-INN </strong></span></td>
    </tr>
    <tr>
      <td height="22" colspan="5" align="center"><span class="textoContenido">Jr. Bernardo Alcedo 147 - Lince</span></td>
    </tr>
    <tr>
      <td height="22" colspan="5" align="center"><span class="textoContenido">Lima  - Lima / T. (01) 455-6349</span></td>
    </tr>
    <tr>
      <td height="22" colspan="5" align="center" class="textoContenido" style="text-align:center;">&nbsp;</td>
    </tr>
    <tr>
      <td height="22" colspan="5" align="center" class="textoContenido" style="text-align:center;">Recepción:<strong> <?php echo $_SESSION['xyznombre'];?></strong></td>
    </tr>
    <tr>
      <td height="22" colspan="5" align="center" class="textoContenido" style="text-align:center;">Dia:<strong> <?php echo nombrededia($xfechaapertura);?></strong>  - Turno: <strong> <?php echo turnoNombre($xturno);?></strong></td>
    </tr>
    <tr>
      <td height="22" colspan="5" align="center"><span class="textoContenido1"> Apertura: <?php echo Cfecha($xfechaapertura).' - '.date('H:i',strtotime($xfechaapertura));?></span></td>
    </tr>
    <tr>
      <td height="22" colspan="5" align="center"><span class="textoContenido1">Cierre: <?php echo Cfecha($xcierre).' - '.date('H:i',strtotime($xcierre));;?></span></td>
    </tr>
    <tr>
      <td height="22" colspan="5" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td height="22" colspan="5" align="center"><span class="textoContenido"><strong>LISTA DE PRODUCTOS</strong></span></td>
    </tr>
    <tr>
      <td height="22" colspan="5">&nbsp;</td>
    </tr>
    
    <tr>
      <td height="22" align="left" class="textoContenidoMenor">PRODUCTOS</td>
      <td width="30" height="22" align="right"><span class="textoContenidoMenor">ULT</span></td>
      <td width="30" height="22" align="right"><span class="textoContenidoMenor">VEND</span></td>
      <td width="30" height="22" align="right"><span class="textoContenidoMenor">COM</span></td>
      <td width="30" height="22" align="right"><span class="textoContenidoMenor"><strong>SALD</strong></span></td>
    </tr>
    
    <?php 
	while($pFila = $sqlproducto->fetch_row()){
	?>
    
    <tr>
      <td width="157" height="22" align="left"><span class="textoContenidoMenor"> <?php echo $pFila['1']?> </span></td>
      <td width="30" height="22" align="right"><span class="textoContenidoMenor"> <?php echo $pFila['5']?> </span></td>
      <td width="30" height="22" align="right"> <span class="textoContenidoMenor"><?php echo $pFila['6']?> </span></td>
      <td width="30" height="22" align="right"> <span class="textoContenidoMenor"><?php echo $pFila['7']?> </span></td>
      <td width="30" height="22" align="right"> <span class="textoContenidoMenor"><strong><?php echo $pFila['3']?></strong></span></td>
    </tr>
    <tr>
       <td colspan="5"><div style="border-top:1px; border-top-color:#666666; border-top-style:ridge; width:100%;"></div></td>
    </tr>
    <?php 
	}
	?>
    
    <tr>
      <td height="22" colspan="5" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td height="22" colspan="5" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td height="22" colspan="5" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td height="22" colspan="5" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td height="22" colspan="5" align="center">&nbsp;</td>
    </tr>
    <tr>
      <td height="22" colspan="5" align="center">&nbsp;</td>
    </tr>
    <tr>
       <td colspan="5"><div style="border-top:1px; border-top-color:#666666; border-top-style:ridge; width:100%;"></div></td>
    </tr>
    <tr>
      <td height="22" colspan="5" align="center">-</td>
    </tr>
  </tbody>
</table>
</body>
</html>