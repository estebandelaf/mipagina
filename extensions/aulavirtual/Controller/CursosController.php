<?php

App::uses('AppController', 'Controller');

class  CursosController extends AppController {

	public function index () {
		$this->set(
			'cursos',
			Configure::read('nav.website./cursos.nav')
		);
	}

	public function mostrar ($curso, $subpage = '') {
		// si el curso no existe mostrar error
		$cursos = Configure::read('nav.website./cursos.nav');
		if (!array_key_exists('/'.$curso, $cursos)) {
			Session::message(
				'El curso <em>'.$curso.
				'</em> solicitado no existe'
			);
			$this->redirect('/inicio');
		}
		// setear variables para el curso
		$this->set(
			'curso',
			$cursos['/'.$curso]['name']
		);
		// determinar subpaginas que se solicitan
		$subpages = func_get_args();
		array_shift($subpages);
		// determinar que hacer
		$this->autoRender = false;
		// si solo se está pidiendo la página principal
		if (!isset($subpage[0])) {
			$this->set('directory', '/archivos/cursos/'.$curso);
			$this->render('Cursos/archivos');
			return;
		}
		// si se pidió el calendario
		else if ($subpage=='calendario') {
			$this->planilla($curso, 'calendario');
			return;
		}
		// si se pidieron las notas
		else if ($subpage=='notas') {
			$this->planilla($curso, 'notas');
			return;
		}
		// si se pidió ver la página de código
		else if ($subpage=='codigo') {
			$this->codigo($curso);
			return;
		}
		// supongamos que se quiere mostrar el contenido de un
		// directorio
		$flag = $this->directorio($curso, $subpage);
		// no se encontró posible acción para la página -> página no
		// existe
		if(!$flag) $this->render('Cursos/error404');
	}

	/**
	 * Método para buscar y renderizar una planilla
	 * @version 2013-08-07
	 */
	private function planilla ($curso, $planilla) {
		App::uses('Spreadsheet', 'Utility/Spreadsheet');
		$p = 'Model/Datasource/cursos'.DS.$curso.DS.$planilla;
		foreach (Spreadsheet::$exts as $ext) {
			if (file_exists(DIR_WEBSITE.DS.$p.'.'.$ext)) {
				$this->set(array(
					'titulo' => ucfirst(str_replace(
						'-', ' ', $planilla
					)),
					'archivo' => $p.'.'.$ext,
				));
				$this->render('Cursos/planilla');
				return;
			}
		}
		$this->render('Cursos/error404');
	}

	/**
	 * Método para buscar y renderizar el contenido de un directorio
	 * @version 2013-08-07
	 */
	private function directorio ($curso, $directorio) {
		$d = '/archivos/cursos/'.$curso.'/'.$directorio;
		if (file_exists(DIR_WEBSITE.'/webroot'.$d)) {
			$this->set(array(
				'titulo' => ucfirst(str_replace(
					'-', ' ', $directorio
				)),
				'directorio' => $d,
			));
			$this->render('Cursos/directorio');
			return true;
		}
		return false;
	}

	/**
	 * Método para buscar y renderizar el contenido del directorio "codigo"
	 * @version 2013-08-07
	 */
	private function codigo ($curso) {
		$d = DIR_WEBSITE.'/webroot/archivos/cursos/'.$curso.'/codigo';
		if (file_exists($d)) {
			$this->set('directorio', $d);
			$this->render('Cursos/codigo');
		} else {
			$this->render('Cursos/error404');
		}
	}

}
