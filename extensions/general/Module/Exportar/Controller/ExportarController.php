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
		$this->set(array(
			'id' => $id,
			'data' => Session::read('export.'.$id),
		));
	}

	public function barcode ($string, $type = 'code128') {
		$this->set(array(
			'string' => base64_decode($string),
			'type' => $type,
		));
	}

	public function qrcode ($string) {
		$this->set('string', base64_decode($string));
	}

}
