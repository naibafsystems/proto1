<?php $this->load->library("general"); ?>
<h3>M&oacute;dulo II - Personal ocupado promedio y salarios causados en el mes</h3>
<br/>
<form id="frmModuloII" name="frmModuloII" method="post" action="">
<table>
<thead>
<tr>
  <th>Tipo de contrataci&oacute;n</th>
  <th width="200px" style="text-align:center">N&uacute;mero promedio de personas ocupadas en el mes</th>
  <th width="230px" style="text-align:center">Total Sueldos y salarios causados por el personal ocupado en el mes (miles de pesos)</th>
  <th width="230px" style="text-align:center">Costo de personal (miles de pesos)</th>
</tr>
</thead>
<tbody>
<tr>
  <td width="450">1. Propietarios, socios y familiares sin remuneraci&oacute;n fija</td>
  <td style="text-align:center"><input type="text" id="potpsfr" name="potpsfr" value="<?php echo $modulo2["potpsfr"]; ?>" size="7" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"/></td>
  <td style="text-align:center">&nbsp;</td>
  <td style="text-align:center">&nbsp;</td> 
</tr>
<tr>
  <td style="text-align:left">2. Personal permanente (Contrato a t&eacute;rmino indefinido)</td>
  <td style="text-align:center"><input type="text" id="potperm" name="potperm" value="<?php echo $modulo2["potperm"]; ?>" size="7" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"/></td>
  <td style="text-align:center"><input type="text" id="gpper" name="gpper" value="<?php echo $modulo2["gpper"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox" size="7"/></td>
  <td style="text-align:center">&nbsp;</td>
</tr>
<tr>
  <td style="text-align:left">3. Personal temporal contratado directamente por el hotel<br/>(Contrato a t&eacute;rmino definido)</td>
  <td style="text-align:center"><input type="text" id="pottcde" name="pottcde" value="<?php echo $modulo2["pottcde"]; ?>" size="7" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"/></td>
  <td style="text-align:center"><input type="text" id="gpssde" name="gpssde" value="<?php echo $modulo2["gpssde"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox" size="7"/></td>
  <td style="text-align:center">&nbsp;</td>
</tr>
<tr>
  <td style="text-align:left">4. Personal temporal contratado a  traves de empresas especializadas</td>
  <td style="text-align:center"><input type="text" id="pottcag" name="pottcag" value="<?php echo $modulo2["pottcag"]; ?>" size="7" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"/></td>
  <td style="text-align:center">&nbsp;</td>
  <td style="text-align:center"><input type="text" id="gpppta" name="gpppta" value="<?php echo $modulo2["gpppta"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox" size="7"/></td>
</tr>
<tr>
  <td style="text-align:left">5. Aprendices y pasantes (universitarios, t&eacute;cnicos y tecn&oacute;logos) Ley 789 de 2002</td>
  <td style="text-align:center"><input type="text" id="potpau" name="potpau" value="<?php echo $modulo2["potpau"]; ?>" size="7" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"/></td>
  <td style="text-align:center"><input type="text" id="gppgpa" name="gppgpa" value="<?php echo $modulo2["gppgpa"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox" size="7"/></td>
  <td style="text-align:center">&nbsp;</td>
</tr>
<tr>
  <td style="text-align:left">6. Total (Sume renglones 2,3 y 5 en columna de valores)</td>
  <td style="text-align:center"><input type="text" id="pottot" name="pottot" value="<?php echo $modulo2["pottot"]; ?>" size="7" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"/></td>
  <td style="text-align:center"><input type="text" id="gpsspot" name="gpsspot" value="<?php echo $modulo2["gpsspot"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox" size="7"/></td>
  <td style="text-align:center">&nbsp;</td>
</tr>
</tbody>
</table>
<br/>
<div id="divgpssde"></div>
<div id="divgppgpa"></div>
<br/>
<?php //Validar que el formulario esté en estado 99 - 5 para poder ser activado por el administrador 
	  if (($novedad_estado["novedad"]==99)&&($novedad_estado["estado"]==5)){  
?>  	<!-- input type="button" id="btnOBSAdminII" name="btnOBSAdminII" value="Observaciones Administrador" class="button"/-->        
<?php } ?>
<input type="hidden" id="op" name="op" value="<?php echo $modulo2["op"]; ?>"/>
<input type="hidden" id="nro_orden" name="nro_orden" value="<?php echo $nro_orden; ?>"/> 
<input type="hidden" id="nro_establecimiento" name="nro_establecimiento" value="<?php echo $nro_establecimiento; ?>"/>
</form>