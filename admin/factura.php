<?php
include "validar.php";
include "config.php";
include "include/functions.php";
date_default_timezone_set('America/Lima');

/*

//$ubigeo = $mysqli->query("select * from ubigeo group by idregion asc");

//CONTRATOS REGULADOS Y NO REGULADOS
$sqlcregulados = $mysqli->query(" 
select idcontrato, tipocontrato, estado from contrato where estado = 1");
$xregulados = 0;
$xnoregulados = 0;

while($reFila = $sqlcregulados->fetch_row()){
	if($reFila['1'] == 1){
		$xregulados++;  
	}else if ($reFila['1'] == 2){
		$xnoregulados++;
	}
}

////////////////////////////////////////////////////////////////////////////////

//CLIENTES REGULARES E IRREGULARES
$sqlclientesreg = $mysqli->query(" 
select idcliente, condicion from cliente where estado = 1");
$xregulares = 0;
$xirregulares = 0;

while($regFila = $sqlclientesreg->fetch_row()){
	if($regFila['1'] == 1){
		$xregulares++;  
	}else if ($regFila['1'] == 2){
		$xirregulares++;
	}
}

/////////////////////////////////////////////////////////////////////////////////

//VENCIMIENTO DE CONTRATOS
//$diasantes = 60;
//$sqlcontratovence = $mysqli->query(" 
//select idcontrato, fechasta from contrato where fechasta <= date_add(curdate(), interval '$diasantes' day) and estado = 1");
/*
$xporvencer = 0;
$xvencidos = 0;
$xvigentes = 0;
$xhoy = date('Y-m-d');
while($conFila = $sqlcontratovence->fetch_row()){
	$xvence = $conFila['1'];
	if($xvence > $xhoy){
		$xporvencer++; 
				
	}else if ($xvence <= $xhoy){
		$xvencidos++;
	}
	
}

$sqlcontratovence = $mysqli->query(" 
select idcontrato, fechasta from contrato where estado = 1");

$numcontrato = $sqlcontratovence->num_rows;

$xvencidos = 0;
$xvigentes = 0;
$xhoy = date('Y-m-d');

while($conFila = $sqlcontratovence->fetch_row()){
	$xvence = $conFila['1'];
	if($xvence > $xhoy){
		$xvigentes++;
	}else if ($xvence <= $xhoy){
		$xvencidos++;
	}
}

/////////////////////////////////////////////////////////////////////////////////

$xhoy = date('Y-m-d');
$xnuncavence = '0000-00-00';
//VENCIMIENTO DE GARANTIAS

//$diasantes = 60;
/*$sqlgarantiavence = $mysqli->query(" 
select idgarantia, vencimiento from garantia where vencimiento <= date_add(curdate(), interval '$diasantes' day) and vencimiento <> '$xnuncavence'  and  garantia.vencimiento > '$xhoy' and estado = 1");*/



/*
$sqlgarantiavence = $mysqli->query(" 
select idgarantia, vencimiento from garantia where estado = 1");

$xgarvigentes = 0;
$xgarvencidos = 0;
$xhoy = date('Y-m-d');
while($garFila = $sqlgarantiavence->fetch_row()){
	$xvence = $garFila['1'];
	
	if($xvence > $xhoy || $xvence == $xnuncavence){
		$xgarvigentes++; 
				
	}else if ($xvence <= $xhoy){
		$xgarvencidos++;
	}
}

/////////////////////////////////////////////////////////////////////////////////

//VENCIMIENTO DE POLIZAS
/*$diasantes = 60;
$sqlpolizavence = $mysqli->query(" 
select idpoliza, fechahasta from poliza where fechahasta <= date_add(curdate(), interval '$diasantes' day) and estado = 1");
*/


/*
$sqlpolizavence = $mysqli->query(" 
select idpoliza, fechahasta from poliza where estado = 1");

$xpolvigente = 0;
$xpolvencidos = 0;
$xhoy = date('Y-m-d');
while($polFila = $sqlpolizavence->fetch_row()){
	$xvence = $polFila['1'];
	
	if($xvence > $xhoy){
		$xpolvigente++; 
				
	}else if ($xvence <= $xhoy){
		$xpolvencidos++;
	}
	
}

//VENCIMIENTO DE CUPONES
$sqlconfig = $mysqli->query("select idconfig, diasantescupon from  configgeneral where idconfig = 1");
$cFila = $sqlconfig->fetch_row();
$diasantes = $cFila['1'];
$sqlpolizavence = $mysqli->query(" 
select iddetalleaviso, vencimiento from polizadetalleaviso where vencimiento <= date_add(curdate(), interval '$diasantes' day) and estado = 0");
$xcupporvencer = 0;
$xcupvencidos = 0;
$xhoy = date('Y-m-d');
while($polFila = $sqlpolizavence->fetch_row()){
	$xvence = $polFila['1'];
	
	if($xvence > $xhoy){
		$xcupporvencer++; 
				
	}else if ($xvence <= $xhoy){
		$xcupvencidos++;
	}
}

//CONTRATO CUMPLE - NO CUMPLE
$sqlcontcumple = $mysqli->query(" 
select 
	contrato.idcontrato, 
	contrato.estado, 
	contrato.cumple
	from contrato where estado = 1 order by idcontrato asc");

$xcontcumple = 0;
$xcontnocumple = 0;

//Contrato
while($conclFila = $sqlcontcumple->fetch_row()){
	
	$xcumple = $conclFila['2'];
	
	//***Verificar Las Polizas///////////////
	/*
	$xzidcontrato = $conclFila['0'];
	$sqlContratoPoliza = $mysqli->query("	
		SELECT contratorequisito.idrequisito, contratorequisito.idcontrato, contratorequisito.idpoliza, poliza.idpoliza, poliza.fechahasta, poliza.estado
		FROM contratorequisito
		INNER JOIN poliza ON poliza.idpoliza = contratorequisito.idpoliza
		WHERE poliza.estado <>1
		AND poliza.fechahasta <  '$xhoy' and contratorequisito.idcontrato = '$xzidcontrato'
		GROUP BY contratorequisito.idcontrato");
	/////////////////////////////////////////
	$numerocumple = $sqlContratoPoliza->num_rows;
	$sqlContratoPoliza->free(); */
/*	
	if($xcumple == 1){
		$xcontcumple++;	
	}else if($xcumple == 2 ){
		$xcontnocumple++;
	}else{
		$xcontnocumple++;
	}

	
	//echo $xcumple;
	//echo $number;

} //fin contrato


*/

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
      <td width="230" height="25" align="left" valign="top"><?php include ("menu_nav.php"); ?></td>
      <td width="21">&nbsp;</td>
      <td width="1125" valign="top"><table width="850" border="0" cellpadding="0" cellspacing="0">
        <tbody>
          <tr>
            <td width="610" height="30"> <h3> <i class="fa fa-laptop"></i> Factura</h3> <div class="lineahorizontal" style="background:#EFEFEF;"></div> </td>
            <td width="240"> <a href="" class="btnnegro" style="color:#FFFFFF;"> Guardar </a>   <a href="" class="btnnegro" style="color:#FFFFFF;"> Cancelar </a> </td>
          </tr>
          <tr>
            <td height="30" colspan="2"><table width="850" border="0" cellpadding="0" cellspacing="0">
              <tbody>
                <tr>
                  <td width="224" height="30" class="textoContenido">&nbsp;</td>
                  <td width="188" height="30">&nbsp;</td>
                  <td width="193" height="30">&nbsp;</td>
                  <td width="195" height="30">&nbsp;</td>
                  </tr>
                <tr>
                  <td height="30">&nbsp;</td>
                  <td height="30">&nbsp;</td>
                  <td height="30">&nbsp;</td>
                  <td height="30">&nbsp;</td>
                  </tr>
                <tr>
                  <td height="30">&nbsp;</td>
                  <td height="30">&nbsp;</td>
                  <td height="30">&nbsp;</td>
                  <td height="30">&nbsp;</td>
                </tr>
                <tr>
                  <td height="56" valign="top">&nbsp;</td>
                  <td height="56" valign="top">&nbsp;</td>
                  <td height="56" colspan="2" valign="top">&nbsp;</td>
                  </tr>
                <tr>
                  <td height="25">&nbsp;</td>
                  <td height="25">&nbsp;</td>
                  <td height="25">&nbsp;</td>
                  <td height="25">&nbsp;</td>
                </tr>
                <tr>
                  <td height="25">&nbsp;</td>
                  <td height="25">&nbsp;</td>
                  <td height="25">&nbsp;</td>
                  <td height="25">&nbsp;</td>
                </tr>
                <tr>
                  <td height="25" colspan="4">&nbsp;</td>
                </tr>
                <tr>
                  <td height="25">&nbsp;</td>
                  <td height="25">&nbsp;</td>
                  <td height="25">&nbsp;</td>
                  <td height="25">&nbsp;</td>
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
  </tbody>
</table>

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




