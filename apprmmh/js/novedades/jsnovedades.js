/**
 * LIBRERIA DE FUNCIONES JAVASCRIPT PARA EL MODULO DE NOVEDADES
 * Daniel M. Díaz Forero
 * Agosto 01 de 2012 
 */

$(function(){
	
	$("#txtFechaVisita").datepicker();
	$("#txtTelFuncionario").numerico().largo(12);
	
		$("#btnGuardarNovedadCR").click(function(){
			
			$("#frmNovedadesCR").validate({
				rules : {
					txtFechaVisita: { required: true
					},
					cmbEstadoEST: {  required: true,
						             comboBox: '-'
					},
					cmbNovedad: { required: true,
						          comboBox: '-'
					},
					txtNombreFuncionario: { required: true					
					},
					txtTelFuncionario: { required: true
					},
					txtCargoFuncionario: { required: true
					},
					txaObsCritico: { required: true				
					}
				},
				//Mensajes de validacion
				messages : {
					txtFechaVisita: { required: "Debe ingresar la fecha de visita."
					},
					cmbEstadoEST: {  required: "Debe seleccionar el estado de la novedad.",
			                         comboBox: "Debe seleccionar el estado de la novedad."
					},
					cmbNovedad: { required: "Debe seleccionar la novedad.",
						          comboBox: "Debe seleccionar la novedad."
					},
					txtNombreFuncionario: { required: "Debe ingresar el nombre del funcionario."					
					},
					txtTelFuncionario: { required: "Debe ingresar el telefono del funcionario."
					},
					txtCargoFuncionario: { required: "Debe ingresar el cargo del funcionario."
					},
					txaObsCritico: { required: "Debe realizar las observaciones de la novedad."				
					}
				},
				//Mensajes de error
				errorPlacement: function(error, element) {
					element.after(error);		        
					error.css('display','inline');
					error.css('margin-left','10px');				
					error.css('color',"#FF0000");
				},
				submitHandler: function(form) {
					//Validar consultas camara
					var chk1 = $('#radActiva').is(':checked');
					var chk2 = $('#radCancelada').is(':checked');
					var chk3 = $('#radNoregistra').is(':checked');	
					if ( !chk1 && !chk2 && !chk3){
						$("#errcam").css('display','inline');
						$("#errcam").css('margin-left','10px');				
						$("#errcam").css('color',"#FF0000");
						$("#errcam").html("Debe seleccionar la consulta realizada a la c&aacute;mara.");
					} 
					else{
						$("#errcam").html("");
						$.ajax({
							type: "POST",
							url: base_url + "novedades/guardarNovedad",
							data: $("#frmNovedadesCR").serialize(),
							dataType: "html",
						    cache: false,
							success: function(data){
								alert("La novedad ha sido registrada exitosamente");
								location.reload();								
							}
						});
					}
				}
			});						
		});	
		
		
		//Guardar las aprobaciones de las novedades
		$("#btnGuardarNovedadCO").click(function(){
			
			//Validar que las observaciones del critico esten diligenciadas, en caso contrario
			//debo obligar a la fuente para que escriba diligencie estos campos.
			
			//Validar el formulario del critico
			$("#frmNovedadesCR").validate({
				rules : {
					txtFechaVisita: { required: true
					},
					cmbEstadoEST: {	required: true,
						            comboBox : '-'
					}
			        ,
					cmbNovedad: { required: true,
			                      comboBox: '-'
		            },
					txtNombreFuncionario: { required: true					
					},
					txtTelFuncionario: { required: true
					},
					txtCargoFuncionario: { required: true
					},
					txaObsCritico: { required: true				
					}					
				},
				//Mensajes de validacion
				messages : {
					txtFechaVisita: { required: "Debe ingresar la fecha de visita."
					},
					cmbEstadoEST: {	required: "Debe seleccionar el estado de la empresa.",
									comboBox: "Debe seleccionar el estado de la empresa."
					}
				    ,
					cmbNovedad: { required: "Debe seleccionar la novedad.",
						          comboBox: "Debe seleccionar la novedad."
					},
					txtNombreFuncionario: { required: "Debe ingresar el nombre del funcionario."					
					},
					txtTelFuncionario: { required: "Debe ingresar el telefono del funcionario."
					},
					txtCargoFuncionario: { required: "Debe ingresar el cargo del funcionario."
					},
					txaObsCritico: { required: "Debe realizar las observaciones de la novedad."				
					}
				},
				//Mensajes de error
				errorPlacement: function(error, element) {
					element.after(error);		        
					error.css('display','inline');
					error.css('margin-left','10px');				
					error.css('color',"#FF0000");
				},
				submitHandler: function(form) {
					//No hago nada
				}
			});
			
			//Validar el formulario del coordinador
			$("#frmCoordinador").validate({
				rules: {
					txaObsCoordinador: {
						required: true
					}
				},
				messages: {
					txaObsCoordinador: {
						required: "Debe ingresar la observaci&oacute;n de Aceptaci&oacute;n y/o rechazo de la novedad."
					}
				},
				errorPlacement: function(error, element) {
					element.after(error);		        
					error.css('display','inline');
					error.css('margin-left','10px');				
					error.css('color',"#FF0000");
				},
				submitHandler: function(form){
					//No hago nada
				}
			});
			
			if ($("#frmNovedadesCR").valid()){
				if ($("#frmCoordinador").valid()){
					//Validar consultas camara
					var chk1 = $('#radActiva').is(':checked');
					var chk2 = $('#radCancelada').is(':checked');
					var chk3 = $('#radNoregistra').is(':checked');	
					if ( !chk1 && !chk2 && !chk3){
						$("#errcam").css('display','inline');
						$("#errcam").css('margin-left','10px');				
						$("#errcam").css('color',"#FF0000");
						$("#errcam").html("Debe seleccionar la consulta realizada a la c&aacute;mara.");
					} 
					else{
						$("#errcam").html("");
						//Verificar si se aprobo o se rechazo la novedad.
						$.ajax({
							type: "POST",
							url: base_url + "novedades/aprobarNovedad",
							data: { //Paso los datos del formulario del critico. Los paso uno a uno, porque el submit es del formulario de coordinador.
								    'txtFechaVisita' : $("#txtFechaVisita").val(),
								    'cmbEstadoEST' : $("#cmbEstadoEST").val(),
								    'radConsultas' : $("input[name='radConsultas']:checked").val(),
								    'cmbNovedad' : $('#cmbNovedad option:selected').val(),
								    'txtNombreFuncionario' : $("#txtNombreFuncionario").val(),
								    'txtTelFuncionario' : $("#txtTelFuncionario").val(),
								    'txtCargoFuncionario' : $("#txtCargoFuncionario").val(),
								    'txaObsCritico' : $("#txaObsCritico").val(),
								    'hddCritico' : $("#hddCritico").val(),
								    'hddNroOrden': $("#hddNroOrden").val(),
								    'hddNroEstablecimiento': $("#hddNroEstablecimiento").val(),
								    'hddNovedad' : $("#hddNovedad").val(),
								    'hddOp' : $("#hddOp").val(),
								    //Paso los datos del formulario del coordinador
								    'radAceptada' : $("input[name='radAceptada']:checked").val(),
								    'txaObsCoordinador' : $("#txaObsCoordinador").val(),
								    'hddCoordinador' : $("#hddCoordinador").val(),
								    'hddNroOrden' : $("#hddNroOrden").val(),
								    'hddNroEstablecimiento' : $("#hddNroEstablecimiento").val(),
								    'hddNovedad' : $("#hddNovedad").val(),
								    'hddValidarCR' : $("#hddValidarCR").val()
							},
							dataType: "html",
						    cache: false,
							success: function(data){
								alert("La novedad ha sido registrada exitosamente");
								location.reload();
								//alert(data);
							}
						});						
					}					
				}
				else{
					//alert("Debe ingresar la observaci&oacute;n de Aceptaci&oacute;n y/o rechazo de la novedad.");
					return false;
				}
			}
			else{
				//alert("Debe diligenciar el reporte de novedades para reportar la novedad");
				return false;
			}
			
			
			/*********************
			
			
			$("#frmCoordinador").validate({
				rules: {
					txaObsCoordinador: {
						required: true
					}
				},
				messages: {
					txaObsCoordinador: {
						required: "Debe ingresar la observaci&oacute;n de Aceptaci&oacute;n y/o rechazo de la novedad."
					}
				},
				errorPlacement: function(error, element) {
					element.after(error);		        
					error.css('display','inline');
					error.css('margin-left','10px');				
					error.css('color',"#FF0000");
				},
				submitHandler: function(form){
					
					//Validar checks de radSI y radNO
					var rad1 = $('#radSI').is(':checked');
					var rad2 = $('#radNO').is(':checked');
					if (!rad1 && !rad2){
						$("#errAcept").css('display','inline');
						$("#errAcept").css('margin-left','10px');				
						$("#errAcept").css('color',"#FF0000");
						$("#errAcept").html("Debe indicar si la novedad fue aceptada o no.");
					}
					else{
						$("#errAcept").html("");
						$.ajax({
							type: "POST",
							url: base_url + "novedades/aprobarNovedad",
							data: $("#frmCoordinador").serialize(),
							dataType: "html",
						    cache: false,
							success: function(data){
								//alert("La novedad ha sido registrada exitosamente");
								alert(data);
							}
						});
					}					
				}
			});
			
			
			****************/
			
		});
		
	
});
	