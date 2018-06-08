
<!DOCTYPE html>
<html>
<head>
<title> SimpleModal Confirm Modal Dialog </title>
<meta name='author' content='Eric Martin' />
<meta name='copyright' content='2010 - Eric Martin' />

</head>
<body>

<?php


//$fecha = strtotime("2017-08-05 10:05:27");
$fechafin = date("2017-08-05 10:05:27"); //Fecha Hora Fin
$fechahoy = date("Y-m-d H:i:s");  //date("2017-08-05 09:57:27"); //Fecha Hora del Sistema

 
$minutos = ceil((strtotime($fechafin) - strtotime($fechahoy)) / 60);
 
if ($minutos <= 15) {
	 echo 'Menos de 15 minutos de diferencia';
}else{
	echo 'Mas de 15 minutos de diferencia';
}

echo "<br><br>";
$dia = date('w', strtotime($fechahoy));
$hora = date('H:i',strtotime($fechahoy));
$horamedia = date('H:i', strtotime('08:00:00'));

echo "Dia: ".$dia."<br>";
echo "Hora: ".$hora."<br><br>";
echo "Fecha: ".$fechahoy."<br><br>";

if($hora < "18:30"){
	echo "Es antes de 18:30";
}else{
	echo "Es depues de 18:30";
}

?>

</body>
</html>