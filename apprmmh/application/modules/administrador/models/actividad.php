<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* Trata con todas las actividades CIIU */

class Actividad extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
    }
    
	function obtenerActividades() {
		$actividades = array();
		$roles = "";
		$sql = "SELECT id_ciiu, nom_ciiu, num_digitos
				FROM rmmh_param_ciiu3";
		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
			$i = 0;
			foreach($query->result() as $row){
				$actividades[$i]["id"] = $row->id_ciiu;
				$actividades[$i]["nombre"] = $row->nom_ciiu;
				$i++;
			}
		}
		$this->db->close();
		return $actividades;
	}
	
	function nombreActividad($actividad){
		$nombre = "";
		$sql = "SELECT CONCAT(id_ciiu,' ',nom_ciiu) AS nombre
                FROM rmmh_param_ciiu3
                WHERE id_ciiu = $actividad";
		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
			$i=0;
			foreach($query->result() as $row){
				$nombre = $row->nombre;
			}
		}
		$this->db->close();
		return $nombre;
	}
	
	
}//EOC	