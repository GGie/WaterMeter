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
 
 
	//Memunculkan halaman jika halaman yang diakses user tidak ada
	public function error_page(){
		$this->load->view('home/error_404');
	}
	


	public function index() {
	// * Create Comment 17 Juli 2018x
	// * Menu Utama
		
		$menu_tab = $this->db->query('SELECT * FROM menu WHERE status_id=1 AND menu_level=2 ORDER BY menu_order asc');
		
		$menus['menu_tab']		= $menu_tab;
		$this->load->view('home/home', $menus);
	}
	
	
	public function index() {
	// * Create Comment 17 Juli 2018x
	// * Menu Utama Petugas

		$menus['menu_tab']		= $menu_tab;
		$this->load->view('petugas/home', $menus);
	}
	
	
	function menu_child( $menu_id ){
		return $this->db->query("SELECT * FROM menu WHERE menu_pid='" . $menu_id . "' AND status_id=1 ORDER BY menu_order");
	}
	
	
	public function permissions() {
	// * Create Comment 17 Juli 2018
	// * Menu Untuk merubah permissions user -> Menu Setting
	
		$data['menu_id'] = 4;
		
		//if ( $this->permissions->menu($data['menu_id'], 'view') ) {
			$this->load->view('setting/permissions');	
		//}
	}
	
	
	
	public function users() {
	// * Create Comment 17 Juli 2018
	// * Menu management users -> Menu Setting
	
		$this->load->view('setting/users');		
	}
	
	

	
	
	
	public function ip() {
	// * Create Comment 17 Juli 2018
	// * Menu History Login Users -> Menu Tool
	
		$this->load->view('tool/ip');
		$this->load->view('home/footer');		
	}
	
	

	public function change()
	{
		$data = "";
		$this->load->view('setting/change_pass', $data);
	}
	
	
	public function group(){
	// * Create Comment 17 Juli 2018
	// * Untuk menambahkan group akses -> Menu Setting
	
		$data = "";
		$this->load->view('setting/group', $data);
	}
	
	
	public function pelanggan() {
	// * Create Comment 17 Juli 2018
	// * Menu management users -> Menu Setting
	
		$data = "";
		$this->load->view('pelanggan/pelanggan', $data);		
	}
	
		
}
