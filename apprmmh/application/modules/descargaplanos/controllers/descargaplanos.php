<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controlador para el modulo de administracion de RMMH
 * @author Daniel Mauricio D�az Forero - DMDiazF
 * @since  Julio 17 de 2012
 */


class Descargaplanos extends MX_Controller {
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
	
	//Funcion principal. Se ejecuta por defecto al cargar el controlador (Muestra la funcion Directorio)
	public function index(){		
		
		$this->load->model("periodo");
		$data["controller"] = "administrador";
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==4){
			$data['tipo_usuario']="ADMINISTRADOR";
		}
		$data["nom_usuario"] = $nom_usuario;
		$data["view"] = "administrador";
		$data["menu"] = "adminmenu";
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
		redirect('/administrador', 'location', 301);
	}
	
		
	public function descargarPlanos(){
		$this->load->model("usuario");
		$this->load->model("periodo");
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		
		if($tipo_usuario==4){
			$data['tipo_usuario']="ADMINISTRADOR";
			$data["menu"] = "adminmenu";
		}
		elseif($tipo_usuario==5){
			$data['tipo_usuario']="LOGISTICA";
			$data["menu"] = "logmenu";
		}
		$data["nom_usuario"] = $nom_usuario;
		$data["controller"] = "administrador";
		$this->load->model("divipola");
		$data["view"] = "descargaplanos";
		$data["anios"] = $this->divipola->obtenerAnios();
		$this->load->view("layout",$data);
	}
	
	public function descargaPlanosXLS($modulo){
		$this->load->model("sede");
		$this->load->model("subsede");
		$this->load->model("divipola");
		$this->load->model("modulo1");
		$this->load->model("modulo2");
		$this->load->model("modulo3");
		$this->load->model("modulo4");
		$this->load->model("envioform");
		$this->load->model("observacion");
		$this->load->model("novedad");
		$this->load->model("usuario");
		$this->load->model("consolidado");
		$this->load->library("danecrypt");
		$data = array();
		$nomfile = "";
		
		/**
		 * Pedazo de c�digo para armmar un arreglo desde un bucle
		 * @author SJNEIRAG
		 * @since Julio 2015
		 */
		$per="0,0";
		//Para descargar planos hist�ricos
		if(isset($_REQUEST['anio'])){
			$ano_periodo=$_REQUEST['anio'];
			$variableVacia=0; //Variable igual a 0 pra armar el array
			foreach ($_REQUEST as $clave => $value) {
				$claves = substr($clave, 0, -1); //Asigno a la variable solamente lo que comience por mes y mes1.
				if($claves=='per' || $claves=='per1') //Condiciono para filtar lo que comience por per y per1.
				{
					$variableVacia=$variableVacia.",".$value; //Aqu� armo el array con el contenido de $variableVacia.
					$per=$variableVacia; // Asigno el array a una variable ($per)
				}
			}
		}
		else{	 	
			$ano_periodo = $this->session->userdata("ano_periodo");
		}
		if(isset($_REQUEST['anio'])){
			$mes_periodo=substr($per,2); //Le quito lo que asign� la $variableVacia, para que solamente mande los meses selccionados en el formulario para la consulta.
		}
		else{
			$mes_periodo = $this->session->userdata("mes_periodo");
		} 

		/**
		 * ******************************************************
		 */
		
		//Este array me retorna la letra correspondiente de cada columna del excel -- Solo va hasta "CZ". Si se necesitan mas hay que agregarlas en el array.
		$arrayLetters = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z", 
		                      "AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ","AR","AS","AT","AU","AV","AW","AX","AY","AZ",
		                      "BA","BB","BC","BD","BE","BF","BG","BH","BI","BJ","BK","BL","BM","BN","BO","BP","BQ","BR","BS","BT","BU","BV","BW","BX","BY","BZ",
		                      "CA","CB","CC","CD","CE","CF","CG","CH","CI","CJ","CK","CL","CM","CN","CO","CP","CQ","CR","CS","CT","CU","CV","CW","CX","CY","CZ",
							  "DA","DB","DC","DD","DE","DF","DG","DH","DI","DJ","DK","DL","DM","DN","DO","DP","DQ","DR","DS","DT","DU","DV","DW","DX","DY","DZ");
		switch($modulo){
			case 1: //Descarga de planos en excel para el modulo I
				    $nomfile = "modulo1.xls";
					$headers = array("ano_periodo","mes_periodo","nro_orden","nro_establecimiento","ulocal","idnit","idproraz","idnomcom","idsigla","idact","iddirecc","iddepto","nom_depto","idmpio","nom_mpio","idtelno","idfaxno","idpagweb","idcorreo","finicial","ffinal",
                                     "idnomcomest","idsiglaest","iddireccest","iddeptoest","nom_deptoest","idmpioest","nom_mpioest","idtelnoest","idfaxnoest","idcorreoest","fk_novedad","fk_sede","nom_sede","fk_subsede","nom_subsede","fk_estado","estado");				    
					$data = $this->modulo1->descargaPlanosModulo($ano_periodo, $mes_periodo);
				    break;
				    
			case 2: //Descarga de planos en excel para el modulo II
				    $nomfile = "modulo2.xls";
				    $headers = array("nro_orden", "nro_establecimiento", "ano_periodo", "mes_periodo","idact","potpsfr","potperm","gpper","pottcde","gpssde","pottcag","gpppta","potpau","gppgpa","pottot","gpsspot","fk_novedad","fk_estado","estado");
				    $data = $this->modulo2->descargaPlanosModulo($ano_periodo, $mes_periodo);
				    break;
				    
			case 3: //Modulo III
				    $nomfile = "modulo3.xls";
				    $headers = array("nro_orden","nro_establecimiento","ano_periodo","mes_periodo","idact","inalo","inali","inba","insr","inoe","inoio","intio","fk_novedad","fk_estado","estado");
				    $data = $this->modulo3->descargaPlanosModulo($ano_periodo, $mes_periodo);
				    break;
				    
			case 4: //Modulo IV
				    $nomfile = "modulo4.xls";
				    $headers = array("nro_orden", "nro_establecimiento", "ano_periodo", "mes_periodo","idact","habdia","ihdo","ihoa","camdia","icda","icva","ihpn","ihpnr","huetot","mvnr","mvcr","mvor","mvsr","mvotr","mvott", "mvnnr", "mvcnr", "mvonr", 
				                     "mvsnr", "mvotnr", "mvottnr", "thsen", "thusen", "thdob", "thudob", "thsui", "thusui", "thmult", "thumult", "thotr", "thuotr", "thtot", "ingsen", "ingdob", "ingsui", "ingmult", "ingotr", "ingtot", 
				                     "tphto", "inalosen", "inalodob", "inalosui", "inalomul", "inalootr", "inalotot","fk_novedad","fk_estado","estado");
				    $data = $this->modulo4->descargaPlanosModulo($ano_periodo, $mes_periodo);
				    break;
				    				    
			case 5: //Descarga de Novedades
				    $nomfile = "novedades.xls";
				    $headers = array("nro_orden","nro_establecimiento","ano_periodo","mes_periodo","fk_critico","fecha_visita","estado_empresa","consulta_camara","fk_novedad","nom_novedad","nom_func","tel_func","cargo_func","obs_critico","fk_coordinador","aceptada","obs_coordinador");
				    $data = $this->novedad->descargaPlanosNovedades($ano_periodo, $mes_periodo);
				    break;
				    
			case 6: //Descarga de observaciones
				    $nomfile = "observaciones.xls";
				    $headers = array("nro_orden", "nro_establecimiento", "ano_periodo", "mes_periodo", "fecha", "modulo", "nom_modulo", "descripcion", "fk_novedad", "fk_estado","estado");
				    $data = $this->observacion->descargaPlanosObservaciones($ano_periodo, $mes_periodo);
				    break;	    
				    	    
			case 0: //Envio del formulario
					$nomfile = "envioform.xls";
				    $headers = array("nro_orden", "nro_establecimiento", "ano_periodo", "mes_periodo","observaciones", "dmpio", "fedili", "repleg", "responde", "respoca", "teler", "emailr", "fk_novedad","fk_estado","estado");
					$data = $this->envioform->descargaPlanosModulo($ano_periodo, $mes_periodo);
				    break;
			case 7: //Descarga consolidado modulo II
					$nomfile = "consolidadoModulo2.xls";
					$headers = array("nro_orden", "nro_establecimientos", "ano_periodo", "mes_periodo","potpsfr","potperm","gpper","pottcde","gpssde","pottcag","gpppta","potpau","gppgpa","pottot","gpsspot");
					$data = $this->modulo2->descargaPlanosConsolidado($ano_periodo, $mes_periodo);
					break;
			case 8: //Descarga consolidado modulo III
					$nomfile = "consolidadoModulo3.xls";
					$headers = array("nro_orden","nro_establecimientos","ano_periodo","mes_periodo","inalo","inali","inba","insr","inoe","inoio","intio");
					$data = $this->modulo3->descargaPlanosConsolidado($ano_periodo, $mes_periodo);
					break;
			case 9: //Descarga consolidado modulo IV
					$nomfile = "consolidadoModulo4.xls";
					$headers = array("nro_orden","nro_establecimientos","ano_periodo","mes_periodo","ihdo","ihoa","icda","icva","ihpn","ihpnr","huetot","thsen","thusen","thdob","thudob","thsui","thusui","thmult","thumult","thotr","thuotr","thtot","mvnr","mvnnr","mvcr","mvcnr","mvor","mvonr","mvsr","mvsnr","mvotr","mvotnr","mvott","mvottnr");
					$data = $this->modulo4->descargaPlanosConsolidado($ano_periodo, $mes_periodo);
					break;
			case 10: //Descarga hist�rico consolidado todos los modulos
					$nomfile = "consolidadoModulos.xls";
					$headers = array("nro_orden","nro_establecimiento","ano_periodo","mes_periodo","potpsfr","potperm","gpper","pottcde","gpssde","pottcag","gpppta","potpau",
									"gppgpa","pottot","gpsspot","inalo","inali","inba","insr","inoe","inoio","intio","ihdo","ihoa","icda","icva","ihpn","ihpnr","huetot","mvnr",
									"mvcr","mvor","mvsr","mvotr","mvott","mvnnr","mvcnr","mvonr","mvsnr","mvotnr","mvottnr","thsen","thusen","thdob","thudob","thsui","thusui","thmult",
									"thumult","thotr","thuotr","thtot");
					$data = $this->consolidado->descargaPlanosConsolidado($ano_periodo, $mes_periodo);
					break;
			case 11: //Descarga consolidado por empresa
				$nomfile = "consolidadoModulosEmpresa.xls";
				$headers = array("nro_orden","nro_establecimientos","ano_periodo","mes_periodo","potpsfr","potperm","gpper","pottcde","gpssde","pottcag","gpppta","potpau",
						"gppgpa","pottot","gpsspot","inalo","inali","inba","insr","inoe","inoio","intio","ihdo","ihoa","icda","icva","ihpn","ihpnr","huetot","mvnr","mvnnr",
						"mvcr","mvcnr","mvor","mvonr","mvsr","mvsnr","mvotr","mvotnr","mvott","mvottnr","thsen","thusen","thdob","thudob","thsui","thusui","thmult",
						"thumult","thotr","thuotr","thtot");
				$data = $this->consolidado->descargaPlanosConsolidadoEmpresa($ano_periodo, $mes_periodo);
				break;
		}
		
		$this->load->model("usuario");
		$usuarios = $this->usuario->reportePasswords();
		$sheet = $this->phpexcel->getActiveSheet();
		
		//Poner los encabezados del excel
		$styleArray = array('font' => array('bold' => true, 'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE ));
		for ($i=0; $i<count($headers); $i++){
			$columna = $arrayLetters[$i]."1";
			$sheet->setCellValue($columna,$headers[$i]);
			$sheet->getStyle($columna)->applyFromArray($styleArray);		
		}
		
		//Poner todos los datos del excel
		//Recorrer todos los registros de los datos del usuario
		for ($x=0; $x<count($data); $x++){
			//Recorrer todos los registros de los datos de los encabezados
			for ($y=0; $y<count($headers); $y++){
				$letra = $arrayLetters[$y].($x+2);
				$sheet->setCellValue($letra,$data[$x][$headers[$y]]);
			}
		}
		
		$writer = new PHPExcel_Writer_Excel5($this->phpexcel);		
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=$nomfile"); //En caso de fallas por demasiado tama�o del archivo eliminar esta linea.		
		$writer->save('php://output');		
	}
	
	//Descarga del plano en Excel para el modulo 5 de la CIIU
	public function descargaPlanosMOD5(){
		$this->load->model("modulo5");
		$nomfile = "modulo5.xls";
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$styleArray = array('font' => array('bold' => true, 'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE));
		$sheet = $this->phpexcel->getActiveSheet();
		$sheet->setCellValue("A2","Nro. Orden");
		$sheet->getStyle("A2")->applyFromArray($styleArray);
		$sheet->setCellValue("B2","Nro. Establecimiento");
		$sheet->getStyle("B2")->applyFromArray($styleArray);
		$sheet->setCellValue("C2","Nombre Establecimiento");
		$sheet->getStyle("C2")->applyFromArray($styleArray);
		$sheet->setCellValue("D2","Habitaciones privadas con bano");
		$sheet->getStyle("D2")->applyFromArray($styleArray);
		$sheet->setCellValue("E2","Areas Sociales");
		$sheet->getStyle("E2")->applyFromArray($styleArray);
		$sheet->setCellValue("F2","Bar");
		$sheet->getStyle("F2")->applyFromArray($styleArray);
		$sheet->setCellValue("G2","Restaurante");
		$sheet->getStyle("G2")->applyFromArray($styleArray);
		$sheet->setCellValue("H2","Piscina");
		$sheet->getStyle("H2")->applyFromArray($styleArray);
		$sheet->setCellValue("I2","Salon para eventos");
		$sheet->getStyle("I2")->applyFromArray($styleArray);
		$sheet->setCellValue("J2","Parqueadero");
		$sheet->getStyle("J2")->applyFromArray($styleArray);
		$sheet->setCellValue("K2","Botones");
		$sheet->getStyle("K2")->applyFromArray($styleArray);
		$sheet->setCellValue("L2","Camarera");
		$sheet->getStyle("L2")->applyFromArray($styleArray);
		$sheet->setCellValue("M2","Room Service");
		$sheet->getStyle("M2")->applyFromArray($styleArray);
		$sheet->setCellValue("N2","Servicio de Recepcion");
		$sheet->getStyle("N2")->applyFromArray($styleArray);
		$sheet->setCellValue("O2","Otros Hoteles");
		$sheet->getStyle("O2")->applyFromArray($styleArray);
		
		$sheet->setCellValue("P2","Apartamentos Independientes");
		$sheet->getStyle("P2")->applyFromArray($styleArray);
		$sheet->setCellValue("Q2","Bano Privado en el apartamento");
		$sheet->getStyle("Q2")->applyFromArray($styleArray);
		$sheet->setCellValue("R2","Sala de estar en el apartamento");
		$sheet->getStyle("R2")->applyFromArray($styleArray);
		$sheet->setCellValue("S2","Cocina equipada en el apartamento");
		$sheet->getStyle("S2")->applyFromArray($styleArray);
		$sheet->setCellValue("T2","Comedor en el apartamento");
		$sheet->getStyle("T2")->applyFromArray($styleArray);
		$sheet->setCellValue("U2","Parqueadero");
		$sheet->getStyle("U2")->applyFromArray($styleArray);
		$sheet->setCellValue("V2","Botones");
		$sheet->getStyle("V2")->applyFromArray($styleArray);
		$sheet->setCellValue("W2","Camarera");
		$sheet->getStyle("W2")->applyFromArray($styleArray);
		$sheet->setCellValue("X2","Room Service");
		$sheet->getStyle("X2")->applyFromArray($styleArray);
		$sheet->setCellValue("Y2","Servicio de Recepcion");
		$sheet->getStyle("Y2")->applyFromArray($styleArray);
		$sheet->setCellValue("Z2","Habitaciones con Bano Privado");
		$sheet->getStyle("Z2")->applyFromArray($styleArray);
		$sheet->setCellValue("AA2","Restaurante");
		$sheet->getStyle("AA2")->applyFromArray($styleArray);
		$sheet->setCellValue("AB2","Bar");
		$sheet->getStyle("AB2")->applyFromArray($styleArray);
		$sheet->setCellValue("AC2","Areas sociales");
		$sheet->getStyle("AC2")->applyFromArray($styleArray);
		$sheet->setCellValue("AD2","Otro aparta hoteles");
		$sheet->getStyle("AD2")->applyFromArray($styleArray);
		
		$sheet->setCellValue("AE2","Habitaciones o Apartamentos con Bano Privado");
		$sheet->getStyle("AE2")->applyFromArray($styleArray);
		$sheet->setCellValue("AF2","Locales y servicios comunes para la practica de deportes");
		$sheet->getStyle("AF2")->applyFromArray($styleArray);
		$sheet->setCellValue("AG2","Locales y servicios comunes para la practica de actividades recreativas");
		$sheet->getStyle("AG2")->applyFromArray($styleArray);
		$sheet->setCellValue("AH2","Areas Sociales");
		$sheet->getStyle("AH2")->applyFromArray($styleArray);
		$sheet->setCellValue("AI2","Bar");
		$sheet->getStyle("AI2")->applyFromArray($styleArray);
		$sheet->setCellValue("AJ2","Restaurante");
		$sheet->getStyle("AJ2")->applyFromArray($styleArray);
		$sheet->setCellValue("AK2","Piscina");
		$sheet->getStyle("AK2")->applyFromArray($styleArray);
		$sheet->setCellValue("AL2","Parqueadero");
		$sheet->getStyle("AL2")->applyFromArray($styleArray);
		$sheet->setCellValue("AM2","Botones");
		$sheet->getStyle("AM2")->applyFromArray($styleArray);
		$sheet->setCellValue("AN2","Camarera");
		$sheet->getStyle("AN2")->applyFromArray($styleArray);
		$sheet->setCellValue("AO2","Room Service");
		$sheet->getStyle("AO2")->applyFromArray($styleArray);
		$sheet->setCellValue("AP2","Servicio de recepcion");
		$sheet->getStyle("AP2")->applyFromArray($styleArray);
		$sheet->setCellValue("AQ2","Otro centros vacacionales");
		$sheet->getStyle("AQ2")->applyFromArray($styleArray);
				
		$sheet->setCellValue("AR2","Unidades habitacionales con bano privado");
		$sheet->getStyle("AR2")->applyFromArray($styleArray);
		$sheet->setCellValue("AS2","Unidades habitacionales sin bano privado");
		$sheet->getStyle("AS2")->applyFromArray($styleArray);
		$sheet->setCellValue("AT2","Posadas turisticas");
		$sheet->getStyle("AT2")->applyFromArray($styleArray);
		$sheet->setCellValue("AU2","Ecohabs");
		$sheet->getStyle("AU2")->applyFromArray($styleArray);
		$sheet->setCellValue("AV2","Fincas Turisticas");
		$sheet->getStyle("AV2")->applyFromArray($styleArray);
		$sheet->setCellValue("AW2","Bano Comun");
		$sheet->getStyle("AW2")->applyFromArray($styleArray);
		$sheet->setCellValue("AX2","Areas Sociales");
		$sheet->getStyle("AX2")->applyFromArray($styleArray);
		$sheet->setCellValue("AY2","Restaurante");
		$sheet->getStyle("AY2")->applyFromArray($styleArray);
		$sheet->setCellValue("AZ2","Servicio de Recepcion");
		$sheet->getStyle("AZ2")->applyFromArray($styleArray);
		$sheet->setCellValue("BA2","Concesiones con parques naturales");
		$sheet->getStyle("BA2")->applyFromArray($styleArray);
		$sheet->setCellValue("BB2","Permite el desarrollo de actividades asociadas a su entorno natural y cultural");
		$sheet->getStyle("BB2")->applyFromArray($styleArray);
		$sheet->setCellValue("BC2","Otro alojamiento rural");
		$sheet->getStyle("BC2")->applyFromArray($styleArray);
		
		$sheet->setCellValue("BD2","Habitaciones privadas con bano");
		$sheet->getStyle("BD2")->applyFromArray($styleArray);
		$sheet->setCellValue("BE2","Habitaciones compartidas");
		$sheet->getStyle("BE2")->applyFromArray($styleArray);
		$sheet->setCellValue("BF2","Habitaciones privadas sin bano");
		$sheet->getStyle("BF2")->applyFromArray($styleArray);
		$sheet->setCellValue("BG2","Bano Comun");
		$sheet->getStyle("BG2")->applyFromArray($styleArray);
		$sheet->setCellValue("BH2","Areas Sociales");
		$sheet->getStyle("BH2")->applyFromArray($styleArray);
		$sheet->setCellValue("BI2","Cocina comun");
		$sheet->getStyle("BI2")->applyFromArray($styleArray);
		$sheet->setCellValue("BJ2","Restaurante");
		$sheet->getStyle("BJ2")->applyFromArray($styleArray);
		$sheet->setCellValue("BK2","Servicio de Recepcion");
		$sheet->getStyle("BK2")->applyFromArray($styleArray);
		$sheet->setCellValue("BL2","Camarera");
		$sheet->getStyle("BL2")->applyFromArray($styleArray);
		$sheet->setCellValue("BM2","Otro hostales");
		$sheet->getStyle("BM2")->applyFromArray($styleArray);
		
		$sheet->setCellValue("BN2","Forman parte de un conjunto funcional, cerrado, con aprovechamiento comun de los servicios");
		$sheet->getStyle("BN2")->applyFromArray($styleArray);
		$sheet->setCellValue("BO2","Lugar destinado a la instalacion de carpas");
		$sheet->getStyle("BO2")->applyFromArray($styleArray);
		$sheet->setCellValue("BP2","Instalaciones para instalar hamacas");
		$sheet->getStyle("BP2")->applyFromArray($styleArray);
		$sheet->setCellValue("BQ2","Bano Comun");
		$sheet->getStyle("BQ2")->applyFromArray($styleArray);
		$sheet->setCellValue("BR2","Otro camping");
		$sheet->getStyle("BR2")->applyFromArray($styleArray);
		
		//Obtener los datos de la consulta
		$data = $this->modulo5->descargaPlanosModulo($ano_periodo, $mes_periodo);
		
		for ($i=0; $i<count($data); $i++){
			$sheet->setCellValue("A".($i+3),$data[$i]["nro_orden"]);
			$sheet->setCellValue("B".($i+3),$data[$i]["nro_establecimiento"]);
			$sheet->setCellValue("C".($i+3),$data[$i]["idnomcom"]);
	        
			//Romper cada una de las variables de las categorias
			for ($x=0; $x<strlen($data[$i]["hoteles"]); $x++){
				$arrayLetters = array("D","E","F","G","H","I","J","K","L","M","N","O");
				$sheet->setCellValue($arrayLetters[$x]."1","HOTELES");
				$sheet->getStyle($arrayLetters[$x]."1")->applyFromArray($styleArray);
				$sheet->setCellValue($arrayLetters[$x].($i+3),substr($data[$i]["hoteles"],$x,1));  
			}
			for ($x=0; $x<strlen($data[$i]["apartahoteles"]); $x++){
				$arrayLetters = array("P","Q","R","S","T","U","V","W","X","Y","Z","AA","AB","AC","AD");
				$sheet->setCellValue($arrayLetters[$x]."1","APARTA-HOTELES");
				$sheet->getStyle($arrayLetters[$x]."1")->applyFromArray($styleArray);
				$sheet->setCellValue($arrayLetters[$x].($i+3),substr($data[$i]["apartahoteles"],$x,1));  
			}
			for ($x=0; $x<strlen($data[$i]["cenvacacionales"]); $x++){
				$arrayLetters = array("AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ");
				$sheet->setCellValue($arrayLetters[$x]."1","CENTROS VACACIONALES");
				$sheet->getStyle($arrayLetters[$x]."1")->applyFromArray($styleArray);
				$sheet->setCellValue($arrayLetters[$x].($i+3),substr($data[$i]["cenvacacionales"],$x,1));  
			}
			for ($x=0; $x<strlen($data[$i]["alojarural"]); $x++){
				$arrayLetters = array("AR","AS","AT","AU","AV","AW","AX","AY","AZ","BA","BB","BC");
				$sheet->setCellValue($arrayLetters[$x]."1","ALOJAMIENTOS RURALES");
				$sheet->getStyle($arrayLetters[$x]."1")->applyFromArray($styleArray);
				$sheet->setCellValue($arrayLetters[$x].($i+3),substr($data[$i]["alojarural"],$x,1));  
			}
			for ($x=0; $x<strlen($data[$i]["hostales"]); $x++){
				$arrayLetters = array("BD","BE","BF","BG","BH","BI","BJ","BK","BL","BM");
				$sheet->setCellValue($arrayLetters[$x]."1","HOSTALES");
				$sheet->getStyle($arrayLetters[$x]."1")->applyFromArray($styleArray);
				$sheet->setCellValue($arrayLetters[$x].($i+3),substr($data[$i]["hostales"],$x,1)); 
			}
			for ($x=0; $x<strlen($data[$i]["zonacamp"]); $x++){
				$arrayLetters = array("BN","BO","BP","BQ","BR");
				$sheet->setCellValue($arrayLetters[$x]."1","ZONAS DE CAMPING");
				$sheet->getStyle($arrayLetters[$x]."1")->applyFromArray($styleArray);
				$sheet->setCellValue($arrayLetters[$x].($i+3),substr($data[$i]["zonacamp"],$x,1));  
			}						
		}
		
		$writer = new PHPExcel_Writer_Excel5($this->phpexcel);		
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=$nomfile"); //En caso de fallas por demasiado tama�o del archivo eliminar esta linea.		
		$writer->save('php://output');
	}
	
	
	
		
	//Cierra la sesion del usuario cuando se da click en la opcion salir del menu	
	public function cerrarSesion(){
		$this->load->helper("url");
		$this->load->library("session");
		$this->session->sess_destroy();
		redirect("login","refresh");
	}
	
				
	//Muestra el consolidado de los m�dulos II, III y IV para las empresas.)
	public function mostrarConsolidado($nro_orden){
		$this->load->model("control");
		$this->load->model("periodo");
		$this->load->model("usuario");
		$this->load->model("consolidado");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$tipoUsuario=$this->session->userdata("tipo_usuario");
		$data["empresa"] = $this->usuario->obtenerNombreEmpresa($nro_orden, $ano_periodo, $mes_periodo);
		$data["modulo2"] = $this->consolidado->obtenerModulo2($nro_orden, $ano_periodo, $mes_periodo);
		$data["modulo3"] = $this->consolidado->obtenerModulo3($nro_orden, $ano_periodo, $mes_periodo);
		$data["modulo4"] = $this->consolidado->obtenerModulo4($nro_orden, $ano_periodo, $mes_periodo);
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		
		$data["nom_usuario"] = $nom_usuario;
		$data["nro_orden"] = $nro_orden;
		$data["controller"] = "logistica";
		
		//Muestra el menu dependiendo del rol del usuario. 4 administrador
		if($tipoUsuario==4){
			$data["menu"] = "adminmenu";
			$data['tipo_usuario']="ADMINISTRADOR";
		}
		elseif($tipoUsuario==6){
			$data["menu"] = "tematicamenu";
			$data['tipo_usuario']="TEMATICO";
		}
		else{
			$data["menu"] = "logmenu";
			$data['tipo_usuario']="LOGISTICA";
		}
		$data["view"] = "consolidadoEmpresa";
		
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$this->load->view("layout",$data);
	}

}//EOC
	
	
?>