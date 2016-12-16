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
$generalesEstablec='<div align="center" style="width:inherit; overflow:scroll">';
	$generalesEstablec.='<table class="table1" style="font-size: 11px;">';
		$generalesEstablec.='<thead>';
			$generalesEstablec.='<tr>';
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" rowspan="3">variable / ciudad</th>';
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="2">Establecimientos</th>';
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="10">Ingresos totales</th>';
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="8">Personal ocupado total</th>';
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="5">Ingresos por Alojamiento</td>';
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="5">Hu&eacute;spedes residentes y no residentes</td>';
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="5">Habitaciones vendidas</td>';
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="5">Camas vendidas</td>';
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="5">Tarifa promedio habitaci&oacute;n sencilla</td>';	
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="5">Tarifa promedio habitaci&oacute;n doble</td>';
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="5">Tarifa promedio habitaci&oacute;n tipo suite</td>';
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="5">Tarifa promedio habitaci&oacute;n m&uacute;ltiple</td>';
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="5">Tarifa promedio otro tipo de habitaci&oacute;n</td>';
				
			$generalesEstablec.='</tr>';
			$generalesEstablec.='<tr>';
				//$generalesEstablec.='<th style="border-right: 0px solid #CCCCCC; font-size: 10px;" align="center" rowspan=""></th>';
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="2"></th>';
				//Ingresos totales
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="3">Valores ingresos</th>';
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="3">Participaci&oacute;n % </th>';
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="2">Variaci&oacute;n %</td>';
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="2">Contribuci&oacute;n %</td>';
				//Personal ocupado total
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="3">Valores personal</th>';
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="3">Participaci&oacute;n % </th>';
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="2">Variaci&oacute;n %</td>';
				//Ingresos por Alojamiento
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="3">Participaci&oacute;n %</td>';
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="2">Variaci&oacute;n %</td>';
				
				//Huesperdes residentes y no residentes
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="3">Participaci&oacute;n %</td>';
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="2">Variaci&oacute;n %</td>';
				
				//Habitaciones vendidas
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="3">Participaci&oacute;n %</td>';
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="2">Variaci&oacute;n %</td>';
				
				//Camas vendidas
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="3">Participaci&oacute;n %</td>';
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="2">Variaci&oacute;n %</td>';
				
				//Tarifa promedio habitación sencilla
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="3">Valores</td>';
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="2">Variaci&oacute;n %</td>';
                
				//Tarifa promedio habitación doble
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="3">Valores</td>';
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="2">Variaci&oacute;n %</td>';
				
				//Tarifa promedio habitación tipo suite				
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="3">Valores</td>';
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="2">Variaci&oacute;n %</td>';
				
				//Tarifa promedio habitación multiple				
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="3">Valores</td>';
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="2">Variaci&oacute;n %</td>';
				
				//Tarifa promedio otro tipo de habitación				
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="3">Valores</td>';
				$generalesEstablec.='<th style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center" colspan="2">Variaci&oacute;n %</td>';
				
			$generalesEstablec.='</tr>';
			$generalesEstablec.='<tr>';
				//Establecimientos
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">NORDEST</th>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Nombre </th>';
				//Ingresos totales
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mismo t del año anterior</th>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mes anterior al t </th>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">t=mes de referencia</td>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">t del año anterior</td>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mes anterior al t</td>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">t=mes de referencia</td>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n mensual</td>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n anual</td>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Cont. mensual</td>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Cont. anual</td>';
				//Personal ocupado total
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mismo t del año anterior</th>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mes anterior al t </th>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">t=mes de referencia</td>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">t del año anterior</td>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mes anterior al t</td>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">t=mes de referencia</td>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n mensual</td>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n anual</td>';
				//Ingresos por alonamiento
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mismo t del año anterior</th>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mes anterior al t </th>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">t=mes de referencia</td>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n mensual</th>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n anual</th>';
				
				//Huéspedes residentes y no residentes
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mismo t del año anterior</th>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mes anterior al t </th>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">t=mes de referencia</td>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n mensual</th>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n anual</th>';
				
				//Habitaciones vendidas
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mismo t del año anterior</th>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mes anterior al t </th>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">t=mes de referencia</td>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n mensual</th>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n anual</th>';
				
				//Camas vendidas
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mismo t del año anterior</th>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mes anterior al t </th>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">t=mes de referencia</td>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n mensual</th>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n anual</th>';
				
				//Tarifa promedio habitación sencilla
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mismo t del año anterior</th>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mes anterior al t </th>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">t=mes de referencia</td>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n mensual</th>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n anual</th>';
				
				//Tarifa promedio habitación doble
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mismo t del año anterior</th>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mes anterior al t </th>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">t=mes de referencia</td>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n mensual</th>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n anual</th>';
				
				//Tarifa promedio habitación tipo suite
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mismo t del año anterior</th>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mes anterior al t </th>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">t=mes de referencia</td>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n mensual</th>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n anual</th>';
				
				//Tarifa promedio habitación multiple
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mismo t del año anterior</th>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mes anterior al t </th>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">t=mes de referencia</td>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n mensual</th>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n anual</th>';
				
				//Tarifa promedio otro tipo de habitación	
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mismo t del año anterior</th>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">mes anterior al t </th>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">t=mes de referencia</td>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n mensual</th>';
				$generalesEstablec.='<th class="row2" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">Variaci&oacute;n anual</th>';
				
				
			$generalesEstablec.='</tr>';
			
			$total=count($establecimientosRegional)-1;
			for($i=0; $i<=count($establecimientosRegional)-1; $i++){
				$var = ($i%2!=0)?"row2":"row1";
				
				//Para comparar variaciones ingresos
				$errIngAnu=$this->analisis->compararRango($varAnualIng[$i],$variacion[$i]);
				if($errIngAnu){
					$varAnualIngr[$i]=number_format(($varAnualIng[$i]),2,',','.');
				}else{
					$varAnualIngr[$i]="<font color='red'><b>".number_format(($varAnualIng[$i]),2,',','.')."</b>";
					//$varAnualIng[$i]="<font color='red'><b><a href='".site_url("/indicadorcalidad/fuentesxCritico//")."'>".number_format(($varAnualIng[$i]),2,',','.')."</a></b>";
				}
				$errIngMen=$this->analisis->compararRango($varMensualIng[$i],$variacion[$i]);
				if($errIngMen){
					$varMensualIngr[$i]=number_format(($varMensualIng[$i]),2,',','.');
				}else{
					$varMensualIngr[$i]="<font color='red'><b>".number_format(($varMensualIng[$i]),2,',','.')."</b>";
					//$varMensualIng[$i]="<font color='red'><b><a href='".site_url("/indicadorcalidad/fuentesxCritico//")."'>".number_format(($varMensualIng[$i]),2,',','.')."</a></b>";
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
				
				$generalesEstablec.='<tr>';
					//Establecimientos
					$id_region=$establec["idRegion".$i];
					$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.$establec["regional".$i].'</td>';
					$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.$establecimientosRegional[$i]["nro_establecimiento"].'</td>';
					$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.$establecimientosRegional[$i]["idnomcom"].'</td>';
					//Ingresos
					$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format($ingresos["anual".$i],0,',','.').'</td>';
					$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format($ingresos["anterior".$i],0,',','.').'</td>';
					$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format($ingresos["actual".$i],0,',','.').'</td>';
					
					@$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($ingresos["anual".$i]/$ingresosCiu["anual".$i])*100),2,',','.').'</td>';
					@$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($ingresos["anterior".$i]/$ingresosCiu["anterior".$i])*100),2,',','.').'</td>';
					@$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($ingresos["actual".$i]/$ingresosCiu["actual".$i])*100),2,',','.').'</td>';
					//Variación ingresos
					$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.$varMensualIngr[$i].'</td>';
					$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.$varAnualIngr[$i].'</td>';
					//Contribución Ingresos
					@$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($ingresos["actual".$i]-$ingresos["anterior".$i])/($ingresos["actual38"]-$ingresos["anterior38"])*($varMensualIng[38])),2,',','.').'</td>';
					@$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($ingresos["actual".$i]-$ingresos["anual".$i])/($ingresos["actual38"]-$ingresos["anual38"])*($varAnualIng[38])),2,',','.').'</td>';
					//Personal
					$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format($personal["anual".$i],0,',','.').'</td>';
					$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format($personal["anterior".$i],0,',','.').'</td>';
					$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format($personal["actual".$i],0,',','.').'</td>';
					//Participación
					@$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($personal["anual".$i]/$personalCiudad["anual".$i])*100),2,',','.').'</td>';
					@$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($personal["anterior".$i]/$personalCiudad["anterior".$i])*100),2,',','.').'</td>';
					@$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($personal["actual".$i]/$personalCiudad["actual".$i])*100),2,',','.').'</td>';
					//Variación Personal
					$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.$varMensualPers[$i].'</td>';
					$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.$varAnualPers[$i].'</td>';
					
					//Participación ingresos por alojamiento
					@$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($inalo["anual".$i]/$inaloCiu["anual".$i])*100),2,',','.').'</td>';
					@$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($inalo["anterior".$i]/$inaloCiu["anterior".$i])*100),2,',','.').'</td>';
					@$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($inalo["actual".$i]/$inaloCiu["actual".$i])*100),2,',','.').'</td>';
					
					//variación ingresos por alojamiento
					$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format(($varMensualInalo[$i]),2,',','.').'</td>';
					$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format(($varAnualInalo[$i]),2,',','.').'</td>';
					
					//Participación huespedes residentes y no residentes
					@$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($huetot["anual".$i]/$huetotCiu["anual".$i])*100),2,',','.').'</td>';
					@$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($huetot["anterior".$i]/$huetotCiu["anterior".$i])*100),2,',','.').'</td>';
					@$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($huetot["actual".$i]/$huetotCiu["actual".$i])*100),2,',','.').'</td>';
					
					//Variación huespedes residentes y no residentes
					$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format(($varMensualHuetot[$i]),2,',','.').'</td>';
					$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format(($varAnualHuetot[$i]),2,',','.').'</td>';
					
					//Participación habitaciones vendidas
					@$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($ihoa["anual".$i]/$ihoaCiu["anual".$i])*100),2,',','.').'</td>';
					@$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($ihoa["anterior".$i]/$ihoaCiu["anterior".$i])*100),2,',','.').'</td>';
					@$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($ihoa["actual".$i]/$ihoaCiu["actual".$i])*100),2,',','.').'</td>';
					
					//Variación habitaciones vendidas
					$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format(($varMensualIhoa[$i]),2,',','.').'</td>';
					$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format(($varAnualIhoa[$i]),2,',','.').'</td>';
					
					//Participación camas vendidas
					@$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($icva["anual".$i]/$icvaCiu["anual".$i])*100),2,',','.').'</td>';
					@$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($icva["anterior".$i]/$icvaCiu["anterior".$i])*100),2,',','.').'</td>';
					@$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($icva["actual".$i]/$icvaCiu["actual".$i])*100),2,',','.').'</td>';
					
					//Variación Camas vendidas
					$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format(($varMensualIcva[$i]),2,',','.').'</td>';
					$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format(($varAnualIcva[$i]),2,',','.').'</td>';
					
					//Valores tarifa promedio habitación sencilla
					@$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($thusen["anual".$i])),0,',','.').'</td>';
					@$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($thusen["anterior".$i])),0,',','.').'</td>';
					@$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($thusen["actual".$i])),0,',','.').'</td>';
					
					//Variación tarifa promedio habitación sencilla
					$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format(($varMensualThusen[$i]),2,',','.').'</td>';
					$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format(($varAnualThusen[$i]),2,',','.').'</td>';
					
					//Valores tarifa promedio habitación doble
					@$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($thudob["anual".$i])),0,',','.').'</td>';
					@$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($thudob["anterior".$i])),0,',','.').'</td>';
					@$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($thudob["actual".$i])),0,',','.').'</td>';
						
					//Variación tarifa promedio habitación doble
					$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format(($varMensualThudob[$i]),2,',','.').'</td>';
					$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format(($varAnualThudob[$i]),2,',','.').'</td>';
					
					//Valores tarifa promedio habitación suite
					@$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($thusui["anual".$i])),0,',','.').'</td>';
					@$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($thusui["anterior".$i])),0,',','.').'</td>';
					@$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($thusui["actual".$i])),0,',','.').'</td>';
					
					//Variación tarifa promedio habitación suite
					$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format(($varMensualThusui[$i]),2,',','.').'</td>';
					$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format(($varAnualThusui[$i]),2,',','.').'</td>';
					
					//Valores tarifa promedio habitación multiple				
					@$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($thumult["anual".$i])),0,',','.').'</td>';
					@$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($thumult["anterior".$i])),0,',','.').'</td>';
					@$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($thumult["actual".$i])),0,',','.').'</td>';
						
					//Variación tarifa promedio habitación multiple
					$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format(($varMensualThumult[$i]),2,',','.').'</td>';
					$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format(($varAnualThumult[$i]),2,',','.').'</td>';

					//Valores tarifa promedio otro tipo de habitación	
					@$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($thuotr["anual".$i])),0,',','.').'</td>';
					@$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($thuotr["anterior".$i])),0,',','.').'</td>';
					@$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format((($thuotr["actual".$i])),0,',','.').'</td>';
					
					//Variación tarifa promedio otro tipo de habitación
					$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format(($varMensualThuotr[$i]),2,',','.').'</td>';
					$generalesEstablec.='<td class="'.$var.'" style="border-right: 1px solid #CCCCCC; font-size: 10px;" align="center">'.number_format(($varAnualThuotr[$i]),2,',','.').'</td>';
					
				$generalesEstablec.='</tr>';
			}
		$generalesEstablec.='</thead>';
	$generalesEstablec.='</table>';
$generalesEstablec.='</div>';
//echo $variable;
echo $generalesEstablec;
?>
<form action="moduloanalisis" method="post" target="_blank" id="FormularioExportacion">
<p align="center">Exportar a Excel<img src="<?php echo base_url("images/export_to_excel.gif"); ?>" class="botonExcel" /></p>
<input type="hidden" id="regional" name="regional" value="<?php echo $id_region; ?>" />
<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
</form>