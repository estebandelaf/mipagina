<?php

App::uses('AppController', 'Controller');

class ExportarController extends AppController {

	public function beforeFilter () {
		if(isset($this->Auth)) {
			$this->Auth->allow();
		}
	}

	/**
	 * Requerimientos:
	 *  # pear install Image_Barcode2
	 * Si falla por estabilidad usar (o el que se indique):
	 *  # pear install channel://pear.php.net/Image_Barcode2-0.2.1
	 */
	public function barcode () {
		if(!empty($_GET['txt'])) {
			//ini_set('error_reporting', false);
			require('Image/Barcode2.php');
			$barcode = new Image_Barcode2();
			$barcode->draw(urldecode($_GET['txt']), Image_Barcode2::BARCODE_CODE128);
		} else {
			echo '<h1>Error</h1>';
			echo '<p>Debe especificar un texto para ser representado mediante el código de barras.</p>';
		}
		exit(0);
	}

	/**
	 * Requerimientos: # apt-get install php5-gd
	 */
	public function qrcode () {
		if(!empty($_GET['txt'])) {
			App::import('Vendor/phpqrcode');
			QRcode::png(urldecode($_GET['txt']));	
		} else {
			echo '<h1>Error</h1>';
			echo '<p>Debe especificar un texto para ser representado mediante el código QR.</p>';
		}
		exit(0);
	}

}
