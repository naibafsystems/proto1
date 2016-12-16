<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Observaciones extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->library("session");        
    }
    
    function obtenerObservacionesFuente($nro_orden, $uni_local, $ano, $mes){
    	$observaciones = array();
    	$sql = "SELECT OB.fecha, OB.capitulo, OB.nom_campo, OB.descripcion
				FROM rmmh_admin_observaciones OB, rmmh_admin_usuarios U
				WHERE OB.fk_usuario = U.id_usuario
				AND U.fk_rol = 1
				AND OB.nro_orden = $nro_orden
				AND OB.uni_local = $uni_local
				AND OB.ano_periodo = $ano
				AND OB.mes_periodo = $mes
				ORDER BY OB.capitulo DESC";
       	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		$i = 0;
    		foreach ($query->result() as $row){
      			$observaciones[$i]["fecha"] = $row->fecha;
    			$observaciones[$i]["capitulo"] = $row->capitulo;
      			$observaciones[$i]["campo"] = $row->nom_campo;
    			$observaciones[$i]["descripcion"] = $row->descripcion;    			
    			$observaciones[$i]["bloqueo"] = $this->control->bloquearCampos();
    			$i++;
    		}   			
   		}   		
   		$this->db->close();
   		return $observaciones;
    }
    
	function obtenerObservacionesCritica($nro_orden, $uni_local, $ano, $mes){
    	$observaciones = array();
    	$sql = "SELECT OB.fecha, OB.capitulo, OB.nom_campo, OB.descripcion
				FROM rmmh_admin_observaciones OB, rmmh_admin_usuarios U
				WHERE OB.fk_usuario = U.id_usuario
				AND U.fk_rol = 2
				AND OB.nro_orden = $nro_orden
				AND OB.uni_local = $uni_local
				AND OB.ano_periodo = $ano
				AND OB.mes_periodo = $mes
				ORDER BY OB.capitulo DESC";
       	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		$i = 0;
    		foreach ($query->result() as $row){
      			$observaciones[$i]["fecha"] = $row->fecha;
    			if ($row->capitulo==0)
      				$observaciones[$i]["capitulo"] = "Env&iacute;o";
      			else	
      				$observaciones[$i]["capitulo"] = $row->capitulo;
      			$observaciones[$i]["campo"] = $row->nom_campo;
    			$observaciones[$i]["descripcion"] = $row->descripcion;    			
    			$observaciones[$i]["bloqueo"] = $this->control->bloquearCampos();
    			$i++;
    		}   			
   		}   		
   		$this->db->close();
   		return $observaciones;
    }
    
    function obtenerObservaciones($capitulo, $campo){
    	$this->load->library("session");
    	$this->load->model("control");
    	$observaciones = array();
    	$id_usuario = $this->session->userdata("id");
    	$nro_orden = $this->session->userdata("nro_orden");
    	$uni_local = $this->session->userdata("uni_local");
    	$ano_periodo = $this->session->userdata("ano_periodo");
    	$mes_periodo = $this->session->userdata("mes_periodo");
    	
    	if (($nro_orden!="")&&($uni_local!="")&&($ano_periodo!="")&&($mes_periodo!="")){
    		$sql = "SELECT nom_campo, descripcion  
            	    FROM rmmh_admin_observaciones
                	WHERE nro_orden = $nro_orden
                	AND uni_local = $uni_local
                	AND ano_periodo = $ano_periodo
                	AND mes_periodo = $mes_periodo
                	AND fk_usuario = $id_usuario
                	AND capitulo = $capitulo";    	
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
    
    function actualizarObservacion($capitulo, $nom_campo, $val_campo, $observacion){
    	$id = 0; //Variable que me identifica el id de la observacion (autonumerico)
    	$id_usuario = $this->session->userdata("id");
    	$nro_orden = $this->session->userdata("nro_orden");
    	$uni_local = $this->session->userdata("uni_local");
    	$ano_periodo = $this->session->userdata("ano_periodo");
    	$mes_periodo = $this->session->userdata("mes_periodo");
    	
    	//Pregunto si la observacion ya existe para saber si debo hacer un update o un insert
    	$sql = "SELECT id_observacion
    	        FROM rmmh_admin_observaciones
    	        WHERE nro_orden = $nro_orden
    	        AND uni_local = $uni_local
    	        AND ano_periodo = $ano_periodo
    	        AND mes_periodo = $mes_periodo
    	        AND fk_usuario = $id_usuario
    	        AND nom_campo = '$nom_campo'";
    	$query = $this->db->query($sql);    		
    	foreach($query->result() as $row){
    		$id = $row->id_observacion; 
    	}
    	
    	//Si el valor del campo viene con valor cero, y el id existe, debo eliminar la observacion
    	if (($val_campo==0)&&($id!=0)){
    		//Eliminar el comentario con el id que se obtuvo de la observacion
    		$this->db->where('id_observacion', $id);
			$this->db->delete('rmmh_admin_observaciones');			
    	}	
    	else{
    		if ($id!=0){
    			//Ya existe el registro, por tanto debe realizarse un update
    			$data = array('capitulo' => $capitulo, 
    			              'nom_campo' => $nom_campo,
    			              'descripcion' => $observacion, 
    			              'fecha' => date("Y-m-d h:i:s")
    			);
    			$this->db->where('id_observacion', $id);
				$this->db->update('rmmh_admin_observaciones', $data);
    		}
    		else{
	    		//No existe el registro, por tanto debe realizarse un insert (Solo si la observacion no esta en blanco).   		
	    		if ($observacion!=""){
	    			$data = array('capitulo' => $capitulo,
		    		              'nom_campo' => $nom_campo,		    		              
		    		              'descripcion' => $observacion,
		    		              'fecha' => date("Y-m-d"),
		    		              'nro_orden' => $nro_orden,
		    		              'uni_local' => $uni_local,
		    		              'ano_periodo' => $ano_periodo,
		    		              'mes_periodo' => $mes_periodo,
		    		              'fk_usuario' => $id_usuario
		    		);
		    		$this->db->insert('rmmh_admin_observaciones', $data);		    		
	    		}	    		
    		}    		    		 
    	}
    	 	
    }  

    function insertarObservacion($capitulo, $campo, $observacion, $fecha, $nro_orden, $uni_local, $ano, $mes, $usuario){
    	$data = array ('capitulo' => $capitulo, 
    	               'nom_campo' => $campo,
    	               'descripcion' => $observacion,
    	               'fecha' => $fecha,
    	               'nro_orden' => $nro_orden,
    	               'uni_local' => $uni_local,
    	               'ano_periodo' => $ano, 
    	               'mes_periodo' => $mes,
    	               'fk_usuario' => $usuario);
    	$this->db->insert('rmmh_admin_observaciones', $data);
    }
    
    
    
    
    
    
   
   
}//EOC        
   