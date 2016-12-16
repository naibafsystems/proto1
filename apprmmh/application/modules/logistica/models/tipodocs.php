<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tipodocs extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
    }
    
	function obtenerTipoDocumentos() {
		$tipos = "";
		$sql = "SELECT id_tipodoc, nom_tipodoc
				FROM rmmh_param_tipodocs
				ORDER BY id_tipodoc";
		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
			$i = 0;
			foreach($query->result() as $row){
				$tipos[$i]["id"] = $row->id_tipodoc;
				$tipos[$i]["nombre"] = utf8_decode($row->nom_tipodoc);
				$i++;
			}
		}
		$this->db->close();
		return $tipos;
	}
    
}//EOC