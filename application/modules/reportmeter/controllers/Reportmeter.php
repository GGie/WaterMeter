<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportMeter extends MX_Controller {
	
	public function __construct()
	{
		parent::__construct();
		if ( !$this->session->userdata('is_login') ) {
				redirect(base_url('login'));
				exit;
		}
		$this->load->helper('url');
		$this->load->model('Reportmeter_model');
		$this->load->model('Customer/Customer_model');
		
		ini_set('max_execution_time', 0); 
		ini_set('memory_limit','2048M'); 
		//if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
	}
	
	function upload_image(){
		header('Content-Type: application/json');
		
		$this->load->helper('string');
		$random		= strtoupper(random_string('alnum', 6));
		$reportId	= $this->input->post('reportid');
		$type		= $this->input->post('type');
		$time		= round(microtime(true) * 1000);
		$file		= $this->input->post('file');
			
		try
			{
			
			if ( !$reportId )
					throw new Exception("reportId not found");
			if ( !$type )
					throw new Exception("type not found");
			if ( !$file )
					throw new Exception("file not found");
				
			// create dir upload
			if (!is_dir('upload'))
			  mkdir('upload');
		  
			// create dir reportmeter
			if (!is_dir('reportmeter')) 
			  mkdir('reportmeter');
			
			
			$base64img	= base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $file ));
			$name = $reportId . "-" . $type . "-" . $time . "-" . $random . ".png";
			$ImagePath	= "./upload/reportmeter/" . $name;
			
			if($base64img != ""){
				file_put_contents($ImagePath,($base64img));
				
				$this->Reportmeter_model->delete_imagefile($reportId, $type);
				$database = array(
 						'water_meter_report_id' => $reportId,
						'image_name'	=> $name,
						'image_url' 	=> $ImagePath,
						'image_type' 	=> $type,
						'id_status' 	=> 1,
						'input_by' 		=> $this->session->userdata('user_id'),
						'input_date' 	=> date('Y-m-d H:i:s')
					);

				$this->db->insert('image_file', $database);
			}
			$returnValue = json_encode(array('status' => "success", 'message'=> "Success" ));
			
		} catch(Exception $ex)
		{
			$returnValue = json_encode(array('status' => "failed", "message" => $ex->getMessage()));
		}
		
		echo $returnValue;
	}
	
	function index(){
		$this->Reportmeter_model->watermark(('./upload/reportmeter/154-UNIT-1599289074686.png'), date('Y-m-d H:i:s'));
		echo "OK";
	}
	
	public function getJsonReportMeter($id = "")
	{
		echo $this->Reportmeter_model->getJsonReportMeter($id);
	}
	
	
	
	
	
	// public function users()
	// {
		// echo $this->Setting_model->getJsonUsers();
	// }

	
	
	
	public function create_reportmeter()
	{
			// if(!($this->input->post()))	
					// show_404();
				
			header('Content-Type: application/json');

			// $data = $this->Reportmeter_model->create_reportmeter();
			
			try
			{
				$id = $this->input->post('customer_id');
				
				$customer = $this->Customer_model->get_customer($id);
				
				if ( $customer->num_rows() <= 0 )
					throw new Exception("ID already");
				
					$param["customer_id"] 	= $this->input->post('customer_id');
					$param["customer_name"] = $this->input->post('customer_name');
					$param["reference"] 	= $this->input->post('reference');
					$param["area"] 			= $this->input->post('area');
					$param["id_klasifikasi"]= $this->input->post('id_klasifikasi');
					$param["address"] 		= $this->input->post('address');
					$param["initial_meter"]	= $this->input->post('initial_meter');
					$param["final_meter"]	= $this->input->post('final_meter');
					$param["period_id"]	    = $this->input->post('period_id');
					$param["status_id"]	    = $this->input->post('status_id');
					$param["consumption_meter"]	= $this->input->post('final_meter') - $this->input->post('initial_meter');
					$param["tglcreate"]	    = $this->input->post('tglcreate');
					$param["userid"]	    = $this->session->userdata('user_id');
					
					if ( isset($description) )
						$param["description"] = $description;
				
					$this->Reportmeter_model->create_reportmeter($param);
					// var_dump($getCustomer->num_rows());
					
					$insert_id = $this->db->insert_id();
					if ( $insert_id ) {
						
						// $this->customer_model->update_count_meter(
									// array(
										// 'water_meter_report_id' => $insert_id, 
										// 'initial_meter' 		=> $this->input->post('initial_meter'),
										// 'final_meter' 			=> $this->input->post('final_meter'),
										// 'customer_id' 			=> $param["customer_id"],
									// ));
		
						$returnValue = json_encode(array('status' => "success", 'message'=>'Success'));
					} else {
						$returnValue = json_encode(array('status' => "01", 'message'=>'Failed To Save'));
					}
					
				
			}
			
			catch(Exception $ex)
			{
				$data = array('status' => "failed", "message" => $ex->getMessage());
				echo json_encode($data);
			}
		
		echo $returnValue;
		
	}
	
	
	
	
	public function update_reportmeter($id)
	{
			if(!($this->input->post()))	
				show_404();
				
			header('Content-Type: application/json');


			try
			{
				
		
				if($this->Reportmeter_model->update_reportmeter($id)) {
					
					// $this->customer_model->update_count_meter(
									// array(
										// 'water_meter_report_id' => $id, 
										// 'initial_meter' 		=> $this->input->post('initial_meter'),
										// 'final_meter' 			=> $this->input->post('final_meter'),
										// 'customer_id' 			=> $this->input->post('customer_id'),
									// ));
									
					echo json_encode(array('status' => "success", 'message'=>'Success'));
				} else {
					echo json_encode(array('status' => "failed", 'message'=>'Customer Update Failed'));
				}
		
			}
			
			catch(Exception $ex)
			{
				$data = array('status' => "failed", "message" => $ex->getMessage());
				echo json_encode($data);
			}

			
		// if(!isset($_POST))	
			// show_404();
		
		// if($this->Setting_model->update_jbt($param))
			// echo json_encode(array('success'=>true));
		// else
			// echo json_encode(array('msg'=>'Gagal memasukkan data'));	
	}
	
	
	
	
	
	
	
	public function delete_reportmeter()
	{
			header('Content-Type: application/json');


			try
	    	{
				$id = addslashes(@$_POST['id']);
				
				if ( !$id )
					throw new Exception("ID not found");
				
				if($this->Reportmeter_model->delete_reportmeter($id)) {
					echo json_encode(array('status' => "success", 'message'=>'Success'));
				} else {
					echo json_encode(array('status' => "failed", 'message'=>'Customer data cannot be deleted'));
				}
			}
			
		    catch(Exception $ex)
		    {
		    	$data = array('status' => "failed", "message" => $ex->getMessage());
		    	echo json_encode($data);
		    }
			
	}
	
	public function to_approved(){
		
		$no_doc = @$this->input->post('id');
		$pecah=explode('-',$no_doc);
		
		header('Content-Type: application/json');


			try
	    	{

				if ( !$no_doc )
					throw new Exception("ID not found");
				
				foreach($pecah as $inv){
					$this->approved( $inv, 1);
					
						// $log = array (
							// 'pin'			=> $inv,
							// 'ip'			=> $this->input->ip_address(), 					
							// 'input_by'		=> $this->session->userdata('user_id'),
							// 'input_date'	=> date('Y-m-d H:i:s')
						// );
						// $this->db->insert('water_meter_log', $log);
				}
		
				echo json_encode(array('status' => "success", 'message'=>'Success'));
			}
			
		    catch(Exception $ex)
		    {
		    	$data = array('status' => "failed", "message" => $ex->getMessage());
		    	echo json_encode($data);
		    }
	}
	
	public function to_unapproved(){
		
		$no_doc = @$this->input->post('id');
		$pecah=explode('-',$no_doc);
		
		header('Content-Type: application/json');


			try
	    	{

				if ( !$no_doc )
					throw new Exception("ID not found");
				
				foreach($pecah as $inv){
					$this->approved( $inv, 2);
				}
		
				echo json_encode(array('status' => "success", 'message'=>'Success'));
			}
			
		    catch(Exception $ex)
		    {
		    	$data = array('status' => "failed", "message" => $ex->getMessage());
		    	echo json_encode($data);
		    }
	}
	
	public function approved( $id, $status ){
		if ( !empty($id) ) {
			
			if ( $status == 1 )
		        $status_desc = "Approved";
		    else if ( $status == 2 )
		        $status_desc = "Pending";
		    else if ( $status == 3 )
		        $status_desc = "Open";
		    else if ( $status == 4 )
		        $status_desc = "Scan";
			else if ( $status == 0 )
		        $status_desc = "Delete";
		    else
		        $status_desc = "Not Identification";
			
			$log = array (
				'status'			=> $status,				
				'status_desc'		=> $status_desc,				
				'approved_by'		=> $this->session->userdata('user_id'),
				'approved_date'		=> date('Y-m-d H:i:s')
			);
			
			$this->db->where('id', $id);
			return $this->db->update('water_meter_report', $log);
		} else {
			return false;
		}
	}
	
	function cust_name_combogrid(){
	// * Create Comment 18 Agu 2020
	// * Memanggil Model cust_name_combogrid() dan mengambil ID, Nama Customer dari database CERM
	
	    $getPeriod = @$this->db->get_Where('period', array('status'=>1))->row()->id;
	    
		$data['limit'] = 10;
		$data['search'] = @$_POST['q'];
		$query = $this->Customer_model->get_customer($data);
		foreach ( $query->result_array() as $data) {	
				$row[] = array(
					'reference'				=>$data['reference'],
					'customer_id'			=>$data['customer_id'],
					'customer_name'			=>$data['customer_name'],
					'area'					=>$data['area'],
					'address'				=>$data['address'],
					'count_meter'			=>get_meter($data['customer_id'], $getPeriod, 'final_meter'),
				);
		}
			
		echo json_encode($row);
	}
	
	public function viewImage($id, $period_id)
	{
		$report['data'] = $this->Reportmeter_model->getViewImage($id, $period_id)->row();
		
		if ( $report['data']->status == 1 )
			$report['status'] = "<img src='" . base_url('assets/css/icons/st_green.gif') . "'> Approved";
		else if ( $report['data']->status == 2 )
			$report['status'] = "<img src='" . base_url('assets/css/icons/st_red.gif') . "'> Pending";
		else if ( $report['data']->status == 3 )
			$report['status'] = "<img src='" . base_url('assets/css/icons/st_orange.gif') . "'> Open";
		else if ( $report['data']->status == 4 )
			$report['status'] = "<img src='" . base_url('assets/css/icons/st_blue.gif') . "'> Scan";
		else
			$report['status'] = "Not Identification";
		
		
		$report['image1'] = base_url('Images/getImages/METER/' . $id);
		$report['image2'] = base_url('Images/getImages/UNIT/' . $id);
		// echo json_encode($report['data']->row());
		echo $this->load->view('reportmeter/view_image_detail', $report);
	}
	
	public function xls_reportmeter()
    {
		
		$sql = "SELECT
			(SELECT ktp FROM tbl_customer WHERE customer_id=a.customer_id ORDER BY id desc LIMIT 1) as ktp,
			a.customer_name,
			(SELECT description FROM period WHERE id=a.period_id ORDER BY id desc LIMIT 1) as period,
			(SELECT klasifikasi FROM tbl_klasifikasi AS b WHERE b.id_klasifikasi=a.id_klasifikasi) AS klasifikasi,
			(SELECT business_name FROM tbl_customer WHERE customer_id=a.customer_id ORDER BY id desc LIMIT 1) as owner,
			a.reference, a.area, a.address,
			'prev_read' as prev_read,
			'prev_cons' as prev_cons,
			a.final_meter, a.consumption_meter, a.description,
			(SELECT status FROM water_meter_status WHERE id=a.status ORDER BY id desc LIMIT 1) as status,
			a.customer_id, a.period_id
			FROM water_meter_report as a";
			
			// (SELECT image_url FROM image_file WHERE water_meter_report_id=a.id AND image_type='METER' AND id_status=1 LIMIT 1) as image_url1,
			// (SELECT image_url FROM image_file WHERE water_meter_report_id=a.id AND image_type='UNIT' AND id_status=1 LIMIT 1) as image_url2,
			// a.customer_id, a.period_id
		
		$sql .= " WHERE status!=0";
		
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
		
		if ( !empty($_GET['address']) ) {
			$sql .= " AND a.address LIKE '%" . $_GET['address'] . "%'";
		}
		
		$getPeriod = @$this->db->get_Where('period', array('status'=>1))->row()->id;
		if ( !empty($_GET['period_id'])) 
		{
			$sql .= " AND a.period_id='" . trim($_GET['period_id']) . "'";
		} else {
		    $sql .= " AND a.period_id='" . $getPeriod . "'";
		}
		
		if ( !empty($_GET['DateFrom']) AND !empty($_GET['DateTo']) ) 
		{
			$sql .= " AND (a.tglcreate BETWEEN '" . date('Y-m-d 00:00:01', strtotime($_GET['DateFrom'])) . "' AND '". date('Y-m-d 23:59:59', strtotime($_GET['DateTo'])) ."')";
		}
		
		$sql .= " ORDER BY a.period_id DESC";
		
		$query	= $this->db->query($sql);

		// * Create Comment 22 Mei 2018
	// * Fungsi ini untuk generate dari query finishedgood ( query_fg_cahaya() )menjadi excel	

		// Starting the PHPExcel library
        $this->load->library('Excel/PHPExcel');
        $this->load->library('Excel/PHPExcel/IOFactory');
 
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
 
        $objPHPExcel->setActiveSheetIndex(0);
 
        // Field names in the first row
        $fields = $query->list_fields();
		$col = 0;
		
		
		// merubah style border pada cell yang aktif (cell yang terisi)
		$styleArray = array( 'borders' => 
			array( 'allborders' => 
				array( 'style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('argb' => '00000000'), 
					), 
				),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
             	'rotation'   => 0,
			),
			);
		// melakukan pengaturan pada header kolom
		$fontHeader = array( 
			'font' => array(
				'bold' => true
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
             	'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
             	'rotation'   => 0,
			),
			'fill' => array(
            	'type' => PHPExcel_Style_Fill::FILL_SOLID,
            	'color' => array('rgb' => 'b0c4de')
        	)
		);
		
		//Header Excel
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'No');
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, 'KTP');
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, 'User Name');
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, 'Period Name');
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, 'Site Name');
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 1, 'Owner Name');
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, 1, 'Unitcode');
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, 1, 'Cluster');
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, 1, 'Address');
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, 1, 'Prev Read');
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, 1, 'Prev Cons');
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, 1, 'Current Read');
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, 1, 'Current Cons');
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, 1, 'Remark');
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, 1, 'Status');
			// $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, 1, 'Meter Foto');
			// $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, 1, 'Unit Foto');
		//Header Excel EOF
				
 
        // Fetching the table data
        $row = 2;
        foreach($query->result() as $data)
        {
            $col = 1;
			

				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $row-1, PHPExcel_Cell_DataType::TYPE_STRING);
			
            foreach ($fields as $field)
            {
				if ($data->$field == 'prev_read') { //prev_final_meter
				
					$prev_final_meter = get_meter($data->customer_id, (int)$data->period_id, 'final_meter');
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $prev_final_meter, PHPExcel_Cell_DataType::TYPE_STRING);	
				
				} else if ($data->$field == 'prev_cons') { //prev_consumption_meter
				
					$prev_consumption_meter = get_meter($data->customer_id, (int)$data->period_id, 'final_meter') - get_meter($data->customer_id, (int)$data->period_id, 'initial_meter');
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $prev_consumption_meter, PHPExcel_Cell_DataType::TYPE_STRING);	
				
				}
				
				else if ( $col >= 15 ){
					
					// 12 - 13 kosongin aja
					
				} else if ($col <= 14) {
					
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field, PHPExcel_Cell_DataType::TYPE_STRING);	
				
				}
			$col++;
            }
            
			//image
            // for ($x = 1; $x <= 2; $x++) {
                // $fieldimg = "image_url" . $x;
                
                // if ( is_file($data->$fieldimg) AND $data->$fieldimg != null ) {
                    // $gdImage = imagecreatefromjpeg($data->$fieldimg);
                    
                    // $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
                    // $objDrawing->setName('Sample image');
                    // $objDrawing->setDescription('Sample image');
                    // $objDrawing->setImageResource($gdImage);
                    // $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
                    // $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
                    // $objDrawing->setHeight(50);
                    
                    // if ( $x == 1)
                        // $objDrawing->setCoordinates('K' . $row); //Meter Foto
                    // else
                        // $objDrawing->setCoordinates('L' . $row); //Unit Foto
                    
                    // $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());     
                // }
				
            // }
            
            // $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(50);
            $row++;
        }
 
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
		
		// $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25); //Meter Foto
		// $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(25); //Unit Foto

        $objPHPExcel->setActiveSheetIndex(0);
 
 
		$objWorksheet = $objPHPExcel->getActiveSheet();
		// $objPHPExcel->getActiveSheet()->getStyle('G1:H'.$row)->getNumberFormat()->setFormatCode('#');
		
		$objWorksheet->getStyle('A1:O1')->applyFromArray($fontHeader);
		$objWorksheet->getStyle('A1:O'.$row)->applyFromArray($styleArray);
		$objWorksheet->getStyle('A1:O'.$row)->getFont()
                                ->setName('Arial')
                                ->setSize(9);
		$objWorksheet->getStyle('A1:O'.$row)
								->getAlignment()
								->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		
  
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
 
        // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="REPORT_METER_'.date('dmY').'.xls"');
        header('Cache-Control: max-age=0');
 
        $objWriter->save('php://output');
		

			// $objWriter->save('upload/REPORT_METER_'.date('dmY').'.xls');


		
	}
	
	
	public function pdf_reportmeter()
    {
		$sql = "SELECT a.*,
				(SELECT klasifikasi FROM tbl_klasifikasi AS b WHERE b.id_klasifikasi=a.id_klasifikasi) AS klasifikasi
				FROM water_meter_report AS a";
		
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
		
		if ( !empty($_GET['address']) ) {
			$sql .= " AND a.address LIKE '%" . $_GET['address'] . "%'";
		}
		
		$getPeriod = @$this->db->get_Where('period', array('status'=>1))->row()->id;
		if ( !empty($_GET['period_id'])) 
		{
			$sql .= " AND a.period_id='" . trim($_GET['period_id']) . "'";
		}
		else if ( !empty($this->input->get('period')) AND $this->input->get('period') == 'all') 
		{
			if ( $this->input->get('period') != 'all' ) {
				$sql .= " AND a.period_id='" . trim($this->input->get('period')) . "'";
				$doubleCheck .= " AND a.period_id='" . trim($this->input->get('period')) . "'";
			}
		}
		else {
		    $sql .= " AND a.period_id='" . $getPeriod . "'";
		}
		
		if ( !empty($_GET['DateFrom']) AND !empty($_GET['DateTo']) ) 
		{
			$sql .= " AND (a.tglcreate BETWEEN '" . date('Y-m-d 00:00:01', strtotime($_GET['DateFrom'])) . "' AND '". date('Y-m-d 23:59:59', strtotime($_GET['DateTo'])) ."')";
		}
		else if ( !empty($this->input->get('period_id')) AND $this->input->get('period_id') == 'all') 
		{
			// $sql .= " AND a.period_id='" . trim($_POST['period_id']) . "'";
			// $doubleCheck .= " AND a.period_id='" . trim($_POST['period_id']) . "'";
		}
		
		$sql .= " ORDER BY a.tglcreate DESC";
		
		// file_put_contents('report.txt', "request : " . $sql . " \r\n", FILE_APPEND | LOCK_EX);
		
		$data['data']		= $this->db->query($sql);
        //load the view and saved it into $html variable
		if ( $_GET['detail'] == "true" )
			$html = $this->load->view('reportmeter/pdf_reportmeter_detail', $data, true);
		else
			$html = $this->load->view('reportmeter/pdf_reportmeter', $data, true);
		// else
			// $html = $this->load->view('reportmeter/pdf_reportmeter', $data, true);
        //this the the PDF filename that user will get to download
        $pdfFilePath = "PDF_" . date('Ymd_His') . ".pdf";
 
        //load mPDF library
        $this->load->library('m_pdf');
 
		
       //generate the PDF from the given html
        $this->m_pdf->pdf->AddPage('L', // L - landscape, P - portrait
        '', '', '', '',
        4, // margin_left
        4, // margin right
        4, // margin top
        0, // margin bottom
        18, // margin header
        12); // margin footer
		$css = base_url('assets/css/style.css');
        $this->m_pdf->pdf->WriteHTML($css, 1);
        $this->m_pdf->pdf->WriteHTML($html, 2);
 
        //download it.
        //$this->m_pdf->pdf->Output($pdfFilePath, "D");        
        $this->m_pdf->pdf->Output($pdfFilePath, "I");     		
    }
	
	public function pdf_viewimage($id, $period_id)
    {
		$report['data'] = $this->Reportmeter_model->getViewImage($id, $period_id)->row();
		
		if ( $report['data']->status == 1 )
			$report['status'] = "<img src='" . base_url('assets/css/icons/st_green.gif') . "'> Approved";
		else if ( $report['data']->status == 2 )
			$report['status'] = "<img src='" . base_url('assets/css/icons/st_red.gif') . "'> Pending";
		else if ( $report['data']->status == 3 )
			$report['status'] = "<img src='" . base_url('assets/css/icons/st_orange.gif') . "'> Open";
		else if ( $report['data']->status == 4 )
			$report['status'] = "<img src='" . base_url('assets/css/icons/st_blue.gif') . "'> Scan";
		else
			$report['status'] = "Not Identification";
		
		
		$report['image1'] = base_url('Images/getImages/METER/' . $id);
		$report['image2'] = base_url('Images/getImages/UNIT/' . $id);
		// echo json_encode($report['data']->row());
		$html = $this->load->view('reportmeter/view_image_detail', $report, true);

        //this the the PDF filename that user will get to download
        $pdfFilePath = "PDF_" . date('Ymd_His') . ".pdf";
 
        //load mPDF library
        $this->load->library('m_pdf');
 
		
       //generate the PDF from the given html
        $this->m_pdf->pdf->AddPage('P', // L - landscape, P - portrait
        '', '', '', '',
        4, // margin_left
        4, // margin right
        4, // margin top
        0, // margin bottom
        18, // margin header
        12); // margin footer
		$css = base_url('assets/css/style.css');
        $this->m_pdf->pdf->WriteHTML($css, 1);
        $this->m_pdf->pdf->WriteHTML($html, 2);
 
        //download it.
        //$this->m_pdf->pdf->Output($pdfFilePath, "D");        
        $this->m_pdf->pdf->Output($pdfFilePath, "I");     		
    }
	
	public function xls()
    {
		
	}
}
