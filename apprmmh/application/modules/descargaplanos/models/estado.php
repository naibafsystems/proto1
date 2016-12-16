<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Estado extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->library("session");
        $this->load->helper("url");
    }
    
    function nombreEstado($estado){
    	$nombre = "";
    	$sql = "SELECT CONCAT(id_estado,' - ',nom_estado) AS nombre
                FROM rmmh_param_estados
                WHERE id_estado = $estado";
    	$query = $this->db->query($sql);
   		if ($query->num_rows()>0){
			foreach($query->result() as $row){
				$nombre = $row->nombre;
			}
		}
		$this->db->close();
		return $nombre;
    	
    }
    
   	 
    
} //EOC   	