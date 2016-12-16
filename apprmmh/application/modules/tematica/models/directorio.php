<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Directorio extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->library("session");
        $this->load->library("paginador2");
    }
    
	//Realiza el conteo de todas las fuentes del sistema. Es utilizado en el paginador de CodeIgniter del directorio  
	function contarFuentes($ano_periodo, $mes_periodo){
		$total = 0;
	    $sql = "SELECT COUNT(EST.nro_establecimiento) AS total
	            FROM rmmh_admin_control C, rmmh_admin_empresas EMP, rmmh_admin_establecimientos EST
	            WHERE C.nro_orden = EMP.nro_orden
	            AND C.nro_orden = EST.nro_orden
	            AND C.nro_establecimiento = EST.nro_establecimiento
	            AND C.ano_periodo = $ano_periodo
	            AND C.mes_periodo = $mes_periodo";
	    $query = $this->db->query($sql);
	    if ($query->num_rows() > 0){
	    	foreach($query->result() as $row){
	    		$total = $row->total;    			
	    	}
	    }
	    $this->db->close();
	    return $total;
	}
	
	//Obtiene todas las fuentes del sistemas. Es utilizado en el paginador de CodeIgniter del directorio
    function obtenerFuentes($ano_periodo, $mes_periodo, $desde, $hasta){
		$this->load->model("divipola");
	    $this->load->model("sede");
	    $this->load->model("subsede");
	    $fuentes = array();	    	
	    $sql = "SELECT EM.nro_orden, ES.nro_establecimiento, EM.idproraz, ES.idnomcom, ES.idsigla, ES.iddirecc, ES.idtelno,
    	               ES.idfaxno, ES.idcorreo, ES.finicial, ES.ffinal, ES.fk_depto, ES.fk_mpio, ES.fk_ciiu, ES.fk_sede, ES.fk_subsede,
    	               C.fk_novedad, C.fk_estado 
                FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
                WHERE C.nro_orden = EM.nro_orden
                AND C.nro_orden = ES.nro_orden
                AND C.nro_establecimiento = ES.nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo
                AND C.nro_orden > 0
                ORDER BY EM.nro_orden, ES.nro_establecimiento, ES.fk_depto, ES.fk_mpio
                LIMIT $desde, $hasta";	    
	    $query = $this->db->query($sql);
	    if ($query->num_rows() > 0){
	    	$i = 0;
	    	foreach($query->result() as $row){
	    		$fuentes[$i]["nro_orden"] = $row->nro_orden;
	    		$fuentes[$i]["nro_establecimiento"] = $row->nro_establecimiento;
	    		$fuentes[$i]["idproraz"] = $row->idproraz;
	    		$fuentes[$i]["idnomcom"] = $row->idnomcom;
	    		$fuentes[$i]["idsigla"] = $row->idsigla;
	    		$fuentes[$i]["iddirecc"] = $row->iddirecc;
	    		$fuentes[$i]["idtelno"] = $row->idtelno;
	    		$fuentes[$i]["idfaxno"] = $row->idfaxno;	    		
	    		$fuentes[$i]["idcorreo"] = $row->idcorreo;
	    		$fuentes[$i]["finicial"] = $row->finicial;
	    		$fuentes[$i]["ffinal"] = $row->ffinal;
	    		$fuentes[$i]["fk_depto"] = $this->divipola->nombreDepartamento($row->fk_depto);
	    		$fuentes[$i]["fk_mpio"] = $this->divipola->nombreMunicipio($row->fk_mpio);
	    		$fuentes[$i]["ciiu"] = $row->fk_ciiu;	    		
	    		$fuentes[$i]["sede"] = $this->sede->nombreSede($row->fk_sede);
	    		$fuentes[$i]["subsede"] = $this->subsede->nombreSubSede($row->fk_subsede);
	    		$fuentes[$i]["novedad"] = $row->fk_novedad;
	    		$fuentes[$i]["estado"] = $row->fk_estado;
	    		$i++;    			
	    	}
	    }
	    $this->db->close();
	    return $fuentes;	    	 
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
    
   	//Cuenta la cantidad de registros del directorio para el paginador de formularios
   	function contarDirectorio($opcion, $busqueda, $ano_periodo, $mes_periodo){
   		$total = 0;
   		$sql = "SELECT COUNT(*) AS total
                FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
                WHERE C.nro_orden = EM.nro_orden
                AND C.nro_orden = ES.nro_orden
                AND C.nro_establecimiento = ES.nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo ";
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
   	
   	
	function buscarDirectorio($opcion, $busqueda, $ano_periodo, $mes_periodo){
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
   		switch($opcion){
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
   	
   	
   	function buscarDirectorioPagina($opcion, $busqueda, $ano_periodo, $mes_periodo, $desde, $hasta){
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
   	
   	/*****
	function buscarDirectorioPagina($desde, $opcion, $busqueda, $ano_periodo, $mes_periodo){
   		$this->load->model("sede");
   		$this->load->model("subsede");
   		$this->load->model("divipola");
   		$hasta = $this->paginador2->getRegsPagina();
   		$directorio = array();
   		$sql = "SELECT C.nro_orden, C.nro_establecimiento, ES.fk_ciiu, EM.idproraz, ES.idnomcom, ES.fk_depto, ES.fk_mpio, ES.fk_sede, ES.fk_subsede
                FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
                WHERE C.nro_orden = EM.nro_orden
                AND C.nro_orden = ES.nro_orden
                AND C.nro_establecimiento = ES.nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo ";
   		switch($opcion){
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
    			$i++;    			
   			}
   		}    	
    	$this->db->close();
   		return $directorio; 
   	}
   	*****/
   	
   	
   	function conteoDirectorio(){   		
   		$sql = "SELECT COUNT(*) AS nregs
				FROM rmmh_admin_dirfuentes";
   		$query = $this->db->query($sql);
   		foreach($query->result() as $row){
   			if($row->nregs > 1){
   				$novedad = 9;	
   			}
   			else{
   				$novedad = 5;
   			}
   		}
   		$this->db->close();
   		return $novedad;
   	} 
   	
	// 1. Funcion para validar el ingreso de los datos en la carga automatica del directorio
   	function validarDirectorio($codigo, $valor){   		
   		$this->load->library("session");
   		$ano = $this->session->userdata("ano_periodo");
   		$mes = $this->session->userdata("mes_periodo");
   		$result = true;
   		switch ($codigo){
   			case 1: //nro.orden - verificar que no este duplicado.
   					$sql = "SELECT COUNT(DF.nro_orden) AS nreg
						    FROM rmmh_admin_dirfuentes DF, rmmh_admin_usuarios U, rmmh_admin_control C
							WHERE DF.nro_orden = U.nro_orden
							AND DF.nro_orden = C.nro_orden
							AND C.ano_periodo = $ano
							AND C.mes_periodo = $mes
							AND U.fk_rol = 1
							AND DF.nro_orden = $valor";					
   					/*
   				    $sql = "SELECT COUNT(*) AS nreg
						    FROM rmmh_admin_dirfuentes DF
							WHERE nro_orden = $valor";
					*/			    
   					$query = $this->db->query($sql);
   					foreach($query->result() as $row){
   						if ($row->nreg > 0){
   							$result = false;
   						}
   					}
   				    break;
   			case 2: //nit - verificar que no este duplicado.
   				    $sql = "SELECT COUNT(*) AS nreg
						    FROM rmmh_admin_usuarios
							WHERE num_identificacion = $valor";
   					$query = $this->db->query($sql);
   					foreach($query->result() as $row){
   						if ($row->nreg > 0){
   							$result = false;
   						}
   					}
   				    break;
   			case 3: //fk-depto - que exista el departamento.
   				    $sql = "SELECT COUNT(id_depto) AS nreg
                            FROM rmmh_param_deptos
							WHERE id_depto = $valor";
   					$query = $this->db->query($sql);
   					foreach($query->result() as $row){
   						if ($row->nreg==0){
   							$result = false;
   						}
   					}
   				    break;
   			case 4: //fk_mpio - que exista el municipio.
   				    $sql = "SELECT COUNT(id_mpio) AS nreg
                            FROM rmmh_param_mpios
							WHERE id_mpio = $valor";
   					$query = $this->db->query($sql);
   					foreach($query->result() as $row){
   						if ($row->nreg==0){
   							$result = false;
   						}
   					}   				    
   				    break;
   			case 5: //fk_ciiu - que exista la actividad.
   				    $sql = "SELECT COUNT(*) AS nreg
							FROM rmmh_param_ciiu3
							WHERE id_ciiu = $valor";
   					$query = $this->db->query($sql);
   					foreach($query->result() as $row){
   						if ($row->nreg==0){
   							$result = false;
   						}
   					}
   					break;
   			case 6: //fk_sede - que exista la sede.
   					$sql = "SELECT COUNT(*) AS nreg
							FROM rmmh_param_sedes
							WHERE id_sede = $valor";
   					$query = $this->db->query($sql);
   					foreach($query->result() as $row){
   						if ($row->nreg==0){
   							$result = false;
   						}
   					}
   				    break;
   			case 7: //fk_subsede - que exista la subsede.
   				    $sql = "SELECT COUNT(*) AS nreg
							FROM rmmh_param_subsedes
							WHERE id_subsede = $valor";
   					$query = $this->db->query($sql);
   					foreach($query->result() as $row){
   						if ($row->nreg==0){
   							$result = false;
   						}
   					}
   				    break;
   			case 8: //fk_rol - Que el rol exista
   					$sql = "SELECT COUNT(*) AS nreg
							FROM rmmh_param_roles
							WHERE id_rol = $valor";
   					$query = $this->db->query($sql);
   					foreach($query->result() as $row){
   						if ($row->nreg==0){
   							$result = false;
   						}
   					}
   				    break;
   			case 9: //fk_tipodoc - Que el tipo de documento exista
   					$sql = "SELECT COUNT(*) AS nreg
							FROM rmmh_param_tipodocs
							WHERE id_tipodoc = $valor";
   					$query = $this->db->query($sql);
   					foreach($query->result() as $row){
   						if ($row->nreg==0){
   							$result = false;
   						}
   					}
   				    break;
   		}
   		return $result;
   	}
   	
   	//***
   	//* FUNCIONES PARA EL REPORTE OPERATIVO 
   	//**
   	
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
   	
   	//Obtener los datos de una empresa que ya este registrada en el directorio de empresas (buscando por nit o por numero de orden).
   	function obtenerDatosEmpresa($nit, $nro_orden){
   		$empresa = array();
   		$sql = "SELECT nro_orden, idnit, idproraz, idnomcom, idsigla, iddirecc, idtelno, idfaxno, idaano, idpagweb, idcorreo, fk_depto, fk_mpio
                FROM rmmh_admin_empresas
                WHERE nro_orden = $nro_orden
                OR idnit = $nit";   		
   		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
   			foreach($query->result() as $row){
				$empresa["nro_orden"] = $row->nro_orden;
    			$empresa["idnit"] = $row->idnit;
    			$empresa["idproraz"] = $row->idproraz;
    			$empresa["idnomcom"] = $row->idnomcom;
    			$empresa["idsigla"] = $row->idsigla;
    			$empresa["iddirecc"] = $row->iddirecc;
    			$empresa["idtelno"] = $row->idtelno;
    			$empresa["idfaxno"] = $row->idfaxno;
    			$empresa["idaano"] = $row->idaano;
    			$empresa["idpagweb"] = $row->idpagweb;
    			$empresa["idcorreo"] = $row->idcorreo;
    			$empresa["fk_depto"] = $row->fk_depto;
    			$empresa["fk_mpio"] = $row->fk_mpio;    			
			}
   		}
   		$this->db->close();
   		return $empresa;
   	}
   	
   	
   	//dmdiazf - Octubre 12 2012
   	//Obtener todos los datos de una fuente para permitir modificarlos desde el administrador.
   	function obtenerDatosFuente($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
   		$datos = array();
   		$sql = "SELECT EM.*, ES.*
                FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
                WHERE C.nro_orden = EM.nro_orden
                AND C.nro_orden = ES.nro_orden
                AND C.nro_establecimiento = ES.nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo";
   		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
   			foreach($query->result() as $row){
				$empresa["nro_orden"] = $row->nro_orden;
    			$empresa["idnit"] = $row->idnit;
    			$empresa["idproraz"] = $row->idproraz;
    			$empresa["idnomcom"] = $row->idnomcom;
    			$empresa["idsigla"] = $row->idsigla;
    			$empresa["iddirecc"] = $row->iddirecc;
    			$empresa["idtelno"] = $row->idtelno;
    			$empresa["idfaxno"] = $row->idfaxno;
    			$empresa["idaano"] = $row->idaano;
    			$empresa["idpagweb"] = $row->idpagweb;
    			$empresa["idcorreo"] = $row->idcorreo;
    			$empresa["fk_depto"] = $row->fk_depto;
    			$empresa["fk_mpio"] = $row->fk_mpio;    			
			}
   		}
   		$this->db->close();
   		return $empresa;
   		
   		
   	} 
    
}//EOF

