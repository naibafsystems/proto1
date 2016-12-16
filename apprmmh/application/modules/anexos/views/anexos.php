<?php echo $error;?>
<?php echo form_open_multipart("soportes/upload"); ?>
<fieldset style="border: 1px solid #CCCCCC; padding-left: 10px;">
<legend><h3>&nbsp;Archivos Anexos&nbsp;</h3></legend>
<br/>
<table>
<tr>
  <td></td>
  <td><input type="file" id="userfile" name="userfile" size="75" /></td>
</tr>
<tr>
  <td colspan="2"><input type="submit" id="btnSoporte" name="btnSoporte" value="Cargar Archivo" class="button"/></td>
</tr>
</table>
<br/>
<table width="97%" class="table" align="center">
<thead class="thead">
<tr>
  <th>Id Soporte</th>
  <th>Periodo</th>
  <th>Establecimiento</th>
  <th>Nombre Archivo</th>
  <th>Tama&ntilde;o Archivo</th>
  <th>Tipo Archivo</th>
  <th>Opciones</th>
</tr>
</thead>
<tbody>
</tbody>
</table>
</fieldset>
<?php echo form_close(); ?>