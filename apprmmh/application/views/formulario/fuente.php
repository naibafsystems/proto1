<?php 
	//Los datos que yo recibo en esta vista se propagan a traves de las demas vistas qye yo llame desde esta vista, 
	//por lo que la variable controller puede ser accedida desde cualquiera de las vistas de los capitulos.
	$this->load->library("general");
?>
<div id="content">
	<h3><?php echo "(".$nro_orden.") - ".$nombre; ?></h3>
	<br/>
	<div id="tabs">
		
		<ul>
			<li><a href="#tabs-1">Cap&iacute;tulo I<img id="imgtab1" src="<?php echo $this->general->obtenerImagen($caratula["imagen"]); ?>" border="0" style="padding-left: 10px;"/></a></li>
			<li><a href="#tabs-2">Cap&iacute;tulo II<img id="imgtab2" src="<?php echo $this->general->obtenerImagen($capitulo1["imagen"]); ?>" border="0" style="padding-left: 10px;"/></a></li>
			<li><a href="#tabs-3">Cap&iacute;tulo III<img id="imgtab3" src="<?php echo $this->general->obtenerImagen($capitulo2["imagen"]); ?>" border="0" style="padding-left: 10px;"/></a></li>
			<li><a href="#tabs-4">Cap&iacute;tulo IV<img id="imgtab4" src="<?php echo $this->general->obtenerImagen($capitulo3["imagen"]); ?>" border="0" style="padding-left: 10px;"/></a></li>
			<li><a href="#tabs-5">Cap&iacute;tulo V<img id="imgtab5" src="<?php echo $this->general->obtenerImagen($capitulo4["imagen"]); ?>" border="0" style="padding-left: 10px;"/></a></li>
			<?php if ($tab_envio){ ?>
				<li><a href="#tabs-6">Enviar formulario<img id="imgtab6" src="<?php echo $this->general->obtenerImagen($envio["imagen"]); ?>" border="0" style="padding-left: 10px;"/></a></li>
			<?php } ?>
			<?php if ($pazysalvo){ ?>
				<li><a href="#tabs-7">Paz y Salvo<img id="imgtab7" src="<?php echo $this->general->obtenerImagen($envio["imagen"]); ?>" border="0" style="padding-left: 10px;"/></a></li>
			<?php } ?>	
		</ul>
				
		<div id="tabs-1">
		    <?php $this->load->view("formulario/caratula"); ?>		    			
		</div>
		<div id="tabs-2">
			<?php $this->load->view("formulario/capitulo1"); ?>
		</div>
		<div id="tabs-3">
			<?php $this->load->view("formulario/capitulo2"); ?>			
		</div>
		<div id="tabs-4">
			<?php $this->load->view("formulario/capitulo3"); ?>			
		</div>
		<div id="tabs-5">
			<?php $this->load->view("formulario/capitulo4"); ?>			
		</div>
		<?php if ($tab_envio){ ?>
		<div id="tabs-6">
			<?php $this->load->view("formulario/envioform"); ?>
		</div>
		<?php } ?>
		<?php if ($pazysalvo){ ?>
		<div id="tabs-7">
			<?php $this->load->view("formulario/pazysalvo"); ?>
		</div>
		<?php } ?>
	</div>
</div>


<?php /*******
      //Daniel M. Díaz
      //Junio 14 2012
      //Si el usuario es un critico, se carga la vista para mostrar las observaciones diligenciadas por la fuente
      ********/ 
      if ($controller=="critico"){ 
      	$this->load->view("critico/observaciones");
      }
?>
