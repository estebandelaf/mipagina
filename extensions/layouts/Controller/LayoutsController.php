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

// clase que extiende este controlador
App::uses ('AppController', 'Controller');

/**
 * Controlador para Layouts
 * Permite desplegar el listado de layouts disponibles y seleccionar uno
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
 * @version 2014-03-11
 */
class LayoutsController extends AppController {

	public function beforeFilter () {
	}

	/**
	 * Método quee muestra los layouts disponibles y asigna uno nuevo en
	 * caso que así se haya solicitado.
	 * @param layout Layout que se desea utilizar
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2014-03-11
	 */
	public function index ($layout = null) {
		// en caso que se haya solicitado un Layout cambiarlo
		if ($layout) {
			$this->layout = $layout;
			Session::write ('config.page.layout', $layout);
		}
		// mostrar layouts disponibles
		$omitir = array('.', '..', 'index.php');
		$layouts = array();
		foreach (App::paths() as $path) {
			if (!is_dir($path.DS.'View'.DS.'Layouts'))
				continue;
			$files = scandir ($path.DS.'View'.DS.'Layouts');
			foreach ($files as &$file) {
				if (!in_array($file, $omitir)) {
					$l = substr($file, 0, -4);
					if (!in_array($l, $layouts))
						$layouts[] = $l;
				}
			}
		}
		sort($layouts);
		$this->set ('layouts', $layouts);
	}

}
