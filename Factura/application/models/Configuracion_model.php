<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Configuracion_model extends CI_Model
{
    public function construct()
    {
        parent::__construct();
    }
    public function ListaTipoDocumento()
	{
		$this->db->trans_begin();
		$sql="SELECT  * FROM tab_tipodocumento";
				
		$query=$this->db->query($sql);			
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return $query->result_array();	
		}			

	}
	public function ListaDocumentoIdentidad()
	{
		$this->db->trans_begin();
		$sql="SELECT  * FROM tab_documentoidentidad";				
		$query=$this->db->query($sql);			
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return $query->result_array();	
		}			

	}
	public function ListaAnticipos()
	{
		$this->db->trans_begin();
		$sql="SELECT  * FROM tab_anticipo";				
		$query=$this->db->query($sql);			
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return $query->result_array();	
		}			

	}

	/*Verificar lo de arriba*/

	public function ListaTipoPrecio()
	{
		$this->db->trans_begin();
		$sql="SELECT  * FROM tab_parametros WHERE tipparam_id=?";				
		$query=$this->db->query($sql,array(1));			
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return $query->result_array();	
		}			

	}
	public function ListaTipoImpuesto()
	{
		$this->db->trans_begin();
		$sql="SELECT  * FROM tab_parametros WHERE tipparam_id=?";				
		$query=$this->db->query($sql,array(2));			
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return $query->result_array();	
		}			

	}
	public function ListaUniMedida()
	{
		$this->db->trans_begin();
		$sql="SELECT  * FROM tab_parametros WHERE tipparam_id=?";				
		$query=$this->db->query($sql,array(3));			
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return $query->result_array();	
		}			

	}

	public function ListaTipoOperacion()
	{
		$this->db->trans_begin();
		$sql="SELECT  * FROM tab_tipoperacion ";				
		$query=$this->db->query($sql);			
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return $query->result_array();	
		}			

	}

	public function ListaDatosAdicionales()
	{
		$this->db->trans_begin();
		$sql="SELECT  * FROM tab_tipodatoadicional ";				
		$query=$this->db->query($sql);			
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return $query->result_array();	
		}			

	}
	public function ListaDocRelacionados()
	{
		$this->db->trans_begin();
		$sql="SELECT  * FROM tab_documentorelacionado ";				
		$query=$this->db->query($sql);			
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return $query->result_array();	
		}			

	}

	public function ListaDiscrepancias($CodDoc)
	{
		$this->db->trans_begin();
		$sql="SELECT  * FROM tab_tipodiscrepancias WHERE docaplica_discre=? ";				
		$query=$this->db->query($sql,array($CodDoc));			
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return $query->result_array();	
		}			

	}

	public function BuscaNumeracion($param)
	{
		$this->db->trans_begin();
		$sql="SELECT  * FROM series WHERE codsunat=?";				
		$query=$this->db->query($sql,array($param));			
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return $query->row_array();	
		}			

	}

	
	public function ActualizaNumeracion($tipoDoc,$Correl)
	{
		
		$this->db->trans_begin();
		$sql = "UPDATE series set numeracion=?	WHERE codsunat=?";
		$query = $this->db->query($sql,array($Correl,$tipoDoc));
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
		
	}

}
?>	