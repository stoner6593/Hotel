<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
require_once dirname(__FILE__) . '/tcpdf_min/tcpdf_barcodes_2d.php';
 
class Barcode extends TCPDF2DBarcode
{
	
    function __construct()
    {
        //parent::__construct();
       //$this->RUCEmpresa=1234;
    }
   
}

