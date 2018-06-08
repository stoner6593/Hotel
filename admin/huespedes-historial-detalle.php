<?php
include "validar.php";
include "config.php";
include "include/functions.php";
date_default_timezone_set('America/Lima');
$xidhabitacion = $_GET['idhabitacion'];
$xidalquiler = $_GET['idalquiler'];

//Viene de historial de huespedes
$historia = $_GET['historia'];

$sqlalquiler = $mysqli->query("select
	alquilerhabitacion.idalquiler,
	alquilerhabitacion.idhuesped,
	alquilerhabitacion.idhabitacion,
	alquilerhabitacion.nrohabitacion,
	alquilerhabitacion.tipooperacion,
	alquilerhabitacion.total,
	
	huesped.idhuesped,
	huesped.nombre,
	
	alquilerhabitacion.comentarios,
	alquilerhabitacion.nroorden
	
	from alquilerhabitacion inner join huesped on huesped.idhuesped = alquilerhabitacion.idhuesped
	where alquilerhabitacion.idalquiler = '$xidalquiler' 
	");
	
	$xaFila = $sqlalquiler->fetch_row();
	$xnrohabitacion = $xaFila['3'];
	
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
	where idalquiler = '$xidalquiler' order by idalquilerdetalle asc
	");


$sqlhabitaciontipo = $mysqli->query("select
	habitacion.idhabitacion,
	habitacion.idtipo,
	habitacion.numero,
	habitacion.nrohuespedes,
	habitacion.nroadicional,
		
	habitaciontipo.idtipo,
	habitaciontipo.nombre,
	
	habitaciontipo.preciohoraadicionaluno,
	habitaciontipo.preciohuespedadicionaluno,
	
	habitaciontipo.preciohoraadicionaldos,
	habitaciontipo.preciohuespedadicionaldos,
	
	habitaciontipo.preciodiariouno,
	habitaciontipo.preciohorauno,
	
	habitaciontipo.preciodiariodos,
	habitaciontipo.preciohorados,
	
	habitacion.preciodiariodj,
	habitacion.preciohorasdj,
	
	habitacion.preciodiariovs,
	habitacion.preciohorasvs,
	
	habitacion.costopersonaadicional,
	habitacion.costohoraadicional
	
	
	from habitacion inner join habitaciontipo on habitaciontipo.idtipo = habitacion.idtipo
	where habitacion.idhabitacion = '$xidhabitacion'");
	
	$xhFila = $sqlhabitaciontipo->fetch_row();
	$nroadicional = $xhFila['4']; //Ocupantes Adicionales permitidos
	$xidtipohabitacion = $xhFila['5']; 
	$xtipohabitacion = $xhFila['6']; 
	//$xpreciopordia = 
	//$xprecioporhora = 
	
	
	$fechahoy = Cfecha(date('Y-m-d'));
	
	//CONTROLAR ENTRE SEMANA Y FIN DE SEMANA
	//Domingo=0 - Lunes=1 - Martes=2 - Miercoles=3 - Jueves=4 - Viernes=5 - Sabado=6
	$xhoy = date('Y-m-d H:i:s');
	
	$dia = date('w', strtotime($xhoy));
	$hora = date('H:i',strtotime($xhoy));
	$horamedia = date('H:i', strtotime('08:00'));
	
	//Uso de Switch Case
	switch ($dia) {
	case 0:

		if($hora < $horamedia){
			//echo "Tarifa 2 - Viernes";
			$nombreprecio = "Aplica Precios Fin Semana";
			$xpreciohoraadicional = $xhFila['20'];
			$xpreciohuespedadicional = $xhFila['19'];
			$preciodiario = $xhFila['17'];
			$preciohora = $xhFila['18'];
		}else{
			//echo "Tarifa 1 :: Domingo - Jueves ";
			$nombreprecio = "Aplica Precios Entre Semana";
			$xpreciohoraadicional = $xhFila['20'];
			$xpreciohuespedadicional = $xhFila['19'];
			$preciodiario = $xhFila['15'];
			$preciohora = $xhFila['16'];
		}
		break;
	case 1:
	case 2:
	case 3:
	case 4:
		//echo "Tarifa 1 :: Domingo - Jueves ";
		$nombreprecio = "Aplica Precios Entre Semana";
		$xpreciohoraadicional = $xhFila['20'];
		$xpreciohuespedadicional = $xhFila['19'];
		$preciodiario = $xhFila['15'];
		$preciohora = $xhFila['16'];
		break;
	case 5:
		if($hora < $horamedia){
			//echo "Tarifa 1 :: Domingo - Jueves ";
			$nombreprecio = "Aplica Precios Entre Semana";
			$xpreciohoraadicional = $xhFila['20'];
			$xpreciohuespedadicional = $xhFila['19'];
			$preciodiario = $xhFila['15'];
			$preciohora = $xhFila['16'];
		}else{
			//echo "Tarifa 2 - Viernes";
			$nombreprecio = "Aplica Precios Fin Semana";
			$xpreciohoraadicional = $xhFila['20'];
			$xpreciohuespedadicional = $xhFila['19'];
			$preciodiario = $xhFila['17'];
			$preciohora = $xhFila['18'];
		}
		break;
	case 6:
		//echo "Tarifa 2 - Viernes";
		$nombreprecio = "Aplica Precios Fin Semana";
		$xpreciohoraadicional = $xhFila['20'];
		$xpreciohuespedadicional = $xhFila['19'];
		$preciodiario = $xhFila['17'];
		$preciohora = $xhFila['18'];
		break;
	}
	
	/*
	if($xdia >= 0 && $xdia <= 4){
		//Aplicar Precio Uno
		$nombreprecio = "Aplica Precios Entre Semana";
		$xpreciohoraadicional = $xhFila['20'];
		$xpreciohuespedadicional = $xhFila['19'];
		$preciodiario = $xhFila['15'];
		$preciohora = $xhFila['16'];

		
	} elseif ($xdia >= 5 && $xdia <= 6) {
		//Aplicar Precio Dos
		$nombreprecio = "Aplica Precios Fin Semana";
		$xpreciohoraadicional = $xhFila['20'];
		$xpreciohuespedadicional = $xhFila['19'];
		$preciodiario = $xhFila['17'];
		$preciohora = $xhFila['18'];
	} */
	
	
	
//Consumos *****
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
	where venta.idalquiler = '$xidalquiler'	order by ventadetalle.idventadetalle asc");

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Administrador</title>

<?php include "head-include.php"; ?>

<script>
	function calcularHuespedAdicional(){
		var nroadicional = parseInt(document.form1.txtnrocupanteadicional.value);
		var costoocupanteadicional = parseFloat(document.form1.txtprecioocupanteadicional.value);	
		document.form1.txtimporteocupanteadicional.value = formatCurrency(parseFloat(nroadicional*costoocupanteadicional).toFixed(2));
	} 
	function calcularHoraAdicional(){
		var nrohoraadicional = parseInt(document.form2.txtnrohoraadicional.value);
		var costohoraadicional = parseFloat(document.form2.txtpreciohoraadicional.value);	
		document.form2.txtimportehoraadicional.value = formatCurrency(parseFloat(nrohoraadicional*costohoraadicional).toFixed(2));
	}    
	
</script>


<script language="javascript">
    function objAjax(){
    var req = false;
    try{
    req = new XMLHttpRequest(); /* Para Firefox */
    }catch(error1){
        try{
            req = new ActiveXObject("Msxml2.XMLHTTP"); /* Algunas versiones de IE */
        }catch(error2){
            try{
                req = new ActiveXObject("Microsoft.XMLHTTP"); /* Algunas versiones de IE */
            }catch(error3){
                req = false;
            }
        }
    }
    return req;    
	}

	var req = objAjax();
	
	function ImprimirOrden(){ 
        window.open('imprimir/print_alquiler-orden.php?idhabitacion=<?php echo $xidhabitacion.'&idalquiler='.$xidalquiler;?>','modelo','width=1000, height=350, scrollbars=yes' );
    }
	function PersonasAdicionales(){ 
        window.open('persona-adicional.php?idhabitacion=5&idalquiler=14&nombrecliente=&idcliente=15','modelo','width=1000, height=350, scrollbars=yes' );
    }
	<?php 
		$xtipoalq = $xaFila['4'];
		if($xtipoalq==1){
			$xabrirventa = "ImprimirOrdenHora";
		}elseif($xtipoalq==2){
			$xabrirventa = "ImprimirOrdenDia";
		}
	?>
	
function PendientedePago(){
		var nroadicional = parseFloat(document.frmdeuda.txtpendientepago.value);
		if(nroadicional > 0){
			alert("No puede finalizar mientras hay pendiente de pago.");
			return false;
		}
		return true;
	} 
</script>


<script type="text/javascript" language="javascript">
	$(document).ready(function(){
		$("#mostrar").click(function(){
			$('.div1').show();
			$('.div2').show();
		});
		$("#ocultar").click(function(){
			$('.div1').hide();
			$('.div2').hide();
		});
	});
</script>
    
</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">

    <tr>
      <td height="25" colspan="3"><?php include ("head.php"); ?></td>
    </tr>
    <tr>
      <td width="185" height="25" align="left" valign="top"><?php include ("menu_nav.php"); ?></td>
      <td width="25">&nbsp;</td>
      <td width="793" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
       
          <tr>
            <td width="460" height="30"> <h3 style="color:#E1583E;"> <i class="fa fa-users"></i> Habitación Alquilada (Detalle)</h3></td>
            <td width="203"><span class="textoContenido"><strong>ORDEN #: <?php echo $xaFila['9'];?><span class="textoContenido" style="font-size:28px;color:#E1583E;">
              <input name="txtidalquiler" type="hidden" id="txtidalquiler" value="<?php echo $xidalquiler;?>">
            </span></strong></span></td>
            <td width="242" align="center">  <button type="button" onclick="window.location.href='control-habitaciones.php';" class="btngris" style="border:0px; cursor:pointer;"> <i class="fa fa-arrow-left"></i> Volver </button> </td>
          </tr>
          <tr>
            <td height="30" colspan="3"><table width="100%" border="0" cellpadding="1" cellspacing="1">
             
                <tr>
                  <td width="911" height="30"><div class="lineahorizontal" style="background:#BFBFBF;">
				  
                  <?php if ($_SESSION['msgerror']!=""){ ?>
                  <div class="alert alert-success alert-dismissable textoContenidoMenor">
                  	<?php echo $_SESSION['msgerror'];$_SESSION['msgerror']="";?> 
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  </div>
                  <?php } ?>
                  
                  </div></td>
                </tr>
                <tr>
                  <td height="30">
                    <table width="95%" border="0" cellpadding="1" cellspacing="1">
                        <tr>
                          <td width="315" height="25" align="left" valign="middle"> <h3> <?php echo $xaFila['7'];?> </h3>  <a href="#" onClick="PersonasAdicionales();" class="btnnegro"> Personas Adicionales </a> </td>
                          <td width="266" height="25" align="left" valign="middle"><span class="textoContenido"><strong>Hab. <?php echo $xtipohabitacion;?> #: </strong></span> <span class="textoContenido" style="font-size:28px;color:#E1583E;"><?php echo $xaFila['3'];?>
                              <input name="txtidhabitacion" type="hidden" id="txtidhabitacion" value="<?php echo $xidhabitacion;?>">
                              <span class="textoContenido" style="font-size:28px;color:#00A230;">
                              <input name="txtnrohabitacion" type="hidden" id="txtnrohabitacion" value="<?php echo $xnrohabitacion;?>">
                          </span></span></td>
                          <td width="160" height="25" align="left" valign="middle" class="textoContenido">&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="25" colspan="3" valign="top"><div class="lineahorizontal" style="background:#BFBFBF;"></div></td>
                        </tr>
                        <tr>
                          <td height="30" colspan="3" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="1">
                            <tr class="textoContenido">
                              <td width="6%" height="25" align="center">#</td>
                              <td width="46%" height="25">Concepto</td>
                              <td width="11%" height="25">Precio  (S/ )</td>
                              <td width="10%">Total (S/ )</td>
                              <td width="10%">&nbsp;</td>
                              <td width="13%">&nbsp;</td>
                              <td width="4%" height="25">&nbsp;</td>
                            </tr>
                            <tr>
                              <td height="25" colspan="7"><div class="lineahorizontal" style="background:#00A230;"></div></td>
                            </tr>
                            <?php while ($tmpFila = $sqldetalle->fetch_row()){ $num++; ?>
                            <tr class="textoContenidoMenor">
                              <td height="25" align="center" class="textoContenido"><?php echo $num;?></td>
                              <td height="25"><span class="textoContenido">
                                <?php 
								
								if($tmpFila['12']==1){ //Estado Pago
									$xprecioalquiler = $xprecioalquiler + $tmpFila['20'];
								}elseif($tmpFila['12']==0){
									$precioalquilerpendiente = $precioalquilerpendiente + $tmpFila['20'];
								}
								echo tipoAlquiler($tmpFila['2']).' ('.$tmpFila['19'].')';
								if($tmpFila['2'] != 4 &&  $tmpFila['2'] != 5){
									echo fechadesdehasta($tmpFila['3'],$tmpFila['4']);
								}
								?></span></td>
                              <td height="25" align="center" class="textoContenido"><?php echo number_format($tmpFila['18'],2);?></td>
                              <td height="25" align="center" class="textoContenido"><?php echo number_format($tmpFila['20'],2);?></td>
                              <td height="25" align="center" class="textoContenido"><?php echo estadoPago($tmpFila['12'],2);?></td>
                              <td height="25" align="center" class="textoContenido">
                              
                              <?php if($tmpFila['12']==0){ ?>
                              <a href="include/alquiler/prg_cobrar-adicionales.php?formapago=efectivo&idalquiler=<?php echo $xidalquiler.'&idhabitacion='.$xidhabitacion.'&idalquilerdetalle='.$tmpFila['0'].'&monto='.$tmpFila['20'];?>" onClick="return confirm('¿Confirma pagar con Efectivo?');" class="btnnegro" style="border:0px; padding-left:10px; padding-right:10px; cursor:pointer;"> <i class="fa fa-money fa-lg"></i> </a>
                              <?php } ?>
                              
                              <?php if($tmpFila['12']==0){ ?>
                              <a href="include/alquiler/prg_cobrar-adicionales.php?formapago=visa&idalquiler=<?php echo $xidalquiler.'&idhabitacion='.$xidhabitacion.'&idalquilerdetalle='.$tmpFila['0'].'&monto='.$tmpFila['20'];?>" onClick="return confirm('¿Confirma pagar con Tarjeta?');" class="btnnegro" style="border:0px; padding-left:10px; padding-right:10px; cursor:pointer;"> <i class="fa fa-cc-visa fa-lg"></i> </a>
                              <?php } ?>
                              
                              </td>
                              <td height="25" align="center">
                              
							  	<?php $xidtmp = $tmpFila['0'];?>
                              
                              	<?php if($tmpFila['12']==0){?>                                
								<a href="include/alquiler/prg_alquiler-anular-item.php?iddetalle=<?php echo $xidtmp.'&idalquiler='.$xidalquiler.'&idhabitacion='.$xidhabitacion; ?>" onClick="return confirm('¿Confirma la Anulación?');" class="btnquitar" style="border:0px; cursor:pointer;background:#515151;"> <i class="fa fa-close"></i> </a>                                
                            	<?php } ?>  
                              
                              </td>
                            </tr>
                            <?php } ?>
                          </table></td>
                        </tr>
                        <tr>
                          <td height="52" colspan="3" valign="bottom">&nbsp;</td>
                      </tr>
                        <tr>
                          <td height="30"><table width="100%" border="0" cellpadding="1" cellspacing="1">
                            <tr>
                              <td width="201" height="21" align="left" bgcolor="#FFFFFF" class="textoContenido"> <strong>Consumo</strong></td> 
                              <td width="107" align="right" bgcolor="#FFFFFF">
                              
                              </td>
                            </tr>
                          </table>
                            <table width="100%" border="0" cellpadding="4" cellspacing="1" bgcolor="#E0E0E0">
                            <tr class="textoContenidoMenor">
                              <td width="225" height="25" bgcolor="#F4F4F4">Producto</td>
                              <td width="79" height="25" align="right" bgcolor="#F4F4F4">Precio  (S/)</td>
                              <td width="78" height="25" align="right" bgcolor="#F4F4F4">Importe (S/)</td>
                              </tr>
                            <?php $xprodtotal = 0; $num = 0; while($vFila = $sqlventa->fetch_row()){?>
                            <tr class="textoContenidoMenor">
                              <td height="25" bgcolor="#FFFFFF">(<?php echo $vFila['5']; ?>)  <?php echo $vFila['4']; ?></td>
                              <td height="25" align="right" bgcolor="#FFFFFF"><?php echo $vFila['6']; ?></td>
                              <td height="25" align="right" bgcolor="#FFFFFF"><?php echo $vFila['7']; ?></td>
                              </tr>
                            <?php
							$_SESSION['xcliente']="";
							$_SESSION['xidcliente']=""; 
							
							$xprodtotal = $xprodtotal + $vFila['7']; 
							$num++;
							} 
						?>
                          </table></td>
                          <td height="30" colspan="2"><table width="100%" border="0" align="right" cellpadding="1" cellspacing="1">
                            <tbody>
                              <tr>
                                <td width="395" height="25"><form id="frmcomentario" name="frmcomentario" method="post" action="include/alquiler/prg_anotaciones.php?idhabitacion=<?php echo $xidhabitacion.'&idalquiler='.$xidalquiler;?>">
                                  <table width="396" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tbody>
                                      <tr>
                                        <td width="352" height="25"><?php echo $xaFila['8'];?></td>
                                        <td width="44" height="25">&nbsp;</td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </form></td>
                              </tr>
                            </tbody>
                          </table></td>
                        </tr>
                        <tr>
                          <td height="30" colspan="3"><div class="lineahorizontal" style="background:#FFAF03;"> </div></td>
                        </tr>
                        <tr>
                          <td height="30" colspan="3"><table width="100%" border="0" cellspacing="1" cellpadding="1">
                            <tbody>
                              <tr class="textoContenido">
                                <td width="21%" height="24"><strong>Resumen del Cliente</strong></td>
                                <td width="17%" height="24">Habitación: S/ <strong><?php echo number_format($xprecioalquiler,2);?></strong></td>
                                <td width="18%" height="24">Consumo: S/ <?php echo number_format($xprodtotal,2);?></td>
                                <td width="21%" height="24"><strong>Importe Total: S/ <?php echo number_format(($xprecioalquiler + $xprodtotal),2) ?></strong></td>
                                <td width="23%" height="24"> 
                                <form name="frmdeuda" id="frmdeuda">
                                <span style="color:#E1583E; font-weight:600;"> Pendiente de Pago: S/ <?php echo number_format($precioalquilerpendiente,2); ?> </span> <input name="txtpendientepago" type="hidden" id="txtpendientepago" value="<?php echo $precioalquilerpendiente;?>">
                                </form>
                                </td>
                              </tr>
                            </tbody>
                          </table></td>
                        </tr>
                        <tr>
                          <td height="30" colspan="3"><div class="lineahorizontal" style="background:#FFAF03;"> </div></td>
                        </tr>
                        <tr>
                          <td height="30" colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="1">
                            <tbody>
                              <tr>
                                <td width="276" height="30" align="left" valign="middle">

                                <a href="#" onClick="ImprimirOrden(); return false" class="btnrojo"> <i class="fa fa-print"></i> Imprimir </a> 
                                <a href="control-habitaciones.php" class="btnnegro"> <i class="fa fa-close"></i> Salir </a> 
                                
                                </td>
                                <td width="620" height="30" align="right" valign="middle">&nbsp;</td>
                              </tr>
                            </tbody>
                          </table></td>
                        </tr>
                     
                    </table>
                  </td>
                </tr>
             
            </table></td>
            </tr>
  
      </table></td>
    </tr>
    <tr>
      <td height="25" colspan="3"></td>
    </tr>

</table>
<p>&nbsp;</p>

<!-- Load MODAL MSG JS 
<script type='text/javascript' src='modalmsg/jquery.js'></script>
<script type='text/javascript' src='modalmsg/jquery.simplemodal.js'></script>
<script type='text/javascript' src='modalmsg/confirm.js'></script> -->
</body>
</html>
<?php include ("footer.php") ?>




