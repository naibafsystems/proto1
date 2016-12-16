<?php $this->load->library("session");
	  $this->load->helper("url");
	  $periodo = $this->session->userdata('ano_periodo') . $this->session->userdata('mes_periodo');
?>

<form id="frmPeriodo" name="frmPeriodo" method="post" action="<?php echo site_url("administrador/actualizarPeriodo"); ?>">
<div id="menu" class="row">
	<div class="twelvecol last">
		<ul>
			<?php if ($bloqueo){ ?>
				<li><a href="<?php echo site_url("fuente/generarPDF"); ?>">Imprimir formulario&nbsp;<img src="<?php echo base_url("images/acrobat.png"); ?>" border="0"/></a></li>
			<?php } ?>
			<li style="padding-top: 3px;"><a href="<?php echo site_url("fuente/descarga"); ?>">Formulario&nbsp;<img src="<?php echo base_url("images/acrobat.png"); ?>" title="Formulario en Blanco" border="0"/></a></li>
			<li style="padding-top: 3px;"><a href="#">Manual diligenciamiento&nbsp;<img src="<?php echo base_url("images/acrobat.png"); ?>" title="Manual Diligenciamiento" border="0"/></a></li>
			<li style="padding-top: 3px;"><a href="#">Opciones usuario&nbsp;<img src="<?php echo base_url("images/user.png"); ?>" title="Cambiar datos usuario" border="0"/></a></li>
			<li style="padding-top: 3px;"><a href="<?php echo site_url("$controller/cerrarSesion"); ?>">Salir&nbsp;<img src="<?php echo base_url("images/exit.png"); ?>" title="Salir de la aplicaci&oacute;n" border="0"/></a></li>
		</ul>
	</div>	
</div>
</form>