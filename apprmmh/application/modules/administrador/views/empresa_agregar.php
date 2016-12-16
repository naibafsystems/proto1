<script type="text/javascript">
	$("#txtNroOrden").numerico().largo(11);
	$("#txtNitEmpresa").numerico().largo(11);
	$("#txtNitDigValida").numerico().largo(1);
	$("#txtRazonSocial").mayusculas().largo(70);
	$("#txtNomComercial").mayusculas().largo(70);
	$("#txtSigla").mayusculas().largo(20);
	$("#txtDireccion").mayusculas().largo(80);
	$("#txtTelefono").numerico().largo(15);
	$("#txtFax").numerico().largo(15);
	$("#txtPagWeb").minusculas();
	$("#txtEmail").minusculas();
	$("#cmbDepartamento").cargarCombo("cmbCiudad","administrador/actualizarmunicipios");
</script>
<form id="frmEmpresaInsert" name="frmEmpresaInsert" method="post" action="">
<table>
<tr>
  <td>Nro. Orden:</td>
  <td><input type="text" id="txtNroOrden" name="txtNroOrden" value="" class="textBox" size="15"/></td>
</tr>
<tr>
  <td>Nit Empresa:</td>
  <td><input type="text" id="txtNitEmpresa" name="txtNitEmpresa" value="" class="textBox"/>&nbsp;&nbsp;DV:&nbsp;<input type="text" id="txtNitDigValida" name="txtNitDigValida" value="" size="3" class="textBox"/></td> 
</tr>
<tr>
  <td>Raz&oacute;n social: </td>
  <td><input type="text" id="txtRazonSocial" name="txtRazonSocial" value="" class="textBox" size="70"/></td>
</tr>
<tr>
  <td>Nombre Comercial: </td>
  <td><input type="text" id="txtNomComercial" name="txtNomComercial" value="" class="textBox" size="70"/></td>
</tr>
<tr>
  <td>Sigla: </td>
  <td><input type="text" id="txtSigla" name="txtSigla" value="" class="textBox"/></td>
</tr>
<tr>
  <td>Direcci&oacute;n:</td>
  <td><input type="text" id="txtDireccion" name="txtDireccion" value="" class="textBox" size="70"/></td>  
</tr>
<tr>
  <td>Tel&eacute;fono:</td>
  <td><input type="text" id="txtTelefono" name="txtTelefono" value="" class="textBox"/></td>
</tr>
<tr>
  <td>Fax:</td>
  <td><input type="text" id="txtFax" name="txtFax" value="" class="textBox"/></td>
</tr>
<tr>
  <td>P&aacute;gina Web:</td>  
  <td><input type="text" id="txtPagWeb" name="txtPagWeb" value="" class="textBox" size="70"/></td>
</tr>
<tr>
  <td>Email:</td>
  <td><input type="text" id="txtEmail" name="txtEmail" value="" class="textBox" size="70"/></td>
</tr>
<tr>
  <td>Departamento: </td>
  <td><select id="cmbDepartamento" name="cmbDepartamento">
      <option value="-" selected="selected">Seleccione...</option>
      <?php for ($i=0; $i<count($departamentos); $i++){ ?>
      	<option value="<?php echo $departamentos[$i]["codigo"]; ?>"><?php echo $departamentos[$i]["nombre"]; ?></option>
      <?php } ?>
      </select>
  </td>
</tr>
<tr>
  <td>Municipio:</td>
  <td><select id="cmbCiudad" name="cmbCiudad">
      <option value="-" selected="selected">Seleccione...</option>
      <?php for ($i=0; $i<count($municipios); $i++){ ?>
      	<option value="<?php echo $municipios[$i]["codigo"]; ?>"><?php echo $municipios[$i]["nombre"]; ?></option>
      <?php } ?>
      </select>
  </td>
</tr>
<tr>
  <td colspan="2">&nbsp;</td>
</tr>
<tr>
  <td colspan="2"><input type="submit" id="btnAgregarEmpresaInt" name="btnAgregarEmpresaInt" value="Agregar Empresa" class="button"/></td>
</tr>
</table>
</form>