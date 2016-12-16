<?php $this->load->library("general"); ?>
<h3>Movimiento mensual de los establecimientos que conforman la unidad local</h3>
<p>N&uacute;mero de establecimientos de este informe</p>
<br/>
<form id="frmCapituloI" name="frmCapituloI" method="post" action="">  
  <table>
  <tr>
    <td>1. Iniciales(+):</td>
    <td><input type="text" id="esini" name="esini" value="<?php echo $capitulo1["esini"]; ?>" style="width: 80px;" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"/></td>
  </tr>
  <tr>
    <td>2. Aperturas en el mes(+):</td>
    <td><input type="text" id="esape" name="esape" value="<?php echo $capitulo1["esape"]; ?>" style="width: 80px;" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"/></td>
  </tr>
  <tr>
    <td>3. Cierres en el mes(-):</td>
    <td><input type="text" id="escie" name="escie" value="<?php echo $capitulo1["escie"]; ?>" style="width: 80px;" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"/></td>
  </tr>
  <tr>
    <td><label>4. Total al final del mes(=):</label></td>
    <td><input type="text" id="estot" name="estot" value="<?php echo $capitulo1["estot"]; ?>" style="width: 80px;" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"/></td>
  </tr>
  <tr>
    <td colspan="2"></td>
  </tr>
  </table>
  <br/>
  <div id="observaciones"></div>
  <br/>
  <?php if (!$bloqueo){ 
  	 		switch($controller){
		  		case 'fuente':   	  $button = '<input type="submit" id="btnCapituloI" name="btnCapituloI" value="Guardar y continuar" class="button"/>';
		                   		 	  break; 
		  		case 'critico':  	  $button = '<input type="button" id="btnCap1CR" name="btnCap1CR" value="Guardar Observaciones" class="button"/>';
		                   		 	  break;
		  		case 'administrador': $button = '<input type="button" id="btnCap1CR" name="btnCap1CR" value="Guardar Observaciones" class="button"/>';
		  		                      break;           		                 
	        }
  ?>	         
  			<table>
  			<tr>
   				<td colspan="2"><?php echo $button; ?></td>
  			</tr>
  			</table>
  <?php } ?>
  <input type="hidden" id="op" name="op" value="<?php echo $capitulo1["op"]; ?>"/>
  <input type="hidden" id="numord" name="numord" value="<?php echo $nro_orden; ?>"/>  
</form>
  