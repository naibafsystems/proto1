<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Capitulo1 extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->library("session"); 
        $this->load->model("observaciones");       
    }
    
    function obtenerCapitulo(){
    	$capitulo1 = array();
    	$nro_orden = $this->session->userdata("nro_orden");
    	$uni_local = $this->session->userdata("uni_local");
    	$ano_periodo = $this->session->userdata("ano_periodo");
    	$mes_periodo = $this->session->userdata("mes_periodo");
    	$sql = "SELECT C.cap1, MV.esini, MV.esape, MV.escie, MV.estot
				FROM rmmh_form_movmensual MV, rmmh_admin_control C
                WHERE MV.nro_orden = C.nro_orden
                AND   MV.uni_local = C.uni_local
                AND   MV.ano_periodo = C.ano_periodo
                AND   MV.mes_periodo = C.mes_periodo
                AND   C.nro_orden = $nro_orden
                AND   C.uni_local = $uni_local
                AND   C.ano_periodo = $ano_periodo
                AND   C.mes_periodo = $mes_periodo";        
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
      			$capitulo1["op"] = "update";
    			$capitulo1["imagen"] = $row->cap1;
    			$capitulo1["esini"] = $row->esini;
    			$capitulo1["esape"] = $row->esape;
    			$capitulo1["escie"] = $row->escie;
    			$capitulo1["estot"] = $row->estot;
    			//$capitulo1["observaciones"] = $this->observaciones->obtenerObservaciones(1);
    		}   			
   		}
   		else{
   			$capitulo1["op"] = "insert";
   			$capitulo1["imagen"] = "0";
   			$capitulo1["esini"] = "";
   			$capitulo1["esape"] = "";
   			$capitulo1["escie"] = "";
   			$capitulo1["estot"] = "";
   			//$capitulo1["observaciones"] = $this->observaciones->obtenerObservaciones(1);
   		}    	
    	$this->db->close();
   		return $capitulo1;
    }
    
	function obtenerCapituloNroOrden($nro_orden, $uni_local, $ano_periodo, $mes_periodo){
    	$capitulo1 = array();
    	$sql = "SELECT C.cap1, MV.esini, MV.esape, MV.escie, MV.estot
				FROM rmmh_form_movmensual MV, rmmh_admin_control C
                WHERE MV.nro_orden = C.nro_orden
                AND   MV.uni_local = C.uni_local
                AND   MV.ano_periodo = C.ano_periodo
                AND   MV.mes_periodo = C.mes_periodo
                AND   C.nro_orden = $nro_orden
                AND   C.uni_local = $uni_local
                AND   C.ano_periodo = $ano_periodo
                AND   C.mes_periodo = $mes_periodo";        
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
      			$capitulo1["op"] = "update";
    			$capitulo1["imagen"] = $row->cap1;
    			$capitulo1["esini"] = $row->esini;
    			$capitulo1["esape"] = $row->esape;
    			$capitulo1["escie"] = $row->escie;
    			$capitulo1["estot"] = $row->estot;
    			//$capitulo1["observaciones"] = $this->observaciones->obtenerObservaciones(1);
    		}   			
   		}
   		else{
   			$capitulo1["op"] = "insert";
   			$capitulo1["imagen"] = "0";
   			$capitulo1["esini"] = "";
   			$capitulo1["esape"] = "";
   			$capitulo1["escie"] = "";
   			$capitulo1["estot"] = "";
   			//$capitulo1["observaciones"] = $this->observaciones->obtenerObservaciones(1);
   		}    	
    	$this->db->close();
   		return $capitulo1;
    }
    
    function insertarCapitulo($esini, $esape, $escie, $estot){            
    	$nro_orden = $this->session->userdata("nro_orden");     //Obtener desde la sesion
    	$uni_local = $this->session->userdata("uni_local");     //Obtener desde la sesion
    	$ano_periodo = $this->session->userdata("ano_periodo"); //Obtener desde la sesion
    	$mes_periodo = $this->session->userdata("mes_periodo"); //Obtener desde la sesion
    	$data = array('nro_orden' => $nro_orden,
    	              'uni_local' => $uni_local,
    	              'ano_periodo' => $ano_periodo,
    	              'mes_periodo' => $mes_periodo,
    	              'esini' => $esini,
    	              'esape' => $esape,
    	              'escie' => $escie,
    	              'estot' => $estot
    	);
		$this->db->insert('rmmh_form_movmensual', $data);
		$this->db->close();		
    }

	function actualizarCapitulo($esini, $esape, $escie, $estot){            
    	$nro_orden = $this->session->userdata("nro_orden");     //Obtener desde la sesion
    	$uni_local = $this->session->userdata("uni_local");     //Obtener desde la sesion
    	$ano_periodo = $this->session->userdata("ano_periodo"); //Obtener desde la sesion
    	$mes_periodo = $this->session->userdata("mes_periodo"); //Obtener desde la sesion
    	$data = array('esini' => $esini,
    	              'esape' => $esape,
    	              'escie' => $escie,
    	              'estot' => $estot
    	);
		$this->db->where("nro_orden",   $nro_orden);
		$this->db->where("uni_local",   $uni_local);
		$this->db->where("ano_periodo", $ano_periodo);
		$this->db->where("mes_periodo", $mes_periodo);
    	$this->db->update('rmmh_form_movmensual', $data);
		$this->db->close();
    }
    
    function actualizarCapituloCritico($nro_orden, $uni_local, $esini, $esape, $escie, $estot){
    	$ano_periodo = $this->session->userdata("ano_periodo"); //Obtener desde la sesion
    	$mes_periodo = $this->session->userdata("mes_periodo"); //Obtener desde la sesion
    	$data = array('esini' => $esini,
    	              'esape' => $esape,
    	              'escie' => $escie,
    	              'estot' => $estot
    	);
		$this->db->where("nro_orden",   $nro_orden);
		$this->db->where("uni_local",   $uni_local);
		$this->db->where("ano_periodo", $ano_periodo);
		$this->db->where("mes_periodo", $mes_periodo);
    	$this->db->update('rmmh_form_movmensual', $data);
		$this->db->close();
    }
    
    /**
     * Funcion para obtener la información del capítulo I del formulario, luego de que ya se ha diligenciado el formulario. 
     * Ya se han obtenido los datos para el nro de orden, la unidad local, el año y el mes del periodo.
     * @param $nro_orden: Nro de Orden del formulario
     * @param $uni_local: Se asigna por directorio. (Pendiente por remover)
     * @param $ano_periodo: Año de proceso
     * @param $mes_periodo: Mes de proceso
     */
	public function obtenerInfoCapitulo($nro_orden, $uni_local){
    	$capitulo1 = array(
    	  'op'=>'',
    	  'imagen'=>0,
    	  'esini'=>'',
    	  'esape'=>'',
    	  'escie'=>'',
    	  'estot'=>''        
    	);
    	$ano_periodo = $this->session->userdata("ano_periodo");
    	$mes_periodo = $this->session->userdata("mes_periodo");
    	$sql = "SELECT CTRL.cap1, C1.esini, C1.esape, C1.escie, C1.estot
				FROM rmmh_form_movmensual C1, rmmh_admin_control CTRL
				WHERE C1.nro_orden = CTRL.nro_orden
				AND C1.uni_local = CTRL.uni_local
				AND C1.ano_periodo = CTRL.ano_periodo
				AND C1.mes_periodo = CTRL.mes_periodo
				AND CTRL.nro_orden = $nro_orden
				AND CTRL.uni_local = $uni_local
				AND CTRL.ano_periodo = $ano_periodo
				AND CTRL.mes_periodo = $mes_periodo";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
      			$capitulo1["op"] = "update";
    			$capitulo1["imagen"] = $row->cap1;
    			$capitulo1["esini"] = $row->esini;
    			$capitulo1["esape"] = $row->esape;
    			$capitulo1["escie"] = $row->escie;
    			$capitulo1["estot"] = $row->estot;
   			}
    	}
    	$this->db->close();
   		return $capitulo1; 
    }
    
    
   
}//EOC        
   