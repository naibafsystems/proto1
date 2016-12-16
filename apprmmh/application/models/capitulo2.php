<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Capitulo2 extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->library("session");        
    }
    
    function obtenerCapitulo(){
    	$capitulo2 = array();
    	$nro_orden = $this->session->userdata("nro_orden");
    	$uni_local = $this->session->userdata("uni_local");
    	$ano_periodo = $this->session->userdata("ano_periodo");
    	$mes_periodo = $this->session->userdata("mes_periodo");
    	$sql = "SELECT C.cap2, IO.inalo, IO.inali, IO.inba, IO.inoe, IO.inoio, IO.intio
                FROM rmmh_form_ingoperacionales IO, rmmh_admin_control C
                WHERE IO.nro_orden = C.nro_orden
                AND IO.uni_local = C.uni_local
                AND IO.ano_periodo = C.ano_periodo
                AND IO.mes_periodo = C.mes_periodo
                AND C.nro_orden = $nro_orden
                AND C.uni_local = $uni_local
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
      			$capitulo2["op"] = "update";
    			$capitulo2["imagen"] = $row->cap2;
    			$capitulo2["inalo"] = $row->inalo;
    			$capitulo2["inali"] = $row->inali;
    			$capitulo2["inba"] = $row->inba;
    			$capitulo2["inoe"] = $row->inoe;
				$capitulo2["inoio"] = $row->inoio;
				$capitulo2["intio"] = $row->intio;	    			      		
    		}   			
   		}
   		else{
   			$capitulo2["op"] = "insert";
   			$capitulo2["imagen"] = "0";
   			$capitulo2["inalo"] = "";
   			$capitulo2["inali"] = "";
   			$capitulo2["inba"] = "";
   			$capitulo2["inoe"] = "";
   			$capitulo2["inoio"] = "";
   			$capitulo2["intio"] = "";
   		}    	
    	$this->db->close();
   		return $capitulo2;
    }
    
    function insertarCapitulo($inalo, $inali, $inba, $inoe, $inoio, $intio){            
    	$nro_orden = $this->session->userdata("nro_orden");     //Obtener desde la sesion
    	$uni_local = $this->session->userdata("uni_local");     //Obtener desde la sesion
    	$ano_periodo = $this->session->userdata("ano_periodo"); //Obtener desde la sesion
    	$mes_periodo = $this->session->userdata("mes_periodo"); //Obtener desde la sesion
    	$data = array('nro_orden' => $nro_orden,
    	              'uni_local' => $uni_local,
    	              'ano_periodo' => $ano_periodo,
    	              'mes_periodo' => $mes_periodo,
    	              'inalo' => $inalo,
    	              'inali' => $inali,
    	              'inba' => $inba,
    	              'inoe' => $inoe,
    	              'inoio' => $inoio,
    	              'intio' => $intio
    	);
		$this->db->insert('rmmh_form_ingoperacionales', $data);
		$this->db->close();
    }

	function actualizarCapitulo($inalo, $inali, $inba, $inoe, $inoio, $intio){            
    	$nro_orden = $this->session->userdata("nro_orden");     //Obtener desde la sesion
    	$uni_local = $this->session->userdata("uni_local");     //Obtener desde la sesion
    	$ano_periodo = $this->session->userdata("ano_periodo"); //Obtener desde la sesion
    	$mes_periodo = $this->session->userdata("mes_periodo"); //Obtener desde la sesion
    	$data = array('inalo' => $inalo,
    	              'inali' => $inali,
    	              'inba' => $inba,
    	              'inoe' => $inoe,
    	              'inoio' => $inoio,
    	              'intio' => $intio
    	);
		$this->db->where("nro_orden",   $nro_orden);
		$this->db->where("uni_local",   $uni_local);
		$this->db->where("ano_periodo", $ano_periodo);
		$this->db->where("mes_periodo", $mes_periodo);
    	$this->db->update('rmmh_form_ingoperacionales', $data);
		$this->db->close();
    }
    
	function actualizarCapituloCritico($nro_orden, $uni_local, $inalo, $inali, $inba, $inoe, $inoio, $intio){            
    	$ano_periodo = $this->session->userdata("ano_periodo"); //Obtener desde la sesion
    	$mes_periodo = $this->session->userdata("mes_periodo"); //Obtener desde la sesion
    	$data = array('inalo' => $inalo,
    	              'inali' => $inali,
    	              'inba' => $inba,
    	              'inoe' => $inoe,
    	              'inoio' => $inoio,
    	              'intio' => $intio
    	);
		$this->db->where("nro_orden",   $nro_orden);
		$this->db->where("uni_local",   $uni_local);
		$this->db->where("ano_periodo", $ano_periodo);
		$this->db->where("mes_periodo", $mes_periodo);
    	$this->db->update('rmmh_form_ingoperacionales', $data);
		$this->db->close();
    }
    
    /**
     * Funcion para obtener la informaci�n del cap�tulo II del formulario, luego de que ya se ha diligenciado el formulario. 
     * Ya se han obtenido los datos para el nro de orden, la unidad local, el a�o y el mes del periodo.
     * @param $nro_orden: Nro de Orden del formulario
     * @param $uni_local: Se asigna por directorio. (Pendiente por remover)
     * @param $ano_periodo: A�o de proceso
     * @param $mes_periodo: Mes de proceso
     */
    public function obtenerInfoCapitulo($nro_orden, $uni_local){
    	$capitulo2 = array(
    	  'op'=>'',
    	  'imagen'=>0,
    	  'inalo'=>'',
    	  'inali'=>'',
    	  'inba'=>'',
    	  'inoe'=>'',
    	  'inoio'=>'',
    	  'intio'=>''
    	);
    	$ano_periodo = $this->session->userdata("ano_periodo");
    	$mes_periodo = $this->session->userdata("mes_periodo");
    	$sql = "SELECT *
				FROM rmmh_form_ingoperacionales C2, rmmh_admin_control CTRL
				WHERE C2.nro_orden = CTRL.nro_orden
				AND C2.uni_local = CTRL.uni_local
				AND C2.ano_periodo = CTRL.ano_periodo
				AND C2.mes_periodo = CTRL.mes_periodo
				AND CTRL.nro_orden = $nro_orden
				AND CTRL.uni_local = $uni_local
				AND CTRL.ano_periodo = $ano_periodo
				AND CTRL.mes_periodo = $mes_periodo";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
      			$capitulo2["op"] = "update";
    			$capitulo2["imagen"] = $row->cap2;
    			$capitulo2["inalo"] = $row->inalo;
    			$capitulo2["inali"] = $row->inali;
    			$capitulo2["inba"] = $row->inba;
    			$capitulo2["inoe"] = $row->inoe;
				$capitulo2["inoio"] = $row->inoio;
				$capitulo2["intio"] = $row->intio;	     			
    		}   			
   		}
   		$this->db->close();
   		return $capitulo2; 
    }
    
    
   
}//EOC  