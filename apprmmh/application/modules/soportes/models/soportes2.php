<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Soportes2 extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * @author Daniel M. Díaz
     * @since Junio 24 de 2013
     * Funcion para obtener los datos del propietario de un archivo anexo      
     */
    public function datosSoporte($id){
    	$datos = array();
    	$sql = "SELECT nro_orden, nro_establecimiento, ano_periodo, mes_periodo
                FROM rmmh_param_soportes
                WHERE id_soporte = $id";
    	$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
    		foreach ($query->result() as $row){
      			$datos["nro_orden"] = $row->nro_orden;
				$datos["nro_establecimiento"] = $row->nro_establecimiento;
				$datos["ano_periodo"] = $row->ano_periodo;
				$datos["mes_periodo"] = $row->mes_periodo;				
      		}
    	}
    	$this->db->close();
    	return $datos;
    }
    
    
    public function agregarSoporte($nombre_soporte, $tipo_soporte, $tamano_soporte, $binario_soporte, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$data = array('nom_soporte' => $nombre_soporte,
   					  'tip_soporte' => $tipo_soporte,
    	              'tam_soporte' => $tamano_soporte,
    	              'bin_soporte' => $binario_soporte,
    	              'nro_orden' => $nro_orden,
    	              'nro_establecimiento' => $nro_establecimiento, 
    	              'ano_periodo' => $ano_periodo,
    	              'mes_periodo' => $mes_periodo
    	        );
		$this->db->insert('rmmh_param_soportes', $data); 
    }
    
    /**
     * @author Daniel M. Díaz
     * @since  Junio 24 de 2013
     * Felíz cumpleaños hermanita !!!
     * Función para obtener los datos de un soporte y mostrarlo en el aplicativo
     */
    public function obtenerSoporte($id){
    	$soporte = array();
    	$sql = "SELECT id_soporte, nom_soporte, tip_soporte, tam_soporte, bin_soporte, nro_orden, nro_establecimiento, ano_periodo, mes_periodo
                FROM rmmh_param_soportes
                WHERE id_soporte = $id";
    	$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
    		foreach ($query->result() as $row){
      			$soporte["id_soporte"] = $row->id_soporte;
				$soporte["nom_soporte"] = $row->nom_soporte;	
				$soporte["tip_soporte"] = $row->tip_soporte;
				$soporte["tam_soporte"] = $row->tam_soporte;
				$soporte["bin_soporte"] = $row->bin_soporte;
				$soporte["nro_orden"] = $row->nro_orden;
				$soporte["nro_establecimiento"] = $row->nro_establecimiento;
				$soporte["ano_periodo"] = $row->ano_periodo;
				$soporte["mes_periodo"] = $row->mes_periodo;				
      		}
    	}
    	$this->db->close();
    	return $soporte;
    }
    
    /**
     * @author Daniel M. Díaz
     * @since Junio 24 de 2013
     * Felíz cumpleaños hermanita !!!
     * Función para obtener los archivos anexos que se han agregado como soportes a una novedad 
     */
    public function obtenerSoportes($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$datos = array();
    	$sql = "SELECT id_soporte, nom_soporte, tip_soporte, tam_soporte, bin_soporte, nro_orden, nro_establecimiento, ano_periodo, mes_periodo
				FROM rmmh_param_soportes
				WHERE nro_orden = $nro_orden
				AND nro_establecimiento = $nro_establecimiento
				AND ano_periodo = $ano_periodo
				AND mes_periodo = $mes_periodo";    	
    	$query = $this->db->query($sql);
		if ($query->num_rows()>0){
			$i = 0;
			foreach ($query->result() as $row){
      			$datos[$i]["id_soporte"] = $row->id_soporte;
				$datos[$i]["nom_soporte"] = $row->nom_soporte;	
				$datos[$i]["tip_soporte"] = $row->tip_soporte;
				$datos[$i]["tam_soporte"] = $row->tam_soporte;
				$datos[$i]["bin_soporte"] = $row->bin_soporte;
				$datos[$i]["nro_orden"] = $row->nro_orden;
				$datos[$i]["nro_establecimiento"] = $row->nro_establecimiento;
				$datos[$i]["ano_periodo"] = $row->ano_periodo;
				$datos[$i]["mes_periodo"] = $row->mes_periodo;
				$i++;
      		}
		}
		$this->db->close();
		return $datos;
    }
    
    /**
     * @author Daniel M. Díaz
     * @since  Junio 24 de 2013
     * Felíz cumpleaños hermanita !!!
     * Función para eliminar los archivos anexos agregados como soportes a una novedad
     */
    public function eliminarSoporte($id){
    	$this->db->where('id_soporte', $id);
		$this->db->delete('rmmh_param_soportes'); 
    }
    
}//EOC