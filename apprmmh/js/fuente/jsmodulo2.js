//DMDIAZF - Agosto 15, 2012
//Funciones JavaScript para el modulo II de fuente
//

$(function(){
	
	var mensajeGPSSDE = "Justificar el bajo sueldo y salarios del personal temporal contratado directamente por la empresa.";
	var mensajeGPPGPA = "Justificar el bajo sueldo y salarios del personal aprend&iacute;z";
	
	//Configuracion inicial del formulario
	$("#tabs").tabs();
	$("#potpsfr").numerico().largo(7);
	$("#potperm").numerico().largo(7);
	$("#gpper").numerico().largo(7);
	$("#pottcde").numerico().largo(7);
	$("#gpssde").numerico().largo(7);
	$("#pottcag").numerico().largo(7);
	$("#gpppta").numerico().largo(7);
	$("#potpau").numerico().largo(7);
	$("#gppgpa").numerico().largo(7);
	$("#pottot").numerico().largo(7);
	$("#gpsspot").numerico().largo(7);
	//$("#potpau").hint("Universitarios, tecn&oacute;logos o t&eacute;cnicos");
	$("#gpssde").cajaObservaciones('parseInt($("#gpssde").val()) < SMMLV',"divgpssde",mensajeGPSSDE,'obsgpssde');
	$("#gppgpa").cajaObservaciones('parseInt($("#gppgpa").val()) < (SMMLV / 2)',"divgppgpa",mensajeGPPGPA,'obsgppgpa');  //Validaciones para justificar el salario de aprendices.
	
	
	//Lanzo función ajax para saber si la fuente ha diligenciado justificaciones para este capitulo y mostrarlas en el recuadro.
	$.ajax({
		type: "POST",
		url: base_url + "fuente/obtenerObservaciones",
		data: {'campo': 0, 'modulo': 2}, //Se envia el campo en cero para que traiga todas las observaciones del modulo 2
		dataType: "html", 
	    cache: false,
		success: function(data){
			var datos = eval(data);
			if(typeof(datos) != "undefined"){ //Si se recibio alguna respuesta de observaciones 
				for (i=0; i<datos.length; i++){
					var bloquear = "";
					var div = "#div" + datos[i].campo;
					var caja = "obs" + datos[i].campo;
					datos[i].mensaje = obtenerMensaje2(datos[i].campo); //Obtengo el mensaje para la justificacion.
					if (datos[i].bloqueo==true){
						var bloquear = 'disabled = "disabled"';
					}					
					var contenido = '<p>'+datos[i].mensaje+'</p><textarea id="'+caja+'" name="'+caja+'" rows="3" style="width: 75%; border: 1px solid #CCCCCC;"'+ bloquear +'>'+datos[i].descripcion+'</textarea>';
					//Muestro el contenido dentro del div asignado
					$(div).html(contenido);										
				}
			}
																
		}					
	});
	
	
	//Validar el formulario del modulo II (Personal Ocupado promedio y salarios causados en el mes)
	$("#frmModuloII").validate({
		rules : {
			potpsfr : {		required   : true,
							menorQue   : 0
			},
			potperm : {		required   :  true,
			                expresion  : 'parseInt($("#potperm").val())== 0 &&  parseInt($("#gpper").val()) > 0' 
			},
			gpper   : {		required   : true,
							expresion  : 'parseInt($("#potperm").val()) > 0  &&  parseInt($("#gpper").val()) == 0',
							expresion2 : '(parseInt($("#gpper").val()) / parseInt($("#potperm").val()) < SMMLV) '
							//expresion3 : '(parseInt($("#gpper").val()) / parseInt($("#potperm").val()) > SMMLV*25)'	
			},
			pottcde : {		required   : true,
							expresion  : 'parseInt($("#pottcde").val())== 0 &&  parseInt($("#gpssde").val()) > 0'
			},
			gpssde  : {		required   : true,
							expresion  : 'parseInt($("#pottcde").val()) > 0  &&  parseInt($("#gpssde").val()) == 0',
							expresion2 : 'parseInt($("#gpssde").val()) / parseInt($("#pottcde").val()) < SMMLV'
							//expresion3 : '(parseInt($("#gpssde").val()) / parseInt($("#pottcde").val()) > SMMLV*25)'
			},
			pottcag : {		required   : true,
							expresion  : 'parseInt($("#pottcag").val())== 0 &&  parseInt($("#gpppta").val()) > 0'
			},
			gpppta   : {	required   : true,
							expresion  : 'parseInt($("#pottcag").val()) > 0  &&  parseInt($("#gpppta").val()) == 0',
							expresion2 : 'parseInt($("#gpppta").val()) / parseInt($("#pottcag").val()) < SMMLV'
							//expresion3 : 'parseInt($("#gpppta").val()) / parseInt($("#pottcag").val()) > SMMLV*25'	
			},
			potpau  : {		required   : true,
							expresion  : 'parseInt($("#potpau").val())== 0 &&  parseInt($("#gppgpa").val()) > 0'
			},
			gppgpa  : {		required   : true,
							expresion  : 'parseInt($("#potpau").val()) > 0  &&  parseInt($("#gppgpa").val()) == 0'							
							//expresion2 : 'parseInt($("#gppgpa").val()) / parseInt($("#potpau").val()) < 0.75 * SMMLV',
							//expresion3 : 'parseInt($("#gppgpa").val()) / parseInt($("#potpau").val()) > SMMLV*25'
			},
			pottot  : {		required   : true,
							igualQue   : 'parseInt($("#potpsfr").val()) + parseInt($("#potperm").val()) + parseInt($("#pottcde").val()) + parseInt($("#potpau").val())' 
			},
			gpsspot : {		required   : true,		
							igualQue   : 'parseInt($("#gpper").val()) + parseInt($("#gpssde").val()) + parseInt($("#gpppta").val())'
			},
			obsgppgpa: {	required   : true
			}
		},
		messages : {
			potpsfr : {		required   :  "Falta n&uacute;mero de personal propietario, socios y familiares.",
							menorQue   :  "No puede ser negativo."
			},
			potperm : {		required   :  "Falta n&uacute;mero de personal permanente.",
							expresion  :  "Existen salarios sin personal permanente."
			},
			gpper   : {		required   :  "Falta salario de personal permanente.",
							expresion  :  "Existe personal permanente sin salarios.",
							expresion2 :  "<br/>El salario promedio del personal permanente no puede ser menor que el salario m&iacute;nimo mensual legal vigente. Promedie el personal si hay personas que no trabajaron todo el mes."
							//expresion3 :  "<br/>El salario promedio del personal permanente no puede ser mayor a 25 salarios m&iacute;nimos mensuales legales vigentes. Promedie el personal si hay personas que no trabajaron todo el mes."			
			},
			pottcde : {		required   : "Falta n&uacute;mero de personal temporal directo.",
							expresion  : "Existen salarios sin personal temporal directo."
			},
			gpssde  : {		required   : "Falta salario del personal temporal directo.",
							expresion  : "Existe personal temporal directo sin salarios.",
							expresion2 : "<br/>El salario promedio del personal temporal directo no puede ser menor que el salario m&iacute;nimo mensual legal vigente. Promedie el personal si hay personas que no trabajaron todo el mes."
							//expresion3 : "<br/>El salario promedio del personal temporal directo no puede ser mayor a 25 salarios m&iacute;nimos mensuales legales vigentes. Promedie el personal si hay personas que no trabajaron todo el mes."
			},
			pottcag : {		required   : "Falta n&uacute;mero de personal temporal indirecto.",
							expresion  : "Hay un valor cobrado por otras empresas sin que suministren personal temporal."
			},
			gpppta   : {	required   : "Falta salario de personal temporal indirecto.",
							expresion  : "Hay personal temporal con otras empresas sin un valor cobrado por dichas empresas.",
							expresion2 : "<br/>El salario promedio del personal temporal indirecto no puede ser menor que el salario m&iacute;nimo mensual legal vigente. Promedie el personal si hay personas que no trabajaron todo el mes."
							//expresion3 : "<br/>El salario promedio del personal temporal indirecto no puede ser mayor a 25 salarios m&iacute;nimos mensuales legales vigentes. Promedie el personal si hay personas que no trabajaron todo el mes."
			},
			potpau  : {		required   : "Falta n&uacute;mero de personal aprendiz o estudiante.",
							expresion  : "Hay gastos por personal aprendiz sin personas en esta categoria."
			},
			gppgpa  : {		required   : "Falta salario de personal aprendiz o estudiante.",
							expresion  : "Existe personal aprendiz, pero no hay gastos causados por estos."
							//expresion2 : "<br/>El salario promedio del personal aprendiz no puede ser menor que el 75% del salario m&iacute;nimo mensual legal vigente. Promedie el personal si hay personas que no trabajaron todo el mes.",
							//expresion3 : "<br/>El salario promedio del personal aprendiz no puede ser mayor a 25 salarios m&iacute;nimos mensuales legales vigentes. Promedie el personal si hay personas que no trabajaron todo el mes."
			},
			pottot  : {		required   : "Falta personal ocupado.",
							igualQue   : "La suma no corresponde."
			},
			gpsspot : {		required   : "Falta salario del personal ocupado.",								
							igualQue   : "La suma no corresponde."
			},
			obsgppgpa: {	required: "Justifique."
			}
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
			$.ajax({
				type: "POST",
				url: base_url + "fuente/actualizarModuloII",
				data: $("#frmModuloII").serialize(),
				dataType: "html", 
			    cache: false,
				success: function(data){
					var image = $("#imgtab2");
					image.attr("src", base_url + "/images/tick.png");
					$("#tabs").tabs({selected: 2});																								
				}					
			});
		}
	});
	
});


//Funcion para obtener los mensajes de las cajas de texto de las justificaciones
function obtenerMensaje2(campo){
	var mensaje = "";
	switch(campo){
		case 'gppgpa':  mensaje = "Justificar el bajo sueldo y salarios del personal aprend&iacute;z";
		                break;
		default:        mensaje = "Justificar el bajo sueldo y salarios del personal aprend&iacute;z";
		                break;
	}
	return mensaje;
}

//Funcion para obtener los mensajes de las cajas de texto de las justificaciones
function obtenerMensaje3(campo){
	var mensaje = "";
	switch(campo){
		case 'intio1':  mensaje = "Justificar el bajo porcentaje de ingresos por alojamiento en el total de ingresos.";
						break;
		case 'intio2':  mensaje = "Justificar el alto porcentaje de participaci&oacute;n de otros ingresos en el total de ingresos.";
		                break;
		case 'inalo':   mensaje = "Especifique el valor de ingresos por alojamiento.";
						break;
		case 'inoio':   mensaje = "Desagregue el valor de otros ingresos netos operacionales no incluidos.";
						break;
	}
	return mensaje;
}




//Funcion para obtener los mensajes de las cajas de texto de las justificaciones
function obtenerMensaje4(campo){
	var mensaje = "";
	switch(campo){
		case 'ihoa':      mensaje = "Justifique por qu&eacute; durante el mes, el n&uacute;mero de habitaciones vendidas fue mayor que el de habitaciones disponibles.";
						  break;
		case 'icva':      mensaje = "En el mes el n&uacute;mero de camas vendidas fue mayor que el n&uacute;mero de camas disponibles &iquest;Se vendieron camas supletorias?";
		                  break;
		case 'inalosen':  mensaje = "Si por el tipo de habitaci&oacute;n sencilla s&oacute;lo se diligencia los ingresos de alojamiento el rubro deber&iacute;a ser menor o igual al ingreso total.";
						  break;
		case 'inalodob':  mensaje = "Si por el tipo de habitaci&oacute;n doble s&oacute;lo se diligencia los ingresos de alojamiento el rubro deber&iacute;a ser menor o igual al ingreso total.";
						  break;
		case 'inalosui':  mensaje = "Si por el tipo de habitaci&oacute;n suite s&oacute;lo se diligencia los ingresos de alojamiento el rubro deber&iacute;a ser menor o igual al ingreso total.";
		  				  break;				  	
		case 'inalomul':  mensaje = "Si por el tipo de habitaci&oacute;n m&uacute;ltiple s&oacute;lo se diligencia los ingresos de alojamiento el rubro deber&iacute;a ser menor o igual al ingreso total.";
		  				  break;
		case 'inalootr':  mensaje = "Si por otro tipo de habitaci&oacute;n s&oacute;lo se diligencia los ingresos de alojamiento el rubro deber&iacute;a ser menor o igual al ingreso total.";
		                  break;
	}
	return mensaje;
}