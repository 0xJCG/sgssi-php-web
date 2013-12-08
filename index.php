<?php
	session_start();
	$previous_encoding = mb_internal_encoding();
	mb_internal_encoding('UTF-8');
	mb_internal_encoding($previous_encoding);

	require 'interfaces/cabecera.php';
	require 'includes/cmercado.php';
?>
				<noscript>
					<p>Su navegador no soporta JavaScript o lo tiene deshabilitado. Necesita JavaScript para poder utilizar esta p&aacute;gina web de manera correcta.</p>
				</noscript>
<?php
	$mercado = CMercado::getCMercado();
	
	if (isset($_POST['anadir'])) {
		$mercado->anadirOferta($_POST['titulo'], $_POST['descripcion'], $_POST['imagen']);
	} elseif (isset($_POST['modificar'])) {
		$mercado->modificarOferta($_POST['titulo'], $_POST['descripcion'], $_POST['imagen'], $_POST['modificar']);
	} elseif (isset($_GET['eliminar'])) {
		$mercado->eliminarOferta($_GET['eliminar']);
	}
	
	$datosMercado = $mercado->getMercado();
	
	$limite = count($datosMercado);
	for ($i = 0; $i < $limite; $i++) {
		echo '<div class="mensaje">';
		if ((isset($_SESSION['nombre']) && $_SESSION['nombre'] == $datosMercado[$i][3]) || (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 1))
			echo '<p class="opciones"><a href="index.php?modificar=' . $datosMercado[$i][0] . '">Modificar</a>. <a href="index.php?eliminar=' . $datosMercado[$i][0] . '">Eliminar</a>.</p>';
		echo '<h2>' . $datosMercado[$i][1] . '</h2>';		
		echo '<p>Por ' . $datosMercado[$i][3] . ', el ' . $datosMercado[$i][4] . '</p>';
		echo '<p>' . $datosMercado[$i][2] . '</p>';
		echo "</div>";
	}
	
	if (isset($_SESSION['codigo'])) {
		if (isset($_GET['modificar'])) {
			$datosOferta = $mercado->getDatosOferta($_GET['modificar']);
			$titulo = $datosOferta[0][0];
			$descripcion = $datosOferta[0][1];
		}
		require 'interfaces/formulario_mercado.php';
	}

	require 'interfaces/pie.html';
?>