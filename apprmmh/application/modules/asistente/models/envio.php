<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Envio extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
    }
	
	function obtenerEnvio($nro_orden, $uni_local, $ano_periodo, $mes_periodo){
    	$envio = array();
    	$sql = "SELECT C.envio, EF.observaciones, EF.dmpio, EF.fedili, EF.repleg, EF.responde, EF.respoca, EF.teler, EF.emailr
			    FROM rmmh_form_envioform EF, rmmh_admin_control C
				WHERE EF.nro_orden = C.nro_orden
			    AND EF.uni_local = C.uni_local
				AND EF.ano_periodo = C.ano_periodo
				AND EF.mes_periodo = C.mes_periodo
				AND C.nro_orden = $nro_orden
				AND C.uni_local = $uni_local
				AND C.ano_periodo = $ano_periodo
				AND C.mes_periodo = $mes_periodo";    	    	
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
      			$envio["op"] = "update";
    			$envio["imagen"] = $row->envio;
    			$envio["observaciones"] = utf8_decode($row->observaciones);
    			$envio["dmpio"] = utf8_decode($row->dmpio);
    			$envio["fedili"] = $this->general->formatoFecha($row->fedili,'-'); 
    			$envio["repleg"] = utf8_decode($row->repleg);
				$envio["responde"] = utf8_decode($row->responde);
				$envio["respoca"] = utf8_decode($row->respoca);	    			      		
				$envio["teler"] = $row->teler;
				$envio["emailr"] = $row->emailr;
    		}   			
   		}
   		else{
   				$envio["op"] = "insert";
    			$envio["imagen"] = "0";
    			$envio["observaciones"] = "";
    			$envio["dmpio"] = "";
    			$envio["fedili"] = "";
    			$envio["repleg"] = "";
				$envio["responde"] = "";
				$envio["respoca"] = "";	    			      		
				$envio["teler"] = "";
				$envio["emailr"] = "";
   		}    	
    	$this->db->close();
   		return $envio;
    }
	
	function validarEnvio($nro_orden, $uni_local, $ano_periodo, $mes_periodo){
    	$result = false;
    	$estados = array();
    	$sql = "SELECT caratula, cap1, cap2, cap3, cap4
                FROM rmmh_admin_control
                WHERE nro_orden = $nro_orden
                AND uni_local = $uni_local
                AND ano_periodo = $ano_periodo
                AND mes_periodo = $mes_periodo";    	
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
      			$estados[0] = $row->caratula; 
    			$estados[1] = $row->cap1;  
    			$estados[2] = $row->cap2;  
    			$estados[3] = $row->cap3;  
    			$estados[4] = $row->cap4;  
    		}
    		$this->db->close();
   			for ($i=0; $i<count($estados);$i++){
    			if ($estados[$i]==2){
    				$result = true;    			
    			}
    			else{
    				$result = false;
    				break;
    			}
    		}
    	}
    	return $result;
    }
	
	function guardarEnvio($nro_orden, $uni_local, $ano_periodo, $mes_periodo, $fteObserv, $dmpio, $fedili, $repleg, $responde, $respoca, $teler, $emailr){            
    	$data = array('nro_orden' => $nro_orden,
    	              'uni_local' => $uni_local,
    	              'ano_periodo' => $ano_periodo,
    	              'mes_periodo' => $mes_periodo,
    	              'observaciones' => $fteObserv,
    	              'dmpio' => $dmpio,
    	              'fedili' => $fedili,
    	              'repleg' => $repleg,
    	              'responde' => $responde,
    	              'respoca' => $respoca,
    	              'teler' => $teler,
    	              'emailr' => $emailr
    	);
		$this->db->insert('rmmh_form_envioform', $data);
		$this->db->close();		
    }
	

    
}//EOC   