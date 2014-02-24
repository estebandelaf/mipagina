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

class ContactoController extends AppController {

	public function beforeFilter () {
		if(isset($this->Auth)) {
			$this->Auth->allow('index');
		}
	}

	public function index () {
		// si no hay datos para el envió del correo electrónico no permirir cargar página de contacto
		if(Configure::read('email.default')===NULL) {
			Session::message('Página de contacto deshabilitada');
			$this->redirect('/');
		}
		// si se envió el formulario se procesa
		if(isset($_POST['submit'])) {			
			App::uses('Email', 'Network/Email');
			$email = new Email();
			$email->replyTo($_POST['correo'], $_POST['nombre']);
			$email->to(Configure::read('email.default.to'));
			$email->subject('Contacto desde la web #'.date('YmdHis'));
			$email->send($_POST['mensaje']);
			Session::message('Su mensaje ha sido enviado, se responderá a la brevedad.');
			$this->redirect('/contacto');
		}
	}

}
