<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modulo3 extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->library("session");        
    }
    
    function obtenerModulo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$modulo3 = array();
    	$sql = "SELECT C.modulo3, IO.inalo, IO.inali, IO.inba, IO.insr, IO.inoe, IO.inoio, IO.intio
                FROM rmmh_form_ingoperacionales IO, rmmh_admin_control C
                WHERE IO.nro_orden = C.nro_orden
                AND IO.nro_establecimiento = C.nro_establecimiento
                AND IO.ano_periodo = C.ano_periodo
                AND IO.mes_periodo = C.mes_periodo
                AND C.nro_orden = $nro_orden
                AND C.nro_establecimiento = $nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
      			$modulo3["op"] = "update";
    			$modulo3["imagen"] = $row->modulo3;
    			$modulo3["inalo"] = $row->inalo;
    			$modulo3["inali"] = $row->inali;
    			$modulo3["inba"] = $row->inba;
    			$modulo3["insr"] = $row->insr;
    			$modulo3["inoe"] = $row->inoe;
				$modulo3["inoio"] = $row->inoio;
				$modulo3["intio"] = $row->intio;	    			      		
    		}   			
   		}
   		else{
   			$modulo3["op"] = "insert";
   			$modulo3["imagen"] = "0";
   			$modulo3["inalo"] = "";
   			$modulo3["inali"] = "";
   			$modulo3["inba"] = "";
   			$modulo3["inoe"] = "";
   			$modulo3["inoio"] = "";
   			$modulo3["intio"] = "";
   		}    	
    	$this->db->close();
   		return $modulo3;   		
    }
    
    function actualizarModulo($inalo, $inali, $inba, $insr, $inoe, $inoio, $intio, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$data = array('inalo' => $inalo, 
    	              'inali' => $inali, 
    	              'inba' => $inba, 
    			      'insr' => $insr,
    	              'inoe' => $inoe, 
    	              'inoio' => $inoio, 
    	              'intio' => $intio);
    	$this->db->where("nro_orden",   $nro_orden);
		$this->db->where("nro_establecimiento",$nro_establecimiento);
		$this->db->where("ano_periodo", $ano_periodo);
		$this->db->where("mes_periodo", $mes_periodo);
    	$this->db->update('rmmh_form_ingoperacionales', $data);
		$this->db->close();
    }
    
    function insertarModulo($inalo, $inali, $inba, $insr, $inoe, $inoio, $intio, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$data = array('inalo' => $inalo, 
    	              'inali' => $inali,
    	              'inba' => $inba,
    			      'insr' => $insr,
    	              'inoe' => $inoe,
    	              'inoio' => $inoio,
    	              'intio' => $intio,
    	              'nro_orden' => $nro_orden,
    	              'nro_establecimiento' => $nro_establecimiento,
    	              'ano_periodo' => $ano_periodo,
    	              'mes_periodo' => $mes_periodo);
    	$this->db->insert('rmmh_form_ingoperacionales', $data);
		$this->db->close();
    }
    
	function existeRegistro($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$retorno = false;
    	$sql = "SELECT * 
    	        FROM rmmh_form_ingoperacionales 
    	        WHERE nro_orden = $nro_orden
    	        AND nro_establecimiento = $nro_establecimiento
    	        AND ano_periodo = $ano_periodo
    	        AND mes_periodo = $mes_periodo";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0)
    		$retorno = true;
    	return $retorno;	
    }
    
    
   
    
    
   
}//EOC  