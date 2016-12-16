<div id="content">
	<h1>M&oacute;dulo de Novedades</h1>
	<table width="100%">
	<tr>
	  <td><b>Nro. Orden:</b></td>
	  <td><?php echo $datos["nro_orden"]; ?></td>
	</tr>
	<tr>
	  <td><b>Nro. Establecimiento:</b></td>
	  <td><?php echo $datos["nro_establecimiento"]; ?></td>
	</tr>
	<tr>
	  <td><b>Raz&oacute;n Social Empresa:</b></td>
	  <td><?php echo $datos["idproraz"]; ?></td>
	</tr>
	<tr>
	  <td><b>Nombre Comercial Establecimiento: </b></td>
	  <td><?php echo $datos["idnomcom"]; ?></td>
	</tr>
	<tr>
	  <td><b>Actividad CIIU:</b></td>
	  <td><?php echo "(".$datos["fk_ciiu"].") - ".$datos["nom_ciiu"]; ?></td>
	</tr>
	<tr>
	  <td><b>Critico:</b></td>
	  <td><?php echo $datos["nom_critico"]; ?></td>
	</tr>
	</table>
	<br/>
	<fieldset style="border: 1px solid #CCCCCC; padding-left: 10px;">
	<legend><h3>&nbsp;Reporte de Novedades&nbsp;</h3></legend>
	<br/>
	<form id="frmNovedadesCR" name="frmNovedadesCR" method="post" action="<?php echo site_url("novedades/guardarNovedad"); ?>">
		
		<table width="100%" align="center">
		<tr>
		  <td width="25%">Fecha visita: </td>
		  <td><input type="text" id="txtFechaVisita" name="txtFechaVisita" value="<?php echo $novedad["fecha_visita"]; ?>" class="textbox" <?php if ($bloqueo){ echo 'disabled="disabled"'; } ?> <?php if ($rol==6){ echo 'disabled="disabled"'; }?>/></td>
		</tr>
		<tr>
		  <td>Estado empresa: </td>
		  <td><select id="cmbEstadoEST" name="cmbEstadoEST" class="select" <?php if ($bloqueo){ echo 'disabled="disabled"'; } ?> <?php if ($rol==6){ echo 'disabled="disabled"'; }?>>
		      <option value="-">Seleccione...</option>	  		
		  		<?php for ($i=0; $i<count($estados_novedad); $i++){ 
		  		 			if ($estados_novedad[$i]["id"]==$novedad["estado_empresa"]){
		  		 				if ($rol==6){
		  		 					echo '<option value="'.$estados_novedad[$i]["id"].'" selected="selected" disabled>'.$estados_novedad[$i]["nombre"].'</option>';
		  		 				}
		  		 				else{
		  		 					echo '<option value="'.$estados_novedad[$i]["id"].'" selected="selected">'.$estados_novedad[$i]["nombre"].'</option>';
		  		 				}
		  		 			}
		  		 			else{ 
		  		 				if ($rol==6){
		  		 					echo '<option value="'.$estados_novedad[$i]["id"].'" disabled>'.$estados_novedad[$i]["nombre"].'</option>';
		  		 				}
		  		 				else{
		  		 					echo '<option value="'.$estados_novedad[$i]["id"].'">'.$estados_novedad[$i]["nombre"].'</option>';
		  		 				}
		  		 			}
		  		 	  } 
		  		?>
		      </select>
		  </td>
		</tr>
		<tr>
		  <td>Consultas C&aacute;mara de Comercio / P&aacute;ginas web: </td>
		  <td><input type="radio" id="radActiva" name="radConsultas" value="1" <?php if ($novedad["consulta_camara"]==1) echo 'checked="checked"'; ?> <?php if ($bloqueo){ echo 'disabled="disabled"'; } ?> <?php if ($rol==6){ echo 'disabled="disabled"'; }?> />1. Activa&nbsp;&nbsp;
		      <input type="radio" id="radCancelada" name="radConsultas" value="2" <?php if ($novedad["consulta_camara"]==2) echo 'checked="checked"'; ?> <?php if ($bloqueo){ echo 'disabled="disabled"'; } ?> <?php if ($rol==6){ echo 'disabled="disabled"'; }?> />2. Cancelada&nbsp;&nbsp;
		      <input type="radio" id="radNoregistra" name="radConsultas" value="3" <?php if ($novedad["consulta_camara"]==3) echo 'checked="checked"'; ?> <?php if ($bloqueo){ echo 'disabled="disabled"'; } ?> <?php if ($rol==6){ echo 'disabled="disabled"'; }?> />3. No Registra
		      <div id="errcam"></div>
		  </td>
		</tr>
		<tr>
		  <td>Novedad asignada:</td>
		  <td><select id="cmbNovedad" name="cmbNovedad" class="select" <?php if ($bloqueo){ echo 'disabled="disabled"'; } ?><?php if ($rol==6){ echo 'disabled="disabled"'; }?>>
		        <option value="-">Seleccione...</option>
		        <?php for ($i=0; $i<count($novedades); $i++){
		        	  		if ($novedades[$i]["id"]==$novedad["fk_novedad"]){ 
		        	  			echo '<option value="'.$novedades[$i]["id"].'" selected="selected">'.$novedades[$i]["nombre"].'</option>';
		        	  		}	   
		        			else{
		        				echo '<option value="'.$novedades[$i]["id"].'">'.$novedades[$i]["nombre"].'</option>';
		        			}
		              }
		        ?>
		      </select>
		  </td>
		</tr>
		<tr>
		  <td>Nombre Funcionario: </td>
		  <td><input type="text" id="txtNombreFuncionario" name="txtNombreFuncionario" value="<?php echo $novedad["nom_func"]; ?>" class="textbox" size="60" <?php if ($bloqueo){ echo 'disabled="disabled"'; } ?> <?php if ($rol==6){ echo 'disabled="disabled"'; }?> /></td>
		</tr>
		<tr>
		  <td>Tel&eacute;fono funcionario: </td>
		  <td><input type="text" id="txtTelFuncionario" name="txtTelFuncionario" value="<?php echo $novedad["tel_func"]; ?>" class="textbox" <?php if ($bloqueo){ echo 'disabled="disabled"'; } ?> <?php if ($rol==6){ echo 'disabled="disabled"'; }?> /></td>
		</tr>
		<tr>
		  <td>Cargo Funcionario: </td>
		  <td><input type="text" id="txtCargoFuncionario" name="txtCargoFuncionario" value="<?php echo $novedad["cargo_func"]; ?>" class="textbox" size="60" <?php if ($bloqueo){ echo 'disabled="disabled"'; } ?> <?php if ($rol==6){ echo 'disabled="disabled"'; }?> /></td>
		</tr>
		<tr>
		  <td valign="top">Observaciones Cr&iacute;tico:</td>
		  <td><textarea id="txaObsCritico" name="txaObsCritico" cols="62" rows="5" style="border: 1px solid #CCCCCC;" <?php if ($bloqueo){ echo 'disabled="disabled"'; } ?> <?php if ($rol==6){ echo 'disabled="disabled"'; }?>><?php echo $novedad["obs_critico"]; ?></textarea></td>
		</tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>
		     
		     <input type="hidden" id="hddCritico" name="hddCritico" value="<?php echo $datos["id_critico"]; ?>"/>
		     <input type="hidden" id="hddNroOrden" name="hddNroOrden" value="<?php echo $datos["nro_orden"]; ?>"/>
	         <input type="hidden" id="hddNroEstablecimiento" name="hddNroEstablecimiento" value="<?php echo $datos["nro_establecimiento"]; ?>"/>
		     <input type="hidden" id="hddNovedad" name="hddNovedad" value="<?php echo $novedad["fk_novedad"]; ?>"/>
		     <input type="hidden" id="hddOp" name="hddOp" value="<?php echo $novedad["op"]; ?>"/>
		  </td>
		</tr>
		
		<?php if (($rol==2)&&($rol!=6)){ ?>
		<tr>
		  <td>&nbsp;</td>
		  <td><input type="submit" id="btnGuardarNovedadCR" name="btnGuardarNovedadCR" value="Guardar Novedad" class="button" <?php if ($bloqueo){ echo 'disabled="disabled"'; } ?>/></td>
		</tr>
		<?php } ?>
		
		</table>
		
	</form>	
	<br/>
	</fieldset>
	<?php if ($rol!=2){ ?>
		<br/>
		<fieldset style="border: 1px solid #CCCCCC; padding-left: 10px;">
		<legend><h3>&nbsp;Coordinador&nbsp;</h3></legend>
		<br/>
		<form id="frmCoordinador" name="frmCoordinador" method="post" action="<?php echo site_url("novedades/aprobarNovedad"); ?>">
		<table width="100%">
		<tr>
	  		<td width="25%">Novedad Aceptada:</td>
	  		<td><input type="radio" id="radSI" name="radAceptada" value="1" <?php if ($novedad["aceptada"]==1) echo 'checked="checked"'; ?> <?php if ($rol==6){ echo 'disabled="disabled"'; }?> />1. Si&nbsp;&nbsp;
	      		<input type="radio" id="radNO" name="radAceptada" value="0" <?php if ($novedad["aceptada"]==0) echo 'checked="checked"'; ?> <?php if ($rol==6){ echo 'disabled="disabled"'; }?> />2. No&nbsp;&nbsp;
	      		<div id="errAcept"></div>
	  		</td>	  
		</tr>
		<tr>
	  		<td valign="top">Observaciones:</td>
	  		<td><textarea id="txaObsCoordinador" name="txaObsCoordinador" cols="62" rows="5" style="border: 1px solid #CCCCCC;" <?php if ($rol==6){ echo 'disabled="disabled"'; }?>><?php echo $novedad["obs_coordinador"]; ?></textarea></td>
		</tr>
		<tr>
		    <td>&nbsp;</td>
		    <td><input type="hidden" id="hddCoordinador" name="hddCoordinador" value="<?php echo $coordinador; ?>"/></td>
		</tr>
		<tr>
		    <td></td>
		    <td>
		      <?php if ($rol!=6){ ?>
		      	<input type="submit" id="btnGuardarNovedadCO" name="btnGuardarNovedadCo" value="Aceptar / Rechazar Novedad" class="button"/>
		      <?php } ?>
		      <input type="hidden" id="hddNroOrden" name="hddNroOrden" value="<?php echo $datos["nro_orden"]; ?>"/>
	          <input type="hidden" id="hddNroEstablecimiento" name="hddNroEstablecimiento" value="<?php echo $datos["nro_establecimiento"]; ?>"/>
	          <input type="hidden" id="hddNovedad" name="hddNovedad" value="<?php echo $novedad["fk_novedad"]; ?>"/>
	          <input type="hidden" id="hddValidarCR" name="hddValidarCR" value="">
		    </td>
		</tr>
		</table>
		</form>
		<br/>
		</fieldset>
		
		<!-- Cargar modulo para la carga de anexos -->
		<?php  echo Modules::run("soportes/soportes/index",$datos["nro_orden"],$datos["nro_establecimiento"]); ?>
		
		
	<?php } ?>	
	<br/>	
</div>