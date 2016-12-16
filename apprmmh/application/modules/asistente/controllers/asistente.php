<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Asistente extends MX_Controller {

	public function __construct(){
        parent::__construct();
		$this->load->helper("url");
		$this->load->library("session");		
		$this->load->library("validarsesion");
		$this->load->library("pagination");
		$this->load->library("general");
    }

	//Se ejecuta por defecto al iniciar el modulo	
	public function index(){
		$this->load->model("periodo");
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==3){
			$data['tipo_usuario']="ASISTENTE T&Eacute;CNICO";
		}
		$data["nom_usuario"] = $nom_usuario;
		$data["controller"] = "asistente";
		$data["view"] = "astecnico";
		$data["menu"] = "asismenu";
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$this->load->view("layout",$data);
	}
	
	//Actualiza el ano, mes del periodo segun se seleccione en el combo del menu
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
		redirect('/asistente', 'location', 301);
	}
	
	//Muestra el directorio de fuentes asignadas a la misma sede en la que se encuentra un asistente
	public function directorio(){
		$this->load->model("control");
		$this->load->model("periodo");
		$this->load->model("usuario");
		$idasistente = $this->session->userdata("id");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$sede = $this->usuario->obtenerSede($idasistente);
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==3){
			$data['tipo_usuario']="ASISTENTE T&Eacute;CNICO";
		}
		$data["nom_usuario"] = $nom_usuario;
		$data["controller"] = "asistente";
		$data["view"] = "directorio";
		$data["menu"] = "asismenu";
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		
		//Configuracion del paginador
		$config = array();
		$config["base_url"] = site_url("asistente/directorio");
		$config["total_rows"] = $this->usuario->contarFuentesAsignadasSede($sede, $ano_periodo, $mes_periodo);
		$config["per_page"] = 50;   //Cantidad de registros por pagina que debe mostrar el paginador
		$config["num_links"] = 5;  //Cantidad de links para cambiar de página que va a mostrar el paginador.
		$config["first_link"] = "Primero";
		$config["last_link"] = "&Uacute;ltimo";
		$config["use_page_numbers"] = TRUE;
		$this->pagination->initialize($config);
		//Trabajo de paginacion
		$pagina = ($this->uri->segment(3))?$this->uri->segment(3):1;
		$desde = ($pagina - 1) * $config["per_page"];
		$data["total"] = $config["total_rows"];
		$data["fuentes"] = $this->usuario->obtenerFuentesAsignadasSedePagina($sede, $ano_periodo, $mes_periodo, $desde, $config["per_page"]);
		$data["links"] = $this->pagination->create_links();
		$this->load->view("layout",$data);
	}
	
	
	//Realiza la asignacion de fuentes a criticos que se encuentren en la misma sede
	public function usuarios(){
		$this->load->model("usuario");
		$this->load->model("periodo");
		$idasistente = $this->session->userdata("id");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$sede = $this->usuario->obtenerSede($idasistente);
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==3){
			$data['tipo_usuario']="ASISTENTE T&Eacute;CNICO";
		}
		$data["nom_usuario"] = $nom_usuario;
		$data["controller"] = "asistente";
		$data["view"] = "usuarios";
		$data["menu"] = "asismenu";
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$data["reciente"] = $this->periodo->obtenerPeriodoActual();
		//Paginador para los registros de usuarios
		$this->paginador2->setFuncion("asistente/pagerUsuarios");
		$data["total"] = $this->usuario->contarCriticos($sede, $ano_periodo, $mes_periodo);
		$data["criticos"] = $this->usuario->obtenerCriticosPagina($sede, 0, $ano_periodo, $mes_periodo);
		$data["paginador"] = $this->paginador2->paginar('divUsuarios',1,$data["total"]);
		$this->load->view("layout",$data);
	}
	
	//Realiza la busqueda de formularios sobre las fuentes asignadas al critico
	public function formularios(){
		$this->load->model("periodo");
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==3){
			$data['tipo_usuario']="ASISTENTE T&Eacute;CNICO";
		}
		$data["nom_usuario"] = $nom_usuario;
		$data["menu"] = "asismenu";
		$data["controller"] = "critico";
		$data["view"] = "formularios";
		$this->load->view("layout",$data);
	}
	
	//Muestra el reporte operativo para el critico
	public function operativo(){
		$this->load->model("usuario");
		$this->load->model("control");
		$this->load->model("periodo");
		$idasistente = $this->session->userdata("id");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$sede = $this->usuario->obtenerSede($idasistente);
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==3){
			$data['tipo_usuario']="ASISTENTE T&Eacute;CNICO";
		}
		$data["nom_usuario"] = $nom_usuario;
		$data["controller"] = "asistente";
		$data["menu"] = "asismenu";
		$data["view"] = "operativo";
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$data["informe"] = $this->control->informeOperativoAsistente(0, 0, $ano_periodo, $mes_periodo, $sede, 0); //No importa el ID del usuario, No Importa la subsede.				
		$this->load->view("layout",$data);
	}
	
	//Muestra el reporte operativo por criticos
	public function operativoCritico(){
		$this->load->model("usuario");
		$this->load->model("periodo");
		$this->load->model("control");
		$this->load->model("sede");
		$this->load->model("subsede");
		$idasistente = $this->session->userdata("id");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$sede = $this->usuario->obtenerSede($idasistente);
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$data["controller"] = "asistente";
		$data["menu"] = "asismenu";
		$data["view"] = "operativocr";
		$data["sedes"] = $this->sede->obtenerSedes();
		$criticos = $this->usuario->obtenerCriticos($sede, $ano_periodo, $mes_periodo);
		//Para cada uno de los criticos que se encontraron, obtengo su respectivo reporte operativo
		for ($i=0; $i<count($criticos); $i++){
			$data["reporte"][$i]["nombre"] = $criticos[$i]["nombre"];
			$data["reporte"][$i]["reporte"] = $this->control->informeOperativoAsistente($criticos[$i]["id"], 0, $ano_periodo, $mes_periodo, $sede, 0);
		}
		$this->load->view("layout",$data);		
	}
	
	//Muestra el detalle del reporte operativo
	public function detalleOperativo($index){
		$this->load->model("control");
		$this->load->model("usuario");
		$this->load->model("periodo");
		$this->load->model("directorio");
		$idasistente = $this->session->userdata("id");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$sede = $this->usuario->obtenerSede($idasistente);
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==2){
			$data['tipo_usuario']="CR&Iacute;TICO";
		}
		$data["nom_usuario"] = $nom_usuario;
		$data["controller"] = "critico";
		$data["menu"] = "asismenu";
		$data["view"] = "operativodetalle";
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		switch($index){
			case 0: //Directorio Base;
					$data["titulo"] = "Directorio Base";
					$data["fuentes"] = $this->directorio->obtenerDirectorioBase(0, 0, $ano_periodo, $mes_periodo, $sede, 0);
					break;
			case 1: //Nuevos
				    $data["titulo"] = "Nuevos"; 
					$data["fuentes"] = $this->directorio->obtenerDirectorioNuevos(0, 0, $ano_periodo, $mes_periodo, $sede, 0);				    
					break;
			case 2: //Total a Recolectar;
				    $data["titulo"] = "Total a Recolectar";
					$data["fuentes"] = $this->directorio->obtenerDirectorioTotalRecolectar(0, 0, $ano_periodo, $mes_periodo, $sede, 0);					
					break;
			case 3: //Sin Distribuir
					$data["titulo"] = "Sin Distribuir";
					$data["fuentes"] = $this->directorio->obtenerDirectorioSinDistribuir(0, 0, $ano_periodo, $mes_periodo, $sede, 0);					
					break;
			case 4: //Distribuidos
					$data["titulo"] = "Distribuidos";
					$data["fuentes"] = $this->directorio->obtenerDirectorioDistribuir(0, 0, $ano_periodo, $mes_periodo, $sede, 0);					
					break;
			case 5: //En Digitacion
					$data["titulo"] = "En digitaci&oacute;n";
					$data["fuentes"] = $this->directorio->obtenerDirectorioEnDigitacion(0, 0, $ano_periodo, $mes_periodo, $sede, 0);					
					break;
			case 6: //Digitados
					$data["titulo"] = "Digitados";
					$data["fuentes"] = $this->directorio->obtenerDirectorioDigitados(0, 0, $ano_periodo, $mes_periodo, $sede, 0);					
					break;
			case 7: //Analisis - Verificacion
					$data["titulo"] = "Analisis - Verificaci&oacute;n";
					$data["fuentes"] = $this->directorio->obtenerDirectorioAnalisisVerificacion(0, 0, $ano_periodo, $mes_periodo, $sede, 0);
					break;
			case 8: //Verificados
					$data["titulo"] = "Verificados";
					$data["fuentes"] = $this->directorio->obtenerDirectorioVerificados(0, 0, $ano_periodo, $mes_periodo, $sede, 0);					
					break;
			case 9: //Novedades
					$data["titulo"] = "Novedades";
					$data["fuentes"] = $this->directorio->obtenerDirectorioNovedades(0, 0, $ano_periodo, $mes_periodo, $sede, 0);					
					break;																		
		}
		$this->load->view("layout",$data);
	}
	
	//Cierra la sesion del critico y retorna al login
	public function cerrarSesion(){				
		$this->session->sess_destroy();
		redirect("login","refresh");
	}
	
	//Muestra el detalle del formulario
	public function detalleFormulario($nro_orden, $nro_establecimiento){
		$this->load->model("control");
		$this->load->model("usuario");
		$this->load->model("periodo");
		$this->load->model("divipola");
		$this->load->model("modulo1");
		$this->load->model("modulo2");
		$this->load->model("modulo3");
		$this->load->model("modulo4");
		$this->load->model("modulo5");
		$this->load->model("envioform");
		$this->load->model("observacion");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==3){
			$data['tipo_usuario']="ASISTENTE T&Eacute;CNICO";
		}
		$data["nom_usuario"] = $nom_usuario;
		$data["controller"] = "asistente";
		$data["menu"] = "asismenu";
		$data["view"] = "detalle";
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
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
		
		$data["pyz"] = $this->envioform->datosPazYSalvo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data["pazysalvo"] = $this->control->validarPazYSalvo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data["critico"] = $this->observacion->obtenerNombreCritico($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo); //Obtiene el nombre del critico que trabajo sobre el formulario
		$data["logistico"] = $this->observacion->obtenerNombreLogistico($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo); //Obtiene el nombre del logistico que trabajo sobre el formulario
		$data["observaciones"] = $this->observacion->obtenerObservaciones($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data["observacionesCR"] = $this->observacion->obtenerObservacionesCritica($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data["observacionesAT"] = $this->observacion->obtenerObservacionesAsistente($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data["observacionesLG"] = $this->observacion->obtenerObservacionesLogistica($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo); 
		$data["observacionesAD"] = $this->observacion->obtenerObservacionesAdministrador($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data["bloqueo"] = false; //Todos los campos se habilitan para que sean modificados por el asistente
		$this->load->view("layout",$data);
	}
	
	//Realiza la asignacion de fuentes a los criticos desde el modulo del asistente técnico (Para la misma sede del asistente tecnico)
	public function asignarFuentes($idcritico){
		$this->load->model("periodo");
		$this->load->model("usuario");
		$idasistente = $this->session->userdata("id");
		$sede = $this->usuario->obtenerSede($idasistente);
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$data["controller"] = "administrador";
		$data["menu"] = "asismenu";
		$data["view"] = "asignarfuente";
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$data["idcritico"] = $idcritico;
		$data["nomcritico"] = $this->usuario->obtenerNombreCritico($idcritico);
		$data["sinasignar"] = $this->usuario->obtenerFuentesSinAsignar($sede, $ano_periodo, $mes_periodo);
		$data["asignados"] = $this->usuario->obtenerFuentesAsignadas($idcritico, $sede, $ano_periodo, $mes_periodo);
		$this->load->view("layout",$data);
	}
	
	//Actualiza la tabla de control y asigna las fuentes a un critico 
	public function asignarFuentesCritico(){
		$this->load->model("usuario");
		$this->load->model("control");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$usuario = $this->input->post("hddCritico");		 //Obtengo el ID del usuario
		$rol = $this->usuario->obtenerRolUsuario($usuario);  //Con base en el id de usuario obtengo el rol de ese usuario
		$fuentes = $this->input->post("chkSinasignar");
		for ($i=0; $i<count($fuentes); $i++){
			$arrayData = explode("-",$fuentes[$i]);			
			$this->control->asignarFuenteCritico($arrayData[0], $arrayData[1], $ano_periodo, $mes_periodo, $usuario);						
		}
		redirect("asistente/asignarFuentes/$usuario","location", 301);
	}
	
	//Actualiza la tabla de control y remueve las fuentes que se han asignado a un critico
	public function removerFuentesCritico(){
		$this->load->model("control");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$critico = $this->input->post("hddCritico");
		$fuentes = $this->input->post("chkAsignados");
		for ($i=0; $i<count($fuentes); $i++){
			$arrayData = explode("-",$fuentes[$i]);
			$this->control->asignarFuenteCritico($arrayData[0], $arrayData[1], $ano_periodo, $mes_periodo, 0);
		}
		redirect("asistente/asignarFuentes/$critico","location", 301);
	}
	
	//Funciones AJAX Utilizadas en el modulo de crítica
	//*************************************************
	
	// 1) Realiza las funciones de paginacion de resultados del directorio de critica
	public function pagerDirectorio(){
		$this->load->model("usuario");
		$idasistente = $this->session->userdata("id");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$sede = $this->usuario->obtenerSede($idasistente);
		$pagina = $this->input->post("pagina");
		$desde = ($pagina - 1) * $this->paginador2->getRegsPagina();
		$this->paginador2->setFuncion("asistente/pagerDirectorio");
		$data["total"] = $this->usuario->contarFuentesAsignadasSede($sede, $ano_periodo, $mes_periodo);
		$data["fuentes"] = $this->usuario->obtenerFuentesAsignadasSedePagina($desde, $sede, $ano_periodo, $mes_periodo);
		$data["paginador"] = $this->paginador2->paginar('divResultados',$pagina,$data["total"]);
		$this->load->view("directorio",$data);
	}
	
	// 2) Realiza la busqueda de formularios sobre las fuentes asignadas al critico (Genera los resultados de la Busqueda)
	public function buscarFuentes(){
		$this->load->model("control");
		$this->load->model("usuario");		
		$this->load->model("directorio");
		$idasistente = $this->session->userdata("id");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$sede = $this->usuario->obtenerSede($idasistente);//Obtengo la sede del asistente tecnico
		$opcion = $this->input->post("opcion");
		$busqueda = $this->input->post("buscar");
		//Configuracion del paginador
		$config = array();
		$config["base_url"] = site_url("asistente/buscarFuentes");
		$config["total_rows"] = $this->directorio->contarDirectorioAsistente($ano_periodo, $mes_periodo, $sede, $opcion, $busqueda);
		$config["per_page"] = 50;   //Cantidad de registros por pagina que debe mostrar el paginador
		$config["num_links"] = 5;  //Cantidad de links para cambiar de página que va a mostrar el paginador.
		$config["first_link"] = "Primero";
		$config["last_link"] = "&Uacute;ltimo";
		$config["use_page_numbers"] = TRUE;
		$this->pagination->initialize($config);
		//Trabajo de paginacion
		$pagina = ($this->uri->segment(3))?$this->uri->segment(3):1; //Si esta definido un valor por get, utilice el valor, de lo contrario utilice cero (para el primer valor a mostrar).
		$desde = ($pagina - 1) * $config["per_page"];
		$data["fuentes"] = $this->directorio->buscarDirectorioAsistentePagina($ano_periodo, $mes_periodo, $sede, $opcion, $busqueda, $desde, $config["per_page"]);
		$data["total"] = $config["total_rows"];
		$data["links"] = $this->pagination->create_links();		
		$this->load->view("ajxformularios",$data);
	}
	
	// 3) Guarda las observaciones realizadas por un critico a uno de los formularios
	public function guardarObservacion(){
		$this->load->model("observacion");
		$capitulo = $this->input->post("capitulo");
		$campo = "";
		$observacion = $this->input->post("observacion");
		$fecha = date("Y-m-d h:i:s");
		$this->observacion->guardarObservacion($capitulo, $campo, $observacion, $fecha, $nro_orden, $uni_local, $ano_periodo, $mes_periodo, $idcritico);
	}
	
	// 4) Guarda las modificaciones en crítica que se hayan realizado a los capitulos del formulario 
	public function guardarCapitulo(){
		$this->load->model("modulo1");		
		$this->load->model("modulo2");
		$this->load->model("modulo3");
		$this->load->model("modulo4");
		$this->load->model("modulo5");		
		$this->load->model("envioform");
		$this->load->model("observacion");
		$this->load->model("control");
		$idasistente = $this->session->userdata("id");
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
			$array = explode("=", $str);
			$asignacion = "\$" . $array[0] . "='" . str_replace("+"," ",$array[1]) . "';";   						
  			eval($asignacion);
		}
		//Dependiendo del capitulo que se reciba, voy a actualizar los datos del capitulo.
		switch($capitulo){
			case 1:  //Guardar los datos del formulario
				     $this->modulo1->actualizarModulo($nro_orden, $nro_establecimiento, $idnit, $idproraz, $idnomcom, $idsigla, $iddirecc, $iddepto, $idmpio, $idtelno, $idfaxno, $idpagweb, $idcorreo, $finicial, $ffinal,
				                                      $idnomcomest, $idsiglaest, $iddireccest, $iddeptoest, $idmpioest, $idtelnoest, $idfaxnoest, $idcorreoest, $nom_cadena, $nom_operador);
                                                     
                     break;
                     
			case 2:  //Guardar los datos del formulario
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
			         break;
			         
			case 3:  //Guardar los datos del formulario
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
			         break;
			         
			case 4:  //Guardar los datos del formulario
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
					 /*if (!isset($obsinalomul)){
						$obsinalomul = "";			
					 }
					 if (!isset($obsinalootr)){
						$obsinalootr = "";
					 }*/
					 $this->observacion->actualizarObservacion($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 4, 'ihoa', $ihoa, $obsihoa);
					 $this->observacion->actualizarObservacion($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 4, 'icva', $icva, $obsicva);
					 $this->observacion->actualizarObservacion($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 4, 'huetot', $huetot, $obshuetot);
					 $this->observacion->actualizarObservacion($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 4, 'thudob', $thudob, $obsthudob);
					 $this->observacion->actualizarObservacion($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 4, 'thusui', $thusui, $obsthusui);
					 $this->observacion->actualizarObservacion($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 4, 'thumult', $thumult, $obsthumult);
				     $this->observacion->actualizarObservacion($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 4, 'inalomul', $inalomul, $obsinalomul);
					 $this->observacion->actualizarObservacion($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 4, 'inalootr', $inalootr, $obsinalootr);
			         break;
			         
			case 5:  //Guardar los datos del modulo nuevo de clasificacion CIIU4
                     //Recibo nuevamente todos los checks que ha diligenciado la fuente, pero con la matrix de checkboxes.
					 //Matriz que contiene cada uno de los checks de cada una de las areas.
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
				     $this->modulo5->actualizarModulo($resultados[1], $resultados[2], $resultados[3], $resultados[4], $resultados[5], $resultados[6], $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $otro_servicio);
                     //Acualiza el código ciiu en la tabla estableciilentos
				     $data["categorias"] = $this->modulo5->obtenercategorias(); //Se pasan los datos necesarios para el modulo5.
				      
				     //Acualiza el código ciiu en la tabla estableciilentos
				     //$this->modulo5->acualizaCodCiiu($resultados[1], $resultados[2], $resultados[3], $resultados[4], $resultados[5], $resultados[6], $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $otro_servicio);
				     for ($i=0; $i<count($data["categorias"]); $i++){
				     	$j=$i+1;
				     	if($resultados[$j]>0){
				     		$this->modulo5->acualizaCodCiiu($data["categorias"][$i]['cod_ciiu'], $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $otro_servicio);
				     	}
				     }
				     
				     break;         
			         
					 default: $this->envioform->actualizarModulo($fteObserv, $dmpio, $fedili, $repleg, $responde, $respoca, $teler, $emailr, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
			         break;					  
		}
		$this->observacion->guardarObservacion($capitulo, $campo, $observacion, $fecha, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $idasistente);		 
	} 
	
	// 5) Realiza las funciones de paginacion de resultados de los usuarios del asistente tecnico
	function pagerUsuarios(){
		$this->load->model("usuario");
		$this->load->model("periodo");
		$idasistente = $this->session->userdata("id");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$sede = $this->usuario->obtenerSede($idasistente);
		$pagina = $this->input->post("pagina");
		$desde = ($pagina - 1) * $this->paginador2->getRegsPagina();
		$this->paginador2->setFuncion("asistente/pagerUsuarios");
		$data["reciente"] = $this->periodo->obtenerPeriodoActual();
		$data["total"] = $this->usuario->contarCriticos($sede, $ano_periodo, $mes_periodo);
		$data["criticos"] = $this->usuario->obtenerCriticosPagina($sede, $desde, $ano_periodo, $mes_periodo);
		$data["paginador"] = $this->paginador2->paginar('divUsuarios',$pagina,$data["total"]);
		$this->load->view("usuarios",$data);
	}
	
	function pagerBuscadorFuentes(){
		$this->load->model("usuario");		
		$this->load->model("directorio");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$idasistente = $this->session->userdata("id");
		$sede = $this->usuario->obtenerSede($idasistente);//Obtengo la sede del asistente tecnico
		$opcion = $this->input->post("opcion");
		$busqueda = $this->input->post("buscar");
		$pagina = $this->input->post("pagina");
		$desde = ($pagina - 1) * $this->paginador2->getRegsPagina();
		$this->paginador2->setFuncion("asistente/pagerBuscadorFuentes");		
		$data["total"] = $this->directorio->contarDirectorioAsistente($ano_periodo, $mes_periodo, $sede, $opcion, $busqueda);
		$data["fuentes"] = $this->directorio->buscarDirectorioAsistentePagina($ano_periodo, $mes_periodo, $sede, $desde, $opcion, $busqueda);
		$data["paginador"] = $this->paginador2->paginar('divResultados',$pagina,$data["total"]);
		$this->load->view("ajxformularios",$data);		
	}

	// 6) Realiza la modificacion de datos de criticos
	public function UPDUsuario(){
		$this->load->model("usuario");
		$this->load->model("tipodocs");
		$this->load->model("rol");
		$this->load->model("sede");
		$this->load->model("subsede");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$index = $this->input->post("index");		
		$data["index"] = $index;
		$data["tipodoc"] = $this->tipodocs->obtenerTipoDocumentos();
		$data["roles"] = $this->rol->obtenerRoles();
		$data["sedes"] = $this->sede->obtenerSedes();
		$data["subsedes"] = $this->subsede->obtenerSubsedes(0); 
		$data["usuario"] = $this->usuario->obtenerUsuarioID($index, $ano_periodo, $mes_periodo);
		$this->load->view("ajxusuarioupd",$data);	
	}
	
	// x) Inserta el registro de la crecion de un nuevo usuario en la B.D.
	public function insertarUsuario(){
		$this->load->helper("url");
		$this->load->library("danecrypt");
		$this->load->library("general");
		$this->load->model("usuario");
		foreach($_POST as $nombre_campo => $valor){
  			$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   			
  			eval($asignacion);
		}
		$nro_orden = 0; //No se asigna un numero de orden
		$fecini = $this->general->formatoFecha($txtFecCreacion,"/");
		$fecfin = $this->general->formatofecha($txtFecVencimiento,"/");
		$password = $this->danecrypt->encode($txtPassword);
		$this->usuario->insertarUsuario($txtNumId, $txtNomUsuario, $txtLogin, $password, $txtEmail, $fecini, $fecfin, $nro_orden, $cmbRol, $cmbSede, $cmbSubsede, $cmbTipoDocumento);
		redirect('/asistente/usuarios','refresh');
	}

	// 7) Realiza la eliminacion de registros del critico desde el modulo de asistente
	public function eliminarUsuario($index){
		$this->load->helper("url");
		$this->load->model("usuario");
		$this->usuario->eliminarUsuario($index);
		redirect('/asistente/usuarios','refresh');
	}
	
	// 8) Actualizar usuario (Se actualizan los datos del usuario que se ha modificado desde el modulo de usuarios del asistente tecnico)
	public function actualizarUsuario(){
		$this->load->library("danecrypt");
		$this->load->helper("url");
		$this->load->model("usuario");
		foreach($_POST as $nombre_campo => $valor){
  			$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
  			eval($asignacion);
		}
		$password = $this->danecrypt->encode($txtPassword);
		$this->usuario->actualizarUsuario($hddIndex, $txtNumId, $txtNomUsuario, $txtLogin, $password, $txtEmail, $txtFecCreacion, $txtFecVencimiento, $cmbRol, $cmbsede, $cmbsubsede, $cmbTipoDocumento);		
		redirect('/asistente/usuarios','refresh');		
	}
	
	// 9) Inserta un nuevo usuario "critico" desde el modulo de asistente técnico. 
	public function INSUsuario(){
		$this->load->model("tipodocs");
		$this->load->model("rol");
		$this->load->model("sede");
		$this->load->model("subsede");
		$data["tipodoc"] = $this->tipodocs->obtenerTipoDocumentos();
		$data["roles"] = $this->rol->obtenerRoles();
		$data["sedes"] = $this->sede->obtenerSedes();
		$data["subsedes"] = $this->subsede->obtenerSubsedes(0); //Obtiene todas las subsedes		
		$this->load->view("ajxusuarioins",$data);
	}
	
	public function consultaFuentesAsignadas(){
		$this->load->model("control");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$rol = $this->input->post("rol");
		$id_usuario = $this->input->post("usuario");
		$fuentes = $this->control->obtenerNumeroFuentesAsignadas($rol, $id_usuario, $ano_periodo, $mes_periodo);		                           
		echo json_encode($fuentes);
	}
	
	
	
}//EOC
