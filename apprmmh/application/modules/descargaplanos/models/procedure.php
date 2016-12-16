<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Procedure extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
    }
    
	function trasladarSedeSubsede($nro_orden, $nro_establecimiento, $sede, $subsede){
    	$sql = "CALL sp_cambioSedes($nro_orden, $nro_establecimiento, $sede, $subsede)";
    	$query = $this->db->query($sql);
    	$this->db->close();
    	return 0;
    }
    
    function removerFuenteBackup($operacion, $id_usuario, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$sql = "CALL sp_controlCambios('$operacion',$id_usuario,$nro_orden,$nro_establecimiento,$ano_periodo,$mes_periodo)";
    	$query = $this->db->query($sql);
    	$this->db->close();
    	return 0;
    }
	
	function cambiarEstadoFormulario($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $novedad, $estado, $usuario){
    	$sql = "CALL sp_cambioEstados($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $novedad, $estado, $usuario)";
    	$query = $this->db->query($sql);
    	$this->db->close();
    	return 0;
    }
    
}//EOC	
    