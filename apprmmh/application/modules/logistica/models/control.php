<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Control extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
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
    
    function informeOperativoLogistica($logistico, $ano_periodo, $mes_periodo, $sede=0, $subsede=0){
		$informeOP = array();
     	$informeOP["directorio_base"] = $this->directorioBase(0, $logistico, $ano_periodo, $mes_periodo, $sede, $subsede);
     	$informeOP["nuevos"] = $this->nuevos(0, $logistico, $ano_periodo, $mes_periodo, $sede, $subsede);
     	$informeOP["total_recolectar"] = $informeOP["directorio_base"] + $informeOP["nuevos"];
		$informeOP["sin_distribuir"] = $this->sinDistribuir(0, $logistico, $ano_periodo, $mes_periodo, $sede, $subsede);
		$informeOP["distribuidos"] = $this->distribuidos(0, $logistico, $ano_periodo, $mes_periodo, $sede, $subsede);
     	$informeOP["digitacion"] = $this->digitacion(0, $logistico, $ano_periodo, $mes_periodo, $sede, $subsede);
     	$informeOP["digitados"] = $this->digitados(0, $logistico, $ano_periodo, $mes_periodo, $sede, $subsede);
     	$informeOP["analisis_verificacion"] = $this->analisisVerificacion(0, $logistico, $ano_periodo, $mes_periodo, $sede, $subsede);
     	$informeOP["verificados"] = $this->verificados(0, $logistico, $ano_periodo, $mes_periodo, $sede, $subsede);
     	$informeOP["novedades"] = $this->novedades(0, $logistico, $ano_periodo, $mes_periodo, $sede, $subsede);
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
	private function nuevos($usuarioCR, $usuarioLOG, $ano_periodo, $mes_periodo, $sede, $subsede){
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


    // Funcion para obtener el conteo de formularios con novedades
    //Se modifica el query para que solo tenga en cuenta las novedades que han sido aprobadas. 
    private function novedades($usuarioCR, $usuarioLOG, $ano_periodo, $mes_periodo, $sede, $subsede){
     	$total = 0;
     	/*
     	$sql = "SELECT COUNT(*) AS novs
     	        FROM rmmh_admin_control
     	        WHERE fk_novedad NOT IN (5,9,99)
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
     	*/
     	$sql = "SELECT COUNT(*) AS novs
                FROM (  SELECT COUNT(DISTINCT(C.nro_establecimiento)) AS nregs
                        FROM rmmh_admin_control C, rmmh_admin_histnovedades HN, rmmh_param_novedades NV
                        WHERE C.nro_orden = HN.nro_orden
                        AND C.nro_establecimiento = HN.nro_establecimiento
                        AND C.ano_periodo = HN.ano_periodo
                        AND C.mes_periodo = HN.mes_periodo
                        AND HN.fk_novedad = NV.id_novedad
                        AND C.ano_periodo = $ano_periodo
                        AND C.mes_periodo = $mes_periodo
                        AND HN.aceptada = 1 ";
     	if ($usuarioCR!=0){
     		$sql.= "AND C.fk_usuariocritica = $usuarioCR ";
     	}
     	if ($usuarioLOG!=0){
     		$sql.= "AND C.fk_usuariologistica = $usuarioLOG ";
     	}
    	if ($sede!=0){
     		$sql .= "AND C.fk_sede = $sede ";
     	}
     	if ($subsede!=0){
     		$sql .= "AND C.fk_subsede = $subsede ";
     	}
        $sql .= " GROUP BY HN.nro_orden, HN.nro_establecimiento, HN.ano_periodo, HN.mes_periodo
                     ) AS A";        
        
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
   
	//DMDIAZF - Agosto 14, 2012
	//Funcion para actualizar el estado en el que se encuentra diligenciado uno de los modulos de la encuesta
	function actualizarControl($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $campo, $valor){
    	
		//Actualizar solo los formularios que tengan novedad en 5 ó 9
		$novedad = $this->obtenerNovedadControl($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		if (($novedad==5)||($novedad==9)){
			$data = array($campo => $valor);    	
			$this->db->where("nro_orden", $nro_orden);
			$this->db->where("nro_establecimiento", $nro_establecimiento);
			$this->db->where("ano_periodo", $ano_periodo);
			$this->db->where("mes_periodo", $mes_periodo);		
			$this->db->update("rmmh_admin_control", $data);
		}
    }
    
    //DMDIAZF - Marzo 22, 2013
    //Funcion para actualizar la novedad y estado en control desde el modulo de logistica (Cuidar los 99-2 y los formularios en 0).
	function actualizarNovedadEstado($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $estado){
			if (($estado>1)&&($estado<=3)){
				$novedad = $this->obtenerNovedadControl($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				if (($novedad==5)||($novedad==9)){
					$data = array("fk_novedad" => $novedad, 
				              	  "fk_estado" => $estado);    	
					$this->db->where("nro_orden", $nro_orden);
					$this->db->where("nro_establecimiento", $nro_establecimiento);
					$this->db->where("ano_periodo", $ano_periodo);
					$this->db->where("mes_periodo", $mes_periodo);		
					$this->db->update("rmmh_admin_control", $data);
				}	
			}
	} 

	//DMDIAZF - Marzo 22, 2013
	function obtenerNovedadControl($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
		$sql = "SELECT fk_novedad
				FROM rmmh_admin_control
				WHERE nro_orden = $nro_orden
				AND nro_establecimiento = $nro_establecimiento
				AND ano_periodo = $ano_periodo
				AND mes_periodo = $mes_periodo";
		$query = $this->db->query($sql);
    	foreach ($query->result() as $row){
			$novedad = $row->fk_novedad;
    	}
    	$this->db->close();
    	return $novedad;
	}
	 
	 
	
	
    
}//EOC	