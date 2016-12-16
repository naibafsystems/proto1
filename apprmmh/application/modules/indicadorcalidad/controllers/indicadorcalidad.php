<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Indicadorcalidad extends MX_Controller {
	/**
	 * Controlador para el indicador de calidad
	 * @author Jesús Neira Guio - SJNEIRAG
	 * @since Septiembre 2015
	 */
	public function __construct(){
        parent::__construct();
		$this->load->helper("url");
		$this->load->library("session");		
		$this->load->library("validarsesion");
		$this->load->library("pagination");
		$this->load->library("general");
	}
	
	public function index(){
		$this->load->model("periodo");
		$this->load->model("indicador");
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==3){
			$data['tipo_usuario']="ASISTENTE T&Eacute;CNICO";
			$data["menu"] = ("asistente/asismenu");
		}
		if($tipo_usuario==4){
			$data['tipo_usuario']="ADMINISTRADOR";
			$data["menu"] =  ("administrador/adminmenu");
		}
		$data["nom_usuario"] = $nom_usuario;
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$usuario = $this->session->userdata("id");
		$data["ano_periodo"]=$ano_periodo;
		$data["mes_periodo"]=$mes_periodo;
		$data["view"] = "indicadorcalidad";
		$data["controller"] = "indicadorcalidad";
		$data["estado_indicador"]=$this->indicador->obtenerEstado($ano_periodo, $mes_periodo);
		$data["sede"] = $this->indicador->obtenerSede($usuario);
		$sede=$data["sede"]["fk_sede"];
		if(!isset($subsedeId)){
			$subsede=$data["sede"]["fk_subsede"];
			$data["nomSubsede"]=$data["sede"]["nom_subsede"];
		}else{
			$subsede=$subsedeId;
			$data["subsede"] = $this->indicador->obtenerNombreSubsede($subsedeId);
			$data["nomSubsede"]=$data["subsede"]["nom_subsede"];
		}
		$data["obtener_fuentes"]=$this->indicador->obtenerFuentes($ano_periodo, $mes_periodo, $subsede);
		$data["fuentes_indicador"] = $this->indicador->buscarFuentesIndicador($ano_periodo, $mes_periodo, $subsede);
		$data["criticos_calificar"]=$this->indicador->obtenerCriticosCalificar($ano_periodo, $mes_periodo,$subsede);
		$variable=0;
		$promedio=0;
		
		for($i=0; $i<=count($data["criticos_calificar"])-1; $i++){
			$idcritico=$data["criticos_calificar"][$i]["criticos"];
			$data["fuentes_calificadas".$i]=$this->indicador->obtenerFuentesCalificadas($ano_periodo, $mes_periodo, $idcritico,0);
			$variable=$variable.','.$data["fuentes_calificadas".$i]["calificadas"];
			$data["promedio_fuentes".$i]=$this->indicador->obtenerPromedioFuentes($ano_periodo, $mes_periodo, $idcritico);
			$promedio=$promedio.','.$data["promedio_fuentes".$i]["promedio"];
		}
		$data["calificadas"]=$variable;
		$data["promediofuentes"]=$promedio;
		$data["registrosCierre"]=$this->indicador->obtenerRegistrosCierre($ano_periodo, $mes_periodo, $subsede);
		$data["promedio_subsede"]=$this->indicador->obtenerPromedioSubsede($ano_periodo, $mes_periodo,$subsede);
		$data["fuentes_calificar"]=$this->indicador->obtenerFuentesCalificar($ano_periodo, $mes_periodo, $subsede);
		if(count($data["fuentes_calificar"])>0){
			$data["promedioCalSede"]= $data["promedio_subsede"]["promedio"]/count($data["fuentes_calificar"]);
			$data["calcula_nivelCalidad"]=$this->indicador->calcularNivelCalidad($data["promedioCalSede"]);
			$data["nivel"]=$data["calcula_nivelCalidad"];
			$data["fuentesCalificadasSubsedes"]=$this->indicador->obtenerFuentesCalificadas($ano_periodo, $mes_periodo, 0, $subsede);
		}
		
		//Promedio y nivel de calificación de los 4 meses anteriores
		$fecha = $ano_periodo."-".$mes_periodo;
		$mes1 = strtotime ( '-1 month' , strtotime ( $fecha ) ) ;
		$data["mes1"] = date ( 'Y-m' , $mes1 );
		$mes_periodo1=date ('m' , $mes1);
		$data["promedioMes1"]=$this->indicador->obtenerPromedioSubsede($ano_periodo, $mes_periodo1, $subsede);
		$data["fuentesCalMes1"]=$this->indicador->obtenerFuentesCalificar($ano_periodo, $mes_periodo1, $subsede);
		if(count($data["fuentesCalMes1"])>0){
			$data["promedioCalSedeM1"]= $data["promedioMes1"]["promedio"]/count($data["fuentesCalMes1"]);
			$data["calcula_nivelCalidad1"]=$this->indicador->calcularNivelCalidad($data["promedioCalSedeM1"]);
			$data["nivelmes1"]=$data["calcula_nivelCalidad1"];
		}else{
			$data["promedioCalSedeM1"]=0;
			$data["nivelmes1"]="-";
		}
		$mes2 = strtotime ( '-2 month' , strtotime ( $fecha ) ) ;
		$data["mes2"] = date ( 'Y-m' , $mes2 );
		$mes_periodo2=date ('m' , $mes2);
		$data["promedioMes2"]=$this->indicador->obtenerPromedioSubsede($ano_periodo, $mes_periodo2, $subsede);
		$data["fuentesCalMes2"]=$this->indicador->obtenerFuentesCalificar($ano_periodo, $mes_periodo2, $subsede);
		if(count($data["fuentesCalMes2"])>0){
			$data["promedioCalSedeM2"]= $data["promedioMes2"]["promedio"]/count($data["fuentesCalMes2"]);
			$data["calcula_nivelCalidad2"]=$this->indicador->calcularNivelCalidad($data["promedioCalSedeM2"]);
			$data["nivelmes2"]=$data["calcula_nivelCalidad2"];
		}else{
			$data["promedioCalSedeM2"]=0;
			$data["nivelmes2"]="-";
		}
		$mes3 = strtotime ( '-3 month' , strtotime ( $fecha ) ) ;
		$data["mes3"] = date ( 'Y-m' , $mes3 );
		$mes_periodo3=date ('m' , $mes3);
		$data["promedioMes3"]=$this->indicador->obtenerPromedioSubsede($ano_periodo, $mes_periodo3, $subsede);
		$data["fuentesCalMes3"]=$this->indicador->obtenerFuentesCalificar($ano_periodo, $mes_periodo3, $subsede);
		if(count($data["fuentesCalMes3"])>0){
			$data["promedioCalSedeM3"]= $data["promedioMes3"]["promedio"]/count($data["fuentesCalMes3"]);
			$data["calcula_nivelCalidad3"]=$this->indicador->calcularNivelCalidad($data["promedioCalSedeM3"]);
			$data["nivelmes3"]=$data["calcula_nivelCalidad3"];
		}else{
			$data["promedioCalSedeM3"]=0;
			$data["nivelmes3"]="-";
		}
		$mes4 = strtotime ( '-4 month' , strtotime ( $fecha ) ) ;
		$data["mes4"] = date ( 'Y-m' , $mes4 );
		$mes_periodo4=date ('m' , $mes4);
		$data["promedioMes4"]=$this->indicador->obtenerPromedioSubsede($ano_periodo, $mes_periodo4, $subsede);
		$data["fuentesCalMes4"]=$this->indicador->obtenerFuentesCalificar($ano_periodo, $mes_periodo4, $subsede);
		if(count($data["fuentesCalMes4"])>0){
			$data["promedioCalSedeM4"]= $data["promedioMes4"]["promedio"]/count($data["fuentesCalMes4"]);
			$data["calcula_nivelCalidad4"]=$this->indicador->calcularNivelCalidad($data["promedioCalSedeM4"]);
			$data["nivelmes4"]=$data["calcula_nivelCalidad4"];
		}else{
			$data["promedioCalSedeM4"]=0;
			$data["nivelmes4"]="-";
		}
		$data["accionesCorrectivas"]=$this->indicador->obtenerAccionesCorrectivas($ano_periodo, $mes_periodo, $subsede);
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$this->load->view("layout",$data);
	}

	public function indicadorSubsede($subsedeId){
		$this->load->model("periodo");
		$this->load->model("indicador");
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==3){
			$data['tipo_usuario']="ASISTENTE T&Eacute;CNICO";
			$data["menu"] = ("asistente/asismenu");
		}
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
		$data["view"] = "indicadorcalidad";
		$data["controller"] = "indicadorcalidad";
		$data["estado_indicador"]=$this->indicador->obtenerEstado($ano_periodo, $mes_periodo);
		$data["sede"] = $this->indicador->obtenerSede($usuario);
		$sede=$data["sede"]["fk_sede"];
		if(!isset($subsedeId)){
			$subsede=$data["sede"]["fk_subsede"];
			$data["nomSubsede"]=$data["sede"]["nom_subsede"];
		}else{
			$subsede=$subsedeId;
			$data["subsede"] = $this->indicador->obtenerNombreSubsede($subsedeId);
			$data["nomSubsede"]=$data["subsede"]["nom_subsede"];
		}
		$data["obtener_fuentes"]=$this->indicador->obtenerFuentes($ano_periodo, $mes_periodo, $subsede);
		$data["fuentes_indicador"] = $this->indicador->buscarFuentesIndicador($ano_periodo, $mes_periodo, $subsede);
		$data["criticos_calificar"]=$this->indicador->obtenerCriticosCalificar($ano_periodo, $mes_periodo,$subsede);
		$variable=0;
		$promedio=0;
	
		for($i=0; $i<=count($data["criticos_calificar"])-1; $i++){
			$idcritico=$data["criticos_calificar"][$i]["criticos"];
			$data["fuentes_calificadas".$i]=$this->indicador->obtenerFuentesCalificadas($ano_periodo, $mes_periodo, $idcritico,0);
			$variable=$variable.','.$data["fuentes_calificadas".$i]["calificadas"];
			$data["promedio_fuentes".$i]=$this->indicador->obtenerPromedioFuentes($ano_periodo, $mes_periodo, $idcritico);
			$promedio=$promedio.','.$data["promedio_fuentes".$i]["promedio"];
		}
		$data["calificadas"]=$variable;
		$data["promediofuentes"]=$promedio;
		$data["registrosCierre"]=$this->indicador->obtenerRegistrosCierre($ano_periodo, $mes_periodo, $subsede);
		$data["promedio_subsede"]=$this->indicador->obtenerPromedioSubsede($ano_periodo, $mes_periodo,$subsede);
		$data["fuentes_calificar"]=$this->indicador->obtenerFuentesCalificar($ano_periodo, $mes_periodo, $subsede);
		if(count($data["fuentes_calificar"])>0){
			$data["promedioCalSede"]= $data["promedio_subsede"]["promedio"]/count($data["fuentes_calificar"]);
			$data["calcula_nivelCalidad"]=$this->indicador->calcularNivelCalidad($data["promedioCalSede"]);
			$data["nivel"]=$data["calcula_nivelCalidad"];
			$data["fuentesCalificadasSubsedes"]=$this->indicador->obtenerFuentesCalificadas($ano_periodo, $mes_periodo, 0, $subsede);
		}
		//Promedio y nivel de calificación de los 4 meses anteriores
		$fecha = $ano_periodo."-".$mes_periodo;
		$mes1 = strtotime ( '-1 month' , strtotime ( $fecha ) ) ;
		$data["mes1"] = date ( 'Y-m' , $mes1 );
		$mes_periodo1=date ('m' , $mes1);
		$data["promedioMes1"]=$this->indicador->obtenerPromedioSubsede($ano_periodo, $mes_periodo1, $subsede);
		$data["fuentesCalMes1"]=$this->indicador->obtenerFuentesCalificar($ano_periodo, $mes_periodo1, $subsede);
		if(count($data["fuentesCalMes1"])>0){
			$data["promedioCalSedeM1"]= $data["promedioMes1"]["promedio"]/count($data["fuentesCalMes1"]);
			$data["calcula_nivelCalidad1"]=$this->indicador->calcularNivelCalidad($data["promedioCalSedeM1"]);
			$data["nivelmes1"]=$data["calcula_nivelCalidad1"];
		}else{
			$data["promedioCalSedeM1"]=0;
			$data["nivelmes1"]="-";
		}
		$mes2 = strtotime ( '-2 month' , strtotime ( $fecha ) ) ;
		$data["mes2"] = date ( 'Y-m' , $mes2 );
		$mes_periodo2=date ('m' , $mes2);
		$data["promedioMes2"]=$this->indicador->obtenerPromedioSubsede($ano_periodo, $mes_periodo2, $subsede);
		$data["fuentesCalMes2"]=$this->indicador->obtenerFuentesCalificar($ano_periodo, $mes_periodo2, $subsede);
		if(count($data["fuentesCalMes2"])>0){
			$data["promedioCalSedeM2"]= $data["promedioMes2"]["promedio"]/count($data["fuentesCalMes2"]);
			$data["calcula_nivelCalidad2"]=$this->indicador->calcularNivelCalidad($data["promedioCalSedeM2"]);
			$data["nivelmes2"]=$data["calcula_nivelCalidad2"];
		}else{
			$data["promedioCalSedeM2"]=0;
			$data["nivelmes2"]="-";
		}
		$mes3 = strtotime ( '-3 month' , strtotime ( $fecha ) ) ;
		$data["mes3"] = date ( 'Y-m' , $mes3 );
		$mes_periodo3=date ('m' , $mes3);
		$data["promedioMes3"]=$this->indicador->obtenerPromedioSubsede($ano_periodo, $mes_periodo3, $subsede);
		$data["fuentesCalMes3"]=$this->indicador->obtenerFuentesCalificar($ano_periodo, $mes_periodo3, $subsede);
		if(count($data["fuentesCalMes3"])>0){
			$data["promedioCalSedeM3"]= $data["promedioMes3"]["promedio"]/count($data["fuentesCalMes3"]);
			$data["calcula_nivelCalidad3"]=$this->indicador->calcularNivelCalidad($data["promedioCalSedeM3"]);
			$data["nivelmes3"]=$data["calcula_nivelCalidad3"];
		}else{
			$data["promedioCalSedeM3"]=0;
			$data["nivelmes3"]="-";
		}
		$mes4 = strtotime ( '-4 month' , strtotime ( $fecha ) ) ;
		$data["mes4"] = date ( 'Y-m' , $mes4 );
		$mes_periodo4=date ('m' , $mes4);
		$data["promedioMes4"]=$this->indicador->obtenerPromedioSubsede($ano_periodo, $mes_periodo4, $subsede);
		$data["fuentesCalMes4"]=$this->indicador->obtenerFuentesCalificar($ano_periodo, $mes_periodo4, $subsede);
		if(count($data["fuentesCalMes4"])>0){
			$data["promedioCalSedeM4"]= $data["promedioMes4"]["promedio"]/count($data["fuentesCalMes4"]);
			$data["calcula_nivelCalidad4"]=$this->indicador->calcularNivelCalidad($data["promedioCalSedeM4"]);
			$data["nivelmes4"]=$data["calcula_nivelCalidad4"];
		}else{
			$data["promedioCalSedeM4"]=0;
			$data["nivelmes4"]="-";
		}
		$data["accionesCorrectivas"]=$this->indicador->obtenerAccionesCorrectivas($ano_periodo, $mes_periodo, $subsede);
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
		redirect('/asistente', 'location', 301);
	}
	
	/**
	 * Función para generar el inidcardor de calidad
	 * @author Jesús Neira Guio - SJNEIRAG
	 * @since Septiembre 2015
	 */
	public function generaIndicador(){
		$this->load->model("periodo");
		$this->load->model("indicador");
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==3){
			$data['tipo_usuario']="ASISTENTE T&Eacute;CNICO";
			$data["menu"] = ("asistente/asismenu");
		}
		if($tipo_usuario==4){
			$data['tipo_usuario']="ADMINISTRADOR";
			$data["menu"] =  ("administrador/adminmenu");
		}
		$data["nom_usuario"] = $nom_usuario;
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$data["ano_periodo"]=$ano_periodo;
		$data["mes_periodo"]=$mes_periodo;
		$data["view"] = "indicadorcalidad";
		$data["controller"] = "indicadorcalidad";
		$subsede=$_REQUEST['subsede'];
		$data["fuentes_indicador"] = $this->indicador->buscarFuentesIndicador($ano_periodo, $mes_periodo, $subsede);
		//Verifica que no existan rfegistros de fuentes para calificar
		if(count($data["fuentes_indicador"])==0)
		{	
			$data["obtener_fuentes"]=$this->indicador->obtenerFuentes($ano_periodo, $mes_periodo, $subsede);
			$numero_fuentes=$data["obtener_fuentes"]["numero_fuentes"];
			$porcentaje=round($numero_fuentes*0.10);
			//Si porcentaje menor a uno, le asigna 1 a limit, si no le asigna e 10% del total de fuentes aceptadas.
			if($porcentaje<1){
				$limit=1;
			}else{
				$limit=$porcentaje;
			}
			$data["fuentes_calificar"]=$this->indicador->fuentesCalificar($ano_periodo, $mes_periodo, $subsede, $limit);
			for($i=0; $i<=count($data["fuentes_calificar"])-1; $i++){
				$nro_establecimiento=$data["fuentes_calificar"][$i]["nro_establecimiento"];
				$nro_orden=$data["fuentes_calificar"][$i]["nro_orden"];
				$subsede=$data["fuentes_calificar"][$i]["subsede"]; 
				$ano_periodo=$data["fuentes_calificar"][$i]["ano_periodo"];
				$mes_periodo=$data["fuentes_calificar"][$i]["mes_periodo"];
				$usuariocritico=$data["fuentes_calificar"][$i]["usuariocritica"];
				$usuariologistica=$data["fuentes_calificar"][$i]["usuariologistica"];
				$estado=$data["fuentes_calificar"][$i]["estado"];
				$inclusion=$data["fuentes_calificar"][$i]["inclusion"];
				$id_usuario=$data["fuentes_calificar"][$i]["id_usuario"];
				$nom_usuario=$data["fuentes_calificar"][$i]["nom_usuario"];
				$nom_estado=$data["fuentes_calificar"][$i]["nom_estado"];
				$estado=1;
				$usuario = $this->session->userdata("id");
				$this->indicador->insertarFuentesCalificar($ano_periodo, $mes_periodo, $nro_orden, $nro_establecimiento, $subsede, $inclusion, $usuariocritico, $usuario, $estado);
				$this->load->helper('url');
			} 
		}else{
			echo "Existen ".count($data["fuentes_indicador"])." fuentes registradas para inidicador de calidad.";
		}
		
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		//$this->load->view("indicadorcalildad",$data);
	}
	
	/**
	 * Función para mostrar las fuentes a calificar para el inidcardor de calidad
	 * @author Jesús Neira Guio - SJNEIRAG
	 * @since Septiembre 2015
	 */
	public function fuentesxCritico($idcritico, $nomcritico){
		$this->load->model("periodo");
		$this->load->model("indicador");
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		$data["idcritico"]=$idcritico;
		$data["nomcritico"]=$nomcritico;
		$idestablecimiento=0;
		if($tipo_usuario==3){
			$data['tipo_usuario']="ASISTENTE T&Eacute;CNICO";
			$data["menu"] = ("asistente/asismenu");
		}
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
		$data["ano_periodo"]=$ano_periodo;
		$data["mes_periodo"]=$mes_periodo;
		$usuario = $this->session->userdata("id");
		$data["estado_indicador"]=$this->indicador->obtenerEstado($ano_periodo, $mes_periodo);
		$data["view"] = "fuentescalificar";
		$data["controller"] = "indicadorcalidad";
		$data["fuentes_calificar"]=$this->indicador->obtenerFuentesxCritico($ano_periodo, $mes_periodo, $idcritico, $idestablecimiento);
		$variable=0;
		for ($i=0; $i<count($data["fuentes_calificar"]); $i++){
			$establecimiento=$data["fuentes_calificar"][$i]["nro_establecimiento"];
			$data["calificacion".$i]=$this->indicador->obtenerCalificacionFuente($ano_periodo, $mes_periodo, $idcritico, $establecimiento);
			$variable=$variable.','.$data["calificacion".$i]["calificacion"];
		}
		$data["calific"]=$variable;
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$this->load->view("layout",$data);
	}
	
	/**
	 * Función para el formulario del indicador de calidad
	 * @author Jesús Neira Guio - SJNEIRAG
	 * @since Septiembre 2015
	 */
	public function formularioIndicador($idestablecimiento){
		$this->load->model("periodo");
		$this->load->model("indicador");
		$this->load->model("fichanalisis/ficha");
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		$data["idestablecimiento"]=$idestablecimiento;
		$idcritico=0;
		if($tipo_usuario==3){
			$data['tipo_usuario']="ASISTENTE T&Eacute;CNICO";
			$data["menu"] = ("asistente/asismenu");
		}
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
		$data["ano_periodo"]=$ano_periodo;
		$data["mes_periodo"]=$mes_periodo;
		$usuario = $this->session->userdata("id");
		$data["estado_indicador"]=$this->indicador->obtenerEstado($ano_periodo, $mes_periodo);
		$data["view"] = "formularioindicador";
		$data["controller"] = "indicadorcalidad";
		$data["fuentes_calificar"]=$this->indicador->obtenerFuentesxCritico($ano_periodo, $mes_periodo, $idcritico, $idestablecimiento);
		$nro_orden=$data["fuentes_calificar"][0]["nro_orden"];
		$nro_establecimiento=$data["fuentes_calificar"][0]["nro_establecimiento"];
		$data["variables"]=$this->indicador->obtenerVariablesIndicador();
		$fuenteIndicador=$data["fuentes_calificar"][0]["idfuentes"];
		$data["fuente_calificada"] = $this->indicador->buscarFuentesCalificadas($fuenteIndicador);
		$subsede= $nro_orden=$data["fuentes_calificar"][0]["subsede"];
		//Verifica si el indicador está cerrado
		$data["registrosCierre"]=$this->indicador->obtenerRegistrosCierre($ano_periodo, $mes_periodo, $subsede);
		//Rango para la variación mensual para el indicador de calidad.
		$tabla = "rmmh_form_ingoperacionales";
		$campo = "intio";
		$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		
		if($data[$campo]["actual"]>0 && $data[$campo]["actual"]<=100000){
			$rango=-1;
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
		//Calculamos la magnitud del error para cada una de las variables.
		for($i=0; $i<=count($data["variables"]); $i++){
			switch($i){
			case 0: //INALO
				$tabla = "rmmh_form_ingoperacionales";
				$campo = "inalo";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$inalo=$data[$i]["magerror"];
				break;
			case 1: //INALI
				$tabla = "rmmh_form_ingoperacionales";
				$campo = "inali";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$inali=$data[$i]["magerror"];
				break;
			case 2: //INBA
				$tabla = "rmmh_form_ingoperacionales";
				$campo = "inba";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$inba=$data[$i]["magerror"];
				break;
			case 3: //INSR
				$tabla = "rmmh_form_ingoperacionales";
				$campo = "insr";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$insr=$data[$i]["magerror"];
				break;
			case 4: //INOE
				$tabla = "rmmh_form_ingoperacionales";
				$campo = "inoe";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$inoe=$data[$i]["magerror"];
				break;
			case 5: //INOIO
				$tabla = "rmmh_form_ingoperacionales";
				$campo = "inoio";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$inoio=$data[$i]["magerror"];
				break;
			case 6: //INTIO
				$tabla = "rmmh_form_ingoperacionales";
				$campo = "intio";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$intio=$data[$i]["magerror"];
				break;
			case 7: //POTPERM
				$tabla = "rmmh_form_persalarios";
				$campo = "potperm";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$potperm=$data[$i]["magerror"];
				break;
			case 8: //GPPER
				$tabla = "rmmh_form_persalarios";
				$campo = "gpper";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$gpper=$data[$i]["magerror"];
				break;
			case 9: //Percapita personal permanente
				$tabla = "rmmh_form_persalarios";
				$index = "salpper";
				$campo = "gpper / potperm";
				$data[$index]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$index]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$index]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$index]["actual"], $data[$index]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$index]["varmensual"]);
				$percapperm=$data[$i]["magerror"];
			case 10: // % salarios personal permanente/ ingresos 
				$tabla1 = "rmmh_form_ingoperacionales";
				$tabla2 = "rmmh_form_persalarios";
				$index = "porsaling";
				$campo = "(gpper/intio)*100";
				$data[$index]["actual"] = $this->ficha->obtenerValorActualMulti($tabla1, $tabla2, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$index]["anterior"] = $this->ficha->obtenerValorAnteriorMulti($tabla1, $tabla2, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$index]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$index]["actual"], $data[$index]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$index]["varmensual"]);
				$porsaling=$data[$i]["magerror"];
				break;
			case 11: // POTTCDE
				$tabla = "rmmh_form_persalarios";
				$campo = "pottcde";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$pottcde=$data[$i]["magerror"];
				break;
			case 12: // GPSSDE
				$tabla = "rmmh_form_persalarios";
				$campo = "gpssde";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$gpssde=$data[$i]["magerror"];
				break;
			case 13: //Percapita personal directo
				$tabla = "rmmh_form_persalarios";
				$index = "salperdir";
				$campo = "gpssde/pottcde";
				$data[$index]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$index]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$index]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$index]["actual"], $data[$index]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$index]["varmensual"]);
				$salperdir=$data[$i]["magerror"];
				break;
			case 14: // % salarios personal temporal directo/ ingresos.
				$tabla1 = "rmmh_form_ingoperacionales";
				$tabla2 = "rmmh_form_persalarios";
				$index = "porsalperdir";
				$campo = "(gpssde/intio)*100";
				$data[$index]["actual"] = $this->ficha->obtenerValorActualMulti($tabla1, $tabla2, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$index]["anterior"] = $this->ficha->obtenerValorAnteriorMulti($tabla1, $tabla2, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$index]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$index]["actual"], $data[$index]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$index]["varmensual"]);
				$porsalperdir=$data[$i]["magerror"];
				break;
			case 15: // POTTCAG
				$tabla = "rmmh_form_persalarios";
				$campo = "pottcag";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$pottcag=$data[$i]["magerror"];
				break;
			case 16: //GPPPTA
				$tabla = "rmmh_form_persalarios";
				$campo = "gpppta";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$gpppta=$data[$i]["magerror"];
				break;
			case 17: //Percápita temporal sumnistrado por otras empresas
				$tabla = "rmmh_form_persalarios";
				$index = "pertempoemp";
				$campo = "gpppta/pottcag";
				$data[$index]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$index]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$index]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$index]["actual"], $data[$index]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$index]["varmensual"]);
				$pertempoemp=$data[$i]["magerror"];
				break;
			case 18: // % salarios personal temporal directo/ ingresos.
				$tabla1 = "rmmh_form_ingoperacionales";
				$tabla2 = "rmmh_form_persalarios";
				$index = "porsaltemp";
				$campo = "(gpppta/intio)*100";
				$data[$index]["actual"] = $this->ficha->obtenerValorActualMulti($tabla1, $tabla2, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$index]["anterior"] = $this->ficha->obtenerValorAnteriorMulti($tabla1, $tabla2, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$index]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$index]["actual"], $data[$index]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$index]["varmensual"]);
				$porsaltemp=$data[$i]["magerror"];
				break;
			case 19: //POTPAU
				$tabla = "rmmh_form_persalarios";
				$campo = "potpau";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$potpau=$data[$i]["magerror"];
				break;
			case 20: //GPPGPA
				$tabla = "rmmh_form_persalarios";
				$campo = "gppgpa";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$gppgpa=$data[$i]["magerror"];
				break;
			case 21: //Percápita personal aprendiz.
				$tabla = "rmmh_form_persalarios";
				$index = "peraprndiz";
				$campo = "gppgpa/potpau";
				$data[$index]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$index]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$index]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$index]["actual"], $data[$index]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$index]["varmensual"]);
				$peraprndiz=$data[$i]["magerror"];
				break;
			case 22: //% salarios personal aprendiz/Ingresos.
				$tabla1 = "rmmh_form_ingoperacionales";
				$tabla2 = "rmmh_form_persalarios";
				$index = "porsalaprendiz";
				$campo = "(gppgpa/intio)*100";
				$data[$index]["actual"] = $this->ficha->obtenerValorActualMulti($tabla1, $tabla2, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$index]["anterior"] = $this->ficha->obtenerValorAnteriorMulti($tabla1, $tabla2, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$index]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$index]["actual"], $data[$index]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$index]["varmensual"]);
				$porsalaprendiz=$data[$i]["magerror"];
				break;
			case 23: //POTTOT
				$tabla = "rmmh_form_persalarios";
				$campo = "pottot";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$pottot=$data[$i]["magerror"];
				break;
			case 24: //GPSSPOT
				$tabla = "rmmh_form_persalarios";
				$campo = "gpsspot";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$gpsspot=$data[$i]["magerror"];
				break;
			case 25: //Ingresos percápita producidos (INTIO/POTTOT).
				$tabla1 = "rmmh_form_ingoperacionales";
				$tabla2 = "rmmh_form_persalarios";
				$index = "ingperpord";
				$campo = "(intio*1000)/pottot";
				$data[$index]["actual"] = $this->ficha->obtenerValorActualMulti($tabla1, $tabla2, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$index]["anterior"] = $this->ficha->obtenerValorAnteriorMulti($tabla1, $tabla2, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$index]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$index]["actual"], $data[$index]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$index]["varmensual"]);
				$ingperpord=$data[$i]["magerror"];
				break;
			case 26: //Habitaciones vendidas/disponibles (IHOA/IHDO).
				$tabla = "rmmh_form_caracthoteles";
				$index = "habvendis";
				$campo = "(ihoa/ihdo)*100";
				$data[$index]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$index]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$index]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$index]["actual"], $data[$index]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$index]["varmensual"]);
				$habvendis=$data[$i]["magerror"];
				break;
			case 27: //Camas vendidas/disponibles (ICVA/ICDA)
				$tabla = "rmmh_form_caracthoteles";
				$index = "camvenoc";
				$campo = "(icva/icda)*100";
				$data[$index]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$index]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$index]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$index]["actual"], $data[$index]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$index]["varmensual"]);
				$camvenoc=$data[$i]["magerror"];
				break;
			case 28: //Estancia media 
				$tabla = "rmmh_form_caracthoteles";
				$index = "estmedia";
				$campo = "icva/huetot";
				$data[$index]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$index]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$index]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$index]["actual"], $data[$index]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$index]["varmensual"]);
				$estmedia=$data[$i]["magerror"];
				break;
			case 29: //IHDO
				$tabla = "rmmh_form_caracthoteles";
				$campo = "ihdo";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$ihdo=$data[$i]["magerror"];
				break;
			case 30: //IHOA
				$tabla = "rmmh_form_caracthoteles";
				$campo = "ihoa";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$ihoa=$data[$i]["magerror"];
				break;
			case 31: //ICDA
				$tabla = "rmmh_form_caracthoteles";
				$campo = "icda";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$icda=$data[$i]["magerror"];
				break;
			case 32: //ICVA
				$tabla = "rmmh_form_caracthoteles";
				$campo = "icva";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$icva=$data[$i]["magerror"];
				break;
			case 33: //IHPN
				$tabla = "rmmh_form_caracthoteles";
				$campo = "ihpn";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$ihpn=$data[$i]["magerror"];
				break;
			case 34: //IHPNR
				$tabla = "rmmh_form_caracthoteles";
				$campo = "ihpnr";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$ihpnr=$data[$i]["magerror"];
				break;
			case 35: //HUETOT
				$tabla = "rmmh_form_caracthoteles";
				$campo = "huetot";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$huetot=$data[$i]["magerror"];
				break;
			case 36: //MVNR
				$tabla = "rmmh_form_caracthoteles";
				$campo = "mvnr";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$mvnr=$data[$i]["magerror"];
				break;
			case 37: //MVCR
				$tabla = "rmmh_form_caracthoteles";
				$campo = "mvcr";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$mvcr=$data[$i]["magerror"];
				break;
			case 38: //MVOR
				$tabla = "rmmh_form_caracthoteles";
				$campo = "mvor";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$mvor=$data[$i]["magerror"];
				break;
			case 39: //MVSR
				$tabla = "rmmh_form_caracthoteles";
				$campo = "mvsr";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$mvsr=$data[$i]["magerror"];
				break;
			case 40: //MVOTR
				$tabla = "rmmh_form_caracthoteles";
				$campo = "mvotr";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$mvotr=$data[$i]["magerror"];
				break;
			case 41: //MVNNR
				$tabla = "rmmh_form_caracthoteles";
				$campo = "mvnnr";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$mvnnr=$data[$i]["magerror"];
				break;
			case 42: //MVCNR
				$tabla = "rmmh_form_caracthoteles";
				$campo = "mvcnr";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$mvcnr=$data[$i]["magerror"];
				break;
			case 43: //MVONR
				$tabla = "rmmh_form_caracthoteles";
				$campo = "mvonr";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$mvonr=$data[$i]["magerror"];
				break;
			case 44: //MVSNR
				$tabla = "rmmh_form_caracthoteles";
				$campo = "mvsnr";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$mvsnr=$data[$i]["magerror"];
				break;
			case 45: //MVOTNR
				$tabla = "rmmh_form_caracthoteles";
				$campo = "mvotnr";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$mvotnr=$data[$i]["magerror"];
				break;
			case 46: //THSEN
				$tabla = "rmmh_form_caracthoteles";
				$campo = "thsen";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$thsen=$data[$i]["magerror"];
				break;
			case 47: //THUSEN
				$tabla = "rmmh_form_caracthoteles";
				$campo = "thusen";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$thusen=$data[$i]["magerror"];
				break;
			case 48: //THDOB
				$tabla = "rmmh_form_caracthoteles";
				$campo = "thdob";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$thdob=$data[$i]["magerror"];
				break;
			case 49: //THUDOB
				$tabla = "rmmh_form_caracthoteles";
				$campo = "thudob";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$thudob=$data[$i]["magerror"];
				break;
			case 50: //THSUI
				$tabla = "rmmh_form_caracthoteles";
				$campo = "thsui";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$thsui=$data[$i]["magerror"];
				break;
			case 51: //THUSUI
				$tabla = "rmmh_form_caracthoteles";
				$campo = "thusui";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$thusui=$data[$i]["magerror"];
				break;
			case 52: //THMULT
				$tabla = "rmmh_form_caracthoteles";
				$campo = "thmult";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$thmult=$data[$i]["magerror"];
				break;
			case 53: //THUMULT
				$tabla = "rmmh_form_caracthoteles";
				$campo = "thumult";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$thumult=$data[$i]["magerror"];
				break;
			case 54: //THOTR
				$tabla = "rmmh_form_caracthoteles";
				$campo = "thotr";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$thotr=$data[$i]["magerror"];
				break;
			case 55: //THUOTR
				$tabla = "rmmh_form_caracthoteles";
				$campo = "thuotr";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$thuotr=$data[$i]["magerror"];
				break;
			case 56: //THTOT
				$tabla = "rmmh_form_caracthoteles";
				$campo = "thtot";
				$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$campo]["varmensual"]);
				$thtot=$data[$i]["magerror"];
				break;
			case 57: //Ingresos por alojamiento/Total ingresos netos operacionales (INALO/INTIO).
				$tabla = "rmmh_form_ingoperacionales";
				$index = "aloingneto";
				$campo = "(inalo/intio)*100";
				$data[$index]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$index]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$index]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$index]["actual"], $data[$index]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$index]["varmensual"]);
				$aloingneto=$data[$i]["magerror"];
				break;
			case 58: //Porcentaje de ocupación
				$tabla = "rmmh_form_caracthoteles";
				$index = "porocupacion";
				$campo = "(ihoa/ihdo)*100";
				$data[$index]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$index]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$index]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$index]["actual"], $data[$index]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$index]["varmensual"]);
				$porocupacion=$data[$i]["magerror"];
				break;	
			case 59: //REVPAR (Ingreso Medio por Habitación Ofrecida)
				$tabla1 = "rmmh_form_ingoperacionales";
				$tabla2 = "rmmh_form_caracthoteles";
				$index = "ingmedhab";
				$campo = "(inalo*1000)/ihdo";
				$data[$index]["actual"] = $this->ficha->obtenerValorActualMulti($tabla1, $tabla2, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$index]["anterior"] = $this->ficha->obtenerValorAnteriorMulti($tabla1, $tabla2, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$index]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$index]["actual"], $data[$index]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$index]["varmensual"]);
				$ingmedhab=$data[$i]["magerror"];
				break;
			case 60: //GREVPAR (Ingreso Bruto por Habitación Ofrecida)
				$tabla1 = "rmmh_form_ingoperacionales";
				$tabla2 = "rmmh_form_caracthoteles";
				$index = "ingbrutohab";
				$campo = "(intio*1000)/ihdo";
				$data[$index]["actual"] = $this->ficha->obtenerValorActualMulti($tabla1, $tabla2, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$index]["anterior"] = $this->ficha->obtenerValorAnteriorMulti($tabla1, $tabla2, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$index]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$index]["actual"], $data[$index]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$index]["varmensual"]);
				$ingbrutohab=$data[$i]["magerror"];
				break;
			case 61: //ADR (Facturación Media por habitación Ocupada)
				$tabla1 = "rmmh_form_ingoperacionales";
				$tabla2 = "rmmh_form_caracthoteles";
				$index = "facmedhab";
				$campo = "(inalo*1000)/ihoa";
				$data[$index]["actual"] = $this->ficha->obtenerValorActualMulti($tabla1, $tabla2, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$index]["anterior"] = $this->ficha->obtenerValorAnteriorMulti($tabla1, $tabla2, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				$data[$index]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$index]["actual"], $data[$index]["anterior"]);
				$data[$i]["magerror"] = $this->indicador->calcularMagitudError($data[$index]["varmensual"]);
				$facmedhab=$data[$i]["magerror"];
				break;		
			}
			
		}
		//Se asigna una variable al areglo con la magnitud  de error para cada una de las variables calculadas anteriormente
		$data["magnitudError"]=array($inalo,$inali,$inba,$insr,$inoe,$inoio,$intio,$potperm,$gpper,$percapperm,$porsaling,$pottcde,
									 $gpssde,$salperdir,$porsalperdir,$pottcag,$gpppta,$pertempoemp,$porsaltemp,$potpau,$gppgpa,$peraprndiz,
		                             $porsalaprendiz,$pottot,$gpsspot,$ingperpord,$habvendis,$camvenoc,$estmedia,$ihdo,$ihoa,$icda,
		                             $icva,$ihpn,$ihpnr,$huetot,$mvnr,$mvcr,$mvor,$mvsr,$mvotr,$mvnnr,$mvcnr,$mvonr,$mvsnr,$mvotnr,$thsen,
				                     $thusen,$thdob,$thudob,$thsui,$thusui,$thmult,$thumult,$thotr,$thuotr,$thtot,$aloingneto,$porocupacion,
		                             $ingmedhab,$ingbrutohab,$facmedhab);
		//Obtener la calificación de la fuente
		$data["calificacion"]=$this->indicador->obtenerCalificacionFuentesId($ano_periodo, $mes_periodo, $fuenteIndicador);
		//si hay formulario calificado
		if($data["calificacion"]["calificacion"]>0){
			//Calcula nivel de calidad
			$data["calcula_nivelCalidad"]=$this->indicador->calcularNivelCalidad($data["calificacion"]["calificacion"]);
			
		}
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$this->load->view("layout",$data);
	}
	
	/**
	 * Función para llenar la columna de logro critica
	 * @author Jesús Neira Guio - SJNEIRAG
	 * @since Septiembre 2015
	 */
	public function logrocritica(){
		$this->load->model("periodo");
		$this->load->model("indicador");
		$this->load->model("fichanalisis/ficha");
		//$this->load->view("formularioindicador");
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		
		if($_REQUEST['opcion']==0){
			$logro=100-($_REQUEST['opcion']*$_REQUEST['error']);
			echo number_format($logro,2,'.','');
			echo '<input type="hidden" id="logrocritica'.$_REQUEST['id'].'" name="logrocritica'.$_REQUEST['id'].'" value="'.number_format($logro,2,'.',',').'"/>';
		}elseif($_REQUEST['opcion']==1){
			$logro=100-($_REQUEST['opcion']*$_REQUEST['error']);
			echo number_format($logro,2,'.','');
			echo '<input type="hidden" id="logrocritica'.$_REQUEST['id'].'" name="logrocritica'.$_REQUEST['id'].'" value="'.number_format($logro,2,'.',',').'"/>';
		}
	}
	
	/**
	 * Función para llenar la columna de valor critica
	 * @author Jesús Neira Guio - SJNEIRAG
	 * @since Septiembre 2015
	 */
	public function valoracioncritica(){
		$this->load->model("periodo");
		$this->load->model("indicador");
		$this->load->model("fichanalisis/ficha");
		//$this->load->view("formularioindicador");
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($_REQUEST['opcion']==0){
			$logro=100-($_REQUEST['opcion']*$_REQUEST['error']);
			$valoracion=($logro*$_REQUEST['peso'])/100;
			echo number_format($valoracion,2,'.','');
			echo '<input type="hidden" id="valorcritica'.$_REQUEST['id'].'" name="valorcritica'.$_REQUEST['id'].'" value="'.number_format($valoracion,2,'.',',').'"/>';
		}elseif($_REQUEST['opcion']==1){
			$logro=100-($_REQUEST['opcion']*$_REQUEST['error']);
			$valoracion=($logro*$_REQUEST['peso'])/100;
			echo number_format($valoracion,2,'.','');
			echo '<input type="hidden" id="valorcritica'.$_REQUEST['id'].'" name="valorcritica'.$_REQUEST['id'].'" value="'.number_format($valoracion,2,'.',',').'"/>';
		}
	}
	
	/**
	 * Función para grabar el inidcardor de calidad
	 * @author Jesús Neira Guio - SJNEIRAG
	 * @since Septiembre 2015
	 */
	public function grabarIndicador(){
		$this->load->model("periodo");
		$this->load->model("indicador");
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==3){
			$data['tipo_usuario']="ASISTENTE T&Eacute;CNICO";
			$data["menu"] = ("asistente/asismenu");
		}
		if($tipo_usuario==4){
			$data['tipo_usuario']="ADMINISTRADOR";
			$data["menu"] =  ("administrador/adminmenu");
		}
		$data["nom_usuario"] = $nom_usuario;
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$data["ano_periodo"]=$ano_periodo;
		$data["mes_periodo"]=$mes_periodo;
		$data["view"] = "formularioindicador";
		$data["controller"] = "indicadorcalidad";
		$fuente=$_REQUEST["idfuentes"];
		$data["fuente_calificada"] = $this->indicador->buscarFuentesCalificadas($fuente);
		for($i=0; $i<=61; $i++){
			$idvariable=$_REQUEST["variable".$i];
			$peso= $_REQUEST["peso".$i];
			$magerror=$_REQUEST["magerror".$i];
			$error=$_REQUEST["error".$i];
			$conformidad[$i]= explode("-", $_REQUEST["conforme".$i]);
			$conforme=$conformidad[$i][0];
			$logorcritica=$_REQUEST["logrocritica".$i];
			$valorcritica=$_REQUEST["valorcritica".$i];
			$idestablecimiento=$_REQUEST["idestablecimiento"];
			$idfuente=$_REQUEST["idfuentes"];
			$estado=1;
			//echo $error."</p>";
			if(count($data["fuente_calificada"])>0){
				$this->indicador->modificaIndicador($idvariable, $peso, $magerror, $error, $conforme, $logorcritica, $valorcritica, $idestablecimiento, $idfuente, $estado);
			}else{
				$this->indicador->insertarIndicador($idvariable, $peso, $magerror, $error, $conforme, $logorcritica, $valorcritica, $idestablecimiento, $idfuente, $estado);
			}
			$this->load->helper('url');
		}
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		//$this->load->view("indicadorcalildad",$data);
	}
	
	
	/**
	 * Función para mostrar el indicador de calidad para todas las subsedes
	 * @author Jesús Neira Guio - SJNEIRAG
	 * @since Septiembre 2015
	 */
	public function adminindicador(){
		$this->load->model("periodo");
		$this->load->model("indicador");
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==3){
			$data['tipo_usuario']="ASISTENTE T&Eacute;CNICO";
			$data["menu"] = ("asistente/asismenu");
		}
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
		$data["view"] = "adminindicador";
		$data["controller"] = "indicadorcalidad";
		$data["estado_indicador"]=$this->indicador->obtenerEstado($ano_periodo, $mes_periodo);
		$data["sede"] = $this->indicador->obtenerSede($usuario);
		$data["obtener_subsedes"]=$this->indicador->obtenerSubsedes();
		$fuentesAceptadas=0;
		$fuentesCalificar=0;
		$fuentesCalificadas=0;
		$promediCalificacionFts=0;
		for($i=0; $i<=count($data["obtener_subsedes"])-1; $i++){
			$subsede=$data["obtener_subsedes"][$i]["idsubsede"];
			$data["obtener_fuentes".$i]=$this->indicador->obtenerFuentes($ano_periodo, $mes_periodo, $subsede);
			$fuentesAceptadas=$fuentesAceptadas.','.$data["obtener_fuentes".$i]["numero_fuentes"];
			$data["obtener_fuentes_calificar".$i]=$this->indicador->obtenerFuentesCalificar($ano_periodo, $mes_periodo, $subsede);
			$fuentesCalificar=$fuentesCalificar.','.count($data["obtener_fuentes_calificar".$i]);
			$data["fuentes_calificadas".$i]=$this->indicador->obtenerFuentesCalificadas($ano_periodo, $mes_periodo, 0, $subsede);
			$fuentesCalificadas=$fuentesCalificadas.','.$data["fuentes_calificadas".$i]["calificadas"];
			$data["promedio_Calificacion_Fts".$i]=$this->indicador->obtenerPromedioSubsede($ano_periodo, $mes_periodo,$subsede);
			$promediCalificacionFts=$promediCalificacionFts.','.$data["promedio_Calificacion_Fts".$i]["promedio"];
		}
		$data["fuentesAceptadas"]= $fuentesAceptadas;
		$data["fuentesCalificar"]= $fuentesCalificar;
		$data["fuentesCalificadas"]=$fuentesCalificadas;
		$data["promediCalificacionFts"]=$promediCalificacionFts;
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$this->load->view("layout",$data);
	}
	
	/**
	 * Función para actualizar el estdo del módulo de inidcardor de calidad
	 * @author Jesús Neira Guio - SJNEIRAG
	 * @since Septiembre 2015
	 */
	public function actualizaEstadoModuloIndicador(){
		$this->load->model("indicador");
		$estado=$_REQUEST["habIndicador"];
		$anio=$_REQUEST["ano_periodo"];
		$periodo=$_REQUEST["mes_periodo"];
		$this->indicador->modificaEstadoModuloIndicador($estado, $anio, $periodo);
	}
	
	/**
	 * Función para generar el cierre del indicardor de calidad
	 * @author Jesús Neira Guio - SJNEIRAG
	 * @since Septiembre 2015
	 */
	public function generaCierreIndicador(){
		$this->load->model("periodo");
		$this->load->model("indicador");
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==3){
			$data['tipo_usuario']="ASISTENTE T&Eacute;CNICO";
			$data["menu"] = ("asistente/asismenu");
		}
		if($tipo_usuario==4){
			$data['tipo_usuario']="ADMINISTRADOR";
			$data["menu"] =  ("administrador/adminmenu");
		}
		$data["nom_usuario"] = $nom_usuario;
		$usuario = $this->session->userdata("id");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$data["ano_periodo"]=$ano_periodo;
		$data["mes_periodo"]=$mes_periodo;
		$subsede=$_REQUEST["subsede"];
		$data["obtener_fuentes"]=$this->indicador->obtenerFuentes($ano_periodo, $mes_periodo, $subsede);
		$fuentesAceptadas=$data["obtener_fuentes"]["numero_fuentes"];
		$data["obtener_fuentes_calificar"]=$this->indicador->obtenerFuentesCalificar($ano_periodo, $mes_periodo, $subsede);
		$fuentesSeleccionadas=count($data["obtener_fuentes_calificar"]);
		$data["fuentes_calificadas"]=$this->indicador->obtenerFuentesCalificadas($ano_periodo, $mes_periodo, 0, $subsede);
		$fuentesCalificadas=$data["fuentes_calificadas"]["calificadas"];
		$data["promedio_Calificacion_Fts"]=$this->indicador->obtenerPromedioSubsede($ano_periodo, $mes_periodo,$subsede);
		$calificacion=$data["promedio_Calificacion_Fts"]["promedio"];
		$promedio=number_format(($calificacion/$fuentesSeleccionadas),2,'.','');
		$cierre=1;
		$fechaCierre=date("Y/m/d");
		$estado=1;
		if($promedio==100){
			$nivel="Excelente calidad";
		}elseif($promedio > 98 && $promedio <= 99.9){
			$nivel="Buena calidad";
		}elseif($promedio > 92 && $promedio <= 97.9){
			$nivel="Calidad aceptable";
		}elseif($promedio >= 85 && $promedio <= 91.9){
			$nivel="Calidad regular";
		}elseif($promedio < 85){
			$nivel="Mala calidad";
		}
		$data["registrosCierre"]=$this->indicador->obtenerRegistrosCierre($ano_periodo, $mes_periodo, $subsede);
		if(count($data["registrosCierre"])==0){
			$this->indicador->insertarCierreIndicador($ano_periodo, $mes_periodo, $subsede, $usuario, $fuentesAceptadas, $fuentesSeleccionadas, $fuentesCalificadas, $promedio, $cierre, $fechaCierre, $estado, $nivel);
		}
	}
	
	/**
	 * Función para actualizar la acción correctiva del indicardor de calidad
	 * @author Jesús Neira Guio - SJNEIRAG
	 * @since Septiembre 2015
	 */
	public function actualizaAccionCorrectiva(){
		$this->load->model("indicador");
		$accionCorrectiva=$_REQUEST["accionCorrectiva"];
		$idFuentesCalificar=$_REQUEST["idfuentes"];
		$fechaRegistroAccion=date("Y/m/d");
		$this->indicador->insertaAccionCorrectiva($accionCorrectiva, $fechaRegistroAccion, $idFuentesCalificar);
	}
}//EOC