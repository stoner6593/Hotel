<?php
include "validar.php";
include "config.php";
include "include/functions.php";
date_default_timezone_set('America/Lima');

$xidprimario = $_GET['idprimario'];
$xestado = $_GET['estado'];

if($xestado=="modifica"){
	$sqlhabitaciontipomod = $mysqli->query("select 
	idtipo,
	nombre,
	
	preciodiariouno,
	preciohorauno,
	preciohoraadicionaluno,
	preciohuespedadicionaluno,
	
	preciodiariodos,
	preciohorados,
	preciohoraadicionaldos,
	preciohuespedadicionaldos
	
	from habitaciontipo where idtipo='$xidprimario'");
	
	$xhFila = $sqlhabitaciontipomod->fetch_row();
	
}

$sqlhabitaciontipo = $mysqli->query("select 
	idtipo,
	nombre,
	
	preciodiariouno,
	preciohorauno,
	preciohoraadicionaluno,
	preciohuespedadicionaluno,
	
	preciodiariodos,
	preciohorados,
	preciohoraadicionaldos,
	preciohuespedadicionaldos
	
	from habitaciontipo order by idtipo asc");



	
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
      <td width="216" height="25" align="left" valign="top"><?php include ("menu_nav.php"); ?></td>
      <td width="33">&nbsp;</td>
      <td width="754" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
       
          <tr>
            <td width="637" height="30"> <h3 style="color:#E1583E;"> <i class="fa fa-hotel"></i> Tipo de Habitaciones</h3></td>
            <td width="170" align="center"> <button type="button" onclick="window.location.href='habitaciones.php';" class="btngris" style="border:0px; cursor:pointer;"> <i class="fa fa-arrow-left"></i> Volver </button> </td>
          </tr>
          <tr>
            <td height="30" colspan="2"><table width="100%" border="0" cellpadding="1" cellspacing="1">
              <tr>
                <td width="100%" height="30"><div class="lineahorizontal" style="background:#BFBFBF;"></div></td>
              </tr>
              <tr>
                <td width="100%" height="30"><form id="form1" name="form1" method="post" action="<?php if($xestado=="modifica"){echo 'include/habitaciontipo/prg_habitaciontipo-modifica.php';}else{echo 'include/habitaciontipo/prg_habitaciontipo-nuevo.php';}?>">
                  <table width="900" border="0" cellpadding="1" cellspacing="1">
                    <tr> </tr>
                  </table>
                  <table width="99%" border="0" cellpadding="1" cellspacing="1">
                    <tbody>
                      <tr>
                        <td width="174"><span class="textoContenidoMenor">Tipo de Habitación</span></td>
                        <td colspan="2">&nbsp;</td>
                        <td width="168">&nbsp;</td>
                        <td width="193" height="30">&nbsp;</td>
                      </tr>
                      <tr>
                        <td width="174" valign="top"><input name="txtnombre" type="text" class="textbox" id="txthuespedmaximo4" value="<?php echo $xhFila['1'];?>" readonly></td>
                        <td colspan="2" valign="middle"><input name="txtidtipo" type="hidden" id="txtidtipo" value="<?php echo $xhFila['0'];?>"></td>
                        <td width="168" valign="top">&nbsp;</td>
                        <td width="193" height="30">&nbsp;</td>
                      </tr>
                      <tr>
                        <td height="30" colspan="3" valign="bottom" class="textoContenido"><strong>Precios de Domingo a Jueves (S/)</strong></td>
                        <td width="168" height="30">&nbsp;</td>
                        <td width="193">&nbsp;</td>
                      </tr>
                      <tr>
                        <td height="30" colspan="5"><div class="lineahorizontal" style="background:#00A230;"></div></td>
                      </tr>
                      <tr>
                        <td width="174" height="30"><span class="textoContenidoMenor"> Diario (D - J)</span></td>
                        <td width="183"><span class="textoContenidoMenor"> Huésped Adicional (Diario D-J</span>)</td>
                        <td width="184"><span class="textoContenidoMenor"> Horas (D - J)</span></td>
                        <td width="168" height="30"><span class="textoContenidoMenor"> Hora Adicional (D - J)</span></td>
                        <td width="193"><span class="textoContenidoMenor"> Hora Huésped Adicional (D - J)</span></td>
                      </tr>
                      <tr>
                        <td width="174" height="30" valign="top"><input name="txtpreciodiariouno" type="text" class="textbox" value="<?php if($xhFila['2']!=""){echo number_format($xhFila['2'],2);}else{ echo "0.00";}?>" style="text-align:right;" onFocus = "txtpreciodiariouno.value = EliminarComa(this.value)" onBlur="document.form1.txtpreciodiariouno.value = formatCurrency(txtpreciodiariouno.value);"></td>
                        <td width="183" valign="top"><input name="txtpreciohuespedadicionaluno" type="text" class="textbox" value="<?php if($xhFila['5']!=""){echo number_format($xhFila['5'],2);}else{ echo "0.00";}?>" style="text-align:right;" onFocus = "txtpreciohuespedadicionaluno.value = EliminarComa(this.value)" onBlur="document.form1.txtpreciohuespedadicionaluno.value = formatCurrency(txtpreciohuespedadicionaluno.value);"></td>
                        <td width="184" valign="top"><input name="txtpreciohorauno" type="text" class="textbox" value="<?php if($xhFila['3']!=""){echo number_format($xhFila['3'],2);}else{ echo "0.00";}?>" style="text-align:right;" onFocus = "txtpreciohorauno.value = EliminarComa(this.value)" onBlur="document.form1.txtpreciohorauno.value = formatCurrency(txtpreciohorauno.value);"></td>
                        <td width="168" height="30" valign="top"><input name="txtpreciohoraadicionaluno" type="text" class="textbox" value="<?php if($xhFila['4']!=""){echo number_format($xhFila['4'],2);}else{ echo "0.00";}?>" style="text-align:right;" onFocus = "txtpreciohoraadicionaluno.value = EliminarComa(this.value)" onBlur="document.form1.txtpreciohoraadicionaluno.value = formatCurrency(txtpreciohoraadicionaluno.value);"></td>
                        <td width="193" valign="top"><input name="txtpreciohuespedadicionaluno" type="text" class="textbox" value="<?php if($xhFila['5']!=""){echo number_format($xhFila['5'],2);}else{ echo "0.00";}?>" style="text-align:right;" onFocus = "txtpreciohuespedadicionaluno.value = EliminarComa(this.value)" onBlur="document.form1.txtpreciohuespedadicionaluno.value = formatCurrency(txtpreciohuespedadicionaluno.value);"></td>
                      </tr>
                      <tr>
                        <td height="30" colspan="2" valign="bottom" class="textoContenido">&nbsp;</td>
                        <td height="30">&nbsp;</td>
                        <td height="30">&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td height="30" colspan="2" valign="bottom" class="textoContenido"><strong>Precios de Viernes a Sábado (S/)</strong></td>
                        <td height="30">&nbsp;</td>
                        <td height="30">&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td height="30" colspan="5" valign="top"><div class="lineahorizontal" style="background:#00A230;"></div></td>
                      </tr>
                      <tr>
                        <td width="174" height="30"><span class="textoContenidoMenor"> Diario (V-S)</span></td>
                        <td width="183"><span class="textoContenidoMenor">Huésped Adicional (V-S)</span></td>
                        <td width="184"><span class="textoContenidoMenor"> Horas (V-S)</span></td>
                        <td width="168"><span class="textoContenidoMenor"> Hora Adicional (V-S)</span></td>
                        <td width="193"><span class="textoContenidoMenor"> Hora Huésped Adicional (V-S)</span></td>
                      </tr>
                      <tr>
                        <td height="30" valign="top"><input name="txtpreciodiariodos" type="text" class="textbox" id="txtpreciodiariodos" style="text-align:right;" onFocus = "txtpreciodiariodos.value = EliminarComa(this.value)" onBlur="document.form1.txtpreciodiariodos.value = formatCurrency(txtpreciodiariodos.value);" value="<?php if($xhFila['6']!=""){echo number_format($xhFila['6'],2);}else{ echo "0.00";}?>"></td>
                        <td valign="top"><input name="txtpreciohuespedadicionaldos" type="text" class="textbox" id="txtpreciohuespedadicionaldos" style="text-align:right;" onFocus = "txtpreciohuespedadicionaldos.value = EliminarComa(this.value)" onBlur="document.form1.txtpreciohuespedadicionaldos.value = formatCurrency(txtpreciohuespedadicionaldos.value);" value="<?php if($xhFila['9']!=""){echo number_format($xhFila['9'],2);}else{ echo "0.00";}?>"></td>
                        <td valign="top"><input name="txtpreciohorados" type="text" class="textbox" id="txtpreciohorados" style="text-align:right;" onFocus = "txtpreciohorados.value = EliminarComa(this.value)" onBlur="document.form1.txtpreciohorados.value = formatCurrency(txtpreciohorados.value);" value="<?php if($xhFila['7']!=""){echo number_format($xhFila['7'],2);}else{ echo "0.00";}?>"></td>
                        <td height="30" valign="top"><input name="txtpreciohoraadicionaldos" type="text" class="textbox" id="txtpreciohoraadicionaldos" style="text-align:right;" onFocus = "txtpreciohoraadicionaldos.value = EliminarComa(this.value)" onBlur="document.form1.txtpreciohoraadicionaldos.value = formatCurrency(txtpreciohoraadicionaldos.value);" value="<?php if($xhFila['8']!=""){echo number_format($xhFila['8'],2);}else{ echo "0.00";}?>"></td>
                        <td valign="top"><input name="txtpreciohuespedadicionaldos" type="text" class="textbox" id="txtpreciohuespedadicionaldos" style="text-align:right;" onFocus = "txtpreciohuespedadicionaldos.value = EliminarComa(this.value)" onBlur="document.form1.txtpreciohuespedadicionaldos.value = formatCurrency(txtpreciohuespedadicionaldos.value);" value="<?php if($xhFila['9']!=""){echo number_format($xhFila['9'],2);}else{ echo "0.00";}?>"></td>
                      </tr>
                      <tr>
                        <td height="30" colspan="5" class="textoContenidoMenor"><div class="lineahorizontal" style="background:#00A230;"></div></td>
                      </tr>
                      <tr>
                        <td height="30" colspan="3"><?php if($xestado=="modifica"){?>
                          <button type="submit" class="btnrojo" style="border:0px; cursor:pointer;"> <i class="fa fa-refresh"></i> Actualizar </button>
                          <?php }else{?>
                          <button type="submit" class="btnnegro" style="border:0px; cursor:pointer;"> <i class="fa fa-save"></i> Guardar </button>
                          <?php } ?>
                          <button type="button" onclick="window.location.href='habitaciones-tipo.php';" class="btnnegro" style="border:0px; cursor:pointer;"> <i class="fa fa-remove"></i> Cancelar </button></td>
                        <td width="168" height="30">&nbsp;</td>
                        <td width="193" height="30">&nbsp;</td>
                      </tr>
                      <tr>
                        <td width="174" height="30">&nbsp;</td>
                        <td height="30" colspan="2">&nbsp;</td>
                        <td width="168" height="30">&nbsp;</td>
                        <td width="193" height="30">&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                </form></td>
              </tr>
              <tr>
                <td width="100%" height="30">&nbsp;</td>
              </tr>
              <tr>
                <td width="100%" height="30" class="textoContenido"><strong>Lista Tipo de Habitaciones y Precios (S/)</strong></td>
              </tr>
              <tr>
                <td width="100%" height="30"><div class="lineahorizontal" style="background:#00A230;"> </div></td>
              </tr>
              <tr>
                <td width="100%" height="30"><?php
						$item = 0;
						while ($xhFila = $sqlhabitaciontipo->fetch_row())
						{		
						$item++;
					?>
                  <table width="99%" border="0" cellpadding="4" cellspacing="1" bgcolor="#E0E0E0">
                    <tr class="textoContenidoMenor">
                      <td height="30" colspan="9" bgcolor="#FFFFFF">Tipo:<strong> <?php echo $xhFila['1']; ?></strong></td>
                    </tr>
                    <tr class="textoContenidoMenor">
                      <td width="76" height="30" align="right" bgcolor="#F4F4F4"> Diario (D-J)</td>
                      <td width="85" height="30" align="right" bgcolor="#F4F4F4">Por Horas (D-J)</td>
                      <td width="93" height="30" align="right" bgcolor="#F4F4F4"> Hora Adic. (D-J)</td>
                      <td width="121" align="right" bgcolor="#F4F4F4">Por  Hués. Adic. (D-J)</td>
                      <td width="74" align="right" bgcolor="#ECECEC"> Diario (V-S)</td>
                      <td width="103" align="right" bgcolor="#ECECEC">Por Horas (V-S)</td>
                      <td width="105" align="right" bgcolor="#ECECEC"> Hora Adic.l (V-S)</td>
                      <td width="121" align="right" bgcolor="#ECECEC"><p class="textoContenidoMenor">Por  Hués. Adic. (V-S)</p></td>
                      <td width="33" bgcolor="#F4F4F4" align="center">Edit</td>
                    </tr>
                    <tr class="textoContenidoMenor">
                      <td width="76" height="25" align="right" bgcolor="#FFFFFF"><?php echo number_format($xhFila['2'],2); ?></td>
                      <td width="85" height="25" align="right" bgcolor="#FFFFFF"><?php echo number_format($xhFila['3'],2); ?></td>
                      <td width="93" height="25" align="right" bgcolor="#FFFFFF"><?php echo number_format($xhFila['4'],2); ?></td>
                      <td width="121" height="25" align="right" bgcolor="#FFFFFF"><?php echo number_format($xhFila['5'],2); ?></td>
                      <td width="74" align="right" bgcolor="#FFFFFF"><?php echo number_format($xhFila['6'],2); ?></td>
                      <td width="103" align="right" bgcolor="#FFFFFF"><?php echo number_format($xhFila['7'],2); ?></td>
                      <td width="105" align="right" bgcolor="#FFFFFF"><?php echo number_format($xhFila['8'],2); ?></td>
                      <td width="121" align="right" bgcolor="#FFFFFF"><?php echo number_format($xhFila['9'],2); ?></td>
                      <td align="center" bgcolor="#FFFFFF"><button type="button" onclick="window.location.href='habitaciones-tipo.php?idprimario=<?php echo $xhFila['0'].'&estado=modifica';?>';" class="btnmodificar" style="border:0px; cursor:pointer;"> <i class="fa fa-edit"></i></button></td>
                    </tr>
                  </table>
                  <?php
						}
						$sqlhabitaciontipo->free();
					?>
                  <br>
                  <br></td>
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





