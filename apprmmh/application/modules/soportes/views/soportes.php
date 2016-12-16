<br/>
<fieldset style="border: 1px solid #CCCCCC; padding-left: 10px;">
<legend><h3>&nbsp;Archivos anexos&nbsp;</h3></legend>
<br/>
<span style="color: #FF0000;"><?php echo $error;?></span>
<?php echo form_open_multipart('soportes/subirAnexo');?>
<input type="file" id="userfile" name="userfile" size="75"/>
<br /><br />
<input type="submit" id="btnAnexos" name="btnAnexos" value="Subir archivo anexo" class="button" />
<input type="hidden" id="hddNumord" name="hddNumord" value="<?php echo $nro_orden; ?>"/>
<input type="hidden" id="hddNumest" name="hddNumest" value="<?php echo $nro_establecimiento; ?>"/>
<?php echo form_close(); ?>
<br/>
<table width="99%" class="table" align="center">
<thead class="thead">
<tr>
  <th>Id Soporte</th>
  <th>Nombre Archivo</th>
  <th>Tama&ntilde;o Archivo</th>
  <th>Tipo Archivo</th>
  <th>Opciones</th>
</tr>
</thead>
<tbody>
<?php for ($i=0; $i<count($soportes); $i++){
	     $class = (($i%2)==0)?"row1":"row2";
	     $id = $soportes[$i]["id_soporte"];	
		 if ($soportes[$i]["tam_soporte"] > 1000){
		 	$unidad = "MB";
		 }
		 else{
		 	$unidad = "kB";
		 }
	     
?>  	 <tr class="<?php echo $class; ?>">
		   <td><?php echo $soportes[$i]["id_soporte"]; ?></td>
		   <td><?php echo $soportes[$i]["nom_soporte"]; ?></td>
		   <td><?php echo number_format($soportes[$i]["tam_soporte"],2,',','.'); ?>&nbsp;<?php echo $unidad; ?></td>
		   <td><?php echo $soportes[$i]["tip_soporte"]; ?></td>
		   <td>
		   	  <a target="_blank" href="<?php echo site_url("/soportes/mostrarSoporte/$id"); ?>" title="Ver anexo"><img src="<?php echo base_url("images/images.png"); ?>"/></a>
		   	  <a href="<?php echo site_url("/soportes/eliminarSoporte/$id"); ?>" title="Eliminar anexo"><img src="<?php echo base_url("images/delete.png"); ?>"/></a>
		   </td>
		 </tr>
<?php } ?>
</tbody>
</table>
<br/>
</fieldset>
