<?php
	ini_set('display_errors', '0');
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
	class TimeoutException extends RuntimeException {}
	class Generaxml extends Invoice
	{
		
		//private $sqlalquiler=null; 
		public $idalquiler;
		public $tipo_documento;

        public $SUNAT_ID;
        public $SUNAT_FECHA_RECEPCION;
        public $SUNAT_HORA_RECEPCION ;
        public $SUNAT_FECHA_GENERACION;
        public $SUNAT_HORA_GENERACION;

        public $SUNAT_ID_DOCUMENTO_ENVIADO;
        public $SUNAT_CODIGO;
        public $SUNAT_DESCRIPCION;
        public $SUNAT_NOTE;
        public $SUNAT_RUC_RECEPCION;
        public $SUNAT_RUC_PROCESADO;
        public $SUNAT_RUC_RECEPTOR;
        public $SUNAT_ID_DOCUMENTO_PROCESADO;


		       

		function __construct($idalquiler,$tipo_documento)
		{
			$this->idalquiler=$idalquiler;
			$this->tipo_documento=$tipo_documento;
			$this->crear_directorio();

			$this->SUNAT_ID=$SUNAT_ID;
        	$this->SUNAT_FECHA_RECEPCION= $SUNAT_FECHA_RECEPCION;
	        $this->SUNAT_HORA_RECEPCION=$SUNAT_HORA_RECEPCION ;
	        $this->SUNAT_FECHA_GENERACION=$SUNAT_FECHA_GENERACION;
	        $this->SUNAT_HORA_GENERACION=$SUNAT_HORA_GENERACION;
	        $this->SUNAT_ID_DOCUMENTO_ENVIADO=$SUNAT_ID_DOCUMENTO_ENVIADO;
	        $this->SUNAT_CODIGO=$SUNAT_CODIGO;
	        $this->SUNAT_DESCRIPCION=$SUNAT_DESCRIPCION;
	        $this->SUNAT_NOTE= $SUNAT_NOTE;
	        $this->SUNAT_RUC_RECEPCION=$SUNAT_RUC_RECEPCION;
	        $this->SUNAT_RUC_PROCESADO=$SUNAT_RUC_PROCESADO;
	        $this->SUNAT_RUC_RECEPTOR=$SUNAT_RUC_RECEPTOR;
	        $this->SUNAT_ID_DOCUMENTO_PROCESADO=$SUNAT_ID_DOCUMENTO_PROCESADO;
			
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

			if($this->tipo_documento=='1'){
				$this->tipo_documento='03';
			}else if($this->tipo_documento=='2'){
				$this->tipo_documento='01';
			}	

			$sqlalquiler = $link->query("select
			alquilerhabitacion.idalquiler,
			alquilerhabitacion.idhuesped,
			alquilerhabitacion.idhabitacion,
			alquilerhabitacion.nrohabitacion,
			alquilerhabitacion.tipooperacion,
			alquilerhabitacion.total,
			
			huesped.idhuesped,
			huesped.nombre,
			huesped.ciudad,
			huesped.tipo_documento,
			huesped.documento,
			
			alquilerhabitacion.comentarios,
			alquilerhabitacion.nroorden,
			alquilerhabitacion.fecharegistro
			
			from alquilerhabitacion inner join huesped on huesped.idhuesped = alquilerhabitacion.idhuesped
			where alquilerhabitacion.idalquiler = '$this->idalquiler' 
			");		
			$xaFila = $sqlalquiler->fetch_row();
			
			
			//
			if($xaFila[9]==''){
				$RUCReceptor='00000000';
				$RznSoc= $xaFila[7];
				$Direccion=$xaFila[8];
				$TipoDocumento='1';
			}else{

				$RUCReceptor=$xaFila[10];
				$RznSoc= $xaFila[7];
				$Direccion=$xaFila[8];
				$TipoDocumento=$xaFila[9];

			}

			$array = [
							'Encabezado' => [
								
								'Emisor' => [
									'RUCEmisor' => '20545756022',
									'RznSoc' => 'INVERSIONES INKA´S PALACE S.A.C.',
									'NomComercial' => '',
									'Ubigeo' => 150101,
									'Direccion'=>"CAL.MANUEL DEL PINO NRO. 116 URB. SANTA BEATRIZ (ALT.CDRA.16 AV.ARENALES) LIMA - LIMA - LIMA",
									'Urbanizacion' => '',
									'Departamento' => 'LIMA',
									'Provincia' => 'LIMA',
									'Distrito' => 'LIMA',
								],
								'Receptor' => [
									'RUCReceptor' =>$RUCReceptor,
									'RznSoc' => $RznSoc,											
									'Direccion'=> $Direccion,
									'TipoDocumento'=>$TipoDocumento,
								],
							],
					];

			

			//Detalle Aquiler
			$sqldetalle = $link->query("select
				idalquilerdetalle,
				idalquiler,
				tipoalquiler,	
				fechadesde,	
				fechahasta,	
				nrohoras,	
				nrodias,	
				costohora,	
				costodia,	
				formapago,	
				totalefectivo,	
				totalvisa,	
				estadopago,	
				costoingresoanticipado,	
				horaadicional,
				costohoraadicional,	
				huespedadicional,	
				costohuespedadicional,	
				preciounitario,	
				cantidad,	
				total,	
				idturno,	
				idusuario
				
				from alquilerhabitacion_detalle 
				where idalquiler = '$this->idalquiler'  order by idalquilerdetalle asc
				");
			$descripcion="";
			$items=array();
			$globalIGV=0; $globalTotalVenta=0; $globalGrabadas=0; 
			while ($tmpFila = $sqldetalle->fetch_row()){ $num++; 

			
				
				$descripcion=tipoAlquiler($tmpFila['2']).' ('.$tmpFila['19'].')';
				if($tmpFila['2'] != 4 &&  $tmpFila['2'] != 5){
					$descripcion.= fechadesdehasta($tmpFila['3'],$tmpFila['4']);
				}
				//$pu=number_format($tmpFila[18] / 1.18,2);								
				$pu=number_format($tmpFila[20] / 1.18,2);								
				//$t=($pu * 1);
				$t=$tmpFila[20];
				$st=number_format($t / (1.18 ),2);
				$igv=number_format($t - $st,2);
				
				
				$item ["pro_id"]     = $num;
	            $item ["pro_desc"]   =str_replace('<br>', '', $descripcion) ;
	            $item ['pro_cantidad']   = 1;
	            $item ["pro_unimedida"]  = 'NIU';
	            $item ["pro_preunitario"]    =$pu;
	            $item ['pro_preref']     =number_format($pu,2);
	            $item ["pro_tipoprecio"]     = "01"; //Precio Incluye IGV
	            $item ["pro_igv"]    = $igv;
	            $item ['pro_tipoimpuesto']   = "10"; //Gravado - Operación Onerosa
	            $item ["pro_isc"]    = number_format(0.00,2);
	            $item ["pro_otroimpuesto"]   = number_format(0.00,2);
	            $item ['pro_subtotal']   = $st;
	            $item ['pro_total']  =number_format($t,2);

	            $globalIGV+=$igv;
	            $globalTotalVenta+= $t;//$tmpFila[18];
	            $globalGrabadas+=$st;
	           
	            array_push($items,$item);

	            
			}
			//FIN DETALLE ALQUILER
			
			//INICIO DETALLE VENTAS
			$sqlventa = $link->query("select
			venta.idventa,
			venta.idalquiler,
			ventadetalle.idventadetalle,
			ventadetalle.idventa,
			ventadetalle.nombre,
			ventadetalle.cantidad,
			ventadetalle.precio,
			ventadetalle.importe
			
			from venta left join ventadetalle on ventadetalle.idventa = venta.idventa
			where venta.idalquiler = '$this->idalquiler'  order by ventadetalle.idventadetalle asc");

			$detTotventa=0;
			while($vFila = $sqlventa->fetch_row()){

				$pu2=number_format($vFila[6] / 1.18,2);								
				$t2=($vFila[6] * $vFila[5]);

				$st2=number_format($t2 / (1.18 ),2);
				$igv2=number_format($t2 - $st2,2);


				//$st2=number_format($t2 * (18 / 100 ),2);
				//$igv2=number_format($vFila[7] - $t2,2);

				$item2 ["pro_id"]     = rand();
	            $item2 ["pro_desc"]   =$vFila['4'] ;
	            $item2 ['pro_cantidad']   = $vFila['5'];
	            $item2 ["pro_unimedida"]  = 'NIU';
	            $item2 ["pro_preunitario"]    =$pu2;
	            $item2 ['pro_preref']     =number_format($pu2,2);
	            $item2 ["pro_tipoprecio"]     = "01"; //Precio Incluye IGV
	            $item2 ["pro_igv"]    = $igv2;
	            $item2 ['pro_tipoimpuesto']   = "10"; //Gravado - Operación Onerosa
	            $item2 ["pro_isc"]    = number_format(0.00,2);
	            $item2 ["pro_otroimpuesto"]   = number_format(0.00,2);
	            $item2 ['pro_subtotal']   = $st2;
	            $item2 ['pro_total']  =number_format($t2,2);
	            
	            $globalIGV+=$igv2;
	            $globalTotalVenta+=number_format($t2,2);
	            $globalGrabadas+=$st2;
	           
	            if(count($item2)>0){

	            	array_push($items,$item2);

	            }

			}

			//CORRELATIVO PARA LOS DOCUMENTOS

			$correlativo=$link->query("SELECT * FROM series WHERE codsunat='$this->tipo_documento' and estado=1")->fetch_row();

			
			$date = new DateTime($xaFila[13]);
			//Validar si es boleta o factura
			$corre=$correlativo[3].'-'.str_pad($correlativo[4], 8, "0", STR_PAD_LEFT);;
			
			$this->setEncabezado($array);			
			$this->setId($corre);
			$this->InvoiceTypeCode="03"; //01 factura - 03 boleta
			$this->setIssueDate($date->format('Y-m-d')); //Fecha registro

			$this->DocumentCurrencyCode="PEN"; //PEN SOLES - USD DOLARES			
			$this->setInvoiceLine($items);
			//$this->ci->invoice->setDiscrepancia($discrepancia);
			//$this->ci->invoice->setDocRelacionado($relacionado);
			$this->setTotalIgv(number_format($globalIGV,2));
			$this->setTotalIsc(number_format(0.00,2));
			$this->setTotalOtrosTributos(number_format(0.00,2));
			$this->setTotalVenta(number_format($globalTotalVenta,2));
			$this->setGravadas(number_format($globalGrabadas,2));//Venta Grabada
			$this->setGratuitas(number_format(0.00,2));//Venta Gratuitas
			$this->setInafectas(number_format(0.00,2));//Venta Inafectas
			$this->setExoneradas(number_format(0.00,2));//Venta Exoneradas
			$this->setDescuentoGlobal(number_format(0.00,2));//DescuentoGlobal
			$this->setMontoPercepcion(number_format(0.00,2));//MontoPercepcion
			$this->setTipoOperacion("01");//TipoOperacion 01 Venta Interna
			$MontoLetras=num_to_letras($globalTotalVenta,"PEN");
			$this->setMontoEnLetras($MontoLetras);//Total Venta Letras
			
			//General XML	
			switch ($correlativo[1])
	           {
	              
	                case "07":
	                   // $this->ci->invoice->_xmlCreditNote();
	                    break;
	                case "08":
	                    //$this->ci->invoice->_xmlDebitNote();
	                    break;
	                default: 
	                	$this->_xml();
	                	break;                       
	               
	            }
				
			
			//FIN GENERA XML
			//Arreglo listo para enviar al firmado del XML
	        $dato['TotIgv']=$globalIGV;
	        $dato['TotVenta']=$globalTotalVenta;
	        $dato['TotGravada']=$globalGrabadas ;
	        $dato['TotGratuitas']=0.00;
	        $dato['TotInafectas']=0.00;
	        $dato['TotExoneradas']=0.00;
	        $dato['DescuentoGlobal']=0.00;
	        $dato['Moneda']='PEN'; 
	        $dato['tipo_documento']=trim($correlativo[1]); 
	        $dato['fecharegistro']=$date->format('Y-m-d');

			$arrayFirmado=array('NomDocXML'=>$this->getId(),
				'TipoDocumento'=>$this->InvoiceTypeCode,
				'RUCEmisor'=>$array['Encabezado']['Emisor']['RUCEmisor']);
			
			$firmado= new Firmado();			
			
			//Firma XML - Devuelve Nombre de XML
			$result=$firmado->Firmar_xml($arrayFirmado); //Validar luego			
			
			//Comprime XML .zip	
			$zip = new ZipArchive();

			$nombreZip=substr($result, 0,-4).'.zip';
			$filename = './XMLENVIAR/'.$nombreZip;			
 
			if($zip->open($filename,ZIPARCHIVE::CREATE)===true) {
			        $zip->addFile('./XMLFIRMADOS/'.$result,$result);			       
			        $zip->close();
			       // echo 'Creado '.$filename;
			}
			else {
			        //echo 'Error creando '.$filename;
			}						
		
			@$cargaZip='./XMLENVIAR/'.$nombreZip;
			$zipEnviar=(file_get_contents($cargaZip));

			//Nombre para el archivo PDF ***** mejorar
			$nombre_archivo = utf8_decode($array['Encabezado']['Emisor']['RUCEmisor'].'-'.$date->format('Y-m-d').'-'.$corre);
			$this->generapdfinvoice($array,$corre,$dato,$items,$MontoLetras,$nombre_archivo,$firmado->firma,$xaFila[3]); //Genera PDF
			$Respuesta=$this->enviar_sunat($zipEnviar,$nombreZip,$nombre_archivo);	

			
			$res=json_decode($Respuesta,TRUE);
			echo $Respuesta; //Muestra Respuesta
			
			if($res['errors']=="0"):					
				//if($res['success']['codRespuesta'][0]==0):
					//Aquí trabajar para guardar en BD
					$codigoRespuesta=$res['success']['codRespuesta'][0];
					$msgRespuesta=$res['success']['Description'][0];
					
	            	//Actualiza estado de envío de alquiler a SUNAT / Esto para cuando se agreguen nuevos productos solo se envíen los NO FACTURADOS
	           		 $sqlactualiza = $link->query("UPDATE  alquilerhabitacion_detalle SET procesado=1 where idalquilerdetalle = '$tmpFila[0]'");
	            	 //Actualiza estado de envío de producto a SUNAT / Esto para cuando se agreguen nuevos productos solo se envíen los NO FACTURADOS
	            	$sqlDetalleVenta = $link->query("UPDATE ventadetalle SET procesado=1 where idventadetalle='$vFila[2]'");
																	
				//endif;	
			else:
					$codigoRespuesta=$res['errors']['getCode'];
					$msgRespuesta=$res['errors']['getMessage'];		
			endif;
			
			
			$this->ActualizaCorrelativo($correlativo);
			$mensajeSunat=str_replace("'","",$msgRespuesta);
			if(trim($codigoRespuesta)=='WSDL'): $codigoRespuesta=-1; endif;
			$this->ActualizaVenta($correlativo,$codigoRespuesta,$mensajeSunat,$nombreZip,$nombre_archivo,$corre);
			
			
		}

		//Actualizar Correlativo
		function ActualizaCorrelativo($numeracion=array()){
			$db = new conexion();
			$link = $db->conexion();
			return $link->query("UPDATE series SET numeracion = numeracion + 1 WHERE codsunat='$numeracion[1]' and iddocumento='$numeracion[0]'");

		}
		//Actualiza datos de venta
		function ActualizaVenta($numeracion=array(),$codigoRespuesta,$msgRespuesta,$nombreZip,$nombre_archivo,$corre){
			$db = new conexion();
			$link = $db->conexion();
			return $link->query("UPDATE alquilerhabitacion SET iddocumento ='$numeracion[0]',correlativo='$numeracion[4]',codigo_respuesta='$codigoRespuesta',
				mensaje_respuesta='$msgRespuesta',nombrezip='$nombreZip',nombre_archivo='$nombre_archivo',documento='$corre'
			WHERE idalquiler ='$this->idalquiler'");
		}

		
		//Enviar a SUNAT
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

				try {


					$respuesta=$client->sendBill(array('fileName'=>$nombreZip,'contentFile'=>$zipEnviar));
					
				    /*register_shutdown_function('shutdown');     
					ini_set('max_execution_time', 1); //max 1 segundo, cambiar a 3 para ver ejecución normal
					sleep(3); */
				   

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
	                //throw new MiExcepción('foo!');
	            } catch(TimeoutException $e) {
	            	$error=json_encode(array('success'=>0,'errors'=>array('getMessage' =>'ERROR SUNAT' ,'getCode'=>0)));
	                return json_encode($ArrayMessage);
	            
	            } catch (Exception $e) {
	                // relanzarla
	                $ArrayMessage=array('success'=>0,'nombre_archivo'=>$nombre_archivo.'.pdf','errors'=>array('getMessage' =>$e->getMessage() ,'getCode'=>$e->getCode()));
	                return json_encode($ArrayMessage);
	            }	

			
				
			} catch(TimeoutException $e) {
	            	$error=json_encode(array('success'=>0,'errors'=>array('getMessage' =>'ERROR SUNAT' ,'getCode'=>0)));
	                return json_encode($ArrayMessage);	

			} catch (SoapFault $fault) {
				$filtrar=str_replace("soap-env:Client."," ", $fault->faultcode);
			    $ArrayMessage=array('success'=>0,'errors'=>array('getCode'=>$filtrar,'getMessage'=>$fault->faultstring.' Verifique su conexión a Internet'),'nombre_archivo'=>$nombre_archivo.'.pdf');
			  
			    return json_encode($ArrayMessage);
			} catch (Exception $e) { 
			    
			    $ArrayMessage=array('success'=>0,'nombre_archivo'=>$nombre_archivo.'.pdf','errors'=>array('getMessage' =>$e->getMessage() ,'getCode'=>$e->getCode()));
			    return json_encode($ArrayMessage);
			}

			
			
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

		public function generapdfinvoice($Emcabezado=array(),$NumDocumento,$Datos,$productos=array(),$MontoLetras,$nombre_archivo,$firma='',$NHabitacion=''){		

			$arr=$Emcabezado;
			$medidas = array(90, 217); // Ajustar aqui segun los milimetros necesarios;

			$pdf = new Pdf('P', 'mm', $medidas, true, 'UTF-8', false);
			$pdf->setPageFormat($medidas, $orientation='P');
			

			$pdf->RUCEmpresa=$arr['Encabezado']['Emisor']['RUCEmisor'];
			$pdf->NumDocumento=$NumDocumento;

	        $pdf->SetCreator(PDF_CREATOR);
	        $pdf->SetAuthor('Erwin Torres León');
	        $pdf->SetTitle($nombre_archivo);
	        //$pdf->SetSubject('Tutorial TCPDF');
	        //$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
	       
	       switch ($Datos['tipo_documento'])
		       {
		          
		            case "01":	            	
		                $pdf->NomDocumento='FACTURA ELECTRÓNICA';
		                break;
		            case "03":
		                $pdf->NomDocumento='BOLETA ELECTRÓNICA';
		                break;
		            case "07": 
		            	$pdf->NomDocumento='NOTA DE CRÉDITO ELECTRÓNICA';
		            	break;
		            case "08": 
		            	$pdf->NomDocumento='NOTA DE DÉDITO ELECTRÓNICA';
		            	break;	                       
		           
		        }
	       
	 		
			
			// Establecer el tipo de letra
	 
			//Si tienes que imprimir carácteres ASCII estándar, puede utilizar las fuentes básicas como
			// Helvetica para reducir el tamaño del archivo.
			$pdf->SetFont('Helvetica', '', 12, '', true);
	 
			// Añadir una página
			// Este método tiene varias opciones, consulta la documentación para más información.
	       	$pdf->Open();
			$pdf->AddPage();
	 		 // ponemos los márgenes 
			//$pdf->SetMargins(15,15); 
			
		     /* incluimos un rectángulo relleno para contener datos del cliente */ 
			//$pdf->Rect(15,47,180,22,'FD','',array(255,255,255));
			$pdf->SetFont('Helvetica','B',8);
			$pdf->SetXY(2,24);
			$pdf->Cell(2, 48, "RUC/DNI:",0,0,'L');
			$pdf->SetFont('Helvetica','',8);
			$pdf->SetXY(20,24);
			$pdf->Cell(10, 48, $arr['Encabezado']['Receptor']['RUCReceptor'],0,0,'L');
			$pdf->SetFont('Helvetica','B',10);			


			$pdf->SetFont('Helvetica','B',8); 
			$pdf->Ln(7);
			$pdf->SetXY(2,28);
			$pdf->Cell(17, 48, "Cliente:",0,0,'L');
			$pdf->SetFont('Helvetica','',8);
			$pdf->SetXY(20,28);
			$pdf->Cell(17, 48, $arr['Encabezado']['Receptor']['RznSoc'],0,0,'L');
			$pdf->Ln(5);
			$pdf->SetFont('Helvetica','B',8);
			$pdf->SetXY(2,32);
			$pdf->Cell(17, 48, "Dirección:",0,0,'L'); 
			$pdf->SetXY(20,32);
			$pdf->SetFont('Helvetica','',8);
			$pdf->Cell(190, 48, $arr['Encabezado']['Receptor']['Direccion'],0,'L'); 
			$pdf->SetFont('Helvetica','B',8); 
			$pdf->SetXY(2,36);  
			$pdf->Cell(30, 48, "Fecha de Emisión:",0,0,'L');
			$pdf->SetFont('Helvetica','',8);
			$pdf->SetXY(30,36);
			$pdf->Cell(30, 48, $Datos['fecharegistro'],0,0,'L'); 
			$pdf->SetFont('Helvetica','B',8);
			$pdf->SetXY(2,40);  
			$pdf->Cell(30, 48, "Moneda:",0,0,'L');
			$pdf->SetFont('Helvetica','',8);
			$pdf->SetXY(30,40);
			$pdf->Cell(30, 48, 'Soles',0,0,'L'); 

			$pdf->SetFont('Helvetica','B',8);
			$pdf->SetXY(2,44);  
			$pdf->Cell(30, 48, "Nº Habitación:",0,0,'L');
			$pdf->SetFont('Helvetica','',8);
			$pdf->SetXY(30,44);
			$pdf->Cell(30, 48, $NHabitacion,0,0,'L'); 


			$pdf->Ln(4);
			$pdf->SetX(1);
		    $pdf->Cell(100,52,"------------------------------------------------------------------------------------",0,0,'L');
		    $pdf->Ln();
		    // Anchuras de las columnas
		    //$w = array(10, 20, 16, 95,18,22);
		    $w = array(8, 50);
		    // Títulos de las columnas
			//$header = array('Cod.', 'Uni. Medida', 'Cantidad', 'Descripción','Precio','V. Venta');
			$pdf->SetFont('Helvetica','B',8);
			$header = array('Cod.', 'Descripción');
			$pdf->SetXY(2,69); 
			//$html ='<hr>';
			//$pdf->writeHTML($html, true, false, true, false, '');
			//$pdf->SetDash(1,1);
			//$pdf->Line(2,67,320,67);
		    // Cabeceras
		    for($i=0;$i<count($header);$i++)		    	
		    	$pdf->Cell($w[$i],7,$header[$i],0,0,'L',0);
		    	
		    	
				
		    $pdf->Ln();		    
		    // Datos
		    $i=1;
		    $pdf->SetFont('Helvetica','',7);
		   	

		   	if($Datos['Moneda']=='PEN'):
		   		$CodMoneda='S/.';
		   	else:
		   		$CodMoneda='$';
		   	endif;

		    foreach($productos as $row)
		    {
		    	$pdf->SetX(2);
		        $pdf->Cell($w[0],4,$i,'0');
		        
		        $y = $pdf->GetY();
				$acotado = $row['pro_desc'];
				$pdf->MultiCell($w[1],4,$acotado,0,‘L’); $pdf->SetXY(149,$y);		       
		       
		        $pdf->Ln();
		        
		        $pdf->SetFont('Helvetica','B',7);
		        $pdf->Cell(60,1,$CodMoneda.' '.number_format(round($row['pro_total']),2),0,0,'R');       
		        $pdf->Ln();
		        $i++;
		       $pdf->SetFont('Helvetica','',7);
		    }
		   	
		   	/*TOTALES*/
		   	$pdf->TotGravadas=$CodMoneda." ".number_format($Datos['TotGravada'],2);
		   	$pdf->TotGratuitas=$CodMoneda." ".number_format($Datos['TotGratuitas'],2);
		   	$pdf->TotExoneradas=$CodMoneda." ".number_format($Datos['TotExoneradas'],2);
		   	$pdf->TotInafectas=$CodMoneda." ".number_format($Datos['TotInafectas'],2);


			//$pdf->Ln();
			//$pdf->Cell(65,5,'SON: '.$MontoLetras,0,0,'R');
			//$pdf->SetFont('Helvetica','',8);
			//$pdf->Cell(50,5,"SUB TOTAL: ".$CodMoneda,0,0,'R');
			//$pdf->SetFont('Helvetica','B',8);
			//$pdf->Cell(10,5,number_format(($Datos['TotGravada']),2),0,0,'R');
			$pdf->SetX(0);
			$pdf->Cell(100,5,"------------------------------------------------------------------------------------------------",0,0,'L');
			$pdf->Ln();
			$pdf->SetFont('Helvetica','',7);
			$pdf->Cell(17,5,"OP. GRAVADAS: ".$CodMoneda,0,0,'R');
			$pdf->SetFont('Helvetica','B',7);
			$pdf->Cell(48,5,number_format($Datos['TotGravada'],2),0,0,'R');
			$pdf->Ln();
			$pdf->SetFont('Helvetica','',7);
			$pdf->Cell(20,5,"OP. EXONERADAS: ".$CodMoneda,0,0,'R');
			$pdf->SetFont('Helvetica','B',7);
			$pdf->Cell(45,5,number_format($Datos['TotExoneradas'],2),0,0,'R');
			$pdf->Ln();
			$pdf->SetFont('Helvetica','',7);
			$pdf->Cell(17,5,"OP. INAFECTAS: ".$CodMoneda,0,0,'R');
			$pdf->SetFont('Helvetica','B',7);
			$pdf->Cell(48,5,number_format($Datos['TotInafectas'],2),0,0,'R');
			$pdf->Ln();
			$pdf->SetFont('Helvetica','',7);
			$pdf->Cell(17,5,"OP. GRATUITAS: ".$CodMoneda,0,0,'R');
			$pdf->SetFont('Helvetica','B',7);
			$pdf->Cell(48,5,number_format($Datos['TotGratuitas'],2),0,0,'R');
			$pdf->Ln();
			$pdf->SetFont('Helvetica','',7);
			$pdf->Cell(17,5,"IGV: ".$CodMoneda,0,0,'R');
			$pdf->SetFont('Helvetica','B',7);
			$pdf->Cell(48,5,number_format($Datos['TotIgv'],2),0,0,'R');
			$pdf->Ln();
			$pdf->SetFont('Helvetica','',7);
			$pdf->Cell(17,5,"TOTAL: ".$CodMoneda,0,0,'R');
			$pdf->SetFont('Helvetica','B',7);
			$pdf->Cell(48,5,number_format($Datos['TotVenta'],2),0,0,'R');
			//$pdf->Ln();

		    $datosAdicionales_CDB=$arr['Encabezado']['Emisor']['RUCEmisor']."|".$Datos['tipo_documento']."|".$NumDocumento."|".$Datos['TotIgv']."|".$Datos['TotVenta']."|".$Datos['fecharegistro']."|".$arr['Encabezado']['Receptor']['TipoDocumento']."|".$arr['Encabezado']['Receptor']['RUCReceptor']; 
		    
		           
			// set style for barcode
			$style = array(
			    'border' => 0,
			    'vpadding' => 'auto',
			    'hpadding' => 'auto',
			    'fgcolor' => array(0,0,0),
			    'bgcolor' => false, //array(255,255,255)
			    'module_width' => 1, // width of a single module in points
			    'module_height' => 1 // height of a single module in points
			);
			$pdf->CodBarras=$datosAdicionales_CDB;
			$pdf->SetX(2);
			$pdf->Ln();
			$pdf->SetX(15);
			//$pdf->Cell(15,5,$firma,0,'C');	
			
			$pdf->Cell(2,5,'Representación impresa de la '.ucwords(strtolower($pdf->strtolower_utf8($pdf->NomDocumento))).'',0,'J');	
			$pdf->Ln();
			$alto=$pdf->GetY();
			$pdf->SetX(20);
			$pdf->Cell(2,5,$pdf->write2DBarcode($datosAdicionales_CDB, 'PDF417', 10, $alto, 135, 20, $style, 'N'),0,'J');
			
			//$pdf->Line(10,10,200,10);
			
			//$nombre_archivo='prueba.pdf';
	        $pdf->Output('PDF/'.$nombre_archivo.'.pdf', 'F');

		}
	 
	}
	
	
	//Prueba de errores
		
    function shutdown(){ //async
        $e = error_get_last(); 
        if(!empty($e)){
            //echo "Soy lento we";
            $error=json_encode(array('success'=>0,'errors'=>array('getMessage' =>'ERROR SUNAT' ,'getCode'=>0)));
            echo json_encode($error);
        }
    } 

	$dato=new Generaxml($_POST['idalquiler'],$_POST['tipo_documento']);
	
	
	$dato->generar_xml();
?>