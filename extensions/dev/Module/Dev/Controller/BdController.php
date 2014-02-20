<?php

App::uses ('AppController', 'Controller');

class BdController extends AppController {

	public function tablas () {
		if (isset($_POST['submit'])) {
			$db = &Database::get ($_POST['database']);
			$tables = $db->getTables();
			$data = array();
			foreach($tables as &$table) {
				$info = $db->getInfoFromTable($table['name']);
				$row = array(
					'name' => $info['name'],
					'comment' => $info['comment'],
					'columns' => array(),
					'pk' => implode ('<br />', $info['pk']),
				);
				foreach ($info['columns'] as &$column) {
					$name = 
					$row['columns'][] = '<strong>['.$column['name'].']</strong> '.
								($column['comment']!=''?$column['comment'].': ':'').
								$column['type'].
								'('.$column['length'].')'.
								(($column['null']==='YES'||$column['null']==1)?' NULL':' NOT NULL').
								(" DEFAULT '".$column['default']."' ").
								(($column['auto']==='YES'||$column['auto']==1)?'AUTO ':'').
								(in_array($column['name'], $info['pk'])?'PK ':'').
								(is_array($column['fk'])?'FK:'.$column['fk']['table'].'.'.$column['fk']['column']:'')
					;
				}
				$row['columns'] = implode ('<br />', $row['columns']);
				$data[] = $row;
			}
			$this->set (array(
				'database' => $_POST['database'],
				'data' => $data
			));
		}
		$this->_setDatabases ();
	}

	public function poblar () {
		if (isset($_FILES['file'])) {
			$db = &Database::get ($_POST['database']);
			App::uses ('Spreadsheet', 'Utility/Spreadsheet');
			$sheets = Spreadsheet::sheets($_FILES['file']);
			$message = array();
			// hacer todo en una transacción
			$db->transaction();
			foreach($sheets as $id => &$name) {
				$data = Spreadsheet::read($_FILES['file'], $id);
				$table = $db->sanitize ($name);
				$info = $db->getInfoFromTable ($table);
				$cols = array_flip(array_shift ($data));
				$existsQuery = 'SELECT COUNT(*) FROM '.$table.' ';
				$whereQuery = 'WHERE '.implode(' = \'?\' AND ', $info['pk']).' = \'?\'';
				$updateQuery = 'UPDATE '.$table.' SET';
				$insertQuery = 'INSERT INTO '.$table.' ('.implode(', ', array_keys($cols)).') VALUES ';
				// contar registros totales (en el archivo) y existentes antes de hacer algo en la tabla
				$registros = array(
					'total' => count($data),
					'existentes' => $db->getValue ('SELECT COUNT(*) FROM '.$table),
					'actualizados' => 0,
					'insertados' => 0,
				);
				// eliminar datos de la tabla en caso que se haya solicitado
				if (isset($_POST['delete'])) {
					$db->query ('DELETE FROM '.$table);
				}
				// agregar (o actualizar) cada registro
				foreach ($data as &$row) {
					$where = $whereQuery;
					foreach ($info['pk'] as $pk) {
						$where = preg_replace ('/\?/', $row[$cols[$pk]], $where, 1);
					}
					// si el registro existe se actualiza
					if ($db->getValue($existsQuery.$where)) {
						$values = array();
						$auxCols = array_keys ($cols);
						foreach ($row as &$col) {
							if ((string)$col!=='0' && empty($col)) {
								$values[] = array_shift($auxCols).' = NULL';
							} else {
								$values[] = array_shift($auxCols).' = \''.$col.'\'';
							}
						}
						$db->query ($query = $updateQuery.' '.implode(', ', $values).' '.$where);
						$registros['actualizados']++;
					}
					// si el registro no existe se inserta
					else {
						$values = array();
						foreach ($row as &$col) {
							if ((string)$col!=='0' && empty($col)) {
								$values[] = 'NULL';
							} else {
								$values[] = '\''.$col.'\'';
							}
						}
						$db->query($insertQuery.' ('.implode(', ', $values).')');
						$registros['insertados']++;
					}
					
				}
				$message[] = $_POST['database'].'.'.$table.
					': existentes='.$registros['existentes'].
					', actualizados='.$registros['actualizados'].
					', insertados='.$registros['insertados'].
					', total='.$registros['total'];
			}
			// terminar transacción
			$db->commit();
			Session::message (implode('<br />', $message));
		}
		$this->_setDatabases ();
	}

	public function descargar () {
		$this->autoRender = false;
		if (isset($_POST['step1'])) {
			$db = &Database::get ($_POST['database']);
			$this->set(array(
				'database' => $_POST['database'],
				'type' => $_POST['type'],
				'tables' => $db->getTables(),
			));
			$this->render ('Bd/descargar_step2');
		} else if (isset($_POST['step2'])) {
			$db = &Database::get ($_POST['database']);
			$data = array();
			foreach ($_POST['tables'] as &$table) {
				$data[$table] = $db->getTableWithColsNames ('
					SELECT *
					FROM '.$db->sanitize($table).'
				');
			}
			$this->set(array(
				'id'=>'database_'.$_POST['database'],
				'type'=>$_POST['type'],
				'data'=>$data,
			));
			$this->render ('Bd/descargar_step3');
		} else {
			$this->_setDatabases ();
			$this->render ('Bd/descargar_step1');
		}
	}

	private function _setDatabases () {
		$databases = array();
		$aux = Configure::read('database');
		foreach ($aux as $database => &$config) {
			$databases[$database] = $database;
		}
		$this->set ('databases', $databases);
	}

}
