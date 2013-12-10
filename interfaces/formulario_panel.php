				<div class="formulario">
					<h1>Panel de usuario</h1>
					<form id="formularioPanel" name="formularioPanel" action="panel.php" method="post">
						<p>
							<input type="text" name="usuario" maxlength="50" value="<?php echo $_SESSION['nombre']; ?>" disabled="disabled" />
						</p>
						<p>
							<input type="text" name="correo" value="<?php echo $_SESSION['correo']; ?>" maxlength="100" />
						</p>
						<p>
							<input type="text" name="telefono" maxlength="9" value="<?php echo $_SESSION['telefono']; ?>" placeholder="Tel&eacute;fono" />
						</p>
						<p>
							<input id="pass" type="password" name="pass" maxlength="50" placeholder="Actual contrase&ntilde;a" />
						</p>
						<p>
							<input id="pass1" type="password" name="pass1" maxlength="50" placeholder="Nueva contrase&ntilde;a" />
						</p>
						<p>
							<input id="pass2" type="password" name="pass2" maxlength="50" placeholder="Vuelva a escribir la nueva contrase&ntilde;a" />
						</p>
						<p>
<?php
	/*** set a form token ***/
	$form_token = md5( uniqid('auth', true) );
	
	/*** set the session form token ***/
	$_SESSION['form_token'] = $form_token;
?>
							<input type="hidden" name="form_token" value="<?php echo $form_token; ?>" />
							<input type="hidden" name="panel" value="1" />
							<input class="boton" type="submit" value="Modificar" />
						</p>
					</form>
				</div>
