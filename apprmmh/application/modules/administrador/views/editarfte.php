<script type="text/javascript">

	$(function(){
		$("#btnPruebas").click(function(){				
			$("#divCambioEST").html("<br/>&iquest; Realmente desea cambiar el estado de este formulario ?");
			$("#divCambioEST").append('<br/><input type="button" id="btnCambiarYES" name="btnCambiarYES" value="Aceptar" class="button"/>'); 
			$("#divCambioEST").append('&nbsp;&nbsp;<input type="button" id="btnCambiarNO" name="btnCambiarNO" value="Cancelar" class="button"/>');
			$("#btnCambiarYES").bind("click", function() {
				var numord = $("#hddNroOrden").val();
				var numest = $("#hddNroEstablecimiento").val();
				var novestado = ($("#cmbNovestado").val()).split("-");
				$.ajax({
					type: "POST",
					url: base_url + "administrador/cambiarFuente",
					data: {'novedad': novestado[0], 'estado': novestado[1], 'numord':numord, 'numest':numest}, 
					dataType: "html", 
				    cache: false,
					success: function(data){
						$("#divCambioEST").css("color","#E00078");
						$("#divCambioEST").css("font-weight","bolder");
						$("#divCambioEST").html("<br/>Se ha modificado el estado del formulario.");
						$("#divCambioEST").effect('slide','',1500,'');				
					}					
				});				
			});
			$("#btnCambiarNO").bind("click", function() {
				  $("#divCambioEST").html("");
			});
		});		
	});

</script>

<h1>Editar Fuente</h1>
<form id="frmEditarFuente" name="frmEditarFuente" method="post" action="<?php echo site_url("administrador/actualizarDatosFuente"); ?>">
<table width="100%">
<tr>
  <td width="20%"><b>Nro. Orden:</b></td>
  <td><?php echo $empresa["nro_orden"]; ?></td>
</tr>
<tr>
  <td><b>Nro. Establecimiento:</b></td>
  <td><?php echo $establecimiento["nro_establecimiento"]; ?></td>
</tr>
<tr>
  <td><b>Raz&oacute;n Social Empresa:</b></td>
  <td><?php echo $empresa["idproraz"]; ?></td>
</tr>
<tr>
  <td><b>Nombre Comercial Establecimiento:</b></td>
  <td><?php echo $establecimiento["idnomcom"]; ?></td>
</tr>    
</table>
<br/>
<fieldset style="border: 1px solid #CCCCCC; padding-top:10px; padding-left:10px;">
<legend><b>Datos de la empresa</b>&nbsp;</legend>
<!-- Tabla para mostrar los datos de la empresa -->
<table width="100%">
<tr>
  <td width="10%">Nit: </td>
  <td><input type="text" id="idnit" name="idnit" value="<?php echo $empresa["idnit"]; ?>" size="15" class="textbox"/></td>
</tr>
<tr>
  <td>Raz&oacute;n Social: </td>
  <td><input type="text" id="idproraz" name="idproraz" value="<?php echo $empresa["idproraz"]; ?>" size="70" class="textbox"/></td>
</tr>
<tr>
  <td>Nombre Comercial: </td>
  <td><input type="text" id="idnomcom" name="idnomcom" value="<?php echo $empresa["idnomcom"]; ?>" size="70" class="textbox"/></td>
</tr>
<tr>
  <td>Sigla: </td>
  <td><input type="text" id="idsigla" name="idsigla" value="<?php echo $empresa["idsigla"]; ?>" size="15" class="textbox"/></td>
</tr>
<tr>
  <td>Direcci&oacute;n: </td>
  <td><input type="text" id="iddirecc" name="iddirecc" value="<?php echo $empresa["iddirecc"]; ?>" size="70" class="textbox"/></td>
</tr>
<tr>
  <td>Tel&eacute;fono: </td>
  <td><input type="text" id="idtelno" name="idtelno" value="<?php echo $empresa["idtelno"]; ?>" size="15" class="textbox"/></td>
</tr>
<tr>
  <td>Fax: </td>
  <td><input type="text" id="idfaxno" name="idfaxno" value="<?php echo $empresa["idfaxno"]; ?>" size="15" class="textbox"/></td>
</tr>
<tr>
  <td>Apartado A&eacute;reo: </td>
  <td><input type="text" id="idaano" name="idaano" value="<?php echo $empresa["idaano"]; ?>" size="15" class="textbox"/></td>
</tr>
<tr>
  <td>P&aacute;gina Web: </td>
  <td><input type="text" id="idpagweb" name="idpagweb" value="<?php echo $empresa["idpagweb"]; ?>" size="70" class="textbox"/></td>
</tr>
<tr>
  <td>Correo Electr&oacute;nico: </td>
  <td><input type="text" id="idcorreo" name="idcorreo" value="<?php echo $empresa["idcorreo"]; ?>" size="70" class="textbox"/></td>
</tr>
<tr>
  <td>Departamento: </td>
  <td><select id="cmbDeptoEmp" name="cmbDeptoEmp" class="select">
      <option value="-">Seleccione el departamento...</option>
      <?php for ($i=0; $i<count($departamentos); $i++){
      	    	if ($empresa["fk_depto"]==$departamentos[$i]["codigo"]){
      ?>    		<option value="<?php echo $departamentos[$i]["codigo"]; ?>" selected="selected"><?php echo utf8_encode($departamentos[$i]["nombre"]); ?></option>
      <?php 	} 
      	    	else{
      ?>    		<option value="<?php echo $departamentos[$i]["codigo"]; ?>"><?php echo utf8_encode($departamentos[$i]["nombre"]); ?></option>
      <?php    	}
      		}
      ?>
      </select>
  </td>
</tr>
<tr>
  <td>Municipio: </td>
  <td><select id="cmbMpioEmp" name="cmbMpioEmp" class="select">
      <option value="-">Seleccione el municipio...</option>
      <?php for ($i=0; $i<count($municipios); $i++){ 
      			if ($empresa["fk_mpio"]==$municipios[$i]["codigo"]){
      ?>			<option value="<?php echo $municipios[$i]["codigo"]; ?>" selected="selected"><?php echo $municipios[$i]["nombre"]; ?></option>
      <?php     }
      			else{
      ?>			<option value="<?php echo $municipios[$i]["codigo"]; ?>"><?php echo $municipios[$i]["nombre"]; ?></option>
      <?php 	}
      		} 
      ?>
      </select>
  </td>
</tr>
</table>
<!-- Fin tabla -->
<br/>
</fieldset>
<br/>
<fieldset style="border: 1px solid #CCCCCC; padding-top:10px; padding-left:10px;">
<legend><b>Datos del establecimiento</b>&nbsp;</legend>
<!-- Tabla para mostrar los datos del establecimiento -->
<table width="100%">
<tr>
  <td width="10%">Nombre Comercial: </td>
  <td><input type="text" id="idnomcomest" name="idnomcomest" value="<?php echo $establecimiento["idnomcom"]; ?>" size="70" class="textbox"/></td>
</tr>
<tr>
  <td>Sigla: </td>
  <td><input type="text" id="idsiglaest" name="idsiglaest" value="<?php echo $establecimiento["idsigla"]; ?>" size="15" class="textbox"/></td>
</tr>
<tr>
  <td>Direcci&oacute;n: </td>
  <td><input type="text" id="iddireccest" name="iddireccest" value="<?php echo $establecimiento["iddirecc"]; ?>" size="70" class="textbox"/></td>
</tr>
<tr>
  <td>Tel&eacute;fono: </td>
  <td><input type="text" id="idtelnoest" name="idtelnoest" value="<?php echo $establecimiento["idtelno"]; ?>" size="15" class="textbox"/></td>
</tr>
<tr>
  <td>Fax: </td>
  <td><input type="text" id="idfaxnoest" name="idfaxnoest" value="<?php echo $establecimiento["idfaxno"]; ?>" size="15" class="textbox"/></td>
</tr>
<tr>
  <td>Correo Electr&oacute;nico: </td>
  <td><input type="text" id="idcorreoest" name="idcorreoest" value="<?php echo $establecimiento["idcorreo"]; ?>" size="70" class="textbox"/></td>
</tr>
<tr>
  <td>Actividad Comercial: </td>
  <td><select id="cmbActEst" name="cmbActEst" class="select" style="width: 98%">
      <?php for ($i=0; $i<count($actividades); $i++){ 
      			if ($establecimiento["fk_ciiu"]==$actividades[$i]["id"]){
      ?>			<option value="<?php echo $actividades[$i]["id"]; ?>" selected="selected"><?php echo "(".$actividades[$i]["id"].") ".$actividades[$i]["nombre"]; ?></option>
      <?php     }
      			else{
      ?>			<option value="<?php echo $actividades[$i]["id"]; ?>"><?php echo "(".$actividades[$i]["id"].") ".$actividades[$i]["nombre"]; ?></option>
      <?php 	}
      		} 
      ?>
      </select>
  </td>
</tr>
<tr>
  <td>Departamento: </td>
  <td><select id="cmbDeptoEst" name="cmbDeptoEst" class="select">
      <option value="-">Seleccione el departamento...</option>
      <?php for ($i=0; $i<count($departamentos); $i++){
      	    	if ($establecimiento["fk_depto"]==$departamentos[$i]["codigo"]){
      ?>    		<option value="<?php echo $departamentos[$i]["codigo"]; ?>" selected="selected"><?php echo utf8_encode($departamentos[$i]["nombre"]); ?></option>
      <?php 	} 
      	    	else{
      ?>    		<option value="<?php echo $departamentos[$i]["codigo"]; ?>"><?php echo utf8_encode($departamentos[$i]["nombre"]); ?></option>
      <?php    	}
      		}
      ?>
      </select>
  </td>
</tr>
<tr>
  <td>Municipio: </td>
  <td><select id="cmbMpioEst" name="cmbMpioEst" class="select">
      <option value="-">Seleccione el municipio...</option>
      <?php for ($i=0; $i<count($municipios); $i++){ 
      			if ($establecimiento["fk_mpio"]==$municipios[$i]["codigo"]){
      ?>			<option value="<?php echo $municipios[$i]["codigo"]; ?>" selected="selected"><?php echo $municipios[$i]["nombre"]; ?></option>
      <?php     }
      			else{
      ?>			<option value="<?php echo $municipios[$i]["codigo"]; ?>"><?php echo $municipios[$i]["nombre"]; ?></option>
      <?php 	}
      		} 
      ?>
      </select>
  </td>
</tr>
<tr>
  <td>Sede: </td>
  <td><select id="cmbSedeEst" name="cmbSedeEst" class="select">
      <option value="-">Seleccione la sede...</option>
      <?php for ($i=0; $i<count($sedes); $i++){ 
      			if ($establecimiento["fk_sede"]==$sedes[$i]["id"]){
      ?>			<option value="<?php echo $sedes[$i]["id"]; ?>" selected="selected"><?php echo $sedes[$i]["nombre"]; ?></option>
      <?php     }
      			else{
      ?>			<option value="<?php echo $sedes[$i]["id"]; ?>"><?php echo $sedes[$i]["nombre"]; ?></option>
      <?php 	}
      		} 
      ?>
      </select>
  </td>
</tr>
<tr>
  <td>Subsede: </td>
  <td><select id="cmbSubSedeEst" name="cmbSubSedeEst" class="select">
      <option value="-">Seleccione la sede...</option>
      <?php for ($i=0; $i<count($subsedes); $i++){ 
      			if ($establecimiento["fk_subsede"]==$subsedes[$i]["id"]){
      ?>			<option value="<?php echo $subsedes[$i]["id"]; ?>" selected="selected"><?php echo $subsedes[$i]["nombre"]; ?></option>
      <?php     }
      			else{
      ?>			<option value="<?php echo $subsedes[$i]["id"]; ?>"><?php echo $subsedes[$i]["nombre"]; ?></option>
      <?php 	}
      		} 
      ?>
      </select>
  </td>
</tr>
</table>
<br/>
<!-- Fin Tabla-->
</fieldset>
<br/>
<input type="submit" id="btnActualizarFuente" name="btnActualizarFuente" value="Actualizar Datos" class="button"/>
<br/><br/>
<fieldset style="border: 1px solid #CCCCCC; padding-top:10px; padding-left:10px;">
<legend><b>Datos de control del formulario</b></legend>

<table width="100%">
<tr>
  <td width="25%">
     <!-- Tabla para el estado general -->
     <p><b>Estado General del formulario</b></p>
	 <table>
	 <tr>
  		<td width="160">Novedad Actual: </td>
  		<td><?php echo $control["novedad"]; ?></td>
	 </tr>
	 <tr>
  		<td>Estado Actual: </td>
  		<td><?php echo $control["estado"]; ?></td>
	 </tr>
	 </table>
	 <br/>
	 <p><b>Estado de los m&oacute;dulos del formulario</b></p>
	 <table width="100%">
	 <tr>
  		<td>Estado M&oacute;dulo I:</td>
  		<td><?php echo $control["modulo1"]; ?></td>
	 </tr>
	 <tr>
  		<td>Estado M&oacute;dulo II:</td>
  		<td><?php echo $control["modulo2"]; ?></td>
	 </tr>
	 <tr>
  		<td>Estado M&oacute;dulo III:</td>
  		<td><?php echo $control["modulo3"]; ?></td>
	 </tr>
	 <tr>
  		<td>Estado M&oacute;dulo IV:</td>
  		<td><?php echo $control["modulo4"]; ?></td>
	 </tr>
	 <tr>
  		<td>Estado Env&iacute;o Formulario:</td>
  		<td><?php echo $control["envio"]; ?></td>
	 </tr>
	 </table>
     <!-- Fin tabla estado general -->
  </td>
  <td valign="top" width="75%" style="padding-right: 10px; padding-left: 75px;">
  	  <!-- Tabla para el cambio de estados -->
  	  <p><b>Cambio de estados del formulario</b></p>
  	  <table>
  	  <tr>
  	    <td>Seleccione el estado:</td>
  	    <td><select id="cmbNovestado" name="cmbNovestado" class="select">
  	          <option value="5-0">Sin Distribuir</option>
  	          <option value="5-1">Distribuido</option>
  	          <option value="5-2">En digitaci&oacute;n</option>
  	          <option value="5-3">Digitado</option>
  	          <option value="99-4">An&aacute;lisis - Verificaci&oacute;n</option>
  	          <option value="99-5">Verificado</option>
  	        </select>
  	        &nbsp;&nbsp;
  	        <input type="button" id="btnPruebas" name="btnPruebas" value="Cambiar Estado" class="button"/>
  	    </td>
  	  </tr>  	  
  	  </table>
  	  <div id="divCambioEST"></div>  	  
  	  <!-- Fin tabla cambio de estados -->
  </td>
</tr>
</table>
</fieldset>
<input type="hidden" id="hddNroOrden" name="hddNroOrden" value="<?php echo $empresa["nro_orden"]; ?>"/>
<input type="hidden" id="hddNroEstablecimiento" name="hddNroEstablecimiento" value="<?php echo $establecimiento["nro_establecimiento"]; ?>"/>
</form>