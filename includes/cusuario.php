<?php
	require 'conexionbd.php';
	
	/* Clase que nos servira para realizar metodos relacionados con usuarios. */
	class CUsuario {
		private $_conexion; // variable para guardar una conexion con la base de datos.
		private static $_miCUsuario; // Variable estatica en la que guardaremos la unica instancia de esta clase.
		
		/* Constructora de la clase. */
		private function __construct() {
			$this->_conexion = ConexionBD::getConexionBD();
		}
		
		public static function getCUsuario() { // Metodo que nos deja acceder a la unica instancia de esta clase.
			if (!self::$_miCUsuario)
				self::$_miCUsuario = new CUsuario();
			return self::$_miCUsuario;
		}
		
		private function _getConexion() {
			return $this->_conexion;
		}
		
		/* Funcion que permite a un usuario loguearse en el sistema. */
		public function login($user, $pass) {
			/* Recogemos la sal del usuario para poder realizar la comprobacion con la contrasena. */
			$sal = $this->_getConexion()->executeScalar("SELECT sal FROM usuarios WHERE nombre = ?", array($user));
			
			$pass = hash("sha512", $pass . $sal);
			
			/* Recogemos los datos del usuario de la base de datos. */
			$datosUsuario = $this->_getConexion()->execute("SELECT codigo, nombre, correo, contrasena, tipo FROM usuarios WHERE nombre = ? AND contrasena = ?", array($user, $pass));
			if (!empty($datosUsuario)) { // Si no esta vacio quiere decir que el usuario existe.
				/* Creamos variables de sesion para guardar los datos del usuario para no tener que llamar siempre a la base de datos. */
				$_SESSION['codigo'] = $datosUsuario[0][0];
				$_SESSION['nombre'] = $datosUsuario[0][1];
				$_SESSION['correo'] = $datosUsuario[0][2];
				$_SESSION['contrasena'] = $datosUsuario[0][3];
				$_SESSION['sal'] = $sal;
				$_SESSION['tipo'] = $datosUsuario[0][4];
				unset($datosUsuario);
				return true;
			} else {
				unset($datosUsuario);
				return false;
			}
		}
		
		/* Funcion que permite a un usuario registrarse y loguearse en el sistema. */
		public function registrar($user, $email, $pass, $sal) {
			/* Ejecutamos una sentencia INSERT para añadir al nuevo usuario en la base de datos. */
			$this->_getConexion()->execute("INSERT INTO usuarios (nombre, correo, contrasena, sal) VALUES (?, ?, ?, ?)", array($user, $email, hash("sha512", $pass . $sal), $sal));
			$this->login($user, $pass); // Logueamos al nuevo usuario.
		}
		
		/* Funcion que permite modificar los datos a un usuario. */
		public function modificarUsuario($email, $nuevaPass, $viejaPass) {
			$viejaPass = hash("sha512", $viejaPass . $_SESSION['sal']);
			echo $nuevaPass;
			
			if ($nuevaPass == "")
				$nuevaPass = $viejaPass;
			else
				$nuevaPass = hash("sha512", $nuevaPass . $_SESSION['sal']);
			
			if ($_SESSION['contrasena'] != $viejaPass) // La contrasena actual tiene que coincidir con la introducida por el usuario en el formulario.
				return false;
			else {
				if ($_SESSION['correo'] != $email) { // Si el correo se pretende modificar, debemos buscar que no exista en la base de datos.
					$correo = $this->_getConexion()->executeScalar("SELECT nombre FROM usuarios WHERE correo = ?", array($email));
					if (!empty($correo)) // Si existe, no podemos continuar.
						return false;
					else {
						$_SESSION['correo'] = $email;
						$_SESSION['contrasena'] = $nuevaPass;
						$this->_getConexion()->execute("UPDATE usuarios SET correo = ?, contrasena = ? WHERE codigo = ?", array($email, $nuevaPass, $_SESSION['codigo']));
						return true;
					}
				}
				else {
					$this->_getConexion()->execute("UPDATE usuarios SET correo = ?, contrasena = ? WHERE codigo = ?", array($email, $nuevaPass, $_SESSION['codigo']));
					return true;
				}
			}
		}
	}
?>