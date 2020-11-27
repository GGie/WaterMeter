<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer_model extends CI_Model {
	
	
	
	
	
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	

	public function get_customer($param = "")
	{
		$sql = "SELECT id, customer_id, customer_name, reference, kawasan, area, id_klasifikasi, address, count_meter FROM tbl_customer";
		
		$sql .= " WHERE status='1'";
		
		if ( !empty($param['customer_id']) ) {
			$sql .= " AND customer_id='" . $param['customer_id'] . "'";
		}
		
		if ( !empty($param['reference']) ) {
			$sql .= " AND reference='" . $param['reference'] . "'";
		}
		
		if ( !empty($param['search']) ) {
			$sql .= " AND (customer_name LIKE '%" . $param['search'] . "%'";
			$sql .= " OR reference LIKE '%" . $param['search'] . "%'";
			$sql .= " OR area LIKE '%" . $param['search'] . "%'";
			$sql .= " OR address LIKE '%" . $param['search'] . "%')";
		}
		
		if ( !empty($param['limit']) ) {
			$sql .= " limit " . $param['limit'];
		}
		
		
		
		
        $query = $this->db->query($sql);

        return $query;
	}
	
	
	public function create_customer()
	{
		log_users();
		update_load_data('CUSTOMER');
		
		return $this->db->insert('tbl_customer',
			array(
				'customer_id'			=> $this->input->post('customer_id'),
				'ktp'					=> $this->input->post('ktp'),
				'business_name'			=> str_replace("'", "", $this->input->post('business_name')),
				'customer_name'			=> str_replace("'", "", $this->input->post('customer_name')),
				'reference'				=> $this->input->post('reference'),
				'kawasan'				=> str_replace("'", "", $this->input->post('kawasan')),
				'area'					=> str_replace("'", "", $this->input->post('area')),
				'id_klasifikasi'		=> $this->input->post('id_klasifikasi'),
				'address'				=> str_replace("'", "", $this->input->post('address')),
				'count_meter'			=> $this->input->post('count_meter'),
				'description'			=> str_replace("'", "", $this->input->post('description')),
				'input_by'				=> $this->session->userdata('user_id'),
				'input_date'			=> date('Y-m-d H:i:s'),
				// 'update_by'			=> $data->update_by,
				// 'update_date'		=> date('Y-m-d', strtotime($data->update_date))
				
		));
	}
	
	public function update_customer($id)
	{
		if ( !$this->input->post('id') )
			return false;
		
		log_users();
		update_load_data('CUSTOMER');
		
		$this->db->where('id', $this->input->post('id'));
		return $this->db->update('tbl_customer',
			array(
				'customer_id'			=> $this->input->post('customer_id'),
				'ktp'					=> $this->input->post('ktp'),
				'business_name'			=> str_replace("'", "", $this->input->post('business_name')),
				'customer_name'			=> str_replace("'", "", $this->input->post('customer_name')),
				'reference'				=> $this->input->post('reference'),
				'kawasan'				=> str_replace("'", "", $this->input->post('kawasan')),
				'area'					=> str_replace("'", "", $this->input->post('area')),
				'id_klasifikasi'		=> $this->input->post('id_klasifikasi'),
				'address'				=> str_replace("'", "", $this->input->post('address')),
				'count_meter'			=> $this->input->post('count_meter'),
				'description'			=> str_replace("'", "", $this->input->post('description')),
				// 'input_by'				=> $data->input_by,
				// 'input_date'			=> date('Y-m-d H:i:s'),
				'update_by'				=> $this->session->userdata('user_id'),
				'update_date'			=> date('Y-m-d H:i:s'),
		));
	}
	

	
	public function getJsonCustomer()
	{
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 99999999999;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'customer_id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$offset = ($page-1) * $rows;
		
		$sql = "SELECT a.*, (SELECT klasifikasi FROM tbl_klasifikasi AS b WHERE b.id_klasifikasi=a.id_klasifikasi) AS klasifikasi FROM `tbl_customer` AS a";
		
		$sql .= " WHERE status=1";
		
		if ( !empty($_POST['reference'])) 
		{
			$sql .= " AND a.reference LIKE '%" . $_POST['reference'] . "%'";
		}
		
		if ( !empty($_POST['customer_id'])) 
		{
			$sql .= " AND a.customer_id LIKE '%" . $_POST['customer_id'] . "%'";
		}
		
		if ( !empty($_POST['customer_name'])) 
		{
			$sql .= " AND a.customer_name LIKE '%" . $_POST['customer_name'] . "%'";
		}
		
		if ( !empty($_POST['kawasan'])) 
		{
			$sql .= " AND a.kawasan LIKE '%" . $_POST['kawasan'] . "%'";
		}
		
		if ( !empty($_POST['area'])) 
		{
			$sql .= " AND a.area LIKE '%" . $_POST['area'] . "%'";
		}
		
		if ( !empty($_POST['id_klasifikasi'])) 
		{
			$sql .= " AND a.id_klasifikasi='" . $_POST['id_klasifikasi'] . "'";
		}
		
		if ( !empty($_POST['address'])) 
		{
			$sql .= " AND a.address LIKE '%" . $_POST['address'] . "%'";
		}
		
		$result = array();
		$result['total'] = $this->db->query( $sql )->num_rows();
		$row = array();
		
		$sql .= " ORDER BY $sort $order limit $offset,$rows";
		$criteria = $this->db->query( $sql );
		
		foreach($criteria->result() as $data)
		{
			$row[] = array(
				'id'					=> $data->id,
				'customer_id'			=> $data->customer_id,
				'ktp'					=> $data->ktp,
				'business_name'			=> $data->business_name,
				'customer_name'			=> $data->customer_name,
				'reference'				=> $data->reference,
				'kawasan'				=> $data->kawasan,
				'area'					=> $data->area,
				'id_klasifikasi'		=> $data->id_klasifikasi,
				'klasifikasi'			=> $data->klasifikasi,
				'address'				=> $data->address,
				'count_meter'			=> $data->count_meter,
				'description'			=> $data->description,
				'input_by'				=> $data->input_by,
				'input_date'			=> date('Y-m-d', strtotime($data->input_date)),
				'update_by'				=> $data->update_by,
				'update_date'			=> date('Y-m-d', strtotime($data->update_date))
			);
		}
		$result=array_merge($result,array('rows'=>$row));
		return json_encode($result);
	}
	
	
	
	
	public function delete_customer($id)
	{
		log_users();
		update_load_data('CUSTOMER');
		
		$this->db->where('id', $id);
		return $this->db->update('tbl_customer',
			array(
				'status'			=> 0
		));
		
		// if (!$this->db->delete('tbl_customer')) {
			// # Delete Failed
			// return false;
		// }  
		// else{
			// # delete Sucess
			// return true;
		// }
	
	}
 
	public function update_count_meter($param)
	{
		// if ( !$param['water_meter_report_id'] )
			// return false;
		
		// $water_meter_count = @$this->db->get_Where('water_meter_count', array('water_meter_report_id' => $param['water_meter_report_id']))->row()->id;
		
		// if ( $param["initial_meter"] == 0 AND $param["initial_meter"] == 0 )
		    // $status = 2; //pending
		// else
		    // $status = 1; //approved
		    
		// if ( $water_meter_count != null ) {
			
			// $this->db->where('water_meter_report_id', $param['water_meter_report_id']);
			// $this->db->update('water_meter_count',
				// array(
					// 'water_meter_report_id'	=> $param['water_meter_report_id'],
					// 'customer_id'			=> $param['customer_id'],
					// 'initial_meter'			=> $param['initial_meter'],
					// 'final_meter'			=> $param['final_meter'],
					// 'status'				=> $status,
					// 'consumption_meter'		=> $param['final_meter'] - $param['initial_meter'],
					// 'update_by'				=> !empty($param['user_id']) ? $param['user_id'] : $this->session->userdata('user_id'),
					// 'update_date'			=> date('Y-m-d H:i:s'),
			// ));
			
		// } else {
			// $this->db->insert('water_meter_count',
				// array(
					// 'water_meter_report_id'	=> $param['water_meter_report_id'],
					// 'customer_id'			=> $param['customer_id'],
					// 'initial_meter'			=> $param['initial_meter'],
					// 'final_meter'			=> $param['final_meter'],
					// 'status'				=> $status,
					// 'consumption_meter'		=> $param['final_meter'] - $param['initial_meter'],
					// 'input_by'				=> !empty($param['user_id']) ? $param['user_id'] : $this->session->userdata('user_id'),
					// 'input_date'			=> date('Y-m-d H:i:s'),
			// ));
		// }
		
		// $this->db->where('customer_id', $param['customer_id']);
		// return $this->db->update('tbl_customer',
			// array(
				// 'count_meter'			=> @get_counter($param['customer_id'], 'final_meter'),  //$param['final_meter'],
				// 'update_by'				=> !empty($param['user_id']) ? $param['user_id'] : $this->session->userdata('user_id'),
				// 'update_date'			=> date('Y-m-d H:i:s'),
		// ));
		
		
		
	}
	
	function auto_customer_id()
	{
		$q = $this->db->query("SELECT max(RIGHT(group_id, 6)) as group_id FROM `group`");
		foreach ($q->result() as $d)
		{
			$dt1 = 1 + $d->group_id ;
			$dt2 = "" . sprintf("%06s", $dt1) ;
			return $dt2;
		}
	}
	
	
}

/* End of file Customer_model.php */
/* Location: ./application/controllers/Customer_model.php */