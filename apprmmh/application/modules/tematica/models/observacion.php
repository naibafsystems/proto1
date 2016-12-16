<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Observacion extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
		$this->load->library("paginador2");
    }
    
	//Obtiene las observaciones realizadas por la fuente
    function obtenerObservaciones($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
		$observaciones = array();
		$sql = "SELECT fecha, modulo, nom_campo, descripcion
                FROM rmmh_admin_observaciones OBS, rmmh_admin_usuarios U
                WHERE OBS.fk_usuario = U.id_usuario
                AND U.fk_rol = 1
                AND OBS.nro_orden = $nro_orden
                AND OBS.nro_establecimiento = $nro_establecimiento
                AND OBS.ano_periodo = $ano_periodo
                AND OBS.mes_periodo = $mes_periodo
                ORDER BY OBS.modulo";		                
		$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		$i = 0;
			foreach ($query->result() as $row){
      			$observaciones[$i]["fecha"] = $row->fecha;
    			$observaciones[$i]["modulo"] = $this->obtenerNombreCapitulo($row->modulo);
    			$observaciones[$i]["campo"] = $row->nom_campo;
    			$observaciones[$i]["observacion"] = $row->descripcion;    			
    			$i++;
    		}   			
   		}
		$this->db->close();
    	return $observaciones;	
	}
	
	//Obtiene las observaciones realizadas por la fuente en un modulo especifico
	function obtenerObservacionesModulo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $modulo){
		$observaciones = array();
		$sql = "SELECT fecha, modulo, nom_campo, descripcion
                FROM rmmh_admin_observaciones OBS, rmmh_admin_usuarios U
                WHERE OBS.fk_usuario = U.id_usuario
                AND U.fk_rol = 1
                AND OBS.nro_orden = $nro_orden
                AND OBS.nro_establecimiento = $nro_establecimiento
                AND OBS.ano_periodo = $ano_periodo
                AND OBS.mes_periodo = $mes_periodo
                AND OBS.modulo = $modulo
                ORDER BY OBS.modulo";		                
		$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		$i = 0;
			foreach ($query->result() as $row){
      			$observaciones[$i]["fecha"] = $row->fecha;
    			$observaciones[$i]["modulo"] = $this->obtenerNombreCapitulo($row->modulo);
    			$observaciones[$i]["campo"] = $row->nom_campo;    			
    			$observaciones[$i]["descripcion"] = $row->descripcion;
    			$i++;
    		}   			
   		}
		$this->db->close();
    	return $observaciones;	
	}
	
	//Obtiene las observaciones realizadas por la critica
	function obtenerObservacionesCritica($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
		$observaciones = array();
		$sql = "SELECT fecha, modulo, nom_campo, descripcion
                FROM rmmh_admin_observaciones OBS, rmmh_admin_usuarios U
                WHERE OBS.fk_usuario = U.id_usuario
                AND U.fk_rol = 2
                AND OBS.nro_orden = $nro_orden
                AND OBS.nro_establecimiento = $nro_establecimiento
                AND OBS.ano_periodo = $ano_periodo
                AND OBS.mes_periodo = $mes_periodo
                ORDER BY OBS.modulo;";		
		$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		$i = 0;
			foreach ($query->result() as $row){
      			$observaciones[$i]["fecha"] = $row->fecha;
    			$observaciones[$i]["modulo"] = $this->obtenerNombreCapitulo($row->modulo);
    			$observaciones[$i]["campo"] = $row->nom_campo;
    			$observaciones[$i]["observacion"] = $row->descripcion;
    			$i++;
    		}   			
   		}
		$this->db->close();
    	return $observaciones;	
	}
	
	//Obtiene las observaciones realizadas por el asistente tecnico
	function obtenerObservacionesAsistente($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
		$observaciones = array();
		$sql = "SELECT fecha, modulo, nom_campo, descripcion
                FROM rmmh_admin_observaciones OBS, rmmh_admin_usuarios U
                WHERE OBS.fk_usuario = U.id_usuario
                AND U.fk_rol = 3
                AND OBS.nro_orden = $nro_orden
                AND OBS.nro_establecimiento = $nro_establecimiento
                AND OBS.ano_periodo = $ano_periodo
                AND OBS.mes_periodo = $mes_periodo
                ORDER BY OBS.modulo;";		
		$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		$i = 0;
			foreach ($query->result() as $row){
      			$observaciones[$i]["fecha"] = $row->fecha;
    			$observaciones[$i]["modulo"] = $this->obtenerNombreCapitulo($row->modulo);
    			$observaciones[$i]["campo"] = $row->nom_campo;
    			$observaciones[$i]["observacion"] = $row->descripcion;
    			$i++;
    		}   			
   		}
		$this->db->close();
    	return $observaciones;
	}
	
	//Obtiene las observaciones realizadas por logistica
	function obtenerObservacionesLogistica($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
		$observaciones = array();
		$sql = "SELECT fecha, modulo, nom_campo, descripcion
                FROM rmmh_admin_observaciones OBS, rmmh_admin_usuarios U
                WHERE OBS.fk_usuario = U.id_usuario
                AND U.fk_rol = 5
                AND OBS.nro_orden = $nro_orden
                AND OBS.nro_establecimiento = $nro_establecimiento
                AND OBS.ano_periodo = $ano_periodo
                AND OBS.mes_periodo = $mes_periodo
                ORDER BY OBS.modulo;";		
		$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		$i = 0;
			foreach ($query->result() as $row){
      			$observaciones[$i]["fecha"] = $row->fecha;
    			$observaciones[$i]["modulo"] = $this->obtenerNombreCapitulo($row->modulo);
    			$observaciones[$i]["campo"] = $row->nom_campo;
    			$observaciones[$i]["observacion"] = $row->descripcion;
    			$i++;
    		}   			
   		}
		$this->db->close();
    	return $observaciones;
	}
	
	//Obtiene las observaciones realizadas por el administrador
	function obtenerObservacionesAdministrador($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
		$observaciones = array();
		$sql = "SELECT fecha, modulo, nom_campo, descripcion
                FROM rmmh_admin_observaciones OBS, rmmh_admin_usuarios U
                WHERE OBS.fk_usuario = U.id_usuario
                AND U.fk_rol = 4
                AND OBS.nro_orden = $nro_orden
                AND OBS.nro_establecimiento = $nro_establecimiento
                AND OBS.ano_periodo = $ano_periodo
                AND OBS.mes_periodo = $mes_periodo
                ORDER BY OBS.modulo;";		
		$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		$i = 0;
			foreach ($query->result() as $row){
      			$observaciones[$i]["fecha"] = $row->fecha;
    			$observaciones[$i]["modulo"] = $this->obtenerNombreCapitulo($row->modulo);
    			$observaciones[$i]["campo"] = $row->nom_campo;
    			$observaciones[$i]["observacion"] = $row->descripcion;
    			$i++;
    		}   			
   		}
		$this->db->close();
    	return $observaciones;
	}
	
	//Funcion para asignar los nombres de los capitulos en la consulta de observaciones
	function obtenerNombreCapitulo($capitulo){
		$nombre = "";
		switch($capitulo){
			case  0: $nombre = "Env&iacute;o formulario";
					 break; 
			
			case 99: $nombre = "Ficha de an&aacute;lisis";
			         break;
			         
			default: $nombre = "M&oacute;dulo ".$capitulo;
					 break;         
		}
		return $nombre;
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
    
    
    //Se copia esta funcion desde la fuente para que guarde las observaciones de la fuente y permita modificarlas desde el administrador.
    //Se modifica para que pregunte si el usuario ha hecho observaciones sobre un solo modulo
    function actualizarObservacion($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $modulo, $nom_campo, $val_campo, $observacion){
    	$this->load->model("usuario");
    	$id = 0; //Variable que me identifica el id de la observacion (autonumerico). Pregunto si la observacion ya existe para saber si debo hacer un update o un insert
    	$obsBD = "";
    	$sql = "SELECT id_observacion, descripcion
    	        FROM rmmh_admin_observaciones
    	        WHERE nro_orden = $nro_orden
    	        AND nro_establecimiento = $nro_establecimiento
    	        AND ano_periodo = $ano_periodo
    	        AND mes_periodo = $mes_periodo
    	        AND modulo = $modulo
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
	    			$id_usuario = $this->usuario->obtenerIDFuente($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
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
	
	//Otiene el listado de observaciones realizadas y que se encuentran en el sistema para realizar 
    //una descarga de observaciones dentro de las descargas de archivos planos en excel
    function descargaPlanosObservaciones($ano_periodo, $mes_periodo){
    	$sql = "SELECT OB.nro_orden, OB.nro_establecimiento, OB.ano_periodo, OB.mes_periodo, OB.fecha, OB.modulo, CASE modulo
                                                                                                     WHEN 1 THEN 'Módulo I'
                                                                                                     WHEN 2 THEN 'Módulo II'
                                                                                                     WHEN 3 THEN 'Módulo III'
                                                                                                     WHEN 4 THEN 'Módulo IV'
                                                                                                     WHEN 0 THEN 'Envío del formulario'
                                                                                                     WHEN 99 THEN 'Ficha de analisis'
                                                                                                   END nom_modulo, descripcion AS observacion, C.fk_novedad, C.fk_estado
				FROM rmmh_admin_control C, rmmh_admin_observaciones OB
				WHERE C.nro_orden = OB.nro_orden
				AND C.nro_establecimiento = OB.nro_establecimiento
				AND C.ano_periodo = OB.ano_periodo
				AND C.mes_periodo = OB.mes_periodo
				AND C.ano_periodo = $ano_periodo
				AND C.mes_periodo = $mes_periodo";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		$i = 0;
			foreach ($query->result() as $row){
      			$observaciones[$i]["nro_orden"] = $row->nro_orden;
    			$observaciones[$i]["nro_establecimiento"] = $row->nro_establecimiento;
    			$observaciones[$i]["ano_periodo"] = $row->ano_periodo;
    			$observaciones[$i]["mes_periodo"] = $row->mes_periodo;
    			$observaciones[$i]["fecha"] = $row->fecha;
    			$observaciones[$i]["modulo"] = $row->modulo;
    			$observaciones[$i]["nom_modulo"] = $row->nom_modulo;
    			$observaciones[$i]["modulo"] = $row->nom_modulo;
    			$observaciones[$i]["descripcion"] = $row->observacion;
    			$observaciones[$i]["fk_novedad"] = $row->fk_novedad;
    			$observaciones[$i]["fk_estado"] = $row->fk_estado;
    			$observaciones[$i]["estado"] = $this->novedad->nombreEstadoFormulario($row->fk_novedad, $row->fk_estado);
    			$i++;
    		}   			
   		}
		$this->db->close();
    	return $observaciones;
    }
    
    //Obtiene el nombre del critico que le está realizando la crítica a un formulario
    function obtenerNombreCritico($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$nombre = "";
    	$sql = "SELECT U.nom_usuario
				FROM rmmh_admin_control C, rmmh_admin_usuarios U
				WHERE C.fk_usuariocritica = U.id_usuario
				AND C.nro_orden = $nro_orden
				AND C.nro_establecimiento = $nro_establecimiento
				AND C.ano_periodo = $ano_periodo
				AND C.mes_periodo = $mes_periodo";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		$i = 0;
			foreach ($query->result() as $row){
      			$nombre = $row->nom_usuario;
    		}   			
   		}
		$this->db->close();
    	return strtoupper($nombre);
    }
    
    //Obtiene el nombre del logistico que le está realizando la crítica a un formulario
    function obtenerNombreLogistico($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$nombre = "";
    	$sql = "SELECT U.nom_usuario
				FROM rmmh_admin_control C, rmmh_admin_usuarios U
				WHERE C.fk_usuariologistica = U.id_usuario
				AND C.nro_orden = $nro_orden
				AND C.nro_establecimiento = $nro_establecimiento
				AND C.ano_periodo = $ano_periodo
				AND C.mes_periodo = $mes_periodo";
    	$query = $this->db->query($sql);
    	if ($query->num_rows() > 0){
    		$i = 0;
			foreach ($query->result() as $row){
      			$nombre = $row->nom_usuario;
    		}   			
   		}
		$this->db->close();
    	return strtoupper($nombre);
    }   
    
    
}//EOC    