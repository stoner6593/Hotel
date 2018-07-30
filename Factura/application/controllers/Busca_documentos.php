<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Busca_documentos extends CI_Controller {

	public function __construct()
	{
		parent::__construct();		
	
	}
	public function index()
	{
		//$this->load->view('principal');
	}

	public function BuscaDocumento($docCliente=NULL,$tipDocumento=NULL,$numDocumento=NULL,$fechaEnvio=NULL){ 

		/*$docCliente = $this->input->get("docCliente",TRUE);
		$tipDocumento = $this->input->get("tipDocumento",TRUE);
		$numDocumento = $this->input->get("numDocumento",TRUE);
		$fechaEnvio = $this->input->get("fechaEnvio",TRUE);*/
		//echo $fechaEnvio;
		$this->load->model('Buscadocumentos_model');			
		$res=$this->Buscadocumentos_model->_buscaDocumentos($docCliente,$tipDocumento,$numDocumento,$fechaEnvio);
		$variable = array();
		$i=0;	
		if($res):
			
			foreach($res as $row)
			{	
				$variable[$i][]=$row['num_doc_cli'];					
				$variable[$i][]=$row['nom_cli'];	
				$variable[$i][]=$row['num_doc'];	
				$variable[$i][]=$row['total'];
				$variable[$i][]=$row['estado'];
				$variable[$i][]=$row['respuesta'];						
				$variable[$i][]=  '<i class="btn btn-success btn-xs fa fa-file-code-o" title="Descargar XML '.$row['nomarchivo'].".xml".'" ></i>';
				$variable[$i][]=  '<i class="btn btn-brown btn-xs fa fa-file-zip-o" title="Descargar Archivo ZIP '.$row['nomarchivo'].".zip".'"></i>';	
				$variable[$i][]=  '<i class="btn btn-danger btn-xs fa fa-file-pdf-o" title="Descargar PDF '.$row['nompdf'].".pdf".'" ></i>';		
				
			  
				$i++;
			}
		endif;		
		$total['aaData']=$variable;
		echo json_encode($total);
	
			
	 
	 

	}
}
