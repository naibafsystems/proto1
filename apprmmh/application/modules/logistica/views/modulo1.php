<h3>M&oacute;dulo I - Identificaci&oacute;n y datos generales</h3>
<br/>
<form id="frmModuloI" name="frmModuloI" method="post" action="">
<fieldset style="padding: 10px; border: 1px solid #CCCCCC">
<legend><b>&nbsp;1. Ubicaci&oacute;n y datos generales de la empresa&nbsp;</b></legend>
<table>
<tr>
<td>
  <table>
  <tr>
    <td><label style="display: block; float: left; width: 900px;">Raz&oacute;n Social:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="idproraz" name="idproraz" value="<?php echo $modulo1["idproraz"]; ?>" size="80" maxlength="80" class="textbox"/></label></td>
  </tr>
  </table>
</td>    
</tr>
<tr>
<td>
	<table width="100%">
	<tr>
	  <td><label style="display: block; float: left; width: 660px;">Nombre Comercial:&nbsp;<input type="text" id="idnomcom" name="idnomcom" value="<?php echo $modulo1["idnomcom"]; ?>" size="80" maxlength="80" class="textbox" /></label>
	      <!-- label style="display: block; float: left; width: 200px; text-align: right;">Sigla:&nbsp;<input type="text" id="idsigla" name="idsigla" value="<?php// echo $modulo1["idsigla"]; ?>" size="20" maxlength="20" class="textbox" /></label-->
	  </td>	  
	</tr>
	</table>
</td>
</tr>
<tr>
<td>
	<table width="100%">
	<tr>
	  <td><label style="display: block; float: left; width: 820px;">Domicilio principal o direcci&oacute;n de la gerencia:&nbsp;<input type="text" id="iddirecc" name="iddirecc" value="<?php echo $modulo1["iddirecc"]; ?>" size="80" maxlength="80" class="textbox"/></label></td>
	</tr>
	</table>
</td>
</tr>
<tr>
<td>
	<table width="100%">
	<tr>
	  <td width="45%"><label style="display: block; float: left; width: 270px;">Departamento:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	      <select id="iddepto" name="iddepto" class="select">
          <option value="-">Seleccione...</option>
	      <?php for ($i=0; $i<count($departamentos); $i++){ 
	   		 		if ($departamentos[$i]["codigo"]==$modulo1["iddepto"]){
	      ?>       		<option value="<?php echo $departamentos[$i]["codigo"]; ?>" selected="selected"><?php echo $departamentos[$i]["nombre"]; ?></option>
	      <?php 	}
	         		else{ ?>
	   					<option value="<?php echo $departamentos[$i]["codigo"]; ?>"><?php echo $departamentos[$i]["nombre"]; ?></option> 
	      <?php 	} 
	   		    }
	      ?>
          </select>
          </label>
      </td>
	  <td><label style="display: block; float: left; width: 480px;">&nbsp;Municipio: 
	      <select id="idmpio" name="idmpio" class="select">
          <option value="-">Seleccione...</option>
	      <?php for ($i=0; $i<count($municipios); $i++){
	  				if ($municipios[$i]["codigo"]==$modulo1["idmpio"]){ 
	      ?>			<option value="<?php echo $municipios[$i]["codigo"]; ?>" selected="selected"><?php echo $municipios[$i]["nombre"]; ?></option>
	      <?php     }
	  				else{ ?>
	  					<option value="<?php echo $municipios[$i]["codigo"]; ?>"><?php echo $municipios[$i]["nombre"]; ?></option>
	      <?php		} 
	  			}
	  	  ?>
          </select>
          </label>
      </td>	
	</tr>
	</table>
</td>
</tr>
<tr>
<td>
	<table width="100%">
	<tr>
	  <td><label style="display: block; float: left; width: 235px;">Tel&eacute;fono:&nbsp;<input type="text" id="idtelno" name="idtelno" value="<?php echo $modulo1["idtelno"]; ?>" size="13" maxlength="13" class="textbox"/></label></td>
	  <!-- td><label style="display: block; float: left; width: 195px;">Fax:&nbsp;<input type="text" id="idfaxno" name="idfaxno" value="<?php //echo $modulo1["idfaxno"]; ?>" size="13" maxlength="13" class="textbox"/></label></td-->
	  <td><label style="display: block; float: left; width: 550px;">P&aacute;gina web:&nbsp;<input type="text" id="idpagweb" name="idpagweb" value="<?php echo $modulo1["idpagweb"]; ?>" size="60" maxlength="255" class="textbox"/></label></td>
	</tr>
	</table>
</td>
</tr>
<tr>
<td>
    <table width="100%">
    <tr>
      <td><label style="display: block; float: left; width: 620px;">Email gerencia:&nbsp;<input type="text" id="idcorreo" name="idcorreo" value="<?php echo $modulo1["idcorreo"]; ?>" size="80" maxlength="80" class="textbox"/></label></td>
    </tr>
    </table>
</td>
<tr>
<td>
    <table width="100%">
    <tr>
      <td><label style="display: block; float: left; width: 820px;">Cadena hotelera al que pertenece:&nbsp; <input type="text" id="nom_cadena" name="nom_cadena"  value="<?php echo $modulo1["nom_cadena"]; ?>" size="50" maxlength="80" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></label></td>
    </tr>
    </table>
</td>
</tr>
<tr>
<td>
    <table width="100%">
    <tr>
      <td><label style="display: block; float: left; width: 820px;">Operador hotelero al que pertenece:&nbsp; <input type="text" id="nom_operador" name="nom_operador"  value="<?php echo $modulo1["nom_operador"]; ?>" size="50" maxlength="80" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></label></td>
    </tr>
    </table>
</td>
</tr>
<!-- tr>
<td>
    <table>
    <tr>
      <td width="10%"valign="bottom" rowspan="2">Fechas de referencia de informaci&oacute;n: </td>
      <td width="2%">Desde</td>
      <td width="2%">&nbsp;</td>
      <td width="10%">Hasta</td>
    </tr>
    <tr>
      <td><input type="text" id="finicial" name="finicial" value="<?php echo $modulo1["finicial"]; ?>" class="textbox"/></td>
      <td>&nbsp;</td>
      <td><input type="text" id="ffinal" name="ffinal" value="<?php echo $modulo1["ffinal"]; ?>" class="textbox"/></td>
    </tr>
    </table>
</td>
</tr-->
</table>
</fieldset>
<br/>
<fieldset style="padding: 10px; border: 1px solid #CCCCCC">
<legend><b>&nbsp;2. Informaci&oacute;n general del establecimiento&nbsp;</b></legend>
<table width="100%">
<tr>
<td>
	<table width="100%">
	<tr>
	  <td><label style="display: block; float: left; width: 720px;">Nombre del establecimiento:&nbsp;&nbsp;&nbsp;<input type="text" id="idnomcomest" name="idnomcomest" value="<?php echo $modulo1["idnomcomest"]; ?>" size="80" maxlength="80" class="textbox" /></label>
	      <label style="display: block; float: left; width: 200px;">Sigla:&nbsp;<input type="text" id="idsiglaest" name="idsiglaest" value="<?php echo $modulo1["idsiglaest"]; ?>" size="20" maxlength="20" class="textbox" /></label>
	  </td>
	</tr>
	</table>
</td>
</tr>
<tr>
<td>
	<table width="100%">	
	<tr>
	  <td><label style="display: block; float: left; width: 720px;">Direcci&oacute;n del establecimiento:&nbsp;<input type="text" id="iddireccest" name="iddireccest" value="<?php echo $modulo1["iddireccest"]; ?>" size="80" maxlength="80" class="textbox"/></label></td>
	</tr>
	</table>
</td>
</tr>
<tr>
<td>
	<table width="100%">
	<tr>
	  <td width="45%"><label style="display: block; float: left; width: 270px;">Departamento:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      <select id="iddeptoest" name="iddeptoest" class="select">
          <option value="-">Seleccione...</option>
	  	  <?php for ($i=0; $i<count($departamentos); $i++){ 
	   		 		if ($departamentos[$i]["codigo"]==$modulo1["iddeptoest"]){
	      ?>       		<option value="<?php echo $departamentos[$i]["codigo"]; ?>" selected="selected"><?php echo $departamentos[$i]["nombre"]; ?></option>
	      <?php 	}
	         		else{ ?>
	   					<option value="<?php echo $departamentos[$i]["codigo"]; ?>"><?php echo $departamentos[$i]["nombre"]; ?></option> 
	      <?php 	} 
	   		    }
	      ?>
          </select>
          </label>
      </td>
	  <td><label style="display: block; float: left; width: 480px;">&nbsp;Municipio:
	      <select id="idmpioest" name="idmpioest" class="select">
          <option value="-">Seleccione...</option>
	      <?php for ($i=0; $i<count($municipios); $i++){
	  				if ($municipios[$i]["codigo"]==$modulo1["idmpioest"]){ 
	      ?>			<option value="<?php echo $municipios[$i]["codigo"]; ?>" selected="selected"><?php echo $municipios[$i]["nombre"]; ?></option>
	      <?php     }
	  				else{ ?>
	  					<option value="<?php echo $municipios[$i]["codigo"]; ?>"><?php echo $municipios[$i]["nombre"]; ?></option>
	      <?php		} 
	  			}
	  	  ?>
          </select>
          </label>
      </td>	
	</tr>
	</table>
</td>
</tr>
<tr>
<td>
	<table width="100%">
	<tr>
	  <td><label style="display: block; float: left; width: 220px;">Tel&eacute;fono:&nbsp;<input type="text" id="idtelnoest" name="idtelnoest" value="<?php echo $modulo1["idtelnoest"]; ?>" size="13" maxlength="13" class="textbox"/></label></td>
	  <!-- td><label style="display: block; float: left; width: 180px;">Fax:&nbsp;<input type="text" id="idfaxnoest" name="idfaxnoest" value="<?php //echo $modulo1["idfaxnoest"]; ?>" size="13" maxlength="13" class="textbox"/></label></td-->
	  <td><label style="display: block; float: left; width: 550px;">Email establecimiento:&nbsp;<input type="text" id="idcorreoest" name="idcorreoest" value="<?php echo $modulo1["idcorreoest"]; ?>" size="60" maxlength="80" class="textbox"/></label></td>
	</tr>
	</table>
</td>  
</tr>
</table>
</fieldset>
<br/>
<?php //Validar que el formulario esté en estado 99 - 4 para que pueda ser utilizado / modificado por el logistico
      //if (($novedad_estado["novedad"]==99)&&($novedad_estado["estado"]==4) || ($novedad_estado["novedad"]==99 && $novedad_estado["estado"]==5)){  
?>		  

<input type="button" id="btnOBSLogisticaI" name="btnOBSLogisticaI" value="Observaciones Log&iacute;stica" class="button"/>
		  	
<?php //} ?>
 <input type="hidden" id="finicial" name="finicial" value="<?php echo date("1/m/Y"); ?>"/>
 <input type="hidden" id="idfaxno" name="idfaxno" value="0"/>
 <input type="hidden" id="idfaxnoest" name="idfaxnoest" value="0"/>
 <input type="hidden" id="ffinal" name="ffinal" value="<?php echo date("30/m/Y"); ?>"/> 
<input type="hidden" id="nro_orden" name="nro_orden" value="<?php echo $modulo1["nro_orden"]; ?>"/>
<input type="hidden" id="nro_establecimiento" name="nro_establecimiento" value="<?php echo $modulo1["nro_establecimiento"]; ?>"/>
<input type="hidden" id="idnit" name="idnit" value="<?php echo $modulo1["idnit"]; ?>"/>
</form>