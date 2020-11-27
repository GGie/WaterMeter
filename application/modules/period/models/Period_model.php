<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Period_model extends CI_Model {
	
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	

	public function get_period($param)
	{
		$sql = "SELECT id, description, font_size, font_style, status FROM period";
		
		$sql .= " WHERE status!=99";
		
		if ( !empty($param['search']) ) {
			$sql .= " AND description LIKE '%" . $param['search'] . "%'";
		}
		
		if ( !empty($param['period_id']) ) {
			$sql .= " AND id='" . $param['period_id'] . "'";
		}
		
		if ( !empty($param['status']) ) {
			$sql .= " AND status='" . $param['status'] . "'";
		}
		
		$sql .= " ORDER BY id DESC";
		
        if ( !empty($param['limit']) ) {
			$sql .= " limit " . $param['limit'];
		}
		
		$query = $this->db->query($sql);

        return $query;
	}
	
	
	public function create_period($param)
	{
		log_users();
		update_load_data('PERIOD');
		
		return $this->db->insert('period',
			array(
				'description'		    => $this->input->post('description'),
				'status'                => 2, // 1 => period aktif, 2 => period nonaktif
				'font_size'				=> 8,
				'font_style'			=> "bold",
				'input_by'				=> $this->session->userdata('user_id'),
				'input_date'			=> date('Y-m-d H:i:s'),
				// 'update_by'			=> $data->update_by,
				// 'update_date'		=> date('Y-m-d', strtotime($data->update_date))
				
		));
	}
	
    public function create_active($param)
	{
		log_users();
		update_load_data('PERIOD');
		
		$this->db->where('status !=', 0);
		$this->db->update('period',
			array(
				'status'		=> 2 //Nonaktif
		));
		
		$paramPeriod['period_id'] = $param['id'];
		$this->InsertOrUpdateReport($paramPeriod);
		
		$this->db->where('id', $param['id']);
		return $this->db->update('period',
			array(
				'status'		=> 1 //Aktif
		));
		
	}
	
	public function InsertOrUpdateReport($param)
	{
	    $periode = $param['period_id'];
		// $getCustomer = @$this->db->get_Where('tbl_customer', array('status' => 1))->result();
		$getCustomer = @$this->db->select('customer_id, customer_name, ktp, reference, kawasan, area, id_klasifikasi, address')->where( array('status' => 1) )->get('tbl_customer')->result();
		
		//0 = delete, 1 = approved, 2 = pending, 3 = open
		foreach ( $getCustomer as $customer ) {
		    /*
		    //water_meter_report
		    $getReport = @$this->db->select('id')->where( array('customer_id' => $customer->customer_id, 'period_id' => $periode) )->get('water_meter_report')->row();
		    // $getReport = @$this->db->get_Where('water_meter_report', array('customer_id' => $customer->customer_id, 'period_id' => $param['period_id']))->row();

		    if ( $getReport != null ) {
			
    			// $this->db->where('id', $getReport->id);
    			// $this->db->update('water_meter_report',
				$insert = array(
					'customer_id'   => $customer->customer_id,
					'customer_name' => str_replace("'", "", $customer->customer_name),
					'ktp'			=> str_replace("'", "", $customer->ktp),
					'reference'     => $customer->reference,
					'kawasan'       => str_replace("'", "", $customer->kawasan),
					'area'          => str_replace("'", "", $customer->area),
					'id_klasifikasi'=> $customer->id_klasifikasi,
					'address'       => str_replace("'", "", $customer->address),
					'period_id'     => $periode,
    					
    			);
    			
    		} else {
				$report = @get_report_meter($customer->customer_id, (int)$periode);
				$initial_meter = (!$report) ? '0' : $report->final_meter;
				 
    			// $this->db->insert('water_meter_report',
				$insert = array(
					'customer_id'   => $customer->customer_id,
					'customer_name' => str_replace("'", "", $customer->customer_name),
					'ktp'			=> str_replace("'", "", $customer->ktp),
					'reference'     => $customer->reference,
					'kawasan'       => str_replace("'", "", $customer->kawasan), 
					'area'          => str_replace("'", "", $customer->area),
					'id_klasifikasi'=> $customer->id_klasifikasi,
					'address'       => str_replace("'", "", $customer->address),
					'initial_meter' => $initial_meter, //@get_counter($customer_id, 'final_meter'),
					'final_meter' 	=> 0,
					'period_id'     => $periode,
					'status'        => 3,
					'status_desc'	=> "Open",
					'input_by'      => $this->session->userdata('user_id'),
					'input_date'    => date('Y-m-d H:i:s'),
    			);
    		}
			*/
			$report = @get_report_meter($customer->customer_id, (int)$periode);
			$initial_meter = (!$report) ? '0' : $report->final_meter;
			
			$insert = array(
					'customer_id'   => $customer->customer_id,
					'customer_name' => str_replace("'", "", $customer->customer_name),
					'ktp'			=> str_replace("'", "", $customer->ktp),
					'reference'     => $customer->reference,
					'kawasan'       => str_replace("'", "", $customer->kawasan),
					'area'          => str_replace("'", "", $customer->area),
					'id_klasifikasi'=> $customer->id_klasifikasi,
					'address'       => str_replace("'", "", $customer->address),
					'period_id'     => $periode,
					'initial_meter' => $initial_meter,
					'input_by'      => $this->session->userdata('user_id'),
					'input_date'    => date('Y-m-d H:i:s'),
    					
    			);
				$this->updateOnDuplicate('water_meter_report',$insert);
    		
    		
		    
		}
		
		
	}
	
	public function updateOnDuplicate($table, $data ) {
		 if (empty($table) || empty($data)) return false;
		 $duplicate_data = array();
		 
		 foreach($data AS $key => $value) {
			$duplicate_data[] = sprintf("%s='%s'", $key, addslashes($value));
		 }

		 $sql = sprintf("%s ON DUPLICATE KEY UPDATE %s", $this->db->insert_string($table, $data), implode(',', $duplicate_data));
		 
		 $this->db->query($sql);
		 return $this->db->insert_id();
	}

	public function update_period($id)
	{
		if ( !$this->input->post('id') )
			return false;
		
		log_users();
		update_load_data('PERIOD');
		
		$this->db->where('id', $this->input->post('id'));
		return $this->db->update('period',
			array(
				'description'		=> $this->input->post('description'),
				'update_by'				=> $this->session->userdata('user_id'),
				'update_date'			=> date('Y-m-d H:i:s')
		));
	}
	

	
	public function getJsonPeriod($id = "")
	{
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10000;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';
		$offset = ($page-1) * $rows;
		
		$sql = "SELECT * FROM period";
		
		$sql .= " WHERE status!=0";
		
		if ( !empty($_POST['od']) ) {
			$sql .= " AND id LIKE '%" . $_POST['id'] . "%'";
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
		
		    if ( $data->status == 1 )
		        $status = "<img src='" . base_url('assets/css/icons/st_green.gif') . "'> Aktif";
		    else if ( $data->status == 2 )
		        $status = "<img src='" . base_url('assets/css/icons/st_red.gif') . "'> Nonaktif";
		        
			$row[] = array(
				'id'		=> $data->id,
				'description'			=> $data->description,
				'status'				=> $status,
				'input_date'			=> date('Y-m-d', strtotime($data->input_date)),
				'update_by'				=> $data->update_by,
				'update_date'			=> date('Y-m-d', strtotime($data->update_date))
			);
		}
		$result=array_merge($result,array('rows'=>$row));
		return json_encode($result);
	}
	
	
	
	
	public function delete_period($id)
	{
		log_users();
		update_load_data('PERIOD');
		
		$this->db->where('id', $id);
		return $this->db->update('period',
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

/* End of file Period_model.php */
/* Location: ./application/controllers/Period_model.php */