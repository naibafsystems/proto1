<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.
$this->load->library("general");
$style = 'style="color: #FF0000; font-weight: bold;"';
if($estado_indicador["estado_indicador"]==0){
	echo '<div style="color:#FF0000;" align="center">El m&oacute;dulo para generar el indicador de calidad correspondiente a '.$estado_indicador["nom_periodo"].' se encuentra cerrado, favor comun&iacute;quese con el administrador!!!</div>';
}
else{
	?>
	<center>FORMULARIO DE INDICADOR DE CALIDAD PERIODO <?php echo $ano_periodo." - ".$mes_periodo;?><br>
	ESTABLECIMIENTO: <?php echo $fuentes_calificar[0]["establecimiento"]; ?><br>
	No. ESTABLECIMIENTO: <?php echo $fuentes_calificar[0]["nro_establecimiento"]; ?></cente>
		
	<?php	$style = 'style="color: #FF0000; font-weight: bold;"'; ?>
	<div id="reporteOPCritico">
	<form id="frmGrabaIndicador" name="frmGrabaIndicador" method="post" action="<?php echo site_url("indicadorcalidad/grabaIndicador"); ?>">
		<table width="100%" class="table" style="font-size: 11px;">
		<thead>
		<tr>
		  <th style="border-right: 1px solid #CCCCCC;" align="center">ID VARIABLES</th>
		  <th style="border-right: 1px solid #CCCCCC;" align="center">VARIABLES GENERALES</th>
		  <th style="border-right: 1px solid #CCCCCC;" align="center">Peso %</th>
		  <th style="border-right: 1px solid #CCCCCC;" align="center">Magnitud error</th>
		  <th style="border-right: 1px solid #CCCCCC;" align="center">% Error</th>
		  <th style="border-right: 1px solid #CCCCCC;" align="center">Conformidad<br>Si &nbsp; &nbsp; &nbsp; No</th>
		  <th style="border-right: 1px solid #CCCCCC;" align="center">Logro Crítica %</th>
		  <th style="border-right: 1px solid #CCCCCC;" align="center">Valoración Crítica Peso X Logro</th>
		</tr>
		</thead>
		<tbody>
		<?php 
		for ($i=0; $i<count($variables); $i++){
			    //Verifica que la fuente tenga calificación
				if(count($fuente_calificada)>0){
					$logrocritica=$fuente_calificada[$i]["logrocritica"];
					$valorcritica=$fuente_calificada[$i]["valorcritica"];
					if($fuente_calificada[$i]["conformidad"]==0){
						$checked1="checked";
					}else{
						$checked1="";	
					}
					if($fuente_calificada[$i]["conformidad"]==1){
						$checked2="checked";
					}else{
						$checked2="";
					}	 
				}else{
					$logrocritica="";
					$valorcritica="";
					$checked1="";
					$checked2="";
				}
				if($this->session->userdata("tipo_usuario")!=3 || count($registrosCierre)>0){
					$disabled='disabled';
				}else{
					$disabled='';
				}	
					 
				$var = ($i%2!=0)?"row2":"row1";
				$html='<tr class="'.$var.'">';
				$html.='<td align="center">'.$variables[$i]["idvariable"];
					$html.='<input type="hidden" id="variable'.$i.'" name="variable'.$i.'" value="'.$variables[$i]["idvariable"].'"/>';
				$html.='</td>';
				$html.='<td align="rigth">'.utf8_decode($variables[$i]["variable"]).'</td>';
				$html.='<td align="center">';
					$html.=$variables[$i]["peso"];
					$html.='<input type="hidden" id="peso'.$i.'" name="peso'.$i.'" value="'.$variables[$i]["peso"].'"/>';
				$html.='</td>';
				$html.='<td align="center">';
					$html.=$magnitudError[$i];
					$html.='<input type="hidden" id="magerror'.$i.'" name="magerror'.$i.'" value="'.$magnitudError[$i].'"/>';
				$html.='</td>';
				$html.='<td align="center">';
					if($magnitudError[$i]==1){
						$error="33";
					}elseif($magnitudError[$i]==1){
						$error="66";	
					}else{
						$error="100";
					}
					$html.=number_format($error,2,'.','');
					$html.='<input type="hidden" id="error'.$i.'" name="error'.$i.'" value="'.number_format($error,2,'.',',').'" />';
				$html.='</td>';
		  		$html.='<td align="center">';
		  			$html.='<input type="radio" name="conforme'.$i.'" value="0-'.$i.'-'.number_format($error,2,'.','').'-'.$variables[$i]["peso"].'" '.$checked1.' '.$disabled.'> &nbsp; &nbsp; &nbsp;';
		  			$html.='<input type="radio" name="conforme'.$i.'" value="1-'.$i.'-'.number_format($error,2,'.','').'-'.$variables[$i]["peso"].'" '.$checked2.' '.$disabled.'>';
		  		$html.='</td>';
		  		$html.='<td align="center">';
		  			$html.='<div id="divLogro'.$i.'">';
		  				$html.=$logrocritica;
		  				$html.='<input type="hidden" id="logrocritica'.$i.'" name="logrocritica'.$i.'" value="'.$logrocritica.'"/>';
		  			$html.='</div>';
				$html.='</td>';
		  		$html.='<td align="center">';
					$html.='<div id="divValoracion'.$i.'">';
						$html.=$valorcritica;
						$html.='<input type="hidden" id="valorcritica'.$i.'" name="valorcritica'.$i.'" value="'.$valorcritica.'"/>';
					$html.='</div>';
				$html.='</td>';
		  	$html.='</tr>';
		  	echo $html;
		}
		?>	
		</tbody>
		</table>
			<div align="center">Calificaci&oacute;n total fuente: <?php echo $calificacion["calificacion"];?></div>
			<br/>
			<?php
			if($this->session->userdata("tipo_usuario")==3 && count($registrosCierre)==0){ ?>
				<div><input type="hidden" id="idestablecimiento" name="idestablecimiento" value="<?php echo $fuentes_calificar[0]["nro_establecimiento"]; ?>"/></div>
				<div><input type="hidden" id="idfuentes" name="idfuentes" value="<?php echo $fuentes_calificar[0]["idfuentes"]; ?>"/></div>
				<div align="center"><input type="button" id="btnGrabarIndicador" name="btnGrabarIndicador" value="GrabarIndicador" class="button"/></div>
			<!-- input type="button" id="btnBuscarASTT" name="btnBuscarASTT" value="Buscar" class="button"/-->	 
		<?php } ?>
	</form>
	</div>
		
	<?php
	if(isset($calcula_nivelCalidad)){ 
		if($calcula_nivelCalidad=='Mala calidad' || $calcula_nivelCalidad=='Calidad regular'){
			echo "<br><p style='color: red'>".$calcula_nivelCalidad.", acci&oacute;n correctiva:</p>";
			?>
			<form id="frmAccionCorrectiva" name="frmAccionCorrectiva" method="post" action="<?php echo site_url("indicadorcalidad/actualizaAccionCorrectiva"); ?>">
				<div align="center">
					<textarea cols=85 rows=3 id="accionCorrectiva" name="accionCorrectiva"><?php echo $fuentes_calificar[0]["accionCorrectiva"]; ?></textarea> 
				</div>	
				<div><input type="hidden" id="idfuentes" name="idfuentes" value="<?php echo $fuentes_calificar[0]["idfuentes"]; ?>"/></div>
				<input type="button" id="btnAccionCorrectiva" name="btnAccionCorrectiva" value="GrabarAccionCorrectiva" class="button"/></div>
			</form>
			<?php
			if($fuentes_calificar[0]["accionCorrectiva"]!=''){
				echo ("<br><center><<<<a href='javascript:history.back(1)'>Regresar</a></center>");
			}
		}
		else{
			echo ("<br><center><<<<a href='javascript:history.back(1)'>Regresar</a></center>");
		}
	}
	
	
}	 

?>