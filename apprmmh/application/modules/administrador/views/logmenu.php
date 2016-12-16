<?php $this->load->library("session");
	  $this->load->helper("url");	
	  $periodo = $this->session->userdata('ano_periodo') . $this->session->userdata('mes_periodo');	  
?>

<form id="frmPeriodo" name="frmPeriodo" method="post" action="<?php echo site_url("logistica/actualizarPeriodo"); ?>">
<div id="menu" class="row">
	<div class="twelvecol last">
		<ul>
			<li>
			    <select id="cmbPeriodo" name="cmbPeriodo" class="select">
			    <option value="------">...</option>			    
			    <?php for ($i=0; $i<count($periodos); $i++){ 
			          	 if ($periodos[$i]["periodo"]==$periodo)
			          	 	echo '<option value="'.$periodos[$i]["periodo"].'" selected="selected">'.$periodos[$i]["nom_periodo"].'</option>';
			          	 else	
			          	 	echo '<option value="'.$periodos[$i]["periodo"].'">'.$periodos[$i]["nom_periodo"].'</option>';
			          } 
			    ?>
			    </select>			    
			</li>
			<li><a href="<?php echo site_url("logistica/directorio"); ?>">Directorio</a></li>			
			<li><a href="<?php echo site_url("logistica/formularios"); ?>">Formularios</a></li>
			<li><a href="<?php echo site_url("logistica/operativo"); ?>">Operativo</a></li>
			<li><a href="<?php echo site_url("administrador/descargaPlanos"); ?>">Descarga Planos</a></li>
			<li><a href="<?php echo site_url("logistica/descarga"); ?>">Formulario&nbsp;<img src="<?php echo base_url("images/acrobat.png"); ?>" title="Formulario en Blanco" border="0"/></a></li>
			<li><a href="<?php echo site_url("logistica/cerrarSesion"); ?>">Salir&nbsp;<img src="<?php echo base_url("images/exit.png"); ?>" title="Salir de la aplicaci&oacute;n" border="0"/></a></li>
		</ul>
	</div>	
</div>
</form>