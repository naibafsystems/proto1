<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rol extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
    }
    
	function obtenerRoles() {
		$roles = "";
		$sql = "SELECT id_rol, nom_rol
                FROM rmmh_param_roles
                ORDER BY nom_rol";
		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
			$i = 0;
			foreach($query->result() as $row){
				$roles[$i]["id"] = $row->id_rol;
				$roles[$i]["nombre"] = utf8_decode($row->nom_rol);
				$i++;
			}
		}
		$this->db->close();
		return $roles;
	}
	
	function nombreRol($id){
		$nombre = "";
		$sql = "SELECT nom_rol
                FROM rmmh_param_roles
                WHERE id_rol = $id";
		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
			$i = 0;
			foreach($query->result() as $row){
				$nombre = $row->nom_rol;				
			}
		}
		$this->db->close();
		return $nombre;
	}
    
}//EOC

