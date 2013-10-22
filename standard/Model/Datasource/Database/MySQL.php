<?php

/**
 * MiPaGiNa (MP)
 * Copyright (C) 2012 Esteban De La Fuente Rubio (esteban[at]delaf.cl)
 * 
 * Este programa es software libre: usted puede redistribuirlo y/o
 * modificarlo bajo los términos de la Licencia Pública General GNU
 * publicada por la Fundación para el Software Libre, ya sea la versión
 * 3 de la Licencia, o (a su elección) cualquier versión posterior de la
 * misma.
 * 
 * Este programa se distribuye con la esperanza de que sea útil, pero
 * SIN GARANTÍA ALGUNA; ni siquiera la garantía implícita
 * MERCANTIL o de APTITUD PARA UN PROPÓSITO DETERMINADO.
 * Consulte los detalles de la Licencia Pública General GNU para obtener
 * una información más detallada.
 * 
 * Debería haber recibido una copia de la Licencia Pública General GNU
 * junto a este programa.
 * En caso contrario, consulte <http://www.gnu.org/licenses/gpl.html>.
 */

/**
 * Clase para trabajar con una base de datos MySQL (o MariaDB)
 * @todo Se deben completar los métodos para la clase
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
 * @version 2012-12-24
 */
final class MySQL extends DatabaseManager {
	
	/**
	 * Constructor de la clase
	 * 
	 * Realiza conexión a la base de datos, recibe parámetros para la
	 * conexión
	 * @param config Arreglo con los parámetros de la conexión
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	public function __construct ($config) {
		// verificar que existe el soporte para MySQL en PHP
		if (!function_exists('mysqli_init')) {
			$this->error (
				'Unable to find the MySQL extension'
			);
		}
		// definir configuración para el acceso a la base de datos
		$this->config = array_merge(array(
			'host' => 'localhost',
			'port' => '3306',
			'char' => 'utf8',
		), $config);
		// realizar conexión a la base de datos
		$this->id = mysqli_init();
		$conexion = mysqli_real_connect(
			$this->id,
			$this->config['host'],
			$this->config['user'],
			$this->config['pass'],
			$this->config['name'],
			$this->config['port']
		);
		if (!$conexion) {
			$this->error('Can\'t connect to database!');
			//['.mysqli_connect_errno().']
			// '.mysqli_connect_error());
		}
		unset($conexion);
		// establecer charset para la conexion
		mysqli_set_charset($this->id, $this->config['char']);
	}

	/**
	 * Destructor de la clase
	 * 
	 * Cierra la conexión con la base de datos.
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	public function __destruct () {

	}
	
	/**
	 * Realizar consulta en la base de datos
	 * @param sql Consulta SQL que se desea realizar
	 * @return Resource Identificador de la consulta
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	public function query ($sql) {

	}
	
	/**
	 * Obtener una tabla (como arreglo) desde la base de datos
	 * @param sql Consulta SQL que se desea realizar
	 * @return Array Arreglo bidimensional con la tabla y sus datos
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	public function getTable ($sql) {

	}
	
	/**
	 * Obtener una sola fila desde la base de datos
	 * @param sql Consulta SQL que se desea realizar
	 * @return Array Arreglo unidimensional con la fila
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	public function getRow ($sql) {

	}

	/**
	 * Obtener una sola columna desde la base de datos
	 * @param sql Consulta SQL que se desea realizar
	 * @return Array Arreglo unidimensional con la columna
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	public function getCol ($sql) {

	}

	/**
	 * Obtener un solo valor desde la base de datos
	 * @param sql Consulta SQL que se desea realizar
	 * @return Mixed Valor devuelto
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	public function getValue ($sql) {

	}
	
	/**
	 * Método que limpia el string recibido para hacer la consulta en la
	 * base de datos de forma segura
	 * @param string String que se desea limpiar
	 * @param trim Indica si se deben o no quitar los espacios
	 * @return String String limpiado
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	public function sanitize ($string, $trim = true) {
		if ($trim)
			$string = trim($string);
		return mysqli_real_escape_string ($this->id, $string);
	}

	/**
	 * Iniciar transacción
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	public function transaction () {

	}
	
	/**
	 * Confirmar transacción
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	public function commit () {

	}
	
	/**
	 * Cancelar transacción
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	public function rollback () {

	}
	
	/**
	 * Ejecutar un procedimiento almacenado
	 * @param procedure Procedimiento almacenado que se quiere ejecutar
	 * @return Mixed Valor que retorna el procedimeinto almacenado
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	public function exec ($procedure) {

	}
	
	/**
	 * Obtener una tabla mediante un procedimiento almacenado
	 * @param procedure Procedimiento almacenado que se desea ejecutar
	 * @return Array Arreglo bidimensional con la tabla y sus datos
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	public function getTableFromSP ($procedure) {

	}

	/**
	 * Obtener una sola fila mediante un procedimiento almacenado
	 * @param procedure Procedimiento almacenado que se desea ejecutar
	 * @return Array Arreglo unidimensional con la fila
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	public function getRowFromSP ($procedure) {

	}
	
	/**
	 * Obtener una sola columna mediante un procedimiento almacenado
	 * @param procedure Procedimiento almacenado que se desea ejecutar
	 * @return Array Arreglo unidimensional con la columna
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	public function getColFromSP ($procedure) {

	}
	
	/**
	 * Obtener un solo valor mediante un procedimiento almacenado
	 * @param procedure Procedimiento almacenado que se desea ejecutar
	 * @return Mixed Valor devuelto por el procedimiento
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	public function getValueFromSP ($procedure) {

	}

	/**
	 * Asigna un límite para la obtención de filas en la consulta SQL
	 * @param sql Consulta SQL a la que se le agrega el límite
	 * @return String Consulta con el límite agregado
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	public function setLimit ($sql, $records, $offset = 0) {

	}

	/**
	 * Genera filtro para utilizar like en la consulta SQL
	 * @param colum Columna por la que se filtrará (se sanitiza)
	 * @param value Valor a buscar mediante like (se sanitiza)
	 * @return String Filtro utilizando like
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-11-11
	 */
	public function like ($column, $value) {

	}

	/**
	 * Concatena los parámetros pasados al método
	 * 
	 * El método acepta n parámetros, pero dos como mínimo deben ser
	 * pasados.
	 * @param par1 Parámetro 1 que se quiere concatenar
	 * @param par2 Parámetro 2 que se quiere concatenar
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	public function concat ($par1, $par2) {

	}
	
	/**
	 * Listado de tablas de la base de datos
	 * @return Array Arreglo con las tablas (nombre y comentario)
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	public function getTables () {

	}

	/**
	 * Obtener comentario de una tabla
	 * @param table Nombre de la tabla
	 * @return String Comentario de la tabla
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	public function getCommentFromTable ($table) {

	}
	
	/**
	 * Listado de columnas de una tabla (nombre, tipo, largo máximo, si
	 * puede tener un valor nulo y su valor por defecto)
	 * @param table Tabla a la que se quiere buscar las columnas
	 * @return Array Arreglo con la información de las columnas
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	public function getColsFromTable ($table) {

	}
	
	/**
	 * Listado de claves primarias de una tabla
	 * @param table Tabla a buscar su o sus claves primarias
	 * @return Arreglo con la o las claves primarias
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	public function getPksFromTable ($table) {

	}
	
	/**
	 * Listado de claves foráneas de una tabla
	 * @param table Tabla a buscar su o sus claves foráneas
	 * @return Arreglo con la o las claves foráneas
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	public function getFksFromTable ($table) {

	}

	/**
	 * Entrega información de una tabla (nombre, comentario, columnas,
	 * pks y fks)
	 * @param table Tabla a buscar sus datos
	 * @return Arreglo con los datos de la tabla
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	public function getInfoFromTable ($tablename) {

	}

	/**
	 * Seleccionar una tabla con los nombres de las columnas
	 * @param sql Consulta SQL que se desea realizar
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	public function getTableWithColsNames ($sql) {

	}
	
	/**
	 * Exportar una consulta a un archivo CSV y descargar
	 *
	 * La cantidad de campos seleccionados en la query debe ser igual
	 * al largo del arreglo de columnas
	 * @param sql Consulta SQL
	 * @param file Nombre para el archivo que se descargará
	 * @param cols Arreglo con los nombres de las columnas a utilizar en la
	 * tabla
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	public function toCSV ($sql, $file, $cols) {

	}
	
}
