<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->library("danecrypt");
    }
    
    function cambiarPassword($idusuario, $clave){
    	$password = $this->danecrypt->encode($clave);
    	$data = array("pass_usuario" => $password);
    	$this->db->where("id_usuario", $idusuario);
    	$this->db->update("rmmh_admin_usuarios", $data);
    }
    
    function compararPassword($idusuario, $clave){
    	$result = false;
    	$dbpass = "";
    	$password = $this->danecrypt->encode($clave);
    	$sql = "SELECT pass_usuario
    	        FROM rmmh_admin_usuarios
    	        WHERE id_usuario = $idusuario";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
      			$dbpass = $row->pass_usuario;    				    			      		
    		}   			
   		}
   		$this->db->close();
   		if (strcmp($password,$dbpass)==0){
   			$result = true;
   		}
   		else{
   			$result = false;
   		}
   		return $result;
    }
    
}//EOC 	