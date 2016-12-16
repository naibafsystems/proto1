<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Analisis extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->library("session");        
    }
    
    /**
     * Función para obtener el mes anterior
     * @author Jesús Neira Guio SJNEIRAG
     * @since octubre de 2015
     */
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
    
    /**
     * Función para obtener el mes del año anterior
     * @author Jesús Neira Guio SJNEIRAG
     * @since octubre de 2015
     */
    function obtenerPeriodoAnual($ano_periodo, $mes_periodo){
    	$data = array();
    	$data["ano"] = $ano_periodo - 1;
    	$data["mes"] = $mes_periodo;
    	return $data;
    }
    
    /**
     * Función para obtener número de establecimilentos mes actual
     * @author Jesús Neira Guio SJNEIRAG
     * @since octubre de 2015
     */
    function obtenerValorActualEst($tabla1, $tabla2, $campo, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec){
    	$valor = 0;
    	$sql = "SELECT $campo
				FROM $tabla1, $tabla2 
				WHERE $tabla1.nro_orden = $tabla2.nro_orden
				AND $tabla1.nro_establecimiento = $tabla2.nro_establecimiento
				AND $tabla1.ano_periodo = $ano_periodo
				AND $tabla1.mes_periodo = $mes_periodo ";
				if($depto!=''){
    	        	$sql.=" AND fk_depto $depto ";
    			}
    			if($mpio!=''){
    				$sql.=" AND fk_mpio $mpio";
    			}
    			if($idEstablec!=''){
    				$sql.=" AND $tabla1.nro_establecimiento=$idEstablec ";
    			}
    	//	echo $sql."<br><br>";		 	
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
     * Función para obtener número de establecimilentos mes anterior
     * @author Jesús Neira Guio SJNEIRAG
     * @since octubre de 2015
     */
    function obtenerValorAnteriorEst($tabla1, $tabla2, $campo, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec){
    	$antes = $this->obtenerPeriodoAnterior($ano_periodo, $mes_periodo);
    	$ano = $antes["ano"];
    	$mes = $antes["mes"];
    	$valor = 0;
    	$sql = "SELECT $campo
    	FROM $tabla1, $tabla2
    	WHERE $tabla1.nro_orden = $tabla2.nro_orden
    	AND $tabla1.nro_establecimiento = $tabla2.nro_establecimiento
    	AND $tabla1.ano_periodo = $ano
    	AND $tabla1.mes_periodo = $mes";
		if($depto!=''){
    	   	$sql.=" AND fk_depto $depto";
    	}
    	if($mpio!=''){
    		$sql.=" AND fk_mpio $mpio";
    	}
    	if($idEstablec!=''){
    		$sql.=" AND $tabla1.nro_establecimiento=$idEstablec ";
    	}
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
     *  Función para obtener número de establecimilentos mes año anterior
     * @author Jesús Neira Guio SJNEIRAG
     * @since octubre de 2015
     */
    function obtenerValorAnualEst($tabla1, $tabla2, $campo, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec){
    	$antes = $this->obtenerPeriodoAnual($ano_periodo, $mes_periodo);
    	$ano = $antes["ano"];
    	$mes = $antes["mes"];
    	$valor = 0;
    	$sql = "SELECT $campo
    	FROM $tabla1, $tabla2
    	WHERE $tabla1.nro_orden = $tabla2.nro_orden
    	AND $tabla1.nro_establecimiento = $tabla2.nro_establecimiento
    	AND $tabla1.ano_periodo = $ano
    	AND $tabla1.mes_periodo = $mes";
		if($depto!=''){
    	   	$sql.=" AND fk_depto $depto";
    	}
    	if($mpio!=''){
    		$sql.=" AND fk_mpio $mpio";
    	}
    	if($idEstablec!=''){
    		$sql.=" AND $tabla1.nro_establecimiento=$idEstablec ";
    	}
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
     *  Función para calcular la variacion Mensual en la ficha de analisis
     * @author Jesús Neira Guio SJNEIRAG
     * @since octubre de 2015
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
     *  Función para calcular la variacion Anual en la ficha de analisis
     * @author Jesús Neira Guio SJNEIRAG
     * @since octubre de 2015
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
     *  Función para obtener las regiones para el módulo de análisis
     * @author Jesús Neira Guio SJNEIRAG
     * @since octubre de 2015
     */
	function obtenerRegiones($idRegional){
    	$regiones = array();
    	$sql = "SELECT id_region, nom_region,
    			departamentos_incluidos, municipios_incluidos,
    			variacion_limite 
    			FROM rmmh_param_regiones ";
    			if($idRegional!=''){
    				$sql.="WHERE ";
    				$sql.="id_region=$idRegional ";
    			}
    			$sql.="ORDER BY id_region ASC"; 
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		$i=0;
    		foreach ($query->result() as $row){
    			$regiones[$i]["id_region"] = $row->id_region;
    			$regiones[$i]["nom_region"] = $row->nom_region;
    			$regiones[$i]["departamentos_incluidos"] = $row->departamentos_incluidos;
    			$regiones[$i]["municipios_incluidos"] = $row->municipios_incluidos;
    			$regiones[$i]["variacion_limite"] = $row->variacion_limite;
    		$i++;	
    		}
    	}
    	
    	$this->db->close();
   		return $regiones;   		
    }
    
    /**
     *  Función para comprar rangos de variaciones
     * @author Jesús Neira Guio SJNEIRAG
     * @since octubre de 2015
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
    
    
    /**
     *  Función para obtener los establecimientos de cada regional
     * @author Jesús Neira Guio SJNEIRAG
     * @since febrero de 2016
     */
    function obtenerEstablecimientosRegional($municipios,$departamentos){
    	$establec = array();
    	$sql = "SELECT nro_orden, nro_establecimiento,
    			idnomcom, fk_depto,
    			fk_mpio
    			FROM  rmmh_admin_establecimientos ";
    			$sql.="WHERE ";
		    	if($municipios!='' && $departamentos!=''){
		    		$sql.="fk_mpio $municipios ";
		    		$sql.="AND ";
		    		$sql.="fk_depto $departamentos ";
		    	}
		    	elseif($departamentos!=''){
		    		$sql.="fk_depto $departamentos ";
		    	}elseif($municipios!=''){
		    		$sql.="fk_mpio $municipios ";
		    	}
    	$sql.="ORDER BY nro_establecimiento ASC";
    	
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		$i=0;
    		foreach ($query->result() as $row){
    			$establec[$i]["nro_orden"] = $row->nro_orden;
    			$establec[$i]["nro_establecimiento"] = $row->nro_establecimiento;
    			$establec[$i]["idnomcom"] = $row->idnomcom;
    			$establec[$i]["fk_depto"] = $row->fk_depto;
    			$establec[$i]["fk_mpio"] = $row->fk_mpio;
    			$i++;
    		}
    	}
    	 
    	$this->db->close();
    	return $establec;
    }
}//EOC  
