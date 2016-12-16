<p><b>Capitulo V. Caracter&iacute;sticas de los hoteles</b></p>
<br/>
<form id="frmCapituloV" name="frmCapituloV" method="post" action="<?php echo site_url("fuente/capituloV"); ?>">
<table>
  <thead>
  <tr>
    <th colspan="4" align="center">Caracter&iacute;sticas de los hoteles</th>
  </tr>
  </thead>
  <tbody>
  <tr>
    <td rowspan="2">N&uacute;mero de habitaciones:</td>
    <td>Disponibles promedio d&iacute;a</td>
	<td>Ofrecidas total mes</td>
    <td>Ocupadas o vendidas</td>
  </tr>
  <tr>
    <td><input type="text" id="habdia" name="habdia" value=""/></td>
	<td><input type="text" id="ihdo" name="ihdo" value=""/></td>
	<td><input type="text" id="ihoa" name="ihoa" value=""/></td>
  </tr>
  <tr>
	<td rowspan="2">N&uacute;mero de camas:</td>
	<td>Disponibles promedio d&iacute;a</td>
	<td>Ofrecidas total mes</td>
	<td>Ocupadas o vendidas</td>
  </tr>
  <tr>
    <td><input type="text" id="camdia" name="camdia" value=""/></td>
	<td><input type="text" id="icda" name="icda" value=""/></td>
	<td><input type="text" id="icva" name="icva" value=""/></td>
  </tr>
  <tr>
    <td rowspan="2">Huespedes - Llegada de personas:</td>
	<td>Residentes en Colombia</td>
	<td>No Residentes</td>
	<td>Total</td>
  </tr>
  <tr>
	<td><input type="text" id="ihpn" name="ihpn" value=""/></td>
	<td><input type="text" id="ihpnr" name="ihpnr" value=""/></td>
	<td><input type="text" id="huetot" name="huetot" value=""/></td>
  </tr>
  </tbody>
</table>
<br/>
<table>
  <thead>
  <tr>
    <th colspan="3" align="center">Motivo de viaje</th>
  </tr>
  <tr>
    <th>Motivo de viaje</th>
	<th>Residentes %</th>
	<th>No Residentes %</th>
  </tr>
  </thead>
  <tbody>
  <tr>
    <td>1. Negocios y convenciones</td>
	<td><input type="text" id="mvnr" name="mvnr" value=""/></td>
	<td><input type="text" id="mvnnr" name="mvnnr" value=""/></td>
  </tr>  
  <tr>
    <td>2. Ocio y recreaci&oacute;n</td>
	<td><input type="text" id="mvor" name="mvor" value=""/></td>
	<td><input type="text" id="mvonr" name="mvonr" value=""/></td>
  </tr>
  <tr>
    <td>3. Salud y Belleza</td>
	<td><input type="text" id="mvsr" name="mvsr" value=""/></td>
	<td><input type="text" id="mvsnr" name="mvsnr" value=""/></td>
  </tr>
  <tr>
    <td>4. Otros</td>
	<td><input type="text" id="mvotr" name="mvotr" value=""/></td>
	<td><input type="text" id="mvotnr" name="mvotnr" value=""/></td>
  </tr>
  <tr>
    <td>5. Total</td>
	<td><input type="text" id="mvott" name="mvott" value=""/></td>
	<td><input type="text" id="mvottnr" name="mvottnr" value=""/></td>
  </tr>
  </tbody>
</table>
<br/>
<table>
  <thead>
  <tr>
    <th colspan="4">Ingresos por habitaci&oacute;n vendida (Diligencie de acuerdo con las siguientes especificaciones)</th>			  			  
  </tr>
  <tr>
    <th>Tipo de habitaci&oacute;n</th>
    <th>N&uacute;mero de habitaciones vendidas</th>
    <th>Ingresos totales (Millones de pesos)</th>			  
    <th>Ingresos totales por alojamiento (Millones de pesos)</th>
  </tr>
  </thead>
  <tbody>
  <tr>
    <td>1. Sencilla</td>
	<td><input type="text" id="thsen" name="thsen" value=""/></td>
	<td><input type="text" id="ingsen" name="ingsen" value=""/></td>			  
	<td><input type="text" id="inalosen" name="inalosen" value=""/></td>			  
  </tr>
  <tr>
	<td>2. Doble</td>
	<td><input type="text" id="thdob" name="thdob" value=""/></td>
	<td><input type="text" id="ingdob" name="ingdob" value=""/></td>			  
	<td><input type="text" id="inalodob" name="inalodob" value=""/></td>			  
  </tr>
  <tr>
	<td>3. Suite</td>
	<td><input type="text" id="thsui" name="thsui" value=""/></td>
	<td><input type="text" id="ingsui" name="ingsui" value=""/></td>			  
	<td><input type="text" id="inalosui" name="inalosui" value=""/></td>			  
  </tr>
  <tr>
	<td>4. Multiple</td>
	<td><input type="text" id="thmult" name="thmult" value=""/></td>
	<td><input type="text" id="ingmul" name="ingmul" value=""/></td>			  
	<td><input type="text" id="inalomul" name="inalomul" value=""/></td>			  
  </tr>
  <tr>
	<td>5. Otro tipo de habitaci&oacute;n</td>
	<td><input type="text" id="thotr" name="thotr" value=""/></td>
	<td><input type="text" id="ingotr" name="ingotr" value=""/></td>			  
	<td><input type="text" id="inalootr" name="inalootr" value=""/></td>			  
  </tr>
  <tr>
	<td>6. Total</td>
	<td><input type="text" id="thtot" name="thtot" value=""/></td>
	<td><input type="text" id="ingtot" name="ingtot" value=""/></td>			  
	<td><input type="text" id="inalotot" name="inalotot" value=""/></td>			  
  </tr>
  </tbody>
</table>
<div id="observCap5"></div>
<br/>
<table>
<tr>
  <td colspan="2"><input type="submit" id="btnCapituloV" name="btnCapituloV" value="Guardar y continuar"/></td>
</tr>
</table>
</form>