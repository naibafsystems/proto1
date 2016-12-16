<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controlador para el modulo de logistica de RMMH
 * @author Daniel Mauricio D�az Forero - DMDiazF
 * @since  Julio 30 de 2012
 */


class Logistica extends MX_Controller {
	
	public function __construct(){
        parent::__construct();
        $this->load->library("pagination");
        $this->load->library("danecrypt"); 
        $this->load->library('phpexcel/PHPExcel');
        $this->load->library("validarsesion");
    }
	
	//Funcion principal. Se ejecuta por defecto al cargar el controlador (Muestra la funcion Directorio)
	public function index(){
		$this->load->model("periodo");				
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==5){
			$data['tipo_usuario']="LOGISTICA";
		}
		$data["nom_usuario"] = $nom_usuario;
		$data["controller"] = "logistica";
		$data["view"] = "logistica";
		$data["menu"] = "logmenu";
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
		redirect('/logistica', 'location', 301);
	}
	
	//Muestra el directorio de fuentes que se ha asignado a un usuario logistico
	//Solo puede ver las fuentes que le han sido asignadas desde el administrador.
	public function directorio(){		
		$this->load->model("control");
		$this->load->model("periodo");
		$this->load->model("usuario");
		$this->load->model("tipodocs");
		$this->load->model("sede");
		$this->load->model("subsede");
		$this->load->model("actividad");
		$this->load->model("divipola");
		$logistico = $this->session->userdata("id");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==5){
			$data['tipo_usuario']="LOGISTICA";
		}
		$data["nom_usuario"] = $nom_usuario;
		$data["controller"] = "logistica";
		$data["view"] = "directorio";
		$data["menu"] = "logmenu";
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$data["reciente"] = $this->periodo->obtenerPeriodoActual(); //Obtengo cual es el periodo mas reciente para bloquear la carga del directorio solo para el periodo actual
		//Datos para la gestion de los usuarios del directorio (Agregar, Remover, Descarga Directorio)
		$data["tipodocs"] = $this->tipodocs->obtenerTipoDocumentos();
		$data["sedes"] = $this->sede->obtenerSedes();
		$data["subsedes"] = $this->subsede->obtenerSubSedes();
		$data["actividades"] = $this->actividad->obtenerActividades();
		$data["departamentos"] = $this->divipola->obtenerDepartamentos();
		$data["municipios"] = $this->divipola->obtenerMunicipios(0);
		
		//Configuracion del paginador
		$config = array();
		$config["base_url"] = "logistica/directorio";
		//$config["base_url"] = site_url("logistica/directorio");		
		$config["total_rows"] = $this->usuario->contarFuentesAsignadas($logistico, $ano_periodo, $mes_periodo);
		$config["per_page"] = 50;   //Cantidad de registros por pagina que debe mostrar el paginador
		$config["num_links"] = 5;  //Cantidad de links para cambiar de p�gina que va a mostrar el paginador.
		$config["first_link"] = "Primero";
		$config["last_link"] = "&Uacute;ltimo";
		$config["use_page_numbers"] = TRUE;
		$this->pagination->initialize($config);
		//Trabajo de paginacion
		$pagina = ($this->uri->segment(3))?$this->uri->segment(3):1;
		$desde = ($pagina - 1) * $config["per_page"];
		$data["total"] = $config["total_rows"];
		$data["fuentes"] = $this->usuario->obtenerFuentesAsignadasLogisticaPAG($ano_periodo, $mes_periodo, $logistico, $desde, $config["per_page"]);
		$data["links"] = $this->pagination->create_links();
		$this->load->view("layout",$data);
	}
	
	//Muestra la busqueda de formularios desde el modulo de logistica
	//Solo puede ver las fuentes que le han sido asignadas desde el administrador.
	public function formularios(){		
		$this->load->model("periodo");
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==5){
			$data['tipo_usuario']="LOGISTICA";
		}
		$data["nom_usuario"] = $nom_usuario;
		$data["controller"] = "logistica";
		$data["view"] = "formularios";
		$data["menu"] = "logmenu";
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$this->load->view("layout",$data);		
	}
	
	//Muestra el reporte operativo para el modulo de critica
	//Genera el reporte operativo solo de las fuentes que le han sido asignadas desde el administrador
	public function operativo(){
		$this->load->model("control");
		$this->load->model("periodo");
		$logistico = $this->session->userdata("id");
		$ano_periodo = $this->session->userdata("ano_periodo");	
		$mes_periodo = $this->session->userdata("mes_periodo");
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==5){
			$data['tipo_usuario']="LOGISTICA";
		}
		$data["nom_usuario"] = $nom_usuario;
		$data["controller"] = "logistica";
		$data["view"] = "operativo";
		$data["menu"] = "logmenu";
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$data["informe"] = $this->control->informeOperativoLogistica($logistico, $ano_periodo, $mes_periodo, $sede=0, $subsede=0);
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
	
	public function generarPazySalvo(){
		$this->load->library("session");
		$this->load->helper("dompdf_helper");
		$this->load->model("envioform");
		$nro_establecimiento = $this->input->post("nro_establecimiento");
		//$nro_orden = $this->session->userdata("nro_orden"); 
		$nro_orden = $this->input->post("nro_orden");
		$uni_local = $this->session->userdata("uni_local"); //
		$ano = $this->session->userdata("ano_periodo");
		$mes = $this->session->userdata("mes_periodo");
		//Obtengo los datos para generar el paz y salvo
		$data["pyz"] = $this->envioform->datosPazYSalvo($nro_orden, $nro_establecimiento, $ano, $mes); 
		$html = $this->load->view("pazysalvo",$data,true);
        generarPdf($html,'pazysalvo','letter','portrait');                
	}
	
	/********************************************************** 
	 * Libreria de funciones AJAX para el modulo de logistica	  
	 **********************************************************/
	
	//Hace la paginacion de resultados para el directorio de logistica
	public function pagerDirectorio(){
		$this->load->model("usuario");
		$this->load->model("periodo");
		$this->load->model("tipodocs");
		$this->load->model("sede");
		$this->load->model("subsede");
		$this->load->model("actividad");
		$this->load->model("divipola");
		$logistico = $this->session->userdata("id");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$pagina = $this->input->post("pagina");
		$desde = ($pagina - 1) * $this->paginador2->getRegsPagina();
		$this->paginador2->setFuncion("logistica/pagerDirectorio");
		$data["tipodocs"] = $this->tipodocs->obtenerTipoDocumentos();
		$data["sedes"] = $this->sede->obtenerSedes();
		$data["subsedes"] = $this->subsede->obtenerSubSedes();
		$data["actividades"] = $this->actividad->obtenerActividades();
		$data["departamentos"] = $this->divipola->obtenerDepartamentos();
		$data["municipios"] = $this->divipola->obtenerMunicipios(0);
		$data["reciente"] = $this->periodo->obtenerPeriodoActual(); 
		$data["total"] = $this->usuario->contarFuentesAsignadas($logistico, $ano_periodo, $mes_periodo);
		$data["fuentes"] = $this->usuario->obtenerFuentesAsignadasLogisticaPAG($ano_periodo, $mes_periodo, $logistico, $desde);
		$data["paginador"] = $this->paginador2->paginar('divResultados',$pagina,$data["total"]);
		$this->load->view("directorio",$data);
	}
	
	//Realiza la b�squeda de fuentes dentro del directorio de fuentes de la RMMH
	public function buscarFuentes(){		
		$this->load->model("control");
		$this->load->model("directorio");
		$usuarioLOG = $this->session->userdata("id");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$opcion = $this->input->post("opcion");
		$buscar = $this->input->post("buscar");
		//Configuracion del paginador
		$config = array();
		$config["base_url"] = site_url("logistica/buscarFuentes");
		$config["total_rows"] = $this->directorio->contarDirectorio($usuarioLOG, $opcion, $buscar, $ano_periodo, $mes_periodo);
		$config["per_page"] = 50;   //Cantidad de registros por pagina que debe mostrar el paginador
		$config["num_links"] = 5;  //Cantidad de links para cambiar de p�gina que va a mostrar el paginador.
		$config["first_link"] = "Primero";
		$config["last_link"] = "&Uacute;ltimo";
		$config["use_page_numbers"] = TRUE;
		$this->pagination->initialize($config);
		//Trabajo de paginacion
		$pagina = ($this->uri->segment(3))?$this->uri->segment(3):1; //Si esta definido un valor por get, utilice el valor, de lo contrario utilice cero (para el primer valor a mostrar).
		$desde = ($pagina - 1) * $config["per_page"];
		$data["fuentes"] = $this->directorio->buscarDirectorioPagina($usuarioLOG, $opcion, $buscar, $ano_periodo, $mes_periodo, $desde, $config["per_page"]); 
		$data["total"] = $config["total_rows"];
		$data["links"] = $this->pagination->create_links();		
		$this->load->view("ajxformularios",$data);
		
		
		
		/***
		$pagina = $this->input->post("pagina");
		$desde = ($pagina - 1) * $this->paginador2->getRegsPagina();
		$this->paginador2->setFuncion("logistica/pagerBuscadorFuentes");
		$data["total"] = $this->directorio->contarDirectorio($usuarioLOG, $opcion, $buscar, $ano_periodo, $mes_periodo);
		$data["fuentes"] = 
		$data["paginador"] = $this->paginador2->paginar('divResultados',1,$data["total"]);
		$this->load->view("ajxformularios",$data);
		***/
	}
	
	
	//Paginador para la busqueda de resultados de la busqueda de formularios
	public function pagerBuscadorFuentes(){
		$this->load->model("directorio");
		$usuarioLOG = $this->session->userdata("id");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$opcion = $this->input->post("opcion");
		$buscar = $this->input->post("buscar");
		$pagina = $this->input->post("pagina");	
		$desde = ($pagina - 1) * $this->paginador2->getRegsPagina();	
		$this->paginador2->setFuncion("logistica/pagerBuscadorFuentes");
		$data["total"] = $this->directorio->contarDirectorio($usuarioLOG, $opcion, $buscar, $ano_periodo, $mes_periodo);
		$data["fuentes"] = $this->directorio->buscarDirectorioPagina($usuarioLOG, $desde, $opcion, $buscar, $ano_periodo, $mes_periodo);
		$data["paginador"] = $this->paginador2->paginar('divResultados',$pagina,$data["total"]);
		$this->load->view("ajxformularios",$data);	
	}
	
	
	//Hace la paginacion de resultados para la busqueda de formularios de logistica
	public function pagerBuscador(){
		$this->load->model("usuario");
		$this->load->model("directorio");
		$buscar = $this->input->post("buscar");
		$logistico = $this->session->userdata("id");
		$ano_periodo = $this->session->userdata("ano_periodo");	
		$mes_periodo = $this->session->userdata("mes_periodo");
		$pagina = $this->input->post("pagina");
		$desde = ($pagina - 1) * $this->paginador2->getRegsPagina();
		$this->paginador2->setFuncion("logistica/pagerBuscador");
		$data["total"] = $this->directorio->contarFuentesResultado($ano_periodo, $mes_periodo, $logistico, $buscar);
		$data["fuentes"] = $this->directorio->buscarDirectorioLogisticoPAG($ano_periodo, $mes_periodo, $logistico, $desde, $buscar);
		$data["paginador"] = $this->paginador2->paginar('divResultados',$pagina,$data["total"]);
		$this->load->view("ajxformularios",$data);
	}
	
	
	//Muestra el detalle de las fuentes en el reporte operativo de logistica
	public function detalleOperativo($index){
		$this->load->model("control");
		$this->load->model("periodo");
		$this->load->model("directorio");
		$usuarioCR = 0; //No se necesitan los datos del critico
		$usuarioLOG = $this->session->userdata("id");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$sede = 0;
		$subsede = 0;
		$data["controller"] = "logistica";
		$data["menu"] = "logmenu";
		$data["view"] = "operativodetalle";
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
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
	
	
	//Muestra el detalle del formulario (de fuente) desde el logistico (sirve en directorio y reporte operativo)
	public function mostrarFormulario($nro_orden, $nro_establecimiento){
		//var_dump($this->input->post()); die();
		
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
		if($tipo_usuario==5){
			$data['tipo_usuario']="LOGISTICA";
		}
		$data["nom_usuario"] = $nom_usuario;
		$data["controller"] = "logistica";
		$data["menu"] = "logmenu";
		$data["view"] = "detalle";
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		//Obtener los datos del formulario
		$data["departamentos"] = $this->divipola->obtenerDepartamentos();
		$data["municipios"] = $this->divipola->obtenerMunicipios(0);
		$data["categorias"] = $this->modulo5->obtenerCategorias();
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
		//Rango para la variaci�n anual y mensual para la ficha de an�lisis.
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
    	$data[$campo]["err1"] = $this->envioform->compararRango($data[$campo]["varmensual"], $rango); //Se compara si el valor est� dentro del rango de [-15,15]
    	$data[$campo]["err2"] = $this->envioform->compararRango($data[$campo]["varanual"], $rango); //Se compara si el valor est� dentro del rango de [-15,15]
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
    	$data[$campo]["err1"] = $this->envioform->compararRango($data[$campo]["varmensual"], $rango); //Se compara si el valor est� dentro del rango de [-15,15]
    	$data[$campo]["err2"] = $this->envioform->compararRango($data[$campo]["varanual"], $rango); //Se compara si el valor est� dentro del rango de [-15,15]
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
    	$data[$campo]["err1"] = $this->envioform->compararRango($data[$campo]["varmensual"], $rango); //Se compara si el valor est� dentro del rango de [-15,15]
    	$data[$campo]["err2"] = $this->envioform->compararRango($data[$campo]["varanual"], $rango); //Se compara si el valor est� dentro del rango de [-15,15]
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
    	
    	//Total hu�spedes - huetot
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
	
	//Actualiza el combo de las subsedes a partir de una sede escogida
	public function actualizarSubsedes(){
		$this->load->model("subsede");
		$idsede = $this->input->post("id");
		$subsedes = $this->subsede->obtenerSubsedesID($idsede);
		echo '<option value="-" selected="selected">Seleccione</option>';
		for ($i=0; $i<count($subsedes); $i++){
			echo '<option value="'.$subsedes[$i]["id"].'">'.$subsedes[$i]["nombre"].'</option>';	
		}		
	}
	
	//Insertar / Agregar una nueva fuente desde el directorio de fuentes del administrador
	public function insertarFuente(){
		$this->load->model("control");
		$this->load->model("usuario");
		$this->load->model("directorio");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		foreach($_POST as $nombre_campo => $valor){
  			$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   			
  			eval($asignacion);
		}
		//Validar que el establecimiento no se encuentre ya registrado
		if (!$this->usuario->validaRegistroEstablecimiento($txtNumOrden, $txtNumEstab, $ano_periodo, $mes_periodo)){
			//Validar si la empresa no se encuentra ya registrada
			if (!$this->usuario->validaRegistroEmpresa($txtNitEmpresa, $txtNumOrden)){  //Si la empresa no est� registrada la agrego.
				//Creo el registro de la empresa
				$this->directorio->insertarEmpresa($txtNumOrden, $txtNitEmpresa, $txtNomEmpresa, $txtNomEmpresa, '', '', 0, 0, 0, '', '', $cmbDeptoEstab, $cmbMpioEstab);
			}
			else{ //La empresa ya esta registrada, luego obtengo los datos de esa empresa.
				$empresa = $this->directorio->obtenerDatosEmpresa($txtNitEmpresa, $txtNumOrden);				
			}
			//Crea el registro del establecimiento
			$this->directorio->insertarEstablecimiento($txtNumOrden, $txtNumEstab, $txtNomEstab, '', $txtDirEstab, $cmbMpioEstab, $cmbDeptoEstab, 0, 0, '', date("Y-m-d"), date("Y-m-d"), $cmbActivEstab, $cmbDeptoEstab, $cmbMpioEstab, $cmbSedeEstab, $cmbSubSedeEstab);
			//Crea el registro en la tabla de usuarios
			$login = "F".$txtNumEstab;
			$password = $this->danecrypt->generarPassword();
			$this->usuario->insertarUsuario($txtNitEmpresa, $txtNomEstab, $login, $password, '', date("Y-m-d h:i:s"), '0000-00-00 00:00:00', $txtNumOrden, $txtNumEstab, 1, 1, $cmbSedeEstab, $cmbSubSedeEstab); //Agregar con el rol fuente
			//Agregar registro en la tabla de control
			$idusuario = $this->usuario->IDUltimoInsertado();
			$this->control->insertarControl($txtNumOrden, $txtNumEstab, $ano_periodo, $mes_periodo, 1, 0, 0, 0, 0, 0, $cmbInclusion, 'A', 9, 0, $cmbSedeEstab, $cmbSubSedeEstab, 0, 0);
		}
		else{
			echo "Ya est� el registro del establecimiento";
		}
	}
	
	//Remueve las fuentes del directorio de fuentes. Operacion DELETE sobre el directorio de fuentes. Se eliminan los datos del periodo actual. 
	//Si existen datos de periodos anteriores, estos datos se mantienen.
	public function removerFuente(){
		$this->load->model("usuario");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		foreach($_POST as $nombre_campo => $valor){
  			$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   			
  			eval($asignacion);
		}
		$arrayData = explode("-",$cmbFuenteLOG);
		$nro_orden = $arrayData[0];
		$nro_establecimiento = $arrayData[1];
		$this->usuario->eliminarFuente($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);				
	}
	
	//Funcion para descargar el directorio. Genera un archivo Excel donde se muestran las contrase�as del directorio sin encriptar
	public function descargaDirectorio(){
		$this->load->model("usuario");
		$usuario = $this->session->userdata("id");
		$ano_periodo = $this->session->userdata("ano_periodo"); 
		$mes_periodo = $this->session->userdata("mes_periodo");
		//$usuarios = $this->usuario->reportePasswords(); //Obtiene todos los usuarios del sistema
		$usuarios = $this->usuario->reportePasswordsLogistica($usuario, $ano_periodo, $mes_periodo);  //Obtiene solo los usuarios asignados al logistico
		$sheet = $this->phpexcel->getActiveSheet();
		$sheet->getColumnDimension('A')->setWidth(30);
		$sheet->getColumnDimension('B')->setWidth(30);
		$sheet->getColumnDimension('C')->setWidth(30);
		$sheet->getColumnDimension('D')->setWidth(30);
		$sheet->getColumnDimension('E')->setWidth(30);
		$sheet->setCellValue('A1','ID. Fuente');
		$sheet->setCellValue('B1','Nit - Nro. Identificacion');
		$sheet->setCellValue('C1','Nombre Usuario');
		$sheet->setCellValue('D1','Login');
		$sheet->setCellValue('E1','Password');
		
		$styleArray = array('font' => array('bold' => true, 'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE ));
		$sheet->getStyle('A1')->applyFromArray($styleArray);
		$sheet->getStyle('B1')->applyFromArray($styleArray);
		$sheet->getStyle('C1')->applyFromArray($styleArray);
		$sheet->getStyle('D1')->applyFromArray($styleArray);
		$sheet->getStyle('E1')->applyFromArray($styleArray);
		
		for ($i=0; $i<count($usuarios); $i++){
			$codA = "A".($i+3);
			$codB = "B".($i+3);
			$codC = "C".($i+3);
			$codD = "D".($i+3);
			$codE = "E".($i+3);
			$sheet->setCellValue($codA,$usuarios[$i]["id"]);
			$sheet->setCellValue($codB,$usuarios[$i]["num_identificacion"]);
			$sheet->setCellValue($codC,$usuarios[$i]["nom_usuario"]);
			$sheet->setCellValue($codD,$usuarios[$i]["log_usuario"]);
			$sheet->setCellValue($codE,$usuarios[$i]["pas_usuario"]);
		}
		
		$writer = new PHPExcel_Writer_Excel5($this->phpexcel);
		header('Content-type: application/vnd.ms-excel');
		$writer->save('php://output');
	}
	
	public function guardarCapitulo(){
		$this->load->model("modulo1");		
		$this->load->model("modulo2");
		$this->load->model("modulo3");
		$this->load->model("modulo4");	
		$this->load->model("modulo5");	
		$this->load->model("envioform");
		$this->load->model("observacion");
		$this->load->model("control");
		$idcritico = $this->session->userdata("id");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");		
		$form = $this->input->post("form");		
		$capitulo = $this->input->post("capitulo");
		$campo = "";
		$observacion = $this->input->post("observacion");
		$fecha = date("Y-m-d h:i:s");		
		$idaano = 0; //Como no se utiliza el apartado aereo, de todas formas lo envio pero en ceros.
		$arrData = explode("&",$form); //Recibo todos los datos del formulario como una sola cadena de texto separada por "ampersands". Los separo.
		foreach ($arrData as $str){
			//Preguntar si la variable tiene un dato, sino asignar la variable con valor vacio.
			if (strrpos($str, ";")===false){
				$array = explode("=", $str);
				$asignacion = "\$" . $array[0] . "='" . str_replace("+"," ",$array[1]) . "';";   						
  				eval($asignacion);
			}
			else{
				$array = explode(";", $str);
				$asignacion = "\$" . $array[0] . "=\"\";";
				eval($asignacion); 	
			}
		}
		
		//Dependiendo del capitulo que se reciba, voy a actualizar los datos del capitulo.
		switch($capitulo){
			case 1:  //Preguntar si existe el registro. Si existe lo actualizo. Si no lo agrego.
				     $this->modulo1->actualizarModulo($nro_orden, $nro_establecimiento, $idnit, $idproraz, $idnomcom, $idsigla, $iddirecc, $iddepto, $idmpio, $idtelno, $idfaxno, $idpagweb, $idcorreo, $finicial, $ffinal,
                                                     $idnomcomest, $idsiglaest, $iddireccest, $iddeptoest, $idmpioest, $idtelnoest, $idfaxnoest, $idcorreoest, $nom_cadena, $nom_operador);
                     /**/
                     //Verificar el estado del formulario y continuar con el manejo normal de la novedad y el estado.
                     $this->control->actualizarControl($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 'modulo1', 2); //Estado del modulo 1 en (2 - Diligenciado)
                     
                     //Actualizar la novedad y el estado en control
                     $this->control->actualizarNovedadEstado($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $estado=2);
					 
                     break;
                     
			case 2:  //Guardar los datos del formulario
				     //Pregunto si el registro existe. Si existe lo actualizo sino lo inserto.
				     if ($this->modulo2->existeRegistro($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo)){
					 	//El registro ya existe, por lo que debo actualizarlo.
				     	$this->modulo2->actualizarModulo($potpsfr, $potperm, $gpper, $pottcde, $gpssde, $pottcag, $gpppta, $potpau, $gppgpa, $pottot, $gpsspot, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
					 	//Guardar las observaciones de la fuente
					 	if (!isset($obsgpssde)){
					 		$obsgpssde = "";
					 	}
					 	if (!isset($obsgppgpa)){
							$obsgppgpa = "";
					 	}
					 	$this->observacion->actualizarObservacion($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 2, 'gpssde', $gpssde, $obsgpssde);
					 	$this->observacion->actualizarObservacion($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 2, 'gppgpa', $gppgpa, $obsgppgpa);
					 }	
					 else{
					 	//El registro no existe. Por lo que debo ingresarlo a la B.D.
					 	$this->modulo2->insertarModulo($potpsfr, $potperm, $gpper, $pottcde, $gpssde, $pottcag, $gpppta, $potpau, $gppgpa, $pottot, $gpsspot, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
					 	/**/
					 	//Verificar el estado del formulario y continuar con el manejo normal de la novedad y el estado.
					 }
					 $this->control->actualizarControl($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 'modulo2', 2); //Estado del modulo 2 en (2 - Diligenciado)
					 
					  //Actualizar la novedad y el estado en control
                     $this->control->actualizarNovedadEstado($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $estado=2);
			         break;
			         
			case 3:  //Guardar los datos del formulario
				     //Pregunto si el registro existe. Si existe lo actualizo, si no lo inserto.
				     if ($this->modulo3->existeRegistro($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo)){				
					 	$this->modulo3->actualizarModulo($inalo, $inali, $inba, $insr, $inoe, $inoio, $intio, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				     	//Guardar las observaciones de la fuente
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
					 	
					 	$this->observacion->actualizarObservacion($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 3, 'intio1', $intio, $obsintio1);
					 	$this->observacion->actualizarObservacion($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 3, 'intio2', $intio, $obsintio2);
					 	$this->observacion->actualizarObservacion($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 3, 'inalo', $inalo, $obsinalo);
					 	$this->observacion->actualizarObservacion($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 3, 'inoio', $inoio, $obsinoio);
					 	$this->observacion->actualizarObservacion($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 3, 'inoe', $inoe, $obsinoe);
				     }
				     else{
				     	//El registro no existe. Por lo que debo ingresarlo a la B.D.
				     	$this->modulo3->insertarModulo($inalo, $inali, $inba, $insr, $inoe, $inoio, $intio, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);				     	
				     }
			         $this->control->actualizarControl($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 'modulo3', 2); //Estado del modulo 3 en (2 - Diligenciado)
			         
			          //Actualizar la novedad y el estado en control
                     $this->control->actualizarNovedadEstado($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $estado=2);
				     break;
			         
			case 4:  //Guardar los datos del formulario
					 //Pregunto si el registro existe. Si existe lo actualizo, si no lo inserto.
					 if ($this->modulo4->existeRegistro($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo)){
				     	$this->modulo4->actualizarModulo($habdia, $ihdo, $ihoa, $camdia, $icda, $icva, $ihpn, $ihpnr, $huetot, $mvnr, $mvcr, $mvor, $mvsr, $mvotr, $mvott, $mvnnr, $mvcnr, $mvonr, $mvsnr, $mvotnr, $mvottnr, $thsen, $thusen, $thdob, $thudob, $thsui, $thusui, $thmult, $thumult, $thotr, $thuotr, $thtot, $ingsen, $ingdob, $ingsui, $ingmult, $ingotr, $ingtot, $tphto=0, $inalosen, $inalodob, $inalosui, $inalomul, $inalootr, $inalotot, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
					 	//Guardar las observaciones de la fuente					
				     	if (!isset($obsihoa)){
							$obsihoa = "";
					 	}
					 	if (!isset($obsicva)){
							$obsicva = "";
					 	}
					 	if (!isset($obshuetot)){
					 		$obshuetot = "";
					 	}
					 	if (!isset($obsthudob)){
							$obsthudob = "";
					 	}
					 	if (!isset($obsthusui)){
							$obsthusui = "";
					 	}
					 	if (!isset($obsthumult)){
							$obsthumult = "";
					 	}
					 	if (!isset($obsinalomul)){
							$obsinalomul = "";			
					 	}
					 	if (!isset($obsinalootr)){
							$obsinalootr = "";
					 	}
					 	$this->observacion->actualizarObservacion($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 4, 'ihoa', $ihoa, $obsihoa);
					 	$this->observacion->actualizarObservacion($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 4, 'icva', $icva, $obsicva);
					 	$this->observacion->actualizarObservacion($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 4, 'huetot', $huetot, $obshuetot);
					 	$this->observacion->actualizarObservacion($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 4, 'thudob', $thudob, $obsthudob);
					 	$this->observacion->actualizarObservacion($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 4, 'thusui', $thusui, $obsthusui);
					 	$this->observacion->actualizarObservacion($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 4, 'thumult', $thumult, $obsthumult);
				     	$this->observacion->actualizarObservacion($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 4, 'inalomul', $inalomul, $obsinalomul);
					 	$this->observacion->actualizarObservacion($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 4, 'inalootr', $inalootr, $obsinalootr);
					 }
					 else{
					 	//El registro no existe. Por lo que debo ingresarlo a la B.D.
					 	$tphto = 0;
					 	$this->modulo4->insertarModulo($habdia, $ihdo, $ihoa, $camdia, $icda, $icva, $ihpn, $ihpnr, $huetot, $mvnr, $mvcr, $mvor, $mvsr, $mvotr, $mvott, $mvnnr, $mvcnr, $mvonr, $mvsnr, $mvotnr, $mvottnr, $thsen,  $thusen, $thdob, $thudob, $thsui, $thusui, $thmult, $thumult, $thotr, $thtot, $ingsen, $ingdob, $ingsui, $ingmult, $ingotr, $ingtot, $tphto, $inalosen, $inalodob, $inalosui, $inalomul, $inalootr, $inalotot, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);					 	
					 }	 
				     $this->control->actualizarControl($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 'modulo4', 2); //Estado del modulo 1 en (2 - Diligenciado)
				     
				     //Actualizar la novedad y el estado en control
                     $this->control->actualizarNovedadEstado($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $estado=2);
					 break;
				     
			case 5:  //Guardar los datos del modulo nuevo de clasificacion CIIU4
                     //Recibo nuevamente todos los checks que ha diligenciado la fuente, pero con la matrix de checkboxes.
					 //Matriz que contiene cada uno de los checks de cada una de las areas.
					 //Pregunto si el registro existe. Si existe lo actualizo, si no lo inserto.
		$matrix[1] = array("chkServicios11","chkServicios12","chkServicios13","chkServicios14","chkServicios15","chkServicios16","chkServicios17","chkServicios18","chkServicios19","chkServicios110","chkServicios111","chkServicios112");
					 $matrix[2] = array("chkServicios21","chkServicios22","chkServicios23","chkServicios24","chkServicios25","chkServicios26","chkServicios27","chkServicios28","chkServicios29","chkServicios210","chkServicios211","chkServicios212","chkServicios213","chkServicios214","chkServicios215");
					 $matrix[3] = array("chkServicios31","chkServicios32","chkServicios33","chkServicios34","chkServicios35","chkServicios36","chkServicios37","chkServicios38","chkServicios39","chkServicios310","chkServicios311","chkServicios312","chkServicios313");
					 $matrix[4] = array("chkServicios41","chkServicios42","chkServicios43","chkServicios44","chkServicios45","chkServicios46","chkServicios47","chkServicios48","chkServicios49","chkServicios410","chkServicios411","chkServicios412");
					 $matrix[5] = array("chkServicios51","chkServicios52","chkServicios53","chkServicios54","chkServicios55","chkServicios56","chkServicios57","chkServicios58","chkServicios59","chkServicios510");
					 $matrix[6] = array("chkServicios61","chkServicios62","chkServicios63","chkServicios64","chkServicios65");
					  
					 $otroServ=explode("&",$_REQUEST['form']);
					 
					 for($z=0; $z<=count($otroServ); $z++){
						
						if (stristr($otroServ[$z], 'otroServicio')) {
							$otro_serv=explode("=",$otroServ[$z]);
							$otro=$otro_serv[1];
							$otro_servicio = str_replace("+", " ", $otro);
						}
					 }
					 $resultados = array(); //Array que contiene cada una de las areas 
					 //Para cada una de las areas, recorro la matriz y preparo un string de cada area.
					 for ($x=1; $x<=count($matrix); $x++){ //Recorre el array de checks 
					 	$cadena = "";
						for ($i=0; $i<count($matrix[$x]); $i++){ //Para cada array de checks construya la cadena del tipo "100000000001", y almacenela en resultados
							$string = '$valor=(isset($'.$matrix[$x][$i].'))?1:0;'; //Si esta definido el check, pasa 1, si no esta definido, pasa 0.
							eval($string);
							$cadena .= $valor;
						}
						$resultados[$x] = $cadena;
					 }
					 
					 if ($this->modulo5->existeRegistro($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo)){
					 	//El registro ya existe. Por lo que actualizo los datos que ya hayan sido diligenciados.
					 	$this->modulo5->actualizarModulo($resultados[1], $resultados[2], $resultados[3], $resultados[4], $resultados[5], $resultados[6], $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $otro_servicio);
					 }
					 else{
					 	//El registro no existe. Por lo que debo ingresarlo a la B.D.
					 	$this->modulo5->insertarModulo($resultados[1], $resultados[2], $resultados[3], $resultados[4], $resultados[5], $resultados[6], $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $otro_servicio);					 	
					 }					 
                     $this->control->actualizarControl($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 'modulo5', 2); //Estado del modulo 1 en (2 - Diligenciado)
                     
                     //Acualiza el c�digo ciiu en la tabla estableciilentos
                     $data["categorias"] = $this->modulo5->obtenercategorias(); //Se pasan los datos necesarios para el modulo5.
                      
                     //Acualiza el c�digo ciiu en la tabla estableciilentos
                     //$this->modulo5->acualizaCodCiiu($resultados[1], $resultados[2], $resultados[3], $resultados[4], $resultados[5], $resultados[6], $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $otro_servicio);
                     for ($i=0; $i<count($data["categorias"]); $i++){
                     	$j=$i+1;
                     	if($resultados[$j]>0){
                     		$this->modulo5->acualizaCodCiiu($data["categorias"][$i]['cod_ciiu'], $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
                     	}
                     }
                     
                     //Actualizar la novedad y el estado en control
                     $this->control->actualizarNovedadEstado($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $estado=2);
					 break;	     
			         
			default: if ($this->envioform->existeRegistro($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo)){
					 	//El registro ya existe. Por lo que actualizo los datos que ya hayan sido diligenciados     	
						$this->envioform->actualizarModulo($observaciones, $dmpio, $fedili, $repleg, $responde, $respoca, $teler, $emailr, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
					 }
					 else{	
					 	//El registro no existe. Por lo que debo ingresarlo a la B.D.
					 	$this->envioform->insertarModulo($observaciones, $dmpio, $fedili, $repleg, $responde, $respoca, $teler, $emailr, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
					 }
					 $this->control->actualizarControl($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 'envio', 2); //Estado del modulo 1 en (2 - Diligenciado)
					 
					 //Actualizar la novedad y el estado en control
                     $this->control->actualizarNovedadEstado($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $estado=3);
			         break;					  
		}
		$this->observacion->guardarObservacion($capitulo, $campo, $observacion, $fecha, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $idcritico); //Guardo la observacion del logistico.
	}
	
	//Obtiene los datos actuales para una fuente que va a ser eliminada del sistema.
	public function obtenerDatosFuente(){
		$this->load->model("sede");
		$this->load->model("subsede");
		$this->load->model("usuario");
		$this->load->model("actividad");
		$this->load->model("divipola");
		foreach($_POST as $nombre_campo => $valor){
  			$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   			
  			eval($asignacion);
		}
		$arrayDatos = explode("-",$cmbFuenteLOG);
		$nro_orden = $arrayDatos[0];
		$nro_establecimiento = $arrayDatos[1];
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$inclusion = "";
		$info = $this->usuario->obtenerDatosFuente($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		switch ($info["inclusion"]){
			case 'F': $inclusion = "Forzosa";
			          break;
			case 'P': $inclusion = "Probabil&iacute;stica";
			          break;        
		}
		echo '<fieldset style="border: 1px solid #CCCCCC; padding: 10px;">
			  <legend><b>&nbsp;Datos Empresa&nbsp;</b></legend>
			  <table>
			  <tr>
	  			<td>Nro. Orden:&nbsp;&nbsp;</td>
	  			<td>'.$info["nro_orden"].'</td>
			  </tr>
	          <tr>
	  			<td>Nit Empresa:&nbsp;&nbsp;</td>
	  			<td>'.$info["idnit"].'</td>
			  </tr>
			  <tr>
      			<td>Nombre Empresa:&nbsp;&nbsp;</td>
      			<td>'.$info["idproraz"].'</td>
			  </tr>
			  </table>
			  </fieldset>
			  <br/>
			  <fieldset style="border: 1px solid #CCCCCC; padding: 10px;">
			  <legend><b>&nbsp;Datos Establecimiento&nbsp;</b></legend>
			  <table>
			  <tr>
	  			<td>Nro. Establecimiento:&nbsp;&nbsp;</td>
	  			<td>'.$info["nro_establecimiento"].'</td>
			  </tr>
			  <tr>
	  			<td>Nombre:&nbsp;&nbsp;</td>
	  			<td>'.$info["idnomcom"].'</td>
			  </tr>
			  <tr>
	  			<td>Direcci&oacute;n:&nbsp;&nbsp;</td>
	  			<td>'.$info["iddirecc"].'</td>
			  </tr>	
			  <tr>
	  			<td>Departamento:&nbsp;&nbsp;</td>
	  			<td>'.$this->divipola->nombreDepartamento($info["fk_depto"]).'</td>    
			  </tr>
			  <tr>
	  			<td>Municipio:&nbsp;&nbsp;</td>
	  			<td>'.$this->divipola->nombreMunicipio($info["fk_mpio"]).'</td>    
			  </tr>
			  <tr>
	  			<td>Actividad:&nbsp;&nbsp;</td>
	  			<td>'.$this->actividad->nombreActividad($info["fk_ciiu"]).'</td>    
			  </tr>
			  <tr>
	  			<td>Sede:&nbsp;&nbsp;</td>
	  			<td>'.$this->sede->nombreSede($info["fk_sede"]).'</td>    
			  </tr>
			  <tr>
	  			<td>Sub - Sede:&nbsp;&nbsp;</td>
	  			<td>'.$this->subsede->nombreSubSede($info["fk_subsede"]).'</td>    
			  </tr>
			  <tr>
	  			<td>Inclusi&oacute;n:&nbsp;&nbsp;</td>
	  			<td>'.$inclusion.'</td>
			  </tr>
			  </table>
			  </fieldset>';
	}
	
	//Muestra el consolidado de los m�dulos II, III y IV para las empresas.)
	public function mostrarConsolidado($nro_orden){
		$this->load->model("control");
		$this->load->model("periodo");
		$this->load->model("usuario");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$data["nombre"] = $this->usuario->obtenerNombreEmpresa($nro_orden, $ano_periodo, $mes_periodo);
		$data["nro_orden"] = $nro_orden;
		$data["controller"] = "logistica";
		$data["menu"] = "logmenu";
		$data["view"] = "consolidadoEmpresa";
		//$data["view"] = "detalle";
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$this->load->view("layout",$data);
	}
	
	
}//EOC