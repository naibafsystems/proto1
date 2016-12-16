<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Novedad extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->library("session");
        $this->load->helper("url");
    }
    
   	function buscarNovedades($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
   		$result = false;
   		$sql = "SELECT COUNT(*) AS num
				FROM rmmh_admin_histnovedades
				WHERE nro_orden = $nro_orden
				AND nro_establecimiento = $nro_establecimiento
				AND ano_periodo = $ano_periodo
				AND mes_periodo = $mes_periodo";
   		$query = $this->db->query($sql);
   		if ($query->num_rows()>0){
			foreach($query->result() as $row){
				$num = $row->num;
			}
		}
		$this->db->close();
		
		if ($num>0){
			$result = '<img src="'.base_url("/images/exclam.png").'"/>';			
		}
		else{
			$result = "";
		}
		return $result;
   	}

   	function descargaPlanosNovedades($ano_periodo, $mes_periodo){
   		$novedades = array();
   		$sql = "SELECT C.nro_orden, C.nro_establecimiento, C.ano_periodo, C.mes_periodo, HN.fk_critico, HN.fecha_visita, HN.estado_empresa, HN.consulta_camara, HN.fk_novedad,
                       HN.nom_func, HN.tel_func, HN.cargo_func, HN.obs_critico, HN.fk_coordinador, HN.aceptada, HN.obs_coordinador
				FROM rmmh_admin_control C, rmmh_admin_histnovedades HN, rmmh_param_novedades NV
				WHERE C.nro_orden = HN.nro_orden
				AND C.nro_establecimiento = HN.nro_establecimiento
				AND C.ano_periodo = HN.ano_periodo
				AND C.mes_periodo = HN.mes_periodo
				AND HN.fk_novedad = NV.id_novedad
				AND C.ano_periodo = $ano_periodo
				AND C.mes_periodo = $mes_periodo
				AND HN.aceptada = 1
				GROUP BY HN.nro_orden, HN.nro_establecimiento, HN.ano_periodo, HN.mes_periodo";
   		$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
    		$i = 0;
    		foreach ($query->result() as $row){
      			$novedades[$i]["nro_orden"] = $row->nro_orden;
      			$novedades[$i]["nro_establecimiento"] = $row->nro_establecimiento;
      			$novedades[$i]["ano_periodo"] = $row->ano_periodo;
      			$novedades[$i]["mes_periodo"] = $row->mes_periodo;
    			$novedades[$i]["fk_critico"] = $this->usuario->obtenerNombreUsuario($row->fk_critico);
      			$novedades[$i]["fecha_visita"] = $row->fecha_visita;
      			$novedades[$i]["estado_empresa"] = $this->nombreEstadoNovedad($row->estado_empresa);
      			$novedades[$i]["consulta_camara"] = $this->nombreConsultaCamara($row->consulta_camara);
      			$novedades[$i]["fk_novedad"] = $row->fk_novedad;
      			$novedades[$i]["nom_novedad"] = $this->nombreNovedad($row->fk_novedad);
      			$novedades[$i]["nom_func"] = $row->nom_func;
      			$novedades[$i]["tel_func"] = $row->tel_func;
      			$novedades[$i]["cargo_func"] = $row->cargo_func;
      			$novedades[$i]["obs_critico"] = $row->obs_critico;
      			$novedades[$i]["fk_coordinador"] = $this->usuario->obtenerNombreUsuario($row->fk_coordinador);
      			$novedades[$i]["aceptada"] = $row->aceptada;
      			$novedades[$i]["obs_coordinador"] = $row->obs_coordinador;
      			$i++;
    		}
    	}
    	$this->db->close();
   		return $novedades;
    }
    
	function nombreNovedad($novedad){
   		$nombre = ""; 
   		$sql = "SELECT CONCAT(id_novedad,' - ',nom_novedad) AS nombre
                FROM rmmh_param_novedades
                WHERE id_novedad = $novedad";
   		$query = $this->db->query($sql);
   		if ($query->num_rows()>0){
			foreach($query->result() as $row){
				$nombre = $row->nombre;
			}
		}
		$this->db->close();
		return $nombre;
   	}
	
	function nombreNovedadPlanos($novedad){
   		$nombre = ""; 
   		$sql = "SELECT nom_novedad
                FROM rmmh_param_novedades
                WHERE id_novedad = $novedad";
   		$query = $this->db->query($sql);
   		if ($query->num_rows()>0){
			foreach($query->result() as $row){
				$nombre = $row->nom_novedad;
			}
		}
		$this->db->close();
		return $nombre;
   	}
   	
   	function nombreEstadoFormulario($novedad, $estado){
   		$nombre = "";	
   		$test = $novedad.$estado;
   		switch ($test){
   			case 50:  $nombre= 'Sin Distribuir';
   			          break;
   			case 90:  $nombre = 'Sin Distribuir';
   			          break;
   			case 51:  $nombre = 'Distribuido';
   			          break;
   			case 91:  $nombre = 'Distribuido';
   			          break;
   			case 52:  $nombre = 'En Digitacion';
   			          break;
   			case 92:  $nombre = 'En Digitacion';
   			          break;
   			case 53:  $nombre = 'Digitado';
   			          break;
   			case 93:  $nombre = 'Digitado';
   			          break;
   			case 994: $nombre = 'Analisis y Verificacion';
   			          break;
   			case 995: $nombre = 'Verificado';
   			          break;
   			default:  //Novedad
   					  $nombre = $this->nombreNovedadPlanos($novedad);
   					  break;
   		}
   		return $nombre;
   	}
   	
   	function nombreEstadoNovedad($estado){
   		$nombre = "";
   		$sql = "SELECT nom_estado
                FROM rmmh_param_estadosnovedad
				WHERE id_estado = $estado";
   		$query = $this->db->query($sql);
   		if ($query->num_rows()>0){
			foreach($query->result() as $row){
				$nombre = $row->nom_estado;
			}
		}
		$this->db->close();
		return $nombre;
   	}
   	
   	function nombreConsultaCamara($consulta){
   		$nombre = "";
   		switch($consulta){
   			case 1: $nombre = "Activa";
   			        break;
   			case 2: $nombre = "Cancelada";
   			        break;
   			case 3: $nombre = "No registra";
   			        break;                
   		}
   		return $nombre;
   	}
   	
   		
    
} //EOC   	