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
 * Clase abstracta para el controlador asociado a la tabla proveedor de la base de datos
 * Comentario de la tabla: Listado de proveedores de la empresa
 * Esta clase permite controlar las acciones básicas entre el modelo y vista para la tabla proveedor, o sea implementa métodos CRUD
 * @author MiPaGiNa Code Generator
 * @version 2014-02-19 17:22:05
 */
abstract class ProveedoresBaseController extends AppController {

	protected $_registersPerPage = 20; ///< Registros por página en la vista "listar"

	/**
	 * Controlador para listar los registros de tipo Proveedor
	 * @todo Agregar condiciones para paginar los datos
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-19 17:22:05
	 */
	public function listar ($page = 1, $orderby = null, $order = 'A') {
		// crear objeto
		$Proveedores = new Proveedores();
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
				if(in_array(Proveedor::$columnsInfo[$var]['type'], array('char', 'character varying')))
					$where[] = $Proveedores->like($var, $val);
				else
					$where[] = $Proveedores->sanitize($var)." = '".$Proveedores->sanitize($val)."'";
			}
			// agregar condicion a la busqueda
			$Proveedores->setWhereStatement(implode(' AND ', $where));
		}
		// si se debe ordenar se agrega
		if($orderby) {
			$Proveedores->setOrderByStatement($orderby.' '.($order=='D'?'DESC':'ASC'));
		}
		// total de registros
		$registers_total = $Proveedores->count();
		// paginar si es necesario
		if((integer)$page>0) {
			$registers_per_page = Configure::read('app.registers_per_page');
			$pages = ceil($registers_total/$registers_per_page);
			$Proveedores->setLimitStatement($registers_per_page, ($page-1)*$registers_per_page);
			if ($page != 1 && $page > $pages) {
				$this->redirect(
					$this->module_url.'proveedores/listar/1'.($orderby ? '/'.$orderby.'/'.$order : '').$searchUrl
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
			'Proveedores' => $Proveedores->getObjects(),
			'columnsInfo' => Proveedor::$columnsInfo,
			'registers_total' => $registers_total,
			'pages' => isset($pages) ? $pages : 0,
			'linkEnd' => ($orderby ? '/'.$orderby.'/'.$order : '').$searchUrl,
			'fkModule' => Proveedor::$fkModule,
		));
	}
	
	/**
	 * Controlador para crear un registro de tipo Proveedor
	 * @todo Permitir subir los archivo al crear el registro
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-19 17:22:05
	 */
	public function crear () {
		// si se envió el formulario se procesa
		if(isset($_POST['submit'])) {
			$Proveedor = new Proveedor();
			$Proveedor->set($_POST);
			$Proveedor->save();
//			if(method_exists($this, 'u')) $this->u();
			Session::message('Registro Proveedor creado');
			$this->redirect(
				$this->module_url.'proveedores/listar'
			);
		}
		// setear variables
		$this->set(array(
			'columnsInfo' => Proveedor::$columnsInfo,
			'fkModule' => Proveedor::$fkModule,
		));
	}
	
	/**
	 * Controlador para editar un registro de tipo Proveedor
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-19 17:22:05
	 */
	public function editar ($rut) {
		$Proveedor = new Proveedor($rut);
		// si el registro que se quiere editar no existe error
		if(!$Proveedor->exists()) {
			Session::message('Registro Proveedor('.implode(', ', func_get_args()).') no existe, no se puede editar');
			$this->redirect(
				$this->module_url.'proveedores/listar'
			);
		}
		// si no se ha enviado el formulario se mostrará
		if(!isset($_POST['submit'])) {
			$this->set(array(
				'Proveedor' => $Proveedor,
				'columnsInfo' => Proveedor::$columnsInfo,
				'fkModule' => Proveedor::$fkModule,
			));
		}
		// si se envió el formulario se procesa
		else {
			$Proveedor->set($_POST);
			$Proveedor->save();
			if(method_exists($this, 'u')) {
				$this->u($rut);
			}
			Session::message('Registro Proveedor('.implode(', ', func_get_args()).') editado');
			$this->redirect(
				$this->module_url.'proveedores/listar'
			);
		}
	}

	/**
	 * Controlador para eliminar un registro de tipo Proveedor
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-19 17:22:05
	 */
	public function eliminar ($rut) {
		$Proveedor = new Proveedor($rut);
		// si el registro que se quiere eliminar no existe error
		if(!$Proveedor->exists()) {
			Session::message('Registro Proveedor('.implode(', ', func_get_args()).') no existe, no se puede eliminar');
			$this->redirect(
				$this->module_url.'proveedores/listar'
			);
		}
		$Proveedor->delete();
		Session::message('Registro Proveedor('.implode(', ', func_get_args()).') eliminado');
		$this->redirect($this->module_url.'proveedores/listar');
	}



}
