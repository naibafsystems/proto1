<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Periodo extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
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
	
	//Obtiene el periodo más reciente que esté creado en la base de datos
    function obtenerPeriodoActual(){
    	$periodo = array();
    	$sql = "SELECT MAX(ano_periodo) AS ano_periodo, MAX(mes_periodo) AS mes_periodo FROM rmmh_param_periodos";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
      			$periodo["ano"] = $row->ano_periodo;
      			$periodo["mes"] = $row->mes_periodo;
   			}
   		}    	
    	$this->db->close();
   		return $periodo;
    }
    
	//Se pregunta si un periodo ya se encuentra registrado en la tabla periodos
    //Si ya esta registrado, No se realiza el cierre del periodo. Si no esta registrado
    //entonces si se realiza el cierre del periodo.
    function buscarPeriodo($ano, $mes){
    	$result = false;
    	$sql = "SELECT COUNT(*) AS counter
                FROM rmmh_param_periodos
                WHERE ano_periodo = $ano
                AND mes_periodo = $mes";
    	$query = $this->db->query($sql);
    	foreach ($query->result() as $row){
      		if ($row->counter > 0){
      			$result = true;
      		}
   		}    	
    	$this->db->close();
   		return $result;
    }
    
    
    function validaCierre($ano, $mes){
    	$result = false;
    	$sql = "SELECT COUNT(*) AS open
                FROM rmmh_admin_control
                WHERE ano_periodo = $ano
                AND mes_periodo = $mes
                AND fk_novedad NOT IN (99)
                AND fk_estado NOT IN (5)";
    	$query = $this->db->query($sql);
    	foreach($query->result() as $row){
    		if ($row->open > 0){
    			$result = false;
    		}
    		else{
    			$result = true;
    		}
    	}
    	$this->db->close();
    	return $result;
    }

    
	//Cuando se ejecuta el cierre del periodo, crea un nuevo registro en la tabla rmmh_param_periodos para el siguiente
    //periodo que se agrega.
    function cerrarPeriodo($ano, $mes){
    	$anosig = $ano;
		//Calcular cual va a ser el siguiente ano y mes
		if ($mes<12){
			$messig = $mes + 1;
		}
		else{
			$messig = 1;
			$anosig = $ano + 1;
		}
		$periodo = $anosig."-".$messig;
		
		//Insertar el registro del siguiente periodo en la tabla de periodos
		$data = array('ano_periodo' => $anosig, 
     				  'mes_periodo' => $messig, 
     				  'nom_periodo' => $this->obtenerNombrePeriodo($anosig, $messig));
     	$this->db->insert('rmmh_param_periodos', $data);
		$this->db->close();
    }
    
}//EOC    