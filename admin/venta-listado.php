<?php
include "validar.php";
include "config.php";
include "include/functions.php";

$xdato = $_POST['txtproducto'];
$xmando = $_POST['txtmando'];

$xidturno = $_SESSION['idturno'];

$sqlconsulta = $mysqli->query("select
	idventa,
	numero,
	cliente,
	fecha,
	hora,
	total,
	operacion,
	formapago,
	estado,
	estadoturno,
	idusuario,
	idturno
	
	from venta where estadoturno = 1 and idturno = '$xidturno' order by idventa desc");
	
	
	
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Administrador</title>
<link href="opera.css" rel="stylesheet" type="text/css">

<?php include "head-include.php"; ?>

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
      <td width="810" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tbody>
          <tr>
            <td width="729" height="30"><h3 style="color:#E1583E;"> <i class="fa fa-shopping-basket"></i> Lista de Venta de Productos de Turno</h3> </td>
            <td width="175" align="center" valign="middle"><button type="button" onclick="window.location.href='venta.php';" class="btngris" style="border:0px; cursor:pointer;"> <i class="fa fa-arrow-left"></i> Volver </button></td>
          </tr>
          <tr>
            <td height="30" colspan="2"> <div class="lineahorizontal" style="background:#EFEFEF;"></div> </td>
            </tr>
          <tr>
            <td height="10" colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td height="30" colspan="2"><table width="99%" border="0" cellpadding="4" cellspacing="1" bgcolor="#E0E0E0">
              <tr class="textoContenidoMenor">
                <td width="31" height="25" align="center" bgcolor="#F4F4F4">#</td>
                <td width="59" bgcolor="#F4F4F4">Ticket</td>
                <td width="181" bgcolor="#F4F4F4">Cliente</td>
                <td width="146" height="25" bgcolor="#F4F4F4">Fecha/Hora</td>
                <td width="60" height="25" align="right" bgcolor="#F4F4F4">Operación</td>
                <td width="49" height="25" align="right" bgcolor="#F4F4F4">F. Pago</td>
                <td width="62" align="right" bgcolor="#F4F4F4">Monto S/</td>
                <td width="57" align="right" bgcolor="#F4F4F4">Estado</td>
                <td width="73" align="right" bgcolor="#F4F4F4">Usuario</td>
                <td width="38" align="center" bgcolor="#F4F4F4">Anular</td>
                <td width="44" align="center" bgcolor="#F4F4F4">Detalle</td>
              </tr>
              <?php $num = 0; while($vFila = $sqlconsulta->fetch_row()){ $num++;?>
              <tr class="textoContenidoMenor">
                <td height="25" align="center" bgcolor="#FFFFFF"><?php echo $num; ?></td>
                <td height="25" bgcolor="#FFFFFF"><?php echo $vFila['1']; ?></td>
                <td height="25" align="left" bgcolor="#FFFFFF"><?php echo $vFila['2']; ?></td>
                <td height="25" align="center" bgcolor="#FFFFFF"><?php echo Cfecha($vFila['3']).' - '.$vFila['4']; ?></td>
                <td height="25" align="right" bgcolor="#FFFFFF"><?php echo tipoOperacion($vFila['6']); ?></td>
                <td height="25" align="right" bgcolor="#FFFFFF"><?php echo formaPago($vFila['7']); ?></td>
                <td height="25" align="right" bgcolor="#FFFFFF"><?php echo number_format($vFila['5'],2); ?></td>
                <td height="25" align="right" bgcolor="#FFFFFF"><?php echo estadoPago($vFila['8']); ?></td>
                <td height="25" align="right" bgcolor="#FFFFFF"><?php echo $vFila['10']; ?></td>
                <td align="center" bgcolor="#FFFFFF">
                	
                    <?php if($vFila['8'] != 0){ ?>
                	<button type="button"  onClick="window.location.href='venta-anularventa.php?xidventa=<?php echo $vFila['0'].'&anulacion=1';?>';" class="btnmodificar tooltip" style="border:0px; background:#999999; cursor:pointer;" tooltip="Anular Venta"> <i class="fa fa-close"></i></button>
                    <?php } ?>
                    </td>
                <td align="center" bgcolor="#FFFFFF"><button type="button"  onClick="window.location.href='venta-completada.php?xidventa=<?php echo $vFila['0'].'&detalle=1'; ?>';" class="btnmodificar tooltip" style="border:0px; background:#00A230; cursor:pointer;" tooltip="Ver dentalle"> <i class="fa fa-check"></i></button></td>
              </tr>
              <?php } ?>
            </table></td>
            </tr>
          <tr>
            <td height="30" colspan="2">&nbsp;</td>
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




