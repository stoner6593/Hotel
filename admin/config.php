<?php

	global $mysqli;
	$mysqli = new mysqli("127.0.0.1:3307", "root", "", "webhotelcentral");
	if ($mysqli->connect_errno) {
		echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno.") " . $mysqli->connect_error;
	}

	$acentos = $mysqli->query("SET NAMES 'utf8'");


	/*
	AGREGADO PARA QUE FUNCIONE CON LAS CLASES DE FE SIN MODIFICAR LOS ARCHIVOS YA EXISTENTES
	 */
	/**
	* 
	*/
	
	class Conexion 
	{
		
		/**
		* Gestiona la conexión con la base de datos
		*/

		private $dbhost = '127.0.0.1:3307';

		private $dbuser = 'root';

		private $dbpass = '';

		private $dbname = 'webhotelcentral';

		public function conexion () {

			/**
			* @return object link_id con la conexión
			*/

			$link_id = new mysqli($this->dbhost,$this->dbuser,$this->dbpass,$this->dbname);

			if ($link_id ->connect_error) {

				echo "Error de Connexion ($link_id->connect_errno)

				$link_id->connect_error\n";

				

				exit;

			} else {

				return $link_id;

			}

		}
	}
?>