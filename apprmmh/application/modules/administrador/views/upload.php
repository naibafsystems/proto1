<?php $this->load->helper("url"); ?>
<div id="directorioUpload">

<?php if ($this->uri->segment(3)!=NULL){
		 switch($this->uri->segment(3)){
		 	case 0: echo "<p><b>El directorio ha sido cargado exitosamente.</b></p>";
		 	        break;
		 	case 1: echo "<p><b>No se ha podido cargar el directorio. Se han presentado errores.</b></p>";
		 	        break;
		 	case 2: echo "<p><b>No se ha podido cargar el directorio. No se ha encontrado el archivo en el servidor.</b></p>";
		 	        break;                
		 }	
      }else { 
?> 
		<form id="frmUpload" name="frmUpload" method="post" action="<?php echo site_url("administrador/cargarDirectorio"); ?>" enctype="multipart/form-data">
		<h1>Cargar Directorio</h1>
		<table width="100%">
		<tr>
		  <td><input type="file" id="txtFile" name="txtFile" value="" size="50"/></td>
		</tr>
		<tr>
		  <td><input type="submit" id="btnUpload" name="btnUpload" value="Cargar Directorio" class="button"/></td>
		</tr>
		<tr>
		  <td>&nbsp;</td>
		</tr>
		<tr>
		  <td><a href="<?php echo site_url("administrador/descargaManualCSV"); ?>">Descargar manual de carga del directorio (*.pdf)&nbsp;<img src="<?php echo base_url("images/acrobat.png")?>"></img></a></td>
		</tr>
		<tr>
		  <td><a href="<?php echo site_url("administrador/descargaArchivoCSV")?>">Descargar archivo de carga (*.csv)&nbsp;<img src="<?php echo base_url("images/excel.png"); ?>"></img></a></td>
		</tr>
		</table>
		</form>
<?php } ?>
</div>