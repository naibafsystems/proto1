<!-- -->
<style>
	.links strong{
		color: #F00;
	}
	
	
	.links a:link {
		padding: 2px 2px 2px 2px;
		text-align: center;
		text-decoration: none;
		font-size: 12px;
		color: #000;
		background: #FFFFFF;
	}
	
	.links a:visited {
		/*border: 1px solid #F00;*/
		padding: 2px 2px 2px 2px;
		text-align: center;
		text-decoration:none;
		font-size: 12px; 
		color:#000;
	} 
	
	.links a:hover {
		border: 1px solid #000;
		padding: 2px 2px 2px 2px;
		text-decoration:underline;
		font-weight: bolder; 
		color:#F00; 
		background: #EEEEEE;
	}
</style>
<?php  //if (($ano_periodo == $reciente["ano"])&&($mes_periodo == $reciente["mes"])){ ?>   
		  <div class="row">
	         <div class="fivecol"><h1>Usuarios</h1></div>
	         <div style="text-align: right;" class="sixcol">
	            <input type="button" id="btnInsertar" name="btnInsertar" value="Agregar Usuario" class="button"/>
	         </div>
          </div>	 
<?php  //} ?>

<table width="100%" style="font-size: 11px;">
<tr>
 <td>
   <div id="divUsuarios">
   <form id="frmUsuarios" name="frmUsuarios" method="post" action="">
   <table width="100%" class="table">
   <thead class="thead">
   <tr>
     <th width="40%">Nombre</th>
     <th>Nivel</th>
     <th>Sede</th>
     <th align="center" width="10%">Fuentes</th>
     <th align="center" width="10%">Modificar</th>
     <th align="center" width="10%">Eliminar</th>
     <th align="center" width="10%">Asignar fuentes</th>
   </tr>
   </thead>
   <tbody>
   <?php for ($i=0; $i<count($usuarios); $i++){
   			if (($i%2)==0)
   				$class = "row1";
   			else 
   				$class = "row2";	 
   ?>
	   <tr class="<?php echo $class; ?>">
	     <td>&nbsp;&nbsp;<?php echo strtoupper($usuarios[$i]["nombre"]); ?></td>
	     <td><?php echo $usuarios[$i]["rol"]; ?></td>
	     <td><?php echo $usuarios[$i]["sede"]; ?></td>
	     <td align="center"><a href="<?php echo site_url("administrador/fuentesasignadas/".$usuarios[$i]["id"]); ?>"><?php echo $usuarios[$i]["fuentes"]; ?></a></td>
	     <td align="center">
	     	 <?php  //if (($ano_periodo == $reciente["ano"])&&($mes_periodo == $reciente["mes"])){ ?> 
	     	 	<a href="javascript:modificarUsuarioADM(<?php echo $usuarios[$i]["id"]; ?>);"><img src="<?php echo base_url("images/edit.png"); ?>" border="0"/></a>
	     	 <?php //} ?>
	     </td>
	     <td align="center">
	     	 <?php  //if (($ano_periodo == $reciente["ano"])&&($mes_periodo == $reciente["mes"])){ 
	     				if ($usuarios[$i]["idxrol"]!=4){ ?>
	     				<a href="javascript:eliminarUsuarioADM(<?php echo $usuarios[$i]["idxrol"]; ?>,<?php echo $usuarios[$i]["id"]; ?>);"><img src="<?php echo base_url("images/delete.png"); ?>" border="0"/></a>
	     				<?php } ?>
	     	  <?php //} ?>	
	     </td>
	     <td align="center">
	   		  <?php //if (($ano_periodo == $reciente["ano"])&&($mes_periodo == $reciente["mes"])){ 
		     	       //Solo se pueden asignar fuentes a los usuarios criticos y logistica. (Por eso el IF).
		     	       // idxrol 2 = critica
		     	       // idxrol 5 = logistica  
		   			   if ($usuarios[$i]["idxrol"]==2){
		   	  ?>		   <a href="<?php echo site_url("administrador/asignarFuentes/".$usuarios[$i]["id"]); ?>"><img src="<?php echo base_url("images/go.png"); ?>" border="0"/></a>
		   	  <?php    } 
		   	  		   else if ($usuarios[$i]["idxrol"]==5){
		   	  ?>		   <a href="<?php echo site_url("administrador/asignarFuentesLOG/".$usuarios[$i]["id"]); ?>"><img src="<?php echo base_url("images/go.png"); ?>" border="0"/></a>		   	
		   	  <?php    }
		   	        //} 
		   	  ?>	  
	     </td>
	   </tr>
   <?php } ?>
   </tbody>   
   <!-- links -->
   <tfoot>
	<tr>
  		<td colspan="7">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" align="left">&nbsp;</td>
		<td colspan="4" align="right" class="links"><?php echo $links; ?></td>
	</tr>
	</tfoot>
   <!-- links -->
   </table>   
   </form>
   </div>   
 </td> 
</tr>
<tr>
 <td>
   <div id="detalle"></div>
 </td> 
</tr>
</table>