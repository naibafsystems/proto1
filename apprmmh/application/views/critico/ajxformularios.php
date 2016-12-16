<?php $this->load->helper("url"); ?>
<div id="divDirectorio">
<?php if (count($fuentes)>0){ ?>
	<table width="100%" class="table">
	<thead class="thead">
	<tr>
  		<th><b>Nro. Orden</b></th>
  		<th><b>Unidad Local</b></th>  
  		<th><b>Actividad CIIU</b></th>
  		<th><b>Raz&oacute;n Social</b></th>
  		<th><b>Nombre Comercial</b></th>
  		<th><b>Departamento</b></th>
  		<th><b>Municipio</b></th>
  		<th><b>Sede</b></th>
	</tr>
	</thead>
	<tbody>
	<?php  for ($i=0; $i<count($fuentes); $i++){ 
			  if (($i%2)==0){
			  	$class = "row1";
		  	  }
		  	  else{
		  		$class = "row2";
		  	  }
	?>
	<tr class="<?php echo $class; ?>">
  		<td><?php echo $fuentes[$i]["nro_orden"]; ?></td>
  		<td><?php echo $fuentes[$i]["uni_local"]; ?></td>
  		<td><?php echo $fuentes[$i]["ciiu"]; ?></td>
  		<td><a href="<?php echo base_url("critico/mostrarFormulario/".$fuentes[$i]["nro_orden"]); ?>"><?php echo $fuentes[$i]["idproraz"]; ?></a></td>
  		<td><?php echo $fuentes[$i]["idnomcom"]; ?></td>
  		<td><?php echo $fuentes[$i]["fk_depto"]; ?></td>
  		<td><?php echo $fuentes[$i]["fk_mpio"]; ?></td>
  		<td><?php echo $fuentes[$i]["sede"]; ?></td>  
	</tr>
	<?php } ?>
	</tbody>
	<tfoot>
	<tr>
  		<td colspan="8">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4" align="left"><b>Total registros: <?php echo $total; ?></b></td>
  		<td colspan="4" align="right"><?php echo $paginador; ?></td>
	</tr>
	</tfoot>
	</table>
<?php }
else{
	echo '<p><b>No se han encontrado fuentes para este periodo.</b></p>';
}?>	
</div>