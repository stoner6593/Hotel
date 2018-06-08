<?php
session_start();
include "validar.php";
include "include/functions.php";

include "config.php";
$nombrecliente = $_GET['nombrecliente'];
$idhabitacion = $_GET['idhabitacion'];
$idalquiler = $_GET['idalquiler'];
$idcliente = $_GET['idcliente'];

//echo $idalquiler;

$sqladicional = $mysqli->query("select
	idpersona,
	idalquiler,
	idcliente,
	nombre,
	dni,
	nacimiento
	
	from alquiler_personaadicional where idalquiler = '$idalquiler'
	order by idpersona asc")

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Administrador</title>
<?php include "head-include.php"; ?>

</head>
<body OnLoad="form1.txtdato.focus()">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="100%" height="25" valign="middle" bgcolor="#FFFFFF"><form name="form1" method="post" action="include/alquiler/prg_persona-adicional.php?idalquiler=<?php echo $idalquiler.'&idhabitacion='.$idhabitacion.'&nombrecliente='.$nombrecliente.'&idcliente='.$idcliente;?>"> 

      <table width="100%" border="0" cellpadding="1" cellspacing="1">
        <tr>
          <td width="33%"><p>
            <label for="rdtipo2" class="textoContenidoMenor"> </label>
            <span class="textoContenido"><strong>Personas Adicionales</strong></span></p></td>
          <td width="19%" class="textoContenidoMenor">&nbsp;</td>
          <td width="20%" class="textoContenidoMenor">&nbsp;</td>
          <td width="28%">&nbsp;</td>
        </tr>
        <tr>
          <td width="33%" class="textoContenidoMenor">Nombres y Apellidos</td>
          <td width="19%" class="textoContenidoMenor">DNI</td>
          <td class="textoContenidoMenor">Fecha de Nacimiento</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><input name="txtnombre" type="text" class="textbox" id="txtnombre"></td>
          <td><input name="txtdni" type="text" class="textbox" id="txtdni"></td>
          <td><input name="txtnacimiento" type="text" class="textbox" id="txtnacimiento">
            <input name="mando" type="hidden" id="mando" value="si"></td>
          <td><button type="submit" class="btnnegro" style="border:0px; cursor:pointer;"> <i class="fa fa-save"></i> Guardar </button></td>
        </tr>
      </table>
      <label></label>
    </form>    </td>
  </tr>
  <tr>
    <td height="77" valign="top" bgcolor="#FFFFFF">
	<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#F0F0F0">
        <tr class="textoContenidoMenor">
          <td width="5%" height="25" bgcolor="#F4F4F4" ><div align="center"><strong>#</strong></div></td>
          <td width="38%" height="25" align="left" valign="middle" bgcolor="#F4F4F4" ><div align="left">Nombres y Apellidos</div></td>
          <td width="31%" align="left" valign="middle" bgcolor="#F4F4F4" ><div align="left">DNI </div></td>
          <td width="15%" height="25" align="left" valign="middle" bgcolor="#F4F4F4" ><div align="center">Fecha de Nacimiento</div></td>
          <td width="11%" height="25" bgcolor="#F4F4F4" ><div align="center"></div></td>
        </tr>
	  <?php
	$suma =0;		
	while($aFila = $sqladicional->fetch_row())
	{
		$suma++;
	?>
        <tr class="textoContenidoMenor">
          <td height="25" bgcolor="#FFFFFF" class="textoContenidoNegro"><div align="center"><? echo $suma; ?></div></td>
          <td height="25" bgcolor="#FFFFFF" class="textoContenidoNegro"><?php echo $aFila['3'];?></td>
          <td bgcolor="#FFFFFF" class="textoContenidoNegro"><?php echo $aFila['4'];?></td>
          <td height="25" bgcolor="#FFFFFF" class="textoContenidoNegro" align="center"><?php echo $aFila['5'];?></td>
          <td height="25" bgcolor="#FFFFFF" class="textoContenidoNegro"><div align="center">
            
            <a href="#" onclick='entregar(<? echo $Fila['0'];?> , "<?php echo $Fila['1']; ?>")' class="btnestado"> <i class="fa fa-check"></i> </a>
            
          </div></td>
        </tr>	
<?php
}
$sqladicional->free();
$mysqli->close()
?>
    </table></td>
  </tr>
  <tr>
    <td height="19" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
</table>
</body>
</html>