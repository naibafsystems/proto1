<form id="frmRemoverFTE" name="frmRemoverFTE" method="post" action="">
<table>
<tr>
  <td>Fuente:</td>
  <td><select id="cmbFuenteLOG" name="cmbFuenteLOG" class="select">
  	  <option value="-">Seleccione...</option>
      <?php for ($i=0; $i<count($fuentes); $i++){ ?>
      	  <option value="<?php echo $fuentes[$i]["nro_orden"]."-".$fuentes[$i]["nro_establecimiento"]; ?>"><?php echo $fuentes[$i]["idproraz"]." - ".$fuentes[$i]["idnomcom"]; ?></option>
      <?php } ?>
      </select>
  </td>
</tr>
<tr>
  <td colspan="2">
  <div id="datosFuente">
  
  </div>
  </td>
</tr>
<tr>
  <td colspan="2">&nbsp;</td>
</tr>
<tr>
  <td colspan="2">
  	<input type="button" id="btnRemoverFTELOG" name="btnRemoverFTELOG" value="Eliminar Fuente" class="textbox"/>
  	<input type="button" id="btnCancelar" name="btnCancelar" value="Cancelar" class="textbox"/>
  </td>
</tr>
</table>
</form>