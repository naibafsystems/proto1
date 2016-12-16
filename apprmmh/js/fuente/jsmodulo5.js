// DMDIAZF - Octubre 29, 2012
// Funciones JavaScript para el módulo V - Clasificacion CIIU4 
// Modificada hoy, Diciembre 10 de 2012



$(function(){
	
	/*//Validar el formulario del modulo 4 (Caracteristicas de los hoteles)
	$("#frmModuloV").validate({
		rules : {
			otroServicio:{required:true
			}
		},
		messages : {
			otroServicio:{required:"Este campo es obligatorio."
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
			result1= true;
		}
	});*/
	
	// Solo se puede señalar una de las seis categorias
	$("#chkCategoria1").click(function(){
		if ($("#chkCategoria1").attr("checked")){
			$("#chkCategoria2").attr("disabled",true);
			$("#chkCategoria2").prop("checked",false);
			$("#chkCategoria3").attr("disabled",true);
			$("#chkCategoria3").prop("checked",false);
			$("#chkCategoria4").attr("disabled",true);
			$("#chkCategoria4").prop("checked",false);
			$("#chkCategoria5").attr("disabled",true);
			$("#chkCategoria5").prop("checked",false);
			$("#chkCategoria6").attr("disabled",true);
			$("#chkCategoria6").prop("checked",false);
			$('[name^=chkServicios2]').attr("disabled",true);
			$('[name^=chkServicios3]').attr("disabled",true);
			$('[name^=chkServicios4]').attr("disabled",true);
			$('[name^=chkServicios5]').attr("disabled",true);
			$('[name^=chkServicios6]').attr("disabled",true);
		}
		else{
			$('[name^=chkCategoria]').attr("disabled",false);
			$('[name^=chkServicios]').attr("disabled",false);
			$('[name^=chkServicios]').attr("checked",false);
		}
	});
	
	
	$("#chkCategoria2").click(function(){
		if ($("#chkCategoria2").attr("checked")){
			$("#chkCategoria1").attr("disabled",true);
			$("#chkCategoria1").prop("checked",false);
			$("#chkCategoria3").attr("disabled",true);
			$("#chkCategoria3").prop("checked",false);
			$("#chkCategoria4").attr("disabled",true);
			$("#chkCategoria4").prop("checked",false);
			$("#chkCategoria5").attr("disabled",true);
			$("#chkCategoria5").prop("checked",false);
			$("#chkCategoria6").attr("disabled",true);
			$("#chkCategoria6").prop("checked",false);
			$('[name^=chkServicios1]').attr("disabled",true);
			$('[name^=chkServicios3]').attr("disabled",true);
			$('[name^=chkServicios4]').attr("disabled",true);
			$('[name^=chkServicios5]').attr("disabled",true);
			$('[name^=chkServicios6]').attr("disabled",true);
		}
		else{
			$('[name^=chkCategoria]').attr("disabled",false);
			$('[name^=chkServicios]').attr("disabled",false);
			$('[name^=chkServicios]').attr("checked",false);
		}
	});
	
	$("#chkCategoria3").click(function(){
		if ($("#chkCategoria3").attr("checked")){
			$("#chkCategoria1").attr("disabled",true);
			$("#chkCategoria1").prop("checked",false);
			$("#chkCategoria2").attr("disabled",true);
			$("#chkCategoria2").prop("checked",false);
			$("#chkCategoria4").attr("disabled",true);
			$("#chkCategoria4").prop("checked",false);
			$("#chkCategoria5").attr("disabled",true);
			$("#chkCategoria5").prop("checked",false);
			$("#chkCategoria6").attr("disabled",true);
			$("#chkCategoria6").prop("checked",false);
			$('[name^=chkServicios1]').attr("disabled",true);
			$('[name^=chkServicios2]').attr("disabled",true);
			$('[name^=chkServicios4]').attr("disabled",true);
			$('[name^=chkServicios5]').attr("disabled",true);
			$('[name^=chkServicios6]').attr("disabled",true);
		}
		else{
			$('[name^=chkCategoria]').attr("disabled",false);
			$('[name^=chkServicios]').attr("disabled",false);
			$('[name^=chkServicios]').attr("checked",false);
		}
	});
	
	$("#chkCategoria4").click(function(){
		if ($("#chkCategoria4").attr("checked")){
			$("#chkCategoria1").attr("disabled",true);
			$("#chkCategoria1").prop("checked",false);
			$("#chkCategoria2").attr("disabled",true);
			$("#chkCategoria2").prop("checked",false);
			$("#chkCategoria3").attr("disabled",true);
			$("#chkCategoria3").prop("checked",false);
			$("#chkCategoria5").attr("disabled",true);
			$("#chkCategoria5").prop("checked",false);
			$("#chkCategoria6").attr("disabled",true);
			$("#chkCategoria6").prop("checked",false);
			$('[name^=chkServicios1]').attr("disabled",true);
			$('[name^=chkServicios2]').attr("disabled",true);
			$('[name^=chkServicios3]').attr("disabled",true);
			$('[name^=chkServicios5]').attr("disabled",true);
			$('[name^=chkServicios6]').attr("disabled",true);
		}
		else{
			$('[name^=chkCategoria]').attr("disabled",false);
			$('[name^=chkServicios]').attr("disabled",false);
			$('[name^=chkServicios]').attr("checked",false);
		}
	});
	
	$("#chkCategoria5").click(function(){
		if ($("#chkCategoria5").attr("checked")){
			$("#chkCategoria1").attr("disabled",true);
			$("#chkCategoria1").prop("checked",false);
			$("#chkCategoria2").attr("disabled",true);
			$("#chkCategoria2").prop("checked",false);
			$("#chkCategoria3").attr("disabled",true);
			$("#chkCategoria3").prop("checked",false);
			$("#chkCategoria4").attr("disabled",true);
			$("#chkCategoria4").prop("checked",false);
			$("#chkCategoria6").attr("disabled",true);
			$("#chkCategoria6").prop("checked",false);
			$('[name^=chkServicios1]').attr("disabled",true);
			$('[name^=chkServicios2]').attr("disabled",true);
			$('[name^=chkServicios3]').attr("disabled",true);
			$('[name^=chkServicios4]').attr("disabled",true);
			$('[name^=chkServicios6]').attr("disabled",true);
		}
		else{
			$('[name^=chkCategoria]').attr("disabled",false);
			$('[name^=chkServicios]').attr("disabled",false);
			$('[name^=chkServicios]').attr("checked",false);
		}
	});
	
	$("#chkCategoria6").click(function(){
		if ($("#chkCategoria6").attr("checked")){
			$("#chkCategoria1").attr("disabled",true);
			$("#chkCategoria1").prop("checked",false);
			$("#chkCategoria2").attr("disabled",true);
			$("#chkCategoria2").prop("checked",false);
			$("#chkCategoria3").attr("disabled",true);
			$("#chkCategoria3").prop("checked",false);
			$("#chkCategoria4").attr("disabled",true);
			$("#chkCategoria4").prop("checked",false);
			$("#chkCategoria5").attr("disabled",true);
			$("#chkCategoria5").prop("checked",false);
			$('[name^=chkServicios1]').attr("disabled",true);
			$('[name^=chkServicios2]').attr("disabled",true);
			$('[name^=chkServicios3]').attr("disabled",true);
			$('[name^=chkServicios4]').attr("disabled",true);
			$('[name^=chkServicios5]').attr("disabled",true);
		}
		else{
			$('[name^=chkCategoria]').attr("disabled",false);
			$('[name^=chkServicios]').attr("disabled",false);
			$('[name^=chkServicios]').attr("checked",false);
		}
	});
	
	
	if ($("#chkServicios112").prop("checked")){
		$("#divihoa").show();
	}
	 
	
    
	
	$("#btnModuloV").click(function(){
		//Validar cada una de las categorias
		var arrayCategorias = ["chkCategoria1","chkCategoria2","chkCategoria3","chkCategoria4","chkCategoria5","chkCategoria6"];
		var categoriasChecked = new Array();
		//Recorrer el array de categorias
		for (i=0; i<arrayCategorias.length; i++){
			var checkCategoria = "#" + arrayCategorias[i];
			if ($(checkCategoria).attr("checked")){ //Si la categoria esta chequeada, valido los servicios
				var categoria = i + 1;
				categoriasChecked.push(categoria); //Guardo la categoria seleccionada 
			}
		}
		
		if (categoriasChecked.length > 0){
			for (j=0; j<categoriasChecked.length; j++){ //Recorrer el array que contiene las categorias que fueron seleccionadas
				switch(categoriasChecked[j]){
					case 1: nombreCategoria = "Hoteles";
						    arrayServicios = ["chkServicios11","chkServicios12","chkServicios13","chkServicios14","chkServicios15","chkServicios16","chkServicios17","chkServicios18","chkServicios19","chkServicios110","chkServicios111","chkServicios112"];
						    break;
					case 2: nombreCategoria = "Aparta - Hoteles";
						    arrayServicios = ["chkServicios21","chkServicios22","chkServicios23","chkServicios24","chkServicios25","chkServicios26","chkServicios27","chkServicios28","chkServicios29","chkServicios210","chkServicios211"];
						    break;
					case 3: nombreCategoria = "Centros vacacionales";
						    arrayServicios = ["chkServicios31","chkServicios32","chkServicios33","chkServicios34","chkServicios35","chkServicios36","chkServicios37","chkServicios38","chkServicios39","chkServicios310","chkServicios311","chkServicios312","chkServicios313"];
						    break;
					case 4: nombreCategoria = "Alojamiento rural";
						    arrayServicios = ["chkServicios41","chkServicios42","chkServicios43","chkServicios44","chkServicios45","chkServicios46","chkServicios47","chkServicios48","chkServicios49","chkServicios410","chkServicios411","chkServicios412"];
						    break;
					case 5: nombreCategoria = "Hostales";
						    arrayServicios = ["chkServicios51","chkServicios52","chkServicios53","chkServicios54","chkServicios55","chkServicios56","chkServicios57","chkServicios58","chkServicios59","chkServicios510"];	
						    break;
					case 6: nombreCategoria = "Zonas para camping";
						    arrayServicios = ["chkServicios61","chkServicios62","chkServicios63","chkServicios64","chkServicios65"];
						    break;
				}
				var contador = 0;
				for (x=0; x<arrayServicios.length; x++){ //Recorrer el array de servicios de las categorias seleccionadas
					var checkServicios = "#" + arrayServicios[x];
					if ($(checkServicios).attr("checked")){  
						contador++;
					}
				}
				
				if (contador==0){
					alert("Debe seleccionar al menos uno de los servicios de la categoria \"" + nombreCategoria+ "\"");
					result = false;
					break; //No continua revisando. De todas formas hay categorias con servicios sin seleccionar
				}
				else{
					result = true;
				}
			}
			
		}
		else{
			alert("Debe seleccionar una de las categorias");
			return false;
		}
		
		//Si toda la validacion está O.K. entonces result = true
		if (result){
			if ($("#otroServicio").is(':visible') && $("#otroServicio").val() == ''){
				alert ('Debe especificar otro servicio');
				return false;
			}else{
				$.ajax({
					type: "POST",
					url: base_url + "fuente/actualizarModuloV",
					data: $("#frmModuloV").serialize(),
					dataType: "html", 
				    cache: false,
					success: function(data){
						// Como &eacute;sta es la ultima pestaña, no se activan mas pestañas, sino que se hace un submit del formulario, 
						// para que se valide si ya todos los capitulos fueron enviados, y si es as&iacute;, mostrar la pestaña del env&iacute;o del 
						// formulario. Se desactiva el cambio de pestaña.
						var image = $("#imgtab5");
						image.attr("src", base_url + "/images/tick.png");
						$("#tabs").tabs({selected: 5});
						$("#frmModuloV").submit();
					}
				});
			}
		}
	});
	
	
});


//Muestra el cuadro texto, dependiendo de la respuesta del cuadro lista
$(document).ready(function(){ 
   $("#chkServicios112").change(function () {
	   $("#chkServicios112").each(function () {
		   if($("#chkServicios112").attr("checked")){
			   $("#formularioInsindc").show(); 
		   }
		   else{
			   $("#formularioInsindc").hide(); 
		   }
       });
   })
    $("#chkServicios211").change(function () {
	   $("#chkServicios211").each(function () {
		   if($("#chkServicios211").attr("checked")){
			   $("#formularioInsindc").show(); 
		   }
		   else{
			   $("#formularioInsindc").hide(); 
		   }
       });
   })
   $("#chkServicios313").change(function () {
	   $("#chkServicios313").each(function () {
		   if($("#chkServicios313").attr("checked")){
			   $("#formularioInsindc").show(); 
		   }
		   else{
			   $("#formularioInsindc").hide(); 
		   }
       });
   })
   $("#chkServicios412").change(function () {
	   $("#chkServicios412").each(function () {
		   if($("#chkServicios412").attr("checked")){
			   $("#formularioInsindc").show(); 
		   }
		   else{
			   $("#formularioInsindc").hide(); 
		   }
       });
   })
   $("#chkServicios510").change(function () {
	   $("#chkServicios510").each(function () {
		   if($("#chkServicios510").attr("checked")){
			   $("#formularioInsindc").show(); 
		   }
		   else{
			   $("#formularioInsindc").hide(); 
		   }
       });
   })
   $("#chkServicios65").change(function () {
	   $("#chkServicios65").each(function () {
		   if($("#chkServicios65").attr("checked")){
			   $("#formularioInsindc").show(); 
		   }
		   else{
			   $("#formularioInsindc").hide(); 
		   }
       });
   })
});