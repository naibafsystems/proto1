<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Control extends CI_Model {
	
	function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->library("session");
        $this->load->library("general");
    }
    
	//DMDIAZF - Agosto 13, 2012
    //Funcion para obtener la novedad y el estado en el que se encuentra un formulario    
    private function obtenerNovedadEstado(){
    	$novestado = array('novedad' => 0, 'estado' => 0);
    	$nro_orden = $this->session->userdata('nro_orden');      				//Obtener desde la sesion     
		$nro_establecimiento = $this->session->userdata('nro_establecimiento'); //Obtener desde la sesion  
		$ano_periodo = $this->session->userdata('ano_periodo');  				//Obtener desde la sesion
		$mes_periodo = $this->session->userdata('mes_periodo');  				//Obtener desde la sesion
		$sql = "SELECT fk_novedad AS novedad, fk_estado AS estado
                FROM rmmh_admin_control
                WHERE nro_orden = $nro_orden
                AND nro_establecimiento = $nro_establecimiento
                AND ano_periodo = $ano_periodo
                AND mes_periodo = $mes_periodo";				
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0){
			foreach ($query->result() as $row){
      			$novestado["novedad"] = $row->novedad;
      			$novestado["estado"] = $row->estado;
   			}
		}
		
		$this->db->close();
		return $novestado;
    }
    
	//DMDIAZF - Agosto 13, 2012
    //Funcion para bloquear los campos de un formulario luego de que el formulario ya fue enviado a crítica. 
    //Se bloquean los botones de envio en cada formulario, y se deshabilitan todas las cajas de texto.
    function bloquearCampos(){
    	$bloqueo = false;
    	$novestado = $this->obtenerNovedadEstado();
    	//Si el estado es distinto a 5 ó 9. Debe bloquearse
    	if (($novestado["novedad"]!=5)&&($novestado["novedad"]!=9)){
    		$bloqueo = true;
    	}
    	else if ($novestado["estado"]>3){
    		$bloqueo = true;
    	}
    	return $bloqueo;    	
    }
    
	//DMDIAZF - Agosto 13, 2012
	//Funcion para validar si una fuente ya diligencio el formulario por completo para que pueda descargar el paz y salvo
    function validarPazYSalvo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	//Si el estado está en 99 - 5 ya fue verificado por el critico / asistente tecnico, por lo que ya puede descargar el paz y salvo
    	$retorno = false;
    	$sql = "SELECT fk_novedad, fk_estado
				FROM rmmh_admin_control
				WHERE nro_orden = $nro_orden
				AND nro_establecimiento = $nro_establecimiento
				AND ano_periodo = $ano_periodo
				AND mes_periodo = $mes_periodo";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
    			//Pregunto si el formulario ya fue enviado a DANE Central. Ya se puede generar el paz y salvo
    			if (($row->fk_novedad==99)&&($row->fk_estado==5)){
    				$retorno = true;
    			}	    		
    			else{
    				$retorno = false;
    			}		
    		}
    	}
    	$this->db->close();
    	return $retorno;
    }
    
    //DMDIAZF - Agosto 14, 2012
    //Funcion para obtener la novedad en la que se encuentra un formulario que esta siendo diligenciado 
	function obtenerNovedad($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$result = 5; //Novedad para las fuentes que ingresan desde el directorio (No ingresan como fuentes nuevas).
    	$sql = "SELECT fk_novedad
                FROM rmmh_admin_control
                WHERE nro_orden = $nro_orden
                AND nro_establecimiento = $nro_establecimiento
                AND ano_periodo = $ano_periodo
                AND mes_periodo = $mes_periodo";
    	$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
    		foreach($query->result() as $row){
	    		$result = $row->fk_novedad;
    		}
    	}
    	$this->db->close();
    	return $result;
    }
    
    
    
    //DMDIAZF - Agosto 14, 2012
	//Funcion para actualizar el estado en el que se encuentra diligenciado uno de los modulos de la encuesta
	function actualizarControl($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $campo, $valor){
    	$data = array($campo => $valor);    	
		$this->db->where("nro_orden", $nro_orden);
		$this->db->where("nro_establecimiento", $nro_establecimiento);
		$this->db->where("ano_periodo", $ano_periodo);
		$this->db->where("mes_periodo", $mes_periodo);		
		$this->db->update("rmmh_admin_control", $data);
    }
    
    //DMDIAZF - Agosto 14, 2012
    //Funcion para actualizar la novedad y el estado de un registro en la tabla de control
	function actualizarNovedadEstado($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $novedad, $estado){
    	$data = array('fk_novedad' => $novedad,
		              'fk_estado' => $estado  
		        );
		$this->db->where("nro_orden", $nro_orden);
		$this->db->where("nro_establecimiento", $nro_establecimiento);
		$this->db->where("ano_periodo", $ano_periodo);
		$this->db->where("mes_periodo", $mes_periodo);
		$this->db->update("rmmh_admin_control",$data);
    }
    
    //DMDIAZF - Agosto 14, 2012
    //Funcion para obtener el estado de diligenciamiento de un capitulo. Si el estado está en 0 inserto, si esta en dos actualizo.
    function obtenerEstadoModulo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $campo){
    	$result = 0;
    	$sql = "SELECT $campo
                FROM rmmh_admin_control
                WHERE nro_orden = $nro_orden
                AND nro_establecimiento = $nro_establecimiento
                AND ano_periodo = $ano_periodo
                AND mes_periodo = $mes_periodo";
    	$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
    		foreach($query->result() as $row){
	    		$result = $row->$campo;
    		}
    	}
    	$this->db->close();
    	return $result;    	
    }
    
    
	//DMDIAZF - Validar que todos los modulos ya hayan sido diligenciados por la fuente para poder enviar el formulario
    function validarEnvioFuente($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$retorno = true;
    	$envio = array();
    	$sql = "SELECT modulo1, modulo2, modulo3, modulo4, modulo5, envio
                FROM rmmh_admin_control
                WHERE nro_orden = $nro_orden
                AND nro_establecimiento = $nro_establecimiento
                AND ano_periodo = $ano_periodo
                AND mes_periodo = $mes_periodo";
    	$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
    		foreach($query->result() as $row){
    			$envio[0] = 2;
    			$envio[1] = $row->modulo1;
	    		$envio[2] = $row->modulo2;
	    		$envio[3] = $row->modulo3;
	    		$envio[4] = $row->modulo4;
	    		$envio[5] = $row->modulo5;	    		
    		}
    	}
    	$this->db->close();
    	
    	//Recorrer el array y verificar que cada uno de los modulos esta en dos.
    	for ($i=0; $i<count($envio); $i++){
    		if ($envio[$i]!=2){
    			$retorno = false;
    			break;
    		}
    	}
    	return $retorno;
    }
	
}

?>