<script type="text/javascript">

$(function(){

	$("#txtNumId").numerico();
	$("#txtNomUsuario").mayusculas();	
	$("#txtFecCreacion").datepicker();
	$("#txtFecVencimiento").datepicker();
	$("#cmbsede").cargarCombo("cmbSubsede","administrador/actualizarSubsedes");

	$("#frmINSusuario").validate({
		//Reglas de validacion
		rules: {
			cmbTipoDocumento: {	required: true,
				                comboBox: '-'
			},
			txtNumId: {	required: true
			},
			txtNomUsuario: { required: true
			},
			txtLogin: { required: true
			},
			txtPassword: { required: true
			},
			txtEmail: {	required: true,
				        email: true
			},
			txtFecCreacion: { required: true	
			},
			txtFecVencimiento: { required: true 
			},
			cmbRol: { required: true,
					  comboBox:'-'
            },
            cmbsede: {	required: true,
					    comboBox: '-'
            },
            cmbSubsede: { required: true,
					      comboBox: '-'
            }
		},
		messages: {
			cmbTipoDocumento: {	required : "Debe indicar el tipo de documento del usuario.",
				                comboBox : "Debe indicar el tipo de documento del usuario."
			},
			txtNumId: {	required: "Debe indicar el n&uacute;mero de documento del usuario."
			},
			txtNomUsuario: { required: "Debe indicar los nombres y apellidos del usuario."	
			},
			txtLogin: { required: "Debe ingresar un login para el usuario."
			},
			txtPassword: { required: "Debe ingresar una contrase&ntilde;a para el usuario."
			},
			txtEmail: {	required: "Debe ingresar el email del usuario.",
				        email: "No es un email v&aacute;lido."
			},
			txtFecCreacion: { required: "Debe ingresar la fecha de creaci&oacute;n del usuario."
			},
			txtFecVencimiento: { required: "Debe ingresar la fecha de vencimiento del usuario."	
			},
			cmbRol: { required: "Debe seleccionar el rol del usuario.",
				      comboBox: "Debe seleccionar el rol del usuario." 
			},
			cmbsede: { required: "Debe seleccionar la sede del usuario.",
				       comboBox: "Debe seleccionar la sede del usuario."
			},
			cmbSubsede: { required: "Debe seleccionar la subsede del usuario.",
				          comboBox: "Debe seleccionar la subsede del usuario."
			}
		},
		//Mensajes de error
		errorPlacement: function(error, element) {
			element.after(error);		        
			error.css('display','inline');
			error.css('margin-left','10px');				
			error.css('color',"#FF0000");
		},
		//Envio del formulario
		submitHandler: function(form) {
			
			//Valido que el numero de identificacion del usuario ni el login ya estén registrados, 
			$.ajax({
				type: "POST",
				url: base_url + "administrador/validaNitLogin",
				data: {'tipodoc': $("#cmbTipoDocumento").val(),
					   'numdoc': $("#txtNumId").val(),
					   'login': $("#txtLogin").val() 
				},
				dataType: "html", 
				cache: false,
				success: function(data){
					var test = eval("("+data+")");					
					$("#errorNumID").css('display','inline');
					$("#errorNumID").css('margin-left','10px');				
					$("#errorNumID").css('color',"#FF0000");
				    $("#errorNumID").html(test.error);
					if (test.valid!=false){
						form.submit();
						//location.reload();
					}			    										
				}
			});
		}
		
	});
});

</script>

<?php $this->load->helper("url"); ?>
   <br/>
   <h1>Agregar Nuevo Usuario</h1>
   <br/>
   <form id="frmINSusuario" name="frmINSusuario" method="post" action="<?php echo site_url("administrador/insertarUsuario"); ?>">
   <table width="100%">
   <tr>
     <td width="150">Tipo documento: </td>
     <td><select id="cmbTipoDocumento" name="cmbTipoDocumento" class="select">
     	 <option value="-">Seleccione el tipo de documento...</option>
         <?php for ($i=0; $i<count($tipodoc); $i++){
     	 	 		echo '<option value="'.$tipodoc[$i]["id"].'">'.$tipodoc[$i]["nombre"].'</option>';
     	 		}
     	 ?>
         </select>
     </td>
   </tr>
   <tr>
     <td>Num. Identificaci&oacute;n: </td>
     <td><input type="text" id="txtNumId" name="txtNumId" value="" class="textbox"/><div id="errorNumID"></div></td>
   </tr>
   <tr>
     <td>Nombre Usuario: </td>
     <td><input type="text" id="txtNomUsuario" name="txtNomUsuario" value="" size="50" class="textbox"/></td>
   </tr>
   <tr>
     <td>Login: </td>
     <td><input type="text" id="txtLogin" name="txtLogin" value="" class="textbox" maxlength="20"/><div id="errorLogin"></div></td>
   </tr>
   <tr>
     <td>Password: </td>
     <td><input type="text" id="txtPassword" name="txtPassword" value="" class="textbox"/></td>
   </tr>
   <tr>
     <td>Email: </td>
     <td><input type="text" id="txtEmail" name="txtEmail" value="" size="50" class="textbox"/></td>
   </tr>
   <tr>
     <td>Fecha creaci&oacute;n: </td>
     <td><input type="text" id="txtFecCreacion" name="txtFecCreacion" value="<?php echo date("d/m/Y"); ?>" class="textbox"/></td>
   </tr>
   <tr>
     <td>Fecha vencimiento: </td>
     <td><input type="text" id="txtFecVencimiento" name="txtFecVencimiento" value="" class="textbox"/></td>
   </tr>
   <tr>
     <td>Rol: (*)</td>
     <td><select id="cmbRol" name="cmbRol" class="select">
         <option value="-">Seleccione el rol...</option>
         <?php for ($i=0; $i<count($roles); $i++){
         	   		echo '<option value="'.$roles[$i]["id"].'">'.$roles[$i]["nombre"].'</option>';
     	 		}
     	 ?>
         </select>
     </td>
   </tr>
   <tr>
     <td>Sede: </td>
     <td><select id="cmbsede" name="cmbsede" class="select">
         <option value="-">Seleccione la sede...</option>
         <?php for ($i=0; $i<count($sedes); $i++){
     	       		echo '<option value="'.$sedes[$i]["id"].'">'.$sedes[$i]["nombre"].'</option>';
     	 		}
     	 ?>
         </select>
     </td>
   </tr>
   <tr>
     <td>Subsede: </td>
     <td><select id="cmbSubsede" name="cmbSubsede" class="select">
     	 <option value="-">Seleccione la subsede...</option>
     	 <?php for ($i=0; $i<count($subsedes); $i++){
     	 	   		echo '<option value="'.$subsedes[$i]["id"].'">'.$subsedes[$i]["nombre"].'</option>';
     	 	   }
     	 ?>
         </select>
     </td>
   </tr>
   <tr>
     <td colspan="2">&nbsp;</td>
   </tr>
   <tr>
     <td colspan="2"><input type="submit" id="btnUsuarioADM" name="btnUsuarioADM" value="Agregar" class="button"/></td>
   </tr>
   </table>
   </form>

