/**
     * Funciones de JavaScript para el indicador de calidad.
     * @author Jesús Neira Guio SJNEIRAG
     * @since Agosto de 2015
     */
//Actualizar la sesion con el periodo seleccionado en el comboBox de periodos
	$("#cmbPeriodo").change(function(){	
		$('#frmPeriodo').submit();
	});

$(function(){
	$("#btnGenerarIndicadorr").click(function(){
		//alert($("#subsede").val());
		var subsede = $("#subsede").val();
		var generar = $("#GenerarIndicador").val();
		$.ajax({
			type: "POST",
			url: base_url + "indicadorcalidad/generaIndicador",
			data: {'subsede': subsede,
				   'guscar': generar
		    },
			dataType: "html", 
		    cache: false,
			success: function(data){
				//$("#detalle").html(data);
				alert("El inidcador de calidad para la subsede "+subsede+" se registró exitosamente");
				location.reload();
			}
		});			
	});
});

//Modifica los usuarios criticos desde el modulo de asistentes
function modificarUsuario(index){
	$.ajax({	url: base_url + "asistente/UPDUsuario",
				type: "post",
				dataType: "html",
				data: "index=" + index,				
				success: function(data){					
					$("#detalle").dialog("close");
					location.reload();
				}
	});
}

//Carga la columna logro critica
$(document).ready(function()
{
	for (var i = 0; i <= 62; i++) {
		$("input[name=conforme"+i+"]").change(function () {
			var opcion = $(this).val();
			var variable = opcion.split('-');
			$.ajax({
				type: "POST",
				url: base_url + "indicadorcalidad/logrocritica",
				data: {'opcion': variable[0],
						'error':variable[2],
						'peso':variable[3],
						'id':variable[1]
				},
				dataType: "html", 
			    cache: false,
				success: function(data){
					$("#divLogro"+variable[1]+"").html(data);
				}
			});	
		});
	}
});

//Carga la columna valoración critica
$(document).ready(function()
{
	for (var i = 0; i <= 62; i++) {
		$("input[name=conforme"+i+"]").change(function () {
			var opcion = $(this).val();
			var variable = opcion.split('-');
			$.ajax({
				type: "POST",
				url: base_url + "indicadorcalidad/valoracioncritica",
				data: {'opcion': variable[0],
						'error':variable[2],
						'peso':variable[3],
						'id':variable[1]
				},
				dataType: "html", 
			    cache: false,
				success: function(data){
					$("#divValoracion"+variable[1]+"").html(data);
				}
			});	
		});
	}
});

//Limpia el formulario cuando se carga nuevamente el browser
function clearForm(){
	  $('#frm input[type="text"]').each(function(){
	  $(this).val("");  
	  });
	  $('#frm input[type="radio":checked]').each(function(){
	      $(this).checked = false;  
	  });
 }

//Función para grabar la calificación del formlulario
$(function(){
	$("#btnGrabarIndicador").click(function(){
		var cierto=0;
		for ($i=0; $i<=61; $i++){
			if(!$("input:radio[name=conforme"+$i+"]:checked").val()){
				cierto=1;
			}
			
		}
		if(cierto==1){
			alert("Debe seleccionar una opción de conformidad para todas las variables!!");
		}else{$.ajax({
				type: "POST",
				url: base_url + "indicadorcalidad/grabarIndicador",
				data:  $("#frmGrabaIndicador").serialize(),
				dataType: "html", 
			    cache: false,
				success: function(data){
					//$("#detalle").html(data);
					alert("El inidcador de calidad registró exitosamente");
					location.reload();
				}
			});
	}
	});
});

//Función para cambiar el estado del módulo del indicador de calidad
$(function(){
	$("#btnestadoIndicador").click(function(){
		$.ajax({
			type: "POST",
			url: base_url + "indicadorcalidad/actualizaEstadoModuloIndicador",
			data:  $("#frmEstadoIndicador").serialize(),
			dataType: "html", 
		    cache: false,
			success: function(data){
				//$("#detalle").html(data);
				alert("El estado del módulo de inidcador de calidad se actualizó exitosamente");
				location.reload();
			}
		});			
	});
});

//Generar el cierre del indicador de calidad
$(function(){
	$("#btnGenerarCierreIndicador").click(function(){
		var subsede = $("#subsede").val();
		var generar = $("#GenerarIndicador").val();
		del = confirm('¿Esta seguro de generar el cierre del inidcador de calidad?, una vez realizado el cierre no podrá calificar mas formularios.');
		if(del){ 
			$.ajax({
				type: "POST",
				url: base_url + "indicadorcalidad/generaCierreIndicador",
				data:  $("#frmGeneraCierreIndicador").serialize(),
				dataType: "html", 
			    cache: false,
				success: function(data){
					//$("#detalle").html(data);
					alert("El cierre del inidcador de calidad para la subsede "+subsede+" se registró exitosamente");
					location.reload();
				}
			});
		}
	});
});

//Función grabar la acción correctiva del indicador de calidad
$(function(){
	$("#btnAccionCorrectiva").click(function(){
		if($("#accionCorrectiva").val()==''){
			alert("Debe diligenciar la acción correctiva.");
		}else{
			$.ajax({
				type: "POST",
				url: base_url + "indicadorcalidad/actualizaAccionCorrectiva",
				data:  $("#frmAccionCorrectiva").serialize(),
				dataType: "html", 
			    cache: false,
				success: function(data){
					//$("#detalle").html(data);
					alert("La acción correctiva se registró exitosamente");
					location.reload();
				}
			});
		}
	});
});