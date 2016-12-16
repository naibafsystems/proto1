<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controlador para el modulo de administracion de RMMH
 * @author Daniel Mauricio D�az Forero - DMDiazF
 * @since  Julio 17 de 2012
 */


class Obtenersalario extends MX_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->helper("url");
        $this->load->helper("download");
        $this->load->library("session");
        $this->load->library("validarsesion");
        $this->load->library("danecrypt");
        $this->load->library("pagination"); //Este es el paginador propio de CodeIgniter        
        $this->load->library('phpexcel/PHPExcel');
    }
	
	//Funcion principal. Se ejecuta por defecto al cargar el controlador (Muestra la funcion Directorio)
	public function index(){		
		
		$this->load->model("periodo");
		$data["controller"] = "administrador";
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==4){
			$data['tipo_usuario']="ADMINISTRADOR";
		}
		$data["nom_usuario"] = $nom_usuario;
		$data["view"] = "administrador";
		$data["menu"] = "adminmenu";
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$this->load->view("layout",$data);		
	}
	
	//Actualiza el ano y el mes del periodo desde el combo de periodos del menu del administrador.
	public function actualizarPeriodo(){
		$periodo = $this->input->post("cmbPeriodo");
		$ano = substr($periodo,0,4);
		$mes = substr($periodo,4,strlen($periodo));
		if (($ano!="----")&&($mes!="--")){
			$this->session->unset_userdata('ano_periodo');
			$this->session->unset_userdata('mes_periodo');
			$this->session->set_userdata('ano_periodo', $ano);
			$this->session->set_userdata('mes_periodo', $mes);
		}
		redirect('/administrador', 'location', 301);
	}
	
	public function obtenerSalario(){
		$this->load->model("periodo");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$salario = $this->periodo->obtenerSalarioPeriodo($ano_periodo, $mes_periodo);
		echo json_encode($salario);
	}

	
		
	//Cierra la sesion del usuario cuando se da click en la opcion salir del menu	
	public function cerrarSesion(){
		$this->load->helper("url");
		$this->load->library("session");
		$this->session->sess_destroy();
		redirect("login","refresh");
	}
	
				
	//Muestra el consolidado de los m�dulos II, III y IV para las empresas.)
	public function mostrarConsolidado($nro_orden){
		$this->load->model("control");
		$this->load->model("periodo");
		$this->load->model("usuario");
		$this->load->model("consolidado");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$tipoUsuario=$this->session->userdata("tipo_usuario");
		$data["empresa"] = $this->usuario->obtenerNombreEmpresa($nro_orden, $ano_periodo, $mes_periodo);
		$data["modulo2"] = $this->consolidado->obtenerModulo2($nro_orden, $ano_periodo, $mes_periodo);
		$data["modulo3"] = $this->consolidado->obtenerModulo3($nro_orden, $ano_periodo, $mes_periodo);
		$data["modulo4"] = $this->consolidado->obtenerModulo4($nro_orden, $ano_periodo, $mes_periodo);
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		
		$data["nom_usuario"] = $nom_usuario;
		$data["nro_orden"] = $nro_orden;
		$data["controller"] = "logistica";
		
		//Muestra el menu dependiendo del rol del usuario. 4 administrador
		if($tipoUsuario==4){
			$data["menu"] = "adminmenu";
			$data['tipo_usuario']="ADMINISTRADOR";
		}
		elseif($tipoUsuario==6){
			$data["menu"] = "tematicamenu";
			$data['tipo_usuario']="TEMATICO";
		}
		else{
			$data["menu"] = "logmenu";
			$data['tipo_usuario']="LOGISTICA";
		}
		$data["view"] = "consolidadoEmpresa";
		
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$this->load->view("layout",$data);
	}

}//EOC
	
	
?>