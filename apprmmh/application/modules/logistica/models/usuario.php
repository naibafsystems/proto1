<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
		$this->load->library("paginador2");
    }
    
    //Realiza el conteo de las fuentes que han sido asignadas a un logistico
    function contarFuentesAsignadas($usuarioLOG, $ano_periodo, $mes_periodo){
    	$total = 0;
    	$sql = "SELECT COUNT(*) AS total
				FROM rmmh_admin_control
				WHERE ano_periodo = $ano_periodo
				AND mes_periodo = $mes_periodo
				AND fk_usuariologistica = $usuarioLOG";
    	$query = $this->db->query($sql);
    	if ($query->num_rows()>0){    		
    		foreach($query->result() as $row){
    			$total = $row->total;
    		}
    	}
    	$this->db->close();
    	return $total;
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
	
	function obtenerNombreEmpresa($nro_orden, $ano_periodo, $mes_periodo){
		$nombre = "";
		$sql = "SELECT idproraz
		FROM rmmh_admin_control C, rmmh_admin_empresas EM
		WHERE C.nro_orden = EM.nro_orden
		AND C.nro_orden = EM.nro_orden
		AND C.nro_orden = $nro_orden
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
    
    //Obtiene las fuentes que le han sido asignadas a un logístico para un periodo, realizando la paginacion de resultados
	function obtenerFuentesAsignadasLogisticaPAG($ano_periodo, $mes_periodo, $usuarioLOG, $desde, $hasta){
    	$asignadas = array();
		$this->load->model("divipola");
    	$this->load->model("sede");
    	$this->load->model("subsede");    	
    	$sql = "SELECT C.nro_orden, C.nro_establecimiento, EM.idproraz, ES.idnomcom, ES.idsigla, ES.iddirecc, ES.idtelno, ES.idfaxno, ES.idcorreo,
                       ES.finicial, ES.ffinal, ES.fk_depto, ES.fk_mpio, ES.fk_sede, ES.fk_subsede, C.fk_novedad, C.fk_estado
				FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
				WHERE C.nro_orden = EM.nro_orden
				AND C.nro_orden = ES.nro_orden
				AND C.nro_establecimiento = ES.nro_establecimiento
				AND C.ano_periodo = $ano_periodo
				AND C.mes_periodo = $mes_periodo
				AND C.fk_usuariologistica = $usuarioLOG
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
	    		$asignadas[$i]["novedad"] = $row->fk_novedad;
	    		$asignadas[$i]["estado"] = $row->fk_estado;
    			$i++;
    		}
    	}
    	$this->db->close();
    	return $asignadas;    	
    }
    
	//Obtiene todos los usuarios del sistema que son fuentes (Filtrando para un año y un periodo)
    function obtenerFuentesAnoPeriodo($ano_periodo, $mes_periodo){
    	$this->load->model("divipola");
    	$this->load->model("sede");
    	$fuentes = array();
    	$sql = "SELECT DF.nro_orden, DF.uni_local, DF.idproraz, DF.idnomcom, DF.idsigla, DF.iddirecc, DF.idtelno,
    	        DF.idfaxno, DF.idaano, DF.idcorreo, DF.finicial, DF.ffinal, DF.fk_depto, DF.fk_mpio, DF.fk_ciiu, DF.fk_sede
                FROM rmmh_param_periodos P, rmmh_admin_control C, rmmh_admin_dirfuentes DF
                WHERE P.ano_periodo = C.ano_periodo
                AND P.mes_periodo = C.mes_periodo
                AND C.nro_orden = DF.nro_orden
                AND P.ano_periodo = $ano_periodo
                AND P.mes_periodo = $mes_periodo";
    	$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
    		$i = 0;
    		foreach($query->result() as $row){
	    		$fuentes[$i]["nro_orden"] = $row->nro_orden;
	    		$fuentes[$i]["uni_local"] = $row->uni_local;
	    		$fuentes[$i]["idproraz"] = $row->idproraz;
	    		$fuentes[$i]["idnomcom"] = $row->idnomcom;
	    		$fuentes[$i]["idsigla"] = $row->idsigla;
	    		$fuentes[$i]["iddirecc"] = $row->iddirecc;
	    		$fuentes[$i]["idtelno"] = $row->idtelno;
	    		$fuentes[$i]["idfaxno"] = $row->idfaxno;
	    		$fuentes[$i]["idaano"] = $row->idaano;
	    		$fuentes[$i]["idcorreo"] = $row->idcorreo;
	    		$fuentes[$i]["finicial"] = $row->finicial;
	    		$fuentes[$i]["ffinal"] = $row->ffinal;
	    		$fuentes[$i]["fk_depto"] = $this->divipola->nombreDepartamento($row->fk_depto);
	    		$fuentes[$i]["fk_mpio"] = $this->divipola->nombreMunicipio($row->fk_mpio);	    		
	    		$fuentes[$i]["sede"] = utf8_decode($this->sede->nombreSede($row->fk_sede));
	    		$fuentes[$i]["ciiu"] = $row->fk_ciiu;
	    		$i++;
    		}
    	}
    	$this->db->close();
    	return $fuentes;
    }
    
	//Valida si una fuente ya existe dentro del directorio de fuentes registrada para un año y un mes 
    function validaFuenteNIT($ano, $mes, $nit){
    	$retorno = false;
    	$sql = "SELECT *
                FROM rmmh_admin_usuarios U, rmmh_admin_control C
                WHERE U.id_usuario = C.fk_usuario
                AND U.num_identificacion = $nit
                AND C.ano_periodo = $ano
                AND C.mes_periodo = $mes";
    	$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
    		$retorno = true;
    	}
    	$this->db->close();
    	return $retorno;
    }
    
	//Inserta el registro de un nuevo usuario en la base de datos
    function insertarUsuario($num_identificacion, $nom_usuario, $log_usuario, $pass_usuario, $mail_usuario, $fec_creacion, $fec_vencimiento, $nro_orden, $nro_establecimiento, $fk_tipodoc, $fk_rol, $fk_sede, $fk_subsede){
		//Verificar que el usuario no exista ya en la base de datos
		$data = array('num_identificacion' => $num_identificacion,
    	              'nom_usuario' => $nom_usuario,
    	              'log_usuario' => $log_usuario,
    	              'pass_usuario' => $pass_usuario,
    	              'mail_usuario' => $mail_usuario,
    	              'fec_creacion' => $fec_creacion,
    	              'fec_vencimiento' => $fec_vencimiento,
    	              'nro_orden' => $nro_orden,
		              'nro_establecimiento' => $nro_establecimiento,
		              'fk_tipodoc' => $fk_tipodoc,
		              'fk_rol' => $fk_rol,
		              'fk_sede' => $fk_sede,
		              'fk_subsede' => $fk_subsede		              
    	);
		$this->db->insert('rmmh_admin_usuarios', $data);
		$this->db->close();
    }
    
	//Obtiene el ID de usuario del ultimo usuario que se inserto en la B.D.
    function IDUltimoInsertado(){
    	$id = 0;
    	$sql = "SELECT MAX(id_usuario) AS id FROM rmmh_admin_usuarios";
    	$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
    		$i = 0;
    		foreach($query->result() as $row){
	    		$id = $row->id;
    		}
    	}
    	$this->db->close();
    	return $id;
    }
    
/************************************************************
     * ELIMINA LOS DATOS DE UNA FUENTE PARA UN ANO - MES PERIODO
     * - Borra los datos en control (Para el Ano - mes de periodo)
     * - Borra los datos del directorio.
     * - Borra los datos del usuario.
     * - Borra las tablas de los capitulos. (rmmh_form_movmensual, rmmh_form_ingoperacionales, rmmh_form_persalarios, rmmh_form_caracthoteles, rmmh_form_envioform)
     * - Borra la tablas de las observaciones.
     ************************************************************/
    function eliminarFuente($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$query = $this->db->query("SET FOREIGN_KEY_CHECKS = 0");
    	//Inicio la transaccion
		$this->db->trans_start();
    	//Obtengo id de usuario para hacer el borrado
    	$id = $this->obtenerIDFuente($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
    	//Borrado tabla de control
    	$this->db->where('nro_orden', $nro_orden);
		$this->db->where('nro_establecimiento', $nro_establecimiento);
		$this->db->where('ano_periodo', $ano_periodo);
		$this->db->where('mes_periodo', $mes_periodo);
		$this->db->delete('rmmh_admin_control');    	
		//Borrado tabla de usuarios
		$this->db->where("id_usuario", $id);
		$this->db->where("fk_rol", 1);  //Me aseguro de que solo elimine fuentes
		$this->db->delete('rmmh_admin_usuarios');		
		//Borrado de tabla de establecimientos
		$this->db->where("nro_orden", $nro_orden);
		$this->db->where("nro_establecimiento", $nro_establecimiento);
		$this->db->delete('rmmh_admin_establecimientos');		
		//Borrado tablas de capitulos
    	$tablas = array('rmmh_form_ingoperacionales', 'rmmh_form_persalarios', 'rmmh_form_caracthoteles', 'rmmh_form_envioform', 'rmmh_admin_observaciones');
		$this->db->where('nro_orden', $nro_orden);
		$this->db->where('nro_establecimiento', $nro_establecimiento);
		$this->db->where('ano_periodo', $ano_periodo);
		$this->db->where('mes_periodo', $mes_periodo);
		$this->db->delete($tablas);		
		//Termino la transaccion
		$query = $this->db->query("SET FOREIGN_KEY_CHECKS = 1");
		$this->db->trans_complete(); 	
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
	
	//Obtiene todos los datos de un usuario del sistema para enviarlos al excel de desgarga del directorio de fuentes
	function reportePasswords(){
    	$reporte = array();
    	$sql = "SELECT id_usuario, num_identificacion, nom_usuario, log_usuario, pass_usuario
    	        FROM rmmh_admin_usuarios
    	        WHERE num_identificacion > 0
    	        AND fk_rol = 1
    	        ORDER BY id_usuario";
    	$query = $this->db->query($sql);
    	$i = 0;
    	foreach($query->result() as $row){
    		$reporte[$i]["id"] = $row->id_usuario;
    		$reporte[$i]["num_identificacion"] = $row->num_identificacion;
    		$reporte[$i]["nom_usuario"] = $row->nom_usuario;
    		$reporte[$i]["log_usuario"] = $row->log_usuario;
    		$reporte[$i]["pas_usuario"] = $this->danecrypt->decode($row->pass_usuario);
    		$i++;
    	}
    	$this->db->close();
		return $reporte;	
    }
    
    //Obtiene todos los datos de un usuario del sistema para enviarlos al excel de descarga del directorio de fuentes.
    //En este caso, obtiene la descarga de claves de todos los usuarios que han sido asignados a un usuario logístico.
    //Solo descarga las claves de los usuarios que han sido asignados a otro usuario logistico
    function reportePasswordsLogistica($usuario, $ano_periodo, $mes_periodo){
    	$reporte = array();
    	$sql = "SELECT U.id_usuario, U.num_identificacion, U.nom_usuario, U.log_usuario, U.pass_usuario
                FROM rmmh_admin_control CTRL, rmmh_admin_usuarios U
                WHERE CTRL.nro_orden = U.nro_orden
                AND CTRL.nro_establecimiento = U.nro_establecimiento
                AND CTRL.fk_usuariologistica = $usuario               
                AND CTRL.ano_periodo = $ano_periodo
                AND CTRL.mes_periodo = $mes_periodo
                AND U.fk_rol = 1";                
    	$query = $this->db->query($sql);
    	$i = 0;
    	foreach($query->result() as $row){
    		$reporte[$i]["id"] = $row->id_usuario;
    		$reporte[$i]["num_identificacion"] = $row->num_identificacion;
    		$reporte[$i]["nom_usuario"] = $row->nom_usuario;
    		$reporte[$i]["log_usuario"] = $row->log_usuario;
    		$reporte[$i]["pas_usuario"] = $this->danecrypt->decode($row->pass_usuario);
    		$i++;
    	}
    	$this->db->close();
		return $reporte;
    }
    
    
    
    
	//Funcion que me indica si una empresa ya esta registrada en el directorio de empresas
    function validaRegistroEmpresa($nit, $nro_orden){
    	$retorno = false;
    	$sql = "SELECT *
                FROM rmmh_admin_empresas
                WHERE nro_orden = $nro_orden
                OR idnit = $nit";
    	$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
    		$retorno = true;
    	}
    	$this->db->close();
    	return $retorno;    	
    }
    
    
    //Funcion que me indica si un establecimiento ya esta registrado en el directorio de empresas (Para un año y periodo).
    function validaRegistroEstablecimiento($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$retorno = false;
    	$sql = "SELECT *
                FROM rmmh_admin_control C, rmmh_admin_establecimientos ES
                WHERE C.nro_orden = ES.nro_orden
                AND C.nro_establecimiento = ES.nro_establecimiento
                AND C.nro_orden = $nro_orden
                AND C.nro_establecimiento = $nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo";
    	$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
    		$retorno = true;
    	}
    	$this->db->close();
    	return $retorno;
    }
    
	//Funcion para consultar los datos de una empresa - establecimiento segun su numero de orden y nro_establecimiento
    function obtenerDatosFuente($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$datos = array();
    	$sql = "SELECT EM.nro_orden, EM.idnit, EM.idproraz, ES.nro_establecimiento, ES.idnomcom, ES.iddirecc, ES.fk_depto, ES.fk_mpio, ES.fk_ciiu, ES.fk_sede, ES.fk_subsede, C.inclusion
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
    			$datos["nro_orden"] = $row->nro_orden;
    			$datos["nro_establecimiento"] = $row->nro_establecimiento;
    			$datos["idnit"] = $row->idnit;
    			$datos["idproraz"] = $row->idproraz;
    			$datos["idnomcom"] = $row->idnomcom;
    			$datos["iddirecc"] = $row->iddirecc;
    			$datos["fk_depto"] = $row->fk_depto;
    			$datos["fk_mpio"] = $row->fk_mpio;
    			$datos["fk_ciiu"] = $row->fk_ciiu;
    			$datos["fk_sede"] = $row->fk_sede;
    			$datos["fk_subsede"] = $row->fk_subsede;
    			$datos["inclusion"] = $row->inclusion;
    		}
    	}
    	$this->db->close();
    	return $datos;
    }
    
}//EOC    