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
 * Manejar archivos xml
 *
 * Esta clase permite leer y generar archivos xml
 * @author DeLaF, esteban[at]delaf.cl
 * @version 2014-02-17
 */
final class XML {

	public static function read ($archivo) {
	}

	public static function generate ($data, $id) {
		// limpiar posible contenido envíado antes
		ob_clean();
		// cabeceras del archivo
		header('Content-type: application/xml');
		header('Content-Disposition: inline; filename='.$id.'.xml');
		header('Pragma: no-cache');
		header('Expires: 0');
		// cuerpo del archivo
		$root = string2url(Inflector::underscore($id));
		$item = Inflector::singularize($root);
		echo '<?xml version="1.0" encoding="utf-8" ?>',"\n";
		echo '<',$root,'>',"\n";
		$titles = array_shift($data);
		foreach ($titles as &$col) {
			$col = string2url(strip_tags($col));
		}
		foreach($data as &$row) {
			echo "\t",'<',$item,'>',"\n";
			foreach($row as $key => &$col) {
				$key = $titles[$key];
				echo "\t\t",'<',$key,'>',rtrim(str_replace('<br />', ', ', strip_tags($col, '<br>')), " \t\n\r\0\x0B,"),'</',$key,'>',"\n";
			}
			echo "\t",'</',$item,'>',"\n";
		}
		echo '</',$root,'>',"\n";
		// terminar script
		exit(0);
	}

}
