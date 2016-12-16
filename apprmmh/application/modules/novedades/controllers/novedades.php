<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controlador para el modulo de administracion de RMMH
 * @author Daniel Mauricio Díaz Forero - DMDiazF
 * @since  Julio 17 de 2012
 */


class Novedades extends MX_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->helper("url");
        $this->load->helper("form");
        $this->load->library("validarsesion");
        $this->load->library("session");
        $this->load->library("general");
    }
    
    public function registro($nro_orden, $nro_establecimiento){
    	$this->load->model("novedad");
    	$this->load->model("soporte");
    	$this->load->model("usuario");
    	$this->load->model("periodo");
    	$idusuario = $this->session->userdata("id");
    	$data["controller"] = "administrador";
    	$data["ano_periodo"] = $this->session->userdata("ano_periodo");
    	$data["mes_periodo"] = $this->session->userdata("mes_periodo");    	
    	$data["estados_novedad"] = $this->novedad->obtenerEstadosNovedad();
    	$data["novedades"] = $this->novedad->obtenerNovedades();
    	$data["datos"] = $this->novedad->obtenerDatosFuenteNovedad($nro_orden, $nro_establecimiento, $data["ano_periodo"], $data["mes_periodo"]);
    	$data["novedad"] = $this->novedad->obtenerDatosNovedad($nro_orden, $nro_establecimiento, $data["ano_periodo"], $data["mes_periodo"]);
    	$data["rol"] = $this->usuario->obtenerRolUsuario($idusuario);
    	$data["coordinador"] = $idusuario;    	    	
    	$data["view"] = "novedades";
    	$data["menu"] = $this->novedad->obtenerMenu($data["rol"]);
    	$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
    	$data["bloqueo"] = $this->novedad->bloqueoCampos($data["rol"], $nro_orden, $nro_establecimiento, $data["ano_periodo"], $data["mes_periodo"]); //Se envía el rol como parametro para que este bloqueo solo se realice para los críticos, y solo cuando la novedad ya ha sido aprobada.    	
    	$this->load->view("layout",$data);
    }
    
    //Guarda la novedad que es reportada por uno de los críticos (SOLO GUARDA NOVEDADES PARA LOS CRITICOS). 
    public function guardarNovedad(){
    	$this->load->model("novedad");
    	$ano_periodo = $this->session->userdata("ano_periodo");
    	$mes_periodo = $this->session->userdata("mes_periodo");
    	foreach($_POST as $nombre_campo => $valor){
  			$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
  			eval($asignacion);
		}
		$fechaVisita = $this->general->formatoFecha($txtFechaVisita,'/');
		if ($hddOp=="upd"){
			$this->novedad->actualizarNovedadCritico($hddCritico, $fechaVisita, $cmbEstadoEST, $radConsultas, $cmbNovedad, $txtNombreFuncionario, $txtTelFuncionario, $txtCargoFuncionario, $txaObsCritico, $hddNroOrden, $hddNroEstablecimiento, $ano_periodo, $mes_periodo);
		}
		elseif ($hddOp=="ins"){
		    $this->novedad->guardarNovedadCritico($hddCritico, $fechaVisita, $cmbEstadoEST, $radConsultas, $cmbNovedad, $txtNombreFuncionario, $txtTelFuncionario, $txtCargoFuncionario, $txaObsCritico, $hddNroOrden, $hddNroEstablecimiento, $ano_periodo, $mes_periodo);
		}		
    }
    
    public function aprobarNovedad(){
    	$this->load->model("novedad");
    	$this->load->model("control");
    	$ano_periodo = $this->session->userdata("ano_periodo");
    	$mes_periodo = $this->session->userdata("mes_periodo");
    	foreach($_POST as $nombre_campo => $valor){
    		$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
    		eval($asignacion);
    	}
    	
    	//Pregunto si la novedad ya existe en la tabla de hist_novedades, y si ya existe, lo que hago es ir a actualizar el registro, 
    	//en caso de no existir la novedad, procedo a ingresarla en la tabla hist_novedades.
    	if ($this->novedad->verificarNovedadExiste($hddNroOrden, $hddNroEstablecimiento, $ano_periodo, $mes_periodo)){
    		//Debo actualizar la novedad. La novedad ya fue registrada por el crítico
    		$fechaVisita = $this->general->formatoFecha($txtFechaVisita,'/');
    		if($radAceptada==1){
    			//Si la novedad fue aceptada, se marca la novedad - estado en la tabla de control.
    			$this->novedad->actualizarNovedadCritico($hddCritico, $fechaVisita, $cmbEstadoEST, $radConsultas, $cmbNovedad, $txtNombreFuncionario, $txtTelFuncionario, $txtCargoFuncionario, $txaObsCritico, $hddNroOrden, $hddNroEstablecimiento, $ano_periodo, $mes_periodo); //Por si se modificó algo, se actualiza
    			$this->novedad->actualizarNovedadCoordinador($hddCoordinador, $radAceptada, $txaObsCoordinador, $hddNroOrden, $hddNroEstablecimiento, $ano_periodo, $mes_periodo); //Se Aprueba o rechaza
    			$this->control->actualizarNovedad($hddNroOrden, $hddNroEstablecimiento, $ano_periodo, $mes_periodo, $cmbNovedad); //Se modifica el registro de control
    		}
    		else if($radAceptada==0){
    			//Si la novedad fue rechazada, se registra el rechazo en hist_novedades, y el formulario continua en la misma novedad-estado en que venia.
    			$this->novedad->actualizarNovedadCritico($hddCritico, $fechaVisita, $cmbEstadoEST, $radConsultas, $cmbNovedad, $txtNombreFuncionario, $txtTelFuncionario, $txtCargoFuncionario, $txaObsCritico, $hddNroOrden, $hddNroEstablecimiento, $ano_periodo, $mes_periodo); //Por si se modificó algo, se actualiza
    			$this->novedad->actualizarNovedadCoordinador($hddCoordinador, $radAceptada, $txaObsCoordinador, $hddNroOrden, $hddNroEstablecimiento, $ano_periodo, $mes_periodo);
    			//Si el formulario ya habia sido marcado como novedad previamente, y luego se rechaza, actualizo el control en digitacion. si no estaba marcado como novedad, solo se rechaza, y no se actualiza el estado.    			
    			$datos = $this->control->obtenerNovedadEstado($hddNroOrden, $hddNroEstablecimiento, $ano_periodo, $mes_periodo); //Obtengo el estado y la novedad en la que está el registro en la tabla de control
    			if (($datos["novedad"]!=5)&&($datos["novedad"]!=9)&&($datos["novedad"]!=99)){ //Si ya tenían novedad, cambio la novedad.
    				//Actualizar novedad y estado a 5 - 1 Notificado. (Para que modifiquen datos y/o vuelvan a enviar el formulario nuevamente).
    				$_NOVEDAD = 5; $_ESTADO = 1;
    				$this->control->actualizarNovedadEstado($hddNroOrden, $hddNroEstablecimiento, $ano_periodo, $mes_periodo, $_NOVEDAD, $_ESTADO);		
    			}  			
    		}
    	}
    	else{
    		//La novedad aun no ha sido ingresada por el critico. Se esta ingresando totalmente por el administrador. Debo ingresarla a la tabla histnovedades
    		//Obtengo los datos del usuario que está diligenciando la novedad.
    		$fechaVisita = $this->general->formatoFecha($txtFechaVisita,'/');
    		$idusuario = $this->session->userdata("id");
    		//Ingreso la parte del reporte del critico.
    		$this->novedad->guardarNovedadCritico($idusuario, $fechaVisita, $cmbEstadoEST, $radConsultas, $cmbNovedad, $txtNombreFuncionario, $txtTelFuncionario, $txtCargoFuncionario, $txaObsCritico, $hddNroOrden, $hddNroEstablecimiento, $ano_periodo, $mes_periodo);
    		if ($radAceptada==1){  //Si se aprobó la novedad
    			$this->novedad->actualizarNovedadCritico($hddCritico, $fechaVisita, $cmbEstadoEST, $radConsultas, $cmbNovedad, $txtNombreFuncionario, $txtTelFuncionario, $txtCargoFuncionario, $txaObsCritico, $hddNroOrden, $hddNroEstablecimiento, $ano_periodo, $mes_periodo); //Por si se modificó algo, se actualiza
    			$this->novedad->actualizarNovedadCoordinador($hddCoordinador, $radAceptada, $txaObsCoordinador, $hddNroOrden, $hddNroEstablecimiento, $ano_periodo, $mes_periodo);
    			$this->control->actualizarNovedad($hddNroOrden, $hddNroEstablecimiento, $ano_periodo, $mes_periodo, $cmbNovedad); //Pone la novedad en estado distinto a (5,9,99) y el estado lo pone en 5.	
    		}	
    		else{  //Si se negó la novedad  
    			//Si la novedad fue rechazada, se registra el rechazo en hist_novedades, y el formulario continua en la misma novedad-estado en que venia.
    			$this->novedad->actualizarNovedadCritico($hddCritico, $fechaVisita, $cmbEstadoEST, $radConsultas, $cmbNovedad, $txtNombreFuncionario, $txtTelFuncionario, $txtCargoFuncionario, $txaObsCritico, $hddNroOrden, $hddNroEstablecimiento, $ano_periodo, $mes_periodo); //Por si se modificó algo, se actualiza
    			$this->novedad->actualizarNovedadCoordinador($hddCoordinador, $radAceptada, $txaObsCoordinador, $hddNroOrden, $hddNroEstablecimiento, $ano_periodo, $mes_periodo);
    		}
    	}
    	
    }
    
    
    public function uploadFile($nro_orden, $uni_local){
    	$this->load->model("novedad");
    	$this->load->model("usuario");
    	$this->load->model("soporte");
    	$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png|pdf';
		$config['max_size']	= '2048'; //2 MB
		$idusuario = $this->session->userdata("id");		
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$this->load->library('upload', $config);
		$data["novedades"] = $this->novedad->obtenerNovedades();
		$data["datos"] = $this->novedad->obtenerDatosFuenteNovedad($nro_orden, $uni_local, $ano_periodo, $mes_periodo);
		$data["novedad"] = $this->novedad->obtenerDatosNovedad($nro_orden, $uni_local, $ano_periodo, $mes_periodo);
		$data["rol"] = $this->usuario->obtenerRolUsuario($idusuario);	
		$data["soportes"] = $this->soporte->obtenerSoportes($nro_orden, $uni_local, $ano_periodo, $mes_periodo);
		$data["coordinador"] = $idusuario;
		$data["view"] = "novedades";
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
			$binario = addslashes(fread(fopen($pathFile, "r"), filesize($pathFile)));
			//$binario = addslashes (file_get_contents($pathFile));	
			$this->soporte->agregarSoporte($nombreFile, $tipoFile, $tamaFile, $binario, $nro_orden, $uni_local, $ano_periodo, $mes_periodo);
			redirect("novedades/registro/$nro_orden/$uni_local",'refresh');
		}
		$this->load->view('layout', $data);
    }
    
    
    function abrirArchivo($id){
    	error_reporting(E_ALL);
    	$this->load->model("soporte");
    	$soporte = $this->soporte->obtenerDatosSoporte($id);
    	$nombre = $soporte["nombre"];
    	$tipo = $soporte["tipo"];
    	$tama = $soporte["tamano"];
    	$contenido = $soporte["contenido"];
    	
    	
    	$image=imagecreatefromjpeg($content);
    	header("Content-type: $tipo");	 
  		header("Content-Disposition: inline; filename=$nombre");
  		echo($image);	
  		//exit(); 
  		 		
	}
  		
  	
    
    
	
}//EOC