				<div class="formulario">
					<h1>Panel de usuario</h1>
					<form id="formularioPanel" name="formularioPanel" action="panel.php" method="post">
						<p>
							<label>
								Nombre de usuario
								<span class="small">Con un m&aacute;ximo 50 caracteres</span>
							</label>
							<input type="text" name="usuario" maxlength="50" value="<?php echo $rs[0][0]; ?>" disabled="disabled" />
							<label>
								Correo electr&oacute;nico
								<span class="small">M&aacute;x. 100 caracteres</span>
							</label>
							<input type="text" name="correo" value="<?php echo $rs[0][1]; ?>" maxlength="100" />
							<label>
								Contrase&ntilde;a
								<span class="small">Introduzca su contrase&ntilde;a</span>
							</label>
							<input id="pass" type="password" name="pass" maxlength="50" />
							<label>
								Nueva contrase&ntilde;a
								<span class="small">Introduzca su nueva contrase&ntilde;a</span>
							</label>
							<input id="pass1" type="password" name="pass1" maxlength="50" />
							<label>
								Contrase&ntilde;a
								<span class="small">Vuelva a introducir su nueva contrase&ntilde;a</span>
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
							<input type="hidden" name="modificado" value="1" />
							<input class="boton" name="modificar" type="submit" value="Modificar" />
							<!-- <input class="boton" name="registrar" type="button" value="Registrar" onclick="comprobarDatos(this.form)" /> -->
						</p>
					</form>
				</div>
