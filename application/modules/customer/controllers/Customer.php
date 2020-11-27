<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends MX_Controller {
	
	public function __construct()
	{
		parent::__construct();
		if ( !$this->session->userdata('is_login') ) {
				redirect(base_url('login'));
				exit;
		}
		$this->load->helper('url');
		$this->load->model('Customer_model');
		
		
		//if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
	}

	
	
	public function qrcode($qr){				
	
		$this->load->library('qrcode/ciqrcode');
		// header("Content-Type: image/png");
		$this->load->library('ciqrcode');
		
		$params['data'] = $qr;
		$params['level'] = 'A';
		$params['size'] = 10;
		$params['savename'] = FCPATH . "upload/qrcode/" . $qr .'.png';
		$this->ciqrcode->generate($params);

		echo '<img src="'.base_url() . "upload/qrcode/" . $qr .'.png" />';
		echo '<center><b>' . $qr . '</b></center>';
	
	}
	
	
	
	public function getJsonCustomer()
	{
		echo $this->Customer_model->getJsonCustomer();
	}
	
	
	
	
	
	// public function users()
	// {
		// echo $this->Setting_model->getJsonUsers();
	// }

	
	
	
	public function create_customer()
	{
			if(!($this->input->post()))	
					show_404();
				
			header('Content-Type: application/json');


			try
			{
				$id = $this->input->post('customer_id');
				
				$customer = $this->Customer_model->get_customer($id);
				
				if ( $customer->num_rows() >= 1 )
					throw new Exception("ID already");
				
				if($this->Customer_model->create_customer())
					echo json_encode(array('status' => "success", 'message'=>'Success'));
				else
					echo json_encode(array('status' => "failed", 'message'=>'Customer Input Failed'));
		
			}
			
			catch(Exception $ex)
			{
				$data = array('status' => "failed", "message" => $ex->getMessage());
				echo json_encode($data);
			}
		
		
	}
	
	
	
	
	public function update_customer($id)
	{
			if(!($this->input->post()))	
				show_404();
				
			header('Content-Type: application/json');


			try
			{
				
		
				if($this->Customer_model->update_customer($id))
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
	
	
	
	
	
	
	
	public function delete_customer()
	{
			header('Content-Type: application/json');


			try
	    	{
				$id = addslashes($_POST['id']);
		
				if($this->Customer_model->delete_customer($id))
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
	

}
