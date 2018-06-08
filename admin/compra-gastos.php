<?php
include "validar.php";
include "config.php";
include "include/functions.php";
date_default_timezone_set('America/Lima');

$xidturno = $_SESSION['idturno'];

$txtdato = $_POST['txtdato'];

if($txtdato==""){
	$sqlproducto = $mysqli->query("select
	idgasto,
	nombre,
	cantidad,
	monto,
	descripcion,
	fechayhora,
	estadoturno,
	usuario,
	descripcion,
	idturno
	
	from gasto where estadoturno = 1 and idturno = '$xidturno' order by idgasto asc");
}else{
	$sqlproducto = $mysqli->query("select
	idgasto,
	nombre,
	cantidad,
	monto,
	descripcion,
	fechayhora,
	estadoturno,
	usuario,
	descripcion,
	idturno
	
	from gasto 
	where estadoturno = 1 and nombre regexp '$txtdato|$txtdato.' 
	and idturno = '$xidturno' order by idgasto asc");
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
      <td width="185" height="25" align="left" valign="top"><?php include ("menu_nav.php"); ?></td>
      <td width="25">&nbsp;</td>
      <td width="810" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
       
          <tr>
            <td width="525" height="30"> <h3 style="color:#E1583E;"> <i class="fa fa-shopping-basket"></i> Registro de Compras Gastos / Stock</h3> </td>
            <td width="285" align="center"> 

            <button onclick="window.location.href = 'compra-gastos-editor.php';" class="btngris" style="border:0px; cursor:pointer;"> <i class="fa fa-plus-circle"></i> Registrar Compra / Gasto </button> 
            
            </td>
          </tr>
          <tr>
            <td height="30" colspan="2"><table width="100%" border="0" cellpadding="1" cellspacing="1">
             
                <tr>
                  <td height="30"><div class="lineahorizontal" style="background:#EFEFEF;"></div></td>
                </tr>
                <tr>
                  <td height="30"><form id="form1" name="form1" method="post">
                    <table width="100%" border="0" cellpadding="1" cellspacing="1">

                        <tr>
                          <td width="65%"><input name="txtdato" type="text" class="textbox" id="txtdato" placeholder="Ingrese el nombre del producto o servicio"></td>
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
                  <td height="30"><table width="100%" border="0" cellpadding="4" cellspacing="1" bgcolor="#E0E0E0">
                    
                      <tr class="textoContenidoMenor">
                        <td width="45" height="25" align="center" bgcolor="#F4F4F4">#</td>
                        <td width="272" height="25" bgcolor="#F4F4F4">Nombre</td>
                        <td width="58" height="25" align="center" bgcolor="#F4F4F4">Cantidad </td>
                        <td width="92" height="25" align="right" bgcolor="#F4F4F4">Monto (S/)</td>
                        <td width="80" align="center" bgcolor="#F4F4F4">Fecha</td>
                        <td width="81" align="center" bgcolor="#F4F4F4">Usuario </td>
                        <td width="208" align="left" bgcolor="#F4F4F4">Anotaciones</td>
                      </tr>
                      
                      <?php 
					  $num = 0;
					  while($xpFila = $sqlproducto->fetch_row()) { 
					  $num++;
					  ?>
                      <tr class="textoContenidoMenor">
                        <td height="25" align="center" bgcolor="#FFFFFF"><?php echo $num;?></td>
                        <td height="25" bgcolor="#FFFFFF"><?php echo $xpFila['1'];?></td>
                        <td height="25" align="center" bgcolor="#FFFFFF"><?php echo $xpFila['2'];?></td>
                        <td height="25" align="right" bgcolor="#FFFFFF"><?php echo number_format($xpFila['3'],2);?></td>
                        <td align="center" bgcolor="#FFFFFF"><?php echo Cfecha($xpFila['5']);?></td>
                        <td height="25" align="center" bgcolor="#FFFFFF"><?php echo $xpFila['7'];?></td>
                        <td align="left" bgcolor="#FFFFFF"><?php echo $xpFila['8'];?></td>
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