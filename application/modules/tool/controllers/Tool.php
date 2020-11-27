<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tool extends MX_Controller {

	public function __construct()
	{
		parent :: __construct() ;
		$this->load->helper('url');
		$this->load->model('tool/Tool_model');

	}

	public function getJson()
	{
		echo $this->Tool_model->getJson();
	}
	
	public function getJsonIp()
	{
		echo $this->Tool_model->getJsonIp();
	}

	public function getJsonInv($inv)
	{
		echo $this->Tool_model->getJsonInv($inv);
	}
	
	public function getJsonAcc($inv)
	{
		echo $this->Tool_model->getJsonAcc($inv);
	}

	public function update_hafgfr()
	{
		if(!isset($_POST))	
			show_404();
		
		if($this->Tool_model->update_hafgfr())
			echo json_encode(array('success'=>true));
		else
			echo json_encode(array('msg'=>'Gagal Close Capa'));
			
	}

	public function getJsonVlg()
	{
		echo $this->Tool_model->getJsonVlg();
	}
	
	function open_fak(){
		
		if(!isset($_POST))	
			show_404();
		
		$rcvd_vlg1 = $_POST['rcvd_vlg1'];
		$rcvd_vlg2 = $_POST['rcvd_vlg2'];
		
		if($this->Tool_model->open_fak($rcvd_vlg1, $rcvd_vlg2))
			echo json_encode(array('success'=>true));
		else
			echo json_encode(array('msg'=>'Gagal Menghapus data'));
	}
	
	function blok_fak(){
		
		if(!isset($_POST))	
			show_404();
		
		$rcvd_vlg1 = $_POST['rcvd_vlg1'];
		$rcvd_vlg2 = $_POST['rcvd_vlg2'];
		
		if($this->Tool_model->blok_fak($rcvd_vlg1, $rcvd_vlg2))
			echo json_encode(array('success'=>true));
		else
			echo json_encode(array('msg'=>'Gagal Menghapus data'));
	}
	
	
	function get_accounts(){
		$query = $this->Tool_model->get_accounts();
		foreach ( $query->result_array() as $data) {	
				$row[] = array(
					'arek_ref'			=>$data['arek_ref'],
					'arek_oms'			=>$data['arek_oms'],
				);
		}
			
		echo json_encode($row);
	}	
	
	public function ip(){
		//$this->load->view('tool/ip');
		$this->load->library('user_agent');
		echo $this->agent->browser().' '.$this->agent->version(); //Browser
		echo "<br>";
		echo $this->agent->agent_string(); // User Agent
		echo "<br>";
		echo $this->input->ip_address(); // IP Address
		echo "<br>";
		echo $this->agent->platform(); // System Operasi
		echo "<br>";
		echo gethostname();
		echo "<br>";
		echo date('Y-m-d H:i:s');
	}	
}
