<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Directorio extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
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
   	
   	
   	function buscarDirectorio($busqueda){
   		$this->load->library("session");
   		$this->load->model("sede");
   		$this->load->model("divipola");
   		$directorio = array();
   		$ano = $this->session->userdata("ano_periodo");
   		$mes = $this->session->userdata("mes_periodo");
   		$sql = "SELECT C.nro_orden, DF.uni_local, DF.fk_ciiu, DF.idproraz, DF.idnomcom, DF.fk_depto, DF.fk_mpio, DF.fk_sede
			    FROM rmmh_admin_dirfuentes DF, rmmh_admin_control C
				WHERE DF.nro_orden = C.nro_orden";
   		if (is_numeric($busqueda)){
   			$sql.= " AND C.nro_orden = $busqueda ";
   		}
   		else{
   			$sql.= " AND DF.idproraz LIKE '%$busqueda%'";
   		}		   		   		
    	$sql.= " AND C.ano_periodo = $ano
                 AND C.mes_periodo = $mes";
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
   	
   	
   	//Realiza la busqueda dentro del directorio de fuentes asignado a un usuario particular
   	function buscarDirectorioUsuario($usuario, $busqueda){
   		$this->load->library("session");
   		$this->load->model("sede");
   		$this->load->model("divipola");
   		$directorio = array();
   		$ano = $this->session->userdata("ano_periodo");
   		$mes = $this->session->userdata("mes_periodo");
   		$sql = "SELECT *
                FROM rmmh_admin_dirfuentes DF, rmmh_admin_control C
                WHERE DF.nro_orden = C.nro_orden
                AND C.fk_usuario = $usuario
                AND C.ano_periodo = $ano
                AND C.mes_periodo = $mes ";
   		if (is_numeric($busqueda)){
   			$sql .= "AND C.nro_orden = $busqueda ";
   		}
   		else{
   			$sql .= "AND DF.idproraz LIKE '%$busqueda%'";
   		}
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
   	
   	
   	//Realiza la busqueda dentro del directorio de fuentes asignado a un usuario particular
   	function buscarDirectorioUsuarioPagina($desde, $usuario, $busqueda){
   		$this->load->library("session");
   		$this->load->library("paginador2");
   		$this->load->model("sede");
   		$this->load->model("divipola");
   		$ano = $this->session->userdata("ano_periodo");
   		$mes = $this->session->userdata("mes_periodo");
   		$hasta = $this->paginador2->getRegsPagina();
   		$directorio = array();
   		$sql = "SELECT C.nro_orden, DF.uni_local, DF.fk_ciiu, DF.idproraz, DF.idnomcom, DF.fk_depto, DF.fk_mpio, DF.fk_sede
			    FROM rmmh_admin_dirfuentes DF, rmmh_admin_control C
				WHERE DF.nro_orden = C.nro_orden 
				AND C.fk_usuario = $usuario
				AND ano_periodo = $ano
				AND mes_periodo = $mes ";
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
	
   	
   	function buscarDirectorioPagina($desde, $busqueda){
   		$this->load->library("session");
   		$this->load->library("paginador2");
		$this->load->model("sede");
   		$this->load->model("divipola");
   		$ano = $this->session->userdata("ano_periodo");
   		$mes = $this->session->userdata("mes_periodo");
   		$hasta = $this->paginador2->getRegsPagina();
   		$directorio = array();
   		$sql = "SELECT C.nro_orden, DF.uni_local, DF.fk_ciiu, DF.idproraz, DF.idnomcom, DF.fk_depto, DF.fk_mpio, DF.fk_sede
			    FROM rmmh_admin_dirfuentes DF, rmmh_admin_control C
				WHERE DF.nro_orden = C.nro_orden ";
   		if (is_numeric($busqueda)){
   			$sql.= " AND C.nro_orden = $busqueda ";
   		}
   		else{
   			$sql.= " AND DF.idproraz LIKE '%$busqueda%'";
   		}
   		$sql.= "AND C.ano_periodo = $ano
   		       AND C.mes_periodo = $mes ";		   		   		
   		//validar si desde es negativo, entonces desde cero
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
   	
   	
   	//Obtiene el directorio base para mostrar el detalle en el reporte operativo
   	function obtenerDirectorioBase($usuario, $sede, $subsede){
   		$this->load->library("session");
   		$this->load->model("divipola");
   		$this->load->model("sede");
   		$ano = $this->session->userdata("ano_periodo");
   		$mes = $this->session->userdata("mes_periodo");
   		$directorio = array();
   		$sql = "SELECT *
				FROM rmmh_admin_dirfuentes DF, rmmh_admin_control C
				WHERE DF.nro_orden = C.nro_orden
				AND C.fk_novedad = 5 ";
   		if ($usuario!=0){
			$sql.= "AND C.fk_usuario = $usuario ";
		}
		if ($sede!=0){
			$sql.= "AND C.fk_sede = $sede ";
		}
		if ($subsede!=0){ 
			$sql.= "AND C.fk_subsede = $subsede ";
		}
		$sql.= "AND C.ano_periodo = $ano 
		        AND C.mes_periodo = $mes";
		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
			$i=0;
			foreach($query->result() as $row){
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
   	
   	//Obtiene el directorio de nuevas fuentes para mostrar el detalle en el reporte operativo
   	function obtenerDirectorioNuevos($usuario, $sede, $subsede){
   		$this->load->library("session");
   		$this->load->model("divipola");
   		$this->load->model("sede");
   		$ano = $this->session->userdata("ano_periodo");
   		$mes = $this->session->userdata("mes_periodo");
   		$sql = "SELECT *
                FROM rmmh_admin_dirfuentes DF, rmmh_admin_control C
                WHERE DF.nro_orden = C.nro_orden               
                AND C.fk_novedad = 9 ";
   		if ($usuario!=0){
                $sql.= "AND C.fk_usuario = $usuario ";		
   		}
   		if ($sede!=0){
			$sql.= "AND C.fk_sede = $sede ";
		}
		if ($subsede!=0){ 
			$sql.= "AND C.fk_subsede = $subsede ";
		}
   		$sql.= "AND C.ano_periodo = $ano
   		        AND C.mes_periodo = $mes";   		
   		$query = $this->db->query($sql);
   		if ($query->num_rows()>0){
   			$i=0;
   			foreach($query->result() as $row){
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
   	
   	//Obtiene el directorio del total a recolectar para mostrar el detalle en el reporte operativo
   	function obtenerDirectorioTotalRecolectar($usuario, $sede, $subsede){
   		$this->load->library("session");
   		$ano = $this->session->userdata("ano_periodo");
   		$mes = $this->session->userdata("mes_periodo");
   		$this->load->model("divipola");
   		$this->load->model("sede");
   		$sql = "SELECT *
				FROM rmmh_admin_dirfuentes DF, rmmh_admin_control C
				WHERE DF.nro_orden = C.nro_orden
				AND C.fk_novedad IN (5,9) ";
   		if ($usuario!=0){
				$sql.= "AND C.fk_usuario = $usuario ";
		}
   		if ($sede!=0){
			$sql.= "AND C.fk_sede = $sede ";
		}
		if ($subsede!=0){ 
			$sql.= "AND C.fk_subsede = $subsede ";
		}		
		$sql.= "AND C.ano_periodo = $ano 
		        AND C.mes_periodo = $mes";
		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
   			$i=0;
   			foreach($query->result() as $row){
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
   	
   	//Obtiene el directorio del total de fuentes sin distribuir para el detalle del reporte operativo
   	function obtenerDirectorioSinDistribuir($usuario, $sede, $subsede){
		$this->load->library("session");
   		$this->load->model("divipola");
		$this->load->model("sede");
		$ano = $this->session->userdata("ano_periodo");
		$mes = $this->session->userdata("mes_periodo");
		$sql = "SELECT *
				FROM rmmh_admin_dirfuentes DF, rmmh_admin_control C
				WHERE DF.nro_orden = C.nro_orden				
				AND C.fk_estado = 0 ";
		if ($usuario!=0){
			$sql.= "AND C.fk_usuario = $usuario ";
		}
		if ($sede!=0){
			$sql.= "AND C.fk_sede = $sede ";
		}
		if ($subsede!=0){ 
			$sql.= "AND C.fk_subsede = $subsede ";
		}	
		$sql.= "AND ano_periodo = $ano 
		        AND mes_periodo = $mes";
		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
   			$i=0;
   			foreach($query->result() as $row){
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
   	
   	//Obtiene el directorio del total de fuentes Distribuidos para el detalle del reporte operativo
   	function obtenerDirectorioDistribuir($usuario, $sede, $subsede){
   		$this->load->library("session");
   		$this->load->model("divipola");
   		$this->load->model("sede");
   		$ano = $this->session->userdata("ano_periodo");
   		$mes = $this->session->userdata("mes_periodo");
   		$sql = "SELECT *
				FROM rmmh_admin_dirfuentes DF, rmmh_admin_control C
				WHERE DF.nro_orden = C.nro_orden				
				AND C.fk_estado = 1 ";
   		if ($usuario!=0){
			$sql.= "AND C.fk_usuario = $usuario ";
		}
		if ($sede!=0){
			$sql.= "AND C.fk_sede = $sede ";
		}
		if ($subsede!=0){ 
			$sql.= "AND C.fk_subsede = $subsede ";
		}	
		$sql.= "AND C.ano_usuario = $ano
		        AND C.mes_usuario = $mes";
		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
   			$i=0;
   			foreach($query->result() as $row){
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
   	
   	//Obtiene el directorio del total de fuentes en digitacion para el detalle del reporte operativo
   	function obtenerDirectorioEnDigitacion($usuario, $sede, $subsede){
   		$this->load->library("session");
   		$this->load->model("divipola");
   		$this->load->model("sede");
   		$ano = $this->session->userdata("ano_periodo");
   		$mes = $this->session->userdata("mes_periodo");
   		$sql = "SELECT *
				FROM rmmh_admin_dirfuentes DF, rmmh_admin_control C
				WHERE DF.nro_orden = C.nro_orden
				AND C.fk_estado = 2 ";
   		if ($usuario!=0){
				$sql .= "AND C.fk_usuario = $usuario ";
		}
		if ($sede!=0){
			$sql.= "AND C.fk_sede = $sede ";
		}
		if ($subsede!=0){ 
			$sql.= "AND C.fk_subsede = $subsede ";
		}	
		$sql.= "AND C.ano_periodo = $ano
		        AND C.mes_periodo = $mes";
		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
   			$i=0;
   			foreach($query->result() as $row){
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
   	
   	//Obtiene el directorio del total de fuentes digitados para el detalle del reporte operativo
   	function obtenerDirectorioDigitados($usuario, $sede, $subsede){
   		$this->load->library("session");
   		$this->load->model("divipola");
   		$this->load->model("sede");
   		$ano = $this->session->userdata("ano_periodo");
   		$mes = $this->session->userdata("mes_periodo");
   		$sql = "SELECT *
				FROM rmmh_admin_dirfuentes DF, rmmh_admin_control C
				WHERE DF.nro_orden = C.nro_orden				
				AND C.fk_estado = 3 ";
   		if ($usuario!=0){
			$sql.= "AND fk_usuario = $usuario ";
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
   	
   	//Obtiene el directorio del total de fuentes en analisis-verificacion para el detalle del reporte operativo
   	function obtenerDirectorioAnalisisVerificacion($usuario, $sede, $subsede){
   		$this->load->library("session");
   		$this->load->model("divipola");
   		$this->load->model("sede");
   		$ano = $this->session->userdata("ano_periodo");
   		$mes = $this->session->userdata("mes_periodo");
   		$sql = "SELECT *
			    FROM rmmh_admin_dirfuentes DF, rmmh_admin_control C
			    WHERE DF.nro_orden = C.nro_orden				
				AND C.fk_novedad = 99
				AND C.fk_estado = 4 ";
   		if ($usuario!=0){
			$sql.= "AND C.fk_usuario = $usuario ";
		}
		if ($sede!=0){
			$sql.= "AND C.fk_sede = $sede ";
		}
		if ($subsede!=0){ 
			$sql.= "AND C.fk_subsede = $subsede ";
		}	
		$sql.= "AND C.ano_periodo = $ano 
		        AND C.mes_periodo = $mes";
		$query = $this->db->query($sql);
		if ($query->num_rows()>0){
   			$i=0;
   			foreach($query->result() as $row){
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
   	
   	//Obtiene el directorio del total de fuentes en Verificado para el detalle del reporte operativo
   	function obtenerDirectorioVerificados($usuario, $sede, $subsede){
   		$this->load->library("session");
   		$this->load->model("divipola");
   		$this->load->model("sede");
   		$ano = $this->session->userdata("ano_periodo");
   		$mes = $this->session->userdata("mes_periodo");
   		$sql = "SELECT *
                FROM rmmh_admin_dirfuentes DF, rmmh_admin_control C
                WHERE DF.nro_orden = C.nro_orden                
                AND C.fk_novedad = 99
                AND C.fk_estado = 5 ";
   		if ($usuario!=0){
        	$sql.= "AND C.fk_usuario = $usuario ";
        }
        if ($sede!=0){
			$sql.= "AND C.fk_sede = $sede ";
		}
		if ($subsede!=0){ 
			$sql.= "AND C.fk_subsede = $subsede ";
		}	
        $sql.= "AND C.ano_usuario = $ano
                AND C.mes_usuario = $mes";
        $query = $this->db->query($sql);
		if ($query->num_rows()>0){
   			$i=0;
   			foreach($query->result() as $row){
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
   	
   	//Obtiene el directorio del total de fuentes con Novedades para el detalle del reporte operativo
   	function obtenerDirectorioNovedades($usuario, $sede, $subsede){
   		$this->load->library("session");
   		$this->load->model("divipola");
   		$this->load->model("sede");
   		$ano = $this->session->userdata("ano_periodo");
   		$mes = $this->session->userdata("mes_periodo");
   		$sql = "SELECT *
				FROM rmmh_admin_dirfuentes DF, rmmh_admin_control C
				WHERE DF.nro_orden = C.nro_orden				
				AND C.fk_novedad NOT IN (5,9,99)
				AND C.fk_estado = 5 ";
   		if ($usuario!=0){
			$sql.= "AND C.fk_usuario = $usuario ";
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
   	
   	
   	/***
   	 * DANIEL MAURICIO DIAZ FORERO	
   	 * JUNIO 06 / 2012
   	 * METODOS PARA LA VALIDACION DE LA CARGA AUTOMATICA DEL DIRECTORIO DE FUENTES.
   	 */
   	
   	// 0. Funcion para obtener el numero de fuentes registradas en el directorio. Si el valor es 0, el 
   	// directorio se esta cargando por primera vez, si es mayor que cero, el directorio se esta cargando 
   	// por segunda vez, por lo que las fuentes que entran, entran como fuentes nuevas con la novedad 9.
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
  

}//EOC