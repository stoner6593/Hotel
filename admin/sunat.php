<?php
include "validar.php";
include "config.php";
include "include/functions.php";
date_default_timezone_set('America/Lima');

$txtbuscarpor = $_POST['txtbuscarpor'];
$txtdato = $_POST['txtdato'];


$sqlalquiler = $mysqli->query("select
      alquilerhabitacion.idalquiler,
     
     
      alquilerhabitacion.nrohabitacion,
           
      huesped.nombre,
      huesped.ciudad,
      huesped.tipo_documento,
      huesped.documento,
      
      alquilerhabitacion.comentarios,
      alquilerhabitacion.nroorden,
      alquilerhabitacion.fecharegistro,

      alquilerhabitacion.documento,
      alquilerhabitacion.codigo_respuesta,
      alquilerhabitacion.mensaje_respuesta,
      alquilerhabitacion.nombrezip,
      alquilerhabitacion.nombre_archivo,
      alquilerhabitacion.correlativo,
      alquilerhabitacion.iddocumento
      
      from alquilerhabitacion inner join huesped on huesped.idhuesped = alquilerhabitacion.idhuesped
      where alquilerhabitacion.codigo_respuesta != 0 
      ");   




?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Administrador</title>

<?php include "head-include.php"; ?>

</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="example" class=" table table-bordered table-hover">

    <tr>
      <td height="25" colspan="3"><?php include ("head.php"); ?></td>
    </tr>
    <tr>
      <td width="185" height="25" align="left" valign="top"><?php include ("menu_nav.php"); ?></td>
      <td width="25">&nbsp;</td>
      <td width="810" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
       
          
          <tr>
            <td height="30" colspan="2"><table width="100%" border="0" cellpadding="1" cellspacing="1">
             
                <tr>
                  <td height="30"><div class="lineahorizontal" style="background:#BFBFBF;"></div></td>
                </tr>
                <tr>
                  <td height="30" class=" text-success">
                    <h3 style="color:#E1583E;"> <i class="fa fa-users"></i> Listado de documentos pendientes a enviar</h3>
                    
                  </td>
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
                      <td width="346" height="25" bgcolor="#F4F4F4">Cliente</td>
                      <td width="58" height="25" align="center" bgcolor="#F4F4F4">Nº Documento</td>
                      <td width="98" height="25" bgcolor="#F4F4F4">Fecha</td>
                      <td width="98" height="25" bgcolor="#F4F4F4">Estado</td>
                      <td width="131" height="25" bgcolor="#F4F4F4">Mensaje SUNAT</td>
                      <td width="10" height="10" bgcolor="#F4F4F4">Enviar</td>
                      <!--<td width="10" height="10" bgcolor="#F4F4F4">PDF</td>-->
                
                    </tr>
                    <?php
						$item = 0;
						while ($xhFila = $sqlalquiler->fetch_row())
						{		
						$item++;
					?>
                    <tr class="<?php if($item % 0==1){echo 'textoContenidoMenorRojo';}else{echo 'textoContenidoMenor';} ?>">
                      <td height="25" align="center" bgcolor="#FFFFFF"><?php echo $xhFila[0]; ?></td>
                      <td height="25" align="left" bgcolor="#FFFFFF"><?php echo $xhFila['2']; ?></td>
                      <td height="25" align="center" bgcolor="#FFFFFF"><?php echo ($xhFila['14']); ?></td>
                      <td height="25" bgcolor="#FFFFFF" align="left"><?php echo $xhFila['8']; ?></td>
                      <td height="25" bgcolor="#FFFFFF" align="left"><?php echo $xhFila['10']; ?></td>
                      <td height="25" bgcolor="#FFFFFF" align="left"><?php echo $xhFila['11']; ?></td>  
                      <td height="5" bgcolor="#FFFFFF" align="left"><button type="button" data-id-nombre_archivo="<?php echo $xhFila ['13']; ?>" data-id-zip="<?php echo $xhFila ['12']; ?>" data-id-idalquiler="<?php echo $xhFila ['0']; ?>" data-id-tipo_documento="<?php echo $xhFila ['4']; ?>" id="CapturaDato" class="btnmodificar" style="border:0px; cursor:pointer;"> <i class="fa fa-send"></i> </button></td> 
                      <td height="5" bgcolor="#FFFFFF" align="left"><button type="button" data-id-nombre_archivo2="<?php echo $xhFila ['13']; ?>" data-id-zip2="<?php echo $xhFila ['12']; ?>" data-id-idalquiler2="<?php echo $xhFila ['0']; ?>" data-id-tipo_documento2="<?php echo $xhFila ['15']; ?>" id="CapturaDato2" class="btnmodificar" style="border:0px; cursor:pointer;"> <i class="fa fa-send"></i> </button></td>                   
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

<script type="text/javascript">
  
  $(function(){
     $('#example').on('click','#CapturaDato',function(e){

          e.preventDefault();           
           var cod=$(this).attr('data-id-idalquiler'); 
           var tipo_documento=$(this).attr('data-id-tipo_documento'); 
           var zip=$(this).attr('data-id-zip'); 
           var nombre_archivo=$(this).attr('data-id-nombre_archivo'); 
           //console.log(nomDocumento +'-'+nombre_archivo);
           swal({
            title: "Enviar Documento a SUNAT?",
            text: "Una vez enviado no se puede revertir el proceso..!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            closeOnClickOutside: false,
            closeOnEsc: false
          })
          .then((willDelete) => {

            if (willDelete) {
              //Enviar proceso por ajax
              //console.log({'idalquiler':cod,'tipo_documento':tipo_documento,'zip':zip,'nombre_archivo':nombre_archivo});
               $.ajax({
                    url:'FE/Contingencia.php',
                    type:'post',
                    data:{'idalquiler':cod,'tipo_documento':tipo_documento,'zip':zip,'nombre_archivo':nombre_archivo},
                    //dataType:'json',
                    beforeSend:function(){
                       $('#ProcesaEnvio').attr('disabled','disabled');   
                       $("#liAnula").removeClass();
                       $("#liAnula").addClass('fa fa-spinner fa-spin');
                        swal('Enviando...!',{
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                     buttons: false
                });
                
                    },  
                    success:function(data){
                        
                       data = eval("("+data+")");  
                       //console.log(data);
                        if(typeof data.success != "undefined"){                     
                            if(data.errors==0){                             
                              
                               
                               swal({
                                  title: "Enviado...!",
                                  text: data.success['Description'],
                                  icon: "success",
                                  buttons: true,
                                  dangerMode: true

                                })
                                .then((willDelete) => {
                                  if (willDelete) {
                                      swal("Transacción Finalizada!", {
                                        icon: "success",
                                      });
                                      window.open('FE/PDF/'+data.success['nombre_archivo']); 
                                      window.location.href='sunat.php';    
                                      
                                  } /*else {
                                    swal("Transacción Finalizada!");
                                  }*/
                                });
                                                                                   
                                $("#liAnula").removeClass();
                                $("#liAnula").addClass('fa fa-arrow-up');
                                $('#ProcesaEnvio').removeAttr('disabled');    
                                           
                                            
                            }else{
                                if(typeof data.errors != "undefined"){
                                    if(data.success==0){
                                        swal("Error!",data.errors['getCode']+' '+data.errors['getMessage'], "error");
                                        $("#liAnula").removeClass();
                                        $("#liAnula").addClass('fa fa-file-code-o');
                                        $('#ProcesaEnvio').removeAttr('disabled');     
                                        
                                    }else{
                                         if(data.success==2){

                                            swal("Error!",data.errors, "error");
                                            $("#liAnula").removeClass();
                                            $("#liAnula").addClass('fa fa-arrow-up');
                                            $('#ProcesaEnvio').removeAttr('disabled'); 
                                            
                                        }
                                    }
                                   
                                }
                            }
                        }
                                       
                        
                    },
                    error:function(rpta){ 
                     swal("Error!","Ocurió un Error al Realizar Petición..!", "error");                  
                     $("#liAnula").removeClass();
                     $("#liAnula").addClass('fa fa-arrow-up');
                    $('#ProcesaEnvio').removeAttr('disabled');   
                     console.log(rpta);
                       
                        
                    }

                });
              /*swal("algo", {
                icon: "success",
              });*/
            } else {
              swal("El proceso de envío fue cancelado..!!");
            }
          });
      }) 




       $('#example').on('click','#CapturaDato2',function(e){

          e.preventDefault();           
           var cod=$(this).attr('data-id-idalquiler2'); 
           var tipo_documento=$(this).attr('data-id-tipo_documento2'); 
           var zip=$(this).attr('data-id-zip2'); 
           var nombre_archivo=$(this).attr('data-id-nombre_archivo2'); 
           //console.log(nomDocumento +'-'+nombre_archivo);
           swal({
            title: "Enviar Documento a SUNAT?",
            text: "Una vez enviado no se puede revertir el proceso..!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            closeOnClickOutside: false,
            closeOnEsc: false
          })
          .then((willDelete) => {

            if (willDelete) {
              //Enviar proceso por ajax
              //console.log({'idalquiler':cod,'tipo_documento':tipo_documento,'zip':zip,'nombre_archivo':nombre_archivo});
               $.ajax({
                    url:'FE/GeneraxmlContingencia.php',
                    type:'post',
                    data:{'idalquiler':cod,'tipo_documento':tipo_documento},
                    //dataType:'json',
                    beforeSend:function(){
                       $('#ProcesaEnvio').attr('disabled','disabled');   
                       $("#liAnula").removeClass();
                       $("#liAnula").addClass('fa fa-spinner fa-spin');
                        swal('Enviando...!',{
                    closeOnClickOutside: false,
                    closeOnEsc: false,
                     buttons: false
                });
                
                    },  
                    success:function(data){
                        
                       data = eval("("+data+")");  
                       
                        if(typeof data.success != "undefined"){                     
                            if(data.errors==0){                             
                              
                               
                               swal({
                                  title: "Enviado...!",
                                  text: data.success['Description'],
                                  icon: "success",
                                  buttons: true,
                                  dangerMode: true

                                })
                                .then((willDelete) => {
                                  if (willDelete) {
                                      swal("Transacción Finalizada!", {
                                        icon: "success",
                                      });
                                      window.open('FE/PDF/'+data.success['nombre_archivo']); 
                                      window.location.href='sunat.php';    
                                      
                                  } /*else {
                                    swal("Transacción Finalizada!");
                                  }*/
                                });
                                                                                   
                                $("#liAnula").removeClass();
                                $("#liAnula").addClass('fa fa-arrow-up');
                                $('#ProcesaEnvio').removeAttr('disabled');    
                                           
                                            
                            }else{
                                if(typeof data.errors != "undefined"){
                                    if(data.success==0){
                                        swal("Error!",data.errors['getCode']+' '+data.errors['getMessage'], "error");
                                        $("#liAnula").removeClass();
                                        $("#liAnula").addClass('fa fa-file-code-o');
                                        $('#ProcesaEnvio').removeAttr('disabled');     
                                        
                                    }else{
                                         if(data.success==2){

                                            swal("Error!",data.errors, "error");
                                            $("#liAnula").removeClass();
                                            $("#liAnula").addClass('fa fa-arrow-up');
                                            $('#ProcesaEnvio').removeAttr('disabled'); 
                                            
                                        }
                                    }
                                   
                                }
                            }
                        }
                                       
                        
                    },
                    error:function(rpta){ 
                     swal("Error!","Ocurió un Error al Realizar Petición..!", "error");                  
                     $("#liAnula").removeClass();
                     $("#liAnula").addClass('fa fa-arrow-up');
                    $('#ProcesaEnvio').removeAttr('disabled');   
                     console.log(rpta);
                       
                        
                    }

                });
              /*swal("algo", {
                icon: "success",
              });*/
            } else {
              swal("El proceso de envío fue cancelado..!!");
            }
          });
      })           
  })
</script>




