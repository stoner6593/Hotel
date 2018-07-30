<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cliente_model extends CI_Model
{
    public function construct()
    {
        parent::__construct();
    }
    
		/*Listar Personal*/
	
	public function listacliente($estado)
	{
		$this->db->trans_begin();
		$sql="select * from tab_clientes where  cli_estado=?  ";
		$query=$this->db->query($sql,array($estado));			
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return $query->result_array();	
		}			

	}
	
	public function buscli_modi($id)
	{	
		$this->db->trans_begin();
		$sql="select * from tab_clientes where  id=?  ";
		$query=$this->db->query($sql,($id));
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return $query->row_array();						
		}	
	}
	
	public function buscli_dni($dni)
	{
		$this->db->trans_begin();
		$sql="select * from tab_clientes where  cli_estado=? and cli_numdoc=?  ";
		$query=$this->db->query($sql,array('AC',$dni));
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return $query->row_array();
			//return $query->num_rows();					
		}		

	}
	
	public function busper_user($user)
	{
		$this->db->trans_begin();
		$sql="select * from tab_personal where  per_estado=? and usu_usuario=?  ";
		$query=$this->db->query($sql,array('AC',$user));
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return $query->row_array();
			//return $query->num_rows();					
		}	

	}
	
	public function busper_user2($idper)
	{
		$this->db->trans_begin();
		$sql="select * from tab_personal where  per_estado=? and per_id=?  ";
		$query=$this->db->query($sql,array('AC',$idper));
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return $query->row_array();
			//return $query->num_rows();					
		}	

	}
	
	
	/*Agrega  Cliente*/
	public function agregarcliente($rucdni,$razon_social,$direccion,$telefono,$mail,$contacto,$telefono_contacto,$correo_contacto)
	{
	
		$estado='AC';		
		$this->db->trans_begin();
		$sql = "INSERT INTO tab_clientes (cli_numdoc,cli_razonsocial ,cli_direccion,cli_telefono ,cli_correo,cli_contacto,cli_contactotelef,cli_contactocorreo,
			cli_estado) VALUES(?,?,?,?,?,?,?,?,?)";
		$query = $this->db->query($sql,array($rucdni,$razon_social,$direccion,$telefono,$mail,$contacto,$telefono_contacto,$correo_contacto,$estado));
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
				
	}
	
	/*Modificar Cliente*/
	public function modificacliente($idcli,$rucdni,$razon_social,$direccion,$telefono,$mail,$contacto,$telefono_contacto,$correo_contacto,$estado)
	{				
		$this->db->trans_begin();
		$sql="UPDATE tab_clientes SET cli_numdoc=?,cli_razonsocial=?,cli_direccion=?,cli_telefono=?,cli_correo=?,cli_contacto=?,
			cli_contactotelef=?,cli_contactocorreo=?,cli_estado=? WHERE id=?"	;			
		$query = $this->db->query($sql,array($rucdni,$razon_social,$direccion,$telefono,$mail,$contacto,$telefono_contacto,$correo_contacto,$estado,$idcli));
		
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}		
		
	
	}
	

	
}

