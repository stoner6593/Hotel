<?php

require_once ("tcpdf_barcodes_2d.php");

$code = "hello";
$type = "PDF417";

$barcodeobj = new TCPDF2DBarcode($code, $type);

$barcodeobj->getBarcodePNG();
//$barcodeobj->getBarcodeHTML();



?>
