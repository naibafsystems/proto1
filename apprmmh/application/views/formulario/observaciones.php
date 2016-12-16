<p><b>Observaciones</b></p>			
<br/>
<form id="frmObservaciones" name="frmObservaciones" method="post" action="">
<table>
<tr>
  <td colspan="3">Observaciones<textarea id="fteObserv" name="fteObserv" style="width: 99%;" rows="5"></textarea></td>			      
</tr>
<tr>
  <td valign="top">
     <fieldset>
     <legend>Ciudad y fecha de diligenciamiento</legend>
	 <table>
	 <tr>
	   <td>Ciudad</td>
	   <td colspan="3"><input type="text" id="dmpio" name="dmpio" value=""></td>
	 </tr>
	 <tr>
	   <td>Fecha de diligenciamiento</td>
	   <td><input type="text" id="fedili" name="fedili" value="<?php echo date("d/m/Y"); ?>"/></td>			            
	 </tr>
	 <tr>
	   <td>&nbsp;</td>
	   <td>&nbsp;</td>
	 </tr>
	 <tr>
	   <td>&nbsp;</td>
	   <td>&nbsp;</td>
	 </tr>
	 <tr>
	   <td>&nbsp;</td>
	   <td>&nbsp;</td>
	 </tr>			         
	 </table>
	 </fieldset>
  </td>
  <td valign="top">
     <fieldset>
	 <legend>Responsable de la empresa</legend>
	 <table>
	 <tr>
	   <td>Nombre:</td>
	   <td><input type="text" id="repleg" name="repleg" value=""/></td>
	 </tr>
	 <tr>
	   <td>&nbsp;</td>
	   <td>&nbsp;</td>
	 </tr>
	 <tr>
	   <td>Firma:</td>
	   <td style="border-bottom: 1px solid #000000;">&nbsp;</td>
	 </tr>
	 <tr>
	   <td>&nbsp;</td>
	   <td>&nbsp;</td>
	 </tr>
	 <tr>
	   <td>&nbsp;</td>
	   <td>&nbsp;</td>
	 </tr>
	 <tr>
	   <td>&nbsp;</td>
	   <td>&nbsp;</td>
	 </tr>
	 </table>
	 </fieldset>
  </td>
  <td valign="top">
     <fieldset>
	 <legend>Persona a quien dirigirse para consultas</legend>
	 <table>
	   <tr>
	     <td>Nombre:</td>
		 <td><input type="text" id="responde" name="responde" value=""/></td>
	   </tr>
	   <tr>
	     <td>Cargo:</td>
	     <td><input type="text" id="respoca" name="respoca" value=""></td>
	   </tr>
	   <tr>
	     <td>Tel.:</td>
	     <td><input type="text" id="teler" name="teler" value=""></td>
	   </tr>
	   <tr>
	     <td>Correo electr&oacute;nico:</td>
	     <td><input type="text" id="emailr" name="emailr" value=""></td>
	   </tr>
	 </table>
	 </fieldset>
  </td>
</tr>  
</table>
<br>
<p>La no presentaci&oacute;n oportuna de este informe acarrea las sanciones establecidas en la Ley 079 de 1993.</p>
<br/>
<p style="text-align: right;"><input type="submit" id="btnObservaciones" name="btnObservaciones" value="Guardar y enviar" class="button"/></p>
</form>