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

// Clase que será extendida por esta clase
App::uses('AppController', 'Controller');

/**
 * Clase abstracta para el controlador asociado a la tabla persona de la base de datos
 * Comentario de la tabla: Listado de personas (sean o no usuarios del sistema)
 * Esta clase permite controlar las acciones básicas entre el modelo y vista para la tabla persona, o sea implementa métodos CRUD
 * @author MiPaGiNa Code Generator
 * @version 2013-07-05 01:36:25
 */
abstract class PersonasBaseController extends AppController {

	protected $_registersPerPage = 20; ///< Registros por página en la vista "listar"

	/**
	 * Controlador para listar los registros de tipo Persona
	 * @todo Agregar condiciones para paginar los datos
	 * @author MiPaGiNa Code Generator
	 * @version 2013-07-05 01:36:25
	 */
	public function listar ($page = 1, $orderby = null, $order = 'A') {
		// crear objeto
		$Personas = new Personas();
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
				if(in_array(Persona::$columnsInfo[$var]['type'], array('char', 'character varying')))
					$where[] = $Personas->like($var, $val);
				else
					$where[] = $Personas->sanitize($var)." = '".$Personas->sanitize($val)."'";
			}
			// agregar condicion a la busqueda
			$Personas->setWhereStatement(implode(' AND ', $where));
		}
		// si se debe ordenar se agrega
		if($orderby) {
			$Personas->setOrderByStatement($orderby.' '.($order=='D'?'DESC':'ASC'));
		}
		// total de registros
		$registers_total = $Personas->count();
		// paginar si es necesario
		if((integer)$page>0) {
			$registers_per_page = Configure::read('app.registers_per_page');
			$pages = ceil($registers_total/$registers_per_page);
			$Personas->setLimitStatement($registers_per_page, ($page-1)*$registers_per_page);
			if ($page != 1 && $page > $pages) {
				$this->redirect(
					$this->module_url.'personas/listar/1'.($orderby ? '/'.$orderby.'/'.$order : '').$searchUrl
				);
			}
		}
		// setear variables
		$this->set(array(
			'controller' => $this->request->params['controller'],
			'page' => $page,
			'orderby' => $orderby,
			'order' => $order,
			'searchUrl' => $searchUrl,
			'search' => $search,
			'Personas' => $Personas->getObjects(),
			'columnsInfo' => Persona::$columnsInfo,
			'registers_total' => $registers_total,
			'pages' => isset($pages) ? $pages : 0,
			'linkEnd' => ($orderby ? '/'.$orderby.'/'.$order : '').$searchUrl,
		));
	}
	
	/**
	 * Controlador para crear un registro de tipo Persona
	 * @todo Permitir subir los archivo al crear el registro
	 * @author MiPaGiNa Code Generator
	 * @version 2013-07-05 01:36:25
	 */
	public function crear () {
		// si se envió el formulario se procesa
		if(isset($_POST['submit'])) {
			$Persona = new Persona();
			$Persona->set($_POST);
			$Persona->save();
//			if(method_exists($this, 'u')) $this->u();
			Session::message('Registro Persona creado');
			$this->redirect(
				$this->module_url.'personas/listar'
			);
		}
		// setear variables
		$this->set(array(
			'columnsInfo' => Persona::$columnsInfo,
		));
	}
	
	/**
	 * Controlador para editar un registro de tipo Persona
	 * @author MiPaGiNa Code Generator
	 * @version 2013-07-05 01:36:25
	 */
	public function editar ($run) {
		$Persona = new Persona($run);
		// si el registro que se quiere editar no existe error
		if(!$Persona->exists()) {
			Session::message('Registro Persona('.implode(', ', func_get_args()).') no existe, no se puede editar');
			$this->redirect(
				$this->module_url.'personas/listar'
			);
		}
		// si no se ha enviado el formulario se mostrará
		if(!isset($_POST['submit'])) {
			$this->set(array(
				'Persona' => $Persona,
				'columnsInfo' => Persona::$columnsInfo,
			));
		}
		// si se envió el formulario se procesa
		else {
			$Persona->set($_POST);
			$Persona->save();
			if(method_exists($this, 'u')) {
				$this->u($run);
			}
			Session::message('Registro Persona('.implode(', ', func_get_args()).') editado');
			$this->redirect(
				$this->module_url.'personas/listar'
			);
		}
	}

	/**
	 * Controlador para eliminar un registro de tipo Persona
	 * @author MiPaGiNa Code Generator
	 * @version 2013-07-05 01:36:25
	 */
	public function eliminar ($run) {
		$Persona = new Persona($run);
		// si el registro que se quiere eliminar no existe error
		if(!$Persona->exists()) {
			Session::message('Registro Persona('.implode(', ', func_get_args()).') no existe, no se puede eliminar');
			$this->redirect(
				$this->module_url.'personas/listar'
			);
		}
		$Persona->delete();
		Session::message('Registro Persona('.implode(', ', func_get_args()).') eliminado');
		$this->redirect($this->module_url.'personas/listar');
	}

	/**
	 * Método para subir todos los archivos desde un formulario
	 * @author MiPaGiNa Code Generator
	 * @version 2013-07-05 01:36:25
	 */
	protected function u ($run) {
		App::uses('File', 'Utility');
		$Persona = new Persona($run);
		$files = array('imagen');
		foreach($files as &$file) {
			if(isset($_FILES[$file]) && !$_FILES[$file]['error']) {
				$archivo = File::upload($_FILES[$file]);
				if(is_array($archivo)) {
					$Persona->saveFile($file, $archivo);
				}
			}
		}
	}

	/**
	 * Método para descargar un archivo desde la base de datos
	 * @author MiPaGiNa Code Generator
	 * @version 2013-07-05 01:36:25
	 */
	public function d ($campo, $run) {
		$Persona = new Persona($run);
		$this->response->sendFile(array(
			'name' => $Persona->{$campo.'_name'},
			'type' => $Persona->{$campo.'_type'},
			'size' => $Persona->{$campo.'_size'},
			'data' => pg_unescape_bytea($Persona->{$campo.'_data'}),
		));
	}


}
