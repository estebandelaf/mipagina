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
 * Manejo de planillas de cálculo de OpenDocumment
 * @author DeLaF, esteban[at]delaf.cl
 * @version 2013-04-04
 */
final class ODS {

	/**
	 * Lee el contenido de una hoja y lo devuelve como arreglo
	 * @param sheet Hoja a leer (0..n)
	 * @return Arreglo con los datos de la hoja (indices parten en 1)
	 * @author DeLaF, esteban[at]delaf.cl
	 * @version 2012-06-11
	 */
	public static function read ($archivo = null, $hoja = 0) {
		App::uses('XLS', 'Utility/Spreadsheet');
		return XLS::read($archivo, $hoja, 'OOCalc');
	}

	/**
	 *  Crea una planilla de cálculo a partir de un arreglo
	 * @param data Arreglo utilizado para generar la planilla
	 * @param id Identificador de la planilla
	 * @author DeLaF, esteban[at]delaf.cl
	 * @version 2013-07-05
	 */
	public static function generate ($data, $id) {
		App::import('Vendor/odsPhpGenerator/ods');
		$ods = new \odsphpgenerator\ods();
		$table = new \odsphpgenerator\odsTable($id);
		foreach($data as &$fila) {
			$row = new \odsphpgenerator\odsTableRow();
			foreach($fila as &$celda)
				$row->addCell(new \odsphpgenerator\odsTableCellString(str_replace('<br />', "\n", $celda)));
			$table->addRow($row);
		}
		$ods->addTable($table);
		unset($data, $table, $fila, $celda, $row);
		$ods->downloadOdsFile($id.'.ods');
		exit(0);
	}

	/**
	 * Método que retorna los nombres de las hojas
	 * @param archivo Archivo que se procesará
	 * @return Arreglo con los nombres de las hojas
	 * @author DeLaF (esteban[at]delaf.cl)
	 * @version 2013-04-04
	 */
	public static function sheets ($archivo) {
		App::uses('XLS', 'Utility/Spreadsheet');
		return XLS::sheets($archivo, 'OOCalc');
	}

}
