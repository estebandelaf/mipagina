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
 * Clase para despachar una Shell
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
 * @version 2012-09-14
 */
class ShellDispatcher {

	/**
	 * Método que ejecuta el comando solicitado
	 * @param argv Argumentos pasados al script (incluye comando)
	 * @return Resultado de la ejecición del comando
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-09-14
	 */
	public static function run ($argv) {
		// Determinar que ejecutar
		if(!empty($argv[1])) {
			$command = ucfirst($argv[1]);
			$args = array_slice($argv, 2);
		} else {
			$command = null;
			$args = array_slice($argv, 1);
		}
		// Despachar shell
		return self::dispatch($command, $args);
	}

	/**
	 * Método que ejecuta un comando
	 * @param command Comando a ejecutar
	 * @param args Argumentos que se pasarán al comando
	 * @return Resultado de la ejecución del comando
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-09-14
	 */
	private static function dispatch ($command, $args) {
		// Si el comando fue vacío se retorna estado de error
		if(empty($command)) return 1;
		// Cargar clase
		$class = $command.'Shell';
		App::uses($class, 'Shell/Command');
		// Crear objeto
		$shell = new $class();
		// Método principal que se ejecutará
		$method = new ReflectionMethod($shell, 'main');
		// Invocar el método con los argumentos de $request->params['pass'] 
		$return = $method->invokeArgs($shell, $args);
		// Retornar estado
		return $return ? $return : 0;
	}

}
