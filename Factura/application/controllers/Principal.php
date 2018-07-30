<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Principal extends CI_Controller {

	public function __construct()
	{
		parent::__construct();		
	
	}
	public function index()
	{
		$this->load->model(array('Configuracion_model'));
		$data_content['TipoDocumento'] = $this->Configuracion_model->ListaTipoDocumento();
		$data_content['TipoDocumentoIdent'] = $this->Configuracion_model->ListaDocumentoIdentidad();
		$data_content['Anticipo'] = $this->Configuracion_model->ListaAnticipos();
		/*Nuevo*/
		$data_content['TipoPrecio'] = $this->Configuracion_model->ListaTipoPrecio();		
		$data_content['TipoImpuesto'] = $this->Configuracion_model->ListaTipoImpuesto();
		$data_content['UniMedida'] = $this->Configuracion_model->ListaUniMedida();
		$data_content['TipOpera'] = $this->Configuracion_model->ListaTipoOperacion();
		$data_content['DatosAdicionales'] = $this->Configuracion_model->ListaDatosAdicionales();
		$data_content['DocRelacionados'] = $this->Configuracion_model->ListaDocRelacionados();		
		//$this->load->view('principal',$data_content);
		$data['contenido'] = $this->load->view('general',$data_content,true);
		$this->load->view('principal',$data);	
	}

	public function CargaDiscrepancia($CodDoc=NULL){
		//echo $this->input->get('CodDoc');
		$this->load->model(array('Configuracion_model'));
		$data_content['Discrepancias'] = $this->Configuracion_model->ListaDiscrepancias($CodDoc);
		echo  $this->load->view('Discrepancia',$data_content,TRUE);
		//$this->load->view('principal',$data_content);	
		
		
	}
}
