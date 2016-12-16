<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Control extends CI_Model {
	
	function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->library("session");
        $this->load->library("general");
    }
    
    
    
    function validarPazYSalvo($nro_orden, $uni_local, $ano_periodo, $mes_periodo){
    	//Si el estado está en 99 - 5 ya fue verificado por el critico / asistente tecnico, por lo que ya puede descargar el paz y salvo
    	$retorno = false;
    	$sql = "SELECT fk_novedad, fk_estado
				FROM rmmh_admin_control
				WHERE nro_orden = $nro_orden
				AND uni_local = $uni_local
				AND ano_periodo = $ano_periodo
				AND mes_periodo = $mes_periodo";    
	   	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
    			//Pregunto si el formulario ya fue enviado
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
    
    
    
    //DMDIAZF - Junio 25 2012
    //Funcion para obtener los estados de todos los capitulos del formulario. Si todos los estados estan en capitulo2
	//entonces el formulario ha quedado diligenciado y pasa al estado 3.
	function validarEstadosFormulario($nro_orden, $uni_local, $ano_periodo, $mes_periodo){
		$array = array();
		$estadoGEN = 3;
		$sql = "SELECT caratula, cap1, cap2, cap3, cap4 
				FROM rmmh_admin_control
				WHERE nro_orden = $nro_orden
				AND uni_local = $uni_local
				AND ano_periodo = $ano_periodo
				AND mes_periodo = $mes_periodo";
		$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
    			$array[0] = $row->caratula;
    			$array[1] = $row->cap1;
    			$array[2] = $row->cap2;
    			$array[3] = $row->cap3;
    			$array[4] = $row->cap4;    			
    		}
    	}
    	
    	for ($i=0; $i<count($array); $i++){
    		if ($array[$i]!=2){
    			$estadoGEN = 2;
    			break;
    		}
    	}
    	$this->db->close();
    	return $estadoGEN;
	}    
    
    
    
    //dmdiazf - Junio 13 2012
    //Funcion para obtener el resumen de un periodo. 
    //Puede verse este resumen del periodo al momento en que se va a realilzar el cierre del periodo.
    //Se muestran los formularios Sin Distribuir, Distribuidos, En digitacion, Digitados, Analisis-Verificacion, Verificados
    function resumenPeriodo($ano, $mes){
    	
    }
    
    
    
    //dmdiazf - Junio 13 2012
    //Funcion para cerrar todos los estados y novedades de un periodo anterior
    //Todos los formularios de un periodo se cierran. Se ponen en novedad/estado 99 - 5, para representar que el formulario
    //se ha cerrado y que el control a partir del cierra lo tiene DANE Central
    function cierrePeriodoActual($ano, $mes){
    	$data = array('fk_novedad' => 99,
    	              'fk_estado' => 5);    	
		$this->db->where("ano_periodo", $ano);
		$this->db->where("mes_periodo", $mes);		
		$this->db->update("rmmh_admin_control", $data);
    } 
    
    
    //dmdiazf - Junio 08 2012
    //Funcion para duplicar los registros de control para un siguiente periodo.
    //Se duplican todos los registro de control para las fuentes.
    function crearFuentesPeriodo(){
    	$this->load->library("session");
    	$this->load->model("periodo");
    	$ano = $this->session->userdata("ano_periodo");
    	$mes = $this->session->userdata("mes_periodo");
    	$periodo = $this->periodo->obtenerPeriodoActual(); //Obtener el ultimo periodo mas reciente
    	$sql = "INSERT INTO rmmh_admin_control (nro_orden, uni_local, ano_periodo, mes_periodo, caratula, cap1, cap2, cap3, cap4, envio, fk_novedad, fk_estado, fk_sede, fk_subsede, fk_rolacceso, fk_usuario, control)
                SELECT DF.nro_orden, DF.uni_local, ".$periodo["ano"].",". $periodo["mes"]. ", 0, 0, 0, 0, 0, 0, 5, 0, DF.fk_sede, DF.fk_subsede, 1, U.id_usuario, 'A'
                FROM rmmh_admin_dirfuentes DF, rmmh_admin_usuarios U, rmmh_admin_control C
                WHERE DF.nro_orden = U.nro_orden
			    AND DF.nro_orden = C.nro_orden
			    AND C.ano_periodo = $ano
                AND C.mes_periodo = $mes
				AND U.fk_rol = 1";
    	$query = $this->db->query($sql);
    	$this->db->close();    	
    }
    
    
    // dmdiazf - Abril 19 2012
    // Funcion para bloquear los campos de un formulario luego de que el formulario ya 
    // fue enviado a DANE Central. Se bloquean los botones de envio en cada formulario, 
    // y se deshabilitan todas las cajas de texto.
    function bloquearCampos(){
    	$bloqueo = false;
    	$novestado = $this->obtenerNovedadEstado();
    	//Cuando el estado es 3, deben bloquearse los campos.
    	
    	if ($novestado["estado"]>=4){
    		$bloqueo = true;
    	}
    	return $bloqueo;
    }
    
	// dmdiazf - Abril 19 2012
    // Funcion para bloquear los campos de un formulario luego de que el formulario ya 
    // fue enviado a DANE Central. Se bloquean los botones de envio en cada formulario, 
    // y se deshabilitan todas las cajas de texto. Recibe como parametro el nro de orden y la unidad local
    function bloquearCamposAdministrador($nro_orden, $uni_local){
    	$bloqueo = true;
    	$novestado = $this->obtenerInfoNovedadEstado($nro_orden, $uni_local);
    	//Cuando la novedad es 5 y el estado es 3, deben bloquearse los campos.
    	if (($novestado["novedad"]==99)&&($novestado["estado"]==5)){
    		$bloqueo = false; //Habilito los campos solo si estan en estado 99 - 5
    	}
    	return $bloqueo;
    }
    
    
    //dmdiazf - Abril 30 2012
    //Funcion para obtener el numero de fuentes que se le han asignado a un usuario de rol distinto a fuente.
    function obtenerNumeroFuentesAsignadas($rol, $id){
    	$this->load->library("session");
    	$ano = $this->session->userdata("ano_periodo");
    	$mes = $this->session->userdata("mes_periodo");
    	$nro = 0;
    	$sql = "SELECT COUNT(*) AS nro
                FROM rmmh_admin_control C
                WHERE C.fk_rolacceso = $rol
                AND C.fk_usuario = $id
                AND C.ano_periodo = $ano
                AND C.mes_periodo = $mes";        
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
    			$nro = $row->nro;
    		}
    	}
    	$this->db->close();
    	return $nro;
    }
        
    
    // dmdiazf - Abril 19 2012
    // Funcion para obtener la novedad y el estado en el que se encuentra un formulario
    // ya se ha actualizado en la base de datos.
    private function obtenerNovedadEstado(){
    	$novestado = array('novedad' => 0, 'estado' => 0);
    	$nro_orden = $this->session->userdata('nro_orden');      //Obtener desde la sesion     
		$uni_local = $this->session->userdata('uni_local');      //Obtener desde la sesion  
		$ano_periodo = $this->session->userdata('ano_periodo');  //Obtener desde la sesion
		$mes_periodo = $this->session->userdata('mes_periodo');  //Obtener desde la sesion
		$sql = "SELECT fk_novedad AS novedad, fk_estado AS estado
                FROM rmmh_admin_control
                WHERE nro_orden = $nro_orden
                AND uni_local = $uni_local
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
    
    // dmdiazf - Mayo 15 2012
    // Funcion para obtener la novedad y el estado en el que se encuentra un formulario
    // ya se ha actualizado en la base de datos. (Recibe como parametro el numero de orden y la unidad local)
    private function obtenerInfoNovedadEstado($nro_orden, $uni_local){
    	$novestado = array('novedad' => 0, 'estado' => 0);
    	$ano_periodo = $this->session->userdata('ano_periodo');  //Obtener desde la sesion
		$mes_periodo = $this->session->userdata('mes_periodo');  //Obtener desde la sesion
		$sql = "SELECT fk_novedad AS novedad, fk_estado AS estado
                FROM rmmh_admin_control
                WHERE nro_orden = $nro_orden
                AND uni_local = $uni_local
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
    
    function actualizarControl($campo, $valor){
    	$nro_orden = $this->session->userdata('nro_orden');           
		$uni_local = $this->session->userdata('uni_local');        
		$ano_periodo = $this->session->userdata('ano_periodo');  
		$mes_periodo = $this->session->userdata('mes_periodo');  
    	$data = array($campo => $valor);    	
		$this->db->where("nro_orden", $nro_orden);
		$this->db->where("uni_local", $uni_local);
		$this->db->where("ano_periodo", $ano_periodo);
		$this->db->where("mes_periodo", $mes_periodo);		
		$this->db->update("rmmh_admin_control", $data);
    }
    
    function actualizarNovedad($novedad){
    	$nro_orden = $this->session->userdata('nro_orden');           
		$uni_local = $this->session->userdata('uni_local');        
		$ano_periodo = $this->session->userdata('ano_periodo');  
		$mes_periodo = $this->session->userdata('mes_periodo');  
		$data = array('fk_novedad' => $novedad);
		$this->db->where("nro_orden", $nro_orden);
		$this->db->where("uni_local", $uni_local);
		$this->db->where("ano_periodo", $ano_periodo);
		$this->db->where("mes_periodo", $mes_periodo);
		$this->db->update("rmmh_admin_control",$data);
    }
    
    function actualizarEstado($estado){
    	$nro_orden = $this->session->userdata('nro_orden');           
		$uni_local = $this->session->userdata('uni_local');        
		$ano_periodo = $this->session->userdata('ano_periodo');  
		$mes_periodo = $this->session->userdata('mes_periodo');  
		$data = array('fk_estado' => $estado);
		$this->db->where("nro_orden", $nro_orden);
		$this->db->where("uni_local", $uni_local);
		$this->db->where("ano_periodo", $ano_periodo);
		$this->db->where("mes_periodo", $mes_periodo);
		$this->db->update("rmmh_admin_control",$data);
    }
    
    function actualizarNovedadEstado($novedad, $estado){
    	$nro_orden = $this->session->userdata('nro_orden');           
		$uni_local = $this->session->userdata('uni_local');        
		$ano_periodo = $this->session->userdata('ano_periodo');  
		$mes_periodo = $this->session->userdata('mes_periodo');  
		$data = array('fk_novedad' => $novedad,
		              'fk_estado' => $estado  
		        );
		$this->db->where("nro_orden", $nro_orden);
		$this->db->where("uni_local", $uni_local);
		$this->db->where("ano_periodo", $ano_periodo);
		$this->db->where("mes_periodo", $mes_periodo);
		$this->db->update("rmmh_admin_control",$data);
    }
    
    function actualizarNovedadEstadoCritica($nro_orden, $uni_local, $novedad, $estado){
    	$this->load->library("session");
    	$ano_periodo = $this->session->userdata('ano_periodo');  
		$mes_periodo = $this->session->userdata('mes_periodo');  
		$data = array('fk_novedad' => $novedad,
		              'fk_estado' => $estado  
		        );
		$this->db->where("nro_orden", $nro_orden);
		$this->db->where("uni_local", $uni_local);
		$this->db->where("ano_periodo", $ano_periodo);
		$this->db->where("mes_periodo", $mes_periodo);
		$this->db->update("rmmh_admin_control",$data);
    }
    
    // dmdiazf - Mayo 15 2012
    // Realiza las operaciones de asignación de carga de fuentes a los críticos    
    function asignarFuenteCritico($nro_orden, $rol, $usuario){
    	$data = array('fk_rolacceso'=>$rol,
    	              'fk_usuario' => $usuario);
    	$this->db->where("nro_orden", $nro_orden);
    	$this->db->update("rmmh_admin_control",$data);
    }
    
     // dmdiazf - Mayo 15 2012
     //Crea los registros de control cuando se realiza el cargue masivo del directorio     
     function insertarControl($nro_orden, $uni_local, $ano_periodo, $mes_periodo, $caratula, $cap1, $cap2, $cap3, $cap4, $envio, $fk_novedad, $fk_estado, $fk_sede, $fk_subsede, $fk_rolacceso, $fk_usuario, $control){
     	$data = array('nro_orden' => $nro_orden, 
     				  'uni_local' => $uni_local, 
     				  'ano_periodo' => $ano_periodo, 
     				  'mes_periodo' => $mes_periodo, 
     				  'caratula' => $caratula, 
     				  'cap1' =>	$cap1, 
     				  'cap2' => $cap2, 
     				  'cap3' => $cap3, 
     				  'cap4' => $cap4, 
     				  'envio' => $envio, 
     				  'fk_novedad' => $fk_novedad, 
     				  'fk_estado' => $fk_estado, 
     				  'fk_sede' => $fk_sede, 
     				  'fk_subsede' => $fk_subsede, 
     				  'fk_rolacceso' => $fk_rolacceso, 
     				  'fk_usuario' => $fk_usuario, 
     				  'control' => $control);
     	$this->db->insert('rmmh_admin_control', $data);
		$this->db->close();	
     }
     
     
     // DMDIAZF - Mayo 25 2012
     // Grupo de funciones para realizar las consultas del reporte de control de operativo
     function informeOperativo($ano, $mes, $sede, $subsede){
     	//Desde esta funcion se llaman a las demas funciones y se obtiene todo el reporte operativo
     	$informeOP = array();
     	$informeOP["directorio_base"] = $this->directorioBase($usuario=0, $ano, $mes, $sede, $subsede);
     	$informeOP["nuevos"] = $this->nuevos($usuario=0, $ano, $mes, $sede, $subsede);
     	$informeOP["total_recolectar"] = $informeOP["directorio_base"] + $informeOP["nuevos"];
     	$informeOP["sin_distribuir"] = $this->sinDistribuir($usuario=0, $ano, $mes, $sede, $subsede);
     	$informeOP["distribuidos"] = $this->distribuidos($usuario=0, $ano, $mes, $sede, $subsede);
     	$informeOP["digitacion"] = $this->digitacion($usuario=0, $ano, $mes, $sede, $subsede);
     	$informeOP["digitados"] = $this->digitados($usuario=0, $ano, $mes, $sede, $subsede);
     	$informeOP["analisis_verificacion"] = $this->analisisVerificacion($usuario=0, $ano, $mes, $sede, $subsede);
     	$informeOP["verificados"] = $this->verificados($usuario=0, $ano, $mes, $sede, $subsede);
     	$informeOP["novedades"] = $this->novedades($usuario=0, $ano, $mes, $sede, $subsede);
     	$informeOP["pct_dbase"] = $this->calcularPorcentaje($informeOP["directorio_base"], $informeOP["total_recolectar"]);
     	$informeOP["pct_nuevos"] = $this->calcularPorcentaje($informeOP["nuevos"], $informeOP["total_recolectar"]);
     	$informeOP["pct_totrecolectar"] = $this->calcularPorcentaje($informeOP["total_recolectar"], $informeOP["total_recolectar"]);
     	$informeOP["pct_sindistribuir"] = $this->calcularPorcentaje($informeOP["sin_distribuir"], $informeOP["total_recolectar"]);
     	$informeOP["pct_distribuidos"] = $this->calcularPorcentaje($informeOP["distribuidos"], $informeOP["total_recolectar"]);
     	$informeOP["pct_digitacion"] = $this->calcularPorcentaje($informeOP["digitacion"], $informeOP["total_recolectar"]);
     	$informeOP["pct_digitados"] = $this->calcularPorcentaje($informeOP["digitados"], $informeOP["total_recolectar"]);
     	$informeOP["pct_analisisver"] = $this->calcularPorcentaje($informeOP["analisis_verificacion"], $informeOP["total_recolectar"]);
     	$informeOP["pct_verificados"] = $this->calcularPorcentaje($informeOP["verificados"], $informeOP["total_recolectar"]);
     	$informeOP["pct_novedades"] = $this->calcularPorcentaje($informeOP["novedades"], $informeOP["total_recolectar"]);
     	return $informeOP;
     }
     
     
     // DMDIAZF - Junio 04 2012
     // Grupo de funciones para realizar las consultas del reporte de control de operativo (Obtiene reporte operativo para un usuario particular)
     function informeOperativoUsuario($usuario, $ano, $mes, $sede, $subsede){
     	//Desde esta funcion se llaman a las demas funciones y se obtiene todo el reporte operativo
     	$informeOP = array();
     	$informeOP["directorio_base"] = $this->directorioBase($usuario, $ano, $mes, $sede, $subsede);
     	$informeOP["nuevos"] = $this->nuevos($usuario, $ano, $mes, $sede, $subsede);
     	$informeOP["total_recolectar"] = $informeOP["directorio_base"] + $informeOP["nuevos"];
     	$informeOP["sin_distribuir"] = $this->sinDistribuir($usuario, $ano, $mes, $sede, $subsede);
     	$informeOP["distribuidos"] = $this->distribuidos($usuario, $ano, $mes, $sede, $subsede);
     	$informeOP["digitacion"] = $this->digitacion($usuario, $ano, $mes, $sede, $subsede);
     	$informeOP["digitados"] = $this->digitados($usuario, $ano, $mes, $sede, $subsede);
     	$informeOP["analisis_verificacion"] = $this->analisisVerificacion($usuario, $ano, $mes, $sede, $subsede);
     	$informeOP["verificados"] = $this->verificados($usuario, $ano, $mes, $sede, $subsede);
     	$informeOP["novedades"] = $this->novedades($usuario, $ano, $mes, $sede, $subsede);
     	$informeOP["pct_dbase"] = $this->calcularPorcentaje($informeOP["directorio_base"], $informeOP["total_recolectar"]);
     	$informeOP["pct_nuevos"] = $this->calcularPorcentaje($informeOP["nuevos"], $informeOP["total_recolectar"]);
     	$informeOP["pct_totrecolectar"] = $this->calcularPorcentaje($informeOP["total_recolectar"], $informeOP["total_recolectar"]);
     	$informeOP["pct_sindistribuir"] = $this->calcularPorcentaje($informeOP["sin_distribuir"], $informeOP["total_recolectar"]);
     	$informeOP["pct_distribuidos"] = $this->calcularPorcentaje($informeOP["distribuidos"], $informeOP["total_recolectar"]);
     	$informeOP["pct_digitacion"] = $this->calcularPorcentaje($informeOP["digitacion"], $informeOP["total_recolectar"]);
     	$informeOP["pct_digitados"] = $this->calcularPorcentaje($informeOP["digitados"], $informeOP["total_recolectar"]);
     	$informeOP["pct_analisisver"] = $this->calcularPorcentaje($informeOP["analisis_verificacion"], $informeOP["total_recolectar"]);
     	$informeOP["pct_verificados"] = $this->calcularPorcentaje($informeOP["verificados"], $informeOP["total_recolectar"]);
     	$informeOP["pct_novedades"] = $this->calcularPorcentaje($informeOP["novedades"], $informeOP["total_recolectar"]);
     	return $informeOP;
     }
     
	 // DMDIAZF - Mayo 25 2012
	 // Funcion para obtener el conteo del directorio base para un periodo
     private function directorioBase($usuario, $ano, $mes, $sede, $subsede){
     	$this->load->library("session");
     	$ano = $this->session->userdata("ano_periodo");
     	$mes = $this->session->userdata("mes_periodo");
     	$nregs = 0;
     	$sql = "SELECT COUNT(*) AS nregs
			    FROM rmmh_admin_control
                WHERE nro_orden <> 0 
                AND fk_novedad = 5 ";
     	if ($sede!=0){
     		$sql.= "AND fk_sede = $sede ";
     	}
     	if ($subsede!=0){
     		$sql.= "AND fk_subsede = $subsede ";
     	}
     	if ($usuario!=0){
     		$sql.= "AND fk_usuario = $usuario ";
     	}
     	$sql.= "AND ano_periodo = $ano 
     	        AND mes_periodo = $mes";
     	$query = $this->db->query($sql);
		foreach ($query->result() as $row){
      		$nregs = $row->nregs;
      	}
		$this->db->close();
		return $nregs;
     }

     // DMDIAZF - Mayo 25 2012
     // Funcion para obtener el conteo de nuevos (fuentes que ingresan a la muestra como nuevos)
     private function nuevos($usuario, $ano, $mes, $sede, $subsede){
     	$this->load->library("session");
     	$ano = $this->session->userdata("ano_periodo");
     	$mes = $this->session->userdata("mes_periodo");
     	$nregs = 0;
     	$sql = "SELECT COUNT(*) AS nregs
			    FROM rmmh_admin_control
				WHERE nro_orden <> 0 
				AND fk_novedad = 9 ";
     	if ($sede!=0){
     		$sql.= "AND fk_sede = $sede ";
     	}
     	if ($subsede!=0){
     		$sql.= "AND fk_subsede = $subsede ";
     	}
     	if ($usuario!=0){
     		$sql.= "AND fk_usuario = $usuario ";
     	}
     	$sql.= "AND ano_periodo = $ano 
     	        AND mes_periodo = $mes";
     	$query = $this->db->query($sql);
		foreach ($query->result() as $row){
      		$nregs = $row->nregs;
      	}
		$this->db->close();
		return $nregs;
     }
     
     // DMDIAZF - Mayo 25 2012
     // Funcion para obtener el conteo de formularios sin distribuir
     public function sinDistribuir($usuario, $ano, $mes, $sede, $subsede){
     	$this->load->library("session");
     	$ano = $this->session->userdata("ano_periodo");
     	$mes = $this->session->userdata("mes_periodo");
     	$nregs = 0;
     	$sql = "SELECT COUNT(*) AS nregs
				FROM rmmh_admin_control
				WHERE nro_orden <> 0 
				AND fk_estado = 0 ";
     	if ($sede!=0){
     		$sql.= "AND fk_sede = $sede ";
     	}
     	if ($subsede!=0){
     		$sql.= "AND fk_subsede = $subsede ";
     	}
     	if ($usuario!=0){
     		$sql.= "AND fk_usuario = $usuario ";
     	}
     	$sql.= "AND ano_periodo = $ano
     	        AND mes_periodo = $mes";
     	$query = $this->db->query($sql);
		foreach ($query->result() as $row){
      		$nregs = $row->nregs;
      	}
		$this->db->close();
		return $nregs;
     }
     	
     // DMDIAZF - Mayo 25 2012
     // Funcion para obtener el conteo de formularios distribuidos
     public function distribuidos($usuario, $ano, $mes, $sede, $subsede){
     	$this->load->library("session");
     	$ano = $this->session->userdata("ano_periodo");
     	$mes = $this->session->userdata("mes_periodo");
     	$nregs = 0;
     	$sql = "SELECT COUNT(*) AS nregs
			    FROM rmmh_admin_control
				WHERE nro_orden <> 0 
				AND fk_estado = 1 ";
     	if ($sede!=0){
     		$sql .= "AND fk_sede = $sede ";
     	}
     	if ($subsede!=0){
     		$sql .= "AND fk_subsede = $subsede ";
     	}
     	if ($usuario!=0){
     		$sql.= "AND fk_usuario = $usuario ";
     	}
     	$sql.= "AND ano_periodo = $ano
     	        AND mes_periodo = $mes";
     	$query = $this->db->query($sql);
		foreach ($query->result() as $row){
      		$nregs = $row->nregs;
      	}
		$this->db->close();
		return $nregs;
     }
     
     // DMDIAZF - Mayo 25 2012
     // Funcion para obtener el conteo de formularios en digitacion
     public function digitacion($usuario, $ano, $mes, $sede, $subsede){
     	$this->load->library("session");
     	$ano = $this->session->userdata("ano_periodo");
     	$mes = $this->session->userdata("mes_periodo");
     	$nregs = 0;
     	$sql = "SELECT COUNT(*) AS nregs
				FROM rmmh_admin_control
				WHERE nro_orden <> 0 
				AND fk_estado = 2 ";
     	if ($sede!=0){
     		$sql .= "AND fk_sede = $sede ";
     	}
     	if ($subsede!=0){
     		$sql .= "AND fk_subsede = $subsede ";
     	}
     	if ($usuario!=0){
     		$sql.= "AND fk_usuario = $usuario ";
     	}
     	$sql.= "AND ano_periodo = $ano
     	        AND mes_periodo = $mes";
     	$query = $this->db->query($sql);
		foreach ($query->result() as $row){
      		$nregs = $row->nregs;
      	}
		$this->db->close();
		return $nregs;
     } 
     
     // DMDIAZF - Mayo 25 2012
     // Funcion para obtener el conteo de formularios digitados
     public function digitados($usuario, $ano, $mes, $sede, $subsede){
     	$this->load->library("session");
     	$ano = $this->session->userdata("ano_periodo");
     	$mes = $this->session->userdata("mes_periodo");
     	$nregs = 0;
     	$sql = "SELECT COUNT(*) AS nregs
			    FROM rmmh_admin_control
				WHERE  nro_orden <> 0
				AND fk_estado = 3 ";
     	if ($sede!=0){
     		$sql .= "AND fk_sede = $sede ";
     	}
     	if ($subsede!=0){
     		$sql .= "AND fk_subsede = $subsede ";
     	}
     	if ($usuario!=0){
     		$sql.= "AND fk_usuario = $usuario ";
     	}
     	$sql.= "AND ano_periodo = $ano
     	        AND mes_periodo = $mes";
     	$query = $this->db->query($sql);
		foreach ($query->result() as $row){
      		$nregs = $row->nregs;
      	}
		$this->db->close();
		return $nregs;
     }
     
     // DMDIAZF - Mayo 25 2012
     // Funcion para obtener el conteo de formularios en Análisis - Verificación
     public function analisisVerificacion($usuario, $ano, $mes, $sede, $subsede){
     	$this->load->library("session");
     	$ano = $this->session->userdata("ano_periodo");
     	$mes = $this->session->userdata("mes_periodo");
     	$nregs = 0;
     	$sql = "SELECT COUNT(*) AS nregs
				FROM rmmh_admin_control
				WHERE nro_orden <> 0 
				AND fk_novedad = 99
				AND fk_estado = 4 ";
     	if ($sede!=0){
     		$sql .= "AND fk_sede = $sede ";
     	}
     	if ($subsede!=0){
     		$sql .= "AND fk_subsede = $subsede ";
     	}
     	if ($usuario!=0){
     		$sql.= "AND fk_usuario = $usuario ";
     	}
     	$sql.= "AND ano_periodo = $ano
     	        AND mes_periodo = $mes";
     	$query = $this->db->query($sql);
     	foreach ($query->result() as $row){
      		$nregs = $row->nregs;
      	}
		$this->db->close();
		return $nregs;     	
     }
     
     // DMDIAZF - Mayo 25 2012
     // Funcion para obtener el conteo de formularios verificados
     public function verificados($usuario, $ano, $mes, $sede, $subsede){
     	$this->load->library("session");
     	$ano = $this->session->userdata("ano_periodo");
     	$mes = $this->session->userdata("mes_periodo");
     	$nregs = 0;
     	$sql = "SELECT COUNT(*) AS nregs
				FROM rmmh_admin_control
				WHERE nro_orden <> 0 
				AND fk_novedad = 99
				AND fk_estado = 5 ";
     	if ($sede!=0){
     		$sql .= "AND fk_sede = $sede ";
     	}
     	if ($subsede!=0){
     		$sql .= "AND fk_subsede = $subsede ";
     	}
     	if ($usuario!=0){
     		$sql.= "AND fk_usuario = $usuario ";
     	}
     	$sql.= "AND ano_periodo = $ano
     	        AND mes_periodo = $mes";
     	$query = $this->db->query($sql);
     	foreach ($query->result() as $row){
      		$nregs = $row->nregs;
      	}
		$this->db->close();
		return $nregs;
     }
     
     // DMDIAZF - Mayo 25 2012
     // Funcion para obtener el conteo de formularios con novedades
     private function novedades($usuario, $ano, $mes, $sede, $subsede){
     	$this->load->library("session");
     	$ano = $this->session->userdata("ano_periodo");
     	$mes = $this->session->userdata("mes_periodo");
     	$nregs = 0;
     	$sql = "SELECT COUNT(*) AS nregs
     	        FROM rmmh_admin_control
     	        WHERE nro_orden <> 0 
     	        AND fk_novedad NOT IN (5,9,99)
     	        AND fk_estado = 5 ";
     	if ($sede!=0){
     		$sql .= "AND fk_sede = $sede ";
     	}
     	if ($subsede!=0){
     		$sql .= "AND fk_subsede = $subsede ";
     	}
     	if ($usuario!=0){
     		$sql.= "AND fk_usuario = $usuario ";
     	}
     	$sql.= "AND ano_periodo = $ano
     	        AND mes_periodo = $mes";
     	$query = $this->db->query($sql);
     	foreach ($query->result() as $row){
      		$nregs = $row->nregs;
      	}
		$this->db->close();
		return $nregs;
     }

     // DMDIAZF - Mayo 25 2012
     // Funcion para calcular el porcentaje de un valor sobre una base
     private function calcularPorcentaje($valor, $base){
     	if ($base>0){
     		$porc = ($valor * 100) / $base;
     	}
     	else{
     		$porc = 0;
     	}
     	return number_format($porc,2,',','.');     	
     }
     
     
     
}//EOC
