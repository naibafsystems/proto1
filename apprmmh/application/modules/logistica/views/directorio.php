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
<script type="text/javascript">
$(function(){
  $("#agregarFuenteLOG").hide();
  $("#removerFuenteLOG").hide();
  $("#observacionesLOG").hide();
});
</script>
<div id="divResultados">
<?php 
	$this->load->library("session");
	$this->load->helper("url");
	$ano = $this->session->userdata("ano_periodo");
	$mes = $this->session->userdata("mes_periodo");
?>
<div class="row">
	<div class="fivecol"><h1>Directorio de Fuentes</h1></div>
	<div style="text-align: right;" class="sixcol">
	  <?php if (($ano == $reciente["ano"])&&($mes == $reciente["mes"])){ ?>
	  
	  			<!--<input type="button" id="btnAgregarLOG" name="btnAgregarLOG" value="Agregar Fuente" class="button"/>-->
	  			<!--<input type="button" id="btnEliminarLOG" name="btnEliminarLOG" value="Remover Fuente" class="button"/>-->
	  			<input type="button" id="btnDescargaLOG" name="btnDescargaLOG" value="Descarga Directorio" class="button"/>
	  <?php } ?>
	</div>
</div>

<form id="frmDir" name="frmDir" method="post" action="<?php echo site_url("logistica/descargadirectorio"); ?>"></form>


<div id="divDirectorio">
<?php if (count($fuentes)>0){ ?>
	<table width="100%" class="table" style="font-size: 11px;">
	<thead class="thead">
	<tr>
  		<th><b>N.Orden</b></th>
  		<th><b>N.Establ</b></th>  
  		<th><b>Nombre Establecimiento</b></th>
  		<th><b>Departamento</b></th>
  		<th><b>Municipio</b></th>
  		<th><b>Sede</b></th>
  		<th><b>Subsede</b></th>
  		<th><b>Novedades</b></th>
  		<th><b>Estado</b></th>
	</tr>
	</thead>
	<tbody>
	<?php  for ($i=0; $i<count($fuentes); $i++){ 
			  if (($i%2)==0){
			  	$class = "row1";
		  	  }
		  	  else{
		  		$class = "row2";
		  	  }
	?>
	<tr class="<?php echo $class; ?>">
  		<td><a href="<?php echo base_url("logistica/mostrarFormulario/".$fuentes[$i]["nro_orden"]."/".$fuentes[$i]["nro_establecimiento"]); ?>"><?php echo $fuentes[$i]["nro_orden"]; ?></a></td>
  		<td><a href="<?php echo base_url("logistica/mostrarFormulario/".$fuentes[$i]["nro_orden"]."/".$fuentes[$i]["nro_establecimiento"]); ?>"><?php echo $fuentes[$i]["nro_establecimiento"]; ?></a></td>
  		<td><?php echo $fuentes[$i]["idnomcom"]; ?></td>
  		<td><?php echo $fuentes[$i]["fk_depto"]; ?></td>
  		<td><?php echo $fuentes[$i]["fk_mpio"]; ?></td>
  		<td><?php echo $fuentes[$i]["sede"]; ?></td>
  		<td><?php echo $fuentes[$i]["subsede"]; ?></td>
  		<td><a href="<?php echo site_url("/novedades/registro/".$fuentes[$i]["nro_orden"]."/".$fuentes[$i]["nro_establecimiento"]); ?>">Novedades</a></td>
  		<td class="redText"><?php echo $this->control->obtenerEstadoControl($fuentes[$i]["novedad"], $fuentes[$i]["estado"]); ?></td>  
	</tr>
	<?php } ?>
	</tbody>
	<tfoot>
	<tr>
  		<td colspan="9">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" align="left"><b>Total registros: <?php echo $total; ?></b></td>
		<td colspan="3" align="right">&nbsp;</td>
  		<td colspan="3" align="right" class="links"><?php echo $links; ?></td>
	</tr>
	</tfoot>
	</table>
<?php }
else{
	echo '<p><h3 class="rojo">No se han encontrado fuentes para este periodo.</h3></p>';
}?>	
</div>
<br/>
</div>
<div id="agregarFuenteLOG">
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
<br/>
<div id="removerFuenteLOG">
<?php 
	$data["fuentes"] = $fuentes;
	$this->load->view("ajxfuentesdel",$data); 
?>
</div>
