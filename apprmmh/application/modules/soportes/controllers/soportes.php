<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Soportes extends MX_Controller {

		public function __construct(){
			parent::__construct();
			$this->load->helper(array("form","url","file"));				
			$this->load->library("session");
		}
			
		public function index($nro_orden, $nro_establecimiento){
			$this->load->model("soportes2");
			$ano_periodo = $this->session->userdata("ano_periodo");
			$mes_periodo = $this->session->userdata("mes_periodo");
			$data["error"] = "";		
			$data["nro_orden"] = $nro_orden;
			$data["nro_establecimiento"] = $nro_establecimiento;
			$data["soportes"] = $this->soportes2->obtenerSoportes($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);			
			$this->load->view("soportes",$data);
		}
		
		public function subirAnexo(){
			$this->load->model("soportes2");
			$nro_orden = $this->input->post("hddNumord");
			$nro_establecimiento = $this->input->post("hddNumest");
			$ano_periodo = $this->session->userdata("ano_periodo");
			$mes_periodo = $this->session->userdata("mes_periodo");
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|pdf';				
			$config['max_size']	= '3000';
			$config['max_width']  = '1024';
			$config['max_height']  = '768';
			$this->load->library("upload",$config);
			if (!$this->upload->do_upload()){
				//No se logró subir el archivo
				$error = array('error' => $this->upload->display_errors());
				//$this->load->view('soportes', $error);
				redirect("/novedades/registro/$nro_orden/$nro_establecimiento","refresh");
			}
			else{
				//Desbaratar el upload y empezar a armar el BLOB
				$data = array('upload_data' => $this->upload->data());
				if (file_exists($data["upload_data"]["full_path"])){
						$string = read_file($data["upload_data"]["full_path"]);
						if (!$string){
							$error = array('error' => $this->upload->display_errors());
							//$this->load->view('soportes',$error);
							//Se elimina el archivo que fue cargado al servidor
							delete_files($data["upload_data"]["full_path"]);
							unlink($data["upload_data"]["full_path"]); //Eliminar el archivo del servidor.
							//Se redirecciona al modulo de novedades
							redirect("/novedades/registro/$nro_orden/$nro_establecimiento","refresh");
						}
						else{
							//Agregar el registro del soporte cargado en la B.D.
							$this->soportes2->agregarSoporte($data["upload_data"]["file_name"], $data["upload_data"]["file_type"], $data["upload_data"]["file_size"], $string, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
							//Mostrar de nuevo los soportes que se han cargado en la base de datos
							$datos["soportes"] = $this->soportes2->obtenerSoportes($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
							//$this->load->view("soportes",$datos);
							//Se elimina el archivo que fue cargado al servidor
							delete_files($data["upload_data"]["full_path"]);
							unlink($data["upload_data"]["full_path"]); //Eliminar el archivo del servidor.
							//Se redirecciona al modulo de novedades
							redirect("/novedades/registro/$nro_orden/$nro_establecimiento","refresh");							
						}
				}
				else{
					$error = array('error' => $this->upload->display_errors());
					//$this->load->view('soportes', $error);
					redirect("/novedades/registro/$nro_orden/$nro_establecimiento","refresh");
				}
			}
		}
		
		function mostrarSoporte($id){
			$this->load->model("soportes2");
			$soporte = $this->soportes2->obtenerSoporte($id);
			$tipo = $soporte["tip_soporte"];
			$nombre = $soporte["nom_soporte"];
			$contenido = $soporte["bin_soporte"];
			header("Content-type: $tipo");	 
			header("Content-Disposition: inline; filename=$nombre");
			print $contenido;
		}
		
		function eliminarSoporte($id){
			$this->load->model("soportes2");
			$nro_orden = $this->input->post("hddNumord");
			$nro_establecimiento = $this->input->post("hddNumest");
			$datos = $this->soportes2->datosSoporte($id);
			$nro_orden = $datos["nro_orden"];
			$nro_establecimiento = $datos["nro_establecimiento"];
			$this->soportes2->eliminarSoporte($id);
			redirect("/novedades/registro/$nro_orden/$nro_establecimiento","refresh");			
		}
			
			
				
	}//EOC
?>