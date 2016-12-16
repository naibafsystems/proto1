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
	  			<input type="button" id="btnAgregar" name="btnAgregar" value="Agregar Fuente" class="button"/>
	  			<input type="button" id="btnEliminar" name="btnEliminar" value="Remover Fuente" class="button"/>
	  			<input type="button" id="btnDescarga" name="btnDescarga" value="Descarga Directorio" class="button"/>
	  <?php } ?>
	</div>
</div>

<form id="frmDir" name="frmDir" method="post" action="<?php echo site_url("administrador/descargadirectorio"); ?>"></form>


<div id="divDirectorio">
<?php if (count($fuentes)>0){ ?>
	<table width="100%" class="table">
	<thead class="thead">
	<tr>
  		<th><b>Nro. Orden</b></th>
  		<th><b>Unidad Local</b></th>  
  		<th><b>Actividad CIIU</b></th>
  		<th><b>Raz&oacute;n Social</b></th>
  		<th><b>Nombre Comercial</b></th>
  		<th><b>Departamento</b></th>
  		<th><b>Municipio</b></th>
  		<th><b>Sede</b></th>
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
  		<td><?php echo $fuentes[$i]["nro_orden"]; ?></td>
  		<td><?php echo $fuentes[$i]["uni_local"]; ?></td>
  		<td><?php echo $fuentes[$i]["ciiu"]; ?></td>
  		<td><a href="<?php echo base_url("administrador/mostrarFormulario/".$fuentes[$i]["nro_orden"]); ?>"><?php echo $fuentes[$i]["idproraz"]; ?></a></td>
  		<td><?php echo $fuentes[$i]["idnomcom"]; ?></td>
  		<td><?php echo $fuentes[$i]["fk_depto"]; ?></td>
  		<td><?php echo $fuentes[$i]["fk_mpio"]; ?></td>
  		<td><?php echo $fuentes[$i]["sede"]; ?></td>  
	</tr>
	<?php } ?>
	</tbody>
	<tfoot>
	<tr>
  		<td colspan="7">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2" align="left"><b>Total registros: <?php echo $total; ?></b></td>
		<td colspan="3" align="right">&nbsp;</td>
  		<td colspan="2" align="right"><?php echo $paginador; ?></td>
	</tr>
	</tfoot>
	</table>
<?php }
else{
	echo '<p><h3 class="rojo">No se han encontrado fuentes para este periodo.</h3></p>';
}?>	
</div>
<br/>

<?php  if (($ano == $reciente["ano"])&&($mes == $reciente["mes"])){   
			$this->load->view("admin/upload"); 
       }
?>

<div id="agregarFuente">
<?php 
	
	//Preparo array para terminar de enviarlo como parametro a la vista AJAX
	$data["tipodocs"] = $tipodocs;
	$data["sedes"] = $sedes;
	$data["subsedes"] = $subsedes;
	$data["actividades"] = $actividades;
	$data["departamentos"] = $departamentos;
	$data["municipios"] = $municipios;
	$this->load->view("admin/ajxfuentesadd",$data); 
?>
</div>
<br/>
<div id="removerFuente">
<?php 
	$data["fuentes"] = $fuentesall;
	$this->load->view("admin/ajxfuentesdel",$data); 
?>
</div>