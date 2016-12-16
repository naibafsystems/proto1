<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
		$this->load->library("paginador2");
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
	
	//Realiza el conteo de las fuentes que se han asignado a un critico para el paginador del directorio
	function contarFuentesAsignadas($ano_periodo, $mes_periodo, $idcritico){
		$total = 0;
		$sql = "SELECT COUNT(*) AS total
				FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
				WHERE C.nro_orden = EM.nro_orden
				AND C.nro_orden = ES.nro_orden
				AND C.nro_establecimiento = ES.nro_establecimiento
				AND C.ano_periodo = $ano_periodo
				AND C.mes_periodo = $mes_periodo
				AND C.fk_usuariocritica = $idcritico";
		$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
    		foreach($query->result() as $row){
    			$total = $row->total;
    		}
    	}
		$this->db->close();
    	return $total;
	} 
	
	
	//Obtiene todas las fuentes que le han sido asignadas a un critico para un periodo
    function obtenerFuentesAsignadas($ano_periodo, $mes_periodo, $idcritico){
    	$this->load->model("divipola");
    	$this->load->model("sede");
    	$asignadas = array();    	
    	$sql = "SELECT C.nro_orden, C.nro_establecimiento, EM.idproraz, ES.idnomcom, ES.idsigla, ES.iddirecc, ES.idtelno, ES.idfaxno, ES.idcorreo,
                       ES.finicial, ES.ffinal, ES.fk_depto, ES.fk_mpio, ES.fk_sede, ES.fk_subsede
				FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
				WHERE C.nro_orden = EM.nro_orden
				AND C.nro_orden = ES.nro_orden
				AND C.nro_establecimiento = ES.nro_establecimiento
				AND C.ano_periodo = $ano_periodo
				AND C.mes_periodo = $mes_periodo
				AND C.fk_usuariocritica = $idcritico";
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
	    		$asignadas[$i]["subsede"] = $this->sede->nombreSede($row->fk_subsede);
    			$i++;
    		}
    	}
    	$this->db->close();
    	return $asignadas;
    }
	
	
	//Obtiene las fuentes que le han sido asignadas a un critico para un periodo, realizando la paginacion de resultados
	function obtenerFuentesAsignadasPagina($ano_periodo, $mes_periodo, $idcritico, $desde, $hasta){
    	$this->load->model("divipola");
    	$this->load->model("sede");
    	$asignadas = array();
    	$sql = "SELECT C.nro_orden, C.nro_establecimiento, EM.idproraz, ES.idnomcom, ES.idsigla, ES.iddirecc, ES.idtelno, ES.idfaxno, ES.idcorreo,
                       ES.finicial, ES.ffinal, ES.fk_depto, ES.fk_mpio, ES.fk_sede, ES.fk_subsede, C.fk_novedad, C.fk_estado
				FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
				WHERE C.nro_orden = EM.nro_orden
				AND C.nro_orden = ES.nro_orden
				AND C.nro_establecimiento = ES.nro_establecimiento
				AND C.ano_periodo = $ano_periodo
				AND C.mes_periodo = $mes_periodo
				AND C.fk_usuariocritica = $idcritico
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
	    		$asignadas[$i]["subsede"] = $this->sede->nombreSede($row->fk_subsede);
	    		$asignadas[$i]["novedad"] = $row->fk_novedad;
	    		$asignadas[$i]["estado"] = $row->fk_estado;
    			$i++;
    		}
    	}
    	$this->db->close();
    	return $asignadas;    	
    }
    
//Obtiene todos los usuarios criticos que estan asignados a una sede
	function obtenerCriticos($sede){
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
				$criticos[$i]["nombre"] = utf8_decode($row->nom_usuario);
				$criticos[$i]["log_usuario"] = $row->log_usuario;
				$criticos[$i]["pass_usuario"] = $row->pass_usuario;
				$criticos[$i]["email"] = $row->mail_usuario;
				$criticos[$i]["fec_creacion"] = $row->fec_creacion;
				$criticos[$i]["fec_vencimiento"] = $row->fec_vencimiento;
				$criticos[$i]["nro_orden"] = $row->nro_orden;
				$criticos[$i]["rol"] = utf8_decode($this->rol->nombreRol($row->fk_rol));
				$criticos[$i]["sede"] = utf8_decode($this->sede->nombreSede($row->fk_sede));
				$criticos[$i]["fk_tipodoc"] = $row->fk_tipodoc;
				$criticos[$i]["fuentes"] = $this->control->obtenerNumeroFuentesAsignadas($row->fk_rol, $row->id_usuario);
				$i++;
			}
		}
		$this->db->close();
		return $criticos;
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