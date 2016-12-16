<?php $this->load->helper("url"); ?>
<h1>Bienvenido a la Encuesta Mensual de Hoteles</h1>
<p>El objetivo de esta investigaci&oacute;n es obtener informaci&oacute;n coyuntural del sector, relacionada con ingresos, empleo y gastos de personal, adem&aacute;s de algunos indicadores espec&iacute;ficos que describen su estado y evoluci&oacute;n en el corto plazo, para guiar la implementaci&oacute;n de medidas o pol&iacute;ticas que beneficien el desarrollo sectorial. Gracias a su valiosa colaboraci&oacute;n, los resultados de esta investigaci&oacute;n son una herramienta importante en la toma de decisiones econ&oacute;micas del pa&iacute;s.</p>
<br/>
<p><b>Importante:&nbsp;</b>Los datos que el DANE solicita en este formulario son estrictamente confidenciales y en ning&uacute;n caso tienen fines fiscales ni pueden utilizarse como prueba judicial (Art. 5&deg; Ley 79/93).</p>
<br/><br/>
<div id="login">
	<form id="frmIngresar" name="frmIngresar" method="post" action="<?php echo site_url("login/validar"); ?>" accept-charset="utf-8">				
	<table>
	<tr>
		<td><label>Login:</label></td>
		<td><input type="text" id="txtLogin" name="txtLogin" value="" size="15" maxlength="15" class="txtLogin"/></td>
	</tr>
	<tr>
		<td><label>Password:</label></td>
		<td><input type="password" id="txtPassword" name="txtPassword" value="" size="15" maxlength="15" class="txtLogin"/></td>
	</tr>
	<tr>
	    <td colspan="2">&nbsp;</td>
	</tr>
	<tr>
	    <td colspan="2" align="center"><input type="submit" id="btnIngresar" name="btnIngresar" value="Ingresar" class="button"/></td>
	</tr>
	</table>
	</form>
</div>
<br/><br/>