<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<head>
		<title>Segunda mano</title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<link href="css/ordenador.css" type="text/css" rel="stylesheet" />
		<script type="text/javascript" src="js/sha512.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.js"></script>
		<script type="text/javascript" src="js/formularios.js"></script>
	</head>
	<body>
		<div id="container">
			<div id="header"><!--div: menubar, adbar, sidebar-->
				<h1 id="pr_title"><a href="index.php">Segunda mano</a></h1>
				<h1 id="conectado">&iexcl;Hola, <?php echo (isset($_SESSION['nombre']))?'<a href="panel.php">' . $_SESSION['nombre'] . '</a>' . '! <a href="conectar.php?desconectar">Desconectar.</a>':'an&oacute;nimo! <a href="conectar.php">Conectar.</a>' ?></h1>
			</div>
			<div class="clear"></div>
			<div id="maincontent">
