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
			return $this->getConexion()->execute("SELECT mercado.codigo, titulo, descripcion, nombre, fecha FROM mercado, usuarios WHERE mercado.usuario = usuarios.codigo ORDER BY fecha DESC", array());
		}
		
		public function getDatosOferta($codigo) {
			return $this->getConexion()->execute("SELECT titulo, descripcion FROM mercado WHERE codigo = ?", array($codigo));
		}
		
		public function anadirOferta($titulo, $descripcion, $imagen) {
			$this->getConexion()->execute("INSERT INTO mercado (titulo, descripcion, usuario, ruta_imagen, fecha) VALUES (?, ?, ?, ?, ?)", array($titulo, $descripcion, $_SESSION['codigo'], $imagen, date('Y-m-d H:i:s')));
		}
		
		public function eliminarOferta($codigo) {
			$this->getConexion()->execute("DELETE FROM mercado WHERE codigo = ?", array($codigo));
		}
		
		public function modificarOferta($titulo, $descripcion, $imagen, $codigo) {
			$this->getConexion()->execute("UPDATE mercado SET titulo = ?, descripcion = ?, ruta_imagen = ?, fecha = ? WHERE codigo = ?", array($titulo, $descripcion, $imagen, date('Y-m-d H:i:s'), $codigo));
		}
		
	}
?>