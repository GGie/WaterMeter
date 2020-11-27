<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MX_Controller {

	public function __construct()
	{
		parent :: __construct() ;
		if ( !$this->session->userdata('is_login') ) {
				redirect(base_url('login'));
				exit;
		}
		//$this->load->library('session');

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
	
	//cek session user
	function check_refresh($menu = ""){
	
		header('Content-Type: application/json');

		if($menu != ""){
			 echo select_load_data($menu);
		}
		
	}

	public function index() {
	// * Create Comment 17 Juli 2018x
	// * Menu Utama
		
		$menu_tab = $this->db->query('SELECT * FROM menu WHERE status_id=1 AND menu_level=2 ORDER BY menu_order asc');
		
		$menus['menu_tab']		= $menu_tab;
		
		// if ( $this->session->userdata("jabatan_id") == "10001" )
			$this->load->view('home/home', $menus);
		// else
			// $this->load->view('petugas/home', $menus);
	}
	
	
	function menu_child( $menu_id ){
		return $this->db->query("SELECT * FROM menu WHERE menu_pid='" . $menu_id . "' AND status_id=1 ORDER BY menu_order");
	}
	
	
	public function permissions() {
	// * Create Comment 17 Juli 2018
	// * Menu Untuk merubah permissions user -> Menu Setting
		$data['menu_id'] = 4;

		if ( $this->permissions->menu($data['menu_id'], 'view') ) {
			$this->load->view('setting/permissions', $data);
		} else {
			$this->show_403();
		}
		
	}
	
	
	
	public function users() {
	// * Create Comment 17 Juli 2018
	// * Menu management users -> Menu Setting
	$result = json_decode(select_load_data('USER'), true);
	$data['refresh'] = $result['data'];
	
		$data['menu_id'] = 3;

		if ( $this->permissions->menu($data['menu_id'], 'view') ) {
			$this->load->view('setting/users', $data);
		} else {
			$this->show_403();
		}	
	}
	
	

	
	public function dirmonitor() {
		$data['menu_id'] = 5;

		if ( $this->permissions->menu($data['menu_id'], 'view') ) {
			$this->load->view('tool/dirmonitor', $data);
		} else {
			$this->show_403();
		}
	}
	
	
	public function ip() {
	// * Create Comment 17 Juli 2018
	// * Menu History Login Users -> Menu Tool
	$result = json_decode(select_load_data('IP'), true);
	
		$data['menu_id'] = 40;
		$data['refresh'] = $result['data'];
		
		if ( $this->permissions->menu($data['menu_id'], 'view') ) {
			$this->load->view('tool/ip', $data);
		} else {
			$this->show_403();
		}	
	}
	
	

	public function change()
	{
		$data = "";
		$this->load->view('setting/change_pass', $data);
	}
	
	
	public function group(){
	// * Create Comment 17 Juli 2018
	// * Untuk menambahkan group akses -> Menu Setting
	$result = json_decode(select_load_data('GROUP'), true);
	$data['refresh'] = $result['data'];
	
		$data['menu_id'] = 34;

		if ( $this->permissions->menu($data['menu_id'], 'view') ) {
			$this->load->view('setting/group', $data);
		} else {
			$this->show_403();
		}
		
	}
	
	
	public function customer() {
	// * Create Comment 05 Agustus 2020
	// * Menu management Master Data -> Data Customer
	$result = json_decode(select_load_data('CUSTOMER'), true);
	$data['refresh'] = $result['data'];
	
		$data['menu_id'] = 44;
		$data['getPeriod'] = @$this->db->get_Where('period', array('status'=>1))->row()->id;
		
		if ( $this->permissions->menu($data['menu_id'], 'view') ) {
			$this->load->view('customer/customer', $data);
		} else {
			$this->show_403();
		}
			
	}
	
	public function reportmeter() {
	// * Create Comment 06 Agustus 2020
	// * Menu management Master Data -> Report Meter
		$result = json_decode(select_load_data('REPORTMETER'), true);

		$data['menu_id'] = 45;
		$data['refresh'] = $result['data'];

		if ( $this->permissions->menu($data['menu_id'], 'view') ) {
			$data['getPeriod'] = @$this->db->get_Where('period', array('status'=>1))->row()->id;
			$this->load->view('reportmeter/reportmeter', $data);
		} else {
			$this->show_403();
		}		
	}
	
	public function description() {
	// * Create Comment 06 Agustus 2020
	// * Menu management Master Data -> Report Meter
	$result = json_decode(select_load_data('DESCRIPTION'), true);
	$data['refresh'] = $result['data'];
	
		$data['menu_id'] = 6;

		if ( $this->permissions->menu($data['menu_id'], 'view') ) {
			$this->load->view('description/description', $data);	
		} else {
			$this->show_403();
		}
			
	}
	
	public function period() {	
	// * Create Comment 22 Agustus 2020
	// * Menu management Master Data -> Period
	$result = json_decode(select_load_data('PERIOD'), true);
	$data['refresh'] = $result['data'];
	
		$data['menu_id'] = 7;

		if ( $this->permissions->menu($data['menu_id'], 'view') ) {
			$this->load->view('period/period', $data);
		} else {
			$this->show_403();
		}
			
	}
	
	public function klasifikasi() {
	// * Create Comment 01 September 2020
	// * Menu management Master Data -> Period
	$result = json_decode(select_load_data('KLASIFIKASI'), true);
	$data['refresh'] = $result['data'];
	
		$data['menu_id'] = 48;

		if ( $this->permissions->menu($data['menu_id'], 'view') ) {
			$this->load->view('klasifikasi/klasifikasi', $data);
		} else {
			$this->show_403();
		}
			
	}
	
	public function secret() {
	// * Create Comment 08 November 2020
	// * Menu management Master Data -> Secret
	$result = json_decode(select_load_data('SECRET'), true);
	$data['refresh'] = $result['data'];
	
		$data['menu_id'] = 49;

		if ( $this->permissions->menu($data['menu_id'], 'view') ) {
			$this->load->view('secret/secret', $data);
		} else {
			$this->show_403();
		}
			
	}
	
		
}
