<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configuracion extends CI_Controller {

	public function __construct()
	{
		parent::__construct();		
	
	}
	public function index()
	{
		//$this->load->view('principal');
	}

	public function BuscaRuc(){
		/*$doc = $this->input->get("doc");
		if(strlen($doc)==11):
			$ruc = "10479617967";
	        // Creo la url con la direccion del servicio y sus parametros
	        $dir = "https://sunapiperu.com/api_qa/contribuyente?apikey=sunapi&ruc=".$doc."";
	        //$dir = "https://sunapiperu.com/api/contribuyente?ruc=".$doc."&apikey=6nx5ck4mtg5gxxyja9vl41zoqvvllsqn93l380tt1";
	        // Obtengo el resultado del servicio en formato json
	        $dir_json = file_get_contents($dir);
	        // Convierto la cadena json en un array php de objetos json
	        $dir_array = json_decode($dir_json,true);
	        //var_dump($dir_array);
	        $array=array("success"=>$dir_array,"errors"=>0); 
	    else:
	    	$array=array("success"=>0,"errors"=>"Longitud de RUC es incorrecta");
	    endif;  
	    echo json_encode($array);*/

	    $this->load->library('Sunat');
	    $doc = $this->input->get("doc");
	    if(strlen($doc)==11):
	    	//echo json_encode( $this->sunat->BuscaDatosSunat($doc) );
			$dato=$this->sunat->BuscaDatosSunat($doc);
			if(count($dato)>0):
				$array=array("success"=> $this->sunat->BuscaDatosSunat($doc),"errors"=>0); 
			else:
				$array=array("success"=> 0,"errors"=>"No se encontraron registros..!"); 
			endif;
	    endif;
		
			
	      // $dir_array= $this->sunat->BuscaDatosSunat($doc);
	       
		echo json_encode($array);
	      //echo $doc;
	     
	   
	}
}
//https://sunapiperu.com/api/contribuyente?ruc=10479617967&apikey=6nx5ck4mtg5gxxyja9vl41zoqvvllsqn93l380tt
//https://sunapiperu.com/api/contribuyente?ruc=10479617967&apikey=6nx5ck4mtg5gxxyja9vl41zoqvvllsqn93l380tt