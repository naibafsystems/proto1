<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cargadir extends MX_Controller {

	public function __construct(){
        parent::__construct();
        $this->load->helper("download");
        $this->load->library("session");
        $this->load->library("danecrypt");  
    }

	public function index(){
		$this->load->model("periodo");
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$data["controller"] = "administrador";
		$data["menu"] = "adminmenu";
		$data["view"] = "cargadir";
		$this->load->view("layout",$data);	
	}
	
	public function UploadFile() {
		$this->load->model("usuario");
		$this->load->model("control");
		$this->load->model("periodo");
		$this->load->model("empresa");
		$this->load->model("directorio");
		$this->load->model("establecimiento");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$tipofile = $this->input->post("radCarga");
		$config["upload_path"] = "./uploads/";
		$config["allowed_types"] = '*';
		$config["max_size"] = 60;
		$config["max_width"] = 1024;
		$config["max_height"] = 768;
		$resultado = array(); //Contiene las lineas con el resultado de la operacion de carga del directorio
		$errs = 0; //Contador para los errores que se producen durante la lectura de registros del archivo.
		$novedad = $this->directorio->conteoDirectorio($ano_periodo, $mes_periodo); //Obtiene la novedad en la carga del directorio (5 - Primera Carga del periodo, 9 - Otras Cargas del periodo)
		$inserts = 0; //Contador para cada uno de los registros que se insertan en la B.D.
		$this->load->library("upload", $config);
		
		if ($this->upload->do_upload("txtFile")){ 
			
			// EL ARCHIVO SE LOGRO CARGAR EXITOSAMENTE EN EL SERVIDOR 
			switch($tipofile){
				case 1: //Obtener los datos del archivo de empresas
					    $upload = array('upload_data' => $this->upload->data());
						$path = $upload["upload_data"]["full_path"];
						if (file_exists($path)){
							$fp = fopen($path,"r");
							$separador = ";";
							$campos = array("nro_orden","idnit","idproraz","idnomcom","idsigla","iddirecc","idtelno","idfaxno","idaano","idpagweb","idcorreo","fk_depto","fk_mpio"); //Contiene las columnas tal cual como estan definidas en el archivo plano de empresas
							$counter = 0; //Contador de las filas del archivo *.CSV
							while ($linea = fgets($fp,1024)){ //Recorro todas las líneas del archivo
								if ($counter > 2){
									$arrayData = explode($separador, $linea);
									for ($i=0; $i<count($campos); $i++){
      									$asignacion = "\$".$campos[$i]."='".htmlspecialchars($arrayData[$i], ENT_QUOTES)."';";
      									eval($asignacion);
      								}
      								
      								//Se valida la informacion que contiene el archivo plano de empresas.
      								$res[1] = $this->directorio->validarDirectorioEmpresa(1, $nro_orden);
      								$res[2] = $this->directorio->validarDirectorioEmpresa(2, $idnit);
      								$res[3] = $this->directorio->validarDirectorioEmpresa(3, $idproraz);
      								$res[4] = $this->directorio->validarDirectorioEmpresa(4, $fk_depto);
      								$res[5] = $this->directorio->validarDirectorioEmpresa(5, $fk_mpio);
      								
      								//Recorrer el array RES y verificar que no se presentó nigún error
      								$flagDIR = true;
      								for ($k=1; $k<=count($res); $k++){
      									if ($res[$k]==false){ //Si se produjo algun error en la validacion
      										switch($k){
      											case 1:	$resultado[$errs] = "ERROR. Falla al cargar el directorio de empresas. El nro de orden ($nro_orden) ya existe.";
      													$errs++; 
      													break; 
      											case 2: $resultado[$errs] = "ERROR. Falla al cargar el directorio de empresas. El nit de la empresa ($idnit) se encuentra duplicado.";
      											        $errs++;
      											        break;
      											case 3: $resultado[$errs] = ""; //No se producen errores en esta validacion
      											        $errs++;
      											        break;        		
      											case 4: $resultado[$errs] = "ERROR. Falla al cargar el directorio de empresas. El departamento ($fk_depto) no existe.";
      											        $errs++;
      											        break;
      											case 5: $resultado[$errs] = "ERROR. Falla al cargar el directorio de empresas. El municipio ($fk_mpio) no existe.";
      											        $errs++;
      											        break;                
      										}
      										$flagDIR = false;
      										break;
      									}
      								}
      								
      								if ($flagDIR){
      									// 1) Insertar datos sobre la tabla de empresas. NO se crean usuarios, hasta tanto no se creen los establecimientos.
      									
      									$nom_empresa = strtoupper($idproraz);
      									$nom_establecimiento = strtoupper($idnomcom);
      									$this->empresa->insertarEmpresa($nro_orden, $idnit, $nom_empresa, $nom_establecimiento, $idsigla, $iddirecc, $idtelno, $idfaxno, $idaano, $idpagweb, $idcorreo, $fk_depto, $fk_mpio);
      									$inserts++;	
      								}
      								
								}
								$counter++;	
							}
						}
						else{
							echo "No existe el archivo. No se pudo subir al servidor.";
						}						
					    break;
				case 2: //Carga de archivo de establecimientos
					    $upload = array('upload_data' => $this->upload->data());
						$path = $upload["upload_data"]["full_path"];
						if (file_exists($path)){
							$fp = fopen($path,"r");
							$separador = ";";
							$campos = array("nro_orden","nro_establecimiento","idnomcom","idsigla","iddirecc","idmpio","iddepto","idtelno","idfaxno","idcorreo","fk_ciiu","fk_depto","fk_mpio","fk_sede","fk_subsede","inclusion"); //Contiene las columnas tal cual como estan definidas en el archivo plano de empresas
							$counter = 0; //Contador de las filas del archivo *.CSV
							while ($linea = fgets($fp,1024)){ //Recorro todas las líneas del archivo
								if ($counter > 2){
									$arrayData = explode($separador, $linea);
									for ($i=0; $i<count($campos); $i++){
      									$asignacion = "\$".$campos[$i]."='".htmlspecialchars($arrayData[$i], ENT_QUOTES)."';";
      									eval($asignacion);
      								}
      								//Se valida la informacion que contiene el archivo plano de establecimientos.
      								$res[1] = $this->directorio->validarDirectorioEstablecimientos(1, $nro_orden);
      								//$res[2] = $this->directorio->validarDirectorioEstablecimientos(2, $nro_establecimiento);
      								$res[2] = $this->directorio->validarEstablecimientoPeriodo($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
      								$res[3] = $this->directorio->validarDirectorioEstablecimientos(3, $idmpio);
      								$res[4] = $this->directorio->validarDirectorioEstablecimientos(4, $iddepto);
      								$res[5] = $this->directorio->validarDirectorioEstablecimientos(5, $fk_ciiu);
      								$res[6] = $this->directorio->validarDirectorioEstablecimientos(6, $fk_sede);
      								$res[7] = $this->directorio->validarDirectorioEstablecimientos(7, $fk_subsede);
      								$res[8] = $this->directorio->validarDirectorioEstablecimientos(8, $inclusion);
      								
      								//Recorrer el array RES y verificar que no se presentó nigún error
      								$flagDIR = true;
      								for ($k=1; $k<=count($res); $k++){
      									if ($res[$k]==false){
      										switch($k){
      											case 1: $resultado[$errs] = "ERROR. Falla al cargar el directorio de establecimientos. El nro de orden ($nro_orden) no existe.";
      											        $errs++;
      													break;
      											case 2: $resultado[$errs] = "ERROR. Falla al cargar el directorio de establecimientos. El nro de establecimiento ($nro_establecimiento) ya se encuentra registrado.";
      											        $errs++;
      												    break;
      											case 3: $resultado[$errs] = "ERROR. Falla al cargar el directorio de establecimientos. El codigo de municipio ($idmpio) no existe.";
      													$errs++;
      													break;
      											case 4: $resultado[$errs] = "ERROR. Falla al cargar el directorio de establecimientos. El codigo de departamento ($iddepto) no existe.";
      											        $errs++;
      													break;
      											case 5: $resultado[$errs] = "ERROR. Falla al cargar el directorio de establecimientos. El codigo de actividad ciiu ($fk_ciiu) no existe.";
      													$errs++;
      													break;
      											case 6: $resultado[$errs] = "ERROR. Falla al cargar el directorio de establecimientos. El codigo de la sede ($fk_sede) no existe.";
      											        $errs++;
      												    break;
      											case 7: $resultado[$errs] = "ERROR. Falla al cargar el directorio de establecimientos. El codigo de la subsede ($fk_subsede) no existe.";
      											        $errs++;
      												    break;
      											case 8: $resultado[$errs] = "ERROR. Falla al cargar el directorio de establecimientos. El codigo de inclusion ($inclusion) no existe.";	    
      										}
      										$flagDIR = false;
      										break;
      									}
      								}
      								if ($flagDIR){
      									// 1) Insertar datos sobre la tabla de establecimientos
      									// Valido si el establecimiento ya existe, no lo creo.
      									if (!$this->establecimiento->validarEstablecimiento($nro_orden, $nro_establecimiento)){ //Si no existe el establecimiento, se crea un nuevo registro del establecimiento
      										$this->establecimiento->insertarEstablecimiento($nro_orden, $nro_establecimiento, $idnomcom, $idsigla, $iddirecc, $idmpio, $iddepto, $idtelno, $idfaxno, $idcorreo, $fk_ciiu, $fk_depto, $fk_mpio, $fk_sede, $fk_subsede);		
      									}
      									
      									// 2) Insertar datos sobre la tabla de usuarios      
      									// Valido su el usuario ya existe, no lo creo.									
      									if (!$this->usuario->validarUsuario($nro_orden, $nro_establecimiento)){
      										// 	Si el usuario no existe se ingresa el usuario y me retorna el IDUltimoInsertado.
      										$login = "F".$nro_establecimiento;
      										$password = $this->danecrypt->generarPassword();
      										$nitEmpresa = $this->empresa->obtenerNITEmpresa($nro_orden);
      										$this->usuario->insertarUsuario($nitEmpresa,strtoupper($idnomcom), $login, $password, $idcorreo, date("Y-m-d h:i:s"), date("Y-m-d h:i:s"), $nro_orden, $nro_establecimiento, 1, 1, $fk_sede, $fk_subsede);
      										$usuario = $this->usuario->IDUltimoInsertado();
      									}
      									else{
      										// Si el usuario ya existe no se crea, y debe devolverme el ID del usuario.
      										$usuario = $this->usuario->obtenerIDUsuario($nro_orden, $nro_establecimiento);
      									}	
      									
      									
      									// 3) Insertar datos sobre la tabla de control
      									//Estoy obteniendo los datos desde la sesion. Por tanto hay que tener en cuenta en que mes estoy haciendo la carga de los archivos. 
      									$ano_periodo = $this->session->userdata("ano_periodo");
      									$mes_periodo = $this->session->userdata("mes_periodo");
      									$this->control->insertarControl($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 1, 0, 0, 0, 0, 0, $inclusion, 'A', $novedad, 0, $fk_sede, $fk_subsede, 0, 0);
      									$inserts++;
      								}
      								
								}
								$counter++;
							}	
						}
						else{
							echo "No existe el archivo. No se pudo subir al servidor.";
						}
					    break;
			}
			
			$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
			$data["controller"] = "administrador";
			$data["menu"] = "adminmenu";
			$data["view"] = "resultados";
			$data["errores"] = $resultado;
			$data["inserts"] = $inserts;
			$this->load->view("layout",$data);
		}
		else{
			// SE PRODUJERON ERRORES - NO SE PUDO CARGAR EL ARCHIVO 
			$error = array('error' => $this->upload->display_errors());			
		}		
	}
	
	//Descarga el manual para la carga del directorio con archivo CSV
	public function descargaManualCSV(){		
		$file = "./res/confcarga.pdf";
		if (file_exists($file)){
			$data = file_get_contents($file); // Read the file's contents
			$name = 'manual.pdf';
			force_download($name, $data); 
		}
		else{
			die("<h3>ERROR: NO se ha podido descargar el archivo del formulario. No existe el archivo. Consulte con su administrador</h3>");
			exit(-1);
		}
	}
	
	//Descarga el modelo de archivo CSV para la carga del directorio de empresas
	public function descargaArchivoEmpresasCSV(){		
		$file = "./res/empresas.csv";
		if (file_exists($file)){
			$data = file_get_contents($file); // Read the file's contents
			$name = 'empresas.csv';
			force_download($name, $data); 
		}
		else{
			die("<h3>ERROR: NO se ha podido descargar el archivo del formulario. No existe el archivo. Consulte con su administrador</h3>");
			exit(-1);
		}
	}
	
	//Descarga el modelo de archivo CSV para la carga del directorio de establecimientos
	public function descargaArchivoEstablecimientosCSV(){		
		$file = "./res/establecimientos.csv";
		if (file_exists($file)){
			$data = file_get_contents($file); // Read the file's contents
			$name = 'establecimientos.csv';
			force_download($name, $data); 
		}
		else{
			die("<h3>ERROR: NO se ha podido descargar el archivo del formulario. No existe el archivo. Consulte con su administrador</h3>");
			exit(-1);
		}
	}
	
	
	
}//EOC