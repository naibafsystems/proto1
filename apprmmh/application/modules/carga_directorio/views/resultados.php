<h1>Resultados de la carga del directorio</h1>

<?php if (count($errores)>0){
	     echo "<h3>Errores en la carga del directorio</h3>";
	     for ($i=0; $i<count($errores); $i++){
	     	echo $errores[$i]."<br/>"; 
	     }
      }
      echo "<br/><br/>";
      if ($inserts > 0){
      	 echo "<h3>Se insertaron $inserts registros nuevos.</h3>";
      }
      else{
      	 echo "No se insertaron registros nuevos.";
      }
?>
<br/><br/><br/>