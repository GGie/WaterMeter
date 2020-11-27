<?php
 
class PdfGenerator
{
  public function generate($html, $filename, $setup = 'potrait', $ukuran = 'A4')
  {
    define('DOMPDF_ENABLE_AUTOLOAD', false);
    //require_once("./vendor/dompdf/dompdf/dompdf_config.inc.php");
	require_once(dirname(__FILE__) . '/dompdf/dompdf_config.inc.php');
 
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
	$width =  3.37 * 72; // Width in points (3.37" x 72 pt/in)
	$height = 2.125 * 72; // Height in points (2.125" x 72 pt/in)
	
	$size = array(0,0,595.28,841.89);
    $dompdf->set_paper($ukuran, $setup);
    //$dompdf->get_page_number();
    $dompdf->render();
    $dompdf->stream($filename.'.pdf',array("Attachment"=>0));
  }
}