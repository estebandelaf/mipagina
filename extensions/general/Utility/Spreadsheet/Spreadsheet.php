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
 * Manejar planillas en formato CSV, ODS y XLS
 *
 * Esta clase permite leer y generar planillas de cálculo
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
 * @version 2013-07-05
 */
final class Spreadsheet {

	public static $exts = array('ods', 'xls', 'xlsx', 'csv'); ///< extensions

	/**
	 * Lee una planilla de cálculo (CSV, ODS o XLS)
	 * @param archivo arreglo pasado el archivo (ejemplo $_FILES['archivo']) o bien la ruta hacia el archivo
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2013-07-01
	 */
	public static function read ($archivo, $hoja = 0) {
		// si lo que se paso fue la ruta del archivo se debe construir el arreglo con los datos del mismo (igual a arreglo $_FILES)
		if(!is_array($archivo)) {
			// parche: al hacer $archivo['tmp_name'] = $archivo no queda como array, por lo que uso un auxiliar para resetear a archivo
			$aux = $archivo;
			$archivo = null;
			$archivo['tmp_name'] = $aux;
			unset($aux);
			$archivo['name'] = basename($archivo['tmp_name']);
			switch(strtolower(substr($archivo['name'], strrpos($archivo['name'], '.')+1))) {
				case 'csv': { $archivo['type'] = 'text/csv'; break; }
				case 'txt': { $archivo['type'] = 'text/plain'; break; }
				case 'ods': { $archivo['type'] = 'application/vnd.oasis.opendocument.spreadsheet'; break; }
				case 'xls': { $archivo['type'] = 'application/vnd.ms-excel'; break; }
				case 'xlsx': { $archivo['type'] = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'; break; }
				case 'xlsm': { $archivo['type'] = 'application/vnd.ms-excel.sheet.macroEnabled.12'; break; }
			}
			$archivo['size'] = filesize($archivo['tmp_name']);
		}
		// en caso que sea archivo CSV
		if($archivo['type']=='text/csv' || $archivo['type']=='text/plain') {
			App::uses('CSV', 'Utility/Spreadsheet');
			return CSV::read($archivo['tmp_name']);
		}
		// en caso que sea archivo ODS
		else if($archivo['type']=='application/vnd.oasis.opendocument.spreadsheet') {
			App::uses('ODS', 'Utility/Spreadsheet');
			return ODS::read($archivo['tmp_name'], $hoja);
		}
		// en caso que sea archivo XLS
		else if($archivo['type']=='application/vnd.ms-excel') {
			App::uses('XLS', 'Utility/Spreadsheet');
			return XLS::read($archivo['tmp_name'], $hoja);
		}
		// en caso que sea archivo XLSX
		else if($archivo['type']=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
			App::uses('XLS', 'Utility/Spreadsheet');
			return XLS::read($archivo['tmp_name'], $hoja, 'Excel2007');
		}
		// en caso que sea archivo XLSM
		else if($archivo['type']=='application/vnd.ms-excel.sheet.macroEnabled.12') {
			App::uses('XLS', 'Utility/Spreadsheet');
			return XLS::read($archivo['tmp_name'], $hoja, 'Excel2007');
		}
	}

	/**
	 * Crea una planilla de cálculo a partir de un arreglo
	 * @param data Arreglo utilizado para generar la planilla
	 * @param id Identificador de la planilla
	 * @param formato extension de la planilla para definir formato
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2013-07-05
	 */
	public static function generate ($data, $id, $formato = 'ods') {
		// en caso que sea archivo CSV
		if($formato == 'csv') {
			App::uses('CSV', 'Utility/Spreadsheet');
			CSV::generate($data, $id);
		}
		// en caso que sea archivo ODS
		else if($formato == 'ods') {
			App::uses('ODS', 'Utility/Spreadsheet');
			ODS::generate($data, $id);
		}
		// en caso que sea archivo XLS
		else if($formato == 'xls') {
			App::uses('XLS', 'Utility/Spreadsheet');
			XLS::generate($data, $id);
		}
		// en caso que sea archivo XML
		else if($formato == 'xml') {
			App::uses('XML', 'Utility/Spreadsheet');
			XML::generate($data, $id);
		}
		// en caso que sea archivo JSON
		else if($formato == 'json') {
			App::uses('JSON', 'Utility/Spreadsheet');
			JSON::generate($data, $id);
		}
		// terminar ejecucion del script
		exit();
	}

	/**
	 * Cargar tabla desde un archivo HTML
	 * @todo Revisar errores que se generán por loadHTML (quitar el @, no usarlo!!)
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 */
	public static function readFromHTML($html, $tableId = 1, $withColsNames = true, $utf8decode = false) {
		// arreglo para ir guardando los datos de la tabla
		$data = array();
		// crear objeto DOM (Document Object Model)
		$dom = new DOMDocument();
		@$dom->loadHTML($html);
		// crear objeto para hacer querys al documento
		$xpath = new DOMXPath($dom);
		// si se pidió una tabla por número se sacan todas las tablas y se
		// saca la de la posición (número) requerida
		if(is_numeric($tableId)) {
			$tables = $xpath->query('//table');
			$table = $tables->item($tableId-1);
		}
		// si se está buscando por id la tabla, se hace la búsqueda de forma
		// directa
		else {
			$table = $xpath->query('//div[@id="'.$tableId.'"]');
		}
		// procesar filas
		$rows = $table->getElementsByTagName('tr');
		$from = $withColsNames ? 0 : 1;
		for($i=$from; $i<$rows->length; ++$i) {
			// procesar columnas de cada fila
			$cols = $rows->item($i)->getElementsByTagName('td');
			$row = array();
			foreach($cols as $col) {
				$row[] = $utf8decode ? trim(utf8_decode($col->nodeValue)) : trim($col->nodeValue);
			}
			$data[] = $row;
		}
		// retornar datos de la tabla
		return $data;
	}

	/**
	 * Método que retorna los nombres de las hojas
	 * @param archivo Archivo que se procesará
	 * @return Arreglo con los nombres de las hojas
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2013-04-04
	 */
	public static function sheets ($archivo) {
		// si lo que se paso fue la ruta del archivo se debe construir el arreglo con los datos del mismo (igual a arreglo $_FILES)
		if(!is_array($archivo)) {
			// parche: al hacer $archivo['tmp_name'] = $archivo no queda como array, por lo que uso un auxiliar para resetear a archivo
			$aux = $archivo;
			$archivo = null;
			$archivo['tmp_name'] = $aux;
			unset($aux);
			$archivo['name'] = basename($archivo['tmp_name']);
			switch(strtolower(substr($archivo['name'], strrpos($archivo['name'], '.')+1))) {
				case 'csv': { $archivo['type'] = 'text/csv'; break; }
				case 'txt': { $archivo['type'] = 'text/plain'; break; }
				case 'ods': { $archivo['type'] = 'application/vnd.oasis.opendocument.spreadsheet'; break; }
				case 'xls': { $archivo['type'] = 'application/vnd.ms-excel'; break; }
				case 'xlsx': { $archivo['type'] = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'; break; }
			}
			$archivo['size'] = filesize($archivo['tmp_name']);
		}
		// en caso que sea archivo CSV
		if($archivo['type']=='text/csv' || $archivo['type']=='text/plain') {
			App::uses('CSV', 'Utility/Spreadsheet');
			return CSV::sheets($archivo['tmp_name']);
		}
		// en caso que sea archivo ODS
		else if($archivo['type']=='application/vnd.oasis.opendocument.spreadsheet') {
			App::uses('ODS', 'Utility/Spreadsheet');
			return ODS::sheets($archivo['tmp_name']);
		}
		// en caso que sea archivo XLS
		else if($archivo['type']=='application/vnd.ms-excel') {
			App::uses('XLS', 'Utility/Spreadsheet');
			return XLS::sheets($archivo['tmp_name']);
		}
		// en caso que sea archivo XLSX
		else if($archivo['type']=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
			App::uses('XLS', 'Utility/Spreadsheet');
			return XLS::sheets($archivo['tmp_name'], 'Excel2007');
		}
	}
	
	/**
	 * Método que lee una hoja de cálculo y dibuja una tabla en HTML
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2013-04-04
	 */
	public static function file2html ($file, $sheet = -1, $options = array()) {
		// helper
		App::uses('TableHelper', 'View/Helper');
		$table = new TableHelper();
		// opciones
		$options = array_merge(array(
			'id' => 'file2html',
		), $options);
		// obtener las hojas del archivo
		$sheets = self::sheets(DIR_WEBSITE.DS.$file);
		if($sheet>-1) $sheets = array($sheet=>$sheets[$sheet]);
		// buffer para ir guardando lo que se va generando
		$buffer = '';
		// scripts
		echo '<style>#',$options['id'],' > ul { height: 28px; }</style>';
		echo '<script>$(function() { $("#',$options['id'],'").tabs(); }); </script>';
		// iniciar pestañas
		echo '<div id="',$options['id'],'" style="margin-top: 1em">';
		// agregar títulos de la pestaña
		echo '<ul>';
		foreach($sheets as $id => &$name) {
			echo '<li><a href="#',$options['id'],'_',string2url($name),'">',$name,'</a></li>';
		}
		echo '</ul>';
		// agregar hojas
		foreach($sheets as $id => &$name) {
			echo '<div id="',$options['id'],'_',string2url($name),'">',"\n";
			echo $table->generate(self::read(DIR_WEBSITE.DS.$file, $id));
			echo '</div>';
		}
		// finalizar
		echo '</div>';
		// entregar buffer
		return $buffer;
	}

	/**
	 * Método que tranforma una hoja de calculo (un arreglo donde
	 * la primera fila son los nombres de las columnas) a un
	 * arreglo asociativo (donde las claves de las columnas en
	 * las filas es el nombre de la columna).
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2013-05-08
	 */
	public static function sheet2array ($data) {
		$colNames = array_shift($data);
		$cols = count($colNames);
		$aux = array();
		foreach($data as &$row) {
			$auxRow = array();
			for($i=0; $i<$cols; ++$i) {
				$auxRow[$colNames[$i]] = $row[$i];
			}
			$aux[] = $auxRow;
		}
		return $aux;
	}

}
