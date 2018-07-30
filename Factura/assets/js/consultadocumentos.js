 $(function(){

	$("#DocReceptor").on("keyup",function(e){

		e.preventDefault();
		var n = $("#DocReceptor").val().length ;

		if(n==11){
				
			$.ajax({
				url:base_url+"Configuracion/BuscaRuc",
				type:"get",
				data:{"doc":$("#DocReceptor").val()},	
				dataType: 'json',
				success:function(data){
					//console.log(data);					
					$("#NomLegalEmisor").val(data.success.RazonSocial);
					$("#DireccionEmisor").val(data.success.Direccion);					
					
					  
				 },
				 error:function(data){
					alertify.error("Ocurrió un error durante el proceso..!");
					console.log(data);
					  
				 }


			});
		}
	})
})
function ConsultaDocumento(){

	if(("#DocReceptor").length==11){

		console.log($("#DocReceptor").val());
	}
}