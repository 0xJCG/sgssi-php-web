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
		
		private function getConexion() {
			return $this->_conexion;
		}
		
		/* Funcion que permite a un usuario loguearse en el sistema. */
		public function login($user, $pass) {
			/* Recogemos la sal del usuario para poder realizar la comprobacion con la contrasena. */
			$sal = $this->getConexion()->executeScalar("SELECT sal FROM usuarios WHERE nombre = ?", array($user));
			
			$pass = hash("sha512", $pass . $sal);
			
			/* Recogemos los datos del usuario de la base de datos. */
			$datosUsuario = $this->getConexion()->execute("SELECT codigo, nombre, correo, telefono, cbancaria, contrasena, tipo FROM usuarios WHERE nombre = ? AND contrasena = ?", array($user, $pass));
			if (!empty($datosUsuario)) { // Si no esta vacio quiere decir que el usuario existe.
				/* Creamos variables de sesion para guardar los datos del usuario para no tener que llamar siempre a la base de datos. */
				$_SESSION['codigo'] = $datosUsuario[0][0];
				$_SESSION['nombre'] = $datosUsuario[0][1];
				$_SESSION['correo'] = $datosUsuario[0][2];
				$_SESSION['telefono'] = $datosUsuario[0][3];
				$_SESSION['cbancaria'] = $datosUsuario[0][4];
				$_SESSION['contrasena'] = $datosUsuario[0][5];
				$_SESSION['sal'] = $sal;
				$_SESSION['tipo'] = $datosUsuario[0][6];
				unset($datosUsuario);
				return true;
			} else {
				unset($datosUsuario);
				return false;
			}
		}
		
		/* Funcion que permite a un usuario registrarse y loguearse en el sistema. */
		public function registrar($user, $email, $telefono, $cbancaria, $pass, $sal) {
			$correo = $this->getConexion()->executeScalar("SELECT COUNT(*) FROM usuarios WHERE correo = ?", array($email));
			$usuario = $this->getConexion()->executeScalar("SELECT COUNT(*) FROM usuarios WHERE nombre = ?", array($user));
			if (!empty($correo) || !empty($usuario)) // Si existen, no podemos continuar.
				return false;
			else {
				/* Ejecutamos una sentencia INSERT para anadir al nuevo usuario en la base de datos. */
				$this->getConexion()->execute("INSERT INTO usuarios (nombre, correo, telefono, cbancaria, contrasena, sal) VALUES (?, ?, ?, ?, ?, ?)", array($user, $email, $telefono, $cbancaria, hash("sha512", $pass . $sal), $sal));
				$this->login($user, $pass); // Logueamos al nuevo usuario.
				return true;
			}
		}
		
		/* Funcion que permite modificar los datos a un usuario. */
		public function modificarUsuario($email, $telefono, $cbancaria, $nuevaPass, $viejaPass) {
			$viejaPass = hash("sha512", $viejaPass . $_SESSION['sal']); // Debemos hacerlo para poder compararla con la contrasena de la base de datos.

			if ($nuevaPass == "") // Si no se ha cambiado la contrasena, para no tener problemas, a la nueva contrasena le asignamos la vieja.
				$nuevaPass = $viejaPass;
			else // Hasheamos la nueva contrasena con la sal del usuario.
				$nuevaPass = hash("sha512", $nuevaPass . $_SESSION['sal']);
			
			if ($_SESSION['contrasena'] != $viejaPass) // La contrasena actual tiene que coincidir con la introducida por el usuario en el formulario.
				return false;
			else {
				if ($_SESSION['correo'] != $email) { // Si el correo se pretende modificar, debemos buscar que no exista en la base de datos.
					$correo = $this->getConexion()->executeScalar("SELECT COUNT(*) FROM usuarios WHERE correo = ?", array($email));
					if ($correo != 0) // Si existe, no podemos continuar.
						return false;
					else { // El correo no existe.
						/* Asignamos los nuevos datos a las variables de sesion. */
						$_SESSION['correo'] = $email;
						$_SESSION['telefono'] = $telefono;
						$_SESSION['contrasena'] = $nuevaPass;
						
						if ($cbancaria == "")
							$cbancaria = $_SESSION['cbancaria'];
						else 
							$cbancaria = $this->cifrarCBancaria($cbancaria);
						
						if ($cbancaria != null) {
							$this->getConexion()->execute("UPDATE usuarios SET correo = ?, telefono = ?, cbancaria = ?, contrasena = ? WHERE codigo = ?", array($email, $telefono, $cbancaria, $nuevaPass, $_SESSION['codigo']));
							return true;
						} else 
							return false;
					}
				} else { // No se ha modificado el correo.
					/* Asignamos los nuevos datos a las variables de sesion. */
					$_SESSION['telefono'] = $telefono;
					$_SESSION['contrasena'] = $nuevaPass;
					
					if ($cbancaria == "")
							$cbancaria = $_SESSION['cbancaria'];
						else 
							$cbancaria = $this->cifrarCBancaria($cbancaria);
					
					if ($cbancaria != null) {
						$this->getConexion()->execute("UPDATE usuarios SET telefono = ?, cbancaria = ?, contrasena = ? WHERE codigo = ?", array($telefono, $cbancaria, $nuevaPass, $_SESSION['codigo']));
						return true;
					} else
						return false;
				}
			}
		}
		
		private function cifrarCBancaria($numero) {
			/* Ciframos la cuenta bancaria. */
			$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '', MCRYPT_MODE_CBC, '');
			$iv_size = mcrypt_enc_get_iv_size($cipher);
				
			$key = substr(sha1($_SESSION['sal']), 0, 32);
			$iv =  substr(sha1(intval($_SESSION['nombre']) * $_SESSION['telefono'] / 2), 0, 32);
				
			if (mcrypt_generic_init($cipher, $key, $iv) != -1) {
				$encrypted = mcrypt_generic($cipher, $numero);
				mcrypt_generic_deinit($cipher);
				$_SESSION['cbancaria'] = bin2hex($encrypted);
				return bin2hex($encrypted);
			}
			return null;
		}
	}
?>
