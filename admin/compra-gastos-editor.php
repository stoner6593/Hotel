<?php
include "validar.php";
include "config.php";
include "include/functions.php";

$xdato = $_POST['txtproducto'];
$xmando = $_POST['txtmando'];

$xactualiza = $_GET['actualiza'];

$sqlproducto = $mysqli->query("select
	idproducto,
	nombre,
	precioventa,
	estado
	from producto order by idproducto asc");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Administrador</title>
<link href="opera.css" rel="stylesheet" type="text/css">

<?php include "head-include.php"; ?>


<script>
	function validarDatos() { 
	
		if (espacioVacio(document.form1.txtproducto.value) == false ) {  
		alert("Debe ingresar el producto / asunto o servicio.");
		document.form1.txtproducto.focus();
		return false  
		}
		
		var Lstopcion = parseInt(document.form1.txtproductoopcion.value)
		if (Lstopcion==1 && document.form1.txtproducto.value == 0)
		{
		alert("Seleccione un producto");
		document.form1.txtproducto.focus();
		return false;
		}
		
		if(Lstopcion==2){
		if (espacioVacio(document.form1.txtservicio.value) == false ) {  
		alert("Debe ingresar el Concepto o Asunto");
		document.form1.txtservicio.focus();
		return false  
		}
		}
		
		var Lstcantidad = parseInt(document.form1.txtcantidad.value)
		if (Lstcantidad==0)
		{
		alert("La cantidad debe ser mayor a cero");
		document.form1.txtcantidad.focus();
		return false;
		}
	
	
	
	
		return true; 
	}
	
	function cambiarEstadoUno(){
		document.form1.txtservicio.disabled = true;
		document.form1.txtproducto.disabled = false;
		document.form1.txtproducto.focus();
	}
	function cambiarEstadoDos(){
		document.form1.txtproducto.disabled = true;
		document.form1.txtservicio.disabled = false;
		document.form1.txtservicio.focus();
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
      <td width="1125" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">

          <tr>
            <td width="691" height="30"><h3 style="color:#E1583E;"> <i class="fa fa-shopping-basket"></i> Registro de Compras - Gastos / Actualizar Stock</h3> </td>
            <td width="213" align="center" valign="middle"><button type="button" onclick="window.location.href='compra-gastos.php';" class="btngris" style="border:0px; cursor:pointer;"> <i class="fa fa-arrow-left"></i> Volver </button></td>
          </tr>
          <tr>
            <td height="30" colspan="2"> <div class="lineahorizontal" style="background:#EFEFEF;"></div> </td>
            </tr>
          <tr>
            <td height="30" colspan="2"><form id="form1" name="form1" method="post" action="include/gastos/prg_gastos-nuevo.php">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
     
                  <tr>
                    <td width="247" height="40" align="left" bgcolor="#FFFFFF"><span class="textoContenido">Nombre de Producto Existente </span></td>
                    <td height="40" colspan="2" bgcolor="#FFFFFF" class="textoContenidoMenor">
                    	
						<input name="txtproductoopcion" type="radio" id="opcionuno" value="1" checked="checked" onClick="return cambiarEstadoUno();">
						<label for="opcionuno">
                        <?php
                            echo "<select name='txtproducto' class='textbox' >";   
							     echo "<option value=\"".'0'."\" selected=\"selected\">".'--Seleccione--'."</option>";
                            while ($xpFila = $sqlproducto->fetch_row()){
                                if ($xpFila['1'] == $xpFila['0']){
                                    echo "<option value=\"".$xpFila['0']."\" selected=\"selected\">".$xpFila['1']."</option>";
                                }else{	
                                    echo "<option value=\"".$xpFila['0']."\">".$xpFila['1']."</option>";
                                }
                            }
							echo "</select>";
                            $sqlproducto->free();
                            ?>
                  		</label>
                      </td>
                  </tr>
                  <tr>
                    <td height="40" align="left" bgcolor="#FFFFFF"><span class="textoContenido">Otro Producto / Servicio o Asunto</span></td>
                    <td height="40" colspan="2" align="left" bgcolor="#FFFFFF">
                      
                      <input type="radio" name="txtproductoopcion" id="opciondos" value="2" onClick="return cambiarEstadoDos();">
                      <label for="opciondos">
                      <input name="txtservicio" type="input" class="textbox" id="txtservicio" placeholder="Ingrese el Servicio o Asunto" disabled>
                      </label>
                      </td>
                  </tr>
                  <tr>
                    <td height="10" colspan="3" bgcolor="#FFFFFF">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="30" colspan="3" bgcolor="#FFFFFF" >
       				<div class="ui-state-highlight textoContenido" style="padding:3px; text-align:center; width:97%">
                  	Si ha seleccionado &quot;Producto existente&quot; se actualizará el Stock aún que no ingrese el monto
					</div>
                    </td>
                  </tr>
                  <tr>
                    <td height="10" bgcolor="#FFFFFF" class="textoContenido">&nbsp;</td>
                    <td height="10" bgcolor="#FFFFFF" class="textoContenido">&nbsp;</td>
                    <td height="10" bgcolor="#FFFFFF">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="30" bgcolor="#FFFFFF" class="textoContenido">Cantidad                      </td>
                    <td width="200" height="30" bgcolor="#FFFFFF" class="textoContenido">Monto S/ </td>
                    <td width="331" height="30" bgcolor="#FFFFFF">&nbsp;</td>
                    </tr>
                  <tr>
                    <td height="30" align="left" bgcolor="#FFFFFF"><input type="text" name="txtcantidad"  class="textbox" onKeyPress="return soloNumero(event);"  value="1" maxlength="5"></td>
                    <td height="30" align="left" bgcolor="#FFFFFF"><input name="txtmonto" type="text" id="txtmonto" style="text-align:justify;" onFocus = "txtmonto.value = EliminarComa(this.value)" onBlur="document.form1.txtmonto.value = formatCurrency(txtmonto.value);" value="0.00"  class="textbox"></td>
                    <td height="30" bgcolor="#FFFFFF" class="textoContenido">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="30" align="left" bgcolor="#FFFFFF"><span class="textoContenido">Descripción</span></td>
                    <td height="30" align="left" bgcolor="#FFFFFF">&nbsp;</td>
                    <td height="30" bgcolor="#FFFFFF">&nbsp;</td>
                    </tr>
                  <tr>
                    <td height="30" colspan="3" align="left" bgcolor="#FFFFFF"><textarea name="txtdescripcion" id="txtdescripcion" class="textbox"></textarea></td>
                    </tr>
                  <tr>
                    <td height="30" colspan="3" align="left" bgcolor="#FFFFFF"><div class="lineahorizontal" style="background:#EFEFEF;"></div></td>
                  </tr>
                  <tr>
                    <td height="30" colspan="3" align="left" bgcolor="#FFFFFF"><button type="submit" onClick="return validarDatos();" class="btnrojo" style="border:0px; cursor:pointer;"> <i class="fa fa-save"></i> Guadar</button>
                    <button type="button" onclick="window.location.href='compra-gastos.php';" class="btnnegro" style="border:0px; cursor:pointer;"> <i class="fa fa-remove"></i> Cancelar </button></td>
                    </tr>
       
              </table>
            </form></td>
          </tr>
          <tr>
            <td height="10" colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td height="30" colspan="2">&nbsp;</td>
            </tr>
       
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




