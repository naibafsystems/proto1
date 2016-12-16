<?php $this->load->library("session");
	  $this->load->helper("url");	
	  $periodo = $this->session->userdata('ano_periodo') . $this->session->userdata('mes_periodo');	  
?>

<form id="frmPeriodo" name="frmPeriodo" method="post" action="<?php echo site_url("tematica/actualizarPeriodo"); ?>">
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
			<li><a href="<?php echo site_url("tematica/directorio"); ?>">Directorio</a></li>			
			<li><a href="<?php echo site_url("tematica/usuarios"); ?>">Usuarios</a></li>
			<li><a href="<?php echo site_url("tematica/formularios"); ?>">Formularios</a></li>
			<li><a href="<?php echo site_url("tematica/operativo"); ?>">Operativo</a></li>
			<li><a href="<?php echo site_url("tematica/descarga"); ?>">Formulario&nbsp;<img src="<?php echo base_url("images/acrobat.png"); ?>" title="Formulario en Blanco" border="0"/></a></li>
			<li><a href="<?php echo site_url("tematica/cerrarSesion"); ?>">Salir&nbsp;<img src="<?php echo base_url("images/exit.png"); ?>" title="Salir de la aplicaci&oacute;n" border="0"/></a></li>
		</ul>
	</div>	
</div>
</form>