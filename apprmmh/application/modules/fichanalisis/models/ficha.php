<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ficha extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();		
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
   		return $valor;    
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
    	if (($valor1 < $liminf)||($valor1> $limsup)){
    		return true;
    	}
    	else{
    		return false;
    	}
    }
    
    
    
    
    
    
  
    
    
}//EOC  
    