<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class auto_log extends MX_Controller {

	public function __construct()
	{
		parent :: __construct() ;
		$data = array (
					'url'	=> base_url($this->uri->uri_string()),
					'computer' 		=> gethostname(),
					'ip_address' 	=> $this->input->ip_address(),
					'user_id'		=> $this->session->userdata('user_id'),
					'nmuser' 		=> $this->session->userdata('username'),
					'log_date'		=> date('Y-m-d H:i:s'),
				);
		$this->db->insert('log_load', $data);
		$this->db->reconnect();
	}
}