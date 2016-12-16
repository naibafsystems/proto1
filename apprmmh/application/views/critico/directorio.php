<?php $this->load->helper("url"); ?>
<div id="divResultados">
<h1>Directorio de Fuentes</h1>
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
  		<td><?php echo $fuentes[$i]["fk_ciiu"]; ?></td>
  		<td><a href="<?php echo base_url("critico/mostrarFormulario/".$fuentes[$i]["nro_orden"]); ?>"><?php echo $fuentes[$i]["idproraz"]; ?></a></td>
  		<td><?php echo $fuentes[$i]["idnomcom"]; ?></td>
  		<td><?php echo $fuentes[$i]["fk_depto"]; ?></td>
  		<td><?php echo $fuentes[$i]["fk_mpio"]; ?></td>
  		<td><?php echo utf8_encode($fuentes[$i]["sede"]); ?></td>  
	</tr>
	<?php } ?>
	</tbody>
	<tfoot>
	<tr>
  		<td colspan="7">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2" align="left"><b>Total registros: <?php echo $total; ?></b></td>
		<td colspan="3" align="right">&nbsp;</td>
  		<td colspan="2" align="right"><?php echo $paginador; ?></td>
	</tr>
	</tfoot>
	</table>
<?php }
else{
	echo '<p><h3 class="rojo">No se han encontrado fuentes para este periodo.</h3></p>';
}?>	
</div>