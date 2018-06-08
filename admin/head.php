<?php
date_default_timezone_set('America/Lima');
session_start();
include "validar.php";
?>

<link href="estilo.css" rel="stylesheet" type="text/css">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="100%" height="59" bgcolor="#515151" class="nombreTitulo"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td width="135" align="center" valign="middle"><img src="../imagenesv/logohotelcentralinnmovil2.png" alt=""/></td>
          <td width="220" align="center" valign="middle"><h3 style="color:#FFFFFF;"> Administración de Hotel </h3></td>
          <td width="645" align="right"><table width="306" border="0" cellspacing="0" cellpadding="0">
            <tbody>
              <tr>
                <td width="40" height="25">
                	<span class="fa-stack" style="color:#E1583E;">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-user fa-stack-1x" style="color:#FFFFFF;"></i>
                    </span>
                </td>
                <td width="266" height="25"><span class="textoContenido" style="color:#FFFFFF;"> <?php echo $_SESSION['xyznombre'].' ('.$_SESSION['xyzusuario'].')';?> </span> </td>
                </tr>
            </tbody>
          </table>
          
          
          
          </td>
        </tr>
        
    </table></td>
  </tr>
</table>
