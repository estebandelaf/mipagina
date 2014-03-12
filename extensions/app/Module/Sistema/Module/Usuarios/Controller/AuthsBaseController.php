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
 * Clase abstracta para el controlador asociado a la tabla auth de la base de datos
 * Comentario de la tabla: Permisos de grupos para acceder a recursos
 * Esta clase permite controlar las acciones básicas entre el modelo y vista para la tabla auth, o sea implementa métodos CRUD
 * @author MiPaGiNa Code Generator
 * @version 2014-02-23 23:52:13
 */
abstract class AuthsBaseController extends AppController {

	protected $_registersPerPage = 20; ///< Registros por página en la vista "listar"

	/**
	 * Controlador para listar los registros de tipo Auth
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-23 23:52:13
	 */
	public function listar ($page = 1, $orderby = null, $order = 'A') {
		// crear objeto
		$Auths = new Auths();
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
				if(in_array(Auth::$columnsInfo[$var]['type'], array('char', 'character varying')))
					$where[] = $Auths->like($var, $val);
				else
					$where[] = $Auths->sanitize($var)." = '".$Auths->sanitize($val)."'";
			}
			// agregar condicion a la busqueda
			$Auths->setWhereStatement(implode(' AND ', $where));
		}
		// si se debe ordenar se agrega
		if($orderby) {
			$Auths->setOrderByStatement($orderby.' '.($order=='D'?'DESC':'ASC'));
		}
		// total de registros
		$registers_total = $Auths->count();
		// paginar si es necesario
		if((integer)$page>0) {
			$registers_per_page = Configure::read('app.registers_per_page');
			$pages = ceil($registers_total/$registers_per_page);
			$Auths->setLimitStatement($registers_per_page, ($page-1)*$registers_per_page);
			if ($page != 1 && $page > $pages) {
				$this->redirect(
					$this->module_url.'auths/listar/1'.($orderby ? '/'.$orderby.'/'.$order : '').$searchUrl
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
			'Auths' => $Auths->getObjects(),
			'columnsInfo' => Auth::$columnsInfo,
			'registers_total' => $registers_total,
			'pages' => isset($pages) ? $pages : 0,
			'linkEnd' => ($orderby ? '/'.$orderby.'/'.$order : '').$searchUrl,
			'fkModule' => Auth::$fkModule,
		));
	}
	
	/**
	 * Controlador para crear un registro de tipo Auth
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-23 23:52:13
	 */
	public function crear () {
		// si se envió el formulario se procesa
		if(isset($_POST['submit'])) {
			$Auth = new Auth();
			$Auth->set($_POST);
			$Auth->save();
			Session::message('Registro Auth creado');
			$this->redirect(
				$this->module_url.'auths/listar'
			);
		}
		// setear variables
		$this->set(array(
			'columnsInfo' => Auth::$columnsInfo,
			'fkModule' => Auth::$fkModule,
		));
	}
	
	/**
	 * Controlador para editar un registro de tipo Auth
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-23 23:52:13
	 */
	public function editar ($id) {
		$Auth = new Auth($id);
		// si el registro que se quiere editar no existe error
		if(!$Auth->exists()) {
			Session::message('Registro Auth('.implode(', ', func_get_args()).') no existe, no se puede editar');
			$this->redirect(
				$this->module_url.'auths/listar'
			);
		}
		// si no se ha enviado el formulario se mostrará
		if(!isset($_POST['submit'])) {
			$this->set(array(
				'Auth' => $Auth,
				'columnsInfo' => Auth::$columnsInfo,
				'fkModule' => Auth::$fkModule,
			));
		}
		// si se envió el formulario se procesa
		else {
			$Auth->set($_POST);
			$Auth->save();
			if(method_exists($this, 'u')) {
				$this->u($id);
			}
			Session::message('Registro Auth('.implode(', ', func_get_args()).') editado');
			$this->redirect(
				$this->module_url.'auths/listar'
			);
		}
	}

	/**
	 * Controlador para eliminar un registro de tipo Auth
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-23 23:52:13
	 */
	public function eliminar ($id) {
		$Auth = new Auth($id);
		// si el registro que se quiere eliminar no existe error
		if(!$Auth->exists()) {
			Session::message('Registro Auth('.implode(', ', func_get_args()).') no existe, no se puede eliminar');
			$this->redirect(
				$this->module_url.'auths/listar'
			);
		}
		$Auth->delete();
		Session::message('Registro Auth('.implode(', ', func_get_args()).') eliminado');
		$this->redirect($this->module_url.'auths/listar');
	}



}
