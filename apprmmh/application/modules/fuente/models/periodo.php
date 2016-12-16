<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Periodo extends CI_Model {

		//Obtiene los periodos en los que la fuente tiene formularios pendientes por diligenciar
		function obtenerPeriodosPendientes($nro_orden, $nro_establecimiento){
			$periodos = array();
			$sql = "SELECT CONCAT(C.ano_periodo, C.mes_periodo) AS periodo, CONCAT(C.ano_periodo,' - ',LPAD(C.mes_periodo,2,'0')) AS nom_periodo
                    FROM rmmh_admin_control C, rmmh_param_periodos P
                    WHERE C.ano_periodo = P.ano_periodo
                    AND C.mes_periodo = P.mes_periodo
                    AND C.nro_orden = $nro_orden
                    AND C.nro_establecimiento = $nro_establecimiento
                    AND fk_novedad IN (5,9)
                    AND fk_estado IN (0,1,2,3)";								
			$query = $this->db->query($sql);
    		if ($query->num_rows() > 0){
	    		$i = 0;
    			foreach($query->result() as $row){
    				$periodos[$i]["periodo"] = $row->periodo;
    				$periodos[$i]["nom_periodo"] = $row->nom_periodo;
    				$i++;
    			}
    		}
    		$this->db->close();
    		return $periodos;    		
		}
		
		//Obtiene todos los periodos que se han creado en la B.D. (Se concatena el año y el mes).
    	function obtenerPeriodosTodosMOD(){
    		$periodos = array();
    		$sql = "SELECT CONCAT(ano_periodo,mes_periodo) AS periodo, CONCAT(ano_periodo,' - ',LPAD(mes_periodo,2,'0')) AS nom_periodo 
    	    	    FROM rmmh_param_periodos r
    	        	ORDER BY ano_periodo DESC";
    		$query = $this->db->query($sql);
    		if ($query->num_rows() > 0){
	    		$i = 0;
    			foreach($query->result() as $row){
    				$periodos[$i]["periodo"] = $row->periodo;
    				$periodos[$i]["nom_periodo"] = $row->nom_periodo;
    				$i++;
    			}
    		}
    		$this->db->close();
    		return $periodos;
    	}
    	
    	
		//Obtiene el nombre de un periodo (Año y Mes) - Se utiliza en el header del modulo.
		function obtenerNombrePeriodo($ano, $mes){
    		$nombremes = "";
    		$nombrePeriodo = "";
    		switch ($mes){
    			case 1:  $nombremes = "Enero";
    					 break;
    			case 2:  $nombremes = "Febrero";
    					 break;
    			case 3:  $nombremes = "Marzo";
    					 break;
    			case 4:  $nombremes = "Abril";
    					 break;
    			case 5:  $nombremes = "Mayo";
    					 break;
    			case 6:  $nombremes = "Junio";
    					 break;
    			case 7:  $nombremes = "Julio";
    					 break;
    			case 8:  $nombremes = "Agosto";
    					 break;
    			case 9:  $nombremes = "Septiembre";
    					 break;
    			case 10: $nombremes = "Octubre";
    					 break;
    			case 11: $nombremes = "Noviembre";
    					 break;
    			case 12: $nombremes = "Diciembre";
    					 break;		 		 																		
    		}
    		$nombrePeriodo = $nombremes." - ".$ano;
    		return $nombrePeriodo;
		}
    	
    	
    	
	}//EOC