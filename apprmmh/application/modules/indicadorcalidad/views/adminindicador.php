<?php
$this->load->library("general");
$style = 'style="color: #FF0000; font-weight: bold;"';

if($estado_indicador["estado_indicador"]==0){
	$selected0="selected";
	$selected1="";
}else{
	$selected0="";
	$selected1="selected";
}
if($this->session->userdata("tipo_usuario")==4){
	?>
	<form id="frmEstadoIndicador" name="frmEstadoIndicador" method="post" action="<?php echo site_url("indicadorcalidad/generaIndicador"); ?>">
	<div align="center">
		Cambiar estado al m&oacute;dulo del inidicador de calidad:
		<select name="habIndicador">
			<option value="0" <?php echo $selected0; ?> >Inhabilitado</option>
			<option value="1" <?php echo $selected1; ?> >Habilitado</option>
		</select>
	<input type="hidden" id="ano_periodo" name="ano_periodo" value="<?php echo $ano_periodo; ?>"/>
	<input type="hidden" id="mes_periodo" name="mes_periodo" value="<?php echo $mes_periodo; ?>"/>
	<input type="button" id="btnestadoIndicador" name="btnestadoIndicador" value="Cambiar" class="button"/></div>
	</form>
	<?php
}
	
if($estado_indicador["estado_indicador"]==0){
	echo '<br><div style="color:#FF0000;" align="center">El m&oacute;dulo para generar el indicador de calidad correspondiente a '.$estado_indicador["nom_periodo"].' se encuentra inhabilitado!!!</div>';
	
}
else{
	//Si no encuentra formularios seleccionados, muestra el formulario para generar los indicadores
	//if(count($fuentes_indicador)==0){
	?>
	<br>
	<hr noshade="noshade" />
	<center>SUBSEDES INDICADOR DE CALIDAD <?php echo $ano_periodo." - ".$mes_periodo;?></center>
	
	<?php	$style = 'style="color: #FF0000; font-weight: bold;"'; ?>
	<div id="reporteOPCritico">
	<table width="100%" class="table" style="font-size: 11px;">
	<thead>
		<tr>
			<th style="border-right: 1px solid #CCCCCC;" align="center">Cod. Sede</th>
		  	<th style="border-right: 1px solid #CCCCCC;" align="center">Sede</th>
		  	<th style="border-right: 1px solid #CCCCCC;" align="center">Formularios aceptados</th>
		  	<th style="border-right: 1px solid #CCCCCC;" align="center">Formularios para calificar</th>
		  	<th style="border-right: 1px solid #CCCCCC;" align="center">Formularios calificados</th>
		  	<th style="border-right: 1px solid #CCCCCC;" align="center">Pendientes por calificar</th>
		  	<th style="border-right: 1px solid #CCCCCC;" align="center">Calificaci&oacute;n</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		for ($i=0; $i<count($obtener_subsedes); $i++){
				$fuentesAcep=explode(",",$fuentesAceptadas);
				$fuentesParaCali=explode(",",$fuentesCalificar);
				$fuentesCalific=explode(",",$fuentesCalificadas);
				$promCalFts=explode(",",$promediCalificacionFts);
				if($promCalFts[$i+1]!=''){
					$promedioCalFts[$i]=$promCalFts[$i+1];
					$promedioCalificacionFuentes=$promedioCalFts[$i]/$fuentesParaCali[$i+1];
				}else{
					$promedioCalFts[$i]=0;
					$promedioCalificacionFuentes=0;
				}
				$subsede[$i]=$obtener_subsedes[$i]["idsubsede"];
				$var = ($i%2!=0)?"row2":"row1";
				$html='<tr class="'.$var.'">';
				$html.='<td align="center">'.$obtener_subsedes[$i]["idsubsede"].'</td>';
				if($fuentesParaCali[$i+1]==0){
					$html.='<td align="center">'.$obtener_subsedes[$i]["nomsubsede"].'</td>';
				}else{
		  			$html.='<td align="center"><a href="'.site_url("/indicadorcalidad/indicadorSubsede/$subsede[$i]/").'">'.utf8_decode($obtener_subsedes[$i]["nomsubsede"]).'</a></td>';
				}
		  		$html.='<td align="center">'.$fuentesAcep[$i+1].'</td>';
		  		$html.='<td align="center">'.$fuentesParaCali[$i+1].'</td>';
		  		$html.='<td align="center">'.$fuentesCalific[$i+1].'</td>';
		  		$html.='<td align="center">'.($fuentesParaCali[$i+1]-$fuentesCalific[$i+1]).'</td>';
		  		$html.='<td align="center">'.number_format($promedioCalificacionFuentes,2,'.','').'</td>';
		  	$html.='</tr>';
		  	echo $html;
		}
		?>	
	</tbody>
	</table>
	<?php 
	} 
//}
?>