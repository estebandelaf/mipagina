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
 * Clase para cargar una página PHP
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
 * @version 2012-10-19
 */
class PhpPage {

	/**
	 * Método que renderiza una página PHP
	 * @param file Archivo que se desea renderizar
	 * @param vars Arreglo con variables que se desean pasar
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-10-19
	 */
	public static function render ($file, $vars = array()) {
		return self::_evaluate($file, $vars);
	}

	/**
	 * Método que evalua el archivo de la vista utilizando las variables
	 * indicadas en $___dataForView
	 * @param ___viewFn Archivo con la página que se desea renderizar
	 * @param ___dataForView Variables para la página a renderizar
	 * @return Buffer de la página renderizada
	 * @author CakePHP
	 */
	private static function _evaluate($___viewFn, $___dataForView = array()) {
		// Extraer del arreglo las variables para que se reemplacen en la vista
		extract($___dataForView, EXTR_SKIP);
		// crea variables globales para aquellas que se han difinido y existan
		$globals = Configure::read('page.globals');
		foreach($globals as &$global) {
			global $$global;
		}
		// Iniciar buffer
		ob_start();
		// Incluir vista y automáticamente se reemplazará por lo que había en $___dataForView
		include $___viewFn;
		// Limpiar y retornar buffer
		return ob_get_clean();
	}

}
