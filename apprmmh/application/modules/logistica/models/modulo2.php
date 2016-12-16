<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modulo2 extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->library("session");        
    }
    
    function obtenerModulo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$modulo2 = array();
    	$sql = "SELECT C.modulo2, C.nro_orden, C.nro_establecimiento, PS.potpsfr, PS.potperm, PS.gpper, PS.pottcde, PS.gpssde, PS.pottcag, PS.gpppta, PS.potpau, PS.gppgpa, PS.pottot, PS.gpsspot
                FROM rmmh_form_persalarios PS, rmmh_admin_control C
                WHERE PS.nro_orden = C.nro_orden
                AND PS.nro_establecimiento = C.nro_establecimiento
                AND PS.ano_periodo = C.ano_periodo
                AND PS.mes_periodo = C.mes_periodo
                AND C.nro_orden = $nro_orden
                AND C.nro_establecimiento = $nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo";    	   	
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
      			$modulo2["op"] = "update";
    			$modulo2["imagen"] = $row->modulo2;    			
    			$modulo2["potpsfr"] = $row->potpsfr;
    			$modulo2["potperm"] = $row->potperm;
    			$modulo2["gpper"] = $row->gpper;
    			$modulo2["pottcde"] = $row->pottcde;
				$modulo2["gpssde"] = $row->gpssde;
				$modulo2["pottcag"] = $row->pottcag;	    			      		
				$modulo2["gpppta"] = $row->gpppta;
				$modulo2["potpau"] = $row->potpau;
				$modulo2["gppgpa"] = $row->gppgpa;	    			      		
				$modulo2["pottot"] = $row->pottot;
				$modulo2["gpsspot"] = $row->gpsspot;
    		}   			
   		}
   		else{
   			$modulo2["op"] = "insert";
   			$modulo2["imagen"] = "0";
   			$modulo2["potpsfr"] = "";
    		$modulo2["potperm"] = "";
    		$modulo2["gpper"] = "";
    		$modulo2["pottcde"] = "";
			$modulo2["gpssde"] = "";
			$modulo2["pottcag"] = "";	    			      		
			$modulo2["gpppta"] = "";
			$modulo2["potpau"] = "";
			$modulo2["gppgpa"] = "";	    			      		
			$modulo2["pottot"] = "";
			$modulo2["gpsspot"] = "";
   		}    	
    	$this->db->close();
   		return $modulo2;   		   		
    }
    
    function actualizarModulo($potpsfr, $potperm, $gpper, $pottcde, $gpssde, $pottcag, $gpppta, $potpau, $gppgpa, $pottot, $gpsspot, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
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
    	              'gpsspot' => $gpsspot);
    	$this->db->where("nro_orden",   $nro_orden);
		$this->db->where("nro_establecimiento",$nro_establecimiento);
		$this->db->where("ano_periodo", $ano_periodo);
		$this->db->where("mes_periodo", $mes_periodo);
    	$this->db->update('rmmh_form_persalarios', $data);
		$this->db->close();
    }
    
    function insertarModulo($potpsfr, $potperm, $gpper, $pottcde, $gpssde, $pottcag, $gpppta, $potpau, $gppgpa, $pottot, $gpsspot, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
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
    	              'gpsspot' => $gpsspot, 
    	              'nro_orden' => $nro_orden, 
    	              'nro_establecimiento' => $nro_establecimiento, 
    	              'ano_periodo' => $ano_periodo, 
    	              'mes_periodo' => $mes_periodo);
    	$this->db->insert('rmmh_form_persalarios', $data);
		$this->db->close();
    }
    
    function existeRegistro($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$retorno = false;
    	$sql = "SELECT * 
    	        FROM rmmh_form_persalarios 
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
