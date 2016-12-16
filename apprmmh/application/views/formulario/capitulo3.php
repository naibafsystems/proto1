<?php $this->load->library("general"); ?>
<h3>Personal ocupado promedio y salarios causados en el mes</h3>
<br/>
<form id="frmCapituloIII" name="frmCapituloIII" method="post" action="">
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
  <td><input type="text" id="potpsfr" name="potpsfr" value="<?php echo $capitulo3["potpsfr"]; ?>" size="7" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"/></td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>2. Personal permanente (Contrato a t&eacute;rmino indefinido)</td>
  <td><input type="text" id="potperm" name="potperm" value="<?php echo $capitulo3["potperm"]; ?>" size="7" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"/></td>
  <td><input type="text" id="gpper" name="gpper" value="<?php echo $capitulo3["gpper"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox" size="7"/></td>
</tr>
<tr>
  <td>3. Personal temporal contratado directamente por la empresa<br/>(Contrato a t&eacute;rmino definido)</td>
  <td><input type="text" id="pottcde" name="pottcde" value="<?php echo $capitulo3["pottcde"]; ?>" size="7" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"/></td>
  <td><input type="text" id="gpssde" name="gpssde" value="<?php echo $capitulo3["gpssde"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox" size="7"/></td>
</tr>
<tr>
  <td>4. Temporales suministrados por otras empresas</td>
  <td><input type="text" id="pottcag" name="pottcag" value="<?php echo $capitulo3["pottcag"]; ?>" size="7" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"/></td>
  <td><input type="text" id="gppta" name="gppta" value="<?php echo $capitulo3["gpppta"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox" size="7"/></td>
</tr>
<tr>
  <td>5. Personal aprendiz o estudiante por convenio</td>
  <td><input type="text" id="potpau" name="potpau" value="<?php echo $capitulo3["potpau"]; ?>" size="7" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"/></td>
  <td><input type="text" id="gppgpa" name="gppgpa" value="<?php echo $capitulo3["gppgpa"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox" size="7"/></td>
</tr>
<tr>
  <td>6. Total (Sume renglones 1 a 5)</td>
  <td><input type="text" id="pottot" name="pottot" value="<?php echo $capitulo3["pottot"]; ?>" size="7" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"/></td>
  <td><input type="text" id="gpsspot" name="gpsspot" value="<?php echo $capitulo3["gpsspot"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox" size="7"/></td>
</tr>
</tbody>
</table>
<br/>
<?php if (!$bloqueo){ 
			switch($controller){
		  		case 'fuente':        $button = '<input type="submit" id="btnCapituloIII" name="btnCapituloIII" value="Guardar y continuar" class="button"/>';
		                   		      break; 
		  		case 'critico':       $button = '<input type="button" id="btnCap3CR" name="btnCap3CR" value="Guardar Observaciones" class="button"/>';
		                   		      break;
		  		case 'administrador': $button = '<input type="button" id="btnCap3CR" name="btnCap3CR" value="Guardar Observaciones" class="button"/>';
		  		                      break;           		                 
	        }
?>
<table>
  <tr>
    <td colspan="2"><?php echo $button; ?></td>
  </tr>
</table>
<?php } ?>
<input type="hidden" id="op" name="op" value="<?php echo $capitulo3["op"]; ?>"/>
<input type="hidden" id="numord" name="numord" value="<?php echo $nro_orden; ?>"/> 
</form>