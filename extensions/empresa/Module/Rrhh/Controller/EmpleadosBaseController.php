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

// Clase que será extendida por esta clase
App::uses('AppController', 'Controller');

/**
 * Clase abstracta para el controlador asociado a la tabla empleado de la base de datos
 * Comentario de la tabla: Listado de empleados de la empresa
 * Esta clase permite controlar las acciones básicas entre el modelo y vista para la tabla empleado, o sea implementa métodos CRUD
 * @author MiPaGiNa Code Generator
 * @version 2014-03-08 14:08:04
 */
abstract class EmpleadosBaseController extends AppController {

	protected $_registersPerPage = 20; ///< Registros por página en la vista "listar"

	/**
	 * Controlador para listar los registros de tipo Empleado
	 * @author MiPaGiNa Code Generator
	 * @version 2014-03-08 14:08:04
	 */
	public function listar ($page = 1, $orderby = null, $order = 'A') {
		// crear objeto
		$Empleados = new Empleados();
		// si se debe buscar se agrega filtro
		$searchUrl = null;
		$search = array();
		if(!empty($_GET['search'])) {
			$searchUrl = '?search='.$_GET['search'];
			$filters = explode(',', $_GET['search']);
			$where = array();
			foreach($filters as &$filter) {
				list($var, $val) = explode(':', $filter);
				$search[$var] = $val;
				// dependiendo del tipo de datos se ve como filtrar
				if(in_array(Empleado::$columnsInfo[$var]['type'], array('char', 'character varying')))
					$where[] = $Empleados->like($var, $val);
				else
					$where[] = $Empleados->sanitize($var)." = '".$Empleados->sanitize($val)."'";
			}
			// agregar condicion a la busqueda
			$Empleados->setWhereStatement(implode(' AND ', $where));
		}
		// si se debe ordenar se agrega
		if($orderby) {
			$Empleados->setOrderByStatement($orderby.' '.($order=='D'?'DESC':'ASC'));
		}
		// total de registros
		$registers_total = $Empleados->count();
		// paginar si es necesario
		if((integer)$page>0) {
			$registers_per_page = Configure::read('app.registers_per_page');
			$pages = ceil($registers_total/$registers_per_page);
			$Empleados->setLimitStatement($registers_per_page, ($page-1)*$registers_per_page);
			if ($page != 1 && $page > $pages) {
				$this->redirect(
					$this->module_url.'empleados/listar/1'.($orderby ? '/'.$orderby.'/'.$order : '').$searchUrl
				);
			}
		}
		// setear variables
		$this->set(array(
			'module_url' => $this->module_url,
			'controller' => $this->request->params['controller'],
			'page' => $page,
			'orderby' => $orderby,
			'order' => $order,
			'searchUrl' => $searchUrl,
			'search' => $search,
			'Empleados' => $Empleados->getObjects(),
			'columnsInfo' => Empleado::$columnsInfo,
			'registers_total' => $registers_total,
			'pages' => isset($pages) ? $pages : 0,
			'linkEnd' => ($orderby ? '/'.$orderby.'/'.$order : '').$searchUrl,
			'fkModule' => Empleado::$fkModule,
		));
	}
	
	/**
	 * Controlador para crear un registro de tipo Empleado
	 * @author MiPaGiNa Code Generator
	 * @version 2014-03-08 14:08:04
	 */
	public function crear () {
		// si se envió el formulario se procesa
		if(isset($_POST['submit'])) {
			$Empleado = new Empleado();
			$Empleado->set($_POST);
			$Empleado->save();
			Session::message('Registro Empleado creado');
			$this->redirect(
				$this->module_url.'empleados/listar'
			);
		}
		// setear variables
		$this->set(array(
			'columnsInfo' => Empleado::$columnsInfo,
			'fkModule' => Empleado::$fkModule,
		));
	}
	
	/**
	 * Controlador para editar un registro de tipo Empleado
	 * @author MiPaGiNa Code Generator
	 * @version 2014-03-08 14:08:04
	 */
	public function editar ($run) {
		$Empleado = new Empleado($run);
		// si el registro que se quiere editar no existe error
		if(!$Empleado->exists()) {
			Session::message('Registro Empleado('.implode(', ', func_get_args()).') no existe, no se puede editar');
			$this->redirect(
				$this->module_url.'empleados/listar'
			);
		}
		// si no se ha enviado el formulario se mostrará
		if(!isset($_POST['submit'])) {
			$this->set(array(
				'Empleado' => $Empleado,
				'columnsInfo' => Empleado::$columnsInfo,
				'fkModule' => Empleado::$fkModule,
			));
		}
		// si se envió el formulario se procesa
		else {
			$Empleado->set($_POST);
			$Empleado->save();
			if(method_exists($this, 'u')) {
				$this->u($run);
			}
			Session::message('Registro Empleado('.implode(', ', func_get_args()).') editado');
			$this->redirect(
				$this->module_url.'empleados/listar'
			);
		}
	}

	/**
	 * Controlador para eliminar un registro de tipo Empleado
	 * @author MiPaGiNa Code Generator
	 * @version 2014-03-08 14:08:04
	 */
	public function eliminar ($run) {
		$Empleado = new Empleado($run);
		// si el registro que se quiere eliminar no existe error
		if(!$Empleado->exists()) {
			Session::message('Registro Empleado('.implode(', ', func_get_args()).') no existe, no se puede eliminar');
			$this->redirect(
				$this->module_url.'empleados/listar'
			);
		}
		$Empleado->delete();
		Session::message('Registro Empleado('.implode(', ', func_get_args()).') eliminado');
		$this->redirect($this->module_url.'empleados/listar');
	}

	/**
	 * Método para subir todos los archivos desde un formulario
	 * @author MiPaGiNa Code Generator
	 * @version 2014-03-08 14:08:04
	 */
	protected function u ($run) {
		App::uses('File', 'Utility');
		$Empleado = new Empleado($run);
		$files = array('foto');
		foreach($files as &$file) {
			if(isset($_FILES[$file]) && !$_FILES[$file]['error']) {
				$archivo = File::upload($_FILES[$file]);
				if(is_array($archivo)) {
					$Empleado->saveFile($file, $archivo);
				}
			}
		}
	}

	/**
	 * Método para descargar un archivo desde la base de datos
	 * @author MiPaGiNa Code Generator
	 * @version 2014-03-08 14:08:04
	 */
	public function d ($campo, $run) {
		$Empleado = new Empleado($run);
		$this->response->sendFile(array(
			'name' => $Empleado->{$campo.'_name'},
			'type' => $Empleado->{$campo.'_type'},
			'size' => $Empleado->{$campo.'_size'},
			'data' => pg_unescape_bytea($Empleado->{$campo.'_data'}),
		));
	}


}
