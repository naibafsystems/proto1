<form id="frmUsuarios" name="frmUsuarios" method="post" action="">
<table width="100%" class="table">
<thead class="thead">
	<tr>
    	<th width="50%">Nombre</th>
     	<th>Nivel</th>
     	<th>Sede</th>
     	<th>Fuentes</th>
     	<th align="center" width="5%">Modificar</th>
     	<th align="center" width="5%">Eliminar</th>
     	<th align="center" width="8%">Asignar fuentes</th>
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
	    <td><?php echo utf8_encode($usuarios[$i]["rol"]); ?></td>
	    <td><?php echo utf8_encode($usuarios[$i]["sede"]); ?></td>
	    <td><?php echo $usuarios[$i]["fuentes"]; ?></td>
	    <td align="center"><a href="javascript:modificarUsuario(<?php echo $usuarios[$i]["id"]; ?>);"><img src="<?php echo base_url("images/edit.png"); ?>" border="0"/></a></td>
	    <td align="center"><a href="javascript:eliminarUsuario(<?php echo $usuarios[$i]["id"]; ?>);"><img src="<?php echo base_url("images/delete.png"); ?>" border="0"/></a></td>
	    <td align="center">
	   	<?php  //Solo se pueden asignar fuentes a los usuarios criticos. (Por eso el IF).  
	   			if ($usuarios[$i]["idxrol"]==2){
	   	?>			<a href="<?php echo site_url("administrador/asignarFuentes/".$usuarios[$i]["id"]); ?>"><img src="<?php echo base_url("images/go.png"); ?>" border="0"/></a>
	   	<?php  }  ?>
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
    <td colspan="2" align="right">&nbsp;</td>
    <td colspan="3" align="right"><?php echo $paginador; ?></td>         
</tr>    
</tfoot>
</table>   
</form>