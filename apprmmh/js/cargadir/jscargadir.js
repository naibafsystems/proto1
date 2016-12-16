/**
 * LIBRERIA DE FUNCIONES JAVASCRIPT PARA LA CARGA DEL DIRECTORIO
 * Daniel Mauricio Díaz Forero
 * Agosto 27 de 2012
 */


$(function(){
	
	$("input[name=radCarga]").click(function(){
		var result = "";
		var check = $("input[@name=radCarga]:checked").val();		
		switch(check){
			case '1': result = "Cargar Directorio de Empresas";
		        	  break;
			case '2': result = "Cargar Directorio de Establecimientos";
					  break;			
		}
		$("#dvCarga").html("<h3>" + result + "</h3>");
	});
	
	
	
	
	
});
