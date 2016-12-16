<h3>Ingresos netos operacionales causados en el mes (miles de pesos)</h3>
<p>En los valores parciales no incluya impuestos indirectos (IVA, Consumo)</p>
<br/>
<form id="frmCapituloIII" name="frmCapituloIII" method="post" action="">
  <table>
  <tr>
    <td>1. Alojamiento. </td>
	<td><input type="text" id="inalo" name="inalo" value="<?php echo $capitulo3["inalo"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox" size="7"/></td>
  </tr>
  <tr>
	<td><label>2. Servicios de alimentos y bebidas no alcoh&oacute;licas, no incluidas en alojamiento</label></td>
    <td><input type="text" id="inali" name="inali" value="<?php echo $capitulo3["inali"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox" size="7"/></td>
  </tr>
  <tr>
	<td>3. Servicios de bebidas alcoh&oacute;licas y cigarrilos, no incluidos en alojamiento</td>
	<td><input type="text" id="inba" name="inba" value="<?php echo $capitulo3["inba"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox" size="7"/></td>
  </tr>
  <tr>
	<td>4. Alquiler de salones y/u organizaci&oacute;n de eventos</td>
	<td><input type="text" id="inoe" name="inoe" value="<?php echo $capitulo3["inoe"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox" size="7"/></td>
  </tr>
  <tr>
	<td>5. Otros ingresos netos operacionales no incluidos anteriormente</td>
    <td><input type="text" id="inoio" name="inoio" value="<?php echo $capitulo3["inoio"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox" size="7"/></td>
  </tr>
  <tr>
	<td>6. Total de ingresos netos operacionales (Sin IVA)</td>
    <td><input type="text" id="intio" name="intio" value="<?php echo $capitulo3["intio"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox" size="7"/></td>
  </tr>
  </table>
  <div id="observaciones2"></div>
  <br/>
  <?php //Validar que el formulario esté en estado 99 - 4 para poder ser activado 
	  if (($novedad_estado["novedad"]==99)&&($novedad_estado["estado"]==4)){  
  ?>  	<table>
  		<tr>
    		<td colspan="2"><input type="button" id="btnOBSCriticaIII" name="btnOBSCriticaIII" value="Observaciones Asistente" class="button"/></td>
  		</tr>
  		</table>
  <?php } ?>
  <input type="hidden" id="op" name="op" value="<?php echo $capitulo3["op"]; ?>"/>
  <input type="hidden" id="hddNumOrden" name="hddNumOrden" value="<?php echo $nro_orden; ?>"/>
  <input type="hidden" id="hddUniLocal" name="hddUniLocal" value="<?php echo $uni_local; ?>"/>   
</form>