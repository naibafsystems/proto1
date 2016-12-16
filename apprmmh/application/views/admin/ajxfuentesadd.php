<form id="frmAgregarFTE" name="frmAgregarFTE" method="post" action="">
<table>
<tr>
  <td valign="top">Nro. Orden:</td>
  <td><input type="text" id="txtNumOrden" name="txtNumOrden" value="" class="textbox"/></td>
</tr>
<tr>
  <td valign="top">Tip. Documento:&nbsp;</td>
  <td><select id="cmbTipoDoc" name="cmbTipoDoc" class="select">
	  <option value="-" selected="selected">Seleccione...</option>
	  <?php for ($i=0; $i<count($tipodocs); $i++){ ?>
	  	<option value="<?php echo $tipodocs[$i]["id"]; ?>"><?php echo $tipodocs[$i]["nombre"]; ?></option>
	  <?php } ?>	  	  	
      </select>
  </td>
</tr>
<tr>
  <td valign="top">Num. Documento:&nbsp;</td>
  <td><input type="text" id="txtNumDoc" name="txtNumDoc" value="" class="textbox"/></td>	
</tr>
<tr>
  <td valign="top">Sede:&nbsp;</td>
  <td><select id="cmbSedes" name="cmbSedes" class="select">
      <option value="-" selected="selected">Seleccione...</option>
	  <?php for ($i=0; $i<count($sedes); $i++){ ?>
      	<option value="<?php echo $sedes[$i]["id"]; ?>"><?php echo $sedes[$i]["nombre"]; ?></option>
      <?php } ?>
      </select>
  </td>	
</tr>
<tr>
  <td valign="top">SubSede:&nbsp;</td>
  <td><select id="cmbSubsedes" name="cmbSubsedes" class="select">
      <option value="-" selected="selected">Seleccione...</option>
	  <?php for ($i=0; $i<count($subsedes); $i++){ ?>
      	<option value="<?php echo $subsedes[$i]["id"]; ?>"><?php echo $subsedes[$i]["nombre"]; ?></option>
      <?php } ?>
      </select>
  </td>	
</tr>
<tr>
  <td valign="top">Act. Econ&oacute;mica:&nbsp;</td>
  <td><select id="cmbActividad" name="cmbActividad" class="select">
      <option value="-" selected="selected">Seleccione...</option>
      <?php for ($i=0; $i<count($actividades); $i++){ ?>
      	<option value="<?php echo $actividades[$i]["id"]; ?>"><?php echo $actividades[$i]["id"]; ?>&nbsp;-&nbsp;<?php echo $actividades[$i]["nombre"]; ?></option>
      <?php } ?>      
      </select>
  </td>	
</tr>
<tr>
  <td>Nom. Comercial:</td>
  <td colspan="2"><input type="text" id="idnomcom" name="idnomcom" value="" size="60" maxlength="60" class="textbox" /></td>
</tr>
<tr>
  <td>Departamento:</td>
  <td colspan="2">
     <select id="iddepto" name="iddepto" class="select">
       <option value="-">Seleccione...</option>	   
       <?php for ($i=0; $i<count($departamentos); $i++){ ?>
       	 <option value="<?php echo $departamentos[$i]["codigo"]; ?>"><?php echo $departamentos[$i]["nombre"]; ?></option>	
       <?php } ?>
     </select>    
  </td>
</tr>
<tr>
  <td>Municipio:</td>
  <td colspan="2">
    <select id="idmpio" name="idmpio" class="select">
      <option value="-">Seleccione...</option>
      <?php for ($i=0; $i<count($municipios); $i++){ ?>
        <option value="<?php echo $municipios[$i]["codigo"]; ?>"><?php echo $municipios[$i]["nombre"]; ?></option> 
      <?php } ?>
    </select>
  </td>
</tr>
<tr>
<td colspan="3">&nbsp;</td>
</tr>
<tr>
<td colspan="3"><input type="submit" id="btnAgregarFuente" name="btnAgregarFuente" value="Agregar Fuente" class="button"/></td>
</tr>
</table>



</form>