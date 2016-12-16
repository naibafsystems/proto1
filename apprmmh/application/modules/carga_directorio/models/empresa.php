<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empresa extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->library("session");
    }
    
    function insertarEmpresa($nro_orden, $idnit, $idproraz, $idnomcom, $idsigla, $iddirecc, $idtelno, $idfaxno, $idaano, $idpagweb, $idcorreo, $fk_depto, $fk_mpio){
    	$data = array('nro_orden' => $nro_orden, 
    	              'idnit' => $idnit, 
    	              'idproraz' => $idproraz, 
    	              'idnomcom' => $idnomcom, 
    	              'idsigla' => $idsigla, 
    	              'iddirecc' => $iddirecc, 
    	              'idtelno' => $idtelno, 
    	              'idfaxno' => $idfaxno, 
    	              'idaano' => $idaano, 
    	              'idpagweb' => $idpagweb, 
    	              'idcorreo' => $idcorreo, 
    	              'fk_depto' => $fk_depto, 
    	              'fk_mpio' => $fk_mpio);
    	$this->db->insert('rmmh_admin_empresas', $data);
    }
    
    function obtenerNITEmpresa($nro_orden){
    	$nit = 0;
    	$sql = "SELECT idnit
                FROM rmmh_admin_empresas
                WHERE nro_orden = $nro_orden";
    	$query = $this->db->query($sql);
   		if ($query->num_rows()>0){
			foreach($query->result() as $row){
				$nit = $row->idnit;
			}
		}
		$this->db->close();
		return $nit;
    }
    
   	
}//EOC 