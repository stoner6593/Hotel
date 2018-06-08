<?php
	require_once("./src/autoload.php");
	
	$cliente = new \Sunat\Sunat(true, true);
	//$ruc = "20601075246"; // RUC de 11 digitos
	//$dni = "00000000"; // DNI de 8 digitos
	$documento=$_POST['documento'];
	$tipo_documento=$_POST['tipo_documento'];
	
	if(strlen ($documento)==8 and $tipo_documento==1){
		echo ( $cliente->search( $documento ,true) );
	}else if(strlen ($documento)==11 and $tipo_documento==6){
		echo ( $cliente->search( $documento ,true) );
	}else{
		echo json_encode(array(	"success" 	=> false,
								"msg" 		=> "No se ha encontrado resultados."
							));
	}
	//print_r ( $cliente->search( $ruc ) );
	//print_r ( $cliente->search( $dni ) );
?>
