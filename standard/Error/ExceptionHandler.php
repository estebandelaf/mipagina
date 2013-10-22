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

// se utilizará el controlador de errores
App::uses('ErrorController', 'Controller');

/**
 * Clase que permite manejar las excepciones que aparecen durante
 * la ejecución de la aplicación.
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
 * @version 2013-06-12
 */
class ExceptionHandler {

	protected static $controller; ///< Controlador
	
	/**
	 * Método para manejar las excepciones ocurridos en la aplicación
	 * @todo Ver como mostrar la excepción dentro de la misma página y no una en blanco.
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2013-06-10
	 */
	public static function handle (Exception $exception) {
		// obtener controlador
		self::$controller = new ErrorController(new Request(), new Response());
		// indicar que se hará con el error
		self::$controller->error_reporting = Configure::read('debug');
		// Generar arreglo
		$data = array(
			'exception' => get_class($exception),
			'message' => $exception->getMessage(),
			'trace' => $exception->getTraceAsString()
		);
		// Renderizar
		self::$controller->display($data);
	}

}
