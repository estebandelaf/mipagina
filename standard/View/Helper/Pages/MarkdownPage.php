<?php

/**
 * MiPaGiNa (MP)
 * Copyright (C) 2014 Esteban De La Fuente Rubio (esteban[at]delaf.cl)
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
 * Clase para cargar una página en formato Markdown
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
 * @version 2012-10-19
 */
class MarkdownPage {

	/**
	 * Método que renderiza una página en formato Markdown
	 * @param file Archivo que se desea renderizar
	 * @param vars Arreglo con variables que se desean pasar
	 * @return Buffer de la página renderizada
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-10-19
	 */
	public static function render ($file, $vars = array()) {
		App::import('Vendor/markdown/markdown');
		return Markdown(self::_evaluate($file, $vars));
	}
	
	/**
	 * Método que evalua el archivo con formato Markdown
	 * @param file Archivo que se desea renderizar
	 * @param vars Arreglo con variables que se desean pasar
	 * @return Buffer de la página renderizada
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-10-19
	 */
	private static function _evaluate($file, $variables = array()) {
		// cargar achivo
		$data = file_get_contents($file);
		// reemplazar variables en los datos del archivo
		foreach($variables as $key => $valor)
			$data = str_replace('{'.$key.'}', $valor, $data);
		// retornar plantilla ya procesada
		return $data;
	}

}
