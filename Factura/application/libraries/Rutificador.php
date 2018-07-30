<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Rutificador{
	
	function __construct(){
		
	}
	
	function BuscaDatosRutificador($dniruc=null){
		
			$urlDatos = 'http://peru.rutificador.com/';
			if(!$webString = file_get_contents($urlDatos))
				 throw new Exception('Existe un error al conectarse con el servidor, favor contactar al administrador stoner6593@gmail.com.'); 
			//aquí se busca el dato $csrfmiddlewaretoken en un input de html: <input type='hidden' name='csrfmiddlewaretoken' value='IOV6qRNIzsFRhqxAxGC8emzjKz1Wq4nX' /> y es cargado en la variable $csrfmiddlewaretoken
			$pattern = '/<input(.*?)name=\'csrfmiddlewaretoken\'(.*)value=\'(.*?)\'/i';
			preg_match_all($pattern, $webString, $matches);
			if(!$csrfmiddlewaretoken = $matches[3][0])
				throw new Exception('Existe un error al conectarse con el servidor, favor contactar al administrador stoner6593@gmail.com.'); 
			$csrftoken = $csrfmiddlewaretoken; // es el mismo token
			$urlPost = "http://peru.rutificador.com/get_generic_ajax/";
			$agents = 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:52.0) Gecko/20100101 Firefox/52.0';
			$referer = $urlDatos;
			$fields = array(
				'csrfmiddlewaretoken' => $csrfmiddlewaretoken,
				'entrada' => $dniruc
			);
			$fields_string = http_build_query($fields);
			//abro la conexión
			$ch = curl_init();
			//seteo las opciones
			curl_setopt($ch, CURLOPT_URL, $urlPost);
			curl_setopt($ch, CURLOPT_REFERER, $referer);
			curl_setopt($ch, CURLOPT_USERAGENT, $agents);
			curl_setopt($ch, CURLOPT_COOKIE, 'csrftoken=' . $csrftoken);
			curl_setopt($ch, CURLOPT_POST, count($fields));
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			//ejecuto el post
			$result = curl_exec($ch);
			//cierro la conexión
			curl_close($ch);
			return $result;
		
	}
}
?>