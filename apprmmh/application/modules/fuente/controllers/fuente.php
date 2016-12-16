<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controlador para el modulo de logistica de RMMH
 * @author Daniel Mauricio Díaz Forero - DMDiazF
 * @since  Julio 30 de 2012
 */


class Fuente extends MX_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->library("validarsesion");
        $this->load->library("session");
        $this->load->helper("url");
    }
    
    public function index(){
    	$this->load->model("periodo");
    	$this->load->model("divipola");
    	$this->load->model("control");    	
    	$this->load->model("modulo1");  
    	$this->load->model("modulo2"); 
    	$this->load->model("modulo3"); 
    	$this->load->model("modulo4");
    	$this->load->model("modulo5");
    	$this->load->model("envioform");
    	$nro_orden = $this->session->userdata("nro_orden");
    	$nro_establecimiento = $this->session->userdata("nro_establecimiento");
    	$ano_periodo = $this->session->userdata("ano_periodo");
    	$mes_periodo = $this->session->userdata("mes_periodo");
    	$nom_usuario = $this->session->userdata("nombre");
    	$tipo_usuario = $this->session->userdata("tipo_usuario");
    	if($tipo_usuario==1){
    		$data['tipo_usuario']="FUENTE";	
    	}
    	//$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
    	$data["periodos"] = $this->periodo->obtenerPeriodosPendientes($nro_orden, $nro_establecimiento);
    	$data["controller"] = "fuente";
    	$data["menu"] = "fuentemenu";
    	$data["view"] = "fuente";
    	$data["nom_usuario"] = $nom_usuario;
    	$data["nro_orden"] = $nro_orden;
    	$data["nro_establecimiento"] = $nro_establecimiento;
    	$data["departamentos"] = $this->divipola->obtenerDepartamentos();
		$data["municipios"] = $this->divipola->obtenerMunicipios(0); //Obtiene todos los municipios
		$data["categorias"] = $this->modulo5->obtenercategorias(); //Se pasan los datos necesarios para el modulo5.
    	$data["modulo1"] = $this->modulo1->obtenerModulo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);  //ESTE HACE POR EL MODULO 1
    	$data["modulo2"] = $this->modulo2->obtenerModulo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);  //ESTE HACE POR EL MODULO 2
    	$data["modulo3"] = $this->modulo3->obtenerModulo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);  //ESTE HACE POR EL MODULO 3
    	$data["modulo4"] = $this->modulo4->obtenerModulo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);  //ESTE HACE POR EL MODULO 4
    	$data["modulo5"] = $this->modulo5->obtenerModulo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);  //ESTE HACE POR EL MODULO 5
    	$data["envio"] = $this->envioform->obtenerModulo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
    	$data["tab_envio"] = $this->envioform->validarEnvioFormulario($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
    	
    	//En este array se almacenan los indices de las variables en los que se presentan errores
    	//en la variacion de la ficha de analisis.
    	$erroresIndices = array();
    	$nro_orden = $this->session->userdata("nro_orden");
    	$nro_establecimiento = $this->session->userdata("nro_establecimiento");
    	$ano_periodo = $this->session->userdata("ano_periodo");
    	$mes_periodo = $this->session->userdata("mes_periodo");
    	//Rango para la variación anual y mensual para la ficha de análisis.
    	
    	
    //Rango para la variación anual y mensual para la ficha de análisis.
		$tabla = "rmmh_form_ingoperacionales";
		$campo = "intio";
		$data[$campo]["actual"] = $this->envioform->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		
		if($data[$campo]["actual"]>0 && $data[$campo]["actual"]<=100000){
			$rango=25;
		}
		elseif($data[$campo]["actual"]>100000 && $data[$campo]["actual"]<=300000){
			$rango=20;
		}
		elseif($data[$campo]["actual"]>300000 && $data[$campo]["actual"]<=1200000){
			$rango=15;
		}
		elseif($data[$campo]["actual"]>1200000 && $data[$campo]["actual"]<=3000000){
			$rango=10;
		}
		elseif($data[$campo]["actual"]>3000000){
			$rango=5;
		}
		else{
			$rango=0;
		}
		
		$data["nro_orden"] = $nro_orden;
    	$data["nro_establecimiento"] = $nro_establecimiento;
    	//$data["novedad_estado"] = $this->control->obtenerNovedadEstado($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
    	
    	//Ingresos causados en el mes - INALO
    	$tabla = "rmmh_form_ingoperacionales";
    	$campo = "inalo";
    	$data[$campo]["actual"] = $this->envioform->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
    	$data[$campo]["anterior"] = $this->envioform->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
    	$data[$campo]["anual"] = $this->envioform->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
    	$data[$campo]["varmensual"] = $this->envioform->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
    	$data[$campo]["varanual"] = $this->envioform->calcularVariacionAnual($data["inalo"]["actual"], $data["inalo"]["anual"]);
    	//$data[$campo]["err1"] = $this->ficha->compararValor(">", $data[$campo]["varmensual"], 15);
    	//$data[$campo]["err2"] = $this->ficha->compararValor(">", $data[$campo]["varanual"], 15);
    	$data[$campo]["err1"] = $this->envioform->compararRango($data[$campo]["varmensual"], $rango); //Se compara si el valor está dentro del rango de [-15,15]
    	$data[$campo]["err2"] = $this->envioform->compararRango($data[$campo]["varanual"], $rango); //Se compara si el valor está dentro del rango de [-15,15]
    	if (($data[$campo]["err1"])||($data[$campo]["err2"])){
    		array_push($erroresIndices,1); //Se presentan errores en el indice 1 (INALO)
    	}
    	
    	//Ingresos causados en el mes - INALI
    	$tabla = "rmmh_form_ingoperacionales";
    	$campo = "inali";
    	$data[$campo]["actual"] = $this->envioform->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
    	$data[$campo]["anterior"] = $this->envioform->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
    	$data[$campo]["anual"] = $this->envioform->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
    	$data[$campo]["varmensual"] = $this->envioform->calcularVariacionMensual($data["inali"]["actual"], $data["inali"]["anterior"]);
    	$data[$campo]["varanual"] = $this->envioform->calcularVariacionAnual($data["inali"]["actual"], $data["inali"]["anual"]);
    	//$data[$campo]["err1"] = $this->ficha->compararValor(">", $data[$campo]["varmensual"], 15);
    	//$data[$campo]["err2"] = $this->ficha->compararValor(">", $data[$campo]["varanual"], 15);
    	$data[$campo]["err1"] = $this->envioform->compararRango($data[$campo]["varmensual"], $rango); //Se compara si el valor está dentro del rango de [-15,15]
    	$data[$campo]["err2"] = $this->envioform->compararRango($data[$campo]["varanual"], $rango); //Se compara si el valor está dentro del rango de [-15,15]
    	if (($data[$campo]["err1"])||($data[$campo]["err2"])){
    		array_push($erroresIndices,1); //Se presentan errores en el indice 1 (INALO)
    	}
    	
    	//Ingresos causados en el mes - INOE
    	$tabla = "rmmh_form_ingoperacionales";
    	$campo = "inoe";
    	$data[$campo]["actual"] = $this->envioform->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
    	$data[$campo]["anterior"] = $this->envioform->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
    	$data[$campo]["anual"] = $this->envioform->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
    	$data[$campo]["varmensual"] = $this->envioform->calcularVariacionMensual($data["inoe"]["actual"], $data["inoe"]["anterior"]);
    	$data[$campo]["varanual"] = $this->envioform->calcularVariacionAnual($data["inoe"]["actual"], $data["inoe"]["anual"]);
    	//$data[$campo]["err1"] = $this->ficha->compararValor(">", $data[$campo]["varmensual"], 15);
    	//$data[$campo]["err2"] = $this->ficha->compararValor(">", $data[$campo]["varanual"], 15);
    	$data[$campo]["err1"] = $this->envioform->compararRango($data[$campo]["varmensual"], $rango); //Se compara si el valor está dentro del rango de [-15,15]
    	$data[$campo]["err2"] = $this->envioform->compararRango($data[$campo]["varanual"], $rango); //Se compara si el valor está dentro del rango de [-15,15]
    	if (($data[$campo]["err1"])||($data[$campo]["err2"])){
    		array_push($erroresIndices,1); //Se presentan errores en el indice 1 (INALO)
    	}
    	
    	//Ingresos causados en el mes - INTIO
    	$campo = "intio";
    	$data[$campo]["actual"] = $this->envioform->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
    	$data[$campo]["anterior"] = $this->envioform->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
    	$data[$campo]["anual"] = $this->envioform->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
    	$data[$campo]["varmensual"] = $this->envioform->calcularVariacionMensual($data[$campo]["actual"], $data[$campo]["anterior"]);
    	$data[$campo]["varanual"] = $this->envioform->calcularVariacionAnual($data[$campo]["actual"], $data[$campo]["anual"]);
    	//$data[$campo]["err1"] = $this->ficha->compararValor(">", $data[$campo]["varmensual"], 15);
    	//$data[$campo]["err2"] = $this->ficha->compararValor(">", $data[$campo]["varanual"], 15);
    	$data[$campo]["err1"] = $this->envioform->compararRango($data[$campo]["varmensual"], $rango);
    	$data[$campo]["err2"] = $this->envioform->compararRango($data[$campo]["varanual"], $rango);
    	if (($data[$campo]["err1"])||($data[$campo]["err2"])){
    		array_push($erroresIndices,6); //Se presentan errores en el indice 6 (INTIO)
    	}
    	
    	//Personal ocupado y salarios causados en el mes - POTTOT
    	$tabla = "rmmh_form_persalarios";
    	$index = "pottot";
    	$campo = "pottot";
    	$data[$index]["actual"] = $this->envioform->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
    	$data[$index]["anterior"] = $this->envioform->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
    	$data[$index]["anual"] = $this->envioform->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
    	$data[$index]["varmensual"] = $this->envioform->calcularVariacionMensual($data[$index]["actual"], $data[$index]["anterior"]);
    	$data[$index]["varanual"] = $this->envioform->calcularVariacionAnual($data[$index]["actual"], $data[$index]["anual"]);
    	//$data[$index]["err1"] = $this->ficha->compararValor(">=", $data[$index]["varmensual"], 15);
    	//$data[$index]["err2"] = $this->ficha->compararValor(">=", $data[$index]["varanual"], 15);
    	$data[$index]["err1"] = $this->envioform->compararRango($data[$index]["varmensual"], $rango);
    	$data[$index]["err2"] = $this->envioform->compararRango($data[$index]["varanual"], $rango);
    	if (($data[$index]["err1"])||($data[$index]["err2"])){
    		array_push($erroresIndices,7); //Se presentan errores en el indice 7 (POTTOT)
    	}
    	
    	//Camas ocupadas o vendidas - ICVA
    	$tabla = "rmmh_form_caracthoteles";
    	$index = "icva";
    	$campo = "icva";
    	$data[$index]["actual"] = $this->envioform->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
    	$data[$index]["anterior"] = $this->envioform->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
    	$data[$index]["anual"] = $this->envioform->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
    	$data[$index]["varmensual"] = $this->envioform->calcularVariacionMensual($data[$index]["actual"], $data[$index]["anterior"]);
    	$data[$index]["varanual"] = $this->envioform->calcularVariacionAnual($data[$index]["actual"], $data[$index]["anual"]);
    	//$data[$index]["err1"] = $this->ficha->compararValor(">=", $data[$index]["varmensual"], 15);
    	//$data[$index]["err2"] = $this->ficha->compararValor(">=", $data[$index]["varanual"], 15);
    	$data[$index]["err1"] = $this->envioform->compararRango($data[$index]["varmensual"], $rango);
    	$data[$index]["err2"] = $this->envioform->compararRango($data[$index]["varanual"], $rango);
    	if (($data[$index]["err1"])||($data[$index]["err2"])){
    		array_push($erroresIndices,7); //Se presentan errores en el indice 7 (POTTOT)
    	}
    	
    	//Habitaciones ocupadas o vendidas - IHOA
    	$tabla = "rmmh_form_caracthoteles";
    	$index = "ihoa";
    	$campo = "ihoa";
    	$data[$index]["actual"] = $this->envioform->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
    	$data[$index]["anterior"] = $this->envioform->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
    	$data[$index]["anual"] = $this->envioform->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
    	$data[$index]["varmensual"] = $this->envioform->calcularVariacionMensual($data[$index]["actual"], $data[$index]["anterior"]);
    	$data[$index]["varanual"] = $this->envioform->calcularVariacionAnual($data[$index]["actual"], $data[$index]["anual"]);
    	//$data[$index]["err1"] = $this->ficha->compararValor(">=", $data[$index]["varmensual"], 15);
    	//$data[$index]["err2"] = $this->ficha->compararValor(">=", $data[$index]["varanual"], 15);
    	$data[$index]["err1"] = $this->envioform->compararRango($data[$index]["varmensual"], $rango);
    	$data[$index]["err2"] = $this->envioform->compararRango($data[$index]["varanual"], $rango);
    	if (($data[$index]["err1"])||($data[$index]["err2"])){
    		array_push($erroresIndices,7); //Se presentan errores en el indice 7 (POTTOT)
    	}
    	
    	//Total huéspedes - huetot
    	$tabla = "rmmh_form_caracthoteles";
    	$index = "huetot";
    	$campo = "huetot";
    	$data[$index]["actual"] = $this->envioform->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
    	$data[$index]["anterior"] = $this->envioform->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
    	$data[$index]["anual"] = $this->envioform->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
    	$data[$index]["varmensual"] = $this->envioform->calcularVariacionMensual($data[$index]["actual"], $data[$index]["anterior"]);
    	$data[$index]["varanual"] = $this->envioform->calcularVariacionAnual($data[$index]["actual"], $data[$index]["anual"]);
    	//$data[$index]["err1"] = $this->ficha->compararValor(">=", $data[$index]["varmensual"], 15);
    	//$data[$index]["err2"] = $this->ficha->compararValor(">=", $data[$index]["varanual"], 15);
    	$data[$index]["err1"] = $this->envioform->compararRango($data[$index]["varmensual"], $rango);
    	$data[$index]["err2"] = $this->envioform->compararRango($data[$index]["varanual"], $rango);
    	if (($data[$index]["err1"])||($data[$index]["err2"])){
    		array_push($erroresIndices,7); //Se presentan errores en el indice 7 (POTTOT)
    	}
    	
    	//Valido si ya todos los capitulos han sido diligenciados. Si es así, el estado del formulario pasa a 5-3 ó 9-3 (Digitado).
    	//Cuando se recarga la pagina, si ya todos los capitulos estan diligenciados, se cambia la novedad y el estado del formulario a 5-3 (Diligenciado).
		if ($data["tab_envio"]){
			//Obtengo la novedad con la que debo actualizar control
			$novedad = $this->control->obtenerNovedad($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo); //Obtener la novedad en la que está el formulario
			if (($novedad==5)||($novedad==9)){  //Si el formulario aun no ha sido verificado por la critica
				$this->control->actualizarNovedadEstado($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $novedad, 3); //El formulario ha sido digitado
			}
		}
    	$data["bloqueo"] = $this->control->bloquearCampos();
    	$data["pyz"] = $this->envioform->datosPazYSalvo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
    	$data["pazysalvo"] = $this->control->validarPazYSalvo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
    	
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
		redirect('/fuente', 'location', 301);
	}
    
	public function generarPDF(){
		$this->load->helper("dompdf_helper");
		$this->load->model("modulo1");
		$this->load->model("modulo2");
		$this->load->model("modulo3");
		$this->load->model("modulo4");
		$nro_orden = $this->session->userdata("nro_orden");
		$nro_establecimiento = $this->session->userdata("nro_establecimiento");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$data["modulo1"] = $this->modulo1->obtenerModulo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data["modulo2"] = $this->modulo2->obtenerModulo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data["modulo3"] = $this->modulo3->obtenerModulo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);  
		$data["modulo4"] = $this->modulo4->obtenerModulo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo); 
		$html = $this->load->view("generapdf",$data,true);
		generarPdf($html,'reporte','letter','portrait');
	}
	
	public function descarga(){
		$this->load->helper("download");
		$file = "./res/formrmmh.pdf";
		if (file_exists($file)){
			$data = file_get_contents($file); // Read the file's contents
			$name = 'formulario.pdf';
			force_download($name, $data); 
		}
	}
	
	public function descargaManual(){
		$this->load->helper("download");
		$file = "./res/man_fuente.pdf";
		if (file_exists($file)){
			$data = file_get_contents($file); // Read the file's contents
			$name = 'manual.pdf';
			force_download($name, $data); 
		}
	}
	
	public function opcionesUsuario($err){
		$this->load->model("control");
		$data["controller"] = "fuente";
		$data["menu"] = "fuentemenu";
		$data["view"] = "opciones";
		$data["bloqueo"] = $this->control->bloquearCampos();
		switch($err){
			case 1:  $data["error"] = "Se ha cambiado la contrase&ntilde;a exitosamente.";
			         break;
			case 2:  $data["error"] = "La contrase&ntilde;a actual no coincide.";
			         break;
			default: $data["error"] = "";
			         break;
		}
		$this->load->view("layout",$data);
	}
    
	//Cierra la sesion de usuario y retorna al login
    public function cerrarSesion(){
		$this->load->helper("url");
		$this->load->library("session");
		$this->session->sess_destroy();
		redirect("login","refresh");
	}
	
	//Cambiar la contraseña desde las opciones de usuario
	public function cambiarClave(){
		$this->load->model("usuario");
		$idusuario = $this->session->userdata("id");
		$claveActual = $this->input->post("txtClaveActual");
		$claveNueva = $this->input->post("txtNuevaClave");
		$confirmacion = $this->input->post("txtConfirm");
		if ($this->usuario->compararPassword($idusuario, $claveActual)){
			$this->usuario->cambiarPassword($idusuario, $claveNueva);
			redirect('/fuente/opcionesUsuario/1', 'refresh');				
		}
		else{
			redirect('/fuente/opcionesUsuario/2', 'refresh');
		}
	}
    
	/**********************************************************************************************************************************************/
	
    //Funciones AJAX
    //Guarda/Actualiza los datos de la caratula que han sido enviados desde el modulo I de la encuesta
	public function actualizarModuloI(){
		
		//var_dump($this->input->post()); die();
		$this->load->model("control");	
		$this->load->model("modulo1");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		foreach($_POST as $nombre_campo => $valor){
  			$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   			
  			eval($asignacion);
		}
		$this->modulo1->actualizarModulo($nro_orden, $nro_establecimiento, $idnit, $idproraz, $idnomcom, $idsigla, $iddirecc, $iddepto, $idmpio, $idtelno, $idfaxno, $idpagweb, $idcorreo, $finicial, $ffinal,$idnomcomest, $idsiglaest, $iddireccest, $iddeptoest, $idmpioest, $idtelnoest, $idfaxnoest, $idcorreoest, $nom_cadena, $nom_operador);
		//$this->modulo1->actualizarModulo($nro_orden, $nro_establecimiento, $idnit, $idproraz, $idnomcom, $idsigla, $iddirecc, $iddepto, $idmpio, $idtelno, $idfaxno, $idpagweb, $idcorreo, $idnomcomest, $idsiglaest, $iddireccest, $iddeptoest, $idmpioest, $idtelnoest, $idfaxnoest, $idcorreoest, $nom_cadena);
		$this->control->actualizarControl($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 'modulo1', 2); //Estado del modulo 1 en (2 - Diligenciado)
		$novedad = $this->control->obtenerNovedad($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo); //Obtener la novedad en la que está el formulario
		$this->control->actualizarNovedadEstado($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $novedad, 2); //Actualizar el estado de control (5 Deuda - 2 Digitacion)
	}	
	
	
	//Guarda/Actualiza los datos del modulo II de la encuesta
	public function actualizarModuloII(){
		$this->load->model("control");
		$this->load->model("modulo2");
		$this->load->model("observaciones");
		$id_usuario = $this->session->userdata("id");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		foreach($_POST as $nombre_campo => $valor){
  			$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   			
  			eval($asignacion);
		}
		//Si viene definida alguna justificacion en el formulario, debe guardarse la justificacion en la B.D.
		if (!isset($obsgpssde)){
			$obsgpssde = "";
		}
		if (!isset($obsgppgpa)){
			$obsgppgpa = "";
		}
		
		$estado = $this->control->obtenerEstadoModulo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo,'modulo2');
		if (($op=='insert')&&($estado==0)){
			//Insertar el registro en la tabla del modulo II
			$this->modulo2->insertarModulo($potpsfr, $potperm, $gpper, $pottcde, $gpssde, $pottcag, $gpppta, $potpau, $gppgpa, $pottot, $gpsspot, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
			//Actualizar el registro de la tabla de control
			$this->observaciones->actualizarObservacion($id_usuario, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 2, 'gpssde', $gpssde, $obsgpssde);
			$this->observaciones->actualizarObservacion($id_usuario, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 2, 'gppgpa', $gppgpa, $obsgppgpa);
			$this->control->actualizarControl($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 'modulo2', 2); //Estado del modulo 2 en (2 - Diligenciado)
			$novedad = $this->control->obtenerNovedad($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo); //Obtener la novedad en la que está el formulario
			$this->control->actualizarNovedadEstado($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $novedad, 2); //Actualizar el estado de control (5 Deuda - 2 Digitacion)
		}
		elseif(($op=='update')&&($estado!=0)){
			//Update sobre el registro de la tabla del modulo II
			$this->modulo2->actualizarModulo($potpsfr, $potperm, $gpper, $pottcde, $gpssde, $pottcag, $gpppta, $potpau, $gppgpa, $pottot, $gpsspot, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
			//Actualizar el registro de la tabla de control
			$this->observaciones->actualizarObservacion($id_usuario, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 2, 'gpssde', $gpssde, $obsgpssde);
			$this->observaciones->actualizarObservacion($id_usuario, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 2, 'gppgpa', $gppgpa, $obsgppgpa);
			$this->control->actualizarControl($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 'modulo2', 2); //Estado del modulo 2 en (2 - Diligenciado)
			$novedad = $this->control->obtenerNovedad($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo); //Obtener la novedad en la que está el formulario
			$this->control->actualizarNovedadEstado($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $novedad, 2); //Actualizar el estado de control (5 Deuda - 2 Digitacion)
		}
	}
	
	//Funciones AJAX
	//Guarda/Actualiza los datos del modulo III de la encuesta
	public function actualizarModuloIII(){
		$this->load->model("control");
		$this->load->model("modulo3");
		$this->load->model("observaciones");
		$id_usuario = $this->session->userdata("id");
		$nro_orden = $this->session->userdata("nro_orden");
		$nro_establecimiento = $this->session->userdata("nro_establecimiento");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		foreach($_POST as $nombre_campo => $valor){
  			$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
  			eval($asignacion);
		}
		//Si viene definida alguna justificacion en el formulario, debe guardarse la justificacion en la B.D.
		if (!isset($obsintio1)){
			$obsintio1 = "";
		}
		if (!isset($obsintio2)){
			$obsintio2 = "";
		}
		if (!isset($obsinalo)){			
			$obsinalo = "";
		}
		if (!isset($obsinoio)){
			$obsinoio = "";
		}
		if (!isset($obsinoe)){
			$obsinoe = "";
		}
		
		$estado = $this->control->obtenerEstadoModulo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo,'modulo3');
		if (($op=='insert')&&($estado==0)){
			//Insertar el registro en la tabla del modulo III
			$this->modulo3->insertarModulo($inalo, $inali, $inba, $insr, $inoe, $inoio, $intio, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
			//Actualizar el registro de la tabla de control
			$this->observaciones->actualizarObservacion($id_usuario, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 3, 'intio1', $intio, $obsintio1);
			$this->observaciones->actualizarObservacion($id_usuario, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 3, 'intio2', $intio, $obsintio2);
			$this->observaciones->actualizarObservacion($id_usuario, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 3, 'inalo', $inalo, $obsinalo);
			$this->observaciones->actualizarObservacion($id_usuario, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 3, 'inoio', $inoio, $obsinoio);
			$this->observaciones->actualizarObservacion($id_usuario, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 3, 'inoe', $inoe, $obsinoe);
			$this->control->actualizarControl($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 'modulo3', 2); //Estado del modulo 3 en (2 - Diligenciado)
			$novedad = $this->control->obtenerNovedad($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo); //Obtener la novedad en la que está el formulario
			$this->control->actualizarNovedadEstado($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $novedad, 2); //Actualizar el estado de control (5 Deuda - 2 Digitacion)
		}
		else if(($op=='update')&&($estado!=0)){
			//Update sobre el registro de la tabla del modulo III
			$this->modulo3->actualizarModulo($inalo, $inali, $inba, $insr, $inoe, $inoio, $intio, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
			//Actualizar el registro de la tabla de control
			$this->observaciones->actualizarObservacion($id_usuario, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 3, 'intio1', $intio, $obsintio1);
			$this->observaciones->actualizarObservacion($id_usuario, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 3, 'intio2', $intio, $obsintio2);
			$this->observaciones->actualizarObservacion($id_usuario, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 3, 'inalo', $inalo, $obsinalo);
			$this->observaciones->actualizarObservacion($id_usuario, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 3, 'inoio', $inoio, $obsinoio);
			$this->observaciones->actualizarObservacion($id_usuario, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 3, 'inoe', $inoe, $obsinoe);
			$this->control->actualizarControl($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 'modulo3', 2); //Estado del modulo 3 en (2 - Diligenciado)
			$novedad = $this->control->obtenerNovedad($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo); //Obtener la novedad en la que está el formulario
			$this->control->actualizarNovedadEstado($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $novedad, 2); //Actualizar el estado de control (5 Deuda - 2 Digitacion)			
		}
	}
	
	//Funciones AJAX
	//Guarda/Actualiza los datos del modulo IV de la encuesta
	public function actualizarModuloIV(){
		$this->load->model("control");
		$this->load->model("modulo4");
		$this->load->model("observaciones");
		$id_usuario = $this->session->userdata("id");
		$nro_orden = $this->session->userdata("nro_orden");
		$nro_establecimiento = $this->session->userdata("nro_establecimiento");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$tphto = 0; //Se trata de una variable que no viene declarada dentro del formulario de captura;
		foreach($_POST as $nombre_campo => $valor){
  			$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
  			eval($asignacion);
		}
		
		//Si viene definida alguna justificacion en el formulario, debe guardarse la justificacion en la B.D.
		if (!isset($obsihoa)){
			$obsihoa = "";
		}
		if (!isset($obsicva)){
			//Guardar la observacion de la fuente
			$obsicva = "";
		}
		if (!isset($obshuetot)){
			//Guardar la observacion de la fuente
			$obshuetot = "";
		}
		if (!isset($obsthudob)){
			//Guardar la observacion de la fuente
			$obsthudob = "";
		}
		if (!isset($obsthusui)){
			//Guardar la observacion de la fuente
			$obsthusui = "";
		}
		if (!isset($obsthumult)){
			//Guardar la observacion de la fuente
			$obsthumult = "";
		}
		if (!isset($obsinalootr)){
			//Guardar la observacion de la fuente
			$obsinalootr = "";
		}
		
		$estado = $this->control->obtenerEstadoModulo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo,'modulo4');		
		if (($op=='insert')&&($estado==0)){
			//Insertar el registro en la tabla del modulo IV
			$this->modulo4->insertarModulo($ihdo, $ihoa, $icda, $icva, $ihpn, $ihpnr, $huetot, $mvnr, $mvcr, $mvor, $mvsr, $mvotr, $mvott, $mvnnr, $mvcnr, $mvonr, $mvsnr, $mvotnr, $mvottnr, $thsen, $thusen, $thdob, $thudob, $thsui, $thusui, $thmult, $thumult, $thotr, $thuotr, $thtot,  $tphto, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
			//Actualizar el registro en la tabla de control
			$this->observaciones->actualizarObservacion($id_usuario, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 4, 'ihoa', $ihoa, $obsihoa);
			$this->observaciones->actualizarObservacion($id_usuario, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 4, 'icva', $icva, $obsicva);
			$this->observaciones->actualizarObservacion($id_usuario, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 4, 'huetot', $huetot, $obshuetot);
			$this->observaciones->actualizarObservacion($id_usuario, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 4, 'thudob', $thudob, $obsthudob);
			$this->observaciones->actualizarObservacion($id_usuario, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 4, 'thusui', $thusui, $obsthusui);
			$this->observaciones->actualizarObservacion($id_usuario, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 4, 'thumult', $thumult, $obsthumult);
			$this->observaciones->actualizarObservacion($id_usuario, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 4, 'inalomul', $inalomul, $obsinalomul);
			$this->observaciones->actualizarObservacion($id_usuario, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 4, 'inalootr', $inalootr, $obsinalootr);
			$this->control->actualizarControl($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 'modulo4', 2); //Estado del modulo 4 en (2 - Diligenciado)
			$novedad = $this->control->obtenerNovedad($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo); //Obtener la novedad en la que está el formulario
			$this->control->actualizarNovedadEstado($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $novedad, 2); //Actualizar el estado de control (5 Deuda - 2 Digitacion)
		}
		else if(($op=='update')&&($estado!=0)){
			//Update sobre el registro de la tabla del modulo IV
			$this->modulo4->actualizarModulo($ihdo, $ihoa, $icda, $icva, $ihpn, $ihpnr, $huetot, $mvnr, $mvcr, $mvor, $mvsr, $mvotr, $mvott, $mvnnr, $mvcnr, $mvonr, $mvsnr, $mvotnr, $mvottnr, $thsen, $thusen, $thdob, $thudob, $thsui, $thusui, $thmult, $thumult, $thotr, $thuotr, $thtot, $tphto, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
			//Actualizar el registro en la tabla de control
			$this->observaciones->actualizarObservacion($id_usuario, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 4, 'ihoa', $ihoa, $obsihoa);
			$this->observaciones->actualizarObservacion($id_usuario, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 4, 'icva', $icva, $obsicva);
			$this->observaciones->actualizarObservacion($id_usuario, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 4, 'huetot', $huetot, $obshuetot);
			$this->observaciones->actualizarObservacion($id_usuario, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 4, 'thudob', $thudob, $obsthudob);
			$this->observaciones->actualizarObservacion($id_usuario, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 4, 'thusui', $thusui, $obsthusui);
			$this->observaciones->actualizarObservacion($id_usuario, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 4, 'thumult', $thumult, $obsthumult);
			$this->observaciones->actualizarObservacion($id_usuario, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 4, 'inalomul', $inalomul, $obsinalomul);
			$this->observaciones->actualizarObservacion($id_usuario, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 4, 'inalootr', $inalootr, $obsinalootr);
			$this->control->actualizarControl($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 'modulo4', 2); //Estado del modulo 4 en (2 - Diligenciado)
			$novedad = $this->control->obtenerNovedad($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo); //Obtener la novedad en la que está el formulario
			$this->control->actualizarNovedadEstado($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $novedad, 2); //Actualizar el estado de control (5 Deuda - 2 Digitacion)	
		}
	}
	
	public function actualizarModuloV(){
		$this->load->model("control");
		$this->load->model("modulo5");
		$nro_orden = $this->session->userdata("nro_orden");
		$nro_establecimiento = $this->session->userdata("nro_establecimiento");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		foreach($_POST as $nombre_campo => $valor){
  			$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
  			eval($asignacion);
  		}
		
		//Verificar el estado en el que se encuentra el modulo 5
		$estado = $this->control->obtenerEstadoModulo($nro_orden,$nro_establecimiento,$ano_periodo,$mes_periodo,'modulo5');		
		//Matriz que contiene cada uno de los checks de cada una de las areas.
		$matrix[1] = array("chkServicios11","chkServicios12","chkServicios13","chkServicios14","chkServicios15","chkServicios16","chkServicios17","chkServicios18","chkServicios19","chkServicios110","chkServicios111","chkServicios112");
		$matrix[2] = array("chkServicios21","chkServicios22","chkServicios23","chkServicios24","chkServicios25","chkServicios26","chkServicios27","chkServicios28","chkServicios29","chkServicios210","chkServicios211");
		$matrix[3] = array("chkServicios31","chkServicios32","chkServicios33","chkServicios34","chkServicios35","chkServicios36","chkServicios37","chkServicios38","chkServicios39","chkServicios310","chkServicios311","chkServicios312","chkServicios313");
		$matrix[4] = array("chkServicios41","chkServicios42","chkServicios43","chkServicios44","chkServicios45","chkServicios46","chkServicios47","chkServicios48","chkServicios49","chkServicios410","chkServicios411","chkServicios412");
		$matrix[5] = array("chkServicios51","chkServicios52","chkServicios53","chkServicios54","chkServicios55","chkServicios56","chkServicios57","chkServicios58","chkServicios59","chkServicios510");
		$matrix[6] = array("chkServicios61","chkServicios62","chkServicios63","chkServicios64","chkServicios65");
		$otro_servicio = $_REQUEST['otroServicio'];
		echo $op;
		if (($op=='insert')&&($estado==0)){
			$resultados = array(); //Array que contiene cada una de las areas 
			//Para cada una de las areas, recorro la matriz y preparo un string de cada area.
			for ($x=1; $x<=count($matrix); $x++){ //Recorre el array de checks 
				$cadena = "";
				for ($i=0; $i<count($matrix[$x]); $i++){ //Para cada array de checks construya la cadena del tipo "100000000001", y almacenela en resultados
					$string = '$valor=(isset($'.$matrix[$x][$i].'))?1:0;';
					eval($string);
					$cadena .= $valor;
				}
				$resultados[$x] = $cadena;
			}
		
			//Guardar los datos del modulo en la tabla del formulario
			$this->modulo5->insertarModulo($resultados[1], $resultados[2], $resultados[3], $resultados[4], $resultados[5], $resultados[6], $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $otro_servicio);
			//Actualizar los datos de control
			$this->control->actualizarControl($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 'modulo5', 2); //Estado del modulo 5 en (2 - Diligenciado)
			$novedad = $this->control->obtenerNovedad($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo); //Obtener la novedad en la que está el formulario
			$this->control->actualizarNovedadEstado($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $novedad, 2); //Actualizar el estado de control (5 Deuda - 2 Digitacion)
			//Acualiza el código ciiu en la tabla estableciilentos
			$this->modulo5->acualizaCodCiiu($resultados[1], $resultados[2], $resultados[3], $resultados[4], $resultados[5], $resultados[6], $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $otro_servicio);
		}
		else if(($op=='update')&&($estado!=0)){
			//Update sobre el registro de la tabla del modulo V
			$resultados = array(); //Array que contiene cada una de las areas 
			//Para cada una de las areas, recorro la matriz y preparo un string de cada area.
			for ($x=1; $x<=count($matrix); $x++){ //Recorre el array de checks 
				$cadena = "";
				for ($i=0; $i<count($matrix[$x]); $i++){ //Para cada array de checks construya la cadena del tipo "100000000001", y almacenela en resultados
					$string = '$valor=(isset($'.$matrix[$x][$i].'))?1:0;';
					eval($string);
					$cadena .= $valor;
				}
				$resultados[$x] = $cadena;
			}
			
			//Actualizar los datos del modulo en la tabla del formulario
			$this->modulo5->actualizarModulo($resultados[1], $resultados[2], $resultados[3], $resultados[4], $resultados[5], $resultados[6], $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $otro_servicio);
			//Actualizar los datos de control
			$this->control->actualizarControl($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 'modulo5', 2); //Estado del modulo 5 en (2 - Diligenciado)
			$novedad = $this->control->obtenerNovedad($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo); //Obtener la novedad en la que está el formulario
			$this->control->actualizarNovedadEstado($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $novedad, 2); //Actualizar el estado de control (5 Deuda - 2 Digitacion)
			//Acualiza el código ciiu en la tabla estableciilentos
			$data["categorias"] = $this->modulo5->obtenercategorias(); //Se pasan los datos necesarios para el modulo5.
			
			for ($i=0; $i<count($data["categorias"]); $i++){
				$j=$i+1;
				if($resultados[$j]>0){
					$this->modulo5->acualizaCodCiiu($data["categorias"][$i]['cod_ciiu'], $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				}	
			}  
		}
	} 
	
	//Funciones AJAX
	//Guarda/Actualiza los datos del envio del formulario de la encuesta.
	public function actualizarModuloEnvio(){
		$this->load->model("control");
		$this->load->model("envioform");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		foreach($_POST as $nombre_campo => $valor){
  			$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
  			eval($asignacion);
		}
		
		//Para poder enviar el formulario debo validar que todos los modulos ya hayan sido diligenciados
		if ($this->control->validarEnvioFuente($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo)){ 
			//Se hace el envío del formuario y todos sus modulos a la critica.
			//$estado corresponde al estado del capitulo de envio
			$estado = $this->control->obtenerEstadoModulo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo,'envio');
			if (($op=='insert')&&($estado==0)){ 
				$this->envioform->insertarModulo($fteObserv, $dmpio, $fedili, $repleg, $responde, $respoca, $teler, $emailr, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$this->control->actualizarControl($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 'envio', 2); //Estado del envio del formulario en (2 - Diligenciado)
			}
			else if(($op=='update')&&($estado!=0)){ 
				$this->envioform->actualizarModulo($fteObserv, $dmpio, $fedili, $repleg, $responde, $respoca, $teler, $emailr, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$this->control->actualizarControl($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 'envio', 2); //Estado del envio del formulario en (2 - Diligenciado)	
			}
			
			//OJO !!! - SE ACTUALIZA EL ESTADO Y LA NOVEDAD A 99 - 4  (SE ENVIA EL FORMULARIO AL CRITICO)
			if ($this->control->actualizarNovedadEstado($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 99, 4)){ //Actualizar el estado de control (99 Rinde - 4 Analisis/Verificacion)
				$data["cod"] = 0;
				$data["error"] = "El formulario ha sido enviado.";
			}
			else{
				$data["cod"] = 1;
				$data["error"] = utf8_encode("Por favor diligencie todos los módulos antes de enviar el formulario.");
			}
			echo json_encode($data);
		}
	}
	
	//Funciones AJAX
	//Obtiene las observaciones que se han realizado sobre los capitulos de un formulario (por parte de la fuente)
	public function obtenerObservaciones(){
		$this->load->model("observaciones");
		$campo = $this->input->post("campo");
		$modulo = $this->input->post("modulo");
		$idusuario = $this->session->userdata("id");
		$nro_orden = $this->session->userdata("nro_orden");		
		$nro_establecimiento = $this->session->userdata("nro_establecimiento");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$observaciones = $this->observaciones->obtenerObservaciones($idusuario, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $modulo, $campo);		
		echo json_encode($observaciones);
	}
    
    //Funciones AJAX
    //Carga un combo de municipios con base en la seleccion de un combo de departamentos
    public function actualizarMunicipios(){
		$this->load->model("divipola");
		$iddepto = $this->input->post("id");		
		$municipios = $this->divipola->obtenerMunicipios($iddepto);
		echo '<option value="-">Seleccione...</option>';
		for ($i=0; $i<count($municipios); $i++){
			echo '<option value="'.$municipios[$i]["codigo"].'">'.utf8_decode($municipios[$i]["nombre"]).'</option>';	
		}
	}
    
	public function guardarObservacion(){
		$this->load->model("control");
		$this->load->model("observacion");
		$operacion = $this->input->post("op");
		$index = $this->input->post("idx");
		$nro_orden = $this->session->userdata("nro_orden");
		$nro_establecimiento = $this->session->userdata("nro_establecimiento");
		$observacion = $this->input->post("obs");
		$fecha = date("Y-m-d h:i:s");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$idcritico = $this->session->userdata("id");
		$capitulo = 99; //Se indica que el capitulo 99 es la ficha de analisis.
		$campo = "ficha_analisis_".$index;
		if ($operacion=='I'){ //Insertar una nueva observacion.
			$this->observacion->guardarObservacion($capitulo, $campo, $observacion, $fecha, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $idcritico);
		}
		else if ($operacion=='U'){ //Se esta actualizando una observacion que ya existia.
			$this->observacion->actualizarObservacion($observacion, $index, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		}
	}
	
	public function consultarObservacion(){
		$this->load->model("observacion");
		$index = $this->input->post("idx");
		$nro_orden = $this->session->userdata("nro_orden");
		$nro_establecimiento = $this->session->userdata("nro_establecimiento");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$observ = $this->observacion->consultarObservacion($index, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		echo $observ;
	}
	
	public function validarEnvio(){
		$this->load->helper("url");
		$this->load->model("control");
		$this->load->model("observacion");
		$nro_orden = $this->session->userdata("nro_orden");
		$nro_establecimiento = $this->session->userdata("nro_establecimiento");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$errores = explode(",",$this->input->post("err"));
	
		//Para cada uno de los errores que se encuentran en el array, debo validar que exista una observacion en la tabla rmmh_admin_observaciones
		$valid = false;
	
		//El formulario viene con errores, debe validarse que cada error haya sido corregido y/o justificado.
		for ($i=0; $i<count($errores); $i++){
				
			//Pregunto si el error no viene vacio para poder validarlo
			if ($errores[$i]!=""){
				if ($this->observacion->validarObservacion($errores[$i], $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo)){
					$valid = true;
				}
				else{
					$valid = false;
					break;
				}
			}
			else{
				//Si el error viene vacio es porque no hay errores, o el error no existe, por tanto: $valid = true
				//Este error se debe a que el explode siempre genera una posicion en el array de errores asi no hayan errores).
				$valid = true;
			}
		}
	
		if ($valid){
			echo "El formulario ha sido enviado a DANE Central.";
			$this->control->actualizarNovedadEstado($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 99, 5); //Se envia el formulario y la ficha de analisis a DANE Central
		}
		else{
			echo "<h3>ERROR: Debe corregir y/o justificar todos los errores de variaci&oacute;n en la ficha de an&aacute;lisis.</h3>";
		}
	
	}
	
}//EOC

