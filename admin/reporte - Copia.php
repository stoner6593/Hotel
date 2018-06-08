<?php
include "validar.php";
include "config.php";
include "include/functions.php";
date_default_timezone_set('America/Lima');

$xidturno = $_GET["xidturno"];

$sqlusuarioturno = $mysqli->query("select 
	idturno,
	idusuario
	from ingresosturno where idturno = '$xidturno'");
	$xuFila = $sqlusuarioturno->fetch_row();
	
	$xidusuario = $xuFila["1"]; //Usuario de Turno

//RESUMEN DE PRODUCTOS
//$xidusuario = $_SESSION['xyzidusuario'];


$sqlordenproductos = $mysqli->query("select
	idventa,
	formapago,
	estadoturno,
	total,
	idusuario
	from venta 
	where estadoturno = 1 and idusuario = '$xidusuario' order by idventa");

	$xefectivo = 0;
	$xvisa = 0;
	$xsumatotal = 0;
	
	while($vFila = $sqlordenproductos->fetch_row()){
		if($vFila['1']==1){
			$xefectivo = $xefectivo + $vFila['3'];//total
		}elseif($vFila['1']==2){
			$xvisa = $xvisa + $vFila['3'];//total
		}
		$xsumatotal = $xsumatotal + $vFila['3'];
	}
//FIN RESUMEN DE PRODUCTOS

//RESUMEN DE HABITACION
$sqlordenhabitacion = $mysqli->query("select
	idalquiler,
	formapago,
	estadoturno,
	total,
	idusuario,
	
	totalefectivo,
	totalvisa
	
	from alquiler
	where estadoturno = 1 and idusuario = '$xidusuario'");
	
	$xefectivoh = 0;
	$xvisah = 0;
	$xsumatotalh = 0;
	
	while($hFila = $sqlordenhabitacion->fetch_row()){
		
		/* if($hFila['1']==1){
			$xefectivoh = $xefectivoh + $hFila['3'];//total
		}elseif($hFila['1']==2){
			$xvisah = $xvisah + $hFila['3'];//total
		}*/
		
		$xefectivoh = $xefectivoh + $hFila['5'];
		$xvisah = $xvisah + $hFila['6'];
		
		$xsumatotalh = $xsumatotalh + $hFila['3'];
		
	}
//FIN RESUMEN DE HABITACION


//TOTAL INGRESOS DE TURNO
$xsumatotalingresoefectivo = $xefectivo + $xefectivoh;
$xsumatotalingresovisa = $xvisa + $xvisah;
$xsumatotalingreso = $xsumatotal + $xsumatotalh;

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
<title>Administrador</title>
<link href="opera.css" rel="stylesheet" type="text/css">
<script src="chartjs/Chart.js"></script>
<link href="http://fontawesome.io/assets/font-awesome/css/font-awesome.css" rel="stylesheet"> 
</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td height="25" colspan="3"><?php include ("head.php"); ?></td>
    </tr>
    <tr>
      <td width="185" height="25" align="left" valign="top"><?php include ("menu_nav.php"); ?></td>
      <td width="25">&nbsp;</td>
      <td width="793" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tbody>
          <tr>
            <td height="30"> <h3 style="color:#E1583E;"> <i class="fa fa-calendar"></i> Reportes </h3> <div class="lineahorizontal" style="background:#EFEFEF;"></div> </td>
            </tr>
          <tr>
            <td height="246" valign="top"><table width="99%" border="0" cellpadding="0" cellspacing="0">
              <tbody>
                <tr>
                  <td height="30" colspan="3" class="textoContenido"><table width="100%" border="0" cellspacing="1" cellpadding="2">
                    <tbody>
                      <tr>
                        <td height="25" colspan="3" class="textoContenido">Antes de Cerrar su Turno debe Imprimir o Guardar toda información resultante para que el Siguiente usuario pueda abrir turno.</td>
                      </tr>
                      <tr>
                        <td height="25" colspan="3" class="textoContenido"><div class="lineahorizontal" style="background:#EFEFEF;"></div></td>
                        </tr>
                      <tr>
                        <td height="25">&nbsp;</td>
                        <td height="25">&nbsp;</td>
                        <td height="25">&nbsp;</td>
                      </tr>
                      <tr>
                        <td width="242" height="25"><strong>Resumen de Ordenes de Turno</strong></td>
                        <td width="410" height="25">Usuario: <?php echo $_SESSION['xyznombre'];?></td>
                        <td width="182" height="25">&nbsp;</td>
                      </tr>
                    </tbody>
                  </table></td>
                  </tr>
                <tr>
                  <td height="19" colspan="3" bgcolor="#FFFFFF"><div class="lineahorizontal" style="background:#EFEFEF;"></div></td>
                  </tr>
                <tr>
                  <td width="408" height="171" bgcolor="#E1583E"><table width="387" border="0" align="center" cellpadding="5" cellspacing="1">
                    <tbody>
                      <tr>
                        <td height="35" colspan="2" align="center" bgcolor="#FFFFFF" class="textoContenido"><strong>ORDENES DE HABITACIÓN</strong></td>
                        </tr>
                      <tr>
                        <td width="87" height="25" bgcolor="#FFFFFF"><span class="textoContenido">Efectivo</span></td>
                        <td width="300" bgcolor="#FFFFFF"><span class="textoContenido">S/ <?php echo number_format($xefectivoh,2);?></span></td>
                        </tr>
                      <tr>
                        <td height="25" bgcolor="#FFFFFF"><span class="textoContenido">Visa</span></td>
                        <td bgcolor="#FFFFFF"><span class="textoContenido">S/ <?php echo number_format($xvisah,2);?></span></td>
                        </tr>
                      <tr>
                        <td height="25" bgcolor="#FFFFFF"><span class="textoContenido">Total</span></td>
                        <td bgcolor="#FFFFFF"><strong><span class="textoContenido">S/ <?php echo number_format($xsumatotalh,2);?></span></strong></td>
                        </tr>
                      </tbody>
                    </table></td>
                  <td width="29" height="171">&nbsp;</td>
                  <td width="413" height="171" bgcolor="#E1583E"><table width="387" border="0" align="center" cellpadding="5" cellspacing="1">
                    <tbody>
                      <tr>
                        <td height="35" colspan="2" align="center" bgcolor="#FFFFFF" class="textoContenido"><strong>ORDENES DE PRODUCTOS</strong></td>
                        </tr>
                      <tr>
                        <td width="87" height="25" bgcolor="#FFFFFF"><span class="textoContenido">Efectivo</span></td>
                        <td width="300" height="25" bgcolor="#FFFFFF"><span class="textoContenido">S/ <?php echo number_format($xefectivo,2);?></span></td>
                        </tr>
                      <tr>
                        <td height="25" bgcolor="#FFFFFF"><span class="textoContenido">Visa</span></td>
                        <td height="25" bgcolor="#FFFFFF"><span class="textoContenido">S/ <?php echo number_format($xvisa,2);?></span></td>
                        </tr>
                      <tr>
                        <td height="25" bgcolor="#FFFFFF"><strong><span class="textoContenido">Total</span></strong></td>
                        <td height="25" bgcolor="#FFFFFF"><strong><span class="textoContenido">S/ <?php echo number_format($xsumatotal,2);?></span></strong></td>
                        </tr>
                      </tbody>
                    </table></td>
                </tr>
                <tr>
                  <td height="30" align="center"></td>
                  <td height="30" align="center">&nbsp;</td>
                  <td height="30" align="center">&nbsp;</td>
                </tr>
                <tr>
                  <td height="30" colspan="3"><div class="lineahorizontal" style="background:#EFEFEF;"></div></td>
                  </tr>
                <tr>
                  <td height="25"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1">
                    <tbody>
                      <tr>
                        <td height="35" colspan="2" align="center" bgcolor="#FFFFFF" class="textoContenido"><strong>TOTAL INGRESOS DE TURNO</strong></td>
                      </tr>
                      <tr>
                        <td width="155" height="25" bgcolor="#FFFFFF"><span class="textoContenido">Efectivo</span></td>
                        <td width="187" bgcolor="#FFFFFF"><span class="textoContenido">S/ <?php echo number_format($xsumatotalingresoefectivo,2);?></span></td>
                      </tr>
                      <tr>
                        <td height="25" bgcolor="#FFFFFF"><span class="textoContenido">Visa</span></td>
                        <td bgcolor="#FFFFFF"><span class="textoContenido">S/ <?php echo number_format($xsumatotalingresovisa,2);?></span></td>
                      </tr>
                      <tr>
                        <td height="25" bgcolor="#FFFFFF"><strong><span class="textoContenido">Total General</span></strong></td>
                        <td bgcolor="#FFFFFF"><span class="textoContenido">S/ <?php echo number_format($xsumatotalingreso,2);?></span></td>
                      </tr>
                    </tbody>
                  </table></td>
                  <td height="25">&nbsp;</td>
                  <td height="25"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1">
                    <tbody>
                      <tr>
                        <td height="35" colspan="2" align="center" bgcolor="#FFFFFF" class="textoContenido"><strong>GASTOS Y COMPRAS (EGRESO)</strong></td>
                      </tr>
                      <tr>
                        <td height="25" bgcolor="#FFFFFF"><span class="textoContenido">Compras</span></td>
                        <td bgcolor="#FFFFFF"><span class="textoContenido">S/ <?php echo number_format($xcompra,2);?></span></td>
                      </tr>
                      <tr>
                        <td width="103" height="25" bgcolor="#FFFFFF"><span class="textoContenido">Gastos</span></td>
                        <td width="239" bgcolor="#FFFFFF"><span class="textoContenido">S/ <?php echo number_format($xgasto,2);?></span></td>
                      </tr>
                      <tr>
                        <td height="25" bgcolor="#FFFFFF"><strong><span class="textoContenido">Total Egresos</span></strong></td>
                        <td bgcolor="#FFFFFF"><span class="textoContenido">S/ <?php echo number_format($xsumaegreso,2);?></span></td>
                      </tr>
                    </tbody>
                  </table></td>
                </tr>
                <tr>
                  <td height="25" colspan="3"><div class="lineahorizontal" style="background:#EFEFEF;"></div></td>
                  </tr>
                <tr>
                  <td height="25"><table width="365" border="0" align="center" cellpadding="5" cellspacing="1">
                    <tbody>
                      <tr>
                        <td width="342" height="35" align="center" bgcolor="#FFFFFF" class="textoContenido"><strong>TOTAL EFECTIVO EN EL TURNO: S/ <?php echo number_format($xsumatotalingresoefectivo - $xsumaegreso,2);?></strong></td>
                      </tr>
                    </tbody>
                  </table></td>
                  <td height="25">&nbsp;</td>
                  <td height="25" align="right"> <a href="include/usuario/prg_cerrar-turno.php?idturno=<?php echo $xidturno.'&idusuario='.$xidusuario ;?>" class="btnrojo" onClick="return confirm('¿Confirma Cerrar el Turno?');"> <i class="fa fa-close"></i> Cerrar Turno </a>&nbsp;</td>
                </tr>
              </tbody>
            </table></td>
            </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td height="25" colspan="3"></td>
    </tr>
    <tr>
      <td height="25" colspan="3"></td>
    </tr>
  </tbody>
</table>

<p>&nbsp; </p>


<script>

/*
//CLIENTES
var barChartDataClientes = {
	labels : ["Regulares","Irregulares","Total: <?php //echo $xregulares + $xirregulares;?>"],
	
	datasets : [
		{
			label: "My Second dataset",
			fillColor : "rgba(56,128,170,0.9)",
			strokeColor : "rgba(220,220,220,0.8)",
			highlightFill: "rgba(220,220,220,0.75)",
			highlightStroke: "rgba(220,220,220,1)",
			//scaleShowLabels: true
			data : [<?php //echo $xregulares;?>,<?php //echo $xirregulares;?>]
		}
	]

}
var ctx = document.getElementById("clientesregulares").getContext("2d");
new Chart(ctx).Bar(barChartDataClientes);
*/


var ctx = document.getElementById("ContratoCumpleNo").getContext("2d");
var pieChartContratoCumple = new Chart(ctx);
var data = [
  {
    value: <?php echo $xcontcumple;?>,
    color:"#006699",
	highlight: "#999999",
    label: "Cumple"
  },
  {
    value: <?php echo $xcontnocumple;?>,
    color: "#F54E1F",
	highlight: "#999999",
    label: "No Cumple"
  },
];

var pie = pieChartContratoCumple.Pie(data, {});




/*
//CONTRATO
var barChartDataCumpleContrato = {
	labels : ["Cumple","No Cumple","Total: <?php //echo $xcontcumple + $xcontnocumple;?>"],
	
	datasets : [
		{
			label: "My Second dataset",
			fillColor : "rgba(56,128,170,0.9)",
			strokeColor : "rgba(220,220,220,0.8)",
			highlightFill: "rgba(220,220,220,0.75)",
			highlightStroke: "rgba(220,220,220,1)",
			//scaleShowLabels: true
			data : [<?php // echo $xcontcumple;?>,<?php //echo $xcontnocumple;?>]
		}
	]

}
var ctx = document.getElementById("contratocumple").getContext("2d");
new Chart(ctx).Bar(barChartDataCumpleContrato);

*/

// CONTRATO REGULADOS
var barChartDataContratoTipo = {
	labels : ["Regulados","No Regulados","Total: <?php echo $xregulados + $xnoregulados;?>"],
	
	datasets : [
		{
			fillColor : "rgba(56,128,170,0.9)",
			strokeColor : "rgba(220,220,220,0.8)",
			highlightFill: "rgba(220,220,220,0.75)",
			highlightStroke: "rgba(220,220,220,1)",
			data : [<?php echo $xregulados;?>,<?php echo $xnoregulados;?>]
		}
	]

}
var ctx = document.getElementById("tipocontrato").getContext("2d");
new Chart(ctx).Bar(barChartDataContratoTipo);

/*
window.onload = function(){
	var ctx = document.getElementById("tipocontrato").getContext("2d");	
	window.myBar = new Chart(ctx).Bar(barChartDataContratoTipo, {
		responsive : true
	});
}
*/

// VENCIMIENTO DE CONTRATOS
var barChartDataContratoVence = {
	labels : ["Vigentes", "Vencidos","Total: <?php echo $xvigentes + $xvencidos;?>"],
	
	datasets : [
		{
			fillColor : "rgba(56,128,170,0.9)",
			strokeColor : "rgba(220,220,220,0.8)",
			highlightFill: "rgba(220,220,220,0.75)",
			highlightStroke: "rgba(220,220,220,1)",
			data : [<?php echo $xvigentes;?>,<?php echo $xvencidos;?>]
		}
	]

}
var ctx = document.getElementById("contratovence").getContext("2d");
new Chart(ctx).Bar(barChartDataContratoVence);

// VENCIMIENTO DE GARANTIAS
var barChartDataGarantiasVence = {
	labels : ["Vigentes","Vencidos","Total: <?php echo $xgarvigentes + $xgarvencidos;?>"],
	
	datasets : [
		{
			fillColor : "rgba(56,128,170,0.9)",
			strokeColor : "rgba(220,220,220,0.8)",
			highlightFill: "rgba(220,220,220,0.75)",
			highlightStroke: "rgba(220,220,220,1)",
			data : [<?php echo $xgarvigentes;?>,<?php echo $xgarvencidos;?>]
		}
	]

}
var ctx = document.getElementById("garantiasvence").getContext("2d");
new Chart(ctx).Bar(barChartDataGarantiasVence);


// POLIZAS VENCIMIENTO
var barChartDataPolizas = {
	labels : ["Vigentes","Vencidas","Total: <?php echo $xpolvigente + $xpolvencidos;?>"],
	
	datasets : [
		{
			fillColor : "rgba(56,128,170,0.9)",
			strokeColor : "rgba(220,220,220,0.8)",
			highlightFill: "rgba(220,220,220,0.75)",
			highlightStroke: "rgba(220,220,220,1)",
			data : [<?php echo $xpolvigente;?>,<?php echo $xpolvencidos;?>]
		}
	]

}
var ctx = document.getElementById("vencepolizas").getContext("2d");
new Chart(ctx).Bar(barChartDataPolizas);


//COBRANZAS
var barChartDataCobranza = {
	labels : ["Por vencer","Vencidas","Total: <?php echo $xcupporvencer + $xcupvencidos;?>"],
	
	datasets : [
		{
			fillColor : "rgba(56,128,170,0.9)",
			strokeColor : "rgba(220,220,220,0.8)",
			highlightFill: "rgba(220,220,220,0.75)",
			highlightStroke: "rgba(220,220,220,1)",
			data : [<?php echo $xcupporvencer;?>,<?php echo $xcupvencidos;?>]
		}
	]

}
var ctx = document.getElementById("cobranzasvence").getContext("2d");
new Chart(ctx).Bar(barChartDataCobranza);



  </script>
</body>
</html>
<?php include ("footer.php") ?>




