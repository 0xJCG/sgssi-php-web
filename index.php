<?php
	session_start();
	$previous_encoding = mb_internal_encoding();
	mb_internal_encoding('UTF-8');
	mb_internal_encoding($previous_encoding);

	require_once 'vista/cabecera.php';
	require_once 'controlador/cmercado.php';
?>
				<noscript>
					<p>Su navegador no soporta JavaScript o lo tiene deshabilitado. Necesita JavaScript para poder utilizar esta p&aacute;gina web de manera correcta.</p>
				</noscript>
<?php
	$mercado = new CMercado();
	$datosMercado = $mercado->getMercado();
	
	for ($i = 0; $i < count($datosMercado); $i++) {
		echo '<div class="mensaje">';
		if ((isset($_SESSION['nombre']) && $_SESSION['nombre'] == $datosMercado[$i][2]) || (isset($_SESSION['tipo']) && $_SESSION['tipo'] == 1))
			echo '<p class="opciones">Modificar. Eliminar.</p>';
		echo '<h2>' . $datosMercado[$i][0] . '</h2>';		
		echo '<p>Por ' . $datosMercado[$i][2] . ', el ' . $datosMercado[$i][3] . '</p>';
		echo '<p>' . $datosMercado[$i][1] . '</p>';
		echo "</div>";
	}
	
	if (isset($_SESSION['codigo']))
		require_once 'vista/formulario_mercado.php';

	require_once 'vista/pie.html';
?>