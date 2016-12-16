<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controlador para el modulo de temática de RMMH
 * @author Daniel Mauricio Díaz Forero - DMDiazF
 * @since  Noviembre 28 de 2012
 */


class Tematica extends MX_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->helper("url");
        $this->load->helper("download");
        $this->load->library("session");
        $this->load->library("validarsesion");
        $this->load->library("danecrypt");
        $this->load->library("pagination");        
        $this->load->library('phpexcel/PHPExcel');
    }
	
	public function index(){		
		$this->load->model("periodo");
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==6){
			$data['tipo_usuario']="TEMATICA";
		}
		$data["nom_usuario"] = $nom_usuario;
		$data["controller"] = "tematica";
		$data["view"] = "tematica";
		$data["menu"] = "tematicamenu";
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$this->load->view("layout",$data);		
	}
	
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
		redirect('/tematica', 'location', 301);
	}
	
	public function obtenerSalario(){
		$this->load->model("periodo");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$salario = $this->periodo->obtenerSalarioPeriodo($ano_periodo, $mes_periodo);
		echo json_encode($salario);
	}
	
	//Actualiza un combo de Municipios con base en un combo de departamentos
	public function actualizarMunicipios(){
		$this->load->model("divipola");
		$iddepto = $this->input->post("id");
		$municipios = $this->divipola->obtenerMunicipios($iddepto);
		echo '<option value="-" selected="selected">Seleccione</option>';
		for ($i=0; $i<count($municipios); $i++){
			echo '<option value="'.$municipios[$i]["codigo"].'">'.$municipios[$i]["nombre"].'</option>';
		}
	}
	
	//Funciones AJAX
	//Obtiene las observaciones que se han realizado sobre los capitulos de un formulario (por parte de la fuente)
	public function obtenerObservaciones($nro_orden, $nro_establecimiento){
		$this->load->model("observacion");
		$campo = $this->input->post("campo");
		$modulo = $this->input->post("modulo");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$observaciones = $this->observacion->obtenerObservacionesModulo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $modulo);
		echo json_encode($observaciones);
	}
	
	//Ejecuta la funcion del directorio del menu de tematica.
	public function directorio(){
		$this->load->model("sede");
		$this->load->model("subsede");
		$this->load->model("control");
		$this->load->model("periodo");
		$this->load->model("novedad");
		$this->load->model("divipola");
		$this->load->model("tipodocs");
		$this->load->model("actividad");
		$this->load->model("directorio");
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==6){
			$data['tipo_usuario']="TEMATICA";
		}
		$data["nom_usuario"] = $nom_usuario;
		$data["menu"] = "tematicamenu";
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$data["controller"] = "tematica";
		//$data["menu"] = "tematicamenu";
		$data["view"] = "directorio";
		$data["ano_periodo"] = $this->session->userdata("ano_periodo");
		$data["mes_periodo"] = $this->session->userdata("mes_periodo");
		$data["reciente"] = $this->periodo->obtenerPeriodoActual(); //Obtengo cual es el periodo mas reciente para bloquear la carga del directorio, y que solo se muestre para el periodo actual.
		$data["tipodocs"] = $this->tipodocs->obtenerTipoDocumentos();
		$data["sedes"] = $this->sede->obtenerSedes();
		$data["subsedes"] = $this->subsede->obtenerSubSedes();
		$data["actividades"] = $this->actividad->obtenerActividades();
		$data["departamentos"] = $this->divipola->obtenerDepartamentos();
		$data["municipios"] = $this->divipola->obtenerMunicipios(0);
		//Configuracion del paginador
		$config = array();
		$config["base_url"] = site_url("tematica/directorio");
		$config["total_rows"] = $this->directorio->contarFuentes($data["ano_periodo"], $data["mes_periodo"]); //Obtener el numero total de registros que debe procesar el paginador
		$config["per_page"] = 50;   //Cantidad de registros por pagina que debe mostrar el paginador
		$config["num_links"] = 5;  //Cantidad de links para cambiar de página que va a mostrar el paginador.
		$config["first_link"] = "Primero";
		$config["last_link"] = "&Uacute;ltimo";
		$config["use_page_numbers"] = TRUE;
		$this->pagination->initialize($config);
		//Trabajo de paginacion
		$pagina = ($this->uri->segment(3))?$this->uri->segment(3):1; //Si esta definido un valor por get, utilice el valor, de lo contrario utilice cero (para el primer valor a mostrar).
		$desde = ($pagina - 1) * $config["per_page"];
		$data["total"] = $config["total_rows"];
		$data["fuentes"] = $this->directorio->obtenerFuentes($data["ano_periodo"], $data["mes_periodo"], $desde, $config["per_page"]);
		$data["links"] = $this->pagination->create_links();
		$this->load->view("layout",$data);
	}
	
	//Muestra el detalle del formulario (de fuente) desde tematica
	public function mostrarFormulario($nro_orden, $nro_establecimiento){
		$this->load->model("control");
		$this->load->model("periodo");
		$this->load->model("usuario");
		$this->load->model("modulo1");
		$this->load->model("modulo2");
		$this->load->model("modulo3");
		$this->load->model("modulo4");
		$this->load->model("modulo5");
		$this->load->model("divipola");
		$this->load->model("envioform");
		$this->load->model("observacion");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==6){
			$data['tipo_usuario']="TEMATICA";
		}
		$data["nom_usuario"] = $nom_usuario;
		$data["controller"] = "tematica";
		$data["menu"] = "tematicamenu";
		$data["view"] = "detalle";
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$data["categorias"] = $this->modulo5->obtenerCategorias();
		//Obtener los datos del formulario
		$data["departamentos"] = $this->divipola->obtenerDepartamentos();
		$data["municipios"] = $this->divipola->obtenerMunicipios(0);
		$data["nro_orden"] = $nro_orden;
		$data["nro_establecimiento"] = $nro_establecimiento;
		$data["novedad_estado"] = $this->control->obtenerNovedadEstado($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data["nombre"] = $this->usuario->obtenerNombreFuente($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data["modulo1"] = $this->modulo1->obtenerModulo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data["modulo2"] = $this->modulo2->obtenerModulo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data["modulo3"] = $this->modulo3->obtenerModulo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data["modulo4"] = $this->modulo4->obtenerModulo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data["modulo5"] = $this->modulo5->obtenerModulo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data["envio"] = $this->envioform->obtenerModulo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data["tab_envio"] = $this->envioform->validarEnvioFormulario($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		
		//En este array se almacenan los indices de las variables en los que se presentan errores
		//en la variacion de la ficha de analisis.
		$erroresIndices = array();
			
		//$nro_orden = $this->session->userdata("nro_orden");
		//$nro_establecimiento = $this->session->userdata("nro_establecimiento");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		//Rango para la variación anual y mensual para la ficha de análisis.
		$rango=15;
			
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
		
		$data["pyz"] = $this->envioform->datosPazYSalvo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);  //Envia todos los datos para generar el paz y salvo
		$data["pazysalvo"] = $this->control->validarPazYSalvo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data["critico"] = $this->observacion->obtenerNombreCritico($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data["logistico"] = $this->observacion->obtenerNombreLogistico($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data["observaciones"] = $this->observacion->obtenerObservaciones($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data["observacionesCR"] = $this->observacion->obtenerObservacionesCritica($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data["observacionesAT"] = $this->observacion->obtenerObservacionesAsistente($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data["observacionesLG"] = $this->observacion->obtenerObservacionesLogistica($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo); 
		$data["observacionesAD"] = $this->observacion->obtenerObservacionesAdministrador($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data["bloqueo"] = false; //Todos los campos se habilitan para que sean editados por el administrador.
		$this->load->view("layout",$data);
	}
	
	//Muestra los usuarios generales del aplicativo (No se realizan filtros ni por año ni por periodo)
	public function usuarios(){
		$this->load->model("periodo");
		$this->load->model("usuario");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$data["controller"] = "tematica";
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==6){
			$data['tipo_usuario']="TEMATICA";
		}
		$data["nom_usuario"] = $nom_usuario;
		$data["menu"] = "tematicamenu";
		$data["view"] = "usuarios";
		$data["ano_periodo"] = $this->session->userdata("ano_periodo");
		$data["mes_periodo"] = $this->session->userdata("mes_periodo");
		$data["reciente"] = $this->periodo->obtenerPeriodoActual(); //Obtengo cual es el periodo mas reciente para bloquear la carga del directorio, y que solo se muestre para el periodo actual.
		//Configuracion del paginador
		$config = array();
		$config["base_url"] = site_url("tematica/usuarios");
		$config["total_rows"] = $this->usuario->contarUsuarios($data["ano_periodo"], $data["mes_periodo"]); //Nro de registros que debe procesar el paginador
		$config["per_page"] = 50; //Cantidad de registros por pagina que debe mostrar el paginador
		$config["num_links"] = 5; //Cantidad de links para cambiar de página que va a mostrar el paginador.
		$config["first_link"] = "Primero";
		$config["last_link"] = "&Uacute;ltimo";
		$config["use_page_numbers"] = TRUE;
		$this->pagination->initialize($config);
		//Trabajo de paginacion
		$pagina = ($this->uri->segment(3))?$this->uri->segment(3):1; //Si esta definido un valor por get, utilice el valor, de lo contrario utilice cero (para el primer valor a mostrar).
		$desde = ($pagina - 1) * $config["per_page"];
		$data["usuarios"] = $this->usuario->obtenerUsuariosPagina($data["ano_periodo"], $data["mes_periodo"], $desde, $config["per_page"]);
		$data["links"] = $this->pagination->create_links();		
		$this->load->view("layout",$data);					
	}
	
	public function formularios(){
		$this->load->model("periodo");
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==6){
			$data['tipo_usuario']="TEMATICA";
		}
		$data["nom_usuario"] = $nom_usuario;
		$data["menu"] = "tematicamenu";
		$data["controller"] = "tematica";
		$data["view"] = "formularios";
		$this->load->view("layout",$data);
	}
	
	public function buscarFuentes(){
		$this->load->model("control");
		$this->load->model("novedad");
		$this->load->model("periodo");
		$this->load->model("directorio");
		$opcion  = $this->input->post("radBusqueda");
		$buscar = $this->input->post("txtBuscar");
		$data["ano_periodo"] = $this->session->userdata("ano_periodo");
		$data["mes_periodo"] = $this->session->userdata("mes_periodo");
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==6){
			$data['tipo_usuario']="TEMATICA";
		}
		$data["nom_usuario"] = $nom_usuario;
		$data["menu"] = "tematicamenu";
		$data["controller"] = "tematica";
		$data["view"] = "ajxformularios";
		//Configuracion del paginador
		$config = array();
		$config["base_url"] = site_url("tematica/buscarFuentes");
		$config["total_rows"] = $this->directorio->contarDirectorio($opcion, $buscar, $data["ano_periodo"], $data["mes_periodo"]);
		$config["per_page"] = 50;   //Cantidad de registros por pagina que debe mostrar el paginador
		$config["num_links"] = 5;  //Cantidad de links para cambiar de página que va a mostrar el paginador.
		$config["first_link"] = "Primero";
		$config["last_link"] = "&Uacute;ltimo";
		$config["use_page_numbers"] = TRUE;
		$this->pagination->initialize($config);
		//Trabajo de paginacion
		$pagina = ($this->uri->segment(3))?$this->uri->segment(3):1; //Si esta definido un valor por get, utilice el valor, de lo contrario utilice cero (para el primer valor a mostrar).
		$desde = ($pagina - 1) * $config["per_page"];
		$data["fuentes"] = $this->directorio->buscarDirectorioPagina($opcion, $buscar, $data["ano_periodo"], $data["mes_periodo"], $desde, $config["per_page"]);
		$data["total"] = $config["total_rows"];
		$data["links"] = $this->pagination->create_links();		
		$this->load->view("layout",$data);
	}
	
	//Muestra el reporte operativo desde el modulo de tematica
	public function operativo(){
		$this->load->library("session");
		$this->load->model("periodo");
		$this->load->model("sede");
		$this->load->model("subsede");
		$this->load->model("control");
		$ano = $this->session->userdata("ano_periodo");
		$mes = $this->session->userdata("mes_periodo");
		$data["sedes"] = $this->sede->obtenerSedes();
		$data["subsedes"] = $this->subsede->obtenerSubSedesAll();
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$data["sede"] = 0;
		$data["subsede"] = 0;
		$data["informe"] = $this->control->informeOperativo($ano, $mes, $data["sede"], $data["subsede"]); //Obtener todas las sedes y todas las subsedes
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==6){
			$data['tipo_usuario']="TEMATICA";
		}
		$data["nom_usuario"] = $nom_usuario;
		$data["controller"] = "tematica";
		$data["menu"] = "tematicamenu";
		$data["view"] = "operativo";
		$this->load->view("layout",$data);
	}
	
	public function operativoCritico(){
		$this->load->model("usuario");
		$this->load->model("periodo");
		$this->load->model("control");
		$this->load->model("sede");
		$this->load->model("subsede");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$data["controller"] = "tematica";
		$data["menu"] = "tematicamenu";
		$data["view"] = "operativocr";
		$data["sedes"] = $this->sede->obtenerSedes();
		$criticos = $this->usuario->obtenerCriticos(0, 0); //Sede 0 - Subsede 0
		//Para cada uno de los criticos que se encontraron, obtengo su respectivo reporte operativo
		for ($i=0; $i<count($criticos); $i++){
			$data["reporte"][$i]["nombre"] = $criticos[$i]["nombre"];
			$data["reporte"][$i]["reporte"] = $this->control->informeOperativoCritico($criticos[$i]["id"], $ano_periodo, $mes_periodo, 0, 0);
		}
		$this->load->view("layout",$data);
	}
	
	public function detalleOperativo($index, $sede, $subsede){
		$this->load->model("control");
		$this->load->model("periodo");
		$this->load->model("directorio");
		$this->load->model("usuario");
		$this->load->model("novedad");
		$usuario = $this->session->userdata("id");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$usuarioCR = 0;
		$usuarioLOG = 0;
        //Obtener el rol del usuario
        $rol = $this->usuario->obtenerRolUsuario($usuario);
        if ($rol==2){
        	$usuarioCR = $usuario;
        	$usuarioLOG = 0;
        }
        else if($rol==5){
        	$usuarioCR = 0;
        	$usuarioLOG = $usuario;
        }
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$data["controller"] = "tematica";		
		$data["menu"] = "tematicamenu";
		$data["view"] = "ajxdetalleoperativo";
		
		switch($index){
			case 0: //Directorio Base;
					$data["titulo"] = "Directorio Base";
					$data["fuentes"] = $this->directorio->obtenerDirectorioBase($usuarioCR, $usuarioLOG, $ano_periodo, $mes_periodo, $sede, $subsede);
					break;
			case 1: //Nuevos
				    $data["titulo"] = "Nuevos"; 
					$data["fuentes"] = $this->directorio->obtenerDirectorioNuevos($usuarioCR, $usuarioLOG, $ano_periodo, $mes_periodo, $sede, $subsede);				    
					break;
			case 2: //Total a Recolectar;
				    $data["titulo"] = "Total a Recolectar";
					$data["fuentes"] = $this->directorio->obtenerDirectorioTotalRecolectar($usuarioCR, $usuarioLOG, $ano_periodo, $mes_periodo, $sede, $subsede);					
					break;
			case 3: //Sin Distribuir
					$data["titulo"] = "Sin Distribuir";
					$data["fuentes"] = $this->directorio->obtenerDirectorioSinDistribuir($usuarioCR, $usuarioLOG, $ano_periodo, $mes_periodo, $sede, $subsede);					
					break;
			case 4: //Distribuidos
					$data["titulo"] = "Distribuidos";
					$data["fuentes"] = $this->directorio->obtenerDirectorioDistribuir($usuarioCR, $usuarioLOG, $ano_periodo, $mes_periodo, $sede, $subsede);				
					break;
			case 5: //En Digitacion
					$data["titulo"] = "En digitaci&oacute;n";
					$data["fuentes"] = $this->directorio->obtenerDirectorioEnDigitacion($usuarioCR, $usuarioLOG, $ano_periodo, $mes_periodo, $sede, $subsede);
					break;
			case 6: //Digitados
					$data["titulo"] = "Digitados";
					$data["fuentes"] = $this->directorio->obtenerDirectorioDigitados($usuarioCR, $usuarioLOG, $ano_periodo, $mes_periodo, $sede, $subsede);
					break;
			case 7: //Analisis - Verificacion
					$data["titulo"] = "Analisis - Verificaci&oacute;n";
					$data["fuentes"] = $this->directorio->obtenerDirectorioAnalisisVerificacion($usuarioCR, $usuarioLOG, $ano_periodo, $mes_periodo, $sede, $subsede);
					break;
			case 8: //Verificados
					$data["titulo"] = "Verificados";
					$data["fuentes"] = $this->directorio->obtenerDirectorioVerificados($usuarioCR, $usuarioLOG, $ano_periodo, $mes_periodo, $sede, $subsede);
					break;
			case 9: //Novedades
					$data["titulo"] = "Novedades";
					$data["fuentes"] = $this->directorio->obtenerDirectorioNovedades($usuarioCR, $usuarioLOG, $ano_periodo, $mes_periodo, $sede, $subsede);					
					break;																		
		}
		$this->load->view("layout",$data);
	}
	
	//Descarga el archivo del formulario en blanco
	public function descarga(){
		$this->load->helper("download");
		$file = "./res/formrmmh.pdf";
		if (file_exists($file)){
			$data = file_get_contents($file); // Read the file's contents
			$name = 'formulario.pdf';
			force_download($name, $data); 
		}
		else{
			die("<h3>ERROR: NO se ha podido descargar el archivo del formulario. No existe el archivo. Consulte con su administrador</h3>");
			exit(-1);
		}
	}
	
	//Cierra la sesion del usuario cuando se da click en la opcion salir del menu	
	public function cerrarSesion(){
		$this->load->helper("url");
		$this->load->library("session");
		$this->session->sess_destroy();
		redirect("login","refresh");
	}
	
	
	
}//EOC
