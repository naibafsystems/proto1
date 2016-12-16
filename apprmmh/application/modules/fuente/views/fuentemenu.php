<?php $this->load->library("session");
	  $this->load->helper("url");
	  $periodo = $this->session->userdata('ano_periodo') . $this->session->userdata('mes_periodo');
	  $ano_periodo = $this->session->userdata("ano_periodo");
	  $mes_periodo = $this->session->userdata("mes_periodo");
?>

<form id="frmPeriodo" name="frmPeriodo" method="post" action="<?php echo site_url("fuente/actualizarPeriodo"); ?>">
<div id="menu" class="row">
	<div class="twelvecol last">
		<ul>
			 
			<li>
			<?php echo "Periodo ".$ano_periodo." - ".$mes_periodo;  ?>
			    <!-- select id="cmbPeriodo" name="cmbPeriodo" class="select">
			    <option value="------">...</option>			    
			    <?php /*for ($i=0; $i<count($periodos); $i++){ 
			          	 if ($periodos[$i]["periodo"]==$periodo)
			          	 	echo '<option value="'.$periodos[$i]["periodo"].'" selected="selected">'.$periodos[$i]["nom_periodo"].'</option>';
			          	 else	
			          	 	echo '<option value="'.$periodos[$i]["periodo"].'">'.$periodos[$i]["nom_periodo"].'</option>';
			          } */
			          
			    ?>
			    </select-->			    
			</li>
			
            <?php if ($bloqueo){ ?>
				<li><a href="<?php echo site_url("fuente/generarPDF"); ?>">Imprimir formulario&nbsp;<img src="<?php echo base_url("images/acrobat.png"); ?>" border="0"/></a></li>
			<?php } ?>			
			<li style="padding-top: 3px;"><a href="<?php echo site_url("fuente/descarga"); ?>">Formulario&nbsp;<img src="<?php echo base_url("images/acrobat.png"); ?>" title="Formulario en Blanco" border="0"/></a></li>
			<li style="padding-top: 3px;"><a href="<?php echo site_url("fuente/descargaManual"); ?>">Manual diligenciamiento&nbsp;<img src="<?php echo base_url("images/acrobat.png"); ?>" title="Manual Diligenciamiento" border="0"/></a></li>
			<li style="padding-top: 3px;"><a href="<?php echo site_url("fuente/opcionesUsuario/0"); ?>">Opciones usuario&nbsp;<img src="<?php echo base_url("images/user.png"); ?>" title="Cambiar datos usuario" border="0"/></a></li>
			<li style="padding-top: 3px;"><a href="<?php echo site_url("$controller/cerrarSesion"); ?>">Salir&nbsp;<img src="<?php echo base_url("images/exit.png"); ?>" title="Salir de la aplicaci&oacute;n" border="0"/></a></li>
		</ul>
	</div>	
</div>
</form>