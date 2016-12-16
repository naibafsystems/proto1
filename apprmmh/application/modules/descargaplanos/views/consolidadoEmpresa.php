<fieldset style="padding: 10px; border: 1px solid #CCCCCC">
<legend align='center'>INFORMACI&Oacute;N CONSOLIDADA HOTEL <?php echo "$nro_orden - $empresa"; ?></legend>
	<fieldset style="padding: 10px; border: 1px solid #CCCCCC">
	<legend>M&oacute;dulo II - Personal ocupado promedio y salarios causados en el mes</legend>
		<table width="100%">
		<thead>
		<tr>
		  <td>Tipo de contrataci&oacute;n</td>
		  <td width="200px" style="text-align:center">N&uacute;mero promedio de personas ocupadas en el mes</td>
		  <td width="230px" style="text-align:center">Total Sueldos y salarios causados por el personal ocupado en el mes (miles de pesos)</td>
		</tr>
		</thead>
		<tbody>
		<tr>
		  <td width="450">1. Propietarios, socios y familiares sin remuneraci&oacute;n fija.</td>
		  <td style="text-align:center"><?php echo number_format($modulo2["potpsfr"],0,',','.'); ?></td>
		  <td style="text-align:center">-&nbsp;</td>
		</tr>
		<tr>
		  <td style="text-align:left">2. Personal permanente (Contrato a t&eacute;rmino indefinido).</td>
		  <td style="text-align:center"><?php echo number_format($modulo2["potperm"],0,',','.'); ?></td>
		  <td style="text-align:center"><?php echo number_format($modulo2["gpper"],0,',','.'); ?></td>
		</tr>
		<tr>
		  <td style="text-align:left">3. Personal temporal contratado directamente por el hotel (Contrato a t&eacute;rmino definido).</td>
		  <td style="text-align:center"><?php echo number_format($modulo2["pottcde"],0,',','.'); ?></td>
		  <td style="text-align:center"><?php echo number_format($modulo2["gpssde"],0,',','.'); ?></td>
		</tr>
		<tr>
		  <td style="text-align:left">4. Personal temporal contratado a  traves de empresas especializadas.</td>
		  <td style="text-align:center"><?php echo number_format($modulo2["pottcag"],0,',','.'); ?></td>
		  <td style="text-align:center"><?php echo number_format($modulo2["gpppta"],0,',','.'); ?></td>
		</tr>
		<tr>
		  <td style="text-align:left">5. Aprendices y pasantes (universitarios, t&eacute;cnicos y tecn&oacute;logos) Ley 789 de 2002.</td>
		  <td style="text-align:center"><?php echo number_format($modulo2["potpau"],0,',','.'); ?></td>
		  <td style="text-align:center"><?php echo number_format($modulo2["gppgpa"],0,',','.'); ?></td>
		</tr>
		<tr>
		  <td style="text-align:left">6. Total (Sume renglones 1 a 5).</td>
		  <td style="text-align:center"><?php echo number_format($modulo2["pottot"],0,',','.'); ?></td>
		  <td style="text-align:center"><?php echo number_format($modulo2["gpsspot"],0,',','.'); ?></td>
		</tr>
		</tbody>
		</table>
	</fieldset>
	<fieldset style="padding: 10px; border: 1px solid #CCCCCC">
	<legend>M&oacute;dulo III - Ingresos netos operacionales causados en el mes (miles de pesos)</legend>
		<table width="100%" style="padding: 10px; border: 1px solid #CCCCCC">
		  <tr>
		    <td width="65%">1. Alojamiento.</td>
			<td style="text-align:center"><?php echo number_format($modulo3["inalo"],0,',','.'); ?></td>
		  </tr>
		  <tr>
			<td><label>2. Servicios de restaurante (alimentos y bebidas no alcoh&oacute;licas), no incluidos en el valor de la tarifa de alojamiento.</label></td>
		    <td style="text-align:center"><?php echo number_format($modulo3["inali"],0,',','.'); ?></td>
		  </tr>
		  <tr>
			<td>3. Servicios de bar (bebidas alcoh&oacute;licas y cigarrilos), no incluidos en el valor de la tarifa de alojamiento.</td>
			<td style="text-align:center"><?php echo number_format($modulo3["inba"],0,',','.'); ?></td>
		  </tr>
		  <tr>
			<td>4. Servicios receptivos (city tours, gu&iacute;as tur&iacute;sticos y servicios similares).</td>
			<td style="text-align:center"><?php echo number_format($modulo3["insr"],0,',','.'); ?></td>
		  </tr>
		  <tr>
			<td>5.  Alquiler de salones y/o apoyo para diferentes eventos (incluya todo lo refente al alquiler; log&iacute;stica, alimentaci&oacute;n, etc.).</td>
			<td style="text-align:center"><?php echo number_format($modulo3["inoe"],0,',','.'); ?></td>
		  </tr>
		  <tr>
			<td>6.  Otros ingresos  operacionales no solicitados antes (Incluye comunicaciones, lavander&iacute;a, peluquer&iacute;a, etc.).</td>
		    <td style="text-align:center"><?php echo number_format($modulo3["inoio"],0,',','.'); ?></td>
		  </tr>
		  <tr>
			<td>7. Total de ingresos netos operacionales (Sin IVA).</td>
		    <td style="text-align:center"><?php echo number_format($modulo3["intio"],0,',','.'); ?></td>
		  </tr>
	  </table>
	</fieldset>
	<fieldset style="padding: 10px; border: 1px solid #CCCCCC">
	<legend>M&oacute;dulo IV -  Caracter&iacute;sticas de los hoteles</legend>
		<table width="100%" style="padding: 10px; border: 1px solid #CCCCCC">
		  <thead>
		  <tr>
		    <td colspan="4" align="center">CARACTER&Iacute;STICAS DE LOS HOTELES</td>
		  </tr>
		  </thead>
		  <tbody>
		  <tr>
		    <td width="260">N&uacute;mero de habitaciones.</td>
		    <td>Ofrecidas total mes: <?php echo $modulo4["ihdo"]; ?></td>
		    <td>Ocupadas o vendidas: <?php echo number_format($modulo4["ihoa"],0,',','.'); ?></td>
		  </tr>
		  <tr>
			<td> N&uacute;mero de camas.</td>
			<td>Ofrecidas total mes: <?php echo number_format($modulo4["icda"],0,',','.'); ?></td>
			<td>Ocupadas o vendidas: <?php echo number_format($modulo4["icva"],0,',','.'); ?></td>
		  </tr>
		  <tr>
		    <td>Huespedes - Llegada de personas<span id="texto6">(Check-In).</span></td>
			<td>Residentes en Colombia: <?php echo number_format($modulo4["ihpn"],0,',','.'); ?></td>
			<td>No Residentes: <?php echo number_format($modulo4["ihpnr"],0,',','.'); ?></td>
			<td>Total: <?php echo number_format($modulo4["huetot"],0,',','.'); ?></td>
		  </tr>
		  </tbody>
		</table>
		
		<br/>
		<table width="100%" style="padding: 10px; border: 1px solid #CCCCCC">
		  <thead>
		  <tr>
		    <td colspan="3" align="center"><span id="texto1">MOTIVO DE VIAJE DE LOS HU&Eacute;SPEDES</span></td>
		  </tr>
		  <tr>
		    <td width="45%">Motivo de viaje</td>
			<td style="text-align:center">Residentes %</td>
			<td style="text-align:center">No Residentes %</td>
		  </tr>
		  </thead>
		  <tbody>
		  <tr>
		    <td><label>1. Negocios.</label></td>
			<td style="text-align:center"><?php echo round($modulo4["mvnr"]); ?></td>
			<td style="text-align:center"><?php echo round($modulo4["mvnnr"]); ?></td>
		  </tr>
		  <tr>
		    <td><label><span id="textoMICE">2. Convenciones (MICE).</span></label></td>
			<td style="text-align:center"><?php echo round($modulo4["mvcr"]); ?></td>
			<td style="text-align:center"><?php echo round($modulo4["mvcnr"]); ?></td>
		  </tr>   
		  <tr>
		    <td><label>3. Ocio, recreo y vacaciones.</label></td>
			<td style="text-align:center"><?php echo round($modulo4["mvor"]); ?></td>
			<td style="text-align:center"><?php echo round($modulo4["mvonr"]); ?></td>
		  </tr>
		  <tr>
		    <td><label>4. Salud y atenci&oacute;n m&eacute;dica (Incluye tratamientos de atenci&oacute;n est&eacute;tica).</label></td>
			<td style="text-align:center"><?php echo round($modulo4["mvsr"]); ?></td>
			<td style="text-align:center"><?php echo round($modulo4["mvsnr"]); ?></td>
		  </tr>
		  <tr>
		    <td><label>5.  Otros (imprevistos de transporte, etc.).</label></td>
			<td style="text-align:center"><?php echo round($modulo4["mvotr"]); ?></td>
			<td style="text-align:center"><?php echo round($modulo4["mvotnr"]); ?></td>
		  </tr>
		  <tr>
		    <td><label>6. Total.</label></td>
			<td style="text-align:center"><?php echo $modulo4["mvott"]; ?></td>
			<td style="text-align:center"><?php echo $modulo4["mvottnr"]; ?></td>
		  </tr>
		  </tbody>
		</table>
		<br/>
		<table width="100%" style="padding: 10px; border: 1px solid #CCCCCC">
		  <thead>
		  <tr>
		    <td colspan="2" align="center">TARIFA PROMEDIO POR TIPO DE ACOMODACI&Oacute;N</td>			  			  
		  </tr>
		  <tr>
		    <td>Tipo de habitaci&oacute;n</td>
		    <td style="text-align:center">N&uacute;mero de habitaciones vendidas</td>
		  </tr>
		  </thead>
		  <tbody>
		  <tr>
		    <td>1. Sencilla</td>
			<td style="text-align:center"><?php echo number_format($modulo4["thsen"],0,',','.'); ?></td>
		  </tr>
		  <tr>
			<td>2. Doble</td>
			<td style="text-align:center"><?php echo number_format($modulo4["thdob"],0,',','.'); ?></td>
		  </tr>
		  <tr>
			<td>3. Suite</td>
			<td style="text-align:center"><?php echo number_format($modulo4["thsui"],0,',','.'); ?></td>
		  </tr>
		  <tr>
			<td><span id="texto3">4. Multiple</span></td>
			<td style="text-align:center"><?php echo number_format($modulo4["thmult"],0,',','.'); ?></td>
		  </tr>
		  <tr>
			<td><span id="texto4">5. Otro tipo de habitaci&oacute;n</span></td>
			<td style="text-align:center"><?php echo number_format($modulo4["thotr"],0,',','.'); ?></td>
		  </tr>
		  <tr>
			<td>6. Total</td>
			<td style="text-align:center"><?php echo number_format($modulo4["thtot"],0,',','.'); ?></td>
			<td></td>			  
		  </tr>
		  </tbody>
		</table>
	</fieldset>		
</fieldset>

