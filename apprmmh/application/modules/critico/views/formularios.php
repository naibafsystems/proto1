<h1>Formularios</h1>
<table width="100%">
<tr>
  <td>
    <form id="frmBusqueda" name="frmBusqueda" method="post" action="<?php echo site_url("critico/buscarFuentes"); ?>">
    <fieldset class="fieldset">
  	<legend>&nbsp;<b>B&uacute;squeda de formularios.</b>&nbsp;&nbsp;</legend>
  	<table>
  	<tr>
  	  <td><b>B&uacute;squeda por:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  	  <td><input type="radio" id="radBusqueda0" name="radBusqueda" value="0"/>Nit Empresa</td>
  	  <td>&nbsp;&nbsp;&nbsp;<input type="radio" id="radBusqueda1" name="radBusqueda" value="1" checked="checked"/>Nro. Orden</td>
  	  <td>&nbsp;&nbsp;&nbsp;<input type="radio" id="radBusqueda2" name="radBusqueda" value="2"/>Nro. Establecimiento</td>
  	  <td>&nbsp;&nbsp;&nbsp;<input type="radio" id="radBusqueda3" name="radBusqueda" value="3"/>Nombre Empresa</td>
  	  <td>&nbsp;&nbsp;&nbsp;<input type="radio" id="radBusqueda4" name="radBusqueda" value="4"/>Nombre Establecimiento</td>
  	</tr>
  	</table>
  	<br/>
  	<table>
  	<tr>  
  	  <td><input type="text" id="txtBuscar" name="txtBuscar" value="" class="textbox" size="90"/></td>
  	  <td><input type="button" id="btnBuscarCR" name="btnBuscarCR" value="Buscar" class="button"/></td>  	  
  	</tr>
  	<tr>
  	</tr>
  	</table>   	
    </fieldset>
    </form>
  </td>
</tr>
<tr>
  <td>&nbsp;</td>
</tr>
<tr>
  <td>
    <div id="divResultados"></div>
  </td>
</tr>
</table>