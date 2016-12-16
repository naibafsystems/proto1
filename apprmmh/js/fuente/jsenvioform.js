//DMDIAZF - Agosto 15, 2012
//Funciones JavaScript para el envio del formulario
//

$(function(){
	
	//Configuracion inicial del formulario
	$("#dmpio").largo(30);
	$("#fedili").largo(10);
	$("#repleg").largo(35);
	$("#responde").largo(35);
	$("#respoca").largo(30);
	$("#teler").largo(13);
	$("#emailr").largo(35);
	
	//Validar el envio del formulario
	//$("#btnModuloEnvio").click(function(){
		$("#frmModuloEnvio").validate({
			rules : {
			    fteObserv: {	maxlength : 500
				},
				/*dmpio :    {	required  :  true
				},
				fedili:    {	required  : true
				},
				repleg :   {	required  : true
				},*/
				responde : {    required : true
				},
				respoca :  {    required : true
				},
				teler : {	    required: true
				}, 
				emailr : {      email: true
				} 
			},
			messages : {
				fteObserv : {
								maxlength : "500 caracteres es el m&aacute;ximo permitido."
				},
				/*dmpio  : {      required  :  "<br/>Falta ciudad diligenciamiento."				
				},
				fedili : {		required  :  "<br/>Falta fecha de diligenciamiento."
				},
				repleg : {	    required  :  "<br/>Falta nombre representante legal."
				},*/
				responde : {    required  :  "<br/>Falta nombre de quien responde la encuesta."
				},
				respoca : {		required  :  "<br/>Falta cargo de quien responde la encuesta."					
				},
				teler   : {		required  :  "<br/>Falta n&uacute;mero telef&oacute;nico de contacto."					
				},
				emailr  : {		email     :  "<br/>No es un correo v&aacute;lido"
				}
			},			
			errorPlacement: function(error, element) {
				element.after(error);		        
				error.css('display','inline');
				error.css('margin-left','10px');				
				error.css('color',"#FF0000");
			},
			submitHandler: function(form) {				
				$.ajax({
					type: "POST",
					url: base_url + "fuente/actualizarModuloEnvio",
					data: $("#frmModuloEnvio").serialize(),
					dataType: "html",
				    cache: false,
					success: function(data){
						var image = $("#imgtab6");
						image.attr("src", base_url + "/images/tick.png");						
						form.submit();												
					}
				});				
			}
		});
	//});
	
});

$(function(){
	
	$("#tabs").tabs({selected: 6});
	$("#fichaObservaciones").hide();
	$("#resultValida").hide();
	
	$("#btnFichaObservaciones").click(function(){
		
		$.ajax({  url: base_url + "fuente/guardarobservacion",
			      data: {'op' : $("#txtOP").val(),
			             'idx' : $("#txtIndex").val(),
			             'obs' : $("#txaFicha").val(),
			             'numord' : $("#txtNumOrden").val(),
			             'numest' : $("#txtNumEstablecimiento").val()
			      },
			      type: "post",
			      dataType: "html",
			      success: function(data){
			    	  $("#fichaObservaciones").dialog("close");
			  		  location.reload();			  		  
			      }
		});
		//$("#fichaObservaciones").dialog("close");
		//location.reload();
				
	});
	
	$("#btnGuardarFicha").click(function(){
		$.ajax({  url: base_url + "fuente/validarEnvio",
			      data: {  'err' : $("#txtErroresValidacion").val(),
						   'numord' : $("#txtNumOrden").val(),
						   'numest' : $("#txtNumEstablecimiento").val()
				  },
				  type: "post",
				  dataType: "html",
				  success: function(data){
					  $("#resultValida").html(data);
					  $("#resultValida").effect('slide','',1500,'');
					  //location.reload();
					  
					  					  
				  }
		});
	});
	
	
});

function corregirFicha(capitulo, campo){
	var item;
	var field = "#" + campo;
	if (capitulo>0){
		item = capitulo - 1;
	}
	else{
		itemo = 0;
	}
	if (campo!=''){
		$(":text").css("border","1px solid #DFDFDF");
		$(field).css("border","1px solid #E00078");
		$(field).focus();
	}
	$("#tabs").tabs({selected: item});
}

function justificarFicha(index){
	//Pregunto si ya habia alguna justificacion hecha anteriormente.
	$("#txtIndex").val(index);
	$.ajax({  url: base_url + "fuente/consultarObservacion",
		      data: {'idx' : index,
					 'numord' : $("#txtNumOrden").val(),
					 'numest' : $("#txtNumEstablecimiento").val()
		      },
		      type: "post",
		      dataType: "html",
		      success: function(data){
		    	  
		    	  if (data=="")
		    		  $("#txtOP").val("I");		    	  
		    	  else
		    		  $("#txtOP").val("U");
			    	  $("#txaFicha").val(data);
				      $("#fichaObservaciones").dialog({
			 		  width: 480,
			 		  title: 'Observaciones ficha de an&aacute;lisis',
			 		  modal: true			
			 	  });
		      }
	});
}

