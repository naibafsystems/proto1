<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modulo1 extends CI_Model {
	
	function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->library("session");
        $this->load->library("general");
    }
    
    function obtenerModulo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$modulo1 = array();
    	$sql = "SELECT CTRL.modulo1, CTRL.nro_orden, CTRL.nro_establecimiento, EMP.idnit, EMP.idproraz, EMP.idnomcom, EMP.idsigla, EMP.iddirecc, EMP.fk_depto, 
    	               EMP.fk_mpio, EMP.idtelno, EMP.idfaxno, EMP.idpagweb, EMP.idcorreo, DATE_FORMAT(EST.finicial,'%d/%m/%Y') AS finicial, DATE_FORMAT(EST.ffinal,'%d/%m/%Y') AS ffinal, EST.idnomcom AS idnomcomest, EST.idsigla AS idsiglaest, 
    	               EST.iddirecc AS iddireccest, EST.iddepto AS iddeptoest, EST.idmpio AS idmpioest, EST.idtelno AS idtelnoest, EST.idfaxno AS idfaxnoest, EST.idcorreo AS idcorreoest, EMP.nom_cadena AS nom_cadena, EMP.nom_operador AS nom_operador, EST.fk_ciiu AS fk_ciiu,
    	               CIU.nom_ciiu AS nom_ciiu
                FROM rmmh_admin_control CTRL, rmmh_admin_empresas EMP, rmmh_admin_establecimientos EST, rmmh_param_ciiu3 CIU
                WHERE CTRL.nro_orden = EMP.nro_orden
                AND CTRL.nro_establecimiento = EST.nro_establecimiento
                AND EMP.nro_orden = EST.nro_orden
                AND CIU.id_ciiu = EST.fk_ciiu
                AND CTRL.nro_orden = $nro_orden
                AND CTRL.nro_establecimiento = $nro_establecimiento
                AND CTRL.ano_periodo = $ano_periodo
                AND CTRL.mes_periodo = $mes_periodo";    	
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
      			$modulo1["imagen"] = $row->modulo1;
    			$modulo1["nro_orden"] = $row->nro_orden;
    			$modulo1["nro_establecimiento"] = $row->nro_establecimiento;
    			$modulo1["idnit"] = $row->idnit;
      			$modulo1["idproraz"] = strtoupper($row->idproraz);
      			$modulo1["idnomcom"] = strtoupper($row->idnomcom);
      			$modulo1["idsigla"] = strtoupper($row->idsigla);
      			$modulo1["iddirecc"] = strtoupper($row->iddirecc);
      			$modulo1["iddepto"] = $row->fk_depto;
      			$modulo1["idmpio"] = $row->fk_mpio;
      			$modulo1["idtelno"] = $row->idtelno;
      			$modulo1["idfaxno"] = $row->idfaxno;
      			$modulo1["idpagweb"] = strtolower($row->idpagweb);
      			$modulo1["idcorreo"] = strtolower($row->idcorreo);
      			$modulo1["finicial"] = $row->finicial;
      			$modulo1["ffinal"] = $row->ffinal;
      			$modulo1["idnomcomest"] = strtoupper($row->idnomcomest);
      			$modulo1["idsiglaest"] = strtoupper($row->idsiglaest);
      			$modulo1["iddireccest"] = strtoupper($row->iddireccest);
      			$modulo1["iddeptoest"] = $row->iddeptoest;
      			$modulo1["idmpioest"] = $row->idmpioest;
      			$modulo1["idtelnoest"] = $row->idtelnoest;
      			$modulo1["idfaxnoest"] = $row->idfaxnoest;
      			$modulo1["idcorreoest"] = strtolower($row->idcorreoest);
      			$modulo1["nom_cadena"]=strtoupper($row->nom_cadena);
      			$modulo1["nom_operador"]=strtoupper($row->nom_operador);
      			$modulo1["fk_ciiu"]=strtoupper($row->fk_ciiu);
      			$modulo1["nom_ciiu"]=strtoupper($row->nom_ciiu);
   			}   			
   		}    	
    	$this->db->close();
   		return $modulo1;
    }
    
    
    function actualizarModulo($nro_orden, $nro_establecimiento, $idnit, $idproraz, $idnomcom, $idsigla, $iddirecc, $iddepto, $idmpio, $idtelno, $idfaxno, $idpagweb, $idcorreo, $finicial, $ffinal,
                              $idnomcomest, $idsiglaest, $iddireccest, $iddeptoest, $idmpioest, $idtelnoest, $idfaxnoest, $idcorreoest, $nom_cadena, $nom_operador){
        // Limpiar las fechas del formato DANE y pasarlas a formato MySQL
        $arrayIni = explode("/",$finicial);                      	
        $arrayFin = explode("/",$ffinal);
        $fechaInicial = $arrayIni[2]."-".$arrayIni[1]."-".$arrayIni[0];
    	$fechaFinal = $arrayFin[2]."-".$arrayFin[1]."-".$arrayFin[0];
        // Actualizar rmmh_admin_empresas
    	$data = array('idnit' => $idnit, 
    	              'idproraz' => $idproraz, 
    	              'idnomcom' => $idnomcom, 
    	              'idsigla' => $idsigla, 
    	              'iddirecc' => $iddirecc, 
    	              'idtelno' => $idtelno, 
    	              'idfaxno' => $idfaxno, 
    	              'idaano' => '', 
    	              'idpagweb' => $idpagweb, 
    	              'idcorreo' => $idcorreo,
    	              'fk_depto' => $iddepto, 
    	              'fk_mpio' => $idmpio,
    				  'nom_cadena' => $nom_cadena,
    				  'nom_operador' => $nom_operador);	
    	$this->db->where("nro_orden",$nro_orden);
    	$this->db->update("rmmh_admin_empresas", $data);
    	
    	// Actualizar rmmh_admin_establecimientos
    	$data = array('idnomcom' => $idnomcomest, 
    	              'idsigla' => $idsiglaest, 
    	              'iddirecc' => $iddireccest, 
    	              'idmpio' => $idmpioest, 
    	              'iddepto' => $iddeptoest, 
    	              'idtelno' => $idtelnoest, 
    	              'idfaxno' => $idfaxnoest, 
    	              'idcorreo' => $idcorreoest, 
    	              'finicial' => $fechaInicial, 
    	              'ffinal' => $fechaFinal);
    	$this->db->where("nro_orden",$nro_orden);
    	$this->db->where("nro_establecimiento",$nro_establecimiento);
		$this->db->update("rmmh_admin_establecimientos", $data);    	                          	
    	$this->db->close();
    	
    	echo $this->db->last_query();
    }
	
	
}

?>