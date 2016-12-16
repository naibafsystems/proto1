<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controlador para el modulo de administracion de RMMH
 * @author Daniel Mauricio Dï¿½az Forero - DMDiazF
 * @since  Julio 17 de 2012
 */


class Administrador extends MX_Controller {
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
	
	//Ejecuta la funcion del directorio del menu del administrador.
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
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==4){
			$data['tipo_usuario']="ADMINISTRADOR";
		}
		$data["nom_usuario"] = $nom_usuario;
		$data["controller"] = "administrador";
		$data["menu"] = "adminmenu";
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
		$config["base_url"] = site_url("administrador/directorio");
		$config["total_rows"] = $this->directorio->contarFuentes($data["ano_periodo"], $data["mes_periodo"]); //Obtener el numero total de registros que debe procesar el paginador
		$config["per_page"] = 50;   //Cantidad de registros por pagina que debe mostrar el paginador
		$config["num_links"] = 5;  //Cantidad de links para cambiar de pï¿½gina que va a mostrar el paginador.
		$config["first_link"] = "Primero";
		$config["last_link"] = "&Uacute;ltimo";
		$config["use_page_numbers"] = TRUE;
		$this->pagination->initialize($config);
		
		//Trabajo de paginacion
		$pagina = ($this->uri->segment(3))?$this->uri->segment(3):1; //Si esta definido un valor por get, utilice el valor, de lo contrario utilice cero (para el primer valor a mostrar).
		$desde = ($pagina - 1) * $config["per_page"];
		$data["fuentes"] = $this->directorio->obtenerFuentes($data["ano_periodo"], $data["mes_periodo"], $desde, $config["per_page"]);
		$data["links"] = $this->pagination->create_links();
		$this->load->view("layout",$data);
	}
	
	public function cargaDirectorio(){
		echo Modules::run('carga_directorio/cargadir/index');
	}
	
	
	/******
	//Ejecuta la carga automatica del directorio desde el archivo *.csv (Se carga un archivo plano con datos de las fuentes a cargar en la encuesta)
	public function cargarDirectorio(){
		$this->load->model("control");
		$this->load->model("usuario");
		$this->load->model("directorio");
		$config["upload_path"] = "./uploads/";
		$config["allowed_types"] = '*';
		$config["max_size"] = 60;
		$config["max_width"] = 1024;
		$config["max_height"] = 768;
		$conteo = 0; //Contador para cada uno de los registros que se insertan en la B.D.
		$this->load->library("upload", $config);
		if ($this->upload->do_upload("txtFile")){ 
			//Carga exitosa del directorio. Se empieza a procesar el archivo.
			$upload = array('upload_data' => $this->upload->data());
			$path = $upload["upload_data"]["full_path"];
			if (file_exists($path)){
				//Leer el archivo
				$fp = fopen($path,"r");
      			$separador = ';'; //Caracter con el que se separan los campos del archivo
      			$campos = array("nro_orden","uni_local","nit","idproraz","idnomcom","idsigla","iddirecc","idtelno","idfaxno","idaano","idcorreo","finicial","ffinal","fk_depto","fk_mpio","fk_ciiu","fk_sede","fk_subsede"); //Contiene las columnas tal cual como estan definidas en el archivo plano
				$counter = 0; //Contador para cada una de las lineas que se estï¿½n recorriendo
				$novedad = $this->directorio->conteoDirectorio(); //Obtiene la novedad en la carga del directorio (5 - Primera Carga, 9 - Otras Cargas)
				while ($linea = fgets($fp,1024)){
					//Se descarta la primera linea que contiene el encabezado de las columnas
					if ($counter > 0){ 
      					$arrayData = explode($separador, $linea);
						for ($i=0; $i<count($campos); $i++){
      						$asignacion = "\$".$campos[$i]."='".$arrayData[$i]."';";
      						eval($asignacion);
      					}
      					//Validar la informacion del archivo plano
      					$res[1] = $this->directorio->validarDirectorio(1, $nro_orden);
      					$res[2] = $this->directorio->validarDirectorio(2, $nit);
      					$res[3] = $this->directorio->validarDirectorio(3, $fk_depto);
      					$res[4] = $this->directorio->validarDirectorio(4, $fk_mpio);
      					$res[5] = $this->directorio->validarDirectorio(5, $fk_ciiu);
      					$res[6] = $this->directorio->validarDirectorio(6, $fk_sede);
      					$res[7] = $this->directorio->validarDirectorio(7, $fk_subsede);
      					$flagDIR = true;
      					for ($k=1; $k<=count($res); $k++){
      						if ($res[$k]==false){
      							//Se produjeron errores en la validacion
      							switch($k){
      								case 1: echo "Falla al cargar el directorio. Nro de orden duplicado. (Linea: $counter).<br/>";
      								        break;
      								case 2: echo "Falla al cargar el directorio. Nro de nit duplicado. (Linea: $counter).<br/>";
      								        break;        
      								case 3: echo "Falla al cargar el directorio. No existe el codigo de departamento. (Linea: $counter).<br/>";
      								        break;
      								case 4: echo "Falla al cargar el directorio. No existe el codigo de municipio. (Linea: $counter).<br/>";
      								        break;                
      								case 5: echo "Falla al cargar el directorio. No existe el codigo de actividad. (Linea: $counter).<br/>";
      								        break;
      								case 6: echo "Falla al cargar el directorio. No existe el codigo de sede. (Linea: $counter).<br/>";
      								        break;
									case 7: echo "Falla al cargar el directorio. No existe el codigo de subsede. (Linea: $counter).<br/>";
      								        break;      								        
      							}
      							$flagDIR = false; //No insertar el registro;
      							break; 
      						}
      					}
      					if ($flagDIR){
      						// 1) Insertar datos sobre la tabla directorio.
      						$this->directorio->insertarFuentes($nro_orden, $uni_local, strtoupper($idproraz), strtoupper($idnomcom), $idsigla, $iddirecc, $idtelno, $idfaxno, $idaano, $idcorreo, $finicial, $ffinal, $fk_depto, $fk_mpio, $fk_ciiu, $fk_sede, $fk_subsede);
      						// 2) Insertrar datos sobre la tabla del usuario.
      						$login = "F".$nro_orden;
      						$password = $this->danecrypt->generarPassword();
      						$this->usuario->insertarUsuario($nit,strtoupper($idproraz), $login, $password, $idcorreo, date("Y-m-d h:i:s"), date("Y-m-d h:i:s"), $nro_orden, 1, $fk_sede, $fk_subsede, 1);
      						// 3) Insertar datos sobre la tabla de control.
      						$usuario = $this->usuario->IDUltimoInsertado();
      						$ano = $this->session->userdata("ano_periodo");
      						$mes = $this->session->userdata("mes_periodo");
      						$this->control->insertarControl($nro_orden, $uni_local, $ano, $mes, 0, 0, 0, 0, 0, 0, $novedad, 0, $fk_sede, $fk_subsede, 1, $usuario, 'A', 0);
      						$conteo++;
      					}  					
      				}
      				$counter++;
				}
				redirect("/administrador/directorio/0", "location", 301);				
			}
			else{
				redirect("/administrador/directorio/2", "location", 301);				
			}			
		}
		else{
			//Error:  No se ha podido cargar el archivo.
			redirect("/administrador/directorio/1", "location", 301);	
		}
	}
	*******/

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
	
	//Descarga el modelo de archivo CSV para la carga del directorio
	public function descargaArchivoCSV(){		
		$file = "./res/archivo.csv";
		if (file_exists($file)){
			$data = file_get_contents($file); // Read the file's contents
			$name = 'archivo.csv';
			force_download($name, $data); 
		}
		else{
			die("<h3>ERROR: NO se ha podido descargar el archivo del formulario. No existe el archivo. Consulte con su administrador</h3>");
			exit(-1);
		}
	}
	
	//Muestra los usuarios generales del aplicativo (No se realizan filtros ni por aï¿½o ni por periodo)
	public function usuarios(){
		$this->load->model("periodo");
		$this->load->model("usuario");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==4){
			$data['tipo_usuario']="ADMINISTRADOR";
		}
		$data["nom_usuario"] = $nom_usuario;
		$data["controller"] = "administrador";
		$data["menu"] = "adminmenu";
		$data["view"] = "usuarios";
		$data["ano_periodo"] = $this->session->userdata("ano_periodo");
		$data["mes_periodo"] = $this->session->userdata("mes_periodo");
		$data["reciente"] = $this->periodo->obtenerPeriodoActual(); //Obtengo cual es el periodo mas reciente para bloquear la carga del directorio, y que solo se muestre para el periodo actual.		
		
		//Configuracion del paginador
		$config = array();
		$config["base_url"] = site_url("administrador/usuarios");
		$config["total_rows"] = $this->usuario->contarUsuarios($data["ano_periodo"], $data["mes_periodo"]); //Nro de registros que debe procesar el paginador
		$config["per_page"] = 50; //Cantidad de registros por pagina que debe mostrar el paginador
		$config["num_links"] = 5; //Cantidad de links para cambiar de pï¿½gina que va a mostrar el paginador.
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
	
	//Muestra el formulario para actualizar los datos de un usuario
	public function UPDUsuario(){
		$this->load->model("usuario");
		$this->load->model("tipodocs");
		$this->load->model("rol");
		$this->load->model("sede");
		$this->load->model("subsede");
		$index = $this->input->post("index");
		$data["index"] = $index;
		$data["tipodoc"] = $this->tipodocs->obtenerTipoDocumentos();
		$data["roles"] = $this->rol->obtenerRolesUsuario();
		$data["sedes"] = $this->sede->obtenerSedes();
		$data["subsedes"] = $this->subsede->obtenerSubsedes(0); 
		$data["usuario"] = $this->usuario->obtenerUsuarioID($index);
		$this->load->view("ajxusuarioupd",$data);			
	}
	
	//Elimina el registro de un usuario en Administrador/Usuarios/Eliminar Usuario
	public function eliminarUsuario($index){
		$this->load->helper("url");
		$this->load->model("usuario");
		$this->usuario->eliminarUsuario($index);
		redirect('/administrador/usuarios','refresh');
	}
	
	
	public function fuentesAsignadas($id){
		$this->load->model("periodo");
		$this->load->model("usuario");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==4){
			$data['tipo_usuario']="ADMINISTRADOR";
		}
		$data["nom_usuario"] = $nom_usuario;
		$data["controller"] = "administrador";
		$data["menu"] = "adminmenu";
		$data["view"] = "ftesasignadas";
		$data["nomcritico"] = $this->usuario->obtenerNombreUsuario($id);
		$data["asignadas"] = $this->usuario->obtenerFuentesAsignadas($id, $ano_periodo, $mes_periodo);
		$this->load->view("layout",$data);
	}
		
	
	//Permite la asignacion de fuentes a los criticos (Administrador/Usuarios/Asignar fuentes)
	public function asignarFuentes($id){
		$this->load->model("periodo");
		$this->load->model("usuario");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();		
		$data["idcritico"] = $id;
		$data["nomcritico"] = $this->usuario->obtenerNombreUsuario($id);
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==4){
			$data['tipo_usuario']="ADMINISTRADOR";
		}
		$data["nom_usuario"] = $nom_usuario;
		$data["controller"] = "administrador";
		$data["menu"] = "adminmenu";
		$data["view"] = "asignarfuente";
		$data["sinasignar"] = $this->usuario->obtenerFuentesSinAsignar($ano_periodo, $mes_periodo);
		$data["asignados"] = $this->usuario->obtenerFuentesAsignadas($id, $ano_periodo, $mes_periodo);
		$this->load->view("layout",$data);
	}
	
	//Permite la asignacion de fuentes a los logisticos (Administrador/Usuarios/AsignarFuentes) -- Asignacion unicamente para usuarios logisticos
	public function asignarFuentesLOG($id){
		$this->load->model("periodo");
		$this->load->model("usuario");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==4){
			$data['tipo_usuario']="ADMINISTRADOR";
		}
		$data["nom_usuario"] = $nom_usuario;
		$data["controller"] = "administrador";
		$data["menu"] = "adminmenu";
		$data["view"] = "asignarfuentelog";
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$data["idlogistico"] = $id;
		$data["nomlogistico"] = $this->usuario->obtenerNombreUsuario($id);
		$data["asignados"] = $this->usuario->obtenerFuentesAsignadasLogistica($id, $ano_periodo, $mes_periodo); 
		$data["sinasignar"] = $this->usuario->obtenerFuentesSinAsignarLogistica($ano_periodo, $mes_periodo);  
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
		redirect("administrador/asignarFuentes/$usuario","location", 301);
	}
	
	public function asignarFuentesLogistico(){
		$this->load->model("usuario");
		$this->load->model("control");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");		
		$logistico = $this->input->post("hddLogistico");		 //Obtengo el ID del usuario
		$rol = $this->usuario->obtenerRolUsuario($logistico);  //Con base en el id de usuario obtengo el rol de ese usuario
		$fuentes = $this->input->post("chkSinasignar");
		for ($i=0; $i<count($fuentes); $i++){
			$arrayData = explode("-",$fuentes[$i]);			
			$this->control->asignarFuenteLogistico($arrayData[0], $arrayData[1], $ano_periodo, $mes_periodo, $logistico);			
		}
		redirect("administrador/asignarFuentesLOG/$logistico","location", 301);
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
		redirect("administrador/asignarFuentes/$critico","location", 301);
	}
	
	//Actualiza la tabla de control y remueve las fuentes que se han asignado a un logistico
	public function removerFuentesLogistico(){
		$this->load->model("control");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$logistico = $this->input->post("hddLogistico");
		$fuentes = $this->input->post("chkAsignados");
		for ($i=0; $i<count($fuentes); $i++){
			$arrayData = explode("-",$fuentes[$i]);			
			$this->control->asignarFuenteLogistico($arrayData[0], $arrayData[1], $ano_periodo, $mes_periodo,0);
		}
		redirect("administrador/asignarFuentesLOG/$logistico","location", 301);
	}
	
	//Actualiza los datos de un usuario en Administrador/Usuarios/Actualizar Usuario
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
		redirect('/administrador/usuarios','refresh');
	}
	
	
	public function descargaPlanos(){
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
		 * Pedazo de cï¿½digo para armmar un arreglo desde un bucle
		 * @author SJNEIRAG
		 * @since Julio 2015
		 */
		$per="0,0";
		//Para descargar planos histï¿½ricos
		if(isset($_REQUEST['anio'])){
			$ano_periodo=$_REQUEST['anio'];
			$variableVacia=0; //Variable igual a 0 pra armar el array
			foreach ($_REQUEST as $clave => $value) {
				$claves = substr($clave, 0, -1); //Asigno a la variable solamente lo que comience por mes y mes1.
				if($claves=='per' || $claves=='per1') //Condiciono para filtar lo que comience por per y per1.
				{
					$variableVacia=$variableVacia.",".$value; //Aquï¿½ armo el array con el contenido de $variableVacia.
					$per=$variableVacia; // Asigno el array a una variable ($per)
				}
			}
		}
		else{	 	
			$ano_periodo = $this->session->userdata("ano_periodo");
		}
		if(isset($_REQUEST['anio'])){
			$mes_periodo=substr($per,2); //Le quito lo que asignï¿½ la $variableVacia, para que solamente mande los meses selccionados en el formulario para la consulta.
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
			case 10: //Descarga histï¿½rico consolidado todos los modulos
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
		header("Content-Disposition: attachment; filename=$nomfile"); //En caso de fallas por demasiado tamaï¿½o del archivo eliminar esta linea.		
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
		$sheet->setCellValue("O2","Apartamentos Independientes");
		$sheet->getStyle("O2")->applyFromArray($styleArray);
		$sheet->setCellValue("P2","Bano Privado en el apartamento");
		$sheet->getStyle("P2")->applyFromArray($styleArray);
		$sheet->setCellValue("Q2","Sala de estar en el apartamento");
		$sheet->getStyle("Q2")->applyFromArray($styleArray);
		$sheet->setCellValue("R2","Cocina equipada en el apartamento");
		$sheet->getStyle("R2")->applyFromArray($styleArray);
		$sheet->setCellValue("S2","Comedor en el apartamento");
		$sheet->getStyle("S2")->applyFromArray($styleArray);
		$sheet->setCellValue("T2","Parqueadero");
		$sheet->getStyle("T2")->applyFromArray($styleArray);
		$sheet->setCellValue("U2","Botones");
		$sheet->getStyle("U2")->applyFromArray($styleArray);
		$sheet->setCellValue("V2","Camarera");
		$sheet->getStyle("V2")->applyFromArray($styleArray);
		$sheet->setCellValue("W2","Room Service");
		$sheet->getStyle("W2")->applyFromArray($styleArray);
		$sheet->setCellValue("X2","Servicio de Recepcion");
		$sheet->getStyle("X2")->applyFromArray($styleArray);
		$sheet->setCellValue("Y2","Habitaciones o Apartamentos con Bano Privado");
		$sheet->getStyle("Y2")->applyFromArray($styleArray);
		$sheet->setCellValue("Z2","Locales y servicios comunes para la practica de deportes");
		$sheet->getStyle("Z2")->applyFromArray($styleArray);
		$sheet->setCellValue("AA2","Locales y servicios comunes para la practica de actividades recreativas");
		$sheet->getStyle("AA2")->applyFromArray($styleArray);
		$sheet->setCellValue("AB2","Areas Sociales");
		$sheet->getStyle("AB2")->applyFromArray($styleArray);
		$sheet->setCellValue("AC2","Bar");
		$sheet->getStyle("AC2")->applyFromArray($styleArray);
		$sheet->setCellValue("AD2","Restaurante");
		$sheet->getStyle("AD2")->applyFromArray($styleArray);
		$sheet->setCellValue("AE2","Piscina");
		$sheet->getStyle("AE2")->applyFromArray($styleArray);
		$sheet->setCellValue("AF2","Parqueadero");
		$sheet->getStyle("AF2")->applyFromArray($styleArray);
		$sheet->setCellValue("AG2","Botones");
		$sheet->getStyle("AG2")->applyFromArray($styleArray);
		$sheet->setCellValue("AH2","Camarera");
		$sheet->getStyle("AH2")->applyFromArray($styleArray);
		$sheet->setCellValue("AI2","Room Service");
		$sheet->getStyle("AI2")->applyFromArray($styleArray);
		$sheet->setCellValue("AJ2","Servicio de recepcion");
		$sheet->getStyle("AJ2")->applyFromArray($styleArray);
		$sheet->setCellValue("AK2","Unidades habitacionales con bano privado");
		$sheet->getStyle("AK2")->applyFromArray($styleArray);
		$sheet->setCellValue("AL2","Unidades habitacionales sin bano privado");
		$sheet->getStyle("AL2")->applyFromArray($styleArray);
		$sheet->setCellValue("AM2","Posadas turisticas");
		$sheet->getStyle("AM2")->applyFromArray($styleArray);
		$sheet->setCellValue("AN2","Ecohabs");
		$sheet->getStyle("AN2")->applyFromArray($styleArray);
		$sheet->setCellValue("AO2","Fincas Turisticas");
		$sheet->getStyle("AO2")->applyFromArray($styleArray);
		$sheet->setCellValue("AP2","Bano Comun");
		$sheet->getStyle("AP2")->applyFromArray($styleArray);
		$sheet->setCellValue("AQ2","Areas Sociales");
		$sheet->getStyle("AQ2")->applyFromArray($styleArray);
		$sheet->setCellValue("AR2","Restaurante");
		$sheet->getStyle("AR2")->applyFromArray($styleArray);
		$sheet->setCellValue("AS2","Servicio de Recepcion");
		$sheet->getStyle("AS2")->applyFromArray($styleArray);
		$sheet->setCellValue("AT2","Concesiones con parques naturales");
		$sheet->getStyle("AT2")->applyFromArray($styleArray);
		$sheet->setCellValue("AU2","Permite el desarrollo de actividades asociadas a su entorno natural y cultural");
		$sheet->getStyle("AU2")->applyFromArray($styleArray);
		$sheet->setCellValue("AV2","Habitaciones privadas con bano");
		$sheet->getStyle("AV2")->applyFromArray($styleArray);
		$sheet->setCellValue("AW2","Habitaciones compartidas");
		$sheet->getStyle("AW2")->applyFromArray($styleArray);
		$sheet->setCellValue("AX2","Habitaciones privadas sin bano");
		$sheet->getStyle("AX2")->applyFromArray($styleArray);
		$sheet->setCellValue("AY2","Bano Comun");
		$sheet->getStyle("AY2")->applyFromArray($styleArray);
		$sheet->setCellValue("AZ2","Areas Sociales");
		$sheet->getStyle("AZ2")->applyFromArray($styleArray);
		$sheet->setCellValue("BA2","Cocina comun");
		$sheet->getStyle("BA2")->applyFromArray($styleArray);
		$sheet->setCellValue("BB2","Restaurante");
		$sheet->getStyle("BB2")->applyFromArray($styleArray);
		$sheet->setCellValue("BC2","Servicio de Recepcion");
		$sheet->getStyle("BC2")->applyFromArray($styleArray);
		$sheet->setCellValue("BD2","Camarera");
		$sheet->getStyle("BD2")->applyFromArray($styleArray);
		$sheet->setCellValue("BE2","Forman parte de un conjunto funcional, cerrado, con aprovechamiento comun de los servicios");
		$sheet->getStyle("BE2")->applyFromArray($styleArray);
		$sheet->setCellValue("BF2","Lugar destinado a la instalacion de carpas");
		$sheet->getStyle("BF2")->applyFromArray($styleArray);
		$sheet->setCellValue("BG2","Instalaciones para instalar hamacas");
		$sheet->getStyle("BG2")->applyFromArray($styleArray);
		$sheet->setCellValue("BH2","Bano Comun");
		$sheet->getStyle("BH2")->applyFromArray($styleArray);
		
		//Obtener los datos de la consulta
		$data = $this->modulo5->descargaPlanosModulo($ano_periodo, $mes_periodo);
		
		for ($i=0; $i<count($data); $i++){
			$sheet->setCellValue("A".($i+3),$data[$i]["nro_orden"]);
			$sheet->setCellValue("B".($i+3),$data[$i]["nro_establecimiento"]);
			$sheet->setCellValue("C".($i+3),$data[$i]["idnomcom"]);
	        
			//Romper cada una de las variables de las categorias
			for ($x=0; $x<strlen($data[$i]["hoteles"]); $x++){
				$arrayLetters = array("D","E","F","G","H","I","J","K","L","M","N");
				$sheet->setCellValue($arrayLetters[$x]."1","HOTELES");
				$sheet->getStyle($arrayLetters[$x]."1")->applyFromArray($styleArray);
				$sheet->setCellValue($arrayLetters[$x].($i+3),substr($data[$i]["hoteles"],$x,1));  
			}
			for ($x=0; $x<strlen($data[$i]["apartahoteles"]); $x++){
				$arrayLetters = array("O","P","Q","R","S","T","U","V","W","X");
				$sheet->setCellValue($arrayLetters[$x]."1","APARTA-HOTELES");
				$sheet->getStyle($arrayLetters[$x]."1")->applyFromArray($styleArray);
				$sheet->setCellValue($arrayLetters[$x].($i+3),substr($data[$i]["apartahoteles"],$x,1));  
			}
			for ($x=0; $x<strlen($data[$i]["cenvacacionales"]); $x++){
				$arrayLetters = array("Y","Z","AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ");
				$sheet->setCellValue($arrayLetters[$x]."1","CENTROS VACACIONALES");
				$sheet->getStyle($arrayLetters[$x]."1")->applyFromArray($styleArray);
				$sheet->setCellValue($arrayLetters[$x].($i+3),substr($data[$i]["cenvacacionales"],$x,1));  
			}
			for ($x=0; $x<strlen($data[$i]["alojarural"]); $x++){
				$arrayLetters = array("AK","AL","AM","AN","AO","AP","AQ","AR","AS","AT","AU");
				$sheet->setCellValue($arrayLetters[$x]."1","ALOJAMIENTOS RURALES");
				$sheet->getStyle($arrayLetters[$x]."1")->applyFromArray($styleArray);
				$sheet->setCellValue($arrayLetters[$x].($i+3),substr($data[$i]["alojarural"],$x,1));  
			}
			for ($x=0; $x<strlen($data[$i]["hostales"]); $x++){
				$arrayLetters = array("AV","AW","AX","AY","AZ","BA","BB","BC","BD");
				$sheet->setCellValue($arrayLetters[$x]."1","HOSTALES");
				$sheet->getStyle($arrayLetters[$x]."1")->applyFromArray($styleArray);
				$sheet->setCellValue($arrayLetters[$x].($i+3),substr($data[$i]["hostales"],$x,1)); 
			}
			for ($x=0; $x<strlen($data[$i]["zonacamp"]); $x++){
				$arrayLetters = array("BE","BF","BG","BH");
				$sheet->setCellValue($arrayLetters[$x]."1","ZONAS DE CAMPING");
				$sheet->getStyle($arrayLetters[$x]."1")->applyFromArray($styleArray);
				$sheet->setCellValue($arrayLetters[$x].($i+3),substr($data[$i]["zonacamp"],$x,1));  
			}						
		}
		
		$writer = new PHPExcel_Writer_Excel5($this->phpexcel);		
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=$nomfile"); //En caso de fallas por demasiado tamaï¿½o del archivo eliminar esta linea.		
		$writer->save('php://output');
	}
	
	
	
	public function formularios(){
		$this->load->model("periodo");
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==4){
			$data['tipo_usuario']="ADMINISTRADOR";
		}
		$data["nom_usuario"] = $nom_usuario;
		$data["menu"] = "adminmenu";
		$data["controller"] = "administrador";
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
		if($tipo_usuario==4){
			$data['tipo_usuario']="ADMINISTRADOR";
		}
		$data["nom_usuario"] = $nom_usuario;
		$data["menu"] = "adminmenu";
		$data["controller"] = "administrador";
		$data["view"] = "ajxformularios";
		//Configuracion del paginador
		$config = array();
		$config["base_url"] = site_url("administrador/buscarFuentes");
		$config["total_rows"] = $this->directorio->contarDirectorio($opcion, $buscar, $data["ano_periodo"], $data["mes_periodo"]);
		$config["per_page"] = 50;   //Cantidad de registros por pagina que debe mostrar el paginador
		$config["num_links"] = 5;  //Cantidad de links para cambiar de pï¿½gina que va a mostrar el paginador.
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
	
	//Muestra el reporte operativo desde el modulo de administracion
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
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==4){
			$data['tipo_usuario']="ADMINISTRADOR";
		}
		$data["nom_usuario"] = $nom_usuario;
		$data["sede"] = 0;
		$data["subsede"] = 0;
		$data["informe"] = $this->control->informeOperativo($ano, $mes, $data["sede"], $data["subsede"]); //Obtener todas las sedes y todas las subsedes
		$data["controller"] = "administrador";
		$data["menu"] = "adminmenu";
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
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==4){
			$data['tipo_usuario']="ADMINISTRADOR";
		}
		$data["nom_usuario"] = $nom_usuario;
		$data["controller"] = "administrador";
		$data["menu"] = "adminmenu";
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
	
	public function ajaxOperativoCritico($sede, $subsede){
		$this->load->model("usuario");
		$this->load->model("control");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$criticos = $this->usuario->obtenerCriticos($sede, $subsede);
		//Para cada uno de los criticos que se encontraron, obtengo su respectivo reporte operativo
		if (count($criticos)>0){
			for ($i=0; $i<count($criticos); $i++){
				$data["reporte"][$i]["nombre"] = $criticos[$i]["nombre"];
				$data["reporte"][$i]["reporte"] = $this->control->informeOperativoCritico($criticos[$i]["id"], $ano_periodo, $mes_periodo, $sede, $subsede);
			}
			$this->load->view("ajxoperativocr",$data);
		}
		else{
			echo "<h3>No se han encontrado resultados</h3>";
		}
	}
	
	public function actualizarSubSedeOperativo(){
		$this->load->model("subsede");
		$sede = $this->input->post("sede");
		$subsedes = $this->subsede->obtenerSubsedesID($sede);
		echo '<select id="cmbSubSedeOP" name="cmbSubSedeOP" class="select">';
		echo '<option value="-" selected="selected">Seleccione...</option>';
		echo '<option value="0">Todas las subsedes.</option>';		
		for ($i=0; $i<count($subsedes); $i++){
			echo '<option value="'.$subsedes[$i]["id"].'">'.$subsedes[$i]["nombre"].'</option>';
		}
		echo '</select>';		
	}
	
	public function actualizarOperativo(){
		$this->load->library("session");
		$this->load->model("control");
		$ano = $this->session->userdata("ano_periodo");
		$mes = $this->session->userdata("mes_periodo");
		$data["sede"] = $this->input->post("sede");
		$data["subsede"] = $this->input->post("subsede");
		$data["informe"] = $this->control->informeOperativo($ano, $mes, $data["sede"], $data["subsede"]);
		$this->load->view("ajxoperativo",$data);		
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
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==4){
			$data['tipo_usuario']="ADMINISTRADOR";
		}
		$data["nom_usuario"] = $nom_usuario;
		$data["controller"] = "administrador";		
		$data["menu"] = "adminmenu";
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
	
	//CIERRA EL PERIODO ACTUAL DE DILIGENCIAMIENTO
	public function cierrePeriodo(){
		// Octubre 03 - 2012
		// Nota: Se modifica la propiedad del cierre de periodos. 
		// Descripcion: Al cerrar el periodo y abrir periodos se copian las fuentes y pasan con estado
		// (5-0) para el nuevo periodo, las fuentes para el periodo que se estï¿½ cerrando se mantienen 
		// con el mismo estado y novedad. (No se cambian al estado 99 - 5). Solo se crean registros para 
		//el nuevo periodo. Se hace apertura y cierre en una sola funcion
		$this->load->model("periodo");
		$this->load->model("control");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==4){
			$data['tipo_usuario']="ADMINISTRADOR";
		}
		$data["nom_usuario"] = $nom_usuario;
		$data["controller"] = "administrador";
		$data["menu"] = "adminmenu";
		$data["view"] = "cierreper";
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$data["periodo_actual"] = $this->periodo->obtenerPeriodoActual();
		$data["nombre_actual"] = $this->periodo->obtenerNombrePeriodo($data["periodo_actual"]["ano"], $data["periodo_actual"]["mes"]);
		$data["estado_actual"] = ($this->periodo->validaCierre($ano_periodo, $mes_periodo)) ? 'Cerrado' : 'Abierto'; 
		if ($data["periodo_actual"]["mes"]<12){
			$ano_nuevo = $data["periodo_actual"]["ano"];
			$mes_nuevo = $data["periodo_actual"]["mes"] + 1;
		}
		else{
			$ano_nuevo = $data["periodo_actual"]["ano"] + 1;
			$mes_nuevo = 1; 
		}
		$data["ano_nuevo"] = $ano_nuevo;
		$data["mes_nuevo"] = $mes_nuevo;
		$data["nombre_nuevo"] = $this->periodo->obtenerNombrePeriodo($ano_nuevo, $mes_nuevo);
		$data["dirbase"] = $this->control->directorioBase(0, 0, $ano_periodo, $mes_periodo, 0, 0);
		$data["nuevos"] = $this->control-> nuevos(0, 0, $ano_periodo, $mes_periodo, 0, 0);
		$data["sindistribuir"] = $this->control->sinDistribuir(0, 0, $ano_periodo, $mes_periodo, 0, 0);
		$data["distribuido"] = $this->control->distribuidos(0, 0, $ano_periodo, $mes_periodo, 0, 0);
		$data["digitacion"] = $this->control->digitacion(0, 0, $ano_periodo, $mes_periodo, 0, 0);
		$data["digitados"] = $this->control->digitados(0, 0, $ano_periodo, $mes_periodo, 0, 0);
		$data["analverif"] = $this->control->analisisVerificacion(0, 0, $ano_periodo, $mes_periodo, 0, 0);
		$data["verificados"] = $this->control->verificados(0, 0, $ano_periodo, $mes_periodo, 0, 0);
		$data["novedades"] = $this->control->novedades(0,0, $ano_periodo, $mes_periodo, 0, 0); 
		$this->load->view("layout",$data);
	}
	
	
	public function cierreEfectivoPeriodo(){
		$this->load->model("periodo");
		$this->load->model("control");
		$ano = $this->input->post("ano");
		$mes = $this->input->post("mes");
		if ($this->periodo->validaCierre($ano, $mes)){
			//Se cierra el periodo, se mantiene la novedad-estado del periodo anterior, y se duplican las fuentes para el nuevo periodo en novedad y estado (5-0).
			$this->control->cierrePeriodoActual($ano, $mes);
			echo "El periodo ha sido cerrado."; 
		}
		else{
			//El periodo ya esta cerrado
			echo "Este periodo ya ha sido cerrado.";
		}
	}
	
	//Cierra la sesion del usuario cuando se da click en la opcion salir del menu	
	public function cerrarSesion(){
		$this->load->helper("url");
		$this->load->library("session");
		$this->session->sess_destroy();
		redirect("login","refresh");
	}
	
	//Muestra el detalle del formulario (de fuente) desde el administrador
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
		if($tipo_usuario==4){
			$data['tipo_usuario']="ADMINISTRADOR";
		}
		$data["nom_usuario"] = $nom_usuario;
		$data["controller"] = "administrador";
		$data["menu"] = "adminmenu";
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
		//Rango para la variaciï¿½n anual y mensual para la ficha de anï¿½lisis.
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
	
	public function generarPazySalvo(){
		$this->load->library("session");
		$this->load->helper("dompdf_helper");
		$this->load->model("envioform");
		if($this->session->userdata("nro_establecimiento")!=0)
		{	
			$nro_establecimiento = $this->session->userdata("nro_establecimiento");
		}
		else
		{	
			$nro_establecimiento = $this->input->post("nro_establecimiento");
		}
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
	
	
	/****************************************************
	 * FUNCIONES AJAX PARA EL MODULO DE ADMINISTRACION
	 ****************************************************/
	
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
	
	//Insertat / Agregar una nueva empresa desde el directorio de fuentes del administrador
	public function insertarEmpresa(){
		$this->load->model("directorio");
		$this->load->model("usuario");
		foreach($_POST as $nombre_campo => $valor){
  			$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   			
  			eval($asignacion);
		}
		
		$validar = $this->usuario->validaRegistroEmpresa($txtNitEmpresa, $txtNroOrden); 
		if ($validar == 0){  //Validar que la empresa no estï¿½ ya registrada.
			//La empresa no estï¿½ registrada. Debe agregarse el registro
			$nit = $txtNitEmpresa . $txtNitDigValida;		 
			$this->directorio->insertarEmpresa($txtNroOrden, $nit, $txtRazonSocial, $txtNomComercial, $txtSigla, $txtDireccion, $txtTelefono, $txtFax, $idaano=0, $txtPagWeb, $txtEmail, $cmbDepartamento, $cmbCiudad);
			echo "La empresa ha sido registrada.";
		}
		else if ($validar == 1){
			//La empresa ya estï¿½ registrada. Retorno el Nro de orden.
			echo "El Nro. de orden de la empresa ya se encuentra registrado. ($txtNroOrden)";
		}
		else if ($validar == 2){
			//El nï¿½mero de nit de la empresa que se intenta registrar ya existe.
			echo "El NIT de la empresa ya se encuentra registrado. ($nit)";
		}
	}
	
	
	
	//Insertar / Agregar una nueva fuente desde el directorio de fuentes del administrador
	public function insertarFuente(){
		$this->load->model("control");
		$this->load->model("empresa");
		$this->load->model("usuario");
		$this->load->model("directorio");
		$this->load->model("establecimiento");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		foreach($_POST as $nombre_campo => $valor){
  			$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   			
  			eval($asignacion);
		}
		if ($this->empresa->existeEmpresa($txtNumOrden)){
			//Validar que el establecimiento no estï¿½ registrado ya
			if (!$this->usuario->validaRegistroEstablecimiento($txtNumOrden, $txtNumEstab, $ano_periodo, $mes_periodo)){
				$this->establecimiento->insertarEstablecimiento($txtNumOrden, $txtNumEstab, $txtNomEstab, "", $txtDirEstab, 0, 0, "", NULL, NULL, $cmbActivEstab, $cmbDeptoEstab, $cmbMpioEstab, $cmbSedeEstab, $cmbSubSedeEstab);
				//Crea el registro en la tabla de usuarios
				$login = "F".$txtNumEstab;
				$password = $this->danecrypt->generarPassword();
				$nitEmpresa = $this->empresa->obtenerNITEmpresa($txtNumOrden);
				$this->usuario->insertarUsuario($nitEmpresa, $txtNomEstab, $login, $password, '', date("Y-m-d h:i:s"), '0000-00-00 00:00:00', $txtNumOrden, $txtNumEstab, 1, 1, $cmbSedeEstab, $cmbSubSedeEstab); //Agregar con el rol fuente
				//Agregar registro en la tabla de control
				$idusuario = $this->usuario->IDUltimoInsertado();
				$this->control->insertarControl($txtNumOrden, $txtNumEstab, $ano_periodo, $mes_periodo, 1, 0, 0, 0, 0, 0, $cmbInclusion, 'A', 9, 0, $cmbSedeEstab, $cmbSubSedeEstab, 0, 0);
			}			
			else{
				echo "No se puede agregar el establecimiento. El establecimiento ya se encuentra registrado.";
			}
		}
		else{
			echo "No se puede agregar el establecimiento. La empresa indicada no existe o aun no ha sido registrada.";
		}
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
		$arrayDatos = explode("-",$cmbFuente);
		$nro_orden = $arrayDatos[0];
		$nro_establecimiento = $arrayDatos[1];
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$inclusion = "";
		$info = $this->usuario->obtenerDatosFuente($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		
		switch ($info["inclusion"]){
			case 1: $inclusion = "Forzosa";
			          break;
			case 2: $inclusion = "Probabil&iacute;stica";
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
	  			<td>'.$info["inclusion"].'</td>
			  </tr>
			  </table>
			  </fieldset>';		  
		
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
		$arrayData = explode("-",$cmbFuente);
		$nro_orden = $arrayData[0];
		$nro_establecimiento = $arrayData[1];
		$this->usuario->eliminarFuente($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		echo $this->db->last_query();		
	}
	
	//Funcion para descargar el directorio. Genera un archivo Excel donde se muestran las contraseï¿½as del directorio sin encriptar
	public function descargaDirectorio(){
		$this->load->model("usuario");
		$usuarios = $this->usuario->reportePasswords();
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
	
	//Descarga del directorio de usuarios
	public function directorioUsuarios(){
		$this->load->model("usuario");
		$usuarios = $this->usuario->reporteDirectorioUsuarios();
		$sheet = $this->phpexcel->getActiveSheet();
		$sheet->getColumnDimension('A')->setWidth(30);
		$sheet->getColumnDimension('B')->setWidth(30);
		$sheet->getColumnDimension('C')->setWidth(30);
		$sheet->getColumnDimension('D')->setWidth(30);
		$sheet->getColumnDimension('E')->setWidth(30);
		$sheet->setCellValue('A1','ID. Usuario');
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
			$sheet->setCellValue($codC,strtoupper($usuarios[$i]["nom_usuario"]));
			$sheet->setCellValue($codD,$usuarios[$i]["log_usuario"]);
			$sheet->setCellValue($codE,$usuarios[$i]["pas_usuario"]);
		}
		$writer = new PHPExcel_Writer_Excel5($this->phpexcel);
		header('Content-type: application/vnd.ms-excel');
		$writer->save('php://output');
	}
	
	//Muestra el formulario para realizar la captura de datos e ingresar los datos de un nuevo usuario del sistema (No para fuentes)
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
	
	//Busca en la base de datos si el numero de identificacion del usuario que se esta creando ya estï¿½ creado en la base de datos
	public function validaNitLogin(){
		$this->load->model("usuario");
		$tipo = $this->input->post("tipodoc");
		$numero = $this->input->post("numdoc");
		$login = $this->input->post("login");
		$valid1 = $this->usuario->numIdentificacionExiste($tipo,$numero);
		$valid2 = $this->usuario->existeLogin($login);
		if (($valid1==true)||($valid2==true)){
			$validar = false;
			$error = "El usuario ya existe.";
		}
		else{
			$validar = true;
			$error = "&nbsp;";
		}
		$arrayError = array('valid' => $validar,
			                'error' => $error);
		echo json_encode($arrayError);		
	}
		
	
	
	//Agrega el registro de un nuevo usuario creado en el sistema a la B.D.
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
		$nro_establecimiento = 0; //No se asigna un numero de establecimiento
		$fecini = $this->general->formatoFecha($txtFecCreacion,"/");
		$fecfin = $this->general->formatofecha($txtFecVencimiento,"/");
		$password = $this->danecrypt->encode($txtPassword);
		//$this->usuario->insertarUsuario($txtNumId, $txtNomUsuario, $txtLogin, $password, $txtEmail, $fecini, $fecfin, $nro_orden, $cmbRol, $cmbsede, $cmbSubsede, $cmbTipoDocumento);
		$this->usuario->insertarUsuario($txtNumId, $txtNomUsuario, $txtLogin, $password, $txtEmail, $fecini, $fecfin, $nro_orden, $nro_establecimiento, $cmbTipoDocumento, $cmbRol, $cmbsede, $cmbSubsede);
		redirect('/administrador/usuarios','refresh');
	}
	
	
	//Paginador para la busqueda de resultados de la busqueda de formularios
	public function pagerBuscadorFuentes(){
		$this->load->library("session");
		$this->load->library("paginador2");
		$this->load->model("directorio");
		$buscar = $this->input->post("buscar");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$opcion = $this->input->post("opcion");
		$buscar = $this->input->post("buscar");
		$pagina = $this->input->post("pagina");
		$desde = ($pagina - 1) * $this->paginador2->getRegsPagina();
		$this->paginador2->setFuncion("administrador/pagerBuscadorFuentes");		
		$data["total"] = $this->directorio->contarDirectorio($opcion, $buscar, $ano_periodo, $mes_periodo);
		$data["fuentes"] = $this->directorio->buscarDirectorioPagina($desde, $opcion, $buscar, $ano_periodo, $mes_periodo);
		$data["paginador"] = $this->paginador2->paginar('divResultados',$pagina,$data["total"]);
		$this->load->view("ajxformularios",$data);		
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
	
	public function consultaFuentesAsignadas(){
		$this->load->model("control");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$rol = $this->input->post("rol");
		$id_usuario = $this->input->post("usuario");
		$fuentes = $this->control->obtenerNumeroFuentesAsignadas($rol, $id_usuario, $ano_periodo, $mes_periodo);
		echo json_encode($fuentes);
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
			$array = explode("=", $str);
			$asignacion = "\$" . $array[0] . "='" . str_replace("+"," ",$array[1]) . "';";   						
  			eval($asignacion);
		}
		
		//Dependiendo del capitulo que se reciba, voy a actualizar los datos del capitulo.
		
		switch($capitulo){
			case 1:  $this->modulo1->actualizarModulo($nro_orden, $nro_establecimiento, $idnit, $idproraz, $idnomcom, $idsigla, $iddirecc, $iddepto, $idmpio, $idtelno, $idfaxno, $idpagweb, $idcorreo, $finicial, $ffinal,
                     $idnomcomest, $idsiglaest, $iddireccest, $iddeptoest, $idmpioest, $idtelnoest, $idfaxnoest, $idcorreoest, $nom_cadena, $nom_operador);
                     break;
                     
			case 2:  //Actualizar los datos del modulo.
				     $this->modulo2->actualizarModulo($potpsfr, $potperm, $gpper, $pottcde, $gpssde, $pottcag, $gpppta, $potpau, $gppgpa, $pottot, $gpsspot, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				     //Actualizar las observaciones de la fuente.				     
					 if (!isset($obsgpssde)){
					 	$obsgpssde = "";
					 }
				     if (!isset($obsgppgpa)){
						$obsgppgpa = "";
					 }
					 $this->observacion->actualizarObservacion($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 2, 'gpssde', $gpssde, $obsgpssde);
					 $this->observacion->actualizarObservacion($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 2, 'gppgpa', $gppgpa, $obsgppgpa);					 
					 break;
			         
			case 3:  //Actualizar los datos del modulo.
				     $this->modulo3->actualizarModulo($inalo, $inali, $inba, $insr, $inoe, $inoio, $intio, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				     //Actualizar las observaciones de la fuente.
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
			         
			case 4:  //Actualizar los datos del modulo
				     $tphto = 0; //Esta variable no viene definida por ningun lado en el modulo 4. 
					 $this->modulo4->actualizarModulo($habdia, $ihdo, $ihoa, $camdia, $icda, $icva, $ihpn, $ihpnr, $huetot, $mvnr, $mvcr, $mvor, $mvsr, $mvotr, $mvott, $mvnnr, $mvcnr, $mvonr, $mvsnr, $mvotnr, $mvottnr, $thsen, $thusen, $thdob, $thudob, $thsui, $thusui, $thmult, $thumult, $thotr, $thuotr, $thtot, $ingsen, $ingdob, $ingsui, $ingmult, $ingotr, $ingtot, $tphto, $inalosen, $inalodob, $inalosui, $inalomul, $inalootr, $inalotot, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				     //Actualizar las observaciones de la fuente.
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
				     //$this->observacion->actualizarObservacion($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 4, 'inalomul', $inalomul, $obsinalomul);
					 //$this->observacion->actualizarObservacion($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, 4, 'inalootr', $inalootr, $obsinalootr);
			         break;
			         
			case 5:  //Actualizar los datos del modulo
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
				     //Acualiza el cï¿½digo ciiu en la tabla estableciilentos
				     $data["categorias"] = $this->modulo5->obtenercategorias(); //Se pasan los datos necesarios para el modulo5.
				      
				     //Acualiza el cï¿½digo ciiu en la tabla estableciilentos
				     //$this->modulo5->acualizaCodCiiu($resultados[1], $resultados[2], $resultados[3], $resultados[4], $resultados[5], $resultados[6], $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $otro_servicio);
				     for ($i=0; $i<count($data["categorias"]); $i++){
				     	$j=$i+1;
				     	if($resultados[$j]>0){
				     		$this->modulo5->acualizaCodCiiu($data["categorias"][$i]['cod_ciiu'], $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
				     	}
				     }
				     break;
			         
			default: $this->envioform->actualizarModulo($observaciones, $dmpio, $fedili, $repleg, $responde, $respoca, $teler, $emailr, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
			         break;					  
		}
		$this->observacion->guardarObservacion($capitulo, $campo, $observacion, $fecha, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $idcritico);
	}
	
	
	//function para editar los datos de la fuente en el directorio de fuentes
	public function editarFuente($nro_orden, $nro_establecimiento){
		$this->load->model("periodo");
		$this->load->model("divipola");
		$this->load->model("empresa");
		$this->load->model("actividad");
		$this->load->model("sede");
		$this->load->model("subsede");
		$this->load->model("establecimiento");
		$this->load->model("control");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$data["controller"] = "administrador";
		$data["view"] = "editarfte";
		$nom_usuario = $this->session->userdata("nombre");
		$tipo_usuario = $this->session->userdata("tipo_usuario");
		if($tipo_usuario==4){
			$data['tipo_usuario']="ADMINISTRADOR";
		}
		$data["nom_usuario"] = $nom_usuario;
		$data["menu"] = "adminmenu";
		$data["periodos"] = $this->periodo->obtenerPeriodosTodosMOD();
		$data["departamentos"] = $this->divipola->obtenerDepartamentos();
		$data["municipios"] = $this->divipola->obtenerMunicipios("");
		$data["actividades"] = $this->actividad->obtenerActividades();
		$data["sedes"] = $this->sede->obtenerSedes();
		$data["subsedes"] = $this->subsede->obtenerSubSedes();
		$data["empresa"] = $this->empresa->obtenerDatosEmpresa($nro_orden);
		$data["establecimiento"] = $this->establecimiento->obtenerDatosEstablecimiento($nro_orden, $nro_establecimiento);
		$data["control"] = $this->control->obtenerInformacionControl($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
		$this->load->view("layout",$data);
	}
	
	
	//Function para eliminar los datos de una fuente. Elimina todos los datos de una fuente
	public function eliminarFuente(){
		$this->load->model("procedure");
		$id_usuario = $this->session->userdata("id");
		$nro_orden = $this->input->post("numord");
		$nro_establecimiento = $this->input->post("numest");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$this->procedure->removerFuenteBackup('DELETE', $id_usuario, $nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo);
	}
	
	//funcion para actualizar los datos de una fuente
	public function actualizarDatosFuente(){
		$this->load->model("procedure");
		$this->load->model("empresa");
		$this->load->model("establecimiento");
		//Recibir todas las variables que vengan enviadas por POST
		foreach($_POST as $nombre_campo => $valor){
  			$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";  			
  			eval($asignacion);
		}
		//Actualizar los datos de la sede y la subsede
		$this->procedure->trasladarSedeSubsede($hddNroOrden, $hddNroEstablecimiento, $cmbSedeEst, $cmbSubSedeEst);
		//Actualizar los datos de la empresa
		$this->empresa->actualizarEmpresa($hddNroOrden, $idnit, $idproraz, $idnomcom, $idsigla, $iddirecc, $idtelno, $idfaxno, $idaano, $idpagweb, $idcorreo, $cmbDeptoEmp, $cmbMpioEmp);
		//Actualizar los datos del establecimiento
		$this->establecimiento->actualizarEstablecimiento($hddNroOrden, $hddNroEstablecimiento, $idnomcomest, $idsiglaest, $iddireccest, $cmbMpioEst, $cmbDeptoEst, $idtelnoest, $idfaxnoest, $idcorreoest, $cmbActEst, $cmbDeptoEst, $cmbMpioEst, $cmbSedeEst, $cmbSubSedeEst);
		redirect("/administrador/editarFuente/$hddNroOrden/$hddNroEstablecimiento", "refresh");
	}
	
	public function cambiarFuente(){
		$this->load->model("procedure");
		$nro_orden = $this->input->post("numord");
		$nro_establecimiento = $this->input->post("numest");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$novedad = $this->input->post("novedad");
		$estado = $this->input->post("estado");
		$usuario = 0; //Esta opcion siempre la ejecuta el administrador
		$this->procedure->cambiarEstadoFormulario($nro_orden, $nro_establecimiento, $ano_periodo, $mes_periodo, $novedad, $estado, $usuario);		
	}
	
	public function obtenerSalario(){
		$this->load->model("periodo");
		$ano_periodo = $this->session->userdata("ano_periodo");
		$mes_periodo = $this->session->userdata("mes_periodo");
		$salario = $this->periodo->obtenerSalarioPeriodo($ano_periodo, $mes_periodo);
		echo json_encode($salario);
	}
			
	//Muestra el consolidado de los mï¿½dulos II, III y IV para las empresas.)
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