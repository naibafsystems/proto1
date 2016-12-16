<?php  class anexos extends MX_Controller {

			public function __construct(){
				parent::__construct();
				$helpers = array("form","url","file");
				$this->load->helper($helpers);				
				$this->load->library("session");
			}
			
			public function index($nro_orden, $nro_establecimiento){
				$this->load->model("");
				$data["error"] = "";		
				$this->anexos2->prueba();		
				$this->load->view("anexos",$data);
			}
			
			
			/****
			function __construct(){
				parent::__construct();
				$helpers = array("form","url","file");
				$this->load->helper($helpers);
			}

			function index(){
				$this->load->view('upload_form', array('error' => ' ' ));
			}

			function do_upload(){
				$this->load->model("soportes");
				$config['upload_path'] = './uploads/';
				$config['allowed_types'] = 'gif|jpg|png|pdf';				
				$config['max_size']	= '3000';
				$config['max_width']  = '1024';
				$config['max_height']  = '768';

				$this->load->library('upload', $config);
				if (!$this->upload->do_upload()){
					//No se logró subir el archivo
					$error = array('error' => $this->upload->display_errors());
					$this->load->view('upload_form', $error);
				}
				else{
					//Se logró subir el archivo al servidor
					$data = array('upload_data' => $this->upload->data());
			
					//Desbaratar el upload y empezar a armar el BLOB
					//Verificar que el archivo existe en la ruta de uploads
					if (file_exists($data["upload_data"]["full_path"])){
						$string = read_file($data["upload_data"]["full_path"]);
						if (!$string){
							$error = array('error' => $this->upload->display_errors());
							$this->load->view('upload_form',$error);
						}
						else{
							//var_dump($string);
							//Agregar el registro del soporte cargado en la B.D.
							$periodo = "2012";
							$numemp = "10200227";
							$estable = "10200227";
							$this->soportes->agregarSoporte($periodo, $numemp, $estable, $string, $data["upload_data"]["file_name"], $data["upload_data"]["file_size"], $data["upload_data"]["file_type"]);
					
							//Mostrar el soporte que se cargo en la base de datos
							$datos["soportes"] = $this->soportes->obtenerSoportes();
							$this->load->view("tabla",$datos);
						}
					}
					else{
						$error = array('error' => $this->upload->display_errors());
						$this->load->view('upload_form', $error);
					}
				}		
			}
	
			function mostrarSoporte($id){
				$this->load->model("soportes");
				$soporte = $this->soportes->obtenerSoporte($id);		
				$tipo = $soporte["soporte_tipo"];
				$nombre = $soporte["soporte_nombre"];
				$contenido = $soporte["soporte_binario"];
		
				header("Content-type: $tipo");	 
				header("Content-Disposition: inline; filename=$nombre");
				print $contenido;
			}
			***/	
		
		}//EOC
?>