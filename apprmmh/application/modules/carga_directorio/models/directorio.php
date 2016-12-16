<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Directorio extends CI_Model {

    function __construct(){        
        parent::__construct();
        $this->load->database();
        $this->load->library("session");        
    }
    
    function conteoDirectorio($ano_periodo, $mes_periodo){
    	 $novedad = 9;
    	 $sql = "SELECT COUNT(*) AS total
    	         FROM rmmh_admin_control
    	         WHERE ano_periodo = $ano_periodo
    	         AND mes_periodo = $mes_periodo";
    	 $query = $this->db->query($sql);
    	 if ($query->num_rows() > 0){
    	 	foreach($query->result() as $row){
	    		if ($row->total == 0){
	    			$novedad = 5;
	    		}
	    		else{
	    			$novedad = 9;
	    		}   			
	    	}
    	 }
    	 $this->db->close();
    	 return $novedad;
    }
    
    public function validarDirectorioEmpresa($index, $campo){
    	$result = true;
    	switch($index){
    		case 1: //Validar que la empresa no exista en la tabla rmmh_admin_empresas
    			    $sql = "SELECT COUNT(*) AS total FROM rmmh_admin_empresas WHERE nro_orden = $campo";
    			    $query = $this->db->query($sql);
    				foreach($query->result() as $row){
	    				if ($row->total == 0){
	    					$result = true; //No existe la empresa. Se puede ingresar el registro.
	    				}
	    				else{
	    					$result = false; //Si existe la empresa. NO se puede ingresar el registro.
	    				}   			
	    			}	    
    			    break;
    		case 2: //Validar que el nit de la empresa no exista en la tabla rmmh_admin_empresas
    				$sql = "SELECT COUNT(*) AS total FROM rmmh_admin_empresas WHERE idnit = $campo";
    				$query = $this->db->query($sql);
    				foreach($query->result() as $row){
	    				if ($row->total == 0){
	    					$result = true; //No existe el nit. Se puede ingresar el registro.
	    				}
	    				else{
	    					$result = false; //Si existe el nit. NO se puede ingresar el registro.
	    				}   			
	    			}	    
    			    break;
    		case 3: //Convertir la razon social que viene desde el archivo plano todo a mayusculas
    				$result = true;	
    				break;
    		case 4: //Validar que el departamento exista
    				$sql = "SELECT COUNT(*) AS total FROM rmmh_param_deptos WHERE id_depto = $campo";
    				$query = $this->db->query($sql);
    				foreach($query->result() as $row){
	    				if ($row->total == 0){
	    					$result = false; //No existe el departamento. NO se puede ingresar el registro.
	    				}
	    				else{
	    					$result = true; //Si existe el Departamento. Se puede ingresar el registro.
	    				}   			
	    			}
	    			break;
    		case 5: //Validar que el municipio exista
    			    $sql = "SELECT COUNT(*) AS total FROM rmmh_param_mpios WHERE id_mpio = $campo";    			    
    			    $query = $this->db->query($sql);
    				foreach($query->result() as $row){
	    				if ($row->total == 0){
	    					$result = false; //No existe el municipio. NO se puede ingresar el registro.
	    				}
	    				else{
	    					$result = true; //Si existe el municipio. Se puede ingresar el registro.
	    				}   			
	    			}		    	    
    	}
    	return $result;
    }
    
    
    
    //Se valida la informacion que contiene el archivo plano de empresas.
    //-- validar que el nro de orden exista
    //-- validar que el nro de establecimiento no este repetido (no exista)
    //-- validar que el municipio exista
    //-- validar que el departamento exista
    //-- validar que la actividad CIIU exista
    //-- validar que la sede exista
    //-- validar que la subsede exista
    //-- validar que el tipo de inclusion este entre 1- Forzosa 2-Probabilística
    public function validarDirectorioEstablecimientos($index, $campo){
    	$result = true;
    	switch($index){
    		case 1: //Validar que el nro de orden exista. (Ya esté creada la empresa).
    				$sql = "SELECT COUNT(*) AS total FROM rmmh_admin_empresas WHERE nro_orden = $campo";
    				$query = $this->db->query($sql);
    				foreach($query->result() as $row){
	    				if ($row->total == 0){
	    					$result = false; //No existe la empresa. NO se puede ingresar el registro.
	    				}
	    				else{
	    					$result = true; //Si existe la empresa. Se puede ingresar el registro.
	    				}   			
	    			}	    
    			    break;    			    
    		case 2: //Validar que el nro de establecimiento no esté repetido. (Que no exista el establecimiento).
    			    $sql = "SELECT COUNT(*) AS total 
    			            FROM rmmh_admin_establecimientos 
    			            WHERE nro_establecimiento = $campo";
    			    $query = $this->db->query($sql);
    			    foreach($query->result() as $row){
    			    	if ($row->total == 0){
    			    		$result = true; //No existe el establecimiento. Se puede agregar el registro.
    			    	}
    			    	else{
    			    		$result = false; //Si existe el establecimiento. NO se puede agregar el registro.
    			    	}
    			    }
    			    break;
    		case 3: //Validar que el municipio exista
    				$sql = "SELECT COUNT(*) AS total FROM rmmh_param_mpios WHERE id_mpio = $campo";
    				$query = $this->db->query($sql);
    				foreach($query->result() as $row){
    					if ($row->total == 0){
    						$result = false; //No existe el municipio. NO se puede agregar el registro.
    					}
    					else{
    						$result = true; //Si existe el municipio. Se puede agregar el registro.
    					}
    				}
    			    break;
    		case 4: //Validar que el departamento exista
    			    $sql = "SELECT COUNT(*) AS total FROM rmmh_param_deptos WHERE id_depto = $campo";
    			    $query = $this->db->query($sql);
    			    foreach($query->result() as $row){
    			    	if ($row->total == 0){
    			    		$result = false; //No existe el departamento. NO se puede agregar el registro.
    			    	}
    			    	else{
    			    		$result = true; //Si existe el departamento. se puede agregar el registro.
    			    	}
    			    }
    			    break;
    		case 5: //Validar que la actividad CIIU exista
    				$sql = "SELECT COUNT(*) AS total FROM rmmh_param_ciiu3 WHERE id_ciiu = $campo";
    				$query = $this->db->query($sql);
    				foreach($query->result() as $row){
    					if ($row->total == 0){
    						$result = false; //No existe la actividad. NO se puede agregar el registro.
    					}
    					else{
    						$result = true; //Si existe la actividad. Se puede agregar el registro.
    					}
    				}
    			    break;
    		case 6: //Validar que la sede exista
    			    $sql = "SELECT COUNT(*) AS total FROM rmmh_param_sedes WHERE id_sede = $campo";
    			    $query = $this->db->query($sql);
    			    foreach($query->result() as $row){
    			    	if ($row->total == 0){
    			    		$result = false; //No existe la sede. NO se puede agregar el registro.
    			    	}
    			    	else{
    			    		$result = true; //Si existe la sede. se puede agregar el registro. 
    			    	}
    			    }
    			    break;
    		case 7: //Validar que la subsede exista
    			    $sql = "SELECT COUNT(*) AS total FROM rmmh_param_subsedes WHERE id_subsede = $campo";
    			    $query = $this->db->query($sql);
    				foreach($query->result() as $row){
    			    	if ($row->total == 0){
    			    		$result = false; //No existe la subsede. NO se puede agregar el registro.
    			    	}
    			    	else{
    			    		$result = true; //Si existe la subsede. se puede agregar el registro. 
    			    	}
    			    }
    			    break;
    		case 8: //Validar que el tipo de inclusion esté entre (1. Forzosa y 2. Probabilística)
    			    if (($campo==1)||($campo==2)){
    			    	$result = true; //El tipo de inclusion está entre forzosa y probabilistica
    			    }
    			    else{
    			    	$result = false;
    			    }
    			    break;  	    	     
    	}
    	return $result;
    }
    
	function validarEstablecimientoPeriodo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo){
    	$result = "";
    	$sql = "SELECT COUNT(*) AS total
                FROM rmmh_admin_control C, rmmh_admin_establecimientos ES
                WHERE C.nro_orden = ES.nro_orden
                AND C.nro_establecimiento = ES.nro_establecimiento
                AND C.nro_orden = $nro_orden
                AND C.nro_establecimiento = $nro_establecimiento
                AND C.ano_periodo = $ano_periodo
                AND C.mes_periodo = $mes_periodo";
    	$query = $this->db->query($sql);
    	foreach($query->result() as $row){
    		if ($row->total == 0){
    			$result = true; //No existe el establecimiento registrado para el periodo. Debe agregarse el registro. 
    		}
    		else{
    			$result = false; //Ya existe el establecimiento registrado para ese periodo.
    		}
    	}
    	$this->db->close();
    	return $result;
    }
    
    
}

?>