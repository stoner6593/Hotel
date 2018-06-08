<?php
include "validar.php";
include "config.php";
include "include/functions.php";
date_default_timezone_set('America/Lima');

$xidusuario = $_GET['xidusuario'];
$xestado = $_GET['estado'];

$sqlusuario = $mysqli->query("select
	user_id,
	user_nombre,
	user_dni,
	user_user,
	user_password,
	user_categoria,
	user_estado
	from usuario order by user_id asc ");

if($xestado=='modifica'){
	$sqlusuariomod = $mysqli->query("select
	user_id,
	user_nombre,
	user_dni,
	user_user,
	user_password,
	user_categoria,
	user_estado
	from usuario where user_id = '$xidusuario'");
	$usFila = $sqlusuariomod->fetch_row();
}

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
  <tbody>
    <tr>
      <td height="25" colspan="3"><?php include ("head.php"); ?></td>
    </tr>
    <tr>
      <td width="230" height="25" align="left" valign="top"><?php include ("menu_nav.php"); ?></td>
      <td width="21">&nbsp;</td>
      <td width="1125" valign="top"><table width="850" border="0" cellpadding="0" cellspacing="0">
        <tbody>
          <tr>
            <td width="610" height="30"> <h3> <i class="fa fa-user"></i> Usuarios </h3> <div class="lineahorizontal" style="background:#EFEFEF;"></div> </td>
            <td width="240">&nbsp;</td>
          </tr>
          <tr>
            <td height="30" colspan="2"><table width="850" border="0" cellpadding="0" cellspacing="0">
              <tbody>
                <tr>
                  <td height="10" colspan="4">
                  <form id="form1" name="form1" method="post" action="<?php if($xestado=='modifica'){echo 'include/usuario/prg_usuario-modifica.php';}else{echo 'include/usuario/prg_usuario-nuevo.php';}?>">
                    <table width="850" border="0" cellpadding="0" cellspacing="0">
                      <tbody>
                        <tr>
                          <td width="271" height="30"><span class="textoContenido">Nombre
                            <input name="txtidusuario" type="hidden" id="txtidusuario" value="<?php echo $usFila['0'];?>">
                          </span></td>
                          <td width="304" height="30"><span class="textoContenido">DNI</span></td>
                          <td width="275"><span class="textoContenido">Categoría</span></td>
                        </tr>
                        <tr>
                          <td height="30"><input name="txtnombre" type="text" class="textbox" id="txtnombre" value="<?php echo $usFila['1'];?>"></td>
                          <td height="30"><input name="txtdni" type="text" class="textbox" id="textfield4" value="<?php echo $usFila['2'];?>"></td>
                          <td>
                          
                          <select name="txtcategoria" id="txtcategoria" class="textbox">
                            <?php if($usFila['5']==1){?>
                            <option value="1" selected>Administrador</option>
                            <option value="2">Recepción</option>
                            <?php } elseif($usFila['5']==2){?>
                            <option value="1">Administrador</option>
                            <option value="2" selected>Recepción</option>
                            <?php } else{?>
                            <option value="1">Administrador</option>
                            <option value="2" selected>Recepción</option>
                            <?php } ?>
                          </select>
                          
                          </td>
                        </tr>
                        <tr>
                          <td height="30"><span class="textoContenido">Usuario (Acceso al Sistema)</span></td>
                          <td height="30"><span class="textoContenido">Contraseña</span></td>
                          <td height="30">&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="30"><input name="txtusuario" type="text" class="textbox"  value="<?php echo $usFila['3'];?>" autocomplete="off"></td>
                          <td height="30"><input name="txtcontrasena" type="password" class="textbox" autocomplete="off"></td>
                          <td height="30" align="center">
                          
                          <?php if($xestado=='modifica'){ ?>
                          <button type="submit" class="btnrojo" style="border:0px; cursor:pointer;"> <i class="fa fa-save"></i> Actualizar </button>
                          <?php }else{ ?>
                          <button type="submit" class="btnrojo" style="border:0px; cursor:pointer;"> <i class="fa fa-save"></i> Guardar </button>
                          <?php } ?>
                          
                          <a href="usuarios.php" class="btnnegro" style="color:#FFFFFF;"> Cancelar </a>
                          
                          </td>
                        </tr>
                        <tr>
                          <td height="10">&nbsp;</td>
                          <td height="10" class="textoContenidoMenor"> <?php if($xestado=='modifica'){ ?> Modificar solo si desea cambiar la contraseña. <?php } ?></td>
                          <td height="10">&nbsp;</td>
                        </tr>
                      </tbody>
                    </table>
                  </form></td>
                </tr>
                <tr>
                  <td height="10" colspan="4"><?php if ($_SESSION['msgerror']!=""){ ?>
                    <div class="alert alert-success alert-dismissable textoContenidoMenor"> <?php echo $_SESSION['msgerror'];$_SESSION['msgerror']="";?> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> </div>
                    <?php } ?></td>
                  </tr>
                <tr>
                  <td height="30" colspan="4">&nbsp;</td>
                </tr>
                <tr>
                  <td height="30" colspan="4"><table width="850" border="0" cellpadding="4" cellspacing="1" bgcolor="#E0E0E0">
                      <tr class="textoContenidoMenor">
                        <td width="51" height="25" bgcolor="#F4F4F4">&nbsp;</td>
                        <td width="239" height="25" bgcolor="#F4F4F4">Nombre</td>
                        <td width="105" height="25" bgcolor="#F4F4F4">DNI</td>
                        <td width="156" height="25" bgcolor="#F4F4F4">Usuario</td>
                        <td width="147" height="25" bgcolor="#F4F4F4">Categoría</td>
                        <td width="33" align="center" bgcolor="#F4F4F4">Est</td>
                        <td width="45" align="center" bgcolor="#F4F4F4">Edit</td>
                        </tr>
                      <?php 
					  $num= 0; 
					  while($uFila = $sqlusuario->fetch_row()) {
						  $num++;
					  ?>
                      <tr class="textoContenidoMenor">
                        <td height="25" align="center" bgcolor="#FFFFFF"><?php echo $num;?></td>
                        <td height="25" bgcolor="#FFFFFF"><?php echo $uFila['1'];?></td>
                        <td height="25" bgcolor="#FFFFFF"><?php echo $uFila['2'];?></td>
                        <td height="25" bgcolor="#FFFFFF"><?php echo $uFila['3'];?></td>
                        <td height="25" bgcolor="#FFFFFF"><?php if($uFila['5']==1){echo "Administrador";} elseif($uFila['5']==2){echo "Recepción";}?></td>
                        <td height="35" align="center" bgcolor="#FFFFFF">
                        <button type="button" class="btnestado" style="border:0px; cursor:pointer; background:#<?php echo $xhFila['13']; ?>"> <i class="fa fa-angle-up"></i></button>
                        </td>
                        <td height="35" align="center" bgcolor="#FFFFFF">
                        <?php if($_SESSION['xyztipo']=='1'):?>
                          <button type="button" onclick="window.location.href='usuarios.php?xidusuario=<?php echo $uFila['0'].'&estado=modifica';?>';" class="btnmodificar" style="border:0px; cursor:pointer;"> <i class="fa fa-edit"></i></button>
                         <?php endif;?> 
                        </td>
                        </tr>
					  <?php } ?>
                  </table></td>
                  </tr>
                <tr>
                  <td width="224" height="30">&nbsp;</td>
                  <td width="188" height="30">&nbsp;</td>
                  <td width="195" height="30">&nbsp;</td>
                  <td width="195" height="30">&nbsp;</td>
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




