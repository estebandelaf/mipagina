<?php

define('ID', $id);

// crear objeto para poder generar el pdf
App::uses('PDFHelper', 'View/Helper');
class PDF extends PDFHelper {
	public function Footer() {
		$this->SetY(-15);
		$this->SetFont('I', 7);
		$this->Cell(0, 10, utf8_decode(
			'Listado de '.ID.' / Página: '.$this->PageNo()
		), 0 , 0, 'C');
	}
}
$pdf = new PDF();

// agregar página
$pdf->AddPage();

// agregar logo
$logo = file_get_contents(DIR_WEBSITE.'/webroot/img/logo.png');
$pdf->MemImage($logo, 10, 10);

// generar títulos
$titulo = 'Listado de '.$id;
$subtitulo = utf8_decode(Configure::read('page.body.title'));

// agregar títulos
$pdf->Ln(6);
$pdf->SetFont('B', 16);
$pdf->SetXY(80, 15);
$pdf->MultiCell(130, 5, $titulo, 0, 'C');
$pdf->SetFont('B', 10);
$pdf->SetX(80);
$pdf->MultiCell(130, 5, $subtitulo, 0, 'C');
$pdf->Ln(15);

// agregar tabla con los datos
$pdf->addTable (array_shift($data), $data, array('fontsize' => 8));

// enviar pdf al navegador
$pdf->Output($id, 'I');

// detener script
exit(0);
