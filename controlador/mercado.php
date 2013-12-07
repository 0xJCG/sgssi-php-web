<?php
	require_once 'modelo/usuario.php';
	
	class Mercado {
		protected static $instancia; // Contendra una instancia de esta clase 'Usuario'.
		private $usuario;
		
		protected function __construct() {}
		
		public static function getMercado() {
			if (!isset(self::$instancia)) { // Si on n'a pas encore instancié notre classe.
				self::$instancia = new self(); // On s'instancie nous-mêmes. :)
			}
			return self::$instancia;
		}
		
		public function crearUsuario($nombre, $correo, $contrasena, $sal, $tipo) {
			$this->usuario = new Usuario($nombre, $correo, $contrasena, $sal, $tipo);
		}
		
		public function getUsuario() {
			return $this->usuario;
		}
	}
?>