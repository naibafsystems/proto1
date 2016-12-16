<div id="divCritica">
<input type="hidden" id="txtCapitulo" name="txtCapitulo" value=""/>
<input type="hidden" id="txtNroOrden" name="txtNroOrden" value="<?php echo $nro_orden; ?>"/>
<table>
<tr>
  <td><b>Fecha:</b></td>
  <td><?php echo date("d/m/Y"); ?></td>
</tr>
<tr>
  <td><b>Hora:</b></td>
  <td><?php echo date("h:i:s"); ?></td>
</tr>
<tr>
  <td colspan="2"><b>Observaciones:</b><br/><textarea id="txaObservacionesCR" name="txaObservacionesCR" rows="5" style="width: 100%" class="textbox"></textarea></td>
</tr>
<tr>
  <td>&nbsp;</td>
</tr>
<tr>
  <td align="right"><input type="submit" id="btnObservacionesCR" name="btnObservacionesCR" value="Guardar Observaciones" class="button"/></td>
</tr>
</table>
</div>
<br/>
<p><b>Observaciones de la fuente</b></p>
<?php if (count($obsfuente)>0){ ?>
		<table width="100%" class="table">
		<thead class="thead">
		<tr>
			<td><b>Fecha</b></td>
			<td align="center"><b>Cap&iacute;tulo</b></td>
			<td align="center"><b>Campo</b></td>
			<td><b>Descripci&oacute;n</b></td>
		</tr>
		</thead>
		<tbody>
		<?php for ($i=0; $i<count($obsfuente); $i++){ ?>
			<tr>
				<td><?php echo $obsfuente[$i]["fecha"]; ?></td>
				<td align="center"><?php echo $obsfuente[$i]["capitulo"]; ?></td>
				<td align="center"><?php echo $obsfuente[$i]["campo"]; ?></td>
				<td><?php echo $obsfuente[$i]["descripcion"]; ?></td>
			</tr>	
		<?php } ?>
		</tbody>
		</table>
<?php }
	  else{
	  	echo "<p>No se han realizado observaciones por la fuente.</p>";
	  } 
?>		
<br/>
<p><b>Observaciones de la cr&iacute;tica</b></p>
<?php if (count($obscritica)>0){ ?>
		<table width="100%" class="table">
		<thead class="thead">
		<tr>
			<td><b>Fecha</b></td>
			<td align="center"><b>Cap&iacute;tulo</b></td>
			<td align="center"><b>Campo</b></td>
			<td><b>Descripci&oacute;n</b></td>
		</tr>
		</thead>
		<tbody>
		<?php for ($i=0; $i<count($obscritica); $i++){ ?>
			<tr>
				<td><?php echo $obscritica[$i]["fecha"]; ?></td>
				<td align="center"><?php echo $obscritica[$i]["capitulo"]; ?></td>
				<td align="center"><?php echo $obscritica[$i]["campo"]; ?></td>
				<td><?php echo $obscritica[$i]["descripcion"]; ?></td>
			</tr>	
		<?php } ?>
		</tbody>
		</table>
<?php }
	  else{
	  	echo "<p>No se han realizado observaciones por la cr&iacute;tica.</p>";
	  } 
?>		
