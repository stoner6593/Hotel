// JavaScript Document

function formatCurrency(num) 
// HACER QUE LOS NUMEROS TENGAN DECIMALES Y MILLARES EN LOS FORM
{
	if (isNaN(num)){
		num=0;
	}
	if (num==""){
		num=0;	
	}
	prefix=''; // '$' Puede entrar como parametro el tipo de moneda
	num = Math.round(parseFloat(num)*Math.pow(10,2))/Math.pow(10,2)  
	prefix = prefix || '';  
	num += '';  
	var splitStr = num.split('.');  
	var splitLeft = splitStr[0];  
	var splitRight = splitStr.length > 1 ? '.' + splitStr[1] : '.00';  
	splitRight = splitRight + '00';  
	splitRight = splitRight.substr(0,3);  
	var regx = /(\d+)(\d{3})/;  
	while (regx.test(splitLeft)) {  
	splitLeft = splitLeft.replace(regx, '$1' + ',' + '$2');
	}  
	return (prefix + splitLeft + splitRight); 
	
/*  ESTE ES LA FUNCION ANTERIOR
	num = num.toString().replace(/\$|\,/g,'');
	if (isNaN(num))
	num = 0;
	var signo = (num == (num = Math.abs(num)));
	num = Math.floor(num * 100 + 0.50000000001);
	centavos = num % 100;
	num = Math.floor(num / 100).toString();
	
	if (centavos < 10)
	centavos = '0' + centavos;
	
	for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
	num = num.substring(0, num.length - (4 * i + 3)) + ',' + num.substring(num.length - (4 * i + 3));
	
	return num + '.' + centavos;
*/
}	

function sumarFecha(fecha)
// AUMENTAR LAS FECHAS EN UN AÑO
{ 
	var linea = new String(fecha);
	var anio = parseInt(linea.substr(6, 4)) + 1;
	var diames = linea.substr(0,6);
	var nuevafecha =  diames + anio;
	
	if (nuevafecha=="NaN"){
		//document.form1.fechahasta.value = "";
		 return ("");
	}
	else {
		//document.form1.fechahasta.value = nuevafecha;
		return (nuevafecha);
	}
}

function EliminarComa(numero){
	// ELIMINAR COMA DE NUMEROS MILLARES
	var patron = ',';
	var prueba = numero;
	var resultado = prueba.replace(patron,'');
	var prueba = resultado;
	var resultado = prueba.replace(patron,'');
	var prueba = resultado;
	var resultado = prueba.replace(patron,'');
	var prueba = resultado;
	var resultado = prueba.replace(patron,'');
	return (resultado);
}

function soloNumero(e) { // 1
    tecla = (document.all) ? e.keyCode : e.which; // 2
    if (tecla==8) return true; // 3
	if (tecla==9) return true; // 3
    patron =/[0-9]/; // 4	(Sirequiere decimales: patron =/[0-9-.]/;)
    te = String.fromCharCode(tecla); // 5
	
    return patron.test(te); // 6
	
	// patron = /\d/; // Solo acepta números
	// patron = /\w/; // Acepta números y letras
	// patron = /\D/; // No acepta números
	// patron =/[A-Za-zñÑ\s]/; // igual que el ejemplo, pero acepta también las letras ñ y Ñ
	// patron = /[ajt69]/; //Acepta solo determinados caracteres
	
	//Dato los caracteres, excepto:
	// patron =/[javierb]/; // 4
	// te = String.fromCharCode(tecla); // 5
	// return !patron.test(te); // 6
} 



function sololetrasynumeros (e) {
	tecla = (document.all) ? e.keyCode : e.which; // 2
    if (tecla==8) return true; // 3
	if (tecla==0) return true; // 3
    // patron =/\w/;; // 4
	patron = /[abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ1234567890-]/;
    te = String.fromCharCode(tecla); // 5
    return patron.test(te); // 6
}

function Anovehiculo(anoactual, fabricacion) 
	{ 
	var resultado = anoactual - fabricacion;
	return (resultado);
	// var f = document.forms['form1']; 
	// f.antiguedad.value = parseInt(f.anoactual.value) - parseInt(f.txtfabricacion.value);
	
	};

function espacioVacio(q) {  
	for ( i = 0; i < q.length; i++ ) {  
			if ( q.charAt(i) != " " ) {  
					return true  
			}  
	}  
	return false  
}

function ddn(num){
	var codigo = '';
	if (num==1){
		codigo = '(041)';
	}else if (num==2){
		codigo = '(043)';
	}else if (num==3){
		codigo = '(083)';
	}else if (num==4){
		codigo = '(054)';
	}else if (num==5){
		codigo = '(066)';
	}else if (num==6){
		codigo = '(076)';
	}else if (num==7){
		codigo = '(084)';
	}else if (num==8){
		codigo = '(067)';
	}else if (num==9){
		codigo = '(062)';
	}else if (num==10){
		codigo = '(056)';
	}else if (num==11){
		codigo = '(064)';
	}else if (num==12){
		codigo = '(044)';
	}else if (num==13){
		codigo = '(074)';
	}else if (num==14){
		codigo = '(01)';
	}else if (num==15){
		codigo = '(065)';
	}else if (num==16){
		codigo = '(082)';
	}else if (num==17){
		codigo = '(053)';
	}else if (num==18){
		codigo = '(063)';
	}else if (num==19){
		codigo = '(073)';
	}else if (num==20){
		codigo = '(051)';
	}else if (num==21){
		codigo = '(042)';
	}else if (num==22){
		codigo = '(052)';
	}else if (num==23){
		codigo = '(072)';
	}else if (num==24){
		codigo = '(01)';
	}else if (num==25){
		codigo = '(061)';	
	}else{
		codigo = '';
	}	
	return codigo;
}

function redondea(sVal){ 
	var nDec = 2;
    var n = parseFloat(sVal); 
    var s = "0.00"; 
    if (!isNaN(n)){ 
     n = Math.round(n * Math.pow(10, nDec)) / Math.pow(10, nDec); 
     s = String(n); 
     s += (s.indexOf(".") == -1? ".": "") + String(Math.pow(10, nDec)).substr(1); 
     s = s.substr(0, s.indexOf(".") + nDec + 1); 
    } 
    return s; 
} 