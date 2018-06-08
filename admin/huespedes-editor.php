<?php
include "validar.php";
include "config.php";
include "include/functions.php";
date_default_timezone_set('America/Lima');

//Cuando viene desde alquiler
$xdesdealquiler = $_GET['xdesdealquiler'];
$idhabitacion = $_GET['idhabitacion'];
$nrohabitacion = $_GET['nrohabitacion'];
$xhabestado = $_GET['xestado'];
$idtipohab = $_GET['idtipohab'];

if($xdesdealquiler==1){
	$linkretorno = "alquilar.php?idhabitacion=".$idhabitacion."&nrohabitacion=".$nrohabitacion."&xestado=".$xhabestado."&idtipohab=".$idtipohab;
}else{
	$linkretorno = 	"huespedes.php";
}


$xidprimario = $_GET['idprimario'];
$xestado = $_GET['estado'];

$sqlestadocivil = $mysqli->query("select 
	idestadocivil,
	nombre
	from estadocivil order by idestadocivil asc");

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
	huesped.nograto,
  huesped.tipo_documento
	
	from huesped 
	where huesped.idhuesped = '$xidprimario'");

$xhFila = $sqlhuesped->fetch_row();
	
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Administrador</title>

<?php  include "head-include.php"; ?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />    

</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">

    <tr>
      <td height="25" colspan="3"><?php include ("head.php"); ?></td>
    </tr>
    <tr>
      <td width="185" height="25" align="left" valign="top"><?php include ("menu_nav.php"); ?></td>
      <td width="25">&nbsp;</td>
      <td width="793" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
       
          <tr>
            <td width="638" height="30"> <h3 style="color:#E1583E;"> <i class="fa fa-users"></i> Huéspedes / Editor</h3></td>
            <td width="155" align="center"> <button type="button" onclick="window.location.href='<?php echo $linkretorno;?>';" class="btngris" style="border:0px; cursor:pointer;"> <i class="fa fa-arrow-left"></i> Volver </button> </td>
          </tr>
          <tr>
            <td height="30" colspan="2"><table width="100%" border="0" cellpadding="1" cellspacing="1">
             
                <tr>
                  <td height="30">
                  <div class="lineahorizontal" style="background:#BFBFBF;"></div><br>
                  
				  <?php if ($_SESSION['msgerror']!=""){ ?>
                  <div class="alert alert-danger alert-dismissable textoContenidoMenor">
                  	<?php echo $_SESSION['msgerror'];$_SESSION['msgerror']="";?> 
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  </div>
                  <?php } ?>
                  
                  </td>
                </tr>
                <tr>
                  <td height="30"><form id="form1" name="form1" method="post" action="<?php if($xestado=="modifica"){echo 'include/huesped/prg_huesped-modifica.php';}else{echo 'include/huesped/prg_huesped-nuevo.php';}?>">
                    <table width="99%" border="0" cellpadding="1" cellspacing="1">
                      <tbody>
                        <tr>
                          <td width="221" height="30"><span class="textoContenido">
                            Tipo de Documento:  </span>                      
                          </td>
                          <td>
                            <select name="tipo_documento" id="tipo_documento" required class="form-control">
                              <option value="0">DOC.TRIB.NO.DOM.SIN.RUC</option>
                              <option value="1">DOC. NACIONAL DE IDENTIDAD</option>
                              <option value="4">CARNET DE EXTRANJERIA</option>
                              <option value="6">REG. UNICO DE CONTRIBUYENTES</option>
                              <option value="7">PASAPORTE</option>
                              <option value="A">CED. DIPLOMATICA DE IDENTIDAD</option>
                            </select>
                          </td>
                          </tr>
                          <tr>
                            <td height="30"><span class="textoContenido">Documento (*)</span></td>
                            <td height="30"><input name="txtdocumento" autocomplete="false" readonly type="text" class="form-control" id="txtdocumento" required value="<?php echo $xhFila['3']?>">
                               <i class="" id="espera"></i> 
                            </td>
                          </tr>
                        <tr>
                          <td width="221" height="30"><span class="textoContenido">Nombre
                            <input name="txtidprimario" type="hidden" id="txtidprimario" value="<?php echo $xhFila['0']?>">
                            <input name="txtdesdealquiler" type="hidden" id="txtdesdealquiler" value="<?php echo $xdesdealquiler;?>">
                            <input name="idhabitacion" type="hidden" id="idhabitacion" value="<?php echo $idhabitacion;?>">
                            <input name="nrohabitacion" type="hidden" id="nrohabitacion" value="<?php echo $nrohabitacion;?>">
                          	<input name="xestado" type="hidden" id="xestado" value="<?php echo $xhabestado;?>">
                          	<input name="idtipohab" type="hidden" id="idtipohab" value="<?php echo $idtipohab;?>">
                          	</span>
                          </td>
                          <td width="221" height="30"><span class="textoContenido">Nacimiento</span></td>
                          
                          <td width="221" height="30"><span class="textoContenido">Estado Civil</span></td>
                        </tr>
                        <tr>
                          <td width="221" height="30"><input name="txtnombre" type="text" class="form-control" id="txtnombre" value="<?php echo $xhFila['1']?>"></td>
                          <td width="221" height="30"><input name="txtnacimiento" type="text" class="form-control" id="datepicker" placeholder="Ej: 10/05/1981" value="<?php if($xhFila['2']!=""){echo Cfecha($xhFila['2']);}?>"></td>
                          
                          <td width="221" height="30"><?php
                            echo "<select name='txtestadocivil' class='form-control' >";             
                            while ($xtFila = $sqlestadocivil->fetch_row()){
                                if ($xhFila['4'] == $xtFila['0']){
                                    echo "<option value=\"".$xtFila['0']."\" selected=\"selected\">".$xtFila['1']."</option>";
                                }else{	
                                    echo "<option value=\"".$xtFila['0']."\">".$xtFila['1']."</option>";
                                }
                            }
							echo "</select>";
                            $sqlestadocivil->free();
                            ?></td>
                        </tr>
                        <tr>
                          <td width="221" height="30"><span class="textoContenido">Direcci&oacute;n</span></td>
                          <td width="221" height="30"><span class="textoContenido">País</span></td>
                          <td width="221" height="30"><span class="textoContenido">Procedencia</span></td>
                          <td width="221" height="30"><span class="textoContenido">Destino</span></td>
                        </tr>
                        <tr>
                          <td width="221" height="30"><input name="txtciudad" type="text" class="form-control" id="txtciudad" value="<?php echo $xhFila['5']?>"></td>
                          <td width="221" height="30"><input name="txtpais" type="text" class="form-control" id="txtpais" value="<?php echo $xhFila['6']?>"></td>
                          <td width="221" height="30"><input name="txtprocedencia" type="text" class="form-control" id="txtprocedencia" value="<?php echo $xhFila['7']?>"></td>
                          <td width="221" height="30"><input name="txtdestino" type="text" class="form-control" id="txtdestino" value="<?php echo $xhFila['8']?>"></td>
                        </tr>
                        <?php if($xestado=="modifica"){?>
                        <tr>
                          <td height="10">&nbsp;</td>
                          <td height="10">&nbsp;</td>
                          <td height="10">&nbsp;</td>
                          <td height="10">&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="10">
                          
                          <span class="textoContenido">Marcar  persona no Grata 
                              <?php if($xhFila['11']==1){?>
                              <input name="txtnograta" type="checkbox" checked id="txtnograta" value="1" style="width:15px; height:15px;">
                              <?php }else{?>
                              <input name="txtnograta" type="checkbox" id="txtnograta" value="1">
                              <?php } ?>
                          </span>
                        
                        </td>
                          <td height="10">&nbsp;</td>
                          <td height="10">&nbsp;</td>
                          <td height="10">&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="10">&nbsp;</td>
                          <td height="10">&nbsp;</td>
                          <td height="10">&nbsp;</td>
                          <td height="10">&nbsp;</td>
                        </tr>
                        <?php } ?>
                        <tr>
                          <td height="10"><span class="textoContenido">Comentarios</span></td>
                          <td height="10">&nbsp;</td>
                          <td height="10">&nbsp;</td>
                          <td height="10">&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="10" colspan="4"><textarea name="txtcomentarios" class="form-control" id="txtcomentarios" style="width:98%"><?php echo $xhFila['9']?></textarea></td>
                        </tr>
                        <tr>
                          <td height="10">&nbsp;</td>
                          <td height="10">&nbsp;</td>
                          <td height="10">&nbsp;</td>
                          <td height="10">&nbsp;</td>
                        </tr>
                        <tr>
                          <td height="10" colspan="2">                          
                            
                            <?php if($xestado=="modifica"){?>
                            <button type="submit" class="btnrojo" style="border:0px; cursor:pointer;"> <i class="fa fa-refresh"></i> Actualizar </button>
                            <?php }else{?>
                            <button type="submit" class="btnnegro" style="border:0px; cursor:pointer;"> <i class="fa fa-save"></i> Guardar </button>
                            <?php } ?>

                            <button type="button" onclick="window.location.href='<?php echo $linkretorno;?>';" class="btnnegro" style="border:0px; cursor:pointer;"> <i class="fa fa-remove"></i> Cancelar </button>                    
                            
                          </td>
                          <td width="221" height="10">&nbsp;</td>
                          <td width="221" height="10">&nbsp;</td>
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
      <td height="25" colspan="3"></td>
    </tr>

</table>
<blockquote>&nbsp;	</blockquote>

</body>
</html>
<?php include ("footer.php") ?>
<script src="../vendor/jossmp/sunatphp/example/js/ajaxview.js"></script>
<script type="text/javascript">
  $(function(){

    $("#tipo_documento").val("<?php echo $xhFila[12];?>").change();
    $("#tipo_documento").on('change',function(e){
      e.preventDefault();
      $("#txtdocumento").removeAttr('readonly');
      $("#txtdocumento").focus();
    })
    $("#txtdocumento").on('keyup',function(e){
        e.preventDefault();
        var documento=$("#txtdocumento").val();
       
        if(documento.length==8 || documento.length==11){
          $.ajax({
                data:  {'documento': documento,'tipo_documento':$("#tipo_documento").val()},
                url:   '../vendor/jossmp/sunatphp/test.php',
                type:  'post',
                beforeSend: function () {
                        $("#espera").addClass('text-success');
                        $("#espera").html("<p> <img src='load.gif'> Procesando, espere por favor...</p>");
                        $.ajaxblock();

                },
                success:  function (response) {
                        
                       
                        data = eval("("+response+")");

                        console.log(data);
                        if(typeof data.success != "undefined"){           
                          if(data.success==true){ 
                             
                              $("#txtnombre").val(data.result.RazonSocial);
                              $("#txtciudad").val(data.result.Direccion);        
                              $("#espera").html('');
                          }else{
                              $("#espera").addClass('text-danger');
                              $("#espera").html(data.msg);
                              $("#txtnombre").val('');
                              $("#txtciudad").val('');   
                          }
                        }
                        $.ajaxunblock();
                },
                errors: function(response){
                    console.log(response);
                    $("#espera").addClass('text-danger');
                    $("#espera").html('Ocurrio un error con el servidor, consulte con el administrador');
                    $.ajaxunblock();
                }
          });

       }

    })
    
  })
</script>




