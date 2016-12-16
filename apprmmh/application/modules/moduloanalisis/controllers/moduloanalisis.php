<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
	 * Controlador para el módulo de análisis
	 * @author Jesús Neira Guio - SJNEIRAG
	 * @since octubre 2015
	 */


class Moduloanalisis extends MX_Controller {
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
	
	//Funcion principal. Se ejecuta por defecto al cargar el controlador 
	public function index(){		
		$this->load->model("periodo");
		$this->load->model("analisis");
		$data["controller"] = "moduloanalisis";
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==4){
			$data['tipo_usuario']="ADMINISTRADOR";
		}
		$data["nom_usuario"] = $nom_usuario;
		$data["view"] = "analisis";
		if($tipo_usuario==4){
			$data['tipo_usuario']="ADMINISTRADOR";
			$data["menu"] =  ("administrador/adminmenu");
		}
		if($tipo_usuario==5){
			$data['tipo_usuario']="LOGISTICA";
			$data["menu"] =  ("logistica/logmenu");
		}
		if($tipo_usuario==6){
			$data['tipo_usuario']="TEMATICA";
			$data["menu"] =  ("tematica/tematicamenu");
		}
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$idRegional='';
		$data["regiones"] = $this->analisis->obtenerRegiones($idRegional);
				
		//Número de establecimientos por regional
		$tabla1="rmmh_admin_control";
		$tabla2="rmmh_admin_establecimientos";
		$index="establec";
		$campo="count(rmmh_admin_control.nro_establecimiento)";
		
		//Ingresos operacionales por regioanal
		$tableIng1="rmmh_form_ingoperacionales";
		$tableIng2="rmmh_admin_establecimientos";
		$indexIng="ingresos";
		$campoIng="sum(intio)";
		
		//Personal ocupado total
		$tablaPer1="rmmh_form_persalarios";
		$tablaPer2="rmmh_admin_establecimientos";
		$indexPer="personal";
		$campoPer="sum(pottot)";
		
		//Camas ofrecidas
		$tablaCamas1="rmmh_form_caracthoteles";
		$tablaCamas2="rmmh_admin_establecimientos";
		$indexCamas="camas";
		$campoCamas="sum(icda)";
		
		//Habitaciones ofrecidas
		$tablaHabit1="rmmh_form_caracthoteles";
		$tablaHabit2="rmmh_admin_establecimientos";
		$indexHabit="habit";
		$campoHabit="sum(ihdo)";
		
		//Ingresos por alojamiento
		$tableInalo1="rmmh_form_ingoperacionales";
		$tableInalo2="rmmh_admin_establecimientos";
		$indexInalo="inalo";
		$campoInalo="sum(inalo)";
		
		//Huespedes residentes y no residentes
		$tableHuetot1="rmmh_form_caracthoteles";
		$tableHuetot2="rmmh_admin_establecimientos";
		$indexHuetot="huetot";
		$campoHuetot="sum(huetot)";
		
		//Camas vendidas
		$tableIcva1="rmmh_form_caracthoteles";
		$tableIcva2="rmmh_admin_establecimientos";
		$indexIcva="icva";
		$campoIcva="sum(icva)";
		
		//Habitaciones vendidas
		$tableIhoa1="rmmh_form_caracthoteles";
		$tableIhoa2="rmmh_admin_establecimientos";
		$indexIhoa="ihoa";
		$campoIhoa="sum(ihoa)";
		
		//Estancia media
		$tableEstancia1="rmmh_form_caracthoteles";
		$tableEstancia2="rmmh_admin_establecimientos";
		$indexEstancia="estancia";
		$campoEstancia="sum(icva/huetot)";
		
		//Porcentaje de ocupación
		$tableOcupacion1="rmmh_form_caracthoteles";
		$tableOcupacion2="rmmh_admin_establecimientos";
		$indexOcupacion="ocupacion";
		$campoOcupacion="avg((ihoa/ihdo)*100)";
		
		//Valores de las variables para todas las regiones
		for($i=0; $i<=count($data["regiones"])-1; $i++){
			$depto= $data["regiones"][$i]["departamentos_incluidos"];
			$mpio=$data["regiones"][$i]["municipios_incluidos"];
			$idEstablec="";
			$data[$index]["regional".$i]=$data["regiones"][$i]["nom_region"];
			$data[$index]["idRegion".$i]=$data["regiones"][$i]["id_region"];
			$data["variacion"][$i]=$data["regiones"][$i]["variacion_limite"];
			$data[$index]["actual".$i] = $this->analisis->obtenerValorActualEst($tabla1, $tabla2, $campo, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$index]["anterior".$i] = $this->analisis->obtenerValorAnteriorEst($tabla1, $tabla2, $campo, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$index]["anual".$i] = $this->analisis->obtenerValorAnualEst($tabla1, $tabla2, $campo, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexIng]["actual".$i] = $this->analisis->obtenerValorActualEst($tableIng1, $tableIng2, $campoIng, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexIng]["anterior".$i] = $this->analisis->obtenerValorAnteriorEst($tableIng1, $tableIng2, $campoIng, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexIng]["anual".$i] = $this->analisis->obtenerValorAnualEst($tableIng1, $tableIng2, $campoIng, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexIng]["varmensual".$i] = $this->analisis->calcularVariacionMensual($data["ingresos"]["actual0"], $data["ingresos"]["anterior0"]);
			$data[$indexIng]["varanual".$i] = $this->analisis->calcularVariacionAnual($data["ingresos"]["actual0"], $data["ingresos"]["anual0"]);
			$data[$indexPer]["actual".$i] = $this->analisis->obtenerValorActualEst($tablaPer1, $tablaPer2, $campoPer, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexPer]["anterior".$i] = $this->analisis->obtenerValorAnteriorEst($tablaPer1, $tablaPer2, $campoPer, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexPer]["anual".$i] = $this->analisis->obtenerValorAnualEst($tablaPer1, $tablaPer2, $campoPer, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexCamas]["actual".$i] = $this->analisis->obtenerValorActualEst($tablaCamas1, $tablaCamas2, $campoCamas, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexCamas]["anterior".$i] = $this->analisis->obtenerValorAnteriorEst($tablaCamas1, $tablaCamas2, $campoCamas, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexCamas]["anual".$i] = $this->analisis->obtenerValorAnualEst($tablaCamas1, $tablaCamas2, $campoCamas, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexHabit]["actual".$i] = $this->analisis->obtenerValorActualEst($tablaHabit1, $tablaHabit2, $campoHabit, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexHabit]["anterior".$i] = $this->analisis->obtenerValorAnteriorEst($tablaHabit1, $tablaHabit2, $campoHabit, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexHabit]["anual".$i] = $this->analisis->obtenerValorAnualEst($tablaHabit1, $tablaHabit2, $campoHabit, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexInalo]["actual".$i] = $this->analisis->obtenerValorActualEst($tableInalo1, $tableInalo2, $campoInalo, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexInalo]["anterior".$i] = $this->analisis->obtenerValorAnteriorEst($tableInalo1, $tableInalo2, $campoInalo, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexInalo]["anual".$i] = $this->analisis->obtenerValorAnualEst($tableInalo1, $tableInalo2, $campoInalo, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexHuetot]["actual".$i] = $this->analisis->obtenerValorActualEst($tableHuetot1, $tableHuetot2, $campoHuetot, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexHuetot]["anterior".$i] = $this->analisis->obtenerValorAnteriorEst($tableHuetot1, $tableHuetot2, $campoHuetot, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexHuetot]["anual".$i] = $this->analisis->obtenerValorAnualEst($tableHuetot1, $tableHuetot2, $campoHuetot, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexIcva]["actual".$i] = $this->analisis->obtenerValorActualEst($tableIcva1, $tableIcva2, $campoIcva, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexIcva]["anterior".$i] = $this->analisis->obtenerValorAnteriorEst($tableIcva1, $tableIcva2, $campoIcva, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexIcva]["anual".$i] = $this->analisis->obtenerValorAnualEst($tableIcva1, $tableIcva2, $campoIcva, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexIhoa]["actual".$i] = $this->analisis->obtenerValorActualEst($tableIhoa1, $tableIhoa2, $campoIhoa, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexIhoa]["anterior".$i] = $this->analisis->obtenerValorAnteriorEst($tableIhoa1, $tableIhoa2, $campoIhoa, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexIhoa]["anual".$i] = $this->analisis->obtenerValorAnualEst($tableIhoa1, $tableIhoa2, $campoIhoa, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexEstancia]["actual".$i] = $this->analisis->obtenerValorActualEst($tableEstancia1, $tableEstancia2, $campoEstancia, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexEstancia]["anterior".$i] = $this->analisis->obtenerValorAnteriorEst($tableEstancia1, $tableEstancia2, $campoEstancia, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexEstancia]["anual".$i] = $this->analisis->obtenerValorAnualEst($tableEstancia1, $tableEstancia2, $campoEstancia, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexOcupacion]["actual".$i] = $this->analisis->obtenerValorActualEst($tableOcupacion1, $tableOcupacion2, $campoOcupacion, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexOcupacion]["anterior".$i] = $this->analisis->obtenerValorAnteriorEst($tableOcupacion1, $tableOcupacion2, $campoOcupacion, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexOcupacion]["anual".$i] = $this->analisis->obtenerValorAnualEst($tableOcupacion1, $tableOcupacion2, $campoOcupacion, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			//Variaciones
			$data["varMensualEst"][$i] = $this->analisis->calcularVariacionMensual($data[$index]["actual".$i], $data[$index]["anterior".$i]);
			$data["varAnualEst"][$i] = $this->analisis->calcularVariacionAnual($data[$index]["actual".$i], $data[$index]["anual".$i]);
			$data["varMensualIng"][$i] = $this->analisis->calcularVariacionMensual($data[$indexIng]["actual".$i], $data[$indexIng]["anterior".$i]);
			$data["varAnualIng"][$i] = $this->analisis->calcularVariacionAnual($data[$indexIng]["actual".$i], $data[$indexIng]["anual".$i]);
			$data["varMensualPer"][$i] = $this->analisis->calcularVariacionMensual($data[$indexPer]["actual".$i], $data[$indexPer]["anterior".$i]);
			$data["varAnualPer"][$i] = $this->analisis->calcularVariacionAnual($data[$indexPer]["actual".$i], $data[$indexPer]["anual".$i]);
			$data["varMensualCam"][$i] = $this->analisis->calcularVariacionMensual($data[$indexCamas]["actual".$i], $data[$indexCamas]["anterior".$i]);
			$data["varAnualCam"][$i] = $this->analisis->calcularVariacionAnual($data[$indexCamas]["actual".$i], $data[$indexCamas]["anual".$i]);
			$data["varMensualHab"][$i] = $this->analisis->calcularVariacionMensual($data[$indexHabit]["actual".$i], $data[$indexHabit]["anterior".$i]);
			$data["varAnualHab"][$i] = $this->analisis->calcularVariacionAnual($data[$indexHabit]["actual".$i], $data[$indexHabit]["anual".$i]);
			$data["varMensualInalo"][$i] = $this->analisis->calcularVariacionMensual($data[$indexInalo]["actual".$i], $data[$indexInalo]["anterior".$i]);
			$data["varAnualInalo"][$i] = $this->analisis->calcularVariacionAnual($data[$indexInalo]["actual".$i], $data[$indexInalo]["anual".$i]);
			$data["varMensualHuetot"][$i] = $this->analisis->calcularVariacionMensual($data[$indexHuetot]["actual".$i], $data[$indexHuetot]["anterior".$i]);
			$data["varAnualHuetot"][$i] = $this->analisis->calcularVariacionAnual($data[$indexHuetot]["actual".$i], $data[$indexHuetot]["anual".$i]);
			$data["varMensualIcva"][$i] = $this->analisis->calcularVariacionMensual($data[$indexIcva]["actual".$i], $data[$indexIcva]["anterior".$i]);
			$data["varAnualIcva"][$i] = $this->analisis->calcularVariacionAnual($data[$indexIcva]["actual".$i], $data[$indexIcva]["anual".$i]);
			$data["varMensualIhoa"][$i] = $this->analisis->calcularVariacionMensual($data[$indexIhoa]["actual".$i], $data[$indexIhoa]["anterior".$i]);
			$data["varAnualIhoa"][$i] = $this->analisis->calcularVariacionAnual($data[$indexIhoa]["actual".$i], $data[$indexIhoa]["anual".$i]);
			
		}
		
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		if(isset($_REQUEST["datos_a_enviar"])){
			//redireccionamos la salida al navegador del cliente (Excel2007)
			header('Content-type: application/vnd.ms-excel; charset=UTF-8');
			header("Content-Disposition: attachment; filename=reporte.xls");
			$this->load->view("analisis",$data);
		}else{
			$this->load->view("layout",$data);
		}		
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
	
	/**
	 * Función para el módulo de análisis variables generales por región
	 * @author Jesús Neira Guio - SJNEIRAG
	 * @since Agosto 2015
	 */
	public function generalesRegion($regional){
		$this->load->model("periodo");
		$this->load->model("analisis");
		$data["controller"] = "moduloanalisis";
		//$data["view"] = "analisis";
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==4){
			$data['tipo_usuario']="ADMINISTRADOR";
			$data["menu"] =  ("administrador/adminmenu");
		}
		if($tipo_usuario==5){
			$data['tipo_usuario']="LOGISTICA";
			$data["menu"] =  ("logistica/logmenu");
		}
		if($tipo_usuario==6){
			$data['tipo_usuario']="TEMATICA";
			$data["menu"] =  ("tematica/tematicamenu");
		}
		$data["nom_usuario"] = $nom_usuario;
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$usuario = $this->session->userdata("id");
		$data["ano_periodo"]=$ano_periodo;
		$data["mes_periodo"]=$mes_periodo;
		$data["view"] = "gnrlsRegion";
		
		//Obtiene la regional
		if(isset($_REQUEST['regional'])){
			$idRegional=$_REQUEST['regional'];
		}else{
			$idRegional=$regional;
		}
						
		$data["regiones"] = $this->analisis->obtenerRegiones($idRegional);
		if($data["regiones"][0]["municipios_incluidos"]!=''){
			$municipios=$data["regiones"][0]["municipios_incluidos"];
		}else{
			$municipios= "";
		}
		if($data["regiones"][0]["departamentos_incluidos"]!=''){
			$departamentos=$data["regiones"][0]["departamentos_incluidos"];
		}else{
			$departamentos= "";
		}
		
		//Optiene los establecimientos de cada rgional
		$data["establecimientosRegional"] = $this->analisis->obtenerEstablecimientosRegional($municipios,$departamentos);
		
		//Número de establecimientos por establecimiento
		$tabla1="rmmh_admin_control";
		$tabla2="rmmh_admin_establecimientos";
		$index="establec";
		$campo="count(rmmh_admin_control.nro_establecimiento)";
		
		//Ingresos operacionales por regioanal
		$tableIng1="rmmh_form_ingoperacionales";
		$tableIng2="rmmh_admin_establecimientos";
		$indexIng="ingresos";
		$indexIngCiu="ingresosCiu";
		$campoIng="sum(intio)";
		
		//Personal ocupado total
		$tablaPer1="rmmh_form_persalarios";
		$tablaPer2="rmmh_admin_establecimientos";
		$indexPer="personal";
		$campoPer="sum(pottot)";
		
		//Personal ocupado total
		$tablaPerCiu1="rmmh_form_persalarios";
		$tablaPerCiu2="rmmh_admin_establecimientos";
		$indexPerCiu="personalCiudad";
		$campoPerCiu="sum(pottot)";
		
		//Camas ofrecidas
		$tablaCamas1="rmmh_form_caracthoteles";
		$tablaCamas2="rmmh_admin_establecimientos";
		$indexCamas="camas";
		$campoCamas="sum(icda)";
		
		//Habitaciones ofrecidas
		$tablaHabit1="rmmh_form_caracthoteles";
		$tablaHabit2="rmmh_admin_establecimientos";
		$indexHabit="habit";
		$campoHabit="sum(ihdo)";
		
		//Ingresos por alojamiento
		$tableInalo1="rmmh_form_ingoperacionales";
		$tableInalo2="rmmh_admin_establecimientos";
		$indexInalo="inalo";
		$indexInaloCiu="inaloCiu";
		$campoInalo="sum(inalo)";
		
		//Huespedes residentes y no residentes
		$tableHuetot1="rmmh_form_caracthoteles";
		$tableHuetot2="rmmh_admin_establecimientos";
		$indexHuetot="huetot";
		$indexHuetotCiu="huetotCiu";
		$campoHuetot="sum(huetot)";
		
		//Camas vendidas
		$tableIcva1="rmmh_form_caracthoteles";
		$tableIcva2="rmmh_admin_establecimientos";
		$indexIcva="icva";
		$indexIcvaCiu="icvaCiu";
		$campoIcva="sum(icva)";
		
		//Habitaciones vendidas
		$tableIhoa1="rmmh_form_caracthoteles";
		$tableIhoa2="rmmh_admin_establecimientos";
		$indexIhoa="ihoa";
		$indexIhoaCiu="ihoaCiu";
		$campoIhoa="sum(ihoa)";
		
		//Tarifa promedio habitación sencilla
		$tableThusen1="rmmh_form_caracthoteles";
		$tableThusen2="rmmh_admin_establecimientos";
		$indexThusen="thusen";
		$campoThusen="thusen";
		
		//Tarifa promedio habitación doble
		$tableThudob1="rmmh_form_caracthoteles";
		$tableThudob2="rmmh_admin_establecimientos";
		$indexThudob="thudob";
		$campoThudob="thudob";
		
		//Tarifa promedio habitación suite
		$tableThusui1="rmmh_form_caracthoteles";
		$tableThusui2="rmmh_admin_establecimientos";
		$indexThusui="thusui";
		$campoThusui="thusui";
		
		//Tarifa promedio habitación múltiple
		$tableThumult1="rmmh_form_caracthoteles";
		$tableThumult2="rmmh_admin_establecimientos";
		$indexThumult="thumult";
		$campoThumult="thumult";
		
		//Tarifa promedio otro tipo de habitación				
		$tableThuotr1="rmmh_form_caracthoteles";
		$tableThuotr2="rmmh_admin_establecimientos";
		$indexThuotr="thuotr";
		$campoThuotr="thuotr";
		
		//Estancia media
		$tableEstancia1="rmmh_form_caracthoteles";
		$tableEstancia2="rmmh_admin_establecimientos";
		$indexEstancia="estancia";
		$campoEstancia="sum(icva/huetot)";
		
		//Porcentaje de ocupación
		$tableOcupacion1="rmmh_form_caracthoteles";
		$tableOcupacion2="rmmh_admin_establecimientos";
		$indexOcupacion="ocupacion";
		$campoOcupacion="avg((ihoa/ihdo)*100)";
		
		//Valores de las variables para todas las regiones
		for($i=0; $i<=count($data["establecimientosRegional"])-1; $i++){
			$idEstablec= $data["establecimientosRegional"][$i]["nro_establecimiento"];
			$depto= "";
			$mpio="";
			$data[$index]["regional".$i]=$data["regiones"][0]["nom_region"];
			$data[$index]["idRegion".$i]=$data["regiones"][0]["id_region"];
			$data["variacion"][$i]=$data["regiones"][0]["variacion_limite"];
			$data[$index]["actual".$i] = $this->analisis->obtenerValorActualEst($tabla1, $tabla2, $campo, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$index]["anterior".$i] = $this->analisis->obtenerValorAnteriorEst($tabla1, $tabla2, $campo, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$index]["anual".$i] = $this->analisis->obtenerValorAnualEst($tabla1, $tabla2, $campo, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			
			//Obtener ingresos por establecimiento
			$data[$indexIng]["actual".$i] = $this->analisis->obtenerValorActualEst($tableIng1, $tableIng2, $campoIng, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexIng]["anterior".$i] = $this->analisis->obtenerValorAnteriorEst($tableIng1, $tableIng2, $campoIng, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexIng]["anual".$i] = $this->analisis->obtenerValorAnualEst($tableIng1, $tableIng2, $campoIng, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			
			//Obtener ingresos por ciudad o regional
			$data[$indexIngCiu]["actual".$i] = $this->analisis->obtenerValorActualEst($tableIng1, $tableIng2, $campoIng, $ano_periodo, $mes_periodo, $departamentos, $municipios, '');
			$data[$indexIngCiu]["anterior".$i] = $this->analisis->obtenerValorAnteriorEst($tableIng1, $tableIng2, $campoIng, $ano_periodo, $mes_periodo, $departamentos, $municipios, '');
			$data[$indexIngCiu]["anual".$i] = $this->analisis->obtenerValorAnualEst($tableIng1, $tableIng2, $campoIng, $ano_periodo, $mes_periodo, $departamentos, $municipios, '');
			
			//variación ingresos por establecimiento
			$data[$indexIng]["varmensual".$i] = $this->analisis->calcularVariacionMensual($data["ingresos"]["actual0"], $data["ingresos"]["anterior0"]);
			$data[$indexIng]["varanual".$i] = $this->analisis->calcularVariacionAnual($data["ingresos"]["actual0"], $data["ingresos"]["anual0"]);
			
			//Obtener personal total ocupado del establecimiento
			$data[$indexPer]["actual".$i] = $this->analisis->obtenerValorActualEst($tablaPer1, $tablaPer2, $campoPer, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexPer]["anterior".$i] = $this->analisis->obtenerValorAnteriorEst($tablaPer1, $tablaPer2, $campoPer, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexPer]["anual".$i] = $this->analisis->obtenerValorAnualEst($tablaPer1, $tablaPer2, $campoPer, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			
			//Obtener personal total ocupado de la ciudad o regional
			$data[$indexPerCiu]["actual".$i] = $this->analisis->obtenerValorActualEst($tablaPerCiu1, $tablaPerCiu2, $campoPer, $ano_periodo, $mes_periodo, $departamentos, $municipios, '');
			$data[$indexPerCiu]["anterior".$i] = $this->analisis->obtenerValorAnteriorEst($tablaPerCiu1, $tablaPerCiu2, $campoPerCiu, $ano_periodo, $mes_periodo, $departamentos, $municipios, '');
			$data[$indexPerCiu]["anual".$i] = $this->analisis->obtenerValorAnualEst($tablaPerCiu1, $tablaPerCiu2, $campoPerCiu, $ano_periodo, $mes_periodo, $departamentos, $municipios, '');
			
			//Obtener ingresos por alojamiento establicimiento
			$data[$indexInalo]["actual".$i] = $this->analisis->obtenerValorActualEst($tableInalo1, $tableInalo2, $campoInalo, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexInalo]["anterior".$i] = $this->analisis->obtenerValorAnteriorEst($tableInalo1, $tableInalo2, $campoInalo, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexInalo]["anual".$i] = $this->analisis->obtenerValorAnualEst($tableInalo1, $tableInalo2, $campoInalo, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			
			//Obtener ingresos por alojamiento ciudad o regional
			$data[$indexInaloCiu]["actual".$i] = $this->analisis->obtenerValorActualEst($tableInalo1, $tableInalo2, $campoInalo, $ano_periodo, $mes_periodo, $departamentos, $municipios, '');
			$data[$indexInaloCiu]["anterior".$i] = $this->analisis->obtenerValorAnteriorEst($tableInalo1, $tableInalo2, $campoInalo, $ano_periodo, $mes_periodo, $departamentos, $municipios, '');
			$data[$indexInaloCiu]["anual".$i] = $this->analisis->obtenerValorAnualEst($tableInalo1, $tableInalo2, $campoInalo, $ano_periodo, $mes_periodo, $departamentos, $municipios, '');
			
			//Obtener huespedes residentes y no residentes por establecimiento
			$data[$indexHuetot]["actual".$i] = $this->analisis->obtenerValorActualEst($tableHuetot1, $tableHuetot2, $campoHuetot, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexHuetot]["anterior".$i] = $this->analisis->obtenerValorAnteriorEst($tableHuetot1, $tableHuetot2, $campoHuetot, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexHuetot]["anual".$i] = $this->analisis->obtenerValorAnualEst($tableHuetot1, $tableHuetot2, $campoHuetot, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			
			//Obtener huespedes residentes y no residentes por ciudad o regional
			$data[$indexHuetotCiu]["actual".$i] = $this->analisis->obtenerValorActualEst($tableHuetot1, $tableHuetot2, $campoHuetot, $ano_periodo, $mes_periodo, $departamentos, $municipios, '');
			$data[$indexHuetotCiu]["anterior".$i] = $this->analisis->obtenerValorAnteriorEst($tableHuetot1, $tableHuetot2, $campoHuetot, $ano_periodo, $mes_periodo, $departamentos, $municipios, '');
			$data[$indexHuetotCiu]["anual".$i] = $this->analisis->obtenerValorAnualEst($tableHuetot1, $tableHuetot2, $campoHuetot, $ano_periodo, $mes_periodo, $departamentos, $municipios, '');

			//Obtener habitaciones vendidas por establecimiento
			$data[$indexIhoa]["actual".$i] = $this->analisis->obtenerValorActualEst($tableIhoa1, $tableIhoa2, $campoIhoa, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexIhoa]["anterior".$i] = $this->analisis->obtenerValorAnteriorEst($tableIhoa1, $tableIhoa2, $campoIhoa, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexIhoa]["anual".$i] = $this->analisis->obtenerValorAnualEst($tableIhoa1, $tableIhoa2, $campoIhoa, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			
			//Obtener habitaciones vendidas por ciudad o regional
			$data[$indexIhoaCiu]["actual".$i] = $this->analisis->obtenerValorActualEst($tableIhoa1, $tableIhoa2, $campoIhoa, $ano_periodo, $mes_periodo, $departamentos, $municipios, '');
			$data[$indexIhoaCiu]["anterior".$i] = $this->analisis->obtenerValorAnteriorEst($tableIhoa1, $tableIhoa2, $campoIhoa, $ano_periodo, $mes_periodo, $departamentos, $municipios, '');
			$data[$indexIhoaCiu]["anual".$i] = $this->analisis->obtenerValorAnualEst($tableIhoa1, $tableIhoa2, $campoIhoa, $ano_periodo, $mes_periodo, $departamentos, $municipios, '');
			
			//Obtener camas vendidas por establecimiento
			$data[$indexIcva]["actual".$i] = $this->analisis->obtenerValorActualEst($tableIcva1, $tableIcva2, $campoIcva, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexIcva]["anterior".$i] = $this->analisis->obtenerValorAnteriorEst($tableIcva1, $tableIcva2, $campoIcva, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexIcva]["anual".$i] = $this->analisis->obtenerValorAnualEst($tableIcva1, $tableIcva2, $campoIcva, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			
			//Obtener camas vendidas por ciudad o regional
			$data[$indexIcvaCiu]["actual".$i] = $this->analisis->obtenerValorActualEst($tableIcva1, $tableIcva2, $campoIcva, $ano_periodo, $mes_periodo, $departamentos, $municipios, '');
			$data[$indexIcvaCiu]["anterior".$i] = $this->analisis->obtenerValorAnteriorEst($tableIcva1, $tableIcva2, $campoIcva, $ano_periodo, $mes_periodo, $departamentos, $municipios, '');
			$data[$indexIcvaCiu]["anual".$i] = $this->analisis->obtenerValorAnualEst($tableIcva1, $tableIcva2, $campoIcva, $ano_periodo, $mes_periodo, $departamentos, $municipios, '');
			
			//Obtener tarifa promedio habitación sencilla
			$data[$indexThusen]["actual".$i] = $this->analisis->obtenerValorActualEst($tableIcva1, $tableThusen2, $campoThusen, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexThusen]["anterior".$i] = $this->analisis->obtenerValorAnteriorEst($tableIcva1, $tableThusen2, $campoThusen, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexThusen]["anual".$i] = $this->analisis->obtenerValorAnualEst($tableIcva1, $tableThusen2, $campoThusen, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			
			//Obtener tarifa promedio habitación doble
			$data[$indexThudob]["actual".$i] = $this->analisis->obtenerValorActualEst($tableThudob1, $tableThudob2, $campoThudob, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexThudob]["anterior".$i] = $this->analisis->obtenerValorAnteriorEst($tableThudob1, $tableThudob2, $campoThudob, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexThudob]["anual".$i] = $this->analisis->obtenerValorAnualEst($tableThudob1, $tableThudob2, $campoThudob, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);

			//Obtener tarifa promedio habitación suite
			$data[$indexThusui]["actual".$i] = $this->analisis->obtenerValorActualEst($tableThusui1, $tableThusui2, $campoThusui, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexThusui]["anterior".$i] = $this->analisis->obtenerValorAnteriorEst($tableThusui1, $tableThusui2, $campoThusui, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexThusui]["anual".$i] = $this->analisis->obtenerValorAnualEst($tableThusui1, $tableThusui2, $campoThusui, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			
			//Obtener tarifa promedio habitación múltiple
			$data[$indexThumult]["actual".$i] = $this->analisis->obtenerValorActualEst($tableThumult1, $tableThumult2, $campoThumult, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexThumult]["anterior".$i] = $this->analisis->obtenerValorAnteriorEst($tableThumult1, $tableThumult2, $campoThumult, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexThumult]["anual".$i] = $this->analisis->obtenerValorAnualEst($tableThumult1, $tableThumult2, $campoThumult, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);

			//Tarifa promedio otro tipo de habitación
			$data[$indexThuotr]["actual".$i] = $this->analisis->obtenerValorActualEst($tableThuotr1, $tableThuotr2, $campoThuotr, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexThuotr]["anterior".$i] = $this->analisis->obtenerValorAnteriorEst($tableThuotr1, $tableThuotr2, $campoThuotr, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexThuotr]["anual".$i] = $this->analisis->obtenerValorAnualEst($tableThuotr1, $tableThuotr2, $campoThuotr, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			
			$data[$indexCamas]["actual".$i] = $this->analisis->obtenerValorActualEst($tablaCamas1, $tablaCamas2, $campoCamas, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexCamas]["anterior".$i] = $this->analisis->obtenerValorAnteriorEst($tablaCamas1, $tablaCamas2, $campoCamas, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexCamas]["anual".$i] = $this->analisis->obtenerValorAnualEst($tablaCamas1, $tablaCamas2, $campoCamas, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexHabit]["actual".$i] = $this->analisis->obtenerValorActualEst($tablaHabit1, $tablaHabit2, $campoHabit, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexHabit]["anterior".$i] = $this->analisis->obtenerValorAnteriorEst($tablaHabit1, $tablaHabit2, $campoHabit, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexHabit]["anual".$i] = $this->analisis->obtenerValorAnualEst($tablaHabit1, $tablaHabit2, $campoHabit, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			
			$data[$indexEstancia]["actual".$i] = $this->analisis->obtenerValorActualEst($tableEstancia1, $tableEstancia2, $campoEstancia, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexEstancia]["anterior".$i] = $this->analisis->obtenerValorAnteriorEst($tableEstancia1, $tableEstancia2, $campoEstancia, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexEstancia]["anual".$i] = $this->analisis->obtenerValorAnualEst($tableEstancia1, $tableEstancia2, $campoEstancia, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexOcupacion]["actual".$i] = $this->analisis->obtenerValorActualEst($tableOcupacion1, $tableOcupacion2, $campoOcupacion, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexOcupacion]["anterior".$i] = $this->analisis->obtenerValorAnteriorEst($tableOcupacion1, $tableOcupacion2, $campoOcupacion, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			$data[$indexOcupacion]["anual".$i] = $this->analisis->obtenerValorAnualEst($tableOcupacion1, $tableOcupacion2, $campoOcupacion, $ano_periodo, $mes_periodo, $depto, $mpio, $idEstablec);
			//Variaciones
			$data["varMensualEst"][$i] = $this->analisis->calcularVariacionMensual($data[$index]["actual".$i], $data[$index]["anterior".$i]);
			$data["varAnualEst"][$i] = $this->analisis->calcularVariacionAnual($data[$index]["actual".$i], $data[$index]["anual".$i]);
			$data["varMensualIng"][$i] = $this->analisis->calcularVariacionMensual($data[$indexIng]["actual".$i], $data[$indexIng]["anterior".$i]);
			$data["varAnualIng"][$i] = $this->analisis->calcularVariacionAnual($data[$indexIng]["actual".$i], $data[$indexIng]["anual".$i]);
			$data["varMensualPer"][$i] = $this->analisis->calcularVariacionMensual($data[$indexPer]["actual".$i], $data[$indexPer]["anterior".$i]);
			$data["varAnualPer"][$i] = $this->analisis->calcularVariacionAnual($data[$indexPer]["actual".$i], $data[$indexPer]["anual".$i]);
			$data["varMensualCam"][$i] = $this->analisis->calcularVariacionMensual($data[$indexCamas]["actual".$i], $data[$indexCamas]["anterior".$i]);
			$data["varAnualCam"][$i] = $this->analisis->calcularVariacionAnual($data[$indexCamas]["actual".$i], $data[$indexCamas]["anual".$i]);
			$data["varMensualHab"][$i] = $this->analisis->calcularVariacionMensual($data[$indexHabit]["actual".$i], $data[$indexHabit]["anterior".$i]);
			$data["varAnualHab"][$i] = $this->analisis->calcularVariacionAnual($data[$indexHabit]["actual".$i], $data[$indexHabit]["anual".$i]);
			$data["varMensualInalo"][$i] = $this->analisis->calcularVariacionMensual($data[$indexInalo]["actual".$i], $data[$indexInalo]["anterior".$i]);
			$data["varAnualInalo"][$i] = $this->analisis->calcularVariacionAnual($data[$indexInalo]["actual".$i], $data[$indexInalo]["anual".$i]);
			$data["varMensualHuetot"][$i] = $this->analisis->calcularVariacionMensual($data[$indexHuetot]["actual".$i], $data[$indexHuetot]["anterior".$i]);
			$data["varAnualHuetot"][$i] = $this->analisis->calcularVariacionAnual($data[$indexHuetot]["actual".$i], $data[$indexHuetot]["anual".$i]);
			$data["varMensualIcva"][$i] = $this->analisis->calcularVariacionMensual($data[$indexIcva]["actual".$i], $data[$indexIcva]["anterior".$i]);
			$data["varAnualIcva"][$i] = $this->analisis->calcularVariacionAnual($data[$indexIcva]["actual".$i], $data[$indexIcva]["anual".$i]);
			$data["varMensualIhoa"][$i] = $this->analisis->calcularVariacionMensual($data[$indexIhoa]["actual".$i], $data[$indexIhoa]["anterior".$i]);
			$data["varAnualIhoa"][$i] = $this->analisis->calcularVariacionAnual($data[$indexIhoa]["actual".$i], $data[$indexIhoa]["anual".$i]);
			$data["varMensualThusen"][$i] = $this->analisis->calcularVariacionMensual($data[$indexThusen]["actual".$i], $data[$indexThusen]["anterior".$i]);
			$data["varAnualThusen"][$i] = $this->analisis->calcularVariacionAnual($data[$indexThusen]["actual".$i], $data[$indexThusen]["anual".$i]);
			$data["varMensualThudob"][$i] = $this->analisis->calcularVariacionMensual($data[$indexThudob]["actual".$i], $data[$indexThudob]["anterior".$i]);
			$data["varAnualThudob"][$i] = $this->analisis->calcularVariacionAnual($data[$indexThudob]["actual".$i], $data[$indexThudob]["anual".$i]);
			$data["varMensualThusui"][$i] = $this->analisis->calcularVariacionMensual($data[$indexThusui]["actual".$i], $data[$indexThusui]["anterior".$i]);
			$data["varAnualThusui"][$i] = $this->analisis->calcularVariacionAnual($data[$indexThusui]["actual".$i], $data[$indexThusui]["anual".$i]);
			$data["varMensualThumult"][$i] = $this->analisis->calcularVariacionMensual($data[$indexThumult]["actual".$i], $data[$indexThumult]["anterior".$i]);
			$data["varAnualThumult"][$i] = $this->analisis->calcularVariacionAnual($data[$indexThumult]["actual".$i], $data[$indexThumult]["anual".$i]);
			$data["varMensualThuotr"][$i] = $this->analisis->calcularVariacionMensual($data[$indexThuotr]["actual".$i], $data[$indexThuotr]["anterior".$i]);
			$data["varAnualThuotr"][$i] = $this->analisis->calcularVariacionAnual($data[$indexThuotr]["actual".$i], $data[$indexThuotr]["anual".$i]);
			
		}
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		if(isset($_REQUEST["datos_a_enviar"])){
			//redireccionamos la salida al navegador del cliente (Excel2007)
			header('Content-type: application/vnd.ms-excel; charset=UTF-8');
			header("Content-Disposition: attachment; filename=reporte.xls");
			$this->load->view("gnrlsRegion",$data);
		}else{
			$this->load->view("layout",$data);
		}
	}
	
}//EOC
	
	
?>