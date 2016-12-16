<?php $this->load->library("session");
	  $this->load->helper("url");	
	  $periodo = $this->session->userdata('ano_periodo') . $this->session->userdata('mes_periodo');	  
?>

<form id="frmPeriodo" name="frmPeriodo" method="post" action="<?php echo site_url("administrador/actualizarPeriodo"); ?>">
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
			<li><a href="<?php echo site_url("administrador/directorio"); ?>">Directorio</a></li>			
			<li><a href="<?php echo site_url("administrador/usuarios"); ?>">Usuarios</a></li>
			<li><a href="<?php echo site_url("administrador/formularios"); ?>">Formularios</a></li>
			<li><a href="<?php echo site_url("administrador/operativo"); ?>">Operativo</a></li>
			<!-- 
			<li><a href="<?php //echo site_url("administrador/descapitulos"); ?>">Descargar Cap&iacute;tulos</a></li>
			<li><a href="<?php //echo site_url("administrador/analisis"); ?>">An&aacute;lisis</a></li>
			<li><a href="<?php //echo site_url("administrador/cuadros"); ?>">Cuadros</a></li>
			<li><a href="<?php //echo site_url("administrador/panel"); ?>">Panel</a></li>
			<li><a href="<?php //echo site_url("administrador/imputaciones"); ?>">Imputaciones</a></li>
			<li><a href="<?php //echo site_url("administrador/indcalidad"); ?>">Indicadores de Calidad</a></li>
			-->
			<li><a href="<?php echo site_url("administrador/cierreperiodo");?>">Cierre de periodo</a></li>
			<li><a href="<?php echo site_url("administrador/descarga"); ?>">Formulario&nbsp;<img src="<?php echo base_url("images/acrobat.png"); ?>" title="Formulario en Blanco" border="0"/></a></li>
			<li><a href="<?php echo site_url("administrador/cerrarSesion"); ?>">Salir&nbsp;<img src="<?php echo base_url("images/exit.png"); ?>" title="Salir de la aplicaci&oacute;n" border="0"/></a></li>
		</ul>
	</div>	
</div>
</form>