<?php
App::import('Vendor/tecnick.com/tcpdf/tcpdf_barcodes_2d');
$barcodeobj = new TCPDF2DBarcode($string, 'QRCode');
$barcodeobj->getBarcodePNG();
exit (0);
