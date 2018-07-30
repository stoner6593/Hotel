<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Invoice extends Documentoelectronico  {

		public function __construct()
		{
			//parent::__construct();
			
			 
		} 
		
		public function _xml(){

		
			
		$totals = array(
			array(
				"ID"=>"1001",
				"PayableAmount"=>$this->getGravadas(),
				"currencyID"=>$this->DocumentCurrencyCode,
			),			
			array(
				"ID"=>"1002",
				"PayableAmount"=>$this->getInafectas(),
				"currencyID"=>$this->DocumentCurrencyCode,
			),
			array(
				"ID"=>"1003",
				"PayableAmount"=>$this->getExoneradas(),
				"currencyID"=>$this->DocumentCurrencyCode,
			),
			array(
				"ID"=>"1004",
				"PayableAmount"=>$this->getGratuitas(),
				"currencyID"=>$this->DocumentCurrencyCode,
			)
		);

		//Monto Percepción
		if($this->getMontoPercepcion()>0):
			$percep=array(
				"ID"=>"2001",
				"PayableAmount"=>number_format($this->getMontoPercepcion(), 2, '.', ''),
				"currencyID"=>$this->DocumentCurrencyCode,
			);
			array_push($totals, $percep);
		endif;	
		
		$arr=$this->getEncabezado();
		$writer = new XMLWriter(); 
		//$writer->openURI('php://output');// quitar slash
		$writer->openMemory();
		$writer->startDocument('1.0','ISO-8859-1'); 
		
		
		$writer->startElement('Invoice');  
			$writer->writeAttribute('xmlns',$this->xmlnsInvoice);          
			$writer->writeAttributeNS('xmlns','cac', null,$this->cac);
			$writer->writeAttributeNS('xmlns','cbc', null, $this->cbc);
			$writer->writeAttributeNS('xmlns','cctss', null, $this->ccts);
			$writer->writeAttributeNS('xmlns','ds', null, $this->ds);
			$writer->writeAttributeNS('xmlns','ext', null,$this->ext);
			$writer->writeAttributeNS('xmlns','qdt', null, $this->qdt);
			$writer->writeAttributeNS('xmlns','sac', null, $this->sac);
			$writer->writeAttributeNS('xmlns','udt', null, $this->udt);
			$writer->writeAttributeNS('xmlns','xsi', null, $this->xsi);
			
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
							//Monto Detracción
							if($this->getMontoDetraccion()>0):
								$writer->startElement('sac:AdditionalMonetaryTotal'); 
										$writer->writeElement("cbc:ID", "2003"); 
											$writer->startElement('cbc:PayableAmount');
									        	$writer->startAttribute('currencyID');
									            	$writer->text($this->DocumentCurrencyCode);
									       		$writer->endAttribute();
									            	$writer->text($this->getMontoDetraccion());
									   		$writer->endElement();
									   		$writer->writeElement("cbc:Percent", ($this->getCalculoDetraccion() * 100)); 						   						
								$writer->endElement(); 

							endif;	

							//Descuento Global
							if($this->getDescuentoGlobal()>0):
								$writer->startElement('sac:AdditionalMonetaryTotal'); 
										$writer->writeElement("cbc:ID", "2005"); 
											$writer->startElement('cbc:PayableAmount');
									        	$writer->startAttribute('currencyID');
									            	$writer->text($this->DocumentCurrencyCode);
									       		$writer->endAttribute();
									            	$writer->text($this->getDescuentoGlobal());
									   		$writer->endElement();						   						
								$writer->endElement(); 

							endif;

							

							$writer->startElement('sac:AdditionalProperty');
								$writer->writeElement("cbc:ID", "1000");
								$writer->writeElement("cbc:Value", "SON: ".$this->getMontoEnLetras()); 
							$writer->endElement(); 

							 /* Tipo de Operación - Catalogo N° 17 */
							//Validar luego para la venta de Factura-Guia
							if(!(empty($this->getTipoOperacion()))):
								$this->setSunatTransaction($this->getTipoOperacion());
								if($this->getTipoOperacion()=="05"):
									$writer->startElement('sac:AdditionalProperty');
										$writer->writeElement("cbc:ID", "3000");
										$writer->writeElement("cbc:Value", "Venta realizada por emisor itinerante"); 
									$writer->endElement(); 

								endif;	

							endif;	

							//Ventas Gratuitas
							if($this->getGratuitas()>0):
								$writer->startElement('sac:AdditionalProperty');
										$writer->writeElement("cbc:ID", "1002");
										$writer->writeElement("cbc:Value", "Articulos gratuitos"); 
									$writer->endElement(); 
							endif;
							
							
								
							//SUNATTransaction
							if(!empty($this->getTipoOperacion())):	
								$writer->startElement('sac:SUNATTransaction');
									$writer->writeElement("cbc:ID", $this->getTipoOperacion());							
								$writer->endElement();
							endif;	 

							

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
			$writer->writeElement("cbc:UBLVersionID", $this->UblVersionId); 
			$writer->writeElement("cbc:CustomizationID", $this->CustomizationId);
			$writer->writeElement("cbc:ID", $this->getId()); 
			$writer->writeElement("cbc:IssueDate", $this->getIssueDate()); 
			$writer->writeElement("cbc:InvoiceTypeCode", $this->InvoiceTypeCode);
			$writer->writeElement("cbc:DocumentCurrencyCode", $this->DocumentCurrencyCode);
			//Fin datos especificos
			//Signature
			$writer->startElement("cac:Signature");
				$writer->writeElement("cbc:ID", $this->getId());
				$writer->startElement("cac:SignatoryParty");
					$writer->startElement("cac:PartyIdentification");
						$writer->writeElement("cbc:ID",$arr['Encabezado']['Emisor']['RUCEmisor']);//RUC Emisor					
					$writer->endElement();
					$writer->startElement("cac:PartyName");
						$writer->startElement("cbc:Name"); 
						$writer->writeCData($arr['Encabezado']['Emisor']['RznSoc']); $writer->endElement();
						//$writer->writeCData("Empresa de Servicios Turísticos S.R.L.");// Nombre Empresa
						
					$writer->endElement();
				$writer->endElement();
				$writer->startElement("cac:DigitalSignatureAttachment");
					$writer->startElement("cac:ExternalReference");
						$writer->writeElement("cbc:URI", $arr['Encabezado']['Emisor']['RUCEmisor']."-".$this->getId());//RUC Emisor  + NUM. factura						
					$writer->endElement();
				$writer->endElement();
			$writer->endElement();
			//Fin Signature

			//AccountingSupplierParty
			$writer->startElement("cac:AccountingSupplierParty");
				$writer->writeElement("cbc:CustomerAssignedAccountID", $arr['Encabezado']['Emisor']['RUCEmisor']); //RUC de la empresa
				$writer->writeElement("cbc:AdditionalAccountID", "6"); //Tipo de Documento 6 es RUC
				$writer->startElement("cac:Party");
					$writer->startElement("cac:PartyName");
						$writer->startElement("cbc:Name"); 
							$writer->writeCData($arr['Encabezado']['Emisor']['RznSoc']);// Nombre Comercial Empresa
						$writer->endElement();
					$writer->endElement();
					$writer->startElement("cac:PostalAddress");
						$writer->writeElement("cbc:ID", $arr['Encabezado']['Emisor']['Ubigeo']);//Num. Postal
						$writer->startElement("cbc:StreetName"); 
							$writer->writeCData($arr['Encabezado']['Emisor']['Direccion']);// Direccion Empresa
						$writer->endElement();
						$writer->writeElement("cbc:CityName", $arr['Encabezado']['Emisor']['Departamento']); //CIUDAD
						$writer->writeElement("cbc:CountrySubentity", $arr['Encabezado']['Emisor']['Provincia']); //CIUDAD
						$writer->writeElement("cbc:District", $arr['Encabezado']['Emisor']['Distrito']);//Distrito
						$writer->startElement("cac:Country");
							$writer->writeElement("cbc:IdentificationCode", $this->IdentificationCode); //Cod. Pais
						$writer->endElement();
					$writer->endElement();
					$writer->startElement("cac:PartyLegalEntity");
						$writer->startElement("cbc:RegistrationName"); 
							$writer->writeCData($arr['Encabezado']['Emisor']['RznSoc']);// Nombre  Empresa
						$writer->endElement(); 		
					$writer->endElement();
				$writer->endElement(); 
			$writer->endElement(); 
			//Fin AccountingSupplierParty

			//AccountingCustomerParty
			$writer->startElement("cac:AccountingCustomerParty");
				$writer->writeElement("cbc:CustomerAssignedAccountID", $arr['Encabezado']['Receptor']['RUCReceptor'] );//RUC Cliente
				$writer->writeElement("cbc:AdditionalAccountID",  $arr['Encabezado']['Receptor']['TipoDocumento']); //Tipo de Documento 6 es RUC
				$writer->startElement("cac:Party");
					$writer->startElement("cac:PartyLegalEntity");
						$writer->startElement("cbc:RegistrationName"); 
							$writer->writeCData($arr['Encabezado']['Receptor']['RznSoc']);// Nombre  Empresa
						$writer->endElement(); 		
					$writer->endElement();
				$writer->endElement();	
			$writer->endElement(); 
			//Fin AccountingCustomerParty

			//TaxTotal
			$writer->startElement("cac:TaxTotal");
				$writer->startElement("cbc:TaxAmount");
		        	$writer->startAttribute("currencyID");
		            	$writer->text($this->DocumentCurrencyCode); //Tipo moneda 
		       		$writer->endAttribute();
		            	$writer->text($this->getTotalIgv()); //TOTAL IGV
		   		$writer->endElement();
		   		$writer->startElement("cac:TaxSubtotal");
		   			$writer->startElement("cbc:TaxAmount");
			        	$writer->startAttribute("currencyID");
			            	$writer->text($this->DocumentCurrencyCode); //Tipo moneda
			       		$writer->endAttribute();
			            	$writer->text($this->getTotalIgv()); //TOTAL IGV
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
			
			//ISC
			if($this->getTotalIsc()>0):
			$writer->startElement("cac:TaxTotal");
				$writer->startElement("cbc:TaxAmount");
		        	$writer->startAttribute("currencyID");
		            	$writer->text($this->DocumentCurrencyCode); //Tipo moneda 
		       		$writer->endAttribute();
		            	$writer->text($this->getTotalIsc()); //TOTAL ISC
		   		$writer->endElement();
		   		$writer->startElement("cac:TaxSubtotal");
		   			$writer->startElement("cbc:TaxAmount");
			        	$writer->startAttribute("currencyID");
			            	$writer->text($this->DocumentCurrencyCode); //Tipo moneda
			       		$writer->endAttribute();
			            	$writer->text($this->getTotalIsc()); //TOTAL ISC
			   		$writer->endElement();
			   		$writer->startElement("cac:TaxCategory");
			   				$writer->startElement("cac:TaxScheme");
			   					$writer->writeElement("cbc:ID", "2000"); //Buscar para que sirve
			   					$writer->writeElement("cbc:Name", "ISC"); //ISC
			   					$writer->writeElement("cbc:TaxTypeCode", "EXC"); //EXC
			   				$writer->endElement();	
			   		$writer->endElement();	
		   		$writer->endElement();
			$writer->endElement();	
			endif;	

			//OTROS TRIBUTOS
			if($this->getTotalOtrosTributos()>0):
				$writer->startElement("cac:TaxTotal");
					$writer->startElement("cbc:TaxAmount");
			        	$writer->startAttribute("currencyID");
			            	$writer->text($this->DocumentCurrencyCode); //Tipo moneda 
			       		$writer->endAttribute();
			            	$writer->text($this->getTotalOtrosTributos()); //TOTAL TotalOtrosTributos
			   		$writer->endElement();
			   		$writer->startElement("cac:TaxSubtotal");
			   			$writer->startElement("cbc:TaxAmount");
				        	$writer->startAttribute("currencyID");
				            	$writer->text($this->DocumentCurrencyCode); //Tipo moneda
				       		$writer->endAttribute();
				            	$writer->text($this->getTotalOtrosTributos()); //TOTAL TotalOtrosTributos
				   		$writer->endElement();
				   		$writer->startElement("cac:TaxCategory");
				   				$writer->startElement("cac:TaxScheme");
				   					$writer->writeElement("cbc:ID", "9999"); //Buscar para que sirve
				   					$writer->writeElement("cbc:Name", "OTROS"); //TotalOtrosTributos
				   					$writer->writeElement("cbc:TaxTypeCode", "OTH"); //OTH
				   				$writer->endElement();	
				   		$writer->endElement();	
			   		$writer->endElement();
				$writer->endElement();	
			endif;
			//Fin Taxtotal

			//LegalMonetaryTotal
			$writer->startElement("cac:LegalMonetaryTotal");
				if($this->getDescuentoGlobal()>0):
					$writer->startElement("cbc:AllowanceTotalAmount");
			        	$writer->startAttribute("currencyID");
			            	$writer->text($this->DocumentCurrencyCode); //Tipo moneda peruana
			       		$writer->endAttribute();
			            	$writer->text($this->getDescuentoGlobal()); //Total Pago FActura
			   		$writer->endElement();
		   		endif;
				$writer->startElement("cbc:PayableAmount");
		        	$writer->startAttribute("currencyID");
		            	$writer->text($this->DocumentCurrencyCode); //Tipo moneda peruana
		       		$writer->endAttribute();
		            	$writer->text($this->getTotalVenta()); //Total Pago FActura
		   		$writer->endElement();
			$writer->endElement();
			//Fin LegalMonetaryTotal
			
			//InvoiceLine			
			if(count($this->getInvoiceLine()) > 0):
				$i=1;
				foreach ($this->getInvoiceLine() as $value) {
					# code...				
					$writer->startElement("cac:InvoiceLine");
						$writer->writeElement("cbc:ID", $i); //Correlativo de Item	
						$writer->startElement("cbc:InvoicedQuantity");
				        	$writer->startAttribute("unitCode");
				            	$writer->text($value['pro_unimedida']); //Tipo unidad de medida
				       		$writer->endAttribute();
				            	$writer->text(number_format($value['pro_cantidad'], 2, '.', '')  ); //Cantidad
				   		$writer->endElement();
				   		$writer->startElement("cbc:LineExtensionAmount");
				        	$writer->startAttribute("currencyID");
				            	$writer->text($this->DocumentCurrencyCode); //Moneda
				       		$writer->endAttribute();
				            	$writer->text($value['pro_subtotal']); //Precio unitario sin IGV
				   		$writer->endElement();
				   		
				   		$writer->startElement("cac:PricingReference");
				   			
				   			$writer->startElement("cac:AlternativeConditionPrice");
				   				$writer->startElement("cbc:PriceAmount");
						        	$writer->startAttribute("currencyID");
						            	$writer->text($this->DocumentCurrencyCode); //Moneda
						       		$writer->endAttribute();
						            	$writer->text( $this->getGratuitas() > 0 ? number_format(0, 2, '.', '') : number_format($value['pro_preref'], 2, '.', '') ); //Precio referencial
						   		$writer->endElement();
						   		$writer->writeElement("cbc:PriceTypeCode",$value['pro_tipoprecio']); //Tipo de precio
				   			$writer->endElement();

				   			if($this->getGratuitas() > 0):
				   				$writer->startElement("cac:AlternativeConditionPrice");
					   				$writer->startElement("cbc:PriceAmount");
							        	$writer->startAttribute("currencyID");
							            	$writer->text($this->DocumentCurrencyCode); //Moneda
							       		$writer->endAttribute();
							            	$writer->text( number_format($value['pro_preref'], 2, '.', '') ); //Precio referencial
							   		$writer->endElement();
							   		$writer->writeElement("cbc:PriceTypeCode","02"); //Tipo de precio
					   			$writer->endElement();
				   			endif;
						$writer->endElement();	   		
						 /* 16 - Afectación al IGV por ítem */
						$writer->startElement("cac:TaxTotal");
							$writer->startElement("cbc:TaxAmount");
					        	$writer->startAttribute("currencyID");
					            	$writer->text($this->DocumentCurrencyCode); //Moneda
					       		$writer->endAttribute();
					            	$writer->text($value['pro_igv']); //IGV
					   		$writer->endElement();
					   		$writer->startElement("cac:TaxSubtotal");
					   			$writer->startElement("cbc:TaxAmount");
						        	$writer->startAttribute("currencyID");
						            	$writer->text($this->DocumentCurrencyCode); //Moneda
						       		$writer->endAttribute();
						            	$writer->text($value['pro_igv']); //IGV  ---- VERIFICAR LUEGO
						   		$writer->endElement();
						   		$writer->startElement("cac:TaxCategory");
						   			$writer->writeElement("cbc:TaxExemptionReasonCode", $value['pro_tipoimpuesto']);
						   			$writer->startElement("cac:TaxScheme");
						   				$writer->writeElement("cbc:ID", "1000");
						   				$writer->writeElement("cbc:Name", "IGV");
						   				$writer->writeElement("cbc:TaxTypeCode", "VAT");
						   			$writer->endElement();
						   		$writer->endElement();		
					   		$writer->endElement();	
						$writer->endElement();

						 /* 17 - Sistema de ISC por ítem */
						if($value['pro_isc']>0):
						$writer->startElement("cac:TaxTotal");
							$writer->startElement("cbc:TaxAmount");
					        	$writer->startAttribute("currencyID");
					            	$writer->text($this->DocumentCurrencyCode); //Moneda
					       		$writer->endAttribute();
					            	$writer->text($value['pro_isc']); //ISC
					   		$writer->endElement();
					   		$writer->startElement("cac:TaxSubtotal");
					   			$writer->startElement("cbc:TaxAmount");
						        	$writer->startAttribute("currencyID");
						            	$writer->text($this->DocumentCurrencyCode); //Moneda
						       		$writer->endAttribute();
						            	$writer->text($value['pro_isc']); //ISC  ---- VERIFICAR LUEGO
						   		$writer->endElement();
						   		$writer->startElement("cac:TaxCategory");
						   			$writer->writeElement("cbc:TaxExemptionReasonCode", $value['pro_tipoimpuesto']);
						   			$writer->writeElement("cbc:TierRange", "01");
						   			$writer->startElement("cac:TaxScheme");
						   				$writer->writeElement("cbc:ID", "2000");
						   				$writer->writeElement("cbc:Name", "ISC");
						   				$writer->writeElement("cbc:TaxTypeCode", "EXC");
						   			$writer->endElement();
						   		$writer->endElement();		
					   		$writer->endElement();	
						$writer->endElement();
						endif;	

						$writer->startElement("cac:Item");
							$writer->startElement("cbc:Description"); 
								$writer->writeCData($value['pro_desc']);// DESCRIPCION DE PRODUCTO
							$writer->endElement();
							$writer->startElement("cac:SellersItemIdentification");
								$writer->writeElement("cbc:ID", $value['pro_id']); //codigo de producto
							$writer->endElement();	
						$writer->endElement();
						$writer->startElement("cac:Price");
							$writer->startElement("cbc:PriceAmount");
					        	$writer->startAttribute("currencyID");
					            	$writer->text($this->DocumentCurrencyCode); //Moneda
					       		$writer->endAttribute();
					            	$writer->text($value['pro_subtotal']); //Valor venta
					   		$writer->endElement();
						$writer->endElement();
					$writer->endElement();
				$i++;
				}

			endif;
			//Fin InvoiceLine

		$writer->endElement();//Fin Invoice 
		$writer->endDocument();
		//$writer->flush(true); //quitar slash
		file_put_contents('XML/'.$this->getId().'.xml', $writer->outputMemory());
		}



		//FUNCION PARA CREAR NOTAS DE CREDITO

		public function _xmlCreditNote(){

		
				
			$totals = array(
				array(
					"ID"=>"1001",
					"PayableAmount"=>$this->getGravadas(),
					"currencyID"=>$this->DocumentCurrencyCode,
				)
			);

			//Monto Percepción
			if($this->getMontoPercepcion()>0):
				$percep=array(
					"ID"=>"2001",
					"PayableAmount"=>number_format($this->getMontoPercepcion(), 2, '.', ''),
					"currencyID"=>$this->DocumentCurrencyCode,
				);
				array_push($totals, $percep);
			endif;	
			
			$arr=$this->getEncabezado();
			$writer = new XMLWriter(); 
			//$writer->openURI('php://output');// quitar slash
			$writer->openMemory();
			$writer->startDocument('1.0','ISO-8859-1'); 
			
			
			$writer->startElement('CreditNote');  
				$writer->writeAttribute('xmlns',$this->xmlnsCreditNote);          
				$writer->writeAttributeNS('xmlns','cac', null,$this->cac);
				$writer->writeAttributeNS('xmlns','cbc', null, $this->cbc);
				$writer->writeAttributeNS('xmlns','cctss', null, $this->ccts);
				$writer->writeAttributeNS('xmlns','ds', null, $this->ds);
				$writer->writeAttributeNS('xmlns','ext', null,$this->ext);
				$writer->writeAttributeNS('xmlns','qdt', null, $this->qdt);
				$writer->writeAttributeNS('xmlns','sac', null, $this->sac);
				$writer->writeAttributeNS('xmlns','udt', null, $this->udt);
				$writer->writeAttributeNS('xmlns','xsi', null, $this->xsi);
				
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
									$writer->writeElement("cbc:Value", "SON: ".$this->getMontoEnLetras()); 
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
				$writer->writeElement("cbc:UBLVersionID", $this->UblVersionId); 
				$writer->writeElement("cbc:CustomizationID", $this->CustomizationId);
				$writer->writeElement("cbc:ID", $this->getId()); 
				$writer->writeElement("cbc:IssueDate", $this->getIssueDate()); 				
				$writer->writeElement("cbc:DocumentCurrencyCode", $this->DocumentCurrencyCode);
				//Fin datos especificos

				//DiscrepancyResponse
				if(count($this->getDiscrepancia()) > 0):
				
					foreach ($this->getDiscrepancia() as $value) {
						$writer->startElement("cac:DiscrepancyResponse");
							$writer->writeElement("cbc:ReferenceID", $value['NumReferenciaDis']);
							$writer->writeElement("cbc:ResponseCode", $value['TipDiscrepancia']);
							$writer->writeElement("cbc:Description", $value['DesReferenciaDis']);	
						$writer->endElement();
					}

				endif;		
				//BillingReference
				if(count($this->getDocRelacionado()) > 0):
				
					foreach ($this->getDocRelacionado() as $value) {
						$writer->startElement("cac:BillingReference");
							$writer->startElement("cac:InvoiceDocumentReference");
								$writer->writeElement("cbc:ID",$value['docuRelacionado']);
								$writer->writeElement("cbc:DocumentTypeCode",  $value['CodDocRelacionado']);
							$writer->endElement();							
						$writer->endElement();
					}

				endif;	


				//Signature
				$writer->startElement("cac:Signature");
					$writer->writeElement("cbc:ID", $this->getId());
					$writer->startElement("cac:SignatoryParty");
						$writer->startElement("cac:PartyIdentification");
							$writer->writeElement("cbc:ID",$arr['Encabezado']['Emisor']['RUCEmisor']);//RUC Emisor					
						$writer->endElement();
						$writer->startElement("cac:PartyName");
							$writer->startElement("cbc:Name"); 
							$writer->writeCData($arr['Encabezado']['Emisor']['RznSoc']); $writer->endElement();
							//$writer->writeCData("Empresa de Servicios Turísticos S.R.L.");// Nombre Empresa
							
						$writer->endElement();
					$writer->endElement();
					$writer->startElement("cac:DigitalSignatureAttachment");
						$writer->startElement("cac:ExternalReference");
							$writer->writeElement("cbc:URI", $arr['Encabezado']['Emisor']['RUCEmisor']."-".$this->getId());//RUC Emisor  + NUM. factura						
						$writer->endElement();
					$writer->endElement();
				$writer->endElement();
				//Fin Signature

				//AccountingSupplierParty
				$writer->startElement("cac:AccountingSupplierParty");
					$writer->writeElement("cbc:CustomerAssignedAccountID", $arr['Encabezado']['Emisor']['RUCEmisor']); //RUC de la empresa
					$writer->writeElement("cbc:AdditionalAccountID", "6"); //Tipo de Documento 6 es RUC
					$writer->startElement("cac:Party");
						$writer->startElement("cac:PartyName");
							$writer->startElement("cbc:Name"); 
								$writer->writeCData($arr['Encabezado']['Emisor']['RznSoc']);// Nombre Comercial Empresa
							$writer->endElement();
						$writer->endElement();
						$writer->startElement("cac:PostalAddress");
							$writer->writeElement("cbc:ID", $arr['Encabezado']['Emisor']['Ubigeo']);//Num. Postal
							$writer->startElement("cbc:StreetName"); 
								$writer->writeCData($arr['Encabezado']['Emisor']['Direccion']);// Direccion Empresa
							$writer->endElement();
							$writer->writeElement("cbc:CityName", $arr['Encabezado']['Emisor']['Departamento']); //CIUDAD
							$writer->writeElement("cbc:CountrySubentity", $arr['Encabezado']['Emisor']['Provincia']); //CIUDAD
							$writer->writeElement("cbc:District", $arr['Encabezado']['Emisor']['Distrito']);//Distrito
							$writer->startElement("cac:Country");
								$writer->writeElement("cbc:IdentificationCode", $this->IdentificationCode); //Cod. Pais
							$writer->endElement();
						$writer->endElement();
						$writer->startElement("cac:PartyLegalEntity");
							$writer->startElement("cbc:RegistrationName"); 
								$writer->writeCData($arr['Encabezado']['Emisor']['RznSoc']);// Nombre  Empresa
							$writer->endElement(); 		
						$writer->endElement();
					$writer->endElement(); 
				$writer->endElement(); 
				//Fin AccountingSupplierParty

				//AccountingCustomerParty
				$writer->startElement("cac:AccountingCustomerParty");
					$writer->writeElement("cbc:CustomerAssignedAccountID", $arr['Encabezado']['Receptor']['RUCReceptor'] );//RUC Cliente
					$writer->writeElement("cbc:AdditionalAccountID",  $arr['Encabezado']['Receptor']['TipoDocumento']); //Tipo de Documento 6 es RUC
					$writer->startElement("cac:Party");
						$writer->startElement("cac:PartyLegalEntity");
							$writer->startElement("cbc:RegistrationName"); 
								$writer->writeCData($arr['Encabezado']['Receptor']['RznSoc']);// Nombre  Empresa
							$writer->endElement(); 		
						$writer->endElement();
					$writer->endElement();	
				$writer->endElement(); 
				//Fin AccountingCustomerParty

				//TaxTotal
				$writer->startElement("cac:TaxTotal");
					$writer->startElement("cbc:TaxAmount");
			        	$writer->startAttribute("currencyID");
			            	$writer->text($this->DocumentCurrencyCode); //Tipo moneda 
			       		$writer->endAttribute();
			            	$writer->text($this->getTotalIgv()); //TOTAL IGV
			   		$writer->endElement();
			   		$writer->startElement("cac:TaxSubtotal");
			   			$writer->startElement("cbc:TaxAmount");
				        	$writer->startAttribute("currencyID");
				            	$writer->text($this->DocumentCurrencyCode); //Tipo moneda
				       		$writer->endAttribute();
				            	$writer->text($this->getTotalIgv()); //TOTAL IGV
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
					if($this->getDescuentoGlobal()>0):
						$writer->startElement("cbc:AllowanceTotalAmount");
				        	$writer->startAttribute("currencyID");
				            	$writer->text($this->DocumentCurrencyCode); //Tipo moneda peruana
				       		$writer->endAttribute();
				            	$writer->text($this->getDescuentoGlobal()); //Total Pago FActura
				   		$writer->endElement();
			   		endif;
					$writer->startElement("cbc:PayableAmount");
			        	$writer->startAttribute("currencyID");
			            	$writer->text($this->DocumentCurrencyCode); //Tipo moneda peruana
			       		$writer->endAttribute();
			            	$writer->text($this->getTotalVenta()); //Total Pago FActura
			   		$writer->endElement();
				$writer->endElement();
				//Fin LegalMonetaryTotal
				
				//InvoiceLine			
				if(count($this->getInvoiceLine()) > 0):
					$i=1;
					foreach ($this->getInvoiceLine() as $value) {
						# code...				
						$writer->startElement("cac:CreditNoteLine");
							$writer->writeElement("cbc:ID", $i); //Correlativo de Item	
							$writer->startElement("cbc:CreditedQuantity");
					        	$writer->startAttribute("unitCode");
					            	$writer->text($value['pro_unimedida']); //Tipo unidad de medida
					       		$writer->endAttribute();
					            	$writer->text($value['pro_cantidad']); //Cantidad
					   		$writer->endElement();
					   		$writer->startElement("cbc:LineExtensionAmount");
					        	$writer->startAttribute("currencyID");
					            	$writer->text($this->DocumentCurrencyCode); //Moneda
					       		$writer->endAttribute();
					            	$writer->text($value['pro_subtotal']); //Precio unitario sin IGV
					   		$writer->endElement();
					   		
					   		$writer->startElement("cac:PricingReference");   

					   			if($this->getGratuitas() > 0):
					   				$writer->startElement("cac:AlternativeConditionPrice");
						   				$writer->startElement("cbc:PriceAmount");
								        	$writer->startAttribute("currencyID");
								            	$writer->text($this->DocumentCurrencyCode); //Moneda
								       		$writer->endAttribute();
								            	$writer->text( number_format($value['pro_preref'], 2, '.', '') ); //Precio referencial
								   		$writer->endElement();
								   		$writer->writeElement("cbc:PriceTypeCode","02"); //Tipo de precio
						   			$writer->endElement();
					   			endif;
							$writer->endElement();	   		
							 /* 16 - Afectación al IGV por ítem */
							$writer->startElement("cac:TaxTotal");
								$writer->startElement("cbc:TaxAmount");
						        	$writer->startAttribute("currencyID");
						            	$writer->text($this->DocumentCurrencyCode); //Moneda
						       		$writer->endAttribute();
						            	$writer->text($value['pro_igv']); //IGV
						   		$writer->endElement();
						   		$writer->startElement("cac:TaxSubtotal");
						   			$writer->startElement("cbc:TaxAmount");
							        	$writer->startAttribute("currencyID");
							            	$writer->text($this->DocumentCurrencyCode); //Moneda
							       		$writer->endAttribute();
							            	$writer->text($value['pro_igv']); //IGV  ---- VERIFICAR LUEGO
							   		$writer->endElement();
							   		$writer->startElement("cac:TaxCategory");
							   			$writer->writeElement("cbc:TaxExemptionReasonCode", $value['pro_tipoimpuesto']);
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
									$writer->writeCData($value['pro_desc']);// DESCRIPCION DE PRODUCTO
								$writer->endElement();
								$writer->startElement("cac:SellersItemIdentification");
									$writer->writeElement("cbc:ID", $value['pro_id']); //codigo de producto
								$writer->endElement();	
							$writer->endElement();
							$writer->startElement("cac:Price");
								$writer->startElement("cbc:PriceAmount");
						        	$writer->startAttribute("currencyID");
						            	$writer->text($this->DocumentCurrencyCode); //Moneda
						       		$writer->endAttribute();
						            	$writer->text($value['pro_subtotal']); //Valor venta
						   		$writer->endElement();
							$writer->endElement();
						$writer->endElement();
					$i++;
					}

				endif;
				//Fin InvoiceLine

			$writer->endElement();//Fin Invoice 
			$writer->endDocument();
			//$writer->flush(true); //quitar slash
			file_put_contents('XML/'.$this->getId().'.xml', $writer->outputMemory());
		}




		//FUNCION PARA CREAR NOTAS DE DEBITO

		public function _xmlDebitNote(){

		
				
			$totals = array(
				array(
					"ID"=>"1001",
					"PayableAmount"=>$this->getGravadas(),
					"currencyID"=>$this->DocumentCurrencyCode,
				)
			);

			//Monto Percepción
			if($this->getMontoPercepcion()>0):
				$percep=array(
					"ID"=>"2001",
					"PayableAmount"=>number_format($this->getMontoPercepcion(), 2, '.', ''),
					"currencyID"=>$this->DocumentCurrencyCode,
				);
				array_push($totals, $percep);
			endif;	
			
			$arr=$this->getEncabezado();
			$writer = new XMLWriter(); 
			//$writer->openURI('php://output');// quitar slash
			$writer->openMemory();
			$writer->startDocument('1.0','ISO-8859-1'); 
			
			
			$writer->startElement('DebitNote');  
				$writer->writeAttribute('xmlns',$this->xmlnsDebitNote);          
				$writer->writeAttributeNS('xmlns','cac', null,$this->cac);
				$writer->writeAttributeNS('xmlns','cbc', null, $this->cbc);
				$writer->writeAttributeNS('xmlns','cctss', null, $this->ccts);
				$writer->writeAttributeNS('xmlns','ds', null, $this->ds);
				$writer->writeAttributeNS('xmlns','ext', null,$this->ext);
				$writer->writeAttributeNS('xmlns','qdt', null, $this->qdt);
				$writer->writeAttributeNS('xmlns','sac', null, $this->sac);
				$writer->writeAttributeNS('xmlns','udt', null, $this->udt);
				$writer->writeAttributeNS('xmlns','xsi', null, $this->xsi);
				
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
									$writer->writeElement("cbc:Value", "SON: ".$this->getMontoEnLetras()); 
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
				$writer->writeElement("cbc:UBLVersionID", $this->UblVersionId); 
				$writer->writeElement("cbc:CustomizationID", $this->CustomizationId);
				$writer->writeElement("cbc:ID", $this->getId()); 
				$writer->writeElement("cbc:IssueDate", $this->getIssueDate()); 				
				$writer->writeElement("cbc:DocumentCurrencyCode", $this->DocumentCurrencyCode);
				//Fin datos especificos

				//DiscrepancyResponse
				if(count($this->getDiscrepancia()) > 0):
				
					foreach ($this->getDiscrepancia() as $value) {
						$writer->startElement("cac:DiscrepancyResponse");
							$writer->writeElement("cbc:ReferenceID", $value['NumReferenciaDis']);
							$writer->writeElement("cbc:ResponseCode", $value['TipDiscrepancia']);
							$writer->writeElement("cbc:Description", $value['DesReferenciaDis']);	
						$writer->endElement();
					}

				endif;		
				//BillingReference
				if(count($this->getDocRelacionado()) > 0):
				
					foreach ($this->getDocRelacionado() as $value) {
						$writer->startElement("cac:BillingReference");
							$writer->startElement("cac:InvoiceDocumentReference");
								$writer->writeElement("cbc:ID",$value['docuRelacionado']);
								$writer->writeElement("cbc:DocumentTypeCode",  $value['CodDocRelacionado']);
							$writer->endElement();							
						$writer->endElement();
					}

				endif;	


				//Signature
				$writer->startElement("cac:Signature");
					$writer->writeElement("cbc:ID", $this->getId());
					$writer->startElement("cac:SignatoryParty");
						$writer->startElement("cac:PartyIdentification");
							$writer->writeElement("cbc:ID",$arr['Encabezado']['Emisor']['RUCEmisor']);//RUC Emisor					
						$writer->endElement();
						$writer->startElement("cac:PartyName");
							$writer->startElement("cbc:Name"); 
							$writer->writeCData($arr['Encabezado']['Emisor']['RznSoc']); $writer->endElement();
							//$writer->writeCData("Empresa de Servicios Turísticos S.R.L.");// Nombre Empresa
							
						$writer->endElement();
					$writer->endElement();
					$writer->startElement("cac:DigitalSignatureAttachment");
						$writer->startElement("cac:ExternalReference");
							$writer->writeElement("cbc:URI", $arr['Encabezado']['Emisor']['RUCEmisor']."-".$this->getId());//RUC Emisor  + NUM. factura						
						$writer->endElement();
					$writer->endElement();
				$writer->endElement();
				//Fin Signature

				//AccountingSupplierParty
				$writer->startElement("cac:AccountingSupplierParty");
					$writer->writeElement("cbc:CustomerAssignedAccountID", $arr['Encabezado']['Emisor']['RUCEmisor']); //RUC de la empresa
					$writer->writeElement("cbc:AdditionalAccountID", "6"); //Tipo de Documento 6 es RUC
					$writer->startElement("cac:Party");
						$writer->startElement("cac:PartyName");
							$writer->startElement("cbc:Name"); 
								$writer->writeCData($arr['Encabezado']['Emisor']['RznSoc']);// Nombre Comercial Empresa
							$writer->endElement();
						$writer->endElement();
						$writer->startElement("cac:PostalAddress");
							$writer->writeElement("cbc:ID", $arr['Encabezado']['Emisor']['Ubigeo']);//Num. Postal
							$writer->startElement("cbc:StreetName"); 
								$writer->writeCData($arr['Encabezado']['Emisor']['Direccion']);// Direccion Empresa
							$writer->endElement();
							$writer->writeElement("cbc:CityName", $arr['Encabezado']['Emisor']['Departamento']); //CIUDAD
							$writer->writeElement("cbc:CountrySubentity", $arr['Encabezado']['Emisor']['Provincia']); //CIUDAD
							$writer->writeElement("cbc:District", $arr['Encabezado']['Emisor']['Distrito']);//Distrito
							$writer->startElement("cac:Country");
								$writer->writeElement("cbc:IdentificationCode", $this->IdentificationCode); //Cod. Pais
							$writer->endElement();
						$writer->endElement();
						$writer->startElement("cac:PartyLegalEntity");
							$writer->startElement("cbc:RegistrationName"); 
								$writer->writeCData($arr['Encabezado']['Emisor']['RznSoc']);// Nombre  Empresa
							$writer->endElement(); 		
						$writer->endElement();
					$writer->endElement(); 
				$writer->endElement(); 
				//Fin AccountingSupplierParty

				//AccountingCustomerParty
				$writer->startElement("cac:AccountingCustomerParty");
					$writer->writeElement("cbc:CustomerAssignedAccountID", $arr['Encabezado']['Receptor']['RUCReceptor'] );//RUC Cliente
					$writer->writeElement("cbc:AdditionalAccountID",  $arr['Encabezado']['Receptor']['TipoDocumento']); //Tipo de Documento 6 es RUC
					$writer->startElement("cac:Party");
						$writer->startElement("cac:PartyLegalEntity");
							$writer->startElement("cbc:RegistrationName"); 
								$writer->writeCData($arr['Encabezado']['Receptor']['RznSoc']);// Nombre  Empresa
							$writer->endElement(); 		
						$writer->endElement();
					$writer->endElement();	
				$writer->endElement(); 
				//Fin AccountingCustomerParty

				//TaxTotal
				$writer->startElement("cac:TaxTotal");
					$writer->startElement("cbc:TaxAmount");
			        	$writer->startAttribute("currencyID");
			            	$writer->text($this->DocumentCurrencyCode); //Tipo moneda 
			       		$writer->endAttribute();
			            	$writer->text($this->getTotalIgv()); //TOTAL IGV
			   		$writer->endElement();
			   		$writer->startElement("cac:TaxSubtotal");
			   			$writer->startElement("cbc:TaxAmount");
				        	$writer->startAttribute("currencyID");
				            	$writer->text($this->DocumentCurrencyCode); //Tipo moneda
				       		$writer->endAttribute();
				            	$writer->text($this->getTotalIgv()); //TOTAL IGV
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

				//RequestedMonetaryTotal
				$writer->startElement("cac:RequestedMonetaryTotal");
					if($this->getDescuentoGlobal()>0):
						$writer->startElement("cbc:AllowanceTotalAmount");
				        	$writer->startAttribute("currencyID");
				            	$writer->text($this->DocumentCurrencyCode); //Tipo moneda peruana
				       		$writer->endAttribute();
				            	$writer->text($this->getDescuentoGlobal()); //Total Pago FActura
				   		$writer->endElement();
			   		endif;
					$writer->startElement("cbc:PayableAmount");
			        	$writer->startAttribute("currencyID");
			            	$writer->text($this->DocumentCurrencyCode); //Tipo moneda peruana
			       		$writer->endAttribute();
			            	$writer->text($this->getTotalVenta()); //Total Pago FActura
			   		$writer->endElement();
				$writer->endElement();
				//Fin RequestedMonetaryTotal
				
				//InvoiceLine			
				if(count($this->getInvoiceLine()) > 0):
					$i=1;
					foreach ($this->getInvoiceLine() as $value) {
						# code...				
						$writer->startElement("cac:DebitNoteLine");
							$writer->writeElement("cbc:ID", $i); //Correlativo de Item	
							$writer->startElement("cbc:DebitedQuantity");
					        	$writer->startAttribute("unitCode");
					            	$writer->text($value['pro_unimedida']); //Tipo unidad de medida
					       		$writer->endAttribute();
					            	$writer->text($value['pro_cantidad']); //Cantidad
					   		$writer->endElement();
					   		$writer->startElement("cbc:LineExtensionAmount");
					        	$writer->startAttribute("currencyID");
					            	$writer->text($this->DocumentCurrencyCode); //Moneda
					       		$writer->endAttribute();
					            	$writer->text($value['pro_subtotal']); //Precio unitario sin IGV
					   		$writer->endElement();
					   		
					   		$writer->startElement("cac:PricingReference");   

					   			if($this->getGratuitas() > 0):
					   				$writer->startElement("cac:AlternativeConditionPrice");
						   				$writer->startElement("cbc:PriceAmount");
								        	$writer->startAttribute("currencyID");
								            	$writer->text($this->DocumentCurrencyCode); //Moneda
								       		$writer->endAttribute();
								            	$writer->text( number_format($value['pro_preref'], 2, '.', '') ); //Precio referencial
								   		$writer->endElement();
								   		$writer->writeElement("cbc:PriceTypeCode","02"); //Tipo de precio
						   			$writer->endElement();
					   			endif;
							$writer->endElement();	   		
							 /* 16 - Afectación al IGV por ítem */
							$writer->startElement("cac:TaxTotal");
								$writer->startElement("cbc:TaxAmount");
						        	$writer->startAttribute("currencyID");
						            	$writer->text($this->DocumentCurrencyCode); //Moneda
						       		$writer->endAttribute();
						            	$writer->text($value['pro_igv']); //IGV
						   		$writer->endElement();
						   		$writer->startElement("cac:TaxSubtotal");
						   			$writer->startElement("cbc:TaxAmount");
							        	$writer->startAttribute("currencyID");
							            	$writer->text($this->DocumentCurrencyCode); //Moneda
							       		$writer->endAttribute();
							            	$writer->text($value['pro_igv']); //IGV  ---- VERIFICAR LUEGO
							   		$writer->endElement();
							   		$writer->startElement("cac:TaxCategory");
							   			$writer->writeElement("cbc:TaxExemptionReasonCode", $value['pro_tipoimpuesto']);
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
									$writer->writeCData($value['pro_desc']);// DESCRIPCION DE PRODUCTO
								$writer->endElement();
								$writer->startElement("cac:SellersItemIdentification");
									$writer->writeElement("cbc:ID", $value['pro_id']); //codigo de producto
								$writer->endElement();	
							$writer->endElement();
							$writer->startElement("cac:Price");
								$writer->startElement("cbc:PriceAmount");
						        	$writer->startAttribute("currencyID");
						            	$writer->text($this->DocumentCurrencyCode); //Moneda
						       		$writer->endAttribute();
						            	$writer->text($value['pro_subtotal']); //Valor venta
						   		$writer->endElement();
							$writer->endElement();
						$writer->endElement();
					$i++;
					}

				endif;
				//Fin InvoiceLine

			$writer->endElement();//Fin Invoice 
			$writer->endDocument();
			//$writer->flush(true); //quitar slash
			file_put_contents('XML/'.$this->getId().'.xml', $writer->outputMemory());
		}

}
?>