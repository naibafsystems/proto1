<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Observacion extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();		
    }
    
	function actualizarObservacion($observacion, $index, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
		$data = array('descripcion' => $observacion);
        $this->db->where('modulo', 99);
        $this->db->where('SUBSTR(nom_campo,16,LENGTH(nom_campo))', $index);
        $this->db->where('nro_orden', $nro_orden);
		$this->db->where('nro_establecimiento', $nro_establecimiento);
		$this->db->where('ano_periodo', $ano_periodo);
		$this->db->where('mes_periodo', $mes_periodo);
        $this->db->update('rmmh_admin_observaciones', $data);
	}
    
    function guardarObservacion($modulo, $campo, $observacion, $fecha, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $usuario){
    	$data = array ('modulo' => $modulo, 
    	               'nom_campo' => $campo,
    	               'descripcion' => $observacion,
    	               'fecha' => $fecha,
    	               'nro_orden' => $nro_orden,
    	               'nro_establecimiento' => $nro_establecimiento,
    	               'ano_periodo' => $ano_periodo, 
    	               'mes_periodo' => $mes_periodo,
    	               'fk_usuario' => $usuario);
    	$this->db->insert('rmmh_admin_observaciones', $data);
    }
    
    function consultarObservacion($index, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$observ = "";
    	$sql = "SELECT descripcion
				FROM rmmh_admin_observaciones
				WHERE modulo = 99
				AND SUBSTR(nom_campo,16,LENGTH(nom_campo)) = $index
				AND nro_orden = $nro_orden
				AND nro_establecimiento = $nro_establecimiento
				AND ano_periodo = $ano_periodo
				AND mes_periodo = $mes_periodo";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
      			$observ = $row->descripcion;    			
    		}   			
   		}
   		$this->db->close();
   		return $observ;
    }
    
	function validarObservacion($index, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$result = false;
    	$sql = "SELECT descripcion
                FROM rmmh_admin_observaciones
                WHERE modulo = 99
                AND SUBSTR(nom_campo,16,LENGTH(nom_campo)) = $index
                AND nro_orden = $nro_orden
                AND nro_establecimiento = $nro_establecimiento
                AND ano_periodo = $ano_periodo
                AND mes_periodo = $mes_periodo";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		$result = true;   			
   		}
   		$this->db->close();
   		return $result;
    }
    
}//EOC 