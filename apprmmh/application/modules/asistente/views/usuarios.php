<!-- -->
<?php  
	$ano = $this->session->userdata("ano_periodo");
	$mes = $this->session->userdata("mes_periodo");
?>


<table width="100%">
<tr>
 <td>
   <div id="divUsuarios">
   <div class="row">
    <div class="fivecol"><h1>Usuarios</h1></div>
    <?php //if (($reciente["ano"]==$ano)&&($reciente["mes"]==$mes)){ ?>
    	<div style="text-align: right;" class="sixcol"><input type="button" id="btnNuevoUsuario" name="btnNuevoUsuario" value="Agregar Usuario" class="button"/></div>
    <?php //} ?>
	</div>	
   <form id="frmUsuarios" name="frmUsuarios" method="post" action="">
   <table width="100%" class="table" style="font-size: 11px;">
   <thead class="thead">
   <tr>
     <th width="40%">Nombre</th>
     <th>Nivel</th>
     <th>Sede</th>
     <th align="center" width="10%">Fuentes</th>
     <th align="center" width="10%">Modificar</th>
     <!--  Se Elimina esta opcion por problemas que se presentan con la eliminacion de las fuentes para un periodo particular 
       <th align="center" width="10%">Eliminar</th>
     -->
     <th align="center" width="10%">Asignar fuentes</th>
   </tr>
   </thead>
   <tbody>
   <?php for ($i=0; $i<count($criticos); $i++){
   			if (($i%2)==0)
   				$class = "row1";
   			else 
   				$class = "row2";	 
   ?>
	   <tr class="<?php echo $class; ?>">
	     <td>&nbsp;&nbsp;<?php echo $criticos[$i]["nombre"]; ?></td>
	     <td><?php echo $criticos[$i]["rol"]; ?></td>
	     <td><?php echo $criticos[$i]["sede"]; ?></td>
	     <td align="center"><?php echo $criticos[$i]["fuentes"]; ?></td>
	     <td align="center">
	     	 <?php //if (($reciente["ano"]==$ano)&&($reciente["mes"]==$mes)){ ?>
	     	 	<a href="javascript:modificarUsuario(<?php echo $criticos[$i]["id"]; ?>);"><img src="<?php echo base_url("images/edit.png"); ?>" border="0"/></a>
	     	 <?php //} ?>	
	     </td>
	     
	     <!-- Se elimina esta opcio por problemas que se presentan con la eliminacion de las fuentes para un periodo particular  
	     <td align="center">
	     	 <?php /*
	     		<a href="javascript:eliminarUsuario(<?php echo $criticos[$i]["idxrol"]; ?>,<?php echo $criticos[$i]["id"]; ?>);"><img src="<?php echo base_url("images/delete.png"); ?>" border="0"/></a>
	     	       */ 
	     	 ?>	
	     </td>
	     -->
	     <td align="center">
	   		 <?php //if (($reciente["ano"]==$ano)&&($reciente["mes"]==$mes)){ ?>
	   		 	<a href="<?php echo site_url("asistente/asignarFuentes/".$criticos[$i]["id"]); ?>"><img src="<?php echo base_url("images/go.png"); ?>" border="0"/></a>
	   		 <?php //} ?>	
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