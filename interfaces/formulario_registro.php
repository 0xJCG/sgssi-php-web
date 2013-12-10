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
							<input type="text" name="telefono" maxlength="9" placeholder="Tel&eacute;fono" />
						</p>
						<p>
							<input id="pass1" type="password" name="pass1" maxlength="50" placeholder="Contrase&ntilde;a" />
						</p>
						<p>
							<input id="pass2" type="password" name="pass2" maxlength="50" placeholder="Vuelva a escribir la contrase&ntilde;a" />
						</p>
						<p>
<?php
	/* Realizamos un token para evitar el Cross Site Request Forgery. */
	/* Solo validaremos el formulario si ha sido enviado desde la propia web. */
	/* Para ello, mas adelante se comprobara que este token sea el correcto, por lo que lo pondremos en el formulario actual y en una variable de sesion. */
	/* Este token sera aleatorio. */
	$token = md5(uniqid('auth', true));
	$_SESSION['token'] = $token;
?>
							<input type="hidden" name="token" value="<?php echo $token; ?>" />
							<input type="hidden" name="registro" value="1" />
							<input class="boton" type="submit" value="Registrar" />
							<!-- <input class="boton" name="registrar" type="button" value="Registrar" onclick="comprobarDatos(this.form)" /> -->
							<input class="boton" name="volver" type="button" value="Volver" onclick="javascript:history.back()" />
						</p>
					</form>
				</div>
