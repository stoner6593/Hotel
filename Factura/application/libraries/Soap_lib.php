 <?php 
if ( ! defined('BASEPATH')) exit('No se permite el acceso directo a las p&aacute;ginas de este sitio.');

class Soap_lib extends Customheaders {

   function  __construct() {
     

   } // end Constructor

   function enviar_sunat(){
   		global $wsdl, $client;
      	$wsdl ='https://www.sunat.gob.pe/ol-ti-itcpgem-sqa/billService?wsdl';
	   	$user="20102501293MODDATOS";
		$pass="moddatos";
				
		$headers=$this->Customheaders($user, $pass);
		//$client = new SoapClient($wsdl, [ 'cache_wsdl' => WSDL_CACHE_NONE, 'trace' => 1 , 'soap_version' => SOAP_1_1 ] ); 
		//$client->__setSoapHeaders([$headers]); 
		//print_r($headers);
   }
 
} // end Class
?>