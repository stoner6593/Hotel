<?php
include "validar.php";
include "config.php";
include "include/functions.php";
date_default_timezone_set('America/Lima');

$xidprimario = $_GET['idprimario'];
$xestado = $_GET['estado'];


$sqlproducto = $mysqli->query("select
	idproducto,
	codigo,
	nombre,
	cantidad,
	cantidadminima,
	precio,
	precioventa,
	descripcion,
	estado
	
	from producto 
	where idproducto = '$xidprimario'");
$xpFila = $sqlproducto->fetch_row();


?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Administrador</title>
<?php include "head-include.php";?>

</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">

    <tr>
      <td height="25" colspan="3"><?php include ("head.php"); ?></td>
    </tr>
    <tr>
      <td width="230" height="25" align="left" valign="top"><?php include ("menu_nav.php"); ?></td>
      <td width="21">&nbsp;</td>
      <td width="1125" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
       
          <tr>
            <td width="701" height="30"> <h3> <i class="fa fa-users"></i> Productos / Editor</h3></td>
            <td width="203" align="right"> <button type="button" onclick="window.location.href='productos.php';" class="btngris" style="border:0px; cursor:pointer;"> <i class="fa fa-arrow-left"></i> Volver </button> </td>
          </tr>
          <tr>
            <td height="30" colspan="2"><table width="100%" border="0" cellpadding="1" cellspacing="1">
             
                <tr>
                  <td height="30"><div class="lineahorizontal" style="background:#EFEFEF;"></div></td>
                </tr>
                <tr>
                  <td height="30"><form id="form1" name="form1" method="post" action="<?php if($xestado=='modifica'){echo 'include/producto/prg_producto-modifica.php';}else{echo 'include/producto/prg_producto-nuevo.php';}?>">
                    <table width="100%" border="0" cellpadding="1" cellspacing="1">
                      <tbody>
                        <tr>
                          <td width="224" height="30" class="textoContenido">Nombre
                          <input name="txtidprimario" type="hidden" id="txtidprimario" value="<?php echo $xpFila['0'];?>"></td>
                          <td width="195" height="30">&nbsp;</td>
                          <td width="193"><span class="textoContenido">Código (Código de Barras)</span></td>
                        </tr>
                        <tr>
                          <td height="30" colspan="2"><input name="txtnombre" type="text" class="textbox" value="<?php echo $xpFila['2'];?>" ></td>
                          <td><input name="txtcodigo" type="text" class="textbox" id="txtcodigo"  onKeyPress="return soloNumero(event)" value="<?php echo $xpFila['1'];?>"></td>
                        </tr>
                        <tr>
                          <td width="224" height="30"><span class="textoContenido">Cantidad / Stock</span></td>
                          <td width="195" height="30"><span class="textoContenido">Precio de Venta</span></td>
                          <td height="30">&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="30"><input name="txtcantidad" type="text" class="textbox"  onKeyPress="return soloNumero(event)" value="<?php echo $xpFila['3'];?>" maxlength="5" <?php if($_SESSION['xyztipo']!=1){echo 'readonly';}?> ></td>
                          <td height="30"><input name="txtprecioventa" type="text" class="textbox" value="<?php echo $xpFila['6'];?>" style="text-align:right;"></td>
                          <td height="30" valign="top">&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="25"><span class="textoContenido">Descripción</span></td>
                          <td height="25">&nbsp;</td>
                          <td height="25">&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="25" colspan="3"><textarea name="txtdescripcion" id="txtdescripcion" class="textbox" style="width:98%;"><?php echo $xpFila['7'];?></textarea></td>
                        </tr>
                        <tr>
                          <td height="25">&nbsp;</td>
                          <td height="25">&nbsp;</td>
                          <td height="25">&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="10">
                            
                            <?php if($xestado=="modifica"){?>
                            <button type="submit" class="btnrojo" style="border:0px; cursor:pointer;"> <i class="fa fa-refresh"></i> Actualizar </button>
                            <?php }else{?>
                            <button type="submit" class="btnnegro" style="border:0px; cursor:pointer;"> <i class="fa fa-save"></i> Guardar </button>
                            <?php } ?>
                            
                          <button type="button" onclick="window.location.href='productos.php';" class="btnnegro" style="border:0px; cursor:pointer;"> <i class="fa fa-remove"></i> Cancelar </button></td>
                          <td height="10">&nbsp;</td>
                          <td height="10">&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="25">&nbsp;</td>
                          <td height="25">&nbsp;</td>
                          <td height="25">&nbsp;</td>
                        </tr>
                      </tbody>
                    </table>
                    <table width="900" border="0" cellpadding="1" cellspacing="1">
                    <tbody>
                      <tr>                        </tr>
                    </tbody>
                    </table>
                  </form></td>
                </tr>
             
            </table></td>
            </tr>
  
      </table></td>
    </tr>
    <tr>
      <td height="25" colspan="3"></td>
    </tr>

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




