<?php

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
