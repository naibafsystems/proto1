<h3>Observaciones de la fuente</h3>
<br/>
<?php if (count($observaciones)>0){ ?>
		<table width="100%" class="table">
		<thead class="thead">
		<tr>
			<th width="15%">Fecha</th>
			<th width="10%" align="center">Cap&iacute;tulo</th>
			<th width="10%" align="center">Campo</th>
			<th>Descripci&oacute;n</th>
		</tr>
		</thead>
		<tbody>
		<?php for ($i=0; $i<count($observaciones); $i++){ 
				 $class = (($i%2)==0)?'row1':'row2';
		?>
			<tr class="<?php echo $class; ?>">
			<td><?php echo $observaciones[$i]["fecha"]; ?></td>
			<td align="center"><?php echo $observaciones[$i]["modulo"]; ?></td>
			<td align="center"><?php echo $observaciones[$i]["campo"]; ?></td>
			<td><?php echo $observaciones[$i]["observacion"]; ?></td>
		</tr>
		<?php } ?>
		</tbody>
		</table>
<?php }
	  else{ 
		echo "<p>No se han realizado observaciones</p>";
      }
?>
<br/><br/>
<h3>Observaciones del (la) cr&iacute;tico (a) - (<?php echo $critico; ?>)</h3>
<br/>
<?php if (count($observacionesCR)>0){ ?>
		<table width="100%" class="table">
		<thead class="thead">
		<tr>
			<th width="15%">Fecha</th>
			<th width="15%" align="center">Cap&iacute;tulo</th>
			<!-- <th width="10%" align="center">Campo</th> -->
			<th>Descripci&oacute;n</th>
		</tr>
		</thead>
		<tbody>
		<?php for ($i=0; $i<count($observacionesCR); $i++){ 
				 $class = (($i%2)==0)?'row1':'row2';
		?>
			<tr class="<?php echo $class; ?>">
			<td><?php echo $observacionesCR[$i]["fecha"]; ?></td>
			<td align="center"><?php echo $observacionesCR[$i]["modulo"]; ?></td>
			<!--  <td align="center"><?php //echo $observacionesCR[$i]["campo"]; ?></td> -->
			<td><?php echo $observacionesCR[$i]["observacion"]; ?></td>
		</tr>
		<?php } ?>
		</tbody>
		</table>
<?php }
	  else{ 
		echo "<p>No se han realizado observaciones</p>";
      }
?>	

<!-- Observaciones del Asistente Técnico -->
<br/><br/>
<h3>Observaciones del Asistente T&eacute;cnico</h3>
<br/>
<?php if (count($observacionesAT)>0){ ?>
		<table width="100%" class="table">
		<thead class="thead">
		<tr>
			<th width="15%">Fecha</th>
			<th width="15%" align="center">Cap&iacute;tulo</th>
			<!-- <th width="10%" align="center">Campo</th> -->
			<th>Descripci&oacute;n</th>
		</tr>
		</thead>
		<tbody>
		<?php for ($i=0; $i<count($observacionesAT); $i++){ 
				 $class = (($i%2)==0)?'row1':'row2';
		?>
			<tr class="<?php echo $class; ?>">
			<td><?php echo $observacionesAT[$i]["fecha"]; ?></td>
			<td align="center"><?php echo $observacionesAT[$i]["modulo"]; ?></td>
			<!--  <td align="center"><?php //echo $observacionesCR[$i]["campo"]; ?></td> -->
			<td><?php echo $observacionesAT[$i]["observacion"]; ?></td>
		</tr>
		<?php } ?>
		</tbody>
		</table>
<?php }
	  else{ 
		echo "<p>No se han realizado observaciones</p>";
      }
?>	

 
<!-- Observaciones de logística -->
<br/><br/>
<h3>Observaciones de Log&iacute;stica - (<?php echo $logistico; ?>)</h3>
<br/>
<?php if (count($observacionesLG)>0){ ?>
		<table width="100%" class="table">
		<thead class="thead">
		<tr>
			<th width="15%">Fecha</th>
			<th width="15%" align="center">Cap&iacute;tulo</th>
			<!-- <th width="10%" align="center">Campo</th> -->
			<th>Descripci&oacute;n</th>
		</tr>
		</thead>
		<tbody>
		<?php for ($i=0; $i<count($observacionesLG); $i++){ 
				 $class = (($i%2)==0)?'row1':'row2';
		?>
			<tr class="<?php echo $class; ?>">
			<td><?php echo $observacionesLG[$i]["fecha"]; ?></td>
			<td align="center"><?php echo $observacionesLG[$i]["modulo"]; ?></td>
			<!--  <td align="center"><?php //echo $observacionesCR[$i]["campo"]; ?></td> -->
			<td><?php echo $observacionesLG[$i]["observacion"]; ?></td>
		</tr>
		<?php } ?>
		</tbody>
		</table>
<?php }
	  else{ 
		echo "<p>No se han realizado observaciones</p>";
      }
?>

<!-- Observaciones del Administrador -->
<br/><br/>
<h3>Observaciones del Administrador</h3>
<br/>
<?php if (count($observacionesAD)>0){ ?>
		<table width="100%" class="table">
		<thead class="thead">
		<tr>
			<th width="15%">Fecha</th>
			<th width="15%" align="center">Cap&iacute;tulo</th>
			<!-- <th width="10%" align="center">Campo</th> -->
			<th>Descripci&oacute;n</th>
		</tr>
		</thead>
		<tbody>
		<?php for ($i=0; $i<count($observacionesAD); $i++){ 
				 $class = (($i%2)==0)?'row1':'row2';
		?>
			<tr class="<?php echo $class; ?>">
			<td><?php echo $observacionesAD[$i]["fecha"]; ?></td>
			<td align="center"><?php echo $observacionesAD[$i]["modulo"]; ?></td>
			<!--  <td align="center"><?php //echo $observacionesCR[$i]["campo"]; ?></td> -->
			<td><?php echo $observacionesAD[$i]["observacion"]; ?></td>
		</tr>
		<?php } ?>
		</tbody>
		</table>
<?php }
	  else{ 
		echo "<p>No se han realizado observaciones</p>";
      }
?>  