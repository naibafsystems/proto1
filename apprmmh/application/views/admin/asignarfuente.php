<style>
	div.scroll {
		height: 400px;
		width: 542px;
		overflow: auto;
		padding: 8px;
		border: 1px solid #CCCCCC;
	}
</style>
<br/>
<h1><?php echo $nomcritico; ?></h1>
<table>
<tr>
  <td valign="top">
  <!-- div sin asignar -->
  <form id="frmSinAsignar" name="frmSinAsignar" method="post" action="<?php echo site_url("administrador/asignarFuentesCritico"); ?>">
  <div id="asignados" class="scroll">
  <?php if (count($sinasignar) > 0) { ?>  
    <table class="table">
    <thead class="thead">
    <tr>
      <th width="10%">Nro. Orden</th>
      <th width="10%">Act. CIIU</th>
      <th width="10%">Sigla</th>
      <th width="35%">Raz&oacute;n Social</th>
      <th width="5%">&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    <?php for ($i=0; $i<count($sinasignar); $i++){
    		$class = (($i%2)==0) ?'row1':'row2'; 
    ?>
    <tr class="<?php echo $class; ?>">
      <td><?php echo $sinasignar[$i]["nro_orden"]; ?></td>
      <td align="center"><?php echo $sinasignar[$i]["fk_ciiu"]; ?></td>
      <td><?php echo $sinasignar[$i]["idsigla"]; ?></td>
      <td><?php echo $sinasignar[$i]["idproraz"]; ?></td>
      <td>
         <input type="checkbox" id="chkSinasignar" name="chkSinasignar[]" value="<?php echo $sinasignar[$i]["nro_orden"]; ?>"/>
      </td>	
    </tr>	
    <?php } ?>
    </tbody>
    </table>
  </div>
  <br/>
  <p align="left"><input type="submit" id="btnAsignar" name="btnAsignar" value="Asignar Fuentes" class="button"/></p>
  <input type="hidden" id="hddCritico" name="hddCritico" value="<?php echo $idcritico; ?>"/>  
  <?php } 
  else {
     echo '<p><h3 class="rojo">Ya se han asignado todas las fuentes.</h3></p>';
  }?>  
  </form>
  </td>
  <td valign="top">
  <!-- div asignados -->
	  <form id="frmAsignados" name="frmAsignados" method="post" action="<?php echo site_url("administrador/removerFuentesCritico"); ?>">
	  <div id="sinasignar" class="scroll">
	  <?php if (count($asignados) > 0) { ?>
	    <table class="table">
	    <thead class="thead">
	    <tr>
	      <th width="10%">Nro. Orden</th>
	      <th width="10%">Act. CIIU</th>
	      <th width="10%">Sigla</th>
	      <th width="35%">Raz&oacute;n Social</th>
	      <th width="5%">&nbsp;</th>
	    </tr>
	    </thead>
	    <tbody>
	    <?php for ($j=0; $j<count($asignados); $j++){ 
	            $class = (($j%2)==0) ?'row1':'row2'; 
	    ?>
	    <tr class="<?php echo $class; ?>">
	      <td><?php echo $asignados[$j]["nro_orden"]; ?></td>
	      <td align="center"><?php echo $asignados[$j]["fk_ciiu"]; ?></td>
	      <td><?php echo $asignados[$j]["idsigla"]; ?></td>
	      <td><?php echo $asignados[$j]["idproraz"]; ?></td>
	      <td><input type="checkbox" id="chkAsignados" name="chkAsignados[]" value="<?php echo $asignados[$j]["nro_orden"]; ?>"/></td>
	    </tr>
	    <?php }?>
	    </tbody>
	    </table>
	  </div>
	  <br/>
	  <p align="left"><input type="submit" id="btnRemover" name="btnRemover" value="Remover Fuentes" class="button"/></p>
	  <input type="hidden" id="hddCritico" name="hddCritico" value="<?php echo $idcritico; ?>"/>
	  <?php }
	  else{ 
	  	echo '<p><h3 class="rojo">No se han asignado fuentes.</h3></p>';
	  }?>
	  <!--  -->  
	  </form>   
  </td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
</table>