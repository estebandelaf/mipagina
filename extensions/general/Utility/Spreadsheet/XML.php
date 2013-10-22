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
 * @version 2013-07-05
 */
final class XML {

	public static function read ($archivo) {
	}

	public static function generate ($data, $id) {
		// limpiar posible contenido envíado antes
		ob_clean();
		// cabeceras del archivo
		header('Content-type: application/xml');
		header('Content-Disposition: inline; filename='.$id.'.csv');
		header('Pragma: no-cache');
		header('Expires: 0');
		// cuerpo del archivo
		echo '<?xml version="1.0" encoding="utf-8" ?>',"\n";
		echo '<table name="',string2url($id),'">',"\n";
		$titles = array_shift($data);
		echo "\t",'<thead>',"\n";
		echo "\t\t",'<th>',"\n";
		foreach ($titles as &$col) {
			echo "\t\t\t",'<td name="',string2url($col),'">',
			str_replace('<br />', ', ', $col),'</td>',"\n";
			$col = string2url($col);
		}
		echo "\t\t",'</th>',"\n";
		echo "\t",'</thead>',"\n";
		echo "\t",'<tbody>',"\n";
		foreach($data as &$row) {
			echo "\t\t",'<tr>',"\n";
			$i = 0;
			foreach($row as &$col) {
				echo "\t\t\t",'<td name="',$titles[$i],'">',
				str_replace('<br />', ', ', $col),'</td>',"\n";
				$i++;
			}
			echo "\t\t",'</tr>',"\n";
		}
		echo "\t",'</tbody>',"\n";
		echo '</table>',"\n";
		// liberar memoria y terminar script
		unset($titles, $data, $id);
		exit(0);
	}

}
