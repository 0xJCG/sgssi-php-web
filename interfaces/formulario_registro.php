				<div class="formulario">
					<h1>Formulario de registro</h1>
					<form id="formularioRegistro" name="formularioRegistro" action="registro.php" method="post">
						<p>
							<input type="text" name="usuario" maxlength="50" placeholder="Usuario" />
						</p>
						<p>
							<input type="text" name="correo" maxlength="100" placeholder="Correo electr&oacute;nico" />
						</p>
						<p>
							<input id="pass1" type="password" name="pass1" maxlength="50" placeholder="Contrase&ntilde;a" />
						</p>
						<p>
							<input type="password" name="pass2" maxlength="50" placeholder="Vuelva a escribir la contrase&ntilde;a" />
						</p>
						<p>
<?php
	/*** set a form token ***/
	$form_token = md5( uniqid('auth', true) );
	
	/*** set the session form token ***/
	$_SESSION['form_token'] = $form_token;
?>
							<input type="hidden" name="form_token" value="<?php echo $form_token; ?>" />
							<input type="hidden" name="registro" value="1" />
							<input class="boton" type="submit" value="Registrar" />
							<!-- <input class="boton" name="registrar" type="button" value="Registrar" onclick="comprobarDatos(this.form)" /> -->
							<input class="boton" name="volver" type="button" value="Volver" onclick="javascript:history.back()" />
						</p>
					</form>
				</div>
