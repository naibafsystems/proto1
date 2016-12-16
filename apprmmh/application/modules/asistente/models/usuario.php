<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
		$this->load->library("paginador2");
		$this->load->library("danecrypt");
    }
    
	//Obtiene la sede a la que ha sido asignado un asistente tecnico
	function obtenerSede($usuario){
		$sede = 0;
		$sql = "SELECT fk_sede
                FROM rmmh_admin_usuarios
                WHERE id_usuario = $usuario";
		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
			foreach($query->result() as $row){
				$sede = $row->fk_sede;
			}
		}		
		$this->db->close();
		return $sede;	
	}
	
	
//Obtiene la razon social de una fuente, de acuerdo al nro_orden y unidad local
	function obtenerNombreFuente($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
		$nombre = "";
		$sql = "SELECT CONCAT(EM.idproraz,' - ',ES.idnomcom) AS idproraz
                FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
                WHERE C.nro_orden = EM.nro_orden
                AND C.nro_orden = ES.nro_orden
                AND C.nro_establecimiento = ES.nro_establecimiento
                AND C.nro_orden = $nro_orden
                AND C.nro_establecimiento = $nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo";
		$query = $this->db->query($sql);		
		if ($query->num_rows()>0){			
			foreach($query->result() as $row){
				$nombre = $row->idproraz;
			}
		}
		$this->db->close();
		return $nombre;
	}
	
	//Obtiene el Nombre de un critico a partir de su id de usuario
	function obtenerNombreCritico($idcritico){
		$nombre = "";
		$sql = "SELECT nom_usuario
				FROM rmmh_admin_usuarios
				WHERE fk_rol = 2
				AND id_usuario = $idcritico";
		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
			foreach($query->result() as $row){
				$nombre = $row->nom_usuario;
			}		
		}
		$this->db->close();
		return $nombre;
	}
	
	//Realiza el conteo del as fuentes asignadas a una sede para el paginador del directorio
	function contarFuentesAsignadasSede($sede, $ano_periodo, $mes_periodo){
		$total = 0;
		$sql = "SELECT COUNT(*) AS total
                FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
                WHERE C.nro_orden = EM.nro_orden
                AND C.nro_orden = ES.nro_orden
                AND C.nro_establecimiento = ES.nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo
                AND C.fk_sede = $sede";
		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
			foreach($query->result() as $row){
				$total = $row->total;
			}
		}
		$this->db->close();    	
    	return $total;
	}
	
	
	
	//Obtiene todas las fuentes que la han sido asignadas, y que estan en la sede de un asistente
	function obtenerFuentesAsignadasSede($sede, $ano_periodo, $mes_periodo){
		$this->load->model("divipola");
		$this->load->model("sede");
		$this->load->model("subsede");
		$fuentes = array();
		$sql = "SELECT C.nro_orden, C.nro_establecimiento, EM.idproraz, ES.idnomcom, ES.idsigla, ES.iddirecc, ES.idtelno, ES.idfaxno, ES.idcorreo,
                       ES.finicial, ES.ffinal, ES.fk_depto, ES.fk_mpio, ES.fk_sede, ES.fk_subsede
                FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
                WHERE C.nro_orden = EM.nro_orden
                AND C.nro_orden = ES.nro_orden
                AND C.nro_establecimiento = ES.nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo
                AND C.fk_sede = $sede";
		$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
    		$i=0;
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
	    		$fuentes[$i]["sede"] = $this->sede->nombreSede($row->fk_sede);
	    		$fuentes[$i]["subsede"] = $this->sede->nombreSede($row->fk_subsede);
    			$i++;
    		}
    	}
    	$this->db->close();    	
    	return $fuentes;
	}
	
	
//Obtiene todas las fuentes que la han sido asignadas, y que estan en la sede de un asistente
	function obtenerFuentesAsignadasSedePagina($sede, $ano_periodo, $mes_periodo, $desde, $hasta){
		$this->load->model("divipola");
		$this->load->model("sede");
		$this->load->model("subsede");
		$fuentes = array();
		$sql = "SELECT C.nro_orden, C.nro_establecimiento, EM.idproraz, ES.idnomcom, ES.idsigla, ES.iddirecc, ES.idtelno, ES.idfaxno, ES.idcorreo,
                       ES.finicial, ES.ffinal, ES.fk_depto, ES.fk_mpio, ES.fk_sede, ES.fk_subsede, C.fk_novedad, C.fk_estado
                FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
                WHERE C.nro_orden = EM.nro_orden
                AND C.nro_orden = ES.nro_orden
                AND C.nro_establecimiento = ES.nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo
                AND C.fk_sede = $sede
                LIMIT $desde, $hasta";
		$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
    		$i=0;
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
	
	
	
	//Obtiene todas las fuentes que le han sido asignadas a los criticos en un periodo
    //Recibe como parametro el id de usuario del critico, para conocer las fuentes que se le han asignado
    function obtenerFuentesAsignadas($id, $sede, $ano_periodo, $mes_periodo){    	
    	$this->load->model("divipola");
    	$this->load->model("sede");
    	$this->load->model("subsede");
    	$fuentes = array();
    	$sql = "SELECT C.nro_orden, C.nro_establecimiento, EM.idproraz, ES.idnomcom, ES.idsigla, ES.iddirecc, ES.idtelno, ES.idfaxno, ES.idcorreo,
                       ES.finicial, ES.ffinal, ES.fk_depto, ES.fk_mpio, ES.fk_sede, ES.fk_subsede
				FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
				WHERE C.nro_orden = EM.nro_orden
				AND C.nro_orden = ES.nro_orden
				AND C.nro_establecimiento = ES.nro_establecimiento
				AND C.ano_periodo = $ano_periodo
				AND C.mes_periodo = $mes_periodo 
    	        AND C.fk_usuariocritica = $id 
    	        AND C.fk_sede = $sede";				
    	$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
    		$i=0;
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
	    		$fuentes[$i]["sede"] = $this->sede->nombreSede($row->fk_sede);
	    		$fuentes[$i]["subsede"] = $this->subsede->nombreSubSede($row->fk_subsede);
    			$i++;
    		}
    	}
    	$this->db->close();    	
    	return $fuentes;
    }
	
	//Obtiene las fuentes que han sido asignadas los criticos para un periodo, realizando la paginacion de resultados
	function obtenerFuentesAsignadasPagina($ano_periodo, $mes_periodo, $sede, $desde){
    	$this->load->model("divipola");
    	$this->load->model("sede");
    	$this->load->model("subsede");
    	$asignadas = array();
    	$hasta = $this->paginador2->getRegsPagina();
    	$sql = "SELECT C.nro_orden, C.nro_establecimiento, EM.idproraz, ES.idnomcom, ES.idsigla, ES.iddirecc, ES.idtelno, ES.idfaxno, ES.idcorreo,
                       ES.finicial, ES.ffinal, ES.fk_depto, ES.fk_mpio, ES.fk_sede, ES.fk_subsede
                FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
                WHERE C.nro_orden = EM.nro_orden
                AND C.nro_orden = ES.nro_orden
                AND C.nro_establecimiento = ES.nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo
                AND C.fk_sede = $sede
				LIMIT $desde, $hasta";				
    	$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
    		$i=0;
    		foreach($query->result() as $row){
    			$asignadas[$i]["nro_orden"] = $row->nro_orden;
	    		$asignadas[$i]["nro_establecimiento"] = $row->nro_establecimiento;
	    		$asignadas[$i]["idproraz"] = $row->idproraz;
	    		$asignadas[$i]["idnomcom"] = $row->idnomcom;
	    		$asignadas[$i]["idsigla"] = $row->idsigla;
	    		$asignadas[$i]["iddirecc"] = $row->iddirecc;
	    		$asignadas[$i]["idtelno"] = $row->idtelno;
	    		$asignadas[$i]["idfaxno"] = $row->idfaxno;	    		
	    		$asignadas[$i]["idcorreo"] = $row->idcorreo;
	    		$asignadas[$i]["finicial"] = $row->finicial;
	    		$asignadas[$i]["ffinal"] = $row->ffinal;
	    		$asignadas[$i]["fk_depto"] = $this->divipola->nombreDepartamento($row->fk_depto);
	    		$asignadas[$i]["fk_mpio"] = $this->divipola->nombreMunicipio($row->fk_mpio);	    		
	    		$asignadas[$i]["sede"] = $this->sede->nombreSede($row->fk_sede);
	    		$asignadas[$i]["subsede"] = $this->subsede->nombreSubSede($row->fk_subsede);
    			$i++;
    		}
    	}
    	$this->db->close();
    	return $asignadas;    	
    }
    
    //Obtiene todas las fuentes que aun no han sido asignadas a ningun critico (Busco por la sede del asistente)	
 	function obtenerFuentesSinAsignar($sede, $ano_periodo, $mes_periodo){
    	$this->load->model("divipola");
    	$this->load->model("sede"); 
    	$this->load->model("subsede");   	
    	$fuentes = array();
    	$sql = "SELECT C.nro_orden, C.nro_establecimiento, EM.idproraz, ES.idnomcom, ES.idsigla, ES.iddirecc, ES.idtelno, ES.idfaxno, ES.idcorreo,
                       ES.finicial, ES.ffinal, ES.fk_depto, ES.fk_mpio, ES.fk_sede, ES.fk_subsede
                FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
                WHERE C.nro_orden = EM.nro_orden
                AND C.nro_orden = ES.nro_orden
                AND C.nro_establecimiento = ES.nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo
                AND C.fk_usuariocritica = 0
                AND C.fk_sede = $sede";
		$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
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
	    		$fuentes[$i]["sede"] = $this->sede->nombreSede($row->fk_sede);
	    		$fuentes[$i]["subsede"] = $this->subsede->nombreSubSede($row->fk_subsede);	    		
	    		$i++;
    		}
    	}
    	$this->db->close();
    	return $fuentes;
    }
    
    
    //Obtiene todas las fuentes que le han sido asignadas a un critico en una sede - territorial
	function obtenerFuentesAsignadasCritico($idcritico, $ano_periodo, $mes_periodo, $sede){
    	$this->load->model("divipola");
    	$this->load->model("sede");
    	$asignadas = array();    	
    	$sql = "SELECT DF.nro_orden, DF.uni_local, DF.fk_ciiu, DF.idsigla, DF.idproraz, DF.idnomcom, DF.fk_depto, DF.fk_mpio, DF.fk_sede
                FROM rmmh_admin_dirfuentes DF, rmmh_admin_control C
                WHERE DF.nro_orden = C.nro_orden                
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo
                AND C.fk_sede = $sede
                AND C.fk_rolacceso = 2
                AND C.fk_usuario = $idcritico";			
    	$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
    		$i=0;
    		foreach($query->result() as $row){
    			$asignadas[$i]["nro_orden"] = $row->nro_orden;
    			$asignadas[$i]["uni_local"] = $row->uni_local;
    			$asignadas[$i]["fk_ciiu"] = $row->fk_ciiu;
    			$asignadas[$i]["idsigla"] = $row->idsigla;
    			$asignadas[$i]["idproraz"] = $row->idproraz;    			
    			$asignadas[$i]["idnomcom"] = $row->idnomcom;
    			$asignadas[$i]["fk_depto"] = $this->divipola->nombreDepartamento($row->fk_depto);
    			$asignadas[$i]["fk_mpio"] = $this->divipola->nombreMunicipio($row->fk_mpio);	
    			$asignadas[$i]["sede"] = utf8_decode($this->sede->nombreSede($row->fk_sede));
    			$i++;
    		}
    	}
    	$this->db->close();
    	return $asignadas;
    }
    
    //Realiza el conteo de los criticos asignados a una sede para el paginador de usuarios del asistente
    function contarCriticos($sede, $ano_periodo, $mes_periodo){
    	$total = 0;
    	$sql = "SELECT COUNT(*) AS total 
    	        FROM rmmh_admin_usuarios
    	        WHERE fk_rol = 2
    	        AND fk_sede = $sede";
    	$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
    		foreach($query->result() as $row){
    			$total = $row->total;
    		}
    	}
    	$this->db->close();
    	return $total;
    }
    
    
    //Obtiene todos los usuarios criticos que estan asignados a una sede
	function obtenerCriticos($sede, $ano_periodo, $mes_periodo){
    	$this->load->model("control");
    	$this->load->model("rol");
    	$this->load->model("sede");
    	$criticos = array();
		$sql = "SELECT *
				FROM rmmh_admin_usuarios
				WHERE fk_rol = 2
				AND fk_sede = $sede";		
		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
			$i = 0;
			foreach($query->result() as $row){
				$criticos[$i]["id"] = $row->id_usuario;
				$criticos[$i]["num_identificacion"] = $row->num_identificacion;
				$criticos[$i]["nombre"] = $row->nom_usuario;
				$criticos[$i]["log_usuario"] = $row->log_usuario;
				$criticos[$i]["pass_usuario"] = $row->pass_usuario;
				$criticos[$i]["email"] = $row->mail_usuario;
				$criticos[$i]["fec_creacion"] = $row->fec_creacion;
				$criticos[$i]["fec_vencimiento"] = $row->fec_vencimiento;
				$criticos[$i]["nro_orden"] = $row->nro_orden;
				$criticos[$i]["rol"] = $this->rol->nombreRol($row->fk_rol);
				$criticos[$i]["sede"] = $this->sede->nombreSede($row->fk_sede);
				$criticos[$i]["fk_tipodoc"] = $row->fk_tipodoc;
				$criticos[$i]["fuentes"] = $this->control->obtenerNumeroFuentesAsignadas(2, $row->id_usuario, $ano_periodo, $mes_periodo);
				$i++;
			}
		}
		$this->db->close();
		return $criticos;
    }

	//Obtiene todos los usuarios criticos que estan asignados a una sede realizando la paginacion de resultados.
	function obtenerCriticosPagina($sede, $desde, $ano_periodo, $mes_periodo){
    	$this->load->model("control");
    	$this->load->model("rol");
    	$this->load->model("sede");
    	$criticos = array();
		$hasta = $this->paginador2->getRegsPagina();
		$sql = "SELECT *
				FROM rmmh_admin_usuarios
				WHERE fk_rol = 2
				AND fk_sede = $sede
				LIMIT $desde, $hasta";
		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
			$i = 0;
			foreach($query->result() as $row){
				$criticos[$i]["id"] = $row->id_usuario;
				$criticos[$i]["num_identificacion"] = $row->num_identificacion;
				$criticos[$i]["nombre"] = utf8_decode($row->nom_usuario);
				$criticos[$i]["log_usuario"] = $row->log_usuario;
				$criticos[$i]["pass_usuario"] = $row->pass_usuario;
				$criticos[$i]["email"] = $row->mail_usuario;
				$criticos[$i]["fec_creacion"] = $row->fec_creacion;
				$criticos[$i]["fec_vencimiento"] = $row->fec_vencimiento;
				$criticos[$i]["nro_orden"] = $row->nro_orden;
				$criticos[$i]["idxrol"] = $row->fk_rol;
				$criticos[$i]["rol"] = $this->rol->nombreRol($row->fk_rol);
				$criticos[$i]["sede"] = $this->sede->nombreSede($row->fk_sede);
				$criticos[$i]["fk_tipodoc"] = $row->fk_tipodoc;
				$criticos[$i]["fuentes"] = $this->control->obtenerNumeroFuentesAsignadas(2, $row->id_usuario, $ano_periodo, $mes_periodo);
				$i++;
			}
		}
		$this->db->close();
		return $criticos;
    }	
	
	//Obtiene todos los datos de un usuario de acuerdo al ID de usuario
	function obtenerUsuarioID($id, $ano_periodo, $mes_periodo){
    	$this->load->model("rol");
    	$this->load->model("sede");
    	$this->load->model("control");
    	$usuario = array();
    	$sql = "SELECT id_usuario, num_identificacion, nom_usuario, log_usuario, pass_usuario, mail_usuario, fec_creacion, fec_vencimiento, nro_orden, fk_rol, fk_sede, fk_subsede, fk_tipodoc
                FROM rmmh_admin_usuarios
                WHERE id_usuario = $id";
    	$query = $this->db->query($sql);
		if ($query->num_rows()>0){			
			foreach($query->result() as $row){
				$usuario["id"] = $row->id_usuario;
				$usuario["num_identificacion"] = $row->num_identificacion;
				$usuario["nombre"] = $row->nom_usuario;
				$usuario["log_usuario"] = $row->log_usuario;
				$usuario["pass_usuario"] = $this->danecrypt->decode($row->pass_usuario);
				$usuario["email"] = $row->mail_usuario;
				$usuario["fec_creacion"] = $row->fec_creacion;
				$usuario["fec_vencimiento"] = $row->fec_vencimiento;
				$usuario["nro_orden"] = $row->nro_orden;
				$usuario["rol"] = $row->fk_rol;
				$usuario["sede"] = $row->fk_sede;
				$usuario["subsede"] = $row->fk_subsede;
				$usuario["fk_tipodoc"] = $row->fk_tipodoc;
				$usuario["fuentes"] = $this->control->obtenerNumeroFuentesAsignadas($row->fk_rol, $row->id_usuario, $ano_periodo, $mes_periodo);
			}
		}
		$this->db->close();
		return $usuario;
    }
    
    //Actualiza los datos de un usuario
    function actualizarUsuario($id, $numident, $nombre, $login, $password, $email, $feccrea, $fecvence, $rol, $sede, $subsede, $tipodoc){
    	$data = array('num_identificacion' => $numident, 
    	              'nom_usuario' => $nombre, 
    	              'log_usuario' => $login, 
    	              'pass_usuario' => $password, 
    	              'mail_usuario' => $email,
    	              'fec_creacion' => $feccrea, 
    	              'fec_vencimiento' => $fecvence,
    	              'fk_rol' => $rol, 
    	              'fk_sede' => $sede,
    	              'fk_subsede' => $subsede,
    	              'fk_tipodoc' => $tipodoc 
    	);
    	$this->db->where('id_usuario', $id);
		$this->db->update('rmmh_admin_usuarios', $data);        
    }
    
    //Inserta el registro de un nuevo usuario en la B.D.
	function insertarUsuario($num_identificacion, $nom_usuario, $log_usuario, $pass_usuario, $mail_usuario, $fec_creacion, $fec_vencimiento, $nro_orden, $fk_rol, $fk_sede, $fk_subsede, $fk_tipodoc){
		//Verificar que el usuario no exista ya en la base de datos
		$data = array('num_identificacion' => $num_identificacion,
    	              'nom_usuario' => $nom_usuario,
    	              'log_usuario' => $log_usuario,
    	              'pass_usuario' => $pass_usuario,
    	              'mail_usuario' => $mail_usuario,
    	              'fec_creacion' => $fec_creacion,
    	              'fec_vencimiento' => $fec_vencimiento,
    	              'nro_orden' => $nro_orden,
		              'fk_rol' => $fk_rol,
		              'fk_sede' => $fk_sede,
		              'fk_subsede' => $fk_subsede,
		              'fk_tipodoc' => $fk_tipodoc
    	);
		$this->db->insert('rmmh_admin_usuarios', $data);
		$this->db->close();
    }
    
	//Elimina los datos de un usuario
	function eliminarUsuario($index){
    	$data = array('id_usuario' => $index);
    	$this->db->delete('rmmh_admin_usuarios',$data);
    	$this->db->close();
    }
    
	function obtenerRolUsuario($id){
      		$rol = 1;
      		$sql = "SELECT fk_rol
                    FROM rmmh_admin_usuarios
                    WHERE id_usuario = $id";
      		$query = $this->db->query($sql);
    		if ($query->num_rows() > 0){
    			foreach($query->result() as $row){
    				$rol = $row->fk_rol;
    			}
    		}
    		$this->db->close();
    		return $rol;	 	
      }
      
	//Obtiene el ID de usuario de una fuente a partir del nro de orden, uni_local, ano_periodo y mes_periodo
    function obtenerIDFuente($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
     	$id = 99999999999; //NO puedo retornar 0, por que el ID de usuario cero es el del administrador.
     	$sql = "SELECT U.id_usuario
			    FROM rmmh_admin_control C, rmmh_admin_usuarios U
                WHERE C.nro_orden = U.nro_orden
                AND C.nro_establecimiento = U.nro_establecimiento
                AND C.nro_orden = $nro_orden
                AND C.nro_establecimiento = $nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo";
     	$query = $this->db->query($sql);		
		if ($query->num_rows()>0){
			foreach($query->result() as $row){
				$id = $row->id_usuario;
			}
		}
		$this->db->close();
		return $id;
	}
	
    
}//EOC	