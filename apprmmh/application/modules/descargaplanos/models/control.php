<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Control extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->library("session");
    }
    
   	function obtenerNovedadEstado($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
   		$result = array();
   		$sql = "SELECT fk_novedad, fk_estado
                FROM rmmh_admin_control
                WHERE nro_orden = $nro_orden
                AND nro_establecimiento = $nro_establecimiento
                AND ano_periodo = $ano_periodo
                AND mes_periodo = $mes_periodo";
   		$query = $this->db->query($sql);
   		if ($query->num_rows()>0){
			foreach($query->result() as $row){
				$result["novedad"] = $row->fk_novedad;
				$result["estado"] = $row->fk_estado;
			}
		}
		$this->db->close();
		return $result;
   	} 
    
    function actualizarNovedadEstado($nro_orden, $uni_local, $ano_periodo, $mes_periodo, $novedad, $estado){
    	$data = array('fk_novedad' => $novedad,
		              'fk_estado' => $estado  
		        );
		$this->db->where("nro_orden", $nro_orden);
		$this->db->where("uni_local", $uni_local);
		$this->db->where("ano_periodo", $ano_periodo);
		$this->db->where("mes_periodo", $mes_periodo);
		$this->db->update("rmmh_admin_control",$data);
    }
    
	function informeOperativoCritico($idcritico, $ano_periodo, $mes_periodo, $sede, $subsede){
		$informeOP = array();
     	$informeOP["directorio_base"] = $this->directorioBase($idcritico, 0, $ano_periodo, $mes_periodo, $sede, $subsede);
     	$informeOP["nuevos"] = $this->nuevos($idcritico, 0, $ano_periodo, $mes_periodo, $sede, $subsede);
     	$informeOP["total_recolectar"] = $informeOP["directorio_base"] + $informeOP["nuevos"];
		$informeOP["sin_distribuir"] = $this->sinDistribuir($idcritico, 0, $ano_periodo, $mes_periodo, $sede, $subsede);
		$informeOP["distribuidos"] = $this->distribuidos($idcritico, 0, $ano_periodo, $mes_periodo, $sede, $subsede);
     	$informeOP["digitacion"] = $this->digitacion($idcritico, 0, $ano_periodo, $mes_periodo, $sede, $subsede);
     	$informeOP["digitados"] = $this->digitados($idcritico, 0, $ano_periodo, $mes_periodo, $sede, $subsede);
     	$informeOP["analisis_verificacion"] = $this->analisisVerificacion($idcritico, 0, $ano_periodo, $mes_periodo, $sede, $subsede);
     	$informeOP["verificados"] = $this->verificados($idcritico, 0, $ano_periodo, $mes_periodo, $sede, $subsede);
     	$informeOP["novedades"] = $this->novedades($idcritico, 0, $ano_periodo, $mes_periodo, $sede, $subsede);
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
	
	//Realiza el conteo del directorio base asignado a un critico
	function directorioBase($usuarioCR, $usuarioLOG, $ano_periodo, $mes_periodo, $sede, $subsede){
		$total = 0;
     	$sql = "SELECT COUNT(*) AS dirbase
                FROM rmmh_admin_control
                WHERE nueva = 0
                AND ano_periodo = $ano_periodo
                AND mes_periodo = $mes_periodo ";
     	if ($usuarioCR!=0){
        	$sql.= "AND fk_usuariocritica = $usuarioCR ";
        }
        if ($usuarioLOG!=0){
        	$sql.= "AND fk_usuariologistica = $usuarioLOG ";
        } 
        if ($sede!=0){
     		$sql.= "AND fk_sede = $sede ";
     	}
     	if ($subsede!=0){
     		$sql.= "AND fk_subsede = $subsede ";
     	}
     	$query = $this->db->query($sql);
		foreach ($query->result() as $row){
      		$total = $row->dirbase;
      	}
		$this->db->close();
		return $total;
	}
	
	//Realiza el conteo de las fuentes nuevas asignadas a un critico
	public function nuevos($usuarioCR, $usuarioLOG, $ano_periodo, $mes_periodo, $sede, $subsede){
     	$total = 0;
     	$sql = "SELECT COUNT(*) AS nuevos
     	        FROM rmmh_admin_control
     	        WHERE nueva = 1
     	        AND ano_periodo = $ano_periodo
     	        AND mes_periodo = $mes_periodo ";        
		if ($usuarioCR!=0){
        	$sql.= "AND fk_usuariocritica = $usuarioCR ";
        }
        if ($usuarioLOG!=0){
        	$sql.= "AND fk_usuariologistica = $usuarioLOG ";
        } 		
     	if ($sede!=0){
     		$sql.= "AND fk_sede = $sede ";
     	}
     	if ($subsede!=0){
     		$sql.= "AND fk_subsede = $subsede ";
     	}
     	$query = $this->db->query($sql);
		foreach ($query->result() as $row){
      		$total = $row->nuevos;
      	}
		$this->db->close();
		return $total;
    }
	
	//Realiza el conteo de las fuentes sin distribuir asignadas a un critico
    public function sinDistribuir($usuarioCR, $usuarioLOG, $ano_periodo, $mes_periodo, $sede, $subsede){
     	$total = 0;
     	$sql = "SELECT COUNT(*) AS sindist
				FROM rmmh_admin_control
				WHERE fk_novedad IN (5,9) 
				AND fk_estado = 0 
				AND ano_periodo = $ano_periodo
				AND mes_periodo = $mes_periodo ";
		if ($usuarioCR!=0){
        	$sql.= "AND fk_usuariocritica = $usuarioCR ";
        }
        if ($usuarioLOG!=0){
        	$sql.= "AND fk_usuariologistica = $usuarioLOG ";
        } 		
     	if ($sede!=0){
     		$sql.= "AND fk_sede = $sede ";
     	}
     	if ($subsede!=0){
     		$sql.= "AND fk_subsede = $subsede ";
     	}
     	$query = $this->db->query($sql);
		foreach ($query->result() as $row){
      		$total = $row->sindist;
      	}
		$this->db->close();
		return $total;
    }
	
	//Realiza el conteo de las fuentes distribuidas que han sido asignadas a un critico
    public function distribuidos($usuarioCR, $usuarioLOG, $ano_periodo, $mes_periodo, $sede, $subsede){
     	$total = 0;
     	$sql = "SELECT COUNT(*) AS dists
			    FROM rmmh_admin_control
				WHERE fk_novedad IN (5,9) 
				AND fk_estado = 1
				AND ano_periodo = $ano_periodo
                AND mes_periodo = $mes_periodo ";
		if ($usuarioCR!=0){
        	$sql.= "AND fk_usuariocritica = $usuarioCR ";
        }
        if ($usuarioLOG!=0){
        	$sql.= "AND fk_usuariologistica = $usuarioLOG ";
        } 			
     	if ($sede!=0){
     		$sql .= "AND fk_sede = $sede ";
     	}
     	if ($subsede!=0){
     		$sql .= "AND fk_subsede = $subsede ";
     	}
     	$query = $this->db->query($sql);
		foreach ($query->result() as $row){
      		$total = $row->dists;
      	}
		$this->db->close();
		return $total;
    }
	
	
    //Funcion para obtener el conteo de formularios en digitacion
    public function digitacion($usuarioCR, $usuarioLOG, $ano_periodo, $mes_periodo, $sede, $subsede){
     	$total = 0;
     	$sql = "SELECT COUNT(*) AS digit
				FROM rmmh_admin_control
				WHERE fk_novedad IN (5,9) 
				AND fk_estado = 2 
				AND ano_periodo = $ano_periodo
				AND mes_periodo = $mes_periodo ";
		if ($usuarioCR!=0){
        	$sql.= "AND fk_usuariocritica = $usuarioCR ";
        }
        if ($usuarioLOG!=0){
        	$sql.= "AND fk_usuariologistica = $usuarioLOG ";
        } 	
     	if ($sede!=0){
     		$sql .= "AND fk_sede = $sede ";
     	}
     	if ($subsede!=0){
     		$sql .= "AND fk_subsede = $subsede ";
     	}
     	$query = $this->db->query($sql);
		foreach ($query->result() as $row){
      		$total = $row->digit;
      	}
		$this->db->close();
		return $total;
    }

    //Funcion para obtener el conteo de formularios digitados
    public function digitados($usuarioCR, $usuarioLOG, $ano_periodo, $mes_periodo, $sede, $subsede){
     	$total = 0;
     	$sql = "SELECT COUNT(*) AS digit
			    FROM rmmh_admin_control
				WHERE fk_novedad IN (5,9) 
				AND fk_estado = 3 
				AND ano_periodo = $ano_periodo
				AND mes_periodo = $mes_periodo ";
		if ($usuarioCR!=0){
        	$sql.= "AND fk_usuariocritica = $usuarioCR ";
        }
        if ($usuarioLOG!=0){
        	$sql.= "AND fk_usuariologistica = $usuarioLOG ";
        } 	    			
     	if ($sede!=0){
     		$sql .= "AND fk_sede = $sede ";
     	}
     	if ($subsede!=0){
     		$sql .= "AND fk_subsede = $subsede ";
     	}
     	$query = $this->db->query($sql);
		foreach ($query->result() as $row){
      		$total = $row->digit;
      	}
		$this->db->close();
		return $total;
    }
	
	//Funcion para obtener el conteo de formularios en analisis-verificacion de un critico 	
	public function analisisVerificacion($usuarioCR, $usuarioLOG, $ano_periodo, $mes_periodo, $sede, $subsede){
     	$total = 0;
     	$sql = "SELECT COUNT(*) AS anverif
				FROM rmmh_admin_control
				WHERE fk_novedad = 99
				AND fk_estado = 4 
				AND ano_periodo = $ano_periodo 
				AND mes_periodo = $mes_periodo ";
		if ($usuarioCR!=0){
        	$sql.= "AND fk_usuariocritica = $usuarioCR ";
        }
        if ($usuarioLOG!=0){
        	$sql.= "AND fk_usuariologistica = $usuarioLOG ";
        }     			
     	if ($sede!=0){
     		$sql .= "AND fk_sede = $sede ";
     	}
     	if ($subsede!=0){
     		$sql .= "AND fk_subsede = $subsede ";
     	}
     	$query = $this->db->query($sql);
     	foreach ($query->result() as $row){
      		$total = $row->anverif;
      	}
		$this->db->close();
		return $total;     	
    }

	//Funcion para obtener el conteo de formularios verificados
    public function verificados($usuarioCR, $usuarioLOG, $ano_periodo, $mes_periodo, $sede, $subsede){
     	$total = 0;
     	$sql = "SELECT COUNT(*) AS verif
				FROM rmmh_admin_control
				WHERE fk_novedad = 99
				AND fk_estado = 5 
				AND ano_periodo = $ano_periodo
				AND mes_periodo = $mes_periodo ";
		if ($usuarioCR!=0){
        	$sql.= "AND fk_usuariocritica = $usuarioCR ";
        }
        if ($usuarioLOG!=0){
        	$sql.= "AND fk_usuariologistica = $usuarioLOG ";
        }   		
     	if ($sede!=0){
     		$sql .= "AND fk_sede = $sede ";
     	}
     	if ($subsede!=0){
     		$sql .= "AND fk_subsede = $subsede ";
     	}
     	$query = $this->db->query($sql);
     	foreach ($query->result() as $row){
      		$total = $row->verif;
      	}
		$this->db->close();
		return $total;
    }


    //Funcion para obtener el conteo de formularios con novedades
    //Se modifica el query para que solo tenga en cuenta las novedades que han sido aprobadas. 
    public function novedades($usuarioCR, $usuarioLOG, $ano_periodo, $mes_periodo, $sede, $subsede){
     	$total = 0;
     	$sql = "SELECT COUNT(*) AS novs
                FROM ( SELECT *
                       FROM rmmh_admin_control
                       WHERE ano_periodo = $ano_periodo
                       AND mes_periodo = $mes_periodo
                       AND fk_novedad NOT IN (5,9,99)
                     ) A
                JOIN ( SELECT *
                       FROM rmmh_admin_histnovedades
                       WHERE ano_periodo = $ano_periodo
                       AND mes_periodo = $mes_periodo
                       GROUP BY nro_orden, nro_establecimiento, ano_periodo, mes_periodo
                     ) B
                ON  A.nro_orden = B.nro_orden AND A.nro_establecimiento = B.nro_establecimiento AND A.ano_periodo = B.ano_periodo AND A.mes_periodo = B.mes_periodo
                WHERE 1 = 1";
        if ($usuarioCR!=0){
     		$sql.= " AND A.fk_usuariocritica = $usuarioCR ";
     	}
     	if ($usuarioLOG!=0){
     		$sql.= " AND A.fk_usuariologistica = $usuarioLOG ";
     	}
    	if ($sede!=0){
     		$sql.= " AND A.fk_sede = $sede ";
     	}
     	if ($subsede!=0){
     		$sql.= " AND A.fk_subsede = $subsede ";
     	}         	
     	$query = $this->db->query($sql);
     	foreach ($query->result() as $row){
      		$total = $row->novs;
      	}
		$this->db->close();
		return $total;		
    }

	//Funcion para calcular el porcentaje de un valor sobre una base
    private function calcularPorcentaje($valor, $base){
     	if ($base>0){
     		$porc = ($valor * 100) / $base;
     	}
     	else{
     		$porc = 0;
     	}
     	return number_format($porc,2,',','.');     	
    }

	//Crea los registros de control cuando se realiza el cargue masivo del directorio
	 function insertarControl($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $nueva, $modulo1, $modulo2, $modulo3, $modulo4, $envio, $inclusion, $control, $fk_novedad, $fk_estado, $fk_sede, $fk_subsede, $fk_usuariocritica, $fk_usuariologistica){
	 	$data = array('nro_orden' => $nro_orden, 
	 	              'nro_establecimiento' => $nro_establecimiento, 
	 	              'ano_periodo' => $ano_periodo, 
	 	              'mes_periodo' => $mes_periodo, 
	 	              'nueva' => $nueva, 
	 	              'modulo1' => $modulo1, 
	 	              'modulo2' => $modulo2, 
	 	              'modulo3' => $modulo3, 
	 	              'modulo4' => $modulo4, 
	 	              'envio' => $envio, 
	 	              'inclusion' => $inclusion, 
	 	              'control' => $control, 
	 	              'fk_novedad' => $fk_novedad, 
	 	              'fk_estado' => $fk_estado, 
	 	              'fk_sede' => $fk_sede, 
	 	              'fk_subsede' => $fk_subsede, 
	 	              'fk_usuariocritica' => $fk_usuariocritica, 
	 	              'fk_usuariologistica' => $fk_usuariologistica);
	 	$this->db->insert('rmmh_admin_control', $data);
		$this->db->close();
	 }     
     
     
	function validarPazYSalvo($nro_orden, $uni_local, $ano_periodo, $mes_periodo){
    	//Si el estado está en 99 - 5 ya fue verificado por el critico / asistente tecnico, por lo que ya puede descargar el paz y salvo
    	$retorno = false;
    	$sql = "SELECT fk_novedad, fk_estado
                FROM rmmh_admin_control
                WHERE nro_orden = $nro_orden
                AND nro_establecimiento = $uni_local
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
    
	 // DMDIAZF - Mayo 25 2012
     // Grupo de funciones para realizar las consultas del reporte de control de operativo
     function informeOperativo($ano, $mes, $sede, $subsede){
     	//Desde esta funcion se llaman a las demas funciones y se obtiene todo el reporte operativo
     	$informeOP = array();
     	$informeOP["directorio_base"] = $this->directorioBase($usuarioCR=0, $usuarioLOG=0, $ano, $mes, $sede, $subsede);
     	$informeOP["nuevos"] = $this->nuevos($usuarioCR=0, $usuarioLOG=0, $ano, $mes, $sede, $subsede);
     	$informeOP["total_recolectar"] = $informeOP["directorio_base"] + $informeOP["nuevos"];
     	$informeOP["sin_distribuir"] = $this->sinDistribuir($usuarioCR=0, $usuarioLOG=0, $ano, $mes, $sede, $subsede);
     	$informeOP["distribuidos"] = $this->distribuidos($usuarioCR=0, $usuarioLOG=0, $ano, $mes, $sede, $subsede);
     	$informeOP["digitacion"] = $this->digitacion($usuarioCR=0, $usuarioLOG=0, $ano, $mes, $sede, $subsede);
     	$informeOP["digitados"] = $this->digitados($usuarioCR=0, $usuarioLOG=0, $ano, $mes, $sede, $subsede);
     	$informeOP["analisis_verificacion"] = $this->analisisVerificacion($usuarioCR=0, $usuarioLOG=0, $ano, $mes, $sede, $subsede);
     	$informeOP["verificados"] = $this->verificados($usuarioCR=0, $usuarioLOG=0, $ano, $mes, $sede, $subsede);
     	$informeOP["novedades"] = $this->novedades($usuarioCR=0, $usuarioLOG=0, $ano, $mes, $sede, $subsede);
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
     
	// dmdiazf - Mayo 15 2012
    // Realiza las operaciones de asignación de carga de fuentes a los críticos    
    function asignarFuenteCritico($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $usuario){
    	$data = array('fk_usuariocritica' => $usuario);
    	$this->db->where("nro_orden", $nro_orden);
    	$this->db->where("nro_establecimiento", $nro_establecimiento);
    	$this->db->where("ano_periodo", $ano_periodo);
    	$this->db->where("mes_periodo", $mes_periodo);
    	$this->db->update("rmmh_admin_control",$data);
    }
    
	// dmdiazf - Julio 31 2012
    // Realiza las operaciones de asignación de carga de fuentes a los logisticos    
    function asignarFuenteLogistico($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $usuario){
    	$data = array('fk_usuariologistica'=>$usuario);
    	$this->db->where("nro_orden", $nro_orden);
    	$this->db->where("nro_establecimiento", $nro_establecimiento);
    	$this->db->where("ano_periodo", $ano_periodo);
    	$this->db->where("mes_periodo", $mes_periodo);
    	$this->db->update("rmmh_admin_control",$data);
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
    	$sql = "INSERT INTO rmmh_admin_control (nro_orden, nro_establecimiento, ano_periodo, mes_periodo, nueva, modulo1, modulo2, modulo3, modulo4, envio, inclusion, control, fk_novedad, fk_estado, fk_sede, fk_subsede, fk_usuariocritica, fk_usuariologistica)
                SELECT C.nro_orden, C.nro_establecimiento, ".$periodo["ano"].",".$periodo["mes"].", 0, 0, 0, 0, 0, 0, C.inclusion, 'A', 5, 0, C.fk_sede, C.fk_subsede, C.fk_usuariocritica, C.fk_usuariologistica
                FROM rmmh_admin_control C
                WHERE C.ano_periodo = $ano
                AND C.mes_periodo = $mes";		
    	$query = $this->db->query($sql);
    	$this->db->close();    	
    }
    
    //dmdiazf - Junio 13 2012
    //Funcion para cerrar todos los estados y novedades de un periodo anterior
    //Todos los formularios de un periodo se cierran. Se mantiene la misma novedad / estado del periodo, y se crea un nuevo registro para el nuevo periodo.    
    function cierrePeriodoActual($ano, $mes){
    	$this->load->model("periodo");
    	$ano_periodo = $this->session->userdata("ano_periodo");	
    	$mes_periodo = $this->session->userdata("mes_periodo");
    	//Se comenta esta linea, debido al cambio de procedimiento en los cierres de periodo. 
    	//Utilizar el nuevo cierre de periodo modificado. 
    	//$this->periodo->crearNuevoPeriodo($ano_periodo, $mes_periodo);
    	$this->periodo->crearNuevoPeriodoMODIFICADO($ano_periodo, $mes_periodo);
    } 
    
    
	//dmdiazf - Julio 31 2012
    //Funcion para obtener el numero de fuentes que se le han asignado a un usuario de rol distinto a fuente.
    function obtenerNumeroFuentesAsignadas($rol, $id, $ano_periodo, $mes_periodo){
    	$nro = 0;
    	if ($rol==2 || $rol==5){
    		$sql = "SELECT COUNT(*) AS nro
                    FROM rmmh_admin_control C ";
    		switch($rol){
    			case 2: $sql.= " WHERE C.fk_usuariocritica = $id ";
    		            break;
    			case 5: $sql.= " WHERE C.fk_usuariologistica = $id ";
    		            break;       
    		}
        	$sql.= "AND C.ano_periodo = $ano_periodo
                    AND C.mes_periodo = $mes_periodo";
        	$query = $this->db->query($sql);
    		if ($query->num_rows() > 0){
    			foreach ($query->result() as $row){
	    			$nro = $row->nro;
    			}
    		}
   		}    
   		$this->db->close();
    	return $nro;	
   }
   
   
   //dmdiazf Octubre 12 2012
   //Funcion para obtener el nombre de un estado a partir de la novedad y el estado
   function obtenerEstadoControl($novedad, $estado){
   		$status = "";
   		if (($novedad==5)||($novedad==9)||($novedad==99)){
   			switch($estado){
   				case 0: $status = "Sin Distribuir";
   						break;
   				case 1: $status = "Distribuido";
   				        break;
   				case 2: $status = "En Digitaci&oacute;n";
   				        break;
   				case 3: $status = "Digitado";
   				        break;
   				case 4: $status = "An&aacute;lisis - Verificaci&oacute;n";
   				        break;
   				case 5: $status = "Verificado";
   				        break;                                				
   			}
   		}
   		else{
   			$status = "Novedad";
   		}
   		return $status;
   }
   
   //dmdiazf - Septiembre 25 2012
   //Funcion para obtener toda la informacion de control para una de las fuentes / Funciona en editar fuentes
   function obtenerInformacionControl($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
   		$this->load->model("novedad");
   		$this->load->model("estado");
   		$info = array();
   		$sql = "SELECT fk_novedad, fk_estado, modulo1, modulo2, modulo3, modulo4, envio
                FROM rmmh_admin_control
                WHERE nro_orden = $nro_orden
                AND nro_establecimiento = $nro_establecimiento
                AND ano_periodo = $ano_periodo
                AND mes_periodo = $mes_periodo";
   		$query = $this->db->query($sql);
   		if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
	    		$info["novedad"] = $this->novedad->nombreNovedad($row->fk_novedad);
	    		$info["estado"] = $this->estado->nombreEstado($row->fk_estado);
	    		$info["modulo1"] = $this->estadoModulo($row->modulo1);
	    		$info["modulo2"] = $this->estadoModulo($row->modulo2);
	    		$info["modulo3"] = $this->estadoModulo($row->modulo3);
	    		$info["modulo4"] = $this->estadoModulo($row->modulo4);
	    		$info["envio"] = $this->estadoModulo($row->envio);
    		}
    	}	
    	$this->db->close();
   		return $info;
   }
   
   //Funcion que me entrega el nombre del estado de un modulo
   function estadoModulo($estado){
   		$nombre = "";
   		switch($estado){
   			case 0: $nombre = "0 - Sin diligenciar";
   			        break;
   			case 2: $nombre = "2 - Diligenciado";
   			        break;        
   		}
   		return $nombre;			
   }
   
	
	

    
}//EOC   