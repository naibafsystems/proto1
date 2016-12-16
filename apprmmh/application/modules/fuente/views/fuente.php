<?php 
	//Los datos que yo recibo en esta vista se propagan a traves de las demas vistas qye yo llame desde esta vista, 
	//por lo que la variable controller puede ser accedida desde cualquiera de las vistas de los capitulos.
	$this->load->library("general");
	
?>
<?php echo "($nro_orden - $nro_establecimiento)  ".$modulo1["idnomcomest"]. " - Actividad: ".$modulo1["fk_ciiu"]. " - ".$modulo1["nom_ciiu"]; ?>
<div id="content">
	<br/>
	<div id="tabs">
		
		<ul>
			<li><a href="#tabs-1">M&oacute;dulo I<img id="imgtab1" src="<?php echo $this->general->obtenerImagen($modulo1["imagen"]); ?>" border="0" style="padding-left: 10px;"/></a></li>
			<li><a href="#tabs-2">M&oacute;dulo II<img id="imgtab2" src="<?php echo $this->general->obtenerImagen($modulo2["imagen"]); ?>" border="0" style="padding-left: 10px;"/></a></li>
			<li><a href="#tabs-3">M&oacute;dulo III<img id="imgtab3" src="<?php echo $this->general->obtenerImagen($modulo3["imagen"]); ?>" border="0" style="padding-left: 10px;"/></a></li>
			<li><a href="#tabs-4">M&oacute;dulo IV<img id="imgtab4" src="<?php echo $this->general->obtenerImagen($modulo4["imagen"]); ?>" border="0" style="padding-left: 10px;"/></a></li>
			<li><a href="#tabs-7">M&oacute;dulo V<img id="imgtab5" src="<?php echo $this->general->obtenerImagen($modulo5["imagen"]); ?>" border="0" style="padding-left: 10px;"/></a></li>			
			<?php if ($tab_envio){ ?>
				<li><a href="#tabs-5">Enviar formulario<img id="imgtab6" src="<?php echo $this->general->obtenerImagen($envio["imagen"]); ?>" border="0" style="padding-left: 10px;"/></a></li>
			<?php } ?>
			<?php if ($pazysalvo){ ?>
				<li><a href="#tabs-6">Paz y Salvo<img id="imgtab7" src="<?php echo $this->general->obtenerImagen($envio["imagen"]); ?>" border="0" style="padding-left: 10px;"/></a></li>
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
		<div id="tabs-7">
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
	</div>
</div>


<?php /*******
      //Daniel M. Díaz
      //Junio 14 2012
      //Si el usuario es un critico, se carga la vista para mostrar las observaciones diligenciadas por la fuente
      ********/ 
      
      /************ COMENTARIO POR EL REDISEÑO DE ESTABLECIMIENTO 

      if ($controller=="critico"){ 
      	$this->load->view("critico/observaciones");
      }
      
      **********/
?>
