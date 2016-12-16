<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modulo5 extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->library("session");        
    }
    
    //Obtiene los datos del modulo 5 desde la B.D.
    function obtenerModulo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$modulo5 = array();
    	$sql = "SELECT C.modulo5, C4.hoteles, C4.apartahoteles, C4.cenvacacionales, C4.alojarural, C4.hostales, C4.zonacamp, C4.otro_servicio
                FROM rmmh_form_clasciiu4 C4, rmmh_admin_control C
                WHERE C4.nro_orden = C.nro_orden
                AND C4.nro_establecimiento = C.nro_establecimiento
                AND C4.ano_periodo = C.ano_periodo
                AND C4.mes_periodo = C.mes_periodo
                AND C.nro_orden = $nro_orden
                AND C.nro_establecimiento = $nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		foreach ($query->result() as $row){
    			$modulo5["op"] = "update";
    			$modulo5["imagen"] = $row->modulo5;
    			$modulo5["hoteles"] = $row->hoteles;
    			$modulo5["apartahoteles"] = $row->apartahoteles;
    			$modulo5["cenvacacionales"] = $row->cenvacacionales;
    			$modulo5["alojarural"] = $row->alojarural;
    			$modulo5["hostales"] = $row->hostales;
    			$modulo5["zonacamp"] = $row->zonacamp;
    			$modulo5["otro_servicio"] = $row->otro_servicio;
    		}
    	}
    	else{
    		$modulo5["op"] = "insert";
    		$modulo5["imagen"] = 0;
    		$modulo5["hoteles"] = "";
    		$modulo5["apartahoteles"] = "";
    		$modulo5["cenvacacionales"] = "";
    		$modulo5["alojarural"] = "";
    		$modulo5["hostales"] = "";
    		$modulo5["zonacamp"] = "";
    		$modulo5["otro_servicio"] = "";
    	}
    	$this->db->close();
   		return $modulo5;
    }
    
    //Guarda los datos del modulo 5 en la B.D.
    function insertarModulo($hoteles, $apartahoteles, $cenvacacionales, $alojarural, $hostales, $zonacamp, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $otro_servicio){
    	$data = array('hoteles' => $hoteles,
    	              'apartahoteles' => $apartahoteles,
    	              'cenvacacionales' => $cenvacacionales,
    	              'alojarural' => $alojarural,
    	              'hostales' => $hostales,
    	              'zonacamp' => $zonacamp,
    	              'nro_orden' => $nro_orden,
    	              'nro_establecimiento' => $nro_establecimiento,
    	              'ano_periodo' => $ano_periodo,
    	              'mes_periodo' => $mes_periodo,
    				  'otro_servicio' => $otro_servicio);
    	$this->db->insert('rmmh_form_clasciiu4',$data);
    	$this->db->close();    		
    }
    
    //Actualiza los datos del modulo 5 en la B.D.
    function actualizarModulo($hoteles, $apartahoteles, $cenvacacionales, $alojarural, $hostales, $zonacamp, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $otro_servicio){
    	$data = array('hoteles' => $hoteles,
    	              'apartahoteles' => $apartahoteles,
    	              'cenvacacionales' => $cenvacacionales,
    	              'alojarural' => $alojarural,
    	              'hostales' => $hostales,
    	              'zonacamp' => $zonacamp,
    	              'otro_servicio' => $otro_servicio);
    	$this->db->where("nro_orden", $nro_orden);
		$this->db->where("nro_establecimiento", $nro_establecimiento);
		$this->db->where("ano_periodo", $ano_periodo);
		$this->db->where("mes_periodo", $mes_periodo);
    	$this->db->update('rmmh_form_clasciiu4', $data);
		$this->db->close();
    }
    
    //Actualiza el código ciiu4
    function acualizaCodCiiu($ciiu, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$data = array('fk_ciiu' => $ciiu);
    	$this->db->where("nro_orden", $nro_orden);
    	$this->db->where("nro_establecimiento", $nro_establecimiento);
    	$this->db->update('rmmh_admin_establecimientos', $data);
    	$this->db->close();
    }
    
    //Obtiene las categorias del modulo 5 de clasificacion de la CIIU 4
    function obtenerCategorias(){
    	$categs = array();
    	$sql = "SELECT id_categoria, nom_categoria, cod_ciiu
                FROM rmmh_param_categciiu4
                ORDER BY id_categoria";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		$i = 0;
    		foreach ($query->result() as $row){
      			$categs[$i]["id"] = $row->id_categoria;
      			$categs[$i]["nombre"] = $row->nom_categoria;
      			$categs[$i]["cod_ciiu"] = $row->cod_ciiu;
      			$i++;
    		}
    	}
    	$this->db->close();
    	return $categs;
    }
    
    //Obtiene los servicios de cada categoria de acuerdo al indicador de la categoria que se recibe por parametro
    function obtenerServicios($index){
    	$servs = array();
    	$sql = "SELECT id_servicio, cod_servicio, nom_servicio, fk_categoria
                FROM rmmh_param_serviciiu4
                WHERE fk_categoria = $index";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		$i = 0;
    		foreach ($query->result() as $row){
    			$servs[$i]["id"] = $row->id_servicio;
    			$servs[$i]["codigo"] = $row->cod_servicio;
    			$servs[$i]["nombre"] = $row->nom_servicio;
    			$servs[$i]["categoria"] = $row->fk_categoria;
    			$i++;
    		}
    	}	
    	$this->db->close();
    	return $servs;
    }
    
	function existeRegistro($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$retorno = false;
    	$sql = "SELECT * 
    	        FROM rmmh_form_clasciiu4
    	        WHERE nro_orden = $nro_orden
    	        AND nro_establecimiento = $nro_establecimiento
    	        AND ano_periodo = $ano_periodo
    	        AND mes_periodo = $mes_periodo";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0)
    		$retorno = true;
    	return $retorno;	
    }
    
    
   
}//EOC  
