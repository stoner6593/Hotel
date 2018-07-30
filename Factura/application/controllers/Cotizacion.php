<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cotizacion extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('session');
	}

	function index (){
				
					
			$data_content['estados']="";
			$data['contenido'] = $this->load->view('cotizacion',$data_content,true);
			$this->load->view('principal',$data);	
	
	}
	/*Guarda Cotización*/
	public function addCotiza()	
	{			
		
		$this->form_validation->set_rules('rucdni','RUC/DNI','required|trim|htmlspecialchars|min_length[8]|max_length[11]|is_natural');	
		$this->form_validation->set_rules('idcli','ID Cliente','required|trim|htmlspecialchars|min_length[1]|is_natural');	
		$this->form_validation->set_rules('nota','Nota','trim|htmlspecialchars|max_length[255]');	
		
	
		if($this->form_validation->run()==FALSE)
		{
			$res = array('success' =>0, 'errors' => $this->form_validation->error_array()); 					
		}else{					
				$idcli = $this->input->post("idcli");
				$nota =ucfirst($this->input->post("nota"));				
						
				
				$this->load->model('Cotizacion_model');	
				$veri_cotiza=$this->Cotizacion_model->agregarCotizacion($idcli,$nota);
						
				 if($veri_cotiza>0):
						$res = array('success' =>'Cotización Registrada', 'errors' => 0);										 
	 				else:
	 					$res = array('success' =>0, 'errors' => "No se registraron datos");										 	
				endif;
					 

		}	
		
		echo json_encode($res).$veri_cotiza; 	
		
			
	}
}
?>