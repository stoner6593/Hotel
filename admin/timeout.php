<?php
    //code
    //Prueba de errores
    ini_set('display_errors', '0');
    /**
    * 
    */

	

    class Prueba
    {
    	function shutdown(){ //async
		    $e = error_get_last(); 
		    if(!empty($e)){
		        //echo "Soy lento we";
		        $error=json_encode(array('success'=>0,'errors'=>array('getMessage' =>'ERROR SUNAT' ,'getCode'=>0)));
		        echo json_encode($error);
		    }
		}
		//Eniar a SUNAT
		function enviar_sunat(/*$zipEnviar,$nombreZip,$nombre_archivo*/){
	        //global $wsdl, $client;
		  	//$wsdl ='https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl';
		  	//https://e-factura.sunat.gob.pe/ol-ti-itcpfegem/billService?wsdl
		  	//https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl

			//$params=array('user'=>'20545756022MODDATOS','pass'=>'moddatos');
			
			try {
				/*$cabecera= new CustomHeaders($params);					
				$client = new SoapClient($wsdl, [ 'cache_wsdl' => WSDL_CACHE_NONE, 'trace' =>TRUE , 'soap_version' => SOAP_1_1 ] ); 
				$client->__setSoapHeaders([$cabecera]); 
				$client->__getFunctions();
				
				$contentFile = new SoapVar($zipEnviar, XSD_BYTE);*/

					//$respuesta=$client->sendBill(array('fileName'=>$nombreZip,'contentFile'=>$zipEnviar));
					
				    register_shutdown_function('shutdown');     
					ini_set('max_execution_time', 1); //max 1 segundo, cambiar a 3 para ver ejecución normal
					sleep(3); 
				    echo "NORMAL";

					/*if($respuesta):

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
		            //throw new MiExcepción('foo!');*/

			
				
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
	}
	$prueba= new Prueba();
	$prueba->enviar_sunat();
//Mas code		