<?php
App::import('Vendor/tecnick.com/tcpdf/tcpdf_barcodes_1d');
$barcodeobj = new TCPDFBarcode($string, $type);
$barcodeobj->getBarcodePNG();
exit (0);
