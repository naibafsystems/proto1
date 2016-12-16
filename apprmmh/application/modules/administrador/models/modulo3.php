<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modulo3 extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->library("session");        
    }
    
    function obtenerModulo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$modulo3 = array();
    	$sql = "SELECT C.modulo3, IO.inalo, IO.inali, IO.inba, IO.insr, IO.inoe, IO.inoio, IO.intio
                FROM rmmh_form_ingoperacionales IO, rmmh_admin_control C
                WHERE IO.nro_orden = C.nro_orden
                AND IO.nro_establecimiento = C.nro_establecimiento
                AND IO.ano_periodo = C.ano_periodo
                AND IO.mes_periodo = C.mes_periodo
                AND C.nro_orden = $nro_orden
                AND C.nro_establecimiento = $nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
      			$modulo3["op"] = "update";
    			$modulo3["imagen"] = $row->modulo3;
    			$modulo3["inalo"] = $row->inalo;
    			$modulo3["inali"] = $row->inali;
    			$modulo3["inba"] = $row->inba;
    			$modulo3["insr"] = $row->insr;
    			$modulo3["inoe"] = $row->inoe;
				$modulo3["inoio"] = $row->inoio;
				$modulo3["intio"] = $row->intio;	    			      		
    		}   			
   		}
   		else{
   			$modulo3["op"] = "insert";
   			$modulo3["imagen"] = "0";
   			$modulo3["inalo"] = "";
   			$modulo3["inali"] = "";
   			$modulo3["inba"] = "";
   			$modulo3["insr"] = "";
   			$modulo3["inoe"] = "";
   			$modulo3["inoio"] = "";
   			$modulo3["intio"] = "";
   		}    	
    	$this->db->close();
   		return $modulo3;   		
    }
    
    function actualizarModulo($inalo, $inali, $inba, $insr, $inoe, $inoio, $intio, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$data = array('inalo' => $inalo, 
    	              'inali' => $inali, 
    	              'inba' => $inba,
    			      'insr' => $insr,
    	              'inoe' => $inoe, 
    	              'inoio' => $inoio, 
    	              'intio' => $intio);
    	$this->db->where("nro_orden",   $nro_orden);
		$this->db->where("nro_establecimiento",$nro_establecimiento);
		$this->db->where("ano_periodo", $ano_periodo);
		$this->db->where("mes_periodo", $mes_periodo);
    	$this->db->update('rmmh_form_ingoperacionales', $data);
		$this->db->close();
    }
    
    function insertarModulo($inalo, $inali, $inba, $insr, $inoe, $inoio, $intio, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$data = array('inalo' => $inalo, 
    	              'inali' => $inali,
    	              'inba' => $inba,
    			      'insr' => $insr,
    	              'inoe' => $inoe,
    	              'inoio' => $inoio,
    	              'intio' => $intio,
    	              'nro_orden' => $nro_orden,
    	              'nro_establecimiento' => $nro_establecimiento,
    	              'ano_periodo' => $ano_periodo,
    	              'mes_periodo' => $mes_periodo);
    	$this->db->insert('rmmh_form_ingoperacionales', $data);
		$this->db->close();
    }
    
	function descargaPlanosModulo($ano_periodo, $mes_periodo){
    	$modulo3 = array();
    	/* SE CAMBIA ESTA CONSULTA PARA HACER QUE EL ESTADO DE LA NOVEDAD DEL CAPITULO COINCIDA CON LA QUE ESTÁ REPORTADA EN EL HISTORICO DE NOVEDADES
    	$sql = "SELECT C.nro_orden, C.nro_establecimiento, C.ano_periodo, C.mes_periodo, 
    	               IFNULL(IO.inalo,0) AS inalo,
                       IFNULL(IO.inali,0) AS inali,
                       IFNULL(IO.inba,0) AS inba,
                       IFNULL(IO.inoe,0) AS inoe,
                       IFNULL(IO.inoio,0) AS inoio,
                       IFNULL(IO.intio,0) AS intio,
                       C.fk_novedad, C.fk_estado
                FROM rmmh_admin_control C
                LEFT JOIN rmmh_form_ingoperacionales IO ON (C.nro_orden = IO.nro_orden AND C.nro_establecimiento = IO.nro_establecimiento AND C.ano_periodo = IO.ano_periodo AND C.mes_periodo = IO.mes_periodo)
                WHERE C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo 
                ORDER BY C.nro_establecimiento ASC"; */
    	
    	$sql = "SELECT C.nro_orden, C.nro_establecimiento, C.ano_periodo, C.mes_periodo,
    	               IFNULL(IO.inalo,0) AS inalo,
                       IFNULL(IO.inali,0) AS inali,
                       IFNULL(IO.inba,0) AS inba,
                       IFNULL(IO.inba,0) AS insr,
                       IFNULL(IO.inoe,0) AS inoe,
                       IFNULL(IO.inoio,0) AS inoio,
                       IFNULL(IO.intio,0) AS intio,
                       IFNULL(HN.fk_novedad,C.fk_novedad) AS fk_novedad, C.fk_estado
                FROM rmmh_admin_control C
                LEFT JOIN rmmh_admin_histnovedades HN ON (C.nro_orden = HN.nro_orden
                                                          AND C.nro_establecimiento = HN.nro_establecimiento
                                                          AND C.ano_periodo = HN.ano_periodo
                                                          AND C.mes_periodo = HN.mes_periodo)
                LEFT JOIN rmmh_form_ingoperacionales IO ON (C.nro_orden = IO.nro_orden
                                                            AND C.nro_establecimiento = IO.nro_establecimiento
                                                            AND C.ano_periodo = IO.ano_periodo
                                                            AND C.mes_periodo = IO.mes_periodo)
                WHERE C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo
                GROUP BY C.nro_orden, C.nro_establecimiento, C.ano_periodo, C.mes_periodo
                ORDER BY C.nro_establecimiento ASC";
    	$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
    		$i = 0;
    		foreach ($query->result() as $row){
      			$modulo3[$i]["nro_orden"] = $row->nro_orden;
      			$modulo3[$i]["nro_establecimiento"] = $row->nro_establecimiento;
      			$modulo3[$i]["ano_periodo"] = $row->ano_periodo;
      			$modulo3[$i]["mes_periodo"] = $row->mes_periodo;      			
    			$modulo3[$i]["inalo"] = $row->inalo;
      			$modulo3[$i]["inali"] = $row->inali;
      			$modulo3[$i]["inba"] = $row->inba;
      			$modulo3[$i]["insr"] = $row->insr;
      			$modulo3[$i]["inoe"] = $row->inoe;
      			$modulo3[$i]["inoio"] = $row->inoio;
      			$modulo3[$i]["intio"] = $row->intio;
      			$modulo3[$i]["fk_novedad"] = $row->fk_novedad;
      			$modulo3[$i]["fk_estado"] = $row->fk_estado;
      			$modulo3[$i]["estado"] = $this->novedad->nombreEstadoFormulario($row->fk_novedad, $row->fk_estado);
      			$i++;
    		}
    	}
    	$this->db->close();
   		return $modulo3;
    }
    
    //Descarga consolidado módulo III
    function descargaPlanosConsolidado($ano_periodo, $mes_periodo){
    	$modulo3 = array();
    	 
    	$sql = "SELECT IO.nro_orden,C.modulo3, count(C.nro_establecimiento) as nro_establecimientos,
    			C.ano_periodo, C.mes_periodo,
                sum(IO.inalo) as inalo, sum(IO.inali) as inali, sum(IO.inba) as inba, 
                sum(IO.insr) as insr, sum(IO.inoe) as inoe, sum(IO.inoio) as inoio, sum(IO.intio) as intio
                FROM rmmh_form_ingoperacionales IO, rmmh_admin_control C
                WHERE IO.nro_orden = C.nro_orden
                AND IO.nro_establecimiento = C.nro_establecimiento
                AND IO.ano_periodo = C.ano_periodo
                AND IO.mes_periodo = C.mes_periodo
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo
                GROUP BY IO.nro_orden";
    	$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
    	$i = 0;
	    	foreach ($query->result() as $row){
		    	$modulo3[$i]["nro_orden"] = $row->nro_orden;
		    	$modulo3[$i]["nro_establecimientos"] = $row->nro_establecimientos;
		    	$modulo3[$i]["ano_periodo"] = $row->ano_periodo;
		    	$modulo3[$i]["mes_periodo"] = $row->mes_periodo;
		    	$modulo3[$i]["inalo"] = $row->inalo;
		    	$modulo3[$i]["inali"] = $row->inali;
		    	$modulo3[$i]["inba"] = $row->inba;
		    	$modulo3[$i]["insr"] = $row->insr;
	    		$modulo3[$i]["inoe"] = $row->inoe;
	    		$modulo3[$i]["inoio"] = $row->inoio;
	    		$modulo3[$i]["intio"] = $row->intio;
	    	
	    	$i++;
	    	}
    	}
    			$this->db->close();
    	return $modulo3;
    	}
}//EOC  