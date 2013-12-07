<?php
	require_once 'baseDeDatos.php';
	
	/* Clase que nos servira para realizar metodos relacionados con usuarios. */
	class CUsuario {
		private $conexion; // variable para guardar una conexion con la base de datos.
		
		/* Constructora de la clase. */
		public function __construct() {
			$this->conexion = new BaseDeDatos();
		}
		
		private function getConexion() {
			return $this->conexion;
		}
		
		/* Funcion que permite a un usuario loguearse en el sistema. */
		public function login($user, $pass) {
			/* Recogemos la sal del usuario para poder realizar la comprobacion con la contrasena. */
			$sal = $this->getConexion()->executeScalar("SELECT sal FROM usuarios WHERE nombre = ?", array($user));
			
			$pass = hash("sha512", $pass . $sal);
			
			/* Recogemos los datos del usuario de la base de datos. */
			$datosUsuario = $this->getConexion()->execute("SELECT codigo, nombre, correo, contrasena, tipo FROM usuarios WHERE nombre = ? AND contrasena = ?", array($user, $pass));
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
			/* Ejecutamos una sentencia INSERT para a�adir al nuevo usuario en la base de datos. */
			$this->getConexion()->execute("INSERT INTO usuarios (nombre, correo, contrasena, sal) VALUES (?, ?, ?, ?)", array($user, $email, hash("sha512", $pass . $sal), $sal));
			$this->login($user, $pass); // Logueamos al nuevo usuario.
		}
		
		/* Funcion que permite modificar los datos a un usuario. */
		public function modificarUsuario($email, $nuevaPass, $viejaPass) {
			$viejaPass = hash("sha512", $viejaPass . $_SESSION['sal']);
			
			if ($nuevaPass == "")
				$nuevaPass = $viejaPass;
			else
				$nuevaPass = hash("sha512", $nuevaPass . $_SESSION['sal']);
			
			if ($_SESSION['contrasena'] != $viejaPass) // La contrasena actual tiene que coincidir con la introducida por el usuario en el formulario.
				return false;
			else {
				if ($_SESSION['correo'] != $email) { // Si el correo se pretende modificar, debemos buscar que no exista en la base de datos.
					$correo = $this->getConexion()->executeScalar("SELECT nombre FROM usuarios WHERE correo = ?", array($email));
					if (!empty($correo)) // Si existe, no podemos continuar.
						return false;
					else {
						$_SESSION['correo'] = $email;
						$_SESSION['contrasena'] = $nuevaPass;
						$this->getConexion()->execute("UPDATE usuarios SET correo = ?, contrasena = ? WHERE codigo = ?", array($email, $nuevaPass, $_SESSION['codigo']));
						return true;
					}
				}
				else {
					$this->getConexion()->execute("UPDATE usuarios SET correo = ?, contrasena = ? WHERE codigo = ?", array($email, $nuevaPass, $_SESSION['codigo']));
					return true;
				}
			}
		}
	}
?>