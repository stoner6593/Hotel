<?php
include "validar.php";
include "config.php";
include "include/functions.php";
date_default_timezone_set('America/Lima');
$xidhabitacion = $_GET['idhabitacion'];
$xidalquiler = $_GET['idalquiler'];
$xidtipohabitacion = $_GET['idtipohabitacion'];

$sqlalquiler = $mysqli->query("select 
	alquilerhabitacion.idalquiler,
	alquilerhabitacion.idhuesped,
	alquilerhabitacion.idhabitacion,
	alquilerhabitacion.nrohabitacion,
	alquilerhabitacion.nroorden,
	
	huesped.idhuesped,
	huesped.nombre
	
	from alquilerhabitacion inner join huesped on huesped.idhuesped = alquilerhabitacion.idhuesped 
	where alquilerhabitacion.idalquiler = '$xidalquiler' and alquilerhabitacion.idhabitacion = '$xidhabitacion' ");

$xaFila = $sqlalquiler->fetch_row();


$sqlhabitaciontipo = $mysqli->query("select
	idtipo,
	nombre
	from habitaciontipo
	where idtipo = '$xidtipohabitacion'");
	
	$xhFila = $sqlhabitaciontipo->fetch_row();
	$xtipohabitacion = $xhFila['1']; 

	
$sqlhabitacion = $mysqli->query("select 
	idhabitacion,
	numero,
	idtipo,
	idestado
	
	from habitacion 
	where idhabitacion <> '$xidhabitacion' and  idestado = 1
	order by numero asc");	//idtipo = '$xidtipohabitacion' and agregar esta linea para que muestre las habitaciones dependiendo el tipo
	
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Administrador</title>

<?php include "head-include.php"; ?>

<script>
	
	function validarDatos() { 
	
		if (espacioVacio(document.form1.txtmotivoanulacion.value) == false ) {  
		alert("Ingrese el motivo de la anulación."); 
		document.form1.txtmotivoanulacion.focus();
		return false  
		}
	
		return true; 
	}

</script>

    
</head>
<body  OnLoad="form1.txtmotivoanulacion.focus()">

<table width="100%" border="0" cellpadding="0" cellspacing="0">

    <tr>
      <td height="25" colspan="3"><?php include ("head.php"); ?></td>
    </tr>
    <tr>
      <td width="230" height="25" align="left" valign="top"><?php include ("menu_nav.php"); ?></td>
      <td width="21">&nbsp;</td>
      <td width="1125" valign="top"><table width="900" border="0" cellpadding="0" cellspacing="0">
       
          <tr>
            <td width="460" height="30"> <h3 style="color:#E1583E;"> <i class="fa fa-users"></i> Cambiar de Habitación</h3></td>
            <td width="203"><span class="textoContenido"><strong>ORDEN #: <?php echo $xaFila['4'];?></strong></span></td>
            <td width="242" align="right">  <button type="button" onclick="window.location.href='alquilar-detalle.php?idalquiler=<?php echo $xidalquiler.'&idhabitacion='.$xidhabitacion;?>';" class="btngris" style="border:0px; cursor:pointer;"> <i class="fa fa-arrow-left"></i> Volver </button> </td>
          </tr>
          <tr>
            <td height="30" colspan="3"><table width="905" border="0" cellpadding="1" cellspacing="1">
             
                <tr>
                  <td height="30"><div class="lineahorizontal" style="background:#BFBFBF;">
				  
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
                    <table width="900" border="0" cellpadding="1" cellspacing="1">
                        <tr>
                          <td width="381" height="25" align="left" valign="middle"> <h3> <?php echo $xaFila['6'];?></h3>  </td>
                          <td width="252" height="25" align="left" valign="middle"><span class="textoContenido"><strong>Hab. <?php echo $xtipohabitacion;?> #: </strong></span> <span class="textoContenido" style="font-size:28px;color:#E1583E;"><?php echo $xaFila['3'];?>
                              <input name="txtidhabitacion" type="hidden" id="txtidhabitacion" value="<?php echo $xidhabitacion;?>">
                              <span class="textoContenido" style="font-size:28px;color:#00A230;">
                              <input name="txtnrohabitacion" type="hidden" id="txtnrohabitacion" value="<?php echo $xnrohabitacion;?>">
                              </span></span></td>
                          <td width="257" height="25" align="left" valign="middle" class="textoContenido"><strong># Ocupantes: <?php echo $xaFila['12'];?></strong></td>
                        </tr>
                        <tr>
                          <td height="25" colspan="3" valign="top"><div class="lineahorizontal" style="background:#BFBFBF;"></div></td>
                        </tr>
                        <tr>
                          <td height="30" colspan="3" valign="top">
                          <form id="form1" name="form1" method="post" action="include/alquiler/prg_alquiler-cambiarhabitacion.php?idalquiler=<?php echo $xidalquiler.'&idhabitacion='.$xidhabitacion.'&idtipohabitacion='.$xidtipohabitacion; ?>">
                            <table width="834" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tbody>
                                <tr>
                                  <td width="259" height="25" class="textoContenido">Seleccione la habitación por el que desea cambiar</td>
                                  <td width="308">
							<?php
                            echo "<select name='txthabitacion' class='textbox' >";             
                            while ($xhFila = $sqlhabitacion->fetch_row()){
                                 echo "<option value=\"".$xhFila['0']."\">".'Habitación: '.$xhFila['1']."</option>";
                            }
							echo "</select>";
                            $sqlhabitacion->free();
                            ?></td>
                                  <td width="267" height="25">
                                  <button type="submit" class="btnnegro" style="border:0px; cursor:pointer;" > <i class="fa fa-save"></i> Confirmar Cambio de Habitación</button>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </form></td>
                        </tr>
                        <tr>
                          <td height="30"><div class="lineahorizontal" style="background:#00A230;"></div></td>
                          <td height="30" colspan="2" align="right"><div class="lineahorizontal" style="background:#FFAF03;"></div></td>
                        </tr>
                        <tr>
                          <td height="30" colspan="3">&nbsp;</td>
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

<!-- Load MODAL MSG JS 
<script type='text/javascript' src='modalmsg/jquery.js'></script>
<script type='text/javascript' src='modalmsg/jquery.simplemodal.js'></script>
<script type='text/javascript' src='modalmsg/confirm.js'></script> -->
</body>
</html>
<?php include ("footer.php") ?>




