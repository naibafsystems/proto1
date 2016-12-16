<?php	$style = 'style="color: #FF0000; font-weight: bold;"'; 
/*$variable='<div align="center">';
	$variable.='<table width="75%" class="table" style="font-size: 11px;">';
		$variable.='<thead>';
			$variable.='<tr>';
				$variable.='<th class="row1" colspan="6" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center"><a href="'.site_url("moduloanalisis/generalesRegion/1").'">Establecimientos</a></th>';
				$variable.='<th class="row1" colspan="6" style="border-right: 1px solid #CCCCCC;" align="center"><a href="'.site_url("moduloanalisis/generalesRegion/2").'">Ingresos netos operacionales</a></th>';
				$variable.='<th class="row1" colspan="6" style="border-right: 1px solid #CCCCCC;" align="center"><a href="'.site_url("moduloanalisis/generalesRegion/3").'">Personas Ocupado Total</a></th>';
				$variable.='<th class="row1" colspan="6" style="border-right: 1px solid #CCCCCC;" align="center"><a href="'.site_url("moduloanalisis/generalesRegion/4").'">Camas ofrecidas</a></th>';
				$variable.='<th class="row1" colspan="6" style="border-right: 1px solid #CCCCCC;" align="center"><a href="'.site_url("moduloanalisis/generalesRegion/5").'">Habitaciones ofrecidas</a></th>';
			$variable.='</tr>';
		$variable.='</thead>';
	$variable.='</table>';
$variable.='</div>';*/
$generalesRegion='<div align="center" style="width:inherit; overflow:scroll">';
	$generalesRegion.='<table class="table1" style="font-size: 11px;">';
		$generalesRegion.='<thead>';
			$generalesRegion.='<tr>';
				$generalesRegion.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" rowspan="2">variable / ciudad</th>';
				$generalesRegion.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="3">Establecimientos</th>';
				$generalesRegion.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="3">Participaci&oacute;n % </th>';
				$generalesRegion.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="2">Variaci&oacute;n %</td>';
				$generalesRegion.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="2">Contribuci&oacute;n %</td>';
				$generalesRegion.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="3">Ingresos netos operacionales</th>';
				$generalesRegion.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="3">Participaci&oacute;n % </th>';
				$generalesRegion.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="2">Variaci&oacute;n %</td>';
				$generalesRegion.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="2">Contribuci&oacute;n %</td>';
				$generalesRegion.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="3">Personal ocupado total</th>';
				$generalesRegion.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="3">Participaci&oacute;n % </th>';
				$generalesRegion.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="2">Variaci&oacute;n %</td>';
				$generalesRegion.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="2">Contribuci&oacute;n %</td>';
				$generalesRegion.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="3">Camas ofrecidas</td>';
				$generalesRegion.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="2">Variaci&oacute;n %</td>';
				$generalesRegion.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="3">Habitaciones ofrecidas</td>';
				$generalesRegion.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="2">Variaci&oacute;n %</td>';
				$generalesRegion.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="3">Ingresos por Alojamiento</td>';
				$generalesRegion.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="3">Hu&eacute;spedes residentes y no residentes</td>';
				$generalesRegion.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="3">Camas vendidas</td>';
				$generalesRegion.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="3">Habitaciones vendidas</td>';
				$generalesRegion.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Estancia media</td>';
				$generalesRegion.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="3">Porcentaje de Ocupaci&oacute;n</td>';
			$generalesRegion.='</tr>';
			$generalesRegion.='<tr>';
				//$generalesRegion.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Ciudad</th>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mismo t del año anterior</th>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mes anterior al t </th>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">t=mes de referencia</td>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">t del año anterior</td>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mes anterior al t</td>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">t=mes de referencia</td>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n mensual</td>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n anual</td>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Cont. mensual</td>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Cont. anual</td>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mismo t del año anterior</th>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mes anterior al t </th>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">t=mes de referencia</td>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">t del año anterior</td>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mes anterior al t</td>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">t=mes de referencia</td>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n mensual</td>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n anual</td>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Cont. mensual</td>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Cont. anual</td>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mismo t del año anterior</th>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mes anterior al t </th>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">t=mes de referencia</td>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">t del año anterior</td>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mes anterior al t</td>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">t=mes de referencia</td>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n mensual</td>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n anual</td>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Cont. mensual</td>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Cont. anual</td>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mismo t del año anterior</th>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mes anterior al t </th>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">t=mes de referencia</td>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n mensual</td>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n anual</td>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mismo t del año anterior</th>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mes anterior al t </th>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">t=mes de referencia</td>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n mensual</td>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n anual</td>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n mensual</th>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n anual</th>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Contribuci&oacute;n</td>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n mensual</th>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n anual</th>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Contribuci&oacute;n </td>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n mensual</th>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n anual</th>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Contribuci&oacute;n anual</td>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n mensual</th>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n anual</th>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Contribuci&oacute;n anual</td>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Mes de referencia</td>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mismo t del año anterior</th>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mes anterior al t</th>';
				$generalesRegion.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">t=mes de referencia</td>';
			$generalesRegion.='</tr>';
			
			for($i=0; $i<=count($regiones)-1; $i++){
				$var = ($i%2!=0)?"row2":"row1";
				$id_region=$establec["idRegion".$i];
				// Variación en el número de establecimiento.
				$errEst = $this->analisis->compararRango($varAnualEst[$i],$variacion[$i]);
				
				//Si hay variación de establecimientos hace lo siguiente
				if($errEst){
					//Para comparar variaciones ingresos
					$errIngAnu=$this->analisis->compararRango($varAnualIng[$i],$variacion[$i]);
					if($errIngAnu){
						$varAnualIngr[$i]=number_format(($varAnualIng[$i]),2,',','.');
					}else{
						//$varAnualIngr[$i]="<font color='red'><b>".number_format(($varAnualIng[$i]),2,',','.')."</b>";
						$varAnualIngr[$i]="<font color='red'><b><a href='".site_url("/moduloanalisis/generalesRegion/$id_region")."'>".number_format(($varAnualIng[$i]),2,',','.')."</a></b>";
					}
					$errIngMen=$this->analisis->compararRango($varMensualIng[$i],$variacion[$i]);
					echo $errIngMen;
					if($errIngMen){
						$varMensualIngr[$i]=number_format(($varMensualIng[$i]),2,',','.');
					}else{
						//$varMensualIngr[$i]="<font color='red'><b>".number_format(($varMensualIng[$i]),2,',','.')."</b>";
						$varMensualIngr[$i]="<font color='red'><b><a href='".site_url("/moduloanalisis/generalesRegion/$id_region")."'>".number_format(($varMensualIng[$i]),2,',','.')."</a></b>";
					}
					//Para comparar variaciones personal
					$errPerAnu=$this->analisis->compararRango($varAnualPer[$i],$variacion[$i]);
					if($errPerAnu){
						$varAnualPers[$i]=number_format(($varAnualPer[$i]),2,',','.');
					}else{
						$varAnualPers[$i]="<font color='red'><b>".number_format(($varAnualPer[$i]),2,',','.')."</b>";
					}
					$errPerMen=$this->analisis->compararRango($varMensualPer[$i],$variacion[$i]);
					if($errPerMen){
						$varMensualPers[$i]=number_format(($varMensualPer[$i]),2,',','.');
					}else{
						$varMensualPers[$i]="<font color='red'><b>".number_format(($varMensualPer[$i]),2,',','.')."</b>";
					}
					//Para comparar variaciones camas ofrecidas
					$errCamasAnu=$this->analisis->compararRango($varAnualCam[$i],$variacion[$i]);
					if($errCamasAnu){
						$varAnualCama[$i]=number_format(($varAnualCam[$i]),2,',','.');
					}else{
						$varAnualCama[$i]="<font color='red'><b>".number_format(($varAnualCam[$i]),2,',','.')."</b>";
					}
					$errCamasMen=$this->analisis->compararRango($varMensualCam[$i],$variacion[$i]);
					if($errCamasMen){
						$varMensualCama[$i]=number_format(($varMensualCam[$i]),2,',','.');
					}else{
						$varMensualCama[$i]="<font color='red'><b>".number_format(($varMensualCam[$i]),2,',','.')."</b>";
					}
					//Para comparar variaciones de habitaciones ofrecidas
					$errHabAnu=$this->analisis->compararRango($varAnualHab[$i],$variacion[$i]);
					if($errHabAnu){
						$varAnualHabi[$i]=number_format(($varAnualHab[$i]),2,',','.');
					}else{
						$varAnualHabi[$i]="<font color='red'><b>".number_format(($varAnualHab[$i]),2,',','.')."</b>";
					}
					$errHabMen=$this->analisis->compararRango($varMensualHab[$i],$variacion[$i]);
					if($errHabMen){
						$varMensualHabi[$i]=number_format(($varMensualHab[$i]),2,',','.');
					}else{
						$varMensualHabi[$i]="<font color='red'><b>".number_format(($varMensualHab[$i]),2,',','.')."</b>";
					}
					$varAnualEst[$i]=number_format(($varAnualEst[$i]),2,',','.');
				}else{ //No hay varaciones en los establecimientos
					$varMensualIngr[$i]=number_format(($varMensualIng[$i]),2,',','.');
					$varAnualIngr[$i]=number_format(($varAnualIng[$i]),2,',','.');
					$varAnualEst[$i]=number_format(($varAnualEst[$i]),2,',','.');
					$varAnualPers[$i]=number_format(($varAnualPer[$i]),2,',','.');
					$varMensualPers[$i]=number_format(($varMensualPer[$i]),2,',','.');
					$varAnualCama[$i]=number_format(($varAnualCam[$i]),2,',','.');
					$varMensualCama[$i]=number_format(($varMensualCam[$i]),2,',','.');
					$varAnualHabi[$i]=number_format(($varAnualHab[$i]),2,',','.');
					$varMensualHabi[$i]=number_format(($varMensualHab[$i]),2,',','.');
				}
				
				$generalesRegion.='<tr>';
					//Establecimientos
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center"><a href="'.site_url("/moduloanalisis/generalesRegion/$id_region").'">'.$establec["regional".$i].'</a></td>';
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.$establec["anual".$i].'</td>';
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.$establec["anterior".$i].'</td>';
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.$establec["actual".$i].'</td>';
					@$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($establec["anual".$i]/$establec["anual38"])*100),2,',','.').'</td>';
					@$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($establec["anterior".$i]/$establec["anterior38"])*100),2,',','.').'</td>';
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($establec["actual".$i]/$establec["actual38"])*100),2,',','.').'</td>';
					//Variación establecimientos
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px; " align="center">'.number_format(($varMensualEst[$i]),2,',','.').'</td>';
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px; " align="center">'.$varAnualEst[$i].'</td>';
					//Contribución estableciomientos
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.@number_format((($establec["actual".$i]-$establec["anterior".$i])/($establec["actual38"]-$establec["anterior38"])*($varMensualEst[38])),2,',','.').'</td>';
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($establec["actual".$i]-$establec["anual".$i])/($establec["actual38"]-$establec["anual38"])*($varAnualEst[38])),2,',','.').'</td>';
					//Ingresos
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format($ingresos["anual".$i],0,',','.').'</td>';
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format($ingresos["anterior".$i],0,',','.').'</td>';
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format($ingresos["actual".$i],0,',','.').'</td>';
					@$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($ingresos["anual".$i]/$ingresos["anual38"])*100),2,',','.').'</td>';
					@$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($ingresos["anterior".$i]/$ingresos["anterior38"])*100),2,',','.').'</td>';
					@$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($ingresos["actual".$i]/$ingresos["actual38"])*100),2,',','.').'</td>';
					//Variación ingresos
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.$varMensualIngr[$i].'</td>';
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.$varAnualIngr[$i].'</td>';
					//Contribución Ingresos
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($ingresos["actual".$i]-$ingresos["anterior".$i])/($ingresos["actual38"]-$ingresos["anterior38"])*($varMensualIng[38])),2,',','.').'</td>';
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($ingresos["actual".$i]-$ingresos["anual".$i])/($ingresos["actual38"]-$ingresos["anual38"])*($varAnualIng[38])),2,',','.').'</td>';
					//Personal
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format($personal["anual".$i],0,',','.').'</td>';
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format($personal["anterior".$i],0,',','.').'</td>';
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format($personal["actual".$i],0,',','.').'</td>';
					@$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($personal["anual".$i]/$personal["anual38"])*100),2,',','.').'</td>';
					@$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($personal["anterior".$i]/$personal["anterior38"])*100),2,',','.').'</td>';
					@$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($personal["actual".$i]/$personal["actual38"])*100),2,',','.').'</td>';
					//Variación Personal
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.$varMensualPers[$i].'</td>';
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.$varAnualPers[$i].'</td>';
					//Contribución personal
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($personal["actual".$i]-$personal["anterior".$i])/($personal["actual38"]-$personal["anterior38"])*($varMensualPer[38])),2,',','.').'</td>';
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($personal["actual".$i]-$personal["anual".$i])/($personal["actual38"]-$personal["anual38"])*($varAnualPer[38])),2,',','.').'</td>';
					//Camas ofrecidas
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format($camas["anual".$i],0,',','.').'</td>';
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format($camas["anterior".$i],0,',','.').'</td>';
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format($camas["actual".$i],0,',','.').'</td>';
					//Variación camas ofrecidas
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.$varMensualCama[$i].'</td>';
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.$varAnualCama[$i].'</td>';
					//Habitaciones ofrecidas
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format($habit["anual".$i],0,',','.').'</td>';
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format($habit["anterior".$i],0,',','.').'</td>';
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format($habit["actual".$i],0,',','.').'</td>';
					//Variación habitaciones ofrecidas
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.$varMensualHabi[$i].'</td>';
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.$varAnualHabi[$i].'</td>';
					//variación ingresos por alojamiento
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format(($varMensualInalo[$i]),2,',','.').'</td>';
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format(($varAnualInalo[$i]),2,',','.').'</td>';
					//Contribución ingresos por alojamiento
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.@number_format((($inalo["actual".$i]-$inalo["anual".$i])/($inalo["actual38"]-$inalo["anual38"])*($varAnualInalo[38])),2,',','.').'</td>';
					//Variación huespedes residentes y no residentes
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format(($varMensualHuetot[$i]),2,',','.').'</td>';
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format(($varAnualHuetot[$i]),2,',','.').'</td>';
					//Contribución huespedes residentes y no residentes
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.@number_format((($huetot["actual".$i]-$huetot["anual".$i])/($huetot["actual38"]-$huetot["anual38"])*($varAnualHuetot[38])),2,',','.').'</td>';
					//Variación Camas vendidas
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format(($varMensualIcva[$i]),2,',','.').'</td>';
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format(($varAnualIcva[$i]),2,',','.').'</td>';
					//Contribución Camas vendidas 
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.@number_format((($icva["actual".$i]-$icva["anual".$i])/($icva["actual38"]-$icva["anual38"])*($varAnualIcva[38])),2,',','.').'</td>';
					//Variación habitaciones vendidas
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format(($varMensualIhoa[$i]),2,',','.').'</td>';
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format(($varAnualIhoa[$i]),2,',','.').'</td>';
					//Contribución habitaciones vendidas
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.@number_format((($ihoa["actual".$i]-$ihoa["anual".$i])/($ihoa["actual38"]-$ihoa["anual38"])*($varAnualIhoa[38])),2,',','.').'</td>';
					//Estancia media
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format($estancia["actual".$i],0,',','.').'</td>';
					//Porcentaje de ocupación
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format(($ocupacion["anual".$i]),2,',','.').'</td>';
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format(($ocupacion["anterior".$i]),2,',','.').'</td>';
					$generalesRegion.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format(($ocupacion["actual".$i]),2,',','.').'</td>';
				$generalesRegion.='</tr>';
			}
		$generalesRegion.='</thead>';
	$generalesRegion.='</table>';
$generalesRegion.='</div>';
//echo $variable;
echo $generalesRegion;
?>
<form action="moduloanalisis" method="post" target="_blank" id="FormularioExportacion">
<p align="center">Exportar a Excel<img src="<?php echo base_url("images/export_to_excel.gif"); ?>" class="botonExcel" /></p>
<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
</form>