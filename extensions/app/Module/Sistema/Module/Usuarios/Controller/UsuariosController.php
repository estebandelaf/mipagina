<?php

/**
 * MiPaGiNa (MP)
 * Copyright (C) 2012 Esteban De La Fuente Rubio (esteban[at]delaf.cl)
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

// Clase abstracta para el controlador (padre de esta)
App::uses('UsuariosBaseController', 'Sistema.Usuarios.Controller');

// Clase para el modelo de este controlador
App::uses('Usuario', 'Sistema.Usuarios.Model');

/**
 * Clase final para el controlador asociado a la tabla usuario de la base de datos
 * Comentario de la tabla: Tabla para usuarios del sistema
 * Esta clase permite controlar las acciones entre el modelo y vista para la tabla usuario
 * @author MiPaGiNa Code Generator
 * @version 2013-06-25 01:39:49
 */
final class UsuariosController extends UsuariosBaseController {

	protected $module_url = '/sistema/usuarios/';

	public function beforeFilter () {
		$this->Auth->allow('ingresar', 'salir', 'contrasenia_recuperar');
		$this->Auth->allowWithLogin('perfil');
		parent::beforeFilter();
	}

	public function ingresar () {
		$this->Auth->login($this);
	}

	public function salir () {
		$this->Auth->logout($this);
	}

	public function contrasenia_recuperar ($usuario = null) {
		$this->autoRender = false;
		// pedir correo
		if ($usuario == null) {
			if (!isset($_POST['submit'])) {
				$this->render ('Usuarios/contrasenia_recuperar_step1');
			} else {
				$Usuario = new Usuario ($_POST['id']);
				if (!$Usuario->exists()) {
					Session::message ('Usuario o email inválido');
					$this->render ('Usuarios/contrasenia_recuperar_step1');
				} else {
					$this->contrasenia_recuperar_email (
						$Usuario->email,
						$Usuario->nombre,
						$Usuario->usuario,
						$this->Auth->hash($Usuario->contrasenia)
					);
					Session::message ('Se ha enviado un email con las instrucciones para recuperar su contraseña');
					$this->redirect('/usuarios/ingresar');
				}
			}
		}
		// cambiar contraseña
		else {
			$Usuario = new Usuario ($usuario);
			if (!$Usuario->exists()) {
				Session::message ('Usuario inválido');
				$this->redirect ('/usuarios/contrasenia/recuperar');
			}
			if (!isset($_POST['submit'])) {
				$this->set('usuario', $usuario);
				$this->render ('Usuarios/contrasenia_recuperar_step2');
			} else {
				if ($this->Auth->hash($Usuario->contrasenia)!=$_POST['codigo']) {
					Session::message ('Código ingresado no es válido para el usuario');
					$this->set('usuario', $usuario);
					$this->render ('Usuarios/contrasenia_recuperar_step2');
				}
				else if (empty ($_POST['contrasenia1']) || empty ($_POST['contrasenia2']) || $_POST['contrasenia1']!=$_POST['contrasenia2']) {
					Session::message ('Contraseña nueva inválida (en blanco o no coinciden)');
					$this->set('usuario', $usuario);
					$this->render ('Usuarios/contrasenia_recuperar_step2');
				}
				else {
					$Usuario->saveContrasenia(
						$_POST['contrasenia1'],
						$this->Auth->settings['model']['user']['hash']
					);
					Session::message ('La contraseña para el usuario '.$usuario.' ha sido cambiada con éxito');
					$this->redirect('/usuarios/ingresar');
				}
			}
		}
	}

	private function contrasenia_recuperar_email ($correo, $nombre, $usuario, $hash) {
		$this->layout = null;
		$this->set (array(
			'nombre'=>$nombre,
			'usuario'=>$usuario,
			'hash'=>$hash,
			'ip'=>AuthComponent::ip(),
		));
		$msg = $this->render('Usuarios/contrasenia_recuperar_email')->body();
		App::uses('Email', 'Network/Email');
		$email = new Email();
		$email->to($correo);
		$email->subject('Recuperación de contraseña');
		$email->send($msg);
	}

	public function crear () {
		// si se envió el formulario se procesa
		if(isset($_POST['submit'])) {
			$Usuario = new Usuario();
			$Usuario->set($_POST);
			if ($Usuario->checkIfUsuarioAlreadyExists ()) {
				Session::message('Nombre de usuario '.$_POST['usuario'].' ya está en uso');
				$this->redirect('/sistema/usuarios/usuarios/crear');
			}
			if ($Usuario->checkIfHashAlreadyExists ()) {
				Session::message('Hash seleccionado ya está en uso');
				$this->redirect('/sistema/usuarios/usuarios/crear');
			}
			if ($Usuario->checkIfEmailAlreadyExists ()) {
				Session::message('Email seleccionado ya está en uso');
				$this->redirect('/sistema/usuarios/usuarios/crear');
			}
			if (empty($Usuario->contrasenia)) {
				$Usuario->contrasenia = string_random (8);
			}
			if (empty($Usuario->hash)) {
				do {
					$Usuario->hash = string_random (32);
				} while ($Usuario->checkIfHashAlreadyExists ());
			}
			$layout = $this->layout;
			$this->layout = null;
			$this->set(array(
				'nombre'=>$Usuario->nombre,
				'usuario'=>$Usuario->usuario,
				'contrasenia'=>$Usuario->contrasenia,
			));
			$msg = $this->render('Usuarios/crear_email')->body();
			$this->layout = $layout;
			$Usuario->contrasenia = $this->Auth->hash($Usuario->contrasenia);
			$Usuario->save();
//			if(method_exists($this, 'u')) $this->u();
			App::uses('Email', 'Network/Email');
			$email = new Email();
			$email->to($Usuario->email);
			$email->subject('Cuenta de usuario creada');
			$email->send($msg);
			Session::message('Registro Usuario creado (se envió email a '.$Usuario->email.' con los datos de acceso');
			$this->redirect($this->module_url.'usuarios/listar');
		}
		// setear variables
		Usuario::$columnsInfo['contrasenia']['null'] = true;
		Usuario::$columnsInfo['hash']['null'] = true;
		$this->set(array(
			'columnsInfo' => Usuario::$columnsInfo,
		));
	}

	public function editar ($id) {
		$Usuario = new Usuario($id);
		// si el registro que se quiere editar no existe error
		if(!$Usuario->exists()) {
			Session::message('Registro Usuario('.implode(
				', ', func_get_args()
				).') no existe, no se puede editar'
			);
			$this->redirect($this->module_url.'usuarios/listar');
		}
		// si no se ha enviado el formulario se mostrará
		if(!isset($_POST['submit'])) {
			Usuario::$columnsInfo['contrasenia']['null'] = true;
			$this->set(array(
				'Usuario' => $Usuario,
				'columnsInfo' => Usuario::$columnsInfo,
			));
		}
		// si se envió el formulario se procesa
		else {
			$Usuario->set($_POST);
			if ($Usuario->checkIfUsuarioAlreadyExists ()) {
				Session::message('Nombre de usuario '.$_POST['usuario'].' ya está en uso');
				$this->redirect('/sistema/usuarios/usuarios/editar/'.$id);
			}
			if ($Usuario->checkIfHashAlreadyExists ()) {
				Session::message('Hash seleccionado ya está en uso');
				$this->redirect('/sistema/usuarios/usuarios/editar/'.$id);
			}
			if ($Usuario->checkIfEmailAlreadyExists ()) {
				Session::message('Email seleccionado ya está en uso');
				$this->redirect('/sistema/usuarios/usuarios/editar/'.$id);
			}
			$Usuario->save();
//			if(method_exists($this, 'u')) $this->u();
			if(!empty($_POST['contrasenia'])) {
				$Usuario->saveContrasenia(
					$_POST['contrasenia'],
					$this->Auth->settings['model']['user']['hash']
				);
			}
			Session::message('Registro Usuario('.implode(
				', ', func_get_args()).') editado'
			);
			$this->redirect($this->module_url.'usuarios/listar');
		}
	}

	public function perfil () {
		// obtener usuario
		$Usuario = new Usuario(Session::read('auth.id'));
		// procesar datos personales
		if (isset($_POST['datosUsuario'])) {
			// actualizar datos generales
			$Usuario->set($_POST);
			if ($Usuario->checkIfUsuarioAlreadyExists ()) {
				Session::message('Nombre de usuario '.$_POST['usuario'].' ya está en uso');
				$this->redirect('/usuarios/perfil');
			}
			if ($Usuario->checkIfHashAlreadyExists ()) {
				Session::message('Hash seleccionado ya está en uso');
				$this->redirect('/usuarios/perfil');
			}
			if ($Usuario->checkIfEmailAlreadyExists ()) {
				Session::message('Email seleccionado ya está en uso');
				$this->redirect('/usuarios/perfil');
			}
			if (empty($Usuario->hash)) {
				do {
					$Usuario->hash = string_random (32);
				} while ($Usuario->checkIfHashAlreadyExists ());
			}
			$Usuario->save();
			// mensaje de ok y redireccionar
			Session::message('Perfil actualizado');
			$this->redirect('/usuarios/perfil');
		}
		// procesar cambio de contraseña
		else if (isset($_POST['cambiarContrasenia'])) {
			if(!empty($_POST['contrasenia1']) && $_POST['contrasenia1']==$_POST['contrasenia2']) {
				$Usuario->saveContrasenia(
					$_POST['contrasenia1'],
					$this->Auth->settings['model']['user']['hash']
				);
			} else {
				Session::message('Contraseñas no coinciden');
				$this->redirect('/usuarios/perfil');
			}
			// mensaje de ok y redireccionar
			Session::message('Contraseña actualizada');
			$this->redirect('/usuarios/perfil');
		}
		// mostrar formulario para edición
		else {
			$this->set(array(
				'Usuario' => $Usuario,
			));
		}
	}

}
