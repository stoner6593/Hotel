<?php
include "validar.php";
include "config.php";
include "include/functions.php";
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
<title>Administrador</title>
<link href="opera.css" rel="stylesheet" type="text/css">

<?php include "head-include.php"; ?>

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
    function ImprimirVentaOrden(){
        window.open('imprimir/print_venta-orden.php?xidventa=<?php echo $xidventa;?>','modelo','width=350, height=500, scrollbars=yes' );
    } 
</script>

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
      <td width="1125" valign="top"><table width="904" border="0" cellpadding="0" cellspacing="0">
        <tbody>
          <tr>
            <td width="729" height="30"><h3 style="color:#E1583E;"> <i class="fa fa-shopping-basket"></i> Venta  Productos</h3></td>
            <td width="175" align="right" valign="middle">
			<?php if($detalle==1){?>            
            <button type="button" onclick="window.location.href='venta-listado.php';" class="btngris" style="border:0px; cursor:pointer;"> <i class="fa fa-arrow-left"></i> Volver </button>
            <?php } ?>
            </td>
          </tr>
          <tr>
            <td height="30" colspan="2">  <div class="lineahorizontal" style="background:#EFEFEF;"></div> </td>
          </tr>
          <tr>
            <td height="30" colspan="2"><table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
              <tbody>
                <tr>
                  <td height="25" colspan="2"> <h2> <span style="color:#00A230;"> <?php if($xguardado==1){ echo 'Venta Completada!'; }else{echo 'Detalle de Ticket!';}?></span> </h2> </td>
                  <td height="25" colspan="2" align="center"><h3>Número: <strong><?php echo $vFila['1'];?></strong></h3></td>
                  </tr>
                <tr>
                  <td height="25" colspan="4"><table width="600" border="0" cellpadding="4" cellspacing="1" bgcolor="#E0E0E0">
                    <tr class="textoContenidoMenor">
                      <td width="329" height="25" bgcolor="#F4F4F4">Producto</td>
                      <td width="49" height="25" bgcolor="#F4F4F4">Cantidad</td>
                      <td width="85" height="25" align="right" bgcolor="#F4F4F4">P. Unitario (S/)</td>
                      <td width="100" height="25" align="right" bgcolor="#F4F4F4">Importe (S/)</td>
                      </tr>
                    <?php $xtotal = 0; while($tmpFila = $sqldetalle->fetch_row()){?>
                    <tr class="textoContenidoMenor">
                      <td height="25" bgcolor="#FFFFFF"><?php echo $tmpFila['3']; ?></td>
                      <td height="25" align="center" bgcolor="#FFFFFF"><?php echo $tmpFila['4']; ?></td>
                      <td height="25" align="right" bgcolor="#FFFFFF"><?php echo $tmpFila['5']; ?></td>
                      <td height="25" align="right" bgcolor="#FFFFFF"><?php echo number_format($tmpFila['6'],2); ?></td>
                      </tr>
                    <?php $xtotal = $xtotal + $tmpFila['5']; } ?>
                    </table></td>
                </tr>
                <tr>
                  <td width="224" height="25">&nbsp;</td>
                  <td width="188" height="25">&nbsp;</td>
                  <td width="193" height="25">&nbsp;</td>
                  <td width="193" height="25" class="textoContenido">&nbsp;</td>
                  </tr>
                <tr>
                  <td height="25" class="textoContenido">Tipo de Operación</td>
                  <td height="25" class="textoContenido">Forma de Pago</td>
                  <td height="25"><span class="textoContenido">Estado </span></td>
                  <td height="25" class="textoContenido">Total Pagado </td>
                  </tr>
                <tr>
                  <td height="25" class="textoContenido"><strong><?php echo tipoOperacion($vFila['6']);?></strong></td>
                  <td height="25" class="textoContenido"><strong><?php echo formaPago($vFila['7']);?></strong></td>
                  <td height="25" align="right" class="textoContenido"><strong><?php echo estadoPago($vFila['8']);?></strong></td>
                  <td height="25" class="textoContenido"><strong>S/ <?php echo number_format($vFila['5'],2);?></strong></td>
                  </tr>
                <tr>
                  <td height="25" colspan="4"><div class="lineahorizontal" style="background:#EFEFEF;"></div></td>
                  </tr>
                <tr>
                  <td height="30" class="textoContenido">Cliente</td>
                  <td height="30">&nbsp;</td>
                  <td height="30"><span class="textoContenido">Fecha / Hora</span></td>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td height="30" colspan="2"><strong><span class="textoContenido"><?php echo $vFila['2'];?></span></strong></td>
                  <td height="30" class="textoContenido"><strong><?php echo Cfecha($vFila['3']);?></strong>  <br></td>
                  <td class="textoContenido"><?php echo $vFila['4'];?></td>
                  </tr>
                <tr>
                  <td height="25" colspan="4">
                  <?php if($vFila['8']==0){?>
                  <p class="textoContenido"> <span style="color:#E1583E;"> Motivo de Anulación: </span> <?php echo $vFila['11'];?> </p>
                  <?php } ?>
                  <div class="lineahorizontal" style="background:#EFEFEF;"></div>
                  </td>
                  </tr>
                <tr>
                  <td height="25" colspan="2"> 

                    <a href="#" onClick="return ImprimirVentaOrden();" class="btnrojo"> <i class="fa fa-print"></i> Imprimir </a>
                                       
                    <?php if($detalle != 1){?>
                    	<?php 
						$xidalquiler = $_GET['idalquiler'];
						$xidhabitacion = $_GET['idhabitacion'];	
						if($xidalquiler != ""){ ?>
						<button type="button" onclick="window.location.href='alquilar-detalle.php?idalquiler=<?php echo $xidalquiler.'&idhabitacion='.$xidhabitacion; ?>';" class="btnnegro" style="border:0px; cursor:pointer;"> <i class="fa fa-remove"></i> Salir </button>                        
                    	<?php }else{ ?>    
                    	<button type="button" onclick="window.location.href='venta.php';" class="btnnegro" style="border:0px; cursor:pointer;"> <i class="fa fa-remove"></i> Salir </button>
                    <?php 
						}
						} 
					?>
                    
                    </td>
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

</body>
</html>
<?php include ("footer.php") ?>




