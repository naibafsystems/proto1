<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Capitulo4 extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->library("session");        
    }
    
    function obtenerCapitulo(){
    	$capitulo4 = array();
    	$nro_orden = $this->session->userdata("nro_orden");
    	$uni_local = $this->session->userdata("uni_local");
    	$ano_periodo = $this->session->userdata("ano_periodo");
    	$mes_periodo = $this->session->userdata("mes_periodo");
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
      			$capitulo4["op"] = "update";
    			$capitulo4["imagen"] = $row->cap4;
    			$capitulo4["habdia"] = $row->habdia;
    			$capitulo4["ihdo"] = $row->ihdo; 
    			$capitulo4["ihoa"] = $row->ihoa;
    			$capitulo4["camdia"] = $row->camdia;
    			$capitulo4["icda"] = $row->icda;
    			$capitulo4["icva"] = $row->icva;
    			$capitulo4["ihpn"] = $row->ihpn;
    			$capitulo4["ihpnr"] = $row->ihpnr;
    			$capitulo4["huetot"] = $row->huetot;
    			$capitulo4["mvnr"] = $row->mvnr;
    			$capitulo4["mvnnr"] = $row->mvnnr;
    			$capitulo4["mvcr"] = $row->mvcr;
    			$capitulo4["mvcnr"] = $row->mvcnr;
    			$capitulo4["mvor"] = $row->mvor;
    			$capitulo4["mvonr"] = $row->mvonr;
    			$capitulo4["mvsr"] = $row->mvsr;
    			$capitulo4["mvsnr"] = $row->mvsnr;
    			$capitulo4["mvotr"] = $row->mvotr;
    			$capitulo4["mvotnr"] = $row->mvotnr;
    			$capitulo4["mvott"] = $row->mvott;
    			$capitulo4["mvottnr"] = $row->mvottnr;
    			$capitulo4["thsen"] = $row->thsen;
    			$capitulo4["ingsen"] = $row->ingsen;
    			$capitulo4["inalosen"] = $row->inalosen;
    			$capitulo4["thdob"] = $row->thdob;
    			$capitulo4["ingdob"] = $row->ingdob;
    			$capitulo4["inalodob"] = $row->inalodob;
    			$capitulo4["thsui"] = $row->thsui;
    			$capitulo4["ingsui"] = $row->ingsui;
    			$capitulo4["inalosui"] = $row->inalosui;
    			$capitulo4["thmult"] = $row->thmult;
    			$capitulo4["ingmult"] = $row->ingmult;
    			$capitulo4["inalomul"] = $row->inalomul;
    			$capitulo4["thotr"] = $row->thotr;
    			$capitulo4["ingotr"] = $row->ingotr;
    			$capitulo4["inalootr"] = $row->inalootr;
    			$capitulo4["thtot"] = $row->thtot;
    			$capitulo4["ingtot"] = $row->ingtot;
    			$capitulo4["inalotot"] = $row->inalotot;
    		}   			
   		}
   		else{
   			$capitulo4["op"] = "insert";
    		$capitulo4["imagen"] = 0;
    		$capitulo4["habdia"] = "";
    		$capitulo4["ihdo"] = ""; 
    		$capitulo4["ihoa"] = "";
    		$capitulo4["camdia"] = "";
    		$capitulo4["icda"] = "";
    		$capitulo4["icva"] = "";
    		$capitulo4["ihpn"] = "";
    		$capitulo4["ihpnr"] = "";
    		$capitulo4["huetot"] = "";
    		$capitulo4["mvnr"] = "";
    		$capitulo4["mvnnr"] = "";
    		$capitulo4["mvcr"] = "";
    		$capitulo4["mvcnr"] = "";
    		$capitulo4["mvor"] = "";
    		$capitulo4["mvonr"] = "";
    		$capitulo4["mvsr"] = "";
    		$capitulo4["mvsnr"] = "";
    		$capitulo4["mvotr"] = "";
    		$capitulo4["mvotnr"] = "";
    		$capitulo4["mvott"] = "";
    		$capitulo4["mvottnr"] = "";
    		$capitulo4["thsen"] = "";
    		$capitulo4["ingsen"] = "";
    		$capitulo4["inalosen"] = "";
    		$capitulo4["thdob"] = "";
    		$capitulo4["ingdob"] = "";
    		$capitulo4["inalodob"] = "";
    		$capitulo4["thsui"] = "";
    		$capitulo4["ingsui"] = "";
    		$capitulo4["inalosui"] = "";
    		$capitulo4["thmult"] = "";
    		$capitulo4["ingmult"] = "";
    		$capitulo4["inalomul"] = "";
    		$capitulo4["thotr"] = "";
    		$capitulo4["ingotr"] = "";
    		$capitulo4["inalootr"] = "";
    		$capitulo4["thtot"] = "";
    		$capitulo4["ingtot"] = "";
    		$capitulo4["inalotot"] = "";
   		}   	
    	$this->db->close();
   		return $capitulo4;
    }
    
    function insertarCapitulo($habdia, $ihdo, $ihoa, $camdia, $icda, $icva, $ihpn, $ihpnr, $huetot, 
                              $mvnr, $mvnnr, $mvcr, $mvcnr, $mvor, $mvonr, $mvsr, $mvsnr, $mvotr, $mvotnr, $mvott, $mvottnr, 
                              $thsen, $ingsen, $inalosen, $thdob, $ingdob, $inalodob, $thsui, $ingsui, $inalosui, $thmult, $ingmult, $inalomul, $thotr, $ingotr, $inalootr, $thtot, $ingtot, $inalotot){            
    	$nro_orden = $this->session->userdata("nro_orden");     //Obtener desde la sesion
    	$uni_local = $this->session->userdata("uni_local");     //Obtener desde la sesion
    	$ano_periodo = $this->session->userdata("ano_periodo"); //Obtener desde la sesion
    	$mes_periodo = $this->session->userdata("mes_periodo"); //Obtener desde la sesion
    	$data = array('nro_orden' => $nro_orden,
    	              'uni_local' => $uni_local,
    	              'ano_periodo' => $ano_periodo,
    	              'mes_periodo' => $mes_periodo,
    	              'habdia' => $habdia,
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
    				  'mvcr' => $mvcr,
    	              'mvcnr' => $mvcnr,
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
		$this->db->insert('rmmh_form_caracthoteles', $data);
		$this->db->close();
    }

	function actualizarCapitulo($habdia, $ihdo, $ihoa, $camdia, $icda, $icva, $ihpn, $ihpnr, $huetot, 
                                $mvnr, $mvnnr, $mvcr, $mvcnr, $mvor, $mvonr, $mvsr, $mvsnr, $mvotr, $mvotnr, $mvott, $mvottnr, 
                                $thsen, $ingsen, $inalosen, $thdob, $ingdob, $inalodob, $thsui, $ingsui, $inalosui, $thmult, $ingmult, $inalomul, $thotr, $ingotr, $inalootr, $thtot, $ingtot, $inalotot){            
    	$nro_orden = $this->session->userdata("nro_orden");     //Obtener desde la sesion
    	$uni_local = $this->session->userdata("uni_local");     //Obtener desde la sesion
    	$ano_periodo = $this->session->userdata("ano_periodo"); //Obtener desde la sesion
    	$mes_periodo = $this->session->userdata("mes_periodo"); //Obtener desde la sesion
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
    				  'mvcr' => $mvcr,
    	              'mvcnr' => $mvcnr,
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
    
	function actualizarCapituloCritico($nro_orden, $uni_local, $habdia, $ihdo, $ihoa, $camdia, $icda, $icva, $ihpn, $ihpnr, $huetot, 
                                $mvnr, $mvnnr, $mvcr, $mvcnr, $mvor, $mvonr, $mvsr, $mvsnr, $mvotr, $mvotnr, $mvott, $mvottnr, 
                                $thsen, $ingsen, $inalosen, $thdob, $ingdob, $inalodob, $thsui, $ingsui, $inalosui, $thmult, $ingmult, $inalomul, $thotr, $ingotr, $inalootr, $thtot, $ingtot, $inalotot){            
    	$ano_periodo = $this->session->userdata("ano_periodo"); //Obtener desde la sesion
    	$mes_periodo = $this->session->userdata("mes_periodo"); //Obtener desde la sesion
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
    				  'mvcr' => $mvcr,
    	              'mvcnr' => $mvcnr,
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
    
	public function obtenerInfoCapitulo($nro_orden, $uni_local){
    	$capitulo4 = array(
    	  'op'=>'',
    	  'imagen'=>0,
    	  'habdia'=>'',
    	  'ihdo'=>'',
    	  'ihoa'=>'',
    	  'camdia'=>'',
    	  'icda'=>'',
    	  'icva'=>'',
    	  'ihpn'=>'',
    	  'ihpnr'=>'',
    	  'huetot'=>'',
    	  'mvnr'=>'',
    	  'mvnnr'=>'',
    	  'mvcr' => '',
    	  'mvcnr' => '',
    	  'mvor'=>'',
    	  'mvonr'=>'',
    	  'mvsr'=>'',
    	  'mvsnr'=>'',
    	  'mvotr'=>'',
    	  'mvotnr'=>'',
    	  'mvott'=>'',
    	  'mvottnr'=>'',
    	  'thsen'=>'',
    	  'ingsen'=>'',
    	  'inalosen'=>'',
    	  'thdob'=>'',
    	  'ingdob'=>'',
    	  'inalodob'=>'',
    	  'thsui'=>'',
    	  'ingsui'=>'',
    	  'inalosui'=>'',
    	  'thmult'=>'',
    	  'ingmult'=>'',
    	  'inalomul'=>'',
    	  'thotr'=>'',
    	  'ingotr'=>'',
    	  'inalootr'=>'',
    	  'thtot'=>'',
    	  'ingtot'=>'',
    	  'inalotot'=>''
    	);
    	$ano_periodo = $this->session->userdata("ano_periodo");
    	$mes_periodo = $this->session->userdata("mes_periodo");
    	$sql = "SELECT *
				FROM rmmh_form_caracthoteles C4, rmmh_admin_control CTRL
				WHERE C4.nro_orden = CTRL.nro_orden
				AND C4.uni_local = CTRL.uni_local
				AND C4.ano_periodo = CTRL.ano_periodo
				AND C4.mes_periodo = CTRL.mes_periodo
				AND CTRL.nro_orden = $nro_orden
				AND CTRL.uni_local = $uni_local
				AND CTRL.ano_periodo = $ano_periodo
				AND CTRL.mes_periodo = $mes_periodo";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
      			$capitulo4["op"] = "update";
    			$capitulo4["imagen"] = $row->cap4;
    			$capitulo4["habdia"] = $row->habdia;
    			$capitulo4["ihdo"] = $row->ihdo; 
    			$capitulo4["ihoa"] = $row->ihoa;
    			$capitulo4["camdia"] = $row->camdia;
    			$capitulo4["icda"] = $row->icda;
    			$capitulo4["icva"] = $row->icva;
    			$capitulo4["ihpn"] = $row->ihpn;
    			$capitulo4["ihpnr"] = $row->ihpnr;
    			$capitulo4["huetot"] = $row->huetot;
    			$capitulo4["mvnr"] = $row->mvnr;
    			$capitulo4["mvnnr"] = $row->mvnnr;
    			$capitulo4["mvcr"] = $row->mvcr;
    			$capitulo4["mvcnr"] = $row->mvcnr;
    			$capitulo4["mvor"] = $row->mvor;
    			$capitulo4["mvonr"] = $row->mvonr;
    			$capitulo4["mvsr"] = $row->mvsr;
    			$capitulo4["mvsnr"] = $row->mvsnr;
    			$capitulo4["mvotr"] = $row->mvotr;
    			$capitulo4["mvotnr"] = $row->mvotnr;
    			$capitulo4["mvott"] = $row->mvott;
    			$capitulo4["mvottnr"] = $row->mvottnr;
    			$capitulo4["thsen"] = $row->thsen;
    			$capitulo4["ingsen"] = $row->ingsen;
    			$capitulo4["inalosen"] = $row->inalosen;
    			$capitulo4["thdob"] = $row->thdob;
    			$capitulo4["ingdob"] = $row->ingdob;
    			$capitulo4["inalodob"] = $row->inalodob;
    			$capitulo4["thsui"] = $row->thsui;
    			$capitulo4["ingsui"] = $row->ingsui;
    			$capitulo4["inalosui"] = $row->inalosui;
    			$capitulo4["thmult"] = $row->thmult;
    			$capitulo4["ingmult"] = $row->ingmult;
    			$capitulo4["inalomul"] = $row->inalomul;
    			$capitulo4["thotr"] = $row->thotr;
    			$capitulo4["ingotr"] = $row->ingotr;
    			$capitulo4["inalootr"] = $row->inalootr;
    			$capitulo4["thtot"] = $row->thtot;
    			$capitulo4["ingtot"] = $row->ingtot;
    			$capitulo4["inalotot"] = $row->inalotot;     			
    		}   			
   		}
   		$this->db->close();
   		return $capitulo4;
    }
    
    
   
}//EOC  
