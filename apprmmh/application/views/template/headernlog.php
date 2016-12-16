<div id="header" class="row">
	<div class="twocol">&nbsp;</div>
	<div class="tencol last">
		<div id="textlogo">
			<h1><?php echo $this->config->item("header"); ?></h1>
		</div>
		<?php 
		if(isset($nom_usuario)){ 				
			$usuario='<div id="usuario" style="font-size:10pt">';
				if($tipo_usuario!='FUENTE' && $tipo_usuario!='ADMINISTRADOR'){	
					$usuario.=$tipo_usuario." - ";
				}
				$usuario.=$nom_usuario; 
			$usuario.='</div>';
			echo $usuario;
		}
		?>
		<div id="periodo">			
			<b>&nbsp;</b>			
		</div>
	</div>		
</div>