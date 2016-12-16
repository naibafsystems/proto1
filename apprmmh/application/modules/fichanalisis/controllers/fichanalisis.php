<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fichanalisis extends MX_Controller {
	
	public function __construct(){
        parent::__construct();
		$this->load->library("session");
        $this->load->library("validarsesion");
	}
	
	/**
	 * Controlador para la ficha de análisis
	 * @author Jesús Neira Guio - SJNEIRAG
	 * @since Julio de 2015
	 */
	
	public function index(){
		$this->load->model("control");
		$this->load->model("ficha");
		
		//En este array se almacenan los indices de las variables en los que se presentan errores 
		//en la variacion de la ficha de analisis.
		$erroresIndices = array();
		
		$nro_orden = $this->uri->segment(3,0);
		$nro_establecimiento = $this->uri->segment(4,0);
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$data["nro_orden"] = $nro_orden;
		$data["nro_establecimiento"] = $nro_establecimiento;
		$data["novedad_estado"] = $this->control->obtenerNovedadEstado($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		
		//Rango para la variación anual y mensual para la ficha de análisis.
		$tabla = "rmmh_form_ingoperacionales";
		$campo = "intio";
		$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		
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
		
		//Ingresos causados en el mes - INALO
		$tabla = "rmmh_form_ingoperacionales";
		$campo = "inalo";
		$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);		
		$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["inalo"]["actual"], $data["inalo"]["anterior"]);
		$data[$campo]["varanual"] = $this->ficha->calcularVariacionAnual($data["inalo"]["actual"], $data["inalo"]["anual"]);
		//$data[$campo]["err1"] = $this->ficha->compararValor(">", $data[$campo]["varmensual"], 15);
		//$data[$campo]["err2"] = $this->ficha->compararValor(">", $data[$campo]["varanual"], 15);
		$data[$campo]["err1"] = $this->ficha->compararRango($data[$campo]["varmensual"], $rango); //Se compara si el valor está dentro del rango de [-15,15]
		$data[$campo]["err2"] = $this->ficha->compararRango($data[$campo]["varanual"], $rango); //Se compara si el valor está dentro del rango de [-15,15] 
		if (($data[$campo]["err1"])||($data[$campo]["err2"])){
			array_push($erroresIndices,1); //Se presentan errores en el indice 1 (INALO)
		}
		
		//Ingresos causados en el mes - INALI
		$campo = "inali";
		$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);		
		$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$campo]["actual"], $data[$campo]["anterior"]);
		$data[$campo]["varanual"] = $this->ficha->calcularVariacionAnual($data[$campo]["actual"], $data[$campo]["anual"]);
		//$data[$campo]["err1"] = $this->ficha->compararValor(">", $data[$campo]["varmensual"], 15);
		//$data[$campo]["err2"] = $this->ficha->compararValor(">", $data[$campo]["varanual"], 15);
		$data[$campo]["err1"] = $this->ficha->compararRango($data[$campo]["varmensual"],$rango);
		$data[$campo]["err2"] = $this->ficha->compararRango($data[$campo]["varanual"],$rango);
		if (($data[$campo]["err1"])||($data[$campo]["err2"])){
			array_push($erroresIndices,2); //Se presentan errores en el indice 2 (INALI)
		}
		
		//Ingresos causados en el mes - INBA
		$campo = "inba";
		$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);		
		$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$campo]["actual"], $data[$campo]["anterior"]);
		$data[$campo]["varanual"] = $this->ficha->calcularVariacionAnual($data[$campo]["actual"], $data[$campo]["anual"]);
		//$data[$campo]["err1"] = $this->ficha->compararValor(">", $data[$campo]["varmensual"], 15);
		//$data[$campo]["err2"] = $this->ficha->compararValor(">", $data[$campo]["varanual"], 15);
		$data[$campo]["err1"] = $this->ficha->compararRango($data[$campo]["varmensual"],$rango);
		$data[$campo]["err2"] = $this->ficha->compararRango($data[$campo]["varanual"],$rango);
		if (($data[$campo]["err1"])||($data[$campo]["err2"])){
			array_push($erroresIndices,3); //Se presentan errores en el indice 3 (INBA)
		}
		
		//Ingresos causados en el mes - INSR
		$campo = "insr";
		$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$campo]["actual"], $data[$campo]["anterior"]);
		$data[$campo]["varanual"] = $this->ficha->calcularVariacionAnual($data[$campo]["actual"], $data[$campo]["anual"]);
		//$data[$campo]["err1"] = $this->ficha->compararValor(">", $data[$campo]["varmensual"], 15);
		//$data[$campo]["err2"] = $this->ficha->compararValor(">", $data[$campo]["varanual"], 15);
		$data[$campo]["err1"] = $this->ficha->compararRango($data[$campo]["varmensual"],$rango);
		$data[$campo]["err2"] = $this->ficha->compararRango($data[$campo]["varanual"],$rango);
		if (($data[$campo]["err1"])||($data[$campo]["err2"])){
			array_push($erroresIndices,3); //Se presentan errores en el indice 3 (INBA)
		}
		
		//Ingresos causados en el mes - INOE
		$campo = "inoe";
		$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);		
		$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$campo]["actual"], $data[$campo]["anterior"]);
		$data[$campo]["varanual"] = $this->ficha->calcularVariacionAnual($data[$campo]["actual"], $data[$campo]["anual"]);
		//$data[$campo]["err1"] = $this->ficha->compararValor(">", $data[$campo]["varmensual"], 15);
		//$data[$campo]["err2"] = $this->ficha->compararValor(">", $data[$campo]["varanual"], 15);
		$data[$campo]["err1"] = $this->ficha->compararRango($data[$campo]["varmensual"],$rango);
		$data[$campo]["err2"] = $this->ficha->compararRango($data[$campo]["varanual"],$rango);
		if (($data[$campo]["err1"])||($data[$campo]["err2"])){
			array_push($erroresIndices,4); //Se presentan errores en el indice 4 (INOE)
		}
		
		//Ingresos causados en el mes - INOIO
		$campo = "inoio";
		$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);		
		$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$campo]["actual"], $data[$campo]["anterior"]);
		$data[$campo]["varanual"] = $this->ficha->calcularVariacionAnual($data[$campo]["actual"], $data[$campo]["anual"]);
		//$data[$campo]["err1"] = $this->ficha->compararValor(">", $data[$campo]["varmensual"], 15);
		//$data[$campo]["err2"] = $this->ficha->compararValor(">", $data[$campo]["varanual"], 15);
		$data[$campo]["err1"] = $this->ficha->compararRango($data[$campo]["varmensual"], $rango); //Se compara si el valor está dentro del rango de [-15,15]
		$data[$campo]["err2"] = $this->ficha->compararRango($data[$campo]["varanual"], $rango); //Se compara si el valor está dentro del rango de [-15,15] 
		if (($data[$campo]["err1"])||($data[$campo]["err2"])){
			array_push($erroresIndices,5); //Se presentan errores en el indice 5 (INOIO)
		}
		
		//Ingresos causados en el mes - INTIO
		$campo = "intio";
		$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);		
		$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$campo]["actual"], $data[$campo]["anterior"]);
		$data[$campo]["varanual"] = $this->ficha->calcularVariacionAnual($data[$campo]["actual"], $data[$campo]["anual"]);
		//$data[$campo]["err1"] = $this->ficha->compararValor(">", $data[$campo]["varmensual"], 15);
		//$data[$campo]["err2"] = $this->ficha->compararValor(">", $data[$campo]["varanual"], 15);
		$data[$campo]["err1"] = $this->ficha->compararRango($data[$campo]["varmensual"], $rango);
		$data[$campo]["err2"] = $this->ficha->compararRango($data[$campo]["varanual"], $rango);
		if (($data[$campo]["err1"])||($data[$campo]["err2"])){
			array_push($erroresIndices,6); //Se presentan errores en el indice 6 (INTIO)
		}
		
		//Personal ocupado y salarios causados en el mes - POTTOT
		$tabla = "rmmh_form_persalarios";
		$index = "pottot";
		$campo = "pottot - potpau";
		$data[$index]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$index]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$index]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);		
		$data[$index]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$index]["actual"], $data[$index]["anterior"]);
		$data[$index]["varanual"] = $this->ficha->calcularVariacionAnual($data[$index]["actual"], $data[$index]["anual"]);
		//$data[$index]["err1"] = $this->ficha->compararValor(">=", $data[$index]["varmensual"], 15);
		//$data[$index]["err2"] = $this->ficha->compararValor(">=", $data[$index]["varanual"], 15);
		$data[$index]["err1"] = $this->ficha->compararRango($data[$index]["varmensual"], $rango);
		$data[$index]["err2"] = $this->ficha->compararRango($data[$index]["varanual"], $rango);
		if (($data[$index]["err1"])||($data[$index]["err2"])){
			array_push($erroresIndices,7); //Se presentan errores en el indice 7 (POTTOT)
		}
		
		//Personal ocupado y salarios causados en el mes - POTPSFR
		$campo = "potpsfr";
		$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);		
		$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$campo]["actual"], $data[$campo]["anterior"]);
		$data[$campo]["varanual"] = $this->ficha->calcularVariacionAnual($data[$campo]["actual"], $data[$campo]["anual"]);
		//$data[$campo]["err1"] = $this->ficha->compararValor(">=", $data[$campo]["varmensual"], 15);
		//$data[$campo]["err2"] = $this->ficha->compararValor(">=", $data[$campo]["varanual"], 15);
		$data[$campo]["err1"] = $this->ficha->compararRango($data[$campo]["varmensual"], $rango);
		$data[$campo]["err2"] = $this->ficha->compararRango($data[$campo]["varanual"], $rango);
		if (($data[$campo]["err1"])||($data[$campo]["err2"])){
			array_push($erroresIndices,8); //Se presentan errores en el indice 8 (POTPSFR)
		}
		
		//Personal ocupado y salarios causados en el mes - POTPERM
		$campo = "potperm";
		$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);		
		$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$campo]["actual"], $data[$campo]["anterior"]);
		$data[$campo]["varanual"] = $this->ficha->calcularVariacionAnual($data[$campo]["actual"], $data[$campo]["anual"]);
		//$data[$campo]["err1"] = $this->ficha->compararValor(">=", $data[$campo]["varmensual"], 15);
		//$data[$campo]["err2"] = $this->ficha->compararValor(">=", $data[$campo]["varanual"], 15);
		$data[$campo]["err1"] = $this->ficha->compararRango($data[$campo]["varmensual"], $rango);
		$data[$campo]["err2"] = $this->ficha->compararRango($data[$campo]["varanual"], $rango);
		if (($data[$campo]["err1"])||($data[$campo]["err2"])){
			array_push($erroresIndices,9); //Se presentan errores en el indice 9 (POTPERM)
		}
		
		//Personal ocupado y salarios causados en el mes - GPPER
		$campo = "gpper";
		$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);		
		$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$campo]["actual"], $data[$campo]["anterior"]);
		$data[$campo]["varanual"] = $this->ficha->calcularVariacionAnual($data[$campo]["actual"], $data[$campo]["anual"]);
		//$data[$campo]["err1"] = $this->ficha->compararValor(">=", $data[$campo]["varmensual"], 15);
		//$data[$campo]["err2"] = $this->ficha->compararValor(">=", $data[$campo]["varanual"], 15);
		$data[$campo]["err1"] = $this->ficha->compararRango($data[$campo]["varmensual"], $rango);
		$data[$campo]["err2"] = $this->ficha->compararRango($data[$campo]["varanual"], $rango);
		if (($data[$campo]["err1"])||($data[$campo]["err2"])){
			array_push($erroresIndices,10); //Se presentan errores en el indice 10 (GPPER)
		}
		
		//Personal ocupado y salarios causados en el mes - Salario percapita personal permanente
		$index = "salpper";
		$campo = "gpper / potperm";
		$data[$index]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$index]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$index]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);		
		$data[$index]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$index]["actual"], $data[$index]["anterior"]);
		$data[$index]["varanual"] = $this->ficha->calcularVariacionAnual($data[$index]["actual"], $data[$index]["anual"]);
		//$data[$index]["err1"] = $this->ficha->compararValor(">=", $data[$index]["varmensual"], 15);
		//$data[$index]["err2"] = $this->ficha->compararValor(">=", $data[$index]["varanual"], 15);
		$data[$index]["err1"] = $this->ficha->compararRango($data[$index]["varmensual"], $rango);
		$data[$index]["err2"] = $this->ficha->compararRango($data[$index]["varanual"], $rango);
	    if (($data[$index]["err1"])||($data[$index]["err2"])){
			array_push($erroresIndices,11); //Se presentan errores en el indice 11 (SALPPER)
		}
		
		//Personal ocupado y salarios causados en el mes - POTTCDE
		$campo = "pottcde";
		$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);		
		$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$campo]["actual"], $data[$campo]["anterior"]);
		$data[$campo]["varanual"] = $this->ficha->calcularVariacionAnual($data[$campo]["actual"], $data[$campo]["anual"]);
		//$data[$campo]["err1"] = $this->ficha->compararValor(">=", $data[$campo]["varmensual"], 15);
		//$data[$campo]["err2"] = $this->ficha->compararValor(">=", $data[$campo]["varanual"], 15);
		$data[$campo]["err1"] = $this->ficha->compararRango($data[$campo]["varmensual"], $rango);
		$data[$campo]["err2"] = $this->ficha->compararRango($data[$campo]["varanual"], $rango);
		if (($data[$campo]["err1"])||($data[$campo]["err2"])){
			array_push($erroresIndices,12); //Se presentan errores en el indice 12 (POTTCDE)
		}
		
		//Personal ocupado y salarios causados en el mes - GPSSDE
		$campo = "gpssde";
		$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$campo]["actual"], $data[$campo]["anterior"]);
		$data[$campo]["varanual"] = $this->ficha->calcularVariacionAnual($data[$campo]["actual"], $data[$campo]["anual"]);
		//$data[$campo]["err1"] = $this->ficha->compararValor(">=", $data[$campo]["varmensual"], 15);
		//$data[$campo]["err2"] = $this->ficha->compararValor(">=", $data[$campo]["varanual"], 15);
		$data[$campo]["err1"] = $this->ficha->compararRango($data[$campo]["varmensual"], $rango);
		$data[$campo]["err2"] = $this->ficha->compararRango($data[$campo]["varanual"], $rango);
		if (($data[$campo]["err1"])||($data[$campo]["err2"])){
			array_push($erroresIndices,13); //Se presentan errores en el indice 13 (GPSSDE)
		}
		
		//Personal ocupado y salarios causados en el mes - Salario percapita temporal directo
		$index = "saltdir";
		$campo = "gpssde/pottcde";
		$data[$index]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$index]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$index]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);		
		$data[$index]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$index]["actual"], $data[$index]["anterior"]);
		$data[$index]["varanual"] = $this->ficha->calcularVariacionAnual($data[$index]["actual"], $data[$index]["anual"]);
		//$data[$index]["err1"] = $this->ficha->compararValor(">=", $data[$index]["varmensual"], 15);
		//$data[$index]["err2"] = $this->ficha->compararValor(">=", $data[$index]["varanual"], 15);
		$data[$index]["err1"] = $this->ficha->compararRango($data[$index]["varmensual"], $rango);
		$data[$index]["err2"] = $this->ficha->compararRango($data[$index]["varanual"], $rango);
		if (($data[$index]["err1"])||($data[$index]["err2"])){
			array_push($erroresIndices,14); //Se presentan errores en el indice 14 (SALTDIR)
		}
		
		//Personal ocupado y salarios causados en el mes - POTTCAG
		$campo = "pottcag";
		$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);		
		$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$campo]["actual"], $data[$campo]["anterior"]);
		$data[$campo]["varanual"] = $this->ficha->calcularVariacionAnual($data[$campo]["actual"], $data[$campo]["anual"]);
		//$data[$campo]["err1"] = $this->ficha->compararValor(">=", $data[$campo]["varmensual"], 15);
		//$data[$campo]["err2"] = $this->ficha->compararValor(">=", $data[$campo]["varanual"], 15);
		$data[$campo]["err1"] = $this->ficha->compararRango($data[$campo]["varmensual"], $rango);
		$data[$campo]["err2"] = $this->ficha->compararRango($data[$campo]["varanual"], $rango);		
		if (($data[$campo]["err1"])||($data[$campo]["err2"])){
			array_push($erroresIndices,15); //Se presentan errores en el indice 15 (POTTCAG)
		}
		
		//Personal ocupado y salarios causados en el mes - GPPPTA
		$campo = "gpppta";
		$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);		
		$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$campo]["actual"], $data[$campo]["anterior"]);
		$data[$campo]["varanual"] = $this->ficha->calcularVariacionAnual($data[$campo]["actual"], $data[$campo]["anual"]);
		//$data[$campo]["err1"] = $this->ficha->compararValor(">=", $data[$campo]["varmensual"], 15);
		//$data[$campo]["err2"] = $this->ficha->compararValor(">=", $data[$campo]["varanual"], 15);
		$data[$campo]["err1"] = $this->ficha->compararRango($data[$campo]["varmensual"], $rango);
		$data[$campo]["err2"] = $this->ficha->compararRango($data[$campo]["varanual"], $rango);
		if (($data[$campo]["err1"])||($data[$campo]["err2"])){
			array_push($erroresIndices,16); //Se presentan errores en el indice 16 (GPPPTA)
		}
		
		//Personal ocupado y salarios causados en el mes - Salario percapita temporal suministrado
		$index = "saltsum";
		$campo = "gpppta/pottcag";
		$data[$index]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$index]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$index]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);		
		$data[$index]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$index]["actual"], $data[$index]["anterior"]);
		$data[$index]["varanual"] = $this->ficha->calcularVariacionAnual($data[$index]["actual"], $data[$index]["anual"]);
		//$data[$index]["err1"] = $this->ficha->compararValor(">=", $data[$index]["varmensual"], 15);
		//$data[$index]["err2"] = $this->ficha->compararValor(">=", $data[$index]["varanual"], 15);
		$data[$index]["err1"] = $this->ficha->compararRango($data[$index]["varmensual"], $rango);
		$data[$index]["err2"] = $this->ficha->compararRango($data[$index]["varanual"], $rango);
		if (($data[$index]["err1"])||($data[$index]["err2"])){
			array_push($erroresIndices,17); //Se presentan errores en el indice 17 (SALTSUM)
		}
		
		//Personal ocupado y salarios causados en el mes - POTPAU
		$campo = "potpau";
		$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);		
		$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$campo]["actual"], $data[$campo]["anterior"]);
		$data[$campo]["varanual"] = $this->ficha->calcularVariacionAnual($data[$campo]["actual"], $data[$campo]["anual"]);
		//$data[$campo]["err1"] = $this->ficha->compararValor(">=", $data[$campo]["varmensual"], 15);
		//$data[$campo]["err2"] = $this->ficha->compararValor(">=", $data[$campo]["varanual"], 15);
		$data[$campo]["err1"] = $this->ficha->compararRango($data[$campo]["varmensual"], $rango);
		$data[$campo]["err2"] = $this->ficha->compararRango($data[$campo]["varanual"], $rango);
		if (($data[$campo]["err1"])||($data[$campo]["err2"])){
			array_push($erroresIndices,18); //Se presentan errores en el indice 18 (POTPAU)
		}
		
		//Personal ocupado y salarios causados en el mes - GPPGPA
		$campo = "gppgpa";
		$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);		
		$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$campo]["actual"], $data[$campo]["anterior"]);
		$data[$campo]["varanual"] = $this->ficha->calcularVariacionAnual($data[$campo]["actual"], $data[$campo]["anual"]);
		//$data[$campo]["err1"] = $this->ficha->compararValor(">=", $data[$campo]["varmensual"], 15);
		//$data[$campo]["err2"] = $this->ficha->compararValor(">=", $data[$campo]["varanual"], 15);
		$data[$campo]["err1"] = $this->ficha->compararRango($data[$campo]["varmensual"], $rango);
		$data[$campo]["err2"] = $this->ficha->compararRango($data[$campo]["varanual"], $rango);
		if (($data[$campo]["err1"])||($data[$campo]["err2"])){
			array_push($erroresIndices,19); //Se presentan errores en el indice 19 (GPPGPA)
		}
		
		//Personal ocupado y salarios causados en el mes - Salario percapita personal aprendiz
		$index = "salpapre";
		$campo = "gppgpa/potpau";
		$data[$index]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$index]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$index]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);		
		$data[$index]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$index]["actual"], $data[$index]["anterior"]);
		$data[$index]["varanual"] = $this->ficha->calcularVariacionAnual($data[$index]["actual"], $data[$index]["anual"]);
		//$data[$index]["err1"] = $this->ficha->compararValor(">=", $data[$index]["varmensual"], 15);
		//$data[$index]["err2"] = $this->ficha->compararValor(">=", $data[$index]["varanual"], 15);
		$data[$index]["err1"] = $this->ficha->compararRango($data[$index]["varmensual"], $rango);
		$data[$index]["err2"] = $this->ficha->compararRango($data[$index]["varanual"], $rango);
		if (($data[$index]["err1"])||($data[$index]["err2"])){
			array_push($erroresIndices,20); //Se presentan errores en el indice 20 (SALPAPRE)
		}
		
		//Personal ocupado y salarios causados en el mes - GPSSPOT
		$campo = "gpsspot";
		$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);		
		$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$campo]["actual"], $data[$campo]["anterior"]);
		$data[$campo]["varanual"] = $this->ficha->calcularVariacionAnual($data[$campo]["actual"], $data[$campo]["anual"]);
		//$data[$campo]["err1"] = $this->ficha->compararValor(">=", $data[$campo]["varmensual"], 15);
		//$data[$campo]["err2"] = $this->ficha->compararValor(">=", $data[$campo]["varanual"], 15);
		$data[$campo]["err1"] = $this->ficha->compararRango($data[$campo]["varmensual"], $rango);
		$data[$campo]["err2"] = $this->ficha->compararRango($data[$campo]["varanual"], $rango);
		if (($data[$campo]["err1"])||($data[$campo]["err2"])){
			array_push($erroresIndices,21); //Se presentan errores en el indice 21 (GPSSPOT)
		}
		
		//Personal ocupado y salarios causados en el mes - Salarios / Total ingresos
		$tabla1 = "rmmh_form_ingoperacionales";
		$tabla2 = "rmmh_form_persalarios";
		$index = "saltoting";
		$campo = "(gpsspot/intio)*100";  
		$data[$index]["actual"] = $this->ficha->obtenerValorActualMulti($tabla1, $tabla2, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$index]["anterior"] = $this->ficha->obtenerValorAnteriorMulti($tabla1, $tabla2, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$index]["anual"] = $this->ficha->obtenerValorAnualMulti($tabla1, $tabla2, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);		
		$data[$index]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$index]["actual"], $data[$index]["anterior"]);
		$data[$index]["varanual"] = $this->ficha->calcularVariacionAnual($data[$index]["actual"], $data[$index]["anual"]);
		//$data[$index]["err1"] = $this->ficha->compararValor(">=", $data[$index]["varmensual"], 15);
		//$data[$index]["err2"] = $this->ficha->compararValor(">=", $data[$index]["varanual"], 15);
		$data[$index]["err1"] = $this->ficha->compararRango($data[$index]["varmensual"], $rango);
		$data[$index]["err2"] = $this->ficha->compararRango($data[$index]["varanual"], $rango);
		if (($data[$index]["err1"])||($data[$index]["err2"])){
			array_push($erroresIndices,22); //Se presentan errores en el indice 22 (SALTOTING)
		}
		
		
		/*
		//Personal ocupado y salarios causados en el mes - ESINI
		$tabla = "rmmh_form_movmensual";
		$campo = "esini";
		$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);		
		$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$campo]["actual"], $data[$campo]["anterior"]);
		$data[$campo]["varanual"] = $this->ficha->calcularVariacionAnual($data[$campo]["actual"], $data[$campo]["anual"]);
		$data[$campo]["err1"] = $this->ficha->compararValor(">", $data[$campo]["varmensual"], 0);
		$data[$campo]["err2"] = $this->ficha->compararValor(">", $data[$campo]["varanual"], 0);
		if (($data[$campo]["err1"])||($data[$campo]["err2"])){
			array_push($erroresIndices,23); //Se presentan errores en el indice 23 (ESINI)
		}
		*/
		
		/*
		//Personal ocupado y salarios causados en el mes - ESAPE
		$tabla = "rmmh_form_movmensual";
		$campo = "esape";
		$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);		
		$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$campo]["actual"], $data[$campo]["anterior"]);
		$data[$campo]["varanual"] = $this->ficha->calcularVariacionAnual($data[$campo]["actual"], $data[$campo]["anual"]);
		$data[$campo]["err1"] = $this->ficha->compararValor(">", $data[$campo]["varmensual"], 0);
		$data[$campo]["err2"] = $this->ficha->compararValor(">", $data[$campo]["varanual"], 0);
		if (($data[$campo]["err1"])||($data[$campo]["err2"])){
			array_push($erroresIndices,24); //Se presentan errores en el indice 24 (ESINI)
		}
		*/
		
		/*
		//Personal ocupado y salarios causados en el mes - ESCIE
		$tabla = "rmmh_form_movmensual";
		$campo = "escie";
		$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);		
		$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$campo]["actual"], $data[$campo]["anterior"]);
		$data[$campo]["varanual"] = $this->ficha->calcularVariacionAnual($data[$campo]["actual"], $data[$campo]["anual"]);
		$data[$campo]["err1"] = $this->ficha->compararValor(">", $data[$campo]["varmensual"], 0);
		$data[$campo]["err2"] = $this->ficha->compararValor(">", $data[$campo]["varanual"], 0);
		if (($data[$campo]["err1"])||($data[$campo]["err2"])){
			array_push($erroresIndices,25); //Se presentan errores en el indice 25 (ESCIE)
		}
		*/
		
		/*
		//Personal ocupado y salarios causados en el mes - ESTOT
		$tabla = "rmmh_form_movmensual";
		$campo = "estot";
		$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);		
		$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$campo]["actual"], $data[$campo]["anterior"]);
		$data[$campo]["varanual"] = $this->ficha->calcularVariacionAnual($data[$campo]["actual"], $data[$campo]["anual"]);
		$data[$campo]["err1"] = $this->ficha->compararValor(">", $data[$campo]["varmensual"], 0);
		$data[$campo]["err2"] = $this->ficha->compararValor(">", $data[$campo]["varanual"], 0);
		if (($data[$campo]["err1"])||($data[$campo]["err2"])){
			array_push($erroresIndices,26); //Se presentan errores en el indice 26 (ESTOT)
		}
		*/
		
		//Caracteristicas - Ingresos percapita producidos
		$tabla1 = "rmmh_form_ingoperacionales";
		$tabla2 = "rmmh_form_persalarios";
		$index = "ingperprod";
		$campo = "(intio*1000)/pottot";
		$data[$index]["actual"] = $this->ficha->obtenerValorActualMulti($tabla1, $tabla2, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$index]["anterior"] = $this->ficha->obtenerValorAnteriorMulti($tabla1, $tabla2, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$index]["anual"] = $this->ficha->obtenerValorAnualMulti($tabla1, $tabla2, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);		
		$data[$index]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$index]["actual"], $data[$index]["anterior"]);
		$data[$index]["varanual"] = $this->ficha->calcularVariacionAnual($data[$index]["actual"], $data[$index]["anual"]);
		//$data[$index]["err1"] = $this->ficha->compararValor(">=", $data[$index]["varmensual"], 15);
		//$data[$index]["err2"] = $this->ficha->compararValor(">=", $data[$index]["varanual"], 15);
		$data[$index]["err1"] = $this->ficha->compararRango($data[$index]["varmensual"], $rango);
		$data[$index]["err2"] = $this->ficha->compararRango($data[$index]["varanual"], $rango);
		if (($data[$index]["err1"])||($data[$index]["err2"])){
			array_push($erroresIndices,23); 
		}
		

		//Caracteristicas - Ingresos Vs. Salarios
		$tabla1 = "rmmh_form_ingoperacionales";
		$tabla2 = "rmmh_form_persalarios";
		$index = "ingvssal";
		$campo = "intio/gpsspot";
		$data[$index]["actual"] = $this->ficha->obtenerValorActualMulti($tabla1, $tabla2, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$index]["anterior"] = $this->ficha->obtenerValorAnteriorMulti($tabla1, $tabla2, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$index]["anual"] = $this->ficha->obtenerValorAnualMulti($tabla1, $tabla2, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);		
		$data[$index]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$index]["actual"], $data[$index]["anterior"]);
		$data[$index]["varanual"] = $this->ficha->calcularVariacionAnual($data[$index]["actual"], $data[$index]["anual"]);
		//$data[$index]["err1"] = $this->ficha->compararValor(">=", $data[$index]["varmensual"], 15);
		//$data[$index]["err2"] = $this->ficha->compararValor(">=", $data[$index]["varanual"], 15);
		$data[$index]["err1"] = $this->ficha->compararRango($data[$index]["varmensual"], $rango);
		$data[$index]["err2"] = $this->ficha->compararRango($data[$index]["varanual"], $rango);
		if (($data[$index]["err1"])||($data[$index]["err2"])){
			array_push($erroresIndices,24); 
		}
		
		//Caracteristicas - Estancia media 1 (De un periodo a otro)
		$tabla = "rmmh_form_caracthoteles";
		$index = "estmedia";
		$campo = "icva/huetot";
		$data[$index]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$index]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$index]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);		
		$data[$index]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$index]["actual"], $data[$index]["anterior"]);
		$data[$index]["varanual"] = $this->ficha->calcularVariacionAnual($data[$index]["actual"], $data[$index]["anual"]);
		//Validacion de estancia media anterior
		$em_anterior = $data[$index]["actual"] - $data[$index]["anterior"];
		//$data[$index]["err1"] = $this->ficha->compararValor(">", $em_anterior, 10);
		$data[$index]["err1"] = $this->ficha->compararRango($em_anterior, 10);
		//Validacion de estancia media anual
		$em_anual = $data[$index]["actual"] - $data[$index]["anual"];
		//$data[$index]["err2"] = $this->ficha->compararValor(">", $em_anual, 5);
		$data[$index]["err2"] = $this->ficha->compararRango($em_anual, 5);
		if (($data[$index]["err1"])||($data[$index]["err2"])){
			array_push($erroresIndices,25); 
		}
		
		//Caracteristicas - Estancia media 2 (Estancia Mes a Mes)
		$tabla = "rmmh_form_caracthoteles";
		$index = "estmedia2";
		$campo = "icva/huetot";
		$data[$index]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		
		//Se comenta esta operacion por ser el primer mes (Eliminar el comentario a partir del segundo periodo)
		//$data[$index]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$index]["anterior"] = 0.00;
		
		//Se comenta esta operacion por ser el primer mes (Eliminar el comentario a partir del segundo periodo)
		//$data[$index]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);		
		$data[$index]["anual"] = 0.00;
		
		//CALCULO DE LAS VARIACIONES
		//Se comenta esta operacion por ser el primer mes (Eliminar el comentario a partir del segundo periodo)
		//$data[$index]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$index]["actual"], $data[$index]["anterior"]);
		$data[$index]["varmensual"] = 0.00;
		
		//Se comenta esta operacion por ser el primer mes (Eliminar el comentario a partir del segundo periodo)
		//$data[$index]["varanual"] = $this->ficha->calcularVariacionAnual($data[$index]["actual"], $data[$index]["anual"]);
		$data[$index]["varanual"] = 0.00;
		
		//Se comenta esta operacion por ser el primer mes (Eliminar el comentario a partir del segundo periodo)
		//$data[$index]["err1"] = $this->ficha->compararValor(">=", $data[$index]["varmensual"], 1);
		$data[$index]["err1"] = $this->ficha->compararValor("==", $data[$index]["actual"], 1);
		
		//Se comenta esta operacion por ser el primer mes (Eliminar el comentario a partir del segundo periodo)
		//$data[$index]["err2"] = $this->ficha->compararValor(">=", $data[$index]["varanual"], 1);
		$data[$index]["err2"] = false;
		
		if (($data[$index]["err1"])||($data[$index]["err2"])){
			array_push($erroresIndices,30); //Se presentan errores en el indice 30 (ESTMEDIA2)
		}
		
		//Caracteristicas - Ingresos por alojamiento/Total ingresos netos operacionales
		$tabla = "rmmh_form_ingoperacionales";
		$index = "aloingneto";
		$campo = "(inalo/intio)*100";
		$data[$index]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$index]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$index]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);		
		$data[$index]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$index]["actual"], $data[$index]["anterior"]);
		$data[$index]["varanual"] = $this->ficha->calcularVariacionAnual($data[$index]["actual"], $data[$index]["anual"]);
		//$data[$index]["err1"] = $this->ficha->compararValor(">=",$data[$index]["varmensual"], 15);
		//$data[$index]["err2"] = $this->ficha->compararValor(">=",$data[$index]["varmensual"], 15);
		$data[$index]["err1"] = $this->ficha->compararRango($data[$index]["varmensual"], $rango);
		$data[$index]["err2"] = $this->ficha->compararRango($data[$index]["varmensual"], $rango);
		if (($data[$index]["err1"])||($data[$index]["err2"])){
			array_push($erroresIndices,26); 
		}
		
		//Porcentaje de ocupación 
		$tabla = "rmmh_form_caracthoteles";
		$index = "porocupacion";
		$campo = "(ihoa/ihdo)*100";
		$data[$index]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$index]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$index]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$index]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$index]["actual"], $data[$index]["anterior"]);
		$data[$index]["varanual"] = $this->ficha->calcularVariacionAnual($data[$index]["actual"], $data[$index]["anual"]);
		//$data[$index]["err1"] = $this->ficha->compararValor(">=",$data[$index]["varmensual"], 15);
		//$data[$index]["err2"] = $this->ficha->compararValor(">=",$data[$index]["varmensual"], 15);
		$data[$index]["err1"] = $this->ficha->compararRango($data[$index]["varmensual"], $rango);
		$data[$index]["err2"] = $this->ficha->compararRango($data[$index]["varmensual"], $rango);
		if (($data[$index]["err1"])||($data[$index]["err2"])){
			array_push($erroresIndices,27); 
		}
		
		//REVPAR (Ingreso Medio por Habitación Ofrecida)
		$tabla1 = "rmmh_form_ingoperacionales";
		$tabla2 = "rmmh_form_caracthoteles";
		$index = "ingmedhab";
		$campo = "(inalo*1000)/ihdo";
		$data[$index]["actual"] = $this->ficha->obtenerValorActualMulti($tabla1, $tabla2, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$index]["anterior"] = $this->ficha->obtenerValorAnteriorMulti($tabla1, $tabla2, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$index]["anual"] = $this->ficha->obtenerValorAnualMulti($tabla1, $tabla2, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$index]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$index]["actual"], $data[$index]["anterior"]);
		$data[$index]["varanual"] = $this->ficha->calcularVariacionAnual($data[$index]["actual"], $data[$index]["anual"]);
		//$data[$index]["err1"] = $this->ficha->compararValor(">=", $data[$index]["varmensual"], 15);
		//$data[$index]["err2"] = $this->ficha->compararValor(">=", $data[$index]["varanual"], 15);
		$data[$index]["err1"] = $this->ficha->compararRango($data[$index]["varmensual"], $rango);
		$data[$index]["err2"] = $this->ficha->compararRango($data[$index]["varanual"], $rango);
		if (($data[$index]["err1"])||($data[$index]["err2"])){
			array_push($erroresIndices,28);
		}
		
		//GREVPAR (Ingreso Bruto por Habitación Ofrecida)
		$tabla1 = "rmmh_form_ingoperacionales";
		$tabla2 = "rmmh_form_caracthoteles";
		$index = "ingbrutohab";
		$campo = "(intio*1000)/ihdo";
		$data[$index]["actual"] = $this->ficha->obtenerValorActualMulti($tabla1, $tabla2, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$index]["anterior"] = $this->ficha->obtenerValorAnteriorMulti($tabla1, $tabla2, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$index]["anual"] = $this->ficha->obtenerValorAnualMulti($tabla1, $tabla2, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$index]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$index]["actual"], $data[$index]["anterior"]);
		$data[$index]["varanual"] = $this->ficha->calcularVariacionAnual($data[$index]["actual"], $data[$index]["anual"]);
		//$data[$index]["err1"] = $this->ficha->compararValor(">=", $data[$index]["varmensual"], 15);
		//$data[$index]["err2"] = $this->ficha->compararValor(">=", $data[$index]["varanual"], 15);
		$data[$index]["err1"] = $this->ficha->compararRango($data[$index]["varmensual"], $rango);
		$data[$index]["err2"] = $this->ficha->compararRango($data[$index]["varanual"], $rango);
		if (($data[$index]["err1"])||($data[$index]["err2"])){
			array_push($erroresIndices,29); //Se presentan errores en el indice 28 (INGVSSAL)
		} 
		
		//ADR (Facturación Media por habitación Ocupada)
		$tabla1 = "rmmh_form_ingoperacionales";
		$tabla2 = "rmmh_form_caracthoteles";
		$index = "facmedhab";
		$campo = "(inalo*1000)/ihoa";
		$data[$index]["actual"] = $this->ficha->obtenerValorActualMulti($tabla1, $tabla2, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$index]["anterior"] = $this->ficha->obtenerValorAnteriorMulti($tabla1, $tabla2, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$index]["anual"] = $this->ficha->obtenerValorAnualMulti($tabla1, $tabla2, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$index]["varmensual"] = $this->ficha->calcularVariacionMensual($data[$index]["actual"], $data[$index]["anterior"]);
		$data[$index]["varanual"] = $this->ficha->calcularVariacionAnual($data[$index]["actual"], $data[$index]["anual"]);
		//$data[$index]["err1"] = $this->ficha->compararValor(">=", $data[$index]["varmensual"], 15);
		//$data[$index]["err2"] = $this->ficha->compararValor(">=", $data[$index]["varanual"], 15);
		$data[$index]["err1"] = $this->ficha->compararRango($data[$index]["varmensual"], $rango);
		$data[$index]["err2"] = $this->ficha->compararRango($data[$index]["varanual"], $rango);
		if (($data[$index]["err1"])||($data[$index]["err2"])){
			array_push($erroresIndices,30); //Se presentan errores en el indice 28 (INGVSSAL)
		}
		
		//Habitaciones ofrecidas (IHDO)
		$tabla = "rmmh_form_caracthoteles";
		$campo = "ihdo";
		$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["ihdo"]["actual"], $data["ihdo"]["anterior"]);
		$data[$campo]["varanual"] = $this->ficha->calcularVariacionAnual($data["ihdo"]["actual"], $data["ihdo"]["anual"]);
		//$data[$campo]["err1"] = $this->ficha->compararValor(">", $data[$campo]["varmensual"], 15);
		//$data[$campo]["err2"] = $this->ficha->compararValor(">", $data[$campo]["varanual"], 15);
		$data[$campo]["err1"] = $this->ficha->compararRango($data[$campo]["varmensual"], $rango); //Se compara si el valor está dentro del rango de [-15,15]
		$data[$campo]["err2"] = $this->ficha->compararRango($data[$campo]["varanual"], $rango); //Se compara si el valor está dentro del rango de [-15,15]
		if (($data[$campo]["err1"])||($data[$campo]["err2"])){
			array_push($erroresIndices,31); 
		}
		
		//Habitaciones ofrecidas (ICDA)
		$tabla = "rmmh_form_caracthoteles";
		$campo = "icda";
		$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["icda"]["actual"], $data["icda"]["anterior"]);
		$data[$campo]["varanual"] = $this->ficha->calcularVariacionAnual($data["icda"]["actual"], $data["icda"]["anual"]);
		//$data[$campo]["err1"] = $this->ficha->compararValor(">", $data[$campo]["varmensual"], 15);
		//$data[$campo]["err2"] = $this->ficha->compararValor(">", $data[$campo]["varanual"], 15);
		$data[$campo]["err1"] = $this->ficha->compararRango($data[$campo]["varmensual"], $rango); //Se compara si el valor está dentro del rango de [-15,15]
		$data[$campo]["err2"] = $this->ficha->compararRango($data[$campo]["varanual"], $rango); //Se compara si el valor está dentro del rango de [-15,15]
		if (($data[$campo]["err1"])||($data[$campo]["err2"])){
			array_push($erroresIndices,32); //Se presentan errores en el indice 1 (INALO)
		}
		
		//Habitaciones ofrecidas (IHOA)
		$tabla = "rmmh_form_caracthoteles";
		$campo = "ihoa";
		$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["ihoa"]["actual"], $data["ihoa"]["anterior"]);
		$data[$campo]["varanual"] = $this->ficha->calcularVariacionAnual($data["ihoa"]["actual"], $data["ihoa"]["anual"]);
		//$data[$campo]["err1"] = $this->ficha->compararValor(">", $data[$campo]["varmensual"], 15);
		//$data[$campo]["err2"] = $this->ficha->compararValor(">", $data[$campo]["varanual"], 15);
		$data[$campo]["err1"] = $this->ficha->compararRango($data[$campo]["varmensual"], $rango); //Se compara si el valor está dentro del rango de [-15,15]
		$data[$campo]["err2"] = $this->ficha->compararRango($data[$campo]["varanual"], $rango); //Se compara si el valor está dentro del rango de [-15,15]
		if (($data[$campo]["err1"])||($data[$campo]["err2"])){
			array_push($erroresIndices,33); //Se presentan errores en el indice 1 (INALO)
		}
		
		//Camas ocupadas o vendidas  (ICVA)
		$tabla = "rmmh_form_caracthoteles";
		$campo = "icva";
		$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["icva"]["actual"], $data["icva"]["anterior"]);
		$data[$campo]["varanual"] = $this->ficha->calcularVariacionAnual($data["icva"]["actual"], $data["icva"]["anual"]);
		//$data[$campo]["err1"] = $this->ficha->compararValor(">", $data[$campo]["varmensual"], 15);
		//$data[$campo]["err2"] = $this->ficha->compararValor(">", $data[$campo]["varanual"], 15);
		$data[$campo]["err1"] = $this->ficha->compararRango($data[$campo]["varmensual"], $rango); //Se compara si el valor está dentro del rango de [-15,15]
		$data[$campo]["err2"] = $this->ficha->compararRango($data[$campo]["varanual"], $rango); //Se compara si el valor está dentro del rango de [-15,15]
		if (($data[$campo]["err1"])||($data[$campo]["err2"])){
			array_push($erroresIndices,34); //Se presentan errores en el indice 1 (INALO)
		}
		
		//Huéspedes Residentes (IHPN)
		$tabla = "rmmh_form_caracthoteles";
		$campo = "ihpn";
		$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["ihpn"]["actual"], $data["ihpn"]["anterior"]);
		$data[$campo]["varanual"] = $this->ficha->calcularVariacionAnual($data["ihpn"]["actual"], $data["ihpn"]["anual"]);
		//$data[$campo]["err1"] = $this->ficha->compararValor(">", $data[$campo]["varmensual"], 15);
		//$data[$campo]["err2"] = $this->ficha->compararValor(">", $data[$campo]["varanual"], 15);
		$data[$campo]["err1"] = $this->ficha->compararRango($data[$campo]["varmensual"], $rango); //Se compara si el valor está dentro del rango de [-15,15]
		$data[$campo]["err2"] = $this->ficha->compararRango($data[$campo]["varanual"], $rango); //Se compara si el valor está dentro del rango de [-15,15]
		if (($data[$campo]["err1"])||($data[$campo]["err2"])){
			array_push($erroresIndices,35); //Se presentan errores en el indice 1 (INALO)
		}
		
		//Huéspedes No Residentes (IHPNR)
		$tabla = "rmmh_form_caracthoteles";
		$campo = "ihpnr";
		$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["ihpnr"]["actual"], $data["ihpnr"]["anterior"]);
		$data[$campo]["varanual"] = $this->ficha->calcularVariacionAnual($data["ihpnr"]["actual"], $data["ihpnr"]["anual"]);
		//$data[$campo]["err1"] = $this->ficha->compararValor(">", $data[$campo]["varmensual"], 15);
		//$data[$campo]["err2"] = $this->ficha->compararValor(">", $data[$campo]["varanual"], 15);
		$data[$campo]["err1"] = $this->ficha->compararRango($data[$campo]["varmensual"], $rango); //Se compara si el valor está dentro del rango de [-15,15]
		$data[$campo]["err2"] = $this->ficha->compararRango($data[$campo]["varanual"], $rango); //Se compara si el valor está dentro del rango de [-15,15]
		if (($data[$campo]["err1"])||($data[$campo]["err2"])){
			array_push($erroresIndices,36); 
		}
		
		//Total Huéspedes (HUETOT)
		$tabla = "rmmh_form_caracthoteles";
		$campo = "huetot";
		$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["huetot"]["actual"], $data["huetot"]["anterior"]);
		$data[$campo]["varanual"] = $this->ficha->calcularVariacionAnual($data["huetot"]["actual"], $data["huetot"]["anual"]);
		//$data[$campo]["err1"] = $this->ficha->compararValor(">", $data[$campo]["varmensual"], 15);
		//$data[$campo]["err2"] = $this->ficha->compararValor(">", $data[$campo]["varanual"], 15);
		$data[$campo]["err1"] = $this->ficha->compararRango($data[$campo]["varmensual"], $rango); //Se compara si el valor está dentro del rango de [-15,15]
		$data[$campo]["err2"] = $this->ficha->compararRango($data[$campo]["varanual"], $rango); //Se compara si el valor está dentro del rango de [-15,15]
		if (($data[$campo]["err1"])||($data[$campo]["err2"])){
			array_push($erroresIndices,36);
		}
		
		//Ingresos causados en el mes - THUSEN
		$tabla = "rmmh_form_caracthoteles";
		$campo = "thusen";
		$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["thusen"]["actual"], $data["thusen"]["anterior"]);
		$data[$campo]["varanual"] = $this->ficha->calcularVariacionAnual($data["thusen"]["actual"], $data["thusen"]["anual"]);
		//$data[$campo]["err1"] = $this->ficha->compararValor(">", $data[$campo]["varmensual"], 15);
		//$data[$campo]["err2"] = $this->ficha->compararValor(">", $data[$campo]["varanual"], 15);
		$data[$campo]["err1"] = $this->ficha->compararRango($data[$campo]["varmensual"], $rango); //Se compara si el valor está dentro del rango de [-15,15]
		$data[$campo]["err2"] = $this->ficha->compararRango($data[$campo]["varanual"], $rango); //Se compara si el valor está dentro del rango de [-15,15]
		if (($data[$campo]["err1"])||($data[$campo]["err2"])){
			array_push($erroresIndices,37); 
		}
		
		//Ingresos causados en el mes - THUDOB
		$tabla = "rmmh_form_caracthoteles";
		$campo = "thudob";
		$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["thudob"]["actual"], $data["thudob"]["anterior"]);
		$data[$campo]["varanual"] = $this->ficha->calcularVariacionAnual($data["thudob"]["actual"], $data["thudob"]["anual"]);
		//$data[$campo]["err1"] = $this->ficha->compararValor(">", $data[$campo]["varmensual"], 15);
		//$data[$campo]["err2"] = $this->ficha->compararValor(">", $data[$campo]["varanual"], 15);
		$data[$campo]["err1"] = $this->ficha->compararRango($data[$campo]["varmensual"], $rango); //Se compara si el valor está dentro del rango de [-15,15]
		$data[$campo]["err2"] = $this->ficha->compararRango($data[$campo]["varanual"], $rango); //Se compara si el valor está dentro del rango de [-15,15]
		if (($data[$campo]["err1"])||($data[$campo]["err2"])){
			array_push($erroresIndices,38); 
		}
		
		//Ingresos causados en el mes - THUSUI
		$tabla = "rmmh_form_caracthoteles";
		$campo = "thusui";
		$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["thusui"]["actual"], $data["thusui"]["anterior"]);
		$data[$campo]["varanual"] = $this->ficha->calcularVariacionAnual($data["thusui"]["actual"], $data["thusui"]["anual"]);
		//$data[$campo]["err1"] = $this->ficha->compararValor(">", $data[$campo]["varmensual"], 15);
		//$data[$campo]["err2"] = $this->ficha->compararValor(">", $data[$campo]["varanual"], 15);
		$data[$campo]["err1"] = $this->ficha->compararRango($data[$campo]["varmensual"], $rango); //Se compara si el valor está dentro del rango de [-15,15]
		$data[$campo]["err2"] = $this->ficha->compararRango($data[$campo]["varanual"], $rango); //Se compara si el valor está dentro del rango de [-15,15]
		if (($data[$campo]["err1"])||($data[$campo]["err2"])){
			array_push($erroresIndices,39); //Se presentan errores en el indice 1 (INALO)
		}
		
		//Ingresos causados en el mes - THUMULT
		$tabla = "rmmh_form_caracthoteles";
		$campo = "thumult";
		$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["thumult"]["actual"], $data["thumult"]["anterior"]);
		$data[$campo]["varanual"] = $this->ficha->calcularVariacionAnual($data["thumult"]["actual"], $data["thumult"]["anual"]);
		//$data[$campo]["err1"] = $this->ficha->compararValor(">", $data[$campo]["varmensual"], 15);
		//$data[$campo]["err2"] = $this->ficha->compararValor(">", $data[$campo]["varanual"], 15);
		$data[$campo]["err1"] = $this->ficha->compararRango($data[$campo]["varmensual"], $rango); //Se compara si el valor está dentro del rango de [-15,15]
		$data[$campo]["err2"] = $this->ficha->compararRango($data[$campo]["varanual"], $rango); //Se compara si el valor está dentro del rango de [-15,15]
		if (($data[$campo]["err1"])||($data[$campo]["err2"])){
			array_push($erroresIndices,40); //Se presentan errores en el indice 1 (INALO)
		}
		
		//Ingresos causados en el mes - THUOTR
		$tabla = "rmmh_form_caracthoteles";
		$campo = "thuotr";
		$data[$campo]["actual"] = $this->ficha->obtenerValorActual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anterior"] = $this->ficha->obtenerValorAnterior($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["anual"] = $this->ficha->obtenerValorAnual($tabla, $campo, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$data[$campo]["varmensual"] = $this->ficha->calcularVariacionMensual($data["thuotr"]["actual"], $data["thuotr"]["anterior"]);
		$data[$campo]["varanual"] = $this->ficha->calcularVariacionAnual($data["thuotr"]["actual"], $data["thuotr"]["anual"]);
		//$data[$campo]["err1"] = $this->ficha->compararValor(">", $data[$campo]["varmensual"], 15);
		//$data[$campo]["err2"] = $this->ficha->compararValor(">", $data[$campo]["varanual"], 15);
		$data[$campo]["err1"] = $this->ficha->compararRango($data[$campo]["varmensual"], $rango); //Se compara si el valor está dentro del rango de [-15,15]
		$data[$campo]["err2"] = $this->ficha->compararRango($data[$campo]["varanual"], $rango); //Se compara si el valor está dentro del rango de [-15,15]
		if (($data[$campo]["err1"])||($data[$campo]["err2"])){
			array_push($erroresIndices,41); //Se presentan errores en el indice 1 (INALO)
		}
		
		$data["validaerrores"] = $this->ficha->stringErrores($erroresIndices);
		$this->load->view("fichanalisis",$data);
	}
	
	public function guardarObservacion(){
		$this->load->model("control");
		$this->load->model("observacion");
		$operacion = $this->input->post("op");
		$index = $this->input->post("idx");
		$nro_orden = $this->input->post("numord");
		$nro_establecimiento = $this->input->post("numest");
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
		$nro_orden = $this->input->post("numord");
		$nro_establecimiento = $this->input->post("numest");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$observ = $this->observacion->consultarObservacion($index, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		echo $observ;
	}
	
	public function validarEnvio(){
		$this->load->helper("url");
		$this->load->model("control");
		$this->load->model("observacion");
		$nro_orden = $this->input->post("numord");
		$nro_establecimiento = $this->input->post("numest");
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