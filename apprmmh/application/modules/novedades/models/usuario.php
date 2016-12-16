<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->library("danecrypt");
        $this->load->library("paginador2");
    }
    
 	function obtenerRolUsuario($id){
    	$rol = 1;
      	$sql = "SELECT fk_rol
                FROM rmmh_admin_usuarios
                WHERE id_usuario = $id";
      	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach($query->result() as $row){
    			$rol = $row->fk_rol;
    		}
    	}
    	$this->db->close();
    	return $rol;	 	
    }
    
}//EOC   
    
