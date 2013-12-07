<?php
	require_once 'conexionbd.php';
	
	/* Clase que nos servira para realizar metodos relacionados con el mercado. */
	class CMercado {
		private $conexion; // variable para guardar una conexion con la base de datos.
		
		/* Constructora de la clase. */
		public function __construct() {
			$this->conexion = new ConexionBD();
		}
		
		private function getConexion() {
			return $this->conexion;
		}
		
		public function getMercado() {
			return $this->getConexion()->execute("SELECT titulo, descripcion, nombre, fecha FROM mercado, usuarios WHERE mercado.usuario = usuarios.codigo", array());
		}
	}
?>