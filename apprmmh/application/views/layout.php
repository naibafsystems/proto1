<?php $this->config->load("sitio");
	  $this->load->helper("url");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html lang="es" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></meta> 
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<!--[if lte IE 9]><link rel="stylesheet" href="<?php echo base_url("css/ie.css"); ?>" type="text/css" media="screen" /><![endif]-->
<link rel="stylesheet" href="<?php echo base_url("css/1140.css"); ?>" type="text/css" media="screen" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url("css/custom-theme/jquery-ui-1.8.18.custom.css"); ?>" />
<link rel="stylesheet" href="<?php echo base_url("css/styles.css"); ?>" type="text/css" media="screen" />
<!-- General -->
<script type="text/javascript" src="<?php echo base_url("js/general/css3-mediaqueries.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/general/jquery-1.7.2.min.js"); ?>"></script>
<!-- <script type="text/javascript" src="<?php //echo base_url("js/general/jquery-1.8.0.min.js"); ?>"></script> -->
<script type="text/javascript" src="<?php echo base_url("js/general/jquery-ui-1.8.18.custom.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/general/jquery.qtip-1.0.0-rc3.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/general/jquery.validate.min.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/general/danevalidator.js"); ?>"></script>
<!-- Fuente -->
<?php if ($controller=="fuente"){ ?>
<script type="text/javascript" src="<?php echo base_url("js/fuente/jsfuente.js");  ?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/fuente/jsmodulo1.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/fuente/jsmodulo2.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/fuente/jsmodulo3.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/fuente/jsmodulo4.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/fuente/jsmodulo5.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/fuente/jsenvioform.js"); ?>"></script>
<?php } ?>

<?php if (($controller!="fuente")&&($controller!="login") && ($controller!="indicadorcalidad")){ ?>
	<!-- Admin -->
	<?php if ($controller=="administrador"){ ?>
	<script type="text/javascript" src="<?php echo base_url("js/admin/jsadmin.js");  ?>"></script>
	<?php } 
	elseif ($controller=="critico"){ ?>
		<!-- Critico -->
		<script type="text/javascript" src="<?php echo base_url("js/critico/jscritico.js");  ?>"></script>
	<?php } 
	elseif ($controller=="asistente"){ ?>
		<!-- Asistente -->	
		<script type="text/javascript" src="<?php echo base_url("js/asistente/jsasistente.js");  ?>"></script>
	<?php } 
	elseif ($controller=="logistica"){ ?>
		<!-- Logistica -->
		<script type="text/javascript" src="<?php echo base_url("js/logistica/jslogistica.js");  ?>"></script>
	<?php } 
	elseif ($controller=="tematica"){ ?>
			<!-- Logistica -->
			<script type="text/javascript" src="<?php echo base_url("js/tematica/jstematica.js");  ?>"></script>
	<?php } ?>
	
<!-- Ficha de analisis -->
<script type="text/javascript" src="<?php echo base_url("js/fichanalisis/jsfichanalisis.js");  ?>"></script>
<!-- Novedades -->
<script type="text/javascript" src="<?php echo base_url("js/novedades/jsnovedades.js");  ?>"></script>
<!-- Carga del directorio -->
<script type="text/javascript" src="<?php echo base_url("js/cargadir/jscargadir.js");  ?>"></script>
<!-- Indicador de calidad -->
<?php }
if (($controller=="indicadorcalidad")&&($controller!="login")){
				   	 						
?>
<script type="text/javascript" src="<?php echo base_url("js/indicador/indicador.js");  ?>"></script>
<script type="text/javascript" src="<?php echo base_url("js/admin/jsadmin.js");  ?>"></script>
<?php } ?>


<title><?php echo $this->config->item("title"); ?></title>
</head>
<body>
<div class="container">
	<?php $this->load->view("template/headernlog"); ?>	
	<?php if (isset($menu)&&($menu!=''))
			  $this->load->view($menu);   
		  else 
		      $this->load->view("template/menu");
	?>
	<div class="row">
		<div id="container2" class="twelvecol last">
		    <div id="contenido">
			    <?php $this->load->view($view); ?>
			</div>
		</div>
	</div>
	<?php $this->load->view("template/footer"); ?>
</div>
</body>
</html>