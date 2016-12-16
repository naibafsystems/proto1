<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Capitulo2 extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();		
    }
    
    function obtenerCapitulo($nro_orden, $uni_local, $ano_periodo, $mes_periodo){
    	$cap2 = array();
    	$sql = "SELECT C.cap1, MV.esini, MV.esape, MV.escie, MV.estot
				FROM rmmh_form_movmensual MV, rmmh_admin_control C
                WHERE MV.nro_orden = C.nro_orden
                AND   MV.uni_local = C.uni_local
                AND   MV.ano_periodo = C.ano_periodo
                AND   MV.mes_periodo = C.mes_periodo
                AND   C.nro_orden = $nro_orden
                AND   C.uni_local = $uni_local
                AND   C.ano_periodo = $ano_periodo
                AND   C.mes_periodo = $mes_periodo";        
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
      			$cap2["op"] = "update";
    			$cap2["imagen"] = $row->cap1;
    			$cap2["esini"] = $row->esini;
    			$cap2["esape"] = $row->esape;
    			$cap2["escie"] = $row->escie;
    			$cap2["estot"] = $row->estot;    			
    		}   			
   		}
   		else{
   			$cap2["op"] = "insert";
   			$cap2["imagen"] = "0";
   			$cap2["esini"] = "";
   			$cap2["esape"] = "";
   			$cap2["escie"] = "";
   			$cap2["estot"] = "";   			
   		}    	
    	$this->db->close();
   		return $cap2;
    }
	
	function guardarCapitulo($nro_orden, $uni_local, $ano_periodo, $mes_periodo, $esini, $esape, $escie, $estot){            
    	$data = array('esini' => $esini,
    	              'esape' => $esape,
    	              'escie' => $escie,
    	              'estot' => $estot
    	);
		$this->db->where("nro_orden",   $nro_orden);
		$this->db->where("uni_local",   $uni_local);
		$this->db->where("ano_periodo", $ano_periodo);
		$this->db->where("mes_periodo", $mes_periodo);
    	$this->db->update('rmmh_form_movmensual', $data);
		$this->db->close();
    }
	
	
    
    
}//EOC        
   