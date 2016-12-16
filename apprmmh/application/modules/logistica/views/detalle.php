<div id="content">
	<h3><?php echo "($nro_orden - $nro_establecimiento) $nombre"; ?></h3>
	<?php echo "($nro_orden - $nro_establecimiento)  ".$modulo1["idnomcomest"]. " - Actividad: ".$modulo1["fk_ciiu"]. " - ".$modulo1["nom_ciiu"]; ?>
	<br/>
	<div id="tabs">
		<ul>
			<li><a href="#tabs-1">M&oacute;dulo I<img id="imgtab1" src="<?php echo $this->general->obtenerImagen($modulo1["imagen"]); ?>" border="0" style="padding-left: 10px;"/></a></li>
			<li><a href="#tabs-2">M&oacute;dulo II<img id="imgtab2" src="<?php echo $this->general->obtenerImagen($modulo2["imagen"]); ?>" border="0" style="padding-left: 10px;"/></a></li>
			<li><a href="#tabs-3">M&oacute;dulo III<img id="imgtab3" src="<?php echo $this->general->obtenerImagen($modulo3["imagen"]); ?>" border="0" style="padding-left: 10px;"/></a></li>
			<li><a href="#tabs-4">M&oacute;dulo IV<img id="imgtab4" src="<?php echo $this->general->obtenerImagen($modulo4["imagen"]); ?>" border="0" style="padding-left: 10px;"/></a></li>
			<li><a href="#tabs-9">M&oacute;dulo V<img id="imgtab5" src="<?php echo $this->general->obtenerImagen($modulo5["imagen"]); ?>" border="0" style="padding-left: 10px;"/></a></li>			
			<?php if ($tab_envio){ ?>
				<li><a href="#tabs-5">Enviar formulario<img id="imgtab6" src="<?php echo $this->general->obtenerImagen($envio["imagen"]); ?>" border="0" style="padding-left: 10px;"/></a></li>
			<?php } ?>
			<?php if ($pazysalvo){ ?>
				<li><a href="#tabs-6">Paz y Salvo<img id="imgtab7" src="<?php echo $this->general->obtenerImagen($envio["imagen"]); ?>" border="0" style="padding-left: 10px;"/></a></li>
			<?php } ?>
			<li><a href="#tabs-7">Observaciones<img id="imgtab6" src="<?php echo $this->general->obtenerImagen($envio["imagen"]); ?>" border="0" style="padding-left: 10px;"/></a></li>
			<?php if (($novedad_estado["novedad"]==99)&&($novedad_estado["estado"]>=4)){ ?>
			<li><a href="#tabs-8">Ficha an&aacute;lisis<img id="imgtab6" src="<?php echo $this->general->obtenerImagen($envio["imagen"]); ?>" border="0" style="padding-left: 10px;"/></a></li>
			<?php } ?>	
		</ul>
	
		<div id="tabs-1">
		    <?php $this->load->view("modulo1"); ?>		    			
		</div>
		<div id="tabs-2">
			<?php $this->load->view("modulo2"); ?>
		</div>
		<div id="tabs-3">
			<?php $this->load->view("modulo3"); ?>			
		</div>
		<div id="tabs-4">
			<?php $this->load->view("modulo4"); ?>			
		</div>
		<div id="tabs-9">
			<?php $this->load->view("modulo5"); ?>
		</div>
		<?php if ($tab_envio){ ?>
			<div id="tabs-5">
				<?php $this->load->view("envioform"); ?>
			</div>				
		<?php } ?>
		<?php if ($pazysalvo){ ?>
		<div id="tabs-6">
			<?php $this->load->view("pazysalvo"); ?>
		</div>
		<?php } ?>
		<div id="tabs-7">
			<?php $this->load->view("observaciones"); ?>
		</div>
		<?php if (($novedad_estado["novedad"]==99)&&($novedad_estado["estado"]>=4)){ ?>
		<div id="tabs-8">
			<?php echo Modules::run('fichanalisis/fichanalisis/index'); ?>
		</div>
		<?php } ?>
			
	</div>
</div>
<div id="observacionesLOG">
<form id="frmObservacionesCR" name="frmObservacionesCR" method="post" action="">
<table width="100%">
<tr>
  <td width="15%">Cr&iacute;tico:</td>
  <td><?php echo $this->session->userdata("nombre"); ?></td>
</tr>
<tr>
  <td width="15%">Fecha:</td>
  <td><?php echo date("Y/m/d"); ?></td>
</tr>
<tr>
  <td width="15%">Hora:</td>
  <td><?php echo date("h:i:s"); ?></td>
</tr>
<tr>
  <td width="15%" valign="top">Observaciones:&nbsp;&nbsp;&nbsp;</td>
  <td><textarea id="txaObservacionesLOG" name="txaObservacionesLOG" rows="5" style="width: 95%" class="textbox"></textarea></td>
</tr>
<tr>
  <td colspan="2">&nbsp;</td>
</tr>
<tr>
  <td width="15%">&nbsp;</td>
  <td><input type="button" id="btnGuardarCriticaLOG" name="btnGuardarCriticaLOG" value="Guardar Observaciones Log&iacute;stica" class="button"/></td>
</tr>
</table>
<input type="hidden" id="hddCapitulo" name="hddCapitulo" value=""/>
<!-- Guardo los datos del nro de orden y el establecimiento para obtenerlos despues en los datos del detalle del formulario  -->
<input type="hidden" id="hddNroOrden" name="hddNroOrden" value="<?php echo $nro_orden; ?>"/>
<input type="hidden" id="hddNroEstablecimiento" name="hddNroEstablecimiento" value="<?php echo $nro_establecimiento; ?>"/>
</form>
</div>