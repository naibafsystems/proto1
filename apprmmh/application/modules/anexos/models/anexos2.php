<?php 

	class anexos2 extends CI_Model {
	
		function __construct(){        
        	parent::__construct();
        	$this->load->database();
        	$this->load->library("session");        	
    	}
    
    	public function prueba(){
    		echo "Probando, Probando, 1,2,3";
    	}
    	
    	/**
    	 * @author Daniel M. Díaz
    	 * @since  Junio 24 / 2013
    	 * Felíz cumpleaños hermanita !!!
    	 * Función para obtener el listado de todos los soportes que se han agregado al aplicativo RMMH
    	 */
    	/*
    	public function obtenerSoportes($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    		$soportes = array();
    		$sql = "SELECT id_soporte, nom_soporte, tip_soporte, tam_soporte, bin_soporte, nro_orden, nro_establecimiento, ano_periodo, mes_periodo
            	    FROM rmmh_param_control
                	WHERE nro_orden = $nro_orden
                	AND nro_establecimiento = $nro_establecimiento
                	AND ano_periodo = $ano_periodo
                	AND mes_periodo = $mes_periodo";
    		$query = $this->db->query($sql);
			if ($query->num_rows()>0){
				$i = 0;
				foreach ($query->result() as $row){
      				$soportes[$i]["id_soporte"] = $row->id_soporte;
      				$soportes[$i]["nom_soporte"] = $row->nom_soporte;
      				$soportes[$i]["tip_soporte"] = $row->tip_soporte;
      				$soportes[$i]["tam_soporte"] = $row->tam_soporte;
      				$soportes[$i]["bin_soporte"] = $row->bin_soporte;
      				$soportes[$i]["nro_orden"] = $row->nro_orden;
      				$soportes[$i]["nro_establecimiento"] = $row->nro_establecimiento;
      				$soportes[$i]["ano_periodo"] = $row->ano_periodo;
      				$soportes[$i]["mes_periodo"] = $row->mes_periodo;
					$i++;	
      			}
			}
			$this->db->close();
			return $soportes;
    	}
    	*/
    
	}//EOC