<?php $this->load->library("general"); ?>
<h3>Caracter&iacute;sticas de los hoteles</h3>
<br/>
<form id="frmCapituloIV" name="frmCapituloIV" method="post" action="">
<table>
  <thead>
  <tr>
    <th colspan="4" align="center">Caracter&iacute;sticas de los hoteles</th>
  </tr>
  </thead>
  <tbody>
  <tr>
    <td width="250" rowspan="2">N&uacute;mero de habitaciones:</td>
    <td>Disponibles por d&iacute;a</td>
	<td>Ofrecidas total mes</td>
    <td>Ocupadas o vendidas</td>
  </tr>
  <tr>
    <td><input type="text" id="habdia" name="habdia" value="<?php echo $capitulo4["habdia"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="ihdo" name="ihdo" value="<?php echo $capitulo4["ihdo"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="ihoa" name="ihoa" value="<?php echo $capitulo4["ihoa"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
  </tr>
  <tr>
	<td rowspan="2">N&uacute;mero de camas:</td>
	<td>Disponibles por d&iacute;a</td>
	<td>Ofrecidas total mes</td>
	<td>Ocupadas o vendidas</td>
  </tr>
  <tr>
    <td><input type="text" id="camdia" name="camdia" value="<?php echo $capitulo4["camdia"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="icda" name="icda" value="<?php echo $capitulo4["icda"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="icva" name="icva" value="<?php echo $capitulo4["icva"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
  </tr>
  <tr>
    <td rowspan="2">Huespedes - Llegada de personas<br/><span id="texto6">(Check-In):</span></td>
	<td>Residentes en Colombia</td>
	<td>No Residentes</td>
	<td>Total</td>
  </tr>
  <tr>
	<td><input type="text" id="ihpn" name="ihpn" value="<?php echo $capitulo4["ihpn"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="ihpnr" name="ihpnr" value="<?php echo $capitulo4["ihpnr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="huetot" name="huetot" value="<?php echo $capitulo4["huetot"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
  </tr>
  </tbody>
</table>
<br/>
<table width="100%">
  <thead>
  <tr>
    <th colspan="4">Ingresos por habitaci&oacute;n vendida (Diligencie de acuerdo con las siguientes especificaciones):</th>			  			  
  </tr>
  <tr>
    <th colspan="4">&nbsp;</th>			  			  
  </tr>
  <tr>
    <th width="16%">Tipo de habitaci&oacute;n</th>
    <th width="15%">N&uacute;mero de habitaciones <br/>vendidas</th>
    <th width="25%"><span id="texto2">Total facturado si la tarifa de la habitaci&oacute;n incluye <br/>alojamiento y otros  servicios (miles de pesos)</span></th>			  
    <th width="30%">Total facturado si la tarifa de la habitaci&oacute;n <br/>s&oacute;lo incluye alojamiento (miles de pesos)</th>
  </tr>
  </thead>
  <tbody>
  <tr>
    <td>1. Sencilla</td>
	<td><input type="text" id="thsen" name="thsen" value="<?php echo $capitulo4["thsen"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="ingsen" name="ingsen" value="<?php echo $capitulo4["ingsen"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>			  
	<td><input type="text" id="inalosen" name="inalosen" value="<?php echo $capitulo4["inalosen"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>			  
  </tr>
  <tr>
	<td>2. Doble</td>
	<td><input type="text" id="thdob" name="thdob" value="<?php echo $capitulo4["thdob"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="ingdob" name="ingdob" value="<?php echo $capitulo4["ingdob"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>			  
	<td><input type="text" id="inalodob" name="inalodob" value="<?php echo $capitulo4["inalodob"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>			  
  </tr>
  <tr>
	<td>3. Suite</td>
	<td><input type="text" id="thsui" name="thsui" value="<?php echo $capitulo4["thsui"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="ingsui" name="ingsui" value="<?php echo $capitulo4["ingsui"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>			  
	<td><input type="text" id="inalosui" name="inalosui" value="<?php echo $capitulo4["inalosui"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>			  
  </tr>
  <tr>
	<td><span id="texto3">4. Multiple</span></td>
	<td><input type="text" id="thmult" name="thmult" value="<?php echo $capitulo4["thmult"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="ingmul" name="ingmul" value="<?php echo $capitulo4["ingmult"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>			  
	<td><input type="text" id="inalomul" name="inalomul" value="<?php echo $capitulo4["inalomul"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>			  
  </tr>
  <tr>
	<td><span id="texto4">5. Otro tipo de habitaci&oacute;n</span></td>
	<td><input type="text" id="thotr" name="thotr" value="<?php echo $capitulo4["thotr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="ingotr" name="ingotr" value="<?php echo $capitulo4["ingotr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>			  
	<td><input type="text" id="inalootr" name="inalootr" value="<?php echo $capitulo4["inalootr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>			  
  </tr>
  <tr>
	<td>6. Total</td>
	<td><input type="text" id="thtot" name="thtot" value="<?php echo $capitulo4["thtot"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="ingtot" name="ingtot" value="<?php echo $capitulo4["ingtot"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>			  
	<td><input type="text" id="inalotot" name="inalotot" value="<?php echo $capitulo4["inalotot"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>			  
  </tr>
  </tbody>
</table>
<br/>
<table>
  <thead>
  <tr>
    <th colspan="3" align="center"><span id="texto1">Motivo de viaje</span></th>
  </tr>
  <tr>
    <th>Motivo de viaje</th>
	<th>Residentes %</th>
	<th>No Residentes %</th>
  </tr>
  </thead>
  <tbody>
  <tr>
    <td><label>1. Negocios</label></td>
	<td><input type="text" id="mvnr" name="mvnr" value="<?php echo $capitulo4["mvnr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="mvnnr" name="mvnnr" value="<?php echo $capitulo4["mvnnr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
  </tr>
  <tr>
    <td><label>2. Convenciones</label></td>
	<td><input type="text" id="mvcr" name="mvcr" value="<?php echo $capitulo4["mvcr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="mvcnr" name="mvcnr" value="<?php echo $capitulo4["mvcnr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
  </tr>   
  <tr>
    <td><label>3. Ocio y recreaci&oacute;n</label></td>
	<td><input type="text" id="mvor" name="mvor" value="<?php echo $capitulo4["mvor"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="mvonr" name="mvonr" value="<?php echo $capitulo4["mvonr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
  </tr>
  <tr>
    <td><label>4. Salud y Belleza</label></td>
	<td><input type="text" id="mvsr" name="mvsr" value="<?php echo $capitulo4["mvsr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="mvsnr" name="mvsnr" value="<?php echo $capitulo4["mvsnr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
  </tr>
  <tr>
    <td><label>5. Otros</label></td>
	<td><input type="text" id="mvotr" name="mvotr" value="<?php echo $capitulo4["mvotr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="mvotnr" name="mvotnr" value="<?php echo $capitulo4["mvotnr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
  </tr>
  <tr>
    <td><label>6. Total</label></td>
	<td><input type="text" id="mvott" name="mvott" value="<?php echo $capitulo4["mvott"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="mvottnr" name="mvottnr" value="<?php echo $capitulo4["mvottnr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
  </tr>
  </tbody>
</table>
<br/>

<div id="observaciones4"></div>
<br/>
<?php if (!$bloqueo){ 
			switch($controller){
		  		case 'fuente':        $button = '<input type="submit" id="btnCapituloIV" name="btnCapituloIV" value="Guardar y continuar" class="button"/>';
		                   		      break; 
		  		case 'critico':       $button = '<input type="button" id="btnCap4CR" name="btnCap4CR" value="Guardar Observaciones" class="button"/>';
		                   		      break;
		  		case 'administrador': $button = '<input type="button" id="btnCap4CR" name="btnCap4CR" value="Guardar Observaciones" class="button"/>';
		  		                      break;           		                 
	        }
?>
<table>
<tr>
  <td colspan="2"><?php echo $button; ?></td>
</tr>
</table>
<?php } ?>
<input type="hidden" id="op" name="op" value="<?php echo $capitulo4["op"]; ?>"/>
<input type="hidden" id="numord" name="numord" value="<?php echo $nro_orden; ?>"/> 
</form>