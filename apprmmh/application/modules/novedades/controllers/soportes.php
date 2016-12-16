<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Soportes extends MX_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->helper("url");
        $this->load->helper("form");
        $this->load->library("validarsesion");
        $this->load->library("session");
        $this->load->library("general");
    }
    
    public function index(){
    	$nro_orden = $this->input->post("hddNroOrden");
    	$uni_local = $this->input->post("hddUniLocal");
    	$ano_periodo = $this->session->userdata("ano_periodo");	
    	$mes_periodo = $this->session->userdata("mes_periodo");
    	
    	$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png|pdf';
		$config['max_size']	= '2048'; //2 MB
		$this->load->library('upload', $config);
		
    	if (!$this->upload->do_upload("fileSoporte")){
			$data["error"] = array('error' => $this->upload->display_errors());
			$data["errorSP"] = $this->novedad->traducirError($data["error"]["error"]);
		}
		else{	
			$data["upload"] = array('upload_data' => $this->upload->data());
			$pathFile = $data["upload"]["upload_data"]["full_path"];
			$nombreFile = $data["upload"]["upload_data"]["file_name"];
			$tipoFile = $data["upload"]["upload_data"]["file_type"];
			$tamaFile = $data["upload"]["upload_data"]["file_size"];
			
			$binario = addslashes(fread(fopen($pathFile, "rb"), filesize($pathFile)));
			 
			
			$img = imagecreatefromjpeg($pathFile);
			
			var_dump($img);
			
			/*
			header("Content-type: $tipoFile");	 
  			header("Content-Disposition: inline; filename=$nombreFile");
  			imagejpeg($img);
			imagedestroy($img);
			
			*/
			
			
			
		}
		
    }
    
}//EOC
    
