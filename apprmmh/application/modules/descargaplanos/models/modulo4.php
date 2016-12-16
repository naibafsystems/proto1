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
    
    function actualizarModulo($habdia, $ihdo, $ihoa, $camdia, $icda, $icva, $ihpn, $ihpnr, $huetot, $mvnr, $mvcr, $mvor, $mvsr, $mvotr, $mvott, $mvnnr, $mvcnr, $mvonr, $mvsnr, $mvotnr, $mvottnr, $thsen, $thusen, $thdob, $thudob, $thsui, $thusui, $thmult,  $thumult, $thotr, $thuotr, $thtot, $ingsen, $ingdob, $ingsui, $ingmult, $ingotr, $ingtot, $tphto, $inalosen, $inalodob, $inalosui, $inalomul, $inalootr, $inalotot, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
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
    	              'mvottnr' => $mvottnr,
    			      'thsen' => $thsen, 'thusen' => $thusen, 
    	              'thdob' => $thdob, 'thudob' => $thudob,
    			      'thsui' => $thsui, 'thusui' => $thusui,
    	              'thmult' => $thmult, 'thumult' => $thumult,
    				  'thotr' => $thotr, 'thuotr' => $thuotr,
    	              'thtot' => $thtot, 'ingsen' => $ingsen, 
    	              'ingdob' => $ingdob, 'ingsui' => $ingsui, 
    	              'ingmult' => $ingmult, 'ingotr' => $ingotr, 
    	              'ingtot' => $ingtot, 'tphto' => $tphto, 
    	              'inalosen' => $inalosen, 'inalodob' => $inalodob, 
    	              'inalosui' => $inalosui, 'inalomul' => $inalomul, 
    	              'inalootr' => $inalootr, 'inalotot' => $inalotot);
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
    	              'mvottnr' => $mvottnr,
    			      'thsen' => $thsen, 'thusen' => $thusen,
    	              'thdob' => $thdob, 'thudob' => $thudob,
    				  'thsui' => $thsui, 'thusui' => $thusui, 
    	              'thmult' => $thmult, 'thumult' => $thumult,
    			      'thotr' => $thotr, 'thuotr' => $thuotr,
    	              'thtot' => $thtot, 'ingsen' => $ingsen, 
    	              'ingdob' => $ingdob, 'ingsui' => $ingsui, 
    	              'ingmult' => $ingmult, 'ingotr' => $ingotr, 
    	              'ingtot' => $ingtot, 'tphto' => $tphto, 
    	              'inalosen' => $inalosen, 'inalodob' => $inalodob, 
    	              'inalosui' => $inalosui, 'inalomul' => $inalomul, 
    	              'inalootr' => $inalootr, 'inalotot' => $inalotot,
    	              'nro_orden' => $nro_orden, 'nro_establecimiento' => $nro_establecimiento,
    	              'ano_periodo' => $ano_periodo, 'mes_periodo' => $mes_periodo);
    	$this->db->insert('rmmh_form_caracthoteles', $data);
		$this->db->close();
    }
    
	function descargaPlanosModulo($ano_periodo, $mes_periodo){
    	$modulo4 = array();
    	/* SE CAMBIA ESTA CONSULTA PARA HACER QUE EL ESTADO DE LA NOVEDAD DEL CAPITULO COINCIDA CON LA QUE ESTÁ REPORTADA EN EL HISTORICO DE NOVEDADES
    	$sql = "SELECT C.nro_orden, C.nro_establecimiento, C.ano_periodo, C.mes_periodo,
    	               IFNULL(CH.habdia,0) AS habdia,
                       IFNULL(CH.ihdo,0) AS ihdo,
                       IFNULL(CH.ihoa,0) AS ihoa,
                       IFNULL(CH.camdia,0) AS camdia,
                       IFNULL(CH.icda,0) AS icda,
                       IFNULL(CH.icva,0) AS icva,
                       IFNULL(CH.ihpn,0) AS ihpn,
                       IFNULL(CH.ihpnr,0) AS ihpnr,
                       IFNULL(CH.huetot,0) AS huetot,
                       IFNULL(CH.mvnr,0) AS mvnr,
                       IFNULL(CH.mvcr,0) AS mvcr,
                       IFNULL(CH.mvor,0) AS mvor,
                       IFNULL(CH.mvsr,0) AS mvsr,
                       IFNULL(CH.mvotr,0) AS mvotr,
                       IFNULL(CH.mvott,0) AS mvott,
                       IFNULL(CH.mvnnr,0) AS mvnnr,
                       IFNULL(CH.mvcnr,0) AS mvcnr,
                       IFNULL(CH.mvonr,0) AS mvonr,
                       IFNULL(CH.mvsnr,0) AS mvsnr,
                       IFNULL(CH.mvotnr,0) AS mvotnr,
                       IFNULL(CH.mvottnr,0) AS mvottnr,
                       IFNULL(CH.thsen,0) AS thsen,
                       IFNULL(CH.thdob,0) AS thdob,
                       IFNULL(CH.thsui,0) AS thsui,
                       IFNULL(CH.thmult,0) AS thmult,
                       IFNULL(CH.thotr,0) AS thotr,
                       IFNULL(CH.thtot,0) AS thtot,
                       IFNULL(CH.ingsen,0) AS ingsen,
                       IFNULL(CH.ingdob,0) AS ingdob,
                       IFNULL(CH.ingsui,0) AS ingsui,
                       IFNULL(CH.ingmult,0) AS ingmult,
                       IFNULL(CH.ingotr,0) AS ingotr,
                       IFNULL(CH.ingtot,0) AS ingtot,
                       IFNULL(CH.tphto,0) AS tphto,
                       IFNULL(CH.inalosen,0) AS inalosen,
                       IFNULL(CH.inalodob,0) AS inalodob,
                       IFNULL(CH.inalosui,0) AS inalosui,
                       IFNULL(CH.inalomul,0) AS inalomul,
                       IFNULL(CH.inalootr,0) AS inalootr,
                       IFNULL(CH.inalotot,0) AS inalotot,
                       C.fk_novedad, C.fk_estado
                FROM rmmh_admin_control C
                LEFT JOIN rmmh_form_caracthoteles CH ON (C.nro_orden = CH.nro_orden AND C.nro_establecimiento = CH.nro_establecimiento AND C.ano_periodo = CH.ano_periodo AND C.mes_periodo = CH.mes_periodo)
                WHERE C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo
                ORDER BY C.nro_establecimiento ASC";*/
    	$sql = "SELECT C.nro_orden, C.nro_establecimiento, C.ano_periodo, C.mes_periodo, EST.fk_ciiu AS idact,
                       IFNULL(CH.habdia,0) AS habdia, IFNULL(CH.ihdo,0) AS ihdo,
                       IFNULL(CH.ihoa,0) AS ihoa, IFNULL(CH.camdia,0) AS camdia,
                       IFNULL(CH.icda,0) AS icda, IFNULL(CH.icva,0) AS icva,
                       IFNULL(CH.ihpn,0) AS ihpn, IFNULL(CH.ihpnr,0) AS ihpnr,
                       IFNULL(CH.huetot,0) AS huetot, IFNULL(CH.mvnr,0) AS mvnr,
                       IFNULL(CH.mvcr,0) AS mvcr, IFNULL(CH.mvor,0) AS mvor,
                       IFNULL(CH.mvsr,0) AS mvsr, IFNULL(CH.mvotr,0) AS mvotr,
                       IFNULL(CH.mvott,0) AS mvott, IFNULL(CH.mvnnr,0) AS mvnnr,
                       IFNULL(CH.mvcnr,0) AS mvcnr, IFNULL(CH.mvonr,0) AS mvonr,
                       IFNULL(CH.mvsnr,0) AS mvsnr, IFNULL(CH.mvotnr,0) AS mvotnr,
                       IFNULL(CH.mvottnr,0) AS mvottnr, 
                       IFNULL(CH.thsen,0) AS thsen, IFNULL(CH.thusen,0) AS thusen,
                       IFNULL(CH.thdob,0) AS thdob, IFNULL(CH.thudob,0) AS thudob,
                       IFNULL(CH.thsui,0) AS thsui, IFNULL(CH.thusui,0) AS thusui,
                       IFNULL(CH.thmult,0) AS thmult, IFNULL(CH.thumult,0) AS thumult,
                       IFNULL(CH.thotr,0) AS thotr, IFNULL(CH.thuotr,0) AS thuotr,
                       IFNULL(CH.thtot,0) AS thtot, IFNULL(CH.ingsen,0) AS ingsen,
                       IFNULL(CH.ingdob,0) AS ingdob, IFNULL(CH.ingsui,0) AS ingsui,
                       IFNULL(CH.ingmult,0) AS ingmult, IFNULL(CH.ingotr,0) AS ingotr,
                       IFNULL(CH.ingtot,0) AS ingtot, IFNULL(CH.tphto,0) AS tphto,
                       IFNULL(CH.inalosen,0) AS inalosen, IFNULL(CH.inalodob,0) AS inalodob,
                       IFNULL(CH.inalosui,0) AS inalosui, IFNULL(CH.inalomul,0) AS inalomul,
                       IFNULL(CH.inalootr,0) AS inalootr, IFNULL(CH.inalotot,0) AS inalotot,
                       IFNULL(HN.fk_novedad, C.fk_novedad) AS fk_novedad, C.fk_estado
                FROM rmmh_admin_control C
                LEFT JOIN rmmh_admin_histnovedades HN ON (C.nro_orden = HN.nro_orden
                                                          AND C.nro_establecimiento = HN.nro_establecimiento
                                                          AND C.ano_periodo = HN.ano_periodo
                                                          AND C.mes_periodo = HN.mes_periodo)
                LEFT JOIN rmmh_form_caracthoteles CH ON (C.nro_orden = CH.nro_orden
                                                         AND C.nro_establecimiento = CH.nro_establecimiento
                                                         AND C.ano_periodo = CH.ano_periodo
                                                         AND C.mes_periodo = CH.mes_periodo)
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
      			$modulo4[$i]["nro_orden"] = $row->nro_orden; 
      			$modulo4[$i]["nro_establecimiento"] = $row->nro_establecimiento; 
      			$modulo4[$i]["ano_periodo"] = $row->ano_periodo; 
      			$modulo4[$i]["mes_periodo"] = $row->mes_periodo;
      			$modulo4[$i]["idact"] = $row->idact;
    			$modulo4[$i]["habdia"] = $row->habdia; 
      			$modulo4[$i]["ihdo"] = $row->ihdo; 
      			$modulo4[$i]["ihoa"] = $row->ihoa; 
      			$modulo4[$i]["camdia"] = $row->camdia; 
      			$modulo4[$i]["icda"] = $row->icda; 
      			$modulo4[$i]["icva"] = $row->icva; 
      			$modulo4[$i]["ihpn"] = $row->ihpn; 
      			$modulo4[$i]["ihpnr"] = $row->ihpnr; 
      			$modulo4[$i]["huetot"] = $row->huetot; 
      			$modulo4[$i]["mvnr"] = $row->mvnr; 
      			$modulo4[$i]["mvcr"] = $row->mvcr; 
      			$modulo4[$i]["mvor"] = $row->mvor; 
      			$modulo4[$i]["mvsr"] = $row->mvsr; 
      			$modulo4[$i]["mvotr"] = $row->mvotr; 
      			$modulo4[$i]["mvott"] = $row->mvott; 
      			$modulo4[$i]["mvnnr"] = $row->mvnnr; 
      			$modulo4[$i]["mvcnr"] = $row->mvcnr; 
      			$modulo4[$i]["mvonr"] = $row->mvonr; 
      			$modulo4[$i]["mvsnr"] = $row->mvsnr; 
      			$modulo4[$i]["mvotnr"] = $row->mvotnr; 
      			$modulo4[$i]["mvottnr"] = $row->mvottnr; 
      			$modulo4[$i]["thsen"] = $row->thsen;
      			$modulo4[$i]["thusen"] = $row->thusen;
      			$modulo4[$i]["thdob"] = $row->thdob;
      			$modulo4[$i]["thudob"] = $row->thudob;
      			$modulo4[$i]["thsui"] = $row->thsui;
      			$modulo4[$i]["thusui"] = $row->thusui;
      			$modulo4[$i]["thmult"] = $row->thmult;
      			$modulo4[$i]["thumult"] = $row->thumult;
      			$modulo4[$i]["thotr"] = $row->thotr;
      			$modulo4[$i]["thuotr"] = $row->thuotr;
      			$modulo4[$i]["thtot"] = $row->thtot; 
      			$modulo4[$i]["ingsen"] = $row->ingsen; 
      			$modulo4[$i]["ingdob"] = $row->ingdob; 
      			$modulo4[$i]["ingsui"] = $row->ingsui; 
      			$modulo4[$i]["ingmult"] = $row->ingmult; 
      			$modulo4[$i]["ingotr"] = $row->ingotr; 
      			$modulo4[$i]["ingtot"] = $row->ingtot; 
      			$modulo4[$i]["tphto"] = $row->tphto; 
      			$modulo4[$i]["inalosen"] = $row->inalosen; 
      			$modulo4[$i]["inalodob"] = $row->inalodob; 
      			$modulo4[$i]["inalosui"] = $row->inalosui; 
      			$modulo4[$i]["inalomul"] = $row->inalomul; 
      			$modulo4[$i]["inalootr"] = $row->inalootr; 
      			$modulo4[$i]["inalotot"] = $row->inalotot; 
      			$modulo4[$i]["fk_novedad"] = $row->fk_novedad;
      			$modulo4[$i]["fk_estado"] = $row->fk_estado;
      			$modulo4[$i]["estado"] = $this->novedad->nombreEstadoFormulario($row->fk_novedad, $row->fk_estado);
    			$i++;
    		}
    	}
    	$this->db->close();
   		return $modulo4;
    }
    
    ////Descarga consolidado módulo IV
	function descargaPlanosConsolidado($ano_periodo, $mes_periodo){
    	$modulo4 = array();
    	$sql = "SELECT  C.nro_orden, count(C.nro_establecimiento) as nro_establecimientos, 
    	    C.ano_periodo, C.mes_periodo, sum(CH.ihdo) as ihdo, 
            sum(CH.ihoa) as ihoa, sum(CH.icda) as icda, sum(CH.icva) as icva, 
            sum(CH.ihpn) as ihpn, sum(CH.ihpnr) as ihpnr,sum(CH.huetot) as huetot,
            round((((sum((CH.ihpn*(CH.mvnr/100))))/sum(CH.ihpn)))*100) as mvnr,
            round((((sum((CH.ihpnr*(CH.mvnnr/100))))/sum(CH.ihpnr)))*100) as mvnnr,
            round((((sum((CH.ihpn*(CH.mvcr/100))))/sum(CH.ihpn)))*100) as mvcr, 
            round((((sum((CH.ihpnr*(CH.mvcnr/100))))/sum(CH.ihpnr)))*100) as mvcnr,
            round((((sum((CH.ihpn*(CH.mvor/100))))/sum(CH.ihpn)))*100) as mvor,
            round((((sum((CH.ihpnr*(CH.mvonr/100))))/sum(CH.ihpnr)))*100) as mvonr,
            round((((sum((CH.ihpn*(CH.mvsr/100))))/sum(CH.ihpn)))*100) as mvsr,
            round((((sum((CH.ihpnr*(CH.mvsnr/100))))/sum(CH.ihpnr)))*100) as mvsnr,
            round((((sum((CH.ihpn*(CH.mvotr/100))))/sum(CH.ihpn)))*100) as mvotr,
            round((((sum((CH.ihpnr*(CH.mvotnr/100))))/sum(CH.ihpnr)))*100) as mvotnr,
    	    CH.mvott, CH.mvottnr,
           	sum(CH.thsen) as thsen, sum(CH.thusen) as thusen, 
        	sum(CH.thdob) as thdob, sum(CH.thudob) as thudob,  
    		sum(CH.thsui) as thsui, sum(CH.thusui) as thusui,
    		sum(CH.thmult) as thmult, sum(CH.thumult) as thumult,
        	sum(CH.thotr) as thotr, sum(CH.thuotr) as thuotr,
        	sum(CH.thtot) as thtot
    	FROM rmmh_form_caracthoteles CH, rmmh_admin_control C
    	WHERE CH.nro_orden = C.nro_orden
    	AND CH.nro_establecimiento = C.nro_establecimiento
    	AND CH.ano_periodo = C.ano_periodo
    	AND CH.mes_periodo = C.mes_periodo
    	AND C.ano_periodo = $ano_periodo
    	AND C.mes_periodo = $mes_periodo
    	GROUP BY C.nro_orden
    	ORDER BY C.nro_orden";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		$i=0;	
	    		foreach ($query->result() as $row){
		    		$modulo4[$i]["nro_orden"] = $row->nro_orden;
		    		$modulo4[$i]["nro_establecimientos"] = $row->nro_establecimientos;
		    		$modulo4[$i]["ano_periodo"] = $row->ano_periodo;
		    		$modulo4[$i]["mes_periodo"] = $row->mes_periodo;
		    		$modulo4[$i]["ihdo"] = $row->ihdo;
		    		$modulo4[$i]["ihoa"] = $row->ihoa;
		    		$modulo4[$i]["icda"] = $row->icda;
		    		$modulo4[$i]["icva"] = $row->icva;
		    		$modulo4[$i]["ihpn"] = $row->ihpn;
		    		$modulo4[$i]["ihpnr"] = $row->ihpnr;
		    		$modulo4[$i]["huetot"] = $row->huetot;
		    		$modulo4[$i]["thsen"] = $row->thsen;
		    		$modulo4[$i]["thusen"] = $row->thusen;
		    		$modulo4[$i]["thdob"] = $row->thdob;
		    		$modulo4[$i]["thudob"] = $row->thudob;
		    		$modulo4[$i]["thsui"] = $row->thsui;
		    		$modulo4[$i]["thusui"] = $row->thusui;
		    		$modulo4[$i]["thmult"] = $row->thmult;
		    		$modulo4[$i]["thumult"] = $row->thumult;
	    			$modulo4[$i]["thotr"] = $row->thotr;
	    			$modulo4[$i]["thuotr"] = $row->thuotr;
	    			$modulo4[$i]["thtot"] = $row->thtot;
	    			$modulo4[$i]["mvnr"] = $row->mvnr;
	    			$modulo4[$i]["mvnnr"] = $row->mvnnr;
	    			$modulo4[$i]["mvcr"] = $row->mvcr;
	    			$modulo4[$i]["mvcnr"] = $row->mvcnr;
	    			$modulo4[$i]["mvor"] = $row->mvor;
	    			$modulo4[$i]["mvonr"] = $row->mvonr;
	    			$modulo4[$i]["mvsr"] = $row->mvsr;
	    			$modulo4[$i]["mvsnr"] = $row->mvsnr;
	    			$modulo4[$i]["mvotr"] = $row->mvotr;
	    			$modulo4[$i]["mvotnr"] = $row->mvotnr;
	    										 
    				$modulo4[$i]["mvott"]=$modulo4[$i]["mvnr"]+$modulo4[$i]["mvcr"]+$modulo4[$i]["mvor"]+$modulo4[$i]["mvsr"]+$modulo4[$i]["mvotr"];
    									 
    				$modulo4[$i]["mvottnr"]=$modulo4[$i]["mvnnr"]+$modulo4[$i]["mvcnr"]+$modulo4[$i]["mvonr"]+$modulo4[$i]["mvsnr"]+$modulo4[$i]["mvotnr"];
    			$i++;
	    		}
    		}
    		
    $this->db->close();
    return $modulo4;
	}
    
}//EOC  
