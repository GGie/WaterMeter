<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Description extends MX_Controller {
	
	public function __construct()
	{
		parent::__construct();
		if ( !$this->session->userdata('is_login') ) {
				redirect(base_url('login'));
				exit;
		}
		$this->load->helper('url');
		$this->load->model('Description_model');
		
		
		//if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
	}

	
	
	
	
	public function getJsonDescription($id = "")
	{
		echo $this->Description_model->getJsonDescription($id);
	}

	
	
	public function create_description()
	{
			// if(!($this->input->post()))	
					// show_404();
				
			header('Content-Type: application/json');
			
			try
			{
				// var_dump($getCustomer->num_rows());
				
				if ( $this->Description_model->create_description() ) {
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
	
	
	
	
	public function update_description()
	{
			if(!($this->input->post()))	
				show_404();
				
			header('Content-Type: application/json');


			try
			{
				
		
				if($this->Description_model->update_description())
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
	
	
	
	
	
	
	
	public function delete_description()
	{
			header('Content-Type: application/json');


			try
	    	{
				$id = addslashes(@$_POST['id']);
				
				if ( !$id )
					throw new Exception("ID not found");
				
				if($this->Description_model->delete_description($id))
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
