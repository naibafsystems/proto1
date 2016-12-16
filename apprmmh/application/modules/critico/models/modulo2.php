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
    
    /****
    
    function insertarCapitulo($potpsfr, $potperm, $gpper, $pottcde, $gpssde, $pottcag, $gpppta, $potpau, $gppgpa, $pottot, $gpsspot){            
    	$nro_orden = $this->session->userdata("nro_orden");     //Obtener desde la sesion
    	$uni_local = $this->session->userdata("uni_local");     //Obtener desde la sesion
    	$ano_periodo = $this->session->userdata("ano_periodo"); //Obtener desde la sesion
    	$mes_periodo = $this->session->userdata("mes_periodo"); //Obtener desde la sesion
    	$data = array('nro_orden' => $nro_orden,
    	              'uni_local' => $uni_local,
    	              'ano_periodo' => $ano_periodo,
    	              'mes_periodo' => $mes_periodo,
    	              'potpsfr' => $potpsfr,
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
		$this->db->insert('rmmh_form_persalarios', $data);
		$this->db->close();
    }

	function actualizarCapitulo($potpsfr, $potperm, $gpper, $pottcde, $gpssde, $pottcag, $gpppta, $potpau, $gppgpa, $pottot, $gpsspot){            
    	$nro_orden = $this->session->userdata("nro_orden");     //Obtener desde la sesion
    	$uni_local = $this->session->userdata("uni_local");     //Obtener desde la sesion
    	$ano_periodo = $this->session->userdata("ano_periodo"); //Obtener desde la sesion
    	$mes_periodo = $this->session->userdata("mes_periodo"); //Obtener desde la sesion
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
    
	function actualizarCapituloCritico($nro_orden, $uni_local, $potpsfr, $potperm, $gpper, $pottcde, $gpssde, $pottcag, $gpppta, $potpau, $gppgpa, $pottot, $gpsspot){            
    	$ano_periodo = $this->session->userdata("ano_periodo"); //Obtener desde la sesion
    	$mes_periodo = $this->session->userdata("mes_periodo"); //Obtener desde la sesion
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
    
    
    public function obtenerInfoCapitulo($nro_orden, $uni_local){
    	$capitulo3 = array(
    	  'op'=>'',
    	  'imagen'=>0,
    	  'potpsfr'=>'',
    	  'potperm'=>'',
    	  'gpper'=>'',
    	  'pottcde'=>'',
    	  'gpssde'=>'',
    	  'pottcag'=>'',
    	  'gpppta'=>'',
    	  'potpau'=>'',
    	  'gppgpa'=>'',
    	  'pottot'=>'',
    	  'gpsspot'=>''
    	);
    	$ano_periodo = $this->session->userdata("ano_periodo");
    	$mes_periodo = $this->session->userdata("mes_periodo");
    	$sql = "SELECT *
				FROM rmmh_form_persalarios C3, rmmh_admin_control CTRL
				WHERE C3.nro_orden = CTRL.nro_orden
				AND C3.uni_local = CTRL.uni_local
				AND C3.ano_periodo = CTRL.ano_periodo
				AND C3.mes_periodo = CTRL.mes_periodo
				AND CTRL.nro_orden = $nro_orden
				AND CTRL.uni_local = $uni_local
				AND CTRL.ano_periodo = $ano_periodo
				AND CTRL.mes_periodo = $mes_periodo";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
      			$capitulo3["op"] = "update";
    			$capitulo3["imagen"] = $row->cap3;
    			$capitulo3["potpsfr"] = $row->potpsfr;
    			$capitulo3["potperm"] = $row->potperm;
    			$capitulo3["gpper"] = $row->gpper;
    			$capitulo3["pottcde"] = $row->pottcde;
				$capitulo3["gpssde"] = $row->gpssde;
				$capitulo3["pottcag"] = $row->pottcag;	    			      		
				$capitulo3["gpppta"] = $row->gpppta;
				$capitulo3["potpau"] = $row->potpau;
				$capitulo3["gppgpa"] = $row->gppgpa;	    			      		
				$capitulo3["pottot"] = $row->pottot;
				$capitulo3["gpsspot"] = $row->gpsspot;	     			
    		}   			
   		}
   		$this->db->close();
   		return $capitulo3;
    }
    
    ********/
    
    
   
}//EOC  
