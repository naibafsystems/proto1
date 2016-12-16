<?php $ano_periodo = $this->session->userdata("ano_periodo");
	  $mes_periodo = $this->session->userdata("mes_periodo"); 
?>
<h1><?php echo $titulo; ?></h1>
<div id="divDirectorio">
<?php if (count($fuentes)>0){ ?>
	<table width="100%" class="table" style="font-size: 11px;">
	<thead class="thead">
	<tr>
  		<th><b>N.Orden</b></th>
  		<th><b>N.Establ</b></th>  
  		<th><b>Nombre Establecimiento</b></th>
  		<th><b>Departamento</b></th>
  		<th><b>Municipio</b></th>
  		<th><b>Sede</b></th>
  		<th><b>Subsede</b></th>
  		<th><b>Novedades</b></th>
  		<th><b>Estado</b></th>  		
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
  		<td><a href="<?php echo base_url("critico/detalleFormulario/".$fuentes[$i]["nro_orden"]."/".$fuentes[$i]["nro_establecimiento"]); ?>"><?php echo $fuentes[$i]["nro_orden"]; ?></a></td>
  		<td><a href="<?php echo base_url("critico/detalleFormulario/".$fuentes[$i]["nro_orden"]."/".$fuentes[$i]["nro_establecimiento"]); ?>"><?php echo $fuentes[$i]["nro_establecimiento"]; ?></a></td>
  		<td><?php echo $fuentes[$i]["idnomcom"]; ?></td>
  		<td><?php echo $fuentes[$i]["fk_depto"]; ?></td>
  		<td><?php echo $fuentes[$i]["fk_mpio"]; ?></td>
  		<td><?php echo $fuentes[$i]["sede"]; ?></td>
  		<td><?php echo $fuentes[$i]["subsede"]; ?></td>
  		<td><a href="<?php echo site_url("/novedades/registro/".$fuentes[$i]["nro_orden"]."/".$fuentes[$i]["nro_establecimiento"]); ?>">Novedades&nbsp;<?php echo $this->novedad->buscarNovedades($fuentes[$i]["nro_orden"], $fuentes[$i]["nro_establecimiento"], $ano_periodo, $mes_periodo); ?></a></td>
  		<td class="redText"><?php echo $this->control->obtenerEstadoControl($fuentes[$i]["novedad"], $fuentes[$i]["estado"]); ?></td>  
	</tr>
	<?php } ?>
	</tbody>	
	</table>
<?php }
else{
	echo '<p><b>No se han encontrado fuentes para este periodo.</b></p>';
}?>	
</div>