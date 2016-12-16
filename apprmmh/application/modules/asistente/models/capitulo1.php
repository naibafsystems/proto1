<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Capitulo1 extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
		$this->load->library("general");
    }
    
    function obtenerCapitulo($nro_orden, $uni_local, $ano_periodo, $mes_periodo){
    	$cap1 = array();    	    	
    	$sql = "SELECT C.caratula, DF.nro_orden, DF.idproraz, DF.idnomcom, DF.idsigla, DF.iddirecc, DF.idtelno, DF.idfaxno, 
		               DF.idaano, DF.idpagweb, DF.idcorreo, DF.finicial, DF.ffinal, DF.fk_depto, DF.fk_mpio, DF.fk_ciiu, DF.fk_sede
                FROM rmmh_admin_dirfuentes DF, rmmh_admin_control C
                WHERE DF.nro_orden = C.nro_orden
                AND C.nro_orden = $nro_orden
				AND C.uni_local = $uni_local
				AND C.ano_periodo = $ano_periodo
				AND C.mes_periodo = $mes_periodo";    	
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
      			$cap1["imagen"] = $row->caratula;
    			$cap1["nro_orden"] = $row->nro_orden;
      			$cap1["idproraz"] = strtoupper($row->idproraz);
      			$cap1["idnomcom"] = strtoupper($row->idnomcom);
      			$cap1["idsigla"] = strtoupper($row->idsigla);
      			$cap1["iddirecc"] = strtoupper($row->iddirecc);
      			$cap1["idtelno"] = $row->idtelno;
      			$cap1["idfaxno"] = $row->idfaxno;
      			$cap1["idaano"] = $row->idaano;
      			$cap1["idpagweb"] = $row->idpagweb;
      			$cap1["idcorreo"] = strtolower($row->idcorreo);
      			$cap1["finicial"] = $this->general->formatoFecha($row->finicial,'-');
      			$cap1["ffinal"] = $this->general->formatoFecha($row->ffinal,'-');
      			$cap1["depto"] = $row->fk_depto;
      			$cap1["mpio"] = $row->fk_mpio;
      			$cap1["ciiu"] = $row->fk_ciiu;
      			$cap1["sede"] = $row->fk_sede;
   			}   			
   		}    	
    	$this->db->close();
   		return $cap1;
    }
	
	function guardarCapitulo($nro_orden, $uni_local, $idproraz, $idnomcom, $idsigla, $iddirecc, $iddepto, $idmpio, $idtelno, $idfaxno, $idaano, $idpagweb, $idcorreo, $finicial, $ffinal){        
    	$data = array('idproraz' => $idproraz,
    	              'idnomcom' => $idnomcom,
    	              'idsigla' => $idsigla,
    	              'iddirecc' => $iddirecc,
    	              'fk_depto' => $iddepto,
    	              'fk_mpio' => $idmpio,
    	              'idtelno' => $idtelno,
    	              'idfaxno' => $idfaxno,
    	              'idaano' => $idaano,
		              'idpagweb' => $idpagweb,
    	              'idcorreo' => $idcorreo, 
    	              'finicial' => $this->general->formatoFecha($finicial,'/'),
    	              'ffinal' => $this->general->formatoFecha($ffinal,'/')
    	);    	
		$this->db->where("nro_orden", $nro_orden);
		$this->db->where("uni_local", $uni_local);
		$this->db->update("rmmh_admin_dirfuentes", $data);
		$this->db->close(); 
    }
    
    
}//EOC        
   
