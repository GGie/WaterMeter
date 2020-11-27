<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Klasifikasi extends MX_Controller {
	
	public function __construct()
	{
		parent::__construct();
		if ( !$this->session->userdata('is_login') ) {
				redirect(base_url('login'));
				exit;
		}
		$this->load->helper('url');
		$this->load->model('Klasifikasi/Klasifikasi_model');
		
		
		//if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
	}

	
	
	
	
	public function getJsonKlasifikasi($id = "")
	{
		echo $this->Klasifikasi_model->getJsonKlasifikasi($id);
	}
	
	
	
	
	
	// public function users()
	// {
		// echo $this->Setting_model->getJsonUsers();
	// }

	
	
	
	public function create_klasifikasi()
	{
			// if(!($this->input->post()))	
					// show_404();
				
			header('Content-Type: application/json');

			try
			{
				$this->Klasifikasi_model->create_klasifikasi();
				// var_dump($getCustomer->num_rows());
				
				$insert_id = $this->db->insert_id();
				if ( $insert_id ) {
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
	
	
	
	
	public function update_klasifikasi()
	{
			if(!($this->input->post()))	
				show_404();
				
			header('Content-Type: application/json');


			try
			{
				
		
				if($this->Klasifikasi_model->update_klasifikasi())
					echo json_encode(array('status' => "success", 'message'=>'Success'));
				else
					echo json_encode(array('status' => "failed", 'message'=>'Customer Update Failed'));
		
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
	
	
	
	
	
	
	
	public function delete_klasifikasi()
	{
			header('Content-Type: application/json');


			try
	    	{
				$id = addslashes(@$_POST['id']);
				
				if ( !$id )
					throw new Exception("ID not found");
				
				if($this->Klasifikasi_model->delete_klasifikasi($id))
					echo json_encode(array('status' => "success", 'message'=>'Success'));
				else
					echo json_encode(array('status' => "failed", 'message'=>'Customer data cannot be deleted'));
			}
			
		    catch(Exception $ex)
		    {
		    	$data = array('status' => "failed", "message" => $ex->getMessage());
		    	echo json_encode($data);
		    }
			
	}
	
	function klasifikasi_combogrid($all = ""){
	// * Create Comment 01 September 2020
	// * Memanggil Model cust_name_combogrid() dan mengambil ID, Nama Customer dari database CERM
	
		if ( !empty($all) ) {
			$row[] = array(
					'id_klasifikasi'	=> '',
					'klasifikasi'		=> 'ALL'
				);
		}
				
		$data['limit'] = 99999;
		$data['search'] = @$_POST['q'];
		$query = $this->Klasifikasi_model->get_klasifikasi($data);
		foreach ( $query->result_array() as $data) {	
				$row[] = array(
					'id_klasifikasi'	=>$data['id_klasifikasi'],
					'klasifikasi'		=>$data['klasifikasi']
				);
		}
			
		echo json_encode($row);
	}
	
	public function pdf_klasifikasi()
    {
		$sql = "SELECT * FROM water_meter_report";
		
		$sql .= " WHERE status=1";
		
		if ( !empty($_GET['reference']) ) {
			$sql .= " AND reference LIKE '%" . $_GET['reference'] . "%'";
		}
		
		if ( !empty($_GET['customer_id']) ) {
			$sql .= " AND customer_id LIKE '%" . $_GET['customer_id'] . "%'";
		}
		
		if ( !empty($_GET['customer_name']) ) {
			$sql .= " AND customer_name LIKE '%" . $_GET['customer_name'] . "%'";
		}
		
		if ( !empty($_GET['area']) ) {
			$sql .= " AND area LIKE '%" . $_GET['area'] . "%'";
		}
		
		if ( !empty($_GET['address']) ) {
			$sql .= " AND address LIKE '%" . $_GET['address'] . "%'";
		}
		
		if ( !empty($_GET['DateFrom']) AND !empty($_GET['DateTo']) ) 
		{
			$sql .= " AND (tglcreate BETWEEN '" . date('Y-m-d 00:00:01', strtotime($_GET['DateFrom'])) . "' AND '". date('Y-m-d 23:59:59', strtotime($_GET['DateTo'])) ."')";
		}
		
		$sql .= " ORDER BY tglcreate DESC";
		
		$data['data']		= $this->db->query($sql);
        //load the view and saved it into $html variable
		if ( $_GET['detail'] == "true" )
			$html = $this->load->view('klasifikasi/pdf_klasifikasi_detail', $data, true);
		else
			$html = $this->load->view('klasifikasi/pdf_klasifikasi', $data, true);
		// else
			// $html = $this->load->view('klasifikasi/pdf_klasifikasi', $data, true);
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
	

}
