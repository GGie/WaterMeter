<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Secret_model extends CI_Model {
	
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	

	public function get_secret($id = "")
	{
		$sql = "SELECT option_id, secret FROM site_options";
		
		$sql .= " WHERE status=1";
		
		if ( $id ) {
			$sql .= " AND id='" . $id . "'";
		}
		
		$sql .= " ORDER BY option_id DESC";
		
        $query = $this->db->query($sql);

        return $query;
	}
	
	
	public function active_secret($param)
	{
		log_users();
		update_load_data('SECRET');
		
		$this->db->where('active !=', 0);
		$this->db->update('site_options',
			array(
				'active'		=> 2 //Nonaktif
		));
		
		$this->db->where('option_id', $param['id']);
		return $this->db->update('site_options',
			array(
				'active'		=> 1 //Aktif
		));
		
	}
	
	public function create_secret()
	{
		log_users();
		update_load_data('SECRET');
		
		$json = array(
				'reportmeter_folder_id' => $this->input->post('reportmeter_folder_id'),
				'client_email'			=> $this->input->post('client_email'),
				'private_key'			=> $this->input->post('private_key')
			);
			
		return $this->db->insert('site_options',
			array(
				'active'			=> 2,
				'option_name'		=> 'GDRIVE',
				'option_value'		=> json_encode($json),
				'input_by'			=> $this->session->userdata('user_id'),
				'input_date'		=> date('Y-m-d H:i:s')
				
		));
	}
	
	public function update_secret($name = "")
	{
		if ( !$this->input->post('option_id') )
			return false;
		
		log_users();
		update_load_data('SECRET');
		
		$json = array(
				'reportmeter_folder_id' => $this->input->post('reportmeter_folder_id'),
				'client_email'			=> $this->input->post('client_email'),
				'private_key'			=> $name, //$this->input->post('private_key')
			);
		
		$this->db->where('option_id', $this->input->post('option_id'));
		return $this->db->update('site_options',
			array(
				'option_name'		=> 'GDRIVE',
				'option_value'		=> json_encode($json),
				'update_by'			=> $this->session->userdata('user_id'),
				'update_date'		=> date('Y-m-d H:i:s')
				
		));
	}
	

	
	public function getJsonSecret($id = "")
	{
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10000;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'option_id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';
		$offset = ($page-1) * $rows;
		
		$sql = "SELECT * FROM site_options";
		
		$sql .= " WHERE option_name='GDRIVE'";
		
		if ( !empty($_POST['option_id']) ) {
			$sql .= " AND option_id LIKE '%" . $_POST['option_id'] . "%'";
		}
		
		if ( !empty($_POST['secret']) ) {
			$sql .= " AND option_value LIKE '%" . $_POST['secret'] . "%'";
		}
		
		// if ( !empty($_POST['limit']) ) {
			// $sql .= " limit " . $_POST['limit'];
		// }
		
		$result = array();
		$result['total'] = $this->db->query( $sql )->num_rows();
		$row = array();
		
		$sql .= " ORDER BY $sort $order limit $offset,$rows";
		$criteria = $this->db->query( $sql );
		
		foreach($criteria->result() as $data)
		{	
		
			if ( $data->active == 1 )
		        $status = "<img src='" . base_url('assets/css/icons/st_green.gif') . "'> Aktif";
		    else if ( $data->active == 2 )
		        $status = "<img src='" . base_url('assets/css/icons/st_red.gif') . "'> Nonaktif";
			
			$json = json_decode($data->option_value, true);
			$row[] = array(
				'option_id'				=> $data->option_id,
				'option_name'			=> $data->option_name,
				'reportmeter_folder_id'	=> $json['reportmeter_folder_id'],
				'client_email'			=> $json['client_email'],
				'private_key'			=> $json['private_key'],
				'active'				=> $status,
				'input_date'			=> date('Y-m-d', strtotime($data->input_date)),
				'update_by'				=> $data->update_by,
				'update_date'			=> date('Y-m-d', strtotime($data->update_date))
			);
		}
		$result=array_merge($result,array('rows'=>$row));
		return json_encode($result);
	}
	
	
	
	
	public function delete_secret($id)
	{
		log_users();
		update_load_data('SECRET');
		
		$this->db->where('option_id', $id);
		return $this->db->update('site_options',
			array(
				'status'			=> 0
		));
		
		// $this->db->where('id', $id);
		// if (!$this->db->delete('site_options')) {
			// # Delete Failed
			// return false;
		// }  
		// else{
			// # delete Sucess
			// return true;
		// }
	
	}
	

	// function auto_customer_id()
	// {
		// $q = $this->db->query("SELECT max(RIGHT(group_id, 6)) as group_id FROM `group`");
		// foreach ($q->result() as $d)
		// {
			// $dt1 = 1 + $d->group_id ;
			// $dt2 = "" . sprintf("%06s", $dt1) ;
			// return $dt2;
		// }
	// }
	
	
}

/* End of file Secret_model.php */
/* Location: ./application/controllers/Secret_model.php */