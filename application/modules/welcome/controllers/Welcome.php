<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MX_Controller {
 
	public function index()
    {
     
    }
	
	public function error(){
			echo $this->load->view('errors/html/error_404');
	}
	
}