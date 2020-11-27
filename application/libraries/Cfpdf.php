<?php if ( !defined('BASEPATH')) exit();
class Cfpdf
{
    function __construct()
    {
//        require_once APPPATH.'/third_party/FPDF/fpdf.php';
        require_once APPPATH.'/third_party/FPDF/html2pdf.php';
    }
}
?>