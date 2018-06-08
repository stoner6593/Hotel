<!doctype html>
<html>
<head>
<meta charset="utf-8">
</head>

<body>

<?php  
	date_default_timezone_set('America/Lima');
	
	$xhora = time(); // Hora actual   
	echo date('h:i a',$xhora)." - ";      
	 
	$xhora = $xhora + (60 *60 * 3);   
	echo date('h:i a', $xhora); // + 12 horas
	
	echo '<br><br>';
	
	$nrodias = 3;
	$fechahoy = date('Y-m-d');
	$nuevafecha = strtotime ( '+'. $nrodias .'day' , strtotime ( $fechahoy ) ) ;
	$nuevafecha = date ( 'Y-m-j' , $nuevafecha );
	echo $nuevafecha;
?>

</body>
</html>