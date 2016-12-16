<h3>Movimiento mensual de los establecimientos que conforman la unidad local</h3>
<p>N&uacute;mero de establecimientos de este informe</p>
<br/>
<form id="frmCapituloII" name="frmCapituloII" method="post" action="">  
  <table>
  <tr>
    <td>1. Iniciales(+):</td>
    <td><input type="text" id="esini" name="esini" value="<?php echo $capitulo2["esini"]; ?>" style="width: 80px;" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"/></td>
  </tr>
  <tr>
    <td>2. Aperturas en el mes(+):</td>
    <td><input type="text" id="esape" name="esape" value="<?php echo $capitulo2["esape"]; ?>" style="width: 80px;" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"/></td>
  </tr>
  <tr>
    <td>3. Cierres en el mes(-):</td>
    <td><input type="text" id="escie" name="escie" value="<?php echo $capitulo2["escie"]; ?>" style="width: 80px;" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"/></td>
  </tr>
  <tr>
    <td><label>4. Total al final del mes(=):</label></td>
    <td><input type="text" id="estot" name="estot" value="<?php echo $capitulo2["estot"]; ?>" style="width: 80px;" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"/></td>
  </tr>  
  </table>
  <div id="observaciones"></div>  
  <br/>
  <?php //Validar que el formulario esté en estado 99 - 4 para poder ser activado 
	  if (($novedad_estado["novedad"]==99)&&($novedad_estado["estado"]==4)){  
  ?>  	<table>
  		<tr>
    		<td colspan="2"><input type="button" id="btnOBSCriticaII" name="btnOBSCriticaII" value="Observaciones Asistente" class="button"/></td>
  		</tr>
  		</table>
  <?php } ?>  
  <input type="hidden" id="op" name="op" value="<?php echo $capitulo2["op"]; ?>"/>
  <input type="hidden" id="hddNumOrden" name="hddNumOrden" value="<?php echo $nro_orden; ?>"/>
  <input type="hidden" id="hddUniLocal" name="hddUniLocal" value="<?php echo $uni_local; ?>"/>  
</form>