<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Caratula extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->library("session");
        $this->load->library("general");
    }
    
    function obtenerCaratula(){
    	$cap1 = array();    	
    	$nro_orden = $this->session->userdata("nro_orden");
    	$sql = "SELECT C.caratula, DF.nro_orden, DF.idproraz, DF.idnomcom, DF.idsigla, DF.iddirecc, DF.idtelno, DF.idfaxno, DF.idaano, DF.idpagweb, DF.idcorreo, DF.finicial, DF.ffinal,
                       DF.fk_depto, DF.fk_mpio, DF.fk_ciiu, DF.fk_sede
                FROM rmmh_admin_dirfuentes DF, rmmh_admin_control C
                WHERE DF.nro_orden = C.nro_orden
                AND DF.nro_orden = $nro_orden";    	
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
      			$caratula["imagen"] = $row->caratula;
    			$caratula["nro_orden"] = $row->nro_orden;
      			$caratula["idproraz"] = strtoupper($row->idproraz);
      			$caratula["idnomcom"] = strtoupper($row->idnomcom);
      			$caratula["idsigla"] = strtoupper($row->idsigla);
      			$caratula["iddirecc"] = strtoupper($row->iddirecc);
      			$caratula["idtelno"] = $row->idtelno;
      			$caratula["idfaxno"] = $row->idfaxno;
      			$caratula["idaano"] = $row->idaano;
      			$caratula["idpagweb"] = $row->idpagweb;
      			$caratula["idcorreo"] = strtolower($row->idcorreo);
      			$caratula["finicial"] = $this->general->formatoFecha($row->finicial,'-');
      			$caratula["ffinal"] = $this->general->formatoFecha($row->ffinal,'-');
      			$caratula["depto"] = $row->fk_depto;
      			$caratula["mpio"] = $row->fk_mpio;
      			$caratula["ciiu"] = $row->fk_ciiu;
      			$caratula["sede"] = $row->fk_sede;
   			}   			
   		}    	
    	$this->db->close();
   		return $caratula;
    }
    
    function obtenerCaratulaNroOrden($nro_orden){
    	$cap1 = array();
    	$sql = "SELECT C.caratula, DF.nro_orden, DF.idproraz, DF.idnomcom, DF.idsigla, DF.iddirecc, DF.idtelno, DF.idfaxno, DF.idaano, DF.idpagweb, DF.idcorreo, DF.finicial, DF.ffinal,
                       DF.fk_depto, DF.fk_mpio, DF.fk_ciiu, DF.fk_sede
                FROM rmmh_admin_dirfuentes DF, rmmh_admin_control C
                WHERE DF.nro_orden = C.nro_orden
                AND DF.nro_orden = $nro_orden";    	
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
      			$caratula["imagen"] = $row->caratula;
    			$caratula["nro_orden"] = $row->nro_orden;
      			$caratula["idproraz"] = strtoupper($row->idproraz);
      			$caratula["idnomcom"] = strtoupper($row->idnomcom);
      			$caratula["idsigla"] = strtoupper($row->idsigla);
      			$caratula["iddirecc"] = strtoupper($row->iddirecc);
      			$caratula["idtelno"] = $row->idtelno;
      			$caratula["idfaxno"] = $row->idfaxno;
      			$caratula["idaano"] = $row->idaano;
      			$caratula["idpagweb"] = $row->idpagweb;
      			$caratula["idcorreo"] = strtolower($row->idcorreo);
      			$caratula["finicial"] = $this->general->formatoFecha($row->finicial,'-');
      			$caratula["ffinal"] = $this->general->formatoFecha($row->ffinal,'-');
      			$caratula["depto"] = $row->fk_depto;
      			$caratula["mpio"] = $row->fk_mpio;
      			$caratula["ciiu"] = $row->fk_ciiu;
      			$caratula["sede"] = $row->fk_sede;
   			}   			
   		}    	
    	$this->db->close();
   		return $caratula;
    }
    
    function actualizarCaratula($idproraz, $idnomcom, $idsigla, $iddirecc, $iddepto, $idmpio, $idtelno, $idfaxno, $idaano, $idpagweb, $idcorreo, $finicial, $ffinal){        
    	$nro_orden = $this->session->userdata('nro_orden');     //Obtener el numero de orden desde la sesion
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
		$this->db->update("rmmh_admin_dirfuentes", $data);
		$this->db->close(); 
    }
    
    //Obtiene los datos de la caratula para un nroorden, año y periodo particular
    function actualizarCaratulaCritico($nro_orden, $idproraz, $idnomcom, $idsigla, $iddirecc, $iddepto, $idmpio, $idtelno, $idfaxno, $idaano, $idpagweb, $idcorreo, $finicial, $ffinal){
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
		$this->db->update("rmmh_admin_dirfuentes", $data);
		$this->db->close(); 
    }
}//EOC        
   
