<style>
	.links strong{
		color: #F00;
	}
	
	
	.links a:link {
		padding: 2px 2px 2px 2px;
		text-align: center;
		text-decoration: none;
		font-size: 12px;
		color: #000;
		background: #FFFFFF;
	}
	
	.links a:visited {
		/*border: 1px solid #F00;*/
		padding: 2px 2px 2px 2px;
		text-align: center;
		text-decoration:none;
		font-size: 12px; 
		color:#000;
	} 
	
	.links a:hover {
		border: 1px solid #000;
		padding: 2px 2px 2px 2px;
		text-decoration:underline;
		font-weight: bolder; 
		color:#F00; 
		background: #EEEEEE;
	}
</style>
<br/>
<form id="frmDir" name="frmDir" method="post" action="<?php echo site_url("administrador/descargadirectorio"); ?>"></form>
<div class="row">
	<div class="fivecol"><h1>Directorio de Fuentes</h1></div>
	<div style="text-align: right;" class="sixcol">
	  <?php if (($ano_periodo == $reciente["ano"])&&($mes_periodo == $reciente["mes"])){ ?>
	  			<input type="button" id="btnAgregarEmpresa" name="btnAgregarEmpresa" value="Agregar Empresa" class="button"/>
	  			<input type="button" id="btnAgregar" name="btnAgregar" value="Agregar Establecimiento" class="button"/>
	  			<input type="button" id="btnEliminar" name="btnEliminar" value="Remover Fuente" class="button"/>
	  			<input type="button" id="btnDescarga" name="btnDescarga" value="Descarga Claves" class="button"/>
	  <?php } ?>
	</div>
</div>
<br/>
<div id="divDirectorio">
<table width="100%" class="table" style="font-size: 11px;">
<thead class="thead">
<tr>
  <th>N.Orden</th>
  <th>N.Establ</th>
  <th>Nombre Establecimiento</th>
  <th>Departamento</th>
  <th>Municipio</th>
  <th>Sede</th>
  <th>Subsede</th>
  <th align="center">Novedades</th>
  <th>Estado</th>
  <th>Opciones</th>
</tr>
</thead>
<tbody>
<?php for ($i=0; $i<count($fuentes); $i++){ 
		 $class = (($i%2)==0)?"row1":"row2";
?>
<tr class="<?php echo $class; ?>">
  <td><a href="<?php echo base_url("administrador/mostrarFormulario/".$fuentes[$i]["nro_orden"]."/".$fuentes[$i]["nro_establecimiento"]); ?>"><?php echo $fuentes[$i]["nro_orden"]; ?></a></td>
  <td><a href="<?php echo base_url("administrador/mostrarFormulario/".$fuentes[$i]["nro_orden"]."/".$fuentes[$i]["nro_establecimiento"]); ?>"><?php echo $fuentes[$i]["nro_establecimiento"]; ?></a></td>
  <td><?php echo $fuentes[$i]["idnomcom"]; ?></td>
  <td><?php echo $fuentes[$i]["fk_depto"]; ?></td>
  <td><?php echo $fuentes[$i]["fk_mpio"]; ?></td>
  <td><?php echo $fuentes[$i]["sede"]; ?></td>
  <td><?php echo $fuentes[$i]["subsede"]; ?></td>
  <td><a href="<?php echo site_url("/novedades/registro/".$fuentes[$i]["nro_orden"]."/".$fuentes[$i]["nro_establecimiento"]); ?>">Novedades&nbsp;<?php echo $this->novedad->buscarNovedades($fuentes[$i]["nro_orden"], $fuentes[$i]["nro_establecimiento"], $ano_periodo, $mes_periodo); ?></a></td>
  <td class="redText"><?php echo $this->control->obtenerEstadoControl($fuentes[$i]["novedad"], $fuentes[$i]["estado"]); ?></td>
  <td align="right">
     <a href="<?php echo site_url("administrador/editarFuente/".$fuentes[$i]["nro_orden"]."/".$fuentes[$i]["nro_establecimiento"].""); ?>"><img src="<?php echo base_url("images/edit.png"); ?>"/></a>
     <a href="javascript:removerFuenteDirectorio(<?php echo $fuentes[$i]["nro_orden"]; ?>,<?php echo $fuentes[$i]["nro_establecimiento"]; ?>);"><img src="<?php echo base_url("images/delete.png"); ?>"/></a>
     <?php /*
     <a href="<?php echo site_url("administrador/eliminarFuente/".$fuentes[$i]["nro_orden"]."/".$fuentes[$i]["nro_establecimiento"].""); ?>"><img src="<?php echo base_url("images/delete.png"); ?>"/></a>
     */
     ?>
  </td>
</tr>
<?php } ?>
<tr>
</tr>
</tbody>
<tfoot>
	<tr>
  		<td colspan="9">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" align="left">&nbsp;</td>
		<td colspan="6" align="right" class="links"><?php echo $links; ?></td>
	</tr>
</tfoot>
</table>
</div>


<!-- Div para ageragr empresas -->
<div id="agregarEmpresa">
<?php 
	$data["departamentos"] = $departamentos;
	$data["municipios"] = $municipios;
	$this->load->view("empresa_agregar",$data); 
?>
</div>



<!-- Div para agregar establecimientos -->
<div id="agregarFuente">
<?php 
	//Preparo array para terminar de enviarlo como parametro a la vista AJAX
	$data["tipodocs"] = $tipodocs;
	$data["sedes"] = $sedes;
	$data["subsedes"] = $subsedes;
	$data["actividades"] = $actividades;
	$data["departamentos"] = $departamentos;
	$data["municipios"] = $municipios;
	$this->load->view("ajxfuentesadd",$data); 
?>
</div>
<!-- Div para remover fuentes -->
<div id="removerFuente">
<?php 
	$data["fuentes"] = $fuentes;
	$this->load->view("ajxfuentesdel",$data); 
?>
</div>
