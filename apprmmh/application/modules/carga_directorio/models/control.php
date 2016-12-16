<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Control extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->library("session");
    }
    
  	//Crea los registros de control cuando se realiza el cargue masivo del directorio
	function insertarControl($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $nueva, $modulo1, $modulo2, $modulo3, $modulo4, $envio, $inclusion, $control, $fk_novedad, $fk_estado, $fk_sede, $fk_subsede, $fk_usuariocritica, $fk_usuariologistica){
	 	$data = array('nro_orden' => $nro_orden, 
	 	              'nro_establecimiento' => $nro_establecimiento, 
	 	              'ano_periodo' => $ano_periodo, 
	 	              'mes_periodo' => $mes_periodo, 
	 	              'nueva' => $nueva, 
	 	              'modulo1' => $modulo1, 
	 	              'modulo2' => $modulo2, 
	 	              'modulo3' => $modulo3, 
	 	              'modulo4' => $modulo4, 
	 	              'envio' => $envio, 
	 	              'inclusion' => $inclusion, 
	 	              'control' => $control, 
	 	              'fk_novedad' => $fk_novedad, 
	 	              'fk_estado' => $fk_estado, 
	 	              'fk_sede' => $fk_sede, 
	 	              'fk_subsede' => $fk_subsede, 
	 	              'fk_usuariocritica' => $fk_usuariocritica, 
	 	              'fk_usuariologistica' => $fk_usuariologistica);
	 	$this->db->insert('rmmh_admin_control', $data);
		$this->db->close();
	}
    
}//EOC