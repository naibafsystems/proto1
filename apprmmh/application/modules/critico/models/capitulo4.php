<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Capitulo4 extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();		
    }
	
	function obtenerCapitulo($nro_orden, $uni_local, $ano_periodo, $mes_periodo){
    	$cap4 = array();
    	$sql = "SELECT C.cap3, PS.potpsfr, PS.potperm, PS.gpper, PS.pottcde, PS.gpssde, PS.pottcag, PS.gpppta, PS.potpau, PS.gppgpa, PS.pottot, PS.gpsspot
                FROM rmmh_form_persalarios PS, rmmh_admin_control C
                WHERE PS.nro_orden = C.nro_orden
                AND PS.uni_local = C.uni_local
                AND PS.ano_periodo = C.ano_periodo
                AND PS.mes_periodo = C.mes_periodo
                AND C.nro_orden = $nro_orden
                AND C.uni_local = $uni_local
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo";				
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
      			$cap4["op"] = "update";
    			$cap4["imagen"] = $row->cap3;
    			$cap4["potpsfr"] = $row->potpsfr;
    			$cap4["potperm"] = $row->potperm;
    			$cap4["gpper"] = $row->gpper;
    			$cap4["pottcde"] = $row->pottcde;
				$cap4["gpssde"] = $row->gpssde;
				$cap4["pottcag"] = $row->pottcag;	    			      		
				$cap4["gpppta"] = $row->gpppta;
				$cap4["potpau"] = $row->potpau;
				$cap4["gppgpa"] = $row->gppgpa;	    			      		
				$cap4["pottot"] = $row->pottot;
				$cap4["gpsspot"] = $row->gpsspot;
    		}   			
   		}
   		else{
   			$cap4["op"] = "insert";
   			$cap4["imagen"] = "0";
   			$cap4["potpsfr"] = "";
    		$cap4["potperm"] = "";
    		$cap4["gpper"] = "";
    		$cap4["pottcde"] = "";
			$cap4["gpssde"] = "";
			$cap4["pottcag"] = "";	    			      		
			$cap4["gpppta"] = "";
			$cap4["potpau"] = "";
			$cap4["gppgpa"] = "";	    			      		
			$cap4["pottot"] = "";
			$cap4["gpsspot"] = "";
   		}    	
    	$this->db->close();
   		return $cap4;
    }
	
	function guardarCapitulo($nro_orden, $uni_local, $ano_periodo, $mes_periodo, $potpsfr, $potperm, $gpper, $pottcde, $gpssde, $pottcag, $gpppta, $potpau, $gppgpa, $pottot, $gpsspot){            
    	$data = array('potpsfr' => $potpsfr,
    	              'potperm' => $potperm,
    	              'gpper' => $gpper,
    	              'pottcde' => $pottcde,
    	              'gpssde' => $gpssde,
    	              'pottcag' => $pottcag,
    				  'gpppta' => $gpppta,
    	              'potpau' => $potpau,
    	              'gppgpa' => $gppgpa,
    	              'pottot' => $pottot,
    	              'gpsspot' => $gpsspot
    	);
		$this->db->where("nro_orden",   $nro_orden);
		$this->db->where("uni_local",   $uni_local);
		$this->db->where("ano_periodo", $ano_periodo);
		$this->db->where("mes_periodo", $mes_periodo);
    	$this->db->update('rmmh_form_persalarios', $data);
		$this->db->close();
    }
    
}//EOC 