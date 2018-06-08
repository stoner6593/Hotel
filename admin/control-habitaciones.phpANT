<?php
session_start();
include "validar.php";
include "config.php";
include "include/functions.php";
date_default_timezone_set('America/Lima');

$sqlhabitacion = $mysqli->query("select 
	habitacion.idhabitacion,
	habitacion.idtipo,
	habitacion.idestado,
	habitacion.piso,
	habitacion.numero,
	habitacion.preciodiariodj,
	habitacion.preciohorasdj,
	habitacion.nrohuespedes,
	habitacion.caracteristicas,
	
	habitaciontipo.idtipo,
	habitaciontipo.nombre,
	habitacionestado.idestado,
	habitacionestado.estado,
	habitacionestado.color,
	
	habitacion.idalquiler,
	habitacion.nroadicional,
	habitacion.ubicacion,
	
	habitacion.preciodiariovs,
	habitacion.preciohorasvs
	
	from habitacion inner join habitaciontipo on habitaciontipo.idtipo = habitacion.idtipo
					inner join habitacionestado on habitacionestado.idestado = habitacion.idestado
	order by habitacion.idhabitacion asc");

	
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Administrador</title>

<?php include "head-include.php"; ?>
<link rel="stylesheet" type="text/css" href="abc.css">

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
      <td width="810" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tbody>
          <tr>
            <td height="30" colspan="6"><h3 style="color:#E1583E;"> <i class="fa fa-users"></i> Control de Habitaciones </h3> </td>
            </tr>
          <tr>
            <td height="30" colspan="6"><div class="lineahorizontal" style="background:#BFBFBF;"></div></td>
            </tr>
          <tr>
            <td height="30" colspan="6" align="center" valign="middle">
            
            <div class="grupo">
            
            	<?php 
				while($xhFila = $sqlhabitacion->fetch_row()){ 
				$xidalquiler = $xhFila['14'];
				$sqlalquiler = $mysqli->query("select idalquiler, fechafin from alquilerhabitacion where idalquiler = '$xidalquiler'");
				$aFila = $sqlalquiler->fetch_row();
				//$que = tipoAlquiler($aFila['2']);

				?>
            	<div class="caja tablet-20" style="background:#FFFFFF;">
                	<?php
                    	//Casos de Link
						if($xhFila['2']==1 || $xhFila['2']==4){ //Controlar Estados
							$link = "alquilar.php?idhabitacion=".$xhFila['0'].'&nrohabitacion='.$xhFila['4'].'&xestado='.$xhFila['11'].'&idtipohab='.$xhFila['1'];
						}else if($xhFila['2']==2){
							$link = "alquilar-detalle.php?idhabitacion=".$xhFila['0'].'&idalquiler='.$xidalquiler;
						}
					?>
                	<a href="<?php echo $link; ?>">
                    <div style="width:100%; background:#<?php echo $xhFila['13'] ?>; padding:0px; -webkit-border-radius: 0px;-moz-border-radius: 0px;border-radius: 0px;">
                	  
                      <table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#<?php echo $xhFila['13'] ?>">
                        <tr>
                          <td width="39%" height="43" align="center" valign="middle" bgcolor="#FFFFFF">
                          
                          <h2 style="color:#<?php echo $xhFila['13'] ?>; text-align:center; margin:0px;padding:0px;"> <?php echo $xhFila['4'] ?> </h2> <span class="textoContenidoMenor" style="color:#<?php echo $xhFila['13'] ?>;"> <?php echo habitacionIcono($xhFila['1']);?> </span> </td>
                          <td width="61%" align="center" valign="middle" bgcolor="#FFFFFF">
                          <span class="textoContenidoMenor" style="color:#<?php echo $xhFila['13'] ?>; font-size:10px;">
                          
                              <?php if($aFila['2']!=""){ echo $que; }else{ echo $xhFila['12']; } ?>
                              
                          </span> <br>
                          <span class="textoContenidoMenor" style="color:#<?php echo $xhFila['13'] ?>; text-align:center; margin:0px;padding:0px;font-size:10px;"><?php echo $xhFila['10']; if($xhFila['16']==1){ echo "&nbsp; "."<i class='fa fa-th-large fa-lg'></i>";} ?></span></td>
                        </tr>
                        <tr>
                          <td height="25" colspan="2" align="center" valign="top" bgcolor="">
                          
                          <?php 
						  	$fechafin = date($aFila['1']); //Fecha Hora Fin
							$fechahoy = date("Y-m-d H:i:s");  //date("2017-08-05 09:57:27"); //Fecha Hora del Sistema
							$minutos = ceil((strtotime($fechafin) - strtotime($fechahoy)) / 60);
 							//echo $minutos;
							
							//if ($minutos <= 15) {
							//	 echo 'Menos de 15 minutos de diferencia';
							//}

						  ?>
                          
                          <div class="textoContenidoMenor" style="color:#FFFFFF; <?php if($fechafin !="" && $minutos <= 15) { echo "background:#000000;";}?> padding:0px; margin:0px; width:100%; height:100%; text-align:center;">
                          
                            <?php 
							$fecha = strtotime($aFila['1']);
							$fechafin = Cfecha(date("Y-m-d",$fecha));
							$finhora = date("H:i",$fecha);
							
							if($aFila['1']!=""){
								echo 'Fin: '.$fechafin.' - '.$finhora; 
							}
							?>
                            
                          </div>
                          
                           
                          
                          </td>
                        </tr>
                      </table>
                
                    </div>
                    </a>
                    <div class="separadorsolo" style="margin-top:5px; margin-bottom:5px;"></div>
                </div>
                <?php 
					} 
					$sqlhabitacion->free();
				?>

            </div>
            
            </td>
            </tr>
          <tr>
            <td width="166" height="30"><a href="#" class="btnceleste" style="width:60%; color:#FFFFFF;"> 301 </a></td>
            <td width="166" height="30"><a href="#" class="btnverde" style="width:60%; color:#FFFFFF;"> 301 </a></td>
            <td width="166" height="30"><a href="#" class="btnverde" style="width:60%; color:#FFFFFF;"> 301 </a></td>
            <td width="166" height="30"><a href="#" class="btnverde" style="width:60%; color:#FFFFFF;"> 301 </a></td>
            <td width="166" height="30"><a href="#" class="btnverde" style="width:60%; color:#FFFFFF;"> 301 </a></td>
            <td width="179" height="30"><a href="#" class="btnverde" style="width:60%; color:#FFFFFF;"> 301 </a></td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td height="25" colspan="3"><table width="555" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="10" height="10" align="left" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
          <td width="10" height="10" align="left" valign="middle" bgcolor="#00A230">&nbsp;</td>
          <td width="80" height="10" align="left" valign="middle">&nbsp;<span class="textoContenidoMenor">Disponible</span></td>
          <td width="10" height="10" align="left" valign="middle" bgcolor="#E1583E">&nbsp;</td>
          <td width="73" height="10" align="left" valign="middle">&nbsp;<span class="textoContenidoMenor">Ocupado</span></td>
          <td width="10" height="10" align="left" valign="middle" bgcolor="#FFAF03">&nbsp;</td>
          <td width="91" height="10" align="left" valign="middle">&nbsp;<span class="textoContenidoMenor">Reservado</span></td>
          <td width="10" height="10" align="left" valign="middle" bgcolor="#44A6ED">&nbsp;</td>
          <td width="105" height="10" align="left" valign="middle">&nbsp;<span class="textoContenidoMenor">Mantenimiento</span></td>
          <td width="10" height="10" align="left" valign="middle" bgcolor="#333333">&nbsp;</td>
          <td width="146" height="10" align="left" valign="middle">&nbsp;<span class="textoContenidoMenor">No Disponible</span></td>
        </tr>
        <tr>
          <td width="10" bgcolor="#FFFFFF"></td>
          <td width="10" height="25"></td>
          <td width="80" height="25"></td>
          <td width="10" height="25"></td>
          <td width="73" height="25"></td>
          <td width="10" height="25"></td>
          <td width="91" height="25"></td>
          <td width="10"></td>
          <td width="105"></td>
          <td width="10" height="25"></td>
          <td width="146" height="25"></td>
        </tr>
      </table></td>
    </tr>
  </tbody>
</table>
<?php include "footer.php"; ?>
</body>
</html>





