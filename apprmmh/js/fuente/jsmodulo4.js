//DMDIAZF - Agosto 15, 2012
//Funciones JavaScript para el modulo IV de fuente
//


$(function(){
	
	//Configuracion inicial del formulario
	var mensajeIHOA = "Justifique por qu&eacute; durante el mes, el n&uacute;mero de habitaciones vendidas fue mayor que el de habitaciones ofrecidas.";
	var mensajeICVA = "En el mes el n&uacute;mero de camas vendidas fue mayor que el n&uacute;mero de camas ofrecidas &iquest;Se vendieron camas supletorias?";
	var mensajeHUETOT = "Justifique por qu&eacute; durante el mes, el n&uacute;mero total de hu&eacute;spedes es igual al n&uacute;mero de camas vendidas.";
	var mensajeTHUDOB = "Verificar porque la tarifa por persona en habitaci&oacute;n sencilla es mayor que la doble.";
	var mensajeTHUSUI = "Verificar porque la tarifa por persona en habitaci&oacute;n sencilla es mayor que la tipo suite.";
	var mensajeTHUMULT = "Verificar porque la tarifa por persona en habitaci&oacute;n sencilla es mayor que la m&uacute;ltiple.";
	//var mensajeINALOMUL = "Si por el tipo de habitaci&oacute;n m&uacute;ltiple s&oacute;lo se diligencia los ingresos de alojamiento el rubro deber&iacute;a ser menor o igual al ingreso total.";
	//var mensajeINALOOTR = "Si por otro tipo de habitaci&oacute;n s&oacute;lo se diligencia los ingresos de alojamiento el rubro deber&iacute;a ser menor o igual al ingreso total.";
	//$("#habdia").numerico().largo(7);
	$("#ihdo").numerico().largo(7);		
	$("#ihoa").numerico().largo(7);
	//$("#camdia").numerico().largo(7);
	$("#icda").numerico().largo(7);
	$("#icva").numerico().largo(7);
	$("#ihpn").numerico().largo(7);
	$("#ihpnr").numerico().largo(7);
	$("#huetot").numerico().largo(7);
	$("#mvnr").numerico().largo(4);
	$("#mvcr").numerico().largo(4);		
	$("#mvor").numerico().largo(4);
	$("#mvsr").numerico().largo(4);
	$("#mvsnr").numerico().largo(4);
	$("#mvotr").numerico().largo(4);
	$("#mvott").numerico().largo(4);
	$("#mvnnr").numerico().largo(4);			
	$("#mvcnr").numerico().largo(4);
	$("#mvonr").numerico().largo(4);
	$("#mvotnr").numerico().largo(4);
	$("#mvottnr").numerico().largo(4);
	$("#thsen").numerico().largo(9);
	$("#thusen").numerico().largo(9);
	$("#thdob").numerico().largo(9);
	$("#thudob").numerico().largo(9);
	$("#thsui").numerico().largo(9);
	$("#thusui").numerico().largo(9);
	$("#thmult").numerico().largo(9);
	$("#thumult").numerico().largo(9);
	$("#thotr").numerico().largo(9);
	$("#thuotr").numerico().largo(9);
	$("#thtot").numerico().largo(9);
	//$("#ingsen").numerico().largo(9);
	//$("#ingdob").numerico().largo(9);
	//$("#ingsui").numerico().largo(9);
	//$("#ingmult").numerico().largo(9);
	//$("#ingotr").numerico().largo(9);
	$("#ingtot").numerico().largo(9);
	//$("#inalosen").numerico().largo(9);
	//$("#inalodob").numerico().largo(9);
	//$("#inalosui").numerico().largo(9);
	//$("#inalomul").numerico().largo(9);
	//$("#inalootr").numerico().largo(9);
	$("#inalotot").numerico().largo(9);
	
	$("#ihoa").cajaObservaciones('parseInt($("#ihoa").val()) > parseInt($("#ihdo").val())','divihoa',mensajeIHOA,'obsihoa');
	$("#icva").cajaObservaciones('parseInt($("#icva").val()) > parseInt($("#icda").val())','divicva',mensajeICVA,'obsicva');
	$("#huetot").cajaObservaciones('parseInt($("#huetot").val()) == parseInt($("#icva").val())','divhuetot',mensajeHUETOT,'obshuetot');
	$("#thudob").cajaObservaciones('parseInt($("#thusen").val()) > parseInt($("#thudob").val())','divthudob',mensajeTHUDOB,'obsthudob');
	$("#thusui").cajaObservaciones('parseInt($("#thusen").val()) > parseInt($("#thusui").val())','divthusui',mensajeTHUSUI,'obsthusui');
	$("#thumult").cajaObservaciones('parseInt($("#thusen").val()) > parseInt($("#thumult").val())','divthumult',mensajeTHUMULT,'obsthumult');
	
	//$("#inalomul").cajaObservaciones('parseInt($("#ingmult").val()) > parseInt($("#inalomul").val())','divinalomul',mensajeINALOMUL,'obsinalomul');
	//$("#inalootr").cajaObservaciones('parseInt($("#ingotr").val()) > parseInt($("#inalootr").val())','divinalootr',mensajeINALOOTR,'obsinalootr');
	
	//$("#habdia").hint("Disponibles promedio d&iacute;a. Infraestructura. Capacidad de alojamiento.");
	$("#ihdo").hint("Las habitaciones ofrecidas pueden cambiar si hay habitaciones en mantenimiento o cerradas temporalmente. Ej: si tiene 10 habitaciones f&iacute;sicas que estuvieron disponibles todos los 30 d&iacute;as del mes 'para un mes calendario = 30', entonces las habitaciones ofrecidas total mes ser&aacute;n 300. Se debe manejar mes calendario.");
	//$("#ihoa").hint("N&uacute;mero de habitaciones vendidas por noche en el mes. Puede tenerse en cuenta habitaciones \"supletorias\"");
	//$("#camdia").hint("Disponibles promedio d&iacute;a. Infraestructura. Capacidad de alojamiento. No se incluyen las camas supletorias.");
	$("#icda").hint("Hace referencia a las camas fijas realmente ofrecidas en el mes. No se cuentan camas supletorias.");
	$("#icva").hint("Se obtiene de acuerdo con los registros de hu&eacute;spedes, sumando día a día el n&uacute;mero de veces que cada cama ha estado cedida (vendida) a un cliente; por ejemplo, si la totalidad de hoteles tiene f&iacute;sicamente 200 camas, de las cuales 160 permanecen ocupadas todo el mes, el n&uacute;mero de camas vendidas es de 4 800 (160 camas × 30 días).");
	$("#texto6").hint("Persona que se aloja en un establecimiento, mediante contrato de hospedaje. S&oacute;lo se registran las personas que llegan sin tener en cuenta el tiempo de pernoctaci&oacute;n (Ej. Una persona se registra en un hotel, pernocta seis (6) noches seguidas, se reportar&aacute; como un solo hu&eacute;sped)");
	$("#huetot").hint("Suma de residentes m&aacute;s no residentes");
	$("#texto1").hint("Motivo sin el cual el viaje no se hubiera efectuado.");
	$("#texto2").hint("Ingresos totales por habitaci&oacute;n. Incluye ingresos por alojamiento y otros cobros.");
	$("#texto3").hint("Triple, cu&aacute;druple");
	$("#texto4").hint("Caba&ntilde;a, Apartamento, camping, etc.");
	$("#textoMICE").hint("MICE ( Meeting, incentives, congresses, exhibitions), es aquel que abarca las actividades basadas en la organizaci&oacute;n, promoci&oacute;n, venta y distribuci&oacute;n de reuniones y eventos; productos y servicios que incluyen reuniones gubernamentales, de empresas y de asociaciones; viajes de incentivos de empresas, seminarios, congresos, conferencias, convenciones, exposiciones y ferias.");
	
	//Lanzo función ajax para saber si la fuente ha diligenciado justificaciones para este capitulo y mostrarlas en los recuadros.
	$.ajax({
		type: "POST",
		url: base_url + "fuente/obtenerObservaciones",
		data: {'campo': 0, 'modulo': 4}, //Se envia el campo en cero para que traiga todas las observaciones del modulo 3
		dataType: "html", 
	    cache: false,
		success: function(data){
			var datos = eval(data);
			if(typeof(datos) != "undefined"){ //Si se recibio alguna respuesta de observaciones 
				for (i=0; i<datos.length; i++){
					var bloquear = "";
					var div = "#div"+ datos[i].campo;
					var caja = "obs" + datos[i].campo;
					datos[i].mensaje = obtenerMensaje4(datos[i].campo); //Obtengo el mensaje para la justificacion.
					if (datos[i].bloqueo==true){
						var bloquear = 'disabled = "disabled"';
					}					
					var contenido = '<p>'+datos[i].mensaje+'</p><textarea id="'+caja+'" name="'+caja+'" rows="3" style="width: 75%; border: 1px solid #CCCCCC;"'+ bloquear +'>'+datos[i].descripcion+'</textarea>';
					$(div).html(contenido);
				}
			}																
		}					
	});
	
		
	//Validar el formulario del modulo 4 (Caracteristicas de los hoteles)
	$("#frmModuloIV").validate({
		rules : {
			/*habdia : {		required  :  true,
							menorQue  :  0
			},*/
			ihdo   : {		required  :  true,
							menorQue  : 'parseInt($("#ihdo").val())'
			},
			ihoa   : {		required  : true,
				            expresion : '(parseInt($("#inalo").val()) > 0) && (parseInt($("#ihoa").val())<=0)',
				            mayorQue  : 'parseInt($("#ihdo").val())'
			},
			/*camdia : {		required  : true,
							menorQue  : 0
			},*/
			icda   : {		required  : true,
				            expresion : '(parseInt($("#ihdo").val()) > 0) && (parseInt($("#icda").val())<=0)',
				            menorQue  : 'parseInt($("#ihdo").val())'
			},
			icva   : {		required  : true,
				            expresion : '(parseInt($("#inalo").val()) > 0) && (parseInt($("#ihoa").val()) > 0) && (parseInt($("#icva").val())<=0)',
				            menorQue  : 'parseInt($("#ihoa").val())',
				            expresion2  : 'parseInt($("#icva").val())>parseInt($("#icda").val())'
			},
			ihpn   : {		required  : true,
				            expresion : '(parseInt($("#ihoa").val()) > 0) && (parseInt($("#ihpnr").val()) == 0) && (parseInt($("#inalo").val()) > 0) && (parseInt($("#ihpn").val()) <= 0)'
			},
			ihpnr  : {		required  : true,
				            expresion : '(parseInt($("#ihoa").val()) > 0) && (parseInt($("#ihpn").val()) == 0) && (parseInt($("#inalo").val()) > 0) && (parseInt($("#ihpnr").val()) <= 0)'
			},
			huetot : {		required  : true,
							igualQue  : 'parseInt($("#ihpn").val()) + parseInt($("#ihpnr").val())',
							mayorQue  : 'parseInt($("#icva").val())'
			},
			mvnr   : {		required  : true								
			},
			mvnnr  : {		required  : true
			},
			mvcr   : {		required  : true								
			},
			mvcnr  : {		required  : true
			},
			mvor   : {		required  : true
			},
			mvonr  : {		required  : true
			},
			mvsr   : {		required  : true
			},
			mvsnr  : {		required  : true
			},
			mvotr  : {		required  : true
			},
			mvotnr : {		required  : true
			},
			mvott  : {		required  : true,
							igualQue  : 'parseInt($("#mvnr").val()) + parseInt($("#mvcr").val()) + parseInt($("#mvor").val()) + parseInt($("#mvsr").val()) + parseInt($("#mvotr").val())'	
			},
			mvottnr : {		required  : true,
							igualQue  : 'parseInt($("#mvnnr").val()) + parseInt($("#mvcnr").val()) + parseInt($("#mvonr").val()) + parseInt($("#mvsnr").val()) + parseInt($("#mvotnr").val())'
			},
			thsen   : {		required  : true
			},
			thusen   : {		required  : true,
								expresion : '(parseInt($("#thsen").val()) == 0) && (parseInt($("#thusen").val())>0)',
								expresion2: '(parseInt($("#thsen").val()) > 0) && (parseInt($("#thusen").val()) == 0)'
			},
			/*ingsen  : {		required  : true
			},
			inalosen : {	required  : true
				            //mayorQue  : 'obtenerValor("#ingsen")' 
			},*/
			thdob    : {	required  : true
			},
			thudob    : {	required  : true,
							expresion : '(parseInt($("#thdob").val()) == 0) && (parseInt($("#thudob").val())>0)',
							expresion2: '(parseInt($("#thdob").val()) > 0) && (parseInt($("#thudob").val()) == 0)'
			},
			/*ingdob   : {	required  : true
			},
			inalodob : {	required  : true
							//mayorQue  : 'obtenerValor("#ingdob")'
			},*/
			thsui    : {	required  : true
			},
			thusui    : {	required  : true,
							expresion : '(parseInt($("#thsui").val()) == 0) && (parseInt($("#thusui").val())>0)',
							expresion2: '(parseInt($("#thsui").val()) > 0) && (parseInt($("#thusui").val()) == 0)'
			},
			/*ingsui   : {	required  : true
			},
			inalosui : {	required  : true
							//mayorQue  : 'obtenerValor("#ingsui")'
			},*/
			thmult   : {	required  : true
			},
			thumult   : {	required  : true,
							expresion : '(parseInt($("#thmult").val()) == 0) && (parseInt($("#thumult").val())>0)',
							expresion2: '(parseInt($("#thmult").val()) > 0) && (parseInt($("#thumult").val()) == 0)'
			},
			/*ingmult   : {	required  : true
			},
			inalomul : {	required  : true
						    //mayorQue  : 'obtenerValor("#ingmult")'
			},*/
			thotr    : {	required  : true
			},
			thuotr    : {	required  : true,
							expresion : '(parseInt($("#thotr").val()) == 0) && (parseInt($("#thuotr").val())>0)',
							expresion2: '(parseInt($("#thotr").val()) > 0) && (parseInt($("#thuotr").val()) == 0)'
			},
			/*ingotr   : {	required  : true
			},
			inalootr : {	required  : true
				            //mayorQue  : 'obtenerValor("#ingotr")'
			},*/
			thtot    : {	required  : true,
							igualQue  : 'parseInt($("#thsen").val()) + parseInt($("#thdob").val()) + parseInt($("#thsui").val()) + parseInt($("#thmult").val()) + parseInt($("#thotr").val())', 
				            expresion : '(obtenerValor("#thsen") + obtenerValor("#thdob") + obtenerValor("#thsui") + obtenerValor("#thmult") + obtenerValor("#thotr")) != obtenerValor("#ihoa")'
				            /*expresion2: '(parseInt($("#thtot").val()) == parseInt($("#ihoa").val()))'*/	
			},
			/*ingtot   : {	required  : true,
				            igualQue  : 'parseInt($("#ingsen").val()) + parseInt($("#ingdob").val()) + parseInt($("#ingsui").val()) + parseInt($("#ingmult").val()) + parseInt($("#ingotr").val())'
				            //expresion : 'obtenerValor("#inalo") != (obtenerValor("#inalotot") + obtenerValor("#ingtot"))'
			},
			inalotot : {	required  : true,
							igualQue  : 'parseInt($("#inalosen").val()) + parseInt($("#inalodob").val()) + parseInt($("#inalosui").val()) + parseInt($("#inalomul").val()) + parseInt($("#inalootr").val())',
							expresion : 'obtenerValor("#inalo") != (obtenerValor("#inalotot") + obtenerValor("#ingtot"))'
			},*/
			obsihoa : {		required  : true			
			},
			obsicva : {		required  : true
			},
			obshuetot : {		required  : true
			},
			obsthudob: {	required  : true
			},
			obsthusui: {	required  : true
			},
			obsthumult: {	required  : true
			},
			/*obsinalomul: {	required  : true
			},
			obsinalootr: {	required  : true
			}*/
		},
		messages : {
			/*habdia : {		required  :  "<br/>Falta n&uacute;mero de habitaciones disponibles.",
							menorQue  :  "<br/>Diga si se abrieron nuevas habitaciones o si hubo habitaciones cerradas durante el mes."
			},*/
			ihdo   : {		required  :  "<br/>Falta n&uacute;mero de habitaciones ofrecidas.",
				            menorQue  :  "<br/>Las habitaciones ofrecidas son mayores a las habitaciones disponibles."
			},
			ihoa   : {		required  :  "<br/>Falta n&uacute;mero de habitaciones vendidas.",
				            expresion :  "<br/>Existen ingresos por alojamiento sin habitaciones vendidas.",
				            mayorQue  :  "<br/>Habitaciones ocupadas o  vendidas mes  es mayor de  las ofrecidas total mes, Corrija."	
			},
			/*camdia : {		required  : "<br/>Falta n&uacute;mero de camas disponibles.",
							menorQue  : "<br/>Diga se se abrieron nuevas habitaciones o si hubo habitaciones cerradas durante el mes que afectaran o beneficiaran la disponibilidad de camas"
			},*/
			icda   : {		required  : "<br/>Falta n&uacute;mero de camas ofrecidas.",
				            expresion : "<br/>Falta el n&uacute;mero de camas disponibles.",
				            menorQue  : "N&uacute;mero de camas ofrecidas mes menor que el n&uacute;mero de habitaciones ofrecidas mes, corrija. "
			},
			icva   : {		required  : "<br/>Falta n&uacute;mero de camas vendidas en el mes.",
				            expresion : "<br/>Falta el n&uacute;mero de camas vendidas en el mes.",
				            menorQue  : "N&uacute;mero de camas ocupadas o vendidas mes menor que el n&uacute;mero de habitaciones ocupadas o vendidas mes, corrija.",
				            expresion2  : "N&uacute;mero de camas ocupadas o vendidas mes es mayor que el n&uacute;mero de camas ofrecidas mes, corrija."
			},
			ihpn   : {		required  : "<br/>Falta n&uacute;mero de hu&eacute;spedes colombianos.",
				            expresion : "<br/>Falta n&uacute;mero de hu&eacute;spedes que pernoctaron residentes en Colombia."
			},
			ihpnr  : {		required  : "<br/>Falta n&uacute;mero de hu&eacute;spedes extranjeros.",
				            expresion : "<br/>Falta n&uacute;mero de hu&eacute;spedes que pernoctaron no residentes en Colombia."
			},
			huetot : {		required  : "<br/>Falta total de hu&eacute;spedes.",
							igualQue  : "<br/>Verificar la llegada de personas o el n&uacute;mero total de hu&eacute;spedes en el hotel.",
							mayorQue  : "Verifique o corrija el número de hu&eacute;spedes, es mayor que el n&uacute;mero de camas vendidas.",
			},
			mvnr   : {		required  : "<br/>Falta porcentaje negocios residentes."					            
			},
			mvnnr  : {		required  : "<br/>Falta porcentaje negocios no residentes."
			},
			mvcr   : {		required  : "<br/>Falta porcentaje convenciones residentes."					            
			},
			mvcnr  : {		required  : "<br/>Falta porcentaje convenciones no residentes."
			},
			mvor   : {		required  : "<br/>Falta porcentaje ocio y recreaci&oacute;n residentes."
			},
			mvonr  : {		required  : "<br/>Falta porcentaje ocio y recreaci&oacute;n no residentes."
			},
			mvsr   : {		required  : "<br/>Falta porcentaje salud y belleza residentes."					
			},
			mvsnr  : {		required  : "<br/>Falta porcentaje salud y belleza no residentes."
			},
			mvotr  : {		required  : "<br/>Falta porcentaje otros residentes."
			},
			mvotnr : {		required  : "<br/>Falta porcentaje otros no residentes."
			},
			mvott  : {		required   : "<br/>Falta porcentaje total residentes.",
							//menorQue   : "El total del porcentaje de resitentes no puede ser menor que 100.",
							igualQue   : "<br/>El porcentaje total de residentes no coincide."
			},
			mvottnr : {		required  : "<br/>Falta porcentaje total no residentes.",
							
							igualQue   : "<br/>El porcentaje total de no residentes no coincide."
			},
			thsen   : {		required  : "<br/>Falta n&uacute;mero de habitaciones sencillas vendidas."
			},
			thusen   : {	required  : "<br/>Falta tarifa promedio por tipo de acomodaci&oacute;n habitaci&oacute;n sencilla.",
							expresion : "El n&uacute;mero de habitaciones sencillas vendidas es 0, por lo tanto  la tarifa promedio tiene que ser 0.",
							expresion2 : "La tarifa promedio no puede ser 0, porque hay habitaciones sencillas vendidas." 
			},
			/*ingsen  : {		required  : "<br/>Falta ingresos por habitaciones sencillas."
			},
			inalosen : {	required  : "<br/>Falta ingresos totales por alojamiento habitaciones sencillas."
				            //mayorQue  : "<br/>Si por este tipo de habitaci&oacute;n s&oacute;lo se diligencia los ingresos de alojamiento, el rubro deber&iacute;a ser menor o igual al ingreso total."
			},*/
			thdob    : {	required  : "<br/>Falta n&uacute;mero de habitaciones dobles vendidas."
			},
			thudob    : {	required  : "<br/>Falta tarifa promedio por tipo de acomodaci&oacute;n habitaci&oacute;n doble.",
							expresion : "El n&uacute;mero de habitaciones dobles vendidas es 0, por lo tanto  la tarifa promedio tiene que ser 0.",
							expresion2 : "La tarifa promedio no puede ser 0, porque hay habitaciones dobles vendidas."
			},
			/*ingdob   : {	required  : "<br/>Falta ingresos por habitaciones dobles."
			},
			inalodob : {	required  : "<br/>Falta ingresos totales por alojamiento habitaciones dobles."
							//mayorQue  : "<br/>Si por este tipo de habitaci&oacute;n s&oacute;lo se diligencia los ingresos de alojamiento, el rubro deber&iacute;a ser menor o igual al ingreso total."
			},*/
			thsui    : {	required  : "<br/>Falta n&uacute;mero de habitaciones suite vendidas."
			},
			thusui    : {	required  : "<br/>Falta tarifa promedio por tipo de acomodaci&oacute;n habitaci&oacute;n suite.",
							expresion : "El n&uacute;mero de habitaciones suite vendidas es 0, por lo tanto  la tarifa promedio tiene que ser 0.",
							expresion2 : "La tarifa promedio no puede ser 0, porque hay habitaciones suite vendidas."
			},
			/*ingsui   : {	required  : "<br/>Falta ingresos por habitaciones suite."
			},
			inalosui : {    required  : "<br/>Falta ingresos totales por alojamiento habitaciones suites."
				            //mayorQue  : "<br/>Si por este tipo de habitaci&oacute;n s&oacute;lo se diligencia los ingresos de alojamiento, el rubro deber&iacute;a ser menor o igual al ingreso total."
			},*/
			thmult   : {	required  : "<br/>Falta n&uacute;mero de habitaciones m&uacute;ltiples vendidas."
			},
			thumult   : {	required  : "<br/>Falta tarifa promedio por tipo de acomodaci&oacute;n habitaci&oacute;n m&uacute;ltiple.",
							expresion : "El n&uacute;mero de habitaciones m&uacute;ltiples vendidas es 0, por lo tanto  la tarifa promedio tiene que ser 0.",
							expresion2 : "La tarifa promedio no puede ser 0, porque hay habitaciones m&uacute;ltiples vendidas."
			},
			/*ingmult   : {	required  : "<br/>Falta ingresos por habitaciones m&uacute;ltiples."
			},
			inalomul : {	required  : "<br/>Falta ingresos totales por alojamiento habitaciones m&uacute;ltiples."
				            //mayorQue  : "<br/>Si por este tipo de habitaci&oacute;n s&oacute;lo se diligencia los ingresos de alojamiento, el rubro deber&iacute;a ser menor o igual al ingreso total."
			},*/
			thotr    : {	required  : "<br/>Falta n&uacute;mero de otro tipo de habitaciones vendidas."
			},
			thuotr    : {	required  : "<br/>Falta tarifa promedio por tipo de acomodaci&oacute;n otro tipo de habitaci&oacute;n.",
							expresion : "El n&uacute;mero de otro tipo de habitaciones vendidas es 0, por lo tanto  la tarifa promedio tiene que ser 0.",
							expresion2 : "La tarifa promedio no puede ser 0, porque hay otro tipo de habitaciones vendidas."
			},
			/*ingotr   : {	required  : "<br/>Falta ingresos por otro tipo de habitaciones."
			},
			inalootr : {	required  : "<br/>Falta ingresos totales por alojamiento otro tipo de habitaciones."
				            //mayorQue  : "<br/>Si por este tipo de habitaci&oacute;n s&oacute;lo se diligencia los ingresos de alojamiento, el rubro deber&iacute;a ser menor o igual al ingreso total."
			},*/
			thtot    : {	required  : "<br/>Falta total de habitaciones vendidas.",
				            igualQue  : "<br/>El total de habitaciones vendidas no coincide.",
							expresion : "<br/>El total de habitaciones vendidas no coincide.",
							expresion2: "<br/>El total de habitaciones vendidas no coincide con el numero de habitaciones ocupadas y/o vendidas."
			},
			ingtot   : {	required  : "<br/>Falta total de ingresos.",
				            igualQue  : "<br/>El total de ingresos por alojamiento y otros servicios no coincide."
				            //expresion : "<br/>Debe coincidir con el total de ingresos por alojamiento del Cap&iacute;tulo 3."
			},
			inalotot : {	required  : "<br/>Falta total de ingresos por alojamiento.",
							igualQue  : "<br/>El total de ingresos por alojamiento no coincide.",
							expresion : "<br/>La sumatoria de los totales facturados debe coincidir con el numeral '1. Alojamiento' del m&oacute;dulo 3"
			},
			obsihoa : {		required  : "Por favor complete la observaci&oacute;n."					
			},
			obsicva: {		required  : "Por favor complete la observaci&oacute;n."
			},
			obshuetot: {		required  : "Por favor complete la observaci&oacute;n."
			},
			obsthudob: {	required  : "Por favor complete la observaci&oacute;n."
			},
			obsthusui: {	required  : "Por favor complete la observaci&oacute;n."				
			},
			obsthumult: {	required  : "Por favor complete la observaci&oacute;n."				
			},
			/*obsinalomul: {	required  : "Por favor complete la observaci&oacute;n."
			},
			obsinalootr: {	required  : "Por favor complete la observacio&oacute;n."
			}*/
		},			
		errorPlacement: function(error, element) {
			element.after(error);		        
			error.css('display','block');
			error.css('float','none');
			error.css('vertical-align','top');
			error.css('margin-left','10px');				
			error.css('color',"#FF0000");
		},
		
		submitHandler: function(form) {
			//Validación de porcentajes residentes.
			if($("#ihpn").val() != 0 && $("#mvott").val() != 100)  
			{
				alert ('El porcentaje del motivo de viaje de residentes debe ser igual a 100!!!');
				return false;
			}
			else if($("#ihpnr").val() != 0 && $("#mvottnr").val() != 100)
			{
				alert ('El porcentaje del motivo de viaje de NO residentes debe ser igual a 100!!!');
				return false;
			}
			else if($("#ihpn").val() == 0 && $("#mvott").val() != 0) 
			{
				alert ('El número de residentes de en Colombia es 0, por lo tanto el porcentaje del motivo de viaje residentes debe ser igual a 0!!!');
				return false;
			}
			else if($("#ihpnr").val() == 0 && $("#mvottnr").val() != 0) 
			{
				alert ('El número de NO residentes es 0, por lo tanto el porcentaje del motivo de viaje  de NO residentes debe ser igual a 0!!!');
				return false;
			}
			else
			{
				$.ajax({
					type: "POST",
					url: base_url + "fuente/actualizarModuloIV",
					data: $("#frmModuloIV").serialize(),
					dataType: "html", 
				    cache: false,
					success: function(data){
						var image = $("#imgtab4");
						image.attr("src", base_url + "/images/tick.png");
						$("#tabs").tabs({selected: 4});
					}
				});
			}	
				
		}			
	});
	
	
});

//Funcion para obtener los mensajes de las cajas de texto de las justificaciones
function obtenerMensaje4(campo){
	var mensaje = "";
	switch(campo){
		case 'ihoa':      mensaje = "Justifique por qu&eacute; durante el mes, el n&uacute;mero de habitaciones vendidas fue mayor que el de habitaciones disponibles.";
						  break;
		case 'icva':      mensaje = "En el mes el n&uacute;mero de camas vendidas fue mayor que el n&uacute;mero de camas disponibles &iquest;Se vendieron camas supletorias?";
		                  break;
		case 'thudob':  mensaje = "Verificar porque la tarifa por persona en habitaci&oacute;n sencilla es mayor que la doble.";
						  break;
		case 'thusui':  mensaje = "Verificar porque la tarifa por persona en habitaci&oacute;n sencilla es mayor que la tipo suite.";
						  break;
		case 'thumult':  mensaje = "Verificar porque la tarifa por persona en habitaci&oacute;n sencilla es mayor que la m&uacute;ltiple.";
		  				  break;				  	
		case 'huetot':  mensaje = "Justifique por qu&eacute; durante el mes, el n&uacute;mero total de hu&eacute;spedes es igual al n&uacute;mero de camas vendidas.";
		  				  break;
		/*case 'inalootr':  mensaje = "Si por otro tipo de habitaci&oacute;n s&oacute;lo se diligencia los ingresos de alojamiento el rubro deber&iacute;a ser menor o igual al ingreso total.";
		                  break;*/
	}
	return mensaje;
}

