<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MX_Controller {
	

	public function __construct()
	{
		parent :: __construct() ;
		$this->load->model('login/Login_m');
		$this->load->model('tool/Tool_model');

	}
	
		//cek session user
	function check_session(){
		$id = $this->session->userdata('user_id');
	   if($id){
			 return 1;
	   }else{
			 return 0;
	   }
	}
	
	
	public function index()
	{

		$user = $this->input->post('txtuser');
		$pass = $this->input->post('txtpassword');
		if ( $user AND $pass ) {		// Cek apakah user telah menginput username dan password
			$user_cek = $this->Login_m->cek_login($user, $pass);
			if ( $user_cek == 1 ) {
				$data = $this->Login_m->get_data_login($user, $pass);
				foreach ($data->result() as $data_login ) {
					//echo $data_login->user_name;
					$sess_array = array(
											'user_id' 		=> $data_login->user_id, 
											'username' 		=> $data_login->nmuser, 
											'user_fullname' => $data_login->fullname, 
											'jabatan_id'	=> $data_login->jabatan_id, 
											// 'dept_id' 		=> $data_login->dept_id, 
											'group_id' 		=> $data_login->group_id, 
											'is_login' 		=> TRUE
										) ;
												
					$this->session->set_userdata($sess_array);
					
					
					//update lst login
					$paramLogin = array(
						'last_login'	=> date('Y-m-d H:i:s'),
					);
					$this->db->where('user_id',$data_login->user_id);
					$this->db->update('tbl_user', $paramLogin);
					
					//insert log ip address
					$this->Tool_model->ipaddress();
					if ( $this->session->userdata('url_old') ) {
						redirect($this->session->userdata('url_old'));
					} else {
						redirect(base_url('home'));
					}
				}
			} elseif ( $user_cek == 2 ) {
				$this->session->set_flashdata('message', 'Account Disabled.');
				
				$param['id_browser'] = $this->get__browser();
				$this->load->view('login/login', $param);
			} elseif ( $user_cek == 3 ) {
				$this->session->set_flashdata('message', 'Incorrect Password.');
				
				$param['id_browser'] = $this->get__browser();
				$this->load->view('login/login', $param);
			} elseif ( $user_cek == 4 ) {
				$this->session->set_flashdata('message', 'Incorrect Username.');
				
				$param['id_browser'] = $this->get__browser();
				$this->load->view('login/login', $param);
			} else {
				$this->session->set_flashdata('message', 'Incorrect Login.');
				
				$param['id_browser'] = $this->get__browser();
				$this->load->view('login/login', $param);
			}
		} else {
			if ( !$this->session->userdata('is_login') ) {
				$param['id_browser'] = $this->get__browser();
				$this->load->view('login/login', $param);
			} else {
				redirect(base_url('home'));
			}
		}
		
	}
	
	public function logout() {

		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('user_fullname');
		$this->session->unset_userdata('group_id');
		$this->session->unset_userdata('jabatan_id');
		$this->session->unset_userdata('dept_id');
		$this->session->unset_userdata('is_login');
		//session_destroy() ;
		
		redirect(base_url()) ;
		
	}
	
	function get__browser(){
		
		$user_agent = $_SERVER['HTTP_USER_AGENT']; 
		
		if (preg_match('/MSIE/i', $user_agent)) { $browser = "Internet Explorer";} 
		elseif (preg_match('/Firefox/i', $user_agent)){$browser = "Mozilla Firefox";} 
		elseif (preg_match('/Chrome/i', $user_agent)){$browser = "Google Chrome";} 
		elseif (preg_match('/Safari/i', $user_agent)){$browser = "Safari";} 
		elseif (preg_match('/Opera/i', $user_agent)){$browser = "Opera";}
		else {$browser = "Other";}

		return $browser;
	}
}
