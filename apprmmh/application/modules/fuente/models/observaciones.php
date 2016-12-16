<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Observaciones extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->library("session");        
    }
    
 	function obtenerObservaciones($idusuario, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $modulo, $campo){
    	$this->load->library("session");
    	$this->load->model("control");
    	$observaciones = array();
    	if (($nro_orden!="")&&($nro_establecimiento!="")&&($ano_periodo!="")&&($mes_periodo!="")){
    		$sql = "SELECT nom_campo, descripcion  
            	    FROM rmmh_admin_observaciones
                	WHERE nro_orden = $nro_orden
                	AND nro_establecimiento = $nro_establecimiento
                	AND ano_periodo = $ano_periodo
                	AND mes_periodo = $mes_periodo
                	AND fk_usuario = $idusuario
                	AND modulo = $modulo";    	
    		if ($campo!="0"){
            	$sql .= " AND nom_campo = '$campo'";
        	}
    		$query = $this->db->query($sql);
    		if ($query->num_rows() > 0){
    			$i = 0;
    			foreach ($query->result() as $row){
      				$observaciones[$i]["campo"] = $row->nom_campo;
    				$observaciones[$i]["descripcion"] = $row->descripcion;    			
    				$observaciones[$i]["bloqueo"] = $this->control->bloquearCampos();
    				$i++;
    			}   			
   			}   		   		
    	} 	
    	$this->db->close();
    	return $observaciones;
    }
    
    function actualizarObservacion($id_usuario, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $modulo, $nom_campo, $val_campo, $observacion){
    	$id = 0; //Variable que me identifica el id de la observacion (autonumerico). Pregunto si la observacion ya existe para saber si debo hacer un update o un insert
    	$obsBD = "";
    	$sql = "SELECT id_observacion, descripcion
    	        FROM rmmh_admin_observaciones
    	        WHERE nro_orden = $nro_orden
    	        AND nro_establecimiento = $nro_establecimiento
    	        AND ano_periodo = $ano_periodo
    	        AND mes_periodo = $mes_periodo
    	        AND fk_usuario = $id_usuario
    	        AND nom_campo = '$nom_campo'";    	
    	$query = $this->db->query($sql);    		
    	foreach($query->result() as $row){
    		$id = $row->id_observacion; 
    		$obsBD = $row->descripcion;
    	}
    	//1. El valor del campo es cero y se encontró una observacion en la B.D 
    	//2. Si hay una observacion en la base de datos, pero se esta indicando una nueva observacion vacia.
    	if ((($val_campo==0)&&($id!=0))||(($obsBD!="")&&($observacion==""))){
    		//Eliminar el comentario con el id que se obtuvo de la observacion
    		$this->db->where('id_observacion', $id);
			$this->db->delete('rmmh_admin_observaciones');
			echo $this->db->last_query();
    	}	
    	else{
    		//1. Si se encontró la observación, y como no viene vacía, debo actualizarla.
    		if ($id!=0){
    			//Ya existe el registro, por tanto debe realizarse un update
    			$data = array('modulo' => $modulo, 
    			              'nom_campo' => $nom_campo,
    			              'descripcion' => $observacion, 
    			              'fecha' => date("Y-m-d h:i:s")
    			);
    			$this->db->where('id_observacion', $id);
				$this->db->update('rmmh_admin_observaciones', $data);				
    		}
    		else{
	    		//2. No se encontró la observacion, y tampoco viene vacía, debo insertarla.   		
	    		if ($observacion!=""){
	    			$data = array('modulo' => $modulo,
		    		              'nom_campo' => $nom_campo,		    		              
		    		              'descripcion' => $observacion,
		    		              'fecha' => date("Y-m-d"),
		    		              'nro_orden' => $nro_orden,
		    		              'nro_establecimiento' => $nro_establecimiento,
		    		              'ano_periodo' => $ano_periodo,
		    		              'mes_periodo' => $mes_periodo,
		    		              'fk_usuario' => $id_usuario
		    		);
		    		$this->db->insert('rmmh_admin_observaciones', $data);
	    		}   		
    		}    		    		    		 
    	}
    	 	
    }  
    
}//EOC