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
<body>
<table width="100%">
<tr>
 <td align="left"><img src="<?php echo base_url("images/bannertoppdf.png"); ?>"></td>
 <td align="right" valign="middle" style="font-family: Tahoma, serifSansSerifMonospace; font-size: 23px; font-weight: bold; color: #000000;"><?php echo $header; ?></td> 
</tr>
</table>
<!-- Tabla del Caratula -->
<table width="100%">
 <thead>
  <tr>
    <th style="padding-left: 10px; text-align: left; font-family: Tahoma, serifSansSerifMonospace; font-weight: bold; background-color:#EFEFEF; color: #000000; ">Nombre y direcci&oacute;n de la empresa</th>
  </tr>
 </thead>
 <tbody>
  <tr>
    <td style="font-family: Helvetica; font-size: Small;"><b>Raz&oacute;n social: </b><?php echo $caratula["idproraz"]; ?></td>
  </tr>
  <tr>
    <td style="font-family: Helvetica; font-size: Small;"><b>Nombre Comercial: </b><?php echo $caratula["idnomcom"]; ?></td>
  </tr>
  <tr>
    <td style="font-family: Helvetica; font-size: Small;"><b>Domicilio principal o direcci&oacute;n de la gerencia:&nbsp;&nbsp;</b><?php echo $caratula["iddirecc"]; ?></td>
  </tr>
  <tr>
    <td style="font-family: Helvetica; font-size: Small;"><b>Departamento: </b><?php echo $caratula["depto"]; ?></td>
  </tr>
  <tr>
    <td style="font-family: Helvetica; font-size: Small;"><b>Municipio: </b><?php echo $caratula["mpio"]; ?></td>
  </tr>
  <tr>
    <td style="font-family: Helvetica; font-size: Small;"><b>Tel&eacute;fono: </b><?php echo $caratula["mpio"]; ?></td>
  </tr>
  <tr>
    <td style="font-family: Helvetica; font-size: Small;"><b>Fax: </b><?php echo $caratula["idfaxno"]; ?></td>
  </tr>
  <tr>
    <td style="font-family: Helvetica; font-size: Small;"><b>Apartado A&eacute;reo: </b><?php echo $caratula["idaano"]; ?></td>
  </tr>
  <tr>
    <td style="font-family: Helvetica; font-size: Small;"><b>Correo electr&oacute;nico de la gerencia: </b><?php echo $caratula["idcorreo"]; ?></td>
  </tr>
  <tr>
    <td style="font-family: Helvetica; font-size: Small;"><b>Fechas de referencia de informaci&oacute;n:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Desde: <?php echo $caratula["finicial"]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hasta: <?php echo $caratula["ffinal"]; ?></td>
  </tr>
 </tbody>
</table>

<!-- Tabla capitulo I -->
 <table width="100%">
    <thead>
    <tr>
      <th style="padding-left: 10px; text-align: left; font-family: Tahoma, serifSansSerifMonospace; font-weight: bold; background-color:#EFEFEF; color: #000000; ">Cap&iacute;tulo I - Movimiento mensual de los establecimientos que conforman la unidad local</th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td style="font-family: Helvetica; font-size: Small;"><b>1. Iniciales:</b><?php echo $capitulo1["esini"]; ?></td>
    </tr>
    <tr>
      <td style="font-family: Helvetica; font-size: Small;"><b>2. Aperturas en el mes(+):</b><?php echo $capitulo1["esape"]; ?></td>
    </tr>
    <tr>
      <td style="font-family: Helvetica; font-size: Small;"><b>3. Cierres en el mes(-):</b><?php echo $capitulo1["escie"]; ?></td>
    </tr>
    <tr>
      <td style="font-family: Helvetica; font-size: Small;"><b>4. Total a final de mes(=):</b><?php echo $capitulo1["estot"]; ?></td>
    </tr>
    </tbody>
    </table>
    
<!-- Tabla del capitulo 2 -->
<table width="100%">
    <thead>
    <tr>
      <th style="padding-left: 10px; text-align: left; font-family: Tahoma, serifSansSerifMonospace; font-weight: bold; background-color:#EFEFEF; color: #000000; ">Cap&iacute;tulo II - Ingresos netos operacionales causados en el mes (miles de pesos)</th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td style="font-family: Helvetica; font-size: Small;"><b>1. Alojamiento:</b><?php echo $capitulo2["inalo"]; ?></td>
    </tr>
    <tr>
      <td style="font-family: Helvetica; font-size: Small;"><b>2. Servicios de alimentos y bebidas no alcoh&oacute;licas, no incluidas en alojamiento:</b><?php echo $capitulo2["inali"]; ?></td>
    </tr>
    <tr>
      <td style="font-family: Helvetica; font-size: Small;"><b>3. Servicios de bebidas alcoh&oacute;licas y cigarrilos, no incluidos en alojamiento:</b><?php echo $capitulo2["inba"]; ?></td>
    </tr>
    <tr>
      <td style="font-family: Helvetica; font-size: Small;"><b>4. Alquiler de salones y/u organizaci&oacute;n de eventos:</b><?php echo $capitulo2["inoe"]; ?></td>
    </tr>
    <tr>
      <td style="font-family: Helvetica; font-size: Small;"><b>5. Otros ingresos netos operacionales no incluidos anteriormente: </b><?php echo $capitulo2["inoio"]; ?></td>
    </tr>
    <tr>
      <td style="font-family: Helvetica; font-size: Small;"><b>6. Total de ingresos netos operacionales: </b><?php echo $capitulo2["intio"]; ?></td>
    </tr>
    </tbody>
    </table>
    
<!--  Tabla del capitulo 3 -->
<table width="100%">
    <thead>
    <tr>
      <th style="padding-left: 10px; text-align: left; font-family: Tahoma, serifSansSerifMonospace; font-weight: bold; background-color:#EFEFEF; color: #000000; ">Cap&iacute;tulo III - Personal ocupado promedio y salarios causados en el mes</th>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td>
      
      	<table width="100%">
      	<thead>
      	<tr>
      	  <th>Tipo de Contrataci&oacute;n</th>
      	  <th>N&uacute;mero de personas (Promedio mensual)</th>
      	  <th>Sueldos y salarios totales causados en el mes (Miles de pesos)</th>
      	</tr>
      	</thead>      	
      	<tbody>
      	<tr>
      	  <td>1. Propietarios, socios y familiares sin remuneraci&oacute;n fija</td>
      	  <td align="center"><?php echo $capitulo3["potpsfr"]; ?></td>
      	  <td>&nbsp;</td>
      	</tr>
      	<tr>
      	  <td>2. Personal permanente (Contrato a t&eacute;rmino indefinido)</td>
      	  <td align="center"><?php echo $capitulo3["potperm"]; ?></td>
      	  <td align="center"><?php echo $capitulo3["gpper"]; ?></td>
      	</tr>
      	<tr>
      	  <td>3. Personal temporal contratado directamente por la empresa (Contrato a t&eacute;rmino definido)</td>
      	  <td align="center"><?php echo $capitulo3["pottcde"]; ?></td>
      	  <td align="center"><?php echo $capitulo3["gpssde"]; ?></td>
      	</tr>
      	<tr>
      	  <td>4. Temporales suministrados por otras empresas</td>
      	  <td align="center"><?php echo $capitulo3["pottcag"]; ?></td>
      	  <td align="center"><?php echo $capitulo3["gpppta"]; ?></td>
      	</tr>
      	<tr>
      	  <td>5. Personal aprendiz o estudiante por convenio</td>
      	  <td align="center"><?php echo $capitulo3["potpau"]; ?></td>
      	  <td align="center"><?php echo $capitulo3["gppgpa"]; ?></td>
      	</tr>
      	<tr>
      	  <td>6. Total</td>
      	  <td align="center"><?php echo $capitulo3["pottot"]; ?></td>
      	  <td align="center"><?php echo $capitulo3["gpsspot"]; ?></td>
      	</tr>      	
      	</tbody>
      	</table>
      
      </td>
    </tr>
    </tbody>
    </table>



<!-- CAPITULO IV -->
<table width="100%">
<tr>
  <td colspan="2">
  
  <table width="100%">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td style="padding-left: 10px; text-align: left; font-family: Tahoma, serifSansSerifMonospace; font-weight: bold; background-color:#EFEFEF; color: #000000;">Cap&iacute;tulo IV - Caracter&iacute;sticas de los hoteles</td>
  </tr>
  <tr>
    <td>
        <p>Caracter&iacute;sticas de los hoteles</p>
    	<table width="100%">
    	<tr>
    	  <td>N&uacute;mero de habitaciones</td>
    	  <td>Disponibles promedio d&iacute;a: <?php echo $capitulo4["habdia"]; ?></td>
    	  <td>Ofrecidas total mes: <?php echo $capitulo4["ihdo"]; ?></td>
    	  <td>Ocupadas o vendidas: <?php echo $capitulo4["ihoa"]; ?></td>
    	</tr>
    	<tr>
    	  <td>N&uacute;mero de camas</td>
    	  <td>Disponibles promedio d&iacute;a: <?php echo $capitulo4["camdia"]; ?></td>
    	  <td>Ofrecidas total mes: <?php echo $capitulo4["icda"]; ?></td>
    	  <td>Ocupadas o vendidas: <?php echo $capitulo4["icva"]; ?></td>
    	</tr>
    	<tr>
    	  <td>Hu&eacute;spedes - Llegada de personas</td>
    	  <td>Residentes en Colombia: <?php echo $capitulo4["ihpn"]; ?></td>
    	  <td>No Residentes: <?php echo $capitulo4["ihpnr"]; ?></td>
    	  <td>Total Hu&eacute;spedes: <?php echo $capitulo4["huetot"]; ?></td>
    	</tr>
    	</table>
    	
    	<p>Motivo de Viaje</p>
    	<table width="100%">
    	<tr>
    	  <td>Motivo Viaje</td>
    	  <td>Residentes (%)</td>
    	  <td>No Residentes (%)</td>    	  
    	</tr>
    	<tr>
    	  <td>1. Negocios</td>
    	  <td><?php echo $capitulo4["mvnr"]; ?> %</td>
    	  <td><?php echo $capitulo4["mvnnr"]; ?> %</td>    	  
    	</tr>
    	<tr>
    	  <td>2. Convenciones</td>
    	  <td><?php echo $capitulo4["mvcr"]; ?> %</td>
    	  <td><?php echo $capitulo4["mvcnr"]; ?> %</td>    	  
    	</tr>
    	<tr>
    	  <td>3. Ocio y recreaci&oacute;n</td>
    	  <td><?php echo $capitulo4["mvor"]; ?> %</td>
    	  <td><?php echo $capitulo4["mvonr"]; ?> %</td>    	  
    	</tr>
    	<tr>
    	  <td>4. Salud y Belleza</td>
    	  <td><?php echo $capitulo4["mvsr"]; ?> %</td>
    	  <td><?php echo $capitulo4["mvsnr"]; ?> %</td>    	  
    	</tr>
    	<tr>
    	  <td>5. Otros</td>
    	  <td><?php echo $capitulo4["mvotr"]; ?> %</td>
    	  <td><?php echo $capitulo4["mvotnr"]; ?> %</td>    	  
    	</tr>
    	<tr>
    	  <td>6. Total</td>
    	  <td><?php echo $capitulo4["mvott"]; ?> %</td>
    	  <td><?php echo $capitulo4["mvottnr"]; ?> %</td>    	  
    	</tr>
    	</table>
    	
    	<p>Ingresos por habitaci&oacute;n vendida</p>
    	<table width="100%">
    	<tr>
    	  <td>Tipo de habitaci&oacute;n</td>
    	  <td>N&uacute;mero de habitaciones vendidas</td>
    	  <td>Ingresos totales (Miles de pesos)</td>
    	  <td>Ingresos totales por alojamiento (Miles de pesos)</td>
    	</tr>
    	<tr>
    	  <td>1. Sencilla</td>
    	  <td><?php echo $capitulo4["thsen"]; ?></td>
    	  <td><?php echo $capitulo4["ingsen"]; ?></td>
    	  <td><?php echo $capitulo4["inalosen"]; ?></td>
    	</tr>
    	<tr>
    	  <td>2. Doble</td>
    	  <td><?php echo $capitulo4["thdob"]; ?></td>
    	  <td><?php echo $capitulo4["ingdob"]; ?></td>
    	  <td><?php echo $capitulo4["inalodob"]; ?></td>
    	</tr>
    	<tr>
    	  <td>3. Suite</td>
    	  <td><?php echo $capitulo4["thsui"]; ?></td>
    	  <td><?php echo $capitulo4["ingsui"]; ?></td>
    	  <td><?php echo $capitulo4["inalosui"]; ?></td>
    	</tr>
    	<tr>
    	  <td>4. M&uacute;ltiple</td>
    	  <td><?php echo $capitulo4["thmult"]; ?></td>
    	  <td><?php echo $capitulo4["ingmult"]; ?></td>
    	  <td><?php echo $capitulo4["inalomul"]; ?></td>
    	</tr>
    	<tr>
    	  <td>5. Otro tipo de habitaci&oacute;n</td>
    	  <td><?php echo $capitulo4["thotr"]; ?></td>
    	  <td><?php echo $capitulo4["ingotr"]; ?></td>
    	  <td><?php echo $capitulo4["inalootr"]; ?></td>
    	</tr>
    	<tr>
    	  <td>6. Total</td>
    	  <td><?php echo $capitulo4["thtot"]; ?></td>
    	  <td><?php echo $capitulo4["ingtot"]; ?></td>
    	  <td><?php echo $capitulo4["inalotot"]; ?></td>
    	</tr>
    	</table>
    	
    
    </td>
  </tr>  
  </table>
  
  
  </td>
</tr>
</table>

<p>&nbsp;</p>
<!-- FIRMA DEL FORMULARIO -->
<table width="100%">
<tr>
 <td style="padding-left: 10px; text-align: left; font-family: Tahoma, serifSansSerifMonospace; font-weight: bold; background-color:#EFEFEF; color: #000000; ">Firma</td>
</tr>
</table>    
<table>
<tr>
  <td colspan="3" align="left">Observaciones: <?php echo $envio["observaciones"]; ?></td>			      
</tr>
<tr>
  <td colspan="3">&nbsp;</td>
</tr>
<tr>
  <td valign="top">
     <fieldset style="height: 180px;">
     <legend>Ciudad y fecha de diligenciamiento</legend>	 
	 <table style="margin-top: 20px;">
	 <tr>
	   <td>Ciudad</td>
	   <td colspan="3"><?php echo $envio["dmpio"]; ?></td>
	 </tr>
	 <tr>
	   <td>Fecha de diligenciamiento</td>
	   <td><?php echo $envio["fedili"]; ?></td>			            
	 </tr>	         
	 </table>
	 </fieldset>
  </td>
  <td valign="top">
     <fieldset style="height: 180px;">
	 <legend style="margin-bottom: 10px;">Responsable de la empresa</legend>	 
	 <table style="margin-top: 20px;">
	 <tr>
	   <td>Nombre:</td>
	   <td><?php echo $envio["repleg"]; ?></td>
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
  </td>
  <td valign="top">
     <fieldset style="height: 180px;">
	 <legend style="margin-bottom: 10px;">Persona a quien dirigirse para consultas</legend>	 
	 <table style="margin-top: 20px;">
	   <tr>
	     <td>Nombre:</td>
		 <td><?php echo $envio["responde"]; ?></td>
	   </tr>
	   <tr>
	     <td>Cargo:</td>
	     <td><?php echo $envio["respoca"]; ?></td>
	   </tr>
	   <tr>
	     <td>Tel.:</td>
	     <td><?php echo $envio["teler"]; ?></td>
	   </tr>
	   <tr>
	     <td>Correo electr&oacute;nico:</td>
	     <td><?php echo $envio["emailr"]; ?></td>
	   </tr>
	 </table>
	 </fieldset>
  </td>
</tr>  
</table>
<br>
<p align="center"><b>La no presentaci&oacute;n oportuna de este informe acarrea las sanciones establecidas en la Ley 079 de 1993.</b></p>
<br/>

</body>
</html>