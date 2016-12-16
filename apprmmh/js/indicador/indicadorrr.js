/**
     * Funciones de JavaScript para el indicador de calidad.
     * @author Jesús Neira Guio SJNEIRAG
     * @since Agosto de 2015
     */
alert("vida hp");
$(function(){
	$("#btnGenerarIndicadorr").click(function(){
		alert("nnnnnn");
		var opcion = $("input[name='radBusqueda']:checked").val();
		var buscar = $("#txtBuscar").val();
		$.ajax({
			type: "POST",
			url: base_url + "asistente/buscarFuentes",
			data: {'opcion': opcion,
				   'buscar': buscar
		    },
			dataType: "html", 
		    cache: false,
			success: function(data){
				$("#divResultados").html(data);
			}
		});			
	});
}
