<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Capitulo3 extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();		
    }
    
    function obtenerCapitulo($nro_orden, $uni_local, $ano_periodo, $mes_periodo){
    	$cap3 = array();
    	$sql = "SELECT C.cap2, IO.inalo, IO.inali, IO.inba, IO.inoe, IO.inoio, IO.intio
                FROM rmmh_form_ingoperacionales IO, rmmh_admin_control C
                WHERE IO.nro_orden = C.nro_orden
                AND IO.uni_local = C.uni_local
                AND IO.ano_periodo = C.ano_periodo
                AND IO.mes_periodo = C.mes_periodo
                AND C.nro_orden = $nro_orden
                AND C.uni_local = $uni_local
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
      			$cap3["op"] = "update";
    			$cap3["imagen"] = $row->cap2;
    			$cap3["inalo"] = $row->inalo;
    			$cap3["inali"] = $row->inali;
    			$cap3["inba"] = $row->inba;
    			$cap3["inoe"] = $row->inoe;
				$cap3["inoio"] = $row->inoio;
				$cap3["intio"] = $row->intio;	    			      		
    		}   			
   		}
   		else{
   			$cap3["op"] = "insert";
   			$cap3["imagen"] = "0";
   			$cap3["inalo"] = "";
   			$cap3["inali"] = "";
   			$cap3["inba"] = "";
   			$cap3["inoe"] = "";
   			$cap3["inoio"] = "";
   			$cap3["intio"] = "";
   		}    	
    	$this->db->close();
   		return $cap3;
    }
	
	function guardarCapitulo($nro_orden, $uni_local, $ano_periodo, $mes_periodo, $inalo, $inali, $inba, $inoe, $inoio, $intio){            
    	$data = array('inalo' => $inalo,
    	              'inali' => $inali,
    	              'inba' => $inba,
    	              'inoe' => $inoe,
    	              'inoio' => $inoio,
    	              'intio' => $intio
    	);
		$this->db->where("nro_orden",   $nro_orden);
		$this->db->where("uni_local",   $uni_local);
		$this->db->where("ano_periodo", $ano_periodo);
		$this->db->where("mes_periodo", $mes_periodo);
    	$this->db->update('rmmh_form_ingoperacionales', $data);
		$this->db->close();
    }
    
}//EOC        
   