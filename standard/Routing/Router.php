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

/**
 * Clase para manejar rutas de la aplicación
 * Las rutas conectan URLs con controladores y acciones
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
 * @version 2012-11-15
 */
class Router {
	
	public static $request; ///< Solicitud realizada a la aplicación
	public static $routes = array(); ///< Rutas conectadas, "does the magic"
	public static $autoStaticPages = false; ///< Permite cargar páginas estáticas desde /, sin usar /pages/

	/**
	 * Procesa la url indicando que es lo que se espera obtener según las rutas que existen conectadas
	 * @todo Verificar que funcione para modulos
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-11-09
	 */
	public static function parse ($url) {
		// La url requiere partir con "/", si no lo tiene se coloca
		if(empty($url) || $url[0]!='/') $url = '/'.$url;
		// Arreglo por defecto para los datos de plugin, controlador, accion y parámetros pasados
		$params = array('module'=>null, 'controller'=>null, 'action'=>'index', 'pass'=>null);
		// Si existe una ruta para la url que se esta revisando se carga su configuración
		if(isset(self::$routes[$url])) {
			$route = self::$routes[$url];
			$params['module'] = !empty($route['module']) ? $route['module'] : $params['module'];
			$params['controller'] = !empty($route['controller']) ? $route['controller'] : $params['controller'];
			$params['action'] = !empty($route['action']) ? $route['action'] : $params['action'];
			unset($route['module'], $route['controller'], $route['action']);
			$params['pass'] = $route;
			return $params;
		}
		// Se revisa si es una página estática
		if(self::$autoStaticPages) {
			$location = self::pageLocation($url);
			if($location) {
				$params['controller'] = 'pages';
				$params['action'] = 'display';
				$ext = substr($location, strrpos($location, '.')+1);
				$params['pass'] = array($url, $ext, $location);
				return $params;
			}
		}
		// Buscar alguna que sea parcial (:controller, :action o *)
		foreach(self::$routes as $key=>$aux) {
			$params = array_merge(array('module'=>null, 'controller'=>null, 'action'=>'index', 'pass'=>null), $aux);
			// Tiene :controller
			$controller = strpos($key, ':controller');
			if($controller) {
				$inicioKey = rtrim(substr($key, 0, $controller), '/');
				// Si la URL parte con lo que está antes de :controler
				if(strpos($url, $inicioKey)===0) {
					$ruta = ltrim(str_replace($inicioKey, '', $url), '/');
					$partes = explode('/', $ruta);
					$params['controller'] = array_shift($partes);
					if(empty($params['action']))
						$params['action'] = count($partes) ? array_shift($partes) : 'index';
					$params['pass'] = $partes;
					return $params;
				} else continue;
			}
			// No tiene :controller, pero si :action
			$action = strpos($key, ':action');
			if($action) {
				$inicioKey = rtrim(substr($key, 0, $action), '/');
				// Si la URL parte con lo que está antes de :action
				if(strpos($url, $inicioKey)===0) {
					$ruta = ltrim(str_replace($inicioKey, '', $url), '/');
					if(strlen($ruta)) {
						$partes = explode('/', $ruta);
						if(empty($params['action']))
							$params['action'] = count($partes) ? array_shift($partes) : 'index';
						$params['pass'] = $partes;
					} else {
						$params['action'] = 'index';
						$params['pass'] = array();
					}
					return $params;
				} else continue;	
			}
			// Si no esta el tag :controler ni el de :action se busca si termina en *
			if($key[strlen($key)-1]=='*') {
				$ruta = substr($key, 0, -1);
				// Si se encuentra la ruta al inicio de la url
				if(strpos($url, $ruta)===0) {
					$params['pass'] = explode('/', str_replace($ruta, '', $url));
					return $params;
				}
			}
		}
		// Arreglo por defecto para los datos de plugin, controlador, accion y parámetros pasados
		$params = array('module'=>null, 'controller'=>null, 'action'=>'index', 'pass'=>null);
		// Procesar la URL recibida, en el formato /modulo(s)/controlador/accion/parámetro1/parámetro2/etc
		// Buscar componente de la url que corresponde al modulo (de existir)
		$params['module'] = Module::find($url);
		// Quitar el modulo de la url
		$count = 1;
		$url = str_replace(str_replace('.', '/', Inflector::underscore($params['module'])), '', $url, $count);
		$url = str_replace('//', '/', $url); // Parche, TODO: algo mejor?
		// Separar la url solicitada en partes separadas por los "/"
		$partes = explode('/', $url);
		// quitar primer elemento que es vacio, ya que el string parte con "/"
		array_shift($partes);
		// determinar si el primer elemento es módulo o controlador
		$params['controller'] = array_shift($partes);
		// Segundo parámetro es la acción
		$params['action'] = count($partes) ? array_shift($partes) : 'index';
		// Lo que queda son los argumentos pasados a al acción 
		$params['pass'] = $partes;
		// Si no hay controlador y es un módulo se asigna un controlador estándar para cargar la página con el menu del modulo
		if(empty($params['controller']) && !empty($params['module'])) {
			$params['controller'] = 'module';
			$params['action'] = 'display';
		}
		// Retornar url procesada
		return $params;
	}

	/**
	 * Buscar el archivo correspondiente a una página
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-11-09
	 */
	public static function pageLocation ($page) {
		App::uses('View', 'View');
		return View::location('Pages'.$page);
	}
	
	/**
	 * Obtiene a partir de una url en formato controlador, acción (parámetros),
	 * la url "real" (la que se usa en el navegador), usado generalmente para
	 * los redireccionamientos.
	 * @todo Verificar que haga lo que debería
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-11-09
	 */
	public static function normalize ($url = '/') {
		// Si es arreglo se procesa
		if(is_array($url)) {
			// Opciones por defecto
			$url = array_merge(self::$request->params, $url);
			// Si es una página estática
			if($url['controller']=='pages') {
				$url = $url[0];
			}
			// Si no es una página estática, se debe armar la url
			else {
				$plugin = $url['module']!='' ? $url['module'].'/' : '';
				$controller = $url['controller']!='' ? $url['controller'] : '';
				$action = $url['action']!= '' ? ($url['action']!='index' ? '/'.$url['action'] : '') : '';
				$pass = isset($url['pass'][0]) ? '/'.implode('/', $url['pass']) : '';
				$url = $plugin.$controller.$action.$pass;
			}
		}
		// Si no es arreglo se retorna tal cual
		return self::$request->base.$url;
	}	

	/**
	 * @deprecated
	 * @todo Verificar que pueda ser quitado de la clase (que no este siendo usado)
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-11-09
	 */	
	public static function url ($url) {
		return $url;
	}

	/**
	 * Método para conectar nuevas rutas
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-11-15
	 */
	public static function connect ($from, $to = array()) {
		self::$routes[$from] = $to;
		krsort(self::$routes);
	}

	/**
	 * Setear request info de manera estática
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2012-11-09
	 */
	public static function setRequestInfo(Request $request) {
		self::$request = $request;
	}

}
