<h1>Formularios</h1>
<table width="100%">
<tr>
  <td>
    <form id="frmBusqueda" name="frmBusqueda" method="post" action="<?php echo site_url("administrador/buscarFuentes"); ?>">
    <fieldset class="fieldset">
  	<legend>&nbsp;<b>B&uacute;squeda de formularios.</b>&nbsp;&nbsp;</legend>
  	<p>B&uacute;squeda por n&uacute;mero de &oacute;rden y/o Nombre comercial.</p>
  	<table>
  	<tr>  
  	  <td><input type="text" id="txtBuscar" name="txtBuscar" value="" class="textbox" size="60"/></td>
  	  <td><input type="button" id="btnBuscar" name="btnBuscar" value="Buscar" class="button"/></td>  	  
  	</tr>
  	<tr>
  	</tr>
  	</table>   	
    </fieldset>
    </form>
  </td>
</tr>
<tr>
  <td>
    <div id="divResultados"></div>
  </td>
</tr>
</table>