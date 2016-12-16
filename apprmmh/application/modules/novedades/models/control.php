<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Control extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
    }
    
    function obtenerNovedadEstado($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$datos = array();
    	$sql = "SELECT fk_novedad, fk_estado
                FROM rmmh_admin_control
                WHERE nro_orden = $nro_orden
                AND nro_establecimiento = $nro_establecimiento
                AND ano_periodo = $ano_periodo
                AND mes_periodo = $mes_periodo";
    	$query = $this->db->query($sql);
		if ($query->num_rows()>0){
			foreach ($query->result() as $row){
      			$datos["novedad"] = $row->fk_novedad;
				$datos["estado"] = $row->fk_estado;	
      		}
		}
		$this->db->close();
		return $datos;
    }
    
	function actualizarNovedad($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $novedad){
    	$data = array('fk_novedad' => $novedad, 
    	              'fk_estado' => 5);
		$this->db->where("nro_orden", $nro_orden);
		$this->db->where("nro_establecimiento", $nro_establecimiento);
		$this->db->where("ano_periodo", $ano_periodo);
		$this->db->where("mes_periodo", $mes_periodo);
		$this->db->update("rmmh_admin_control",$data);
    }
    
	function actualizarNovedadEstado($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $novedad, $estado){
    	$data = array('fk_novedad' => $novedad,
		              'fk_estado' => $estado  
		        );
		$this->db->where("nro_orden", $nro_orden);
		$this->db->where("nro_establecimiento", $nro_establecimiento);
		$this->db->where("ano_periodo", $ano_periodo);
		$this->db->where("mes_periodo", $mes_periodo);
		$this->db->update("rmmh_admin_control",$data);
    }
    
}//EOC