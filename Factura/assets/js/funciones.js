//$("#detalle_producto").bind("submit",function(e){
$(function(){

	//Genera Comunicación de Baja
    $("body").on("click","#btnAlular",function(e){
    	e.preventDefault();   	
    	
    	//Recorre Documentos
        var DocAnula=RecorreDocumentosAnulados(); 
        var dato = {'tabla':DocAnula};
        console.log(dato);

        $.ajax({
            url:$("#GuardaDocAnula").attr('action'),
            type:'post',
            data:dato,
            //dataType:'json',
            beforeSend:function(){
               $('#GuardaDocAnula').find('button[type=submit]').attr('disabled','disabled');   
               $("#liAnula").removeClass();
               $("#liAnula").addClass('fa fa-spinner fa-spin');
              
            },  
            success:function(data){
                
               data = eval("("+data+")");  
               
                if(typeof data.success != "undefined"){                     
                    if(data.errors==0){                             
                        
                        //swal({title: data.success['Description'][0] + "==="+ data.success['ReferenceID'][0],type: "success"});

                        swal({
                          title: "Enviado...!",
                          text: data.success['Description'][0],
                          type: "success",
                          //showCancelButton: true,
                          closeOnConfirm: false,
                          showLoaderOnConfirm: true,
                          html: true
                        },
                        function(){
                          setTimeout(function(){
                            swal("Transacción Finalizada!");

                            window.open(base_url+'pdf/'+data.success['nombre_archivo']);
                          }, 100);
                        });
                                                           
                        $("#liAnula").removeClass();
                        $("#liAnula").addClass('fa fa-file-code-o');
                        $('#documento').find('button[type=submit]').removeAttr('disabled');    
                                        
                                    
                    }else{
                        if(typeof data.errors != "undefined"){
                            if(data.success==0){
                                swal("Error!",data.errors['getCode']+' '+data.errors['getMessage'], "error");
                                $("#liAnula").removeClass();
                                $("#liAnula").addClass('fa fa-file-code-o');
                                $('#documento').find('button[type=submit]').removeAttr('disabled');    
                                
                            }else{
                                 if(data.success==2){

                                    swal("Error!",data.errors, "error");
                                    $("#liAnula").removeClass();
                                    $("#liAnula").addClass('fa fa-file-code-o');
                                    $('#documento').find('button[type=submit]').removeAttr('disabled');    
                                    
                                }
                            }
                           
                        }
                    }
                }
                               
                
            },
            error:function(rpta){ 
             swal("Error!","Ocurió un Error al Realizar Petición..!", "error");                  
             $("#liAnula").removeClass();
             $("#liAnula").addClass('fa fa-file-code-o');
             $('#documento').find('button[type=submit]').removeAttr('disabled');    
             console.log(rpta);
               
                
            }

        });

        


    })

	//Buscar Documentos Emitidos
	$("#BuscarDocumentos").on('submit', function(e){
		e.preventDefault();
		//alertify.error("Selecione Tipo de Documento RUC");
		var form = $(this);
	    form.parsley().validate();

	    if (form.parsley().isValid()){
	    	var docCliente=$("#DocCliBus").val(),tipDocumento=$("#cmbTipoServicio").val(),numDocumento=$("#NumDocBuscar").val(),fechaEnvio=$("#datepicker-default").val();
	    	console.log(base_url+"Busca_documentos/BuscaDocumento/"+docCliente+'/'+tipDocumento+'/'+numDocumento+'/'+fechaEnvio);
	    	table.ajax.url(base_url+"Busca_documentos/BuscaDocumento/"+docCliente+'/'+tipDocumento+'/'+numDocumento+'/'+fechaEnvio).load();		
			
			
	    }
	   

	});

	/*Agregar productos al detalle*/
	var Suma=0,TotalVenta=0;
	$("#detalle_producto").on('submit', function(e){
		 e.preventDefault();
	    var form = $(this);

	    form.parsley().validate();

	    if (form.parsley().isValid()){
	    	
	       cadena = "<tr class='danger'>";
		    cadena = cadena + "<td>" + $("#codprod").val() + "</td>";
		    cadena = cadena + "<td>" + $("#desprod").val() + "</td>";
		    cadena = cadena + "<td>" + $("#cantidadprod").val() + "</td>";
		    cadena = cadena + "<td>" + $("#unimedprod").val() + "</td>";	    
		    cadena = cadena + "<td>" + $("#preuniprod").val() + "</td>";
		    cadena = cadena + "<td>" + $("#prerefprod").val() + "</td>";
		    cadena = cadena + "<td>" + $("#tipprecioprod").val() + "</td>";
		    cadena = cadena + "<td>" + $("#impuestoprod").val()+ "</td>";
		    cadena = cadena + "<td>" + $("#tipoimpuestoprod").val() + "</td>";
		    cadena = cadena + "<td>" + $("#totiscprod").val() + "</td>";
		    cadena = cadena + "<td>" + $("#otroimpuestoprod").val() + "</td>";
		    cadena = cadena + "<td>" + $("#subtotalprod").val() + "</td>";
		    cadena = cadena + "<td>" + $("#totalprod").val()+ "</td>";
		    cadena = cadena + "<td id='eliminar' style='cursor:pointer;'><i class='fa fa-trash-o' ></i></td>";
		    $("#table tbody").append(cadena);
		    // Evaluamos el tipo de Impuesto.
		    var str=$("#tipoimpuestoprod").val();
		    if(str.startsWith("1")){
		    	
                Suma=parseFloat($("#preuniprod").val() * $("#cantidadprod").val());
                TotalVenta=Suma;
		    	
		    }else{
		    	if(parseFloat($("#otroimpuestoprod").val())>0){
		    		TotalVenta=Suma + $("#otroimpuestoprod").val();
		    	}
		    }
		    //console.log(Suma);
		    //$('#detalle_producto').parsley().reset();
			$('#detalle_producto')[0].reset();
			$("#codprod").focus();
			CalculaTotales();
	    }
	});


	//Agrega Datos Adicionales
	$("#datos_adicionales").on('submit', function(e){
		 e.preventDefault();
	    var form = $(this);

	    form.parsley().validate();

	    if (form.parsley().isValid()){
	    	
	        cadena = "<tr class='danger'>";
		    cadena = cadena + "<td>" + $("#CodDatoAdicional").val() + "</td>";		   
		    cadena = cadena + "<td>" + $("#DesAdicional").val() + "</td>";
		    cadena = cadena + "<td id='eliminar' style='cursor:pointer;'><i class='fa fa-trash-o' ></i></td>";
		    $("#table_adicional tbody").append(cadena);		   
			$('#datos_adicionales')[0].reset();
			
	    }
	});

	//Discrepancia
	$("#datos_discrepancias").on('submit', function(e){
		e.preventDefault();
	    var form = $(this);

	    form.parsley().validate();

	    if (form.parsley().isValid()){
	    	
	        cadena = "<tr class='danger'>";
		    cadena = cadena + "<td>" + $("#TipDiscrepancia").val() + "</td>";		   
		    cadena = cadena + "<td>" + $("#NumReferenciaDis").val() + "</td>";
		    cadena = cadena + "<td>" + $("#DesReferenciaDis").val() + "</td>";
		    cadena = cadena + "<td id='eliminar' style='cursor:pointer;'><i class='fa fa-trash-o' ></i></td>";
		    $("#table_discrepancia tbody").append(cadena);		   
			$('#datos_discrepancias')[0].reset();
			
	    }
	});

	//Documento Relacionado	
	$("#datos_docrelacionado").on('submit', function(e){
		 e.preventDefault();
	    var form = $(this);

	    form.parsley().validate();

	    if (form.parsley().isValid()){
	    	
	        cadena = "<tr class='danger'>";
		    cadena = cadena + "<td>" + $("#CodDocRelacionado").val() + "</td>";		   
		    cadena = cadena + "<td>" + $("#docuRelacionado").val() + "</td>";
		    cadena = cadena + "<td id='eliminar' style='cursor:pointer;'><i class='fa fa-trash-o' ></i></td>";
		    $("#table_relacionados tbody").append(cadena);		   
			$('#datos_docrelacionado')[0].reset();
			
	    }
	});

	//Documento de Baja
	$("#GuardaDocAnula").on('submit', function(e){
		 e.preventDefault();
	    var form = $(this);

	    form.parsley().validate();

	    if (form.parsley().isValid()){
	    	
	        cadena = "<tr class='danger'>";
		    cadena = cadena + "<td>" + $("#TipDocAnula").val() + "</td>";		   
		    cadena = cadena + "<td>" + $("#SerieAnula").val() + "</td>";
		    cadena = cadena + "<td>" + $("#NumDocBuscarAnula").val() + "</td>";		   
		    cadena = cadena + "<td>" + $("#MotivoAnula").val() + "</td>";		    
		    cadena = cadena + "<td id='eliminar' style='cursor:pointer;'><i class='fa fa-trash-o' ></i></td>";
		    $("#tableAnula tbody").append(cadena);		   
			$('#GuardaDocAnula')[0].reset();
			
	    }
	});


	$("#CerrarDetalle").on("click",function(e){
		$('#detalle_producto').parsley().reset();
		$('#detalle_producto')[0].reset();
	})
	//Realiza cálculo de total
	$("#cantidadprod").on("keyup",function(e){
		e.preventDefault();
		CalculaTotal();
	})
	//Realiza cálculo de total
	$("#preuniprod").on("keyup",function(e){
		e.preventDefault();
		CalculaTotal();
	})
	//Elimina fila
	$(document).on("click","#eliminar",function(){
		var parent = $(this).parents().get(0);
		$(parent).remove();
		CalculaTotales();
	});
	
	//Elimina fila detalle cotiza	
	$(document).on('click', '#eliminar_det_coti', function (event) {
        var TotImpuesto1 = 0,SubTot1=0,SumTot1=0;
        event.preventDefault();
        $(this).closest('tr').remove();
        CalculaTotaCotiza();		
		
    });
	/*Busca cliente*/
	$("#BuscaCliente").on('click',function(e){
		e.preventDefault();
		var rucdni=$("#rucdni").val();		
		if( rucdni.length==11 || rucdni.length==8){			
			$("#res").removeClass('text-danger');
			$("#res").html('<img src="'+base_url+'assets/images/load.gif">');
			$.ajax({
				//url: base_url+"Configuracion/BuscaRuc",
				url: base_url+"Cliente/busca_cli_dni/"+rucdni,
				type:"get",	
				data:{"doc":rucdni},	
				dataType: 'json',
				success:function(data){
					
					if(data.errors==0){
						$("#res").html('');
						$("#res").removeClass('text-danger').addClass('text-success');
						$("#res").html('<img src="'+base_url+'assets/images/accept.png"> '+data.success["Estado"]);
						$("#razon_social").val(data.success["RazonSocial"]);
						$("#direccion").val(data.success["Direccion"]);							
							
					}else{
						if(data.success==2){
							//$("#formcliente1")[0].reset();
							$("#res").removeClass('text-success');	
							$("#res").html(''); 								 
							alertify.error(data.errors);
						}
					}
					if(data.errors==1){
						$("#res").html('');
						$("#res").removeClass('text-danger').addClass('text-success');				
						
						data = eval("("+data.success+")");							
						if(data.status == 'success') {
							$("#res").html('<img src="'+base_url+'assets/images/accept.png"> '+"Activo");	
							$("#razon_social").val(data.value[0]['name']);
						} else if(data.status == 'not_found') {							
							alertify.error(data.status_text);
						} else if(data.status == 'inlimit') {
							alertify.error(data.status_text);
						} else {
							alertify.error('Error desconocido, favor contactar al administrador stoner6593@gmail.com.');
							
						}		
						
							
					}else{
						if(data.success==1){
							//$("#formcliente1")[0].reset();
							$("#res").removeClass('text-success');	
							$("#res").html(''); 								 
							alertify.error(data.errors);
						}
					} 					
					  
				 },
				 error:function(data){
					  alertify.error("Ocurrio un error en el proceso..!");
					  console.log(data);
					  $("#res").html(''); 
					  
				 }


			});
		}else{
			alertify.error("Nº de documento incorrecto..!");
		}
	
	});//Fin Busca Cliente
	/*Busca cliente cotizacion*/
	$("#BuscaClienteCoti").on('click',function(e){
		e.preventDefault();
		var rucdni=$("#rucdni").val();		
		if( rucdni.length==11 || rucdni.length==8){			
			$("#res").removeClass('text-danger');
			$("#res").html('<img src="'+base_url+'assets/images/load.gif">');
			$.ajax({
				//url: base_url+"Configuracion/BuscaRuc",
				url: base_url+"Cliente/busca_cli_dni2/"+rucdni,
				type:"get",	
				data:{"doc":rucdni},	
				dataType: 'json',
				success:function(data){					
					if(data.errors==0){
						$("#res").html('');
						$("#idcli").val(data.success["id"]);						
						$("#razon_social").val(data.success["cli_razonsocial"]);
						$("#direccion").val(data.success["cli_direccion"]);
						$("#mail").val(data.success["cli_correo"]);
						$("#telefono").val(data.success["cli_telefono"]);														
							
					}else{
						if(data.success==0){						
							$("#res").html(''); 								 
							alertify.error(data.errors);
						}
					}							
					  
				 },
				 error:function(data){
					  alertify.error("Ocurrio un error en el proceso..!");
					  console.log(data);
					  $("#res").html(''); 
					  
				 }


			});
		}else{
			alertify.error("Nº de documento incorrecto..!");
		}
	
	});//Fin Busca Cliente
	
	//GUARDA CLIENTE
	$("body").on("submit","#formcliente",function(e){
		e.preventDefault();		
		GuardaCliente();		
		
	});//FIN GUARDA CLIENTE
	
	//ACTIVA ESTADO CLIENTE
	$("#estado").click(function() {  
        if($("#estado").is(':checked')) {  
            $("#estado").attr('checked',true);
			$("#estado").val("AC");
        } else {  
            $("#estado").removeAttr('checked',false);
			$("#estado").val("IN");	
        }  
    });  
    //Agrega Producto/Servicio 
    var CuentaFila=1;
	$("#form_prod_cotiza").on('submit', function(e){
		e.preventDefault();
	    var form = $(this);

	    form.parsley().validate();

	    if (form.parsley().isValid()){
	    	var igv,subtotal,total,tot,valorigv;
			valorigv=parseFloat(0.18) + parseFloat(1);
			tot=parseFloat($("#precio_item").val() * $("#cantidad").val());
			subtotal=parseFloat(tot /(valorigv));
			igv=parseFloat(tot - subtotal);	
			total=parseFloat(subtotal + igv);
	    	if(Operacion==1){
		    					
		        cadena = "<tr class='danger' id='"+CuentaFila+"'>";
			    cadena = cadena + "<td id='des"+ CuentaFila +"'>" + $("#wysihtml5").val() + "</td>";		   
			    cadena = cadena + "<td id='canti"+ CuentaFila +"'>" + $("#cantidad").val() + "</td>";
			    cadena = cadena + "<td id='pre"+ CuentaFila +"'>" + $("#precio_item").val() + "</td>";
			    cadena = cadena + "<td id='ig"+CuentaFila+"'>" + igv.toFixed(2)  + "</td>";		   
			    cadena = cadena + "<td id='subt"+CuentaFila+"'>" + subtotal.toFixed(2) + "</td>";
			    cadena = cadena + "<td id='tot"+CuentaFila+"'>" + total.toFixed(2) + "</td>";
			    cadena = cadena + "<td ><a style='cursor:pointer;' id='editar' onClick='EditaFila("+CuentaFila+")' title='Editar'><i class='fa fa-edit' ></i></a>    <a id='eliminar_det_coti' style='cursor:pointer;' title='Eliminar'><i class='fa fa-trash-o' ></i></a></td>";
			    $("#table_detalle_cotiza tbody").append(cadena);		   
				$('#form_prod_cotiza')[0].reset();
				$(".textarea form-control wysihtml5-editor").text("")
				CalculaTotaCotiza();
				CuentaFila++;
			}else
			{
				$("#des"+filaEdit).text($("#wysihtml5").val());
				$("#canti"+filaEdit).text($("#cantidad").val());
				$("#pre"+filaEdit).text($("#precio_item").val());
				$("#ig"+filaEdit).text(igv.toFixed(2));
				$("#subt"+filaEdit).text(subtotal.toFixed(2));
				$("#tot"+filaEdit).text(total.toFixed(2));
				CalculaTotaCotiza();
				$("#modal_productos_cotiza").modal('hide');
			}
	    }
	});
	

	
})
//Funcion Editar Fila Cotiza
var filaEdit=0;
function EditaFila(fila){
	Operacion=2;
	filaEdit=fila;
	var val1=$("#des"+fila).text();
	var val2=$("#canti"+fila).text();
	var val3=$("#pre"+fila).text();

	$("#wysihtml5").html(val1);
	$("#cantidad").val(val2);
	$("#precio_item").val(val3);
	$("#modal_productos_cotiza").modal("show");

}
//Funcion para guardar y actualizar cliente
function GuardaCliente(){
	var url1;
	if(procedeCli==1){
		url1=base_url+"cliente/addcliente";
	}else if(procedeCli==2){
		url1=base_url+"cliente/modicliente";
	}
	
	var formData = new FormData($('#formcliente')[0]);
	$.ajax({
		type: 'post',
		url: url1,
		data: formData ,// $("#formpersonal").serialize(),
		mimeType: "multipart/form-data",
		contentType: false,
		cache: false,
		processData: false,				
		beforeSend: function(){
			$("#lienvia").removeClass('fa fa-save');
			$("#lienvia").addClass('fa fa-spinner fa-spin');
			$("#enviapersonal").attr('disabled','disabled');				
		},
		success:function(data) {				
						
			data = eval("("+data+")");						
			
			if(typeof data.success != "undefined"){						
				if(data.errors==0){								
					$("#lienvia").removeClass();
					$("#lienvia").addClass('fa fa-save');
					$('#formcliente').find('button[type=submit]').removeAttr('disabled');
					alertify.success(data.success);
					if(procedeCli==1){
						$('#formcliente')[0].reset();
					}	
					$("#res").html('');
					$("#res").removeClass('text-success');	
					setTimeout( function () { tableCliente.ajax.reload(); }, 1000 );					
					
				}else{
					if(typeof data.errors != "undefined"){
						if(data.success==0){
							$("#lienvia").removeClass();
							$("#lienvia").addClass('fa fa-save');
							$('#formcliente').find('button[type=submit]').removeAttr('disabled');	
							var error_string = '';
							for(key in data.errors){
								error_string += data.errors[key]+"<br/>"
							}
							//alertify.alert( error_string );
							alertify.error( error_string );
						}
					}
				}
			}else{
				alertify.error('Whoops! Ocurrió un error durante el proceso..!');
				
			}
		},
		error:function(data){
			alertify.error('Whoops! Ocurrió un error durante el proceso..!.');
			console.log(data);
		}
	});	
}
//CAPTURA DATOS A MODIFICAR
function CaturaCliente(cod){
	
	
	$.ajax({
		url:base_url+"cliente/busca_modi_cli/"+cod,
		type:"get",			
		dataType: 'json',
		beforeSend:function(){
			$("input").removeClass('parsley-error');
			$("input").removeClass('parsley-success');
			$("ul").removeClass('filled');
		},
		success:function(data){	
			
			if(data.errors==0){
				$("#idcli").val(data.success.id);
				$("#rucdni").val(data.success.cli_numdoc);
				$("#razon_social").val(data.success.cli_razonsocial);
				$("#direccion").val(data.success.cli_direccion);
				$("#mail").val(data.success.cli_correo);
				$("#telefono").val(data.success.cli_telefono);
				$("#contacto").val(data.success.cli_contacto);
				$("#telefono_contacto").val(data.success.cli_contactotelef);
				$("#correo_contacto").val(data.success.cli_contactocorreo);
				if(data.success.cli_estado =="AC"){
					$("#estado").attr('checked', true); 
					$("#estado").val("AC");
				}else{
					$("#estado").removeAttr('checked',false);
					$("#estado").val("IN");
				}
				$("#modal_cliente").modal('show');	
			}else if(data.success==0){
				alertify.error(data.errors);				
			
			}
				
			
		 },
		 error:function(data){
			alertify.error("Ocurrio un error en el proceso..!");					
			console.log(data);
			$("body #load").html('');					
			  
		 }


	});	
		

}
//Calcula total detalle cotiza
function CalculaTotaCotiza(){
	var TotImpuesto = 0,SubTot=0,SumTot=0;
	$('#table_detalle_cotiza tbody tr').each(function(){
		SubTot += parseFloat($(this).find('td').eq(4).text());
		TotImpuesto += parseFloat($(this).find('td').eq(3).text());
		SumTot += parseFloat($(this).find('td').eq(5).text());
			
	})
	$("#stot").text("S/. "+ SubTot.toFixed(2));
	$("#sigv").text("S/. "+ TotImpuesto.toFixed(2));
	$("#stt").text("S/. "+ SumTot.toFixed(2));	
}
//Calcula Total de Producto
function CalculaTotal(){
	var igv,subtotal,total,tot,valorigv;
		valorigv=parseFloat($("#calc_igv").val()) + parseFloat(1);
		tot=parseFloat($("#preuniprod").val() * $("#cantidadprod").val());
		subtotal=parseFloat(tot /(valorigv));
		igv=parseFloat(tot - subtotal);	
		total=subtotal + igv;
		$("#impuestoprod").val(igv.toFixed(2));
		$("#subtotalprod").val(subtotal.toFixed(2));
		$("#totalprod").val(total.toFixed(2));	
}

//Totales
function CalculaTotales(){	
    var TotImpuesto = 0,TotISC=0,TotOtrosImpu=0,TotGravadas=0,TipImpuesto,TotExoneradas=0,TotInafectas=0,TotGratuitas=0,TotTotal=0,SumaTotal;
	$('#table tbody tr').each(function(){ //filas con clase 'dato', especifica una clase, asi no tomas el nombre de las columnas
 		
 		TotImpuesto += parseFloat($(this).find('td').eq(7).text()); //numero de la celda 3
 		TotISC += parseFloat($(this).find('td').eq(9).text());
 		TotOtrosImpu += parseFloat($(this).find('td').eq(10).text());
 		TipImpuesto = ($(this).find('td').eq(8).text());
 		TotTotal += parseFloat($(this).find('td').eq(12).text());
 		
 		if(TipImpuesto.startsWith("1")){
 			TotGravadas += parseFloat($(this).find('td').eq(11).text());
 		}
 		if(TipImpuesto=="20"){
 			TotExoneradas += parseFloat($(this).find('td').eq(12).text());
 		}
 		if(TipImpuesto.startsWith("3") || TipImpuesto=="40"){
 			TotInafectas += parseFloat($(this).find('td').eq(12).text());
 		}
 		if(TipImpuesto=="21") {
 			TotGratuitas += parseFloat($(this).find('td').eq(12).text());
 		}
 		//console.log($.contains(TipImpuesto.toString().trim(),"21".trim()) + TipImpuesto  );


 		


	})
	
	// Cuando existe ISC se debe recalcular el IGV.
		
	if(TotISC>0){
		TotImpuesto=parseFloat((TotGravadas + TotISC) * $("#calc_igv").val());
	}	
	SumaTotal=TotGravadas + TotExoneradas + TotInafectas + TotImpuesto + TotISC + TotOtrosImpu;
	$("#TotVenta").val(SumaTotal.toFixed(2));
    $("#TotIgv").val(TotImpuesto.toFixed(2));
    $("#TotIsc").val(TotISC.toFixed(2));
    $("#TotOtrosTributos").val(TotOtrosImpu.toFixed(2));
    $("#TotGravada").val(TotGravadas.toFixed(2));
    $("#TotExoneradas").val(TotExoneradas.toFixed(2));
    $("#TotInafectas").val(TotInafectas.toFixed(2));
    $("#TotGratuitas").val(TotGratuitas.toFixed(2));
}	


function RecorreDetalle(){

    //tenemos 2 variables, la primera será el Array principal donde estarán nuestros datos y la segunda es el objeto tabla
    var DATA    = [];
    var TABLA   = $("#table tbody > tr");
 
    //una vez que tenemos la tabla recorremos esta misma recorriendo cada TR y por cada uno de estos se ejecuta el siguiente codigo
    TABLA.each(function(){
        //por cada fila o TR que encuentra rescatamos 3 datos, el ID de cada fila, la Descripción que tiene asociada en el input text, y el valor seleccionado en un select
        var ID      = $(this).find('td').eq(0).text(),
            DESC    = $(this).find('td').eq(1).text(),
            CANTIDAD = $(this).find('td').eq(2).text(),
            UNIMED  = $(this).find('td').eq(3).text(),
            PREUNIT = $(this).find('td').eq(4).text(),
            PREREF  = $(this).find('td').eq(5).text(),
            TIPOPRECIO= $(this).find('td').eq(6).text(),
            IGV= $(this).find('td').eq(7).text(),
            TIPOIMPUESTO= $(this).find('td').eq(8).text(),
            ISC= $(this).find('td').eq(9).text(),
            OTROIMPUESTO= $(this).find('td').eq(10).text(),
            SUBTOTAL= $(this).find('td').eq(11).text(),
            TOTAL= $(this).find('td').eq(12).text();
 
        //entonces declaramos un array para guardar estos datos, lo declaramos dentro del each para así reemplazarlo y cada vez
        item = {};
        //si miramos el HTML vamos a ver un par de TR vacios y otros con el titulo de la tabla, por lo que le decimos a la función que solo se ejecute y guarde estos datos cuando exista la variable ID, si no la tiene entonces que no anexe esos datos.
        if(ID !== ''){
            item ["pro_id"]     = ID;
            item ["pro_desc"]   = DESC;
            item ['pro_cantidad']   = CANTIDAD;
            item ["pro_unimedida"]  = UNIMED;
            item ["pro_preunitario"]    = PREUNIT;
            item ['pro_preref']     = PREREF;
            item ["pro_tipoprecio"]     = TIPOPRECIO;
            item ["pro_igv"]    = IGV;
            item ['pro_tipoimpuesto']   = TIPOIMPUESTO;
            item ["pro_isc"]    = ISC;
            item ["pro_otroimpuesto"]   = OTROIMPUESTO;
            item ['pro_subtotal']   = SUBTOTAL;
            item ['pro_total']  = TOTAL;
            //una vez agregados los datos al array "item" declarado anteriormente hacemos un .push() para agregarlos a nuestro array principal "DATA".
            DATA.push(item);
        }
    });
    return DATA;
}

function RecorreDatosAdicional(){

    //tenemos 2 variables, la primera será el Array principal donde estarán nuestros datos y la segunda es el objeto tabla
    var DATA2    = [];
    var TABLA2   = $("#table_adicional tbody > tr");
 
    //una vez que tenemos la tabla recorremos esta misma recorriendo cada TR y por cada uno de estos se ejecuta el siguiente codigo
    TABLA2.each(function(){
        //por cada fila o TR que encuentra rescatamos 3 datos, el ID de cada fila, la Descripción que tiene asociada en el input text, y el valor seleccionado en un select
        var CodDatoAdicional      = $(this).find('td').eq(0).text(),
            DesAdicional    = $(this).find('td').eq(1).text();
           
 			
        //entonces declaramos un array para guardar estos datos, lo declaramos dentro del each para así reemplazarlo y cada vez
        item2 = {};
        //si miramos el HTML vamos a ver un par de TR vacios y otros con el titulo de la tabla, por lo que le decimos a la función que solo se ejecute y guarde estos datos cuando exista la variable ID, si no la tiene entonces que no anexe esos datos.
        if(CodDatoAdicional !== ''){
            item2 ["CodDatoAdicional"]     = CodDatoAdicional;
            item2 ["DesAdicional"]   = DesAdicional;
           
            //una vez agregados los datos al array "item" declarado anteriormente hacemos un .push() para agregarlos a nuestro array principal "DATA".
            DATA2.push(item2);
        }
    });
    return DATA2;
}

function RecorreDocRelacionado(){

    //tenemos 2 variables, la primera será el Array principal donde estarán nuestros datos y la segunda es el objeto tabla
    var DATA3    = [];
    var TABLA3   = $("#table_relacionados tbody > tr");
 
    //una vez que tenemos la tabla recorremos esta misma recorriendo cada TR y por cada uno de estos se ejecuta el siguiente codigo
    TABLA3.each(function(){
        //por cada fila o TR que encuentra rescatamos 3 datos, el ID de cada fila, la Descripción que tiene asociada en el input text, y el valor seleccionado en un select
        var CodDocRelacionado      = $(this).find('td').eq(0).text(),
            docuRelacionado    = $(this).find('td').eq(1).text();
           
 			
        //entonces declaramos un array para guardar estos datos, lo declaramos dentro del each para así reemplazarlo y cada vez
        item3 = {};
        //si miramos el HTML vamos a ver un par de TR vacios y otros con el titulo de la tabla, por lo que le decimos a la función que solo se ejecute y guarde estos datos cuando exista la variable ID, si no la tiene entonces que no anexe esos datos.
        if(CodDocRelacionado !== ''){
            item3 ["CodDocRelacionado"]     = CodDocRelacionado;
            item3 ["docuRelacionado"]   = docuRelacionado;
           
            //una vez agregados los datos al array "item" declarado anteriormente hacemos un .push() para agregarlos a nuestro array principal "DATA".
            DATA3.push(item3);
        }
    });
    return DATA3;
}

function RecorreDiscrepancias(){

    //tenemos 2 variables, la primera será el Array principal donde estarán nuestros datos y la segunda es el objeto tabla
    var DATA4    = [];
    var TABLA4   = $("#table_discrepancia tbody > tr");
 
    //una vez que tenemos la tabla recorremos esta misma recorriendo cada TR y por cada uno de estos se ejecuta el siguiente codigo
    TABLA4.each(function(){
        //por cada fila o TR que encuentra rescatamos 3 datos, el ID de cada fila, la Descripción que tiene asociada en el input text, y el valor seleccionado en un select
        var TipDiscrepancia      = $(this).find('td').eq(0).text(),
            NumReferenciaDis    = $(this).find('td').eq(1).text(),
            DesReferenciaDis    = $(this).find('td').eq(2).text();
           
 			
        //entonces declaramos un array para guardar estos datos, lo declaramos dentro del each para así reemplazarlo y cada vez
        item4 = {};
        //si miramos el HTML vamos a ver un par de TR vacios y otros con el titulo de la tabla, por lo que le decimos a la función que solo se ejecute y guarde estos datos cuando exista la variable ID, si no la tiene entonces que no anexe esos datos.
        if(NumReferenciaDis !== ''){
            item4 ["TipDiscrepancia"]     = TipDiscrepancia;
            item4 ["NumReferenciaDis"]   = NumReferenciaDis;
            item4 ["DesReferenciaDis"]   = DesReferenciaDis;
           
            //una vez agregados los datos al array "item" declarado anteriormente hacemos un .push() para agregarlos a nuestro array principal "DATA".
            DATA4.push(item4);
        }
    });
    return DATA4;
}

function RecorreDocumentosAnulados(){

    //tenemos 2 variables, la primera será el Array principal donde estarán nuestros datos y la segunda es el objeto tabla
    var DATA5    = [];
    var TABLA5   = $("#tableAnula tbody > tr");
 
    //una vez que tenemos la tabla recorremos esta misma recorriendo cada TR y por cada uno de estos se ejecuta el siguiente codigo
    TABLA5.each(function(){
        //por cada fila o TR que encuentra rescatamos 3 datos, el ID de cada fila, la Descripción que tiene asociada en el input text, y el valor seleccionado en un select
        var TipDocAnula      = $(this).find('td').eq(0).text(),
            SerAnula    = $(this).find('td').eq(1).text(),
            CorrelAnula    = $(this).find('td').eq(2).text(),
            MotivoAnula    = $(this).find('td').eq(3).text();
           
 			
        //entonces declaramos un array para guardar estos datos, lo declaramos dentro del each para así reemplazarlo y cada vez
        item5 = {};
        //si miramos el HTML vamos a ver un par de TR vacios y otros con el titulo de la tabla, por lo que le decimos a la función que solo se ejecute y guarde estos datos cuando exista la variable ID, si no la tiene entonces que no anexe esos datos.
        if(TipDocAnula !== ''){
            item5 ["TipDocAnula"]     = TipDocAnula;
            item5 ["SerAnula"]   = SerAnula;
            item5 ["CorrelAnula"]   = CorrelAnula,
            item5 ["MotivoAnula"]   = MotivoAnula;
           
            //una vez agregados los datos al array "item" declarado anteriormente hacemos un .push() para agregarlos a nuestro array principal "DATA".
            DATA5.push(item5);
        }
    });
    return DATA5;
}


//VER FUNCIONAMIENTO Y USAR EN OTRO LADO
/*
function grabaTodoTabla(TABLAID){
	//tenemos 2 variables, la primera será el Array principal donde estarán nuestros datos y la segunda es el objeto tabla
	var DATA 	= [];
	var TABLA 	= $("#"+TABLAID+" tbody > tr");
 
	//una vez que tenemos la tabla recorremos esta misma recorriendo cada TR y por cada uno de estos se ejecuta el siguiente codigo
	TABLA.each(function(){
		//por cada fila o TR que encuentra rescatamos 3 datos, el ID de cada fila, la Descripción que tiene asociada en el input text, y el valor seleccionado en un select
		var ID 		= $(this).find('td').eq(0).text(),
			DESC 	= $(this).find('td').eq(1).text(),
			CANTIDAD = $(this).find('td').eq(2).text(),
			UNIMED 	= $(this).find('td').eq(3).text(),
			PREUNIT	= $(this).find('td').eq(4).text(),
			PREREF 	= $(this).find('td').eq(5).text(),
			TIPOPRECIO= $(this).find('td').eq(6).text(),
			IGV= $(this).find('td').eq(7).text(),
			TIPOIMPUESTO= $(this).find('td').eq(8).text(),
			ISC= $(this).find('td').eq(9).text(),
			OTROIMPUESTO= $(this).find('td').eq(10).text(),
			SUBTOTAL= $(this).find('td').eq(11).text(),
			TOTAL= $(this).find('td').eq(12).text();
 
		//entonces declaramos un array para guardar estos datos, lo declaramos dentro del each para así reemplazarlo y cada vez
		item = {};
		//si miramos el HTML vamos a ver un par de TR vacios y otros con el titulo de la tabla, por lo que le decimos a la función que solo se ejecute y guarde estos datos cuando exista la variable ID, si no la tiene entonces que no anexe esos datos.
		if(ID !== ''){
	        item ["pro_id"] 	= ID;
	        item ["pro_desc"] 	= DESC;
	        item ['pro_cantidad'] 	= CANTIDAD;
	        item ["pro_unimedida"] 	= UNIMED;
	        item ["pro_preunitario"] 	= PREUNIT;
	        item ['pro_preref'] 	= PREREF;
	        item ["pro_tipoprecio"] 	= TIPOPRECIO;
	        item ["pro_igv"] 	= IGV;
	        item ['pro_tipoimpuesto'] 	= TIPOIMPUESTO;
	        item ["pro_isc"] 	= ISC;
	        item ["pro_otroimpuesto"] 	= OTROIMPUESTO;
	        item ['pro_subtotal'] 	= SUBTOTAL;
	        item ['pro_total'] 	= TOTAL;
	        //una vez agregados los datos al array "item" declarado anteriormente hacemos un .push() para agregarlos a nuestro array principal "DATA".
	        DATA.push(item);
		}
	});
	
 
	//eventualmente se lo vamos a enviar por PHP por ajax de una forma bastante simple y además convertiremos el array en json para evitar cualquier incidente con compativilidades.
	INFO 	= new FormData();
	aInfo 	= JSON.stringify(DATA); 	
	INFO.append('data', aInfo);
	//INFO.append('formulario', $("#documento").serialize());
	//console.log(aInfo +  {'dato':$("#documento").serialize()});
 	//console.log($("#documento").serialize());
	/*$.ajax({
		data: $("#documento").serialize(), //{'tabla':INFO,'formulario':$("#documento").serialize()},
		type: 'POST',
		url : base_url+'generaxml/generar_xml',
		processData: false, 
		contentType: false,
		success: function(r){
			//Una vez que se haya ejecutado de forma exitosa hacer el código para que muestre esto mismo.
			console.log(r);
		}
	});*/

	/*var project = {};

	  $("#documento").serializeArray().map(function(x) {
	    project[x.name] = x.value;
	  });
	  var dato = {'formulario': project,'tabla':DATA,'token':<?php echo $this->security->get_csrf_hash() ?>}
  	

  	//console.log( JSON.stringify($("#documento").serializeArray()) + "-------" + aInfo);

	console.log(dato);
	$.ajax({
		url:$("#documento").attr('action'),
		type:'post',
		data:dato,
		//dataType:'json',
		beforeSend:function(){
			
		},	
		success:function(rpta){
			
			console.log(rpta);
			
		},
		error:function(rpta){					
			console.log(rpta);

			
		}

	});
}*/