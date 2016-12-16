<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Directorio extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
		$this->load->library("paginador2");
    }
    
    //Realiza el conteo de las fuentes que le han sido asignadas a un asistente para el paginador de la busqueda
    function contarDirectorioAsistente($ano_periodo, $mes_periodo, $sede, $opcion, $busqueda){
    	$total = 0;
    	$sql = "SELECT COUNT(*) AS total
                FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
                WHERE C.nro_orden = EM.nro_orden
                AND C.nro_orden = ES.nro_orden
                AND C.nro_establecimiento = ES.nro_establecimiento
                AND C.ano_periodo = $ano_periodo
				AND C.mes_periodo = $mes_periodo
				AND C.fk_sede = $sede ";
		switch($opcion){
			case 0: $sql .= "AND EM.idnit = $busqueda ";
			        break;
   			case 1: $sql .= "AND C.nro_orden = $busqueda ";
   			        break;
   			case 2: $sql .= "AND C.nro_establecimiento = $busqueda ";
   			        break;
   			case 3: $sql .= "AND EM.idproraz LIKE '%$busqueda%' ";
   			        break;
   			case 4: $sql .= "AND ES.idnomcom LIKE '%$busqueda%' ";
   			        break;
		}
		$query = $this->db->query($sql);
   		if ($query->num_rows() > 0){
   			foreach ($query->result() as $row){
   				$total = $row->total;
   			}
   		}
   		$this->db->close();
   		return $total;
    }
    
	//Realiza la busqueda sobre los formularios de las fuentes que hayan sido asignados a un critico
	function buscarDirectorioAsistente($ano_periodo, $mes_periodo, $sede, $opcion, $busqueda){
   		$this->load->model("sede");
   		$this->load->model("subsede");
   		$this->load->model("divipola");
   		$directorio = array();
   		$sql = "SELECT C.nro_orden, C.nro_establecimiento, ES.fk_ciiu, EM.idproraz, ES.idnomcom, ES.fk_depto, ES.fk_mpio, ES.fk_sede, ES.fk_subsede
                FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
                WHERE C.nro_orden = EM.nro_orden
                AND C.nro_orden = ES.nro_orden
                AND C.nro_establecimiento = ES.nro_establecimiento
                AND C.ano_periodo = $ano_periodo
				AND C.mes_periodo = $mes_periodo
				AND C.fk_sede = $sede ";
		switch($opcion){
			case 0: $sql .= "AND EM.idnit = $busqueda ";
			        break;
   			case 1: $sql .= "AND C.nro_orden = $busqueda ";
   			        break;
   			case 2: $sql .= "AND C.nro_establecimiento = $busqueda ";
   			        break;
   			case 3: $sql .= "AND EM.idproraz LIKE '%$busqueda%' ";
   			        break;
   			case 4: $sql .= "AND ES.idnomcom LIKE '%$busqueda%' ";
   			        break;
		}
		$query = $this->db->query($sql);
   		if ($query->num_rows() > 0){
    		$i = 0;
   			foreach ($query->result() as $row){
      			$directorio[$i]["nro_orden"] = $row->nro_orden;
      			$directorio[$i]["nro_establecimiento"] = $row->nro_establecimiento;    			
    			$directorio[$i]["ciiu"] = $row->fk_ciiu;
    			$directorio[$i]["idproraz"] = $row->idproraz;
    			$directorio[$i]["idnomcom"] = $row->idnomcom;
    			$directorio[$i]["fk_depto"] = $this->divipola->nombreDepartamento($row->fk_depto);
    			$directorio[$i]["fk_mpio"] = $this->divipola->nombreMunicipio($row->fk_mpio);
    			$directorio[$i]["sede"] = $this->sede->nombreSede($row->fk_sede);
    			$directorio[$i]["subsede"] = $this->subsede->nombreSubsede($row->fk_subsede);
    			$i++;       			
   			}
   		}    	
    	$this->db->close();
   		return $directorio;
   	}
	
	function buscarDirectorioAsistentePagina($ano_periodo, $mes_periodo, $sede, $opcion, $busqueda, $desde, $hasta){
   		$this->load->model("sede");
   		$this->load->model("subsede");
   		$this->load->model("divipola");   		
   		$directorio = array();
   		$sql = "SELECT C.nro_orden, C.nro_establecimiento, ES.fk_ciiu, EM.idproraz, ES.idnomcom, ES.fk_depto, ES.fk_mpio, ES.fk_sede, ES.fk_subsede, C.fk_novedad, C.fk_estado
                FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
                WHERE C.nro_orden = EM.nro_orden
                AND C.nro_orden = ES.nro_orden
                AND C.nro_establecimiento = ES.nro_establecimiento
                AND C.ano_periodo = $ano_periodo
				AND C.mes_periodo = $mes_periodo
				AND C.fk_sede = $sede ";
		switch($opcion){
			case 0: $sql .= "AND EM.idnit = $busqueda ";
			        break;
   			case 1: $sql .= "AND C.nro_orden = $busqueda ";
   			        break;
   			case 2: $sql .= "AND C.nro_establecimiento = $busqueda ";
   			        break;
   			case 3: $sql .= "AND EM.idproraz LIKE '%$busqueda%' ";
   			        break;
   			case 4: $sql .= "AND ES.idnomcom LIKE '%$busqueda%' ";
   			        break;
		}
   		$sql.= "LIMIT $desde, $hasta";   		   		
    	$query = $this->db->query($sql);
   		if ($query->num_rows() > 0){
    		$i = 0;
   			foreach ($query->result() as $row){
      			$directorio[$i]["nro_orden"] = $row->nro_orden;
      			$directorio[$i]["nro_establecimiento"] = $row->nro_establecimiento;    			
    			$directorio[$i]["ciiu"] = $row->fk_ciiu;
    			$directorio[$i]["idproraz"] = $row->idproraz;
    			$directorio[$i]["idnomcom"] = $row->idnomcom;
    			$directorio[$i]["fk_depto"] = $this->divipola->nombreDepartamento($row->fk_depto);
    			$directorio[$i]["fk_mpio"] = $this->divipola->nombreMunicipio($row->fk_mpio);
    			$directorio[$i]["sede"] = $this->sede->nombreSede($row->fk_sede);
    			$directorio[$i]["subsede"] = $this->subsede->nombreSubsede($row->fk_subsede);
    			$directorio[$i]["novedad"] = $row->fk_novedad;
    			$directorio[$i]["estado"] = $row->fk_estado;
    			$i++;   			
   			}
   		}    	
    	$this->db->close();
   		return $directorio;
   	}
	
//Obtiene el directorio base para mostrar el detalle en el reporte operativo
   	function obtenerDirectorioBase($usuarioCR, $usuarioLOG, $ano_periodo, $mes_periodo, $sede, $subsede){
   		$this->load->library("session");
   		$this->load->model("divipola");
   		$this->load->model("sede");
   		$this->load->model("subsede");    		
   		$directorio = array();
   		$sql = "SELECT *
                FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
                WHERE C.nro_orden = EM.nro_orden
                AND C.nro_orden = ES.nro_orden
                AND C.nro_establecimiento = ES.nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo
                AND C.nueva = 0 "; 
   		 if ($usuarioCR!=0){
        	$sql.= "AND C.fk_usuariocritica = $usuarioCR ";
         }
         if ($usuarioLOG!=0){
        	$sql.= "AND C.fk_usuariologistica = $usuarioLOG ";
         } 
         if ($sede!=0){
     		$sql.= "AND C.fk_sede = $sede ";
     	 }
     	 if ($subsede!=0){
     		$sql.= "AND C.fk_subsede = $subsede ";
     	 }            
		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
			$i=0;
			foreach($query->result() as $row){
				$directorio[$i]["nro_orden"] = $row->nro_orden;
    			$directorio[$i]["nro_establecimiento"] = $row->nro_establecimiento;
    			$directorio[$i]["idproraz"] = $row->idproraz;
    			$directorio[$i]["idnomcom"] = $row->idnomcom;
    			$directorio[$i]["ciiu"] = $row->fk_ciiu;
    			$directorio[$i]["fk_depto"] = $this->divipola->nombreDepartamento($row->fk_depto);
    			$directorio[$i]["fk_mpio"] = $this->divipola->nombreMunicipio($row->fk_mpio);
    			$directorio[$i]["sede"] = $this->sede->nombreSede($row->fk_sede);
    			$directorio[$i]["subsede"] = $this->subsede->nombreSubSede($row->fk_subsede);
    			$directorio[$i]["novedad"] = $row->fk_novedad;
    			$directorio[$i]["estado"] = $row->fk_estado;
    			$i++;
			}
		}
		$this->db->close();
		return $directorio;
   	}
   	
	//Obtiene el directorio de nuevas fuentes para mostrar el detalle en el reporte operativo
   	function obtenerDirectorioNuevos($usuarioCR, $usuarioLOG, $ano_periodo, $mes_periodo, $sede, $subsede){	
   		$this->load->model("divipola");
   		$this->load->model("sede");
   		$this->load->model("subsede");
   		$sql = "SELECT *
                FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
                WHERE C.nro_orden = EM.nro_orden
                AND C.nro_orden = ES.nro_orden
                AND C.nro_establecimiento = ES.nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo
                AND C.nueva = 1 "; 
   		if ($usuarioCR!=0){
        	$sql.= "AND C.fk_usuariocritica = $usuarioCR ";
        }
        if ($usuarioLOG!=0){
        	$sql.= "AND C.fk_usuariologistica = $usuarioLOG ";
        } 
        if ($sede!=0){
     		$sql.= "AND C.fk_sede = $sede ";
     	}
     	if ($subsede!=0){
     		$sql.= "AND C.fk_subsede = $subsede ";
     	}          
   		$query = $this->db->query($sql);
   		if ($query->num_rows()>0){
   			$i=0;
   			foreach($query->result() as $row){
				$directorio[$i]["nro_orden"] = $row->nro_orden;
    			$directorio[$i]["nro_establecimiento"] = $row->nro_establecimiento;
    			$directorio[$i]["idproraz"] = $row->idproraz;
    			$directorio[$i]["idnomcom"] = $row->idnomcom;
    			$directorio[$i]["ciiu"] = $row->fk_ciiu;
    			$directorio[$i]["fk_depto"] = $this->divipola->nombreDepartamento($row->fk_depto);
    			$directorio[$i]["fk_mpio"] = $this->divipola->nombreMunicipio($row->fk_mpio);
    			$directorio[$i]["sede"] = $this->sede->nombreSede($row->fk_sede);
    			$directorio[$i]["subsede"] = $this->subsede->nombreSubSede($row->fk_subsede);
    			$directorio[$i]["novedad"] = $row->fk_novedad;
    			$directorio[$i]["estado"] = $row->fk_estado;
    			$i++;    			
			}
   		}
   		$this->db->close();
   		return $directorio;
   	}
   	
	//Obtiene el directorio del total a recolectar para mostrar el detalle en el reporte operativo
   	function obtenerDirectorioTotalRecolectar($usuarioCR, $usuarioLOG, $ano_periodo, $mes_periodo, $sede, $subsede){   	
   		$this->load->model("divipola");
   		$this->load->model("sede");
   		$this->load->model("subsede");
   		$sql = "SELECT *
                FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
                WHERE C.nro_orden = EM.nro_orden
                AND C.nro_orden = ES.nro_orden
                AND C.nro_establecimiento = ES.nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo ";                 
   		if ($usuarioCR!=0){
        	$sql.= "AND C.fk_usuariocritica = $usuarioCR ";
        }
        if ($usuarioLOG!=0){
        	$sql.= "AND C.fk_usuariologistica = $usuarioLOG ";
        } 
        if ($sede!=0){
     		$sql.= "AND C.fk_sede = $sede ";
     	}
     	if ($subsede!=0){
     		$sql.= "AND C.fk_subsede = $subsede ";
     	}          
		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
   			$i=0;
   			foreach($query->result() as $row){
				$directorio[$i]["nro_orden"] = $row->nro_orden;
    			$directorio[$i]["nro_establecimiento"] = $row->nro_establecimiento;
    			$directorio[$i]["idproraz"] = $row->idproraz;
    			$directorio[$i]["idnomcom"] = $row->idnomcom;
    			$directorio[$i]["ciiu"] = $row->fk_ciiu;
    			$directorio[$i]["fk_depto"] = $this->divipola->nombreDepartamento($row->fk_depto);
    			$directorio[$i]["fk_mpio"] = $this->divipola->nombreMunicipio($row->fk_mpio);
    			$directorio[$i]["sede"] = $this->sede->nombreSede($row->fk_sede);
    			$directorio[$i]["subsede"] = $this->subsede->nombreSubSede($row->fk_subsede);
    			$directorio[$i]["novedad"] = $row->fk_novedad;
    			$directorio[$i]["estado"] = $row->fk_estado;
    			$i++;
			}
   		}
   		$this->db->close();
   		return $directorio;
   	}
   	
   	//Obtiene el directorio del total de fuentes sin distribuir para el detalle del reporte operativo
   	function obtenerDirectorioSinDistribuir($usuarioCR, $usuarioLOG, $ano_periodo, $mes_periodo, $sede, $subsede){ 	
		$this->load->model("divipola");
		$this->load->model("sede");
		$this->load->model("subsede");		
		$sql = "SELECT *
                FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
                WHERE C.nro_orden = EM.nro_orden
                AND C.nro_orden = ES.nro_orden
                AND C.nro_establecimiento = ES.nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo 
                AND C.fk_novedad IN (5,9)
                AND C.fk_estado = 0 ";                 
   		if ($usuarioCR!=0){
        	$sql.= "AND C.fk_usuariocritica = $usuarioCR ";
        }
        if ($usuarioLOG!=0){
        	$sql.= "AND C.fk_usuariologistica = $usuarioLOG ";
        } 
        if ($sede!=0){
     		$sql.= "AND C.fk_sede = $sede ";
     	}
     	if ($subsede!=0){
     		$sql.= "AND C.fk_subsede = $subsede ";
     	}          
		$query = $this->db->query($sql);		
		if ($query->num_rows()>0){
   			$i=0;
   			foreach($query->result() as $row){
				$directorio[$i]["nro_orden"] = $row->nro_orden;
    			$directorio[$i]["nro_establecimiento"] = $row->nro_establecimiento;
    			$directorio[$i]["idproraz"] = $row->idproraz;
    			$directorio[$i]["idnomcom"] = $row->idnomcom;
    			$directorio[$i]["ciiu"] = $row->fk_ciiu;
    			$directorio[$i]["fk_depto"] = $this->divipola->nombreDepartamento($row->fk_depto);
    			$directorio[$i]["fk_mpio"] = $this->divipola->nombreMunicipio($row->fk_mpio);
    			$directorio[$i]["sede"] = $this->sede->nombreSede($row->fk_sede);
    			$directorio[$i]["subsede"] = $this->subsede->nombreSubSede($row->fk_subsede);
    			$directorio[$i]["novedad"] = $row->fk_novedad;
    			$directorio[$i]["estado"] = $row->fk_estado;
    			$i++;
			}
   		}
   		$this->db->close();
   		return $directorio;
   	}
   	
	//Obtiene el directorio del total de fuentes Distribuidos para el detalle del reporte operativo
   	function obtenerDirectorioDistribuir($usuarioCR, $usuarioLOG, $ano_periodo, $mes_periodo, $sede, $subsede){	
   		$this->load->model("divipola");
   		$this->load->model("sede");
   		$this->load->model("subsede");
   		$sql = "SELECT *
                FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
                WHERE C.nro_orden = EM.nro_orden
                AND C.nro_orden = ES.nro_orden
                AND C.nro_establecimiento = ES.nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo
                AND C.fk_novedad IN (5,9) 
                AND C.fk_estado = 1 ";                 
   		if ($usuarioCR!=0){
        	$sql.= "AND C.fk_usuariocritica = $usuarioCR ";
        }
        if ($usuarioLOG!=0){
        	$sql.= "AND C.fk_usuariologistica = $usuarioLOG ";
        } 
        if ($sede!=0){
     		$sql.= "AND C.fk_sede = $sede ";
     	}
     	if ($subsede!=0){
     		$sql.= "AND C.fk_subsede = $subsede ";
     	}    
		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
   			$i=0;
   			foreach($query->result() as $row){
				$directorio[$i]["nro_orden"] = $row->nro_orden;
    			$directorio[$i]["nro_establecimiento"] = $row->nro_establecimiento;
    			$directorio[$i]["idproraz"] = $row->idproraz;
    			$directorio[$i]["idnomcom"] = $row->idnomcom;
    			$directorio[$i]["ciiu"] = $row->fk_ciiu;
    			$directorio[$i]["fk_depto"] = $this->divipola->nombreDepartamento($row->fk_depto);
    			$directorio[$i]["fk_mpio"] = $this->divipola->nombreMunicipio($row->fk_mpio);
    			$directorio[$i]["sede"] = $this->sede->nombreSede($row->fk_sede);
    			$directorio[$i]["subsede"] = $this->subsede->nombreSubSede($row->fk_subsede);
    			$directorio[$i]["novedad"] = $row->fk_novedad;
    			$directorio[$i]["estado"] = $row->fk_estado;
    			$i++;
			}
   		}
   		$this->db->close();
   		return $directorio;
   	}
   	
	//Obtiene el directorio del total de fuentes en digitacion para el detalle del reporte operativo
   	function obtenerDirectorioEnDigitacion($usuarioCR, $usuarioLOG, $ano_periodo, $mes_periodo, $sede, $subsede){	
   		$this->load->model("divipola");
   		$this->load->model("sede");
   		$this->load->model("subsede");
   		$sql = "SELECT *
                FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
                WHERE C.nro_orden = EM.nro_orden
                AND C.nro_orden = ES.nro_orden
                AND C.nro_establecimiento = ES.nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo
                AND C.fk_novedad IN (5,9) 
                AND C.fk_estado = 2 ";                 
   		if ($usuarioCR!=0){
        	$sql.= "AND C.fk_usuariocritica = $usuarioCR ";
        }
        if ($usuarioLOG!=0){
        	$sql.= "AND C.fk_usuariologistica = $usuarioLOG ";
        } 
        if ($sede!=0){
     		$sql.= "AND C.fk_sede = $sede ";
     	}
     	if ($subsede!=0){
     		$sql.= "AND C.fk_subsede = $subsede ";
     	} 
		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
   			$i=0;
   			foreach($query->result() as $row){
				$directorio[$i]["nro_orden"] = $row->nro_orden;
    			$directorio[$i]["nro_establecimiento"] = $row->nro_establecimiento;
    			$directorio[$i]["idproraz"] = $row->idproraz;
    			$directorio[$i]["idnomcom"] = $row->idnomcom;
    			$directorio[$i]["ciiu"] = $row->fk_ciiu;
    			$directorio[$i]["fk_depto"] = $this->divipola->nombreDepartamento($row->fk_depto);
    			$directorio[$i]["fk_mpio"] = $this->divipola->nombreMunicipio($row->fk_mpio);
    			$directorio[$i]["sede"] = $this->sede->nombreSede($row->fk_sede);
    			$directorio[$i]["subsede"] = $this->subsede->nombreSubSede($row->fk_subsede);
    			$directorio[$i]["novedad"] = $row->fk_novedad;
    			$directorio[$i]["estado"] = $row->fk_estado;
    			$i++;
			}
   		}
   		$this->db->close();
   		return $directorio;
   	}
   	
	//Obtiene el directorio del total de fuentes digitados para el detalle del reporte operativo
   	function obtenerDirectorioDigitados($usuarioCR, $usuarioLOG, $ano_periodo, $mes_periodo, $sede, $subsede){ 	
   		$this->load->model("divipola");
   		$this->load->model("sede");
   		$this->load->model("subsede");
   		$sql = "SELECT *
                FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
                WHERE C.nro_orden = EM.nro_orden
                AND C.nro_orden = ES.nro_orden
                AND C.nro_establecimiento = ES.nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo 
                AND C.fk_novedad IN (5,9)
                AND C.fk_estado = 3 ";                 
   		if ($usuarioCR!=0){
        	$sql.= "AND C.fk_usuariocritica = $usuarioCR ";
        }
        if ($usuarioLOG!=0){
        	$sql.= "AND C.fk_usuariologistica = $usuarioLOG ";
        } 
        if ($sede!=0){
     		$sql.= "AND C.fk_sede = $sede ";
     	}
     	if ($subsede!=0){
     		$sql.= "AND C.fk_subsede = $subsede ";
     	} 
   		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
   			$i=0;
   			foreach($query->result() as $row){
				$directorio[$i]["nro_orden"] = $row->nro_orden;
    			$directorio[$i]["nro_establecimiento"] = $row->nro_establecimiento;
    			$directorio[$i]["idproraz"] = $row->idproraz;
    			$directorio[$i]["idnomcom"] = $row->idnomcom;
    			$directorio[$i]["ciiu"] = $row->fk_ciiu;
    			$directorio[$i]["fk_depto"] = $this->divipola->nombreDepartamento($row->fk_depto);
    			$directorio[$i]["fk_mpio"] = $this->divipola->nombreMunicipio($row->fk_mpio);
    			$directorio[$i]["sede"] = $this->sede->nombreSede($row->fk_sede);
    			$directorio[$i]["subsede"] = $this->subsede->nombreSubSede($row->fk_subsede);
    			$directorio[$i]["novedad"] = $row->fk_novedad;
    			$directorio[$i]["estado"] = $row->fk_estado;
    			$i++;
			}
   		}
   		$this->db->close();
   		return $directorio;
   	}
   	
	//Obtiene el directorio del total de fuentes en analisis-verificacion para el detalle del reporte operativo
   	function obtenerDirectorioAnalisisVerificacion($usuarioCR, $usuarioLOG, $ano_periodo, $mes_periodo, $sede, $subsede){	
   		$this->load->model("divipola");
   		$this->load->model("sede");
   		$this->load->model("subsede");
   		$sql = "SELECT *
                FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
                WHERE C.nro_orden = EM.nro_orden
                AND C.nro_orden = ES.nro_orden
                AND C.nro_establecimiento = ES.nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo
                AND C.fk_novedad = 99 
                AND C.fk_estado = 4 ";                 
   		if ($usuarioCR!=0){
        	$sql.= "AND C.fk_usuariocritica = $usuarioCR ";
        }
        if ($usuarioLOG!=0){
        	$sql.= "AND C.fk_usuariologistica = $usuarioLOG ";
        } 
        if ($sede!=0){
     		$sql.= "AND C.fk_sede = $sede ";
     	}
     	if ($subsede!=0){
     		$sql.= "AND C.fk_subsede = $subsede ";
     	} 
		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
   			$i=0;
   			foreach($query->result() as $row){
				$directorio[$i]["nro_orden"] = $row->nro_orden;
    			$directorio[$i]["nro_establecimiento"] = $row->nro_establecimiento;
    			$directorio[$i]["idproraz"] = $row->idproraz;
    			$directorio[$i]["idnomcom"] = $row->idnomcom;
    			$directorio[$i]["ciiu"] = $row->fk_ciiu;
    			$directorio[$i]["fk_depto"] = $this->divipola->nombreDepartamento($row->fk_depto);
    			$directorio[$i]["fk_mpio"] = $this->divipola->nombreMunicipio($row->fk_mpio);
    			$directorio[$i]["sede"] = $this->sede->nombreSede($row->fk_sede);
    			$directorio[$i]["subsede"] = $this->subsede->nombreSubSede($row->fk_subsede);
    			$directorio[$i]["novedad"] = $row->fk_novedad;
    			$directorio[$i]["estado"] = $row->fk_estado;
    			$i++;
			}
   		}
   		$this->db->close();
   		return $directorio;
   	}
   	
   	
	//Obtiene el directorio del total de fuentes en Verificado para el detalle del reporte operativo
   	function obtenerDirectorioVerificados($usuarioCR, $usuarioLOG, $ano_periodo, $mes_periodo, $sede, $subsede){ 	
   		$this->load->model("divipola");
   		$this->load->model("sede");
   		$this->load->model("subsede");
   		$sql = "SELECT *
                FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
                WHERE C.nro_orden = EM.nro_orden
                AND C.nro_orden = ES.nro_orden
                AND C.nro_establecimiento = ES.nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo
                AND C.fk_novedad = 99 
                AND C.fk_estado = 5 ";                 
   		if ($usuarioCR!=0){
        	$sql.= "AND C.fk_usuariocritica = $usuarioCR ";
        }
        if ($usuarioLOG!=0){
        	$sql.= "AND C.fk_usuariologistica = $usuarioLOG ";
        } 
        if ($sede!=0){
     		$sql.= "AND C.fk_sede = $sede ";
     	}
     	if ($subsede!=0){
     		$sql.= "AND C.fk_subsede = $subsede ";
     	}
		
     	$query = $this->db->query($sql);
		if ($query->num_rows()>0){
   			$i=0;
   			foreach($query->result() as $row){
				$directorio[$i]["nro_orden"] = $row->nro_orden;
    			$directorio[$i]["nro_establecimiento"] = $row->nro_establecimiento;
    			$directorio[$i]["idproraz"] = $row->idproraz;
    			$directorio[$i]["idnomcom"] = $row->idnomcom;
    			$directorio[$i]["ciiu"] = $row->fk_ciiu;
    			$directorio[$i]["fk_depto"] = $this->divipola->nombreDepartamento($row->fk_depto);
    			$directorio[$i]["fk_mpio"] = $this->divipola->nombreMunicipio($row->fk_mpio);
    			$directorio[$i]["sede"] = $this->sede->nombreSede($row->fk_sede);
    			$directorio[$i]["subsede"] = $this->subsede->nombreSubSede($row->fk_subsede);
    			$directorio[$i]["novedad"] = $row->fk_novedad;
    			$directorio[$i]["estado"] = $row->fk_estado;
    			$i++;
			}
   		}
   		$this->db->close();
   		return $directorio;
   	}
   	
	//Obtiene el directorio del total de fuentes con Novedades para el detalle del reporte operativo
	//Se modifica el query para que solo muestre las novedades que ya han sido aprobadas 
   	function obtenerDirectorioNovedades($usuarioCR, $usuarioLOG, $ano_periodo, $mes_periodo, $sede, $subsede){ 	
   		$this->load->model("divipola");
   		$this->load->model("sede");
   		$this->load->model("subsede");
   		/*
   		$sql = "SELECT *
                FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
                WHERE C.nro_orden = EM.nro_orden
                AND C.nro_orden = ES.nro_orden
                AND C.nro_establecimiento = ES.nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo
                AND C.fk_novedad NOT IN (5,9,99) ";
   		if ($usuarioCR!=0){
        	$sql.= "AND C.fk_usuariocritica = $usuarioCR ";
        }
        if ($usuarioLOG!=0){
        	$sql.= "AND C.fk_usuariologistica = $usuarioLOG ";
        } 
        if ($sede!=0){
     		$sql.= "AND C.fk_sede = $sede ";
     	}
     	if ($subsede!=0){
     		$sql.= "AND C.fk_subsede = $subsede ";
     	}	
     	*/
   		$sql = "SELECT C.nro_orden, C.nro_establecimiento, EM.idproraz, ES.idnomcom, ES.fk_ciiu, ES.fk_depto, ES.fk_mpio, ES.fk_sede, ES.fk_subsede, HN.fk_novedad, C.fk_estado
                FROM rmmh_admin_control C, rmmh_admin_histnovedades HN, rmmh_param_novedades NV, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
                WHERE C.nro_orden = EM.nro_orden
                AND C.nro_orden = ES.nro_orden
                AND C.nro_establecimiento = ES.nro_establecimiento 
                AND C.nro_orden = HN.nro_orden
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
     		$sql.= "AND C.fk_sede = $sede ";
     	}
     	if ($subsede!=0){
     		$sql.= "AND C.fk_subsede = $subsede ";
     	}
        $sql.= " GROUP BY HN.nro_orden, HN.nro_establecimiento, HN.ano_periodo, HN.mes_periodo";
		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
   			$i=0;
   			foreach($query->result() as $row){
				$directorio[$i]["nro_orden"] = $row->nro_orden;
    			$directorio[$i]["nro_establecimiento"] = $row->nro_establecimiento;
    			$directorio[$i]["idproraz"] = $row->idproraz;
    			$directorio[$i]["idnomcom"] = $row->idnomcom;
    			$directorio[$i]["ciiu"] = $row->fk_ciiu;
    			$directorio[$i]["fk_depto"] = $this->divipola->nombreDepartamento($row->fk_depto);
    			$directorio[$i]["fk_mpio"] = $this->divipola->nombreMunicipio($row->fk_mpio);
    			$directorio[$i]["sede"] = $this->sede->nombreSede($row->fk_sede);
    			$directorio[$i]["subsede"] = $this->subsede->nombreSubSede($row->fk_subsede);
    			$directorio[$i]["novedad"] = $row->fk_novedad;
    			$directorio[$i]["estado"] = $row->fk_estado;
    			$i++;
			}
   		}
   		$this->db->close();
   		return $directorio;
   	}
   	
    
}//EOC    