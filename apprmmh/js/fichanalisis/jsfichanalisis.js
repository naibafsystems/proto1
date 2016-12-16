//DMDIAZF - Julio 03 de 2012
//Funciones JavaScript para la validacion de la ficha tecnica.

$(function(){
	
	$("#tabs").tabs({selected: 6});
	$("#fichaObservaciones").hide();
	$("#resultValida").hide();
	
	$("#btnFichaObservaciones").click(function(){
		
		$.ajax({  url: base_url + "fichanalisis/guardarobservacion",
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
		$.ajax({  url: base_url + "fichanalisis/validarEnvio",
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
		$(field).css("border","2px solid #E00078");
		$(field).focus();
	}
	$("#tabs").tabs({selected: item});
}

function justificarFicha(index){
	//Pregunto si ya habia alguna justificacion hecha anteriormente.
	$("#txtIndex").val(index);
	$.ajax({  url: base_url + "fichanalisis/consultarObservacion",
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