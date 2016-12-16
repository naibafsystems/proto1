<script type="text/javascript">
$(function(){


	$("#cmbsede").cargarCombo("cmbsubsede","administrador/actualizarSubsedes");

	$("#txtFecCreacion").datepicker();
	$("#txtFecVencimiento").datepicker();

	$("#frmUPDusuario").validate({
		//Reglas de Validacion
		rules : {
			cmbTipoDocumento  : {	required   :   true,				
									comboBox   :   '-'
			},
			txtNumId          : {	required   :   true
			},
			txtNomUsuario     : {	required   :   true
			},
			txtLogin          : {   required   : true
	        },
	        txtPassword       : {	required   : true
	        },
	        txtEmail          : {	required   : true,
	        						email      : true
	        },
	        txtFecCreacion    : {	required   : true
	        },
	        txtFecVencimiento : {	required   : true
	        },
	        cmbRol            : {	required   : true,
	        						comboBox   :'-'
	        },
	        cmbsede           : {	required   : true,
	        						comboBox   : '-'
	        }
		},
		//Mensajes de validacion
		messages : {
			cmbTipoDocumento  : {	required   :   "Debe indicar el tipo de documento del usuario.",
							        comboBox   :   "Debe indicar el tipo de documento del usuario."
			},
			txtNumId          : {	required   :   "Debe indicar el numero de documento del usuario."
			},
			txtNomUsuario     : {	required   :   "Debe indicar los nombres y apellidos del usuario."
			},
			txtLogin          : {	required   :   "Debe ingresar el login del usuario."
			},
			txtPassword       : {	required   :   "Debe ingresar la contrase&ntilde;a del usuario."
			},
			txtEmail          : {	required   :   "Debe ingresar el email del usuario.",
									email      :   "No es un email v&aacute;lido."
			},
			txtFecCreacion    : {	required   :   "Debe ingresar la fecha de creación del usuario."
			},
			txtFecVencimiento : {	required   :   "Debe ingresar la fecha de vencimiento del usuario."
			},
			cmbRol            : {	required   :   "Debe seleccionar el rol del usuario.",
									comboBox   :   "Debe seleccionar el rol del usuario."
			},
			cmbsede           : {	required   :   "Debe seleccionar la sede del usuario.",
									comboBox   :   "Debe seleccionar la sede del usuario."
			}
		},
		//Mensajes de error
		errorPlacement: function(error, element) {
			element.after(error);		        
			error.css('display','inline');
			error.css('margin-left','10px');				
			error.css('color',"#FF0000");
		},
		submitHandler: function(form) {
			this.form.submit();
		}
	});
	
});
</script>
<?php $this->load->helper("url"); ?>
<br/>
<h1>Modificar Usuario</h1>
<br/>
<form id="frmUPDusuario" name="frmUPDUsuario" method="post" action="<?php echo site_url("administrador/actualizarUsuario"); ?>">
<table width="100%">
<tr>
	<td width="150">Tipo documento: </td>
    <td><select id="cmbTipoDocumento" name="cmbTipoDocumento" class="select">
        <option value="-">Seleccione el tipo de documento...</option>
        <?php for ($i=0; $i<count($tipodoc); $i++){
     	 		 if ($usuario["fk_tipodoc"]==$tipodoc[$i]["id"])
         			echo '<option value="'.$tipodoc[$i]["id"].'" selected="selected">'.utf8_encode($tipodoc[$i]["nombre"]).'</option>';
         		 else	
         		 	echo '<option value="'.$tipodoc[$i]["id"].'">'.utf8_encode($tipodoc[$i]["nombre"]).'</option>';
     	}?>
        </select>
    </td>
</tr>
<tr>
    <td>Num. Identificaci&oacute;n: </td>
    <td><input type="text" id="txtNumId" name="txtNumId" value="<?php echo $usuario["num_identificacion"]; ?>" class="textbox"/></td>
</tr>
<tr>
    <td>Nombre Usuario: </td>
    <td><input type="text" id="txtNomUsuario" name="txtNomUsuario" value="<?php echo utf8_encode($usuario["nombre"]); ?>" size="50" class="textbox"/></td>
</tr>
<tr>
    <td>Login: </td>
    <td><input type="text" id="txtLogin" name="txtLogin" value="<?php echo $usuario["log_usuario"]; ?>" class="textbox"/></td>
</tr>
<tr>
    <td>Password: </td>
    <td><input type="text" id="txtPassword" name="txtPassword" value="<?php echo $usuario["pass_usuario"]; ?>" class="textbox"/></td>
</tr>
<tr>
    <td>Email: </td>
    <td><input type="text" id="txtEmail" name="txtEmail" value="<?php echo $usuario["email"]; ?>" size="50" class="textbox"/></td>
</tr>
<tr>
    <td>Fecha creaci&oacute;n: </td>
    <td><input type="text" id="txtFecCreacion" name="txtFecCreacion" value="<?php echo $usuario["fec_creacion"]; ?>" class="textbox"/></td>
</tr>
<tr>
    <td>Fecha vencimiento: </td>
    <td><input type="text" id="txtFecVencimiento" name="txtFecVencimiento" value="<?php echo $usuario["fec_vencimiento"]; ?>" class="textbox"/></td>
</tr>
<tr>
    <td>Rol: </td>
    <td><select id="cmbRol" name="cmbRol" class="select">
        <option value="-">Seleccione el rol...</option>
        <?php for ($i=0; $i<count($roles); $i++){
         		  if ($usuario["rol"]==$roles[$i]["id"])
     	    		 echo '<option value="'.$roles[$i]["id"].'" selected="selected">'.utf8_encode($roles[$i]["nombre"]).'</option>';
     	    	  else	
     	    	     echo '<option value="'.$roles[$i]["id"].'">'.utf8_encode($roles[$i]["nombre"]).'</option>';
        }?>
        </select>
    </td>
</tr>
<tr>
    <td>Sede: </td>
    <td><select id="cmbsede" name="cmbsede" class="select">
        <option value="-">Seleccione la sede...</option>
        <?php for ($i=0; $i<count($sedes); $i++){
     	          if ($usuario["sede"]==$sedes[$i]["id"])	
         		     echo '<option value="'.$sedes[$i]["id"].'" selected="selected">'.utf8_encode($sedes[$i]["nombre"]).'</option>';
         		  else		
         		     echo '<option value="'.$sedes[$i]["id"].'">'.utf8_encode($sedes[$i]["nombre"]).'</option>';
        }?>
        </select>
    </td>
</tr>
<tr>
    <td>Subsede:</td>
    <td><select id="cmbsubsede" name="cmbsubsede" class="select">
        <option value="-">Seleccione la sede...</option>
        <?php for ($i=0; $i<count($subsedes); $i++){
     	          if ($usuario["subsede"]==$subsedes[$i]["id"])	
         		     echo '<option value="'.$subsedes[$i]["id"].'" selected="selected">'.utf8_encode($subsedes[$i]["nombre"]).'</option>';
         		  else		
         		     echo '<option value="'.$subsedes[$i]["id"].'">'.utf8_encode($subsedes[$i]["nombre"]).'</option>';
        }?>
        </select>
    </td>
</tr>
<tr>
    <td colspan="2">&nbsp;</td>
</tr>
<tr>
    <td colspan="2"><input type="submit" id="btnInsertar" name="btnInsertar" value="Modificar Datos" class="button"/></td>
</tr>
</table>
<input type="hidden" id="hddIndex" name="hddIndex" value="<?php echo $index; ?>"/>
</form>