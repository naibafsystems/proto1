//DMDIAZF - Agosto 15, 2012
//Funciones JavaScript para el modulo 1 de fuente
//

$(function(){
	
	//Configuracion inicial del formulario
	$("#tabs").tabs();
	$("#idproraz").mayusculas().largo(60);
	$("#idnomcom").mayusculas().largo(60);	
	$("#idsigla").mayusculas().largo(20);	
	$("#iddirecc").mayusculas().largo(40);	
	$("#iddepto").cargarCombo("idmpio","fuente/actualizarmunicipios");  
	$("#idtelno").numerico().largo(13);	
	$("#idfaxno").numerico().largo(13);
	$("#idpagweb").minusculas().largo(255);
	$("#idcorreo").minusculas().largo(80);	
	$("#finicial").datepicker();
	$("#ffinal").datepicker();
	//$("#ffinal").hint("Referente al periodo que se ofreci&oacute; el servicio de alojamiento - Fecha de operaci&oacute;n.");
	$("#idnomcomest").mayusculas().largo(60);
	$("#idsiglaest").mayusculas().largo(20);
	$("#iddireccest").mayusculas().largo(40);
	$("#iddeptoest").cargarCombo("idmpioest","fuente/actualizarmunicipios");
	$("#idtelnoest").numerico().largo(13);	
	$("#idfaxnoest").numerico().largo(13);
	$("#idcorreoest").minusculas().largo(80);
	
	//Validar el formulario del modulo I (Caratula)
	//$("#btnModuloI").click(function(){
		$("#frmModuloI").validate({
			rules : {
				idproraz : {	required   :  true
				},
				idnomcom : {	required   :  true
				},
				idsigla  : {	maxlength  :  20 
				},
				iddirecc : {	required   :  true	
				},
				iddepto  : {	comboBox   :  '-'
				},
				idmpio   : {	comboBox   :  '-'
				},
				idtelno  : {	required   :  true,
				                min        :  7
				},
				idpagweb : {    required   : false,
								url        : true
				},
				idcorreo : {	email      :  true
				},
				finicial : {	required   :  true									
				},
				ffinal   : {	required   :  true															
				},
				idnomcomest: {  required   :  true
				},
				idsiglaest: {   maxlength  :  20
				},
				iddireccest : {	required   :  true	
				},
				iddeptoest  : {	comboBox   :  '-'						
				},
				idmpioest   : {	comboBox   :  '-'
				},
				idtelnoest  : {	required   :  true,
                                min        :  7
				},
				idcorreoest : {	email      :  true
				}
			},
			messages : {
				idproraz : {	required   :  "Falta la raz&oacute;n social."		
				},
				idnomcom : {    required   :  "Falta nombre comercial."					
				},
				idsigla  : {	maxlength  :  "M&aacute;ximo 20 caracteres."
				},
				iddirecc : {	required   :  "Falta la direcci&oacute;n de la gerencia."					
				},
				iddepto  : {	comboBox   :  "Falta el nombre del departamento."						
				},
				idmpio   : {	comboBox   :  "Falta el nombre del municipio."
				},
				idtelno  : {	required   :  "Falta n&uacute;mero de tel&eacute;fono.",
					            min        :  "M&iacute;nimo 7 D&iacute;gitos."
				},
				idpagweb : {    required   : "",
								url        : "Si no est&aacute; diligenciado no incluya leyendas, dejar en blanco."
				},
				idcorreo : {	email      : "Si no est&aacute; diligenciado no incluya leyendas, dejar en blanco."					
				},
				finicial : {	required   : "Falta fecha inicial."										
				},
				ffinal   : {	required   : "Falta fecha final."
				},
				idnomcomest: {  required   : "Falta nombre comercial establecimiento."
				},
				idsiglaest: {   maxlength  : "M&aacute;ximo 20 caracteres."
				},
				iddireccest : {	required   : "Falta la direcci&oacute;n del establecimiento."
				},
				iddeptoest  : {	comboBox   : "Falta el nombre del departamento."						
				},
				idmpioest   : {	comboBox   : "Falta el nombre del municipio."
				},
				idtelnoest  : {	required   : "Falta n&uacute;mero de tel&eacute;fono.",
		                         min       : "M&iacute;nimo 7 D&iacute;gitos."
				},
				idcorreoest : {	email      : "Si no est&aacute; diligenciado no incluya leyendas, dejar en blanco."
				}
			},
			errorPlacement: function(error, element) {
				//Mostrar el error en la parte de abajo de la caja de texto.
				element.after(error);		        
				error.css('display','block');
				error.css('float','none');
				error.css('vertical-align','top');
				error.css('margin-left','10px');				
				error.css('color',"#FF0000");
			},
			submitHandler: function(form) {
				//Valido las fechas antes de hacer el submit de la caratula
				var finicial = $("#finicial").val();
				var ffinal = $("#ffinal").val();
				var ini = parseDate(finicial);			
				var fin = parseDate(ffinal);
				if (ini > fin){
					$("#divError").html("La fecha inicial debe ser anterior a la fecha final.");
					return false;
				}
				else{
					//Luego de validadas las fechas hago el submit del formulario
					$("#divError").html("");
					$.ajax({
						type: "POST",
						url: base_url + "fuente/actualizarModuloI",
						data: $("#frmModuloI").serialize(),
						dataType: "html",
						cache: false,
						success: function(data){
							
							//alert(data);
							var image = $("#imgtab1");
					   		image.attr("src", base_url + "/images/tick.png");						    
					   		$("#tabs").tabs({selected: 1});					   							   							   								   								   		
						}
					});
				}								
			}
		});		
	//});
	
	
	
});