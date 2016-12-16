<?php 

	switch($message){ 
		case 0: //No se produjeron errores
			    echo "<table>";
			    echo "<tr>";
			    echo "  <td><h1>Cierre de Periodo</h1></td>"; 
			    echo "</tr>";
			    echo "<tr>";
			    echo "  <td><h3>El cierre del periodo se ha realizado exit&oacute;samente.</h3></td>"; 
			    echo "</tr>";
			    echo "<tr>";
			    echo "  <td>Se cre&oacute; el registro del nuevo periodo <b>$nuevo</b>. Se crearon <b>$contador</b> fuentes para el nuevo periodo.</td>"; 
			    echo "</tr>";
			    echo "</table>";
			    break;
			
		case 1: //Ya se borro el periodo.
			    echo "<table>";
			    echo "<tr>";
			    echo "  <td><h1>Cierre de periodo</h1></td>"; 
			    echo "</tr>";
			    echo "<tr>";
			    echo "  <td><h3>El periodo seleccionado ya ha sido cerrado.</h3></td>"; 
			    echo "</tr>";
			    echo "</table>";
			    break;	
			
	}
?>
