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

// Clase que usa esta clase
App::uses('AppController', 'Controller');

/**
 * Clase para cargar una página y entregarla al usuario
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
 * @version 2013-06-10
 */
class ErrorController extends AppController {

	public $error_reporting; ///< Si se debe o no mostrar los errores exactos de las páginas

	/**
	 * Renderizar error
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2013-06-10
	 */
	public function display ($data) {
		// mostrar error exacto solo si se debe
		if ($this->error_reporting) {
			// setear variables
			$this->set($data);
			// renderizar
			$this->render('Error/error_reporting');
		}
		// mostrar error "genérico"
		else $this->render('Error/silence');
		// enviar al cliente
		$this->response->send();
	}

}
