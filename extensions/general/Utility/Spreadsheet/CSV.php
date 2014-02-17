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
 * Manejar archivos csv
 *
 * Esta clase permite leer y generar archivos csv
 * @author DeLaF, esteban[at]delaf.cl
 * @version 2014-02-16
 */
final class CSV {

	/**
	 * Lee un archivo CSV
	 * @param archivo archivo a leer (ejemplo celca tmp_name de un arreglo $_FILES)
	 * @param separador separador a utilizar para diferenciar entre una columna u otra
	 * @author DeLaF, esteban[at]delaf.cl
	 * @version 2012-06-1
	 */
	public static function read ($archivo = null, $separador = ',', $delimitadortexto = '"') {
		if (($handle = fopen($archivo, "r")) !== FALSE) {
			$data = array();
			$i = 0;
			while (($row = fgetcsv($handle)) !== FALSE) {
				$j = 0;
				foreach($row as &$col) {
					$data[$i][$j++] = $col;
				}
				++$i;
			}
			fclose($handle);
		}
		return $data;
	}

	/**
	 * Crea un archivo CSV a partir de un arreglo
	 * @param data Arreglo utilizado para generar la planilla
	 * @param id Identificador de la planilla
	 * @param separador separador a utilizar para diferenciar entre una columna u otra
	 * @author DeLaF, esteban[at]delaf.cl
	 * @version 2014-02-16
	 */
	public static function generate ($data, $id, $separador = ',',
						$delimitadortexto = '"') {
		ob_clean();
		header('Content-type: text/csv');
		header('Content-Disposition: attachment; filename='.$id.'.csv');
		header('Pragma: no-cache');
		header('Expires: 0');
		foreach($data as &$row) {
			foreach($row as &$col) {
				$col = $delimitadortexto.rtrim(str_replace('<br />', ', ', strip_tags($col, '<br>')), " \t\n\r\0\x0B,").$delimitadortexto;
			}
			echo implode($separador, $row),"\n";
			unset($row);
		}
		unset($data);
		exit(0);
	}
	
}
