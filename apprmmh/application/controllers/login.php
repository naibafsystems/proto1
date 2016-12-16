<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controlador para la validacion de acceso mediante usuario y contraseña
 * @author Daniel Mauricio Díaz Forero - DMDiazF
 * @since  Marzo 06 de 2012
 */

class Login extends CI_Controller {
    
	//Carga la vista para el login de usuarios. Se carga por defecto al iniciar la aplicacion (ver aplication/config/routes.php)
	public function index(){
		$this->load->library("session");
		//$this->session->sess_destroy();
		$this->config->load("sitio");
		$this->load->model("periodo");
		$ano = $this->session->userdata("ano_periodo"); 
	  	$mes = $this->session->userdata("mes_periodo");
	  	$data["nombre"]  = $this->session->userdata("nombre");
	  	$data["periodo"] = $this->periodo->obtenerNombrePeriodo($ano, $mes);
		$data["controller"] = "login";
		$data["view"] = "login/login";
		$this->load->view('layout',$data);		
	}
	
	//Recibe los datos del usuario y valida contra la B.D. que el usuario sea válido.
	public function validar(){		
		$this->load->model("usuario");
		$this->load->helper("url");
		$login = $this->input->post("txtLogin"); //Recibir por post con XSS_CLEAN
		$password = $this->input->post("txtPassword"); //Recibir por post con XSS_CLEAN		
		
		if ($this->usuario->validarUsuarioDANE($login, $password)){
			
			//var_dump("OK");
			
			$this->usuario->redireccionarUsuario();
		}
		else{
			
			//var_dump("ERROR");
			redirect('/login', 'location', 301); 
		}		
	}
	
	public function verificar(){
		$this->load->library("danecrypt");
		$password = "GFkFKbZHkDvjcCiCUwfohhWYR4kbmPM5y8i70G9kEM4";
		$decode = $this->danecrypt->decode($password);
		
		var_dump($decode);
	}
	
	
}//EOC

