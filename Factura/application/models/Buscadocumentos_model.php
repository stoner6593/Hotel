<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Buscadocumentos_model extends CI_Model
{
    public function construct()
    {
        parent::__construct();
    }

    

    function _buscaDocumentos($docCliente,$tipDocumento,$numDocumento,$fechaEnvio)
	{
		$f=explode("-",$fechaEnvio);
		$fe=$f[2].'-'.$f[0].'-'.$f[1];
		
		$datos = array($fe);
		$continue = "";
		if($docCliente!=''):			
			$continue.=" AND a.num_doc_cli=? ";
			$datos=array($fe,$docCliente);
		endif;	
		//echo $tipDocumento.'aa';
		if($tipDocumento!=''):
			$continue.=" AND a.tipo_doc=? ";
			//$datos=array($fe,$tipDocumento);
		array_push($datos, $tipDocumento);
		endif;	

		if($numDocumento!=''):			
			$continue.=" AND a.num_doc=? ";
			//$datos=array($fe,$numDocumento);
			array_push($datos, $numDocumento);
		endif;	

		$this->db->trans_begin();
		$sql="SELECT a.num_doc_cli,a.nom_cli,a.num_doc,a.total,a.estado,a.respuesta,a.nomarchivo,a.nompdf
			FROM tab_invoice a INNER JOIN tab_detalle_invoice b ON a.num_doc=b.num_doc
			WHERE a.fecha_emision=? ".$continue;
				
		$query=$this->db->query($sql,$datos);			
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return $query->result_array();	
		}		

	}
}    