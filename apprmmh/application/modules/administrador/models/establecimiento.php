<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Establecimiento extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->library("session");
    }
    
   	function obtenerDatosEstablecimiento($nro_orden, $nro_establecimiento){
   		$establecimiento = array();
   		$sql = "SELECT nro_orden, nro_establecimiento, idnomcom, idsigla, iddirecc, idmpio, iddepto, idtelno, idfaxno, idcorreo, finicial, ffinal, 
   		               fk_ciiu, fk_depto, fk_mpio, fk_sede, fk_subsede
                FROM rmmh_admin_establecimientos
                WHERE nro_orden = $nro_orden
                AND nro_establecimiento = $nro_establecimiento";
   		$query = $this->db->query($sql);
   		if ($query->num_rows()>0){
			foreach($query->result() as $row){
				$establecimiento["nro_orden"] = $row->nro_orden;
				$establecimiento["nro_establecimiento"] = $row->nro_establecimiento;
				$establecimiento["idnomcom"] = $row->idnomcom;
				$establecimiento["idsigla"] = $row->idsigla;
				$establecimiento["iddirecc"] = $row->iddirecc;
				$establecimiento["idmpio"] = $row->idmpio;
				$establecimiento["iddepto"] = $row->iddepto;
				$establecimiento["idtelno"] = $row->idtelno;
				$establecimiento["idfaxno"] = $row->idfaxno;
				$establecimiento["idcorreo"] = $row->idcorreo;
				$establecimiento["finicial"] = $row->finicial;
				$establecimiento["ffinal"] = $row->ffinal;
				$establecimiento["fk_ciiu"] = $row->fk_ciiu;
				$establecimiento["fk_depto"] = $row->fk_depto;
				$establecimiento["fk_mpio"] = $row->fk_mpio;
				$establecimiento["fk_sede"] = $row->fk_sede;
				$establecimiento["fk_subsede"] = $row->fk_subsede;
			}
		}
		$this->db->close();
		return $establecimiento;
   	}
   	
   	function insertarEstablecimiento($nro_orden, $nro_establecimiento, $idnomcom, $idsigla, $iddirecc, $idtelno, $idfaxno, $idcorreo, $finicial, $ffinal, $fk_ciiu, $fk_depto, $fk_mpio, $fk_sede, $fk_subsede){
   		$data = array('nro_orden' => $nro_orden, 
   		              'nro_establecimiento' => $nro_establecimiento, 
   		              'idnomcom' => $idnomcom, 
   		              'idsigla' => $idsigla, 
   		              'iddirecc' => $iddirecc, 
   		              'idmpio' => $fk_mpio, 
   		              'iddepto' => $fk_depto, 
   		              'idtelno' => $idtelno, 
   		              'idfaxno' => $idfaxno, 
   		              'idcorreo' => $idcorreo, 
   		              'finicial' => $finicial, 
   		              'ffinal' => $ffinal, 
   		              'fk_ciiu' => $fk_ciiu, 
   		              'fk_depto' => $fk_depto, 
   		              'fk_mpio' => $fk_mpio, 
   		              'fk_sede' => $fk_sede, 
   		              'fk_subsede' => $fk_subsede);
   		$this->db->insert('rmmh_admin_establecimientos', $data); 
   		
   	}
   	

   	function actualizarEstablecimiento($nro_orden, $nro_establecimiento, $idnomcom, $idsigla, $iddirecc, $idmpio, $iddepto, $idtelno, $idfaxno, $idcorreo, $fk_ciiu, $fk_depto, $fk_mpio, $fk_sede, $fk_subsede){
   		$data = array('idnomcom' => $idnomcom,
                      'idsigla' => $idsigla,
                      'iddirecc' => $iddirecc,
   		              'idmpio' => $idmpio,
   		              'iddepto' => $iddepto,
   		              'idtelno' => $idtelno,
   		              'idfaxno' => $idfaxno,
   		              'idcorreo' => $idcorreo,
   		              'fk_ciiu' => $fk_ciiu,
   		              'fk_depto' => $fk_depto,
   		              'fk_mpio' => $fk_mpio,
   		              'fk_sede' => $fk_sede,
   		              'fk_subsede' => $fk_subsede  
                );
		$this->db->where('nro_orden', $nro_orden);
		$this->db->where('nro_establecimiento', $nro_establecimiento);
		$this->db->update('rmmh_admin_establecimientos', $data);
   	}
   	
}//EOC