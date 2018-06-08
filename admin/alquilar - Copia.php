<?php
include "validar.php";
include "config.php";
include "include/functions.php";
date_default_timezone_set('America/Lima');
$xidhabitacion = $_GET['idhabitacion'];
$xnrohabitacion = $_GET['nrohabitacion'];
$xestadohabitacion = $_GET['xestado'];

$idtipohab = $_GET['idtipohab'];

$sqlhuesped = $mysqli->query("select 
	idhuesped,
	nombre
	from huesped order by idhuesped asc");

$sqltipohab = $mysqli->query("select idtipo, nombre from habitaciontipo where idtipo = '$idtipohab'");
$tFila = $sqltipohab->fetch_row();

$sqlhabitacion = $mysqli->query("select
	habitacion.idhabitacion,
	habitacion.idtipo,
	habitacion.idestado,
	habitacion.piso,
	habitacion.numero,
	
	habitacion.nrohuespedes,
	habitacion.nroadicional,
	
	habitaciontipo.idtipo,
	habitaciontipo.nombre,
	habitaciontipo.preciodiariouno,
	habitaciontipo.preciohorauno,
	habitaciontipo.preciohoraadicionaluno,
	habitaciontipo.preciohuespedadicionaluno,
	
	habitaciontipo.preciodiariodos,
	habitaciontipo.preciohorados,
	habitaciontipo.preciohoraadicionaldos,
	habitaciontipo.preciohuespedadicionaldos
	
	from habitacion inner join habitaciontipo on habitaciontipo.idtipo = habitacion.idtipo
	where habitacion.idhabitacion = $xidhabitacion and habitaciontipo.idtipo = habitacion.idtipo ");
	
	$xhFila = $sqlhabitacion->fetch_row();
	$nroadicional = $xhFila['6']; //Ocupantes Adicionales permitidos
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Administrador</title>

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
	
	
    function abrirCliente(){
        window.open('buscar-cliente.php','modelo','width=800, height=300, scrollbars=yes, location=no, directories=no,resizable=no, top=200,left=300', 'socialPopupWindow');
    } 
</script>


<script type="text/javascript" language="javascript">
	$(document).ready(function(){
		$("#mostrar").click(function(){
			$('.div1').show("swing");
			$('.div2').hide("linear");
		});
		$("#ocultar").click(function(){
			$('.div1').hide("linear");
			$('.div2').show("swing");
		});
	});
</script>


<script>
	function calcularPrecioHoras(){
		var Lstnroadicional = parseInt(document.form1.txtocupantesadicionaleshoras.value);
		var costohoras = parseFloat(document.form1.txtcostohoras.value);
		var costoadicionalhoras = parseFloat(document.form1.txtprecioadicionalhora.value);
		document.form1.txtcostototalhoras.value = parseFloat(costohoras + (Lstnroadicional*costoadicionalhoras)).toFixed(2);;
	}
</script>
    
    
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
            <td width="555" height="30"> <h3 style="color:#E1583E;"> <i class="fa fa-users"></i> Alquilar Habitación</h3></td>
            <td width="248">
            
			<?php if($xestadohabitacion == 1){?>
            <button type="button" onclick="window.location.href='include/habitacion/prg_habitacion-mantenimiento.php?txtidprimario=<?php echo $xidhabitacion;?>';" class="btngris" style="border:0px; cursor:pointer; background:#44A6ED;color:#FFFFFF;"> <i class="fa fa-info-circle"></i> Cambiar a Mantenimiento </button>
            <?php }else if ($xestadohabitacion == 4){ ?>
            <button type="button" onclick="window.location.href='include/habitacion/prg_habitacion-disponible.php?txtidprimario=<?php echo $xidhabitacion;?>';" class="btngris" style="border:0px; cursor:pointer; background:#00A230;color:#FFFFFF;"> <i class="fa fa-info-circle"></i> Cambiar a Disponible </button>
            <?php } ?>
            
            </td>
            <td width="102" align="right"> <button type="button" onclick="window.location.href='control-habitaciones.php';" class="btngris" style="border:0px; cursor:pointer;"> <i class="fa fa-arrow-left"></i> Volver </button> </td>
          </tr>
          <tr>
            <td height="30" colspan="3"><table width="904" border="0" cellpadding="1" cellspacing="1">
             
                <tr>
                  <td height="30"><div class="lineahorizontal" style="background:#BFBFBF;"></div></td>
                </tr>
                <tr>
                  <td height="30"><form id="form1" name="form1" method="post" action="include/alquiler/prg_alquiler-nuevo.php">
                    <table width="904" border="0" cellpadding="1" cellspacing="1">
                      <tbody>
                        <tr>
                          <td height="30" colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                              <tr>
                                <td width="15%" height="40"><span class="textoContenido">Huésped (Cliente)</span></td>
                                <td width="44%" height="40"><input name="txtcliente" type="text" class="textbox" id="txtcliente" style="width:75%;" readonly>
                                  
                                  <button type="button" onclick="abrirCliente(); return false" class="btnmodificar tooltip" tooltip="Seleccionar Huésped" style="border:0px; cursor:pointer;"> <i class="fa fa-search-plus"></i></button>
							       <button type="button" onclick="window.location.href='huespedes-editor.php';" class="btnmodificar tooltip" tooltip="Agregar Huésped" style="border:0px; cursor:pointer;"> <i class="fa fa-plus-square"></i></button>                                  
                                  <input type="hidden" name="txtidcliente" id="txtidcliente"></td>
                                <td width="41%" height="40" align="right"><span class="textoContenido"><strong>Habitación <?php echo $tFila['1'];?> N° </strong></span><span class="textoContenido" style="font-size:28px;color:#00A230;"> <?php echo $xnrohabitacion;?></span>
                                  <input name="txtidhabitacion" type="hidden" id="txtidhabitacion" value="<?php echo $xidhabitacion;?>">
                                  <input name="txtnrohabitacion" type="hidden" id="txtnrohabitacion" value="<?php echo $xnrohabitacion;?>">
                                  <span class="textoContenido"> (<?php echo $xhFila['5'];?> ocupantes máximo)</span></td>
                              </tr>
                            </tbody>
                          </table></td>
                        </tr>
                        <tr>
                          <td colspan="3" align="center"><div class="lineahorizontal" style="background:#00A230;"></div></td>
                        </tr>
                        <tr>
                          <td width="174" height="30" bgcolor="#FFFFFF"><span class="textoContenido" style="color:#00A230;">
                            <input name="txttipoalquiler" type="radio" value="1" checked="checked" id="mostrar">
                            <strong>Alquiler por Horas </strong></span></td>
                          <td height="30" colspan="2" bgcolor="#FFFFFF">

							<?php if($idtipohab != 3){?>
                            <input name="txttipoalquiler" type="radio" value="2" id="ocultar">
                          	<span class="textoContenido" style="color:#FFAF03;"><strong>Alquiler por Día (Desde)</strong></span>
                          	<?php } ?>
                          
                          </td>
                        </tr>
                        <tr>
                          <td height="30" colspan="3" bgcolor="#FFFFFF" class="textoContenido">
                          
                          <div class="div1">
                          
                          <table width="900" border="0" cellpadding="1" cellspacing="1">
                              <tr>
                                <td height="30" colspan="3" bgcolor="#FFFFFF" class="textoContenido"><div class="lineahorizontal" style="background:#00A230;"></div></td>
                                </tr>
                              <tr>
                                <td width="293" height="30" bgcolor="#FFFFFF" class="textoContenido">Costo (S/) </td>
                                <td width="277" height="30" bgcolor="#FFFFFF"> Ocupantes Adicionales (S/ <?php echo $xhFila['12'];?>+) 
                                  <input name="txtprecioadicionalhora" type="hidden" id="txtprecioadicionalhora" value="<?php echo $xhFila['12'];?>"></td>
                                <td height="30"><h3 style="margin:0px; padding:0px;"><strong>Total a Pagar  (S/)</strong> </h3> </td>
                              </tr>
                              <tr>
                                <td height="30"><input name="txtcostohoras" type="text" class="textbox" id="txtcostohoras" style="text-align:right;" value="<?php echo $xhFila['10'];?>" readonly ></td>
                                <td height="30">
                                <select name="txtocupantesadicionaleshoras" id="txtocupantesadicionaleshoras" onChange="return calcularPrecioHoras();" class="textbox" >
                                  <option selected>0</option>
                                  <?php for ($i=1; $i<=$nroadicional; $i++){?>
                                  <option><?php echo $i; ?></option>
                                  <?php } ?>
                                </select></td>
                                <td height="30"><input name="txtcostototalhoras" type="text" class="textbox" id="txtcostototalhoras" style="text-align:right; font-size:18px; background:#E4F8F9;" value="<?php echo $xhFila['10'];?>" readonly></td>
                              </tr>
                              <tr>
                                <td colspan="3"><div class="lineahorizontal" style="background:#00A230;"></div></td>
                              </tr>
                          </table>
                          
                          </div>
                          
                          <div class="grupo total div2" >
                            <table width="900" border="0" cellpadding="1" cellspacing="1">
                                <tr>
                                  <td height="30"><div class="lineahorizontal" style="background:#FFAF03;"></div></td>
                                </tr>
                                <tr>
                                  <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
                                    <tbody>
                                      <tr>
                                        <td width="180" bgcolor="#FFFFFF" class="textoContenido">Costo Diario (S/) </td>
                                        <td width="191" height="25"> Fecha de Entrada</td>
                                        <td width="139" height="25">Fecha de Salida</td>
                                        <td width="162" height="25"> Ocup. Adic. (S/ 10.00+) 
                                          <input type="hidden" name="txtprecioadicionaldia" id="txtprecioadicionaldia"></td>
                                        <td width="208" height="25"><h3 style="margin:0px; padding:0px;"><strong>Total a Pagar  (S/)</strong></h3> </td>
                                      </tr>
                                      <tr>
                                        <td><input name="txtcostodiario" type="text" class="textbox" id="txtcostodiario" style="text-align:right;" value="<?php echo $xhFila['9'];?>" readonly ></td>
                                        <td width="191" height="25" align="center"><input name="txtfechadesde" type="text" class="textbox" id="datepicker" placeholder="Ej: 10/05/1981"></td>
                                        <td width="139" height="25"><select name="txtnrodias" id="txtnrodias" class="textbox">
                                          <option selected>1</option>
                                          <option>2</option>
                                          <option>3</option>
                                          <option>4</option>
                                          <option>5</option>
                                          <option>6</option>
                                          <option>7</option>
                                          <option>8</option>
                                          <option>9</option>
                                          <option>10</option>
                                          <option>11</option>
                                          <option>12</option>
                                          <option>13</option>
                                          <option>14</option>
                                          <option>15</option>
                                          <option>16</option>
                                          <option>17</option>
                                          <option>18</option>
                                          <option>19</option>
                                          <option>20</option>
                                          <option>21</option>
                                          <option>22</option>
                                          <option>23</option>
                                          <option>24</option>
                                          <option>25</option>
                                          <option>26</option>
                                          <option>27</option>
                                          <option>28</option>
                                          <option>29</option>
                                          <option>30</option>
                                        </select></td>
                                        <td width="162" height="25"><select name="txtocupantesadicionalesdia" id="txtnroocupantes4" class="textbox">
                                          <option selected="selected">0</option>
                                          <option>1</option>
                                          <option>2</option>
                                          <option>3</option>
                                        </select></td>
                                        <td width="208" height="25"><input name="txtcostototaldia" type="text" class="textbox" id="txtcostototaldia"  style="text-align:right; font-size:18px; background:#E4F8F9;" value="<?php echo $xhFila['9'];?>" readonly></td>
                                      </tr>
                                    </tbody>
                                  </table></td>
                                </tr>
                                <tr>
                                  <td><div class="lineahorizontal" style="background:#FFAF03;"></div></td>
                                </tr>
                            </table>
                            
                            </div>
                            
                            </td>
                        </tr>
                        <tr>
                          <td height="30"><span class="textoContenido">Comentarios</span></td>
                          <td width="462" height="30">&nbsp;</td>
                          <td width="258" height="30"><h3 style="text-align:right; padding:0px; margin:0px;">&nbsp;</h3></td>
                        </tr>
                        <tr>
                          <td colspan="3"><textarea name="txtcomentarios" class="textbox" id="txtcomentarios" style="width:97%"></textarea></td>
                        </tr>
                        <tr>
                          <td colspan="3"><div class="lineahorizontal" style="background:#EFEFEF;"></div></td>
                        </tr>
                        <tr>
                          <td height="30" colspan="2">                          
                            
                            <?php if($xestado=="modifica"){?>
                            <button type="submit" class="btnrojo" style="border:0px; cursor:pointer;"> <i class="fa fa-refresh"></i> Actualizar </button>
                            <?php }else{?>
                            <button type="submit" class="btnnegro" style="border:0px; cursor:pointer;"> <i class="fa fa-save"></i> Guardar </button>
                            <?php } ?>
                            
                            <button type="button" onclick="window.location.href='control-habitaciones.php';" class="btnnegro" style="border:0px; cursor:pointer;"> <i class="fa fa-remove"></i> Cancelar </button>                    
                            
                          </td>
                          <td height="30">&nbsp;</td>
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
      <td height="25" colspan="3">&nbsp;</td>
    </tr>

</table>

</body>
</html>
<?php include ("footer.php") ?>




