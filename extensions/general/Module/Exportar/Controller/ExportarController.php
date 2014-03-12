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

class ExportarController extends AppController {

	public function beforeFilter () {
	}

	public function ods ($id) {
		$this->_exportTable($id);
	}

	public function xls ($id) {
		$this->_exportTable($id);
	}

	public function csv ($id) {
		$this->_exportTable($id);
	}

	public function pdf ($id) {
		$this->_exportTable($id);
	}

	public function xml ($id) {
		$this->_exportTable($id);
	}

	public function json ($id) {
		$this->_exportTable($id);
	}

	private function _exportTable ($id) {
		$data = Session::read('export.'.$id);
		if (!$data) {
			throw new MiErrorException('No hay datos que exportar');
		}
		$this->set(array(
			'id' => $id,
			'data' => $data,
		));
	}

	public function barcode ($string, $type = 'C128') {
		$this->set(array(
			'string' => base64_decode($string),
			'type' => $type,
		));
	}

	public function qrcode ($string) {
		$this->set('string', base64_decode($string));
	}

	public function pdf417 ($string) {
		$this->set('string', base64_decode($string));
	}

}
