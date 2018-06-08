<?php
session_start();
include "validar.php";
include "config.php";
include "include/functions.php";
date_default_timezone_set('America/Lima');
$xusuarioingresado = $_SESSION['xyzidusuario'];
$nombreusuario = $_SESSION['xyznombre'].' ('.$_SESSION['xyzusuario'].') ';
 
 $sqlusuario = $mysqli->query("select
 	user_id,
	user_user,
	user_nombre,
	user_categoria
	from usuario where user_id = '$xusuarioingresado'
 	");
	$uFila = $sqlusuario->fetch_row();
 
//echo $xusuarioingresado ;
$sqlconsulta = $mysqli->query("select 
	ingresosturno.idturno,
	ingresosturno.idusuario,
	ingresosturno.estadoturno,
	
	usuario.user_id,
	usuario.user_user,
	usuario.user_nombre,
	usuario.user_categoria
	
	from ingresosturno inner join usuario on usuario.user_id = ingresosturno.idusuario
	where ingresosturno.estadoturno = 1");
	
	$numero = $sqlconsulta->num_rows;
	//echo $numero."<br><br>";
	
	$xuFila = $sqlconsulta->fetch_row();
	
	
	
	$xidusuario = $xuFila['3'];
	$xusuario = $xuFila['4'];
	$xusuarionombre = $xuFila['5'];
	
	
	$xidturno = $xuFila['0'];
	$_SESSION['idturno'] = $xuFila['0'];
	
	$abrirturno = 0;
	
	if ($numero==1){
		
		if($xidusuario <> $xusuarioingresado){
			$msg = "Hay un turno abierto con el usuario <br> <strong>".$xusuarionombre." (".$xusuario.")"." </strong> <br> Si requiere cambiar de usuario, antes debe cerrar el turno. <br><br>"."<a href='salir.php' class='btnrojo' style='width:100%; color:#FFFFFF; padding:20px; font-size:18px;'> Salir  </a>";
			$_SESSION['estadomenu'] = 0;
		}else{
			$msg = "Hay un turno abierto con el usuario <br> <strong>".$xusuarionombre." (".$xusuario.")"." </strong> <br> Si requiere cambiar de usuario, antes debe cerrar el turno. <br><br>"."<a href='reporte.php?xidturno=$xidturno' class='btnrojo' style='width:100%; color:#FFFFFF; padding:10px; font-size:18px;'> Cerrar Turno  </a>";
			$_SESSION['estadomenu'] = 1;
			$_SESSION['estadoturno'] = 1;
		}	
	} else {
		$msg = "Para iniciar el trabajo debe abrir un Turno con el Usuario: <br> <strong>".$nombreusuario;
		
		$link = "</strong> <a href='include/usuario/prg_abrir-turno.php?idusuario=$xusuarioingresado' class='btnrojo' style='width:100%; color:#FFFFFF; padding:10px; font-size:18px;'> Abrir Turno </a>";
		
		$_SESSION['estadomenu'] = 0;
		$abrirturno = 1;
	}
	
	
	$xuscategoria = $uFila["3"];
	if($xuscategoria == 1) {
		$msg = "Ha ingresado como Administrador. <br><br>"."Hay un turno abierto con el usuario <br> <strong>".$xusuarionombre." (".$xusuario.")"." </strong> <br><br> Le recomendamos no generar ordenes de Producto ni alquiler de habitaciones cuando está trabajando un Turno.";
		$_SESSION['estadomenu'] = 1;
	}
	
	
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Administrador</title>

<?php include "head-include.php"; ?>

<script>
	
	function validarDatos() { 
		var Lstturno = parseInt(document.form1.txtturno.value);
		
		if (Lstturno == 0 ) {  
		alert("Seleccione el Turno a trabajar."); 
		document.form1.txtturno.focus();
		return false  
		}
	
		return true; 
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
        <tbody>
          <tr>
            <td width="1099" height="30"><h3 style="color:#E1583E;"> <i class="fa fa-users"></i> Bienvenido </h3> </td>
            </tr>
          <tr>
            <td height="30"><div class="lineahorizontal" style="background:#BFBFBF;"></div></td>
            </tr>
          <tr>
            <td height="30" align="center" valign="middle">&nbsp;</td>
            </tr>
          <tr>
            <td height="30" align="center" valign="middle"><table width="387" border="0" cellspacing="0" cellpadding="0">
              <tbody>
                <tr>
                  <td width="387" height="25" align="center"><span class="textoContenido"><?php echo $msg; ?></span></td>
                </tr>
                <tr>
                  <td height="25" align="center">&nbsp;</td>
                </tr>
                <tr>
                  <td height="25" align="center">
                  	<?php if($abrirturno==1){?>
                  	<form name="form1" method="post" action="include/usuario/prg_abrir-turno.php?idusuario=<?php echo $xusuarioingresado;?>">
                    <p>
                      <select name="txtturno" id="txtturno" class="textbox" style="width:100%; font-size:18px; text-align:center;">
                        <option value="0"> Seleccione el Turno </option>
                        <option value="1"> Día </option>
                        <option value="2"> Noche </option>
                      </select>
                    </p>
					<input type="submit" name="enviar" value="Abrir Turno" class="btnrojo" onClick="return validarDatos();"  style="width:100%; color:#FFFFFF; padding:10px; font-size:18px; border:0px; cursor:pointer;">
                    
                  	</form>
    				<?php } ?>              
                  </td>
                </tr>
                <tr>
                  <td height="25" align="center">&nbsp;</td>
                </tr>
                <tr>
                  <td height="25" align="center">&nbsp;</td>
                </tr>
                <tr>
                  <td height="25" align="center">&nbsp;</td>
                </tr>
              </tbody>
            </table></td>
          </tr>
        </tbody>
      </table></td>
    </tr>
    <tr>
      <td height="25" colspan="3">&nbsp;</td>
    </tr>
  </tbody>
</table>
<?php include "footer.php"; ?>
</body>
</html>