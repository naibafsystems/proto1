<?php var_dump($errores); ?>
<h1>Cargar Directorio de empresas y establecimientos</h1>
<form id="frmCargaDirectorio" name="frmCargaDirectorio" method="post" action="<?php echo site_url("administrador/uploadFiles"); ?>" enctype="multipart/form-data">
	<table width="100%">
	<tr>
	  <td><b>Cargar:</b></td>
	  <td><input type="radio" id="radEmpresas" name="radCarga" value="1" checked="checked"> 1. Directorio de Empresas.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      <input type="radio" id="radEstablecimientos" name="radCarga" value="2"> 2. Directorio de Establecimientos. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      <input type="radio" id="radFuentes" name="radCarga" value="3"> 3. Directorio de Fuentes. 
	  </td>
	</tr>
	</table>
	<br/>
	  	<div id="dvCarga"><h3>Cargar Directorio de Empresas</h3></div>
	  	<br/>
	  	<table width="100%">
		<tr>
	  		<td width="25%">Seleccione el archivo a cargar:</td>
	  		<td><input type="file" id="txtFile" name="txtFile" value="" size="80"/></td>
		</tr>
		<tr>
	  		<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
	  		<td>&nbsp;</td>
	  		<td><input type="submit" id="btnUpload" name="btnUpload" value="Cargar Directorio" class="button"/></td>
		</tr>
		</table>
</form>