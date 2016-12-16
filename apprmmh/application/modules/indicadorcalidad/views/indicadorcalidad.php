<?php
$this->load->library("general");
$style = 'style="color: #FF0000; font-weight: bold;"';
if($estado_indicador["estado_indicador"]==0){
	echo '<div style="color:#FF0000;" align="center">El m&oacute;dulo para generar el indicador de calidad correspondiente a '.$estado_indicador["nom_periodo"].' se encuentra inhabilitado, favor comun&iacute;quese con el administrador!!!</div>';
}
else{
	//Si no encuentra formularios seleccionados, muestra el formulario para generar los indicadores
	if(count($fuentes_indicador)==0){
		?>
			<h3><center>GENERAR INDICADOR DE CALIDAD <?php echo $ano_periodo." - ".$mes_periodo;?></center></h3>
			<br><br>
			<form id="frmGeneraIndicador" name="frmGeneraIndicador" method="post" action="<?php echo site_url("indicadorcalidad/generaIndicador"); ?>">
			<div><input type="hidden" id="subsede" name="subsede" value="<?php echo $sede["fk_subsede"]; ?>"/></div>
			<div align="center"><input type="button" id="btnGenerarIndicadorr" name="btnGenerarIndicadorr" value="GenerarIndicador" class="button"/></div>
			<!-- input type="button" id="btnBuscarASTT" name="btnBuscarASTT" value="Buscar" class="button"/-->	 
		</form>
		<?php 
	}
	else{
		?>
		<center>INDICADOR DE CALIDAD PERIODO <?php echo $ano_periodo." - ".$mes_periodo;?></center>
		<center>REPORTE DE CRITICOS SUBSEDE <?php echo strtoupper($nomSubsede); ?></center>
		<center>ASISTENTE T&Eacute;CNICO: <?php echo strtoupper($criticos_calificar[0]["nombre_asistente"]); ?></center>
		<br>
		<?php	$style = 'style="color: #FF0000; font-weight: bold;"'; ?>
		<div id="reporteOPCritico">
		<table width="100%" class="table" style="font-size: 11px;">
		<thead>
		<tr>
		  <th style="border-right: 1px solid #CCCCCC;" align="center">Cr&iacute;tico</th>
		  <th style="border-right: 1px solid #CCCCCC;" align="center">Nombre</th>
		  <th style="border-right: 1px solid #CCCCCC;" align="center">Formularios por calificar</th>
		  <th style="border-right: 1px solid #CCCCCC;" align="center">Formularios calificados</th>
		  <th style="border-right: 1px solid #CCCCCC;" align="center">Pendientes por calificar</th>
		  <th style="border-right: 1px solid #CCCCCC;" align="center">Calificaci&oacute;n Cr&iacute;tico</th>
		</tr>
		</thead>
		<tbody>
		<?php 
		for ($i=0; $i<count($criticos_calificar); $i++){ 
				$calific=explode(",",$calificadas);
				$idcritico=$criticos_calificar[$i]["criticos"];
				$nomcritico=$criticos_calificar[$i]["nombre"];
				$promedio=explode(",",$promediofuentes);
				if($promedio[$i+1]!=''){
					$prom[$i]=$promedio[$i+1];
				}else{
					$prom[$i]=0;
				}
				$pendientesCalificar=($criticos_calificar[$i]["fuentes"]-$calific[$i+1]);
				$promedioCalificacion=$prom[$i]/$criticos_calificar[$i]["fuentes"];
		  	  	$var = ($i%2!=0)?"row2":"row1";
				$html='<tr class="'.$var.'">';
					$html.='<td align="center">'.$criticos_calificar[$i]["criticos"].'</td>';
			  		$html.='<td align="center"><a href="'.site_url("/indicadorcalidad/fuentesxCritico/$idcritico/$nomcritico").'">'.$criticos_calificar[$i]["nombre"].'</a></td>';
					$html.='<td align="center">'.$criticos_calificar[$i]["fuentes"].'</td>';
			  		$html.='<td align="center">'.$calific[$i+1].'</td>';
			  		$html.='<td align="center">'.$pendientesCalificar.'</td>';
			  		$html.='<td align="center">'.number_format($promedioCalificacion,2,'.',',').'</td>';
		  		$html.='</tr>';
		  	echo $html;
		}
		?>	
		</tbody>
		</table>
		<br>
		<div align="center">Promedio calificaci&oacute;n subsede: <?php echo number_format($promedioCalSede,2,'.',',');?></div>
		<br>
	<?php
		if(count($registrosCierre)>0){
			$resumenIndicador='<div align="center">';
				$resumenIndicador.='<table width="50%" class="table" style="font-size: 11px;">';
					$resumenIndicador.='<thead>';
						$resumenIndicador.='<tr>';
							$resumenIndicador.='<th class="row1" style="border-right: 1px solid #CCCCCC;" align="center">Fecha de cierre del indicador</th>';
							$resumenIndicador.='<td class="row1">'.$registrosCierre[0]["fecCierre"].'</td> ';
						$resumenIndicador.='</tr>';
						$resumenIndicador.='<tr>';
							$resumenIndicador.='<th class="row2" style="border-right: 1px solid #CCCCCC;" align="center">Periodo</th>';
							$resumenIndicador.='<td class="row2">'.$ano_periodo." - ".$mes_periodo.'</td>';
						$resumenIndicador.='</tr>';
						$resumenIndicador.='<tr>';
							$resumenIndicador.='<th class="row1" style="border-right: 1px solid #CCCCCC;" align="center">Fuentes calificadas subsede</th>';
							$resumenIndicador.='<td class="row1">'.$fuentesCalificadasSubsedes["calificadas"].'</td>';
						$resumenIndicador.='</tr>';
						$resumenIndicador.='<tr>';
							$resumenIndicador.='<th class="row2" style="border-right: 1px solid #CCCCCC;" align="center">Calilficaci&oacute;n subsede</th>';
							$resumenIndicador.='<td class="row2">'.number_format($promedioCalSede,2,'.',',').'</td>';
						$resumenIndicador.='</tr>';
						$resumenIndicador.='<tr>';
							$resumenIndicador.='<th class="row1" style="border-right: 1px solid #CCCCCC;" align="center">Nivel de calidad</th>';
							$resumenIndicador.='<td class="row1">'.$nivel.'</td>';
						$resumenIndicador.='</tr>';
					$resumenIndicador.='</thead>';
				$resumenIndicador.='</table>';
			$resumenIndicador.='</div>';
			$resumenMeses='<div align="center">';
				$resumenMeses.='<table width="50%" class="table" style="font-size: 11px;">';
					$resumenMeses.='<thead>';
						$resumenMeses.='<tr>';
						$resumenMeses.='<th class="row1" colspan="6" style="border-right: 1px solid #CCCCCC;" align="center">COMPARATIVO &Uacute;LTIMOS 5 PERIODOS</th>';
						$resumenMeses.='</tr>';
						$resumenMeses.='<tr>';
							$resumenMeses.='<th style="border-right: 1px solid #CCCCCC;" align="center"> PERIODOS</th>';
							$resumenMeses.='<th style="border-right: 1px solid #CCCCCC;" align="center">'.$ano_periodo."-".$mes_periodo.'</td>';
							$resumenMeses.='<th style="border-right: 1px solid #CCCCCC;" align="center">'.$mes1.'</td>';
							$resumenMeses.='<th style="border-right: 1px solid #CCCCCC;" align="center">'.$mes2.'</td>';
							$resumenMeses.='<th style="border-right: 1px solid #CCCCCC;" align="center">'.$mes3.'</td>';
							$resumenMeses.='<th style="border-right: 1px solid #CCCCCC;" align="center">'.$mes4.'</td>';
						$resumenMeses.='</tr>';
						$resumenMeses.='<tr>';
							$resumenMeses.='<th class="row1" style="border-right: 1px solid #CCCCCC;" align="center"> INDICADOR DE CALIDAD</th>';
							$resumenMeses.='<td class="row1" align="center">'.number_format($promedioCalSede,2,'.',',').'</td>';
							$resumenMeses.='<td class="row1" align="center">'.number_format($promedioCalSedeM1,2,'.',',').'</td>';
							$resumenMeses.='<td class="row1" align="center">'.number_format($promedioCalSedeM2,2,'.',',').'</td>';
							$resumenMeses.='<td class="row1" align="center">'.number_format($promedioCalSedeM3,2,'.',',').'</td>';
							$resumenMeses.='<td class="row1" align="center">'.number_format($promedioCalSedeM4,2,'.',',').'</td>';
						$resumenMeses.='</tr>';
						$resumenMeses.='<tr>';
							$resumenMeses.='<th class="row2" style="border-right: 1px solid #CCCCCC;" align="center"> NIVEL CALIDAD</th>';
							$resumenMeses.='<td class="row2" align="center">'.$nivel.'</td>';
							$resumenMeses.='<td class="row2" align="center">'.$nivelmes1.'</td>';
							$resumenMeses.='<td class="row2" align="center">'.$nivelmes2.'</td>';
							$resumenMeses.='<td class="row2" align="center">'.$nivelmes3.'</td>';
							$resumenMeses.='<td class="row2" align="center">'.$nivelmes4.'</td>';
						$resumenMeses.='</tr>';
					$resumenMeses.='</thead>';
				$resumenMeses.='</table>';
			$resumenMeses.='</div>';
			$accionCorrectiva='<div align="center">';
				$accionCorrectiva.='<table width="50%" class="table" style="font-size: 11px;">';
					$accionCorrectiva.='<thead>';
						$accionCorrectiva.='<tr>';
							$accionCorrectiva.='<th class="row1" colspan="6" style="border-right: 1px solid #CCCCCC;" align="center">ACCIONES CORRECTIVAS</th>';
						$accionCorrectiva.='</tr>';
						$accionCorrectiva.='<tr>';
						    $accionCorrectiva.='<th style="border-right: 1px solid #CCCCCC;" align="center">No. orden</th>';
							$accionCorrectiva.='<th style="border-right: 1px solid #CCCCCC;" align="center">No. establecimiento</th>';
							$accionCorrectiva.='<th style="border-right: 1px solid #CCCCCC;" align="center"> Acci&oacute;n correctiva</th>';
							$accionCorrectiva.='<th style="border-right: 1px solid #CCCCCC;" align="center">Fecha de registro</td>';
						$accionCorrectiva.='</tr>';
						if(count($accionesCorrectivas)>0){
							for($k=0; $k<=count($accionesCorrectivas)-1; $k++){
								$var = ($k%2!=0)?"row2":"row1";
								$accionCorrectiva.='<tr class="'.$var.'">';
									$accionCorrectiva.='<td align="center">'.$accionesCorrectivas[$k]["orden"].'</td>';
									$accionCorrectiva.='<td align="center">'.$accionesCorrectivas[$k]["establecimiento"].'</td>';
									$accionCorrectiva.='<td align="center">'.$accionesCorrectivas[$k]["accionCorrectiva"].'</td>';
									$accionCorrectiva.='<td align="center">'.$accionesCorrectivas[$k]["fecRegistro"].'</td>';
								$accionCorrectiva.='</tr>';
							}	
						}else{
							$accionCorrectiva.='<tr class="'.$var.'">';
							$accionCorrectiva.='<td align="center" colspan="4">Sin registros de acciones correctivas</td>';
							$accionCorrectiva.='</tr>';
						}
					$accionCorrectiva.='</thead>';
				$accionCorrectiva.='</table>';
			$accionCorrectiva.='</div>';
		}
	}
	if(count($fuentes_indicador)!=0){ 
		if($this->session->userdata("tipo_usuario")!=3){
			if(count($registrosCierre)>0){
				echo $resumenIndicador;
				echo $resumenMeses;
				echo $accionCorrectiva;
			}
			echo "<br>";
			echo ("<center><<<<a href='javascript:history.back(1)'>Regresar</a></center>");
		}else{
			if(count($registrosCierre)==0){
				?>
					<br>
					<form id="frmGeneraCierreIndicador" name="frmGeneraCierreIndicador" method="post" action="<?php echo site_url("indicadorcalidad/generaIndicador"); ?>">
					<div><input type="hidden" id="subsede" name="subsede" value="<?php echo $sede["fk_subsede"]; ?>"/></div>
					<div><input type="hidden" id="asistente" name="asistente" value="<?php echo $criticos_calificar[0]["asistente"]; ?>"/></div>
					<div align="center"><input type="button" id="btnGenerarCierreIndicador" name="btnGenerarCierreIndicador" value="GenerarCierreIndicador" class="button"/></div>
					<!-- input type="button" id="btnBuscarASTT" name="btnBuscarASTT" value="Buscar" class="button"/-->	 
				</form>
				<?php 
			}else{
				echo $resumenIndicador;
				echo $resumenMeses;
				echo $accionCorrectiva;
			}
		}
	}		
}
?>