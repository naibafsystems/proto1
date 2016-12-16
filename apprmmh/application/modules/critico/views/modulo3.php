<?php $this->load->library("general"); ?>
<h3>M&oacute;dulo III - Ingresos operacionales causados en el mes (miles de pesos)</h3>
<p>En los valores parciales no incluya impuestos indirectos (IVA, Consumo)</p>
<br/>
<form id="frmModuloIII" name="frmModuloIII" method="post" action="">
  <table width="100%">
  <tr>
    <td width="60%">1. Alojamiento. </td>
	<td width="40%"><input type="text" id="inalo" name="inalo" value="<?php echo $modulo3["inalo"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox" size="7"/></td>
  </tr>
  <tr>
	<td><label>2. Servicios de restaurante (alimentos y bebidas no alcoh&oacute;licas), no incluidos en el<br/> valor de la tarifa de alojamiento.</label></td>
    <td><input type="text" id="inali" name="inali" value="<?php echo $modulo3["inali"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox" size="7"/></td>
  </tr>
  <tr>
	<td>3. Servicios de bar (bebidas alcoh&oacute;licas y cigarrilos), no incluidos en el valor de la tarifa <br/>de alojamiento.</td>
	<td><input type="text" id="inba" name="inba" value="<?php echo $modulo3["inba"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox" size="7"/></td>
  </tr>
  <tr>
	<td>4. Servicios receptivos (city tours, gu&iacute;as tur&iacute;sticos y servicios similares).</td>
	<td><input type="text" id="insr" name="insr" value="<?php echo $modulo3["insr"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox" size="7"/></td>
  </tr>
  <tr>
	<td>5. Alquiler de salones y/o apoyo en la organizaci&oacute;n de eventos (incluya todo lo refente al alquiler, log&iacute;stica, alimentaci&oacute;n, etc.).</td>
	<td><input type="text" id="inoe" name="inoe" value="<?php echo $modulo3["inoe"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox" size="7"/></td>
  </tr>
  <tr>
	<td>6. Otros ingresos  operacionales no solicitados antes (Incluye comunicaciones, lavander&iacute;a, peluquer&iacute;a, etc.)</td>
    <td><input type="text" id="inoio" name="inoio" value="<?php echo $modulo3["inoio"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox" size="7"/></td>
  </tr>
  <tr>
	<td>6. Total de ingresos operacionales (Sin IVA)</td>
    <td><input type="text" id="intio" name="intio" value="<?php echo $modulo3["intio"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox" size="7"/></td>
  </tr>
  </table>
  <br/>
  <div id="divintio1"></div>
  <div id="divintio2"></div>
  <div id="divinalo"></div>
  <div id="divinoe"></div>
  <div id="divinoio"></div>  
  <div id="observaciones2"></div>
  <br/>
  <?php //Validar que el formulario esté en estado 99 - 5 para poder ser activado por el critico
	  if (($novedad_estado["novedad"]==99)&&($novedad_estado["estado"]==4)){  
  ?>  	<input type="button" id="btnOBSCriticaIII" name="btnOBSCriticaIII" value="Observaciones Cr&iacute;tica" class="button"/>        
  <?php } ?>
  <input type="hidden" id="op" name="op" value="<?php echo $modulo3["op"]; ?>"/>
  <input type="hidden" id="nro_orden" name="nro_orden" value="<?php echo $nro_orden; ?>"/> 
  <input type="hidden" id="nro_establecimiento" name="nro_establecimiento" value="<?php echo $nro_establecimiento; ?>"/>
</form>