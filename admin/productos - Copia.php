<?php
include "validar.php";
include "config.php";
include "include/functions.php";
date_default_timezone_set('America/Lima');

$txtdato = $_POST['txtdato'];

if($txtdato==""){
	$sqlproducto = $mysqli->query("select
	idproducto,
	codigo,
	nombre,
	cantidad,
	cantidadminima,
	precio,
	precioventa,
	descripcion,
	estado
	from producto order by idproducto asc");
}else{
	$sqlproducto = $mysqli->query("select
	idproducto,
	codigo,
	nombre,
	cantidad,
	cantidadminima,
	precio,
	precioventa,
	descripcion,
	estado
	
	from producto 
	where nombre regexp '$txtdato|$txtdato.'
	order by idproducto asc");
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

    <tr>
      <td height="25" colspan="3"><?php include ("head.php"); ?></td>
    </tr>
    <tr>
      <td width="230" height="25" align="left" valign="top"><?php include ("menu_nav.php"); ?></td>
      <td width="21">&nbsp;</td>
      <td width="1125" valign="top"><table width="904" border="0" cellpadding="0" cellspacing="0">
       
          <tr>
            <td width="729" height="30"> <h3> <i class="fa fa-users"></i> Productos </h3></td>
            <td width="175" align="right"> 

            <button onclick="window.location.href = 'productos-editor.php';" class="btngris" style="border:0px; cursor:pointer;"> <i class="fa fa-plus-circle"></i> Nuevo </button> 
            
            </td>
          </tr>
          <tr>
            <td height="30" colspan="2"><table width="904" border="0" cellpadding="1" cellspacing="1">
             
                <tr>
                  <td height="30"><div class="lineahorizontal" style="background:#EFEFEF;"></div></td>
                </tr>
                <tr>
                  <td height="30"><form id="form1" name="form1" method="post">
                    <table width="900" border="0" cellpadding="1" cellspacing="1">

                        <tr>
                          <td width="65%"><input name="txtdato" type="text" class="textbox" id="txtdato" placeholder="Ingrese el nombre del producto"></td>
                          <td width="35%">
                          <button type="submit" class="btnnegro" style="border:0px; cursor:pointer;"> <i class="fa fa-search-plus"></i> Buscar </button> 
                          </td>
                        </tr>

                    </table>
                  </form></td>
                </tr>
                <tr>
                  <td height="10">
                  <?php if ($_SESSION['msgerror']!=""){ ?>
                  <div class="alert alert-success alert-dismissable textoContenidoMenor">
                  	<?php echo $_SESSION['msgerror'];$_SESSION['msgerror']="";?> 
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  </div>
                  <?php } ?>
                  </td>
              </tr>
                <tr>
                  <td height="30"><table width="900" border="0" cellpadding="4" cellspacing="1" bgcolor="#E0E0E0">
                    
                      <tr class="textoContenidoMenor">
                        <td width="40" height="25" bgcolor="#F4F4F4">&nbsp;</td>
                        <td width="110" height="25" bgcolor="#F4F4F4">Código</td>
                        <td width="265" height="25" bgcolor="#F4F4F4">Nombre</td>
                        <td width="58" height="25" bgcolor="#F4F4F4">Cantidad</td>
                        <td width="74" height="25" bgcolor="#F4F4F4">Cant. Mín.</td>
                        <td width="86" height="25" bgcolor="#F4F4F4">Precio</td>
                        <td width="85" height="25" bgcolor="#F4F4F4">Precio  Venta</td>
                        <td width="31" bgcolor="#F4F4F4">&nbsp;</td>
                        <td width="30" align="center" bgcolor="#F4F4F4">Est</td>
                        <td width="30" align="center" bgcolor="#F4F4F4">Edit</td>
                      </tr>
                      
                      <?php 
					  $num = 0;
					  while($xpFila = $sqlproducto->fetch_row()) { 
					  $num++;
					  ?>
                      <tr class="textoContenidoMenor">
                        <td height="25" align="center" bgcolor="#FFFFFF"><?php echo $num;?></td>
                        <td height="25" bgcolor="#FFFFFF"><?php echo $xpFila['1'];?></td>
                        <td height="25" bgcolor="#FFFFFF"><?php echo $xpFila['2'];?></td>
                        <td height="25" align="center" bgcolor="#FFFFFF"><?php echo $xpFila['3'];?></td>
                        <td height="25" align="center" bgcolor="#FFFFFF"><?php echo $xpFila['4'];?></td>
                        <td height="25" align="right" bgcolor="#FFFFFF"><?php echo $xpFila['5'];?></td>
                        <td height="25" align="right" bgcolor="#FFFFFF"><?php echo $xpFila['6'];?></td>
                        <td height="25" bgcolor="#FFFFFF">&nbsp;</td>
                        <td align="center" bgcolor="#FFFFFF"><button type="button" onClick="window.location.href='include/producto/prg_producto-modificaestado.php?xidparaestado=<?php echo $xpFila['0']."&estado=".$xpFila['8']?>';" class="btnestado tooltip" tooltip="Estado" style="border:0px; cursor:pointer; background:#<?php echo colorestado($xpFila['8']); ?>"> <i class="fa fa-angle-up"></i></button></td>
                        <td align="center" bgcolor="#FFFFFF"><button type="button" onclick="window.location.href='productos-editor.php?idprimario=<?php echo $xpFila['0'].'&estado=modifica';?>';" class="btnmodificar tooltip" tooltip="Modificar" style="border:0px; cursor:pointer;"> <i class="fa fa-edit"></i></button></td>
                      </tr>
                    
                    <?php
					  }
					  $sqlproducto->free();
					?>  
                    
                  </table></td>
                </tr>
                <tr>
                  <td height="30">&nbsp;</td>
                  </tr>
                <tr>
                  <td height="30">&nbsp;</td>
                </tr>
                <tr>
                  <td height="30">&nbsp;</td>
                </tr>
             
            </table></td>
            </tr>
  
      </table></td>
    </tr>
    <tr>
      <td height="25" colspan="3"></td>
    </tr>

</table>

</body>
</html>
<?php include ("footer.php") ?>