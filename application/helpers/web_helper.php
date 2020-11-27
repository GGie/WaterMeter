<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Helper untuk pengaturan web
 */

function is_login()
{
    $CI =& get_instance();

    if ( $CI->session->userdata('log_session') == FALSE ) {
        redirect(base_url() . 'akun/masuk');
        //$CI->load->view('akun/masuk');
		exit();
    }

}

// Cek jika belum login
function must_login()
{
    if ( is_login() == false ) {
        redirect('akun/masuk');
        die;
    }
}


/*
//meload file css
function load_css($target_href = array())
{
    $return = '';
    foreach ($target_href as $value) {
        $return .= '<link type="text/css" href="'.$value.'" rel="stylesheet">'.PHP_EOL;
    }
    return $return;
}

//meload file js
function load_js($target_src = array())
{
    $return = '';
    foreach ($target_src as $value) {
        $return .= '<script src="'.$value.'" type="text/javascript"></script>'.PHP_EOL;
    }
    return $return;
}
*/

//membuat div class alert
function get_alert($notif = 'success', $msg = '')
{
    return "<div class='alert alert-" . $notif . "'><b><center> " . $msg . "</center></b></div>";
}

function get_message($notif = 'success', $msg = '')
{
    return "<div class='message alert-" . $notif . "'><b><center> " . $msg . "</center></b></div>";
}

function format_indo($date) {
	if ( $date != '0000-00-00 00:00:00' AND isset($date)){
		$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
		$tahun = substr($date, 0, 4);
		$bulan = substr($date, 5, 2);
		$tgl = substr($date, 8, 2);
		
		$result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " " . $tahun;
		echo $result;
	} else {
		
	}
}

function format_indoX($date) {
	if( strtotime($date) > 0 ){
		return $date;
	} else {
		
	}
}

function format_indo_return($date) {
	if ( $date != '0000-00-00 00:00:00' AND isset($date)){
		$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
		$tahun = substr($date, 0, 4);
		$bulan = substr($date, 5, 2);
		$tgl = substr($date, 8, 2);
		
		$result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " " . $tahun;
		return $result;
	} else {
		
	}
}

function int_to_month($date) {
	
		$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

		$result = $BulanIndo[(int)$date-1];
		return $result;

}

function datex( $datetime ){
	$datex = date('Y-m-d H:i:s', strtotime( $datetime ));
	if ( $datex == '1970-01-01 07:00:00' || $datex == '-0001-11-30 00:00:00' ){
		return '0000-00-00 00:00:00';
	} else {
		return $datex;
	}
}

function tgl_to_day( $tgl ){
	$unix = strtotime($tgl);
	 $hari = date("D", $unix); // hasilnya 3 huruf nama hari bahasa inggris
	 # supaya harinya menjadi bahasa indonesia maka harus kita gant/replace
	 $hari = str_replace('Sun', 'Minggu', $hari);
	 $hari = str_replace('Mon', 'Senin', $hari);
	 $hari = str_replace('Tue', 'Selasa', $hari);
	 $hari = str_replace('Wed', 'Rabu', $hari);
	 $hari = str_replace('Thu', 'Kamis', $hari);
	 $hari = str_replace('Fri', 'Jum\'at', $hari);
	 $hari = str_replace('Sat', 'Sabtu', $hari);
	 
	 echo $hari;
}

function cek_tanggal($teks) {
		//untuk mengecek akhir tanggal - Aplikasi report intercompany
		
		$kata_kotor = array("28", "29", "30", "31"); 
		$hasil = 0;
		$jml_kata = count($kata_kotor);
		for ($i=0;$i<$jml_kata;$i++) {
			if (stristr($teks,$kata_kotor[$i])){ $hasil=1; }
		}
		 
		return $hasil;
 
}

function get_nmuser($user_id){
		$CI =& get_instance();
		
		$sql 	= "SELECT * FROM tbl_user WHERE user_id='" . $user_id . "'";
		$query 	= $CI->db->query( $sql );
		
		if ( $query->num_rows() > 0 ) {
			$nmuser = $query->row()->nmuser;
		} else {
			$nmuser = "";
		}
		
		return $nmuser;
}

function bulan_to_alphabet($bulan){
				switch ($bulan) {
			case 1 :
				return "I";
			break;
			case 2 :
				return "II";
			break;
			case 3 :
				return "III";
			break;
			case 4 :
				return "IV";
			break;
			case 5 :
				return "V";
			break;
			case 6 :
				return "VI";
			break;
			case 7 :
				return "VII";
			break;
			case 8 :
				return "VIII";
			break;
			case 9 :
				return "IX";
			break;
			case 10 :
				return "X";
			break;
			case 11 :
				return "XI";
			break;
			case 12 :
				return "XII";
			break;
			default :
				return "Error";
			break;
		}
}


//CMIS SA EOF
function format_size($size) {
    $mod = 1024;

    $units = explode(' ','B KB MB GB TB PB');
    for ($i = 0; $size > $mod; $i++) {
        $size /= $mod;
    }
	
	return round($size, 2) . ' ' . $units[$i];
	
}

function check_dir($dir){
	$total = 0;
	foreach (new RecursiveDirectoryIterator(($dir)) as $entry) {
		if ($entry->isFile())
		$total += $entry->getSize();
	}
	
	return ($total);
}

function url_help($id){
		
		$CI =& get_instance();

		return base_url('uploads/help' . '/' . $id . '.pdf');
}

function get_counter($customer_id, $field){
		//$id = str_replace("_", "/", $id_nc);
		$CI =& get_instance();
		
		$query 	= "SELECT $field FROM water_meter_count WHERE customer_id='" . $customer_id . "' AND status=1 ORDER BY id desc LIMIT 1";
		$data 	= $CI->db->query( $query );
		if( $data->num_rows() > 0 )
			return $data->row()->$field;
		else
			return 0;

		//if ( $res->$field == $id_field )
		//{
			//echo 'value="$res->$field" <script></script>';
			
		//}
}

function get_meter($customer_id, $period_id, $field){
		//$id = str_replace("_", "/", $id_nc);
		$CI =& get_instance();
		
		$period_id = $period_id - 1;
		$query 	= "SELECT $field FROM water_meter_report WHERE customer_id='" . $customer_id . "' AND period_id='" . $period_id . "' AND status=1 ORDER BY id desc LIMIT 1";
		
		// file_put_contents('log.txt', "*** " . $query . " ***\r\n", FILE_APPEND | LOCK_EX);
		$data 	= $CI->db->query( $query );
		if( $data->num_rows() > 0 )
			return $data->row()->$field;
		else {
			$count = 0;
			
			$query 	= "SELECT $field FROM water_meter_report WHERE customer_id='" . $customer_id . "' AND status=1 ORDER BY id desc";
			$data2 	= $CI->db->query( $query );
			
			if( $data2->num_rows() > 0 ) {
				foreach($data2->result() as $meter){
					if ( $meter->$field != '' ) {
						$count = $meter->$field;
						break;
					}
				}
			} else {
				$count = 0;
			}
			
			return $count;
		}

		//if ( $res->$field == $id_field )
		//{
			//echo 'value="$res->$field" <script></script>';
			
		//}
}

function get_report_meter($customer_id, $period_id, $field = ""){
		//$id = str_replace("_", "/", $id_nc);
		$CI =& get_instance();
		
		/*
		$period_id = $period_id - 1;
		$query 	= "SELECT * FROM water_meter_report WHERE customer_id='" . $customer_id . "' AND period_id='" . $period_id . "' AND status=1 ORDER BY id desc LIMIT 1";
		
		$data 	= $CI->db->query( $query );
		if( $data->num_rows() > 0 )
			return $data->row();
		else {
			$count = false;
			
			$query 	= "SELECT * FROM water_meter_report WHERE customer_id='" . $customer_id . "' AND status=1 ORDER BY id desc";
			$data2 	= $CI->db->query( $query );
			
			if( $data2->num_rows() > 0 ) {
				return $data->row();
			} else {
				$count = false;
			}
			
			return $count;
		}
		*/
		
		$query 	= "SELECT * FROM water_meter_report WHERE customer_id='" . $customer_id . "' AND period_id<'" . $period_id . "' AND status=1 ORDER BY id desc LIMIT 1";
		
		$data 	= $CI->db->query( $query );
		if( $data->num_rows() > 0 )
			return $data->row();
		else {
			return false;
		}
}

function period($period_id){
		//$id = str_replace("_", "/", $id_nc);
		$CI =& get_instance();
		
		$query 	= "SELECT description FROM period WHERE id='" . $period_id . "' ORDER BY id desc LIMIT 1";
		$data 	= $CI->db->query( $query );
		if( $data->num_rows() > 0 )
			return $data->row()->description;
		else
			return 0;
}


function log_users( $desc = "" ){
    $init =& get_instance();
	
	$data['method']		= $init->router->fetch_method();
	$data['description']= $desc;
	$data['user_id']	= $init->session->userdata('user_id');
	$data['date']		= date('Y-m-d H:i:s');
	
	$init->db->insert('log_users', $data);
	
}

function update_load_data($desc){
    $init =& get_instance();
	
      $init->db->set('data', 'data +'. 1 .'', false);
      $init->db->set('update_by', $init->session->userdata('user_id'));
      $init->db->where('description', $desc);
      $init->db->update('log_data');
	
}

function select_load_data($desc){
    $init =& get_instance();
	
	$count = @$init->db->get_where('log_data', array('description' => $desc))->row();
	
	$data = json_encode(array('user_id' => $count->update_by, "data" => $count->data));
	return $data;
}
//sumber encode http://richardpeacock.com/blog/2011/08/encode-any-string-only-alphanumeric-chars-better-urlencode
function gie_encode($input) {
    $strrev = strrev($input);
    $string = base64_encode($strrev);
    return bin2hex($string);
}

function gie_decode($input) {
    $string = pack("H*", $input);
    $base64 =  base64_decode($string);
    return strrev($base64);

}


