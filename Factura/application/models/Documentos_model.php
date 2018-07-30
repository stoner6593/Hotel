<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Documentos_model extends CI_Model
{
    public function construct()
    {
        parent::__construct();
    }

    function _guardaCabecera($datos=array(),$correlativo=NULL,$codigoRespuesta=NULL,$msgRespuesta=NULL,$nombreZip=NULL,$nombre_archivo=NULL) {

    	$f=explode("/",$datos['fecharegistro']);
		$fechaRegistro=$f[2]."-".$f[0]."-".$f[1];
		$nombreZip=substr($nombreZip, 0,-4);	
		$this->db->trans_begin();
		$sql = "INSERT INTO tab_invoice (tipo_doc,num_doc,num_doc_cli,nom_cli,dir_cli,fecha_emision,gravadas,exoneradas,inafectas,gratuitas,subtotal,igv,total,estado,respuesta,nomarchivo,nompdf) 
				VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$query = $this->db->query($sql,array($datos['tipo_documento'],$correlativo,$datos['DocReceptor'],$datos['NomLegalEmisor'],$datos['DireccionEmisor'],$fechaRegistro,
										$datos['TotGravada'],$datos['TotExoneradas'],$datos['TotInafectas'],$datos['TotGratuitas'],$datos['TotGravada'],$datos['TotIgv'],$datos['TotVenta'],$codigoRespuesta,$msgRespuesta,$nombreZip,$nombre_archivo));
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}

    }

    function _guardaDetalle($datos2)
	{
		$this->db->trans_begin();
		$query=$this->db->insert_batch('tab_detalle_invoice', $datos2);					
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}	

	}
}    