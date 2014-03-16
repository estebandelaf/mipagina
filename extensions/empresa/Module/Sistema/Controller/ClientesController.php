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
App::uses('ClientesBaseController', 'Sistema.Controller');

// Clase para el modelo de este controlador
App::uses('Cliente', 'Sistema.Model');

/**
 * Clase final para el controlador asociado a la tabla cliente de la base de datos
 * Comentario de la tabla: 
 * Esta clase permite controlar las acciones entre el modelo y vista para la tabla cliente
 * @author MiPaGiNa Code Generator
 * @version 2014-02-13 15:24:39
 */
final class ClientesController extends ClientesBaseController {

	protected $module_url = '/sistema/';

	public function datos ($rut) {
		$dv = substr($rut, -1);
		$rut = substr(str_replace (array('.', '-'), '', $rut), 0, -1);
		App::uses('Webservice', 'Network/Webservice');
		$Webservice = new Webservice ();
		if ($dv!=rutDV($rut)) {
			$Webservice->error ('RUT inválido');
		} else {
			$Cliente = new Cliente ($rut);
			if (!$Cliente->exists()) {
				$Webservice->error ('Cliente no existe');
			} else {
				$payload = array();
				foreach (array('rut', 'dv', 'razon_social', 'actividad_economica', 'email', 'telefono', 'direccion', 'comuna') as $col)
					$payload[$col] = $Cliente->$col;
				$Webservice->send ($payload);
			}
		}
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
			if (!empty($Cliente->contrasenia))
				$Cliente->contrasenia = $this->Auth->hash($Cliente->contrasenia);
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
			if(!empty($_POST['contrasenia'])) {
				$Cliente->saveContrasenia(
					$_POST['contrasenia'],
					$this->Auth->settings['model']['user']['hash']
				);
			}
			Session::message('Registro Cliente('.implode(', ', func_get_args()).') editado');
			$this->redirect(
				$this->module_url.'clientes/listar'
			);
		}
	}

}
