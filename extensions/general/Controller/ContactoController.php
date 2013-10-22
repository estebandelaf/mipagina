<?php

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
