<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reportmeter_model extends CI_Model {
	
	
	
	
	
	
	public function __construct()
	{
		parent::__construct();
		// $this->load->database();
		ini_set('max_execution_time', 0); 
		ini_set('memory_limit','2048M'); 
	}
	

	public function getViewImage($id, $period_id)
	{

		$sql = "SELECT a.*, 
			(SELECT klasifikasi FROM tbl_klasifikasi AS b WHERE b.id_klasifikasi=a.id_klasifikasi) AS klasifikasi
			FROM `water_meter_report` as a";
		
		$sql .= " WHERE a.status!=0";
		
		$sql .= " AND a.id='" . $id . "'";
		$sql .= " AND a.period_id='" . $period_id . "'";
		
		$sql .= " ORDER BY period_id desc";
		$criteria = $this->db->query( $sql );
		
		return $criteria;
	}
	
	
	public function get_reportmeter($param)
	{
		$sql = "SELECT * FROM water_meter_report";
		
		$sql .= " WHERE status!=0";
		
		if ( !empty($param["id"]) ) {
			$sql .= " AND id='" . $param["id"] . "'";
		}
		
		if ( !empty($param["customer_id"]) ) {
			$sql .= " AND customer_id='" . $param["customer_id"] . "'";
		}
		
		if ( !empty($param["reference"]) ) {
			$sql .= " AND reference='" . $param["reference"] . "'";
		}
		
		if ( !empty($param["period_id"]) ) {
			$sql .= " AND period_id='" . $param["period_id"] . "'";
		}
		
		if ( !empty($_POST['DateFrom']) AND !empty($_POST['DateTo']) ) 
		{ 
			$sql .= " AND (tglcreate BETWEEN '" . date('Y-m-d 00:00:01', strtotime($_POST['DateFrom'])) . "' AND '". date('Y-m-d 23:59:59', strtotime($_POST['DateTo'])) ."')";
			//$query .= " WHERE (ins__dat BETWEEN '". date('Y-m-d', strtotime('2016-01-01')) . "' AND '". date('Y-m-d', strtotime('2016-01-05')) ."')";
		}
		
		$sql .= " ORDER BY customer_id ASC";
		
        $query = $this->db->query($sql);

        return $query;
	}
	
	
	public function create_reportmeter($param)
	{
		//$this->load->model("customer/customer_model");
		
		if ( !empty($param["description"]) )
			$description = str_replace("'", "", $param["description"]);
		else
			$description = "";
		
		log_users();
		update_load_data('reportmeter');
		//if ( $param["initial_meter"] == 0 AND $param["initial_meter"] == 0 )
		    //$status = 2; //pending
		//else
		    //$status = 1; //approved
		$getStatusDesc = @$this->db->get_Where('water_meter_status', array('id'=>$param["status_id"]))->row()->status;

		return $this->db->insert('water_meter_report',
			array(
				'reference'				=> $param["reference"],
				'customer_id'			=> $param["customer_id"],
				'customer_name'			=> str_replace("'", "", $param["customer_name"]), 
				'ktp'					=> str_replace("'", "", $param["ktp"]), 
				'kawasan'				=> str_replace("'", "", $param["kawasan"]),
				'area'					=> str_replace("'", "", $param["area"]),
				'id_klasifikasi'		=> $param["id_klasifikasi"],
				'address'				=> str_replace("'", "", $param["address"]),
				'description'			=> $description,
				'initial_meter'			=> $param["initial_meter"],
				'final_meter'			=> $param["final_meter"],
				'consumption_meter'		=> $param["final_meter"] - $param["initial_meter"], //$param["consumption_meter"],
				'period_id'				=> $param["period_id"],
				'status'				=> $param["status_id"],
				'status_desc'			=> $getStatusDesc,
				'tglcreate'				=> $param["tglcreate"],
				'input_by'				=> $param["userid"],
				'input_date'			=> date('Y-m-d H:i:s'),
				// 'update_by'			=> $data->update_by,
				// 'update_date'		=> date('Y-m-d', strtotime($data->update_date))
				
		));
		
	}
	
	public function update_reportmeter($id)
	{
		if ( empty($id) )
			return false;
		
		$this->load->model("customer/customer_model");
		
		log_users();
		update_load_data('reportmeter');
		
		$getStatusDesc = @$this->db->get_Where('water_meter_status', array('id'=>$this->input->post("status_id")))->row()->status;
		
		$this->db->where('id', $this->input->post('id'));
		return $this->db->update('water_meter_report',
			array(
				'reference'				=> $this->input->post('reference'),
				'customer_id'			=> $this->input->post('customer_id'),
				'customer_name'			=> str_replace("'", "", $this->input->post('customer_name')), 
				'ktp'					=> str_replace("'", "", $this->input->post('ktp')), 
				'kawasan'				=> str_replace("'", "", $this->input->post('kawasan')),
				'area'					=> str_replace("'", "", $this->input->post('area')),
				'id_klasifikasi'		=> $this->input->post('id_klasifikasi'),
				'address'				=> str_replace("'", "", $this->input->post('address')),
				'description'			=> str_replace("'", "", $this->input->post('description')),
				'initial_meter'			=> $this->input->post('initial_meter'),
				'final_meter'			=> $this->input->post('final_meter'),
				'consumption_meter'		=> $this->input->post('final_meter') - $this->input->post('initial_meter'),
				'period_id'				=> $this->input->post("period_id"),
				'status'				=> $this->input->post("status_id"),
				'status_desc'			=> $getStatusDesc,
				'tglcreate'				=> $this->input->post('tglcreate'),
				// 'input_by'				=> $data->input_by,
				// 'input_date'			=> date('Y-m-d H:i:s'),
				'update_by'				=> $this->session->userdata('user_id'),
				'update_date'			=> date('Y-m-d H:i:s')
		));
		
	}
	

    public function APIupdate_reportmeter($param)
	{
		if ( empty($param["id"]) )
			return false;
		
		log_users(json_encode($param));
		update_load_data('reportmeter');
		
		$getStatusDesc = @$this->db->get_Where('water_meter_status', array('id'=>$param["status"]))->row()->status;
		
		$insertData = array(
				'description'			=> str_replace("'", "", $param["description"]),
				'initial_meter'			=> $param["initial_meter"],
				'final_meter'			=> $param["final_meter"],
				'consumption_meter'		=> $param["final_meter"] - $param["initial_meter"],
				'status'				=> $param["status"],
				'status_desc'			=> $getStatusDesc,
				'tglcreate'				=> $param["tglcreate"],
				'createby'				=> $param["userid"],
				// 'input_by'				=> $data->input_by,
				// 'input_date'			=> date('Y-m-d H:i:s'),
				// 'update_date'			=> date('Y-m-d H:i:s')
		);
		
		$this->db->where('id', $param["id"]);
		return $this->db->update('water_meter_report', $insertData);
		
	}
	
	public function getJsonReportMeter($id = "")
	{
		$total_consumption				= 0;
		$total_prev_consumption_meter	= 0;
		
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'customer_id';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$offset = ($page-1) * $rows;
		
		$getPeriod = @$this->db->get_Where('period', array('status'=>1))->row()->id;
		
		// (SELECT image_url FROM image_file WHERE water_meter_report_id=a.id AND image_type='METER' AND id_status=1 LIMIT 1) as image_url1,
			// (SELECT image_url FROM image_file WHERE water_meter_report_id=a.id AND image_type='UNIT' AND id_status=1 LIMIT 1) as image_url2,
			
			
		$sql = "SELECT a.*, b.klasifikasi, c.nmuser, d.description as periode
			FROM `water_meter_report` as a
			LEFT JOIN tbl_klasifikasi as b ON a.id_klasifikasi=b.id_klasifikasi
			LEFT JOIN tbl_user as c ON c.user_id=a.createby
			LEFT JOIN period as d ON d.id=a.period_id";
		$total_cons = "SELECT sum(consumption_meter) as total_consumption FROM `water_meter_report` as a";
		
		$sql .= " WHERE a.status!=0";
		$total_cons .= " WHERE a.status!=0";
		
		if ( !empty($_POST['status_id'])) 
		{
			$sql .= " AND a.status='" . $_POST['status_id'] . "'";
			$total_cons .= " AND a.status='" . $_POST['status_id'] . "'";
		} else if ( !empty($this->input->get('status_id')) ) 
		{
			$sql .= " AND a.status='" . $this->input->get('status_id') . "'";
			$total_cons .= " AND a.status='" . $this->input->get('status_id') . "'";
		}
		
		if ( !empty($id)) 
		{
			$sql .= " AND a.customer_id='" . trim($id) . "'";
			$total_cons .= " AND a.customer_id='" . trim($id) . "'";
		}
		
		if ( !empty($_POST['reference'])) 
		{
			$sql .= " AND a.reference LIKE '%" . trim($_POST['reference']) . "%'";
			$total_cons .= " AND a.reference LIKE '%" . trim($_POST['reference']) . "%'";
		}
		
		if ( !empty($_POST['customer_id'])) 
		{
			$sql .= " AND a.customer_id LIKE '%" . trim($_POST['customer_id']) . "%'";
			$total_cons .= " AND a.customer_id LIKE '%" . trim($_POST['customer_id']) . "%'";
		}
		
		if ( !empty($_POST['customer_name'])) 
		{
			$sql .= " AND a.customer_name LIKE '%" . trim($_POST['customer_name']) . "%'";
			$total_cons .= " AND a.customer_name LIKE '%" . trim($_POST['customer_name']) . "%'";
		}
		
		if ( !empty($_POST['kawasan'])) 
		{
			$sql .= " AND a.kawasan LIKE '%" . trim($_POST['kawasan']) . "%'";
			$total_cons .= " AND a.kawasan LIKE '%" . trim($_POST['kawasan']) . "%'";
		}
		
		if ( !empty($_POST['area'])) 
		{
			$sql .= " AND a.area LIKE '%" . trim($_POST['area']) . "%'";
			$total_cons .= " AND a.area LIKE '%" . trim($_POST['area']) . "%'";
		}
		
		if ( !empty($_POST['id_klasifikasi'])) 
		{
			$sql .= " AND a.id_klasifikasi='" . $_POST['id_klasifikasi'] . "'";
			$total_cons .= " AND a.id_klasifikasi='" . $_POST['id_klasifikasi'] . "'";
		}
		
		if ( !empty($_POST['user_pic'])) 
		{
			$sql .= " AND a.createby LIKE '%" . trim($_POST['user_pic']) . "%'";
			$total_cons .= " AND a.createby LIKE '%" . trim($_POST['user_pic']) . "%'";
		}
		
		if ( !empty($_POST['address'])) 
		{
			$sql .= " AND a.address LIKE '%" . trim($_POST['address']) . "%'";
			$total_cons .= " AND a.address LIKE '%" . trim($_POST['address']) . "%'";
		}
		
		if ( !empty($_POST['period_id'])) 
		{
			$sql .= " AND a.period_id='" . trim($_POST['period_id']) . "'";
			$total_cons .= " AND a.period_id='" . trim($_POST['period_id']) . "'";
		}
		else if ( !empty($this->input->get('period_id')) AND $this->input->get('period_id') == 'all') 
		{
			// $sql .= " AND a.period_id='" . trim($_POST['period_id']) . "'";
			// $total_cons .= " AND a.period_id='" . trim($_POST['period_id']) . "'";
		} else {
		    $sql .= " AND a.period_id='" . $getPeriod . "'";
			$total_cons .= " AND a.period_id='" . $getPeriod . "'";
		}
		
		if ( isset($_POST['DateFrom']) AND isset($_POST['DateTo']) ) 
		{ 
		$sql .= " AND (a.tglcreate BETWEEN '" . date('Y-m-d 00:00:01', strtotime($_POST['DateFrom'])) . "' AND '". date('Y-m-d 23:59:59', strtotime($_POST['DateTo'])) ."')";
		$total_cons .= " AND (a.tglcreate BETWEEN '" . date('Y-m-d 00:00:01', strtotime($_POST['DateFrom'])) . "' AND '". date('Y-m-d  23:59:59', strtotime($_POST['DateTo'])) ."')";
		//$query .= " WHERE (ins__dat BETWEEN '". date('Y-m-d', strtotime('2016-01-01')) . "' AND '". date('Y-m-d', strtotime('2016-01-05')) ."')";
		
		}
		
		$result = array();
		$result['total']	= $this->db->query( $sql )->num_rows();
		$total_consumption	= $this->db->query( $total_cons )->row()->total_consumption;
		$row = array();
		
		$sql .= " ORDER BY $sort $order limit $offset,$rows";
		$criteria = $this->db->query( $sql );
		
		// file_put_contents('report.txt', "request : " . $sql . " \r\n", FILE_APPEND | LOCK_EX);
		
		foreach($criteria->result() as $data)
		{	
			
			
			
			// if ( !empty($_POST['doubleCheck'])) 
			// {
				// $doubleCheckList = " AND reference='" . $data->reference . "'";
				// $doubleCheckData = $this->db->query( $doubleCheck . $doubleCheckList )->num_rows();
			// } else {
				// $doubleCheckData = 0;
			// }
		
		
		    //0 = delete/di delete di server, 1 = approved/sudah di approved admin, 2 = pending/ispending, 3 = open/belum discan	4 = sudah discan ( status di server )
		    if ( $data->status == 1 )
		        $status = "<img src='" . base_url('assets/css/icons/st_green.gif') . "'> Approved";
		    else if ( $data->status == 2 )
		        $status = "<img src='" . base_url('assets/css/icons/st_red.gif') . "'> Pending";
		    else if ( $data->status == 3 )
		        $status = "<img src='" . base_url('assets/css/icons/st_orange.gif') . "'> Open";
		    else if ( $data->status == 4 )
		        $status = "<img src='" . base_url('assets/css/icons/st_blue.gif') . "'> Scan";
		    else
		        $status = "Not Identification";
		    
			// $prev_consumption_meter = get_meter($data->customer_id, (int)$data->period_id, 'final_meter') - get_meter($data->customer_id, (int)$data->period_id, 'initial_meter');
			$report = @get_report_meter($data->customer_id, (int)$data->period_id);
			$prev_final_meter		= (!$report) ? '0' : $report->final_meter;
            $prev_consumption_meter = (!$report) ? '0' : $report->consumption_meter;
				
			$row[] = array(
				'id'					=> $data->id,
				'reference'				=> $data->reference,
				'customer_id'			=> $data->customer_id,
				'customer_name'			=> $data->customer_name,
				'kawasan'				=> $data->kawasan,
				'area'					=> $data->area,
				'id_klasifikasi'		=> $data->id_klasifikasi,
				'klasifikasi'			=> $data->klasifikasi,
				'address'				=> $data->address,
				'description'			=> $data->description,
				'initial_meter'			=> $data->initial_meter,
                'prev_final_meter'      => $prev_final_meter, //get_meter($data->customer_id, (int)$data->period_id, 'final_meter'),
                'prev_consumption_meter'=> $prev_consumption_meter, //$prev_consumption_meter,
				'final_meter'			=> $data->final_meter,
				'consumption_meter'		=> $data->consumption_meter,
				'status_id'			    => $data->status,
				'status'				=> $status,
				'period_id'				=> $data->period_id,
				'period'				=> $data->periode, //period($data->period_id),
				// 'image_url1'			=> $data->image_url1,
				// 'image_url2'			=> $data->image_url2,
				
				'createby'				=> $data->nmuser, //get_nmuser($data->createby),
				'tglcreate'				=> datex($data->tglcreate),
				// 'input_by'				=> $data->input_by,
				// 'input_date'			=> date('Y-m-d', strtotime($data->input_date)),
				// 'update_by'				=> $data->update_by,
				// 'update_date'			=> date('Y-m-d', strtotime($data->update_date))
			);
			
			// $total_consumption				= $total_consumption + $data->consumption_meter;
			// $total_prev_consumption_meter	= $total_prev_consumption_meter + $prev_consumption_meter;
		}
		$footer[] = array(
				'reference'				=> "Total",
				// 'prev_consumption_meter'=> $total_prev_consumption_meter,
				'consumption_meter'		=> $total_consumption,
			);
			
		$result=array_merge($result,array('rows'=>$row, 'footer'=>$footer));
		return json_encode($result);
	}
	
	
	
	
	public function delete_reportmeter($id)
	{
		$status = "FALSE";
        $query = $this->db->query("SELECT customer_id FROM water_meter_report WHERE id='" . $id . "'");
		
		if ( $query->num_rows() > 0 ) {
			
			log_users();
			update_load_data('reportmeter');
			
			//delete di water_meter_count
			// $this->db->where('water_meter_report_id', $id);
			// $this->db->update('water_meter_count',
				// array(
					// 'status'			=> 0
			// ));
			
			//update count_meter di tbl_customer
			$customer_id = $query->row()->customer_id;
			$this->db->where('customer_id', $customer_id);
			$this->db->update('tbl_customer',
				array(
					'count_meter'			=> @get_counter($customer_id, 'final_meter') //$param['final_meter'],
			));
			
			//delete di water_meter_report
			$this->db->where('id', $id);
			$this->db->update('water_meter_report',
				array(
					'status'		=> 0,
					'status_desc'	=> "Delete",
			));
			
			$this->delete_imagefile($id, $query->row()->image_type);
			
			$status = "TRUE";
		
		}
		
		return $status;
		// $this->db->where('id', $id);
		// if (!$this->db->delete('water_meter_report')) {
			// # Delete Failed
			// return false;
		// }  
		// else{
			// # delete Sucess
			// return true;
		// }
	
	}
	
	public function delete_imagefile($id, $type)
	{
		$status = "FALSE";
        // $query = $this->db->query("SELECT image_id FROM image_file WHERE water_meter_report_id='" . $id . "' AND image_type='" . $type . "'");
        $query = $this->db->query("UPDATE
										image_file
									SET
										id_status = 0
									WHERE water_meter_report_id='" . $id . "'
									AND image_type='" . $type . "'");
		
		// if ( $query->num_rows() > 0 ) {
			
			// // delete di water_meter_count
			// $this->db->where('water_meter_report_id', $id);
			// $this->db->where('image_type', $type);
			// $this->db->update('image_file',
				// array(
					// 'id_status'	=> 0
			// ));
			
			// $status = "TRUE";
		
		// }
		
		return $status;
	
	}
	
	public function watermark($image = "", $text = "")
    {
		if ( !empty($image) AND !empty($text) ) {
			$this->load->library('image_lib');
			
			$data = file_get_contents($image); 
			list($width, $height, $type, $attr) = getimagesizefromstring($data);
			
			$wm_font_path = 50; //font-size
			$size = ceil(($width / 100) * $wm_font_path);
			
			$config['source_image'] = $image; //The path of the image to be watermarked
			$config['wm_text'] = $text; //date('Y-m-d H:i:s');
			$config['wm_type'] = 'text';
			// $config['wm_font_path'] = 'system/fonts/texb.ttf';
			$config['maintain_ratio']   = TRUE;
			// $config['dynamic_output'] = true;
			// $config['wm_font_path'] = ./system/fonts/texb.ttf';
			// $config['wm_font_path'] = ./system/fonts/texb.ttf';
			$config['wm_font_size'] = $size;
			$config['image_library'] = 'gd2';
			// $resize_settings['maintain_ratio'] = true.
			// $resize_settings['quality'] = '90%';
			$config['wm_font_color'] = '379fef';
			// $config['quality'] = '80%';
			$config['wm_padding'] = 0;
			$config['wm_vrt_alignment'] = 'bottom';
			$config['wm_hor_alignment'] = 'left';
			$this->image_lib->initialize($config);
			
			//fitur rotasi gambar
			// $config['rotation_angle'] = '270';// 
			// if (!$this->image_lib->rotate()) {
				// echo $this->image_lib->display_errors();
			// }
			
			if (!$this->image_lib->watermark()) {
				echo $this->image_lib->display_errors();
			}
		}
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

/* End of file Reportmeter_model.php */
/* Location: ./application/controllers/Reportmeter_model.php */