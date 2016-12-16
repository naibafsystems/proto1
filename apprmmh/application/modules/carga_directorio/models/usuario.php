<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->library("session");
        $this->load->library("danecrypt");
        $this->load->library("paginador2");
    }
    
    //Obtiene el ID de usuario cuando el usuario ya se encuentra registrado
    function obtenerIDUsuario($nro_orden, $nro_establecimiento){
    	$id = 0;
    	$sql = "SELECT id_usuario
                FROM rmmh_admin_usuarios
                WHERE nro_orden = $nro_orden
                AND nro_establecimiento = $nro_establecimiento";
    	$query = $this->db->query($sql);
    	foreach($query->result() as $row){
    		$id = $row->id_usuario;
    	}
    	$this->db->close();
    	return $id;
    }
    
    //Valida si el registro de un usuario ya esta creado en la base de datos
    function validarUsuario($nro_orden, $nro_establecimiento){
    	$result = "";
    	$sql = "SELECT COUNT(*) AS total
                FROM rmmh_admin_usuarios
                WHERE nro_orden = $nro_orden
                AND nro_establecimiento = $nro_establecimiento";
    	$query = $this->db->query($sql);
    	foreach($query->result() as $row){
    		if ($row->total == 0){
    			$result = false; //No existe el usuario. Debe agregarse el registro. 
    		}
    		else{
    			$result = true; //Ya existe el usuario
    		}
    	}
    	$this->db->close();
    	return $result;
    }
    
	//Inserta el registro de un nuevo usuario en la base de datos
    function insertarUsuario($num_identificacion, $nom_usuario, $log_usuario, $pass_usuario, $mail_usuario, $fec_creacion, $fec_vencimiento, $nro_orden, $nro_establecimiento, $fk_tipodoc, $fk_rol, $fk_sede, $fk_subsede){
		//Verificar que el usuario no exista ya en la base de datos
		$data = array('num_identificacion' => $num_identificacion,
    	              'nom_usuario' => $nom_usuario,
    	              'log_usuario' => $log_usuario,
    	              'pass_usuario' => $pass_usuario,
    	              'mail_usuario' => $mail_usuario,
    	              'fec_creacion' => $fec_creacion,
    	              'fec_vencimiento' => $fec_vencimiento,
    	              'nro_orden' => $nro_orden,
		              'nro_establecimiento' => $nro_establecimiento,
		              'fk_tipodoc' => $fk_tipodoc,
		              'fk_rol' => $fk_rol,
		              'fk_sede' => $fk_sede,
		              'fk_subsede' => $fk_subsede		              
    	);
		$this->db->insert('rmmh_admin_usuarios', $data);
		$this->db->close();
    }
    
	//Obtiene el ID de usuario del ultimo usuario que se inserto en la B.D.
    function IDUltimoInsertado(){
    	$id = 0;
    	$sql = "SELECT MAX(id_usuario) AS id FROM rmmh_admin_usuarios";
    	$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
    		$i = 0;
    		foreach($query->result() as $row){
	    		$id = $row->id;
    		}
    	}
    	$this->db->close();
    	return $id;
    }
    
     
	      
    
}//EOC   
    
