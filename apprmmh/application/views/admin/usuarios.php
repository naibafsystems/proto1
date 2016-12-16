<?php 
	$this->load->library("session");
	$ano = $this->session->userdata("ano_periodo");
	$mes = $this->session->userdata("mes_periodo");
?>
<?php  if (($ano == $reciente["ano"])&&($mes == $reciente["mes"])){ ?>   
		  <div class="row">
	         <div class="fivecol"><h1>Usuarios</h1></div>
	         <div style="text-align: right;" class="sixcol"><input type="button" id="btnInsertar" name="btnInsertar" value="Agregar Usuario" class="button"/></div>
          </div>	 
<?php  } ?>
<table width="100%">
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
	     <td>&nbsp;&nbsp;<?php echo $usuarios[$i]["nombre"]; ?></td>
	     <td><?php echo $usuarios[$i]["rol"]; ?></td>
	     <td><?php echo $usuarios[$i]["sede"]; ?></td>
	     <td align="center"><?php echo $usuarios[$i]["fuentes"]; ?></td>
	     <td align="center">
	     	 <?php  if (($ano == $reciente["ano"])&&($mes == $reciente["mes"])){ ?> 
	     	 	<a href="javascript:modificarUsuarioADM(<?php echo $usuarios[$i]["id"]; ?>);"><img src="<?php echo base_url("images/edit.png"); ?>" border="0"/></a>
	     	 <?php } ?>
	     </td>
	     <td align="center">
	     	 <?php  if (($ano == $reciente["ano"])&&($mes == $reciente["mes"])){ ?>
	     		<a href="javascript:eliminarUsuarioADM(<?php echo $usuarios[$i]["id"]; ?>);"><img src="<?php echo base_url("images/delete.png"); ?>" border="0"/></a>
	     	  <?php } ?>	
	     </td>
	     <td align="center">
	   		  <?php if (($ano == $reciente["ano"])&&($mes == $reciente["mes"])){ 
		     	       //Solo se pueden asignar fuentes a los usuarios criticos y logistica. (Por eso el IF).  
		   			   if (($usuarios[$i]["idxrol"]==2)||($usuarios[$i]["idxrol"]==5)){
		   	  ?>		   <a href="<?php echo site_url("administrador/asignarFuentes/".$usuarios[$i]["id"]); ?>"><img src="<?php echo base_url("images/go.png"); ?>" border="0"/></a>
		   	  <?php    } 
		   	        } 
		   	  ?>	  
	     </td>
	   </tr>
   <?php } ?>
   </tbody>   
   <tfoot>
       <tr>
         <td colspan="7" align="right">&nbsp;</td>
       </tr>
       <tr>
         <td colspan="2"><b>Total registros: <?php echo $total; ?></b></td>
         <td colspan="3" align="right">&nbsp;</td>
         <td colspan="2" align="right"><?php echo $paginador; ?></td>         
       </tr>    
   </tfoot>
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