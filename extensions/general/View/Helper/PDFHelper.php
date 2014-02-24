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

// Importar clase TCPDF
App::import('Vendor/tcpdf/tcpdf');

/**
 * Clase para generar PDFs
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
 * @version 2014-02-23
 */
class PDFHelper extends TCPDF {

	private $defaultOptions = array(
		'font' => array ('family' => 'helvetica', 'size' => 10),
		'header' => array (
			'textcolor' => array (0,0,0),
			'linecolor' => array (136, 137, 140),
			'logoheight' => 20,
		),
		'footer' => array (
			'textcolor' => array (35, 31, 32),
			'linecolor' => array (136, 137, 140),
		),
		'table' => array (
			'fontsize' => 10,
			'width' => 186,
			'height' => 6,
			'align' => 'C',
			'headerbackground' => array (0,0,0),
			'headercolor' => array(255, 255,255),
			'bodybackground' => array(224, 235, 255),
			'bodycolor' => array(0,0,0),
			'colorchange' => true,
		),
	);

	/**
	 * Constructor de la clase
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2014-02-23
	 */
	public function __construct ($o = 'P', $u = 'mm', $s = 'Letter') {
		parent::__construct($o, $u, $s);
		$this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$this->SetHeaderMargin(PDF_MARGIN_HEADER);
		$this->SetFooterMargin(PDF_MARGIN_FOOTER);
	}

	/**
	 * Asignar información del PDF
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2014-02-12
	 */
	public function setInfo ($autor, $titulo) {
		$this->SetCreator('MiPaGiNa');
		$this->SetAuthor($autor);
		$this->SetTitle($titulo);
	}

	/**
	 * Asignar encabezado y pie de página
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2014-02-12
	 */
	public function setStandardHeaderFooter ($logo, $title, $subtitle = '') {
		$size = getimagesize($logo);
		$width = round(($size[0]*$this->defaultOptions['header']['logoheight'])/$size[1]);
		$this->SetHeaderData($logo, $width, $title, $subtitle,
			$this->defaultOptions['header']['textcolor'],
			$this->defaultOptions['header']['linecolor']
		);
		$this->setFooterData(
			$this->defaultOptions['footer']['textcolor'],
			$this->defaultOptions['footer']['linecolor']
		);
		$this->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$this->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	}

	/**
	 * Obtener el ancho de las columnas de una tabla
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2014-02-12
	 */
	private function getTableCellWidth ($total, $cells) {
		$width = floor($total/$cells);
		$widths = array ();
		for ($i=0; $i<$cells; ++$i) {
			$widths[] = $width;
		}
		return $widths;
	}
	
	/**
	 * Agregar una tabla al PDF
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2014-02-12
	 */
	public function addTable ($headers, $data, $options = array(), $html = false) {
		// asignar opciones por defecto
		$options = array_merge($this->defaultOptions['table'],$options);
		// generar tabla
		if ($html)
			$this->addHTMLTable ($headers, $data, $options);
		else
			$this->addNormalTable ($headers, $data, $options);
	}

	/**
	 * Agregar una tabla generada a través de código HTML al PDF
	 * @todo Utilizar las opciones para definir estilo de la tabla HTML
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2014-02-16
	 */
	private function addHTMLTable ($headers, $data, $options = array()) {
		$buffer = '<table>';
		// Definir títulos de columnas
		$buffer .= '<tr>';
		foreach($headers as &$col) {
			$buffer .= '<th style="background-color:#000;color:#fff;text-align:center;font-size:10px"><strong>'.strip_tags($col).'</strong></th>';
		}
		$buffer .= '</tr>';
		// Definir datos de la tabla
		foreach($data as &$row) {
			$buffer .= '<tr>';
			foreach($row as &$col) {
				$buffer .= '<td style="border-bottom:1px solid #ddd;text-align:center;font-size:10px">'.$col.'</td>';
			}
			$buffer .= '</tr>';
		}
		// Finalizar tabla
		$buffer .= '</table>';
		// generar tabla en HTML
		$this->writeHTML ($buffer, true, false, false, false, '');
	}

	/**
	 * Agregar una tabla generada mediante el método Cell
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2014-02-12
	 */
	private function addNormalTable ($headers, $data, $options = array()) {
		// Colors, line width and bold font
		$this->SetFillColor(
			$options['headerbackground'][0],
			$options['headerbackground'][1],
			$options['headerbackground'][2]
		);
		$this->SetTextColor(
			$options['headercolor'][0],
			$options['headercolor'][1],
			$options['headercolor'][2]
		);
		$this->SetFont($this->defaultOptions['font']['family'], 'B',  $options['fontsize']);
		// Header
		$num_headers = count($headers);
		$w = is_array($options['width']) ? $options['width'] :
			$this->getTableCellWidth ($options['width'], $num_headers);
		for($i = 0; $i < $num_headers; ++$i) {
			$this->Cell ($w[$i], $options['height'], $headers[$i], 1, 0, $options['align'], 1);
		}
		$this->Ln();
		// Color and font restoration
		$this->SetFillColor (
			$options['bodybackground'][0],
			$options['bodybackground'][1],
			$options['bodybackground'][2]
		);
		$this->SetTextColor(
			$options['bodycolor'][0],
			$options['bodycolor'][1],
			$options['bodycolor'][2]
		);
		$this->SetFont($this->defaultOptions['font']['family']);
		// Data
		$fill = false;
		foreach($data as &$row) {
			for($i = 0; $i < $num_headers; ++$i) {
				$this->Cell ($w[$i], $options['height'], $row[$i], 'C', 0, $options['align'], $fill);
			}
			$this->Ln();
			if ($options['colorchange'])
				$fill = !$fill;
		}
		$this->Cell(array_sum($w), 0, '', 'T');
	}

	/**
	 * Agregar texto al PDF, es una variación del método Text que permite
	 * definir un ancho al texto. Además recibe menos parámetros para ser
	 * más simple (parámetros comunes solamente).
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2014-02-12
	 */
	public function Texto ($x, $y, $txt, $align='', $w=0, $link='', $border=0, $fill=false) {
		$textrendermode = $this->textrendermode;
		$textstrokewidth = $this->textstrokewidth;
		$this->setTextRenderingMode(0, true, false);
		$this->SetXY($x, $y);
		$this->Cell($w, 0, $txt, $border, 0, $align, $fill, $link);
		// restore previous rendering mode
		$this->textrendermode = $textrendermode;
		$this->textstrokewidth = $textstrokewidth;
	}

	/**
	 * Método idéntico a Texto, pero en vez de utilizar Cell utiliza
	 * MultiCell. La principal diferencia es que este método no permite
	 * agregar un enlace y Texto si.
	 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]delaf.cl)
	 * @version 2014-02-12
	 */
	public function MultiTexto ($x, $y, $txt, $align='', $w=0, $border=0, $fill=false) {
		$textrendermode = $this->textrendermode;
		$textstrokewidth = $this->textstrokewidth;
		$this->setTextRenderingMode(0, true, false);
		$this->SetXY($x, $y);
		$this->MultiCell($w, 0, $txt, $border, $align, $fill);
		// restore previous rendering mode
		$this->textrendermode = $textrendermode;
		$this->textstrokewidth = $textstrokewidth;
	}

}
