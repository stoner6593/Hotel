<link href="opera.css" rel="stylesheet" type="text/css">
<!-- <link href="http://fontawesome.io/assets/font-awesome/css/font-awesome.css" rel="stylesheet">  -->
<link href="awesome/css/font-awesome.css" rel="stylesheet"> 



<!-- MSG 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="bootstrapmsg/bootstrap.min.css"> 
-->
<script src="bootstrapmsg/jquery.min.js"></script>
<script src="bootstrapmsg/bootstrap.min.js"></script>
<script src="alert/sweetalert.min.js"></script>

<script type="text/javascript">
	<!--
	$(document).ready(function () {
	window.setTimeout(function() {
		$(".alert").fadeTo(1500, 0).slideUp(500, function(){
			$(this).remove(); 
		});
	}, 5000);
	 
	});
	//-->
</script>

<style>
	.jumbotron{padding-top:48px;padding-bottom:48px}.container .jumbotron,.container-fluid .jumbotron{padding-right:60px;padding-left:60px}.jumbotron .h1,.jumbotron h1{font-size:63px}}.thumbnail{display:block;padding:4px;margin-bottom:20px;line-height:1.42857143;background-color:#fff;border:1px solid #ddd;border-radius:4px;-webkit-transition:border .2s ease-in-out;-o-transition:border .2s ease-in-out;transition:border .2s ease-in-out}.thumbnail a>img,.thumbnail>img{margin-right:auto;margin-left:auto}a.thumbnail.active,a.thumbnail:focus,a.thumbnail:hover{border-color:#337ab7}.thumbnail .caption{padding:9px;color:#333}.alert{padding:15px;margin-bottom:20px;border:1px solid transparent;border-radius:4px}.alert h4{margin-top:0;color:inherit}.alert .alert-link{font-weight:700}.alert>p,.alert>ul{margin-bottom:0}.alert>p+p{margin-top:5px}.alert-dismissable,.alert-dismissible{padding-right:35px}.alert-dismissable .close,.alert-dismissible .close{position:relative;top:-2px;right:-21px;color:inherit}.alert-success{color:#3c763d;background-color:#dff0d8;border-color:#d6e9c6}.alert-success hr{border-top-color:#c9e2b3}.alert-success .alert-link{color:#2b542c}.alert-info{color:#31708f;background-color:#d9edf7;border-color:#bce8f1}.alert-info hr{border-top-color:#a6e1ec}.alert-info .alert-link{color:#245269}.alert-warning{color:#8a6d3b;background-color:#fcf8e3;border-color:#faebcc}.alert-warning hr{border-top-color:#f7e1b5}.alert-warning .alert-link{color:#66512c}.alert-danger{color:#a94442;background-color:#f2dede;border-color:#ebccd1}.alert-danger hr{border-top-color:#e4b9c0}.alert-danger .alert-link{color:#843534}
</style>

<!-- Data Picker-->
<link rel="stylesheet" type="text/css" href="jqueryui/jquery-ui.css">
<script src="jqueryui/jquery-ui.js"></script>
<script src="jqueryui/jquery-1.12.4.js"></script>
<script src="jqueryui/jquery-ui.js"></script>



<script>
	$( function() {
		<?php
			$archivo = basename($_SERVER['PHP_SELF']); 
			if ($archivo == "huespedes-editor.php"){
		?>
		
		$( "#datepicker" ).datepicker(); //Permite todo
		
		<?php }else{?>
		
		$("#datepicker").datepicker({ minDate: 0 }); //No Permite dias pasados
		
		<?php
		}
		?>
	} );
	
	$( function() {
		<?php
			$archivo = basename($_SERVER['PHP_SELF']); 
			if ($archivo == "huespedes-editor.php"){
		?>
		
		$( "#datepickerdos" ).datepicker(); //Permite todo
		
		<?php }else{?>
		
		$("#datepickerdos").datepicker({ minDate: 0 }); //No Permite dias pasados
		$("#datepickertres").datepicker({ minDate: 0 }); //No Permite dias pasados
		
		<?php
		}
		?>
	} );
</script>



<script src="include/funcionesComunes.js"></script>

<!-- Evitar Actualizar-->
<script>
	$(function() {
	 $(document).keydown(function(e){
	  var code = (e.keyCode ? e.keyCode : e.which);
	  if(code == 116) {
	   e.preventDefault();
	  }
	 });
	});
</script>


<!-- Modal MSG CSS -->
<link type='text/css' href='modalmsg/confirm.css' rel='stylesheet' media='screen' />