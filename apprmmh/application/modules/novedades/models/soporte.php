<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Soporte extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();        
    }
    
    function agregarSoporte($nombre, $tipo, $tamano, $binario, $nro_orden, $uni_local, $ano_periodo, $mes_periodo){
    	$data = array('nom_soporte' => $nombre,
   					  'tip_soporte' => $tipo,
   					  'tam_soporte' => $tamano,
		              'bin_soporte' => $binario,
		              'nro_orden' => $nro_orden,
		              'uni_local' => $uni_local,
		              'ano_periodo' => $ano_periodo,
		              'mes_periodo' => $mes_periodo);
		$this->db->insert('rmmh_param_soportes', $data);    
    }
    
    function obtenerSoportes($nro_orden, $uni_local, $ano_periodo, $mes_periodo){
    	$soportes = array();
    	$sql = "SELECT id_soporte, nom_soporte, tip_soporte, tam_soporte
                FROM rmmh_param_soportes
                WHERE nro_orden = $nro_orden
				AND uni_local = $uni_local
				AND ano_periodo = $ano_periodo
				AND mes_periodo = $mes_periodo";
    	$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
			$i = 0;
			foreach($query->result() as $row){
				$soportes[$i]["id"] = $row->id_soporte;
				$soportes[$i]["nombre"] = $row->nom_soporte;
				$soportes[$i]["tipo"] = $row->tip_soporte;
				$soportes[$i]["tamano"] = $row->tam_soporte;
				$i++;
			}
		}
		$this->db->close();
		return $soportes;
    }
    
    function obtenerDatosSoporte($id){
    	$soporte = array();	
    	$sql = "SELECT nom_soporte, tip_soporte, tam_soporte, bin_soporte
    	        FROM rmmh_param_soportes
    	        WHERE id_soporte = $id";
    	$query = $this->db->query($sql);
    	if ($query->num_rows()>0){
			$i = 0;
			foreach($query->result() as $row){
				$soporte["nombre"] = $row->nom_soporte;
				$soporte["tipo"] = $row->tip_soporte;
				$soporte["tamano"] = $row->tam_soporte;
				$soporte["contenido"] = $row->bin_soporte;
			}
		}
		$this->db->close();
		return $soporte;
    }
    
}//EOC