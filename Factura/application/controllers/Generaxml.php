<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Generaxml extends CI_Controller {

	protected $ci;
	public $correlativo;
	public function __construct()
	{
		parent::__construct();	
		//$this->correlativo;
		$this->ci =& get_instance();
		$this->crear_directorio();//Crea directorios
		
	
	}
	
	public function generar_xml(){
		


		try{


			$dato = $this->input->post("formulario");

			if(isset($_POST['tabla'])):
				//$productos=($_POST['tabla']);
				$productos = $this->input->post("tabla");
			else:
				$productos=[];
			endif;

			if(isset($_POST['discrepancia'])):
				
				$discrepancia = $this->input->post("discrepancia");
			else:
				$discrepancia=[];
			endif;

			if(isset($_POST['relacionado'])):
				
				$relacionado = $this->input->post("relacionado");
			else:
				$relacionado=[];
			endif;
			
			if(count($productos)==0):
				
				$arrayName = array('success' =>2 ,'errors'=>"No hay Productos en la Lista" );
				
			
			echo json_encode($arrayName);
			else:
				
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
								'RUCReceptor' => $dato['DocReceptor'],
								'RznSoc' => $dato['NomLegalEmisor'],											
								'Direccion'=> $dato['DireccionEmisor'],
								'TipoDocumento'=>$dato['TipoDocEmisor'],
							],
						],
				];
	            
				$f=explode("/",$dato['fecharegistro']);
				$fechaRegistro=$f[2]."-".$f[0]."-".$f[1];	

				$this->ci->load->library(array('Invoice','Firmado','zip'));
				$this->load->model('Configuracion_model');				
				$this->load->helper('convertir_helper');
				
				
				$this->correlativo=$this->Configuracion_model->BuscaNumeracion($dato['tipo_documento']);				
				$corre=$this->correlativo['serie'].'-'.str_pad($this->correlativo['numeracion'], 8, "0", STR_PAD_LEFT);;
				
				$this->ci->invoice->setId($corre);
				$this->ci->invoice->InvoiceTypeCode=$this->correlativo['codsunat'];//$dato['tipo_documento'];
				$this->ci->invoice->setIssueDate($fechaRegistro);
				$this->ci->invoice->DocumentCurrencyCode=$dato['Moneda'];	
				$this->ci->invoice->setEncabezado($array);
				$this->ci->invoice->setInvoiceLine($productos);
				$this->ci->invoice->setDiscrepancia($discrepancia);
				$this->ci->invoice->setDocRelacionado($relacionado);
				$this->ci->invoice->setTotalIgv($dato['TotIgv']);
				$this->ci->invoice->setTotalIsc($dato['TotIsc']);
				$this->ci->invoice->setTotalOtrosTributos($dato['TotOtrosTributos']);
				$this->ci->invoice->setTotalVenta($dato['TotVenta']);
				$this->ci->invoice->setGravadas($dato['TotGravada']);//Venta Grabada
				$this->ci->invoice->setGratuitas($dato['TotGratuitas']);//Venta Gratuitas
				$this->ci->invoice->setInafectas($dato['TotInafectas']);//Venta Inafectas
				$this->ci->invoice->setExoneradas($dato['TotExoneradas']);//Venta Exoneradas
				$this->ci->invoice->setDescuentoGlobal($dato['DescuentoGlobal']);//DescuentoGlobal
				$this->ci->invoice->setMontoPercepcion($dato['MontoPercepcion']);//MontoPercepcion
				$this->ci->invoice->setTipoOperacion($dato['TipoOperacion']);//TipoOperacion
				$MontoLetras=num_to_letras($dato['TotVenta'],$dato['Moneda']);
				$this->ci->invoice->setMontoEnLetras($MontoLetras);//Total Venta Letras
				
				//Detración				
				if($dato['MontoDetraccion']>0):

					$this->ci->invoice->setCalculoDetraccion($dato['cal_detraccion']);//setCalculoDetraccion					
					$this->ci->invoice->setMontoDetraccion(number_format($dato['MontoDetraccion'], 2, '.', ''));
				
				endif;
				
				//General XML	
				switch ($dato['tipo_documento'])
		           {
		              
		                case "07":
		                    $this->ci->invoice->_xmlCreditNote();
		                    break;
		                case "08":
		                    $this->ci->invoice->_xmlDebitNote();
		                    break;
		                default: 
		                	$this->ci->invoice->_xml();	
		                	break;                       
		               
		            }
				
				//Actualiza Numeracion    
		        $actuCorrel=$this->correlativo['numeracion'] + 1;
				$this->Configuracion_model->ActualizaNumeracion($this->correlativo['codsunat'],$actuCorrel);
		        
				//Arreglo listo para enviar al firmado del XML
				$arrayFirmado=array('NomDocXML'=>$this->ci->invoice->getId(),
					'TipoDocumento'=>$this->ci->invoice->InvoiceTypeCode,
					'RUCEmisor'=>$array['Encabezado']['Emisor']['RUCEmisor']);

				$this->ci->load->library(('Firmado'));
				
				//Firma XML - Devuelve Nombre de XML
				$result=$this->ci->firmado->firmar_xml($arrayFirmado); //Validar luego
				
				//Comprime XML .zip				
				@$path = './XMLFIRMADOS/'.$result;
				$this->zip->read_file(@$path);
				$nombreZip=substr($result, 0,-4).'.zip';
				$this->zip->archive('./XMLENVIAR/'.$nombreZip);
				@$cargaZip='./XMLENVIAR/'.$nombreZip;
				$zipEnviar=(file_get_contents($cargaZip));

				//Nombre para el archivo PDF ***** mejorar
				$nombre_archivo = utf8_decode($array['Encabezado']['Emisor']['RUCEmisor'].'-'.$fechaRegistro.'-'.$corre);
				$this->generapdfinvoice($array,$corre,$dato,$productos,$MontoLetras,$nombre_archivo); //Genera PDF
				$Respuesta=$this->enviar_sunat($zipEnviar,$nombreZip,$nombre_archivo);	

				
				
				
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
				
				$this->load->model('Documentos_model');	
				$resInvoice=$this->Documentos_model->_guardaCabecera($dato,$corre,$codigoRespuesta,$msgRespuesta,$nombreZip,$nombre_archivo);
				if($resInvoice){
					foreach ($productos as $res2 ):
						$datos2[] = array(						
						'num_doc' => $corre,
						'cod_prod' => $res2['pro_id'],
						'descripcion' => $res2['pro_desc'],							
						'cantidad' => $res2['pro_cantidad'],
						'uni_medida' => $res2['pro_unimedida'],								
						'pre_unitario'=>$res2['pro_preunitario'],						
						'pre_referencial' => $res2['pro_preref'],
						'tipo_precio' => $res2['pro_tipoprecio'],							
						'impuesto' => $res2['pro_igv'],
						'tipo_inpuesto' => $res2['pro_tipoimpuesto'],								
						'isc'=>$res2['pro_isc'],						
						'otro_impuesto' => $res2['pro_otroimpuesto'],							
						'sub_total' => $res2['pro_subtotal'],
						'total' => $res2['pro_total']);							
					endforeach;	
					$this->Documentos_model->_guardaDetalle($datos2);
				}
				
			endif;	
		
		} catch (Exception $e) { 
		    
		    echo $ArrayMessage=array('success'=>'0','errors'=>array('getMessage' =>$e->getMessage() ,'getCode'=>$e->getCode()));
		}	
		
	}

	public function enviar_sunat($zipEnviar,$nombreZip,$nombre_archivo){
   		global $wsdl, $client;
      	$wsdl ='https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl';
      	//https://e-factura.sunat.gob.pe/ol-ti-itcpfegem/billService?wsdl
      	//https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl
	
		$params=array('user'=>'20545756022MODDATOS',
			'pass'=>'moddatos');

		
	
		try {

		   	$this->ci->load->library('Customheaders',$params);
			$cabecera=$this->ci->customheaders;
			$this->ci->customheaders;		
			$client = new SoapClient($wsdl, [ 'cache_wsdl' => WSDL_CACHE_NONE, 'trace' =>TRUE , 'soap_version' => SOAP_1_1 ] ); 
			$client->__setSoapHeaders([$cabecera]); 
			$client->__getFunctions();
			/*$estado = $client->getStatus([
			'ticket' => '201600638220110'
			]);*/
			$contentFile = new SoapVar($zipEnviar, XSD_BYTE);

			$respuesta=$client->sendBill(array('fileName'=>$nombreZip,'contentFile'=>$zipEnviar));

			if($respuesta):

				$leer=$client->__getLastResponse();					
				//Guarda CDR en carpeta destino
				file_put_contents('CDR/R-'.$nombreZip, $respuesta->applicationResponse);			
				
				//Obtiene XML para pocesar respuesta
				$fileData=$this->unzipByteArray($respuesta->applicationResponse);
				//echo ($fileData.'ola');
				$xml=(simplexml_load_string($fileData));				
				$posts = $xml->children('cac', true)->DocumentResponse->children('cac', true)->Response->children('cbc', true);
				
				
				$ArrayMessage=array('success'=> array('ReferenceID' => $posts->ReferenceID,'codRespuesta' => $posts->ResponseCode,
					'Description' => $posts->Description,'nombre_archivo'=>$nombre_archivo.'.pdf' ),'errors'=>0);
			endif;
			
			
			

		} catch (SoapFault $fault) {
			$filtrar=str_replace("soap-env:Client."," ", $fault->faultcode);
		    $ArrayMessage=array('success'=>0,'errors'=>array('getCode'=>$filtrar,'getMessage'=>$fault->faultstring));
		  
		    
		} catch (Exception $e) { 
		    
		    $ArrayMessage=array('success'=>0,'errors'=>array('getMessage' =>$e->getMessage() ,'getCode'=>$e->getCode()));
		}

		return json_encode($ArrayMessage);
		
   }

   //Lee respuesta de SUNAT
	public function unzipByteArray($data){
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
 
 	public function GenerarZip($result){
 		
 		@$path = './XMLFIRMADOS/'.$result;
		$this->zip->read_file(@$path);
		$nombreZip=substr($result, 0,-4).'.zip';
		$this->zip->archive('./XMLENVIAR/'.$nombreZip);
		@$cargaZip='./XMLENVIAR/'.$nombreZip;
		$zipEnviar=(file_get_contents($cargaZip));
		return $zipEnviar;
		//var_dump(($zipEnviar));

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
	}

	public function generapdfinvoice($Emcabezado=array(),$NumDocumento,$Datos,$productos=array(),$MontoLetras,$nombre_archivo,$firma='',$NHabitacion=''){
		

		$arr=$Emcabezado;
		$this->load->library(array('Pdf','Barcode'));

		$medidas = array(90, 217); // Ajustar aqui segun los milimetros necesarios;

		$pdf = new Pdf('P', 'mm', $medidas, true, 'UTF-8', false);
		$pdf->setPageFormat($medidas, $orientation='P');
		//$pdf=new Pdf('P','mm','A4');

		$pdf->RUCEmpresa=$arr['Encabezado']['Emisor']['RUCEmisor'];
		$pdf->NumDocumento=$NumDocumento;

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Erwin Torres León');
        $pdf->SetTitle('Reporte de Documento Eletrónico');
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
       
 
		// datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config_alt.php de libraries/config
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setFooterData($tc = array(0, 64, 0), $lc = array(0, 64, 128));
 
		// datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
 
		// se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
 
		// se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
 
		// se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
 
		//relación utilizada para ajustar la conversión de los píxeles
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
 
 
		// ---------------------------------------------------------
		// establecer el modo de fuente por defecto
        $pdf->setFontSubsetting(true);
 
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
		$pdf->SetFont('Helvetica','',7);
		$pdf->SetXY(20,28);
		//$pdf->Cell(17, 48, $arr['Encabezado']['Receptor']['RznSoc'],0,0,'L');
		$pdf->MultiCell(70,8,$arr['Encabezado']['Receptor']['RznSoc'],0,'L',FALSE,1,20,51); 
		$pdf->Ln(6);
		$pdf->SetFont('Helvetica','B',8);
		$pdf->SetXY(2,35);
		$pdf->Cell(17, 48, "Dirección:",0,0,'L'); 
		$pdf->SetXY(20,35);
		$pdf->SetFont('Helvetica','',7);
		//$y = $pdf->GetY();
		//$pdf->Cell(10, 48, $arr['Encabezado']['Receptor']['Direccion'],0,'L'); 
		
		$pdf->MultiCell(70,8,$arr['Encabezado']['Receptor']['Direccion'],0,'L',FALSE,1,20,57); 
		$pdf->SetFont('Helvetica','B',8); 
		$pdf->SetXY(2,40); 
		$pdf->Cell(30, 48, "Fecha de Emisión:"); //,FALSE,1,2,$pdf->GetY()
		$pdf->SetFont('Helvetica','',8);
		$pdf->SetXY(30,40);
		$pdf->Cell(30, 48, $Datos['fecharegistro'],0,0,'L'); 
		$pdf->SetFont('Helvetica','B',8);
		$pdf->SetXY(2,44);  
		$pdf->Cell(30, 48, "Moneda:",0,0,'L');
		$pdf->SetFont('Helvetica','',8);
		$pdf->SetXY(30,44);
		$pdf->Cell(30, 48, 'Soles',0,0,'L'); 

		$pdf->SetFont('Helvetica','B',8);
		$pdf->SetXY(2,48);  
		$pdf->Cell(30, 48, "Nº Habitación:",0,0,'L');
		$pdf->SetFont('Helvetica','',8);
		$pdf->SetXY(30,44);
		$pdf->Cell(30, 56, $NHabitacion,0,0,'L'); 


		$pdf->Ln(4);
		$pdf->SetX(1);
	    $pdf->Cell(100,52,"------------------------------------------------------------------------------------",0,0,'L');
	    $pdf->Ln();
	    // Anchuras de las columnas
	    //$w = array(10, 20, 16, 95,18,22);
	    $w = array(8, 50);
	    // Títulos de las columnas		
		$pdf->SetFont('Helvetica','B',8);
		$header = array('Cod.', 'Descripción');
		$pdf->SetXY(2,75); 
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
	        /*$pdf->Cell($w[0],6,$i,'LRB');
	        $pdf->Cell($w[1],6,$row['pro_unimedida'],'LRB');
	        $pdf->Cell($w[2],6,$row['pro_cantidad'],'LRB');
	        $pdf->Cell($w[3],6,$row['pro_desc'],'LRB');
	        $pdf->Cell($w[4],6,number_format($row['pro_preunitario'],2),'LRB',0,'R');
	        $pdf->Cell($w[5],6,number_format($row['pro_total'],2),'LRB',0,'R');       
	        $pdf->Ln();
	        $i++;*/

	        
	        $pdf->SetX(2);
	        $pdf->Cell($w[0],4,$i,'0');
	        
	        $y = $pdf->GetY();
			$acotado = $row['pro_desc'];
			$pdf->MultiCell($w[1],4,$acotado,0,'L'); $pdf->SetXY(149,$y);		       
	       
	        $pdf->Ln();
	        
	        $pdf->SetFont('Helvetica','B',7);
	        $pdf->Cell(60,1,$CodMoneda.' '.number_format(round($row['pro_total'],2),2),0,0,'R');       
	        $pdf->Ln();
	        $i++;
	       $pdf->SetFont('Helvetica','',7);
	         
	    }
	   		
	   	/*TOTALES*/
	   	$pdf->TotGravadas=$CodMoneda." ".number_format($Datos['TotGravada'],2);
	   	$pdf->TotGratuitas=$CodMoneda." ".number_format($Datos['TotGratuitas'],2);
	   	$pdf->TotExoneradas=$CodMoneda." ".number_format($Datos['TotExoneradas'],2);
	   	$pdf->TotInafectas=$CodMoneda." ".number_format($Datos['TotInafectas'],2);

	   	//VALIDACION PARA EL DESCUENTO GLOBAL
			
		if($Datos['DescuentoGlobal']>0){
	        $Datos['TotVenta']=number_format($Datos['TotVenta'] - $Datos['DescuentoGlobal'],2);
	        $Datos['TotGravada']=$Datos['TotVenta'] / 1.18;
	        $Datos['TotIgv']=$Datos['TotVenta'] - $Datos['TotGravada'];
	    }

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
		$pdf->Cell(17,5,"DESCUENTO: ".$CodMoneda,0,0,'R');
		$pdf->SetFont('Helvetica','B',7);
		$pdf->Cell(48,5,($Datos['DescuentoGlobal']),0,0,'R');
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
		$pdf->Ln();
		$pdf->SetX(26);
		//$pdf->Cell(2,5,'Forma de Pago: '.$Datos['formapago'],0,'J');
		//$pdf->Line(10,10,200,10);
		
		//$nombre_archivo='prueba.pdf';
        $pdf->Output('PDF/'.$nombre_archivo.'.pdf', 'F');
	}


	
}
