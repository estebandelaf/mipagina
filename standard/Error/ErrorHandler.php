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
 * Clase que permite manejar los errores que aparecen durante
 * la ejecución de la aplicación.
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
 * @version 2012-10-27
 */
class ErrorHandler {

	/**
	 * Método para manejar los errores ocurridos en la aplicación
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-10-27
	 */
	public static function handle($code, $description, $file = null, $line = null, $context = null) {
		// Si no se deben mostrar errores, omitir
		if (error_reporting() === 0) {
			return false;
		}
		// Traducir código de error
		list($error, $log) = self::mapErrorCode($code);
		// Generar arreglo
		$data = array(
			'code' => $code,
			'error' => $error,
			'level' => $log,			
			'description' => $description,
			'file' => $file,
			'line' => $line,
			'context' => $context
		);
		// Renderizar
		self::render($data);
	}

	/**
	 * Método que realiza el renderizado del error
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-10-27
	 */
	private static function render ($data) {
		echo '<div class="error-message">';
		echo '[',$data['error'],'] ', $data['description'], ' en ', $data['file'], ' línea ', $data['line'], '<br />', "\n";
		echo '</div>';
	}

	/**
	 * Método que mapea el de código de error al nivel en string
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-10-27
	 */
	private static function mapErrorCode($code) {
		$error = $log = null;
		switch ($code) {
			case E_PARSE:
			case E_ERROR:
			case E_CORE_ERROR:
			case E_COMPILE_ERROR:
			case E_USER_ERROR:
				$error = 'Fatal Error';
				$log = LOG_ERROR;
			break;
			case E_WARNING:
			case E_USER_WARNING:
			case E_COMPILE_WARNING:
			case E_RECOVERABLE_ERROR:
				$error = 'Warning';
				$log = LOG_WARNING;
			break;
			case E_NOTICE:
			case E_USER_NOTICE:
				$error = 'Notice';
				$log = LOG_NOTICE;
			break;
			case E_STRICT:
				$error = 'Strict';
				$log = LOG_NOTICE;
			break;
			case E_DEPRECATED:
				$error = 'Deprecated';
				$log = LOG_NOTICE;
			break;
		}
		return array($error, $log);
	}	
	
}
