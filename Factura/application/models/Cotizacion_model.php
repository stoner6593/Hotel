<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cotizacion_model extends CI_Model
{
    public function construct()
    {
        parent::__construct();
    }

    /*Agrega  Cotizacioón*/
	public function agregarCotizacion($idcli,$nota)
	{
	
		$estado='AC';
		$f=(date("Y-m-d"));
		
		$this->db->trans_begin();
		$sql = "INSERT INTO tab_cotizacion (cli_id,fecha_registro,sub_total,igv,total,nota,estado) VALUES(?,?,?,?,?,?,?)";
		$query = $this->db->query($sql,array($idcli,$f,120,150,200,$nota,$estado));
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			//return $this->db->insert_id();
			$query = $this->db->query('SELECT LAST_INSERT_ID()');
			$row = $query->row_array();
			return $row['LAST_INSERT_ID()'];
		}
				
	}
}
?>