<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<title>Cash4Trash</title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<link href="css/ordenador.css" type="text/css" rel="stylesheet" />
		<link rel="shortcut icon" href="imagenes/favicon.ico">
		<script type="text/javascript" src="js/sha512.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.js"></script>
		<script type="text/javascript" src="js/formularios.js"></script>
	</head>
	<body>
		<div id="container">
			<div id="header">
				<h1 id="titulo"><a href="index.php">Cash4Trash</a></h1>
				<div id="conectado">
<?php
	if (isset($_SESSION['nombre'])) {
		echo "\t\t\t\t\t" . '<h1>&iexcl;Hola, ' . $_SESSION['nombre'] . '!</h1>' . "\n";
		echo "\t\t\t\t\t" . '<p><a href="panel.php">Panel de usuario</a>.</p>' . "\n";
		echo "\t\t\t\t\t" . '<p><a href="conectar.php?desconectar">Cerrar sesi&oacute;n</a>.</p>' . "\n";
	} else {
		echo "\t\t\t\t\t" . '<h1 id="conectado">&iexcl;Hola, an&oacute;nimo!</h1>' . "\n";
		echo "\t\t\t\t\t" . '<p><a href="conectar.php">Conectar</a>.</p>' . "\n";
		echo "\t\t\t\t\t" . '<p><a href="registro.php">Registrar</a>.</p>' . "\n";
	}
?>
				</div>
			</div>
			<div class="clear"></div>
			<div id="maincontent">
