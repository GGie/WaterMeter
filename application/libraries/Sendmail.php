<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require_once 'Mandrill.php';

 
class Sendmail {
  
    function __construct(){
        //$CI =& get_instance();
		//$this->instan=$CI;       
    }
	function index() {

	}
	
	//PARAM => email, subject, message, link 	
    function send_email( $param ) {
	
			$CI =& get_instance();
		
			if ( isset ( $param['email'] ) ) {
				$CI->db->where('email', $param['email']);
				$cek_akun = $CI->db->get('users');
				foreach ( $cek_akun->result() as $jenis_user ) {}
				if ( $jenis_user->jenis_user == 1 ) {
					
				$email_temp = array(
					'email_subject' 	=> $param['subject'],
					'email_desc' 		=> $param['message'],
					'email_from' 		=> "admin@bisanego.co.id",
					'email_to' 			=> $param['email'],
					'email_link'		=> $param['link'],
					'email_status_id' 	=> 0,
					'input_date' 		=> date('Y-m-d H:i:s')
				);
				
				$CI->db->insert('email_temp', $email_temp);
		
			}
		}
	}
    function send_email_temp( $param ) {
			$CI =& get_instance();
			$CI->load->library('email') ;
			
                    $config = array() ;
					$config['charset'] 		= 'utf-8' ;
                    $config['useragent'] 	= 'Codeigniter' ;
                    $config['protocol'] 	= "smtp" ;
                    $config['mailtype'] 	= "html" ;
                    $config['smtp_host'] 	= "smtp.mandrillapp.com" ;
                    //$config['smtp_host'] 	= "smtp.mandrillapp.com" ;
                    //$config['smtp_host'] 	= "ssl://smtp.gmail.com" ;
                    $config['smtp_port'] 	= "587" ;
                    $config['smtp_timeout'] = "400" ;
                    $config['smtp_user'] 	= "yusufyanuar@hotmail.com" ;
                    //$config['smtp_user'] 	= "anggietriejast@gmail.com" ;
                    $config['smtp_pass'] 	= "aDsgatEVpHEYjJVJCZ4bOw" ;
                    //$config['smtp_pass'] 	= "mC1qfB_hBEfLC1zJ_QFbmg" ;
                    $config['crlf'] 		= "\r\n" ;
                    $config['newline'] 		= "\r\n" ;
                    $config['wordwrap'] 	= TRUE ;
					
					//Kirim ke lebih dari 1 email
					//$emailto = array($param['email'], 'log@bisanego.co.id');
					
					$emailto = array($param['email']);
					foreach ($emailto as $key => $address) {
					
					$CI->email->set_mailtype("html");					
                    $CI->email->from("admin@bisanego.co.id", "Bisanego.co.id") ;
                    $CI->email->to($address);
                    $CI->email->subject($param['subject']) ;
					$data['message']		= $param['message'];
					$data['link'] 			= $param['link'];
					$html 					= $CI->load->view('web/email_newsletters', $data, TRUE);
                    $CI->email->message($html);

						if( $CI->email->send() ){
						
							//$CI->db->where('email_temp_id', $param['email_id']);
							//$CI->db->update('email_temp', array('email_status_id' => 1));
							
							$email_temp = array(
								'email_subject' 	=> $param['subject'],
								'email_desc' 		=> $param['message'],
								'email_from' 		=> "admin@bisanego.co.id",
								'email_to' 			=> $param['email'],
								'email_link'		=> $param['link'],
								'email_status_id' 	=> 1,
								'input_date' 		=> date('Y-m-d H:i:s')
							);
			
							$CI->db->insert('email_log', $email_temp);
							
							$CI->db->delete('email_temp', array('email_temp_id' => $param['email_id']) );
							
							
						}else{
							  //$CI->email->print_debugger();
							
							$CI->db->where('email_temp_id', $param['email_id']);
							$CI->db->update('email_temp', array('email_status_id' => 2));
							
						}
					}
				
 
	}
	
	function mail_capa( $param ) {
	// * Create Comment 22 Mei 2018
	// * Fungsi ini untuk mengirim email CAPA
	
			$CI =& get_instance();
			
			$config = array();
			$link_capa					= $param['link_capa'];
			$subject					= $param['subject'];
			$email						= $param['email'];
/*
				$config = array(
				'protocol' 	=> 'smtp', 
				'smtp_host' => 'ssl://smtp.googlemail.com', 
				'smtp_port' => 465, 
				'smtp_user' => 'anggietriejast@gmail.com',
				'smtp_pass' => 'intannuraeni01',
				'mailtype'	=> 'html', 
				'charset' 	=> 'utf-8', //'utf-8', 
				'newline' 	=> "\r\n",
				//'crlf'		=> "\r\n",				
				'wordwrap' 	=> TRUE 
				);

			
			$config = array(
				'protocol'		=> 'smtp', 
				'smtp_host' 	=> 'mail.cahayajakarta.com', //'213.229.83.3',
				'smtp_port' 	=> '26', 
				'smtp_user' 	=> 'support@cayahajakarta.com',
				'smtp_pass' 	=> 'c4hayajkt',
				'smtp_timeout' 	=> '30',
				'mailtype'		=> 'html', 
				'charset' 		=> 'utf-8', //'iso-8859-1', //'utf-8', 
				//'newline' 		=> "\r\n",
				//'crlf'		=> "\r\n",				
				'wordwrap' 		=> FALSE 
				);
			*/

				//$CI->email->initialize($config);
				//$CI->load->library('email', $config);
				$CI->load->library('email');
				//$CI->email->set_newline("\r\n");
				$CI->email->from('support@cahayajakarta.com', "IT Dept - Cahaya Jakarta");
				$CI->email->to($email);
				$CI->email->subject($subject);
				$text = $link_capa;
				$text .= "<br>";
				$text .= "<br>";
				$text .= "<br>";
				$text .= "<br>==============================================================================================";
				$text .= "<br>PLEASE Do not reply to e-mails, BECAUSE e-mails are sent Automatically By System.";
				$text .= "<br>==============================================================================================";
				$CI->email->message($text);
				if ( !$CI->email->send()) {
						show_error($CI->email->print_debugger());
					}
	}
	
	function mail_capa_rep( $param ) {
	// * Create Comment 22 Mei 2018
	// * Fungsi ini untuk mengirim email CAPA
	
			$CI =& get_instance();
			
			$config = array();
			$email		= $param['email'];
			$attach		= $param['id_capa'];
			$id_user	= $param['id_user'];
			$field		= $param['field'];
			
			$encode = gie_encode($attach . '-' . $id_user . '-' . $field);
				$CI->load->library('email');
				$CI->email->from('support@cahayajakarta.com', "IT Dept - Cahaya Jakarta");
				$CI->email->to($email);
				$CI->email->subject('CORRECTIVE AND PREVENTIVE ACTION');
				$CI->email->attach(base_url('qms/form_capa') . '/' . $attach, 'attachment', $attach . '.pdf');
				$text = "Mohon klik link berikut untuk menandatangani dokumen capa " . str_replace("_", "/", $attach) . "<br> <a href='http://192.168.30.21/cmis/qms/acc/index/" . $encode ."'>Link</a>";
				$CI->email->message($text);
				if ( !$CI->email->send()) {
						show_error($CI->email->print_debugger());
					}
	}
	
	function mail_message( $param ) {
	// * Create Comment 22 Mei 2018
	// * Fungsi ini untuk mengirim email NonConfirmity ( NC ) dan CAPA
	
			$CI =& get_instance();
			
			$config = array();
			$email		= $param['email'];
			$text		= $param['text'];
			$subject	= $param['subject'];
			
			
				$CI->load->library('email');
				$CI->email->from('support@cahayajakarta.com', "IT Dept - Cahaya Jakarta");
				$CI->email->to($email);
				$CI->email->subject( $subject );
				//$CI->email->attach(base_url('qms/form_capa') . '/' . $attach, 'attachment', $attach . '.pdf');
				//$text = $text;
				$CI->email->message($text);
				if ( !$CI->email->send()) {
						show_error($CI->email->print_debugger());
					}
	}
	
	function mail_nc( $param ) {
	// * Create Comment 22 Mei 2018
	// * Fungsi ini untuk mengirim email NonConfirmity ( NC )
	
			$CI =& get_instance();
			
			$config = array();
			$text_email					= $param['text'];
			$subject					= $param['subject'];
			$email						= $param['email'];

				$CI->load->library('email');
				$CI->email->from('support@cahayajakarta.com', "IT Dept - Cahaya Jakarta");
				$CI->email->to($email);
				$CI->email->subject($subject);
				$text = $text_email;
				$text .= "<br>";
				$text .= "<br>";
				$text .= "<br>";
				$text .= "<br>==============================================================================================";
				$text .= "<br>PLEASE Do not reply to e-mails, BECAUSE e-mails are sent Automatically By System.";
				$text .= "<br>==============================================================================================";
				$CI->email->message($text);
				if ( !$CI->email->send()) {
						show_error($CI->email->print_debugger());
					}
	}
	
	function mail_dev( $param ) {
	// * Create Comment 22 Mei 2018
	// * Fungsi ini untuk mengirim email Order Development atau FAD
	
			$CI =& get_instance();
			
			$config = array();
			$link_dev					= $param['link_dev'];
			$subject					= $param['subject'];
			$email						= $param['email'];
			$cc							= $param['cc'];


				//$CI->email->initialize($config);
				//$CI->load->library('email', $config);
				$CI->load->library('email');
				//$CI->email->set_newline("\r\n");
				$CI->email->from('support@cahayajakarta.com', "IT Dept - Cahaya Jakarta");
				//$CI->email->to($email);
				$CI->email->to('andi.a@cahayajakarta.com, anggiyawan@cahayajakarta.com');
				if ( $cc != '' ) {
						$CI->email->cc( $cc ) ;
				}
				$CI->email->subject($subject);
				
				$text = $link_dev;
				$text .= "<br>";
				$text .= "<br>";
				$text .= "<br>";
				$text .= "<br>=========================================================================================";
				$text .= "<br>PLEASE Do not reply to e-mails, BECAUSE e-mails are sent Automatically By System.";
				$text .= "<br>=========================================================================================";
				
				
				$CI->email->message($text);
				if ( !$CI->email->send()) {
						show_error($CI->email->print_debugger());
					}
	}
	
	function mail_rma( $param ) {
	// * Create Comment 22 Mei 2018
	// * Fungsi ini untuk mengirim email RMA Online
	
			$CI =& get_instance();
			
			$config = array();
			$email		= $param['email'];
			$text_email	= $param['text'];
			$subject	= $param['subject'];
			$cc			= 'anggiyawan@cahayajakarta.com, andi.a@cahayajakarta.com';
			
			
				$CI->load->library('email');
				$CI->email->from('support@cahayajakarta.com', "IT Dept - Cahaya Jakarta");
				$CI->email->to($email);
				if ( $cc != '' ) {
						$CI->email->cc($cc) ;
				}
				$CI->email->subject( $subject );
				//$CI->email->attach(base_url('qms/form_capa') . '/' . $attach, 'attachment', $attach . '.pdf');
				$text = $text_email;
				$text .= "<br>";
				$text .= "<br>";
				$text .= "<br>";
				$text .= "==============================================================================================";
				$text .= "<br>PLEASE Do not reply to e-mails, BECAUSE e-mails are sent Automatically By System.";
				$text .= "<br>==============================================================================================";
				$CI->email->message($text);
				if ( !$CI->email->send()) {
						show_error($CI->email->print_debugger());
					}
	}
	
	function sendmail_group( $id_rep ) {
		$CI =& get_instance();
			
		$sql = "SELECT email FROM tbl_rep WHERE id_rep='" . $id_rep . "'";
		$query = $CI->db->query($sql);
		if ( $query->num_rows() > 0 ) {
			foreach ( $query->result() as $data ) {}
			
			return $data->email;
		} else {
			$sql_group = "SELECT email FROM tbl_rep WHERE group_rep='" . $id_rep . "'";
			$query_group = $CI->db->query($sql_group);
			if ( $query_group->num_rows() > 0 ) {
				
				$group = "";
				foreach ( $query_group->result() as $key => $data_group) {
					if ( $key != 0 ){
					$group .= ", ";
					}
					$group .= $data_group->email;
				}
				return $group;
			}
		}
	
	}
	
	function mail_cost( $param ) {
			$CI =& get_instance();
			
			$config = array();
			//$email		= 'staff.acct@cahayajakarta.com'; //$param['email'];
			//$cc			= 'ewy.tjhin@cahayajakarta.com, khoe.theresia@cahayajakarta.com, karel.inaray@theia.id, novi@cahayajakarta.co.id, andi.a@cahayajakarta.com';
			//$email		= 'anggiyawan@cahayajakarta.com, andi.a@cahayajakarta.com'; //$param['email'];
			$email		= 'anggiyawan@cahayajakarta.com'; //$param['email'];
			$attach		= $param['attach'];
			$field		= 'Sales Intercompany Report generate otomatis dari CERM'; //$param['field'];
			
		
				$CI->load->library('email');
				$CI->email->from('support@cahayajakarta.com', "IT Dept - Cahaya Jakarta");
				$CI->email->to($email);
				if ( $cc != '' ) {
						$CI->email->cc($cc) ;
				}
				$CI->email->subject('SALES INTERCOMPANY REPORT');
				$CI->email->attach(base_url('uploads/cost') . '/' . $attach, 'attachment', $attach . '.pdf');
				$text = $field;
				$text .= "<br>";
				$text .= "<br>";
				$text .= "<br>";
				$text .= "==============================================================================================";
				$text .= "<br>PLEASE Do not reply to e-mails, BECAUSE e-mails are sent Automatically By System.";
				$text .= "<br>==============================================================================================";
				$CI->email->message($text);
				if ( !$CI->email->send()) {
						show_error($CI->email->print_debugger());
					}
	}
	
	function mail_cost_all( $param ) {
	// * Create Comment 22 Mei 2018
	// * Fungsi ini untuk mengirim email Intercompany
	
			$CI =& get_instance();
			
			$config = array();
			$email		= 'staff.acct@cahayajakarta.com'; //$param['email'];
			$cc			= 'ewy.tjhin@cahayajakarta.com, khoe.theresia@cahayajakarta.com, karel.inaray@theia.id, novi@cahayajakarta.co.id, andy.william@theia.id, danny.lim@theia.id, andi.a@cahayajakarta.com, anggiyawan@cahayajakarta.com';
			
			//$email		= 'anggiyawan@cahayajakarta.com, andi.a@cahayajakarta.com'; //$param['email'];
			// $email		= 'anggiyawan@cahayajakarta.com'; //$param['email'];
			$attach01		= $param['attach01'];
			$attach02		= $param['attach02'];
			$field		= 'Sales Intercompany Report'; //$param['field'];
			
		
				$CI->load->library('email');
				$CI->email->from('support@cahayajakarta.com', "IT Dept - Cahaya Jakarta");
				$CI->email->to($email);
				if ( $cc != '' ) {
						$CI->email->cc($cc) ;
				}
				$CI->email->subject('SALES INTERCOMPANY REPORT');
				$CI->email->attach(base_url('uploads/cost') . '/' . $attach01, 'attachment', $attach01 . '.pdf');
				$CI->email->attach(base_url('uploads/cost') . '/' . $attach02, 'attachment', $attach02 . '.pdf');
				$text = $field;
				$text .= "<br>";
				$text .= "<br>";
				$text .= "<br>";
				$text .= "==============================================================================================";
				$text .= "<br>PLEASE Do not reply to e-mails, BECAUSE e-mails are sent Automatically By System.";
				$text .= "<br>==============================================================================================";
				$CI->email->message($text);
				if ( !$CI->email->send()) {
						show_error($CI->email->print_debugger());
					}
	}
	
	
	function mail_stock_fg( $param ) {
	// * Create Comment 22 Mei 2018
	// * Fungsi ini untuk mengirim email stock FinishedGood
	
			$CI =& get_instance();
			
			$config = array();
			$email		= 'anggiyawan@cahayajakarta.com, andi.a@cahayajakarta.com'; //$param['email'];
			$cc			= 'anggietriejast@gmail.com';
			
			// $email		= 'khoe.theresia@cahayajakarta.com'; //$param['email'];
			// $cc		= 'ewy.tjhin@cahayajakarta.com, lusiana.peni@cahayajakarta.com, andi.a@cahayajakarta.com, anggiyawan@cahayajakarta.com, anggietriejast@gmail.com'; //$param['email'];
			
			$attach01		= $param['attach01'];
			$attach02		= $param['attach02'];
			// $field		= '[TEST] Note :<br>'; //$param['field'];
			$field		= 'Inventory Report'; //$param['field'];
			
		
				$CI->load->library('email');
				$CI->email->from('support@cahayajakarta.com', "IT Dept - Cahaya Jakarta");
				$CI->email->to($email);
				if ( $cc != '' ) {
						$CI->email->cc($cc) ;
				}
				$CI->email->subject('Inventory Report ' . date('Y-m-d '));
				$CI->email->attach(base_url('uploads/stock') . '/' . $attach01, 'attachment', $attach01 . '.xls');
				$CI->email->attach(base_url('uploads/stock') . '/' . $attach02, 'attachment', $attach02 . '.xls');
				$text = $field;
				// $text .= "Berikut cost yang ditampilkan adalah Cost per seribu, cost satuan dan sales price<br>";
				// $text .= "Cost satuan didapat dari ( (Cost perseribu * Quantity) / 1000 )";
				// $text .= "Sales Price didapat dari Harga jual per satuan";
				$text .= "<br>";
				$text .= "<br>";
				$text .= "<br>";
				$text .= "<br>";
				$text .= "<br>";
				$text .= "==============================================================================================";
				$text .= "<br>PLEASE Do not reply to e-mails, BECAUSE e-mails are sent Automatically By System.";
				$text .= "<br>==============================================================================================";
				$CI->email->message($text);
				if ( !$CI->email->send()) {
						show_error($CI->email->print_debugger());
					}
	}
	
	function mail_stock( $param ) {
	// * Create Comment 22 Mei 2018
	// * Fungsi ini untuk mengirim email stock material
	
			$CI =& get_instance();
			
			$config = array();
			
			if (date('d-m-Y H:i') >= date('t-m-Y 23:40') AND date('d-m-Y H:i') <= date('t-m-Y 23:48')) {
				
				$email		= 'khoe.theresia@cahayajakarta.com'; //$param['email'];
				$cc		= 'ewy.tjhin@cahayajakarta.com, lusiana.peni@cahayajakarta.com, andi.a@cahayajakarta.com, anggiyawan@cahayajakarta.com, anggietriejast@gmail.com'; //$param['email'];
			
			} else {
				
				$email		= 'andi.a@cahayajakarta.com, anggiyawan@cahayajakarta.com'; //$param['email'];
				$cc			= '';
				
			}
			
			
			
			$attach01		= $param['attach01'];
			$attach02		= $param['attach02'];
			$field		= 'Inventory Report'; //$param['field'];
			
		
				$CI->load->library('email');
				$CI->email->from('support@cahayajakarta.com', "IT Dept - Cahaya Jakarta");
				$CI->email->to($email);
				if ( $cc != '' ) {
						$CI->email->cc($cc) ;
				}
				$CI->email->subject('Inventory Report ' . date('Y-m-d '));
				$CI->email->attach(base_url('uploads/stock') . '/' . $attach01, 'attachment', $attach01 . '.xls');
				$CI->email->attach(base_url('uploads/stock') . '/' . $attach02, 'attachment', $attach02 . '.xls');
				$text = $field;
				$text .= "<br>";
				$text .= "<br>";
				$text .= "<br>";
				$text .= "<br>";
				$text .= "<br>";
				$text .= "<br>";
				$text .= "==============================================================================================";
				$text .= "<br>PLEASE Do not reply to e-mails, BECAUSE e-mails are sent Automatically By System.";
				$text .= "<br>==============================================================================================";
				$CI->email->message($text);
				if ( !$CI->email->send()) {
						show_error($CI->email->print_debugger());
					}
	}
	
	
}