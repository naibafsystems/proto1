<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Divipola extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
    }
	
	function nombreDepartamento($id){
		$nombre = "";
		$sql = "SELECT nom_depto FROM rmmh_param_deptos WHERE id_depto = $id";
		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
			foreach($query->result() as $row){
				$nombre = strtoupper($row->nom_depto);
			}
		}
		$this->db->close();
		return $nombre;
	}
	
	function obtenerDepartamentos(){
    	$departamentos = array();
    	$sql = "SELECT id_depto, nom_depto FROM rmmh_param_deptos ORDER BY 2";
    	$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
    		$i = 0;
    		foreach ($query->result() as $row){
      			$departamentos[$i]["codigo"] = $row->id_depto;
      			$departamentos[$i]["nombre"] = utf8_decode($row->nom_depto);
      			$i++;
   			}
    	}
    	$this->db->close();
    	return $departamentos;
    }
	
	function nombreMunicipio($id){
    	$nombre = "";
		$sql = "SELECT nom_mpio FROM rmmh_param_mpios WHERE id_mpio = $id";
		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
			foreach($query->result() as $row){
				$nombre = strtoupper($row->nom_mpio);
			}
		}
		$this->db->close();
		return $nombre;
    }
	
	function obtenerMunicipios($depto){
    	$municipios = array();
    	$sql = "SELECT id_mpio, nom_mpio FROM rmmh_param_mpios";    	
    	if (($depto!=0)&&($depto!="")){
    		$sql.= " WHERE fk_depto = $depto";
    	}		
    	$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
    		$i=0;
    		foreach ($query->result() as $row){
    			$municipios[$i]["codigo"] = $row->id_mpio;
    			$municipios[$i]["nombre"] = utf8_decode($row->nom_mpio);
    			$i++;
    		}
    	}
    	$this->db->close();
    	return $municipios;
    }  
	
	

    
}//EOC   