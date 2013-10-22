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

// Base que extiende este componente
App::uses('Component', 'Controller/Component');

/**
 * Componente para proveer de un sistema de autenticación y autorización
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
 * @version 2013-06-30
 */
class AuthComponent extends Component {

	public $settings = array( ///< Opciones por defecto
		'session' => array(
			'key' => 'auth',
		),
		'redirect' => array(
			'login' => '/',
			'logout' => '/',
			'error' => '/',
		),
		'messages' => array(
			'ok' => array(
				'login' => 'Usuario <em>%s</em> ha iniciado su sesión',
				'logout' => 'Usuario <em>%s</em> ha cerrado su sesión',
				'logged' => 'Usuario <em>%s</em> tiene su sesión abierta'
			),
			'error' => array(
				'auth' => 'No dispone de permisos para acceder a <em>%s</em>',
				'empty' => 'Debe especificar usuario y clave',
				'invalid' => 'Usuario o clave inválida',
			),
		),
		'model' => array(
			'location' => 'Model',
			'user' => array(
				'table' => 'usuario',
				'columns' => array(
					'id' => 'id',
					'user' => 'usuario',
					'pass' => 'contrasenia',
				),
				'hash' => 'sha256',
			),
		)
	);
	public static $session = null; ///< Información de la sesión del usuario
	public $allowedActions = array(); ///< Acciones sin login
	public $allowedActionsWithLogin = array(); ///< Acciones con login

	/**
	 * Método que inicializa el componente y carga la sesión activa
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2013-06-12
	 */
	public function __construct(ComponentCollection $Components, $settings =
		array()) {
		// ejecutar el constructor padre
		parent::__construct($Components, $settings);
		// solicitar clase Auth
		App::uses('Auth', $this->settings['model']['location']);
		// Recuperar sesión
		self::$session = Session::read(
			$this->settings['session']['key']
		);
	}
	
	/**
	 * Método que verifica si el usuario tiene permisos o bien da error
	 * Wrapper para el método que hace la validación
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-11-13
	 */
	public function beforeFilter($controller) {
		// Si no está autorizado se genera error y redirige
		if (!$this->isAuthorized()) {
			Session::message(sprintf($this->settings['messages']['error']['auth'], $this->request->request));
			$controller->redirect($this->settings['redirect']['error']);
		}
	}

	/**
	 * Agregar acciones que se permitirán ejecutar sin estár autenticado
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2013-06-30
	 */
	public function allow ($action = null) {
		$this->allowedActions = array_merge(
			$this->allowedActions,
			func_get_args()
		);
	}

	/**
	 * Agregar acciones que se permitirán ejecutar a cualquier usuario que
	 * esté autenticado
	 */
	public function allowWithLogin ($action = null)  {
		$this->allowedActionsWithLogin = array_merge(
			$this->allowedActionsWithLogin,
			func_get_args()
		);
	}

	/**
	 * Método para determinar si un usuario está o no autorizado a un área
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2013-06-30
	 */
	public function isAuthorized () {
		// Si la acción se encuentra dentro de las permitidas dejar pasar
		if(in_array($this->request->params['action'], $this->allowedActions))
			return true;
		// si el usuario no existe en la sesión se retorna falso
		if(!self::logged()) return false;
		// si la acción se encuentra dentro de las que solo requieren un
		// usuario logueado se acepta
		if(in_array(
			$this->request->params['action'],
			$this->allowedActionsWithLogin)
		) {
			return true;
		}
		// Chequear permisos
		return self::check($this->request);
	}

	/**
	 * Indica si existe una sesión de un usuario creada
	 * @todo Buscar método mejor para verificar que se está logueado
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-11-13
	 */
	public static function logged () {
		// si es un arreglo self::$session
		if(is_array(self::$session) && isset(self::$session['id']) && isset(self::$session['usuario'])) {
			return true;
		}
		// si se llegó acá entonces no se está logueado
		return false;
	}
	
	/**
	 * Método que revisa si hay o no permisos para determinado recurso
	 * @todo Se debería usar el id de settings para poder obtener el campo verdadero en el usuario
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-11-14
	 */
	public static function check ($recurso = null, $usuario = null) {
		// si no se indico el usuario se recupera de la sesión
		if(!$usuario) $usuario = self::$session['id'];
		// si la clase Auth no existe no hay permiso porque no se puede verificar
		if(!class_exists('Auth')) return false;
		// por que se consultará
		if(!$recurso) $recurso = str_replace(Request::getBase(), '', $_SERVER['REQUEST_URI']);
		// verificar permiso
		$Auth = new Auth();
		return $Auth->check($usuario, $recurso);
	}

	/**
	 * Método que realiza el login del usuario
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2013-06-24
	 */
	public function login ($controller) {
		// si ya está logueado se redirecciona
		if($this->logged()) {
			// mensaje para mostrar
			Session::message(sprintf(
				$this->settings['messages']['ok']['logged'],
				self::$session['usuario']
			));
			// redireccionar
			$controller->redirect(
				$this->settings['redirect']['login']
			);
		}
		// si se envió el formulario se procesa
		if(isset($_POST['submit'])) {
			// campos usuario y contraseña
			$userModel = Inflector::camelize($this->settings['model']['user']['table']);
			$usersModel = Inflector::camelize(Inflector::pluralize($this->settings['model']['user']['table']));
			$userField = $this->settings['model']['user']['columns']['user'];
			$passField = $this->settings['model']['user']['columns']['pass'];
			// si el usuario o contraseña es vacio mensaje de error
			if(empty($_POST[$userField]) || empty($_POST[$passField])) {
				Session::message($this->settings['messages']['error']['empty']);
				return;
			}
			// verificar si existe la tupla (usuario, hash(clave)) en la base de datos
			App::uses(
				$userModel,
				$this->settings['model']['location']
			);
			$$usersModel = new $usersModel();
			$$usersModel->setSelectStatement($this->settings['model']['user']['columns']['id']);
			$$usersModel->setWhereStatement(
				$userField.' = \''.$$usersModel->sanitize($_POST[$userField]).'\'
				AND '.$passField.' = \''.$this->hash($_POST[$passField]).'\''
			);
			$userId = $$usersModel->getValue();
			// si no existe error
			if(!(boolean)$userId) {
				Session::message($this->settings['messages']['error']['invalid']);
				return;
			}
			// si existe, crear sesión
			else {
				// crear info de la sesión
				self::$session =  array(
					'id' => $userId,
					'usuario' => $_POST[$userField]
				);
				Session::write($this->settings['session']['key'], self::$session);
				// mensaje para mostrar
				Session::message(sprintf($this->settings['messages']['ok']['login'], $_POST[$userField]));
				// redireccionar
				$controller->redirect($this->settings['redirect']['login']);
			}
		}
	}

	/**
	 * Método que termina la sesión del usuario
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-11-13
	 */
	public function logout ($controller) {
		Session::destroy();
		Session::message(sprintf($this->settings['messages']['ok']['logout'], self::$session[$this->settings['model']['user']['columns']['user']]));
		self::$session = null;
		$controller->redirect($this->settings['redirect']['logout']);
	}
	
	public function hash ($string) {
		return hash($this->settings['model']['user']['hash'], $string);
	}

}
