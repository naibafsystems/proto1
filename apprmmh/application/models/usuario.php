<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
    }
    
    
 	//Daniel M. Díaz - Agosto 13, 2012
    //Validación de usuarios y contraseñas con mecanismos de encriptacion segun la libreria DaneCrypt. (Libraries/DaneCrypt)
    //Permite encriptar y desencriptar la contraseña a pedido. Utiliza encriptacion de dos vias
    function validarUsuarioDANE($login, $password){
    	$this->load->library("danecrypt");
    	$this->load->model("periodo");
    	$periodo = $this->periodo->obtenerPeriodoActual();
    	$ano_periodo = $periodo["ano"];
    	$mes_periodo = $periodo["mes"];
    	
    	$sql = "SELECT U.*
                FROM rmmh_admin_control C, rmmh_admin_usuarios U
                WHERE C.nro_orden = U.nro_orden
                AND C.nro_establecimiento = U.nro_establecimiento
                AND U.log_usuario = '$login'";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		//Acceso fuente
    		$sql2 = "SELECT U.*
                     FROM rmmh_admin_control C, rmmh_admin_usuarios U
                     WHERE C.nro_orden = U.nro_orden
                     AND C.nro_establecimiento = U.nro_establecimiento
                     AND U.log_usuario = '$login'
                     AND C.ano_periodo = $ano_periodo
                     AND C.mes_periodo = $mes_periodo";
    		
    		var_dump($sql2);
    		
    		$query = $this->db->query($sql2);
    		if ($query->num_rows() > 0){
    			//Validar la fuente
    			foreach ($query->result() as $row){
      				$encrypt = $this->danecrypt->encode($password);
      				if (strcmp($row->pass_usuario,$encrypt)==0){
    					$this->load->library("session");
    					$this->load->model("periodo");
    					$periodoActual = $this->periodo->obtenerPeriodoActual();
    					$sessionData = array('auth' => trim('OK'),
    			        	                 'id' => trim($row->id_usuario),
    			            	             'num_identificacion' => trim($row->num_identificacion),
                                	         'nombre' => trim($row->nom_usuario),
    				                	     'nro_orden' => trim($row->nro_orden),
    				                    	 'nro_establecimiento' => trim($row->nro_establecimiento),
    				                     	'clave' => trim($row->pass_usuario),
    				                     	'email' => trim($row->mail_usuario),
    				                     	'tipo_usuario' => trim($row->fk_rol),
    				                     	'fec_creacion' => trim($row->fec_creacion),
    				                     	'fec_vencimiento' => trim($row->fec_vencimiento),
    				                     	'ano_periodo' => trim($periodoActual["ano"]),
    				                     	'mes_periodo' => trim($periodoActual["mes"])
    					           	   );
						$this->session->set_userdata($sessionData);
      					return true;
      				}
    			}      			
   			}
   			else{
   				$this->db->close();
   				return false;
   			}
    	}
    	else{
    		$sql3 = "SELECT U.*
    		         FROM rmmh_admin_usuarios U
    		         WHERE U.log_usuario = '$login'";
    		$query = $this->db->query($sql3);
    		if ($query->num_rows() > 0){
    			//Validar admin
    			foreach ($query->result() as $row){
      				$encrypt = $this->danecrypt->encode($password);
      				if (strcmp($row->pass_usuario,$encrypt)==0){
    					$this->load->library("session");
    					$this->load->model("periodo");
    					$periodoActual = $this->periodo->obtenerPeriodoActual();
    					$sessionData = array('auth' => trim('OK'),
    			        	                 'id' => trim($row->id_usuario),
    			            	             'num_identificacion' => trim($row->num_identificacion),
                                	         'nombre' => trim($row->nom_usuario),
    				                	     'nro_orden' => trim($row->nro_orden),
    				                    	 'nro_establecimiento' => trim($row->nro_establecimiento),
    				                     	'clave' => trim($row->pass_usuario),
    				                     	'email' => trim($row->mail_usuario),
    				                     	'tipo_usuario' => trim($row->fk_rol),
    				                     	'fec_creacion' => trim($row->fec_creacion),
    				                     	'fec_vencimiento' => trim($row->fec_vencimiento),
    				                     	'ano_periodo' => trim($periodoActual["ano"]),
    				                     	'mes_periodo' => trim($periodoActual["mes"])
    					           	   );
						$this->session->set_userdata($sessionData);
      					return true;
      				}
    			}
    		}
    		else{
    			$this->db->close();
    			return false;	
    		}
    	}    	
    }
    
    function redireccionarUsuario(){    	
    	$this->load->helper("url");
    	$this->load->library("session");
    	$tipoUsuario = $this->session->userdata('tipo_usuario');
    	$controller = "login";
    	switch($tipoUsuario){
    		case 1: //Fuentes
    				$controller = "fuente";
    				break;
    		case 2: //Criticos
    				$controller = "critico";
    				break;
    		case 3: //Asistentes Técnicos
    				$controller = "asistente";
    				break;
    		case 4: //Administradores
    				$controller = "administrador";
    				break;
    		case 5: //Logisticos
    				$controller = "logistica";
    				break;
    		case 6: //Tematicos										
    				$controller = "tematica";
    				break;
    		case 7: //Directivos
    				$controller = "directivos";
    				break; 
    		case 8: //Estadisticos
    				$controller = "estadisticos";
    				break;		   						
    	}
    	
    	redirect($controller,'location',301);
    }
    
    
    
    
    
    
	/***************
	 * POR MOTIVOS DE ORDEN EN EL CODIGO SE COMENTAN TODAS LAS SIGUIENTES FUNCIONES, PARA VERIFICAR CUALES DE ESTAS SON REQUERIDAS EN EL ARBOL 
	 * PRINCIPAL. EL RESTO DE LAS FUNCIONES SE MUEVEN DENTRO DE CADA UNO DE LOS MODULOS. 
	 * 
	 
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
     // OBTIENE EL ID DE USUARIO DE UNA FUENTE A PARTIR DEL NRO DE ORDEN, UNI_LOCAL, ANO_PERIODO Y MES_PERIODO
     function obtenerIDFuente($nro_orden, $uni_local, $ano_periodo, $mes_periodo){
     	$id = 99999999999;
     	$sql = "SELECT C.fk_usuario
                FROM rmmh_admin_control C, rmmh_admin_usuarios U
                WHERE C.fk_usuario = U.id_usuario
                AND C.nro_orden = $nro_orden
                AND C.uni_local = $uni_local
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo";
     	$query = $this->db->query($sql);		
		if ($query->num_rows()>0){
			foreach($query->result() as $row){
				$id = $row->fk_usuario;
			}
		}
		$this->db->close();
		return $id;
	}
     	
    
    // ELIMINA LOS DATOS DE UNA FUENTE PARA UN ANO - MES PERIODO
    function eliminarFuente($nro_orden, $uni_local, $ano_periodo, $mes_periodo){
    	$query = $this->db->query("SET FOREIGN_KEY_CHECKS = 0");
    	//Inicio la transaccion
		$this->db->trans_start();
    	//Obtengo id de usuario para hacer el borrado
    	$id = $this->obtenerIDFuente($nro_orden, $uni_local, $ano_periodo, $mes_periodo);
    	//Borrado tabla de control
    	$this->db->where('nro_orden', $nro_orden);
		$this->db->where('uni_local', $uni_local);
		$this->db->where('ano_periodo', $ano_periodo);
		$this->db->where('mes_periodo', $mes_periodo);
		$this->db->delete('rmmh_admin_control');
    	echo $this->db->last_query();
		//Borrado tabla de usuarios
		$this->db->where("id_usuario", $id);
		$this->db->where("fk_rol", 1);  //Me aseguro de que solo elimine fuentes
		$this->db->delete('rmmh_admin_usuarios');
		echo $this->db->last_query();
		//Borrado de tabla de fuentes
		$this->db->where("nro_orden", $nro_orden);
		$this->db->where("uni_local", $uni_local);
		$this->db->delete('rmmh_admin_dirfuentes');
		echo $this->db->last_query();
		//Borrado tablas de capitulos
    	$tables = array('rmmh_form_movmensual', 'rmmh_form_ingoperacionales', 'rmmh_form_persalarios', 'rmmh_form_caracthoteles', 'rmmh_form_envioform');
		$this->db->where('nro_orden', $nro_orden);
		$this->db->where('uni_local', $uni_local);
		$this->db->where('ano_periodo', $ano_periodo);
		$this->db->where('mes_periodo', $mes_periodo);
		$this->db->delete($tables);
		echo $this->db->last_query();
		//Borrado tablas de observaciones
		$this->db->where('nro_orden', $nro_orden);
		$this->db->where('uni_local', $uni_local);
		$this->db->where('ano_periodo', $ano_periodo);
		$this->db->where('mes_periodo', $mes_periodo);
		$this->db->delete("rmmh_admin_observaciones");
		echo $this->db->last_query();
		//Termino la transaccion
		$query = $this->db->query("SET FOREIGN_KEY_CHECKS = 1");
		$this->db->trans_complete(); 	
    }
    
    //Obtiene la razon social de una fuente, de acuerdo al nro_orden y unidad local
	function obtenerNombreFuente($nro_orden, $uni_local){
		$nombre = "";
		$sql = "SELECT idproraz
				FROM rmmh_admin_dirfuentes
				WHERE nro_orden = $nro_orden
				AND uni_local = $uni_local";
		$query = $this->db->query($sql);		
		if ($query->num_rows()>0){
			$i=0;
			foreach($query->result() as $row){
				$nombre = $row->idproraz;
			}
		}
		$this->db->close();
		return $nombre;
	}
    
    
    function reportePasswords(){
    	$this->load->library("danecrypt");
    	$reporte = array();
    	$sql = "SELECT id_usuario, num_identificacion, nom_usuario, log_usuario, pass_usuario
    	        FROM rmmh_admin_usuarios
    	        WHERE num_identificacion <> 0
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
    
    
    //Daniel M. Díaz - Junio 07 2012
    //Valida usuario y contraseña utilizando encriptacion MD5 para la contraseña.
    //Se cambia esta funcion por la utilizada en la libreria danecrypt. (Ver validarUsuarioDANE).
    function validarUsuario($login, $password){
    	$sql = "SELECT U.id_usuario, U.num_identificacion, U.nom_usuario, U.nro_orden, U.log_usuario, U.pass_usuario, U.mail_usuario, U.fk_rol, U.fec_creacion, U.fec_vencimiento, DF.uni_local,
    	               DF.fk_sede, DF.fk_subsede
			    FROM rmmh_admin_usuarios U, rmmh_admin_dirfuentes DF
				WHERE U.nro_orden = DF.nro_orden
				AND U.log_usuario = '$login'";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
      			if (strcmp($row->pass_usuario,md5($password))==0){
    				$this->load->library("session");
    				$this->load->model("periodo");
    				$periodoActual = $this->periodo->obtenerPeriodoActual();
    				$sessionData = array('auth' => 'OK',
    				                     'id' => $row->id_usuario,
    				                     'num_identificacion' => $row->num_identificacion,
                                         'nombre' => $row->nom_usuario,
    				                     'nro_orden' => $row->nro_orden,
    				                     'uni_local' => $row->uni_local,
    				                     'clave' => $row->pass_usuario,
    				                     'email' => $row->mail_usuario,
    				                     'tipo_usuario' => $row->fk_rol,
    				                     'fec_creacion' => $row->fec_creacion,
    				                     'fec_vencimiento' => $row->fec_vencimiento,
    				                     'sede' => $row->fk_sede,
    				                     'subsede' => $row->fk_subsede,
    				                     'ano_periodo' => $periodoActual["ano"],
    				                     'mes_periodo' => $periodoActual["mes"]
    				);
					$this->session->set_userdata($sessionData);
      				return true;
      			}
   			}
   		}    	
    	$this->db->close();
   		return false;   		
    }
    
   
    
    //Obtiene todos los usuarios del sistema que no hacen parte de las fuentes (fk_rol <> 1)
    function obtenerUsuarios(){
    	$this->load->model("control");
    	$this->load->model("rol");
    	$this->load->model("sede");
    	$usuarios = "";
		$sql = "SELECT *
    	        FROM rmmh_admin_usuarios
    	        WHERE fk_rol <> 1";                        
		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
			$i = 0;
			foreach($query->result() as $row){
				$usuarios[$i]["id"] = $row->id_usuario;
				$usuarios[$i]["num_identificacion"] = $row->num_identificacion;
				$usuarios[$i]["nombre"] = utf8_decode($row->nom_usuario);
				$usuarios[$i]["log_usuario"] = $row->log_usuario;
				$usuarios[$i]["pass_usuario"] = $row->pass_usuario;
				$usuarios[$i]["email"] = $row->mail_usuario;
				$usuarios[$i]["fec_creacion"] = $row->fec_creacion;
				$usuarios[$i]["fec_vencimiento"] = $row->fec_vencimiento;
				$usuarios[$i]["nro_orden"] = $row->nro_orden;
				$usuarios[$i]["idxrol"] = $row->fk_rol;
				$usuarios[$i]["rol"] = utf8_decode($this->rol->nombreRol($row->fk_rol));
				$usuarios[$i]["sede"] = utf8_decode($this->sede->nombreSede($row->fk_sede));
				$usuarios[$i]["fk_tipodoc"] = $row->fk_tipodoc;
				$usuarios[$i]["fuentes"] = $this->control->obtenerNumeroFuentesAsignadas($row->fk_rol, $row->id_usuario);
				$i++;
			}
		}
		$this->db->close();
		return $usuarios;
    }
    
//Obtiene todos los usuarios del sistema que no hacen parte de las fuentes (fk_rol <> 1)
    function obtenerUsuariosPagina($desde){
    	$usuarios = array();
    	$this->load->library("paginador2");
    	$this->load->model("control");
    	$this->load->model("rol");
    	$this->load->model("sede");
    	$this->load->model("subsede");
    	$hasta = $this->paginador2->getRegsPagina();
    	
    	$sql = "SELECT U.id_usuario, U.num_identificacion, U.nom_usuario, U.log_usuario, U.pass_usuario, U.mail_usuario, U.fec_creacion, U.fec_vencimiento, U.nro_orden, U.fk_rol, U.fk_sede, U.fk_subsede, U.fk_tipodoc
                FROM rmmh_admin_usuarios U
                WHERE fk_rol <> 1
                LIMIT $desde, $hasta";
    	$query = $this->db->query($sql);
		if ($query->num_rows()>0){
			$i = 0;
			foreach($query->result() as $row){
				$usuarios[$i]["id"] = $row->id_usuario;
				$usuarios[$i]["num_identificacion"] = $row->num_identificacion;
				$usuarios[$i]["nombre"] = utf8_decode($row->nom_usuario);
				$usuarios[$i]["log_usuario"] = $row->log_usuario;
				$usuarios[$i]["pass_usuario"] = $row->pass_usuario;
				$usuarios[$i]["email"] = $row->mail_usuario;
				$usuarios[$i]["fec_creacion"] = $row->fec_creacion;
				$usuarios[$i]["fec_vencimiento"] = $row->fec_vencimiento;
				$usuarios[$i]["nro_orden"] = $row->nro_orden;
				$usuarios[$i]["idxrol"] = $row->fk_rol;
				$usuarios[$i]["rol"] = utf8_decode($this->rol->nombreRol($row->fk_rol));
				$usuarios[$i]["sede"] = utf8_decode($this->sede->nombreSede($row->fk_sede));
				$usuarios[$i]["subsede"] = utf8_decode($this->subsede->nombreSubSede($row->fk_subsede));
				$usuarios[$i]["fk_tipodoc"] = $row->fk_tipodoc;
				$usuarios[$i]["fuentes"] = $this->control->obtenerNumeroFuentesAsignadas($row->fk_rol, $row->id_usuario);
				$i++;
			}
		}
		$this->db->close();
		return $usuarios;
    }
    
    //Obtiene todos los usuarios del sistema que son fuentes
    function obtenerFuentes(){
    	$this->load->library("session");
    	$this->load->model("divipola");
    	$this->load->model("sede");
    	$fuentes = array();
    	$ano = $this->session->userdata("ano_periodo");
    	$mes = $this->session->userdata("mes_periodo");
    	$sql = "SELECT DF.nro_orden, DF.uni_local, DF.idproraz, DF.idnomcom, DF.idsigla, DF.iddirecc, DF.idtelno, 
    	               DF.idfaxno, DF.idaano, DF.idcorreo, DF.finicial, DF.ffinal, DF.fk_depto, DF.fk_mpio, 
    	               DF.fk_ciiu, DF.fk_sede
				FROM rmmh_admin_dirfuentes DF, rmmh_admin_control C
				WHERE DF.nro_orden = C.nro_orden
				AND C.ano_periodo = $ano
				AND C.mes_periodo = $mes
				AND DF.nro_orden <> 0 ";
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
    
    
    //Obtiene todos los usuarios del sistema que son fuentes (Filtrando para un año y un periodo)
    function obtenerFuentesAnoPeriodo($ano, $mes){
    	$this->load->model("divipola");
    	$this->load->model("sede");
    	$fuentes = array();
    	$sql = "SELECT DF.nro_orden, DF.uni_local, DF.idproraz, DF.idnomcom, DF.idsigla, DF.iddirecc, DF.idtelno,
    	        DF.idfaxno, DF.idaano, DF.idcorreo, DF.finicial, DF.ffinal, DF.fk_depto, DF.fk_mpio, DF.fk_ciiu, DF.fk_sede
                FROM rmmh_param_periodos P, rmmh_admin_control C, rmmh_admin_dirfuentes DF
                WHERE P.ano_periodo = C.ano_periodo
                AND P.mes_periodo = C.mes_periodo
                AND C.nro_orden = DF.nro_orden
                AND P.ano_periodo = $ano
                AND P.mes_periodo = $mes";
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
    
    
    //Obtiene todos los usuarios del sistema que son fuentes
    function obtenerFuentesPagina($desde){
    	$this->load->library("session");
    	$this->load->library("paginador2");
    	$this->load->model("divipola");
    	$this->load->model("sede");
    	$fuentes = array();
    	$ano = $this->session->userdata("ano_periodo");
    	$mes = $this->session->userdata("mes_periodo");
    	$hasta = $this->paginador2->getRegsPagina();
    	$sql = "SELECT DF.nro_orden, DF.uni_local, DF.idproraz, DF.idnomcom, DF.idsigla, DF.iddirecc, DF.idtelno, 
    	               DF.idfaxno, DF.idaano, DF.idcorreo, DF.finicial, DF.ffinal, DF.fk_depto, DF.fk_mpio, 
    	               DF.fk_ciiu, DF.fk_sede
				FROM rmmh_admin_dirfuentes DF, rmmh_admin_control C
				WHERE DF.nro_orden = C.nro_orden
				AND C.ano_periodo = $ano
                AND C.mes_periodo = $mes
				AND DF.nro_orden <> 0 
				LIMIT $desde, $hasta";
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
    
    //Obtiene todos los usuarios con rol fuente en la base de datos, filttrando por ano y periodo
    function obtenerFuentesPaginaAnoPeriodo($desde, $ano, $mes){
    	$this->load->library("paginador2");
    	$this->load->model("divipola");
    	$this->load->model("sede");
    	$fuentes = array();
    	$hasta = $this->paginador2->getRegsPagina();
    	$sql = "SELECT DF.nro_orden, DF.uni_local, DF.idproraz, DF.idnomcom, DF.idsigla, DF.iddirecc, DF.idtelno,
    	               DF.idfaxno, DF.idaano, DF.idcorreo, DF.finicial, DF.ffinal, DF.fk_depto, DF.fk_mpio, DF.fk_ciiu, DF.fk_sede
                FROM rmmh_param_periodos P, rmmh_admin_control C, rmmh_admin_dirfuentes DF
                WHERE P.ano_periodo = C.ano_periodo
                AND P.mes_periodo = C.mes_periodo
                AND C.nro_orden = DF.nro_orden
                AND P.ano_periodo = $ano
                AND P.mes_periodo = $mes
                AND DF.nro_orden <> 0
                LIMIT $desde, $hasta";
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
    
    
    
    
    //Inserta un usuario en la base de datos
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
    
    //Verifica que un usuario no exista ya dentro de la base de datos con el mismo login de usuario
    function existeLogin($login){
    	$retorno = false;
    	$sql = "SELECT *
                FROM rmmh_admin_usuarios
                WHERE log_usuario = '$login'";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		$retorno = true;
    	}
    	$this->db->close();
    	return $retorno;
    }
    
    //Elimina el registro de un usuario de la tabla de usuarios
    function eliminarUsuario($index){
    	$data = array('id_usuario' => $index);
    	$this->db->delete('rmmh_admin_usuarios',$data);
    	$this->db->close();
    }
    
    //Obtiene los datos de un usuario de acuerdo a un id de usuario
    function obtenerUsuarioID($id){
    	$this->load->library("danecrypt");
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
				$usuario["nombre"] = utf8_decode($row->nom_usuario);
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
				$usuario["fuentes"] = $this->control->obtenerNumeroFuentesAsignadas($row->fk_rol, $row->id_usuario);
			}
		}
		$this->db->close();
		return $usuario;
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
    
    
    //Obtiene todas las fuentes que ya han sido asignadas a un critico.
    //Recibe como parametro el id de usuario del critico, para conocer las fuentes que se le han asignado
    function obtenerFuentesAsignadas($id){
    	$this->load->library("session");
    	$this->load->model("divipola");
    	$this->load->model("sede");
    	$asignadas = array();
    	$ano = $this->session->userdata("ano_periodo");
    	$mes = $this->session->userdata("mes_periodo");
    	$sql = "SELECT DF.nro_orden, DF.uni_local, DF.fk_ciiu, DF.idsigla, DF.idproraz, DF.idnomcom, DF.fk_depto, DF.fk_mpio, DF.fk_sede
                FROM rmmh_admin_dirfuentes DF, rmmh_admin_control C
                WHERE DF.nro_orden = C.nro_orden
                AND C.fk_rolacceso = 2
                AND C.fk_usuario = $id
                AND C.ano_periodo = $ano
                AND C.mes_periodo = $mes";        
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
    
	//Obtiene todas las fuentes que ya han sido asignadas a un critico.
    //Recibe como parametro el id de usuario del critico, para conocer las fuentes que se le han asignado utilizada para paginacion
    
    function obtenerFuentesAsignadasPagina($critico, $desde){
    	$asignadas = array();
    	$this->load->library("session");
    	$this->load->library("paginador2");
    	$this->load->model("divipola");
    	$this->load->model("sede");
    	$ano = $this->session->userdata("ano_periodo");
    	$mes = $this->session->userdata("mes_periodo");
    	$hasta = $this->paginador2->getRegsPagina();
    	$sql = "SELECT DF.nro_orden, DF.uni_local, DF.fk_ciiu, DF.idproraz, DF.idnomcom, DF.fk_depto, DF.fk_mpio, DF.fk_sede
				FROM rmmh_admin_dirfuentes DF, rmmh_admin_control C
				WHERE DF.nro_orden = C.nro_orden
				AND C.fk_rolacceso = 2
				AND C.fk_usuario = $critico
				AND C.ano_periodo = $ano
				AND C.mes_periodo = $mes
				LIMIT $desde, $hasta";    	    		
    	$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
    		$i=0;
    		foreach($query->result() as $row){
    			$asignadas[$i]["nro_orden"] = $row->nro_orden;
    			$asignadas[$i]["uni_local"] = $row->uni_local;
    			$asignadas[$i]["fk_ciiu"] = $row->fk_ciiu;
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
    
    //Obtiene todas las fuentes que aun no han sido asignadas a un critico
 	function obtenerFuentesSinAsignar(){
    	$this->load->library("session");
 		$this->load->model("divipola");
    	$this->load->model("sede");
    	$ano = $this->session->userdata("ano_periodo");
    	$mes = $this->session->userdata("mes_periodo");
    	$fuentes = array();
    	$sql = "SELECT DF.nro_orden, DF.uni_local, DF.idproraz, DF.idnomcom, DF.idsigla, DF.iddirecc, DF.idtelno,
    	               DF.idfaxno, DF.idaano, DF.idcorreo, DF.finicial, DF.ffinal, DF.fk_depto, DF.fk_mpio,
    	               DF.fk_ciiu, DF.fk_sede
		FROM rmmh_admin_dirfuentes DF, rmmh_admin_control C
		WHERE DF.nro_orden = C.nro_orden
		AND DF.nro_orden <> 0
		AND C.fk_rolacceso <> 2
		AND C.ano_periodo = $ano
		AND C.mes_periodo = $mes";
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
	    		$fuentes[$i]["fk_ciiu"] = $row->fk_ciiu;
	    		$i++;
    		}
    	}
    	$this->db->close();
    	return $fuentes;
    }
    
    //Obtiene todas las fuentes sin asignar (fuentes que aun no han sido asignadas a algun critico)
    //Se realiza la consulta con el mecanismo de paginacion.
    function obtenerFuentesSinAsignarPagina($desde){
    	$this->load->library("paginador2");
    	$this->load->model("divipola");
    	$this->load->model("sede");
    	$hasta = $this->paginador2->getRegsPagina();
    	$fuentes = array();
    	$sql = "SELECT DF.nro_orden, DF.uni_local, DF.idproraz, DF.idnomcom, DF.idsigla, DF.iddirecc, DF.idtelno, 
    	               DF.idfaxno, DF.idaano, DF.idcorreo, DF.finicial, DF.ffinal, DF.fk_depto, DF.fk_mpio, 
    	               DF.fk_ciiu, DF.fk_sede
				FROM rmmh_admin_dirfuentes DF, rmmh_admin_control C
				WHERE DF.nro_orden = C.nro_orden
				AND DF.nro_orden <> 0
				AND C.fk_rolacceso <> 2
				LIMIT $desde, $hasta";
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
	    		$fuentes[$i]["fk_ciiu"] = $row->fk_ciiu;
	    		$i++;
    		}
    	}
    	$this->db->close();
    	return $fuentes;
    }
    
    
    //Obtiene el ID de usuario del ultimo registro insertado en la B.D.    
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
    
    
    
    //Funcion para consultar si una fuente ya se encuentra registrada para un año mes.    
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
    
    
    // Funcion para consultar si una fuente pertenece al directorio de fuentes original o si ha sido una fuente agregada    
    function obtenerEstado($ano, $mes, $nro_orden){
    	$result = 5; //Novedad para las fuentes que ingresan desde el directorio (No ingresan como fuentes nuevas).
    	$sql = "SELECT fk_novedad
                FROM rmmh_admin_dirfuentes DF, rmmh_admin_control C
				WHERE DF.nro_orden = C.nro_orden
				AND C.nro_orden = $nro_orden";
    	$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
    		foreach($query->result() as $row){
	    		$result = $row->fk_novedad;
    		}
    	}
    	$this->db->close();
    	return $result;
    }
    
    
    //Funcion para consultar los datos de una fuente segun el numero de orden    
    function obtenerDatosFuente($num_orden){
    	$datos = array();
    	$sql = "SELECT DF.nro_orden, DF.uni_local, DF.idproraz, DF.idnomcom, DF.idsigla, DF.iddirecc, DF.fk_depto, DF.fk_mpio, DF.fk_ciiu
				FROM rmmh_admin_dirfuentes DF
				WHERE nro_orden = $num_orden";
    	$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
    		foreach($query->result() as $row){
    			$datos["nro_orden"] = $row->nro_orden;
    			$datos["uni_local"] = $row->uni_local;
    			$datos["idproraz"] = $row->idproraz;
    			$datos["idnomcom"] = $row->idnomcom;
    			$datos["idsigla"] = $row->idsigla;
    			$datos["iddirecc"] = $row->iddirecc;
    			$datos["fk_depto"] = $row->fk_depto;
    			$datos["fk_mpio"] = $row->fk_mpio;
    			$datos["fk_ciiu"] = $row->fk_ciiu;
    		}
    	}
    	$this->db->close();
    	return $datos;
    }
    
    
    
    //Funcion para obtener los datos de las sedes que le han asignado a un critico    
    function obtenerSedesCritico($idusuario){
    	$this->load->library("session");
    	$ano = $this->session->userdata("ano_periodo");
    	$mes = $this->session->userdata("mes_periodo");
    	$sedes = array();	
    	$sql = "SELECT DISTINCT(C.fk_sede) AS id, S.nom_sede AS nombre
			    FROM rmmh_admin_usuarios U, rmmh_admin_control C, rmmh_param_sedes S
				WHERE U.id_usuario = C.fk_usuario
				AND C.fk_sede = S.id_sede
				AND C.ano_periodo = $ano
				AND C.mes_periodo = $mes
				AND U.id_usuario = $idusuario
				AND U.fk_rol = 2";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		$i = 0;
    		foreach($query->result() as $row){
    			$datos[$i]["id"] = $row->id;
    			$datos[$i]["nombre"] = $row->nombre;
    			$i++;
    		}	
    	}	
    	$this->db->close();
    	return $datos;
    }
    
    
    //Funcion para obtener los datos de las subsedes que le han asignado a un critico    
    function obtenerSubSedesCritico($idusuario){
    	$this->load->library("session");
    	$ano = $this->session->userdata("ano_periodo");
    	$mes = $this->session->userdata("mes_periodo");
    	$subsedes = array();
    	$sql = "SELECT DISTINCT(C.fk_subsede) AS id, S.nom_subsede AS nombre
				FROM rmmh_admin_usuarios U, rmmh_admin_control C, rmmh_param_subsedes S
				WHERE U.id_usuario = C.fk_usuario
				AND C.fk_subsede = S.id_subsede
				AND C.ano_periodo = $ano
				AND C.mes_periodo = $mes
				AND U.id_usuario = $idusuario
				AND U.fk_rol = 2";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		$i = 0;
    		foreach($query->result() as $row){
    			$datos[$i]["id"] = $row->id;
    			$datos[$i]["nombre"] = $row->nombre;
    			$i++;
    		}	
    	}
    	$this->db->close();
    	return $datos;
    }
    
    
     //Obtiene todas las fuentes que se encuentran en la misma sede de un usuario. (Asistente Técnico)    
     function obtenerFuentesPorSede($ano_periodo, $mes_periodo, $sede){
     	$fuentes = array();
     	$sql = "SELECT DF.nro_orden, DF.uni_local, DF.idproraz, DF.idnomcom, DF.idsigla, DF.iddirecc, DF.idtelno, DF.idfaxno, DF.idaano, DF.idpagweb,
                       DF.idcorreo, DF.finicial, DF.ffinal, DF.fk_depto, DF.fk_mpio, DF.fk_sede, DF.fk_subsede, DF.fk_ciiu
				FROM rmmh_admin_dirfuentes DF, rmmh_admin_control C, rmmh_admin_usuarios U
				WHERE DF.nro_orden = C.nro_orden
				AND DF.nro_orden = U.nro_orden
				AND C.ano_periodo = $ano_periodo
				AND C.mes_periodo = $mes_periodo
				AND U.fk_rol = 1
				AND DF.fk_sede = $sede";
     	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
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


    /**********************************
	**********************************/

    
}//EOC	