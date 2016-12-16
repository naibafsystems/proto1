<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->library("session");
        $this->load->library("danecrypt");
        $this->load->library("paginador2");
    }
    
 	//Obtiene los datos de un usuario de acuerdo a un id de usuario
    function obtenerUsuarioID($id){
    	$this->load->library("danecrypt");
    	$this->load->model("rol");
    	$this->load->model("sede");
    	$this->load->model("control");
    	$ano_periodo = $this->session->userdata("ano_periodo");
    	$mes_periodo = $this->session->userdata("mes_periodo");
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
    
    //Obtiene el nombre de un usuario del sistema (No fuente)
	function obtenerNombreUsuario($id){
    	$nombre = "";
    	$sql = "SELECT id_usuario, nom_usuario
				FROM rmmh_admin_usuarios
				WHERE id_usuario = $id";
    	$query = $this->db->query($sql);
    	foreach($query->result() as $row){
    		$nombre = $row->nom_usuario;	
    	}
    	$this->db->close();
    	return $nombre;
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

    
	
	function contarFuentes($ano_periodo, $mes_periodo){
		$total = 0;
		$sql = "SELECT COUNT(*) AS total
		        FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
		        WHERE C.nro_orden = EM.nro_orden
		        AND C.nro_orden = ES.nro_orden
		        AND C.nro_establecimiento = ES.nro_establecimiento
		        AND C.ano_periodo = $ano_periodo
		        AND C.mes_periodo = $mes_periodo
		        AND C.nro_orden > 0";
		$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
    		foreach($query->result() as $row){
    			$total = $row->total;
    		}
    	}
    	$this->db->close();
    	return $total;
	}
	
	
	
	
 	//Obtiene todos los usuarios del sistema que son fuentes (Sin paginacion)
    function obtenerFuentes($ano_periodo, $mes_periodo){
    	$this->load->model("divipola");
    	$this->load->model("sede");
    	$this->load->model("subsede");
    	$fuentes = array();
    	$sql = "SELECT EM.nro_orden, ES.nro_establecimiento, EM.idproraz, ES.idnomcom, ES.idsigla, ES.iddirecc, ES.idtelno,
    	               ES.idfaxno, ES.idcorreo, ES.finicial, ES.ffinal, ES.fk_depto, ES.fk_mpio, ES.fk_ciiu, ES.fk_sede, ES.fk_subsede 
                FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
                WHERE C.nro_orden = EM.nro_orden
                AND C.nro_orden = ES.nro_orden
                AND C.nro_establecimiento = ES.nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo
                AND C.nro_orden > 0";
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
	    		$fuentes[$i]["ciiu"] = $row->fk_ciiu;
	    		$i++;
    		}
    	}
    	$this->db->close();
    	return $fuentes;
    }
    
    
    //Obtiene todos los usuarios del sistema que han sido agregados como fuente, obtiene por paginas
    function obtenerFuentesPagina($desde, $ano_periodo, $mes_periodo){    	
    	$this->load->library("paginador2");
    	$this->load->model("divipola");
    	$this->load->model("sede");
    	$this->load->model("subsede");
    	$fuentes = array();
    	$hasta = $this->paginador2->getRegsPagina();
    	$sql = "SELECT EM.nro_orden, ES.nro_establecimiento, EM.idproraz, ES.idnomcom, ES.idsigla, ES.iddirecc, ES.idtelno,
    	               ES.idfaxno, ES.idcorreo, ES.finicial, ES.ffinal, ES.fk_depto, ES.fk_mpio, ES.fk_ciiu, ES.fk_sede, ES.fk_subsede 
                FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
                WHERE C.nro_orden = EM.nro_orden
                AND C.nro_orden = ES.nro_orden
                AND C.nro_establecimiento = ES.nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo
                AND C.nro_orden > 0
                ORDER BY EM.nro_orden, ES.nro_establecimiento
                LIMIT $desde, $hasta;";		
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
	    		$fuentes[$i]["ciiu"] = $row->fk_ciiu;
	    		$i++;
    		}
    	}
    	$this->db->close();
    	return $fuentes;
    }
    
	//Obtiene todas las fuentes que ya han sido asignadas a un critico.
    //Recibe como parametro el id de usuario del critico, para conocer las fuentes que se le han asignado
    function obtenerFuentesAsignadas($id, $ano_periodo, $mes_periodo){    	
    	$this->load->model("divipola");
    	$this->load->model("sede");
    	$fuentes = array();
    	$sql = "SELECT C.nro_orden, C.nro_establecimiento, EM.idproraz, ES.idnomcom, ES.idsigla, ES.iddirecc, ES.idtelno, ES.idfaxno, ES.idcorreo,
                       ES.finicial, ES.ffinal, ES.fk_depto, ES.fk_mpio, ES.fk_sede, ES.fk_subsede
				FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
				WHERE C.nro_orden = EM.nro_orden
				AND C.nro_orden = ES.nro_orden
				AND C.nro_establecimiento = ES.nro_establecimiento
				AND C.ano_periodo = $ano_periodo
				AND C.mes_periodo = $mes_periodo
				AND C.fk_usuariocritica = $id";    	        
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
    
    //Obtiene todas las fuentes que ya han sido asignadas a un usuario logistico.
    //Recibe como parametro el id de usuario del logistico, para conocer las fuentes que se le han asignado
    function obtenerFuentesAsignadasLogistica($id, $ano_periodo, $mes_periodo){
    	$this->load->model("divipola");
    	$this->load->model("sede");
    	$this->load->model("subsede");
    	$asignadas = array();
    	$sql = "SELECT C.nro_orden, C.nro_establecimiento, EM.idproraz, ES.idnomcom, ES.idsigla, ES.iddirecc, ES.idtelno, ES.idfaxno, ES.idcorreo,
                       ES.finicial, ES.ffinal, ES.fk_depto, ES.fk_mpio, ES.fk_sede, ES.fk_subsede
                FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
                WHERE C.nro_orden = EM.nro_orden
                AND C.nro_orden = ES.nro_orden
                AND C.nro_establecimiento = ES.nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo
                AND fk_usuariologistica = $id";
    	$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
    		$i=0;
    		foreach($query->result() as $row){
    			$asignadas[$i]["nro_orden"] = $row->nro_orden;
    			$asignadas[$i]["nro_establecimiento"] = $row->nro_establecimiento;
    			$asignadas[$i]["idproraz"] = $row->idproraz;
    			$asignadas[$i]["idnomcom"] = $row->idnomcom;
    			$asignadas[$i]["idsigla"] = $row->idsigla;
    			$asignadas[$i]["idddirecc"] = $row->iddirecc;
    			$asignadas[$i]["idtelno"] = $row->idtelno;
    			$asignadas[$i]["idfaxno"] = $row->idfaxno;
    			$asignadas[$i]["idcorreo"] = $row->idcorreo;
    			$asignadas[$i]["finicial"] = $row->finicial;
    			$asignadas[$i]["ffinal"] = $row->ffinal;
    			$asignadas[$i]["fk_depto"] = $row->fk_depto;
    			$asignadas[$i]["fk_mpio"] = $row->fk_mpio;
    			$asignadas[$i]["sede"] = $this->sede->nombreSede($row->fk_sede);
    			$asignadas[$i]["subsede"] = $this->subsede->nombreSubSede($row->fk_subsede);
    			$i++;
    		}
    	}
    	$this->db->close();
    	return $asignadas;
    }
    
	//Obtiene todas las fuentes que aun no han sido asignadas a un critico
 	function obtenerFuentesSinAsignar($ano_periodo, $mes_periodo){
    	$this->load->model("divipola");
    	$this->load->model("sede");    	
    	$fuentes = array();
    	$sql = "SELECT C.nro_orden, C.nro_establecimiento, EM.idproraz, ES.idnomcom, ES.idsigla, ES.iddirecc, ES.idtelno, ES.idfaxno, ES.idcorreo,
                       ES.finicial, ES.ffinal, ES.fk_depto, ES.fk_mpio, ES.fk_sede, ES.fk_subsede
                FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
                WHERE C.nro_orden = EM.nro_orden
                AND C.nro_orden = ES.nro_orden
                AND C.nro_establecimiento = ES.nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo
                AND C.fk_usuariocritica = 0";
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
	    		$fuentes[$i]["sede"] = utf8_decode($this->sede->nombreSede($row->fk_sede));
	    		$fuentes[$i]["subsede"] = utf8_decode($this->sede->nombreSede($row->fk_subsede));	    		
	    		$i++;
    		}
    	}
    	$this->db->close();
    	return $fuentes;
    }
    
	//Obtiene todas las fuentes que aun no han sido asignadas a un logistico
 	function obtenerFuentesSinAsignarLogistica($ano_periodo, $mes_periodo){
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
                AND fk_usuariologistica = 0";
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
    
 	//Valida si una fuente ya existe dentro del directorio de fuentes registrada para un año y un mes 
    function validaFuenteNIT($nro_orden, $nit, $ano_periodo, $mes_periodo){
    	$retorno = false;
    	/*
    	$sql = "SELECT *
                FROM rmmh_admin_usuarios U, rmmh_admin_control C
                WHERE U.id_usuario = C.fk_usuario
                AND U.num_identificacion = $nit
                AND C.ano_periodo = $ano
                AND C.mes_periodo = $mes";
        */
    	$sql = "SELECT *
                FROM rmmh_admin_control C, rmmh_admin_usuarios U
                WHERE C.nro_orden = U.nro_orden
                AND C.nro_establecimiento = U.nro_establecimiento
                AND C.ano_periodo = $ano
                AND C.mes_periodo = $mes";        
    	$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
    		$retorno = true;
    	}
    	$this->db->close();
    	return $retorno;
    }
    
    //Funcion que me indica si una empresa ya esta registrada en el directorio de empresas
    //Busca primero por el numero de orden, y luego busca por el nit de la empresa.
    function validaRegistroEmpresa($nit, $nro_orden){
    	$retorno = 0;
    	$flag1 = false;
    	$flag2 = false;
    	//Busqueda por el nro de orden.
    	$sql = "SELECT *
    	        FROM rmmh_admin_empresas
    	        WHERE nro_orden = $nro_orden";
    	$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
    		$flag1 = true;
    	}
    	//Busqueda por el nit de la empresa
    	$sql = "SELECT * 
    	        FROM rmmh_admin_empresas
    	        WHERE idnit = $nit";
    	$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
    		$flag2 = true;
    	}
    	
    	if (($flag1==false)||($flag2==false)){
    		$retorno = 0; //Si se puede crear la empresa
    	}
    	else if ($flag1==true){
    		$retorno = 1; //El nro de orden ya existe
    	}
    	else if ($flag2==true){
    		$retorno = 2; //El Nit de la empresa ya se encuentra registrado.
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
    
   //Obtiene todos los usuarios del sistema que son fuentes (Filtrando para un año y un periodo)
    function obtenerFuentesAnoPeriodo($ano_periodo, $mes_periodo){
    	$this->load->model("divipola");
    	$this->load->model("sede");
    	$this->load->model("subsede");
    	$fuentes = array();
    	$sql = "SELECT EM.nro_orden, ES.nro_establecimiento, EM.idproraz, ES.idnomcom, ES.idsigla, ES.iddirecc, ES.idtelno,
    	               ES.idfaxno, ES.idcorreo, ES.finicial, ES.ffinal, ES.fk_depto, ES.fk_mpio, ES.fk_ciiu, ES.fk_sede, ES.fk_subsede
                FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
                WHERE C.nro_orden = EM.nro_orden
                AND C.nro_orden = ES.nro_orden
                AND C.nro_establecimiento = ES.nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo
                AND C.nro_orden > 0
                ORDER BY nro_establecimiento";        
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
	    		$fuentes[$i]["ciiu"] = $row->fk_ciiu;
	    		$i++;
    		}
    	}
    	$this->db->close();
    	return $fuentes;
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
    	        WHERE fk_rol = 1
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
    
    //Obtiene el listado de los datos de los usuarios que no son fuentes del sistema para hacer la descarga del directorio
    //de usuarios del sistema
    function reporteDirectorioUsuarios(){
    	$reporte = array();
    	$sql = "SELECT id_usuario, num_identificacion, nom_usuario, log_usuario, pass_usuario
                FROM rmmh_admin_usuarios
                WHERE num_identificacion > 1
                AND fk_rol > 1
                ORDER BY fk_rol";
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
    
    
    
    
    
    //Cuenta el total de registros de usuarios del sistema para el paginador
    function contarUsuarios($ano_periodo, $mes_periodo){
    	$total = 0;
    	$sql = "SELECT COUNT(*) AS total
    	        FROM rmmh_admin_usuarios
    	        WHERE fk_rol NOT IN (1)";
    	$query = $this->db->query($sql);
		if ($query->num_rows()>0){
			foreach($query->result() as $row){
				$total = $row->total;
			}
		}
		$this->db->close();
		return $total;
    }
    
	//Obtiene todos los usuarios del sistema que no hacen parte de las fuentes (fk_rol <> 1)
    function obtenerUsuarios($ano_periodo, $mes_periodo){
    	$this->load->model("control");
    	$this->load->model("rol");
    	$this->load->model("sede");
    	$usuarios = "";
		$sql = "SELECT *
    	        FROM rmmh_admin_usuarios
    	        WHERE fk_rol NOT IN (1)";
		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
			$i = 0;
			foreach($query->result() as $row){
				$usuarios[$i]["id"] = $row->id_usuario;
				$usuarios[$i]["num_identificacion"] = $row->num_identificacion;
				$usuarios[$i]["nombre"] = $row->nom_usuario;
				$usuarios[$i]["log_usuario"] = $row->log_usuario;
				$usuarios[$i]["pass_usuario"] = $row->pass_usuario;
				$usuarios[$i]["email"] = $row->mail_usuario;
				$usuarios[$i]["fec_creacion"] = $row->fec_creacion;
				$usuarios[$i]["fec_vencimiento"] = $row->fec_vencimiento;
				$usuarios[$i]["nro_orden"] = $row->nro_orden;
				$usuarios[$i]["idxrol"] = $row->fk_rol;
				$usuarios[$i]["rol"] = $this->rol->nombreRol($row->fk_rol);
				$usuarios[$i]["sede"] = $this->sede->nombreSede($row->fk_sede);
				$usuarios[$i]["fk_tipodoc"] = $row->fk_tipodoc;
				$usuarios[$i]["fuentes"] = $this->control->obtenerNumeroFuentesAsignadas($row->fk_rol, $row->id_usuario, $ano_periodo, $mes_periodo);
				$i++;
			}
		}
		$this->db->close();
		return $usuarios;
    }
    
    //Obtiene todos los usuarios del sistema que no hacen parte de las fuentes (fk_rol <> 1)
    function obtenerUsuariosPagina($ano_periodo, $mes_periodo, $desde, $hasta){
    	$usuarios = array();
    	$this->load->model("control");	
    	$this->load->model("rol");
    	$this->load->model("sede");
    	$this->load->model("subsede");
    	$sql = "SELECT U.id_usuario, U.num_identificacion, U.nom_usuario, U.log_usuario, U.pass_usuario, U.mail_usuario, U.fec_creacion, U.fec_vencimiento, U.nro_orden, U.fk_rol, U.fk_sede, U.fk_subsede, U.fk_tipodoc
                FROM rmmh_admin_usuarios U
                WHERE fk_rol NOT IN (1)
                ORDER BY U.fk_rol
                LIMIT $desde, $hasta";
    	$query = $this->db->query($sql);
		if ($query->num_rows()>0){
			$i = 0;
			foreach($query->result() as $row){
				$usuarios[$i]["id"] = $row->id_usuario;
				$usuarios[$i]["num_identificacion"] = $row->num_identificacion;
				$usuarios[$i]["nombre"] = $row->nom_usuario;
				$usuarios[$i]["log_usuario"] = $row->log_usuario;
				$usuarios[$i]["pass_usuario"] = $row->pass_usuario;
				$usuarios[$i]["email"] = $row->mail_usuario;
				$usuarios[$i]["fec_creacion"] = $row->fec_creacion;
				$usuarios[$i]["fec_vencimiento"] = $row->fec_vencimiento;
				$usuarios[$i]["nro_orden"] = $row->nro_orden;
				$usuarios[$i]["idxrol"] = $row->fk_rol;
				$usuarios[$i]["rol"] = $this->rol->nombreRol($row->fk_rol);
				$usuarios[$i]["sede"] = $this->sede->nombreSede($row->fk_sede);
				$usuarios[$i]["subsede"] = $this->subsede->nombreSubSede($row->fk_subsede);
				$usuarios[$i]["fk_tipodoc"] = $row->fk_tipodoc;
				$usuarios[$i]["fuentes"] = $this->control->obtenerNumeroFuentesAsignadas($row->fk_rol, $row->id_usuario, $ano_periodo, $mes_periodo);
				$i++;
			}
		}
		$this->db->close();
		return $usuarios;
    }
    
    
    /***********
    
	//Obtiene todos los usuarios del sistema que no hacen parte de las fuentes (fk_rol <> 1)
    function obtenerUsuariosPagina($desde, $ano_periodo, $mes_periodo){
    	$usuarios = array();
    	$this->load->model("control");
    	$this->load->model("rol");
    	$this->load->model("sede");
    	$this->load->model("subsede");
    	$hasta = $this->paginador2->getRegsPagina();
    	$sql = "SELECT U.id_usuario, U.num_identificacion, U.nom_usuario, U.log_usuario, U.pass_usuario, U.mail_usuario, U.fec_creacion, U.fec_vencimiento, U.nro_orden, U.fk_rol, U.fk_sede, U.fk_subsede, U.fk_tipodoc
                FROM rmmh_admin_usuarios U
                WHERE fk_rol NOT IN (1)
                ORDER BY U.fk_rol
                LIMIT $desde, $hasta";
    	$query = $this->db->query($sql);
		if ($query->num_rows()>0){
			$i = 0;
			foreach($query->result() as $row){
				$usuarios[$i]["id"] = $row->id_usuario;
				$usuarios[$i]["num_identificacion"] = $row->num_identificacion;
				$usuarios[$i]["nombre"] = $row->nom_usuario;
				$usuarios[$i]["log_usuario"] = $row->log_usuario;
				$usuarios[$i]["pass_usuario"] = $row->pass_usuario;
				$usuarios[$i]["email"] = $row->mail_usuario;
				$usuarios[$i]["fec_creacion"] = $row->fec_creacion;
				$usuarios[$i]["fec_vencimiento"] = $row->fec_vencimiento;
				$usuarios[$i]["nro_orden"] = $row->nro_orden;
				$usuarios[$i]["idxrol"] = $row->fk_rol;
				$usuarios[$i]["rol"] = $this->rol->nombreRol($row->fk_rol);
				$usuarios[$i]["sede"] = $this->sede->nombreSede($row->fk_sede);
				$usuarios[$i]["subsede"] = $this->subsede->nombreSubSede($row->fk_subsede);
				$usuarios[$i]["fk_tipodoc"] = $row->fk_tipodoc;
				$usuarios[$i]["fuentes"] = $this->control->obtenerNumeroFuentesAsignadas($row->fk_rol, $row->id_usuario, $ano_periodo, $mes_periodo);
				$i++;
			}
		}
		$this->db->close();
		return $usuarios;
    }
    
    **************/
    
	//Verifica que un usuario no exista ya dentro de la base de datos con el mismo login de usuario (Al momento de crear un nuevo usuario)
    function existeLogin($login){
    	$sql = "SELECT *
                FROM rmmh_admin_usuarios
                WHERE log_usuario = '$login'";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		$this->db->close();
    		return true;
    	}
    	else{
    		$this->db->close();
    		return false;
    	}   	
    }
    
    //Verifica que un numero de identificacion no exista ya dentro de la base de datos. (No pueden haber dos usuarios con el mismo numero de identificacion)
    function numIdentificacionExiste($tipo, $numdoc){
    	$sql = "SELECT fk_tipodoc, num_identificacion
                FROM rmmh_admin_usuarios
                WHERE fk_tipodoc = $tipo
                AND num_identificacion = $numdoc";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		$this->db->close();
    		return true;
    	}
    	else{
    		$this->db->close();
    		return false;
    	}
    }
    
	//Elimina el registro de un usuario de la tabla de usuarios
    function eliminarUsuario($index){
    	$data = array('id_usuario' => $index);
    	$this->db->delete('rmmh_admin_usuarios',$data);
    	$this->db->close();
    }
    
	//Actualiza los datos de un usuario que se encuentra en la B.D.
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
      
      
	//Obtienen el listado de todos los críticos del sistema, para generar el reporte operativo por crítico  
	function obtenerCriticos($sede, $subsede){
		$criticos = array();
		$sql = "SELECT id_usuario, nom_usuario
                FROM rmmh_admin_usuarios
                WHERE fk_rol = 2 ";
		if ($sede!=0){
        	$sql.= "AND fk_sede = $sede ";
		}
		if ($subsede!=0){ 
            $sql.= "AND fk_subsede = $subsede ";
        }
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0){
    		$i = 0;
			foreach($query->result() as $row){
    			$criticos[$i]["id"] = $row->id_usuario;
				$criticos[$i]["nombre"] = $row->nom_usuario;
    			$i++;
    		}
    	}
		$this->db->close();
		return $criticos;
	}      
	      
    
}//EOC   
    
