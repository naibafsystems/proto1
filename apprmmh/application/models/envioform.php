<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Envioform extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->library("session"); 
        $this->load->library("general");       
    }

    function obtenerEnvio(){
    	$envio = array();
    	$nro_orden = $this->session->userdata("nro_orden");
    	$uni_local = $this->session->userdata("uni_local");
    	$ano_periodo = $this->session->userdata("ano_periodo");
    	$mes_periodo = $this->session->userdata("mes_periodo");
    	$sql = "SELECT C.envio, EF.observaciones, EF.dmpio, EF.fedili, EF.repleg, EF.responde, EF.respoca, EF.teler, EF.emailr
			    FROM rmmh_form_envioform EF, rmmh_admin_control C
				WHERE EF.nro_orden = C.nro_orden
			    AND EF.uni_local = C.uni_local
				AND EF.ano_periodo = C.ano_periodo
				AND EF.mes_periodo = C.mes_periodo
				AND C.nro_orden = $nro_orden
				AND C.uni_local = $uni_local
				AND C.ano_periodo = $ano_periodo
				AND C.mes_periodo = $mes_periodo";    	    	
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
      			$envio["op"] = "update";
    			$envio["imagen"] = $row->envio;
    			$envio["observaciones"] = utf8_decode($row->observaciones);
    			$envio["dmpio"] = utf8_decode($row->dmpio);
    			$envio["fedili"] = $this->general->formatoFecha($row->fedili,'-'); 
    			$envio["repleg"] = utf8_decode($row->repleg);
				$envio["responde"] = utf8_decode($row->responde);
				$envio["respoca"] = utf8_decode($row->respoca);	    			      		
				$envio["teler"] = $row->teler;
				$envio["emailr"] = $row->emailr;
    		}   			
   		}
   		else{
   				$envio["op"] = "insert";
    			$envio["imagen"] = "0";
    			$envio["observaciones"] = "";
    			$envio["dmpio"] = "";
    			$envio["fedili"] = "";
    			$envio["repleg"] = "";
				$envio["responde"] = "";
				$envio["respoca"] = "";	    			      		
				$envio["teler"] = "";
				$envio["emailr"] = "";
   		}    	
    	$this->db->close();
   		return $envio;
    }
    
    function insertarEnvio($fteObserv, $dmpio, $fedili, $repleg, $responde, $respoca, $teler, $emailr){            
    	$nro_orden = $this->session->userdata("nro_orden");     //Obtener desde la sesion
    	$uni_local = $this->session->userdata("uni_local");     //Obtener desde la sesion
    	$ano_periodo = $this->session->userdata("ano_periodo"); //Obtener desde la sesion
    	$mes_periodo = $this->session->userdata("mes_periodo"); //Obtener desde la sesion
    	$data = array('nro_orden' => $nro_orden,
    	              'uni_local' => $uni_local,
    	              'ano_periodo' => $ano_periodo,
    	              'mes_periodo' => $mes_periodo,
    	              'observaciones' => $fteObserv,
    	              'dmpio' => $dmpio,
    	              'fedili' => $fedili,
    	              'repleg' => $repleg,
    	              'responde' => $responde,
    	              'respoca' => $respoca,
    	              'teler' => $teler,
    	              'emailr' => $emailr
    	);
		$this->db->insert('rmmh_form_envioform', $data);
		$this->db->close();		
    }

	function actualizarEnvio($observaciones, $dmpio, $fedili, $repleg, $responde, $respoca, $teler, $emailr){            
    	$nro_orden = $this->session->userdata("nro_orden");     //Obtener desde la sesion
    	$uni_local = $this->session->userdata("uni_local");     //Obtener desde la sesion
    	$ano_periodo = $this->session->userdata("ano_periodo"); //Obtener desde la sesion
    	$mes_periodo = $this->session->userdata("mes_periodo"); //Obtener desde la sesion    	
    	$data = array('observaciones' => $observaciones,
    	              'dmpio' => $dmpio,
    	              'fedili' => $fedili,
    	              'repleg' => $repleg,
    	              'responde' => $responde,
    	              'respoca' => $respoca,
    	              'teler' => $teler,
    	              'emailr' => $emailr
    	);
		$this->db->where("nro_orden",   $nro_orden);
		$this->db->where("uni_local",   $uni_local);
		$this->db->where("ano_periodo", $ano_periodo);
		$this->db->where("mes_periodo", $mes_periodo);
    	$this->db->update('rmmh_form_envioform', $data);
		$this->db->close();
    }
    
	function actualizarEnvioCritico($nro_orden, $uni_local, $observaciones, $dmpio, $fedili, $repleg, $responde, $respoca, $teler, $emailr){            
    	$ano_periodo = $this->session->userdata("ano_periodo"); //Obtener desde la sesion
    	$mes_periodo = $this->session->userdata("mes_periodo"); //Obtener desde la sesion    	
    	$data = array('observaciones' => $observaciones,
    	              'dmpio' => $dmpio,
    	              'fedili' => $fedili,
    	              'repleg' => $repleg,
    	              'responde' => $responde,
    	              'respoca' => $respoca,
    	              'teler' => $teler,
    	              'emailr' => $emailr
    	);
		$this->db->where("nro_orden",   $nro_orden);
		$this->db->where("uni_local",   $uni_local);
		$this->db->where("ano_periodo", $ano_periodo);
		$this->db->where("mes_periodo", $mes_periodo);
    	$this->db->update('rmmh_form_envioform', $data);
		$this->db->close();
    }
    
    //Valida si todos los capitulos ya han sido diligenciados. (Si todos los capitulos tienen estado 2
    //en la tabla de control. Si es asi, muestra la pestaña del envio del formulario.
    function validarEnvioFormulario(){
    	$result = false;
    	$estados = array();
    	$nro_orden = $this->session->userdata("nro_orden");
    	$uni_local = $this->session->userdata("uni_local");
    	$ano_periodo = $this->session->userdata("ano_periodo");
    	$mes_periodo = $this->session->userdata("mes_periodo");
    	$sql = "SELECT cap1, cap2, cap3, cap4
                FROM rmmh_admin_control
                WHERE nro_orden = $nro_orden
                AND uni_local = $uni_local
                AND ano_periodo = $ano_periodo
                AND mes_periodo = $mes_periodo";    	
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
      			$estados[0] = 2;           //Estado de la caratula del formulario
    			$estados[1] = $row->cap1;  //Estado del capitulo 1 del formulario
    			$estados[2] = $row->cap2;  //Estado del capitulo 2 del formulario
    			$estados[3] = $row->cap3;  //Estado del capitulo 3 del formulario
    			$estados[4] = $row->cap4;  //Estado del capitulo 4 del formulario
    		}
    		$this->db->close();
   			
    		//Verificar que todos los estados estén en estado diligenciado (2 - Diligenciado), de lo contrario no se puede
    		//mostrar la pestaña del envio del formulario.
    		for ($i=0; $i<count($estados);$i++){
    			if ($estados[$i]==2){
    				$result = true; 
    				//   			
    			}
    			else{
    				$result = false;
    				break;
    			}
    		}
    	}
    	return $result;
    }
    
    
	//Valida si todos los capitulos ya han sido diligenciados. (Si todos los capitulos tienen estado 2
    //en la tabla de control. Si es asi, muestra la pestaña del envio del formulario. (Recibe como parametro el numero de orden 
    //del formulario, y la unidad local)
    function validarEnvioFormularioNroOrden($nro_orden, $uni_local){
    	$result = false;
    	$estados = array();
    	$ano_periodo = $this->session->userdata("ano_periodo");
    	$mes_periodo = $this->session->userdata("mes_periodo");
    	$sql = "SELECT cap1, cap2, cap3, cap4
                FROM rmmh_admin_control
                WHERE nro_orden = $nro_orden
                AND uni_local = $uni_local
                AND ano_periodo = $ano_periodo
                AND mes_periodo = $mes_periodo";    	
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
      			$estados[0] = 2;           //Estado de la caratula del formulario
    			$estados[1] = $row->cap1;  //Estado del capitulo 1 del formulario
    			$estados[2] = $row->cap2;  //Estado del capitulo 2 del formulario
    			$estados[3] = $row->cap3;  //Estado del capitulo 3 del formulario
    			$estados[4] = $row->cap4;  //Estado del capitulo 4 del formulario
    		}
    		$this->db->close();
   			
    		//Verificar que todos los estados estén en estado diligenciado (2 - Diligenciado), de lo contrario no se puede
    		//mostrar la pestaña del envio del formulario.
    		for ($i=0; $i<count($estados);$i++){
    			if ($estados[$i]==2){
    				$result = true;    			
    			}
    			else{
    				$result = false;
    				break;
    			}
    		}
    	}
    	return $result;
    }
    
    
    
    public function obtenerInfoEnvio($nro_orden, $uni_local){
    	$envio = array();
    	$ano_periodo = $this->session->userdata("ano_periodo");
    	$mes_periodo = $this->session->userdata("mes_periodo");
    	$sql = "SELECT *
				FROM rmmh_form_envioform ENV, rmmh_admin_control CTRL
				WHERE ENV.nro_orden = CTRL.nro_orden
				AND ENV.uni_local = CTRL.uni_local
				AND ENV.ano_periodo = CTRL.ano_periodo
				AND ENV.mes_periodo = CTRL.mes_periodo
				AND CTRL.nro_orden = $nro_orden
				AND CTRL.uni_local = $uni_local
				AND CTRL.ano_periodo = $ano_periodo
				AND CTRL.mes_periodo = $mes_periodo";    	
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
      			$envio["op"] = "update";
    			$envio["imagen"] = $row->envio;
    			$envio["observaciones"] = utf8_decode($row->observaciones);
    			$envio["dmpio"] = utf8_decode($row->dmpio);
    			$envio["fedili"] = $this->general->formatoFecha($row->fedili,'-'); 
    			$envio["repleg"] = utf8_decode($row->repleg);
				$envio["responde"] = utf8_decode($row->responde);
				$envio["respoca"] = utf8_decode($row->respoca);	    			      		
				$envio["teler"] = $row->teler;
				$envio["emailr"] = $row->emailr;    			
    		}   			
   		}
   		else{   //Si no se encontraron datos, de todas formas hay que asignarle valores al array indicando que no se encontro informacion
   				$envio["op"] = "update";
    			$envio["imagen"] = 0;
    			$envio["observaciones"] = "";
    			$envio["dmpio"] = "";
    			$envio["fedili"] = ""; 
    			$envio["repleg"] = "";
				$envio["responde"] = "";
				$envio["respoca"] = "";	    			      		
				$envio["teler"] = "";
				$envio["emailr"] = "";
   		}
   		$this->db->close();
   		return $envio; 
    }
    
    
    //Funcion para obtener los datos del paz y  salvo de un usuario
    function datosPazYSalvo($nro_orden, $uni_local, $ano_periodo, $mes_periodo){
    	$this->load->model("divipola");
    	$this->load->model("periodo");
    	$pyz = array();
    	$sql = "SELECT DF.idproraz, DF.idnomcom, U.num_identificacion, DF.iddirecc, DF.fk_depto, DF.fk_mpio, C.ano_periodo, C.mes_periodo
                FROM rmmh_admin_control C, rmmh_admin_dirfuentes DF, rmmh_admin_usuarios U
                WHERE C.nro_orden = DF.nro_orden
                AND C.uni_local = DF.uni_local
                AND C.fk_usuario = U.id_usuario
                AND C.nro_orden = $nro_orden
                AND C.uni_local = $uni_local
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo";    	
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
      			$pyz["nro_orden"] = $nro_orden;
    			$pyz["idproraz"] = $row->idproraz;
    			$pyz["idnomcom"] = $row->idnomcom;
    			$pyz["num_identificacion"] = $row->num_identificacion;
    			$pyz["iddirecc"] = $row->iddirecc;
    			$pyz["depto"] = $this->divipola->nombreDepartamento($row->fk_depto);
    			$pyz["mpio"] =  $this->divipola->nombreMunicipio($row->fk_mpio);
    			$pyz["periodo"] = $this->periodo->obtenerNombrePeriodo($row->ano_periodo, $row->mes_periodo);
    		}   			
   		}
   		$this->db->close();
   		return $pyz;
    }
    
   
}//EOC  