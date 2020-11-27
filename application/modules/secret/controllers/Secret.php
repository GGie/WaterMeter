<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Secret extends MX_Controller {
	
	public function __construct()
	{
		parent::__construct();
		if ( !$this->session->userdata('is_login') ) {
				redirect(base_url('login'));
				exit;
		}
		$this->load->helper('url');
		$this->load->model('Secret_model');
		
		
		//if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
	}

	
	
	
	
	public function getJsonSecret($id = "")
	{
		echo $this->Secret_model->getJsonSecret($id);
	}
	
	
	public function active_secret()
	{
			header('Content-Type: application/json');
			
			try
			{
					$param["id"] 	= $this->input->post('id');
					
					$insert_id = $this->db->insert_id();
					if ( $this->Secret_model->active_secret($param) ) {
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
	
	public function create_secret()
	{
			// if(!($this->input->post()))	
					// show_404();
				
			header('Content-Type: application/json');
			
			try
			{
				// var_dump($getCustomer->num_rows());
				
				if ( $this->Secret_model->create_secret() ) {
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
	
	
	
	
	public function update_secret()
	{
			if(!($this->input->post()))	
				show_404();
				
			header('Content-Type: application/json');


			try
			{
				
				$f=$_FILES['private_key'];
				$name = date('YmdHis') . ".p12";
				
				//create dir
				if (!is_dir('upload')) 
				  mkdir('upload');
			  
				if (!is_dir('upload/secret')) 
				  mkdir('upload/secret');
			  
				$dest='./upload/secret/';

				if(move_uploaded_file($f['tmp_name'], "{$dest}{$name}")) {
				   
				} else {
				   
				}
		
				if($this->Secret_model->update_secret($name))
					echo json_encode(array('status' => "success", 'message'=>'Success'));
				else
					echo json_encode(array('status' => "failed", 'message'=>'Secret Update Failed'));
		
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
	
	
	
	
	
	
	
	public function delete_secret()
	{
			header('Content-Type: application/json');


			try
	    	{
				$id = addslashes(@$_POST['id']);
				
				if ( !$id )
					throw new Exception("ID not found");
				
				if($this->Secret_model->delete_secret($id))
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
