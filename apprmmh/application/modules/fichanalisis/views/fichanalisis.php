<?php	$style = 'style="color: #FF0000; font-weight: bold;"'; 
if($ihoa["varanual"]>0 && $inalo["varanual"]<=0){
?>
	<table width="100%" class="table" style="font-size: 10px">
	<tr>
		<td align="left" style="color: red" width="80%">La variaci&oacute;n de las habitaciones vendidas es mayor a cero, y la variaci&oacute;n de ingresos por alojamiento es menor o igual a cero.</td>
		<td align="center"><a href="javascript:corregirFicha(3,'inalo');" class="redText">Corregir</a></td>
	  	<td align="center"><a href="javascript:justificarFicha(43);">Justificar</a></td>
	</tr>
	</table>
<?php
}
if($ihoa["varanual"]>0 && $icva["varanual"]<=0){
?>
	<table width="100%" class="table" style="font-size: 10px">
	<tr>
		<td align="left" style="color: red" width="80%"> La variaci&oacute;n de las habitaciones vendidas es mayor a cero, y la variaci&oacute;n de camas ocupadas o vendidas es menor o igual a cero.</td>
		<td align="center"><a href="javascript:corregirFicha(4,'icva');" class="redText">Corregir</a></td>
	  	<td align="center"><a href="javascript:justificarFicha(44);">Justificar</a></td>
	</tr>
	</table>
<?php
}
if($ihoa["varanual"]>0 && $huetot["varanual"]<=0){
	?>
	<table width="100%" class="table" style="font-size: 10px">
	<tr>
		<td align="left" style="color: red" width="80%"> La variaci&oacute;n de las habitaciones vendidas es mayor a cero, y la variaci&oacute;n de total hu&eacute;spedes es menor o igual a cero.</td>
		<td align="center"><a href="javascript:corregirFicha(4,'huetot');" class="redText">Corregir</a></td>
	  	<td align="center"><a href="javascript:justificarFicha(45);">Justificar</a></td>
	</tr>
	</table>
<?php
}
if($inalo["varanual"]>0 && $ihoa["varanual"]<=0){
	?>
	<table width="100%" class="table" style="font-size: 10px">
	<tr>
		<td align="left" style="color: red" width="80%"> La variaci&oacute;n de los ingresos por alojamiento es mayor a cero, y la variaci&oacute;n de las habitaciones vendidas es menor o igual a cero.</td>
		<td align="center"><a href="javascript:corregirFicha(4,'ihoa');" class="redText">Corregir</a></td>
	  	<td align="center"><a href="javascript:justificarFicha(46);">Justificar</a></td>
	</tr>
	</table>
<?php
}
if($intio["varanual"]>0 && $pottot["varanual"]<=0){
	?>
	<table width="100%" class="table" style="font-size: 10px">
	<tr>
		<td align="left" style="color: red" width="80%"> La variaci&oacute;n de los ingresos totales es mayor a cero, y la variaci&oacute;n del total personal es menor o igual a cero.</td>
		<td align="center"><a href="javascript:corregirFicha(2,'pottot');" class="redText">Corregir</a></td>
	  	<td align="center"><a href="javascript:justificarFicha(47);">Justificar</a></td>
	</tr>
	</table>
<?php
}
if($ihoa["varanual"]<=0 && $inalo["varanual"]>0){
	?>
	<table width="100%" class="table" style="font-size: 10px">
	<tr>
		<td align="left" style="color: red" width="80%"> La variaci&oacute;n de las habitaciones vendidas es menor a cero, y la variaci&oacute;n de ingresos por alojamiento es mayor o igual a cero.</td>
		<td align="center"><a href="javascript:corregirFicha(4,'ihoa');" class="redText">Corregir</a></td>
	  	<td align="center"><a href="javascript:justificarFicha(48);">Justificar</a></td>
	</tr>
	</table>
<?php
}
if($ihoa["varanual"]<=0 && $icva["varanual"]>0){
	?>
	<table width="100%" class="table" style="font-size: 10px">
	<tr>
		<td align="left" style="color: red" width="80%"> La variaci&oacute;n de las habitaciones vendidas es menor a cero, y la variaci&oacute;n de camas ocupadas o vendidas es mayor o igual a cero.</td>
		<td align="center"><a href="javascript:corregirFicha(4,'ihoa');" class="redText">Corregir</a></td>
	  	<td align="center"><a href="javascript:justificarFicha(49);">Justificar</a></td>
	</tr>
	</table>
<?php
}
if($ihoa["varanual"]<=0 && $huetot["varanual"]>0){
	?>
	<table width="100%" class="table" style="font-size: 10px">
	<tr>
		<td align="left" style="color: red" width="80%"> La variaci&oacute;n de las habitaciones vendidas es menor a cero, y la variación de total hu&eacute;spedes es mayor o igual a cero.</td>
		<td align="center"><a href="javascript:corregirFicha(4,'ihoa');" class="redText">Corregir</a></td>
	  	<td align="center"><a href="javascript:justificarFicha(50);">Justificar</a></td>
	</tr>
	</table>
<?php
}
if($inalo["varanual"]<=0 && $ihoa["varanual"]>0){
	?>
	<table width="100%" class="table" style="font-size: 10px">
	<tr>
		<td align="left" style="color: red" width="80%">  La variaci&oacute;n de los ingresos por alojamiento es menor a cero, y la variaci&oacute;n de las habitaciones vendidas es mayor o igual a cero.</td>
		<td align="center"><a href="javascript:corregirFicha(3,'inalo');" class="redText">Corregir</a></td>
	  	<td align="center"><a href="javascript:justificarFicha(51);">Justificar</a></td>
	</tr>
	</table>
<?php
}
if($intio["varanual"]<=0 && $pottot["varanual"]>0){
	?>
	<table width="100%" class="table" style="font-size: 10px">
	<tr>
		<td align="left" style="color: red" width="80%"> La variaci&oacute;n de los ingresos totales es menor a cero, y la variaci&oacute;n del total personal es mayor o igual a cero.</td>
		<td align="center"><a href="javascript:corregirFicha(3,'intio');" class="redText">Corregir</a></td>
	  	<td align="center"><a href="javascript:justificarFicha(52);">Justificar</a></td>
	</tr>
	</table>
<?php
}
?>
<br>
<h3>Ingresos netos operacionales causados en el mes</h3>
<form id="frmFichaAnalisis" name="frmFichaAnalisis" method="post" action="<?php echo site_url("fichanalisis/validarEnvio"); ?>">
<table width="100%" class="table" style="font-size: 10px">
<thead class="thead">
<tr>
  <th>&nbsp;</th>
  <th width="7%" align="center">Actual</th>
  <th width="7%" align="center">Anterior</th>
  <th width="7%" align="center">Anual</th>
  <th width="7%" align="center">Variaci&oacute;n Mensual</th>
  <th width="7%" align="center">Variaci&oacute;n Anual</th>
  <th colspan="2" width="14%" align="center">Acci&oacute;n</th>  
</tr>
</thead>
<tbody>
<tr>
  <td align="left">Alojamiento (INALO)</td>
  <td align="center"><?php echo number_format($inalo["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($inalo["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($inalo["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($inalo["err1"]){ echo $style; } ?>><?php echo number_format($inalo["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($inalo["err2"]){ echo $style; } ?>><?php echo number_format($inalo["varanual"],2,',','.'); ?></td>
  <?php if (($inalo["err1"])||($inalo["err2"])){  ?>
  		<td align="center"><a href="javascript:corregirFicha(3,'inalo');" class="redText">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(1);">Justificar</a></td>
  <?php } 
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td>
  <?php } ?>      		
</tr>
<tr class="row2">
  <td align="left">Servicios de alimentos y bebidas no alcoh&oacute;licas no incluidos en alojamiento (INALI)</td>
  <td align="center"><?php echo number_format($inali["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($inali["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($inali["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($inali["err1"]){ echo $style; } ?>><?php echo number_format($inali["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($inali["err2"]){ echo $style; } ?>><?php echo number_format($inali["varanual"],2,',','.'); ?></td>
  <?php if (($inali["err1"])||($inali["err2"])){  ?>
  		<td align="center"><a href="javascript:corregirFicha(3,'inali');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(2);">Justificar</a></td>
  <?php }
  		else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php } ?>
</tr>
<tr>
  <td align="left">Servicios de bebidas alcoh&oacute;licas y cigarrillos, no incluidos en alojamiento (INBA)</td>
  <td align="center"><?php echo number_format($inba["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($inba["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($inba["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($inba["err1"]){ echo $style; } ?>><?php echo number_format($inba["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($inba["err2"]){ echo $style; } ?>><?php echo number_format($inba["varanual"],2,',','.'); ?></td>
  <?php if (($inba["err1"])||($inba["err2"])){  ?>
  		<td align="center"><a href="javascript:corregirFicha(3,'inba');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(3);">Justificar</a></td>
  <?php }
  		else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php } ?>
</tr>
<tr>
  <td align="left"> Servicios receptivos (city tours, guías turísticos y servicios similares) (INSR)</td>
  <td align="center"><?php echo number_format($insr["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($insr["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($insr["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($insr["err1"]){ echo $style; } ?>><?php echo number_format($insr["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($insr["err2"]){ echo $style; } ?>><?php echo number_format($insr["varanual"],2,',','.'); ?></td>
  <?php if (($insr["err1"])||($insr["err2"])){  ?>
  		<td align="center"><a href="javascript:corregirFicha(3,'inba');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(3);">Justificar</a></td>
  <?php }
  		else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php } ?>
</tr>
<tr class="row2">
  <td align="left">Alquiler de salones y/o apoyo en la organizaci&oacute;n de eventos (INOE)</td>
  <td align="center"><?php echo number_format($inoe["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($inoe["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($inoe["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($inoe["err1"]){ echo $style; } ?>><?php echo number_format($inoe["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($inoe["err2"]){ echo $style; } ?>><?php echo number_format($inoe["varanual"],2,',','.'); ?></td>
  <?php if (($inoe["err1"])||($inoe["err2"])){ ?>
  		<td align="center"><a href="javascript:corregirFicha(3,'inoe');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(4);">Justificar</a></td>
  <?php }
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php } ?>  
</tr>
<tr>
  <td align="left">Otros ingresos netos operacionales (INOIO)</td>
  <td align="center"><?php echo number_format($inoio["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($inoio["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($inoio["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($inoio["err1"]){ echo $style; } ?>><?php echo number_format($inoio["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($inoio["err2"]){ echo $style; } ?>><?php echo number_format($inoio["varanual"],2,',','.'); ?></td>
  <?php if (($inoio["err1"])||($inoio["err2"])){ ?>
  		<td align="center"><a href="javascript:corregirFicha(3,'inoio');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(5);">Justificar</a></td>
  <?php }
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php } ?>
</tr>
<tr class="row2">
  <td align="left">Total de ingresos netos operacionales (INTIO)</td>
  <td align="center"><?php echo number_format($intio["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($intio["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($intio["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($intio["err1"]){ echo $style; } ?>><?php echo number_format($intio["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($intio["err2"]){ echo $style; } ?>><?php echo number_format($intio["varanual"],2,',','.'); ?></td>
  <?php if (($intio["err1"])||($intio["err2"])){ ?>
  		<td align="center"><a href="javascript:corregirFicha(3,'intio');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(6);">Justificar</a></td>
  <?php }
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php } ?>
</tr>
</tbody>
</table>
<br/>
<h3>Personal ocupado promedio y salarios causados en el mes</h3>
<table width="100%" class="table" style="font-size: 10px;">
<thead class="thead">
<tr>
  <th>&nbsp;</th>
  <th width="7%" align="center">Actual</th>
  <th width="7%" align="center">Anterior</th>
  <th width="7%" align="center">Anual</th>
  <th width="7%" align="center">Variaci&oacute;n Mensual</th>
  <th width="7%" align="center">Variaci&oacute;n Anual</th>
  <th colspan="2" width="14%" align="center">Acci&oacute;n</th>  
</tr>
</thead>
<tbody>
<tr>
  <td align="left">Personal ocupado promedio (POTTOT)</td>
  <td align="center"><?php echo number_format($pottot["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($pottot["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($pottot["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($pottot["err1"]){ echo $style; } ?>><?php echo number_format($pottot["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($pottot["err2"]){ echo $style; } ?>><?php echo number_format($pottot["varanual"],2,',','.'); ?></td>
  <?php if (($pottot["err1"])||($pottot["err2"])){ ?>
  		<td align="center"><a href="javascript:corregirFicha(2,'pottot');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(7);">Justificar</a></td>
  <?php }
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php } ?>
</tr>
<tr class="row2">
  <td align="left">Propietarios, socios y  familiares sin remuneraci&oacute;n fija (POTPSFR)</td>
  <td align="center"><?php echo number_format($potpsfr["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($potpsfr["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($potpsfr["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($potpsfr["err1"]){ echo $style; } ?>><?php echo number_format($potpsfr["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($potpsfr["err2"]){ echo $style; } ?>><?php echo number_format($potpsfr["varanual"],2,',','.'); ?></td>
  <?php if (($potpsfr["err1"])||($potpsfr["err2"])){ ?>
  		<td align="center"><a href="javascript:corregirFicha(2,'potpsfr');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(8);">Justificar</a></td>
  <?php } 
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php } ?>		
</tr>
<tr>
  <td align="left">Personal permanente (POTPERM)</td>
  <td align="center"><?php echo number_format($potperm["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($potperm["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($potperm["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($potperm["err1"]){ echo $style; } ?>><?php echo number_format($potperm["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($potperm["err2"]){ echo $style; } ?>><?php echo number_format($potperm["varanual"],2,',','.'); ?></td>
  <?php if (($potperm["err1"])||($potperm["err2"])){ ?>
  		<td align="center"><a href="javascript:corregirFicha(2,'potperm');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(9);">Justificar</a></td>
  <?php }
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php } ?>
</tr>
<tr class="row2">
  <td align="left">Sueldos y salarios permanente (GPPER)</td>
  <td align="center"><?php echo number_format($gpper["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($gpper["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($gpper["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($gpper["err1"]){ echo $style; } ?>><?php echo number_format($gpper["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($gpper["err2"]){ echo $style; } ?>><?php echo number_format($gpper["varanual"],2,',','.'); ?></td>
  <?php if (($gpper["err1"])||($gpper["err2"])){ ?>
  		<td align="center"><a href="javascript:corregirFicha(2,'gpper');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(10);">Justificar</a></td>
  <?php }
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php } ?>
</tr>
<tr>
  <td align="left">Salario perc&aacute;pita personal permanente</td>
  <td align="center"><?php echo number_format($salpper["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($salpper["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($salpper["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($salpper["err1"]){ echo $style; } ?>><?php echo number_format($salpper["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($salpper["err2"]){ echo $style; } ?>><?php echo number_format($salpper["varanual"],2,',','.'); ?></td>
  <?php if (($salpper["err1"])||($salpper["err2"])){ ?>
  		<td align="center"><a href="javascript:corregirFicha(2,'');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(11);">Justificar</a></td>
  <?php }
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php } ?>  		
</tr>
<tr class="row2">
  <td align="left">Temporal contratado directamente (POTTCDE)</td>
  <td align="center"><?php echo number_format($pottcde["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($pottcde["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($pottcde["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($pottcde["err1"]){ echo $style; } ?>><?php echo number_format($pottcde["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($pottcde["err2"]){ echo $style; } ?>><?php echo number_format($pottcde["varanual"],2,',','.'); ?></td>
  <?php if (($pottcde["err1"])||($pottcde["err2"])){ ?>
  		<td align="center"><a href="javascript:corregirFicha(2,'pottcde');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(12);">Justificar</a></td>
  <?php } 
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php } ?>		
</tr>
<tr>
  <td align="left">Sueldos y salarios temporal directo (GPSSDE)</td>
  <td align="center"><?php echo number_format($gpssde["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($gpssde["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($gpssde["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($gpssde["err1"]){ echo $style; } ?>><?php echo number_format($gpssde["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($gpssde["err2"]){ echo $style; } ?>><?php echo number_format($gpssde["varanual"],2,',','.'); ?></td>
  <?php if (($gpssde["err1"])||($gpssde["err2"])){ ?>
  		<td align="center"><a href="javascript:corregirFicha(2,'gpssde');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(13);">Justificar</a></td>
  <?php } 
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php } ?>		
</tr>
<tr class="row2">
  <td align="left">Salario perc&aacute;pita temporal directo</td>
  <td align="center"><?php echo number_format($saltdir["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($saltdir["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($saltdir["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($saltdir["err1"]){ echo $style; } ?>><?php echo number_format($saltdir["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($saltdir["err2"]){ echo $style; } ?>><?php echo number_format($saltdir["varanual"],2,',','.'); ?></td>
  <?php if (($saltdir["err1"])||($saltdir["err2"])){ ?>
  		<td align="center"><a href="javascript:corregirFicha(2,'');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(14);">Justificar</a></td>
  <?php }
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php } ?>
</tr>
<tr>
  <td align="left">Temporales suministrados por otras empresas (POTTCAG)</td>
  <td align="center"><?php echo number_format($pottcag["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($pottcag["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($pottcag["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($pottcag["err1"]){ echo $style; } ?>><?php echo number_format($pottcag["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($pottcag["err2"]){ echo $style; } ?>><?php echo number_format($pottcag["varanual"],2,',','.'); ?></td>
  <?php if (($pottcag["err1"])||($pottcag["err2"])){ ?>
  		<td align="center"><a href="javascript:corregirFicha(2,'pottcag');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(15);">Justificar</a></td>
  <?php }
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php } ?>		
</tr>
<tr class="row2">
  <td align="left">Sueldos y salarios temporal suministrado (GPPTA)</td>
  <td align="center"><?php echo number_format($gpppta["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($gpppta["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($gpppta["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($gpppta["err1"]){ echo $style; } ?>><?php echo number_format($gpppta["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($gpppta["err2"]){ echo $style; } ?>><?php echo number_format($gpppta["varanual"],2,',','.'); ?></td>
  <?php if (($gpppta["err1"])||($gpppta["err2"])){ ?>
  		<td align="center"><a href="javascript:corregirFicha(2,'gppta');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(16);">Justificar</a></td>
  <?php } 
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php } ?>		
</tr>
<tr>
  <td align="left">Salario perc&aacute;pita temporal suministrado</td>
  <td align="center"><?php echo number_format($saltsum["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($saltsum["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($saltsum["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($saltsum["err1"]){ echo $style; } ?>><?php echo number_format($saltsum["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($saltsum["err2"]){ echo $style; } ?>><?php echo number_format($saltsum["varanual"],2,',','.'); ?></td>
  <?php if (($saltsum["err1"])||($saltsum["err2"])){ ?>
  		<td align="center"><a href="javascript:corregirFicha(2,'');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(17);">Justificar</a></td>
  <?php }
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php } ?>	
</tr>
<tr class="row2">
  <td align="left">Personal aprendiz (POTPAU)</td>
  <td align="center"><?php echo number_format($potpau["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($potpau["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($potpau["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($potpau["err1"]){ echo $style; } ?>><?php echo number_format($potpau["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($potpau["err2"]){ echo $style; } ?>><?php echo number_format($potpau["varanual"],2,',','.'); ?></td>
  <?php if (($potpau["err1"])||($potpau["err2"])){ ?>
  		<td align="center"><a href="javascript:corregirFicha(2,'potpau');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(18);">Justificar</a></td>
  <?php } 
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php } ?>		
</tr>
<tr>
  <td align="left">Sueldos y salarios aprendices (GPPGPA)</td>
  <td align="center"><?php echo number_format($gppgpa["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($gppgpa["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($gppgpa["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($gppgpa["err1"]){ echo $style; } ?>><?php echo number_format($gppgpa["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($gppgpa["err2"]){ echo $style; } ?>><?php echo number_format($gppgpa["varanual"],2,',','.'); ?></td>
  <?php if (($gppgpa["err1"])||($gppgpa["err2"])){ ?>
  		<td align="center"><a href="javascript:corregirFicha(2,'gppgpa');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(19);">Justificar</a></td>
  <?php } 
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php } ?>		
</tr>
<tr class="row2">
  <td align="left">Salario perc&aacute;pita personal aprendiz</td>
  <td align="center"><?php echo number_format($salpapre["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($salpapre["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($salpapre["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($salpapre["err1"]){ echo $style; } ?>><?php echo number_format($salpapre["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($salpapre["err2"]){ echo $style; } ?>><?php echo number_format($salpapre["varanual"],2,',','.'); ?></td>
  <?php if (($salpapre["err1"])||($salpapre["err2"])){ ?>
  		<td align="center"><a href="javascript:corregirFicha(2,'');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(20);">Justificar</a></td>
  <?php } 
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php } ?>		
</tr>
<tr>
  <td align="left">Total sueldos y salarios del personal ocupado (GPSSPOT)</td>
  <td align="center"><?php echo number_format($gpsspot["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($gpsspot["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($gpsspot["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($gpsspot["err1"]){ echo $style; } ?>><?php echo number_format($gpsspot["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($gpsspot["err2"]){ echo $style; } ?>><?php echo number_format($gpsspot["varanual"],2,',','.'); ?></td>
  <?php if (($gpsspot["err1"])||($gpsspot["err2"])){ ?>
  		<td align="center"><a href="javascript:corregirFicha(2,'gpsspot');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(21);">Justificar</a></td>
  <?php } 
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php } ?>		
</tr>
<tr class="row2">
  <td align="left">Salario total ingresos</td>
  <td align="center"><?php echo number_format($saltoting["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($saltoting["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($saltoting["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($saltoting["err1"]){ echo $style; } ?>><?php echo number_format($saltoting["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($saltoting["err2"]){ echo $style; } ?>><?php echo number_format($saltoting["varanual"],2,',','.'); ?></td>
  <?php if (($saltoting["err1"])||($saltoting["err2"])){ ?>
  		<td align="center"><a href="javascript:corregirFicha(2,'');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(22);">Justificar</a></td>
  <?php } 
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php } ?>		
</tr>


<?php 
/****
<tr>
  <td align="left">N&uacute;mero de establecimientos iniciales (ESINI)</td>
  <td align="center"><?php echo number_format($esini["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($esini["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($esini["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($esini["err1"]){ echo $style; } ?>><?php echo number_format($esini["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($esini["err2"]){ echo $style; } ?>><?php echo number_format($esini["varanual"],2,',','.'); ?></td>
  <?php if (($esini["err1"])||($esini["err2"])){ ?>
  		<td align="center"><a href="javascript:corregirFicha(2,'esini');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(23);">Justificar</a></td>
  <?php } 
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php } ?>		
</tr>
****/
?>
<?php 
/****
<tr class="row2">
  <td align="left">N&uacute;mero de establecimientos abiertos en el mes (ESAPE)</td>
  <td align="center"><?php echo number_format($esape["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($esape["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($esape["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($esape["err1"]){ echo $style; } ?>><?php echo number_format($esape["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($esape["err2"]){ echo $style; } ?>><?php echo number_format($esape["varanual"],2,',','.'); ?></td>
  <?php if (($esape["err1"])||($esape["err2"])){ ?>
  		<td align="center"><a href="javascript:corregirFicha(2,'esape');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(24);">Justificar</a></td>
  <?php } 
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php } ?>		
</tr>
****/
?>
<?php 
/****
<tr>
  <td align="left">N&uacute;mero de establecimientos cerrrados en el mes (ESCI)</td>
  <td align="center"><?php echo number_format($escie["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($escie["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($escie["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($escie["err1"]){ echo $style; } ?>><?php echo number_format($escie["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($escie["err2"]){ echo $style; } ?>><?php echo number_format($escie["varanual"],2,',','.'); ?></td>
  <?php if (($escie["err1"])||($escie["err2"])){ ?>
  		<td align="center"><a href="javascript:corregirFicha(2,'escie');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(25);">Justificar</a></td>
  <?php } 
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php } ?>		
</tr>
****/
?>
<?php /****
<tr class="row2">
  <td align="left">Total n&uacute;mero de establecimientos en el mes (ESTOT)</td>
  <td align="center"><?php echo number_format($estot["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($estot["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($estot["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($estot["err1"]){ echo $style; } ?>><?php echo number_format($estot["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($estot["err2"]){ echo $style; } ?>><?php echo number_format($estot["varanual"],2,',','.'); ?></td>
  <?php if (($estot["err1"])||($estot["err2"])){ ?>
  		<td align="center"><a href="javascript:corregirFicha(2,'estot');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(26);">Justificar</a></td>
  <?php } 
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php } ?>		
</tr>
****/
?>
</tbody>
</table>
<br/>
<h3>Caracter&iacute;sticas de la actividad de alojamiento</h3>
<table width="100%" class="table" style="font-size: 10px;">
<thead class="thead" >
<tr>
  <th>&nbsp;</th>
  <th width="7%" align="left">Actual</th>
  <th width="7%" align="center">Anterior</th>
  <th width="7%" align="center">Anual</th>
  <th width="7%" align="center">Variaci&oacute;n Mensual</th>
  <th width="7%" align="center">Variaci&oacute;n Anual</th>
  <th colspan="2" width="14%" align="center">Acci&oacute;n</th>  
</tr>
</thead>
<tbody>
<tr class="row1">
  <td align="left">Habitaciones ofrecidas (IHDO).</td>
  <td align="center"><?php echo number_format($ihdo["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($ihdo["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($ihdo["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($ihdo["err1"]){ echo $style; } ?>><?php echo number_format($ihdo["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($ihdo["err2"]){ echo $style; } ?>><?php echo number_format($ihdo["varanual"],2,',','.'); ?></td>
  <?php if (($ihdo["err1"])||($ihdo["err2"])){  ?>
  		<td align="center"><a href="javascript:corregirFicha(4,'ihdo');" class="redText">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(23);">Justificar</a></td>
  <?php } 
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td>
  <?php } ?>      		
</tr>
<tr class="row2">
  <td align="left">Camas ofrecidas (ICDA).</td>
  <td align="center"><?php echo number_format($icda["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($icda["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($icda["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($icda["err1"]){ echo $style; } ?>><?php echo number_format($icda["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($icda["err2"]){ echo $style; } ?>><?php echo number_format($icda["varanual"],2,',','.'); ?></td>
  <?php if (($icda["err1"])||($icda["err2"])){  ?>
  		<td align="center"><a href="javascript:corregirFicha(4,'icda');" class="redText">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(24);">Justificar</a></td>
  <?php } 
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td>
  <?php } ?>      		
</tr>
<tr class="row1">
  <td align="left">Habitaciones ocupadas o vendidas (IHOA).</td>
  <td align="center"><?php echo number_format($ihoa["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($ihoa["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($ihoa["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($ihoa["err1"]){ echo $style; } ?>><?php echo number_format($ihoa["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($ihoa["err2"]){ echo $style; } ?>><?php echo number_format($ihoa["varanual"],2,',','.'); ?></td>
  <?php if (($ihoa["err1"])||($ihoa["err2"])){  ?>
  		<td align="center"><a href="javascript:corregirFicha(4,'ihoa');" class="redText">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(25);">Justificar</a></td>
  <?php } 
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td>
  <?php } ?>      		
</tr>
<tr class="row2">
  <td align="left">Camas ocupadas o vendidas (ICVA).</td>
  <td align="center"><?php echo number_format($icva["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($icva["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($icva["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($icva["err1"]){ echo $style; } ?>><?php echo number_format($icva["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($icva["err2"]){ echo $style; } ?>><?php echo number_format($icva["varanual"],2,',','.'); ?></td>
  <?php if (($icva["err1"])||($icva["err2"])){  ?>
  		<td align="center"><a href="javascript:corregirFicha(4,'icva');" class="redText">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(26);">Justificar</a></td>
  <?php } 
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td>
  <?php } ?>      		
</tr>
<tr class="row1">
  <td align="left">Hu&eacute;spedes Residentes (IHPN).</td>
  <td align="center"><?php echo number_format($ihpn["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($ihpn["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($ihpn["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($ihpn["err1"]){ echo $style; } ?>><?php echo number_format($ihpn["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($ihpn["err2"]){ echo $style; } ?>><?php echo number_format($ihpn["varanual"],2,',','.'); ?></td>
  <?php if (($ihpn["err1"])||($ihpn["err2"])){  ?>
  		<td align="center"><a href="javascript:corregirFicha(4,'ihpn');" class="redText">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(27);">Justificar</a></td>
  <?php } 
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td>
  <?php } ?>      		
</tr>
<tr class="row2">
  <td align="left">Hu&eacute;spedes No Residentes (IHPNR).</td>
  <td align="center"><?php echo number_format($ihpnr["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($ihpnr["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($ihpnr["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($ihpnr["err1"]){ echo $style; } ?>><?php echo number_format($ihpnr["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($ihpnr["err2"]){ echo $style; } ?>><?php echo number_format($ihpnr["varanual"],2,',','.'); ?></td>
  <?php if (($ihpnr["err1"])||($ihpnr["err2"])){  ?>
  		<td align="center"><a href="javascript:corregirFicha(4,'ihpnr');" class="redText">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(28);">Justificar</a></td>
  <?php } 
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td>
  <?php } ?>      		
</tr>
<tr class="row1">
  <td align="left">Tarifa promedio por tipo de acomodaci&oacute;n doble (THUDOB).</td>
  <td align="center"><?php echo number_format($thudob["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($thudob["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($thudob["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($thudob["err1"]){ echo $style; } ?>><?php echo number_format($thudob["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($thudob["err2"]){ echo $style; } ?>><?php echo number_format($thudob["varanual"],2,',','.'); ?></td>
  <?php if (($thusen["err1"])||($thudob["err2"])){  ?>
  		<td align="center"><a href="javascript:corregirFicha(4,'thudob');" class="redText">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(29);">Justificar</a></td>
  <?php } 
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td>
  <?php } ?>      		
</tr>
<tr class="row2">
  <td align="left">Tarifa promedio por tipo de acomodaci&oacute;n sencilla (THUSEN).</td>
  <td align="center"><?php echo number_format($thusen["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($thusen["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($thusen["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($thusen["err1"]){ echo $style; } ?>><?php echo number_format($thusen["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($thusen["err2"]){ echo $style; } ?>><?php echo number_format($thusen["varanual"],2,',','.'); ?></td>
  <?php if (($thusen["err1"])||($thusen["err2"])){  ?>
  		<td align="center"><a href="javascript:corregirFicha(4,'thusen');" class="redText">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(30);">Justificar</a></td>
  <?php } 
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td>
  <?php } ?>      		
</tr>
<!-- tr class="row1">
  <td align="left">Tarifa promedio por tipo de acomodaci&oacute;n doble (THUDOB).</td>
  <td align="center"><?php //echo number_format($thudob["actual"],2,',','.'); ?></td>
  <td align="center"><?php //echo number_format($thudob["anterior"],2,',','.'); ?></td>
  <td align="center"><?php //echo number_format($thudob["anual"],2,',','.'); ?></td>
  <td align="center" <?php //if ($thudob["err1"]){ echo $style; } ?>><?php echo number_format($thudob["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php //if ($thudob["err2"]){ echo $style; } ?>><?php echo number_format($thudob["varanual"],2,',','.'); ?></td>
  <?php //if (($thusen["err1"])||($thudob["err2"])){  ?>
  		<td align="center"><a href="javascript:corregirFicha(4,'thudob');" class="redText">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(31);">Justificar</a></td>
  <?php //} 
        //else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td>
  <?php // } ?>      		
</tr-->
<tr class="row1">
  <td align="left">Tarifa promedio por acomodaci&oacute;n tipo suite (THUSUI).</td>
  <td align="center"><?php echo number_format($thusui["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($thusui["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($thusui["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($thusui["err1"]){ echo $style; } ?>><?php echo number_format($thusui["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($thusui["err2"]){ echo $style; } ?>><?php echo number_format($thusui["varanual"],2,',','.'); ?></td>
  <?php if (($thusen["err1"])||($thusui["err2"])){  ?>
  		<td align="center"><a href="javascript:corregirFicha(4,'thusui');" class="redText">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(32);">Justificar</a></td>
  <?php } 
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td>
  <?php } ?>      		
</tr>
<tr class="row2">
  <td align="left">Tarifa promedio por tipo de acomodaci&oacute;n multiple (THUMULT).</td>
  <td align="center"><?php echo number_format($thumult["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($thumult["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($thumult["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($thumult["err1"]){ echo $style; } ?>><?php echo number_format($thumult["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($thumult["err2"]){ echo $style; } ?>><?php echo number_format($thumult["varanual"],2,',','.'); ?></td>
  <?php if (($thusen["err1"])||($thumult["err2"])){  ?>
  		<td align="center"><a href="javascript:corregirFicha(4,'thumult');" class="redText">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(33);">Justificar</a></td>
  <?php } 
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td>
  <?php } ?>      		
</tr>
<tr class="row1">
  <td align="left">Tarifa promedio por otro tipo de acomodaci&oacute;n (THUOTR).</td>
  <td align="center"><?php echo number_format($thuotr["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($thuotr["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($thuotr["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($thuotr["err1"]){ echo $style; } ?>><?php echo number_format($thuotr["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($thuotr["err2"]){ echo $style; } ?>><?php echo number_format($thuotr["varanual"],2,',','.'); ?></td>
  <?php if (($thusen["err1"])||($thuotr["err2"])){  ?>
  		<td align="center"><a href="javascript:corregirFicha(4,'thuotr');" class="redText">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(34);">Justificar</a></td>
  <?php } 
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td>
  <?php } ?>      		
</tr>
<tr class="row2">
  <td align="left">Ingresos perc&aacute;pita producidos.</td>
  <td align="center"><?php echo number_format($ingperprod["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($ingperprod["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($ingperprod["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($ingperprod["err1"]){ echo $style; } ?>><?php echo number_format($ingperprod["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($ingperprod["err2"]){ echo $style; } ?>><?php echo number_format($ingperprod["varanual"],2,',','.'); ?></td>
  <?php if (($ingperprod["err1"])||($ingperprod["err2"])){ ?>
  		<td align="center"><a href="javascript:corregirFicha(3,'');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(35);">Justificar</a></td>
  <?php } 
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php } ?>		
</tr>
<!-- tr class="row2">
  <td align="left">Ingresos Vs. Salarios</td>
  <td align="center"><?php //echo number_format($ingvssal["actual"],2,',','.'); ?></td>
  <td align="center"><?php //echo number_format($ingvssal["anterior"],2,',','.'); ?></td>
  <td align="center"><?php //echo number_format($ingvssal["anual"],2,',','.'); ?></td>
  <td align="center" <?php //if ($ingvssal["err1"]){ echo $style; } ?>><?php //echo number_format($ingvssal["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php //if ($ingvssal["err2"]){ echo $style; } ?>><?php //echo number_format($ingvssal["varanual"],2,',','.'); ?></td>
  <?php //if (($ingvssal["err1"])||($ingvssal["err2"])){ ?>
  		<td align="center"><a href="javascript:corregirFicha(3,'');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(28);">Justificar</a></td>
  <?php //} 
        //else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php //} ?>		
</tr-->
<tr class="row1">
  <td align="left">Estancia media (Eme).</td>
  <td align="center"><?php echo number_format($estmedia["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($estmedia["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($estmedia["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($estmedia["err1"]){ echo $style; } ?>><?php echo number_format($estmedia["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($estmedia["err2"]){ echo $style; } ?>><?php echo number_format($estmedia["varanual"],2,',','.'); ?></td>
  <?php if (($estmedia["err1"])||($estmedia["err2"])){ ?>
  		<td align="center"><a href="javascript:corregirFicha(4,'');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(36);">Justificar</a></td>
  <?php } 
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php } ?>		
</tr>
<!-- tr class="row1">
  <td align="left">Estancia media (Eme)</td>
  
  <td align="center" <?php //if ($estmedia2["err1"]){ echo $style; } ?>><?php //echo number_format($estmedia2["actual"],2,',','.'); ?></td>
  <?php /* 
        Se comenta esta linea para el primer periodo (Removerla para el segundo), Remover la linea anterior 
        <td align="center" <?php if ($estmedia2["err1"]){ echo $style; } ?>><?php echo number_format($estmedia2["actual"],2,',','.'); ?></td>
        */
  ?>
  <td align="center"><?php //echo number_format($estmedia2["anterior"],2,',','.'); ?></td>
  <td align="center"><?php //echo number_format($estmedia2["anual"],2,',','.'); ?></td>
  <td align="center"><?php //echo number_format($estmedia2["varmensual"],2,',','.'); ?></td>
  <td align="center"><?php //echo number_format($estmedia2["varanual"],2,',','.'); ?></td>
  <?php /*Se comenta esta linea para el primer periodo (Removerla para el segundo), Remover las dos lineas anteriores 
  		<td align="center" <?php if ($estmedia2["err1"]){ echo $style; } ?>><?php echo number_format($estmedia2["varmensual"],2,',','.'); ?></td>
  		<td align="center" <?php if ($estmedia2["err1"]){ echo $style; } ?>><?php echo number_format($estmedia2["varanual"],2,',','.'); ?></td>
  		*/
  ?>
  <?php //if (($estmedia2["err1"])||($estmedia2["err2"])){ ?>
  		<td align="center"><a href="javascript:corregirFicha(4,'');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(37);">Justificar</a></td>
  <?php //}
       // else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php //} ?>		
</tr-->
<tr class="row2">
  <td align="left">Ingresos por alojamiento/Total ingresos netos operacionales.</td>
  <td align="center"><?php echo number_format($aloingneto["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($aloingneto["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($aloingneto["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($aloingneto["err1"]){ echo $style; } ?>><?php echo number_format($aloingneto["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($aloingneto["err2"]){ echo $style; } ?>><?php echo number_format($aloingneto["varanual"],2,',','.'); ?></td>
  <?php if (($aloingneto["err1"])||($aloingneto["err2"])){ ?>
  		<td align="center"><a href="javascript:corregirFicha(3,'');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(38);">Justificar</a></td>
  <?php }
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php } ?>		
</tr>
<tr class="row1">
  <td align="left">Porcentaje de ocupaci&oacute;n.</td>
  <td align="center"><?php echo number_format($porocupacion["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($porocupacion["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($porocupacion["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($porocupacion["err1"]){ echo $style; } ?>><?php echo number_format($porocupacion["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($porocupacion["err2"]){ echo $style; } ?>><?php echo number_format($porocupacion["varanual"],2,',','.'); ?></td>
  <?php if (($porocupacion["err1"])||($porocupacion["err2"])){ ?>
  		<td align="center"><a href="javascript:corregirFicha(3,'');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(39);">Justificar</a></td>
  <?php }
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php } ?>		
</tr>
<tr class="row2">
  <td align="left">REVPAR (Ingreso Medio por Habitaci&oacute;n Ofrecida).</td>
  <td align="center"><?php echo number_format($ingmedhab["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($ingmedhab["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($ingmedhab["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($ingmedhab["err1"]){ echo $style; } ?>><?php echo number_format($ingmedhab["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($ingmedhab["err2"]){ echo $style; } ?>><?php echo number_format($ingmedhab["varanual"],2,',','.'); ?></td>
  <?php if (($ingmedhab["err1"])||($ingmedhab["err2"])){ ?>
  		<td align="center"><a href="javascript:corregirFicha(3,'');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(40);">Justificar</a></td>
  <?php }
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php } ?>		
</tr>
<tr class="row1">
  <td align="left">GREVPAR (Ingreso Bruto por Habitaci&oacute;n Ofrecida).</td>
  <td align="center"><?php echo number_format($ingbrutohab["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($ingbrutohab["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($ingbrutohab["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($ingbrutohab["err1"]){ echo $style; } ?>><?php echo number_format($ingbrutohab["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($ingbrutohab["err2"]){ echo $style; } ?>><?php echo number_format($ingbrutohab["varanual"],2,',','.'); ?></td>
  <?php if (($ingbrutohab["err1"])||($ingbrutohab["err2"])){ ?>
  		<td align="center"><a href="javascript:corregirFicha(3,'');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(41);">Justificar</a></td>
  <?php }
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php } ?>		
</tr>
<tr class="row2">
  <td align="left">ADR (Facturaci&oacute;n Media por habitaci&oacute;n Ocupada).</td>
  <td align="center"><?php echo number_format($facmedhab["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($facmedhab["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($facmedhab["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($facmedhab["err1"]){ echo $style; } ?>><?php echo number_format($facmedhab["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($facmedhab["err2"]){ echo $style; } ?>><?php echo number_format($facmedhab["varanual"],2,',','.'); ?></td>
  <?php if (($facmedhab["err1"])||($facmedhab["err2"])){ ?>
  		<td align="center"><a href="javascript:corregirFicha(3,'');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(42);">Justificar</a></td>
  <?php }
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php } ?>		
</tr>
</tbody>
</table>
<br/>
<?php $tabla = '<table width="100%" >
				<tr>
  					<td width="80%"><div id="resultValida" style="text-align: right; color: #E00078; font-weight: bolder;"></div></td>
  					<td align="right"><input type="button" id="btnGuardarFicha" name="btnGuardarFicha" value="Enviar ficha a DANE Central" class="button"/></td>
				</tr>
				</table>';

	  if (($controller=="critico")||($controller=="asistente")||($controller=="logistica")){
			if (($novedad_estado["novedad"]==99)&&($novedad_estado["estado"]==4)){ 
				echo $tabla;
			}
	  }
	  else if ($controller=="logistica"){
	  		if (($novedad_estado["novedad"]==99)&&($novedad_estado["estado"]==5)){ 
				//echo $tabla;
			}
	  }

?>
<input type="hidden" id="txtErroresValidacion" name="txtErroresValidacion" value="<?php echo $validaerrores; ?>"/>
</form>

<div id="fichaObservaciones">
<form id="frmObservaciones" name="frmObservaciones" method="post" action="">
<table width="100%" border="1">
<tr>
  <td colspan="2" width="90%"><textarea id="txaFicha" name="txaFicha" rows="5" style="width: 100%;"></textarea></td>
</tr>
<tr>
  <td colspan="2" width="10%">&nbsp;</td>
</tr>
<?php $boton = '<tr>
  					<td><input type="button" id="btnFichaObservaciones" name="btnFichaObservaciones" value="Guardar Observaciones" class="button"/></td>
  					<td><div id="fichaResult"></div></td>
				</tr>';

	  if (($controller=="critico")||($controller=="asistente")){
			if (($novedad_estado["novedad"]==99)&&($novedad_estado["estado"]==4)){ 
				echo $boton;
			}
	  }
	  else if (($controller=="logistica")||($controller="administrador")){
	  		if (($novedad_estado["novedad"]==99)&&($novedad_estado["estado"]==5)){ 
				echo $boton;
			}
	  }

?>
</table>
<input type="hidden" id="txtNumOrden" name="txtNumOrden" value="<?php echo $nro_orden; ?>"/>
<input type="hidden" id="txtNumEstablecimiento" name="txtNumEstablecimiento" value="<?php echo $nro_establecimiento; ?>"/>
<input type="hidden" id="txtIndex" name="txtIndex" value=""/>
<input type="hidden" id="txtOP" name="txtOP" value=""/>
</form>
</div>