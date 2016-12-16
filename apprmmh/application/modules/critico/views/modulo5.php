<?php //Verifica el bloqueo del formulario
	  $strBloqueo = "";
      if($bloqueo){
	  	  $strBloqueo = "disabled";	  
	  }
	  else{
	  	  $strBloqueo = "";
	  }
?>
<h3>M&oacute;dulo V - Clasificaci&oacute;n CIIU 4</h3>
<br/>
<p><b>Instrucciones</b></p>
<br/>
<p>1. De acuerdo a la  modalidad principal de alojamiento que usted presta, seleccione una de las seis categor&iacute;as presentadas (hoteles, aparta-hoteles, centros vacacionales, alojamiento rural, hostales, zonas de camping). En esta se&ntilde;ale los servicios caracter&iacute;sticos de su establecimiento.</p>
<br/>
<!-- p>2. Se&ntilde;ale los servicios adicionales que presta en cualquiera de las cinco categor&iacute;as restantes. </p-->
<br/>
<form id="frmModuloV" name="frmModuloV" method="post" action="">
<table width="100%">
<tr>
<?php  $_NCOLSFIL = 3; //Número de columnas por cada fila.
       $contador = 0;
       for ($i=0; $i<count($categorias); $i++){
	     	$valor = $i+1;
       		$servicios = $this->modulo5->obtenerServicios($valor);
       		
       		//Obtengo el string de datos de cada una de las categorias del formulario
       		switch($valor){
       			case 1: $stringDatos = (isset($modulo5["hoteles"]))?$modulo5["hoteles"]:"";
       			        break;
       			case 2: $stringDatos = (isset($modulo5["apartahoteles"]))?$modulo5["apartahoteles"]:"";
       			        break;        
       			case 3: $stringDatos = (isset($modulo5["cenvacacionales"]))?$modulo5["cenvacacionales"]:"";
       			        break;
       			case 4: $stringDatos = (isset($modulo5["alojarural"]))?$modulo5["alojarural"]:"";
       			        break;
       			case 5: $stringDatos = (isset($modulo5["hostales"]))?$modulo5["hostales"]:"";
       			        break;
       			case 6: $stringDatos = (isset($modulo5["zonacamp"]))?$modulo5["zonacamp"]:"";
       			        break;                
       		}
       		
       		if ($contador<3){
	     		echo '<td valign="top" style="width: 33%;">';
	     		if (strrpos($stringDatos,"1")){ //Si viene un uno en alguna de las cadenas de string-checks, debo marcar toda la categoria
	     			echo '<b>'.$categorias[$i]["cod_ciiu"].' - '.$categorias[$i]["nombre"].'</b>&nbsp;<input type="checkbox" id="chkCategoria'.$valor.'" name="chkCategoria'.$valor.'" value="'.$valor.'" checked="checked"'. $strBloqueo .'/>';
	     		}
	     		else{
	     			echo '<b>'.$categorias[$i]["cod_ciiu"].' - '.$categorias[$i]["nombre"].'</b>&nbsp;<input type="checkbox" id="chkCategoria'.$valor.'" name="chkCategoria'.$valor.'" value="'.$valor.'"'. $strBloqueo .'/>';
	     		}
	     		echo '<br/>';	     		
	     		echo '<table width="100%">';
	     		for ($j=0; $j<count($servicios); $j++){
	     			$serv = $j + 1;
	     			echo '<tr>';
	     			if (isset($stringDatos[$j])&&($stringDatos[$j]==1)){
	     				echo '<td valign="top"><input type="checkbox" id="chkServicios'.$valor.$serv.'" name="chkServicios'.$valor.$serv.'" value="x" checked="checked" '. $strBloqueo .'/></td>';
	     			}
	     			else{
	     				echo '<td valign="top"><input type="checkbox" id="chkServicios'.$valor.$serv.'" name="chkServicios'.$valor.$serv.'" value="x" '. $strBloqueo .'/></td>';
	     			}		
	     			echo '<td valign="top">'.$servicios[$j]["codigo"]." ".$servicios[$j]["nombre"].'</td>';
	     			echo '</tr>';  
	     		}
	     		echo '</table>';
	     		echo '</td>';
	     		$contador++;
	     	}  
	     	else{
	     		echo '<tr><td colspan="3">&nbsp;</td></tr>';
	     		echo '</tr>';
	     		echo '<tr>';
	     		echo '<td valign="top" style="width: 33%;">';
	     		if (strrpos($stringDatos,"1")){ //Si viene un uno en alguna de las cadenas de string-checks, debo marcar toda la categoria
	     			echo '<b>'.$categorias[$i]["cod_ciiu"].' - '.$categorias[$i]["nombre"].'</b>&nbsp;<input type="checkbox" id="chkCategoria'.$valor.'" name="chkCategoria'.$valor.'" value="'.$valor.'" checked="checked"'. $strBloqueo .'/>';
	     		}
	     		else{
	     			echo '<b>'.$categorias[$i]["cod_ciiu"].' - '.$categorias[$i]["nombre"].'</b>&nbsp;<input type="checkbox" id="chkCategoria'.$valor.'" name="chkCategoria'.$valor.'" value="'.$valor.'"'. $strBloqueo .'/>';
	     		}
	     		echo '<br/>';
	     		echo '<table width="100%">';
	     		for ($j=0; $j<count($servicios); $j++){
	     			$serv = $j + 1;
	     			echo '<tr>';
	     			if (isset($stringDatos[$j])&&($stringDatos[$j]==1)){
	     				echo '<td valign="top"><input type="checkbox" id="chkServicios'.$valor.$serv.'" name="chkServicios'.$valor.$serv.'" value="x" checked="checked"'. $strBloqueo .'/></td>';
	     			}
	     			else{
	     				echo '<td valign="top"><input type="checkbox" id="chkServicios'.$valor.$serv.'" name="chkServicios'.$valor.$serv.'" value="x" '. $strBloqueo .'/></td>';
	     			}	
	     			echo '<td valign="top">'.$servicios[$j]["codigo"]." ".$servicios[$j]["nombre"].'</td>';
	     			echo '</tr>';  
	     		}
	     		echo '</table>';
	     		echo '</td>';	     		
	     		$contador = 1;
	     	}	  	  
       } 
?>
</tr>
</table>
<br/>
<?php
$contador = 0;
for ($i=0; $i<count($categorias); $i++){
	$valor = $i+1;
	$servicios = $this->modulo5->obtenerServicios($valor);
	 
	//Obtengo el string de datos de cada una de las categorias del formulario
	switch($valor){
		case 1: $stringDatos = (isset($modulo5["hoteles"]))?$modulo5["hoteles"]:"";
		break;
		case 2: $stringDatos = (isset($modulo5["apartahoteles"]))?$modulo5["apartahoteles"]:"";
		break;
		case 3: $stringDatos = (isset($modulo5["cenvacacionales"]))?$modulo5["cenvacacionales"]:"";
		break;
		case 4: $stringDatos = (isset($modulo5["alojarural"]))?$modulo5["alojarural"]:"";
		break;
		case 5: $stringDatos = (isset($modulo5["hostales"]))?$modulo5["hostales"]:"";
		break;
		case 6: $stringDatos = (isset($modulo5["zonacamp"]))?$modulo5["zonacamp"]:"";
		break;
	}
	$cierto=0;
	//$displayInc='';
	for ($j=0; $j<count($servicios); $j++){
		$serv = $j + 1;
		if(isset($stringDatos[$j])&&($stringDatos[$j]==1)){
			if($valor==1 && $serv==12){
				$displayInc="hide";
			}
			elseif($valor==2 && $serv==15){
				$displayInc="hide";
			}
			elseif($valor==3 && $serv==13){
				$displayInc="hide";
			}
			elseif($valor==4 && $serv==12){
				$displayInc="hide";
			}
			elseif($valor==5 && $serv==10){
				$displayInc="hide";
			}
			elseif($valor==6 && $serv==5){
				$displayInc="hide";
			}
			else{
				$displayInc="none";
			}
		}else{
			if($modulo5["otro_servicio"]==''){
			$displayInc="none";
			}
		}
	}
	$contador = 1;
}

?>
<div id="formularioInsindc" style="display: <? echo $displayInc;?>;">
	<div><span id="texto4">Especifique el otro servicio</span></div>
	<div><textarea cols=75 rows=3 name="otroServicio" id="otroServicio"><?php echo $modulo5["otro_servicio"] ?></textarea></div> 
</div>
<br/>
<br/>
<?php //Validar que el formulario esté en estado 99 - 4 para poder ser activado por el critico 
	  if (($novedad_estado["novedad"]==99)&&($novedad_estado["estado"]==4)){  
?>  	  <center><input type="button" id="btnOBSCriticaV" name="btnOBSCriticaV" value="Observaciones Cr&iacute;tica" class="button"/></center>        
<?php } ?>
<input type="hidden" id="op" name="op" value="<?php echo $modulo5["op"]; ?>"/>
<input type="hidden" id="nro_orden" name="nro_orden" value="<?php echo $nro_orden; ?>"/> 
<input type="hidden" id="nro_establecimiento" name="nro_establecimiento" value="<?php echo $nro_establecimiento; ?>"/>
</form>