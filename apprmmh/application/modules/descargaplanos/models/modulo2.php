<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modulo2 extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->library("session");        
    }
    
    function obtenerModulo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$modulo2 = array();
    	$sql = "SELECT C.modulo2, C.nro_orden, C.nro_establecimiento, PS.potpsfr, PS.potperm, PS.gpper, PS.pottcde, PS.gpssde, PS.pottcag, PS.gpppta, PS.potpau, PS.gppgpa, PS.pottot, PS.gpsspot
                FROM rmmh_form_persalarios PS, rmmh_admin_control C
                WHERE PS.nro_orden = C.nro_orden
                AND PS.nro_establecimiento = C.nro_establecimiento
                AND PS.ano_periodo = C.ano_periodo
                AND PS.mes_periodo = C.mes_periodo
                AND C.nro_orden = $nro_orden
                AND C.nro_establecimiento = $nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo";    	   	
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
      			$modulo2["op"] = "update";
    			$modulo2["imagen"] = $row->modulo2;    			
    			$modulo2["potpsfr"] = $row->potpsfr;
    			$modulo2["potperm"] = $row->potperm;
    			$modulo2["gpper"] = $row->gpper;
    			$modulo2["pottcde"] = $row->pottcde;
				$modulo2["gpssde"] = $row->gpssde;
				$modulo2["pottcag"] = $row->pottcag;	    			      		
				$modulo2["gpppta"] = $row->gpppta;
				$modulo2["potpau"] = $row->potpau;
				$modulo2["gppgpa"] = $row->gppgpa;	    			      		
				$modulo2["pottot"] = $row->pottot;
				$modulo2["gpsspot"] = $row->gpsspot;
    		}   			
   		}
   		else{
   			$modulo2["op"] = "insert";
   			$modulo2["imagen"] = "0";
   			$modulo2["potpsfr"] = "";
    		$modulo2["potperm"] = "";
    		$modulo2["gpper"] = "";
    		$modulo2["pottcde"] = "";
			$modulo2["gpssde"] = "";
			$modulo2["pottcag"] = "";	    			      		
			$modulo2["gpppta"] = "";
			$modulo2["potpau"] = "";
			$modulo2["gppgpa"] = "";	    			      		
			$modulo2["pottot"] = "";
			$modulo2["gpsspot"] = "";
   		}    	
    	$this->db->close();
   		return $modulo2;   		   		
    }
    
    function actualizarModulo($potpsfr, $potperm, $gpper, $pottcde, $gpssde, $pottcag, $gpppta, $potpau, $gppgpa, $pottot, $gpsspot, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$data = array('potpsfr' => $potpsfr, 
    	              'potperm' => $potperm,
    	              'gpper' => $gpper, 
    	              'pottcde' => $pottcde, 
    	              'gpssde' => $gpssde,
    	              'pottcag' => $pottcag, 
    	              'gpppta' => $gpppta, 
    	              'potpau' => $potpau, 
    	              'gppgpa' => $gppgpa, 
    	              'pottot' => $pottot, 
    	              'gpsspot' => $gpsspot);
    	$this->db->where("nro_orden",   $nro_orden);
		$this->db->where("nro_establecimiento",$nro_establecimiento);
		$this->db->where("ano_periodo", $ano_periodo);
		$this->db->where("mes_periodo", $mes_periodo);
    	$this->db->update('rmmh_form_persalarios', $data);
		$this->db->close();
    }
    
    function insertarModulo($potpsfr, $potperm, $gpper, $pottcde, $gpssde, $pottcag, $gpppta, $potpau, $gppgpa, $pottot, $gpsspot, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$data = array('potpsfr' => $potpsfr, 
    	              'potperm' => $potperm, 
    	              'gpper' => $gpper, 
    	              'pottcde' => $pottcde, 
    	              'gpssde' => $gpssde, 
    	              'pottcag' => $pottcag, 
    	              'gpppta' => $gpppta, 
    	              'potpau' => $potpau, 
    	              'gppgpa' => $gppgpa, 
    	              'pottot' => $pottot, 
    	              'gpsspot' => $gpsspot, 
    	              'nro_orden' => $nro_orden, 
    	              'nro_establecimiento' => $nro_establecimiento, 
    	              'ano_periodo' => $ano_periodo, 
    	              'mes_periodo' => $mes_periodo);
    	$this->db->insert('rmmh_form_persalarios', $data);
		$this->db->close();
    }
    
    
	function descargaPlanosModulo($ano_periodo, $mes_periodo){
    	$modulo2 = array();
    	/* SE CAMBIA ESTA CONSULTA PARA HACER QUE EL ESTADO DE LA NOVEDAD DEL CAPITULO COINCIDA CON LA QUE ESTÁ REPORTADA EN EL HISTORICO DE NOVEDADES
    	$sql = "SELECT C.nro_orden, C.nro_establecimiento, C.ano_periodo, C.mes_periodo, 
    	               IFNULL(PS.potpsfr,0) AS potpsfr,
                       IFNULL(PS.potperm,0) AS potperm,
                       IFNULL(PS.gpper,0) AS gpper,
                       IFNULL(PS.pottcde,0) AS pottcde,
                       IFNULL(PS.gpssde,0) AS gpssde,
                       IFNULL(PS.pottcag,0) AS pottcag,
                       IFNULL(PS.gpppta,0) AS gpppta,
                       IFNULL(PS.potpau,0) AS potpau,
                       IFNULL(PS.gppgpa,0) AS gppgpa,
                       IFNULL(PS.pottot,0) AS pottot,
                       IFNULL(PS.gpsspot,0) AS gpsspot,
                       C.fk_novedad, C.fk_estado
                FROM rmmh_admin_control C
                LEFT JOIN rmmh_form_persalarios PS
                ON (C.nro_orden = PS.nro_orden AND C.nro_establecimiento = PS.nro_establecimiento AND C.ano_periodo = PS.ano_periodo AND C.mes_periodo = PS.mes_periodo)
                WHERE C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo
                ORDER BY C.nro_establecimiento ASC";
        */
    	$sql = "SELECT C.nro_orden, C.nro_establecimiento, C.ano_periodo, C.mes_periodo, EST.fk_ciiu AS idact,
                       IFNULL(PS.potpsfr,0) AS potpsfr,
                       IFNULL(PS.potperm,0) AS potperm,
                       IFNULL(PS.gpper,0) AS gpper,
                       IFNULL(PS.pottcde,0) AS pottcde,
                       IFNULL(PS.gpssde,0) AS gpssde,
                       IFNULL(PS.pottcag,0) AS pottcag,
                       IFNULL(PS.gpppta,0) AS gpppta,
                       IFNULL(PS.potpau,0) AS potpau,
                       IFNULL(PS.gppgpa,0) AS gppgpa,
                       IFNULL(PS.pottot,0) AS pottot,
                       IFNULL(PS.gpsspot,0) AS gpsspot,
                       IFNULL(HN.fk_novedad, C.fk_novedad) AS fk_novedad, C.fk_estado
                FROM rmmh_admin_control C
                LEFT JOIN rmmh_admin_histnovedades HN ON (C.nro_orden = HN.nro_orden
                                                          AND C.nro_establecimiento = HN.nro_establecimiento
                                                          AND C.ano_periodo = HN.ano_periodo
                                                          AND C.mes_periodo = HN.mes_periodo)
                LEFT JOIN rmmh_form_persalarios PS ON (C.nro_orden = PS.nro_orden
                                                       AND C.nro_establecimiento = PS.nro_establecimiento
                                                       AND C.ano_periodo = PS.ano_periodo
                                                       AND C.mes_periodo = PS.mes_periodo)
                INNER JOIN rmmh_admin_empresas EMP ON (C.nro_orden = EMP.nro_orden)
                INNER JOIN rmmh_admin_establecimientos EST ON (C.nro_orden = EST.nro_orden AND C.nro_establecimiento = EST.nro_establecimiento)                                       
                WHERE C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo
                GROUP BY C.nro_orden, C.nro_establecimiento, C.ano_periodo, C.mes_periodo
                ORDER BY C.nro_establecimiento ASC";        
    	$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
    		$i = 0;
    		foreach ($query->result() as $row){
      			$modulo2[$i]["nro_orden"] = $row->nro_orden;
      			$modulo2[$i]["nro_establecimiento"] = $row->nro_establecimiento;
      			$modulo2[$i]["ano_periodo"] = $row->ano_periodo;
      			$modulo2[$i]["mes_periodo"] = $row->mes_periodo;
      			$modulo2[$i]["idact"] = $row->idact;
    			$modulo2[$i]["potpsfr"] = $row->potpsfr;
      			$modulo2[$i]["potperm"] = $row->potperm;
      			$modulo2[$i]["gpper"] = $row->gpper;
      			$modulo2[$i]["pottcde"] = $row->pottcde;
      			$modulo2[$i]["gpssde"] = $row->gpssde;
      			$modulo2[$i]["pottcag"] = $row->pottcag;
      			$modulo2[$i]["gpppta"] = $row->gpppta;
      			$modulo2[$i]["potpau"] = $row->potpau;
      			$modulo2[$i]["gppgpa"] = $row->gppgpa;
      			$modulo2[$i]["pottot"] = $row->pottot;
      			$modulo2[$i]["gpsspot"] = $row->gpsspot;
      			$modulo2[$i]["fk_novedad"] = $row->fk_novedad;
      			$modulo2[$i]["fk_estado"] = $row->fk_estado;
      			$modulo2[$i]["estado"] = $this->novedad->nombreEstadoFormulario($row->fk_novedad, $row->fk_estado);
      			$i++;
    		}
    	}
    	$this->db->close();
   		return $modulo2;
    }
    
    //Descarga consolidado módulo II
    function descargaPlanosConsolidado($ano_periodo, $mes_periodo){
    	$modulo2 = array();
    	$sql = "SELECT C.nro_orden, count(C.nro_establecimiento ) as nro_establecimientos,
                C.ano_periodo, C.mes_periodo, sum(PS.potpsfr) as potpsfr,
				sum(PS.potperm) as potperm, sum(PS.gpper) as gpper,
				sum(PS.pottcde) as pottcde, sum(PS.gpssde) as gpssde,
				sum(PS.pottcag) as pottcag, sum(PS.gpppta) as gpppta,
				sum(PS.potpau) as potpau, sum(PS.gppgpa) as gppgpa,
				sum(PS.pottot) as pottot, sum(PS.gpsspot) as gpsspot
                FROM rmmh_form_persalarios PS, rmmh_admin_control C
                WHERE PS.nro_orden = C.nro_orden
                AND PS.nro_establecimiento = C.nro_establecimiento
                AND PS.ano_periodo = C.ano_periodo
                AND PS.mes_periodo = C.mes_periodo
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo
                GROUP BY C.nro_orden";
    	$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
	    	$i = 0;
	    	foreach ($query->result() as $row){
	    		$modulo2[$i]["nro_orden"] = $row->nro_orden;
	    		$modulo2[$i]["nro_establecimientos"] = $row->nro_establecimientos;
	    		$modulo2[$i]["ano_periodo"] = $row->ano_periodo;
	    		$modulo2[$i]["mes_periodo"] = $row->mes_periodo;
	    		$modulo2[$i]["potpsfr"] = $row->potpsfr;
	      			$modulo2[$i]["potperm"] = $row->potperm;
	          			$modulo2[$i]["gpper"] = $row->gpper;
	          			$modulo2[$i]["pottcde"] = $row->pottcde;
	          			$modulo2[$i]["gpssde"] = $row->gpssde;
	          			$modulo2[$i]["pottcag"] = $row->pottcag;
	          			$modulo2[$i]["gpppta"] = $row->gpppta;
	          			$modulo2[$i]["potpau"] = $row->potpau;
	          			$modulo2[$i]["gppgpa"] = $row->gppgpa;
	          			$modulo2[$i]["pottot"] = $row->pottot;
	          			$modulo2[$i]["gpsspot"] = $row->gpsspot;
	          	$i++;
	    		}
    		}
    		$this->db->close();
    		return $modulo2;
    	}
   
}//EOC  
