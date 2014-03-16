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
 * Clase abstracta para el controlador asociado a la tabla provincia de la base de datos
 * Comentario de la tabla: Provincias de cada región del país
 * Esta clase permite controlar las acciones básicas entre el modelo y vista para la tabla provincia, o sea implementa métodos CRUD
 * @author MiPaGiNa Code Generator
 * @version 2014-02-13 19:09:38
 */
abstract class ProvinciasBaseController extends AppController {

	protected $_registersPerPage = 20; ///< Registros por página en la vista "listar"

	/**
	 * Controlador para listar los registros de tipo Provincia
	 * @todo Agregar condiciones para paginar los datos
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-13 19:09:38
	 */
	public function listar ($page = 1, $orderby = null, $order = 'A') {
		// crear objeto
		$Provincias = new Provincias();
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
				if(in_array(Provincia::$columnsInfo[$var]['type'], array('char', 'character varying')))
					$where[] = $Provincias->like($var, $val);
				else
					$where[] = $Provincias->sanitize($var)." = '".$Provincias->sanitize($val)."'";
			}
			// agregar condicion a la busqueda
			$Provincias->setWhereStatement(implode(' AND ', $where));
		}
		// si se debe ordenar se agrega
		if($orderby) {
			$Provincias->setOrderByStatement($orderby.' '.($order=='D'?'DESC':'ASC'));
		}
		// total de registros
		$registers_total = $Provincias->count();
		// paginar si es necesario
		if((integer)$page>0) {
			$registers_per_page = Configure::read('app.registers_per_page');
			$pages = ceil($registers_total/$registers_per_page);
			$Provincias->setLimitStatement($registers_per_page, ($page-1)*$registers_per_page);
			if ($page != 1 && $page > $pages) {
				$this->redirect(
					$this->module_url.'provincias/listar/1'.($orderby ? '/'.$orderby.'/'.$order : '').$searchUrl
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
			'Provincias' => $Provincias->getObjects(),
			'columnsInfo' => Provincia::$columnsInfo,
			'registers_total' => $registers_total,
			'pages' => isset($pages) ? $pages : 0,
			'linkEnd' => ($orderby ? '/'.$orderby.'/'.$order : '').$searchUrl,
			'fkModule' => Provincia::$fkModule,
		));
	}
	
	/**
	 * Controlador para crear un registro de tipo Provincia
	 * @todo Permitir subir los archivo al crear el registro
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-13 19:09:38
	 */
	public function crear () {
		// si se envió el formulario se procesa
		if(isset($_POST['submit'])) {
			$Provincia = new Provincia();
			$Provincia->set($_POST);
			$Provincia->save();
//			if(method_exists($this, 'u')) $this->u();
			Session::message('Registro Provincia creado');
			$this->redirect(
				$this->module_url.'provincias/listar'
			);
		}
		// setear variables
		$this->set(array(
			'columnsInfo' => Provincia::$columnsInfo,
			'fkModule' => Provincia::$fkModule,
		));
	}
	
	/**
	 * Controlador para editar un registro de tipo Provincia
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-13 19:09:38
	 */
	public function editar ($codigo) {
		$Provincia = new Provincia($codigo);
		// si el registro que se quiere editar no existe error
		if(!$Provincia->exists()) {
			Session::message('Registro Provincia('.implode(', ', func_get_args()).') no existe, no se puede editar');
			$this->redirect(
				$this->module_url.'provincias/listar'
			);
		}
		// si no se ha enviado el formulario se mostrará
		if(!isset($_POST['submit'])) {
			$this->set(array(
				'Provincia' => $Provincia,
				'columnsInfo' => Provincia::$columnsInfo,
				'fkModule' => Provincia::$fkModule,
			));
		}
		// si se envió el formulario se procesa
		else {
			$Provincia->set($_POST);
			$Provincia->save();
			if(method_exists($this, 'u')) {
				$this->u($codigo);
			}
			Session::message('Registro Provincia('.implode(', ', func_get_args()).') editado');
			$this->redirect(
				$this->module_url.'provincias/listar'
			);
		}
	}

	/**
	 * Controlador para eliminar un registro de tipo Provincia
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-13 19:09:38
	 */
	public function eliminar ($codigo) {
		$Provincia = new Provincia($codigo);
		// si el registro que se quiere eliminar no existe error
		if(!$Provincia->exists()) {
			Session::message('Registro Provincia('.implode(', ', func_get_args()).') no existe, no se puede eliminar');
			$this->redirect(
				$this->module_url.'provincias/listar'
			);
		}
		$Provincia->delete();
		Session::message('Registro Provincia('.implode(', ', func_get_args()).') eliminado');
		$this->redirect($this->module_url.'provincias/listar');
	}



}
