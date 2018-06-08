<?php
session_start();
include "validar.php";
include "config.php";
include "include/functions.php";

if(isset($_POST['gender'])){

  $condicion=$_POST['gender'] ;
}else{
  $condicion=1;
}

$xdato = $_POST['txtproducto'] ? $_POST['txtproducto'] : $_POST['txtservicio'];
$xmando = $_POST['txtmando'];

$xidhabitacion = $_GET['idhabitacion'];
$xidalquiler = $_GET['idalquiler'];


$xactualiza = $_GET['actualiza'];

$sqlproducto = $mysqli->query("select
	idproducto,
	nombre,
	precioventa,
	estado
	from producto order by orden asc");

$sqlservicio = $mysqli->query("select
  idservicios,
  descripcion,
  costo,
  estado
  from servicios order by descripcion asc");

	if ($xmando == "grabar"){
		
    //print_r($_POST);
		$xcantidad = $_POST['txtcantidad'];
		//Obtener Precio
		$sqlprecio = $mysqli->query("select idproducto, precioventa from producto where nombre = '$xdato'");
    $sqlprecio2 = $mysqli->query("select idservicios, costo from servicios where descripcion = '$xdato'");
		$pFila = $sqlprecio->fetch_row(); 
    $pFila2 = $sqlprecio2->fetch_row(); 


    //Fin
		
		$xidproducto = $pFila['0'];
		$xnombre  = $xdato;
    if($condicion==1){
      $xprecio  = $pFila['1'];
    }else{
      $xprecio  = $pFila2['1'];
    }
		
		 $ximporte = $xcantidad * $xprecio;
	   //echo $xcantidad .'-'.$xprecio;
		$consulta = "insert ventas_tmp (idproducto,nombre,cantidad,precio,importe) values ('$xidproducto','$xnombre','$xcantidad','$xprecio','$ximporte')";
		if($mysqli->query($consulta)){ $tmp = "Ha sido grabado";}else{ $tmp = "No ha sido grabado";};
		$sqlprecio->free();
		
	
	}else if ($xactualiza == "actualizar"){
		
	}else if ($xmando == "" && $xactualiza == ""){
		$sSQL = "delete from ventas_tmp";
		if($mysqli->query($sSQL)){}
		$tmp = "Eliminado";
	}

	$sqltemp = $mysqli->query("select id, idproducto,nombre,cantidad,precio,importe from ventas_tmp order by id asc");
	
	
	
//Si se graba desde Alquiler
$xdesde = $_GET['desde'];

if($xdesde=="alquiler"){
	$xidhabitacion = $_GET['idhabitacion'];
	$xnrohabitacion = $_GET['nrohabitacion'];
	$xestadohabitacion = $_GET['xestado'];
	$idtipohab = $_GET['idtipohab'];
	
	$_SESSION['xidcliente'] = $_POST['txtidcliente'];
	$_SESSION['xcliente'] = $_POST['txtcliente'];
	
	
	 header("Location: alquilar.php?idhabitacion=$xidhabitacion&nrohabitacion=$xnrohabitacion&xestado=$xestadohabitacion&idtipohab=$idtipohab&desdeactualizando=si"); 
	exit;
}
	
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
    function abrirCliente(){
        window.open('buscar-cliente.php','modelo','width=800, height=300, scrollbars=yes' );
    } 
</script>

<script>
	function validarDatos() { 
	
		var LstnumRegistro = parseInt(document.form1.txtnumregistro.value)
		if (LstnumRegistro==0)
		{
		alert("Debe agregar minimo un producto.");
		document.form2.txtproducto.focus();
		return false;
		}
		
		if (espacioVacio(document.form1.txtcliente.value) == false ) {  
		alert("Ingrese un nombre o seleccione."); 
		document.form1.txtcliente.focus();
		return false  
		}
	
		return true; 
	}
</script>
	
<script>
	function CambioOperacion() { 
		var LstOperacion = parseInt(document.form1.tipooperacion.value)
		if (LstOperacion==0)
		{
		document.form1.txttotal.value = "0.00";
		}else{
			document.form1.txttotal.value = document.form1.txttotaltmp.value;
		}
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
      <td width="185" height="25" align="left" valign="top"><?php include ("menu_nav.php"); ?></td>
      <td width="25">&nbsp;</td>
      <td width="793" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tbody>
          <tr>
            <td width="618" height="30"><h3 style="color:#E1583E;"> <i class="fa fa-shopping-basket"></i> Venta  Productos</h3> </td>
            <td width="175" align="center" valign="middle"><button onclick="window.location.href = 'venta-listado.php';" class="btngris" style="border:0px; cursor:pointer;"> <i class="fa fa-plus-circle"></i> Ventas Realizadas </button>&nbsp;</td>
          </tr>
          <tr>
            <td height="30" colspan="2"> <div class="lineahorizontal" style="background:#EFEFEF;"></div> </td>
            </tr>
          <tr>
            <td height="30" colspan="2"><form id="form2" name="form2" method="post" action="venta.php?idhabitacion=<?php echo $xidhabitacion.'&idalquiler='.$xidalquiler;?>">
              <table width="99%" border="0" cellspacing="0" cellpadding="0">
                <tbody>
                  <tr>
                      <input type="radio" id="optproducto" name="gender" value="1" checked> Productos
                      <input type="radio" id="optservicios" name="gender" value="2"> Servicios
                  </tr>
                  <tr>
                    <td width="384" height="45" align="center" bgcolor="#969696">
                    <input type="input" list="producto" id="txtproducto" name="txtproducto" autocomplete="off" class="textbox" placeholder="Ingrese el nombre del Producto ej: Coca Cola"></input>
                    <input type="input" list="servicio" id="txtservicio" name="txtservicio" autocomplete="off" class="textbox" placeholder="Ingrese el nombre del Servicio"></input>
                      <datalist id="producto">
                        <?php while($urow = $sqlproducto->fetch_assoc()) { ?>
                          <option id="<?php echo $urow['idproducto']; ?>" value="<?php echo $urow['nombre']; ?>" label="<?php echo 'S/ '.$urow['precioventa'];?>"></option>
                        <?php } ?>
                      </datalist>

                      <datalist id="servicio">
                        <?php while($urow1 = $sqlservicio->fetch_assoc()) { ?>
                          <option id="<?php echo $urow1['idservicios']; ?>" value="<?php echo $urow1['descripcion']; ?>" label="<?php echo 'S/ '.$urow1['costo'];?>"></option>
                        <?php } ?>
                      </datalist>
                    </td>
                    <td width="119" height="45" align="center" bgcolor="#969696" > <span class="textoContenidoMenor">Cantidad</span>
                      <input name="txtmando" type="hidden" id="txtmando" value="grabar"></td>
                    <td width="136" height="45" bgcolor="#969696"><input name="txtcantidad" type="text" class="textbox" id="txtcantidad"  onKeyPress="return soloNumero(event)" value="1" maxlength="5"></td>
                    <td width="146" height="45" align="center" valign="middle" bgcolor="#969696"><button type="submit" class="btnrojo" style="border:0px; cursor:pointer;"> <i class="fa fa-plus-square"></i> Agregar </button></td>
                  </tr>
                </tbody>
              </table>
            </form></td>
          </tr>
          <tr>
            <td height="10" colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td height="30" colspan="2"><form id="form1" name="form1" method="post" action="include/venta/prg_venta-nuevo.php">
              <table width="99%" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                  <tr>
                    <td height="25" colspan="4"><table width="99%" border="0" cellpadding="4" cellspacing="1" bgcolor="#E0E0E0">
                        <tr class="textoContenidoMenor">
                          <td width="336" height="25" bgcolor="#F4F4F4">Producto</td>
                          <td width="96" height="25" bgcolor="#F4F4F4">Cantidad</td>
                          <td width="118" height="25" align="right" bgcolor="#F4F4F4">Precio Unitario (S/)</td>
                          <td width="121" height="25" align="right" bgcolor="#F4F4F4">Importe (S/)</td>
                          <td width="60" align="center" bgcolor="#F4F4F4">Eliminar</td>
                          </tr>
                        <?php $xtotal = 0; $num = 0; while($tmpFila = $sqltemp->fetch_row()){?>  
                        <tr class="textoContenidoMenor">
                          <td height="25" bgcolor="#FFFFFF"> <?php echo $tmpFila['2']; ?> </td>
                          <td height="25" align="center" bgcolor="#FFFFFF"><?php echo $tmpFila['3']; ?></td>
                          <td height="25" align="right" bgcolor="#FFFFFF"><?php echo $tmpFila['4']; ?></td>
                          <td height="25" align="right" bgcolor="#FFFFFF"><?php echo $tmpFila['5']; ?></td>
                          <td align="center" bgcolor="#FFFFFF"><button type="button"  onClick="window.location.href='include/venta/prg-venta-producto-quitar.php?idtmp=<?php echo $tmpFila['0'];?>';" class="btnmodificar tooltip" style="border:0px; background:#E1583E; cursor:pointer;" tooltip="Quitar"> <i class="fa fa-close"></i></button></td>
                        </tr>
                        <?php 
							$xtotal = $xtotal + $tmpFila['5']; 
							$num++;
							} 
						?>  

                      </table></td>
                  </tr>
                  <tr>
                    <td width="210" height="25">&nbsp;</td>
                    <td width="176" height="25">&nbsp;</td>
                    <td width="181" height="25">&nbsp;</td>
                    <td width="235" height="25" class="textoContenido">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="25" class="textoContenido">Tipo de Operación</td>
                    <td height="25" class="textoContenido">Forma de Pago</td>
                    <td height="25">&nbsp;</td>
                    <td height="25" class="textoContenido">Total a Pagar (S/)</td>
                  </tr>
                  <tr>
                    <td height="25" class="textoContenido">
                    	<label for="venta">
                        <input name="tipooperacion" type="radio" id="venta" value="1" checked onClick="return CambioOperacion();">
                      	Venta</label>
                        
                        <label for="cortesia">
                        <input type="radio" name="tipooperacion" id="cortesia" value="0" onClick="return CambioOperacion();">
                        Cortesía</label>
                        
                        </td>
                    <td height="25" class="textoContenido"><input name="txtformadepago" type="radio" id="radio3" value="1" checked>
                      Efectivo
                      <label for="tipooperacion2">
                        <input type="radio" name="txtformadepago" id="radio5" value="2">
                      </label>
                      <i class="fa fa-cc-visa fa-2x"></i></td>
                    <td height="25" align="right" class="textoContenido"><input name="txtnumregistro" type="hidden" id="txtnumregistro" value="<?php echo $num;?>"> <input name="txttotaltmp" type="hidden" id="txttotaltmp" value="<?php echo number_format($xtotal,2);?>"></td>
                    <td height="25" class="textoContenido"><input name="txttotal" type="text" class="textbox" id="txttotal" style="text-align:right; font-size:20px;" value="<?php echo number_format($xtotal,2);?>" readonly></td>
                  </tr>
                  <tr>
                    <td height="25">&nbsp;</td>
                    <td height="25">&nbsp;</td>
                    <td height="25">&nbsp;</td>
                    <td height="25" class="textoContenido">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="25" colspan="4"><div class="lineahorizontal" style="background:#EFEFEF;"></div></td>
                    </tr>
                  <tr>
                    <td height="30" class="textoContenido">Cliente</td>
                    <td height="30"><input name="txtidalquiler" type="hidden" id="txtidalquiler" value="<?php echo $xidalquiler; ?>">
                      <input name="txtidhabitacion" type="hidden" id="txtidhabitacion" value="<?php echo $xidhabitacion; ?>"></td>
                    <td height="30">&nbsp;</td>
                    <td><span class="textoContenido">Fecha</span></td>
                  </tr>
                  <tr>
                    <td height="30" colspan="3"><input name="txtcliente" type="text" class="textbox" id="txtcliente" style="width:80%;" value="CLIENTE">
                      <button type="button" onclick="abrirCliente(); return false" class="btnmodificar tooltip" tooltip="Buscar Cliente" style="border:0px; cursor:pointer;"> <i class="fa fa-search-plus"></i></button>
                      <input type="hidden" name="txtidcliente" id="txtidcliente"></td>
                    <td class="textoContenido"><input name="txtfecha" type="text" class="textbox" id="txtfecha" value="<?php echo Cfecha(date('Y-m-d'));?>" readonly></td>
                  </tr>
                  <tr>
                    <td height="25">&nbsp;</td>
                    <td height="25">&nbsp;</td>
                    <td height="25">&nbsp;</td>
                    <td height="25">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="25" colspan="2"><button type="submit" onClick="return validarDatos();" class="btnnegro" style="border:0px; cursor:pointer;"> <i class="fa fa-save"></i> Guardar </button>
                      <button type="button" onclick="window.location.href='venta.php';" class="btnnegro" style="border:0px; cursor:pointer;"> <i class="fa fa-remove"></i> Cancelar </button></td>
                    <td height="25">&nbsp;</td>
                    <td height="25">&nbsp;</td>
                  </tr>
                </tbody>
              </table>
            </form></td>
            </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td height="25" colspan="3"></td>
    </tr>
    <tr>
      <td height="25" colspan="3"></td>
    </tr>
  </tbody>
</table>
<blockquote>&nbsp;	</blockquote>

</body>
</html>
<?php include ("footer.php") ?>

<script type="text/javascript">
  
  $(function(){
    $("#txtservicio").hide();
   $("#optservicios").change(function (e) {

      e.preventDefault();
      $("#txtproducto").attr('disabled','disabled');
      $("#txtproducto").hide();
      $("#txtservicio").show();
      $("#txtservicio").removeAttr('disabled');
      $('#optservicios').prop('checked','checked');
      

    })

     $("#optproducto").change(function(e){

      e.preventDefault();
      $("#txtservicio").attr('disabled','disabled');
      $("#txtproducto").removeAttr('disabled');
      $('#optproducto').prop('checked','checked');
      $("#txtservicio").hide();
      $("#txtproducto").show();

    })

  })
</script>




