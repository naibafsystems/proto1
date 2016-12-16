/**********************************************************************************
 * Daniel Mauricio Díaz Forero
/*
 * Marzo 13 de 2012
 * Libreria para la validacion de formularios de captura (Encuestas DANE)
 * Requiere de JQuery jquery-1.7.1.min.js y JQuery Validator jquery.validate.js
 **********************************************************************************/


/*****/

	//*****************************************************************************************
    //* Establece variables de configuracion general de la libreria
    //*****************************************************************************************

	var base_url = "/rmmh/";  //Ruta base para ejecutar AJAX en CodeIgniter
	var SMMLV = obtenerSalario(); //Se elimina para evitar que el valor se vaya "hard-coded" en el script.
	                              //En este caso pregunto con AJAX el valor de la variable para el periodo
	                              //que se encuentra en el Script.
	
	
	$.fn.confirmar = function(){
		return this.click(function(event){
			$("#dialog").dialog();
		});   
	};
	
	
	
	//**************************************************************************************************
	//* Mostrar Ocultar caja de texto de observaciones para la fuente 
	//**************************************************************************************************
	$.fn.cajaObservaciones = function(expresion, div, mensaje, nombreCaja){
		return this.blur(function(event){
			var contenido = "";
			var mydiv = "#" + div;			
			$(mydiv).empty();
			if (parseInt($(this).val())>0 && eval(expresion)==true){
				contenido = '<p>'+mensaje+'</p><textarea id="'+nombreCaja+'" name="'+nombreCaja+'" rows="3" style="width: 75%; boder: 1px solid #CCCCCC;"></textarea>';
				$(mydiv).html(contenido);
			}
			else{
				$(mydiv).html("");
			}
		});
	};
	
	//**************************************************************************************************
	//* Bloquear cajas de texto
	//**************************************************************************************************
	$.fn.bloquearCajas = function(string){
		return this.blur(function(event){
			var miArray = string.split(',');
			if ((parseInt($(this).val())==0)||(parseInt($(this).val())<0)){
				for (i=0; i<miArray.length; i++){
					var temp = "#" + miArray[i];
					$(temp).attr("disabled","disabled");				
				}
			}
			else {
				for (i=0; i<miArray.length; i++){
					var temp = "#" + miArray[i];					
					$(temp).removeAttr("disabled");					
				}
			}
		});
	};
	
	//***************************************************************************************************
	//* Mostrar / ocultar elementos de acuerdo a un valor
	//***************************************************************************************************
	$.fn.mostrarCajas = function(div){
		return this.blur(function(event){			
			var divTest = "#" + div;
			if ((parseInt($(this).val())==0)||(parseInt($(this).val())<0)){
				$(divTest).hide();
			}
			else{
				$(divTest).show();
			}
		});
	};
	
	//**************************************************************************************************
	//* Remueve todos los estilos de error de la libreria
	//**************************************************************************************************
	$.fn.cleanForm = function(){
		$(":text").css('border','1px solid #CCCCCC');	
		$("img").remove();
	};
	
	//**************************************************************************************************
	//* Funcion para mostrar mensajes de error cuando se encuentra en un espacio reducido 
	//**************************************************************************************************
	
	$.fn.errorMSG = function(mensaje){
		var id = $(this).attr('id');
		var image = base_url + "images/error.png";
		var imgprev = "#hint"+id;		
		if($(imgprev).length == 0){
			$(this).css('border','1px solid #FF0000');
			$(this).parent().append('&nbsp;<img id="hint'+id+'" src="'+image+'" border="0"/>&nbsp;');
			return $("#hint"+id).qtip({
				content: mensaje,
				style: {  width: 300,
						  padding: 5,
						  background: '#FFEEEE',
						  color: 'black',
						  textAlign: 'left',
						  border: { width: 1,
		                            radius: 5,
		                            color: '#E00078'
		                  },
		                  tip: 'topLeft',
		                  name: 'dark' // Inherit the rest of the attributes from the preset dark style
		        }
			});
		}
	};
	
	
	//**************************************************************************************************
	//* Pruebas para generar los hints de los formularios de cada capitulo
	//**************************************************************************************************
	$.fn.hint = function(mensaje){
		var id = $(this).attr('id');
		var image = base_url + "/images/help.png";
		$(this).parent().append('&nbsp;&nbsp;<img id="hint'+id+'" src="'+image+'" border="0"/>&nbsp;&nbsp;');
		return $("#hint"+id).qtip({
			content: mensaje,
			style: {  width: 300,
					  padding: 5,
					  background: '#FFEEEE',
					  color: 'black',
					  textAlign: 'left',
					  border: { width: 1,
	                            radius: 5,
	                            color: '#E00078'
	                  },
	                  tip: 'topLeft',
	                  name: 'dark' // Inherit the rest of the attributes from the preset dark style
	        }
		});		
	};
	
	//**************************************************************************************************
	//* Establece la longitud de caracteres que debe tener una caja de texto 
	//**************************************************************************************************
	$.fn.largo = function(expresion) {
		return this.keypress(function(event){
			if ((event.which == 8)||(event.which == 0)) 
				return true;
			else if ($(this).val().length < expresion)
					return true;
				 else
					return false;
		});     
	};
	
	
	//*****************************************************************************************************************
	//* Establece todo el CRUD para las observaciones de cada capitulo del formulario (ver codigo en los controladores)
	//*****************************************************************************************************************
	$.fn.observaciones = function(capitulo, div, expresion, mensaje){
		return this.blur(function(event){
			var nombreCampo = "obs" + $(this).attr('id');
			var mensajeCampo = "msg" + $(this).attr('id');
			//Pregunto si el campo de la observacion ya existe en el formulario, para no agregar dos veces el mismo campo
			if($('#obs' + $(this).attr('id')).length == 0){
				//Pregunto si se cumple la regla de validacion para mostrar el campo
				if (eval(expresion)==true){					
					//Preguntar si existen observaciones ya registradas en la base de datos
					$.ajax({
						type: "POST",
						url: base_url + "fuente/obtenerObservaciones",
						data: { 'campo' : $(this).attr('id'), 'modulo' : capitulo },
						cache: false,
						success: function(data){
							var datos = eval(data);
							var divObs = "#" + div;
							if (datos.length >0){
								//Si existen observaciones en la base de datos. las muestro en el formulario junto con sus valores.								
								for (i=0; i<datos.length; i++){
									var control = "obs" + datos[i].campo;
									var pmensaje = "msg" + datos[i].campo;
									var pregunta = datos[i].mensaje;
									$("#"+div).append('<p id="'+pmensaje+'" align="left"><b>'+pregunta+'</b></p><textarea id="'+control+'" name="'+control+'" rows="3" style="width: 75%;">'+datos[i].descripcion+'</textarea>');
								}
							}
							else{
								//Se cumplen todas las reglas de validacion, pero no existen observaciones registradas en el formulario.
								$("#"+div).append('<p id="'+mensajeCampo+'" align="left"><b>'+mensaje+'</b></p><textarea id="'+nombreCampo+'" name="'+nombreCampo+'" style="width: 75%;" rows="3"></textarea>');	
							}
						}
					});										
				}
			}
			else{
				//Si el campo ya existe en el formulario, debo eliminarlo, porque se recibio un cero como valor
				if (eval(expresion)!=true){
					$("#"+mensajeCampo).remove();
					$("#"+nombreCampo).remove();
				}
			}
		});
	};
	
	
	//*****************************************************************************************
	//* Actualiza el valor de una caja de texto a partir de los valores de otras cajas de texto
	//*****************************************************************************************
	$.fn.actualizarValor = function(element,expresion){
		return this.blur(function(event){
			var target = "#" + element;
			var valor = eval(expresion);			
			if (isNaN(valor))
				valor = 0;
			$(target).val(valor);
		});
	};
	
	//*****************************************************************************************
	//* Ejecuta una funcion ajax para actualizar un comboBox
	//*****************************************************************************************
	$.fn.cargarCombo = function(element,url){
		return this.change(function(event){
			$.ajax({
				type: "POST",
				url: base_url + url,
				data: "id=" + $(this).val(),
			    dataType: "html",
				cache: false,
				success: function(html){
					var target = "#" + element;
					$(target).html("");
					$(html).appendTo(target);									
				}
			});
		});
	};

	//*****************************************************************************************
	//* Convierte todos los caracteres de una caja de texto a mayusculas cuando pierde el foco
	//*****************************************************************************************
	$.fn.mayusculas = function(){
		return this.blur(function(event){
			$(this).val($(this).val().toUpperCase());
		});
	};
	
	//*****************************************************************************************
	//* Convierte todos los caracteres de una caja de texto a minusculas cuando pierde el foco
	//*****************************************************************************************
	$.fn.minusculas = function(){
		return this.blur(function(event){
			$(this).val($(this).val().toLowerCase());
		});
	};

	
	//*************************************************************************************************
	//* Bloquea el ingreso de caracteres de texto sobre una caja de texto, pero permite puntos y comas
	//*************************************************************************************************
	$.fn.bloquearTextoPuntos = function() {
		return this.keypress(function(event){
    		if ((event.which == 8)||(event.which == 0)||(event.which == 44)||(event.which == 46)) return true;
    		if ((event.which >=48)&&(event.which <=57)) 
    			return true;
    		else
    			return false;    		
		});     
	};
	
	//************************************************************************
	//* Bloquea el ingreso de caracteres de texto sobre una caja de texto
	//************************************************************************
	$.fn.numerico = function() {
	    return this.keypress(function(event){
	    		if ((event.which == 8)||(event.which == 0)) return true;
	    		if ((event.which >=48)&&(event.which <=57)) 
	    			return true;
	    		else
	    			return false;    		
	    });    
	};
	
	//************************************************************************
	//* Bloquea el ingreso de caracteres numericos sobre una caja de texto
	//************************************************************************
	$.fn.bloquearNumeros = function() {
	    return this.keypress(function(event){
	    		if ((event.which<48)||(event.which>57))
	    			return true;
	    		else
	    			return false;
	    });    
	};


	//************************************************************************
	//* Configura y ajusta todos los calendarios de jQuery en idioma español
	//************************************************************************
	$.datepicker.regional['es'] = { closeText: 'Cerrar',
			                        currentText: 'Hoy',
			                        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			                        monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
			                        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
			                        dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','S&aacute;b'],
			                        dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
			                        weekHeader: 'Sem',
			                        dateFormat: 'dd/mm/yy',
			                        firstDay: 1,
			                        isRTL: false,
			                        showMonthAfterYear: false,
			                        yearSuffix: ''
	};
	$.datepicker.setDefaults($.datepicker.regional['es']);
	
	
	//****************************************************************************
	//* Valida que el valor por defecto de un comboBox no se haya seleccionado 
	//****************************************************************************
	$.validator.addMethod("comboBox",function (value, element, param) {
		var idx = (param).toString(); 
		if($(element).val()==idx)
		    return false;
		else
		    return true;
	},"");

	
	//***************************************************************************
	//** Compara y valida el valor de una caja de texto
	//***************************************************************************
	$.validator.addMethod("igualQue",function(value, element, param){
		var comp = convertirOperacion(param); 
		var valor = parseInt($(element).val());
		if (valor!=comp)
			return false;
		else
			return true;
	},"");
	
	//***************************************************************************
	//** Compara y valida el valor de una caja de texto (Si es distinto del valor)
	//***************************************************************************
	$.validator.addMethod("diferenteDe",function(value, element, param){
		var comp = convertirOperacion(param); 
		var valor = parseInt($(element).val());
		if (valor==comp)
			return false;
		else
			return true;
	},"");
	
	//*****************************************************************************************************************
	//** Compara y valida que el valor de una caja de texto sea menor o igual que el valor que se recibe por parametro
	//*****************************************************************************************************************
	$.validator.addMethod("menorIgualQue",function(value, element, param){
		var comp = convertirOperacion(param); 
		var valor = parseInt($(element).val());
        if (valor <= comp){			                            	  
      	  return false;
        }
        else{
      	  return true;
        }
    },"");
	
	
	//****************************************************************************************************************
	//** Compara y valida que el valor de una caja de texto sea mayor que el valor que se recibe por parametro
	//****************************************************************************************************************
	$.validator.addMethod("mayorQue",function(value, element, param){
		var comp = convertirOperacion(param);
		var valor = parseInt($(element).val());
	    if (valor > comp)			                            	  
	        return false;
		else
		    return true;		    
	},"");
	
	
	//*****************************************************************************************************************
	//** Compara y valida que el valor de una caja de texto sea mayor o igual que el valor que se recibe por parametro
	//*****************************************************************************************************************
	$.validator.addMethod("mayorIgualQue",function(value, element, param){
		var comp = convertirOperacion(param);
		var valor = parseInt($(element).val());
        if (valor >= comp)			                            	  
            return false;
        else
            return true;
    },"");
	
	
	//****************************************************************************************************************
	//** Compara y valida que el valor de una caja de texto sea menor que el valor que se recibe por parametro
	//****************************************************************************************************************
	$.validator.addMethod("menorQue",function(value, element, param){
		var comp = convertirOperacion(param);
		var valor = parseInt($(element).val());
	    if (valor < comp)			                            	  
	        return false;
		else
		    return true;		    
	},"");
	
	
	//****************************************************************************************************************
	//** Compara y valida que el valor de una caja de texto contra una expresion completa escrita en jQuery
	//****************************************************************************************************************
	$.validator.addMethod("expresion",function(value, element, param){
		var comp = convertirExpresion(param);
		if (comp){
			return false;
		}	
		else{
			return true;
		}
	},"");
	
	$.validator.addMethod("expresion2",function(value, element, param){
		var comp = convertirExpresion(param);
		if (comp){
			return false;
		}	
		else{
			return true;
		}
	},"");
	
	$.validator.addMethod("expresion3",function(value, element, param){
		var comp = convertirExpresion(param);
		if (comp){
			return false;
		}	
		else{
			return true;
		}
	},"");
	
	
	//*****************************************************************************************************************
	//** Funcion para validar que una fecha dada sea una fecha valida
	//*****************************************************************************************************************
	$.validator.addMethod("fecha",function(value, element, param){
		var strFecha = $(element).val().toString();
		//Separar la fecha, y validarla por aparte
		var arrayFecha = strFecha.split("/");
		var myDate = new Date();
		myDate.setFullYear(arrayFecha[2],arrayFecha[1]-1,arrayFecha[0]);
		
		alert(myDate);
		
		/*
		if (esFechaValida(myDate)){
			return true;
		}
		else{
			return false;
		}
		*/
	},"");
	
	
	
	
	
	//**************************************************************************************************
	//** Funciones adicionales utilizadas por las reglas de validacion adicionales del jQuery Validator
	//**************************************************************************************************
	
	//1) Evalua una cadena de texto recibida como parametro y retorna el resultado 
	function convertirOperacion(cadena){
		var result = 0;
		if ((typeof cadena)=='string')
			result = eval(cadena);	
		else if((typeof cadena)=='number')
			result = cadena;
		return parseInt(result);
	}
	
	//2) Evalua una cadena de texto recibida como parametro y retorna un valor de verdadero o falso 
	function convertirExpresion(cadena){
		var result = false;
		if ((typeof cadena)=='string')		
			result = (eval(cadena))?true:false;
		return result;
	}
	
	//3) Funcion que me dice cual es el número de dias en un mes
	function diasEnMes(mes, ano) {
		return new Date(ano || new Date().getFullYear(), mes, 0).getDate();
	}
	
	//4) Funcion que me dice si un objeto ya se encuentra cargado o no dentro del DOM
	function isDefined(variable) {
	    return (typeof(window[variable]) == "undefined")?  false: true;
	}
	
	//5) Funcion para obtener los valores de las cajas de texto. Si la caja de texto viene vacia, por defecto 
	//   asigane el valor de cero. 
	function obtenerValor(nombrecampo){
		var valor;
		valor = $(nombrecampo).val();
		if (valor==""){
			valor = 0;
		}
		return parseInt(valor);
	}
	
	//6) Funcion para obtener el numero de dias en un mes dado el año y el mes.
	function diasEnElMes(mes, ano){
		return 32 - new Date(ano,(mes-1),32).getDate();		
	}
	
	//7) Funcion para obtener la fecha actual con JavaScript
	function fechaActual(){
		var date = new Date();
		var d  = date.getDate();
		var day = (d < 10) ? '0' + d : d;
		var m = date.getMonth() + 1;
		var month = (m < 10) ? '0' + m : m;
		var yy = date.getYear();
		var year = (yy < 1000) ? yy + 1900 : yy;
		var today = year + "-" + month + "-" + day;	
		return today;
	}
	
	//8) Convertir una cadena en una fecha
	function parseDate(str) {
		var m = str.match(/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/);
		return (m) ? new Date(m[3], m[2]-1, m[1]) : null;
	}
	
	//9) Funcion para obtener el valor del SMMLV para el periodo actual
	function obtenerSalario(){
		var result = "";
		$.ajax({
			type: "POST",
			url: base_url + "administrador/obtenerSalario",
			dataType: "json",
			cache: false,
			async: false, //OJO. No eliminar.
			success: function(data){
				var obj = eval('(' + data + ')');
				result = parseFloat(obj);
			}
		});	
		return result;
	}
