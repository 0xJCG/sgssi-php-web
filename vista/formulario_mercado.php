				<div class="formulario">
					<h1>A&ntilde;adir un nuevo elemento al mercado</h1>
					<form id="formularioMercado" name="formularioMercado" action="index.php" method="post">
						<p>
							<label>
								T&iacute;tulo
								<span class="small">Con un m&aacute;ximo 50 caracteres</span>
							</label>
							<input type="text" name="titulo" maxlength="50" />
							<label>
								Descripci&oacute;n
								<span class="small">M&aacute;x. 1000 caracteres</span>
							</label>
							<input type="text" name="descripcion" maxlength="1000" />
							<label>
								Imagen
								<span class="small">Opcional: seleccione una imagen a mostrar en el mensaje</span>
							</label>
							<input type="file" name="imagen" />
							<br />
<?php
	/*** set a form token ***/
	$form_token = md5( uniqid('auth', true) );
	
	/*** set the session form token ***/
	$_SESSION['form_token'] = $form_token;
?>
							<input type="hidden" name="form_token" value="<?php echo $form_token; ?>" />
							<input type="hidden" name="mercado" value="1" />
							<input class="boton" name="enviar" type="submit" value="Enviar" />
						</p>
					</form>
				</div>
