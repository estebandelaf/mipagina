<?php

/**
 * MiPaGiNa (MP)
 * Copyright (C) 2013 Esteban De La Fuente Rubio (esteban[at]delaf.cl)
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
 * Clase base para trabajar con una base de datos cualquiera
 * 
 * Define métodos que deberán ser implementados, clases específicas para
 * la conexión con X base de datos deberán extender esta clase
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
 * @version 2013-06-10
 */
abstract class DatabaseManager {
	
	protected $config; ///< Configuración de la base de datos
	protected $id; ///< Identificador de la conexión

	/**
	 * Retorna la configuración de la conexión a la base de datos
	 * @return Array Arreglo con la configuración
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	final public function getConfig () {
		return $this->config;
	}
	
	/**
	 * Retorna el identificador de la conexión
	 * @return Resource Identificador de la conexión
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	final public function getId () {
		return $this->id;
	}

	/**
	 * Manejador de errores para la base de datos
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2013-06-10
	 */
	final public function error ($msg) {
		throw new DatabaseException(array(
			'msg' => $msg
		));
	}

	/**
	 * Obtener un arreglo con índice el identificador del registro que se
	 * está consultando con algún valor asociado
	 * @param sql Consulta SQL que se desea realizar
	 * @return Array Arreglo unidimensional con los índices y sus datos
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2013-08-13
	 */
	final public function getAssociativeArray ($sql) {
		$table = $this->getTable($sql);
		$array = array();
		foreach ($table as &$row) {
			$array[array_shift($row)] = array_shift($row);
		}
		return $array;
	}

	/**
	 * Constructor de la clase
	 * 
	 * Realiza conexión a la base de datos, recibe parámetros para la
	 * conexión
	 * @param config Arreglo con los parámetros de la conexión
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	abstract public function __construct ($config);

	/**
	 * Destructor de la clase
	 * 
	 * Cierra la conexión con la base de datos.
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	abstract public function __destruct ();
	
	/**
	 * Realizar consulta en la base de datos
	 * @param sql Consulta SQL que se desea realizar
	 * @return Resource Identificador de la consulta
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	abstract public function query ($sql);
	
	/**
	 * Obtener una tabla (como arreglo) desde la base de datos
	 * @param sql Consulta SQL que se desea realizar
	 * @return Array Arreglo bidimensional con la tabla y sus datos
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	abstract public function getTable ($sql);
	
	/**
	 * Obtener una sola fila desde la base de datos
	 * @param sql Consulta SQL que se desea realizar
	 * @return Array Arreglo unidimensional con la fila
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	abstract public function getRow ($sql);

	/**
	 * Obtener una sola columna desde la base de datos
	 * @param sql Consulta SQL que se desea realizar
	 * @return Array Arreglo unidimensional con la columna
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	abstract public function getCol ($sql);

	/**
	 * Obtener un solo valor desde la base de datos
	 * @param sql Consulta SQL que se desea realizar
	 * @return Mixed Valor devuelto
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	abstract public function getValue ($sql);
	
	/**
	 * Método que limpia el string recibido para hacer la consulta en la
	 * base de datos de forma segura
	 * @param string String que se desea limpiar
	 * @param trim Indica si se deben o no quitar los espacios
	 * @return String String limpiado
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	abstract public function sanitize ($string, $trim = true);

	/**
	 * Iniciar transacción
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	abstract public function transaction ();
	
	/**
	 * Confirmar transacción
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	abstract public function commit ();
	
	/**
	 * Cancelar transacción
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	abstract public function rollback ();
	
	/**
	 * Ejecutar un procedimiento almacenado
	 * @param procedure Procedimiento almacenado que se quiere ejecutar
	 * @return Mixed Valor que retorna el procedimeinto almacenado
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	abstract public function exec ($procedure);
	
	/**
	 * Obtener una tabla mediante un procedimiento almacenado
	 * @param procedure Procedimiento almacenado que se desea ejecutar
	 * @return Array Arreglo bidimensional con la tabla y sus datos
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	abstract public function getTableFromSP ($procedure);

	/**
	 * Obtener una sola fila mediante un procedimiento almacenado
	 * @param procedure Procedimiento almacenado que se desea ejecutar
	 * @return Array Arreglo unidimensional con la fila
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	abstract public function getRowFromSP ($procedure);
	
	/**
	 * Obtener una sola columna mediante un procedimiento almacenado
	 * @param procedure Procedimiento almacenado que se desea ejecutar
	 * @return Array Arreglo unidimensional con la columna
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	abstract public function getColFromSP ($procedure);
	
	/**
	 * Obtener un solo valor mediante un procedimiento almacenado
	 * @param procedure Procedimiento almacenado que se desea ejecutar
	 * @return Mixed Valor devuelto por el procedimiento
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	abstract public function getValueFromSP ($procedure);

	/**
	 * Asigna un límite para la obtención de filas en la consulta SQL
	 * @param sql Consulta SQL a la que se le agrega el límite
	 * @return String Consulta con el límite agregado
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	abstract public function setLimit ($sql, $records, $offset = 0);

	/**
	 * Genera filtro para utilizar like en la consulta SQL
	 * @param colum Columna por la que se filtrará (se sanitiza)
	 * @param value Valor a buscar mediante like (se sanitiza)
	 * @return String Filtro utilizando like
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-11-11
	 */
	abstract public function like ($column, $value);

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
	abstract public function concat ($par1, $par2);
	
	/**
	 * Listado de tablas de la base de datos
	 * @return Array Arreglo con las tablas (nombre y comentario)
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	abstract public function getTables ();

	/**
	 * Obtener comentario de una tabla
	 * @param table Nombre de la tabla
	 * @return String Comentario de la tabla
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	abstract public function getCommentFromTable ($table);
	
	/**
	 * Listado de columnas de una tabla (nombre, tipo, largo máximo, si
	 * puede tener un valor nulo y su valor por defecto)
	 * @param table Tabla a la que se quiere buscar las columnas
	 * @return Array Arreglo con la información de las columnas
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	abstract public function getColsFromTable ($table);
	
	/**
	 * Listado de claves primarias de una tabla
	 * @param table Tabla a buscar su o sus claves primarias
	 * @return Arreglo con la o las claves primarias
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	abstract public function getPksFromTable ($table);
	
	/**
	 * Listado de claves foráneas de una tabla
	 * @param table Tabla a buscar su o sus claves foráneas
	 * @return Arreglo con la o las claves foráneas
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	abstract public function getFksFromTable ($table);

	/**
	 * Entrega información de una tabla (nombre, comentario, columnas,
	 * pks y fks)
	 * @param table Tabla a buscar sus datos
	 * @return Arreglo con los datos de la tabla
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	abstract public function getInfoFromTable ($tablename);

	/**
	 * Seleccionar una tabla con los nombres de las columnas
	 * @param sql Consulta SQL que se desea realizar
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	abstract public function getTableWithColsNames ($sql);
	
	/**
	 * Exportar una consulta a un archivo CSV y descargar
	 *
	 * La cantidad de campos seleccionados en la query debe ser igual
	 * al largo del arreglo de columnas
	 * @param sql Consulta SQL
	 * @param file Nombre para el archivo que se descargará
	 * @param cols Arreglo con los nombres de las columnas a utilizar en la tabla
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-12-24
	 */
	abstract public function toCSV ($sql, $file, $cols);

}

// si existe MiException estamos en el framework MiPaGiNa y se extiende
// dicha clase para generar la excepción
if(class_exists('MiException')) {
	class DatabaseException extends MiException {
		protected $_messageTemplate = '%s';
	}
}
// si no existe se crea una clase para la excepción basada en la clase
// base y se utiliza el constructor de la clase MiException
else {
	class DatabaseException extends RuntimeException {
		protected $_messageTemplate = '%s';
		public function __construct($message, $code = 500) {
			if (is_array($message)) {
				$message = vsprintf($this->_messageTemplate, $message);
			}
			parent::__construct($message, $code);
		}
	}	
}
