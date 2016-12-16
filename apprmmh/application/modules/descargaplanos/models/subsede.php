<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subsede extends CI_Model {
	
	function __construct(){        
        parent::__construct();
        $this->load->database();
    }
	
	function obtenerSubSedes(){
    	$subsedes = "";
    	$sql = "SELECT id_subsede, nom_subsede
			    FROM rmmh_param_subsedes
				ORDER BY nom_subsede";    	
    	$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
    		$i=0;
    		foreach($query->result() as $row){
    			$subsedes[$i]["id"] = $row->id_subsede;
    			$subsedes[$i]["nombre"] = $row->nom_subsede;
    			$i++;
    		}
    	}
    	$this->db->close();
    	return $subsedes;
    }
    
	function obtenerSubsedesID($sede) {
		$subsedes = array();
		$sql = "SELECT id_subsede, nom_subsede
                FROM rmmh_param_subsedes
                WHERE fk_sede = $sede
		        ORDER BY nom_subsede";
        $query = $this->db->query($sql);
		if ($query->num_rows()>0){
			$i = 0;
			foreach($query->result() as $row){
				$subsedes[$i]["id"] = $row->id_subsede;
				$subsedes[$i]["nombre"] = $row->nom_subsede;
				$i++;
			}
		}
		$this->db->close();
		return $subsedes;
	}
	
	function nombreSubSede($id){
		$nombre = "";
		$sql = "SELECT nom_subsede
                FROM rmmh_param_subsedes
                WHERE id_subsede = $id";
		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
			$i = 0;
			foreach($query->result() as $row){
				$nombre = utf8_decode($row->nom_subsede);				
			}
		}
		$this->db->close();
		return $nombre;
	}
	
	function obtenerSubSedesAll(){
    	$subsedes = "";
    	$sql = "SELECT id_subsede, nom_subsede
			    FROM rmmh_param_subsedes
				ORDER BY nom_subsede";
    	$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
    		$i=0;
    		foreach($query->result() as $row){
    			$subsedes[$i]["id"] = $row->id_subsede;
    			$subsedes[$i]["nombre"] = $row->nom_subsede;
    			$i++;
    		}
    	}
    	$this->db->close();
    	return $subsedes;
    }

}//EOC