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

// clase que extiende el controlador
App::uses('AppController', 'Controller');

/**
 * Controlador para las páginas de cursos
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
 * @version 2014-02-26
 */
class  CursosController extends AppController {

	/**
	 * Acción que muestra el listado de cursos del aula
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2014-02-26
	 */
	public function index () {
		$this->set(
			'cursos',
			Configure::read('nav.website./cursos.nav')
		);
	}

	/**
	 * Acción que muestra un curso y subpágina (o sea la página del curso
	 * que se desea ver propiamente tal).
	 * Esta acción llamará a otros métodos que cargarán las subpáginas:
	 * - calendario (planilla)
	 * - notas (planilla)
	 * - código
	 * - En caso que no sea una de las 3 anteriores se buscará un directorio
	 *   que coincida con el string en subpage y se mostrará su contenido
	 *   con enlaces para descargas los archivos.
	 * @param curso Directorio del curso disponible en archivos/cursos
	 * @param subpage Página del curso que se quiere cargar
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2014-02-26
	 */
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
	 * @param curso Directorio del curso disponible en archivos/cursos
	 * @param planilla Nombre de la planilla en Model/Data/cursos/X/
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2013-08-07
	 */
	private function planilla ($curso, $planilla) {
		App::uses('Spreadsheet', 'Utility/Spreadsheet');
		$p = 'Model/Data/cursos'.DS.$curso.DS.$planilla;
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
	 * @param curso Directorio del curso disponible en archivos/cursos
	 * @param directorio Directorio dentro de archivos/curso/X/
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
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
	 * Método para buscar y renderizar el contenido del directorio
	 * archivos/cursos/X/codigo
	 * @param curso Directorio del curso disponible en archivos/cursos
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
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
