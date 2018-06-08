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
	habitaciontipo.preciohuespedadicionaldos,
	
	habitaciontipo.ingresoanticipado
	
	from habitacion inner join habitaciontipo on habitaciontipo.idtipo = habitacion.idtipo
	where habitacion.idhabitacion = $xidhabitacion and habitaciontipo.idtipo = habitacion.idtipo ");
	
	$xhFila = $sqlhabitacion->fetch_row();
	$nroadicional = $xhFila['6']; //Ocupantes Adicionales permitidos
	$ingresoanticipado = $xhFila['17']; //Costo Ingreso Anticipado
	$fechahoy = Cfecha(date('Y-m-d'));
	
$sqlhabitacionprecio = $mysqli->query("select
		idhabitacion,
		piso,
		numero,
		idtipo,
		
		preciodiariodj,
		preciohorasdj,
		preciodiariovs,	
		preciohorasvs,
		
		nrohuespedes,
		nroadicional,	
		
		costopersonaadicional,
		costohoraadicional,
		
		caracteristicas,
		idestado,
		idalquiler,
		ubicacion
		from habitacion where idhabitacion = $xidhabitacion");
		$haFila = $sqlhabitacionprecio->fetch_row();

	//CONTROLAR ENTRE SEMANA Y FIN DE SEMANA
	//Domingo=0 - Lunes=1 - Martes=2 - Miercoles=3 - Jueves=4 - Viernes=5 - Sabado=6
	$fecha = date("Y-m-d H:i:s");
	$dia = date('w', strtotime($fecha));
	$hora = date('H:i',strtotime($fecha));
	$horamedia = date('H:i', strtotime('08:00:00'));
	
	//Uso de Switch Case
	//Uso de Switch Case
	switch ($dia) {
    case 0:
        if($hora > $horamedia){
			//echo "Tarifa 1 - Domingo";
			$xpreciodiario = $haFila['4'];
			$xpreciohora = $haFila['5'];
			$xpreciohoraadicional = $haFila['10'];
			$xpreciohuespedadicional = $haFila['11'];
		}else{
			//echo "Tarifa 2 - Domingo";
			$xpreciodiario = $haFila['6'];
			$xpreciohora = $haFila['7'];
			$xpreciohoraadicional = $haFila['10'];
			$xpreciohuespedadicional = $haFila['11'];
		};
        break;
	case 1:
	case 2:
	case 3:
	case 4:
		//echo "Tarifa 1 - Jueves";
		$xpreciodiario = $haFila['4'];
		$xpreciohora = $haFila['5'];
		$xpreciohoraadicional = $haFila['10'];
		$xpreciohuespedadicional = $haFila['11'];
		break;
	case 5:
		if($hora > $horamedia){
			//echo "Tarifa 2 - Viernes";
			$xpreciodiario = $haFila['6'];
			$xpreciohora = $haFila['7'];
			$xpreciohoraadicional = $haFila['10'];
			$xpreciohuespedadicional = $haFila['11'];
		}else{
			//echo "Tarifa 1 - Viernes";
			$xpreciodiario = $haFila['4'];
			$xpreciohora = $haFila['5'];
			$xpreciohoraadicional = $haFila['10'];
			$xpreciohuespedadicional = $haFila['11'];
		};
		break;
	case 6:
		//echo "Tarifa 2 - Sabado";
		$xpreciodiario = $haFila['6'];
		$xpreciohora = $haFila['7'];
		$xpreciohoraadicional = $haFila['10'];
		$xpreciohuespedadicional = $haFila['11'];
		break;
	}
	//Uso de Switch Case
	
	/*
	if($xdia >= 0 && $xdia <= 4){
		//Aplicar Precio Uno
		$nombreprecio = "Aplica Precios Entre Semana";
		
		$xpreciodiario = $xhFila['9'];
		$xpreciohora = $xhFila['10'];
		$xpreciohoraadicional = $xhFila['11'];
		$xpreciohuespedadicional = $xhFila['12'];

		
	}elseif ($xdia >= 5 && $xdia <= 6) {
		//Aplicar Precio Dos
		$nombreprecio = "Aplica Precios Fin Semana";
		
		$xpreciodiario = $xhFila['13'];
		$xpreciohora = $xhFila['14'];
		$xpreciohoraadicional = $xhFila['15'];
		$xpreciohuespedadicional = $xhFila['16'];
	}
	*/
	
$sqlproducto = $mysqli->query("select
	idproducto,
	nombre,
	precioventa,
	estado
	from producto order by idproducto asc");

	$desdeactualizando = $_GET['desdeactualizando'];
	if($desdeactualizando != "si"){
		$sSQL = "delete from ventas_tmp";
		if($mysqli->query($sSQL)){}
		$sSQL = "delete from alquilerhabitacion_detalle_tmp";
		if($mysqli->query($sSQL)){}
		$tmp = "Eliminado";
	}

$sqltemp = $mysqli->query("select id, idproducto,nombre,cantidad,precio,importe from ventas_tmp order by id asc");

/////NUEVA LINEA DE CODIGO
$sqlalquilertmp = $mysqli->query("select
	idtmp,
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
	total,
	cantidad
	
	from alquilerhabitacion_detalle_tmp
	order by idtmp asc");

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
		});
		$("#ocultar").click(function(){
			$('.div1').hide("linear");
		});
	});
</script>



<script>
	function calculartipoOperacion(){
		var Lsttipooperacion = parseInt(document.form1.txttipooperacion.value);
		var Lstmontotmp = parseFloat(document.form1.txttotaltmp.value);
		
		if(Lsttipooperacion == 1){
			document.form1.txtcostototal.value = formatCurrency(parseFloat(Lstmontotmp).toFixed(2));
		}else{
			document.form1.txtcostototal.value = formatCurrency(parseFloat(0.00).toFixed(2));
		}
	}

	function calcularPrecioHoras(){	
		var Lstnroadicional = parseInt(document.form1.txtocupantesadicionaleshoras.value);
		var costoadicionalhoras = parseFloat(document.form1.txtprecioadicionalhora.value);
		var costohora = parseFloat(document.form1.txtcostohoras.value);
		var costototalproducto = parseFloat(document.form1.txttotalproducto.value);
		
		document.form1.txtcostototalhoras.value = formatCurrency(parseFloat(costototalproducto + costohora + (Lstnroadicional*costoadicionalhoras)).toFixed(2));
	}
	
	function calcularPrecioDias(){
		var Lstnrodias = parseInt(document.form1.txtnrodias.value);
		var costodiario = parseFloat(document.form1.txtcostodiario.value);
		document.form1.txtcostototal.value = formatCurrency(parseFloat(Lstnrodias*costodiario).toFixed(2));
	}
	
	function validarDatos() { 
		if (espacioVacio(document.form1.txtcliente.value) == false ) {  
		alert("Seleccione un Huésped (Cliente)"); 
		document.form1.txtcliente.focus();
		return false  
		}
		return true; 
	}

	function mostrando(){
		document.getElementById('efectivo').style.display = 'inline-block';
		document.getElementById('visa').style.display = 'inline-block';
	}
		
	function ocultando(){
		document.getElementById('efectivo').style.display = 'none';
		document.getElementById('visa').style.display = 'none';
	}
	
	function calcularpagocompartido() {
		var costoadividir = parseFloat(document.form1.txtcostototal.value);
		var	costodividido = parseFloat(costoadividir/2);
			
			document.form1.txtmontoefectivo.value = costodividido.toFixed(2);
			document.form1.txtmontovisa.value = costodividido.toFixed(2);
	}
	
	function compararmontos(){
		var totalhoras = parseFloat(document.form1.txtcostototalhoras.value);
		var totaldia = parseFloat(document.form1.txtcostototal.value);
		var tipoalquiler = parseInt(document.form1.txttipoalquiler.value);
		
		var montoefectivo = parseFloat(document.form1.txtmontoefectivo.value);
		var montovisa = parseFloat(document.form1.txtmontovisa.value);
		var montototalcompartido = (montoefectivo + montovisa);
		
		var formapago = parseInt(document.form1.txtformadepago.value);
		
		if(formapago==3){
			if(tipoalquiler == 1){
				if (montototalcompartido > totalhoras || montototalcompartido < totalhoras){
					alert("La suma del Pago en Efectivo y Visa no coincide con el Total.");
					return false;
				}
			}else if(tipoalquiler == 2){
				if (montototalcompartido > totaldia || montototalcompartido < totaldia){
					alert("La suma del Pago en Efectivo y Visa no coincide con el Total.");
					return false;
				}
			}
		}
		return true;
		
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
      <td width="1125" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
       
          <tr>
            <td width="280" height="30"> <h3 style="color:#E1583E;"> <i class="fa fa-users"></i> Alquilar Habitación</h3></td>
            <td width="526" align="right">
            
			<?php if($xestadohabitacion == 1){?>
            <button type="button" onclick="window.location.href='include/habitacion/prg_habitacion-mantenimiento.php?txtidprimario=<?php echo $xidhabitacion;?>';" class="btngris" style="border:0px; cursor:pointer; background:#44A6ED;color:#FFFFFF;"> <i class="fa fa-info-circle"></i> Cambiar a Mantenimiento </button>
            <?php }else if ($xestadohabitacion == 4){ ?>
            <button type="button" onclick="window.location.href='include/habitacion/prg_habitacion-disponible.php?txtidprimario=<?php echo $xidhabitacion;?>';" class="btngris" style="border:0px; cursor:pointer; background:#44A6ED;color:#FFFFFF;"> <i class="fa fa-info-circle"></i> Habitación:<strong> <?php echo $xnrohabitacion;?></strong> en Mantenimiento. ¿Cambiar a Disponible?</button>
            <?php } ?></td>
            <td width="102" align="center"> <button type="button" onclick="window.location.href='control-habitaciones.php';" class="btngris" style="border:0px; cursor:pointer;"> <i class="fa fa-arrow-left"></i> Volver </button> </td>
          </tr>
          <tr>
            <td height="30" colspan="3"><table width="100%" border="0" cellpadding="1" cellspacing="1">
             
                <tr>
                  <td height="30" align="right"><div class="lineahorizontal" style="background:#BFBFBF;"></div></td>
              </tr>
                <tr>
                  <td height="30"><form id="form1" name="form1" method="post" action="include/alquiler/prg_alquiler-nuevo.php" onSubmit="return validarDatos();">
                  	
                    <table width="100%" border="0" cellpadding="1" cellspacing="1">
                      <tbody>
                        <tr>
                          <td width="894" height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                              <tr>
                                <td width="6%" height="40"><span class="textoContenido">Cliente</span></td>
                                <td width="53%" height="40">
                                <input name="txtcliente" type="text" class="textbox" id="txtcliente" style="width:75%;" value="<?php echo $_SESSION['xcliente'];?>" readonly>
                                  
                                  <button type="button" onclick="abrirCliente(); return false" class="btnmodificar tooltip" tooltip="Seleccionar Huésped" style="border:0px; cursor:pointer;"> <i class="fa fa-search-plus"></i></button>
							       <button type="button" onclick="window.location.href='huespedes-editor.php?xdesdealquiler=1&<?php echo 'idhabitacion='.$xidhabitacion.'&nrohabitacion='.$xnrohabitacion.'&xestado='.$xestadohabitacion.'&idtipohab='.$idtipohab;?>';" class="btnmodificar tooltip" tooltip="Agregar Huésped" style="border:0px; cursor:pointer;"> <i class="fa fa-plus-square"></i></button>                                  
                                  <input name="txtidcliente" type="hidden" id="txtidcliente" value="<?php echo $_SESSION['xidcliente'];?>"></td>
                                <td width="26%" height="40" align="center"><span class="textoContenido"><strong><?php echo $tFila['1'];?> N° </strong></span><span class="textoContenido" style="font-size:28px;color:#00A230;"> <?php echo $xnrohabitacion;?></span>
                                  <input name="txtidhabitacion" type="hidden" id="txtidhabitacion" value="<?php echo $xidhabitacion;?>">
                                  <input name="txtnrohabitacion" type="hidden" id="txtnrohabitacion" value="<?php echo $xnrohabitacion;?>">
                                  <input name="txtidtipohabitacion" type="hidden" id="txtidtipohabitacion" value="<?php echo $idtipohab;?>"></td>
                                <td width="15%" align="center">
									<a href="#" id="mostrar" class="btnmodificar"> <i class="fa fa-chevron-down"></i> </a>  
                                    <a href="#" id="ocultar" class="btnmodificar"> <i class="fa fa-chevron-up"></i> </a>
                              </tr>
                            </tbody>
                          </table></td>
                        </tr>
                        <tr>
                          <td height="30" bgcolor="#FFFFFF" class="textoContenido"><div class="lineahorizontal" style="background:#00A230;"></div></td>
                        </tr>
                        <tr>
                          <td height="30" bgcolor="#FFFFFF">
                          
							<div class="div1" style="display:none;">
                              <table width="100%" border="0" cellpadding="1" cellspacing="1">
                                <tbody>
                                  <tr>
                                    <td width="894" height="30" bgcolor="#FFFFFF" class="textoContenido"><table width="100%" border="0" cellpadding="1" cellspacing="1">
                                      <tr>
                                        <td width="200" height="30" bgcolor="#FFFFFF" ><span class="textoContenido" style="color:#00A230;"><strong>  <i class="fa fa-clock-o  fa-lg"></i> Alquiler por Horas </strong></span></td>
                                        <td width="211" height="30" bgcolor="#FFFFFF"><input name="txtcostohoras" type="text" class="textbox" id="txtcostohoras" style="text-align:right; width:85%;" value="<?php echo $xpreciohora;?>" readonly ></td>
                                        <td width="356" height="30"><h3 class="textoContenido" style="margin:0px; padding:0px;">(Por 6 horas)
                                          
                                        </h3></td>
                                        <td width="156"><span class="textoContenido" style="margin:0px; padding:0px;">
                                          Cortesía
                                          <span class="textoContenido" style="margin:0px; padding:0px;">
                                          <input name="txtcortesiahoras" type="checkbox" id="txtcortesiahoras" value="1">
                                          </span> </span></td>
                                        <td width="150" align="center" bgcolor="#FFFFFF">
                                          
                                          <button type="button" class="btnnegro" style="border:0px; cursor:pointer;" onClick="document.form1.action='include/alquiler/prg_alquiler-nuevo-tmp.php?idtipo=1'; document.form1.submit()";> <i class="fa fa-plus-square"></i> Agregar </button>
                                          
                                        </td>
                                        
                                      </tr>
                                    </table></td>
                                  </tr>
                                  <tr>
                                    <td height="30" bgcolor="#FFFFFF" class="textoContenido"><div class="lineahorizontal" style="background:#00A230;"></div></td>
                                  </tr>
                                  <tr>
                                    <td height="30" bgcolor="#FFFFFF" class="textoContenido"><table width="100%" border="0" cellpadding="1" cellspacing="1">
                                      <tr>
                                        <td width="200" height="30" bgcolor="#FFFFFF" ><span class="textoContenido" style="color:#00A230;"><strong> <i class="fa fa-clock-o  fa-lg"></i>  Huésped Adicional</strong></span></td>
                                        <td width="363" height="30"><h3 class="textoContenido" style="margin:0px; padding:0px;">Costo Ocupante Adicional (S/ <?php echo $xpreciohuespedadicional;?>+)
                                          <input name="txtprecioadicionalhora" type="hidden" id="txtprecioadicionalhora" value="<?php echo $xpreciohuespedadicional;?>">
                                        </h3></td>
                                        <td bgcolor="#FFFFFF"><select name="txtocupantesadicionaleshoras" id="txtocupantesadicionaleshoras" onChange="return calcularPrecioHoras();" class="textbox" >
                                          <?php for ($i=1; $i<=$nroadicional; $i++){?>
                                          <option><?php echo $i; ?></option>
                                          <?php } ?>
                                        </select></td>
                                        <td width="150" align="center" bgcolor="#FFFFFF"><button type="button" class="btnnegro" style="border:0px; cursor:pointer;" onClick="document.form1.action='include/alquiler/prg_alquiler-nuevo-tmp.php?idtipo=4'; document.form1.submit()";> <i class="fa fa-plus-square"></i> Agregar </button></td>
                                      </tr>
                                    </table></td>
                                  </tr>
                                  <tr>
                                    <td height="30" bgcolor="#FFFFFF" class="textoContenido"><div class="lineahorizontal" style="background:#00A230;"></div></td>
                                  </tr>
                                  <tr>
                                    <td height="30" bgcolor="#FFFFFF" class="textoContenido"><table width="100%" border="0" cellspacing="1" cellpadding="1">
                                      <tbody>
                                        <tr>
                                          <td width="199" bgcolor="#FFFFFF" class="textoContenido">&nbsp;</td>
                                          <td width="136" bgcolor="#FFFFFF" class="textoContenido">Costo Diario (S/) </td>
                                          <td width="145" height="25"> Fecha de Entrada</td>
                                          <td width="152" height="25">Fecha de Salida</td>
                                          <td height="25" colspan="2">Nro de Días</td>
                                          <td width="152" height="25"><h3 style="margin:0px; padding:0px;">&nbsp;</h3></td>
                                        </tr>
                                        <tr>
                                          <td><span class="textoContenido" style="color:#FFAF03;"><strong> <i class="fa fa-calendar  fa-lg"></i> Alquiler por Día</strong></span></td>
                                          <td><input name="txtcostodiario" type="text" class="textbox" id="txtcostodiario" style="text-align:right; width:75%;" value="<?php echo $xpreciodiario;?>" readonly ></td>
                                          <td width="145" height="25" align="center"><input name="txtfechadesde" type="text" class="textbox" id="datepicker" value="<?php echo $fechahoy;?>" readonly style="width:width:75%;"></td>
                                          <td width="152" height="25"><input name="txtfechahasta" type="text" class="textbox" id="datepickerdos" value="<?php echo $fechahoy;?>" readonly style="width:75%;"></td>
                                          <td width="138" height="25"><select name="txtnrodias" id="txtnroocupantes4" class="textbox" onChange="return calcularPrecioDias();" style="width:55%;">
                                            <option selected="selected">1</option>
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
                                          <td width="145"><span class="textoContenido" style="margin:0px; padding:0px;">Cortesía</span>                                            <input name="txtcortesiadias" type="checkbox" id="txtcortesiadias" value="1"></td>
                                          <td width="152" height="25" align="center">
                                            
                                            <button type="button" class="btnnegro" style="border:0px; cursor:pointer;" onClick="document.form1.action='include/alquiler/prg_alquiler-nuevo-tmp.php?idtipo=2'; document.form1.submit()";> <i class="fa fa-plus-square"></i> Agregar </button>
                                            
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table></td>
                                  </tr>
                                  <tr>
                                    <td height="30" bgcolor="#FFFFFF" class="textoContenido"><div class="lineahorizontal" style="background:#00A230;"></div></td>
                                  </tr>
                                  <tr>
                                    <td height="30" bgcolor="#FFFFFF" class="textoContenido"><table width="100%" border="0" cellpadding="1" cellspacing="1">
                                      <tr>
                                        <td width="200" height="30" bgcolor="#FFFFFF" ><span class="textoContenido" style="color:#FFAF03;"><strong>  <i class="fa fa-calendar  fa-lg"></i> Ingreso Anticipado</strong></span></td>
                                        <td width="212" height="30" bgcolor="#FFFFFF"><input name="txtcostoingresoanticipado" type="text" class="textbox" id="txtcostoingresoanticipado" style="text-align:right; width:85%;" value="<?php echo $ingresoanticipado;?>" readonly ></td>
                                        <td width="505" height="30"><h3 class="textoContenido" style="margin:0px; padding:0px;">&nbsp;</h3></td>
                                        <td width="159" align="center" bgcolor="#FFFFFF"><button type="button" class="btnnegro" style="border:0px; cursor:pointer;" onClick="document.form1.action='include/alquiler/prg_alquiler-nuevo-tmp.php?idtipo=5'; document.form1.submit()";> <i class="fa fa-plus-square"></i> Agregar </button></td>
                                      </tr>
                                    </table></td>
                                  </tr>
                                  <tr>
                                    <td height="30"><div class="lineahorizontal" style="background:#00A230;"></div></td>
                                  </tr>
                                </tbody>
                              </table>
                            </div></td>
                        </tr>
                        <tr>
                          <td height="30"><table width="100%" border="0" cellspacing="1" cellpadding="1">
                          
                              <tr class="textoContenido">
                                <td width="6%" height="25" align="center">#</td>
                                <td width="39%" height="25">Concepto</td>
                                <td width="28%" height="25">Precio de Hoy (S/ ) sujeto a variación</td>
                                <td width="15%">Total (S/ )</td>
                                <td width="12%" height="25">&nbsp;</td>
                              </tr>
                              <tr>
                                <td height="25" colspan="5"><div class="lineahorizontal" style="background:#00A230;"></div></td>
                              </tr>
                              <?php while ($tmpFila = $sqlalquilertmp->fetch_row()){ $num++; ?>
                              <tr class="textoContenidoMenor">
                                <td height="25" align="center" class="textoContenido"><?php echo $num;?></td>
                                <td height="25">
								  <span class="textoContenido">
								  <?php 
								$xprecioalquiler = $xprecioalquiler + $tmpFila['18'];
								echo tipoAlquiler($tmpFila['1']).' ('.$tmpFila['19'].')';
								if($tmpFila['1'] != 4 &&  $tmpFila['1'] != 5){
									echo fechadesdehasta($tmpFila['2'],$tmpFila['3']);
								}
								?>
                                </span></td>
                                <td height="25" align="center" class="textoContenido"><?php echo number_format($tmpFila['17'],2);?></td>
                                <td height="25" align="center" class="textoContenido"><?php echo number_format($tmpFila['18'],2);?></td>
                                <td height="25" align="center">
								
                                <?php $xidtmp = $tmpFila['0'];?>
                                <button type="button"  onClick="document.form1.action='include/alquiler/prg_alquiler-eliminar-tmp.php?idtmp=<?php echo $xidtmp; ?>'; document.form1.submit(); return confirm('¿Confirma Eliminar?'); "; class="btnquitar" style="border:0px; cursor:pointer;"> <i class="fa fa-close"></i> </button></td>
                              </tr>
                              <?php } ?>
                         
                          </table></td>
                        </tr>
                        <tr>
                          <td height="30"><input name="txtnumeroalquiler" type="hidden" id="txtnumeroalquiler" value="<?php echo $num;?>">
                          <input name="txtcostototalhabitacion" type="hidden" id="txtcostototalhabitacion" value="<?php echo $xprecioalquiler;?>"></td>
                        </tr>
                        <tr>
                          <td height="34"><div class="lineahorizontal" style="background:#FFAF03; margin-bottom:3px;"></div></td>
                        </tr>
                        <tr>
                          <td height="34"><table width="100%" border="0" cellpadding="1" cellspacing="1">
                            <tr>
                              <td width="99" height="30" bgcolor="#FFFFFF" class="textoContenido"><span class="textoContenido" style="color:#FFAF03;"><strong>Consumo</strong></span></td>
                              <td width="430" height="30" bgcolor="#FFFFFF"><span class="textoContenido">
                                <input type="input" list="producto" name="txtproducto" autocomplete="off" class="textbox" placeholder="Ingrese el nombre del Producto ej: Coca Cola">
                                <datalist id="producto">
                                  <?php while($urow = $sqlproducto->fetch_assoc()) { ?>
                                  <option id="<?php echo $urow['idproducto']; ?>" value="<?php echo $urow['nombre']; ?>" label="<?php echo 'S/ '.$urow['precioventa'];?>"></option>
                                  <?php } ?>
                                </datalist>
                              </span></td>
                              <td width="136" height="30"><h3 class="textoContenido" style="margin:0px; padding:0px;">
                                <input name="txtcantidad" type="text" class="textbox" id="txtcantidad" style="text-align:right; width:80%;" value="1" >
                                <input name="txtmando" type="hidden" id="txtmando" value="grabar">
                              </h3></td>
                              <td width="222" bgcolor="#FFFFFF">
                              <?php if($xestadohabitacion!=4){?>
                              <button type="button" class="btnrojo" style="border:0px; cursor:pointer;" onClick="document.form1.action='venta.php?desde=alquiler&idhabitacion=<?php echo $xidhabitacion.'&nrohabitacion='.$xnrohabitacion.'&xestado='.$xestadohabitacion.'&idtipohab='.$idtipohab;?>'; document.form1.submit()";> <i class="fa fa-plus-square"></i> Agregar </button>
                              <?php } ?>
                              </td>
                            </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td height="56"><table width="99%" border="0" cellpadding="4" cellspacing="1" bgcolor="#FFFFFF">
                            <tr class="textoContenidoMenor">
                              <td width="336" height="23" bgcolor="#FFFFFF">Producto</td>
                              <td width="96" height="23" bgcolor="#FFFFFF">Cantidad</td>
                              <td width="118" height="23" align="right" bgcolor="#FFFFFF">Precio Unitario (S/)</td>
                              <td width="121" height="23" align="right" bgcolor="#FFFFFF">Importe (S/)</td>
                              <td width="60" align="center" bgcolor="#FFFFFF">Eliminar</td>
                            </tr>
                            
                            <tr class="textoContenidoMenor">
                              <td height="25" colspan="5" bgcolor="#FFFFFF"><div class="lineahorizontal" style="background:#FFAF03; margin-bottom:3px;"></div></td>
                              </tr>
                            <?php $xprodtotal = 0; $num = 0; while($tmpFila = $sqltemp->fetch_row()){?>
                            <tr class="textoContenidoMenor">
                              <td height="25" bgcolor="#FFFFFF"><?php echo $tmpFila['2']; ?></td>
                              <td height="25" align="center" bgcolor="#FFFFFF"><?php echo $tmpFila['3']; ?></td>
                              <td height="25" align="right" bgcolor="#FFFFFF"><?php echo $tmpFila['4']; ?></td>
                              <td height="25" align="right" bgcolor="#FFFFFF"><?php echo $tmpFila['5']; ?></td>
                              <td align="center" bgcolor="#FFFFFF">
                              
                              <button type="button"  onClick="window.location.href='include/venta/prg-venta-producto-quitar.php?idtmp=<?php echo $tmpFila['0'].'&desde=alquiler&idhabitacion='.$xidhabitacion.'&nrohabitacion='.$xnrohabitacion.'&xestado='.$xestadohabitacion.'&idtipohab='.$idtipohab.'&xidcliente='.$_SESSION['xidcliente'].'&xcliente='.$_SESSION['xcliente'];?>';" class="btnmodificar tooltip" style="border:0px; background:#E1583E; cursor:pointer;" tooltip="Quitar"> <i class="fa fa-close"></i></button></td>
                            	
                            </tr>
                            <?php
							$_SESSION['xcliente']="";
							$_SESSION['xidcliente']=""; 
							
							$xprodtotal = $xprodtotal + $tmpFila['5']; 
							$num++;
							} 
						?>
                          </table>
                          <input name="txtnumeroproducto" type="hidden" id="txtnumeroproducto" value="<?php echo $num;?>">
                          <input name="txtcostototalproducto" type="hidden" id="txtcostototalproducto" value="<?php echo $xprodtotal;?>"></td>
                        </tr>
                        <tr>
                          <td height="72"><table width="100%" border="0" cellspacing="1" cellpadding="1">
                            <tbody>
                              <tr>
                                <td height="25" colspan="4"><div class="lineahorizontal" style="background:#00A230;"></div></td>
                              </tr>
                              <tr>
                                <td height="62"><span class="textoContenido">Forma de Pago 
                                  <label for="radio3">
                                    <input name="txtformadepago" type="radio" id="radio3" value="1" checked onClick="ocultando();">
                                    Efectivo </label>
                                  <input name="txtmontoefectivo" type="text" class="textbox" id="efectivo" style="text-align:right; width:50px; display:none;" value="<?php echo $xpreciohora;?>" onBlur="document.form1.txtmontoefectivo.value = formatCurrency(txtmontoefectivo.value);" onFocus = "txtmontoefectivo.value = EliminarComa(this.value)">
                                  <label for="radio5">
                                    <input type="radio" name="txtformadepago" id="radio5" value="2" onClick="ocultando();">
                                    Tarjeta
                                    <input  name="txtmontovisa" type="text" class="textbox" id="visa" style="text-align:right; width:50px; display:none;" value="<?php echo $xpreciohora;?>"   onBlur="document.form1.txtmontovisa.value = formatCurrency(txtmontovisa.value);" onFocus = "txtmontovisa.value = EliminarComa(this.value)">
                                  </label>
                                  <label for="radio4">
                                    <input type="radio" name="txtformadepago" id="radio4" value="3" onClick="mostrando();calcularpagocompartido();">
                                    Ambas Formas </label>
                                </span></td>
                                <td width="131"><input name="txttotalproducto" type="hidden" id="txttotalproducto" value="<?php echo $xprodtotal;?>"></td>
                                <td width="106" height="62"><span class="textoContenido">Total a Cobrar 
                                  <input name="txttotaltmp" type="hidden" id="txttotaltmp" value="<?php echo number_format(($xprecioalquiler+$xprodtotal),2);?>">
                                </span></td>
                                <td width="208" height="62"><input name="txtcostototal" type="text" class="textbox" id="txtcostototal" style="text-align:right; font-size:18px; background:#E4F8F9;" value="<?php echo number_format(($xprecioalquiler+$xprodtotal),2);?>" readonly></td>
                              </tr>
                            </tbody>
                          </table></td>
                        </tr>
                        <tr>
                          <td><textarea name="txtcomentarios" class="textbox" id="txtcomentarios" style="width:97%; line-height:30px;" placeholder="Si el alquiler es una Cortesía indicar los comentarios de quién autoriza."></textarea></td>
                        </tr>
                        <tr>
                          <td><div class="lineahorizontal" style="background:#EFEFEF;"></div></td>
                        </tr>
                        <tr>
                          <td height="30">                          
                            
                            <?php if($xestado=="modifica"){?>
                            <button type="submit" class="btnrojo" style="border:0px; cursor:pointer;" onClick="return validarDatos();"> <i class="fa fa-refresh"></i> Actualizar </button>
                            <?php 
							}else{
								if($xestadohabitacion!=4){
							?>
                            
                            
                            <button type="submit" class="btnnegro" style="border:0px; cursor:pointer;" onClick="return compararmontos(); return validarDatos();"> <i class="fa fa-save"></i> Guardar </button>
                            
                            <?php 
							}
							} 
							?>
                            
                            <button type="button" onclick="window.location.href='control-habitaciones.php';" class="btnnegro" style="border:0px; cursor:pointer;"> <i class="fa fa-remove"></i> Cancelar </button>                    
                            
                          </td>
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

<?php
$_SESSION['xidcliente'] = "";
$_SESSION['xcliente'] = "";
?>

</body>
</html>
<?php include ("footer.php") ?>




