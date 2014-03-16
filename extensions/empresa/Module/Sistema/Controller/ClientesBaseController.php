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
 * Clase abstracta para el controlador asociado a la tabla cliente de la base de datos
 * Comentario de la tabla: Listado de clientes de la empresa
 * Esta clase permite controlar las acciones básicas entre el modelo y vista para la tabla cliente, o sea implementa métodos CRUD
 * @author MiPaGiNa Code Generator
 * @version 2014-02-13 17:14:50
 */
abstract class ClientesBaseController extends AppController {

	protected $_registersPerPage = 20; ///< Registros por página en la vista "listar"

	/**
	 * Controlador para listar los registros de tipo Cliente
	 * @todo Agregar condiciones para paginar los datos
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-13 17:14:50
	 */
	public function listar ($page = 1, $orderby = null, $order = 'A') {
		// crear objeto
		$Clientes = new Clientes();
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
				if(in_array(Cliente::$columnsInfo[$var]['type'], array('char', 'character varying')))
					$where[] = $Clientes->like($var, $val);
				else
					$where[] = $Clientes->sanitize($var)." = '".$Clientes->sanitize($val)."'";
			}
			// agregar condicion a la busqueda
			$Clientes->setWhereStatement(implode(' AND ', $where));
		}
		// si se debe ordenar se agrega
		if($orderby) {
			$Clientes->setOrderByStatement($orderby.' '.($order=='D'?'DESC':'ASC'));
		}
		// total de registros
		$registers_total = $Clientes->count();
		// paginar si es necesario
		if((integer)$page>0) {
			$registers_per_page = Configure::read('app.registers_per_page');
			$pages = ceil($registers_total/$registers_per_page);
			$Clientes->setLimitStatement($registers_per_page, ($page-1)*$registers_per_page);
			if ($page != 1 && $page > $pages) {
				$this->redirect(
					$this->module_url.'clientes/listar/1'.($orderby ? '/'.$orderby.'/'.$order : '').$searchUrl
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
			'Clientes' => $Clientes->getObjects(),
			'columnsInfo' => Cliente::$columnsInfo,
			'registers_total' => $registers_total,
			'pages' => isset($pages) ? $pages : 0,
			'linkEnd' => ($orderby ? '/'.$orderby.'/'.$order : '').$searchUrl,
			'fkModule' => Cliente::$fkModule,
		));
	}
	
	/**
	 * Controlador para crear un registro de tipo Cliente
	 * @todo Permitir subir los archivo al crear el registro
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-13 17:14:50
	 */
	public function crear () {
		// si se envió el formulario se procesa
		if(isset($_POST['submit'])) {
			$Cliente = new Cliente();
			$Cliente->set($_POST);
			$Cliente->save();
//			if(method_exists($this, 'u')) $this->u();
			Session::message('Registro Cliente creado');
			$this->redirect(
				$this->module_url.'clientes/listar'
			);
		}
		// setear variables
		$this->set(array(
			'columnsInfo' => Cliente::$columnsInfo,
			'fkModule' => Cliente::$fkModule,
		));
	}
	
	/**
	 * Controlador para editar un registro de tipo Cliente
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-13 17:14:50
	 */
	public function editar ($rut) {
		$Cliente = new Cliente($rut);
		// si el registro que se quiere editar no existe error
		if(!$Cliente->exists()) {
			Session::message('Registro Cliente('.implode(', ', func_get_args()).') no existe, no se puede editar');
			$this->redirect(
				$this->module_url.'clientes/listar'
			);
		}
		// si no se ha enviado el formulario se mostrará
		if(!isset($_POST['submit'])) {
			$this->set(array(
				'Cliente' => $Cliente,
				'columnsInfo' => Cliente::$columnsInfo,
				'fkModule' => Cliente::$fkModule,
			));
		}
		// si se envió el formulario se procesa
		else {
			$Cliente->set($_POST);
			$Cliente->save();
			if(method_exists($this, 'u')) {
				$this->u($rut);
			}
			Session::message('Registro Cliente('.implode(', ', func_get_args()).') editado');
			$this->redirect(
				$this->module_url.'clientes/listar'
			);
		}
	}

	/**
	 * Controlador para eliminar un registro de tipo Cliente
	 * @author MiPaGiNa Code Generator
	 * @version 2014-02-13 17:14:50
	 */
	public function eliminar ($rut) {
		$Cliente = new Cliente($rut);
		// si el registro que se quiere eliminar no existe error
		if(!$Cliente->exists()) {
			Session::message('Registro Cliente('.implode(', ', func_get_args()).') no existe, no se puede eliminar');
			$this->redirect(
				$this->module_url.'clientes/listar'
			);
		}
		$Cliente->delete();
		Session::message('Registro Cliente('.implode(', ', func_get_args()).') eliminado');
		$this->redirect($this->module_url.'clientes/listar');
	}



}
