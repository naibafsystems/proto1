<h1><?php echo $nomcritico; ?></h1>
<table width="100%" style="font-size: 11px;" class="table">
<thead class="thead">
  <tr>
    <th>Nro. Orden</th>
    <th>Nro. Establecimiento</th>
    <th>Nombre / Raz&oacute;n Social</th>
    <th>Nombre / Nombre del establecimiento</th>
  </tr> 
</thead>
<tbody>
  <?php for ($i=0; $i<count($asignadas); $i++){
  			$class = (($i%2)==0)?"row1":"row2";
  ?>
  <tr class="<?php echo $class; ?>">
    <td><?php echo $asignadas[$i]["nro_orden"]; ?></td>
    <td><?php echo $asignadas[$i]["nro_establecimiento"]; ?></td>
    <td><?php echo $asignadas[$i]["idproraz"]; ?></td>
    <td><?php echo $asignadas[$i]["idnomcom"]; ?></td>
  </tr>
  <?php } ?>
</tbody>
</table>