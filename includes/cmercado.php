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
			return $this->getConexion()->execute("SELECT mercado.codigo, titulo, descripcion, nombre, usuarios.telefono, ruta_imagen, DATE_FORMAT(fecha,'%d-%m-%Y, %H:%i:%s') as mifecha FROM mercado, usuarios WHERE mercado.usuario = usuarios.codigo ORDER BY fecha DESC LIMIT ?, 5", array($desde));
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
		
		public function anadirOferta($titulo, $descripcion) {
			$nombreImagen = $this->subirImagen("imagenes/ofertas/", 'imagen'); // Da igual que haya o no imagen, la base de datos esta preparada para aceptar null.
			$this->getConexion()->execute("INSERT INTO mercado (titulo, descripcion, usuario, ruta_imagen, fecha) VALUES (?, ?, ?, ?, ?)", array($titulo, $descripcion, $_SESSION['codigo'], $nombreImagen, date('Y-m-d H:i:s')));
		}
		
		public function eliminarOferta($codigo) {
			$imagen = $this->getConexion()->executeScalar("SELECT ruta_imagen FROM mercado WHERE codigo = ?", array($codigo)); // Miramos si la oferta contiene imagen.
			if ($imagen != null) // De tenerla...
				unlink('imagenes/ofertas/' . $imagen); // Se elimina del disco duro.
			$this->getConexion()->execute("DELETE FROM mercado WHERE codigo = ?", array($codigo));
		}
		
		public function modificarOferta($titulo, $descripcion, $codigo) {
			$nombreImagen = $this->subirImagen("imagenes/ofertas/", 'imagen'); // Comprobamos si se ha enviado imagen con el formulario.
			if ($nombreImagen) // De haber enviado una...
				/* ... se actualiza con la imagen. */
				$this->getConexion()->execute("UPDATE mercado SET titulo = ?, descripcion = ?, ruta_imagen = ?, fecha = ? WHERE codigo = ?", array($titulo, $descripcion, $nombreImagen, date('Y-m-d H:i:s'), $codigo));
			else // Si no hay imagen, actualizamos sin tocar la imagen original. 
				$this->getConexion()->execute("UPDATE mercado SET titulo = ?, descripcion = ?, fecha = ? WHERE codigo = ?", array($titulo, $descripcion, date('Y-m-d H:i:s'), $codigo));
		}
		
		/***********************************************************************************************************/
		/* Sube una imagen al servidor al directorio especificado teniendo el atributo 'Name' del campo archivo.   */
		/* @param string $destination_dir Directorio de destino dónde queremos dejar el archivo.                   */
		/* @param string $name_media_field Atributo 'Name' del campo archivo, es decir, el del input type="file".  */
		/* @return El nombre de la imagen o null de haber fallado.                                                 */
		/* Sacado de: http://yophpro.com/problema/subir-imagenes-en-php.html                                       */
		/***********************************************************************************************************/
		private function subirImagen($destination_dir, $name_media_field) {
			$tmp_name = $_FILES[$name_media_field]['tmp_name'];
			if (is_dir($destination_dir) && is_uploaded_file($tmp_name)) { // Si hemos enviado un directorio que existe realmente y hemos subido el archivo.
				$img_file = $_FILES[$name_media_field]['name'] ;
				$img_type = $_FILES[$name_media_field]['type'];
				if (strpos($img_type, "gif") || strpos($img_type, "jpeg") || strpos($img_type,"jpg") || strpos($img_type,"png")) { // Comprobamos que se trate de una imagen.
					if (move_uploaded_file($tmp_name, $destination_dir . $img_file)) // Subimos la imagen.
						return $img_file; // Devolvemos el nombre de la imagen.
				}
			} // Si llegamos hasta aqui es que algo ha fallado.
			return null;
		}
	}
?>