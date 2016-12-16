<h3>Personal ocupado promedio y salarios causados en el mes</h3>
<br/>
<form id="frmCapituloIV" name="frmCapituloIV" method="post" action="">
<table>
<thead>
<tr>
  <th>Tipo de contrataci&oacute;n</th>
  <th>N&uacute;mero de personas<br/>(promedio mensual)</th>
  <th>Sueldos y salarios causados <br/>totales en el mes (miles de pesos)</th>
</tr>
</thead>
<tbody>
<tr>
  <td width="450">1. Propietarios, socios y familiares sin remuneraci&oacute;n fija</td>
  <td><input type="text" id="potpsfr" name="potpsfr" value="<?php echo $capitulo4["potpsfr"]; ?>" size="7" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"/></td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>2. Personal permanente (Contrato a t&eacute;rmino indefinido)</td>
  <td><input type="text" id="potperm" name="potperm" value="<?php echo $capitulo4["potperm"]; ?>" size="7" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"/></td>
  <td><input type="text" id="gpper" name="gpper" value="<?php echo $capitulo4["gpper"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox" size="7"/></td>
</tr>
<tr>
  <td>3. Personal temporal contratado directamente por la empresa<br/>(Contrato a t&eacute;rmino definido)</td>
  <td><input type="text" id="pottcde" name="pottcde" value="<?php echo $capitulo4["pottcde"]; ?>" size="7" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"/></td>
  <td><input type="text" id="gpssde" name="gpssde" value="<?php echo $capitulo4["gpssde"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox" size="7"/></td>
</tr>
<tr>
  <td>4. Temporales suministrados por otras empresas</td>
  <td><input type="text" id="pottcag" name="pottcag" value="<?php echo $capitulo4["pottcag"]; ?>" size="7" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"/></td>
  <td><input type="text" id="gppta" name="gppta" value="<?php echo $capitulo4["gpppta"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox" size="7"/></td>
</tr>
<tr>
  <td>5. Personal aprendiz o estudiante por convenio</td>
  <td><input type="text" id="potpau" name="potpau" value="<?php echo $capitulo4["potpau"]; ?>" size="7" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"/></td>
  <td><input type="text" id="gppgpa" name="gppgpa" value="<?php echo $capitulo4["gppgpa"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox" size="7"/></td>
</tr>
<tr>
  <td>6. Total (Sume renglones 1 a 5)</td>
  <td><input type="text" id="pottot" name="pottot" value="<?php echo $capitulo4["pottot"]; ?>" size="7" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"/></td>
  <td><input type="text" id="gpsspot" name="gpsspot" value="<?php echo $capitulo4["gpsspot"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox" size="7"/></td>
</tr>
</tbody>
</table>
<br/>
 <?php //Validar que el formulario esté en estado 99 - 4 para poder ser activado 
	  if (($novedad_estado["novedad"]==99)&&($novedad_estado["estado"]==4)){  
  ?>  	<table>
  		<tr>
    		<td colspan="2"><input type="button" id="btnOBSCriticaIV" name="btnOBSCriticaIV" value="Observaciones Cr&iacute;tica" class="button"/></td>
  		</tr>
		</table>
  <?php } ?>
<input type="hidden" id="op" name="op" value="<?php echo $capitulo4["op"]; ?>"/>
<input type="hidden" id="hddNumOrden" name="hddNumOrden" value="<?php echo $nro_orden; ?>"/>
<input type="hidden" id="hddUniLocal" name="hddUniLocal" value="<?php echo $uni_local; ?>"/>
</form>