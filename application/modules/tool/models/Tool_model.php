<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tool_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function ipaddress()
	{
		log_users();
		update_load_data('IP');
		
		$data = array(
				'ip_address' 	=> $this->input->ip_address(),
				'computer' 		=> gethostname(),
				'user_id'		=> $this->session->userdata('user_id'),
				'nmuser' 		=> $this->session->userdata('username'),
				'last_login' 	=> date('Y-m-d H:i:s'),
		);
		
		$this->db->insert('log_login', $data);
	}
	
	public function getJson()
	{
		$db_sql 	= $this->load->database('sql_cerm', true);
		if ( isset($_POST['DateFrom']) ) {
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'fak__ref';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
		$offset = ($page-1) * $rows;
		
		$query = "SELECT * FROM hafgfk__";
		
		
		//if ( isset($_POST['DateFrom']) AND isset($_POST['DateTo']) ) 
		//{ 
		$query .= " WHERE (ins__dat BETWEEN '" . date('Y-m-d', strtotime($_POST['DateFrom'])) . "' AND '". date('Y-m-d', strtotime($_POST['DateTo'])) ."')";
		//$query .= " WHERE (ins__dat BETWEEN '". date('Y-m-d', strtotime('2016-01-01')) . "' AND '". date('Y-m-d', strtotime('2016-01-05')) ."')";
		
		//}
		if ( isset($_POST['q']) AND $_POST['q'] != '' ) {
			$query .= " AND fak__ref='" . $_POST['q'] . "'";
		}
		
		$result = array();
		$result['total'] = $db_sql->query($query)->num_rows();

		$row = array();
		//$query .= " ORDER BY $sort $order limit $offset, $rows";
		
		$criteria 	= $db_sql->query( $query );
		
		
		foreach($criteria->result_array() as $data)
		{	
		
			if ( $data['dok__srt'] == 1 ) { $dok_type = "Invoice"; } else { $dok_type = "Credite Note"; }
			$row[] = array(
				'dok__srt'		=> $dok_type, //type dok
				'dgbk_ref'		=> $data['dgbk_ref'], //jurnal
				'fak__ref'		=> $data['fak__ref'], //Invoice
				'bkj__ref'		=> $data['bkj__ref'], //financial year
				'kla__rpn'		=> $data['kla__rpn'], //customer keyword
				'ins__dat'		=> date('Y-m-d', strtotime($data['ins__dat'])), //Date of entry
				'dok__dat'		=> date('Y-m-d', strtotime($data['dok__dat'])), //Dokumen date
				'dok__com'		=> $data['dok__com'], //accounting comment
				'user____'		=> $data['user____'], //User
			);
			
		}
		$result=array_merge($result,array('rows'=>$row));
		return json_encode($result);
		//print_r($query);
		}
	}
	
	public function getJsonIp()
	{
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'last_login';
		$order = isset($_POST['order']) ? strval($_POST['order']) : 'desc';
		$offset = ($page-1) * $rows;
		
		$query = "SELECT * FROM log_login";

		if ( isset($_POST['tglawal']) AND isset($_POST['tglakhir']) ) 
		{ 
			$query .= ' WHERE (last_login BETWEEN "'. date('Y-m-d', strtotime($_POST['tglawal'])). '" AND "'. date('Y-m-d', strtotime($_POST['tglakhir'] . ' + 1 days')) . '")';
		} else {
			$query .= ' WHERE (last_login BETWEEN "'. date('Y-m-d'). '" AND "'. date('Y-m-d', strtotime('+ 1 days')) . '")';
		}
		
		if ( isset($_POST['nmuser']) AND $_POST['nmuser'] != '' ) {
			$query .= " AND nmuser='" . $_POST['nmuser'] . "'";
		}
		
		if ( isset($_POST['ip_address']) AND $_POST['ip_address'] != '' ) {
			$query .= " AND ip_address='" . $_POST['ip_address'] . "'";
		}
		
		$result = array();
		$result['total'] = $this->db->query($query)->num_rows();

		$row = array();
		$query .= " ORDER BY $sort $order limit $offset, $rows";
		
		$criteria 	= $this->db->query( $query );
		
		
		foreach($criteria->result_array() as $data)
		{	
		
			$row[] = array(
				'id_login'		=> $data['id_login'],
				'ip_address'	=> $data['ip_address'],
				'computer'		=> $data['computer'],
				'user_id'		=> $data['user_id'],
				'nmuser'		=> $data['nmuser'],
				'last_login'	=> $data['last_login'],
			);
			
		}
		$result=array_merge($result,array('rows'=>$row));
		return json_encode($result);
		//print_r($query);
		
	}
	
}

/* End of file Setting_model.php */
/* Location: ./application/controllers/Setting_model.php */