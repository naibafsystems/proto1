<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Indicador extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->library("session");        
    }
    
    /**
     * Función para obtener el estado del módulo del indicador de calidad
     * @author Jesús Neira Guio SJNEIRAG
     * @since agosto de 2015
     */
    function obtenerEstado($ano_periodo, $mes_periodo){
    	$estado = array();
    	$sql = "SELECT nom_periodo, estado_indicador
                FROM rmmh_param_periodos
                WHERE ano_periodo = $ano_periodo
                AND mes_periodo = $mes_periodo";
    		$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
      			$estado["nom_periodo"]=$row->nom_periodo;
    			$estado["estado_indicador"]=$row->estado_indicador;
			}   			
   		}
   		else{
   			$estado["nom_periodo"]="0";
    		$estado["estado_indicador"]="0";
   		}    	
    	$this->db->close();
   		return $estado;   		   		
    }
    
    /**
     * Función para obtener la sede y las subsede al cuál está asignado el usuario
     * @author Jesús Neira Guio SJNEIRAG
     * @since agosto de 2015
     */
    function obtenerSede($usuario){
    	$sede = array();
    	$sql = "SELECT a.fk_sede, a.fk_subsede, b.nom_subsede
    	FROM rmmh_admin_usuarios a,
    	rmmh_param_subsedes b
    	WHERE id_usuario = $usuario 
    	AND a.fk_subsede= b.id_subsede ";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
    			$sede["fk_sede"]=$row->fk_sede;
    			$sede["fk_subsede"]=$row->fk_subsede;
    			$sede["nom_subsede"]=$row->nom_subsede;
    		}
    	}
    	else{
    		$sede["fk_sede"]="0";
    		$sede["fk_subsede"]="0";
    		$sede["nom_subsede"]="0";
    	}
    	$this->db->close();
    	return $sede;
    }
    
    /**
     * Función para obtener la subsede 
     * @author Jesús Neira Guio SJNEIRAG
     * @since agosto de 2015
     */
    function obtenerNombreSubsede($subsedeId){
    	$subsede = array();
    	$sql = "SELECT a.fk_sede, a.fk_subsede, b.nom_subsede
    	FROM rmmh_admin_usuarios a,
    	rmmh_param_subsedes b
    	WHERE a.fk_subsede = $subsedeId
    	AND a.fk_subsede= b.id_subsede ";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
    			$subsede["fk_sede"]=$row->fk_sede;
    			$subsede["fk_subsede"]=$row->fk_subsede;
    			$subsede["nom_subsede"]=$row->nom_subsede;
    		}
    	}
    	else{
    		$subsede["fk_sede"]="0";
    		$subsede["fk_subsede"]="0";
    		$subsede["nom_subsede"]="0";
    	}
        $this->db->close();
    	return $subsede;
    }
    
    /**
     * Función para consultar si hay indicadores generados para un periodo.
     * @author Jesús Neira Guio SJNEIRAG
     * @since Agosto de 2015
     */
    function buscarFuentesIndicador($ano_periodo, $mes_periodo, $subsede){
    	$fuentes = array();
    	$sql = "SELECT fts_id, fts_anio, fts_periodo, fts_nro_orden, fts_nro_establecimiento,
    			fts_subsede, fts_inclusion, fts_usuario_critico, fts_usuario_asistente,
    			fts_fec_registro, fts_estado
    	FROM rmmh_admin_fuentes_indicador
    	WHERE fts_anio=$ano_periodo
    	AND fts_periodo = $mes_periodo
    	AND fts_subsede = $subsede
    	AND fts_estado=1";
    	
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		$i=0;
    		foreach ($query->result() as $row){
    			$fuentes[$i]["fts_id"] = $row->fts_id;
    			$fuentes[$i]["fts_anio"] = $row->fts_anio;
    			$fuentes[$i]["fts_periodo"] = $row->fts_periodo;
    			$fuentes[$i]["fts_nro_orden"] = $row->fts_nro_orden;
    			$fuentes[$i]["fts_nro_establecimiento"] = $row->fts_nro_establecimiento;
    			$fuentes[$i]["fts_subsede"] = $row->fts_subsede;
    			$fuentes[$i]["fts_inclusion"] = $row->fts_inclusion;
    			$fuentes[$i]["fts_usuario_critico"] = $row->fts_usuario_critico;
    			$fuentes[$i]["fts_usuario_asistente"] = $row->fts_usuario_asistente;
    			$fuentes[$i]["fts_fec_registro"] = $row->fts_fec_registro;
    			$fuentes[$i]["fts_estado"] = $row->fts_estado;
    		$i++;	
    		}
    	}
    	$this->db->close();
    	return $fuentes;
    }
    
    /**
     * Función para seleccionar las fuentes en estado 5
     * @author SJNEIRAG
     * @since 2015
     */    
    
	function obtenerFuentes($ano_periodo, $mes_periodo, $subsede){
	    $fuentes = array();
	    $sql = "SELECT  a.nro_orden, a.nro_establecimiento, a.fk_subsede,
	   		a.ano_periodo, a.mes_periodo, a.fk_usuariocritica, a.fk_estado, b.nom_usuario, c.nom_estado
	    	FROM rmmh_admin_control a
	    	INNER JOIN rmmh_admin_usuarios b ON b.id_usuario = a.fk_usuariocritica
	    	INNER JOIN rmmh_param_estados c ON c.id_estado = a.fk_estado
	    	WHERE a.fk_usuariocritica<>0
	    	AND a.fk_subsede = $subsede
	           AND a.ano_periodo = $ano_periodo
			AND a.mes_periodo = $mes_periodo
			AND a.fk_novedad = 99 
			AND a.fk_estado=5"; 
	    	$query = $this->db->query($sql);
	    	$fuentes["numero_fuentes"]=$query->num_rows();
	    	$this->db->close();
	   		return $fuentes;   		
	}
	    
	 /**
	  * Función para selccionar aleatoriamente el 10 porciento del total de fuentes en estado 5
	  * @author SJNEIRAG
	  * @since Julio 2015
	  */
    function fuentesCalificar($ano_periodo, $mes_periodo, $subsede, $limit){
    	$calificar = array();
    	$sql = "SELECT  a.nro_orden, a.nro_establecimiento, a.fk_subsede,
    	    a.ano_periodo, a.mes_periodo, a.fk_usuariocritica, fk_usuariologistica, a.fk_estado,
    	    a.inclusion, b.id_usuario, b.nom_usuario, c.nom_estado
    		FROM rmmh_admin_control a
    		INNER JOIN rmmh_admin_usuarios b ON b.id_usuario = a.fk_usuariocritica
    		INNER JOIN rmmh_param_estados c ON c.id_estado = a.fk_estado
    		WHERE a.fk_usuariocritica<>0
    		AND a.fk_subsede = $subsede
            AND a.ano_periodo = $ano_periodo
			AND a.mes_periodo = $mes_periodo
			AND a.fk_novedad = 99 
			AND a.fk_estado=5
    	    ORDER BY RAND() LIMIT ".$limit.""; 
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		$i=0;
    		foreach ($query->result() as $row){
    			$calificar[$i]["nro_orden"] = $row->nro_orden;
    			$calificar[$i]["nro_establecimiento"] = $row->nro_establecimiento;
    			$calificar[$i]["subsede"] = $row->fk_subsede;
    			$calificar[$i]["ano_periodo"] = $row->ano_periodo;
    			$calificar[$i]["mes_periodo"] = $row->mes_periodo;
    			$calificar[$i]["usuariocritica"] = $row->fk_usuariocritica;
    			$calificar[$i]["usuariologistica"] = $row->fk_usuariologistica;
    			$calificar[$i]["estado"] = $row->fk_estado;
    			$calificar[$i]["inclusion"] = $row->inclusion;
    			$calificar[$i]["id_usuario"] = $row->id_usuario;
    			$calificar[$i]["nom_usuario"] = $row->nom_usuario;
    			$calificar[$i]["nom_estado"] = $row->nom_estado;
    		$i++;	
    		}
    	}
    	else{
    		$calificar["nro_orden"] = "0";
    		$calificar["nro_establecimiento"]= "0";
    		$calificar["ano_periodo"]="0";
    		$calificar["mes_periodo"]="0";
    		$calificar["fk_usuariocritica"]="0";
    		$calificar["fk_estado"]="0";
    		$calificar["inclusion"]="0";
    		$calificar["id_usuario"]="0";
    		$calificar["nom_usuario"]="0";
    		$calificar["nom_estado"]="0";
    	}
    	
    	$this->db->close();
   		return $calificar;   		
    }   
    
    /**
     * Función para insertar en la base de datos los establecimientos seleccionados aleatoriamente para el indicador.
     * @author SJNEIRAG
     * @since Julio 2015
     */
    function insertarFuentesCalificar($ano_periodo, $mes_periodo, $nro_orden, $nro_establecimiento, $subsede, $inclusion, $usuariocritico, $usuario, $estado){
    	$data = array('fts_anio' => $ano_periodo, 
    			'fts_periodo' => $mes_periodo,
    			'fts_nro_orden' => $nro_orden, 
    			'fts_nro_establecimiento' => $nro_establecimiento,
    			'fts_subsede' => $subsede, 
    			'fts_inclusion' => $inclusion,
    			'fts_usuario_critico' => $usuariocritico, 
    			'fts_usuario_asistente' => $usuario,
    			'fts_estado' => $estado);
    	$this->db->insert('rmmh_admin_fuentes_indicador', $data);
    	$this->db->close();
    }
    
    /**
     * Función para obtener los criticos asignados a los etablecimientos seleccinados para el indicador.
     * @author SJNEIRAG
     * @since Julio 2015
     */
    function obtenerCriticosCalificar($ano_periodo, $mes_periodo,$subsede){
    	$criticoscalificar = array();
    	$sql = "SELECT count(a.fts_usuario_critico) as fuentes, 
    	a.fts_usuario_critico, a.fts_usuario_asistente, b.nom_usuario as nom_usuario_critico,
    	c.nom_usuario as nom_usuario_asistente
    	FROM rmmh_admin_fuentes_indicador a,
    	rmmh_admin_usuarios b,
    	rmmh_admin_usuarios c
    	WHERE fts_anio = $ano_periodo
    	AND fts_periodo = $mes_periodo
    	AND fts_subsede = $subsede
    	AND a.fts_usuario_critico=b.id_usuario
    	AND a.fts_usuario_asistente=c.id_usuario
    	AND fts_estado=1
    	GROUP BY fts_usuario_critico";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		$i=0;
    		foreach ($query->result() as $row){
    			$criticoscalificar[$i]["fuentes"] = $row->fuentes;
    			$criticoscalificar[$i]["criticos"] = $row->fts_usuario_critico;
    			$criticoscalificar[$i]["asistente"] = $row->fts_usuario_asistente;
    			$criticoscalificar[$i]["nombre"] = $row->nom_usuario_critico;
    			$criticoscalificar[$i]["nombre_asistente"] = $row->nom_usuario_asistente;
    			$i++;
    		}
    	}
    	$this->db->close();
    	return $criticoscalificar;
    }
    
    /**
     * Función para obtener las fuentes para califcar por subsede.
     * @author SJNEIRAG
     * @since Julio 2015
     */
    function obtenerFuentesCalificar($ano_periodo, $mes_periodo,$subsede){
    	$fuentescalificar = array();
    	$sql = "SELECT fts_nro_establecimiento, a.fts_usuario_critico, b.nom_usuario
    	FROM rmmh_admin_fuentes_indicador a,
    	rmmh_admin_usuarios b
    	WHERE fts_anio = $ano_periodo
    	AND fts_periodo = $mes_periodo
    	AND fts_subsede = $subsede
    	AND fts_usuario_critico=id_usuario
    	AND fts_estado=1";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
	    	$i=0;
	    	foreach ($query->result() as $row){
	    		$fuentescalificar[$i]["establecimiento"] = $row->fts_nro_establecimiento;
	    		$fuentescalificar[$i]["criticos"] = $row->fts_usuario_critico;
	    		$fuentescalificar[$i]["nombre"] = $row->nom_usuario;
	    	$i++;
	    	}
    	}
    	$this->db->close();
    	return $fuentescalificar;
    }
    
    /**
     * Función para obtener las fuentes registradas en la base de datos para el indicador.
     * @author SJNEIRAG
     * @since Julio 2015
     */
    
    function obtenerFuentesxCritico($ano_periodo, $mes_periodo, $idcritico, $idestablecimiento){
    	$fuentes = array();
    	$sql = "SELECT a.fts_id, a.fts_nro_orden, a.fts_nro_establecimiento, b.idnomcom,
    			fts_subsede, fts_accion_correctiva, fts_fec_registro_accion 
    	FROM rmmh_admin_fuentes_indicador a,
    	rmmh_admin_establecimientos b
    	WHERE fts_anio = $ano_periodo
    	AND fts_periodo = $mes_periodo ";
    	if($idcritico!=0){
    		$sql.="AND fts_usuario_critico = $idcritico ";
    	}
    	if($idestablecimiento!=0){
    		$sql.="AND a.fts_nro_establecimiento = $idestablecimiento ";
    	}
    	$sql.="AND fts_nro_establecimiento=nro_establecimiento ";
    	$sql.="AND fts_estado=1 ";
    	$sql.="ORDER BY a.fts_id ASC ";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
	    	$i=0;
	    	foreach ($query->result() as $row){
	    		$fuentes[$i]["idfuentes"] = $row->fts_id;
	    		$fuentes[$i]["nro_orden"] = $row->fts_nro_orden;
	    		$fuentes[$i]["nro_establecimiento"] = $row->fts_nro_establecimiento;
	    		$fuentes[$i]["establecimiento"] = $row->idnomcom;
	    		$fuentes[$i]["subsede"] = $row->fts_subsede;
	    		$fuentes[$i]["accionCorrectiva"] = $row->fts_accion_correctiva;
	    		$fuentes[$i]["fechaRegAccion"] = $row->fts_fec_registro_accion;
	    	$i++;
	    	}
    	}
    	else{
	    	$fuentes["idfuentes"] = "0";
	    	$fuentes["nro_orden"]= "0";
    		$fuentes["nro_establecimiento"]="0";
    		$fuentes[$i]["establecimiento"] = "0";
    	}
    	$this->db->close();
        	return $fuentes;
    	}
    	
    	
    /**
     * Función para obtener las variables del indicador de calidad.
     * @author SJNEIRAG
     * @since Julio 2015
     */
	function obtenerVariablesIndicador(){
    	$variables = array();
    	$sql = "SELECT var_cal_id, var_cal_variable,
    		var_cal_peso, var_cal_estado,
    		var_posicion
    		FROM rmmh_admin_var_calidad
    		WHERE
    		var_cal_estado=1 
    		ORDER BY var_posicion ASC ";
       		$query = $this->db->query($sql);
        if ($query->num_rows() > 0){
        	$i=0;
        	foreach ($query->result() as $row){
	   	   		$variables[$i]["idvariable"] = $row->var_cal_id;
	   	   		$variables[$i]["variable"] = $row->var_cal_variable;
	   	   		$variables[$i]["peso"] = $row->var_cal_peso;
	   	   	$i++;
        	}
        }
        else{
        	$variables["idvariable"] = "0";
        	$variables["variable"]= "0";
        	$variables["peso"]="0";
        }
        $this->db->close();
        return $variables;
	}
    	  
	/**
    * Calcula la magnitud del error
    */
    function calcularMagitudError($variacion){
    	if ($variacion>=-20 && $variacion<=20){
       		$magnituderror = 1;
       	}
       	elseif($variacion>=-50 && $variacion<=-20){
       		$magnituderror = 2;
       	}
       	elseif($variacion>=20 && $variacion<=50){
       		$magnituderror = 2;
       	}elseif($variacion<=-0.50){
       		$magnituderror = 3;
       	}elseif($variacion>=0.50){
       		$magnituderror = 3;
       	}else{
       		$magnituderror = 0;
       	}
    	return $magnituderror;
    }
    
    /**
     * Función para insertar en la base de datos la calificación del formulario.
     * @author SJNEIRAG
     * @since Julio 2015
     */
    function insertarIndicador($idvariable, $peso, $magerror, $error, $conforme, $logorcritica, $valorcritica, $idestablecimiento, $idfuente, $estado){
    	$data = array('fts_cal_id' => $idfuente,
    			'var_cal_id' => $idvariable,
    			'cal_peso' => $peso,
    			'cal_magnitud_error' => $magerror,
    			'cal_error' => $error,
    			'cal_conformidad' => $conforme,
    			'cal_logro_critica' => $logorcritica,
    			'cal_valoracion_critica' => $valorcritica,
    			'cal_estado' => $estado);
    	$this->db->insert('rmmh_admin_calidad', $data);
    	$this->db->close();
    }
        
    /**
     * Función para actualizar en la base de datos la calificación del formulario.
     * @author SJNEIRAG
     * @since Julio 2015
     */
    function modificaIndicador($idvariable, $peso, $magerror, $error, $conforme, $logorcritica, $valorcritica, $idestablecimiento, $idfuente, $estado){
    	$data = array('fts_cal_id' => $idfuente,
    			'var_cal_id' => $idvariable,
    			'cal_peso' => $peso,
    			'cal_magnitud_error' => $magerror,
    			'cal_error' => $error,
    			'cal_conformidad' => $conforme,
    			'cal_logro_critica' => $logorcritica,
    			'cal_valoracion_critica' => $valorcritica,
    			'cal_estado' => $estado);
    	$this->db->where("var_cal_id",   $idvariable);
    	$this->db->where("fts_cal_id",$idfuente);
    	$this->db->update('rmmh_admin_calidad', $data);
    	$this->db->close();
    }
    
    /**
     * Función para consultar la calificación de la fuente.
     * @author SJNEIRAG
     * @since Julio 2015
     */
    function buscarFuentesCalificadas($fuente){
    	$fuentecalificada = array();
    	$sql = "SELECT cal_id, fts_cal_id,
    			var_cal_id, cal_peso,
    			cal_magnitud_error,cal_error,
    			cal_conformidad, cal_logro_critica,
    			cal_valoracion_critica, cal_estado
    			FROM rmmh_admin_calidad
    			WHERE
    			fts_cal_id=$fuente
    			AND
    			cal_estado=1
    			ORDER BY cal_id ASC ";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		$i=0;
    		foreach ($query->result() as $row){
    			$fuentecalificada[$i]["calid"] = $row->cal_id;
    			$fuentecalificada[$i]["feentesid"] = $row->fts_cal_id;
    			$fuentecalificada[$i]["variable"] = $row->var_cal_id;
    			$fuentecalificada[$i]["peso"] = $row->cal_peso;
    			$fuentecalificada[$i]["magnituderror"] = $row->cal_magnitud_error;
    			$fuentecalificada[$i]["error"] = $row->cal_error;
    			$fuentecalificada[$i]["conformidad"] = $row->cal_conformidad;
    			$fuentecalificada[$i]["logrocritica"] = $row->cal_logro_critica;
    			$fuentecalificada[$i]["valorcritica"] = $row->cal_valoracion_critica;
    			$fuentecalificada[$i]["estado"] = $row->cal_estado;
    			$i++;
    		}
    	}
    	$this->db->close();
    	return $fuentecalificada;
    }
    
    /**
     * Función para obtener la calificacilón para las fuentes
     * @author SJNEIRAG
     * @since Julio 2015
     */
    function obtenerCalificacionFuente($ano_periodo, $mes_periodo, $idcritico, $idestablecimiento){
    	$calific = array();
    	$sql = "SELECT sum(cal_valoracion_critica) as calificacion
    	FROM rmmh_admin_fuentes_indicador a,
    	rmmh_admin_establecimientos b,
    	rmmh_admin_calidad c
    	WHERE fts_anio = $ano_periodo
    	AND fts_periodo = $mes_periodo 
    	AND fts_id=fts_cal_id ";
    	if($idcritico!=0){
    		$sql.="AND fts_usuario_critico = $idcritico ";
    	}
    	if($idestablecimiento!=0){
    		$sql.="AND a.fts_nro_establecimiento = $idestablecimiento ";
    	}
    	$sql.="AND fts_nro_establecimiento=nro_establecimiento ";
    	$sql.="AND fts_estado=1 ";
    	$sql.="ORDER BY a.fts_id ASC ";
    		$query = $this->db->query($sql);
        if ($query->num_rows() > 0){
        	$i=0;
        	foreach ($query->result() as $row){
        		$calific["calificacion"] = $row->calificacion;
        		$i++;
        	}
        }
        $this->db->close();
        return $calific;
   	}
   	
   	/**
   	 * Función para obtener la calificacilón para las fuentes
   	 * @author SJNEIRAG
   	 * @since Julio 2015
   	 */
   	function obtenerFuentesCalificadas($ano_periodo, $mes_periodo, $idcritico, $subsede){
   		$calificadas = array();
   		$sql = "SELECT count(distinct(fts_cal_id)) as calificadas, fts_usuario_critico
	   	FROM rmmh_admin_fuentes_indicador,
	   	rmmh_admin_calidad
	   	WHERE fts_anio =$ano_periodo
	   	AND fts_periodo = $mes_periodo
	   	AND fts_id=fts_cal_id
	   	AND fts_estado=1 ";
	   	if($idcritico!=0){
   			$sql.="AND fts_usuario_critico = $idcritico ";
   		}
   		if($subsede!=0){
   			$sql.="AND fts_subsede = $subsede ";
   		}
   		$query = $this->db->query($sql);
   		if ($query->num_rows() > 0){
   		$i=0;
   		foreach ($query->result() as $row){
   		$calificadas["calificadas"] = $row->calificadas;
   			$i++;
   		}
   		}
   		$this->db->close();
   	        return $calificadas;
   		}
   		
   	/**
   	 * Función para obtener la calificacilón para las fuentes
   	 * @author SJNEIRAG
   	 * @since Septiembre 2015
   	 */
   	function obtenerPromedioFuentes($ano_periodo, $mes_periodo, $idcritico){
   		$promedio = array();
   		$sql = "SELECT sum(cal_valoracion_critica) as promedio, fts_usuario_critico
   		FROM rmmh_admin_fuentes_indicador,
   		rmmh_admin_calidad
   		WHERE fts_anio =$ano_periodo
   		AND fts_periodo = $mes_periodo
   		AND fts_id=fts_cal_id
   		AND fts_estado=1 ";
   		if($idcritico!=0){
   			$sql.="AND fts_usuario_critico = $idcritico ";
   		}
   		$query = $this->db->query($sql);
   		if ($query->num_rows() > 0){
	  		$i=0;
	   		foreach ($query->result() as $row){
	   			$promedio["promedio"] = $row->promedio;
	   		$i++;
	   		}
   		}else{
   			$promedio["promedio"]=0;
   		}
   		$this->db->close();
   		return $promedio;
   	}
   	
   	/**
   	 * Función para obtener la calificacilón para las fuentes
   	 * @author SJNEIRAG
   	 * @since Septiembre 2015
   	 */
   	function obtenerPromedioSubsede($ano_periodo, $mes_periodo, $subsede){
   		$promedio = array();
   		$sql = "SELECT sum(cal_valoracion_critica) as promedio, fts_subsede
   		FROM rmmh_admin_fuentes_indicador,
   		rmmh_admin_calidad
   		WHERE fts_anio =$ano_periodo
   		AND fts_periodo = $mes_periodo
   		AND fts_id=fts_cal_id
   		AND fts_estado=1 ";
   		if($subsede!=0){
   		$sql.="AND fts_subsede = $subsede ";
   		}
   		$query = $this->db->query($sql);
   		if ($query->num_rows() > 0){
	   		$i=0;
	   		foreach ($query->result() as $row){
	   			$promedio["promedio"] = $row->promedio;
	   		$i++;
	   		}
   		}else{
   			$promedio["promedio"]=0;
   		}
   		$this->db->close();
   		return $promedio;
   	}

   	/**
   	 * Función para obtener la calificacilón para las fuentes
   	 * @author SJNEIRAG
   	 * @since Julio 2015
   	 */
   	function obtenerCalificacionFuentesId($ano_periodo, $mes_periodo, $fuenteIndicador){
   		$calific = array();
    	$sql = "SELECT sum(cal_valoracion_critica) as calificacion
    	FROM rmmh_admin_fuentes_indicador a,
    	rmmh_admin_establecimientos b,
    	rmmh_admin_calidad c
    	WHERE fts_anio = $ano_periodo
    	AND fts_periodo = $mes_periodo 
    	AND fts_id=fts_cal_id ";
    	$sql.="AND c.fts_cal_id = $fuenteIndicador ";
    	$sql.="AND fts_nro_establecimiento=nro_establecimiento ";
    	$sql.="AND fts_estado=1 ";
    	$sql.="ORDER BY a.fts_id ASC ";
    	$query = $this->db->query($sql);
       	if ($query->num_rows() > 0){
       		$i=0;
        	foreach ($query->result() as $row){
        		$calific["calificacion"] = $row->calificacion;
        		$i++;
        	}
       }else{
       	$calific["calificacion"] = 0;
       }
       $this->db->close();
       return $calific;
   	}
	
   	/**
   	 * Función para actualizar el estado del módulo de indicador de calidad
   	 * @author SJNEIRAG
   	 * @since Julio 2015
   	 */
   	function modificaEstadoModuloIndicador($estado, $anio, $mes){
   		$data = array('estado_indicador' => $estado);
   		$this->db->where("ano_periodo",   $anio);
   		$this->db->where("mes_periodo",$mes);
   		$this->db->update('rmmh_param_periodos', $data);
   		$this->db->close();
   	}
   	
   	/**
   	 * Función para obtener la calificación para las fuentes
   	 * @author SJNEIRAG
   	 * @since Julio 2015
   	 */
	function obtenerSubsedes(){
   		$subsedes = array();
   		$sql = "SELECT id_subsede, nom_subsede
   		FROM rmmh_param_subsedes
   		ORDER BY id_subsede ASC";
   		$query = $this->db->query($sql);
   	    if ($query->num_rows() > 0){
   	    	$i=0;
   			foreach ($query->result() as $row){
   				$subsedes[$i]["idsubsede"] = $row->id_subsede;
   				$subsedes[$i]["nomsubsede"] = $row->nom_subsede;
   			$i++;
   			}
   		}
   	$this->db->close();
   	return $subsedes;
   	}
   	
   	/**
   	 * Función para obtener los registros de cierre del indicador
   	 * @author SJNEIRAG
   	 * @since Julio 2015
   	 */
   	function obtenerRegistrosCierre($ano_periodo, $mes_periodo, $subsede){
   		$registroscierre = array();
   		$sql = "SELECT ind_cal_id, ind_cal_anio, ind_cal_periodo, ind_cal_subsede,
   				ind_cal_responsable, nom_usuario, ind_cal_form_aceptados, ind_cal_form_seleccionados,
   				ind_cal_form_calificados, ind_cal_calificacion, ind_cal_fec_registro,
   				ind_cal_cierre, ind_cal_fec_cierre, ind_cal_estado, ind_cal_nivel_calidad,
   				ind_cal_fec_correccion, ind_cal_observacion
   				FROM rmmh_admin_ind_calidad,
   				rmmh_admin_usuarios
   				WHERE
   				ind_cal_responsable=id_usuario
   				AND ind_cal_anio=$ano_periodo
   				AND ind_cal_periodo=$mes_periodo
   				AND ind_cal_subsede=$subsede
   		ORDER BY ind_cal_id ASC";
   		$query = $this->db->query($sql);
   		if ($query->num_rows() > 0){
   			$i=0;
   			foreach ($query->result() as $row){
   				$registroscierre[$i]["ind_cal_id"] = $row->ind_cal_id;
   				$registroscierre[$i]["anio"] = $row->ind_cal_anio;
   				$registroscierre[$i]["periodo"] = $row->ind_cal_periodo;
   				$registroscierre[$i]["subsede"] = $row->ind_cal_subsede;
   				$registroscierre[$i]["responsable"] = $row->ind_cal_responsable;
   				$registroscierre[$i]["nomResponsable"] = $row->nom_usuario;
   				$registroscierre[$i]["aceptados"] = $row->ind_cal_form_aceptados;
   				$registroscierre[$i]["seleccionados"] = $row->ind_cal_form_seleccionados;
   				$registroscierre[$i]["calificados"] = $row->ind_cal_form_calificados;
   				$registroscierre[$i]["calificacion"] = $row->ind_cal_calificacion;
   				$registroscierre[$i]["fecRegistro"] = $row->ind_cal_fec_registro;
   				$registroscierre[$i]["cierre"] = $row->ind_cal_cierre;
   				$registroscierre[$i]["fecCierre"] = $row->ind_cal_fec_cierre;
   				$registroscierre[$i]["estado"] = $row->ind_cal_estado;
   				$registroscierre[$i]["nivelCalidad"] = $row->ind_cal_nivel_calidad;
   				$registroscierre[$i]["fecCorreccion"] = $row->ind_cal_fec_correccion;
   				$registroscierre[$i]["observacion"] = $row->ind_cal_observacion;
   				$i++;
   			}
   		}
   		$this->db->close();
   		return $registroscierre;
   	}
   	
   	/**
   	 * Función para registrar el cierre del indicador de calidad
   	 * @author SJNEIRAG
   	 * @since Julio 2015
   	 */
   	function insertarCierreIndicador($ano_periodo, $mes_periodo, $subsede, $usuario, $fuentesAceptadas, $fuentesSeleccionadas, $fuentesCalificadas, $promedio, $cierre, $fechaCierre, $estado, $nivel){
   		$data = array('ind_cal_anio' => $ano_periodo,
   				'ind_cal_periodo' => $mes_periodo,
   				'ind_cal_subsede' => $subsede,
   				'ind_cal_responsable' => $usuario,
   				'ind_cal_form_aceptados' => $fuentesAceptadas,
   				'ind_cal_form_seleccionados' => $fuentesSeleccionadas,
   				'ind_cal_form_calificados' => $fuentesCalificadas,
   				'ind_cal_calificacion' => $promedio,
   				'ind_cal_cierre' => $cierre,
   				'ind_cal_fec_cierre' => $fechaCierre,
   				'ind_cal_estado' => $estado,
   				'ind_cal_nivel_calidad' => $nivel);
   		$this->db->insert('rmmh_admin_ind_calidad', $data);
   		$this->db->close();
   	}
   	
	/**
   	 * Función para calcular el nivel del indicador de calidad
   	 * @author SJNEIRAG
   	 * @since Julio 2015
   	 */
    function calcularNivelCalidad($promedioSede){
    	if($promedioSede==100){
    		$nivel="Excelente calidad";
    	}elseif($promedioSede > 98 && $promedioSede <= 99.99){
    		$nivel="Buena calidad";
    	}elseif($promedioSede > 92 && $promedioSede <= 97.99){
    		$nivel="Calidad aceptable";
    	}elseif($promedioSede >= 85 && $promedioSede <= 91.99){
    		$nivel="Calidad regular";
    	}elseif($promedioSede < 85){
    		$nivel="Mala calidad";
    	}
    	return $nivel;
    }
    
    
    /**
     * Función para calcular el nivel del indicador de calidad
     * @author SJNEIRAG
     * @since Julio 2015
     */
    function insertaAccionCorrectiva($accionCorrectiva, $fecAccioncorrectiva, $idFuentesCalificar){
    	$data = array('fts_accion_correctiva' => $accionCorrectiva,
    				'fts_fec_registro_accion' => $fecAccioncorrectiva);
    	$this->db->where("fts_id",   $idFuentesCalificar);
    	$this->db->update('rmmh_admin_fuentes_indicador', $data);
    	$this->db->close();
    }
    
    /**
     * Función para obtener los accuiones correctivas
     * @author SJNEIRAG
     * @since Julio 2015
     */
    function obtenerAccionesCorrectivas($ano_periodo, $mes_periodo, $subsede){
    	$accionCorrectiva = array();
    	$sql = "SELECT fts_nro_orden, fts_nro_establecimiento, 
    	fts_accion_correctiva, fts_fec_registro_accion
    	FROM rmmh_admin_fuentes_indicador
    	WHERE
    	fts_anio=$ano_periodo
    	AND fts_periodo=$mes_periodo
    	AND fts_subsede=$subsede
    	AND  fts_accion_correctiva != 'null'
    	ORDER BY fts_fec_registro_accion ASC";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		$i=0;
	    	foreach ($query->result() as $row){
	    		$accionCorrectiva[$i]["orden"] = $row->fts_nro_orden;
	    		$accionCorrectiva[$i]["establecimiento"] = $row->fts_nro_establecimiento;
	    		$accionCorrectiva[$i]["accionCorrectiva"] = $row->fts_accion_correctiva;
	    		$accionCorrectiva[$i]["fecRegistro"] = $row->fts_fec_registro_accion;
	    	$i++;
	    	}
    	}
    	$this->db->close();
    	return $accionCorrectiva;
    }
}//EOC  
