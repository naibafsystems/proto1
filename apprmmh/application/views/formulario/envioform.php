<?php $this->load->library("general"); ?>
<h3>Enviar formulario</h3>			
<br/>
<form id="frmEnvio" name="frmEnvio" method="post" action="">
<table>
<tr>
  <td colspan="3" align="left">Observaciones (M&aacute;ximo 500 caracteres)<textarea id="fteObserv" name="fteObserv" style="width: 99%;" rows="5" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"><?php echo $envio["observaciones"]; ?></textarea></td>			      
</tr>
<tr>
  <td colspan="3">&nbsp;</td>
</tr>
<tr>
  <td valign="top">
     <fieldset style="height: 180px;">
     <legend>Ciudad y fecha de diligenciamiento</legend>
	 <table>
	 <tr>
	   <td>Ciudad</td>
	   <td colspan="3"><input type="text" id="dmpio" name="dmpio" value="<?php echo $envio["dmpio"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"/></td>
	 </tr>
	 <tr>
	   <td>Fecha de diligenciamiento</td>
	   <td><input type="text" id="fedili" name="fedili" value="<?php echo date("d/m/Y"); ?>" class="textbox" readonly="readonly"/></td>			            
	 </tr>	         
	 </table>
	 </fieldset>
  </td>
  <td valign="top">
     <fieldset style="height: 180px;">
	 <legend>Responsable de la empresa</legend>
	 <table>
	 <tr>
	   <td>Nombre:</td>
	   <td><input type="text" id="repleg" name="repleg" value="<?php echo $envio["repleg"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"/></td>
	 </tr>
	 <tr>
	   <td>&nbsp;</td>
	   <td>&nbsp;</td>
	 </tr>
	 <tr>
	   <td>Firma:</td>
	   <td style="border-bottom: 1px solid #000000;">&nbsp;</td>
	 </tr>	 
	 </table>
	 </fieldset>
  </td>
  <td valign="top">
     <fieldset style="height: 180px;">
	 <legend>Persona a quien dirigirse para consultas</legend>
	 <table>
	   <tr>
	     <td>Nombre:</td>
		 <td><input type="text" id="responde" name="responde" value="<?php echo $envio["responde"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"/></td>
	   </tr>
	   <tr>
	     <td>Cargo:</td>
	     <td><input type="text" id="respoca" name="respoca" value="<?php echo $envio["respoca"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"></td>
	   </tr>
	   <tr>
	     <td>Tel.:</td>
	     <td><input type="text" id="teler" name="teler" value="<?php echo $envio["teler"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"></td>
	   </tr>
	   <tr>
	     <td>Correo electr&oacute;nico:</td>
	     <td><input type="text" id="emailr" name="emailr" value="<?php echo $envio["emailr"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"></td>
	   </tr>
	 </table>
	 </fieldset>
  </td>
</tr>  
</table>
<br>
<p><b>La no presentaci&oacute;n oportuna de este informe acarrea las sanciones establecidas en la Ley 079 de 1993.</b></p>
<br/>
<?php if (!$bloqueo){ 
			switch($controller){
		  		case 'fuente':        $button = '<input type="submit" id="btnObservaciones" name="btnObservaciones" value="Guardar y enviar" class="button"/>';
		                   		      break; 
		  		case 'critico':  	  $button = '<input type="button" id="btnEnvioCR" name="btnEnvioCR" value="Guardar Observaciones" class="button"/>';
		                   		      break;  
		  		case 'administrador': $button = '<input type="button" id="btnEnvioCR" name="btnEnvioCR" value="Guardar Observaciones" class="button"/>';
		  		                      break;           		               
	        }
?>
<table>
<tr>
  <td colspan="2"><?php echo $button; ?></td>
</tr>
</table>
<?php } ?>
<input type="hidden" id="op" name="op" value="<?php echo $envio["op"]; ?>">
<input type="hidden" id="numord" name="numord" value="<?php echo $nro_orden; ?>"/> 
</form>