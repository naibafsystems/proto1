<h3>Nombre y direcci&oacute;n de la empresa</h3>
<br/>
<form id="frmCapituloI" name="frmCapituloI" method="post" action="">
<table>
<tr>
  <td>Raz&oacute;n Social:</td>
  <td colspan="2"><input type="text" id="idproraz" name="idproraz" value="<?php echo $capitulo1["idproraz"]; ?>" size="60" maxlength="60" class="textbox" /></td>
</tr>
<tr>
  <td>Nombre Comercial:</td>
  <td colspan="2"><input type="text" id="idnomcom" name="idnomcom" value="<?php echo $capitulo1["idnomcom"]; ?>" size="60" maxlength="60" class="textbox" /></td>
</tr>
<tr>
  <td>Sigla:</td>
  <td colspan="2"><input type="text" id="idsigla" name="idsigla" value="<?php echo $capitulo1["idsigla"]; ?>" size="20" maxlength="20" class="textbox" /></td>
</tr>
<tr>
  <td><label>Domicilio principal &oacute; direcci&oacute;n de la gerencia:</label></td>
  <td colspan="2"><input type="text" id="iddirecc" name="iddirecc" value="<?php echo $capitulo1["iddirecc"]; ?>" size="40" maxlength="40" class="textbox"/></td>
</tr>
<tr>
  <td>Departamento:</td>
  <td colspan="2">
     <select id="iddepto" name="iddepto" class="select">
       <option value="-">Seleccione...</option>
	   <?php for ($i=0; $i<count($departamentos); $i++){ 
	   		 	if ($departamentos[$i]["codigo"]==$capitulo1["depto"]){
	   ?>       	<option value="<?php echo $departamentos[$i]["codigo"]; ?>" selected="selected"><?php echo $departamentos[$i]["nombre"]; ?></option>
	   <?php 	}
	         	else{ ?>
	   				<option value="<?php echo $departamentos[$i]["codigo"]; ?>"><?php echo $departamentos[$i]["nombre"]; ?></option> 
	   <?php 	} 
	   		 }
	   ?>
     </select>    
  </td>
</tr>
<tr>
  <td>Municipio:</td>
  <td colspan="2">
    <select id="idmpio" name="idmpio" class="select">
      <option value="-">Seleccione...</option>
	  <?php for ($i=0; $i<count($municipios); $i++){
	  			if ($municipios[$i]["codigo"]==$capitulo1["mpio"]){ 
	  ?>			<option value="<?php echo $municipios[$i]["codigo"]; ?>" selected="selected"><?php echo $municipios[$i]["nombre"]; ?></option>
	  <?php     }
	  			else{ ?>
	  				<option value="<?php echo $municipios[$i]["codigo"]; ?>"><?php echo $municipios[$i]["nombre"]; ?></option>
	  <?php 	} 
	  		}
	  ?>
    </select>
  </td>
</tr>
<tr>
  <td>Telefono:</td>
  <td colspan="2"><input type="text" id="idtelno" name="idtelno" value="<?php echo $capitulo1["idtelno"]; ?>" size="13" maxlength="13" class="textbox"/></td>
</tr>
<tr>
  <td>Fax:</td>
  <td colspan="2"><input type="text" id="idfaxno" name="idfaxno" value="<?php echo $capitulo1["idfaxno"]; ?>" size="13" maxlength="13" class="textbox"/></td>
</tr>
<tr>
  <td>P&aacute;gina Web:</td>
  <td colspan="2"><input type="text" id="idpagweb" name="idpagweb" value="<?php echo $capitulo1["idpagweb"]; ?>" size="75" maxlength="255" class="textbox"/></td>
</tr>
<tr>
  <td>Correo electr&oacute;nico de la gerencia:</td>
  <td colspan="2"><input type="text" id="idcorreo" name="idcorreo" value="<?php echo $capitulo1["idcorreo"]; ?>" size="30" maxlength="30" class="textbox"/></td>
</tr>
<tr>
  <td>Fechas de referencia de informaci&oacute;n:</td>
  <td>Desde:&nbsp;<input type="text" id="finicial" name="finicial" value="<?php echo $capitulo1["finicial"]; ?>" class="textbox"/></td>
  <td>Hasta:&nbsp;<input type="text" id="ffinal" name="ffinal" value="<?php echo $capitulo1["ffinal"]; ?>" class="textbox"/></td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<?php //Validar que el formulario esté en estado 99 - 4 para poder ser activado 
	  if (($novedad_estado["novedad"]==99)&&($novedad_estado["estado"]==4)){  
?>  	<tr>
			<td colspan="3"><input type="button" id="btnOBSCriticaI" name="btnOBSCriticaI" value="Observaciones Asistente" class="button"/></td>
		</tr>
<?php } ?>
</table>
<input type="hidden" id="hddNumOrden" name="hddNumOrden" value="<?php echo $nro_orden; ?>"/>
<input type="hidden" id="hddUniLocal" name="hddUniLocal" value="<?php echo $uni_local; ?>"/>
</form>