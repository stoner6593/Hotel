<?php 
class CustomHeaders extends SoapHeader { 
	
	private $wss_ns = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd'; //http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd
		function __construct(array $params ) {
			 $ns = null; 
			if ($ns) { 
				$this->wss_ns = $ns; 
			} 
		$auth = new stdClass(); 
		$auth->Username = new SoapVar($params['user'], XSD_STRING, NULL, $this->wss_ns, NULL, $this->wss_ns); 
		$auth->Password = new SoapVar($params['pass'], XSD_STRING, NULL, $this->wss_ns, NULL, $this->wss_ns); 
		$username_token = new stdClass(); 
		$username_token->UsernameToken = new SoapVar($auth, SOAP_ENC_OBJECT, NULL, $this->wss_ns, 'UsernameToken', $this->wss_ns); 
		$security_sv = new SoapVar( new SoapVar($username_token, SOAP_ENC_OBJECT, NULL, $this->wss_ns, 'UsernameToken', $this->wss_ns), SOAP_ENC_OBJECT, NULL, $this->wss_ns, 'Security', $this->wss_ns); 
		parent::__construct($this->wss_ns, 'Security', $security_sv, true);

	}
	public function ver(){}
}
?>
