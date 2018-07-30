<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cliente_soap extends CI_Controller
{
	function __construct() {
       parent::__construct();
		global $wsdl, $client;
		
		//$this->load->library('Soap_lib');
		 //$this->load->library('CustomHeaders');
		 
		$wsdl ='https://www.sunat.gob.pe/ol-ti-itcpgem-sqa/billService?wsdl';

       /* try {
			if($this->url_exists($wsdl)!="1"){
				$error=array("success"=>0,"errors"=>"No Hay Conexi&oacute;n a Internet");
			}else{				
				$client = new SoapClient($wsdl, [
					'wsdl_cache' => WSDL_CACHE_NONE,
					'trace' => TRUE,
					"exceptions" => TRUE
				] );
				$error=array("success"=>"Todo OK","errors"=>0);
			}
			
			
		} catch (SoapFault $fault) {
			//trigger_error("SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})", E_USER_ERROR);
			$error=array("success"=>0,"errors"=>array("faultcode:"=> $fault->faultcode,"faultstring:"=> $fault->faultstring));
			
		}*/
		$user="20525411401MLZAPBJL";
		$pass="ckdXTcTxf";
		require_once(str_replace("\\", "/", APPPATH).'libraries/CustomHeaders.php');			
		$headers=new CustomHeaders("20525411401MLZAPBJL", "ckdXTcTxf");
		$client = new SoapClient($wsdl, [ 'cache_wsdl' => WSDL_CACHE_NONE, 'trace' => 1 , 'soap_version' => SOAP_1_1 ] ); 
		$client->__setSoapHeaders([$headers]); 
			//print_r($fcs = $client->__getFunctions()); 
			$estado = $client->getStatus([
			'ticket' => '201600638220110'
			]);
		echo "====== REQUEST HEADERS =====" . PHP_EOL;
			//var_dump($client->__getLastRequestHeaders());
			echo "========= REQUEST ==========" . PHP_EOL;
			var_dump($client->__getLastRequest());
			echo "========= RESPONSE =========" . PHP_EOL;
			//var_dump($client);
			
		try {
			
			//$headers = $this->CustomHeaders("20525411401MLZAPBJL", "ckdXTcTxf");
			
			
			
			/*array
			(
			'encoding'  => 'ISO-8859-1',
			'exception' => True,
			'trace'     => True,
			)*/
			
			//var_dump($estado);
			//print_r($estado->status->content);
			//$r=file_get_contents($estado->status);
			

		} catch (SoapFault $fault) {
			
			
			//echo htmlentities(file_get_contents($wsdl));
			
			//var_dump($fault);
			//trigger_error("ERROR SOAP: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})", E_USER_ERROR);
			//var_dump("ERROR SOAP: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})", E_USER_ERROR);
		}

			 
		//echo json_encode($error);
    }
	
	

	function index(){
		global $wsdl, $client;
		//$this->load->library('CustomHeaders');
		
        try {
			if($client):
				//$headers = new SoapHeader('20102501293WILL2016', '02870964'); 
				//$client->__setSoapHeaders([$headers]);				
				//$fcs = $client->__getFunctions();
				//var_dump($fcs);
			endif;
			/*$estado = $client->getStatus([
			'ticket' => '201700778150370'
			]);
			//var_dump($estado);
			/*$array = [
				'Encabezado' => [
					'IdDoc' => [
						'TipoDTE' => 33,
						'Folio' => 1,
					],
					'Emisor' => [
						'RUTEmisor' => '76192083-9',
						'RznSoc' => 'SASCO SpA',
						'GiroEmis' => 'Servicios integrales de informática',
						'Acteco' => 726000,
						'DirOrigen' => 'Santiago',
						'CmnaOrigen' => 'Santiago',
					],
					'Receptor' => [
						'RUTRecep' => '60803000-K',
						'RznSocRecep' => 'Servicio de Impuestos Internos',
						'GiroRecep' => 'Gobierno',
						'DirRecep' => 'Alonso Ovalle 680',
						'CmnaRecep' => 'Santiago',
					],
				],
			];*/
			//print_r($array['Encabezado']['IdDoc']);
			

        } catch (SoapFault $exception) {
            echo $exception;
        }
		
        //echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
        //echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
        //echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>'; //this generates a lot of text!
	}
	
	
	public function url_exists( $url = NULL ) {

		 if( empty( $url ) ){
			return false;
		}

		// get_headers() realiza una petición GET por defecto
		// cambiar el método predeterminadao a HEAD
		// Ver http://php.net/manual/es/function.get-headers.php
		stream_context_set_default(
			array(
				'http' => array(
					'method' => 'HEAD'
				 )
			)
		);
		$headers = @get_headers( $url );
		sscanf( $headers[0], 'HTTP/%*d.%*d %d', $httpcode );

		//Aceptar solo respuesta 200 (Ok), 301 (redirección permanente) o 302 (redirección temporal)
		$accepted_response = array( 200, 301, 302 );
		if( in_array( $httpcode, $accepted_response ) ) {
			return true;
		} else {
			return false;
		}

	}

}
?>