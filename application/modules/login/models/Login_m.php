<?php

class Login_m extends CI_Model{
	
    function get_data_login($user, $pass){
		$sql = "SELECT * FROM tbl_user WHERE iduser='" . $user . "' AND pwd='" . $pass . "'";
        $query = $this->db->query($sql);

        return $query;
    }
	
	function cek_login($user, $pass)
	{
		//$db_sql = $this->load->database('sql_svr', true);
		
		//1 Berhasil Login
		//2 Akun disable
		//3 Salah password
		//4 Salah username
		if ( isset($user) AND isset($pass))
		{
			$sql = "SELECT * FROM tbl_user WHERE iduser='" . $user . "' AND pwd='" . $pass . "'";
			$query = $this->db->query($sql);
			
			if ( $query->num_rows() > 0 ) {
				if ( $query->row()->status_id == 1 ){
					$result = 1 ;
				} else {
					$result = 2 ;
				}
			} else {
				$sql_check = "SELECT * FROM tbl_user WHERE iduser='" . $user . "'";
				$query_check = $this->db->query($sql_check);
				
				if ( $query_check->num_rows() > 0 ) {
					$result = 3;
				} else {
					$result = 4;
				}
			}
		}
		return $result ;
	}
}

/* End of file Login_m.php */
/* Location: ./application/controllers/Login_m.php */