<?php
	require 'conexionbd.php';
	
	/* Clase que nos servira para realizar metodos relacionados con el mercado. */
	class CMercado {
		private $_conexion; // variable para guardar una conexion con la base de datos.
		private static $_miCMercado; // Variable estatica en la que guardaremos la unica instancia de esta clase.
		
		/* Constructora de la clase. */
		private function __construct() {
			$this->_conexion = ConexionBD::getConexionBD();
		}
		
		public static function getCMercado() { // Metodo que nos deja acceder a la unica instancia de esta clase.
			if (!self::$_miCMercado)
				self::$_miCMercado = new CMercado();
			return self::$_miCMercado;
		}
		
		private function getConexion() {
			return $this->_conexion;
		}
		
		public function getMercado($desde) {
			return $this->getConexion()->execute("SELECT mercado.codigo, titulo, descripcion, nombre, fecha FROM mercado, usuarios WHERE mercado.usuario = usuarios.codigo ORDER BY fecha DESC LIMIT ?, 5", array($desde));
		}
		
		public function getDatosOferta($codigo) {
			return $this->getConexion()->execute("SELECT titulo, descripcion FROM mercado WHERE codigo = ?", array($codigo));
		}
		
		public function getNumeroOfertas() {
			return $this->getConexion()->executeScalar("SELECT COUNT(*) FROM mercado", array());
		}
		
		public function getUsuarioOferta($codigo) {
			return $this->getConexion()->executeScalar("SELECT usuario FROM mercado WHERE codigo = ?", array($codigo));
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