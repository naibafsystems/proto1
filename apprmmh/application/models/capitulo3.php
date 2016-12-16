<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Capitulo3 extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->library("session");        
    }
    
    function obtenerCapitulo(){
    	$capitulo3 = array();
    	$nro_orden = $this->session->userdata("nro_orden");
    	$uni_local = $this->session->userdata("uni_local");
    	$ano_periodo = $this->session->userdata("ano_periodo");
    	$mes_periodo = $this->session->userdata("mes_periodo");
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
   		else{
   			$capitulo3["op"] = "insert";
   			$capitulo3["imagen"] = "0";
   			$capitulo3["potpsfr"] = "";
    		$capitulo3["potperm"] = "";
    		$capitulo3["gpper"] = "";
    		$capitulo3["pottcde"] = "";
			$capitulo3["gpssde"] = "";
			$capitulo3["pottcag"] = "";	    			      		
			$capitulo3["gpppta"] = "";
			$capitulo3["potpau"] = "";
			$capitulo3["gppgpa"] = "";	    			      		
			$capitulo3["pottot"] = "";
			$capitulo3["gpsspot"] = "";
   		}    	
    	$this->db->close();
   		return $capitulo3;
    }
    
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
    
    
   
}//EOC  
