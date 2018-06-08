<?php

	include("Invoice.php");
	include("generales/convertir.php");
	include "../validar.php";
	include "../config.php";
	include "../include/functions.php";
	include "Firmado.php";
	include "CustomHeaders.php";
	include "Pdf.php";
	include "Barcode.php";
	

	/**
	* 
	*/
	class Generaxml extends Invoice
	{
		
		//private $sqlalquiler=null; 
		public $idalquiler;
		public $tipo_documento;
		public $nomDocumento;
		public $nombre_archivo;
		function __construct($idalquiler,$tipo_documento,$nomDocumento,$nombre_archivo)
		{
			$this->idalquiler=$idalquiler;
			$this->tipo_documento=$tipo_documento;
			$this->nomDocumento=$nomDocumento;
			$this->nombre_archivo=$nombre_archivo;
			$this->crear_directorio();
			
		}

		public function crear_directorio(){
			
			if(!is_dir('XMLFIRMADOS/')){
				@mkdir('XMLFIRMADOS/', 0700);
			}
			
			if(!is_dir('XML/')){
				@mkdir('XML/', 0700);
			}
			if(!is_dir('CDR/')){
				@mkdir('CDR/', 0700);
			}
			
			if(!is_dir('XMLENVIAR/')){
				@mkdir('XMLENVIAR/', 0700);
			}
			if(!is_dir('PDF/')){
				@mkdir('PDF/', 0700);
			}
		}

		
		
		//DATOS DE LA EMPRESA
		public function generar_xml(){ 

			$db = new conexion();
			$link = $db->conexion();

			
			

			//CORRELATIVO PARA LOS DOCUMENTOS

		

			
			$date = new DateTime($xaFila[13]);
			
		
			
			$nombreZip=substr($this->nomDocumento, 0,-4).'.zip';
			@$cargaZip='./XMLENVIAR/'.$nombreZip;
			$zipEnviar=(file_get_contents($cargaZip));

			//Nombre para el archivo PDF ***** mejorar
			//$nombre_archivo = utf8_decode($array['Encabezado']['Emisor']['RUCEmisor'].'-'.$date->format('Y-m-d').'-'.$corre);
			//$this->generapdfinvoice($array,$corre,$dato,$items,$MontoLetras,$nombre_archivo,$firmado->firma,$xaFila[3]); //Genera PDF
			$Respuesta=$this->enviar_sunat($zipEnviar,$nombreZip,$this->nombre_archivo);	

			echo $Respuesta; //Muestra Respuesta
			$res=json_decode($Respuesta,TRUE);
			

			if($res['errors']=="0"):					
				//if($res['success']['codRespuesta'][0]==0):
					//Aquí trabajar para guardar en BD
					$codigoRespuesta=$res['success']['codRespuesta'][0];
					$msgRespuesta=$res['success']['Description'][0];
					
																	
				//endif;	
			else:
					$codigoRespuesta=$res['errors']['getCode'];
					$msgRespuesta=$res['errors']['getMessage'];		
			endif;
			
		
			
			$reemplazo=str_replace("'"," ",$msgRespuesta);
			if(trim($codigoRespuesta)=='WSDL'): $codigoRespuesta=-1; endif;
			
			$link->query("UPDATE alquilerhabitacion SET codigo_respuesta='$codigoRespuesta',
				mensaje_respuesta='".$reemplazo."'	WHERE idalquiler ='$this->idalquiler'");
			
			
		}

		
		//Actualiza datos de venta
		function ActualizaVenta($codigoRespuesta,$msgRespuesta,$corre,$idalquiler){
			$db = new conexion();
			$link = $db->conexion();
			return $link->query("UPDATE alquilerhabitacion SET codigo_respuesta='$codigoRespuesta',
				mensaje_respuesta='$msgRespuesta'
			WHERE idalquiler ='$idalquiler'");



		}
		//Eniar a SUNAT
		function enviar_sunat($zipEnviar,$nombreZip,$nombre_archivo){
	   		global $wsdl, $client;
	      	$wsdl ='https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl';
	      	//https://e-factura.sunat.gob.pe/ol-ti-itcpfegem/billService?wsdl
	      	//https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl
		
			$params=array('user'=>'20545756022MODDATOS',
				'pass'=>'moddatos');

			
		
			try {


				$cabecera= new CustomHeaders($params);
			   
					
				$client = new SoapClient($wsdl, [ 'cache_wsdl' => WSDL_CACHE_NONE, 'trace' =>TRUE , 'soap_version' => SOAP_1_1 ] ); 
				$client->__setSoapHeaders([$cabecera]); 
				$client->__getFunctions();
				
				$contentFile = new SoapVar($zipEnviar, XSD_BYTE);

				$respuesta=$client->sendBill(array('fileName'=>$nombreZip,'contentFile'=>$zipEnviar));
				
				
				if($respuesta):

					$leer=$client->__getLastResponse();					
					//Guarda CDR en carpeta destino
					file_put_contents('CDR/R-'.$nombreZip, $respuesta->applicationResponse);			
					
					$res=$this->getDataCDR('CDR/R-'.$nombreZip,1);						

					$ArrayMessage=array('success'=> array('ReferenceID' => $res['ID_DOCUMENTO_ENVIADO'],'codRespuesta' =>$res['CODIGO'],
						'Description' => $res['DESCRIPCION'],'nombre_archivo'=>$nombre_archivo.'.pdf' ),'errors'=>0);
					return json_encode($ArrayMessage);
					
				else:
					$error=json_encode(array('success'=>0,'errors'=>array('getMessage' =>'ERROR SUNAT' ,'getCode'=>0)));
                	 throw new \Exception($error);
				endif;
				

			} catch (SoapFault $fault) {
				$filtrar=str_replace("soap-env:Client."," ", $fault->faultcode);
			    $ArrayMessage=array('success'=>0,'errors'=>array('getCode'=>$filtrar,'getMessage'=>$fault->faultstring));
			  
			    
			} catch (Exception $e) { 
			    
			    $ArrayMessage=array('success'=>0,'errors'=>array('getMessage' =>$e->getMessage() ,'getCode'=>$e->getCode()));
			}

			return json_encode($ArrayMessage);
			
	   	}

	   		/**
	     * Se debe enviar el el nombre del archivo RUC-TIPO-SERIE-NUMERO <br>
	     * Si devuelve el Objeto WebService esta correcto la lectura de la respuesta de SUNAT <br>
	     * Type 1: Lee las respuestas de SendBill <br>
	     * Type 2: Lee la respuesta de un getStatus
	     * @param string $archivo
	     * @param string $type
	     * @return array|string
	     */
	    public function getDataCDR($archivo, $type = '1')
	    {
	        try {

	            switch ($type) {
	                default:
	                case "1":
	                    $archivoZip = $archivo;
	                    break;
	                case "2":
	                    $archivoZip = $archivo;
	                    break;
	            }

	            // Se valida que el .zip exista
	            if (!file_exists($archivoZip)) {
	            	$error=json_encode(array('success'=>0,'errors'=>array('getMessage' =>'El Archivo de respuesta SUNAT no fue encontrado' ,'getCode'=>0)));
	                throw new \Exception($error);
	            	
	            }

	            $zip = new ZipArchive();

	            // Se lee el archivo .zip
	            $readFile = $zip->open($archivoZip);

	            // Se extrae el archivo XML
	            $zip->extractTo('CDR/');

	            // Se valida que se haya extraido correctamente.
	            if ($readFile !== TRUE) {
	                
	                $error=json_encode(array('success'=>0,'errors'=>array('getMessage' =>'Al extraer la respuesta SUNAT ocurrio un error.' ,'getCode'=>0)));
	                throw new \Exception($error);
	            }

	            // archivo XML
	            $archivoXML =  substr($archivo, 0,-4) . '.xml';

	            // Se valida que exista el archivo XML
	            if (!file_exists($archivoXML)) {
	                //throw new \Exception('No se pudo leer el XML de respuesta de SUNAT.');
	                $error=json_encode(array('success'=>0,'errors'=>array('getMessage' =>'No se pudo leer el XML de respuesta de SUNAT.' ,'getCode'=>0)));
	                throw new \Exception($error);
	            }

	            $xml = new DOMDocument('1.0', 'ISO-8859-1');

	            // Se desactivan los errores al leer el Documento XML
	            $xml->load($archivoXML, LIBXML_NOWARNING | LIBXML_NOERROR);

	            /**
	             *  Se capturan los TAGS que almacenan la respuesta SUNAT
	             */

	            // DOCUMENTO DE RESPUESTA SUNAT
	            $DocumentResponse = $xml->getElementsByTagName('DocumentResponse');
	            $itemsDocumentResponse = $DocumentResponse->item(0)->childNodes;
	            $ResponseValue = null;
	            if ($itemsDocumentResponse->length > 0) {
	                for ($DocRes = 0; $DocRes < $itemsDocumentResponse->length; $DocRes++) {
	                    $Response = $itemsDocumentResponse->item($DocRes);
	                    if (isset($Response->tagName)) {
	                        $valtag = $Response->tagName;
	                        if ($valtag == 'cac:Response') {
	                            $ResponseValue = $itemsDocumentResponse->item($DocRes);
	                            break;
	                        }
	                    }
	                }
	            }

	            if (!empty($ResponseValue) && $ResponseValue->childNodes->length > 0) {
	                $ResNodes = $ResponseValue->childNodes;
	                for ($res = 0; $res < $ResNodes->length; $res++) {
	                    if (isset($ResNodes->item($res)->tagName)) {
	                        $tagResnNodes = $ResNodes->item($res)->tagName;
	                        if ($tagResnNodes == 'cbc:ReferenceID') {
	                            $this->SUNAT_ID_DOCUMENTO_ENVIADO = $ResNodes->item($res)->nodeValue;
	                        }
	                        if ($tagResnNodes == 'cbc:ResponseCode') {
	                            $this->SUNAT_CODIGO = $ResNodes->item($res)->nodeValue;
	                        }
	                        if ($tagResnNodes == 'cbc:Description') {
	                            $this->SUNAT_DESCRIPCION = $ResNodes->item($res)->nodeValue;
	                        }
	                    }
	                }
	            }

	            // FECHAS Y HORAS
	            $this->SUNAT_ID = $xml->getElementsByTagName('ID')->item(0)->nodeValue;
	            $this->SUNAT_FECHA_RECEPCION = $xml->getElementsByTagName('IssueDate')->item(0)->nodeValue;
	            $this->SUNAT_HORA_RECEPCION = $xml->getElementsByTagName('IssueTime')->item(0)->nodeValue;
	            $this->SUNAT_FECHA_GENERACION = $xml->getElementsByTagName('ResponseDate')->item(0)->nodeValue;
	            $this->SUNAT_HORA_GENERACION = $xml->getElementsByTagName('ResponseTime')->item(0)->nodeValue;


	            // NOTAS
	            $Notas = $xml->getElementsByTagName('Note');
	            foreach ($Notas as $nota) {
	                $desNota = $nota->nodeValue;
	                $this->SUNAT_NOTE .= $desNota . '|';
	            }

	            // RUC DEL RECEPCION
	            $SenderParty = $xml->getElementsByTagName('SenderParty');
	            $PartyIdentification = $SenderParty->item(0)->childNodes;
	            $this->SUNAT_RUC_RECEPCION = $PartyIdentification->item(0)->nodeValue;

	            // RUC DEL PROCESADO
	            $ReceiverParty = $xml->getElementsByTagName('ReceiverParty');
	            $PartyIdentification = $ReceiverParty->item(0)->childNodes;
	            $this->SUNAT_RUC_PROCESADO = $PartyIdentification->item(0)->nodeValue;

	            // RUC DEL RECEPTOR
	            $RecipientParty = $xml->getElementsByTagName('RecipientParty');
	            $PartyIdentification = $RecipientParty->item(0)->childNodes;
	            $this->SUNAT_RUC_RECEPTOR = $PartyIdentification->item(0)->nodeValue;

	            // DOCUMENTO REFERENCIADO
	            $DocumentReference = $xml->getElementsByTagName('DocumentReference');
	            $ID = $DocumentReference->item(0)->childNodes;
	            $this->SUNAT_ID_DOCUMENTO_PROCESADO = $ID->item(0)->nodeValue;

	            unlink($archivoXML);

	            return ([
	                'ID' => $this->SUNAT_ID,
	                'ID_DOCUMENTO_ENVIADO' => $this->SUNAT_ID_DOCUMENTO_ENVIADO,
	                'CODIGO' => $this->SUNAT_CODIGO,
	                'DESCRIPCION' => $this->SUNAT_DESCRIPCION,
	                'FECHA_RECEPCION' => $this->SUNAT_FECHA_RECEPCION,
	                'HORA_RECEPCION' => $this->SUNAT_HORA_RECEPCION,
	                'FECHA_GENERACION' => $this->SUNAT_FECHA_GENERACION,
	                'HORA_GENERACION' => $this->SUNAT_HORA_GENERACION,
	                'NOTE' => $this->SUNAT_NOTE,
	                'RUC_RECEPCION' => $this->SUNAT_RUC_RECEPCION,
	                'RUC_PROCESADO' => $this->SUNAT_RUC_PROCESADO,
	                'RUC_RECEPTOR' => $this->SUNAT_RUC_RECEPTOR,
	                'ID_DOCUMENTO_PROCESADO' => $this->SUNAT_ID_DOCUMENTO_PROCESADO,
	            ]);

	        } catch (DOMException $e) {
	            //return $ex->getMessage();
	            $ArrayMessage=array('success'=>0,'errors'=>array('getMessage' =>$e->getMessage() ,'getCode'=>$e->getCode()));
			    return json_encode($ArrayMessage);

	        } catch (\Exception $e) {
	            //return $ex->getMessage();
	            $ArrayMessage=array('success'=>0,'errors'=>array('getMessage' =>$e->getMessage() ,'getCode'=>$e->getCode()));
			    return json_encode($ArrayMessage);
	        }
	    }
	    //Lee respuesta de SUNAT
		function unzipByteArray($data){
		  try{

		  /*this firts is a directory*/
		  $head = unpack("Vsig/vver/vflag/vmeth/vmodt/vmodd/Vcrc/Vcsize/Vsize/vnamelen/vexlen", substr($data,0,30));
		  $filename = substr($data,30,$head['namelen']);
		  $if=30+$head['namelen']+$head['exlen']+$head['csize'];
		 /*this second is the actua file*/
		  $head = unpack("Vsig/vver/vflag/vmeth/vmodt/vmodd/Vcrc/Vcsize/Vsize/vnamelen/vexlen", substr($data,$if,30));
		  $raw = gzinflate(substr($data,$if+$head['namelen']+$head['exlen']+30,$head['csize']));
		  //$raw = gzinflate(substr($data,102,968));
		  /*you can create a loop and continue decompressing more files if the were*/
		 
		  return  $raw;//($if+$head['namelen']+$head['exlen']+30).'-'.$head['csize'];
		}
		catch(Exception $e){
			 $ArrayMessage=array('success'=>0,'errors'=>array('getMessage' =>$e->getMessage() ,'getCode'=>$e->getCode()));
		}

		}

		
	 
	}
	
	
	$dato=new Generaxml($_POST['idalquiler'],$_POST['tipo_documento'],$_POST['zip'],$_POST['nombre_archivo']);
	

	$dato->generar_xml();
?>