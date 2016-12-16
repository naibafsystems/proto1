<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Establecimiento extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->library("session");
    }
    
    function validarEstablecimientoPeriodo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$result = "";
    	$sql = "SELECT COUNT(*) AS total
                FROM rmmh_admin_control C, rmmh_admin_establecimientos ES
                WHERE C.nro_orden = ES.nro_orden
                AND C.nro_establecimiento = ES.nro_establecimiento
                AND C.nro_orden = $nro_orden
                AND C.nro_establecimiento = $nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo";
    	$query = $this->db->query($sql);
    	foreach($query->result() as $row){
    		if ($row->total == 0){
    			$result = false; //No existe el establecimiento registrado para el periodo. Debe agregarse el registro. 
    		}
    		else{
    			$result = true; //Ya existe el establecimiento registrado para ese periodo.
    		}
    	}
    	$this->db->close();
    	return $result;
    }
    
    function validarEstablecimiento($nro_orden, $nro_establecimiento){
    	$result = "";
    	$sql = "SELECT COUNT(*) AS total 
    	        FROM rmmh_admin_establecimientos
    	        WHERE nro_orden = $nro_orden
    	        AND nro_establecimiento = $nro_establecimiento";
    	$query = $this->db->query($sql);
    	foreach($query->result() as $row){
    		if ($row->total == 0){
    			$result = false; //No existe el establecimiento. Debe agregarse el registro. 
    		}
    		else{
    			$result = true; //Ya existe el establecimiento.
    		}
    	}
    	$this->db->close();
    	return $result;
    }
    
    function insertarEstablecimiento($nro_orden, $nro_establecimiento, $idnomcom, $idsigla, $iddirecc, $idmpio, $iddepto, $idtelno, $idfaxno, $idcorreo, $fk_ciiu, $fk_depto, $fk_mpio, $fk_sede, $fk_subsede){
    	$data = array('nro_orden' => $nro_orden, 
    	              'nro_establecimiento' => $nro_establecimiento, 
    	              'idnomcom' => $idnomcom, 
    	              'idsigla' => $idsigla, 
    	              'iddirecc' => $iddirecc, 
    	              'idmpio' => $idmpio, 
    	              'iddepto' => $iddepto, 
    	              'idtelno' => $idtelno, 
    	              'idfaxno' => $idfaxno, 
    	              'idcorreo' => $idcorreo, 
    	              'finicial' => NULL, 
    	              'ffinal' => NULL, 
    	              'fk_ciiu' => $fk_ciiu, 
    	              'fk_depto' => $fk_depto, 
    	              'fk_mpio' => $fk_mpio, 
    	              'fk_sede' => $fk_sede, 
    	              'fk_subsede' => $fk_subsede);
    	$this->db->insert('rmmh_admin_establecimientos', $data);
    }
    
   	
}//EOC 