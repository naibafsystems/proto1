<table width="100%" class="table">
<thead class="thead">
<tr>
	<th><b>N.Orden</b></th>
  	<th><b>N.Establecimiento</b></th>  
  	<th><b>Raz&oacute;n Social Empresa</b></th>
  	<th><b>Nombre Establecimiento</b></th>
  	<th><b>Departamento</b></th>
  	<th><b>Municipio</b></th>
  	<th><b>Sede</b></th>
  	<th><b>Subsede</b></th>
  	<th><b>Novedades</b></th>
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
  	<td><?php echo $fuentes[$i]["nro_establecimiento"]; ?></td>
  	<td><a href="<?php echo base_url("administrador/mostrarFormulario/".$fuentes[$i]["nro_orden"]."/".$fuentes[$i]["nro_establecimiento"]); ?>"><?php echo $fuentes[$i]["idproraz"]; ?></a></td>
  	<td><a href="<?php echo base_url("administrador/mostrarFormulario/".$fuentes[$i]["nro_orden"]."/".$fuentes[$i]["nro_establecimiento"]); ?>"><?php echo $fuentes[$i]["idnomcom"]; ?></a></td>
  	<td><?php echo $fuentes[$i]["fk_depto"]; ?></td>
  	<td><?php echo $fuentes[$i]["fk_mpio"]; ?></td>
  	<td><?php echo $fuentes[$i]["sede"]; ?></td>
  	<td><?php echo $fuentes[$i]["subsede"]; ?></td> 
  	<td><a href="<?php echo site_url("/novedades/registro/".$fuentes[$i]["nro_orden"]."/".$fuentes[$i]["nro_establecimiento"]); ?>">Novedades</a></td> 
</tr>
<?php } ?>
</tbody>
<tfoot>
<tr>
	<td colspan="8">&nbsp;</td>
</tr>
<tr>
	<td colspan="4"><b>Total registros: <?php echo $total; ?></b></td>
	<td colspan="4" align="right"><?php echo $paginador; ?></td>
</tr>
</tfoot>
</table>