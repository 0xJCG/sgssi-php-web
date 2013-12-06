				<form id="formularioRegistro" name="formularioRegistro" action="registro.php" method="post">
					<p>
						<label>
							Nombre de usuario
							<span class="small">Con un m&aacute;ximo 50 caracteres</span>
						</label>
						<input type="text" name="usuario" maxlength="50" />
						<label>
							Correo electr&oacute;nico
							<span class="small">M&aacute;x. 100 caracteres</span>
						</label>
						<input type="text" name="correo" maxlength="100" />
						<label>
							Contrase&ntilde;a
							<span class="small">Introduzca su contrase&ntilde;a</span>
						</label>
						<input type="password" name="pass1" maxlength="50" />
						<label>
							Contrase&ntilde;a
							<span class="small">Vuelva a introducir su contrase&ntilde;a</span>
						</label>
						<input type="password" name="pass2" maxlength="50" />
						<br />
<?php
	/*** set a form token ***/
	$form_token = md5( uniqid('auth', true) );
	
	/*** set the session form token ***/
	$_SESSION['form_token'] = $form_token;
?>
						<input type="hidden" name="form_token" value="<?php echo $form_token; ?>" />
						<input type="hidden" name="registro" value="1" />
						<input class="boton" name="registrar" type="submit" value="Registrar" />
						<!-- <input class="boton" name="registrar" type="button" value="Registrar" onclick="comprobarDatos(this.form)" /> -->
						<input class="boton" name="volver" type="button" value="Volver" onclick="javascript:history.back()" />
					</p>
				</form>
