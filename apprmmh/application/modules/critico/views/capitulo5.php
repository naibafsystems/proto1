<h3>Caracter&iacute;sticas de los hoteles</h3>
<br/>
<form id="frmCapituloV" name="frmCapituloV" method="post" action="">
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
    <td><input type="text" id="habdia" name="habdia" value="<?php echo $capitulo5["habdia"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="ihdo" name="ihdo" value="<?php echo $capitulo5["ihdo"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="ihoa" name="ihoa" value="<?php echo $capitulo5["ihoa"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
  </tr>
  <tr>
	<td rowspan="2">N&uacute;mero de camas:</td>
	<td>Disponibles por d&iacute;a</td>
	<td>Ofrecidas total mes</td>
	<td>Ocupadas o vendidas</td>
  </tr>
  <tr>
    <td><input type="text" id="camdia" name="camdia" value="<?php echo $capitulo5["camdia"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="icda" name="icda" value="<?php echo $capitulo5["icda"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="icva" name="icva" value="<?php echo $capitulo5["icva"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
  </tr>
  <tr>
    <td rowspan="2">Huespedes - Llegada de personas<br/><span id="texto6">(Check-In):</span></td>
	<td>Residentes en Colombia</td>
	<td>No Residentes</td>
	<td>Total</td>
  </tr>
  <tr>
	<td><input type="text" id="ihpn" name="ihpn" value="<?php echo $capitulo5["ihpn"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="ihpnr" name="ihpnr" value="<?php echo $capitulo5["ihpnr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="huetot" name="huetot" value="<?php echo $capitulo5["huetot"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
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
	<td><input type="text" id="thsen" name="thsen" value="<?php echo $capitulo5["thsen"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="ingsen" name="ingsen" value="<?php echo $capitulo5["ingsen"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>			  
	<td><input type="text" id="inalosen" name="inalosen" value="<?php echo $capitulo5["inalosen"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>			  
  </tr>
  <tr>
	<td>2. Doble</td>
	<td><input type="text" id="thdob" name="thdob" value="<?php echo $capitulo5["thdob"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="ingdob" name="ingdob" value="<?php echo $capitulo5["ingdob"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>			  
	<td><input type="text" id="inalodob" name="inalodob" value="<?php echo $capitulo5["inalodob"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>			  
  </tr>
  <tr>
	<td>3. Suite</td>
	<td><input type="text" id="thsui" name="thsui" value="<?php echo $capitulo5["thsui"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="ingsui" name="ingsui" value="<?php echo $capitulo5["ingsui"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>			  
	<td><input type="text" id="inalosui" name="inalosui" value="<?php echo $capitulo5["inalosui"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>			  
  </tr>
  <tr>
	<td><span id="texto3">4. Multiple</span></td>
	<td><input type="text" id="thmult" name="thmult" value="<?php echo $capitulo5["thmult"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="ingmul" name="ingmul" value="<?php echo $capitulo5["ingmult"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>			  
	<td><input type="text" id="inalomul" name="inalomul" value="<?php echo $capitulo5["inalomul"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>			  
  </tr>
  <tr>
	<td><span id="texto4">5. Otro tipo de habitaci&oacute;n</span></td>
	<td><input type="text" id="thotr" name="thotr" value="<?php echo $capitulo5["thotr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="ingotr" name="ingotr" value="<?php echo $capitulo5["ingotr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>			  
	<td><input type="text" id="inalootr" name="inalootr" value="<?php echo $capitulo5["inalootr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>			  
  </tr>
  <tr>
	<td>6. Total</td>
	<td><input type="text" id="thtot" name="thtot" value="<?php echo $capitulo5["thtot"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="ingtot" name="ingtot" value="<?php echo $capitulo5["ingtot"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>			  
	<td><input type="text" id="inalotot" name="inalotot" value="<?php echo $capitulo5["inalotot"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>			  
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
    <td><label>1. Negocios </label></td>
	<td><input type="text" id="mvnr" name="mvnr" value="<?php echo $capitulo5["mvnr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="mvnnr" name="mvnnr" value="<?php echo $capitulo5["mvnnr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
  </tr>
  <tr>
    <td><label>2. Convenciones</label></td>
	<td><input type="text" id="mvcr" name="mvcr" value="<?php echo $capitulo5["mvcr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="mvcnr" name="mvcnr" value="<?php echo $capitulo5["mvcnr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
  </tr>  
  <tr>
    <td>3. Ocio y recreaci&oacute;n</td>
	<td><input type="text" id="mvor" name="mvor" value="<?php echo $capitulo5["mvor"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="mvonr" name="mvonr" value="<?php echo $capitulo5["mvonr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
  </tr>
  <tr>
    <td>4. Salud y Belleza</td>
	<td><input type="text" id="mvsr" name="mvsr" value="<?php echo $capitulo5["mvsr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="mvsnr" name="mvsnr" value="<?php echo $capitulo5["mvsnr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
  </tr>
  <tr>
    <td>5. Otros</td>
	<td><input type="text" id="mvotr" name="mvotr" value="<?php echo $capitulo5["mvotr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="mvotnr" name="mvotnr" value="<?php echo $capitulo5["mvotnr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
  </tr>
  <tr>
    <td>6. Total</td>
	<td><input type="text" id="mvott" name="mvott" value="<?php echo $capitulo5["mvott"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="mvottnr" name="mvottnr" value="<?php echo $capitulo5["mvottnr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
  </tr>
  </tbody>
</table>
<br/>
<div id="observaciones4"></div>
<br/>
 <?php //Validar que el formulario esté en estado 99 - 4 para poder ser activado 
	  if (($novedad_estado["novedad"]==99)&&($novedad_estado["estado"]==4)){  
 ?>  	<table>
		<tr>
  			<td colspan="2"><input type="button" id="btnOBSCriticaV" name="btnOBSCriticaV" value="Observaciones Cr&iacute;tica" class="button"/></td>
		</tr>
		</table>
 <?php } ?>
<input type="hidden" id="op" name="op" value="<?php echo $capitulo5["op"]; ?>"/>
<input type="hidden" id="hddNumOrden" name="hddNumOrden" value="<?php echo $nro_orden; ?>"/>
<input type="hidden" id="hddUniLocal" name="hddUniLocal" value="<?php echo $uni_local; ?>"/>
</form>