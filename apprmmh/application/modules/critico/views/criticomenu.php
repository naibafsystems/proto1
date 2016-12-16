<?php $this->load->library("session");
	  $this->load->helper("url");	
	  $periodo = $this->session->userdata('ano_periodo') . $this->session->userdata('mes_periodo');	  
?>

<form id="frmPeriodo" name="frmPeriodo" method="post" action="<?php echo site_url("critico/actualizarPeriodo"); ?>">
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
			<li><a href="<?php echo site_url("critico/directorio"); ?>">Directorio</a></li>			
			<li><a href="<?php echo site_url("critico/formularios"); ?>">Formularios</a></li>
			<li><a href="<?php echo site_url("critico/operativo"); ?>">Operativo</a></li>
			<li><a href="<?php echo site_url("critico/cerrarSesion"); ?>">Salir&nbsp;<img src="<?php echo base_url("images/exit.png"); ?>" title="Salir de la aplicaci&oacute;n" border="0"/></a></li>
		</ul>
	</div>	
</div>
</form>