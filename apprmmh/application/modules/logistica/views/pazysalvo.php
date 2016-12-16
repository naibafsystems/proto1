<?php $this->load->helper("url"); ?>
<form id="frmPazYSalvo" name="frmPazySalvo" method="post" action="<?php echo site_url("logistica/generarPazySalvo"); ?>">
<table width="100%" style="border: 1px solid #CCCCCC;">
<tr>
 <td><img src="<?php echo base_url("images/logo.png");?>"></td>
 <td><h1>Muestra Mensual de Hoteles</h1></td>
</tr>
<tr>
 <td colspan="2" align="center">EL DEPARTAMENTO ADMINISTRATIVO NACIONAL DE ESTADISTICA - DANE HACE CONSTAR QUE:</td>
</tr>
<tr>
  <td colspan="2">&nbsp;</td>
</tr>
<tr>
  <td colspan="2">
  <!-- Tabla de datos -->
  <table width="100%" style="margin-left: 20px; padding-right: 40px;">
  <tr>
    <td>LA EMPRESA <b><?php echo $pyz["idproraz"]; ?></b></td>
  </tr>
  <tr>
    <td>NOMBRE COMERCIAL <b><?php echo $pyz["idnomcom"]; ?></b></td>
  </tr>
  <tr>
    <td>N.I.T: <?php echo $pyz["num_identificacion"]; ?></td>
  </tr>
  <tr>
    <td>DIRECCION: <?php echo $pyz["iddirecc"]; ?></td>
  </tr>
  <tr>
    <td>DEPARTAMENTO: <?php echo $pyz["depto"]; ?></td>
  </tr>
  <tr>
    <td>MUNICIPIO: <?php echo $pyz["mpio"]; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="justify">RINDI&Oacute; LA MUESTRA MENSUAL DE HOTELES CORRESPONDIENTE AL PERIODO <b><?php echo $pyz["periodo"]; ?></b> Y CUMPLI&Oacute; CON LOS REQUISITOS ESTABLECIDOS EN LA LEY 0079 DEL 20 DE OCTUBRE DE 1993, POR
        LO CUAL HA SIDO INSCRITA EN SUS ARCHIVOS EN LA ACTIVIDAD DE SERVICIOS CIIU REV3. LA EMPRESA DEBER&Aacute; IDENTIFICARSE CON EL N&Uacute;MERO: <?php echo $pyz["nro_orden"]; ?> PARA TODOS LOS TR&Aacute;MITES
        REQUERIDOS Y LA INFORMACI&Oacute;N ESTAD&Iacute;STICA QUE LE SEA SOLICITADA POR EL DANE. DE SER NECESARIO, UN FUNCIONARIO DEL DANE SE COMUNICAR&Aacute; CON USTED PARA
        CONFIRMAR LA INFORMACI&Oacute;N SUMINISTRADA EN ESTE FORMULARIO.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>FECHA DE EXPEDICI&Oacute;N: <?php echo date("Y/m/d"); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">DANE: Carrera 59 No. 26-70 Interior I - CAN. Conmutador (571) 5978300 - Fax (571) 5978399<br/>L&iacute;nea gratuita de atenci&oacute;n 01-8000-912002. &oacute; (571) 5978300 Exts. 2532 - 2605</td>
  </tr>
  </table>
  <!--  -->
  </td>
</tr>
</table>
<br/>
<table>
<tr>
  <td><input type="submit" id="btnPazySalvo" name="btnPazySalvo" value="Descargar PDF" class="button"/></td>
</tr>
</table>
<input type="hidden" id="nro_orden" name="nro_orden" value="<?php echo $pyz["nro_orden"]; ?>"/>
<input type="hidden" id="nro_establecimiento" name="nro_establecimiento" value="<?php echo $pyz["nro_establecimiento"]; ?>"/>
</form>