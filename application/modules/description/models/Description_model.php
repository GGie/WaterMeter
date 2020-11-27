<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Description_model extends CI_Model {
	
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	

	public function get_description($id = "")
	{
		$sql = "SELECT id_description, description FROM tbl_description";
		
		$sql .= " WHERE status=1";
		
		if ( $id ) {
			$sql .= " AND id='" . $id . "'";
		}
		
		$sql .= " ORDER BY id_description DESC";
		
        $query = $this->db->query($sql);

        return $query;
	}
	
	
	public function create_description()
	{
		log_users();
		update_load_data('DESCRIPTION');
		
		return $this->db->insert('tbl_description',
			array(
				'description'			=> $this->input->post('description'),
				'input_by'				=> $this->session->userdata('user_id'),
				'input_date'			=> date('Y-m-d H:i:s'),
				// 'update_by'			=> $data->update_by,
				// 'update_date'		=> date('Y-m-d', strtotime($data->update_date))
				
		));
	}
	
	public function update_description()
	{
		if ( !$this->input->post('id_description') )
			return false;
		
		log_users();
		update_load_data('DESCRIPTION');
		
		$this->db->where('id_description', $this->input->post('id_description'));
		return $this->db->update('tbl_description',
			array(
				'description'		=> $this->input->post('description'),
				'update_by'				=> $this->session->userdata('user_id'),
				'update_date'			=> date('Y-m-d H:i:s')
		));
	}
	

	
	public function getJsonDescription($id = "")
	{
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10000;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id_description';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';
		$offset = ($page-1) * $rows;
		
		$sql = "SELECT * FROM tbl_description";
		
		$sql .= " WHERE status=1";
		
		if ( !empty($_POST['id_description']) ) {
			$sql .= " AND id_description LIKE '%" . $_POST['id_description'] . "%'";
		}
		
		if ( !empty($_POST['description']) ) {
			$sql .= " AND description LIKE '%" . $_POST['description'] . "%'";
		}
		
		if ( !empty($_POST['limit']) ) {
			$sql .= " limit " . $_POST['limit'];
		}
		
		$result = array();
		$result['total'] = $this->db->query( $sql )->num_rows();
		$row = array();
		
		$sql .= " ORDER BY $sort $order limit $offset,$rows";
		$criteria = $this->db->query( $sql );
		
		foreach($criteria->result() as $data)
		{	
		
			$row[] = array(
				'id_description'		=> $data->id_description,
				'description'			=> $data->description,
				'status'				=> $data->status,
				'input_date'			=> date('Y-m-d', strtotime($data->input_date)),
				'update_by'				=> $data->update_by,
				'update_date'			=> date('Y-m-d', strtotime($data->update_date))
			);
		}
		$result=array_merge($result,array('rows'=>$row));
		return json_encode($result);
	}
	
	
	
	
	public function delete_description($id)
	{
		log_users();
		update_load_data('DESCRIPTION');
		
		$this->db->where('id_description', $id);
		return $this->db->update('tbl_description',
			array(
				'status'			=> 0
		));
		
		// $this->db->where('id', $id);
		// if (!$this->db->delete('tbl_description')) {
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

/* End of file Description_model.php */
/* Location: ./application/controllers/Description_model.php */