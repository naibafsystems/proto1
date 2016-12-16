<?php $this->load->library("general"); ?>
<h3>M&oacute;dulo IV - Infraestructura y ocupaci&oacute;n hotelera</h3>
<br/>
<form id="frmModuloIV" name="frmModuloIV" method="post" action="">
<table width="100%">
  <thead>
  <tr>
    <th colspan="4" align="center">CARACTER&Iacute;STICAS DE LOS HOTELES</th>
  </tr>
  </thead>
  <tbody>
  <tr>
    <td width="250" rowspan="2">N&uacute;mero de habitaciones:</td>
    <td>Ofrecidas total mes</td>
    <td>Ocupadas o vendidas mes</td>
  	<td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text" id="ihdo" name="ihdo" value="<?php echo $modulo4["ihdo"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="ihoa" name="ihoa" value="<?php echo $modulo4["ihoa"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
	<td rowspan="2">N&uacute;mero de camas:</td>
	<td>Ofrecidas total mes</td>
	<td>Ocupadas o vendidas mes</td>
	<td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="text" id="icda" name="icda" value="<?php echo $modulo4["icda"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="icva" name="icva" value="<?php echo $modulo4["icva"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
  	<td>&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="2">Huespedes - Llegada de personas<br/><span id="texto6">(Check-In):</span></td>
	<td>Residentes en Colombia</td>
	<td>No Residentes</td>
	<td>Total</td>
  </tr>
  <tr>
	<td><input type="text" id="ihpn" name="ihpn" value="<?php echo $modulo4["ihpn"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="ihpnr" name="ihpnr" value="<?php echo $modulo4["ihpnr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="huetot" name="huetot" value="<?php echo $modulo4["huetot"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
  </tr>
  </tbody>
</table>
<br/>
<table width="100%">
  <thead>
  <tr>
    <th colspan="3" align="center"><span id="texto1">MOTIVO DE VIAJE DE LOS HU&Eacute;SPEDES</span></th>
  </tr>
  <tr>
    <th  width="35%">Motivo de viaje</th>
	<th>Residentes %</th>
	<th>No Residentes %</th>
  </tr>
  </thead>
  <tbody>
  <tr>
    <td><label>1. Negocios</label></td>
	<td><input type="text" id="mvnr" name="mvnr" value="<?php echo $modulo4["mvnr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="mvnnr" name="mvnnr" value="<?php echo $modulo4["mvnnr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
  </tr>
  <tr>
    <td><label><span id="textoMICE">2. Convenciones (MICE)</span></label></td>
	<td><input type="text" id="mvcr" name="mvcr" value="<?php echo $modulo4["mvcr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="mvcnr" name="mvcnr" value="<?php echo $modulo4["mvcnr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
  </tr>   
  <tr>
    <td><label>3. Ocio y recreo y vacaciones</label></td>
	<td><input type="text" id="mvor" name="mvor" value="<?php echo $modulo4["mvor"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="mvonr" name="mvonr" value="<?php echo $modulo4["mvonr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
  </tr>
  <tr>
    <td><label>4. Salud y atenci&oacute;n m&eacute;dica (Incluye tratamientos <br>de atenci&oacute;n est&eacute;tica)</label></td>
	<td><input type="text" id="mvsr" name="mvsr" value="<?php echo $modulo4["mvsr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="mvsnr" name="mvsnr" value="<?php echo $modulo4["mvsnr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
  </tr>
  <tr>
    <td><label>5. Otros (amercos, imprevistos de transporte, etc..)</label></td>
	<td><input type="text" id="mvotr" name="mvotr" value="<?php echo $modulo4["mvotr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="mvotnr" name="mvotnr" value="<?php echo $modulo4["mvotnr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
  </tr>
  <tr>
    <td><label>6. Total</label></td>
	<td><input type="text" id="mvott" name="mvott" value="<?php echo $modulo4["mvott"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td><input type="text" id="mvottnr" name="mvottnr" value="<?php echo $modulo4["mvottnr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
  </tr>
  </tbody>
</table>
<br>
<table width="100%">
  <thead>
  <tr>
    <th colspan="3" align="center">TARIFA PROMEDIO POR TIPO DE ACOMODACI&Oacute;N</th>			  			  
  </tr>
  <tr>
    <th colspan="3">&nbsp;</th>			  			  
  </tr>
  <tr>
    <th width="16%">Tipo de habitaci&oacute;n</th>
    <th width="17%" style="text-align:center">N&uacute;mero de habitaciones <br/>vendidas</th>
    <th width="25%" style="padding-right: 20px; text-align:center"><span id="texto2">Tarifa promedio por persona <br> (valor en pesos)</span></th>			  
  </tr>
  </thead>
  <tbody>
  <tr>
    <td>1. Sencilla</td>
	<td style="text-align:center"><input type="text" id="thsen" name="thsen" value="<?php echo $modulo4["thsen"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td style="text-align:center"><input type="text" id="thusen" name="thusen" value="<?php echo $modulo4["thusen"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>			  
  </tr>
  <tr>
	<td>2. Doble</td>
	<td style="text-align:center"><input type="text" id="thdob" name="thdob" value="<?php echo $modulo4["thdob"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td style="text-align:center"><input type="text" id="thudob" name="thudob" value="<?php echo $modulo4["thudob"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>			  
  </tr>
  <tr>
	<td>3. Suite</td>
	<td style="text-align:center"><input type="text" id="thsui" name="thsui" value="<?php echo $modulo4["thsui"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td style="text-align:center"><input type="text" id="thusui" name="thusui" value="<?php echo $modulo4["thusui"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>			  
  </tr>
  <tr>
	<td><span id="texto3">4. Multiple</span></td>
	<td style="text-align:center"><input type="text" id="thmult" name="thmult" value="<?php echo $modulo4["thmult"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td style="text-align:center"><input type="text" id="thumult" name="thumult" value="<?php echo $modulo4["thumult"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>			  
  </tr>
  <tr>
	<td><span id="texto4">5. Otro tipo de habitaci&oacute;n</span></td>
	<td style="text-align:center"><input type="text" id="thotr" name="thotr" value="<?php echo $modulo4["thotr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td style="text-align:center"><input type="text" id="thuotr" name="thuotr" value="<?php echo $modulo4["thuotr"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>			  
  </tr>
  <tr>
	<td>6. Total</td>
	<td style="text-align:center"><input type="text" id="thtot" name="thtot" value="<?php echo $modulo4["thtot"]; ?>" class="textbox" <?php $this->general->bloqueoCampo($bloqueo); ?>/></td>
	<td></td>			  
  </tr>
  </tbody>
</table>
<br/>
<br/>
<div id="divihoa"></div>
<div id="divicva"></div>
<div id="divhuetot"></div>
<div id="divthudob"></div>
<div id="divthusui"></div>
<div id="divthumult"></div>
<div id="divinalomul"></div>
<div id="divinalootr"></div>
<div id="observaciones4"></div>
<br/>
<?php //Validar que el formulario esté en estado 99 - 5 para poder ser activado por el administrador 
	  if (($novedad_estado["novedad"]==99)&&($novedad_estado["estado"]==4)){  
  ?>  	<center><input type="button" id="btnOBSAsistenteIV" name="btnOBSAsistenteIV" value="Observaciones Asistente" class="button"/></center>        
  <?php } ?>	
<input type="hidden" id="op" name="op" value="<?php echo $modulo4["op"]; ?>"/>
<input type="hidden" id="nro_orden" name="nro_orden" value="<?php echo $nro_orden; ?>"/> 
<input type="hidden" id="nro_establecimiento" name="nro_establecimiento" value="<?php echo $nro_establecimiento; ?>"/>
</form>