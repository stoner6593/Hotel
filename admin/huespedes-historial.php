<?php
include "validar.php";
include "config.php";
include "include/functions.php";
date_default_timezone_set('America/Lima');

$xidhuesped = $_GET['xidhuesped'];

$sqlhuesped = $mysqli->query("select 
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
	
	from huesped inner join estadocivil on estadocivil.idestadocivil = huesped.idestadocivil 
	where huesped.idhuesped = '$xidhuesped' ");

$hFila = $sqlhuesped->fetch_row();

$sqlalquiler = $mysqli->query("select
	alquilerhabitacion.idalquiler,
	alquilerhabitacion.idhuesped,
	alquilerhabitacion.idhabitacion,
	alquilerhabitacion.nrohabitacion,
	alquilerhabitacion.nroorden,
	alquilerhabitacion.fecharegistro,
	alquilerhabitacion.estadoalquiler,
	alquilerhabitacion.idusuario,
	alquilerhabitacion.total,
	
	usuario.user_id,
	usuario.user_nombre
	
	from alquilerhabitacion inner join usuario on usuario.user_id = alquilerhabitacion.idusuario  where idhuesped = '$xidhuesped' order by fecharegistro desc");


?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Administrador</title>


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
	
	function ImprimirOrden(){ 
        window.open('imprimir/print_historialcliente.php?xidhuesped=<?php echo $xidhuesped;?>','modelo','width=1000, height=350, scrollbars=yes' );
    }

</script>

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
            <td width="729" height="30"> <h3 style="color:#E1583E;"> <i class="fa fa-users"></i> Historial de Huésped (Cliente)</h3></td>
            <td width="175" align="center"> 

             <a href="huespedes.php" class="btngris">  <i class="fa fa-arrow-left"></i> Volver </a>
            
            </td>
          </tr>
          <tr>
            <td height="30" colspan="2"><table width="100%" border="0" cellpadding="1" cellspacing="1">
             
                <tr>
                  <td height="30"><div class="lineahorizontal" style="background:#BFBFBF;"></div></td>
                </tr>
                <tr>
                  <td height="30"><table width="99%" border="0" cellpadding="1" cellspacing="1">
                    <tr>
                      <td> 
                      <h3> <?php echo $hFila['1'];?> </h3> 
                      <p class="textoContenido"> 
					  <?php 
					  	echo 'DNI: <strong>'.$hFila['3'].'</strong> <br>'; 
						echo 'Nacimiento: <strong>'.Cfecha($hFila['2']).'</strong> <br>'; 
						echo 'Ciudad: <strong>'.$hFila['5'].'</strong> <br>';
						echo 'País: <strong>'.$hFila['6'].'</strong> <br>'; 
						echo 'Procedencia: <strong>'.$hFila['7'].'</strong> <br>';
						echo 'Destino: <strong>'.$hFila['8'].'</strong> <br> <br>';	
						echo 'Comentarios: <br>'.$hFila['9'].'<br>';
					  ?> 
                      </p>
                      </td>
                      <td width="32%"><a href="#" onClick="ImprimirOrden(); return false" class="btnrojo"> <i class="fa fa-print"></i> Imprimir </a> <a href="huespedes.php" class="btnnegro"> <i class="fa fa-close"></i> Salir </a></td>
                    </tr>
                  </table></td>
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
                  <td height="30" class="textoContenido"><strong>Historial de Alquiler de Habitaciones</strong></td>
              </tr>
                <tr>
                  <td height="30"><table width="99%" border="0" cellpadding="4" cellspacing="1" bgcolor="#E0E0E0">
                    <tr class="textoContenidoMenor">
                      <td width="45" height="25" align="center" bgcolor="#F4F4F4">#</td>
                      <td width="135" align="center" bgcolor="#F4F4F4">Fecha Hora de Entrada</td>
                      <td width="135" align="center" bgcolor="#F4F4F4">Fecha Hora de Salida</td>
                      <td width="135" height="25" align="center" bgcolor="#F4F4F4">Habitación</td>
                      <td width="101" align="center" bgcolor="#F4F4F4"># Orden </td>
                      <td width="99" align="center" bgcolor="#F4F4F4">Estado</td>
                      <td width="99" align="center" bgcolor="#F4F4F4">Usuario Registrante</td>
                      <td width="110" align="center" bgcolor="#F4F4F4">Detalle</td>
                    </tr>
                    <?php
						$item = 0;
						while ($xaFila = $sqlalquiler->fetch_row())
						{		
						$item++;
					?>
                    <tr class="textoContenidoMenor">
                      <td height="25" align="center" bgcolor="#FFFFFF"><?php echo $item; ?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php $fecha  = strtotime($xaFila['5']); echo Cfecha($xaFila['5']).' - '.date('H:i',$fecha); ?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php $fecha  = strtotime($xaFila['5']); echo Cfecha($xaFila['5']).' - '.date('H:i',$fecha); ?></td>
                      <td height="25" align="center" bgcolor="#FFFFFF"><?php echo $xaFila['3']; ?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $xaFila['4'];?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php if($xaFila['10'] == 1){ echo 'En uso';}else{echo 'Finalizado';}?></td>
                      <td align="center" bgcolor="#FFFFFF"><?php echo $xaFila['10'];?></td>
                      <td align="center" bgcolor="#FFFFFF"><button type="button" onclick="window.location.href='huespedes-historial-detalle.php?idalquiler=<?php echo $xaFila['0'].'&idhabitacion='.$xaFila['2'].'&historia=1'?>';" class="btnestado" style="border:0px; cursor:pointer; background:#333333;"> <i class="fa fa-table"></i></button></td>
                    </tr>
                    <?php
						}
						$sqlalquiler->free();
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




