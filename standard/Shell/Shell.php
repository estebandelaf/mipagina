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

// Clases que se utilizan
App::uses('ConsoleOutput', 'Shell');

/**
 * Clase base para todo comando de la Shell
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
 * @version 2012-09-14
 */
class Shell {
	
	public $stdout; ///< Atributo con el objeto para la salida de datos
	
	/**
	 * Constructor de la clase, asigna salida estándar a stdout
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-09-14
	 */
	public function __construct () {
			$this->stdout = new ConsoleOutput('php://stdout');
	}	
	
	/**
	 * Método que imprime a la salida indicada
	 * @param message Mensaje que se desea imprimir
	 * @param newlines Cuantas nuevas líneas se deben agregar
	 * @return Caracteres escritos (o falso si falló)
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-09-14
	 */
	public function out ($message = null, $newlines = 1) {
		return $this->stdout->write($message, $newlines);
	}
	
	/**
	 * Método que lee desde la entrada estándar
	 * @param message Mensaje que se desea imprimir antes de leer
	 * @param newlines Cuantas nuevas líneas se deben agregar después del mensaje
	 * @param trim Si se debe usar trim en lo leído (por defecto true)
	 * @return Lo leído desde el teclado
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-09-14
	 */
	public function in ($message = null, $newlines = 0, $trim = true) {
		$this->out($message, $newlines);
		$handle = fopen ('php://stdin', 'r');
		$line = fgets($handle);
		fclose($handle);
		return $trim ? trim($line) : $line;
	}
	
	/**
	 * Guardar un archivo con cierto contenido
	 * @param filename Nombre del archivo
	 * @param data Datos que se deben guardar en el archivo
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-09-14
	 */
	public function createFile ($filename, $data) {
		file_put_contents ($filename, $data);
	}
	
}
