<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function create()
	{
		return $this->db->insert('tbl_sales_order_h',array(
			'so_nomor'=>$this->input->post('so_nomor',true),
			'tgl_so'=>$this->input->post('tgl_so',true),
			'order_by_cust'=>$this->input->post('order_by_cust',true)
		));
	}
	
	public function update_users($id)
	{
		$this->db->where('user_id', $id);
		return $this->db->update('tbl_user',
			array(
				'user_name'			=> $this->input->post('user_name',true),
				'user_pass'			=> gie_encode($this->input->post('user_pass',true)),
				'user_fullname'		=> $this->input->post('user_fullname',true),
				'status_id' 		=> 1,
				'update_by'			=> $this->session->userdata('user_id'),
				'update_date' 		=> date('Y-m-d H:i:s')
		));
	}

	public function delete_users($id)
	{
		return $this->db->delete('tbl_user', array('user_id' => $id)); 
	}
	
	public function getJson($user_id)
	{
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'menu_id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$offset = ($page-1) * $rows;
		
		$result = array();
		$result['total'] = $this->db->get('menu')->num_rows();
		$row = array();
		
		$this->db->where('status_id', 1);
		$this->db->limit($rows,$offset);
		$this->db->order_by($sort,$order);
		$criteria = $this->db->get('menu');
		
		foreach($criteria->result_array() as $data)
		{	
			//if ( $data['view'] == 1 ) { $view = "checked"; }

				$spasi = str_repeat("<font color='white'>.....</font>", $data['menu_level']);
			
			$view 		= $this->_checked($data['menu_id'], 'view', $user_id);
			$created 	= $this->_checked($data['menu_id'], 'created', $user_id);
			$updated 	= $this->_checked($data['menu_id'], 'updated', $user_id);
			$deleted 	= $this->_checked($data['menu_id'], 'deleted', $user_id);
			$print 		= $this->_checked($data['menu_id'], 'print', $user_id);
			
			$row[] = array(
				'menu_id'	=> $data['menu_id'],
				'user_id'	=> $user_id,
				'menu'		=> $spasi . " <img width='8px' src='" . base_url() . "assets/css/icons/edit_add.png'> " . $data['title'],
				'view'		=> "<input type='checkbox' name='view' 	 onclick='check_click(" . $data['menu_id'] . ", \"view\", \"" . $user_id . "\")' id='view" . $data['menu_id'] . "' " . $view . ">",
				'created'	=> "<input type='checkbox' name='created' onclick='check_click(" . $data['menu_id'] . ", \"created\", \"" . $user_id . "\")' id='created" . $data['menu_id'] . "' " . $created . ">",
				'updated'	=> "<input type='checkbox' name='updated' onclick='check_click(" . $data['menu_id'] . ", \"updated\", \"" . $user_id . "\")' id='updated" . $data['menu_id'] . "' " . $updated . ">",
				'deleted'	=> "<input type='checkbox' name='deleted' onclick='check_click(" . $data['menu_id'] . ", \"deleted\", \"" . $user_id . "\")' id='deleted" . $data['menu_id'] . "' " . $deleted . ">",
				'print'		=> "<input type='checkbox' name='print' onclick='check_click(" . $data['menu_id'] . ", \"print\", \"" . $user_id . "\")' id='print" . $data['menu_id'] . "' " . $print . ">",
			);
			
		}
		$result=array_merge($result,array('rows'=>$row));
		return json_encode($result);
	}
	
}

/* End of file Setting_model.php */
/* Location: ./application/controllers/Setting_model.php */