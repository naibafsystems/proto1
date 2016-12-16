<?php $this->load->helper("url"); ?>

<?php if ($cierre){ ?>
			<h1>Cierre de periodo</h1>
			<h3>El periodo <span class="red"><?php echo $nombre; ?></span> ya ha sido cerrado.</h3>
			<br/>
<?php } 
      else { 
?>			<h1>Cierre de periodo</h1>
			<h3>Se dispone a cerrar el periodo <span class="red"><?php echo $nombre; ?>.</span></h3>
			<br/>
			<form id="frmCierrePer" name="frmCierrePer" method="post" action="<?php echo site_url("administrador/cierreEfectivoPeriodo"); ?>">
			<table class="table" width="75%" align="center">
			<thead class="thead">
			<tr>
  				<td colspan="2"><b>Resumen del periodo (<?php echo $nombre; ?>)</b></td>
			</tr>
			</thead>
			<tbody>
			<tr>
  				<td width="30%">Formularios Sin Distribuir</td>
  				<td><b><?php echo $sindistribuir; ?></b> Formularios</td>
			</tr>
			<tr>
  				<td>Formularios Distribuidos</td>
  				<td><b><?php echo $distribuido; ?></b> Formularios</td>
			</tr>
			<tr>
  				<td>Formularios En Digitaci&oacute;n</td>
  				<td><b><?php echo $digitacion; ?></b> Formularios</td>
			</tr>
			<tr>
  				<td>Formularios Digitados</td>
  				<td><b><?php echo $digitados; ?></b> Formularios</td>
			</tr>
			<tr>
  				<td>Formularios en An&aacute;lisis - Verificaci&oacute;n</td>
  				<td><b><?php echo $analverif; ?></b> Formularios</td>
			</tr>
			<tr>
  				<td>Formularios Verificados</td>
  				<td><b><?php echo $verificados; ?></b> Formularios</td>
			</tr>
			</tbody>
			<tfoot>
			<tr>
 				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
  				<td colspan="2" align="right"><input type="submit" id="btnCierrePer" name="btnCierrePer" value="Cerrar Periodo" class="button"/></td>  
			</tr>
			</tfoot>
			</table>
			</form>     
<?php }?>
