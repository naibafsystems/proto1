<?php $this->load->helper("url"); ?>
<table width="100%" class="table">
  <thead>
    <tr>
      <th>Descripci&oacute;n</th>
      <th align="center">Total</th>
      <th align="center">Porcentaje</th>
    </tr>
  </thead>
  <tbody>
  	<tr class="row1">
  		<td>Directorio Base</td>
  		<td align="center"><?php if ($informe["directorio_base"] > 0)
  									echo '<a href="'.site_url("administrador/detalleOperativo/0/$sede/$subsede").'">'.$informe["directorio_base"].'</a>';
  								 else 
  								 	echo $informe["directorio_base"];	 
  						   ?>
  		</td>
  		<td align="center"><?php echo $informe["pct_dbase"]; ?></td>
  	</tr>
  	<tr class="row2">
  	  <td>Nuevos</td>
  	  <td align="center"><?php if ($informe["nuevos"] > 0)
  	  							   echo '<a href="'.site_url("administrador/detalleOperativo/1/$sede/$subsede").'">'.$informe["nuevos"].'</a></td>';
  	    					   else
  	  							   echo $informe["nuevos"]; 
  	  				     ?>
  	  </td>
  	  <td align="center"><?php echo $informe["pct_nuevos"]; ?></td>
  	</tr>
  	<tr class="row1">
  	  <td>Total a recolectar</td>
  	  <td align="center"><?php if ($informe["total_recolectar"] > 0)
  	  							   echo '<a href="'.site_url("administrador/detalleOperativo/2/$sede/$subsede").'">'.$informe["total_recolectar"].'</a></td>';
  	  						   else 	
  	  							   echo $informe["total_recolectar"]; 
  	  					 ?>
  	  </td>
  	  <td align="center"><?php echo $informe["pct_totrecolectar"]; ?></td>
  	</tr>
  	<tr class="row2">
  	  <td>Sin distribuir</td>
  	  <td align="center"><?php if ($informe["sin_distribuir"] > 0)
  	  							   echo '<a href="'.site_url("administrador/detalleOperativo/3/$sede/$subsede").'">'.$informe["sin_distribuir"].'</a></td>';
  	  						   else
  	  						   	   echo $informe["sin_distribuir"];
  	  				     ?>
  	  </td>				     		   	   			
  	  <td align="center"><?php echo $informe["pct_sindistribuir"]; ?></td>
  	</tr>
  	<tr class="row1">
  	  <td>Distribuidos</td>
  	  <td align="center"><?php if ($informe["distribuidos"] > 0)
  	  							   echo '<a href="'.site_url("administrador/detalleOperativo/4/$sede/$subsede").'">'.$informe["distribuidos"].'</a></td>';
  	  						   else
  	  							   echo $informe["distribuidos"]; 
  	  					 ?>
  	  </td>
  	  <td align="center"><?php echo $informe["pct_distribuidos"]; ?></td>
  	</tr>
  	<tr class="row2">
  	  <td>En digitaci&oacute;n</td>
  	  <td align="center"><?php if ($informe["digitacion"] > 0)
  	  							   echo '<a href="'.site_url("administrador/detalleOperativo/5/$sede/$subsede").'">'.$informe["digitacion"].'</a></td>';
  	  						   else	
  	  							   echo $informe["digitacion"]; 
  	  					 ?>
  	  </td>
  	  <td align="center"><?php echo $informe["pct_digitacion"]; ?></td>
  	</tr>
  	<tr class="row1">
  	  <td>Digitados</td>
  	  <td align="center"><?php if ($informe["digitados"] > 0)
  	  							   echo '<a href="'.site_url("administrador/detalleOperativo/6/$sede/$subsede").'">'.$informe["digitados"].'</a></td>';
  	  						   else	
  	  							   echo $informe["digitados"]; 
  	  					 ?>
  	  </td>  	  	
  	  <td align="center"><?php echo $informe["pct_digitados"]; ?></td>
  	</tr>
  	<tr class="row2">
  	  <td>An&aacute;lisis - Verificaci&oacute;n</td>
  	  <td align="center"><?php if ($informe["analisis_verificacion"] > 0)
  	  						       echo '<a href="'.site_url("administrador/detalleOperativo/7/$sede/$subsede").'">'.$informe["analisis_verificacion"].'</a></td>';
  	  						   else	
  	  							   echo $informe["analisis_verificacion"]; 
  	  					 ?>
  	  </td>
  	  <td align="center"><?php echo $informe["pct_analisisver"]; ?></td>
  	</tr>
  	<tr class="row1">
  	  <td>Verificados</td>
  	  <td align="center"><?php if ($informe["verificados"] > 0)
  	  							   echo '<a href="'.site_url("administrador/detalleOperativo/8/$sede/$subsede").'">'.$informe["verificados"].'</a></td>';
  	  						   else			
  	  							   echo $informe["verificados"]; 
  	  					 ?>
  	  </td>
  	  <td align="center"><?php echo $informe["pct_verificados"]; ?></td>
  	</tr>
  	<tr class="row2">
  	  <td>Novedades</td>
  	  <td align="center"><?php if ($informe["novedades"] > 0)
  	  							   echo '<a href="'.site_url("administrador/detalleOperativo/9/$sede/$subsede").'">'.$informe["novedades"].'</a></td>';
  	  						   else	
  	  							   echo $informe["novedades"]; 
  	  					 ?>
  	  </td>
  	  <td align="center"><?php echo $informe["pct_novedades"]; ?></td>
  	</tr>
  </tbody>
</table>