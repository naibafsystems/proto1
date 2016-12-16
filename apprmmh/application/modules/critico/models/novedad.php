<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Novedad extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->library("session");
        $this->load->helper("url");
    }
    
   	function buscarNovedades($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
   		$result = false;
   		$sql = "SELECT COUNT(*) AS num
				FROM rmmh_admin_histnovedades
				WHERE nro_orden = $nro_orden
				AND nro_establecimiento = $nro_establecimiento
				AND ano_periodo = $ano_periodo
				AND mes_periodo = $mes_periodo";
   		$query = $this->db->query($sql);
   		if ($query->num_rows()>0){
			foreach($query->result() as $row){
				$num = $row->num;
			}
		}
		$this->db->close();
		
		if ($num>0){
			$result = '<img src="'.base_url("/images/exclam.png").'"/>';			
		}
		else{
			$result = "";
		}
		return $result;
   	}	
    
} //EOC   	