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

App::uses('AppController', 'Controller');

class ModuleController extends AppController {

	public function beforeFilter () {
		$this->Auth->allow ('index');
		parent::beforeFilter ();
	}

	/**
	 * Renderizará (sin autenticación) el archivo en View/index
	 */
	public function index () {
		$this->autoRender = false;
		$this->render('index');
	}

	/**
	 * Mostrar la página principal para el módulo (con sus opciones de menú)
	 * @todo Verificar que se muestre un enlace solo si existen sus módulos
	 * requeridos
	 * @version 2013-06-14
	 */
	public function display () {
		// desactivar renderizado automático
		$this->autoRender = false;
		// Si existe una vista para el index del modulo se usa
		if(Module::fileLocation($this->request->params['module'], 'View/index')) {
			$this->render('index');
		}
		// Si no se incluye el archivo con el título y el menú para el módulo
		else {
			// incluir menú del módulo
			$nav_module = Configure::read('nav.module');
			if (!$nav_module) $nav_module = array();
			// nombre del módulo para url
			$module = Inflector::underscore($this->request->params['module']);
			// verificar permisos
			foreach ($nav_module as $link=>&$info) {
				// si info no es un arreglo es solo el nombre y se arma
				if(!is_array($info)) {
					$info = array(
						'name' => $info,
						'desc' => '',
						'imag' => '/img/icons/48x48/icono.png',
						'need' => '',
					);
				}
				// si es un arreglo colocar opciones por defecto
				else {
					$info = array_merge(array(
						'name' => $link,
						'desc' => '',
						'imag' => '/img/icons/48x48/icono.png',
						'need' => '',
					), $info);
				}
				// Verificar que los módulos requeridos para ingresar a esta opción estén cargados
/*				if(!empty($info['need'])) {
					$modulos_requeridos = explode(',', $info['need']);
					foreach($modulos_requeridos as $modulo_requerido) {
						if(!Module::loaded($modulo_requerido)) {
							unset($nav_module[$link]);
						}
					}
				}*/
				// Verificar permisos para acceder al enlace
				if(!$this->Auth->check('/'.$module.$link)) {
					unset($nav_module[$link]);
				}
			}
			// setear variables para la vista
			$module = str_replace ('.', '/', Inflector::underscore(
				$this->request->params['module']
			));
			$title = str_replace ('.', ' &raquo; ',
				$this->request->params['module']
			);
			$this->set(array(
				'title' => $title,
				'nav' => $nav_module,
				'module' => $module,
			));
			// renderizar
			$this->render('Module/index');
		}
	}

}
