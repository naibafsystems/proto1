<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Consolidado extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->library("session");        
    }
    
    /**
     * Descarga de planos histórico por empresa modulo 2
     * @author SJNEIRAG
     * @since 2015
     */
    function obtenerModulo2($nro_orden, $ano_periodo, $mes_periodo){
    	$modulo2 = array();
    	$sql = "SELECT C.modulo2, C.nro_orden, C.nro_establecimiento, PS.potpsfr, PS.potperm, PS.gpper, PS.pottcde, PS.gpssde, PS.pottcag, PS.gpppta, PS.potpau, PS.gppgpa, PS.pottot, PS.gpsspot
                FROM rmmh_form_persalarios PS, rmmh_admin_control C
                WHERE PS.nro_orden = C.nro_orden
                AND PS.nro_establecimiento = C.nro_establecimiento
                AND PS.ano_periodo = C.ano_periodo
                AND PS.mes_periodo = C.mes_periodo
                AND C.nro_orden = $nro_orden
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo";
    		$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		$sumaPototo=0;
    		$sumaPotpsfr=0;
    		$sumaPotperm=0;
    		$sumaGpper=0;
    		$sumaPottcde=0;
    		$sumaGpssde=0;
    		$sumaPottcag=0;
    		$sumaGpppta=0;
    		$sumaPotpau=0;
    		$sumaGppgpa=0;
    		$sumaGpsspot=0;
    		foreach ($query->result() as $row){
      			$modulo2["op"] = "update";
    			$modulo2["imagen"] = $row->modulo2;
    			$sumaPotpsfr += $row->potpsfr;
    			$modulo2["potpsfr"] = $sumaPotpsfr;
    			$sumaPotperm += $row->potperm;
    			$modulo2["potperm"] = $sumaPotperm;
    			$sumaGpper += $row->gpper;
    			$modulo2["gpper"] = $sumaGpper;
    			$sumaPottcde += $row->pottcde;
    			$modulo2["pottcde"] = $sumaPottcde;
    			$sumaGpssde += $row->gpssde;
				$modulo2["gpssde"] = $sumaGpssde;
				$sumaPottcag += $row->pottcag;
				$modulo2["pottcag"] = $sumaPottcag;	
				$sumaGpppta += $row->gpppta;
				$modulo2["gpppta"] = $sumaGpppta;
				$sumaPotpau += $row->potpau;
				$modulo2["potpau"] = $sumaPotpau;
				$sumaGppgpa += $row->gppgpa;
				$modulo2["gppgpa"] = $sumaGppgpa;	    			      		
				$sumaPototo +=  $row->pottot;
				$modulo2["pottot"]=$sumaPototo;
				$sumaGpsspot +=  $row->gpsspot;
				$modulo2["gpsspot"] = $sumaGpsspot;
				//echo "mmm".$suma."nooo";
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
    
    /**
     * Descarga de planos histórico por empresa modulo 3
     * @author SJNEIRAG
     * @since 2015
     */
    function obtenerModulo3($nro_orden, $ano_periodo, $mes_periodo){
    	$modulo3 = array();
    	$sql = "SELECT C.modulo3, IO.inalo, IO.inali, IO.inba, IO.insr, IO.inoe, IO.inoio, IO.intio
    	FROM rmmh_form_ingoperacionales IO, rmmh_admin_control C
    	WHERE IO.nro_orden = C.nro_orden
    	AND IO.nro_establecimiento = C.nro_establecimiento
    	AND IO.ano_periodo = C.ano_periodo
    	AND IO.mes_periodo = C.mes_periodo
    	AND C.nro_orden = $nro_orden
    	AND C.ano_periodo = $ano_periodo
    	AND C.mes_periodo = $mes_periodo";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		$sumaInalo=0;
    		$sumaInali=0;
    		$sumaInba=0;
    		$sumaInsr=0;
    		$sumaInoe=0;
    		$sumaInoio=0;
    		$sumaIntio=0;
    		foreach ($query->result() as $row){
    			$modulo3["op"] = "update";
    			$modulo3["imagen"] = $row->modulo3;
    			$sumaInalo += $row->inalo;
    			$modulo3["inalo"] = $sumaInalo;
    			$sumaInali += $row->inali;
    			$modulo3["inali"] = $sumaInali;
    			$sumaInba += $row->inba;
    			$modulo3["inba"] = $sumaInba;
    			$sumaInsr += $row->insr;
    			$modulo3["insr"] = $sumaInsr;
    			$sumaInoe += $row->inoe;
    			$modulo3["inoe"] = $sumaInoe;
    			$sumaInoio += $row->inoio;
    			$modulo3["inoio"] = $sumaInoio;
    			$sumaIntio += $row->intio;
    			$modulo3["intio"] = $sumaIntio;
    		}
    	}
    	else{
    		$modulo3["op"] = "insert";
    		$modulo3["imagen"] = "0";
    		$modulo3["inalo"] = "";
    		$modulo3["inali"] = "";
    		$modulo3["inba"] = "";
    		$modulo3["inoe"] = "";
    		$modulo3["inoio"] = "";
    		$modulo3["intio"] = "";
    	}
    	$this->db->close();
    	return $modulo3;
    }
    
    /**
     * Descarga de planos histórico por empresa modulo 4
     * @author SJNEIRAG
     * @since 2015
     */    
    
function obtenerModulo4($nro_orden, $ano_periodo, $mes_periodo){
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
           	sum(CH.thsen) as thsen, sum(CH.thdob) as thdob,  
    	   	sum(CH.thsui) as thsui, sum(CH.thmult) as thmult, 
         	sum(CH.thotr) as thotr, sum(CH.thtot) as thtot
    		FROM rmmh_form_caracthoteles CH, rmmh_admin_control C
    		WHERE CH.nro_orden = C.nro_orden
	    	AND CH.nro_establecimiento = C.nro_establecimiento
	    	AND CH.ano_periodo = C.ano_periodo
	    	AND CH.mes_periodo = C.mes_periodo
            AND C.nro_orden = $nro_orden
            AND C.ano_periodo = $ano_periodo
			AND C.mes_periodo = $mes_periodo"; 
    	   
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		$i = 0;
    		foreach ($query->result() as $row){
      			$modulo4[$i]["nro_orden"] = $row->nro_orden;
		    		$modulo4["nro_establecimientos"] = $row->nro_establecimientos;
		    		$modulo4["ano_periodo"] = $row->ano_periodo;
		    		$modulo4["mes_periodo"] = $row->mes_periodo;
		    		$modulo4["ihdo"] = $row->ihdo;
		    		$modulo4["ihoa"] = $row->ihoa;
		    		$modulo4["icda"] = $row->icda;
		    		$modulo4["icva"] = $row->icva;
		    		$modulo4["ihpn"] = $row->ihpn;
		    		$modulo4["ihpnr"] = $row->ihpnr;
		    		$modulo4["huetot"] = $row->huetot;
		    		$modulo4["thsen"] = $row->thsen;
		    		$modulo4["thdob"] = $row->thdob;
		    		$modulo4["thsui"] = $row->thsui;
		    		$modulo4["thmult"] = $row->thmult;
	    			$modulo4["thotr"] = $row->thotr;
	    			$modulo4["thtot"] = $row->thtot;
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
	    										 
    				$modulo4["mvott"]=$modulo4["mvnr"]+$modulo4["mvcr"]+$modulo4["mvor"]+$modulo4["mvsr"]+$modulo4["mvotr"];
    									 
    				$modulo4["mvottnr"]=$modulo4["mvnnr"]+$modulo4["mvcnr"]+$modulo4["mvonr"]+$modulo4["mvsnr"]+$modulo4["mvotnr"];
    		$i++;
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
    
 /**
  * Descarga de planos histórico consolidados todos los modulos
  * @author SJNEIRAG
  * @since Julio 2015
  */
    
function descargaPlanosConsolidado($ano_periodo, $mes_periodo){
	$modulos = array();
    $sql = "SELECT C.nro_orden, C.nro_establecimiento,
    C.ano_periodo, C.mes_periodo, PS.potpsfr, PS.potperm,
    PS.gpper, PS.pottcde, PS.gpssde, PS.pottcag, PS.gpppta,
    PS.potpau, PS.gppgpa, PS.pottot, PS.gpsspot,
    IO.inalo, IO.inali, IO.inba, IO.insr,
    IO.inoe, IO.inoio, IO.intio,
    CH.ihdo, CH.ihoa, CH.icda, 
    CH.icva, CH.ihpn, CH.ihpnr, CH.huetot, 
    CH.mvnr, CH.mvnnr, CH.mvcr, CH.mvcnr, 
    CH.mvor, CH.mvonr, CH.mvsr, CH.mvsnr, 
    CH.mvotr, CH.mvotnr, CH.mvott, CH.mvottnr, 
    CH.thsen, CH.thusen, CH.thdob, CH.thudob, 
    CH.thsui, CH.thusui, CH.thmult, CH.thumult,  
    CH.thotr, CH.thuotr, CH.thtot
    FROM
    rmmh_form_persalarios PS,
    rmmh_form_ingoperacionales IO,
    rmmh_form_caracthoteles CH,
    rmmh_admin_control C
    WHERE PS.nro_orden = C.nro_orden
    AND PS.nro_establecimiento = C.nro_establecimiento
    AND PS.ano_periodo = C.ano_periodo
    AND PS.mes_periodo = C.mes_periodo
    AND IO.nro_orden = C.nro_orden
    AND IO.nro_establecimiento = C.nro_establecimiento
    AND IO.ano_periodo = C.ano_periodo
    AND IO.mes_periodo = C.mes_periodo
    AND CH.nro_orden = C.nro_orden
    AND CH.nro_establecimiento = C.nro_establecimiento
    AND CH.ano_periodo = C.ano_periodo
    AND CH.mes_periodo = C.mes_periodo
    AND C.ano_periodo = $ano_periodo
    AND C.mes_periodo IN ($mes_periodo)
    ORDER BY C.nro_orden ASC ";
    $query = $this->db->query($sql);
    if ($query->num_rows()>0){
	    $i = 0;
	    foreach ($query->result() as $row){
	    	$modulos[$i]["nro_orden"] = $row->nro_orden;
	    	$modulos[$i]["nro_establecimiento"] = $row->nro_establecimiento;
		    $modulos[$i]["ano_periodo"] = $row->ano_periodo;
	    	$modulos[$i]["mes_periodo"] = $row->mes_periodo;
	    	$modulos[$i]["potpsfr"] = $row->potpsfr;
	    	$modulos[$i]["potperm"] = $row->potperm;
	    	$modulos[$i]["gpper"] = $row->gpper;
	    	$modulos[$i]["pottcde"] = $row->pottcde;
	    	$modulos[$i]["gpssde"] = $row->gpssde;
	    	$modulos[$i]["pottcag"] = $row->pottcag;
	    	$modulos[$i]["gpppta"] = $row->gpppta;
	    	$modulos[$i]["potpau"] = $row->potpau;
	    	$modulos[$i]["gppgpa"] = $row->gppgpa;
	    	$modulos[$i]["pottot"] = $row->pottot;
	    	$modulos[$i]["gpsspot"] = $row->gpsspot;
	    	$modulos[$i]["inalo"] = $row->inalo;
	    	$modulos[$i]["inali"] = $row->inali;
	    	$modulos[$i]["inba"] = $row->inba;
	    	$modulos[$i]["insr"] = $row->insr;
	    	$modulos[$i]["inoe"] = $row->inoe;
	    	$modulos[$i]["inoio"] = $row->inoio;
	    	$modulos[$i]["intio"] = $row->intio;
	    	$modulos[$i]["ihdo"] = $row->ihdo;
	    	$modulos[$i]["ihoa"] = $row->ihoa;
	    	$modulos[$i]["icda"] = $row->icda;
	    	$modulos[$i]["icva"] = $row->icva;
	    	$modulos[$i]["ihpn"] = $row->ihpn;
	    	$modulos[$i]["ihpnr"] = $row->ihpnr;
	    	$modulos[$i]["huetot"] = $row->huetot;
	    	$modulos[$i]["mvnr"] = $row->mvnr;
	    	$modulos[$i]["mvcr"] = $row->mvcr;
	    	$modulos[$i]["mvor"] = $row->mvor;
	    	$modulos[$i]["mvsr"] = $row->mvsr;
	    	$modulos[$i]["mvotr"] = $row->mvotr;
	    	$modulos[$i]["mvott"] = $row->mvott;
	    	$modulos[$i]["mvnnr"] = $row->mvnnr;
	    	$modulos[$i]["mvcnr"] = $row->mvcnr;
	    	$modulos[$i]["mvonr"] = $row->mvonr;
	    	$modulos[$i]["mvsnr"] = $row->mvsnr;
	    	$modulos[$i]["mvotnr"] = $row->mvotnr;
	    	$modulos[$i]["mvottnr"] = $row->mvottnr;
	    	$modulos[$i]["thsen"] = $row->thsen;
	    	$modulos[$i]["thusen"] = $row->thusen;
	    	$modulos[$i]["thdob"] = $row->thdob;
	    	$modulos[$i]["thudob"] = $row->thudob;
	    	$modulos[$i]["thsui"] = $row->thsui;
	    	$modulos[$i]["thusui"] = $row->thusui;
	    	$modulos[$i]["thmult"] = $row->thmult;
	    	$modulos[$i]["thumult"] = $row->thumult;
	    	$modulos[$i]["thotr"] = $row->thotr;
	    	$modulos[$i]["thuotr"] = $row->thuotr;
	    	$modulos[$i]["thtot"] = $row->thtot;
	    	
	    	$i++;
	    }
    }
    //echo $sql."<br>";
    	$this->db->close();
    	return $modulos;
    }
	
    
    /**
     * Descarga de planos consolidados por empresa
     * @author SJNEIRAG
     * @since Julio 2015
     */
    function descargaPlanosConsolidadoEmpresa($ano_periodo, $mes_periodo){
    	$modulos = array();
    	$sql = "SELECT C.nro_orden, count(C.nro_establecimiento) as establecimientos,
    	C.ano_periodo, C.mes_periodo, sum(PS.potpsfr) as potpsfr, sum(PS.potperm) as potperm,
    	sum(PS.gpper) as gpper, sum(PS.pottcde) pottcde, sum(PS.gpssde) gpssde, sum(PS.pottcag) as pottcag,
    	sum(PS.gpppta) as gpppta, sum(PS.potpau) as potpau, sum(PS.gppgpa) as gppgpa, sum(PS.pottot) as pottot, sum(PS.gpsspot) as gpsspot,
    	sum(IO.inalo) as inalo, sum(IO.inali) as inali, sum(IO.inba) as inba, 
        sum(IO.insr) as insr, sum(IO.inoe) as inoe, sum(IO.inoio) as inoio, sum(IO.intio) as intio,
        sum(CH.ihdo) as ihdo, 
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
        FROM
    	rmmh_form_persalarios PS,
    	rmmh_form_ingoperacionales IO,
    	rmmh_form_caracthoteles CH,
    	rmmh_admin_control C
    	WHERE PS.nro_orden = C.nro_orden
    	AND PS.nro_establecimiento = C.nro_establecimiento
    	AND PS.ano_periodo = C.ano_periodo
    	AND PS.mes_periodo = C.mes_periodo
    	AND IO.nro_orden = C.nro_orden
    	AND IO.nro_establecimiento = C.nro_establecimiento
    	AND IO.ano_periodo = C.ano_periodo
    	AND IO.mes_periodo = C.mes_periodo
    	AND CH.nro_orden = C.nro_orden
    	AND CH.nro_establecimiento = C.nro_establecimiento
    	AND CH.ano_periodo = C.ano_periodo
    	AND CH.mes_periodo = C.mes_periodo
    	AND C.ano_periodo = $ano_periodo
    	AND C.mes_periodo IN ($mes_periodo)
    	GROUP BY IO.nro_orden";
    	$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
    	$i = 0;
    		foreach ($query->result() as $row){
    		$modulos[$i]["nro_orden"] = $row->nro_orden;
    		$modulos[$i]["nro_establecimientos"] = $row->establecimientos;
    		$modulos[$i]["ano_periodo"] = $row->ano_periodo;
    				$modulos[$i]["mes_periodo"] = $row->mes_periodo;
    	    	$modulos[$i]["potpsfr"] = $row->potpsfr;
    	    	$modulos[$i]["potperm"] = $row->potperm;
    	    	$modulos[$i]["gpper"] = $row->gpper;
    	    	$modulos[$i]["pottcde"] = $row->pottcde;
    	    	$modulos[$i]["gpssde"] = $row->gpssde;
    	    	$modulos[$i]["pottcag"] = $row->pottcag;
    	    	$modulos[$i]["gpppta"] = $row->gpppta;
    	    	$modulos[$i]["potpau"] = $row->potpau;
    	    	$modulos[$i]["gppgpa"] = $row->gppgpa;
    	    	$modulos[$i]["pottot"] = $row->pottot;
    	    	$modulos[$i]["gpsspot"] = $row->gpsspot;
    	    	$modulos[$i]["inalo"] = $row->inalo;
    	    	$modulos[$i]["inali"] = $row->inali;
    	    	$modulos[$i]["inba"] = $row->inba;
    	    	$modulos[$i]["insr"] = $row->insr;
    	    	$modulos[$i]["inoe"] = $row->inoe;
    	    	$modulos[$i]["inoio"] = $row->inoio;
    	    	$modulos[$i]["intio"] = $row->intio;
    	    	$modulos[$i]["ihdo"] = $row->ihdo;
    	    	$modulos[$i]["ihoa"] = $row->ihoa;
    	    	$modulos[$i]["icda"] = $row->icda;
    	    	$modulos[$i]["icva"] = $row->icva;
    	    	$modulos[$i]["ihpn"] = $row->ihpn;
    	    	$modulos[$i]["ihpnr"] = $row->ihpnr;
    	    	$modulos[$i]["huetot"] = $row->huetot;
    	    	$modulos[$i]["mvnr"] = $row->mvnr;
    	    	$modulos[$i]["mvcr"] = $row->mvcr;
    	    	$modulos[$i]["mvor"] = $row->mvor;
    	    	$modulos[$i]["mvsr"] = $row->mvsr;
    	    	$modulos[$i]["mvotr"] = $row->mvotr;
    	    	$modulos[$i]["mvott"] = $row->mvott;
    	    	$modulos[$i]["mvnnr"] = $row->mvnnr;
    	    	$modulos[$i]["mvcnr"] = $row->mvcnr;
    	    	$modulos[$i]["mvonr"] = $row->mvonr;
    	    	$modulos[$i]["mvsnr"] = $row->mvsnr;
    	    	$modulos[$i]["mvotnr"] = $row->mvotnr;
    	    	$modulos[$i]["mvottnr"] = $row->mvottnr;
    	    	$modulos[$i]["thsen"] = $row->thsen;
    	    	$modulos[$i]["thusen"] = $row->thusen;
    	    	$modulos[$i]["thdob"] = $row->thdob;
    	    	$modulos[$i]["thudob"] = $row->thudob;
    	    	$modulos[$i]["thsui"] = $row->thsui;
    	    	$modulos[$i]["thusui"] = $row->thusui;
    	    	$modulos[$i]["thmult"] = $row->thmult;
    	    	$modulos[$i]["thumult"] = $row->thumult;
    	    	$modulos[$i]["thotr"] = $row->thotr;
    	    	$modulos[$i]["thuotr"] = $row->thuotr;
    	    	$modulos[$i]["thtot"] = $row->thtot;
    
    	    	$i++;
    		}
    		}
    		//echo $sql."<br>";
    		$this->db->close();
    		return $modulos;
    }
    
}//EOC  
