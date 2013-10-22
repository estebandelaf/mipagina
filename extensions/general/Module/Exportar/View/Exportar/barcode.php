<?php

/**
 * @file barcode.php
 * Dependencias: # pear install Image_Barcode2
 */

include 'Image/Barcode2.php';
ob_clean();
$img = Image_Barcode2::draw($string, $type, 'png', true, 50, 1);
exit(0);
