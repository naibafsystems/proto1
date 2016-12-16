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
    	$sql = "SELECT estado
                FROM rmmh_param_periodos
                WHERE ano_periodo = $ano
                AND mes_periodo = $mes";
    	$query = $this->db->query($sql);
    	foreach($query->result() as $row){
    		if ($row->estado=='C'){
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
    
    //Cuenta la cantidad de fuentes que existen para un periodo
    function conteoFuentes($ano_periodo, $mes_periodo){
    	$total = 0;
    	$sql = "SELECT COUNT(*) AS total
    	        FROM rmmh_admin_control 
    	        WHERE ano_periodo = $ano_periodo
    	        AND mes_periodo = $mes_periodo";
    	$query = $this->db->query($sql);
    	foreach($query->result() as $row){
    		$total = $row->total;
    	}
    	$this->db->close();
    	return $total;
    }
    
    
    
    //Funcion agregar periodo. Crea el registro de un nuevo periodo, y marca el periodo anterior como periodo cerrado.
    //Se pasan por parametro los datos del ano y mes del periodo anterior. (El periodo que se va a cerrar)
    function crearNuevoPeriodo($ano_periodo, $mes_periodo){
   		if ($mes_periodo<12){
			$ano_nuevo = $ano_periodo;
			$mes_nuevo = $mes_periodo + 1;
		}
		else{
			$ano_nuevo = $ano_periodo + 1;
			$mes_nuevo = 1; 
		}
		$this->db->trans_start();
		//Cerrar el periodo anterior.
		$data = array('estado' => 'C');
		$this->db->where('ano_periodo', $ano_periodo);
		$this->db->where('mes_periodo', $mes_periodo);
		$this->db->update('rmmh_param_periodos',$data);
		//Abrir el nuevo periodo
		$data = array('ano_periodo' => $ano_nuevo, 
		              'mes_periodo' => $mes_nuevo,
		              'nom_periodo' => $this->obtenerNombrePeriodo($ano_nuevo, $mes_nuevo),
		              'estado' => 'A');
		$this->db->insert('rmmh_param_periodos', $data);
		$periodo = $this->obtenerPeriodoActual(); //Obtener el ultimo periodo y mas reciente.
		//Duplicar todas las fuentes para el periodo actual
		$sql = "INSERT INTO rmmh_admin_control (nro_orden, nro_establecimiento, ano_periodo, mes_periodo, nueva, modulo1, modulo2, modulo3, modulo4, envio, inclusion, control, fk_novedad, fk_estado, fk_sede, fk_subsede, fk_usuariocritica, fk_usuariologistica)
    	        SELECT C.nro_orden, C.nro_establecimiento, ".$periodo["ano"].",".$periodo["mes"].", 0, 0, 0, 0, 0, 0, C.inclusion, 'A', 5, 0, C.fk_sede, C.fk_subsede, C.fk_usuariocritica, C.fk_usuariologistica
                FROM rmmh_admin_control C
                WHERE C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo"; 
    	$query = $this->db->query($sql);		            
    	$this->db->trans_complete();
		$this->db->close();
    }
	    
}//EOC    