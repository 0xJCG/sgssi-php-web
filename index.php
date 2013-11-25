<?php
	session_start();
	$previous_encoding = mb_internal_encoding();
	mb_internal_encoding('UTF-8');
	mb_internal_encoding($previous_encoding);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<title>Seguridad</title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<link href="css/ordenador.css" type="text/css" rel="stylesheet" />
	</head>
	<body>
		<div id="container">
			<div id="header"><!--div: menubar, adbar, sidebar-->
				<h1 id="pr_title"><a href="index.php">Seguridad</a></h1>
			</div>
			<div class="clear"></div>
			<div id="maincontent">
<?php
	//Codigo Login ola ke ase
	if (!isset($_SESSION['codigo'])) {
		if (isset($_POST['login']) && $_POST['login'] == 1) {
			require('includes/conexiones.php');
			$cn = new Connection();
			$login_successful = $cn->login($_POST['user'], hash("sha512", $_POST['pass']));
			if ($login_successful) {
				if (!empty($_SESSION['codigo']))
					echo "\t\t\t\t" . '<p>Se ha conectado correctamente.</p>' . "\n";
				else {
					echo "\t\t\t\t" . '<p>Los datos introducidos son incorrectos.</p>' . "\n";
					session_destroy();
				}
			}
			else {
				echo "\t\t\t\t" . '<p>No se ha podido conectar.</p>';
				session_destroy();
			}
		} else {
?>
				<form action="index.php" method="post">
					<p>
						<label>
							Usuario
							<span class="small">M&aacute;x. 30 caracteres:</span>
						</label>
						<input type="text" name="user" maxlength="30" />
						<label>
							Contrase&ntilde;a
							<span class="small">Introduce tu contrase&ntilde;a:</span>
						</label>
						<input type="password" name="pass" maxlength="40" />
						<br />
						<input type="hidden" name="login" value="1" />
						<input class="boton" type="submit" value="Conectar" />
					</p>
				</form>
<?php
		}
	} else {
		if (isset($_GET['logout']) && $_GET['logout'] == 1) {
			session_destroy();
			echo "\t\t\t\t" . '<p>Te has desconectado.</p>' . "\n";
		} else {
			echo "\t\t\t\t" . '<p>Conectado.</p>' . "\n";
			echo "\t\t\t\t" . '<p><a href="index.php?logout=1">Desconectar.</a></p>' . "\n";
		}
	}
?>
			</div>
			<div class="clear"></div>
			<div id="footer">
				<p>Web realizada por Jonathan Castro, Alberto Fern&aacute;ndez y Arkaitz Marcos &copy; 2013.</p>
			</div>
		</div>
	</body>
</html>