<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Directorio extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
    }
    
    function contarFuentesResultado($ano_periodo, $mes_periodo, $logistico, $busqueda){
    	$this->load->model("sede");
    	$this->load->model("divipola");
    	$hasta = $this->paginador2->getRegsPagina();
    	$total = 0;
    	$sql = "SELECT COUNT(*) AS total
                FROM rmmh_admin_dirfuentes DF, rmmh_admin_control C
                WHERE DF.nro_orden = C.nro_orden
                AND C.fk_logistica = 5
                AND C.fk_logisticauser = $logistico
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo ";
   		if (is_numeric($busqueda)){
   			$sql .= "AND C.nro_orden = $busqueda ";
   		}
   		else{
   			$sql .= "AND DF.idproraz LIKE '%$busqueda%'";
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
    
	function buscarDirectorioLogisticoPAG($ano_periodo, $mes_periodo, $logistico, $desde, $busqueda){
   		$this->load->model("sede");
   		$this->load->model("divipola");   		
   		$hasta = $this->paginador2->getRegsPagina();
   		$directorio = array();
   		$sql = "SELECT C.nro_orden, DF.uni_local, DF.fk_ciiu, DF.idproraz, DF.idnomcom, DF.fk_depto, DF.fk_mpio, DF.fk_sede
                FROM rmmh_admin_dirfuentes DF, rmmh_admin_control C
                WHERE DF.nro_orden = C.nro_orden
                AND C.fk_logistica = 5
                AND C.fk_logisticauser = $logistico
                AND C.ano_periodo = $ano_periodo
               AND C.mes_periodo = $mes_periodo ";
   		if (is_numeric($busqueda)){
   			$sql .= "AND C.nro_orden = $busqueda ";
   		}
   		else{
   			$sql .= "AND DF.idproraz LIKE '%$busqueda%'";
   		}
   		if ($desde<0){
   			$desde = 0;
   		}
   		$sql.= "LIMIT $desde, $hasta";
   		$query = $this->db->query($sql);
   		if ($query->num_rows() > 0){
    		$i = 0;
   			foreach ($query->result() as $row){
      			$directorio[$i]["nro_orden"] = $row->nro_orden;
    			$directorio[$i]["uni_local"] = $row->uni_local;
    			$directorio[$i]["ciiu"] = $row->fk_ciiu;
    			$directorio[$i]["idproraz"] = $row->idproraz;
    			$directorio[$i]["idnomcom"] = $row->idnomcom;
    			$directorio[$i]["fk_depto"] = $this->divipola->nombreDepartamento($row->fk_depto);
    			$directorio[$i]["fk_mpio"] = $this->divipola->nombreMunicipio($row->fk_mpio);
    			$directorio[$i]["sede"] = utf8_decode($this->sede->nombreSede($row->fk_sede));
    			$i++;    			
   			}
   		}    	
    	$this->db->close();
   		return $directorio;
   	}
   	
   	
   	//FUNCIONES PARA EL REPORTE OPERATIVO
   	//***********************************
   	
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
    			$directorio[$i]["novedad"] = $row->fk_estado;
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
   	
	function insertarFuentes($nro_orden, $uni_local, $idproraz, $idnomcom, $idsigla, $iddirecc, $idtelno, $idfaxno, $idaano, $idcorreo, $finicial, $ffinal, $fk_depto, $fk_mpio, $fk_ciiu, $fk_sede, $fk_subsede){
   		$data = array('nro_orden' => $nro_orden, 
   		              'uni_local' => $uni_local, 
   					  'idproraz'  => $idproraz, 
   		              'idnomcom'  => $idnomcom, 
   		              'idsigla'   => $idsigla, 
   		              'iddirecc'  => $iddirecc, 
   		              'idtelno'   => $idtelno, 
   		              'idfaxno'   => $idfaxno, 
   		              'idaano'    => $idaano, 
   		              'idcorreo'  => $idcorreo, 
   		              'finicial'  => $finicial, 
   		              'ffinal'    => $ffinal, 
   		              'fk_depto'  => $fk_depto, 
   		              'fk_mpio'   => $fk_mpio, 
   		              'fk_ciiu'   => $fk_ciiu, 
   		              'fk_sede'   => $fk_sede,
   		              'fk_subsede' => $fk_subsede);
   		$this->db->insert('rmmh_admin_dirfuentes', $data);
		$this->db->close();	
   	}
   	
	function insertarEmpresa($nro_orden, $idnit, $idproraz, $idnomcom, $idsigla, $iddirecc, $idtelno, $idfaxno, $idaano, $idpagweb, $idcorreo, $fk_depto, $fk_mpio){
 		$data = array('nro_orden' => $nro_orden, 
 		              'idnit' => $idnit, 
 		              'idproraz' => $idproraz, 
 		              'idnomcom' => $idnomcom, 
 		              'idsigla' => $idsigla, 
 		              'iddirecc' => $iddirecc, 
 		              'idtelno' => $idtelno, 
 		              'idfaxno' => $idfaxno, 
 		              'idaano' => $idaano, 
 		              'idpagweb' => $idpagweb, 
 		              'idcorreo' => $idcorreo, 
 		              'fk_depto' => $fk_depto, 
 		              'fk_mpio' => $fk_mpio); 
 		$this->db->insert('rmmh_admin_empresas', $data);
		$this->db->close();  	
    }
    
	function insertarEstablecimiento($nro_orden, $nro_establecimiento, $idnomcom, $idsigla, $iddirecc, $idmpio, $iddepto, $idtelno, $idfaxno, $idcorreo, $finicial, $ffinal, $fk_ciiu, $fk_depto, $fk_mpio, $fk_sede, $fk_subsede){
		$data = array('nro_orden' => $nro_orden, 
		              'nro_establecimiento' => $nro_establecimiento, 
		              'idnomcom' => $idnomcom, 
		              'idsigla' => $idsigla, 
		              'iddirecc' => $iddirecc, 
		              'idmpio' => $idmpio, 
		              'iddepto' => $iddepto, 
		              'idtelno' => $idtelno, 
		              'idfaxno' => $idfaxno, 
		              'idcorreo' => $idcorreo, 
		              'finicial' => $finicial, 
		              'ffinal' => $ffinal, 
		              'fk_ciiu' => $fk_ciiu, 
		              'fk_depto' => $fk_depto, 
		              'fk_mpio' => $fk_mpio, 
		              'fk_sede' => $fk_sede, 
		              'fk_subsede' => $fk_subsede);
		$this->db->insert('rmmh_admin_establecimientos', $data);
		$this->db->close();    	
    }
    
    function contarDirectorio($usuarioLOG, $opcion, $busqueda, $ano_periodo, $mes_periodo){
    	$total = 0;
    	$sql = "SELECT COUNT(*) AS total
                FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
                WHERE C.nro_orden = EM.nro_orden
                AND C.nro_orden = ES.nro_orden
                AND C.nro_establecimiento = ES.nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo "; 
                // AND C.fk_usuariologistica = $usuarioLOG ";
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
    
    
	function buscarDirectorio($usuarioLOG, $opcion, $busqueda, $ano_periodo, $mes_periodo){
   		$this->load->model("sede");
		$this->load->model("subsede");
   		$this->load->model("divipola");
   		$directorio = array();
   		$ano = $this->session->userdata("ano_periodo");
   		$mes = $this->session->userdata("mes_periodo");
   		$sql = "SELECT C.nro_orden, C.nro_establecimiento, ES.fk_ciiu, EM.idproraz, ES.idnomcom, ES.fk_depto, ES.fk_mpio, ES.fk_sede, ES.fk_subsede
                FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
                WHERE C.nro_orden = EM.nro_orden
                AND C.nro_orden = ES.nro_orden
                AND C.nro_establecimiento = ES.nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo "; 
                //AND C.fk_usuariologistica = $usuarioLOG ";
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
   	
	function buscarDirectorioPagina($usuarioLOG, $opcion, $busqueda, $ano_periodo, $mes_periodo, $desde, $hasta){
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
                AND C.mes_periodo = $mes_periodo ";
                //AND C.fk_usuariologistica = $usuarioLOG ";
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
   	
}//EOC