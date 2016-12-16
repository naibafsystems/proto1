<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modulo4 extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->library("session");        
    }
    
    function obtenerModulo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$modulo4 = array();
    	$sql = "SELECT C.modulo4, CH.habdia, CH.ihdo, CH.ihoa, CH.camdia, CH.icda, CH.icva, CH.ihpn, CH.ihpnr, CH.huetot, CH.mvnr, CH.mvnnr, CH.mvcr, CH.mvcnr, CH.mvor, CH.mvonr,
                       CH.mvsr, CH.mvsnr, CH.mvotr, CH.mvotnr, CH.mvott, CH.mvottnr, CH.thsen, CH.thusen, CH.ingsen, CH.inalosen, CH.thdob, CH.thudob, CH.ingdob, CH.inalodob,
                       CH.thsui, CH.thusui, CH.ingsui, CH.inalosui, CH.thmult, CH.thumult, CH.ingmult, CH.inalomul, CH.thotr, CH.thuotr, CH.ingotr, CH.inalootr, CH.thtot, CH.ingtot, CH.inalotot
                FROM rmmh_form_caracthoteles CH, rmmh_admin_control C
                WHERE CH.nro_orden = C.nro_orden
                AND CH.nro_establecimiento = C.nro_establecimiento
                AND CH.ano_periodo = C.ano_periodo
                AND CH.mes_periodo = C.mes_periodo
                AND C.nro_orden = $nro_orden
                AND C.nro_establecimiento = $nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo";    
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
      			$modulo4["op"] = "update";
    			$modulo4["imagen"] = $row->modulo4;
    			$modulo4["habdia"] = $row->habdia;
    			$modulo4["ihdo"] = $row->ihdo; 
    			$modulo4["ihoa"] = $row->ihoa;
    			$modulo4["camdia"] = $row->camdia;
    			$modulo4["icda"] = $row->icda;
    			$modulo4["icva"] = $row->icva;
    			$modulo4["ihpn"] = $row->ihpn;
    			$modulo4["ihpnr"] = $row->ihpnr;
    			$modulo4["huetot"] = $row->huetot;
    			$modulo4["mvnr"] = $row->mvnr;
    			$modulo4["mvnnr"] = $row->mvnnr;
    			$modulo4["mvcr"] = $row->mvcr;
    			$modulo4["mvcnr"] = $row->mvcnr;
    			$modulo4["mvor"] = $row->mvor;
    			$modulo4["mvonr"] = $row->mvonr;
    			$modulo4["mvsr"] = $row->mvsr;
    			$modulo4["mvsnr"] = $row->mvsnr;
    			$modulo4["mvotr"] = $row->mvotr;
    			$modulo4["mvotnr"] = $row->mvotnr;
    			$modulo4["mvott"] = $row->mvott;
    			$modulo4["mvottnr"] = $row->mvottnr;
    			$modulo4["thsen"] = $row->thsen;
    			$modulo4["thusen"] = $row->thusen;
    			$modulo4["ingsen"] = $row->ingsen;
    			$modulo4["inalosen"] = $row->inalosen;
    			$modulo4["thdob"] = $row->thdob;
    			$modulo4["thudob"] = $row->thudob;
    			$modulo4["ingdob"] = $row->ingdob;
    			$modulo4["inalodob"] = $row->inalodob;
    			$modulo4["thsui"] = $row->thsui;
    			$modulo4["thusui"] = $row->thusui;
    			$modulo4["ingsui"] = $row->ingsui;
    			$modulo4["inalosui"] = $row->inalosui;
    			$modulo4["thmult"] = $row->thmult;
    			$modulo4["thumult"] = $row->thumult;
    			$modulo4["ingmult"] = $row->ingmult;
    			$modulo4["inalomul"] = $row->inalomul;
    			$modulo4["thotr"] = $row->thotr;
    			$modulo4["thuotr"] = $row->thuotr;
    			$modulo4["ingotr"] = $row->ingotr;
    			$modulo4["inalootr"] = $row->inalootr;
    			$modulo4["thtot"] = $row->thtot;
    			$modulo4["ingtot"] = $row->ingtot;
    			$modulo4["inalotot"] = $row->inalotot;
    		}   			
   		}
   		else{
   			$modulo4["op"] = "insert";
    		$modulo4["imagen"] = 0;
    		$modulo4["habdia"] = "";
    		$modulo4["ihdo"] = ""; 
    		$modulo4["ihoa"] = "";
    		$modulo4["camdia"] = "";
    		$modulo4["icda"] = "";
    		$modulo4["icva"] = "";
    		$modulo4["ihpn"] = "";
    		$modulo4["ihpnr"] = "";
    		$modulo4["huetot"] = "";
    		$modulo4["mvnr"] = "";
    		$modulo4["mvnnr"] = "";
    		$modulo4["mvcr"] = "";
    		$modulo4["mvcnr"] = "";
    		$modulo4["mvor"] = "";
    		$modulo4["mvonr"] = "";
    		$modulo4["mvsr"] = "";
    		$modulo4["mvsnr"] = "";
    		$modulo4["mvotr"] = "";
    		$modulo4["mvotnr"] = "";
    		$modulo4["mvott"] = "";
    		$modulo4["mvottnr"] = "";
    		$modulo4["thsen"] = "";
    		$modulo4["thusen"] = "";
    		$modulo4["ingsen"] = "";
    		$modulo4["inalosen"] = "";
    		$modulo4["thdob"] = "";
    		$modulo4["thudob"] = "";
    		$modulo4["ingdob"] = "";
    		$modulo4["inalodob"] = "";
    		$modulo4["thsui"] = "";
    		$modulo4["thusui"] = "";
    		$modulo4["ingsui"] = "";
    		$modulo4["inalosui"] = "";
    		$modulo4["thmult"] = "";
    		$modulo4["thumult"] = "";
    		$modulo4["ingmult"] = "";
    		$modulo4["inalomul"] = "";
    		$modulo4["thotr"] = "";
    		$modulo4["thuotr"] = "";
    		$modulo4["ingotr"] = "";
    		$modulo4["inalootr"] = "";
    		$modulo4["thtot"] = "";
    		$modulo4["ingtot"] = "";
    		$modulo4["inalotot"] = "";
   		}   	
    	$this->db->close();
   		return $modulo4;   		
    }
    
    function actualizarModulo($habdia, $ihdo, $ihoa, $camdia, $icda, $icva, $ihpn, $ihpnr, $huetot, $mvnr, $mvcr, $mvor, $mvsr, $mvotr, $mvott, $mvnnr, $mvcnr, $mvonr, $mvsnr, $mvotnr, $mvottnr, $thsen, $thusen, $thdob, $thudob, $thsui, $thusui, $thmult, $thumult, $thotr, $thuotr, $thtot, $ingsen, $ingdob, $ingsui, $ingmult, $ingotr, $ingtot, $tphto, $inalosen, $inalodob, $inalosui, $inalomul, $inalootr, $inalotot, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$data = array('habdia' => $habdia, 'ihdo' => $ihdo, 
    	              'ihoa' => $ihoa, 'camdia' => $camdia, 
    	              'icda' => $icda, 'icva' => $icva, 
    	              'ihpn' => $ihpn, 'ihpnr' => $ihpnr, 
    	              'huetot' => $huetot, 'mvnr' => $mvnr, 
    	              'mvcr' => $mvcr, 'mvor' => $mvor, 
    	              'mvsr' => $mvsr, 'mvotr' => $mvotr, 
    	              'mvott' => $mvott, 'mvnnr' => $mvnnr, 
    	              'mvcnr' => $mvcnr, 'mvonr' => $mvonr, 
    	              'mvsnr' => $mvsnr, 'mvotnr' => $mvotnr, 
    	              'mvottnr' => $mvottnr, 'thsen' => $thsen, 
    	              'thusen' => $thusen, 'thdob' => $thdob, 
    			      'thudob' => $thudob, 'thsui' => $thsui, 
    	              'thusui' => $thusui, 'thmult' => $thmult,
    			      'thumult' => $thumult, 'thotr' => $thotr, 
    	              'thuotr' => $thuotr, 'thtot' => $thtot,
    			      'ingsen' => $ingsen, 'ingdob' => $ingdob,
    			      'ingsui' => $ingsui, 'ingmult' => $ingmult,
    			      'ingotr' => $ingotr, 'ingtot' => $ingtot,
    			      'tphto' => $tphto, 'inalosen' => $inalosen,
    			      'inalodob' => $inalodob, 'inalosui' => $inalosui,
    			      'inalomul' => $inalomul, 'inalootr' => $inalootr,
    			      'inalotot' => $inalotot);
    	$this->db->where("nro_orden", $nro_orden);
		$this->db->where("nro_establecimiento", $nro_establecimiento);
		$this->db->where("ano_periodo", $ano_periodo);
		$this->db->where("mes_periodo", $mes_periodo);
    	$this->db->update('rmmh_form_caracthoteles', $data);
		$this->db->close();
    }
    
    function insertarModulo($habdia, $ihdo, $ihoa, $camdia, $icda, $icva, $ihpn, $ihpnr, $huetot, $mvnr, $mvcr, $mvor, $mvsr, $mvotr, $mvott, $mvnnr, $mvcnr, $mvonr, $mvsnr, $mvotnr, $mvottnr, $thsen, $thusen, $thdob, $thudob, $thsui, $thusui, $thmult, $thumult, $thotr, $thuotr, $thtot, $ingsen, $ingdob, $ingsui, $ingmult, $ingotr, $ingtot, $tphto, $inalosen, $inalodob, $inalosui, $inalomul, $inalootr, $inalotot, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$data = array('habdia' => $habdia, 'ihdo' => $ihdo, 
    	              'ihoa' => $ihoa, 'camdia' => $camdia, 
    	              'icda' => $icda, 'icva' => $icva, 
    	              'ihpn' => $ihpn, 'ihpnr' => $ihpnr, 
    	              'huetot' => $huetot, 'mvnr' => $mvnr, 
    	              'mvcr' => $mvcr, 'mvor' => $mvor, 
    	              'mvsr' => $mvsr, 'mvotr' => $mvotr, 
    	              'mvott' => $mvott, 'mvnnr' => $mvnnr, 
    	              'mvcnr' => $mvcnr, 'mvonr' => $mvonr, 
    	              'mvsnr' => $mvsnr, 'mvotnr' => $mvotnr, 
    	              'mvottnr' => $mvottnr, 'thsen' => $thsen, 
    	              'thusen' => $thusen, 'thdob' => $thdob,
    			      'thudob' => $thudob, 'thsui' => $thsui,
    			      'thusui' => $thusui, 'thmult' => $thmult,
    			      'thumult' => $thumult, 'thotr' => $thotr, 
    	              'thoutr' => $thoutr, 'thtot' => $thtot,
    			      'ingsen' => $ingsen, 'ingdob' => $ingdob,
    			      'ingsui' => $ingsui, 'ingmult' => $ingmult,
    			      'ingotr' => $ingotr, 'ingtot' => $ingtot,
    			      'tphto' => $tphto, 'inalosen' => $inalosen,
    			      'inalodob' => $inalodob, 'inalosui' => $inalosui,
    			      'inalomul' => $inalomul, 'inalootr' => $inalootr,
    			      'inalotot' => $inalotot, 'nro_orden' => $nro_orden,
    			      'nro_establecimiento' => $nro_establecimiento,
    	              'ano_periodo' => $ano_periodo, 'mes_periodo' => $mes_periodo);
    	$this->db->insert('rmmh_form_caracthoteles', $data);
		$this->db->close();
    }
    
	function existeRegistro($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$retorno = false;
    	$sql = "SELECT * 
    	        FROM rmmh_form_caracthoteles 
    	        WHERE nro_orden = $nro_orden
    	        AND nro_establecimiento = $nro_establecimiento
    	        AND ano_periodo = $ano_periodo
    	        AND mes_periodo = $mes_periodo";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0)
    		$retorno = true;
    	return $retorno;	
    }
    
   
}//EOC  
