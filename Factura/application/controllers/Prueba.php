<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Prueba extends CI_Controller
{
	public function __construct()
	{
		parent:: __construct();
		//$this->library('Espacionombres');
		
	}

	public function index()
	{
		
		//$this->load->view('welcome_message');
		//echo $this->documentoelectronico->mensaje();
		//var_dump($this->espacionombres);
		//echo $this->espacionombres->xmlns;
	//header("Content-type: text/xml,  charset-ISO-8859-1"); //quitar slash

	
	//Asignacion de datos
	$this->documentoelectronico->setId("FF11-00000001");
	$fecha=date("Y-m-d");	
	$this->documentoelectronico->setIssueDate($fecha);
	$totals = array(
		array(
			"ID"=>"1001",
			"PayableAmount"=>"127.12",
			"currencyID"=>"PEN",
		),
		array(
			"ID"=>"1002",
			"PayableAmount"=>"0.00",
			"currencyID"=>"PEN",
		),
		array(
			"ID"=>"1003",
			"PayableAmount"=>"0.00",
			"currencyID"=>"PEN",
		),
		array(
			"ID"=>"1004",
			"PayableAmount"=>"0.00",
			"currencyID"=>"PEN",
		)/*,
		array(
			"ID"=>"1000",
			"PayableAmount"=>"SON SIETE CIENTOS CON  DIEZ Y SIETE  00/100",
			"currencyID"=>"PEN",
		)*/
	);
	$writer = new XMLWriter(); 
	//$writer->openURI('php://output');// quitar slash
	$writer->openMemory();
	$writer->startDocument('1.0','ISO-8859-1'); 

	$writer->startElement('Invoice');  
		$writer->writeAttribute('xmlns',$this->espacionombres->xmlnsInvoice);          
		$writer->writeAttributeNS('xmlns','cac', null,$this->espacionombres->cac);
		$writer->writeAttributeNS('xmlns','cbc', null, $this->espacionombres->cbc);
		$writer->writeAttributeNS('xmlns','cctss', null, $this->espacionombres->ccts);
		$writer->writeAttributeNS('xmlns','ds', null, $this->espacionombres->ds);
		$writer->writeAttributeNS('xmlns','ext', null,$this->espacionombres->ext);
		$writer->writeAttributeNS('xmlns','qdt', null, $this->espacionombres->qdt);
		$writer->writeAttributeNS('xmlns','sac', null, $this->espacionombres->sac);
		$writer->writeAttributeNS('xmlns','udt', null, $this->espacionombres->udt);
		$writer->writeAttributeNS('xmlns','xsi', null, $this->espacionombres->xsi);
		
		//INICIO UBLExtensions
		$writer->startElement('ext:UBLExtensions');
			$writer->startElement('ext:UBLExtension');  
				$writer->startElement('ext:ExtensionContent');
					$writer->startElement('sac:AdditionalInformation');  

					foreach($totals as $total){
						$writer->startElement('sac:AdditionalMonetaryTotal'); 
							$writer->writeElement("cbc:ID", $total['ID']); 
								$writer->startElement('cbc:PayableAmount');
						        	$writer->startAttribute('currencyID');
						            	$writer->text($total['currencyID']);
						       		$writer->endAttribute();
						            	$writer->text($total['PayableAmount']);
						   		$writer->endElement();						   						
						$writer->endElement(); 

					}	
					$writer->startElement('sac:AdditionalProperty');
						$writer->writeElement("cbc:ID", "1000");
						$writer->writeElement("cbc:Value", "SON SIETE CIENTOS CON  DIEZ Y SIETE  00/100"); 
					$writer->endElement(); 
					$writer->endElement();
				$writer->endElement();	
			$writer->endElement();

			$writer->startElement('ext:UBLExtension');  
			$writer->startElement('ext:ExtensionContent');
			$writer->endElement();
			$writer->endElement();			

		$writer->endElement();
		//FIN UBLExtensions

		//Datos especificos de factura
		$writer->writeElement("cbc:UBLVersionID", $this->documentoelectronico->UblVersionId); 
		$writer->writeElement("cbc:CustomizationID", $this->documentoelectronico->CustomizationId);
		$writer->writeElement("cbc:ID", $this->documentoelectronico->getId()); 
		$writer->writeElement("cbc:IssueDate", $this->documentoelectronico->getIssueDate()); 
		$writer->writeElement("cbc:InvoiceTypeCode", $this->documentoelectronico->InvoiceTypeCode);
		$writer->writeElement("cbc:DocumentCurrencyCode", $this->documentoelectronico->DocumentCurrencyCode);
		//Fin datos especificos
		//Signature
		$writer->startElement("cac:Signature");
			$writer->writeElement("cbc:ID", $this->documentoelectronico->getId());
			$writer->startElement("cac:SignatoryParty");
				$writer->startElement("cac:PartyIdentification");
					$writer->writeElement("cbc:ID", "20102501293");//RUC Emisor					
				$writer->endElement();
				$writer->startElement("cac:PartyName");
					$writer->startElement("cbc:Name"); $writer->writeCData("Empresa de Servicios Turísticos S.R.L."); $writer->endElement();
						//$writer->writeCData("Empresa de Servicios Turísticos S.R.L.");// Nombre Empresa
					
				$writer->endElement();
			$writer->endElement();
			$writer->startElement("cac:DigitalSignatureAttachment");
				$writer->startElement("cac:ExternalReference");
					$writer->writeElement("cbc:URI", "20102501293-FF11-00000001");//RUC Emisor  + NUM. factura						
				$writer->endElement();
			$writer->endElement();
		$writer->endElement();
		//Fin Signature

		//AccountingSupplierParty
		$writer->startElement("cac:AccountingSupplierParty");
			$writer->writeElement("cbc:CustomerAssignedAccountID", "20102501293"); //RUC de la empresa
			$writer->writeElement("cbc:AdditionalAccountID", "6"); //Tipo de Documento 6 es RUC
			$writer->startElement("cac:Party");
				$writer->startElement("cac:PartyName");
					$writer->startElement("cbc:Name"); 
						$writer->writeCData("Empresa de Servicios Turísticos S.R.L.");// Nombre Comercial Empresa
					$writer->endElement();
				$writer->endElement();
				$writer->startElement("cac:PostalAddress");
					$writer->writeElement("cbc:ID", "200101");//Num. Postal
					$writer->startElement("cbc:StreetName"); 
						$writer->writeCData("Calle Arequipa Nª978 Piura - Piura - Piura");// Direccion Empresa
					$writer->endElement();
					$writer->writeElement("cbc:CityName", "PIURA"); //CIUDAD
					$writer->writeElement("cbc:CountrySubentity", "PIURA"); //CIUDAD
					$writer->writeElement("cbc:District", "PIURA");//Distrito
					$writer->startElement("cac:Country");
						$writer->writeElement("cbc:IdentificationCode", "PE"); //Cod. Pais
					$writer->endElement();
				$writer->endElement();
				$writer->startElement("cac:PartyLegalEntity");
					$writer->startElement("cbc:RegistrationName"); 
						$writer->writeCData("Empresa de Servicios Turísticos S.R.L.");// Nombre  Empresa
					$writer->endElement(); 		
				$writer->endElement();
			$writer->endElement(); 
		$writer->endElement(); 
		//Fin AccountingSupplierParty

		//AccountingCustomerParty
		$writer->startElement("cac:AccountingCustomerParty");
			$writer->writeElement("cbc:CustomerAssignedAccountID", "20102501293");//RUC Cliente
			$writer->writeElement("cbc:AdditionalAccountID", "6"); //Tipo de Documento 6 es RUC
			$writer->startElement("cac:Party");
				$writer->startElement("cac:PartyLegalEntity");
					$writer->startElement("cbc:RegistrationName"); 
						$writer->writeCData("Empresa de Servicios Turísticos S.R.L.");// Nombre  Empresa
					$writer->endElement(); 		
				$writer->endElement();
			$writer->endElement();	
		$writer->endElement(); 
		//Fin AccountingCustomerParty

		//TaxTotal
		$writer->startElement("cac:TaxTotal");
			$writer->startElement("cbc:TaxAmount");
	        	$writer->startAttribute("currencyID");
	            	$writer->text("PEN"); //Tipo moneda peruana
	       		$writer->endAttribute();
	            	$writer->text("22.88"); //ver IGV
	   		$writer->endElement();
	   		$writer->startElement("cac:TaxSubtotal");
	   			$writer->startElement("cbc:TaxAmount");
		        	$writer->startAttribute("currencyID");
		            	$writer->text("PEN"); //Tipo moneda peruana
		       		$writer->endAttribute();
		            	$writer->text("22.88"); //ver IGV
		   		$writer->endElement();
		   		$writer->startElement("cac:TaxCategory");
		   				$writer->startElement("cac:TaxScheme");
		   					$writer->writeElement("cbc:ID", "1000"); //Buscar para que sirve
		   					$writer->writeElement("cbc:Name", "IGV"); //IVG
		   					$writer->writeElement("cbc:TaxTypeCode", "VAT"); //VAT
		   				$writer->endElement();	
		   		$writer->endElement();	
	   		$writer->endElement();
		$writer->endElement();
		//Fin Taxtotal

		//LegalMonetaryTotal
		$writer->startElement("cac:LegalMonetaryTotal");
			$writer->startElement("cbc:PayableAmount");
	        	$writer->startAttribute("currencyID");
	            	$writer->text("PEN"); //Tipo moneda peruana
	       		$writer->endAttribute();
	            	$writer->text("150.00"); //Total Pago FActura
	   		$writer->endElement();
		$writer->endElement();
		//Fin LegalMonetaryTotal
		
		//InvoiceLine
		$writer->startElement("cac:InvoiceLine");
			$writer->writeElement("cbc:ID", "1"); //Correlativo de Item	
			$writer->startElement("cbc:InvoicedQuantity");
	        	$writer->startAttribute("unitCode");
	            	$writer->text("NIU"); //Tipo unidad de medida
	       		$writer->endAttribute();
	            	$writer->text("1"); //Cantidad
	   		$writer->endElement();
	   		$writer->startElement("cbc:LineExtensionAmount");
	        	$writer->startAttribute("currencyID");
	            	$writer->text("PEN"); //Moneda
	       		$writer->endAttribute();
	            	$writer->text("127.12"); //Precio unitario
	   		$writer->endElement();
	   		$writer->startElement("cac:PricingReference");
	   			$writer->startElement("cac:AlternativeConditionPrice");
	   				$writer->startElement("cbc:PriceAmount");
			        	$writer->startAttribute("currencyID");
			            	$writer->text("PEN"); //Moneda
			       		$writer->endAttribute();
			            	$writer->text("0.00"); //Precio referencial
			   		$writer->endElement();
			   		$writer->writeElement("cbc:PriceTypeCode", "01"); //Tipo de precio
	   			$writer->endElement();	   			
			$writer->endElement();	   		
			$writer->startElement("cac:TaxTotal");
				$writer->startElement("cbc:TaxAmount");
		        	$writer->startAttribute("currencyID");
		            	$writer->text("PEN"); //Moneda
		       		$writer->endAttribute();
		            	$writer->text("22.88"); //IGV
		   		$writer->endElement();
		   		$writer->startElement("cac:TaxSubtotal");
		   			$writer->startElement("cbc:TaxAmount");
			        	$writer->startAttribute("currencyID");
			            	$writer->text("PEN"); //Moneda
			       		$writer->endAttribute();
			            	$writer->text("22.88"); //IGV
			   		$writer->endElement();
			   		$writer->startElement("cac:TaxCategory");
			   			$writer->writeElement("cbc:TaxExemptionReasonCode", "10");
			   			$writer->startElement("cac:TaxScheme");
			   				$writer->writeElement("cbc:ID", "1000");
			   				$writer->writeElement("cbc:Name", "IGV");
			   				$writer->writeElement("cbc:TaxTypeCode", "VAT");
			   			$writer->endElement();
			   		$writer->endElement();		
		   		$writer->endElement();	
			$writer->endElement();
			$writer->startElement("cac:Item");
				$writer->startElement("cbc:Description"); 
					$writer->writeCData("PRODUCTO PRUEBA");// DESCRIPCION DE PRODUCTO
				$writer->endElement();
				$writer->startElement("cac:SellersItemIdentification");
					$writer->writeElement("cbc:ID", "1"); //codigo de producto
				$writer->endElement();	
			$writer->endElement();
			$writer->startElement("cac:Price");
				$writer->startElement("cbc:PriceAmount");
		        	$writer->startAttribute("currencyID");
		            	$writer->text("PEN"); //Moneda
		       		$writer->endAttribute();
		            	$writer->text("127.12"); //IGV
		   		$writer->endElement();
			$writer->endElement();
		$writer->endElement();

		//Fin InvoiceLine

	$writer->endElement();//Fin Invoice 
	$writer->endDocument();
	//$writer->flush(true); //quitar slash
	file_put_contents('FF11-00000001.xml', $writer->outputMemory());
	}
}	
?>