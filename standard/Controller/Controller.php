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

// Clases utilizadas por esta clase
App::uses('View', 'View');

/**
 * Clase base para los controladores de la aplicación
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
 * @version 2012-11-06
 */
class Controller {

	public $request; ///< Objeto Request
	public $response; ///< Objeto Response
	public $viewVars = array(); ///< Variables que se pasarán al renderizar la vista
	public $autoRender = true; ///< Autorenderizar una vista asociada a una acción
	public $Components = null; ///< Colección de componentes que se cargarán
	public $components = array(); ///< Nombre de componentes que este controlador utiliza

	/**
	 * Constructor de la clase
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-11-06
	 */
	public function __construct (Request $request, Response $response) {
		// copiar objeto para solicitud y respuesta
		$this->request = $request;
		$this->response = $response;
		// crear colección de componentes
		if(count($this->components)) {
			App::uses('ComponentCollection', 'Controller/Component');
			$this->Components = new ComponentCollection();
			// crear las clases e inicializa atributos con componentes
			$this->Components->init($this);
		}
		// agregar variables por defecto que se pasarán a la vista
		$this->set(array(
			'_base' => $this->request->base,
			'_request' => $this->request->request,
			'_url' => $this->request->url,
		));
		// obtener layout por defecto (el configurado en Config/core.php)
		$this->layout = Configure::read('page.layout');
	}
	
	/**
	 * Método que se ejecuta al iniciar la ejecución del controlador.
	 * Wrapper de Controller::beforeFilter()
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-11-06
	 */
	public function startupProcess () {
		$this->beforeFilter();
	}
	
	/**
	 * Método que se ejecuta al terminar la ejecución del controlador
	 * Wrapper de Controller::afterFilter()
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-11-06
	 */
	public function shutdownProcess () {
		$this->afterFilter();
	}
	
	/**
	 * Método que se ejecuta al iniciar la ejecución del controlador.
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-11-06
	 */
	public function beforeFilter () {
		if($this->Components) {
			$this->Components->trigger('beforeFilter');
		}
	}
	
	/**
	 * Método que se ejecuta al terminar la ejecución del controlador
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-11-06
	 */
	public function afterFilter () {
		if($this->Components) {
			$this->Components->trigger('afterFilter');
		}
	}
	
	/**
	 * Método que se ejecuta antes de renderizar la página
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-11-06
	 */
	public function beforeRender () {
		if($this->Components) {
			$this->Components->trigger('beforeRender');
		}
	}
	
	/**
	 * Método que se ejecuta antes de redirigir la página
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-11-06
	 */
	public function beforeRedirect ($params) {
		if($this->Components) {
			$this->Components->trigger('beforeRedirect', $params);
		}
	}

	/**
	 * Método que ejecuta el método público solicitado como acción del
	 * controlador
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-11-06
	 */
	public function invokeAction(Request $request) {
		// Probar si el método existe
		try {
			// Obtener método
			$method = new ReflectionMethod($this, $request->params['action']);
			// Verificar que el método no sea privado
			if ($method->name[0] === '_' || !$method->isPublic()) {
				throw new PrivateActionException(array(
					'controller' => get_class($this),
					'action' => $request->params['action']
				));
			}
			// Invocar el método con los argumentos de $request->params['pass'] 
			return $method->invokeArgs($this, $request->params['pass']);
		// Si el método no se encuentra
		} catch (ReflectionException $e) {
			// Generar excepción
			throw new MissingActionException(array(
				'controller' => get_class($this),
				'action' => $request->params['action']
			));
		}
	}
	
	/**
	 * Método que renderiza la vista del controlador
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-11-06
	 */
	public function render ($view = null) {
		// Ejecutar eventos que se deben realizar antes de renderizar
		$this->beforeRender();
		// Si la vista es nula se carga la vista según el controlador y accion solicitado
		if($view===null) {
			$view = Inflector::camelize($this->request->params['controller']).DS.$this->request->params['action'];
		}
		// Crear vista para este controlador
		$this->View = new View($this);
		// Renderizar vista y layout
		$this->response->body($this->View->render($view));
		// Entregar respuesta
		return $this->response;
	}

	/**
	 * Guarda una variable para usarla en una vista
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-11-06
	 */
	public function set ($one = null, $two = null) {
		// Verificar que se haya pasado la variable
		if($one!==null) {
			// Si se paso como arreglo se usa
			if (is_array($one)) {
				$data = $one;
			}
			// Si no se paso como arreglo se arma			
			else {
				$data = array($one => $two);
			}
			// Agregar a las variables que se usarán en la vista
			$this->viewVars = array_merge($this->viewVars, $data);
		}
	}

	/**
	 * Redireccionar página
	 * @todo Si la url es un arreglo usar Router::normalize()
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-11-06
	 */
	public function redirect ($url = null, $status = 0) {
		// Ejecutar evento
		$this->beforeRedirect(array($url, $status));
		// si la url es null se redirecciona a la actual
		if(!$url) $url = $this->request->request;
		// Si la url es un arreglo se asume se debe normalizar
		if(is_array($url)) $url = Router::normalize($url);
		// Redireccionar
		header('location: '.$this->request->base.$url);
		// Detener script
		exit(0);
	}

}
