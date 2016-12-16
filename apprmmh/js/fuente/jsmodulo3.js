//DMDIAZF - Agosto 15, 2012
//Funciones JavaScript para el modulo III de fuente
//

$(function(){
	
	//Configuracion inicial del formulario
	var mensajeINALO = "Justificar el bajo porcentaje de ingresos por alojamiento en el total de ingresos.";
	var mensajeINTIO = "Justificar el alto porcentaje de participaci&oacute;n de otros ingresos en el total de ingresos.";
	var mensajeINOIO = "Desagregue y justifique valor de otros ingresos operacionales.";
	var mensajeINALO2 = "Especifique el valor de ingresos por alojamiento.";
	var mensajeINOE = "Especifique el ingreso por alquiler de salones indicando los principales eventos realizados.";
	
	$("#inalo").numerico().largo(9);
	$("#inali").numerico().largo(9);
	$("#inba").numerico().largo(9);
	$("#insr").numerico().largo(9);
	$("#inoe").numerico().largo(9);
	$("#inoio").numerico().largo(9);
	$("#intio").numerico().largo(9);
	//$("#inalo").hint("Servicios como: Desayuno, media pens&iacute;on, pensi&oacute;n completa, es decir todo inclu&iacute;do.");	
	$("#inoe").hint("Los ingresos por organizaci&oacute;n de eventos deben incluir la facturaci&oacute;n completa incluso el suministro de alimentos y bebidas en el evento.");
	$("#inoio").hint("Servicios de tel&eacute;fono, fax, Internet, comunicaci&oacute;n m&oacute;vil, otros servicios de telecomunicaciones, lavander&iacute;a, peluquer&iacute;a, spa, gimnasio, piscina, city tours, gu&iacute;as tur&iacute;sticos y servicios receptivos, venta de souvenirs, seguro hotelero, arrendamientos y otros servicios relacionados con la actividad hotelera.");
	$("#intio").cajaObservaciones('parseInt($("#inalo").val()) < 0.5 * parseInt($("#intio").val())','divintio1',mensajeINALO,'obsintio1');
	$("#intio").cajaObservaciones('parseInt($("#inoio").val()) > 0.4 * parseInt($("#intio").val())','divintio2',mensajeINTIO,'obsintio2');
	$("#inalo").cajaObservaciones('parseInt($("#inalo").val()) > 0','divinalo',mensajeINALO2,'obsinalo');
	$("#inoio").cajaObservaciones('parseInt($("#inoio").val()) > 0','divinoio',mensajeINOIO,'obsinoio');
	$("#inoe").cajaObservaciones('parseInt($("#inoe").val()) > 0','divinoe',mensajeINOE,'obsinoe');
	
	//Lanzo función ajax para saber si la fuente ha diligenciado justificaciones para este capitulo y mostrarlas en los recuadros.
	$.ajax({
		type: "POST",
		url: base_url + "fuente/obtenerObservaciones",
		data: {'campo': 0, 'modulo': 3}, //Se envia el campo en cero para que traiga todas las observaciones del modulo 3
		dataType: "html", 
	    cache: false,
		success: function(data){
			var datos = eval(data);
			if(typeof(datos) != "undefined"){ //Si se recibio alguna respuesta de observaciones 
				for (i=0; i<datos.length; i++){
					var bloquear = "";
					var div = "#div"+ datos[i].campo;
					var caja = "obs" + datos[i].campo;
					datos[i].mensaje = obtenerMensaje3(datos[i].campo); //Obtengo el mensaje para la justificacion.
					if (datos[i].bloqueo==true){
						var bloquear = 'disabled = "disabled"';
					}					
					var contenido = '<p>'+datos[i].mensaje+'</p><textarea id="'+caja+'" name="'+caja+'" rows="3" style="width: 75%; border: 1px solid #CCCCCC;"'+ bloquear +'>'+datos[i].descripcion+'</textarea>';
					$(div).html(contenido);
				}
			}																
		}					
	});
	
	//Validar el formulario del Modulo 3 (Ingresos Netos operacionales causados en el mes)
	$("#frmModuloIII").validate({
		rules : {
			inalo    : {	required   		:   true,
							diferenteDe		:   0
			},
			inali    : {	required        :   true,
							menorQue   		:   0
			},
			inba     : {	required        :   true,
							menorQue        :   0
			},
			insr     : {	required        :   true,
							menorQue        :   0
			},
			inoe     : {	required        :   true,
							menorQue        :   0
			},
			inoio    : {	required        :   true,
							menorQue        :   0			
			},
			intio    : {	required        :   true,
							diferenteDe	    :   0,
							igualQue        :   'parseInt($("#inalo").val()) + parseInt($("#inali").val()) + parseInt($("#inba").val()) + parseInt($("#insr").val()) + parseInt($("#inoe").val()) + parseInt($("#inoio").val())'  //La suma no corresponde
			},
			obsintio1 : {	required   		:   true
			},
			obsintio2: {    required		: 	true
			},
			obsinalo: {		required		: 	true
			},
			obsinoe: {		required		: 	true
			},
			obsinoio: {		required		: 	true
			}
		},
		messages : {
			inalo    : {	required   		:   "Falta ingresos por alojamiento.",
							diferenteDe		:   "Falta ingresos por alojamiento."
			},
			inali    : {	required        :   "Falta ingresos por alimentos y bebidas no alcoh&oacute;licas.",
							menorQue        :   "No pueden haber ingresos negativos."
			},
			inba     : {	required        :   "Falta ingresos por bebidas alcoh&oacute;licas y cigarrillos.",
							menorQue        :   "No pueden haber ingresos negativos."
			},
			insr     : {	required        :   "Falta ingresos de Servicios Receptivos.",
							menorQue        :   "No pueden haber ingresos negativos."
			},	
			inoe     : {	required        :   "Falta ingresos por alquiler de salones y/o eventos.",
							menorQue        :   "No pueden haber ingresos negativos."
			},
			inoio    : {	required        :   "Faltan otros ingresos netos operacionales.",
							menorQue        :   "No pueden haber ingresos negativos."
			},
			intio    : {	required        :   "Falta total de ingresos operacionales.",
							diferenteDe     :   "Falta total de ingresos operacionales.",
							igualQue        :   "La suma no corresponde."
			},
			obsintio1 : {	required   		:   "Justifique."
			},
			obsintio2: {    required		: 	"Justifique."
			},
			obsinalo: {		required		: 	"Justifique."
			},
			obsinoe: {		required		: 	"Justifique."
			},
			obsinoio: {		required		: 	"Justifique."
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
				//async: false,
				type: "POST",
				url: base_url + "fuente/actualizarModuloIII",
				data: $("#frmModuloIII").serialize(),
				dataType: "html", 
				cache: false,
				success: function(data){
					var image = $("#imgtab3");
					image.attr("src", base_url + "/images/tick.png");
					$("#tabs").tabs({selected: 3});										
				}
			});
		}
	});
	
});

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
		case 'inoio':   mensaje = "Desagregue y justifique valor de otros ingresos operacionales.";
						break;
		case 'inoe':   mensaje = "Especifique el ingreso por alquiler de salones indicando los principales eventos realizados.";
						break;				
	}
	return mensaje;
}