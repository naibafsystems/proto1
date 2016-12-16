<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sede extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
    }
    
	function obtenerSedes() {
		$sedes = "";
		$sql = "SELECT id_sede, nom_sede
                FROM rmmh_param_sedes
                ORDER BY nom_sede";
		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
			$i = 0;
			foreach($query->result() as $row){
				$sedes[$i]["id"] = $row->id_sede;
				$sedes[$i]["nombre"] = utf8_decode($row->nom_sede);
				$i++;
			}
		}
		$this->db->close();
		return $sedes;
	}
	
	function nombreSede($id){
		$nombre = "";
		$sql = "SELECT nom_sede
                FROM rmmh_param_sedes
                WHERE id_sede = $id";
		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
			$i = 0;
			foreach($query->result() as $row){
				$nombre = $row->nom_sede;				
			}
		}
		$this->db->close();
		return $nombre;
	}
	
}//EOC