<h1>Opciones de Usuario</h1>
<h3>Modificar contrase&ntilde;a</h3>
<br/>
<p>Ingrese la nueva clave y la confirmaci&oacute;n. La clave debe ser m&iacute;nimo de 6 caracteres y m&aacute;ximo de 16.</p>
<br/>
<form id="frmOpciones" name="frmOpciones" method="post" action="<?php echo site_url("fuente/cambiarClave"); ?>">
<table width="50%" align="center">
<tr>
  <td><b>Clave actual:</b></td>
  <td><input type="password" id="txtClaveActual" name="txtClaveActual" value="" maxlength="17"/></td>
</tr>
<tr>
  <td><b>Nueva clave:</b></td>
  <td><input type="password" id="txtNuevaClave" name="txtNuevaClave" value="" maxlength="17"/></td>
</tr>
<tr>
  <td><b>Confirme su clave:</b></td>
  <td><input type="password" id="txtConfirm" name="txtConfirm" value="" maxlength="17"/></td>
</tr>
<tr>
  <td colspan="2">&nbsp;</td>
</tr>
<tr>
  <td colspan="2"><input type="submit" id="btnOpcionesUser" name="btnOpcionesUser" value="Cambiar clave" class="button"/></td>
</tr>
</table>
<br/>
<div id="errusuario"><h3 style="color: #E00078;"><?php echo $error; ?></h3></div>
<br/>
<a href="<?php echo site_url("fuente/index"); ?>">Regresar al formulario</a>
</form>