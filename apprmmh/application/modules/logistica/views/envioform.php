<?php $this->load->library("general"); ?>
<h3><center>FICHA DE AN&Aacute;LISIS</center></h3>
<form id="frmFichaAnalisis" name="frmFichaAnalisis" method="post" action="<?php echo site_url("fichanalisis/validarEnvio"); ?>">
<table width="100%" class="table" style="font-size: 10px">
<thead class="thead">
<tbody>
<tr>
  <td align="left">Ingresos por alojamiento</td>
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
  <td align="left"> Ingresos por servicios de restaurante</td>
  <td align="center"><?php echo number_format($inali["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($inali["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($inali["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($inali["err1"]){ echo $style; } ?>><?php echo number_format($inali["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($inali["err2"]){ echo $style; } ?>><?php echo number_format($inali["varanual"],2,',','.'); ?></td>
  <?php if (($inali["err1"])||($inali["err2"])){  ?>
  		<td align="center"><a href="javascript:corregirFicha(3,'inalo');" class="redText">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(1);">Justificar</a></td>
  <?php } 
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td>
  <?php } ?>      		
</tr>
<tr>
  <td align="left"> Ingresos por  Alquiler de salones y/o apoyo para diferentes eventos</td>
  <td align="center"><?php echo number_format($inoe["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($inoe["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($inoe["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($inoe["err1"]){ echo $style; } ?>><?php echo number_format($inoe["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($inoe["err2"]){ echo $style; } ?>><?php echo number_format($inoe["varanual"],2,',','.'); ?></td>
  <?php if (($inoe["err1"])||($inoe["err2"])){  ?>
  		<td align="center"><a href="javascript:corregirFicha(3,'inalo');" class="redText">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(1);">Justificar</a></td>
  <?php } 
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td>
  <?php } ?>      		
</tr>
<tr class="row2">
  <td align="left">Total de ingresos operacionales</td>
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
<tr>
  <td align="left">Total personal contratado</td>
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
<tr tr class="row2">
  <td align="left">Camas ocupadas o vendidas</td>
  <td align="center"><?php echo number_format($icva["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($icva["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($icva["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($icva["err1"]){ echo $style; } ?>><?php echo number_format($icva["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($icva["err2"]){ echo $style; } ?>><?php echo number_format($icva["varanual"],2,',','.'); ?></td>
  <?php if (($icva["err1"])||($icva["err2"])){ ?>
  		<td align="center"><a href="javascript:corregirFicha(2,'pottot');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(7);">Justificar</a></td>
  <?php }
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php } ?>
</tr>
<tr>
  <td align="left">Habitaciones ocupadas o vendidas</td>
  <td align="center"><?php echo number_format($ihoa["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($ihoa["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($ihoa["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($ihoa["err1"]){ echo $style; } ?>><?php echo number_format($ihoa["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($ihoa["err2"]){ echo $style; } ?>><?php echo number_format($ihoa["varanual"],2,',','.'); ?></td>
  <?php if (($ihoa["err1"])||($ihoa["err2"])){ ?>
  		<td align="center"><a href="javascript:corregirFicha(2,'pottot');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(7);">Justificar</a></td>
  <?php }
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php } ?>
</tr>
<tr>
  <td align="left">Total hu&eacute;spedes</td>
  <td align="center"><?php echo number_format($huetot["actual"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($huetot["anterior"],2,',','.'); ?></td>
  <td align="center"><?php echo number_format($huetot["anual"],2,',','.'); ?></td>
  <td align="center" <?php if ($huetot["err1"]){ echo $style; } ?>><?php echo number_format($huetot["varmensual"],2,',','.'); ?></td>
  <td align="center" <?php if ($huetot["err2"]){ echo $style; } ?>><?php echo number_format($huetot["varanual"],2,',','.'); ?></td>
  <?php if (($huetot["err1"])||($huetot["err2"])){ ?>
  		<td align="center"><a href="javascript:corregirFicha(2,'pottot');">Corregir</a></td>
  		<td align="center"><a href="javascript:justificarFicha(7);">Justificar</a></td>
  <?php }
        else{ ?>
        <td align="center">&nbsp;</td>
  		<td align="center">&nbsp;</td> 
  <?php } ?>
</tr>
</tbody>
</table>
<?php
if($intio["actual"]>$intio["anterior"] && $pottot["actual"]<$pottot["anterior"]){
	?>
	<table width="100%" class="table" style="font-size: 10px">
	<tr>
		<td align="left" style="color: red" width="80%">Justifique porque se presenta aumento en los ingresos totales y disminuci&oacute;n en el personal ocupado.</td>
		<td align="center"><a href="javascript:corregirFicha(2,'pottot');" class="redText">Corregir</a></td>
	  	<td align="center"><a href="javascript:justificarFicha(53);">Justificar</a></td>
	</tr>
	</table>
<?php
}
if($intio["actual"]>$intio["anual"] && $pottot["actual"]<$pottot["anual"]){
?>
	<table width="100%" class="table" style="font-size: 10px">
	<tr>
		<td align="left" style="color: red" width="80%">Justifique porque se presenta aumento en los ingresos totales y disminuci&oacute;n en el personal ocupado.</td>
		<td align="center"><a href="javascript:corregirFicha(2,'pottot');" class="redText">Corregir</a></td>
	  	<td align="center"><a href="javascript:justificarFicha(54);">Justificar</a></td>
	</tr>
	</table>
<?php
}
if($intio["actual"]<$intio["anterior"] && $pottot["actual"]>$pottot["anterior"]){
	?>
	<table width="100%" class="table" style="font-size: 10px">
	<tr>
		<td align="left" style="color: red" width="80%">Justifique porque se presenta aumento en el personal ocupado y disminución en los ingresos.</td>
		<td align="center"><a href="javascript:corregirFicha(2,'pottot');" class="redText">Corregir</a></td>
	  	<td align="center"><a href="javascript:justificarFicha(55);">Justificar</a></td>
	</tr>
	</table>
<?php
}
if($intio["actual"]<$intio["anual"] && $pottot["actual"]>$pottot["anual"]){
?>
	<table width="100%" class="table" style="font-size: 10px">
	<tr>
		<td align="left" style="color: red" width="80%">Justifique porque se presenta aumento en el personal ocupado y disminución en los ingresos.</td>
		<td align="center"><a href="javascript:corregirFicha(2,'pottot');" class="redText">Corregir</a></td>
	  	<td align="center"><a href="javascript:justificarFicha(56);">Justificar</a></td>
	</tr>
	</table>
<?php
}
?>
</form>

<br>
<br>
<h3>Enviar formulario</h3>			
<br/>
<form id="frmModuloEnvio" name="frmModuloEnvio" method="post" action="">
<table width="100%">
<tr>
  <td colspan="3" align="left">Observaciones (M&aacute;ximo 500 caracteres)<textarea id="fteObserv" name="fteObserv" style="width: 99%;" rows="5" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"><?php echo $envio["observaciones"]; ?></textarea></td>			      
</tr>
<tr>
  <td colspan="3">&nbsp;</td>
</tr>
<tr>
  <!-- td valign="top">
     <fieldset style="height: 180px;">
     <legend>Ciudad y fecha de diligenciamiento</legend>
	 <table>
	 <tr>
	   <td>Ciudad</td>
	   <td colspan="3"><input type="text" id="dmpio" name="dmpio" value="<?php //echo $envio["dmpio"]; ?>" <?php //$this->general->bloqueoCampo($bloqueo); ?> class="textbox"/></td>
	 </tr>
	 <tr>
	   <td>Fecha de diligenciamiento</td>
	   <td><input type="text" id="fedili" name="fedili" value="<?php //echo date("d/m/Y"); ?>" class="textbox" readonly="readonly" <?php //$this->general->bloqueoCampo($bloqueo); ?>/></td>			            
	 </tr>	         
	 </table>
	 </fieldset>
  </td>
  <td valign="top">
     <fieldset style="height: 180px;">
	 <legend>Responsable de la empresa</legend>
	 <table>
	 <tr>
	   <td>Nombre:</td>
	   <td><input type="text" id="repleg" name="repleg" value="<?php //echo $envio["repleg"]; ?>" <?php //$this->general->bloqueoCampo($bloqueo); ?> class="textbox"/></td>
	 </tr>
	 <tr>
	   <td>&nbsp;</td>
	   <td>&nbsp;</td>
	 </tr>
	 <tr>
	   <td>Firma:</td>
	   <td style="border-bottom: 1px solid #000000;">&nbsp;</td>
	 </tr>	 
	 </table>
	 </fieldset>
  </td-->
  <td align="center" valign="top">
     <fieldset style="height: 180px;">
	 <legend>Persona a quien dirigirse para consultas</legend>
	 <table>
	   <tr>
	     <td>Nombre:</td>
		 <td><input type="text" id="responde" name="responde" value="<?php echo $envio["responde"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"/></td>
	   </tr>
	   <tr>
	     <td>Cargo:</td>
	     <td><input type="text" id="respoca" name="respoca" value="<?php echo $envio["respoca"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"></td>
	   </tr>
	   <tr>
	     <td>Tel.:</td>
	     <td><input type="text" id="teler" name="teler" value="<?php echo $envio["teler"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"></td>
	   </tr>
	   <tr>
	     <td>Correo electr&oacute;nico:</td>
	     <td><input type="text" id="emailr" name="emailr" value="<?php echo $envio["emailr"]; ?>" <?php $this->general->bloqueoCampo($bloqueo); ?> class="textbox"></td>
	   </tr>
	 </table>
	 </fieldset>
  </td>
</tr>  
</table>
 <?php //Validar que el formulario esté en estado 99 - 4 para poder ser activado por el administrador 
	   //if (($novedad_estado["novedad"]==99)&&($novedad_estado["estado"]==4) || ($novedad_estado["novedad"]==99 && $novedad_estado["estado"]==5)){  
 ?>  	    <center><input type="button" id="btnOBSEnvioLOG" name="btnOBSEnvioLOG" value="Observaciones Log&iacute;stica" class="button"/></center>
 <?php //} ?>
<input type="hidden" id="op" name="op" value="<?php echo $envio["op"]; ?>">
<input type="hidden" id="nro_orden" name="nro_orden" value="<?php echo $nro_orden; ?>"/> 
<input type="hidden" id="dmpio" name="dmpio" value="11"/>
<input type="hidden" id="fedili" name="fedili" value="30/06/2015"/> 
<input type="hidden" id="repleg" name="repleg" value="mmm"/> 
<input type="hidden" id="nro_establecimiento" name="nro_establecimiento" value="<?php echo $nro_establecimiento; ?>"/>
<br>
<p><b>La no presentaci&oacute;n oportuna de este informe acarrea las sanciones establecidas en la Ley 079 de 1993.</b></p>

</form>