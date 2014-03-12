<?php

// crear objeto para poder generar el pdf
App::uses('PDFHelper', 'View/Helper');
$pdf = new PDFHelper ();

// propiedades del documento
$pdf->setInfo (
	Configure::read('page.body.title'),
	'Tabla: '.$id
);

// encabezado y pie de página
$pdf->setStandardHeaderFooter (
	DIR_WEBSITE.'/webroot/img/logo.png',
	Configure::read('page.body.title'),
	'Tabla: '.$id
);

// agregar datos
$pdf->AddPage();
$pdf->addTable (array_shift($data), $data, array(), true);

// generar pdf y terminar
$pdf->Output($id.'.pdf', 'I');
exit(0);
