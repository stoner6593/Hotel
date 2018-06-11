<?php
include "validar.php";
include "config.php";
include "include/functions.php";
date_default_timezone_set('America/Lima');

$xidprimario = $_GET['idprimario'];
$xestado = $_GET['estado'];

$sqlhabitaciontipo = $mysqli->query("select 
	idtipo,
	nombre
	from habitaciontipo order by idtipo asc");

$sqlhabitacionestado = $mysqli->query("select 
	idestado,
	estado
	from habitacionestado order by idestado asc");

$sqlhabitacion = $mysqli->query("select 
	habitacion.idhabitacion,
	habitacion.idtipo,
	habitacion.idestado,
	habitacion.piso,
	habitacion.numero,
	habitacion.preciodiariodj,
	habitacion.preciohorasdj,
	habitacion.preciodiariovs,
	habitacion.preciohorasvs,
	habitacion.nrohuespedes,
	habitacion.caracteristicas,
	habitacion.nroadicional,
	habitacion.ubicacion,
	
	habitacion.costopersonaadicional,
	habitacion.costohoraadicional,
  habitacion.precio12,
  habitacion.precio12vs

	
	from habitacion 
	where habitacion.idhabitacion = '$xidprimario'");

$xhFila = $sqlhabitacion->fetch_row();
	
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Administrador</title>

<?php include "head-include.php"; ?>

</head>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">

    <tr>
      <td height="25" colspan="3"><?php include ("head.php"); ?></td>
    </tr>
    <tr>
      <td width="230" height="25" align="left" valign="top"><?php include ("menu_nav.php"); ?></td>
      <td width="21">&nbsp;</td>
      <td width="1125" valign="top"><table width="900" border="0" cellpadding="0" cellspacing="0">
       
          <tr>
            <td width="729" height="30"> <h3 style="color:#E1583E;"> <i class="fa fa-hotel"></i> Habitaciones / Editor</h3></td>
            <td width="175" align="right"> <button type="button" onclick="window.location.href='habitaciones.php';" class="btngris" style="border:0px; cursor:pointer;"> <i class="fa fa-arrow-left"></i> Volver </button> </td>
          </tr>
          <tr>
            <td height="30" colspan="2"><table width="905" border="0" cellpadding="1" cellspacing="1">
             
                <tr>
                  <td height="30"><div class="lineahorizontal" style="background:#BFBFBF;"></div>
                  
                  
                  
                  </td>
                </tr>
                <tr>
                  <td height="30"><form id="form1" name="form1" method="post" action="<?php if($xestado=="modifica"){echo 'include/habitacion/prg_habitacion-modifica.php';}else{echo 'include/habitacion/prg_habitacion-nuevo.php';}?>">
                    <table width="900" border="0" cellpadding="1" cellspacing="1">
                    
                      <tr>                        </tr>
                  
                    </table>
                    <table width="900" border="0" cellpadding="1" cellspacing="1">
                      <tbody>
                        <tr>
                          <td width="202" height="25" class="textoContenido">Piso
                          <input name="txtidprimario" type="hidden" id="txtidprimario" value="<?php echo $xhFila['0'];?>"></td>
                          <td width="225" height="25"><span class="textoContenido">Número</span></td>
                          <td width="211" height="25"><span class="textoContenido">Tipo de Habitación</span></td>
                          <td width="249" height="25"><span class="textoContenidoMenor">Nro Huéspedes </span></td>
                        </tr>
                        <tr>
                          <td width="202" height="25">
                          <select name="txtpiso" id="txtpiso" class="textbox">
                            <option>1</option>
                            <option selected="selected">2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                            <option>6</option>
                            <option>7</option>
                            <option>8</option>
                            <option>9</option>
                            <option>10</option>
                          </select></td>
                          <td width="225" height="25"><input name="txtnumero" type="text" class="textbox" value="<?php echo $xhFila['4'];?>" <?php if($xestado=='modifica'){echo 'readonly';}?> ></td>
                          <td width="211" height="25">
							<?php
                            echo "<select name='txttipo' class='textbox' >";             
                            while ($xtFila = $sqlhabitaciontipo->fetch_row()){
                                if ($xhFila['1'] == $xtFila['0']){
                                    echo "<option value=\"".$xtFila['0']."\" selected=\"selected\">".$xtFila['1']."</option>";
                                }else{	
                                    echo "<option value=\"".$xtFila['0']."\">".$xtFila['1']."</option>";
                                }
                            }
							echo "</select>";
                            $sqlhabitaciontipo->free();
                            ?>
                          </span></td>
                          <td width="249" height="25"><input name="txtnrohuespedes" type="text" class="textbox" id="txthuespedmaximo4" value="<?php echo $xhFila['9'];?>"></td>
                        </tr>
                        <tr>
                          <td width="202" height="25"><span class="textoContenidoMenor">Huéspedes Adicionales</span></td>
                          <td width="225" height="25">&nbsp;</td>
                          <td width="211" height="25">&nbsp;</td>
                          <td width="249" height="25">&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="25" valign="top"><input name="txtnroadicional" type="text" class="textbox" id="txtnroadicional" style="width:85%" value="<?php echo $xhFila['11'];?>"></td>
                          <td height="25" colspan="3" valign="top"><span class="textoContenido">Marcar si es con vista  Ventana a la calle </span>
                            <input name="txtubicacion" type="checkbox" <?php if($xhFila['12']==1){echo "checked";}?>  id="txtubicacion" value="1"></td>
                        </tr>
                        <tr>
                          <td height="25">&nbsp;</td>
                          <td height="25">&nbsp;</td>
                          <td height="25">&nbsp;</td>
                          <td height="25">&nbsp;</td>
                        </tr>
                        <tr>
                          <td width="202" height="25"><span class="textoContenidoMenor">Precio Diario (Dom-Jue) </span></td>
                          <td width="225" height="25"><span class="textoContenidoMenor">Precio por Horas (Dom-Jue)</span></td>
                          <td width="211" height="25"><span class="textoContenidoMenor">Precio Diario (Vie-Sab)</span></td>
                          <td width="249" height="25"><span class="textoContenidoMenor">Precio por Horas (Vie-Sab)</span></td>
                        </tr>
                        <tr>
                          <td height="25" valign="top"><input name="txtpreciodiariodj" type="text" class="textbox" id="txtpreciodiariodj" style="width:85%; text-align:right;" onFocus = "txtpreciodiariodj.value = EliminarComa(this.value)" onBlur="document.form1.txtpreciodiariodj.value = formatCurrency(txtpreciodiariodj.value);" value="<?php echo number_format($xhFila['5'],2);?>"></td>
                          <td height="25" valign="top"><input name="txtpreciohorasdj" type="text" class="textbox" id="txtpreciohorasdj" style="width:85%; text-align:right;" onFocus = "txtpreciohorasdj.value = EliminarComa(this.value)" onBlur="document.form1.txtpreciohorasdj.value = formatCurrency(txtpreciohorasdj.value);" value="<?php echo number_format($xhFila['6'],2);?>"></td>
                          <td height="25" valign="top"><input name="txtpreciodiariovs" type="text" class="textbox" id="txtpreciodiariovs" style="width:85%; text-align:right;" onFocus = "txtpreciodiariovs.value = EliminarComa(this.value)" onBlur="document.form1.txtpreciodiariovs.value = formatCurrency(txtpreciodiariovs.value);" value="<?php echo number_format($xhFila['7'],2);?>"></td>
                          <td height="25" valign="top"><input name="txtpreciohorasvs" type="text" class="textbox" id="txtpreciohorasvs" style="width:85%; text-align:right;" onFocus = "txtpreciohorasvs.value = EliminarComa(this.value)" onBlur="document.form1.txtpreciohorasvs.value = formatCurrency(txtpreciohorasvs.value);" value="<?php echo number_format($xhFila['8'],2);?>"></td>
                        </tr>
                        <tr>
                          <td height="25">&nbsp;</td>
                          <td height="25">&nbsp;</td>
                          <td height="25" valign="middle">&nbsp;</td>
                          <td height="25" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td width="202" height="25"><span class="textoContenidoMenor">Precio por Hora Adicional</span></td>
                          <td width="225" height="25"><span class="textoContenidoMenor">Precio por Persona Adicional</span></td>
                          <td width="225" height="25"><span class="textoContenidoMenor">Precio 12H (Dom-Jue)</span></td>
                          <td width="225" height="25"><span class="textoContenidoMenor">Precio 12H (Vie-Sab)</span></td>
                          <td height="25" valign="middle">&nbsp;</td>
                          <td height="25" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="25" valign="top"><input name="txtpreciohoraadicional" type="text" class="textbox" id="txtpreciohoraadicional" style="width:85%; text-align:right;" onFocus = "txtpreciohoraadicional.value = EliminarComa(this.value)" onBlur="document.form1.txtpreciohoraadicional.value = formatCurrency(txtpreciohoraadicional.value);" value="<?php echo number_format($xhFila['13'],2);?>"></td>
                          <td height="25" valign="top"><input name="txtpreciopersonaadicional" type="text" class="textbox" id="txtpreciopersonaadicional" style="width:85%; text-align:right;" onFocus = "txtpreciopersonaadicional.value = EliminarComa(this.value)" onBlur="document.form1.txtpreciopersonaadicional.value = formatCurrency(txtpreciopersonaadicional.value);" value="<?php echo number_format($xhFila['14'],2);?>"></td>
                          <td height="25" valign="top"><input name="txtprecio12" type="text" class="textbox" id="txtprecio12" style="width:85%; text-align:right;" onFocus = "txtprecio12.value = EliminarComa(this.value)" onBlur="document.form1.txtprecio12.value = formatCurrency(txtprecio12.value);" value="<?php echo number_format($xhFila['15'],2);?>"></td>
                           <td height="25" valign="top"><input name="txtprecio12vs" type="text" class="textbox" id="txtprecio12vs" style="width:85%; text-align:right;" onFocus = "txtprecio12vs.value = EliminarComa(this.value)" onBlur="document.form1.txtprecio12vs.value = formatCurrency(txtprecio12vs.value);" value="<?php echo number_format($xhFila['16'],2);?>"></td>
                          <td height="25" valign="middle">&nbsp;</td>
                          <td height="25" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="135" colspan="4" valign="middle"><textarea name="txtcaracteristicas"  class="textbox" style="width:98%; height:80px;"><?php echo $xhFila['10'];?></textarea></td>
                        </tr>
                        <tr>
                          <td height="30" colspan="4">
                          <?php if ($_SESSION['msgerror']!=""){ ?>
                          <div class="alert alert-danger alert-dismissable textoContenidoMenor">
							<?php echo $_SESSION['msgerror'];$_SESSION['msgerror']="";?> 
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                          </div>
                           <?php } ?>
                          </td>
                        </tr>
                        <tr>
                          <td height="30" colspan="2">
                            <?php if($xestado=="modifica"){?>
                            <button type="submit" class="btnrojo" style="border:0px; cursor:pointer;"> <i class="fa fa-refresh"></i> Actualizar </button>
                            <?php }else{?>
                            <button type="submit" class="btnnegro" style="border:0px; cursor:pointer;"> <i class="fa fa-save"></i> Guardar </button>
                            <?php } ?>
                            
                            <button type="button" onclick="window.location.href='habitaciones.php';" class="btnnegro" style="border:0px; cursor:pointer;"> <i class="fa fa-remove"></i> Cancelar </button>
                            
                          </td>
                          <td width="211" height="30">&nbsp;</td>
                          <td width="249" height="30">&nbsp;</td>
                        </tr>
                        <tr>
                          <td width="202" height="30">&nbsp;</td>
                          <td width="225" height="30">&nbsp;</td>
                          <td width="211" height="30">&nbsp;</td>
                          <td width="249" height="30">&nbsp;</td>
                        </tr>
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


<?php include "footer.php" ?>
</body>
</html>





