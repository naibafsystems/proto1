<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Envioform extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->library("session"); 
        $this->load->library("general");       
    }
    
    //DMDIAZF - Agosto 13, 2012
	//Valida si todos los capitulos ya han sido diligenciados. (Si todos los capitulos tienen estado 2 en la tabla de control).
    function validarEnvioFormulario($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$result = false;
    	$estados = array();
    	$sql = "SELECT modulo1, modulo2, modulo3, modulo4 
                FROM rmmh_admin_control
                WHERE nro_orden = $nro_orden
                AND nro_establecimiento = $nro_establecimiento
                AND ano_periodo = $ano_periodo
                AND mes_periodo = $mes_periodo";    	
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
      			$estados[0] = "2";
    			$estados[1] = $row->modulo1;  //Estado del modulo 1 del formulario (Identificacion y datos generales)
    			$estados[2] = $row->modulo2;  //Estado del modulo 2 del formulario (Personal Ocupado Promedio y Salarios causados en el mes)
    			$estados[3] = $row->modulo3;  //Estado del modulo 3 del formulario (Ingresos Netos Operacionales causados en el mes)
    			$estados[4] = $row->modulo4;  //Estado del modulo 4 del formulario (Caracteristicas de los hoteles)    			
    		}
    		$this->db->close();
   			
    		//Verificar que todos los estados estén en estado diligenciado (2 - Diligenciado), de lo contrario no se puede
    		//mostrar la pestaña del envio del formulario.
    		for ($i=0; $i<count($estados);$i++){
    			if ($estados[$i]==2){
    				$result = true; //Se genera la pestaña de envio del formulario.
    			}
    			else{
    				$result = false;
    				break;
    			}
    		}
    	}
    	return $result;
    }
    
    //DMDIAZF - Agosto 14, 2012
    //Se obtienen todos los datos del envio del formulario
	function obtenerModulo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$envio = array();
    	$sql = "SELECT C.envio, EF.observaciones, EF.dmpio, EF.fedili, EF.repleg, EF.responde, EF.respoca, EF.teler, EF.emailr
			    FROM rmmh_form_envioform EF, rmmh_admin_control C
				WHERE EF.nro_orden = C.nro_orden
			    AND EF.nro_establecimiento = C.nro_establecimiento
				AND EF.ano_periodo = C.ano_periodo
				AND EF.mes_periodo = C.mes_periodo
				AND C.nro_orden = $nro_orden
				AND C.nro_establecimiento = $nro_establecimiento
				AND C.ano_periodo = $ano_periodo
				AND C.mes_periodo = $mes_periodo";    	    	
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
      			$envio["op"] = "update";
    			$envio["imagen"] = $row->envio;
    			$envio["observaciones"] = utf8_decode($row->observaciones);
    			$envio["dmpio"] = utf8_decode($row->dmpio);
    			$envio["fedili"] = $this->general->formatoFecha($row->fedili,'-'); 
    			$envio["repleg"] = utf8_decode($row->repleg);
				$envio["responde"] = utf8_decode($row->responde);
				$envio["respoca"] = utf8_decode($row->respoca);	    			      		
				$envio["teler"] = $row->teler;
				$envio["emailr"] = $row->emailr;
    		}   			
   		}
   		else{	$envio["op"] = "insert";
    			$envio["imagen"] = "0";
    			$envio["observaciones"] = "";
    			$envio["dmpio"] = "";
    			$envio["fedili"] = "";
    			$envio["repleg"] = "";
				$envio["responde"] = "";
				$envio["respoca"] = "";	    			      		
				$envio["teler"] = "";
				$envio["emailr"] = "";
   		}    	
    	$this->db->close();
   		return $envio;
    }
    
    function actualizarModulo($observaciones, $dmpio, $fedili, $repleg, $responde, $respoca, $teler, $emailr, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$data = array('observaciones' => $observaciones, 
    	              'dmpio' => $dmpio, 
    	              'fedili' => date("Y-m-d h:i:s"), 
    	              'repleg' => $repleg, 
    	              'responde' => $responde, 
    	              'respoca' => $respoca, 
    	              'teler' => $teler, 
    	              'emailr' => $emailr);
    	$this->db->where("nro_orden",   $nro_orden);
		$this->db->where("nro_establecimiento",$nro_establecimiento);
		$this->db->where("ano_periodo", $ano_periodo);
		$this->db->where("mes_periodo", $mes_periodo);
    	$this->db->update('rmmh_form_envioform', $data);
		$this->db->close();
    }
    
    function insertarModulo($observaciones, $dmpio, $fedili, $repleg, $responde, $respoca, $teler, $emailr, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$data = array('observaciones' => $observaciones, 
    	              'dmpio' => $dmpio, 
    	              'fedili' => date("Y-m-d h:i:s"), 
    	              'repleg' => $repleg, 
    	              'responde' => $responde, 
    	              'respoca' => $respoca, 
    	              'teler' => $teler, 
    	              'emailr' => $emailr, 
    	              'nro_orden' => $nro_orden, 
    	              'nro_establecimiento' => $nro_establecimiento, 
    	              'ano_periodo' => $ano_periodo, 
    	              'mes_periodo' => $mes_periodo);
    	$this->db->insert('rmmh_form_envioform', $data);
		$this->db->close();	
    }
    
    //Funcion para obtener los datos del paz y  salvo de un usuario
    function datosPazYSalvo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$this->load->model("divipola");
    	$this->load->model("periodo");
    	$pyz = array();
    	$sql = "SELECT C.nro_orden, C.nro_establecimiento, C.ano_periodo, C.mes_periodo, EM.idproraz, ES.idnomcom, EM.idnit, ES.iddirecc, ES.fk_depto, ES.fk_mpio
                FROM rmmh_admin_control C, rmmh_admin_empresas EM, rmmh_admin_establecimientos ES
                WHERE C.nro_orden = EM.nro_orden
                AND C.nro_orden = ES.nro_orden
                AND C.nro_establecimiento = ES.nro_establecimiento
                AND C.nro_orden = $nro_orden
                AND C.nro_establecimiento = $nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
      			$pyz["nro_orden"] = $nro_orden;
      			$pyz["nro_establecimiento"] = $nro_establecimiento;
    			$pyz["idproraz"] = $row->idproraz;
    			$pyz["idnomcom"] = $row->idnomcom;
    			$pyz["num_identificacion"] = $row->idnit;
    			$pyz["iddirecc"] = $row->iddirecc;
    			$pyz["depto"] = $this->divipola->nombreDepartamento($row->fk_depto);
    			$pyz["mpio"] =  $this->divipola->nombreMunicipio($row->fk_mpio);
    			$pyz["periodo"] = $this->periodo->obtenerNombrePeriodo($row->ano_periodo, $row->mes_periodo);
    		}   			
   		}
   		$this->db->close();
   		return $pyz;
    }
    
	function descargaPlanosModulo($ano_periodo, $mes_periodo){
    	$envio = array();
    	/* SE CAMBIA ESTA CONSULTA PARA HACER QUE EL ESTADO DE LA NOVEDAD DEL CAPITULO COINCIDA CON LA QUE ESTÁ REPORTADA EN EL HISTORICO DE NOVEDADES
    	$sql = "SELECT C.nro_orden, C.nro_establecimiento, C.ano_periodo, C.mes_periodo,
    	               IFNULL(observaciones,'') AS observaciones,
                       IFNULL(dmpio,'') AS dmpio,
                       IFNULL(fedili,'0000-00-00') AS fedili,
                       IFNULL(repleg,'') AS repleg,
                       IFNULL(responde,'') AS responde,
                       IFNULL(respoca,'') AS respoca,
                       IFNULL(teler,'') AS teler,
                       IFNULL(emailr,'') AS emailr,
                        C.fk_novedad, C.fk_estado
                FROM rmmh_admin_control C
                LEFT JOIN rmmh_form_envioform EF ON (C.nro_orden = EF.nro_orden AND C.nro_establecimiento = EF.nro_establecimiento AND C.ano_periodo = EF.ano_periodo AND C.mes_periodo = EF.mes_periodo)
                WHERE C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo
                ORDER BY C.nro_establecimiento ASC"; */
    	$sql = "SELECT C.nro_orden, C.nro_establecimiento, C.ano_periodo, C.mes_periodo,
    	               IFNULL(observaciones,'') AS observaciones,
                       IFNULL(dmpio,'') AS dmpio,
                       IFNULL(fedili,'0000-00-00') AS fedili,
                       IFNULL(repleg,'') AS repleg,
                       IFNULL(responde,'') AS responde,
                       IFNULL(respoca,'') AS respoca,
                       IFNULL(teler,'') AS teler,
                       IFNULL(emailr,'') AS emailr,
                       IFNULL(HN.fk_novedad,C.fk_novedad) AS fk_novedad, C.fk_estado
                FROM rmmh_admin_control C
                LEFT JOIN rmmh_admin_histnovedades HN ON (C.nro_orden = HN.nro_orden
                                                          AND C.nro_establecimiento = HN.nro_establecimiento
                                                          AND C.ano_periodo = HN.ano_periodo
                                                          AND C.mes_periodo = HN.mes_periodo)
                LEFT JOIN rmmh_form_envioform EF ON (C.nro_orden = EF.nro_orden
                                                     AND C.nro_establecimiento = EF.nro_establecimiento
                                                     AND C.ano_periodo = EF.ano_periodo
                                                     AND C.mes_periodo = EF.mes_periodo)
                WHERE C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo
                GROUP BY C.nro_orden, C.nro_establecimiento, C.ano_periodo, C.mes_periodo
                ORDER BY C.nro_establecimiento ASC;";
    	$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
    		$i = 0;
    		foreach ($query->result() as $row){
      			$envio[$i]["nro_orden"] = $row->nro_orden;
      			$envio[$i]["nro_establecimiento"] = $row->nro_establecimiento;
      			$envio[$i]["ano_periodo"] = $row->ano_periodo;
      			$envio[$i]["mes_periodo"] = $row->mes_periodo;
    			$envio[$i]["observaciones"] = $row->observaciones;
      			$envio[$i]["dmpio"] = $row->dmpio;
      			$envio[$i]["fedili"] = $row->fedili;
      			$envio[$i]["repleg"] = $row->repleg;
      			$envio[$i]["responde"] = $row->responde;
      			$envio[$i]["respoca"] = $row->respoca;
      			$envio[$i]["teler"] = $row->teler;
      			$envio[$i]["emailr"] = $row->emailr;      			
      			$envio[$i]["fk_novedad"] = $row->fk_novedad;
      			$envio[$i]["fk_estado"] = $row->fk_estado;
      			$envio[$i]["estado"] = $this->novedad->nombreEstadoFormulario($row->fk_novedad, $row->fk_estado);
      			$i++;
    		}
    	}
    	$this->db->close();
   		return $envio;
    }
    /**
     *  1) Obtiene los valores actuales para la ficha de analisis
     */
    function obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$valor = 0;
    	$sql = "SELECT $campo
    	FROM $tabla
    	WHERE nro_orden = $nro_orden
    	AND nro_establecimiento = $nro_establecimiento
    	AND ano_periodo = $ano_periodo
    	AND mes_periodo = $mes_periodo";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
    			$valor = $row->$campo;
    		}
    	}
    	$this->db->close();
    	return $valor;
    }
    
    /**
     * 1A) Obtiene los valores actuales para la ficha de analisis (Cuando se producen cruces entre tablas)
     */
    function obtenerValorActualMulti($tabla1, $tabla2, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$valor = 0;
    	$sql = "SELECT $campo
    	FROM $tabla1, $tabla2
    	WHERE $tabla1.nro_orden = $tabla2.nro_orden
    	AND $tabla1.nro_establecimiento = $tabla2.nro_establecimiento
    	AND $tabla1.ano_periodo = $tabla2.ano_periodo
    	AND $tabla1.mes_periodo = $tabla2.mes_periodo
    	AND $tabla1.nro_orden = $nro_orden
    	AND $tabla1.nro_establecimiento = $nro_establecimiento
    	AND $tabla1.ano_periodo = $ano_periodo
    	AND $tabla1.mes_periodo = $mes_periodo";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
    			$valor = $row->$campo;
    		}
    	}
    	$this->db->close();
    }
    
    //Convierte los errores en una cadena separada por comas para ser enviada por post desde un campo oculto del formulario
    //de la ficha de analisis.
    function stringErrores($errores){
    	$string = "";
    	$cadena = "";
    	for ($i=0; $i<count($errores); $i++){
    		$string .= $errores[$i].",";
    	}
    	$cadena = substr($string,0,strlen($string)-1);
    
    	return $cadena;
    }
    
    function obtenerPeriodoAnterior($ano_periodo, $mes_periodo){
    	$data = array();
    	if ($mes_periodo>1){
    		$data["ano"] = $ano_periodo;
    		$data["mes"] = $mes_periodo - 1;
    	}
    	else{
    		$data["ano"] = $ano_periodo - 1;
    		$data["mes"] = 12;
    	}
    	return $data;
    }
    
    function obtenerPeriodoAnual($ano_periodo, $mes_periodo){
    	$data = array();
    	$data["ano"] = $ano_periodo - 1;
    	$data["mes"] = $mes_periodo;
    	return $data;
    }
    
    /**
     * 2) Obtiene los valores para el mes anterior en la ficha de analisis
     */
    function obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$antes = $this->obtenerPeriodoAnterior($ano_periodo, $mes_periodo);
    	$ano = $antes["ano"];
    	$mes = $antes["mes"];
    	$valor = 0;
    	$sql = "SELECT $campo
    	FROM $tabla
    	WHERE nro_orden = $nro_orden
    	AND nro_establecimiento = $nro_establecimiento
    	AND ano_periodo = $ano
    	AND mes_periodo = $mes";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
    			$valor = $row->$campo;
    		}
    	}
    	$this->db->close();
    	return $valor;
    }
    
    /**
     * 2A) Obtiene los valores para el mes anterior en la ficha de analisis (Cuando se producen cruces entre tablas)
     */
    function obtenerValorAnteriorMulti($tabla1, $tabla2, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$antes = $this->obtenerPeriodoAnterior($ano_periodo, $mes_periodo);
    	$ano = $antes["ano"];
    	$mes = $antes["mes"];
    	$valor = 0;
    	$sql = "SELECT $campo
    	FROM $tabla1, $tabla2
    	WHERE $tabla1.nro_orden = $tabla2.nro_orden
    	AND $tabla1.nro_establecimiento = $tabla2.nro_establecimiento
    	AND $tabla1.ano_periodo = $tabla2.ano_periodo
    	AND $tabla1.mes_periodo = $tabla2.mes_periodo
    	AND $tabla1.nro_orden = $nro_orden
    	AND $tabla1.nro_establecimiento = $nro_establecimiento
    	AND $tabla1.ano_periodo = $ano
    	AND $tabla1.mes_periodo = $mes";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
    			$valor = $row->$campo;
    		}
    	}
    	$this->db->close();
    	return $valor;
    }
    
    /**
     * 3 Obtiene los valores anuales (año anterior - mismo mes) para la ficha de analisis
     */
    function obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$antes = $this->obtenerPeriodoAnual($ano_periodo, $mes_periodo);
    	$ano = $antes["ano"];
    	$mes = $antes["mes"];
    	$valor = 0;
    	$sql = "SELECT $campo
    	FROM $tabla
    	WHERE nro_orden = $nro_orden
    	AND nro_establecimiento = $nro_establecimiento
    	AND ano_periodo = $ano
    	AND mes_periodo = $mes";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
    			$valor = $row->$campo;
    		}
    	}
    	$this->db->close();
    	return $valor;
    }
    
    /**
     * 3A Obtiene los valores anuales del año anterior en la ficha de analisis (Cuando se producen cruces entre tablas)
     */
    function obtenerValorAnualMulti($tabla1, $tabla2, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$antes = $this->obtenerPeriodoAnual($ano_periodo, $mes_periodo);
    	$ano = $antes["ano"];
    	$mes = $antes["mes"];
    	$valor = 0;
    	$sql = "SELECT $campo
    	FROM $tabla1, $tabla2
    	WHERE $tabla1.nro_orden = $tabla2.nro_orden
    	AND $tabla1.nro_establecimiento = $tabla2.nro_establecimiento
    	AND $tabla1.ano_periodo = $tabla2.ano_periodo
    	AND $tabla1.mes_periodo = $tabla2.mes_periodo
    	AND $tabla1.nro_orden = $nro_orden
    	AND $tabla1.nro_establecimiento = $nro_establecimiento
    	AND $tabla1.ano_periodo = $ano
    	AND $tabla1.mes_periodo = $mes";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
    			$valor = $row->$campo;
    		}
    	}
    	$this->db->close();
    	return $valor;
    }
    
    
    /**
     * 4 Calcula la variacion Mensual en la ficha de analisis
     */
    function calcularVariacionMensual($actual, $anterior){
    	if ($anterior!=0){
    		//$varmensual = abs((($actual/$anterior)-1)*100);
    		$varmensual = (($actual/$anterior)-1)*100;
    	}
    	else{
    		$varmensual = 0;
    	}
    	return $varmensual;
    }
    
    /**
     * 5 Calcula la variacion Anual en la ficha de analisis
     */
    function calcularVariacionAnual($actual, $anual){
    	if ($anual!=0){
    		//$varanual = abs((($actual/$anual)-1)*100);
    		$varanual = (($actual/$anual)-1)*100;
    	}
    	else{
    		$varanual = 0;
    	}
    	return $varanual;
    }
    
    /**
     * 6 Compara si un valor es mayor que otro en busca de errores de validacion del formulario (Errores en la ficha de analisis)
     */
    function compararValor($operador, $valor1, $valor2){
    	$test = "if (".$valor1." ".$operador." ".$valor2."){ return true; } else { return false; }";
    	return (eval($test));
    }
    
    /**
     * 7 Compara si un valor se encuentra dentro de un rango valido de valores
     */
    function compararRango($valor1, $valor2){
    	$liminf = $valor2 * -1;  //Limite inferior del rango
    	$limsup = $valor2;       //LImite superior del rango
    	if (($valor1 < $liminf)||($valor1 > $limsup)){
    		return true;
    	}
    	else{
    		return false;
    	}
    }
}//EOC