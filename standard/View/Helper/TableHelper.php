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
 * Helper para la creación de tablas en HTML
 * @todo Arreglar tablas para paginar, exportar, etc
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
 * @version 2013-07-08
 */
class TableHelper {

	private $_id = 'table'; ///< Identificador de la tabla
	private $_class = ''; ///< Atributo class para la tabla
	private $_export = false; ///< Crear o no datos para exportar
	private $_exportRemove = array(); ///< Datos que se removeran al exportar
	private $_display = true; ///< Indica si se debe o no mostrar la tabla

	public function __construct ($table = null) {
		// si se paso una tabla se genera directamente y se imprime
		// esto evita una línea de programación em muchos casos
		if(is_array($table)) {
			echo $this->generate($table);
		}
	}

	public function setId ($id) {
		$this->_id = $id;
	}

	public function setClass ($class) {
		$this->_class = $class;
	}

	public function setExport ($export) {
		$this->_export = $export;
	}

	public function setExportRemove ($remove) {
		$this->_exportRemove = $remove;
	}

	public function setDisplay ($display) {
		$this->_display = $display;
	}
	
	public function generate ($table) {
		// si el arreglo esta vacio o no es arreglo retornar nada
		if(!is_array($table) || !count($table)) {
			return null;
		}
		// Utilizar buffer para el dibujado, así lo retornaremos en vez
		// de imprimir directamente
		$buffer = '<div>'."\n";
		// Crear iconos para exportar y ocultar/mostrar tabla
		$buffer .= '<div style="float:right">'."\n";
		$buffer .= $this->export ($table);
		$buffer .= $this->showAndHide ();
		$buffer .= '</div>'."\n";
		// Iniciar tabla
		$buffer .= '<table class="'.$this->_class.'" id="'.$this->_id.'">'."\n";
		// Definir títulos de columnas
		$buffer .= "\t".'<thead>'."\n";
		$titles = array_shift($table);
		$buffer .= "\t\t".'<tr>'."\n";
		foreach($titles as &$col) {
			$buffer .= "\t\t\t".'<th>'.$col.'</th>'."\n";
		}
		$buffer .= "\t\t".'</tr>'."\n";
		$buffer .= "\t".'</thead>'."\n";
		// Definir datos de la tabla
		$buffer .= "\t".'<tbody>'."\n";
		if(is_array($table)) {
			foreach($table as &$row) {
				$buffer .= "\t\t".'<tr>'."\n";
				foreach($row as &$col) {
					$buffer .= "\t\t\t".'<td>'.$col.'</td>'."\n";
				}
				$buffer .= "\t\t".'</tr>'."\n";
			}
		}
		$buffer .= "\t".'</tbody>'."\n";
		// Finalizar tabla
		$buffer .= '</table>'."\n";
		$buffer .= '</div>'."\n";
		// Retornar tabla en HTML
		return $buffer;
	}

	private function export (&$table) {
		// si no se debe exportar retornar vacío
		if(!$this->_export) return '';
		// generar datos para la exportación
		$data = array();
		$nRow = 0;
		$nRows = count($table);
		foreach ($table as &$row) {
			$nRow++;
			if(isset($this->_exportRemove['rows'])) {
				if(
					in_array($nRow, $this->_exportRemove['rows']) ||
					in_array($nRow-$nRows-1, $this->_exportRemove['rows'])
				) {
					continue;
				}
			}
			$nCol = 0;
			$nCols = count($row);
			$aux = array();
			foreach($row as $col) {
				$nCol++;
				if(isset($this->_exportRemove['rows'])) {
					if(
						in_array($nCol, $this->_exportRemove['cols']) ||
						in_array($nCol-$nCols-1, $this->_exportRemove['cols'])
					) {
						continue;
					}
				}
				if(isset($col[0]) && $col[0]!='<') {
					$parts = explode('<br>', $col);
					$aux[] = $parts[0]; // :-)
				} else
					$aux[] = '';
			}
			$data[] = $aux;
		}
		// escribir datos para la exportación
		Session::write('export.'.$this->_id, $data);
		// colocar iconos
		$_base = Request::getBase();
		$buffer = '';
		$extensions = array('ods', 'xls', 'csv', 'pdf', 'xml', 'json');
		foreach ($extensions as $e) {
			$buffer .= '<a href="'.$_base.'/exportar/'.$e.'/'.$this->_id.'" title="Exportar a '.strtoupper($e).'"><img src="'.$_base.'/exportar/img/icons/16x16/'.$e.'.png" alt="" /></a> ';
		}
		return $buffer;
	}

	public function showAndHide () {
		$_base = Request::getBase();
		$buffer = '';
		$buffer .= '<a onclick="$(\'#'.$this->_id.'\').show(); $(\'#tableShow'.$this->_id.'\').hide(); $(\'#tableHide'.$this->_id.'\').show();" id="tableShow'.$this->_id.'" title="Mostrar tabla"><img src="'.$_base.'/img/icons/16x16/actions/more.gif" alt="" /></a>';
		$buffer .= '<a onclick="$(\'#'.$this->_id.'\').hide(); $(\'#tableHide'.$this->_id.'\').hide(); $(\'#tableShow'.$this->_id.'\').show();" id="tableHide'.$this->_id.'" title="Ocultar tabla"><img src="'.$_base.'/img/icons/16x16/actions/less.gif" alt="" /></a>';
		$buffer .= '<script type="text/javascript"> $(function() { ';
		if ($this->_display) {
			$buffer .= '$(\'#tableShow'.$this->_id.'\').hide();';
		} else {
			$buffer .= '$(\'#'.$this->_id.'\').hide(); $(\'#tableHide'.$this->_id.'\').hide();';
		}
		$buffer .= ' }); </script>';
		return $buffer;
	}

}
