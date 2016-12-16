
<table width="100%">
	<tr>
		<td style ="vertical-align:text-top;">
			<fieldset class="fieldset">
		  	<legend><h1>Descarga de Planos</h1></legend>
			<p>Seleccione el m&oacute;dulo a descargar: </p>
			<br/>
			<ul>
			  <li style="padding-left: 10px;"><a href="<?php echo site_url("descargaplanos/descargaPlanosXLS/1"); ?>">M&oacute;dulo I - Identificaci&oacute;n y datos generales (Descarga Directorio)</a></li>
			  <li style="padding-left: 10px;"><a href="<?php echo site_url("descargaplanos/descargaPlanosXLS/2"); ?>">M&oacute;dulo II - Personal ocupado promedio y salarios causados en el mes</a></li>
			  <li style="padding-left: 10px;"><a href="<?php echo site_url("descargaplanos/descargaPlanosXLS/3"); ?>">M&oacute;dulo III - Ingresos netos operacionales causados en el mes (miles de pesos)</a></li>
			  <li style="padding-left: 10px;"><a href="<?php echo site_url("descargaplanos/descargaPlanosXLS/4"); ?>">M&oacute;dulo IV - Caracter&iacute;sticas de los hoteles</a></li>
			  <li style="padding-left: 10px;"><a href="<?php echo site_url("descargaplanos/descargaPlanosMOD5"); ?>">M&oacute;dulo V - Clasificaci&oacute;n CIIU4</a></li>
			  <li style="padding-left: 10px;"><a href="<?php echo site_url("descargaplanos/descargaPlanosXLS/0"); ?>">Env&iacute;o del formulario</a></li>
			  <li style="padding-left: 10px;"><a href="<?php echo site_url("descargaplanos/descargaPlanosXLS/5"); ?>">Descarga de Novedades</a></li>
			  <li style="padding-left: 10px;"><a href="<?php echo site_url("descargaplanos/descargaPlanosXLS/6"); ?>">Descarga de Observaciones</a></li>    
			</ul>
			</fieldset>
		</td>
		<td style ="vertical-align:text-top;">
			<fieldset class="fieldset">
		  	<legend><h1>Consolidado por empresa</h1></legend>
			<p>Seleccione el m&oacute;dulo a descargar: </p>
			<br/>
			<ul>
				<li style="padding-left: 10px;"><a href="<?php echo site_url("descargaplanos/descargaPlanosXLS/7"); ?>">M&oacute;dulo II - Personal ocupado promedio y salarios causados en el mes</a></li>
			  	<li style="padding-left: 10px;"><a href="<?php echo site_url("descargaplanos/descargaPlanosXLS/8"); ?>">M&oacute;dulo III - Ingresos netos operacionales causados en el mes (miles de pesos)</a></li>
			  	<li style="padding-left: 10px;"><a href="<?php echo site_url("descargaplanos/descargaPlanosXLS/9"); ?>">M&oacute;dulo IV - Caracter&iacute;sticas de los hoteles</a></li>
				<li style="padding-left: 10px;"><a href="<?php echo site_url("descargaplanos/descargaPlanosXLS/11"); ?>">Condolidado por empresas</a></li> 
				<br><br><br><br>
			</ul>
			</fieldset>
		</td>
	</tr>
	<tr>
		<td style="text-align: center;" colspan="2">
			<br>
			<?php $this->load->library("general"); ?>
		    <form id="frmDescargaPlanos" name="frmDescargaPlanos" method="post" action="<?php echo site_url("descargaplanos/descargaPlanosXLS/10"); ?>">
		    <fieldset class="fieldset">
		  	<legend><h1>Consolidado hist&oacute;rico</h1></legend>
		  	<table width="100%"	border="1">
		  		<tr>
		  			<td>Seleccione el a&ntilde;o a descargar: 
		  			  <select id="anio" name="anio" class="select">
				      <?php 
				      for ($i=0; $i<count($anios); $i++){ 
					   	  ?><option value="<?php echo $anios[$i]["anio"]; ?>" selected="selected"><?php echo $anios[$i]["anio"]; ?></option>
					      <?php 
				   	   }
				      ?>
			          </select>
			      </td>
		  		</tr>
			  	<tr>
			  	  <td> <br>Seleccione el (los) mes (es) a descargar: 
			  	  <input type="checkbox" id="per1" name="per1" value="1"/ checked="checked">Ene
			  	  <input type="checkbox" id="per2" name="per2" value="2"/>Feb
			  	  <input type="checkbox" id="per3" name="per3" value="3"/>Mar
			  	  <input type="checkbox" id="per4" name="per4" value="4"/>Abr
			  	  <input type="checkbox" id="per5" name="per5" value="5"/>May
			  	  <input type="checkbox" id="per6" name="per6" value="6"/>Jun
			  	  <input type="checkbox" id="per7" name="per7" value="7"/>Jul
			  	  <input type="checkbox" id="per8" name="per8" value="8"/>Ago
			  	  <input type="checkbox" id="per9" name="per9" value="9"/>Sep
			  	  <input type="checkbox" id="per10" name="per10" value="10"/>Oct
			  	  <input type="checkbox" id="per11" name="per11" value="11"/>Nov
			  	  <input type="checkbox" id="per12" name="per12" value="12"/>Dic
			  	</tr>
			  	<tr>  
                  <td>
                  	  <br>	
			  	      <input type="submit" id="btnDescargaPlanos" name="btnDescargaPlanos" value="Descargar" class="button"/>
			  	  </td>  	  
			  	</tr>
		  	</table>
		  	   	
		    </fieldset>
		    </form>
		</td>
	</tr>
</table>


