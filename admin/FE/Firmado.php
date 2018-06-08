 <?php 

/**
* 
*/
 include('xmlseclibs-master/xmlseclibs.php');
use RobRichards\XMLSecLibs\XMLSecurityDSig;
use RobRichards\XMLSecLibs\XMLSecurityKey;

class Firmado
{
	
	public $firma='';
	function __construct()
	{
		# code...
		$this->firma=$firma;
      
	}

	
	public function Firmar_xml($arrayFirmado){
		
		
		
		// Load the XML to be signed
		$doc = new DOMDocument();
		$doc->load('XML/'.$arrayFirmado['NomDocXML'].'.xml');

		// Create a new Security object 
		$objDSig = new XMLSecurityDSig();
		// Use the c14n exclusive canonicalization
		$objDSig->setCanonicalMethod(XMLSecurityDSig::EXC_C14N);
		// Sign using SHA-256
		$objDSig->addReference(
		    $doc, 
		    XMLSecurityDSig::SHA1, 
		    array('http://www.w3.org/2000/09/xmldsig#enveloped-signature'),
		    array('force_uri' => true)
		);

		// Create a new (private) Security key
		$objKey = new XMLSecurityKey(XMLSecurityKey::RSA_SHA1, array('type'=>'private'));
		// Load the private key
		$objKey->loadKey('certificado/prikey.pem', TRUE);
		/* 
		If key has a passphrase, set it using 
		$objKey->passphrase = '<passphrase>';
		*/
		//whetosing
		// Sign the XML file
		//print_r($doc->getElementsByTagName('ExtensionContent')->item(0));
		$objDSig->sign($objKey);

		// Add the associated public key to the signature
		$objDSig->add509Cert(file_get_contents('certificado/cert.pem'), true, false, array('subjectName' => true)); // array('issuerSerial' => true, 'subjectName' => true)); 
		//print_r($doc->getElementsByTagName('ExtensionContent')->item(1));
		// Append the signature to the XML
		

		//$valor=$doc->getElementsByTagName('ExtensionContent')->item(0);

		//print_r($valor);
		if($arrayFirmado['TipoDocumento']=='RC'){
			$objDSig->appendSignature($doc->getElementsByTagName('ExtensionContent')->item(0));
			$nomDoc=$arrayFirmado['RUCEmisor'].'-'.$arrayFirmado['NomDocXML'].'.xml';
		}
		else
		{
			$objDSig->appendSignature($doc->getElementsByTagName('ExtensionContent')->item(1));
			//Nombre del documento xml
			$nomDoc=$arrayFirmado['RUCEmisor'].'-'.$arrayFirmado['TipoDocumento'].'-'.$arrayFirmado['NomDocXML'].'.xml';
		}
		
		
		
		// Save the signed XML
		$doc->save('XMLFIRMADOS/'.$nomDoc);
		//$retornar=array('nomDoc'=>$nomDoc,'objKey'=>);
		$this->firma=$objDSig->firma;
		return $nomDoc;
		
		
	}

}
?>