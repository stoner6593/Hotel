<?php
include "validar.php";
include "config.php";
include "include/functions.php";
date_default_timezone_set('America/Lima');

$txtbuscarpor = $_POST['txtbuscarpor'];
$txtdato = $_POST['txtdato'];

$sql = "select 
	huesped.idhuesped,
	huesped.nombre,
	huesped.nacimiento,
	huesped.documento,
	huesped.idestadocivil,
	huesped.ciudad,
	huesped.pais,
	huesped.procedencia,
	huesped.destino,
	huesped.comentarios,
	huesped.estado,
	
	estadocivil.idestadocivil,
	estadocivil.nombre,
	
	huesped.nograto
	
	from huesped inner join estadocivil on estadocivil.idestadocivil = huesped.idestadocivil ";


if($txtbuscarpor == 1 && $txtdato != ""){
	
	$sqlhuesped = $mysqli->query($sql." 
	where huesped.nombre regexp '$txtdato|$txtdato.'
	order by idhuesped asc");
	
}else if($txtbuscarpor == 2){
	
	$sqlhuesped = $mysqli->query($sql." 
	where huesped.documento  = '$txtdato'");
	
} else {
	$sqlhuesped = $mysqli->query($sql." 
	order by huesped.idhuesped asc Limit 0");
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
            <td width="729" height="30"> <h3 style="color:#E1583E;"> <i class="fa fa-users"></i> Huéspedes (Clientes)</h3></td>
            <td width="175" align="center"> 

            <button onclick="window.location.href = 'huespedes-editor.php';" class="btngris" style="border:0px; cursor:pointer;"> <i class="fa fa-plus-circle"></i> Nuevo </button> 
            
            </td>
          </tr>
          <tr>
            <td height="30" colspan="2"><table width="100%" border="0" cellpadding="1" cellspacing="1">
             
                <tr>
                  <td height="30"><div class="lineahorizontal" style="background:#BFBFBF;"></div></td>
                </tr>
                <tr>
                  <td height="30"><form id="form1" name="form1" method="post">
                    <table width="99%" border="0" cellpadding="1" cellspacing="1">

                        <tr>
                          <td width="22%">
                            <input name="txtbuscarpor" type="radio" id="rddni" value="2" checked>
                            <label for="rddni" class="textoContenidoMenor"> DNI/CE </label>
                          <input name="txtbuscarpor" type="radio" id="rdnombre" value="1">  <label for="rdnombre" class="textoContenidoMenor"> Nombre </label></td>
                          <td width="46%"><input name="txtdato" type="text" class="textbox" id="txtdato" placeholder="Ingrese el dato a buscar"></td>
                          <td width="32%">
                          <button type="submit" class="btnnegro" style="border:0px; cursor:pointer;"> <i class="fa fa-search-plus"></i> Buscar </button> 
                          </td>
                        </tr>

                    </table>
                  </form></td>
                </tr>
                <tr>
                  <td height="20">
                  <?php if ($_SESSION['msgerror']!=""){ ?>
                  <div class="alert alert-success alert-dismissable textoContenidoMenor">
                  	<?php echo $_SESSION['msgerror'];$_SESSION['msgerror']="";?> 
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  </div>
                  <?php } ?></td>
              </tr>
                <tr>
                  <td height="30"><table width="99%" border="0" cellpadding="4" cellspacing="1" bgcolor="#E0E0E0">
                    <tr class="textoContenidoMenor">
                      <td width="50" height="25" align="center" bgcolor="#F4F4F4">#</td>
                      <td width="346" height="25" bgcolor="#F4F4F4">Nombre</td>
                      <td width="58" height="25" align="center" bgcolor="#F4F4F4">Edad</td>
                      <td width="98" height="25" bgcolor="#F4F4F4">Doc.</td>
                      <td width="131" height="25" bgcolor="#F4F4F4">Ciudad</td>
                      <td width="148" bgcolor="#F4F4F4">País</td>
                      <td width="63" height="25" align="center" bgcolor="#F4F4F4">NoGrato</td>
                      <td width="47" align="center" bgcolor="#F4F4F4">Hist</td>
                      <td width="46" bgcolor="#F4F4F4" align="center">Edit</td>
                    </tr>
                    <?php
						$item = 0;
						while ($xhFila = $sqlhuesped->fetch_row())
						{		
						$item++;
					?>
                    <tr class="<?php if($xhFila['13']==1){echo 'textoContenidoMenorRojo';}else{echo 'textoContenidoMenor';} ?>">
                      <td height="25" align="center" bgcolor="#FFFFFF"><?php echo $item; ?></td>
                      <td height="25" align="left" bgcolor="#FFFFFF"><?php echo $xhFila['1']; ?></td>
                      <td height="25" align="center" bgcolor="#FFFFFF"><?php echo edad($xhFila['2']); ?></td>
                      <td height="25" bgcolor="#FFFFFF" align="left"><?php echo $xhFila['3']; ?></td>
                      <td height="25" bgcolor="#FFFFFF" align="left"><?php echo $xhFila['5']; ?></td>
                      <td align="left" bgcolor="#FFFFFF"><?php echo $xhFila['6']; ?></td>
                      <td height="25" bgcolor="#FFFFFF" align="center"><?php if($xhFila['13']==1){echo "<img src='imagenesv/desactivo.gif'/>";} ?></td>
                      <td align="center" bgcolor="#FFFFFF"><button type="button" onclick="window.location.href='huespedes-historial.php?xidhuesped=<?php echo $xhFila['0']?>';"class="btnestado tooltip" style="border:0px; cursor:pointer; background:#333333;"  tooltip="Historial del Huésped"> <i class="fa fa-table"></i></button></td>
                      <td align="center" bgcolor="#FFFFFF"><button type="button" onclick="window.location.href='huespedes-editor.php?idprimario=<?php echo $xhFila['0'].'&estado=modifica';?>';" class="btnmodificar tooltip" style="border:0px; cursor:pointer;" tooltip="Modificar"> <i class="fa fa-edit"></i> </button></td>
                    </tr>
                    <?php
						}
						$sqlhuesped->free();
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




