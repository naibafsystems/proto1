<script>
	$(function() {
		$("#tabs").tabs();
		$("#btnCapituloI").click(function(){
			$("#tabs").tabs({selected: 1});
		});
		$("#btnCapituloII").click(function(){
			$("#tabs").tabs({selected: 2});
		});
		$("#btnCapituloIII").click(function(){
			$("#tabs").tabs({selected: 3});
		});
		$("#btnCapituloIV").click(function(){
			$("#tabs").tabs({selected: 4});
		});
		$("#btnCapituloV").click(function(){
			$("#tabs").tabs({selected: 5});
		});
		$("#btnObservaciones").click(function(){
			alert("Enviar formulario");
		});
		$("#finicial").datepicker();
		$("#ffinal").datepicker();
		$("#fedili").datepicker();
	});
</script>

<div id="content">
	<h1>M&oacute;dulo de Captura</h1>
	<div id="tabs">
		<ul>
			<li><a href="#tabs-1">Cap&iacute;tulo I</a></li>
			<li><a href="#tabs-2">Cap&iacute;tulo II</a></li>
			<li><a href="#tabs-3">Cap&iacute;tulo III</a></li>
			<li><a href="#tabs-4">Cap&iacute;tulo IV</a></li>
			<li><a href="#tabs-5">Cap&iacute;tulo V</a></li>
			<li><a href="#tabs-6">Observaciones</a></li>
		</ul>
		<div id="tabs-1">
			<p><b>Cap&iacute;tulo I. Nombre y direcci&oacute;n de la empresa</b></p>			
			<br/>
			<form id="frmCapituloI" name="frmCapituloI" method="post" action="">
			    <p><label>Raz&oacute;n social:</label><input type="text" id="idproraz" name="idproraz" value="" style="width: 600px;"/></p>
			    <p><label>Nombre comercial:</label><input type="text" id="idnomcom" name="idnomcom" value="" style="width: 335px;"/><label>Sigla:</label><input type="text" id="idsigla" name="idsigla" value=""/></p>
			    <p><label>Domicilio principal o direcci&oacute;n de la gerencia:</label><input type="text" id="iddirecc" name="iddirecc" value="" style="width: 390px;"/></p>
			    <p><label>Municipio:</label><input type="text" id="idmpio" name="idmpio" value=""/><label>Departamento: </label><input type="text" id="iddepto" name="iddepto" value=""/></p>
			    <p><label>Telefono:</label><input type="text" id="idtelno" name="idtelno" value=""/><label>Fax: </label><input type="text" id="idfax" name="idfax" value=""/><label>A.A:</label><input type="text" id="idaano" name="idaano" value=""/></p>
			    <p><label>Correo electr&oacute;nico de la gerencia:</label><input type="text" id="idcorreo" name="idcorreo" value="" style="width: 460px;"/></p>
			    <p><label>Fechas de referencia de informaci&oacute;n</label><label>Desde:</label><input type="text" id="finicial" name="finicial" value=""/><label>Hasta:</label><input type="text" id="ffinal" name="ffinal" value=""/></p>
				<br/>
				<p style="text-align: right; width: 720px;"><input type="button" id="btnCapituloI" name="btnCapituloI" value="Guardar y continuar"/></p>				
			</form>
		</div>
		<div id="tabs-2">
			<p><b>Cap&iacute;tulo II. Movimiento mensual de los establecimientos que conforman la unidad local</b></p>
			<br/>
			<form id="frmCapituloII" name="frmCapituloII" method="post" action="">
				<p>N&uacute;mero de establecimientos de este informe</p>
				<p><label>1. Iniciales(+):</label><input type="text" id="esini" name="esini" value="" style="width: 80px;"/><label>2. Aperturas en el mes(+):</label><input type="text" id="esape" name="esape" value="" style="width: 80px;"/><label>3. Cierres en el mes(-):</label><input type="text" id="escie" name="escie" value="" style="width: 80px;"/><label>4. Total al final del mes(=):</label><input type="text" id="estot" name="estot" value="" style="width: 80px;"/></p>
				<br/>
				<p style="text-align: right;"><input type="button" id="btnCapituloII" name="btnCapituloII" value="Guardar y continuar"/></p>   
			</form>
		</div>
		<div id="tabs-3">
			<p><b>Cap&iacute;tulo III. Ingresos netos operacionales causados en el mes (millones de pesos)</b></p>
			<p>En los valores parciales no incluya impuestos indirectos (IVA, Consumo)</p>
			<br/>
			<table>
			<tr>
			  <td>1. Alojamiento</td>
			  <td><input type="text" id="inalo" name="inalo" value=""/></td>
			</tr>
			<tr>
			  <td>2. Servicios de alimentos y bebidas no alcohólicas, no incluidas en alojamiento</td>
			  <td><input type="text" id="inali" name="inali" value=""/></td>
			</tr>
			<tr>
			  <td>3. Servicios de bebidas alcohólicas y cigarrilos, no incluidos en alojamiento</td>
			  <td><input type="text" id="inba" name="inba" value=""/></td>
			</tr>
			<tr>
			  <td>4. Alquiler de salones y/u organizaci&oacute;n de eventos</td>
			  <td><input type="text" id="inoe" name="inoe" value=""/></td>
			</tr>
			<tr>
			  <td>5. Otros ingresos netos operacionales no incluidos anteriormente</td>
			  <td><input type="text" id="inoio" name="inoio" value=""/></td>
			</tr>
			<tr>
			  <td>6. Total de ingresos netos operacionales</td>
			  <td><input type="text" id="intio" name="intio" value=""/></td>
			</tr>
			</table>
			<br/>
			<p style="text-align: right;"><input type="button" id="btnCapituloIII" name="btnCapituloIII" value="Guardar y continuar"/></p>			
		</div>
		<div id="tabs-4">
			<p><b>Cap&iacute;tulo IV. Personal ocupado promedio y salarios causados en el mes</b></p>
			<br/>
			<table>
			<thead>
			<tr>
			  <th>Tipo de contrataci&oacute;n</th>
			  <th>N&uacute;mero de personas promedio mensual</th>
			  <th>Sueldos y salarios causados totales en el mes (millones de pesos)</th>
			</tr>
			</thead>
			<tbody>
			<tr>
			  <td>1. Propietarios, socios y familiares sin remuneración fija</td>
			  <td><input type="text" id="potpsfr" name="potpsfr" value=""/></td>
			  <td><input type="text" id="" name="" value="" disabled="disabled"/></td>
			</tr>
			<tr>
			  <td>2. Personal permanente (Contrato a término indefinido)</td>
			  <td><input type="text" id="potperm" name="potperm" value=""/></td>
			  <td><input type="text" id="gpper" name="gpper" value=""/></td>
			</tr>
			<tr>
			  <td>3. Personal temporal contratado directamente por la empresa (Contrato a t&eacute;rmino definido)</td>
			  <td><input type="text" id="pottcde" name="pottcde" value=""/></td>
			  <td><input type="text" id="gpssde" name="gpssde" value="" /></td>
			</tr>
			<tr>
			  <td>4. Temporales suministrados por otras empresas</td>
			  <td><input type="text" id="pottcag" name="pottcag" value=""/></td>
			  <td><input type="text" id="gppta" name="gppta" value="" /></td>
			</tr>
			<tr>
			  <td>5. Personal aprendiz o estudiante por convenio</td>
			  <td><input type="text" id="potpau" name="potpau" value=""/></td>
			  <td><input type="text" id="gppgpa" name="gppgpa" value="" /></td>
			</tr>
			<tr>
			  <td>6. Total (Sume renglones 1 a 5)</td>
			  <td><input type="text" id="pottot" name="pottot" value=""/></td>
			  <td><input type="text" id="gpsspot" name="gpsspot" value=""/></td>
			</tr>
			</tbody>
			</table>
			<br/>
			<p style="text-align: right;"><input type="button" id="btnCapituloIV" name="btnCapituloIV" value="Guardar y continuar"/></p>			
		</div>
		<div id="tabs-5">
			<p><b>Cap&iacute;tulo V. Caracter&iacute;sticas de los hoteles</b></p>
			<br/>
			<table>
			<thead>
			<tr>
			  <th colspan="4" align="center">Caracter&iacute;sticas de los hoteles</th>
			</tr>
			</thead>
			<tbody>
			<tr>
			  <td rowspan="2">N&uacute;mero de habitaciones:</td>
			  <td>Disponibles promedio d&iacute;a</td>
			  <td>Ofrecidas total mes</td>
			  <td>Ocupadas o vendidas</td>
			</tr>
			<tr>
			  <td><input type="text" id="habdia" name="habdia" value=""/></td>
			  <td><input type="text" id="ihdo" name="ihdo" value=""/></td>
			  <td><input type="text" id="ihoa" name="ihoa" value=""/></td>
			</tr>
			<tr>
			  <td rowspan="2">N&uacute;mero de camas:</td>
			  <td>Disponibles promedio d&iacute;a</td>
			  <td>Ofrecidas total mes</td>
			  <td>Ocupadas o vendidas</td>
			</tr>
			<tr>
			  <td><input type="text" id="camdia" name="camdia" value=""/></td>
			  <td><input type="text" id="icda" name="icda" value=""/></td>
			  <td><input type="text" id="icva" name="icva" value=""/></td>
			</tr>
			<tr>
			  <td rowspan="2">Huespedes - Llegada de personas:</td>
			  <td>Residentes en Colombia</td>
			  <td>No Residentes</td>
			  <td>Total</td>
			</tr>
			<tr>
			  <td><input type="text" id="ihpn" name="ihpn" value=""/></td>
			  <td><input type="text" id="ihpnr" name="ihpnr" value=""/></td>
			  <td><input type="text" id="huetot" name="huetot" value=""/></td>
			</tr>
			</tbody>
			</table>
			<br/>
			<table>
			<thead>
			<tr>
			  <th colspan="3" align="center">Motivo de viaje</th>
			</tr>
			<tr>
			  <th>Motivo de viaje</th>
			  <th>Residentes %</th>
			  <th>No Residentes %</th>
			</tr>
			</thead>
			<tbody>
			<tr>
			  <td>1. Negocios y convenciones</td>
			  <td><input type="text" id="mvnr" name="" value=""/></td>
			  <td><input type="text" id="mvnnr" name="" value=""/></td>
			</tr>  
			<tr>
			  <td>2. Ocio y recreaci&oacute;n</td>
			  <td><input type="text" id="mvor" name="mvor" value=""/></td>
			  <td><input type="text" id="mvonr" name="mvnor" value=""/></td>
			</tr>
			<tr>
			  <td>3. Otros</td>
			  <td><input type="text" id="mvotr" name="mvotr" value=""/></td>
			  <td><input type="text" id="mvotnr" name="mvotnr" value=""/></td>
			</tr>
			<tr>
			  <td>4. Total</td>
			  <td><input type="text" id="mvott" name="mvott" value=""/></td>
			  <td><input type="text" id="mvottnr" name="mvottnr" value=""/></td>
			</tr>
			</tbody>
			</table>
			<br/>
			<table>
			<thead>
			<tr>
			  <th colspan="4">Ingresos por habitaci&oacute;n vendida (Diligencie de acuerdo con las siguientes especificaciones)</th>			  			  
			</tr>
			<tr>
			  <th>Tipo de habitaci&oacute;n</th>
			  <th>N&uacute;mero de habitaciones vendidas</th>
			  <th>Ingresos totales (Millones de pesos)</th>			  
			  <th>Ingresos totales por alojamiento (Millones de pesos)</th>
			</tr>
			</thead>
			<tbody>
			<tr>
			  <td>1. Sencilla</td>
			  <td><input type="text" id="thsen" name="thsen" value=""/></td>
			  <td><input type="text" id="ingsen" name="ingsen" value=""/></td>			  
			  <td><input type="text" id="inalosen" name="inalosen" value=""/></td>			  
			</tr>
			<tr>
			  <td>2. Doble</td>
			  <td><input type="text" id="thdob" name="thdob" value=""/></td>
			  <td><input type="text" id="ingdob" name="ingdob" value=""/></td>			  
			  <td><input type="text" id="inalodob" name="inalodob" value=""/></td>			  
			</tr>
			<tr>
			  <td>3. Suite</td>
			  <td><input type="text" id="thsui" name="thsui" value=""/></td>
			  <td><input type="text" id="ingsui" name="ingsui" value=""/></td>			  
			  <td><input type="text" id="inalosui" name="inalosui" value=""/></td>			  
			</tr>
			<tr>
			  <td>4. Multiple</td>
			  <td><input type="text" id="thmult" name="thmult" value=""/></td>
			  <td><input type="text" id="ingmul" name="ingmul" value=""/></td>			  
			  <td><input type="text" id="inalomul" name="inalomul" value=""/></td>			  
			</tr>
			<tr>
			  <td>5. Otro tipo de habitaci&oacute;n</td>
			  <td><input type="text" id="thotr" name="thotr" value=""/></td>
			  <td><input type="text" id="ingotr" name="ingotr" value=""/></td>			  
			  <td><input type="text" id="inalootr" name="inalootr" value=""/></td>			  
			</tr>
			<tr>
			  <td>6. Total</td>
			  <td><input type="text" id="thtot" name="thtot" value=""/></td>
			  <td><input type="text" id="ingtot" name="ingtot" value=""/></td>			  
			  <td><input type="text" id="inalotot" name="inalotot" value=""/></td>			  
			</tr>
			</tbody>
			</table>
			<br/>
			<p style="text-align: right;"><input type="button" id="btnCapituloV" name="btnCapituloV" value="Guardar y continuar"/></p>			
		</div>
		<div id="tabs-6">
			<p><b>Observaciones</b></p>			
			<br/>
			<form id="frmObservaciones" name="frmObservaciones" method="post" action="">
			    <table>
			    <tr>
			      <td colspan="3">Observaciones<textarea id="fteObserv" name="fteObserv" style="width: 99%;"></textarea></td>			      
			    </tr>
			    <tr>
			      <td valign="top"><fieldset>
			          <legend>Ciudad y fecha de diligenciamiento</legend>
			          <table>
			          <tr>
			            <td>Ciudad</td>
			            <td colspan="3"><input type="text" id="dmpio" name="dmpio" value=""></td>
			          </tr>
			          <tr>
			            <td>Fecha de diligenciamiento</td>
			            <td><input type="text" id="fedili" name="fedili" value=""/></td>			            
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
			      <td valign="top"><fieldset>
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
			      <td valign="top"><fieldset>
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
				<p style="text-align: right;"><input type="button" id="btnObservaciones" name="btnObservaciones" value="Guardar y enviar"/></p>				
			</form>
		</div>
	</div>
		
</div>