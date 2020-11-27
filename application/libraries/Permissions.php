<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
class Permissions {
 
    public $user_id;
    public $username;
    public $email;
    public $is_login;

	
    public function __construct()
    {
		$CI =& get_instance();
		$this->instan=$CI;
		$CI->load->library('session');
    }

    function menu($menu_id, $akses)
    {
		$CI =& get_instance();
		
		$sql = "SELECT * FROM groups_roles WHERE menu_id='" . $menu_id . "' AND group_id='" . $CI->session->userdata('group_id') . "'";
		$data = $CI->db->query($sql);
		foreach ( $data->result() as $user )
		{
			return $user->$akses;
		}
		
    }
	
	function superadmin()
    {
		
		$CI =& get_instance();
		
		if ( $CI->session->userdata('group_id') == "100001" )
			return TRUE;
		else
			return FALSE;
		
    }
	
    function user_id()
    {
		$CI =& get_instance();
		echo $CI->session->userdata('user_id');
    }
	

}