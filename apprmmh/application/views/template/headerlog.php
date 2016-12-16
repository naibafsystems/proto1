<?php 
  $ano_periodo = $this->session->userdata("ano_periodo");
  $trim_periodo = $this->session->userdata("trim_periodo");
  $nomPeriodo = $this->periodo->obtenerNombrePeriodo($ano_periodo, $trim_periodo);
?>
<div id="header" class="row">
	<div class="twocol">&nbsp;</div>
	<div class="tencol last">
		<div id="textlogo">
			<h1><?php echo $this->config->item("header"); ?></h1>
		</div>		
		<div id="usuario">
			<b>Usuario:&nbsp;</b><?php echo $this->session->userdata("nombre")." ". $this->session->userdata("apellido"); ?>&nbsp;
		</div>
		<div id="periodo">			
			<b>Trimestre:&nbsp;</b><?php echo $nomPeriodo; ?>			
		</div>
	</div>		
</div>