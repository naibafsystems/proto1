<h1>Reporte Operativo por Cr&iacute;tico</h1>
<br/>
<table>
<tr>
  <td>Sede: </td>
  <td><select id="cmbSedeCR" name="cmbSedeCR" class="select">
      <option value="0" selected="selected">DANE Central</option>
  	    <?php for ($i=0; $i<count($sedes); $i++){ ?>
  	    	 <option value="<?php echo $sedes[$i]["id"]; ?>"><?php echo $sedes[$i]["nombre"]; ?></option>
  	    <?php } ?>
      </select>
  </td>
</tr>
<tr>
  <td>Subsede: </td>
  <td><select id="cmbSubSedeCR" name="cmbSubSedeCR" class="select">
      <option value="0" selected="selected">Todas las subsedes.</option> 
      </select>
  </td>
</tr>
<tr>
  <td colspan="2">&nbsp;</td>
</tr>
<tr>
  <td colspan="2"><input type="button" id="btnOperCR" name="btnOperCR" value="Consultar" class="button"/></td>
</tr>
</table>
<br/>
<div id="reporteOPCritico">
<table width="100%" class="table" style="font-size: 11px;">
<thead>
<tr>
  <th rowspan="2" style="border-right: 1px solid #CCCCCC;">Cr&iacute;tico</th>
  <th colspan="2" style="border-right: 1px solid #CCCCCC;">Directorio Base</th>
  <th colspan="2" style="border-right: 1px solid #CCCCCC;">Nuevos</th>
  <th colspan="2" style="border-right: 1px solid #CCCCCC;">Total a recolectar</th>
  <th colspan="2" style="border-right: 1px solid #CCCCCC;">Sin distribuir</th>
  <th colspan="2" style="border-right: 1px solid #CCCCCC;">Distribuidos</th>
  <th colspan="2" style="border-right: 1px solid #CCCCCC;">En Digitaci&oacute;n</th>
  <th colspan="2" style="border-right: 1px solid #CCCCCC;">Digitados</th>
  <th colspan="2" style="border-right: 1px solid #CCCCCC;">An&aacute;lisis - Verificaci&oacute;n</th>
  <th colspan="2" style="border-right: 1px solid #CCCCCC;">Verificados</th>
  <th colspan="2" style="border-right: 1px solid #CCCCCC;">Novedades</th>
</tr>
<tr style="border: 1px solid #CCCCCC;">  
  <th style="border-right: 1px solid #CCCCCC;">Total</th>
  <th style="border-right: 1px solid #CCCCCC;">%</th>
  <th style="border-right: 1px solid #CCCCCC;">Total</th>
  <th style="border-right: 1px solid #CCCCCC;">%</th>
  <th style="border-right: 1px solid #CCCCCC;">Total</th>
  <th style="border-right: 1px solid #CCCCCC;">%</th>
  <th style="border-right: 1px solid #CCCCCC;">Total</th>
  <th style="border-right: 1px solid #CCCCCC;">%</th>
  <th style="border-right: 1px solid #CCCCCC;">Total</th>
  <th style="border-right: 1px solid #CCCCCC;">%</th>
  <th style="border-right: 1px solid #CCCCCC;">Total</th>
  <th style="border-right: 1px solid #CCCCCC;">%</th>
  <th style="border-right: 1px solid #CCCCCC;">Total</th>
  <th style="border-right: 1px solid #CCCCCC;">%</th>
  <th style="border-right: 1px solid #CCCCCC;">Total</th>
  <th style="border-right: 1px solid #CCCCCC;">%</th>
  <th style="border-right: 1px solid #CCCCCC;">Total</th>
  <th style="border-right: 1px solid #CCCCCC;">%</th>
  <th style="border-right: 1px solid #CCCCCC;">Total</th>
  <th style="border-right: 1px solid #CCCCCC;">%</th>
</tr>
</thead>
<tbody>
<?php for ($i=0; $i<count($reporte); $i++){ 
	  	  $var = ($i%2!=0)?"row2":"row1";
?>		<tr class="<?php echo $var; ?>">
	  		<td><?php echo $reporte[$i]["nombre"]; ?></td>
	  		<td><?php echo $reporte[$i]["reporte"]["directorio_base"]; ?></td>
	  		<td><?php echo $reporte[$i]["reporte"]["pct_dbase"]; ?></td>
	  		<td><?php echo $reporte[$i]["reporte"]["nuevos"]; ?></td>
	  		<td><?php echo $reporte[$i]["reporte"]["pct_nuevos"]; ?></td>
	  		<td><?php echo $reporte[$i]["reporte"]["total_recolectar"]; ?></td>
	  		<td><?php echo $reporte[$i]["reporte"]["pct_totrecolectar"]; ?></td>
	  		<td><?php echo $reporte[$i]["reporte"]["sin_distribuir"]; ?></td>
	  		<td><?php echo $reporte[$i]["reporte"]["pct_sindistribuir"]; ?></td>
	  		<td><?php echo $reporte[$i]["reporte"]["distribuidos"]; ?></td>
		  	<td><?php echo $reporte[$i]["reporte"]["pct_distribuidos"]; ?></td>
	  		<td><?php echo $reporte[$i]["reporte"]["digitacion"]; ?></td>
	  		<td><?php echo $reporte[$i]["reporte"]["pct_digitacion"]; ?></td>
	  		<td><?php echo $reporte[$i]["reporte"]["digitados"]; ?></td>
	  		<td><?php echo $reporte[$i]["reporte"]["pct_digitados"]; ?></td>
	  		<td><?php echo $reporte[$i]["reporte"]["analisis_verificacion"]; ?></td>
	  		<td><?php echo $reporte[$i]["reporte"]["pct_analisisver"]; ?></td>
	  		<td><?php echo $reporte[$i]["reporte"]["verificados"]; ?></td>
	  		<td><?php echo $reporte[$i]["reporte"]["pct_verificados"]; ?></td>
	  		<td><?php echo $reporte[$i]["reporte"]["novedades"]; ?></td>
	  		<td><?php echo $reporte[$i]["reporte"]["pct_novedades"]; ?></td>
		</tr>
<?php } ?>	
</tbody>
</table>
<br/>
</div>