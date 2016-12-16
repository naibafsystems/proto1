<form id="frmAgregarFTE" name="frmAgregarFTE" method="post" action="">
<fieldset style="border: 1px solid #CCCCCC; padding: 10px;">
<legend><b>Datos Empresa</b></legend>
	<table>
	<tr>
	  <td>Nro. Orden:</td>
	  <td><input type="text" id="txtNumOrden" name="txtNumOrden" value="" maxlength="11" class="textbox"/></td>
	</tr>	
	</table>
</fieldset>
<br/>
<fieldset style="border: 1px solid #CCCCCC; padding: 10px;">
<legend><b>Datos Establecimiento</b></legend>
	<table>
	<tr>
	  <td>Nro. Establecimiento: </td>
	  <td><input type="text" id="txtNumEstab" name="txtNumEstab" value="" class="textbox"/></td>
	</tr>
	<tr>
	  <td>Nombre: </td>
	  <td><input type="text" id="txtNomEstab" name="txtNomEstab" value="" size="70" class="textbox"/></td>
	</tr>
	<tr>
	  <td>Direcci&oacute;n: </td>
	  <td><input type="text" id="txtDirEstab" name="txtDirEstab" value="" size="70" class="textbox"/></td>
	</tr>	
	<tr>
	  <td>Departamento: </td>
	  <td><select id="cmbDeptoEstab" name="cmbDeptoEstab" class="select">
	      <option value="-">Seleccione...</option>
	      <?php for ($i=0; $i<count($departamentos); $i++){ ?>
       	     <option value="<?php echo $departamentos[$i]["codigo"]; ?>"><?php echo $departamentos[$i]["nombre"]; ?></option>	
       	  <?php } ?>
	      </select>
	  </td>    
	</tr>
	<tr>
	  <td>Municipio: </td>
	  <td><select id="cmbMpioEstab" name="cmbMpioEstab" class="select">
	      <option value="-">Seleccione...</option>
	      <?php for ($i=0; $i<count($municipios); $i++){ ?>
             <option value="<?php echo $municipios[$i]["codigo"]; ?>"><?php echo $municipios[$i]["nombre"]; ?></option> 
          <?php } ?>
	      </select>
	  </td>    
	</tr>
	<tr>
	  <td>Actividad: </td>
	  <td><select id="cmbActivEstab" name="cmbActivEstab" class="select" style="width: 570px;">
	      <option value="-">Seleccione...</option>
	      <?php for ($i=0; $i<count($actividades); $i++){ ?>
      	     <option value="<?php echo $actividades[$i]["id"]; ?>"><?php echo $actividades[$i]["id"]; ?>&nbsp;-&nbsp;<?php echo $actividades[$i]["nombre"]; ?></option>
          <?php } ?>
	      </select>
	  </td>    
	</tr>
	<tr>
	  <td>Sede: </td>
	  <td><select id="cmbSedeEstab" name="cmbSedeEstab" class="select">
	      <option value="-">Seleccione...</option>
	      <?php for ($i=0; $i<count($sedes); $i++){ ?>
      	     <option value="<?php echo $sedes[$i]["id"]; ?>"><?php echo $sedes[$i]["nombre"]; ?></option>
          <?php } ?>
	      </select>
	  </td>    
	</tr>
	<tr>
	  <td>Sub - Sede: </td>
	  <td><select id="cmbSubSedeEstab" name="cmbSubSedeEstab" class="select">
	      <option value="-">Seleccione...</option>
	      <?php for ($i=0; $i<count($subsedes); $i++){ ?>
      	     <option value="<?php echo $subsedes[$i]["id"]; ?>"><?php echo $subsedes[$i]["nombre"]; ?></option>
      	  <?php } ?>
	      </select>
	  </td>    
	</tr>
	<tr>
	  <td>Inclusi&oacute;n: </td>
	  <td><select id="cmbInclusion" name="cmbInclusion" class="select">
	      <option value="-">Seleccione...</option>
	      <option value="1">Forzosa</option>
	      <option value="2">Probabil&iacute;stica</option>
	      </select>
	  </td>
	</tr>
	</table>
</fieldset>
<br/>
<input type="submit" id="btnAgregarFuenteInt" name="btnAgregarFuenteInt" value="Agregar Fuente" class="button"/>
</form>