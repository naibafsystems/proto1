<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Capitulo5 extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();		
    }
	
	function obtenerCapitulo($nro_orden, $uni_local, $ano_periodo, $mes_periodo){
    	$cap5 = array();
    	$sql = "SELECT C.cap4, CH.habdia, CH.ihdo, CH.ihoa, CH.camdia, CH.icda, CH.icva, CH.ihpn, CH.ihpnr, CH.huetot, CH.mvnr, CH.mvnnr, CH.mvcr, CH.mvcnr, CH.mvor, CH.mvonr,
                       CH.mvsr, CH.mvsnr, CH.mvotr, CH.mvotnr, CH.mvott, CH.mvottnr, CH.thsen, CH.ingsen, CH.inalosen, CH.thdob, CH.ingdob, CH.inalodob,
                       CH.thsui, CH.ingsui, CH.inalosui, CH.thmult, CH.ingmult, CH.inalomul, CH.thotr, CH.ingotr, CH.inalootr, CH.thtot, CH.ingtot, CH.inalotot
                FROM rmmh_form_caracthoteles CH, rmmh_admin_control C
                WHERE CH.nro_orden = C.nro_orden
                AND CH.uni_local = C.uni_local
                AND CH.ano_periodo = C.ano_periodo
                AND CH.mes_periodo = C.mes_periodo
                AND C.nro_orden = $nro_orden
                AND C.uni_local = $uni_local
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
      			$cap5["op"] = "update";
    			$cap5["imagen"] = $row->cap4;
    			$cap5["habdia"] = $row->habdia;
    			$cap5["ihdo"] = $row->ihdo; 
    			$cap5["ihoa"] = $row->ihoa;
    			$cap5["camdia"] = $row->camdia;
    			$cap5["icda"] = $row->icda;
    			$cap5["icva"] = $row->icva;
    			$cap5["ihpn"] = $row->ihpn;
    			$cap5["ihpnr"] = $row->ihpnr;
    			$cap5["huetot"] = $row->huetot;
    			$cap5["mvnr"] = $row->mvnr;
    			$cap5["mvnnr"] = $row->mvnnr;
    			$cap5["mvcr"] = $row->mvcr;
    			$cap5["mvcnr"] = $row->mvcnr;
    			$cap5["mvor"] = $row->mvor;
    			$cap5["mvonr"] = $row->mvonr;
    			$cap5["mvsr"] = $row->mvsr;
    			$cap5["mvsnr"] = $row->mvsnr;
    			$cap5["mvotr"] = $row->mvotr;
    			$cap5["mvotnr"] = $row->mvotnr;
    			$cap5["mvott"] = $row->mvott;
    			$cap5["mvottnr"] = $row->mvottnr;
    			$cap5["thsen"] = $row->thsen;
    			$cap5["ingsen"] = $row->ingsen;
    			$cap5["inalosen"] = $row->inalosen;
    			$cap5["thdob"] = $row->thdob;
    			$cap5["ingdob"] = $row->ingdob;
    			$cap5["inalodob"] = $row->inalodob;
    			$cap5["thsui"] = $row->thsui;
    			$cap5["ingsui"] = $row->ingsui;
    			$cap5["inalosui"] = $row->inalosui;
    			$cap5["thmult"] = $row->thmult;
    			$cap5["ingmult"] = $row->ingmult;
    			$cap5["inalomul"] = $row->inalomul;
    			$cap5["thotr"] = $row->thotr;
    			$cap5["ingotr"] = $row->ingotr;
    			$cap5["inalootr"] = $row->inalootr;
    			$cap5["thtot"] = $row->thtot;
    			$cap5["ingtot"] = $row->ingtot;
    			$cap5["inalotot"] = $row->inalotot;
    		}   			
   		}
   		else{
   			$cap5["op"] = "insert";
    		$cap5["imagen"] = 0;
    		$cap5["habdia"] = "";
    		$cap5["ihdo"] = ""; 
    		$cap5["ihoa"] = "";
    		$cap5["camdia"] = "";
    		$cap5["icda"] = "";
    		$cap5["icva"] = "";
    		$cap5["ihpn"] = "";
    		$cap5["ihpnr"] = "";
    		$cap5["huetot"] = "";
    		$cap5["mvnr"] = "";
    		$cap5["mvnnr"] = "";
    		$cap5["mvcr"] = "";
    		$cap5["mvcnr"] = "";
    		$cap5["mvor"] = "";
    		$cap5["mvonr"] = "";
    		$cap5["mvsr"] = "";
    		$cap5["mvsnr"] = "";
    		$cap5["mvotr"] = "";
    		$cap5["mvotnr"] = "";
    		$cap5["mvott"] = "";
    		$cap5["mvottnr"] = "";
    		$cap5["thsen"] = "";
    		$cap5["ingsen"] = "";
    		$cap5["inalosen"] = "";
    		$cap5["thdob"] = "";
    		$cap5["ingdob"] = "";
    		$cap5["inalodob"] = "";
    		$cap5["thsui"] = "";
    		$cap5["ingsui"] = "";
    		$cap5["inalosui"] = "";
    		$cap5["thmult"] = "";
    		$cap5["ingmult"] = "";
    		$cap5["inalomul"] = "";
    		$cap5["thotr"] = "";
    		$cap5["ingotr"] = "";
    		$cap5["inalootr"] = "";
    		$cap5["thtot"] = "";
    		$cap5["ingtot"] = "";
    		$cap5["inalotot"] = "";
   		}   	
    	$this->db->close();
   		return $cap5;
    }
	
	function guardarCapitulo($nro_orden, $uni_local, $ano_periodo, $mes_periodo, 
	                            $habdia, $ihdo, $ihoa, $camdia, $icda, $icva, $ihpn, $ihpnr, $huetot, $mvnr, $mvnnr, $mvcr, $mvcnr, $mvor, $mvonr, $mvsr, $mvsnr, $mvotr, $mvotnr, $mvott, $mvottnr, 
                                $thsen, $ingsen, $inalosen, $thdob, $ingdob, $inalodob, $thsui, $ingsui, $inalosui, $thmult, $ingmult, $inalomul, $thotr, $ingotr, $inalootr, $thtot, 
								$ingtot, $inalotot){            
    	$data = array('habdia' => $habdia,
    				  'ihdo' => $ihdo, 
    			      'ihoa' => $ihoa,
    			      'camdia' => $camdia,
    			      'icda' => $icda,
    			      'icva' => $icva,
    			      'ihpn' => $ihpn,
    			      'ihpnr' => $ihpnr,
    			      'huetot' => $huetot,
    			      'mvnr' => $mvnr,
    			      'mvnnr' => $mvnnr,
    			      'mvor' => $mvor,
    			      'mvonr' => $mvonr,
    			      'mvsr' => $mvsr,
    			      'mvsnr' => $mvsnr,
    			      'mvotr' => $mvotr,
    			      'mvotnr' => $mvotnr,
    			      'mvott' => $mvott,
    			      'mvottnr' => $mvottnr,
    			      'thsen' => $thsen,
    			      'ingsen' => $ingsen,
    			      'inalosen' => $inalosen,
    			      'thdob' => $thdob,
    			      'ingdob' => $ingdob,
    			      'inalodob' => $inalodob,
    			      'thsui' => $thsui,
    			      'ingsui' => $ingsui,
    			      'inalosui' => $inalosui,
    			      'thmult' => $thmult,
    			      'ingmult' => $ingmult,
    			      'inalomul' => $inalomul,
    			      'thotr' => $thotr,
    			      'ingotr' => $ingotr,
    			      'inalootr' => $inalootr,
    			      'thtot' => $thtot,
    			      'ingtot' => $ingtot,
    			      'inalotot' => $inalotot
    	);
		$this->db->where("nro_orden",   $nro_orden);
		$this->db->where("uni_local",   $uni_local);
		$this->db->where("ano_periodo", $ano_periodo);
		$this->db->where("mes_periodo", $mes_periodo);
    	$this->db->update('rmmh_form_caracthoteles', $data);
		$this->db->close();
    }
	
}//EOC