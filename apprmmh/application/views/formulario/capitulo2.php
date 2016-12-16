<?php $this->load->library("general"); ?>
<h3>Ingresos netos operacionales causados en el mes (miles de pesos)</h3>
<p>En los valores parciales no incluya impuestos indirectos (IVA, Consumo)</p>
<br/>
<form id="frmCapituloII" name="frmCapituloII" method="post" action="">
  <table>
  <tr>
    <td>1. Alojamiento </td>
	<td><input type="text" id="inalo" name="inalo" value="<?php echo $capitulo2["inalo"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox" size="7"/></td>
  </tr>
  <tr>
	<td><label>2. Servicios de alimentos y bebidas no alcoh&oacute;licas, no incluidas en alojamiento</label></td>
    <td><input type="text" id="inali" name="inali" value="<?php echo $capitulo2["inali"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox" size="7"/></td>
  </tr>
  <tr>
	<td>3. Servicios de bebidas alcoh&oacute;licas y cigarrilos, no incluidos en alojamiento</td>
	<td><input type="text" id="inba" name="inba" value="<?php echo $capitulo2["inba"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox" size="7"/></td>
  </tr>
  <tr>
	<td>4. Alquiler de salones y/u organizaci&oacute;n de eventos</td>
	<td><input type="text" id="inoe" name="inoe" value="<?php echo $capitulo2["inoe"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox" size="7"/></td>
  </tr>
  <tr>
	<td>5. Otros ingresos netos operacionales no incluidos anteriormente</td>
    <td><input type="text" id="inoio" name="inoio" value="<?php echo $capitulo2["inoio"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox" size="7"/></td>
  </tr>
  <tr>
	<td>6. Total de ingresos netos operacionales (Sin IVA)</td>
    <td><input type="text" id="intio" name="intio" value="<?php echo $capitulo2["intio"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox" size="7"/></td>
  </tr>
  </table>
  <div id="observaciones2"></div>
  <br/>
  <?php if (!$bloqueo){ 
  			switch($controller){
		  		case 'fuente':        $button = '<input type="submit" id="btnCapituloII" name="btnCapituloII" value="Guardar y continuar" class="button"/>';
		                   		      break; 
		  		case 'critico':       $button = '<input type="button" id="btnCap2CR" name="btnCap2CR" value="Guardar Observaciones" class="button"/>';
		                   		 	  break;  
		  		case 'administrador': $button = '<input type="button" id="btnCap2CR" name="btnCap2CR" value="Guardar Observaciones" class="button"/>';
		  		                      break;           		               
	        }
  ?>
  <table>
  <tr>
    <td colspan="2"><?php echo $button; ?></td>
  </tr>
  </table>
  <?php } ?>
  <input type="hidden" id="op" name="op" value="<?php echo $capitulo2["op"]; ?>"/>
  <input type="hidden" id="numord" name="numord" value="<?php echo $nro_orden; ?>"/> 
</form>