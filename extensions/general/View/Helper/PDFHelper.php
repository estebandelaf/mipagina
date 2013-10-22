<?php

/**
 * MiPaGiNa (MP)
 * Copyright (C) 2013 Esteban De La Fuente Rubio (esteban[at]delaf.cl)
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

// Importar clase FPDF
App::import('Vendor/fpdf/fpdf');

/**
 * Stream handler to read from global variables
 * @author http://www.fpdf.org/en/script/script45.php
 */
class VariableStream {
	public $varname;
	public $position;
	function stream_open($path, $mode, $options, &$opened_path) {
		$url = parse_url($path);
		$this->varname = $url['host'];
		if(!isset($GLOBALS[$this->varname])) {
			trigger_error('Global variable '.$this->varname.
				' does not exist', E_USER_WARNING);
			return false;
		}
		$this->position = 0;
		return true;
	}
	function stream_read($count) {
		$ret = substr($GLOBALS[$this->varname], $this->position,$count);
		$this->position += strlen($ret);
		return $ret;
	}
	function stream_eof() {
		return $this->position >= strlen($GLOBALS[$this->varname]);
	}
	function stream_tell() {
		return $this->position;
	}
	function stream_seek($offset, $whence) {
		if($whence==SEEK_SET) {
			$this->position = $offset;
			return true;
		}
		return false;
	}
	function stream_stat() {
		return array();
	}
}

/**
 * 
 * @author http://www.fpdf.org/en/script/script45.php
 */
class PDF_MemImage extends FPDF {
	function PDF_MemImage($orientation='P', $unit='mm', $format='A4') {
		$this->FPDF($orientation, $unit, $format);
		//Register var stream protocol
		stream_wrapper_register('var', 'VariableStream');
	}
	function MemImage($data, $x=null, $y=null, $w=0, $h=0, $link='') {
		//Display the image contained in $data
		$v = 'img'.md5($data);
		$GLOBALS[$v] = $data;
		$a = getimagesize('var://'.$v);
		if(!$a)
			$this->Error('Invalid image data');
		$type = substr(strstr($a['mime'],'/'),1);
		$this->Image('var://'.$v, $x, $y, $w, $h, $type, $link);
		unset($GLOBALS[$v]);
	}
	function GDImage($im, $x=null, $y=null, $w=0, $h=0, $link='') {
		//Display the GD image associated to $im
		ob_start();
		imagepng($im);
		$data = ob_get_clean();
		$this->MemImage($data, $x, $y, $w, $h, $link);
	}
}

/**
 * Clase para generar PDFs
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
 * @version 2013-06-22
 */
class PDFHelper extends PDF_MemImage {

	private $defaultOptions = array(
		'font' => array('family' => 'Arial', 'size' => 10),
		'table' => array(
			'fontsize' => 10,
			'width' => 39,
			'height' => 6,
			'align' => 'C',
		),
	);

	/**
	 *
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2013-06-22
	 */
	public function __construct ($o = 'P', $u = 'mm', $s = 'Letter') {
		parent::__construct($o, $u, $s);
	}

	/**
	 *
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2013-06-22
	 */
	public function SetFont($family = null, $style = null, $size = null) {
		$args = func_num_args();
		switch ($args) {
			case 0: {
				$style = '';
				$size = $this->defaultOptions['font']['size'];
				break;
			}
			case 1: {
				$style = $family;
				$size = $this->defaultOptions['font']['size'];
				break;
			}
			case 2: {
				$size = $style;
				$style = $family;
				break;
			}
		}
		if($args!=3) $family = $this->defaultOptions['font']['family'];
		parent::SetFont ($family, $style, $size);
	}
	
	/**
	 *
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2013-06-22
	 */
	public function addTable ($headers, $data, $options = array()) {
		// asignar opciones por defecto
		$options = array_merge($this->defaultOptions['table'],$options);
		$this->SetDrawColor(100, 100, 100);
		// cabeceras
		$this->SetFont('B', $options['fontsize']);
		$this->SetLineWidth(.1);
		$i = 0;
		foreach($headers as $col) {
			$this->tableAddCol ($i++, $col, $options, true);
		}
		$this->Ln();
		// datos
		$this->SetFont('', $options['fontsize']);
		foreach($data as $row) {
			$i = 0;
			foreach($row as $col) {
				$this->tableAddCol ($i++,
					utf8_decode($col), $options);
			}
			$this->Ln();
		}
	}

	/**
	 *
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2013-06-22
	 */
	private function tableAddCol ($i, $col, $options, $header = false) {
		// ancho
		if (is_array ($options['width']))
			$w = $options['width'][$i];
		else
			$w = $options['width'];
		// alineación
		if (is_array($options['align']))
			$a = $options['align'][$i];
		else
			$a = $options['align'];
		// agregar columna
		$this->SetTextColor(0);
		if($header) {
			$this->SetTextColor(255);
			$this->Cell ($w, $options['height'], $col, 'TB', 0, 'C',
				true);
		} else {
			$this->Cell ($w, $options['height'], $col, 'TB', 0, $a);
		}
	}

}
