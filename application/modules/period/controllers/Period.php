<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Period extends MX_Controller {
	
	public function __construct()
	{
		parent::__construct();
		if ( !$this->session->userdata('is_login') ) {
				redirect(base_url('login'));
				exit;
		}
		$this->load->helper('url');
		$this->load->model('Period_model');
		$this->load->model('Customer/Customer_model');
		
		
		//if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
	}

	
	
	
	
	public function getJsonPeriod($id = "")
	{
		echo $this->Period_model->getJsonPeriod($id);
	}
	
	
	
	

	public function create_period()
	{
			// if(!($this->input->post()))	
					// show_404();
				
			header('Content-Type: application/json');
			
			try
			{

				//if ( $customer->num_rows() <= 0 )
					//throw new Exception("ID already");
				
					$param["description"] 	= $this->input->post('description');
				    $this->Period_model->create_period($param);
					
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
	
	
	
	public function create_active()
	{
			// if(!($this->input->post()))	
					// show_404();
				
			header('Content-Type: application/json');
			
			try
			{

				$param["id"] 	= $this->input->post('id');
				if ( !isset($param["id"]) )
					throw new Exception("ID Not Found");
					
					$insert_id = $this->db->insert_id();
					if ( $this->Period_model->create_active($param) ) {
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
	
	
	public function update_Period($id)
	{
			if(!($this->input->post()))	
				show_404();
			
			header("HTTP/1.1 200 OK");
			header('Content-Type: application/json');


			try
			{
				
		
				if($this->Period_model->update_period($id))
					echo json_encode(array('status' => "success", 'message'=>'Success'));
				else
					echo json_encode(array('status' => "failed", 'message'=>'Period Update Failed'));
		
			}
			
			catch(Exception $ex)
			{
				echo json_encode(array( 'status' => "failed", "message" => $ex->getMessage() ));
			}

	}
	
	
	
	
	
	
	
	public function delete_period()
	{
			header('Content-Type: application/json');


			try
	    	{
				$id = addslashes(@$_POST['id']);
				
				if ( !$id )
					throw new Exception("ID not found");
				
				$getPeriod = @$this->db->get_Where('period', array('id' => $id))->row();
		    
				if ( $getPeriod != null ) {
				
					if ( $getPeriod->status == 1 )
						throw new Exception("Period is used");
					
					if($this->Period_model->delete_period($id))
						echo json_encode(array('status' => "success", 'message'=>'Success'));
					else
						echo json_encode(array('status' => "failed", 'message'=>'Period data cannot be deleted'));
					
				} else {
					echo json_encode(array('status' => "failed", 'message'=>'Period Not Found'));
				}
				
				
			}
			
		    catch(Exception $ex)
		    {
		    	$data = array('status' => "failed", "message" => $ex->getMessage());
		    	echo json_encode($data);
		    }
			
	}
	
	
	function period_combogrid($all = ""){
	// * Create Comment 23 Agu 2020
	// * Memanggil Model period_combogrid() dan mengambil ID, Description dari database
	
		if ( !empty($all) ) {
			$row[] = array(
					'id'	=> '',
					'description'		=> 'ALL'
				);
		}
		$data['limit'] = 10;
		$data['search'] = @$_POST['q'];
		$query = $this->Period_model->get_period($data);
		foreach ( $query->result_array() as $data) {	
				$row[] = array(
					'id'				=>$data['id'],
					'description'       =>$data['description']
				);
		}
			
		echo json_encode($row);
	}
	
	
}
