<?php
defined('BASEPATH') or exit('No direct script access allowed');
 
//load Spout Library
require_once APPPATH . 'third_party/Spout/Autoloader/autoload.php';
 
// use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\WriterFactory;
use Box\Spout\Common\Entity\Row;
use Box\Spout\Common\Type;

class Export extends MX_Controller
{
 
    function __construct()
    {
        parent::__construct();
        //load model
    }
	
    public function xls()
    {
		$sql = "SELECT a.*, b.klasifikasi as klasifikasi, c.nmuser, d.description as periode
			FROM water_meter_report as a
			LEFT JOIN tbl_klasifikasi as b ON a.id_klasifikasi=b.id_klasifikasi
			LEFT JOIN tbl_user as c ON c.user_id=a.createby
			LEFT JOIN period as d ON d.id=a.period_id";
			
		
		$sql .= " WHERE a.status!=0";
		
		if ( !empty($_GET['status_id'])) 
		{
			$sql .= " AND a.status='" . $_GET['status_id'] . "'";
		}
		
		if ( !empty($_GET['reference']) ) {
			$sql .= " AND a.reference LIKE '%" . $_GET['reference'] . "%'";
		}
		
		if ( !empty($_GET['customer_id']) ) {
			$sql .= " AND a.customer_id LIKE '%" . $_GET['customer_id'] . "%'";
		}
		
		if ( !empty($_GET['customer_name']) ) {
			$sql .= " AND a.customer_name LIKE '%" . $_GET['customer_name'] . "%'";
		}
		
		if ( !empty($_GET['area']) ) {
			$sql .= " AND a.area LIKE '%" . $_GET['area'] . "%'";
		}
		
		if ( !empty($_GET['klasifikasi']) ) {
			$sql .= " AND a.id_klasifikasi='" . $_GET['klasifikasi'] . "'";
		}
		
		if ( !empty($_GET['user_pic'])) 
		{
			$sql .= " AND a.createby='" . trim($_GET['user_pic']) . "'";
		}
		
		if ( !empty($_GET['address']) ) {
			$sql .= " AND a.address LIKE '%" . $_GET['address'] . "%'";
		}
		
		if ( !empty($_GET['period_id'])) 
		{
			$sql .= " AND a.period_id='" . trim($_GET['period_id']) . "'";
		}
		
		if ( !empty($_GET['DateFrom']) AND !empty($_GET['DateTo']) ) 
		{
			$sql .= " AND (a.tglcreate BETWEEN '" . date('Y-m-d 00:00:01', strtotime($_GET['DateFrom'])) . "' AND '". date('Y-m-d 23:59:59', strtotime($_GET['DateTo'])) ."')";
		}
		
		$sql .= " ORDER BY a.period_id DESC";
		
		$query	= $this->db->query($sql);
		
		
        //ambil data
         $title = ['No', 'KTP', 'User Name', 'Period Name', 'Site Name', 'Owner Name',
                  'Unitcode', 'Cluster', 'Address', 'Prev Read', 'Prev Cons', 'Current Read',
                  'Current Cons', 'Remark', 'Status', 'Visited Date'];

        $fileName = 'WaterReport' . date('Ymd') . '.xlsx';

        $writer = WriterFactory::create(Type::XLSX); // for XLSX files

        $customers = $query; // dapatkan seluruh data customer
        
        $writer->openToBrowser($fileName); // stream data directly to the browser
        $writer->addRow($title); // tambahkan judul dibaris pertama

		foreach ($customers->result() as $key => $data) {

		$report = @get_report_meter($data->customer_id, (int)$data->period_id);
		
             $row_data[0] = $key+1; //no
             $row_data[1] = $data->ktp; //ktp
             $row_data[2] = $data->nmuser; //get_nmuser($data->createby); // user name
             $row_data[3] = $data->periode; //period
             $row_data[4] = $data->klasifikasi; //site name
             $row_data[5] = $data->customer_name; //owner
             $row_data[6] = $data->reference;
             $row_data[7] = $data->area;
             $row_data[8] = $data->address;
             $row_data[9] = (!$report) ? '0' : $report->final_meter; //Prev Read
             $row_data[10] = (!$report) ? '0' : $report->consumption_meter; //"prev_cons";
             $row_data[11] = (int)$data->final_meter; //Current Read
             $row_data[12] = (int)$data->consumption_meter; //Current Cons
             $row_data[13] = $data->description; //Remark
             $row_data[14] = $data->status_desc; //Status
             $row_data[15] = $data->tglcreate; //date('Y-m-d H:i:s', strtotime($data->tglcreate)); //Status
             
             $plunck_data[] = $row_data;
         }
		 $writer->addRows($plunck_data);
        $writer->close();
    }
}