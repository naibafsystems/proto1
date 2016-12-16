<?php
$this->load->library("general");
$style = 'style="color: #FF0000; font-weight: bold;"';
if($estado_indicador["estado_indicador"]==0){
	echo '<div style="color:#FF0000;" align="center">El m&oacute;dulo para generar el indicador de calidad correspondiente a '.$estado_indicador["nom_periodo"].' se encuentra cerrado, favor comun&iacute;quese con el administrador!!!</div>';
}
else{
	$cadena=$nomcritico;
	$resultado = str_replace("%20", " ", $cadena);
	?>
		<center>INDICADOR DE CALIDAD PERIODO <?php echo $ano_periodo." - ".$mes_periodo; ?></center>
		<center>FUENTES DEL CRITICO <?php echo  $resultado;?></center>
		
		<?php	$style = 'style="color: #FF0000; font-weight: bold;"'; ?>
		<div id="reporteOPCritico">
		<table width="100%" class="table" style="font-size: 11px;">
		<thead>
		<tr>
		  <th style="border-right: 1px solid #CCCCCC;" align="center">Cod. Empresa</th>
		  <th style="border-right: 1px solid #CCCCCC;" align="center">Cod. Establecimiento</th>
		  <th style="border-right: 1px solid #CCCCCC;" align="center">Nombre Empresa</th>
		  <th style="border-right: 1px solid #CCCCCC;" align="center">Calificaci&oacute;n Fuentes</th>
		</tr>
		</thead>
		<tbody>
		<?php 
		for ($i=0; $i<count($fuentes_calificar); $i++){
				$calificacion=explode(",",$calific);
				$establecimiento=$fuentes_calificar[$i]["nro_establecimiento"];
		  	  	$var = ($i%2!=0)?"row2":"row1";
				$html='<tr class="'.$var.'">';
				$html.='<td align="center">'.$fuentes_calificar[$i]["nro_orden"].'</td>';
				$html.='<td align="center"><a href="'.site_url("/indicadorcalidad/formularioIndicador/$establecimiento").'">'.$fuentes_calificar[$i]["nro_establecimiento"].'</a></td>';
		  		$html.='<td align="center"><a href="'.site_url("/indicadorcalidad/formularioIndicador/$establecimiento").'">'.$fuentes_calificar[$i]["establecimiento"].'</a></td>';
		  		$html.='<td align="center">'.$calificacion[$i+1].'</td>';
		  	$html.='</tr>';
		  	echo $html;
		}
		?>	
		</tbody>
		</table>
		<br/>
		</div>
		
	<?php 
	echo ("<center><<<<a href='javascript:history.back(1)'>Regresar</a></center>");
	} 
?>