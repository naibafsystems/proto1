<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Novedad extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->library("general");        
    }
    
    function obtenerEstadosNovedad(){
    	$estados = array();
    	$sql = "SELECT id_estado, nom_estado
    	        FROM rmmh_param_estadosnovedad";
    	$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
    		$i = 0;
    		foreach($query->result() as $row){
    			$estados[$i]["id"] = $row->id_estado;
    			$estados[$i]["nombre"] = $row->nom_estado;
    			$i++;
    		}
    	}
    	$this->db->close();
    	return $estados;
    }
    
    function obtenerDatosNovedad($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$novedad = array();
    	$sql = "SELECT id_novedad, fk_critico, DATE_FORMAT(fecha_visita,'%d/%m/%Y') AS fecha_visita, estado_empresa, consulta_camara, fk_novedad, nom_func, tel_func, cargo_func, obs_critico, 
    	               fk_coordinador, aceptada, obs_coordinador
    	        FROM rmmh_admin_histnovedades
				WHERE nro_orden = $nro_orden
				AND nro_establecimiento = $nro_establecimiento
				AND ano_periodo = $ano_periodo
				AND mes_periodo = $mes_periodo";
    	$query = $this->db->query($sql);
		if ($query->num_rows()>0){
			$i = 0;
			foreach($query->result() as $row){
				$novedad["op"] = "upd";
				$novedad["id_novedad"] = $row->id_novedad;
				$novedad["fk_critico"] = $row->fk_critico;
				$novedad["fecha_visita"] = $row->fecha_visita;
				$novedad["estado_empresa"] = $row->estado_empresa;
				$novedad["consulta_camara"] = $row->consulta_camara;
				$novedad["fk_novedad"] = $row->fk_novedad;
				$novedad["nom_func"] = $row->nom_func;
				$novedad["tel_func"] = $row->tel_func;
				$novedad["cargo_func"] = $row->cargo_func;
				$novedad["obs_critico"] = $row->obs_critico;
				$novedad["fk_coordinador"] = $row->fk_coordinador;
				$novedad["aceptada"] = $row->aceptada;
				$novedad["obs_coordinador"] = $row->obs_coordinador;
			}
		}
		else{
			$novedad["op"] = "ins";
			$novedad["id_novedad"] = "";
			$novedad["fk_critico"] = "";
			$novedad["fecha_visita"] = "";
			$novedad["estado_empresa"] = "";
			$novedad["consulta_camara"] = "";
			$novedad["fk_novedad"] = "";
			$novedad["nom_func"] = "";
			$novedad["tel_func"] = "";
			$novedad["cargo_func"] = "";
			$novedad["obs_critico"] = "";
			$novedad["fk_coordinador"] = "";
			$novedad["aceptada"] = "";
			$novedad["obs_coordinador"] = "";
		}
		$this->db->close();
		return $novedad;
    }
    
    function guardarNovedadCritico($critico, $fechavisita, $estadoEmpresa, $consultaCamara, $novedad, $nombreFunc, $telFunc, $cargoFunc, $obsCritico, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
		$data = array('fk_critico' => $critico,
   					  'fecha_visita' => $fechavisita,
   					  'estado_empresa' => $estadoEmpresa,
		              'consulta_camara' => $consultaCamara,
		              'fk_novedad' => $novedad,
		              'nom_func' => $nombreFunc,
		              'tel_func' => $telFunc,
					  'cargo_func' => $cargoFunc,
		              'obs_critico' => $obsCritico,
		              'nro_orden' => $nro_orden,
		              'nro_establecimiento' => $nro_establecimiento,
		              'ano_periodo' => $ano_periodo,
		              'mes_periodo' => $mes_periodo);
		$this->db->insert('rmmh_admin_histnovedades', $data);     
    }
    
    function actualizarNovedadCoordinador($coordinador, $aceptada, $obsCoordinador, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$data = array('fk_coordinador' => $coordinador,
    	              'aceptada' => $aceptada,
    	              'obs_coordinador' => $obsCoordinador);
    	$this->db->where('nro_orden', $nro_orden);
    	$this->db->where('nro_establecimiento', $nro_establecimiento);
    	$this->db->where('ano_periodo', $ano_periodo);
    	$this->db->where('mes_periodo', $mes_periodo);
    	$this->db->update('rmmh_admin_histnovedades', $data);    	
    }
    
    function actualizarNovedadCritico($critico, $fechavisita, $estadoEmpresa, $consultaCamara, $novedad, $nombreFunc, $telFunc, $cargoFunc, $obsCritico, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$data = array('fk_critico' => $critico,
   					  'fecha_visita' => $fechavisita,
   					  'estado_empresa' => $estadoEmpresa,
		              'consulta_camara' => $consultaCamara,
		              'fk_novedad' => $novedad,
		              'nom_func' => $nombreFunc,
		              'tel_func' => $telFunc,
					  'cargo_func' => $cargoFunc,
		              'obs_critico' => $obsCritico
    	);		              
    	$this->db->where('nro_orden', $nro_orden);
    	$this->db->where('nro_establecimiento', $nro_establecimiento);
    	$this->db->where('ano_periodo', $ano_periodo);
    	$this->db->where('mes_periodo', $mes_periodo);
    	$this->db->update('rmmh_admin_histnovedades', $data);
    }
    
    
    
	function obtenerNovedades() {
		$novedades = array();
		$sql = "SELECT id_novedad, nom_novedad
                FROM rmmh_param_novedades
                WHERE id_novedad NOT IN (5,9,99,97)
                ORDER BY nom_novedad";
		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
			$i = 0;
			foreach($query->result() as $row){
				$novedades[$i]["id"] = $row->id_novedad;
				$novedades[$i]["nombre"] = $row->nom_novedad;
				$i++;
			}
		}
		$this->db->close();
		return $novedades;
	}
	
	function obtenerDatosFuenteNovedad($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
		$datos = array();
		$sql = "SELECT C.nro_orden, C.nro_establecimiento, EM.idproraz, ES.idnomcom, ES.fk_ciiu, ACT.nom_ciiu, U.id_usuario, CASE(C.fk_usuariocritica)
                                                                                                                               WHEN 0 THEN 'SIN CRITICA'
                                                                                                                               ELSE U.nom_usuario
                                                                                                                             END AS nom_usuario
                FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES, rmmh_admin_usuarios U, rmmh_param_ciiu3 ACT
                WHERE C.nro_orden = EM.nro_orden
                AND C.nro_orden = ES.nro_orden
                AND C.nro_establecimiento = ES.nro_establecimiento
                AND C.fk_usuariocritica = U.id_usuario
                AND ES.fk_ciiu = ACT.id_ciiu
                AND C.nro_orden = $nro_orden
                AND C.nro_establecimiento = $nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo";        
		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
			foreach($query->result() as $row){
				$datos["nro_orden"] = $row->nro_orden;
				$datos["nro_establecimiento"] = $row->nro_establecimiento;
				$datos["idproraz"] = $row->idproraz;
				$datos["idnomcom"] = $row->idnomcom;
				$datos["fk_ciiu"] = $row->fk_ciiu;
				$datos["nom_ciiu"] = $row->nom_ciiu;
				$datos["id_critico"] = $row->id_usuario;
				$datos["nom_critico"] = $row->nom_usuario;
			}
		}
		$this->db->close();
		return $datos;
		
	}
	
	//En el modulo de novedades el menu debe adaptarse según el rol del usuario que esté accediendo al módulo
	//con esta funcion se obtiene el menu de acuerdo al rol del usuario
	function obtenerMenu($rol){
		$menu = "";
		switch ($rol){
			case 1: //Fuente
					$menu = "formularios/fuentemenu"; 
					break;
					
			case 2: //Critico
					$menu = "critico/criticomenu";
					break;

			case 3: //Asistente Técnico
					$menu = "asistente/asismenu";
					break;

			case 4: //Administrador
					$menu = "administrador/adminmenu";
					break;

			case 5: //Logistica
					$menu = "logistica/logmenu";
					break;
		}
		return $menu;
	}
	
	//Traduce los errores al momento que se presentan errores cargando la imagen de soporte de las novedades
	function traducirError($error){
		$spanish = "";
		$arrayWords = array("filetype","select");
		for ($i=0; $i<count($arrayWords); $i++){
			if (preg_match("/$arrayWords[$i]/i",$error)) {
	    		switch($i){
	    			case 0: //filetype
	    					$spanish = "El tipo de archivo que intenta cargar no est&aacute; permitido.";
	    					break;
	    					
	    			case 1: //filsesize
	    					$spanish = "El tama&ntilde;o del archivo que intenta cargar supera los 2 MB.";
	    					break;		
	    		}
	    		break;
			}
		}
		return $spanish;	
	}
	
	//Pregunta si el registro de una novedad ya existe en la tabla de historico_novedades
	function verificarNovedadExiste($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
		$existe = false;
		$sql = "SELECT *
                FROM rmmh_admin_histnovedades
                WHERE nro_orden = $nro_orden 
                AND nro_establecimiento = $nro_establecimiento
                AND ano_periodo = $ano_periodo
                AND mes_periodo = $mes_periodo";
		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
			$existe = true;
		}
		$this->db->close();
		return $existe;
	}
	
	//Bloquea los campos del diligenciamiento de la novedad cuando ya ha sido aprobada y/o rechazada
	function bloqueoCampos($rol, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
		$bloqueo = false;
		if ($rol==2){
			$sql = "SELECT aceptada
	                FROM rmmh_admin_histnovedades
	                WHERE nro_orden = $nro_orden
	                AND nro_establecimiento = $nro_establecimiento
	                AND ano_periodo = $ano_periodo
	                AND mes_periodo = $mes_periodo";
			$query = $this->db->query($sql);
			if ($query->num_rows()>0){
				foreach($query->result() as $row){
					if (($row->aceptada==NULL)||($row->aceptada==0)){
						$bloqueo = false;
					}
					else{
						$bloqueo = true;
					}
				}	
			}
			$this->db->close();
		}
		return $bloqueo;
	}
	
	
}//EOC