//DMDIAZF - Agosto 15, 2012
//Funciones JavaScript para el envio del formulario
//

$(function(){
	
	//Actualizar la sesion con el periodo seleccionado en el comboBox de periodos
	$("#cmbPeriodo").change(function(){		
		$('#frmPeriodo').submit();
	});
	
	$("#btnOpcionesUser").click(function(){
		$("#frmOpciones").validate({
			rules: {
				txtClaveActual: {	required: true,
									minlength: 6,
									maxlength: 16
				},
				txtNuevaClave: {	required: true,
									minlength: 6,
									maxlength: 16
				},
				txtConfirm: {		required: true,
									minlength: 6,
									maxlength: 16,
									equalTo: "#txtNuevaClave"
				}
			},
			messages: {
				txtClaveActual: {	required: "Debe digitar la clave actual.",
									minlength: "M&iacute;nimo 6 caracteres.",
									maxlength: "M&aacute;ximo 16 caracteres."
				},
				txtNuevaClave: {	required: "Debe digitar la nueva clave.",
									minlength: "M&iacute;nimo 6 caracteres.",
									maxlength: "M&aacute;ximo 16 caracteres."
				},
				txtConfirm: {		required: "Debe confirmar la nueva clave.",
									minlength: "M&iacute;nimo 6 caracteres.",
									maxlength: "M&aacute;ximo 16 caracteres.",
									equalTo: "No coincide con la nueva clave."
				}
			}, 
			errorPlacement: function(error, element) {
				$("#errusuario").html("");
				element.after(error);		        
				error.css('display','inline');
				error.css('margin-left','10px');				
				error.css('color',"#FF0000");
			}
		});
	});
	
});
