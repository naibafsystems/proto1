<?php $this->load->helper("url");
      $this->config->load('sitio');
      $title = $this->config->item('title');
      $header = $this->config->item('header');
      $footer = $this->config->item('footer');      
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php echo $title; ?></title>
</head>
<body style="font-family: font-family: Tahoma, Geneva, sans-serif; font-size: 10px;">
<!-- Imagenes del Formulario -->
<table width="100%">
<tr>
 <td align="left"><img src="<?php echo base_url("images/bannertoppdf.png"); ?>"></td>
 <td align="right" valign="middle" style="font-family: Tahoma, serifSansSerifMonospace; font-size: 23px; font-weight: bold; color: #000000;"><?php echo $header; ?></td> 
</tr>
</table>
<br/>
<!--  Modulo 1 -->
<h3 style="background-color: #DFDFDF;">M&oacute;dulo I - Identificaci&oacute;n y datos generales </h3>
<p><b>1. Ubicaci&oacute;n y datos generales de la empresa</b></p>
<table width="100%">
<tr>
  <td colspan="3"><b>Raz&oacute;n Social:</b>&nbsp;<?php echo $modulo1["idproraz"]; ?></td>
</tr>
<tr>
  <td><b>Nombre Comercial:</b>&nbsp;<?php echo $modulo1["idnomcom"]; ?></td>
  <td colspan="2"><b>Sigla: </b>&nbsp;<?php echo $modulo1["idsigla"]; ?></td>
</tr>
<tr>
  <td colspan="3"><b>Direcci&oacute;n:</b>&nbsp;<?php echo $modulo1["iddirecc"]; ?></td>
</tr>
<tr>
  <td><b>Departamento:</b>&nbsp;<?php echo $modulo1["iddepto"]; ?></td>
  <td colspan="2"><b>Municipio:</b>&nbsp;<?php echo $modulo1["idmpio"]; ?></td>
</tr>
<tr>
  <td><b>Tel&eacute;fono:</b>&nbsp;<?php echo $modulo1["idtelno"]; ?></td>
  <!-- td><b>Fax:</b>&nbsp;<?php //echo $modulo1["idfaxno"]; ?></td-->
  <td><b>P&aacute;gina Web:</b>&nbsp;<?php echo $modulo1["idpagweb"]; ?></td>
</tr>
<tr>
  <td colspan="3"><b>E-mail gerencia:</b>&nbsp;<?php echo $modulo1["idcorreo"]; ?></td> 
</tr>
<tr>
	<td><b>Operador o cadena hotelera al que pertenece::</b>&nbsp;<?php echo $modulo1["nom_cadena"]; ?></td>
</tr>
</table>
<br/>
<p><b>2. Informaci&oacute;n general del establecimiento</b></p>
<table width="100%">
<tr>
  <td><b>Nombre del establecimiento:</b>&nbsp;<?php echo $modulo1["idnomcomest"]; ?></td>
  <td colspan="2"><b>Sigla:</b>&nbsp;<?php echo $modulo1["idsiglaest"]; ?></td>
</tr>
<tr>
  <td colspan="3"><b>Direcci&oacute;n del establecimiento:</b>&nbsp;<?php echo $modulo1["iddireccest"]; ?></td>
</tr>
<tr>
  <td><b>Departamento:</b>&nbsp;<?php echo $modulo1["iddeptoest"]; ?></td>
  <td colspan="2"><b>Municipio:</b>&nbsp;<?php echo $modulo1["idmpioest"]; ?></td>
</tr>
<tr>
  <td><b>Tel&eacute;fono:</b>&nbsp;<?php echo $modulo1["idtelnoest"]; ?></td>
  <!-- td><b>Fax:</b>&nbsp;<?php //echo $modulo1["idfaxnoest"]; ?></td-->
  <td><b>Email establecimiento:</b>&nbsp;<?php echo $modulo1["idcorreoest"]; ?></td>
</tr>
</table>
<!-- Fin Modulo 1 -->
<br/>
<!-- Modulo 2 -->
<h3 style="background-color: #DFDFDF;">M&oacute;dulo II - Personal ocupado promedio y salarios causados en el mes</h3>
<table width="100%" style="border: 1px solid #CCCCCC;">
<thead style="background-color: #DFDFDF; font-weight: bold;">
<tr>
  <th>TIPO DE CONTRATACI&Oacute;N</th>
  <th>N&uacute;mero promedio de personas ocupadas en el mes</th>
  <th>Total sueldos y salarios causados por el personal ocupado en el mes (miles de pesos)</th>
</tr>
</thead>
<tbody>
<tr>
  <td>1. Propietarios, socios y familiares sin remuneraci&oacute;n fija</td>
  <td align="center"><?php echo $modulo2["potpsfr"]; ?></td>
  <td align="center">&nbsp;</td>
</tr>
<tr>
  <td>2. Personal permanente (Contrato a t&eacute;rmino indefinido)</td>
  <td align="center"><?php echo $modulo2["potperm"]; ?></td>
  <td align="center"><?php echo $modulo2["gpper"]; ?></td>
</tr>
<tr>
  <td>3. Personal temporal contratado directamente por el hotel (Contrato a t&eacute;rmino definido)</td>
  <td align="center"><?php echo $modulo2["pottcde"]; ?></td>
  <td align="center"><?php echo $modulo2["gpssde"]; ?></td>
</tr>
<tr>
  <td>4. Personal temporal contratado a trav&eacute;s de empresas especializadas</td>
  <td align="center"><?php echo $modulo2["pottcag"]; ?></td>
  <td align="center"><?php echo $modulo2["gpppta"]; ?></td>
</tr>
<tr>
  <td>5. Aprendices y pasantes (Universitarios, t&eacute;cnicos y tecn&oacute;logos) Ley 789 de 2002</td>
  <td align="center"><?php echo $modulo2["potpau"]; ?></td>
  <td align="center"><?php echo $modulo2["gppgpa"]; ?></td>
</tr>
<tr>
  <td>6. Total (Sume renglones 1 a 5)</td>
  <td align="center"><?php echo $modulo2["pottot"]; ?></td>
  <td align="center"><?php echo $modulo2["gpsspot"]; ?></td>
</tr>
</tbody>
</table>
<!-- Fin Modulo 2 -->
<br/>
<!-- Modulo 3 -->
<h3 style="background-color: #DFDFDF;">M&oacute;dulo III - Ingresos netos operacionales causados en el mes (miles de pesos)</h3>
<table width="100%" style="border: 1px solid #DFDFDF;">
<tr>
  <td>1. Alojamiento.</td>
  <td align="center"><?php echo $modulo3["inalo"]; ?></td>
</tr>
<tr>
  <td>2. Servicios de restaurante (alimentos y bebidas no alcoh&oacute;licas), no incluidos en el valor de la tarifa de alojamiento.</td>
  <td align="center"><?php echo $modulo3["inali"]; ?></td>
</tr>
<tr>
  <td>3. Servicios de bar (bebidas alcoh&oacute;licas y cigarrillos), no incluidos en el valor de la tarifa de alojamiento.</td>
  <td align="center"><?php echo $modulo3["inba"]; ?></td>
</tr>
<tr>
	<td>4. Servicios receptivos (city tours, gu&iacute;as tur&iacute;sticos y servicios similares).</td>
	<td  align="center"><?php echo $modulo3["insr"]; ?></td>
</tr>
<tr>
  <td>5. Alquiler de salones y/o apoyo en la organizaci&oacute;n de eventos (incluya todo lo refente al alquiler; log&iacute;stica, alimentaci&oacute;n, etc.).</td>
  <td align="center"><?php echo $modulo3["inoe"]; ?></td>
</tr>
<tr>
  <td>6. Otros ingresos netos operacionales no incluidos antes (Incluye comunicaciones, lavander&iacute;a, peluquer&iacute;a, etc.).</td>
  <td align="center"><?php echo $modulo3["inoio"]; ?></td>
</tr>
<tr>
  <td>6. Total de ingresos netos operacionales (Sin IVA)</td>
  <td align="center"><?php echo $modulo3["intio"]; ?></td>
</tr>
</table>
<!-- Fin Modulo 3 -->
<br/>
<!-- Modulo 4 -->
<h3 style="background-color: #DFDFDF;">M&oacute;dulo IV - Caracter&iacute;sticas de los hoteles</h3>
</table>
 <table width="100%" style="border: 1px solid #CCCCCC;">
  <tr>
    <td rowspan="3"><b>1. Numero de Habitaciones</b></td>
  </tr>
  <tr>
    <td align="center"><b>Ofrecidas total al mes:</b></td>
	<td align="center"><b>Ocupadas o vendidas mes:</b></td>
  </tr>
  <tr>
    <td align="center"><?php echo $modulo4["ihdo"]; ?></td>
	<td align="center"><?php echo $modulo4["ihoa"]; ?></td>
  </tr>
  <tr>
    <td rowspan="3"><b>2. N&uacute;mero de camas</b></td>
  </tr>
  <tr>
    <td align="center"><b>Ofrecidas total al mes:</b></td>
	<td align="center"><b>Ocupadas o vendidas mes:</b></td>
  </tr>
  <tr>
    <td align="center"><?php echo $modulo4["icda"]; ?></td>
	<td align="center"><?php echo $modulo4["icva"]; ?></td>
  </tr>
  <tr>
    <td rowspan="2"><b>3. Hu&eacute;spedes - Llegada de personas (Check-In)</b></td>
	<td align="center"><b>Residentes en Colombia</b></td>
	<td align="center"><b>No Residentes</b></td>
	<td align="center"><b>Total</b></td>
  </tr>
  <tr>
    <td align="center"><?php echo $modulo4["ihpn"]; ?></td>
	<td align="center"><?php echo $modulo4["ihpnr"]; ?></td>
	<td align="center"><?php echo $modulo4["huetot"]; ?></td>
  </tr>
  </table>	
  <br/><br/>
  <table width="100%" style="border: 1px solid #CCCCCC;">
  <thead style="border: 1px solid #CCCCCC;">
  <tr>
    <th colspan="3">MOTIVO DE VIAJE DE LOS HU&Eacute;SPEDES (Motivo sin el cual el viaje no se hubiera efectuado)</th>
  </tr>
  <tr>
    <th>Motivo de viaje</th>
    <th>Residentes %</th>
    <th>No Residentes %</th>
  </tr>
  </thead>
  <tbody>
  <tr>
    <td><b>1. Negocios.</b></td>
    <td align="center"><?php echo $modulo4["mvnr"]; ?></td>
    <td align="center"><?php echo $modulo4["mvnnr"]; ?></td>
  </tr>
  <tr>  
    <td><b>2. Convenciones (MICE).</b></td>
    <td align="center"><?php echo $modulo4["mvcr"]; ?></td>
    <td align="center"><?php echo $modulo4["mvcnr"]; ?></td>
  </tr>
  <tr>  
    <td><b>3. Ocio y recreo y vacaciones.</b></td>
    <td align="center"><?php echo $modulo4["mvor"]; ?></td>
    <td align="center"><?php echo $modulo4["mvonr"]; ?></td>
  </tr>
  <tr>  
    <td><b>4. Salud y atención m&eacute;dica (Incluye tratamientos de atenci&oacute;n est&eacute;tica)</b></td>
    <td align="center"><?php echo $modulo4["mvsr"]; ?></td>
    <td align="center"><?php echo $modulo4["mvsnr"]; ?></td>
  </tr>
  <tr>  
    <td><b>5. Otros (Imprevistos de transporte, etc.)</b></td>
    <td align="center"><?php echo $modulo4["mvotr"]; ?></td>
    <td align="center"><?php echo $modulo4["mvotnr"]; ?></td>
  </tr>
  <tr>  
    <td><b>6. Total</b></td>
    <td align="center"><?php echo $modulo4["mvott"]; ?></td>
    <td align="center"><?php echo $modulo4["mvottnr"]; ?></td>
  </tr>
  </tbody>
  </table>
  <br/><br/>
  <table style="border: 1px solid #CCCCCC;">
  <thead style="border: 1px solid #CCCCCC;">
  <tr>
    <td colspan="4" align="center"><b>TARIFA PROMEDIO POR TIPO DE ACOMODACI&Oacute;N</b></td>
  </tr>
  <tr>
    <td><b>Tipo de habitaci&oacute;n</b></td>
	<td><b>N&uacute;mero de habitaciones vendidas</b></td>
	<td><b>Tarifa promedio por tipo de acomodaci&oacute;n (valor en pesos)</b></td>
  </tr>
  </thead>
  <tbody>
  <tr>
    <td><b>1. Sencilla</b></td>
	<td align="center"><?php echo $modulo4["thsen"]; ?></td>
	<td align="center"><?php echo $modulo4["thusen"]; ?></td>
  </tr>
  <tr>
    <td><b>2. Doble</b></td>
	<td align="center"><?php echo $modulo4["thdob"]; ?></td>
	<td align="center"><?php echo $modulo4["thudob"]; ?></td>
  </tr>
  <tr>
    <td><b>3. Suite</b></td>
	<td align="center"><?php echo $modulo4["thsui"]; ?></td>
	<td align="center"><?php echo $modulo4["thusui"]; ?></td>
  </tr>
  <tr>
    <td><b>4. M&uacute;ltiple (Triple, Habitaci&oacute;n compartida)</b></td>
	<td align="center"><?php echo $modulo4["thmult"]; ?></td>
	<td align="center"><?php echo $modulo4["thumult"]; ?></td>
  </tr>
  <tr>
    <td><b>5. Otro tipo de habitaci&oacute;n (Caba&ntilde;a, aparta hotel, camping, etc)</b></td>
	<td align="center"><?php echo $modulo4["thotr"]; ?></td>
	<td align="center"><?php echo $modulo4["thuotr"]; ?></td>
  </tr>
  <tr>
    <td><b>6. Total</b></td>
	<td align="center"><?php echo $modulo4["thtot"]; ?></td>
	<td align="center"></td>
  </tr>
  </tbody>
  </table>
  <br/><br/><br/>
  <p><b>La no presentaci&oacute;n oportuna de este informe acarrea las sanciones establecidas en la Ley 079 de 1993</b></p>  
  <br>
  <p><b>MICE ( Meeting, incentives, congresses, exhibitions)</b>, es aquel que abarca las actividades basadas en la organizaci&oacute;n, promoci&oacute;n, venta y distribuci&oacute;n de reuniones y eventos; productos y servicios que incluyen reuniones gubernamentales, de empresas y de asociaciones; viajes de incentivos de empresas, seminarios, congresos, conferencias, convenciones, exposiciones y ferias”.</p>	
  </body>
</html>