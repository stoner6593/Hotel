<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cliente extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('session');
	}
	public $upload_path = "./gallery/picture/";
	public $upload_path_thumb = "./gallery/picture/thumb/"; 
	
	function index (){
				
			//$data_content['estados']=$this->ver_parametros->cargaestados(); 					
			$data_content['estados']="";
			$data['contenido'] = $this->load->view('cliente',$data_content,true);
			$this->load->view('principal',$data);	
	
	}
	public function busca_cli_dni($dniruc=null)	
	{	
		try{
			if($dniruc)
			{
				$this->load->model('Cliente_model');
				$cant=$this->Cliente_model->buscli_dni($dniruc);
				$nombre="";				
				if($cant):					
					$nombre=$cant['cli_razonsocial'];
					$data=array("success"=>2,"errors"=>"El cliente: <b>".$nombre." </b> ya se encuentra registrado");					
				else:			
					$this->load->library('Sunat');				
					$this->load->library('Rutificador');
					if(strlen($dniruc)==11):					
						$dato=$this->sunat->BuscaDatosSunat($dniruc);
						if(count($dato)>0):
							$data=array("success"=> $this->sunat->BuscaDatosSunat($dniruc),"errors"=>0); 
						else:
							$data=array("success"=> 2,"errors"=>"No se encontraron registros..!"); //2 error
						endif;
					elseif(strlen($dniruc)==8):
						$dato=$this->rutificador->BuscaDatosRutificador($dniruc);
						if(count($dato)>0):
							$data=array("success"=> $dato,"errors"=>1); 
						else:
							$data=array("success"=> 1,"errors"=>$dato); 
						endif;
					endif;	
				endif;
			
			}else{
				//show_404();	
			}
			echo json_encode($data);
		}		
		catch(Exception $e)
		{	$data=array("success"=> 1,"errors"=>$e->getMessage()); 		
			echo json_encode($data);			
			//log_message( 'error', $e->getMessage( ) . ' in ' . $e->getFile() . ':' . $e->getLine() );
		}
				
	}
	
	public function busca_cli_dni2($dniruc=null)	
	{					 
		$this->load->model('Cliente_model');
		$cant=$this->Cliente_model->buscli_dni($dniruc);		
		
		if($cant):	
			$data=array("success"=>$cant,"errors"=>0);			
		else:					
			$data=array("success"=>0,"errors"=>"Cliente no regisrado");			
		endif;	
			
		echo json_encode($data);
			
	}
	
	
	/*Método para Agregar Clientes*/
	public function addcliente()	
	{			
		
		$this->form_validation->set_rules('rucdni','RUC/DNI','required|trim|htmlspecialchars|min_length[8]|max_length[11]|is_natural');	
		$this->form_validation->set_rules('razon_social','Razón Social','required|trim|htmlspecialchars|min_length[3]|max_length[150]');	
		$this->form_validation->set_rules('direccion','Dirección','trim|htmlspecialchars|min_length[5]|max_length[200]');
		$this->form_validation->set_rules('mail','E-mail','trim|required|valid_email');		
		$this->form_validation->set_rules('telefono','Teléfono','trim');
		$this->form_validation->set_rules('contacto','Contacto ','trim');
		$this->form_validation->set_rules('telefono_contacto','Teléfono Contacto','trim');				
		$this->form_validation->set_rules('correo_contacto','Correo Contacto','trim|valid_email');
	
		if($this->form_validation->run()==FALSE)
		{
			$res = array('success' =>0, 'errors' => $this->form_validation->error_array()); 					
		}else{					
				$rucdni = $this->input->post("rucdni");
				$razon_social =ucfirst($this->input->post("razon_social"));				
				$direccion = ucfirst($this->input->post("direccion"));						
				$mail = $this->input->post("mail");
				$telefono = $this->input->post("telefono");
				$contacto = $this->input->post("contacto");
				$telefono_contacto = $this->input->post("telefono_contacto");
				$correo_contacto = $this->input->post("correo_contacto");				
				
				$this->load->model('Cliente_model');	
				$veri_cliente=$this->Cliente_model->agregarcliente($rucdni,$razon_social,
				$direccion,$telefono,$mail,$contacto,$telefono_contacto,$correo_contacto);
						
				 if($veri_cliente):
					$res = array('success' =>'Cliente Registrado', 'errors' => 0);										 
	 
				endif;
					 

		}	
		
		echo json_encode($res); 	
			
	}
	

	public function modicliente()	
	{	
					
		$this->form_validation->set_rules('idcli','ID','required|trim|htmlspecialchars|is_natural');
		$this->form_validation->set_rules('rucdni','RUC/DNI','required|trim|htmlspecialchars|min_length[8]|max_length[11]|is_natural');	
		$this->form_validation->set_rules('razon_social','Razón Social','required|trim|htmlspecialchars|min_length[3]|max_length[150]');	
		$this->form_validation->set_rules('direccion','Dirección','trim|htmlspecialchars|min_length[5]|max_length[200]');
		$this->form_validation->set_rules('mail','E-mail','trim|required|valid_email');		
		$this->form_validation->set_rules('telefono','Teléfono','trim');
		$this->form_validation->set_rules('contacto','Contacto ','trim');
		$this->form_validation->set_rules('telefono_contacto','Teléfono Contacto','trim');				
		$this->form_validation->set_rules('correo_contacto','Correo Contacto','trim|valid_email');
		$this->form_validation->set_rules('estado','Estado','trim');
		
		if($this->form_validation->run()==FALSE)
		{
			$res = array('success' =>0, 'errors' => $this->form_validation->error_array());  
			
		}else{
				$idcli = $this->input->post("idcli");
				$rucdni = $this->input->post("rucdni");
				$razon_social =ucfirst($this->input->post("razon_social"));				
				$direccion = ucfirst($this->input->post("direccion"));						
				$mail = $this->input->post("mail");
				$telefono = $this->input->post("telefono");
				$contacto = $this->input->post("contacto");
				$telefono_contacto = $this->input->post("telefono_contacto");
				$correo_contacto = $this->input->post("correo_contacto");		
				$estado = $this->input->post("estado")? "AC" : "IN";		
																
				$this->load->model('Cliente_model');
				$bus_cli=$this->Cliente_model->buscli_modi($idcli);
				
				if($bus_cli){
					
					$veri_cliente=$this->Cliente_model->modificacliente($idcli,$rucdni,$razon_social,$direccion,$telefono,$mail,$contacto,$telefono_contacto,$correo_contacto,$estado);
					$entityBody = file_get_contents('php://input');			
					if($veri_cliente):
						$res = array('success' =>'Cliente Modificado', 'errors' => 0);										 
			 
					else:
						$res = array('success' =>0, 'errors' => 'Error al modificar cliente');	
					endif;							
				}else{
					$res = array('success' =>0, 'errors' => 'Error al modificar cliente');	
				}
				
				
						 

		}	
		
		echo json_encode($res); 	
			

		
	}
	
	public function listar_cliente($estado)	
	{	
				
		$this->load->model('Cliente_model');			
		$res=$this->Cliente_model->listacliente($estado);
		$variable = array();
		$i=0;	
		if($res):
			foreach($res as $row)
			{	
				$variable[$i][]=$row['id'];
				$variable[$i][]=$row['cli_numdoc'];		
				$variable[$i][]=$row['cli_razonsocial'];	
				$variable[$i][]=$row['cli_direccion']."<br> <a href='#'><i class='fa fa-phone'></i></a> ".$row['cli_telefono']."<br> <a href='#'><i class='fa fa-envelope'></i></a> ".$row['cli_correo'];
				$variable[$i][]=$row['cli_estado'];				
				$variable[$i][]='<a title="Modificar Cliente" data-id-cliente="'.$row['id'].'" id="modifi_cli" class="badge badge-info  "><i class="fa fa-edit"></i></a>';
				//$variable[$i][]="ELIMINA";
			  
				$i++;
			}
		endif;		
		$total['aaData']=$variable;
		echo json_encode($total);
		
			
	}
	
	public function busca_modi_cli($id=null)	
	{			
			
		$this->load->model(array('Cliente_model'));
		$cant=$this->Cliente_model->buscli_modi($id);		
		//$contenido = $this->load->view('personal_modi',$data_content,true);
		if($cant):
			$res = array('success' =>$cant, 'errors' => 0);		
		else:
			$res = array('success' =>0, 'errors' => "No hay registros para el ID: ".$id);		
		endif;	
		echo json_encode($res);
			
	}
	
	public function _upload_picture( $src_name ){
		$config['upload_path'] = $this->upload_path;
		$config['allowed_types'] = 'gif|jpg|png|bmp|jpeg';  
		//$config['max_size']  = '12288';  
		$config['max_size']  = '12288000';  
		$config['max_width']  = '0';  
		$config['max_height']  = '0'; 
		$config['file_name']  = sha1( time() . mt_rand() ); 
		$this->load->library('upload', $config); 

		if ( ! $this->upload->do_upload($src_name)){
			$error = array('error' => $this->upload->display_errors('', '<br/>'));
			return $error;
		}else{
			$data = $this->upload->data();
			if($data['is_image'] == 1) {  
				$this->load->helper("imagenes_helper");
				redimensionar( $data['full_path'], 1024, 768, false);
				redimensionar( $data['full_path'], 76, 76, true, $this->upload_path_thumb );
				return $data;
			}else{
				$error = array('error' => $this->upload->display_errors('', '<br/>'));
				return $error;
			}
		}
	}
	
	

	
}