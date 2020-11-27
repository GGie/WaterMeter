<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Klasifikasi_model extends CI_Model {
	
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	

	public function get_klasifikasi($param)
	{
		$sql = "SELECT id_klasifikasi, klasifikasi FROM tbl_klasifikasi";
		
		$sql .= " WHERE status=1";
		
		if ( !empty($param['id']) ) {
			$sql .= " AND id_klasifikasi LIKE '%" . $param['id_klasifikasi'] . "%'";
		}
		$sql .= " ORDER BY id_klasifikasi DESC";
		
        $query = $this->db->query($sql);

        return $query;
	}
	
	
	public function create_klasifikasi()
	{
		log_users();
		update_load_data('KLASIFIKASI');
		
		return $this->db->insert('tbl_klasifikasi',
			array(
				'klasifikasi'		=> $this->input->post('klasifikasi'),
				'input_by'			=> $this->session->userdata('user_id'),
				'input_date'			=> date('Y-m-d H:i:s'),
				// 'update_by'			=> $data->update_by,
				// 'update_date'		=> date('Y-m-d', strtotime($data->update_date))
				
		));
	}
	
	public function update_klasifikasi()
	{
		if ( !$this->input->post('id_klasifikasi') )
			return false;
		
		log_users();
		update_load_data('KLASIFIKASI');
		
		$this->db->where('id_klasifikasi', $this->input->post('id_klasifikasi'));
		return $this->db->update('tbl_klasifikasi',
			array(
				'klasifikasi'		=> $this->input->post('klasifikasi'),
				'update_by'			=> $this->session->userdata('user_id'),
				'update_date'		=> date('Y-m-d H:i:s')
		));
	}
	

	
	public function getJsonKlasifikasi($id = "")
	{
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10000;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id_klasifikasi';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';
		$offset = ($page-1) * $rows;
		
		$sql = "SELECT * FROM tbl_klasifikasi";
		
		$sql .= " WHERE status=1";
		
		if ( !empty($_POST['id_klasifikasi']) ) {
			$sql .= " AND id_klasifikasi LIKE '%" . $_POST['id_klasifikasi'] . "%'";
		}
		
		if ( !empty($_POST['klasifikasi']) ) {
			$sql .= " AND klasifikasi LIKE '%" . $_POST['klasifikasi'] . "%'";
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
				'id_klasifikasi'		=> $data->id_klasifikasi,
				'klasifikasi'			=> $data->klasifikasi,
				'status'				=> $data->status,
				'input_date'			=> date('Y-m-d', strtotime($data->input_date)),
				'update_by'				=> $data->update_by,
				'update_date'			=> date('Y-m-d', strtotime($data->update_date))
			);
		}
		$result=array_merge($result,array('rows'=>$row));
		return json_encode($result);
	}
	
	
	
	
	public function delete_klasifikasi($id)
	{
		log_users();
		update_load_data('KLASIFIKASI');
		
		$this->db->where('id_klasifikasi', $id);
		return $this->db->update('tbl_klasifikasi',
			array(
				'status'			=> 0
		));
		
		// $this->db->where('id', $id);
		// if (!$this->db->delete('tbl_klasifikasi')) {
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

/* End of file Klasifikasi_model.php */
/* Location: ./application/controllers/Klasifikasi_model.php */