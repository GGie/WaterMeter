<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends MX_Controller  {
	
	public function __construct()
	{
		// parent::__construct();
		// if ( !$this->session->userdata('is_login') ) {
				// redirect('login');
				// exit;
		// }
		// $this->load->helper('url');
		// $this->load->model('Setting_model');
		// $this->load->library('api/RestController');
		
		ini_set('set_time_limit', 0); 
		ini_set('max_execution_time', 0); 
		ini_set('memory_limit','2048M'); 
		// if (!$this->input->is_ajax_request()) exit('No direct script access allowed');
	}

	
	
	
	
	public function index()
	{
		
	}
	
	public function login()
	{
		$this->load->model('login/Login_m');
		$this->load->model('Tool/Tool_model');
		
			$data = file_get_contents('php://input');
			$result = json_decode($data, true);
		
			header('Content-Type: application/json');

			$uid 		= @$result["uid"];
			$signature 	= @$result["signature"];
			$user		= @$result["username"];
			$pass		= @$result["password"];
			
			try
			{
				if (!$result)
					throw new Exception("API KEY DATA");
				if (!$uid)
					throw new Exception("uid null.");
				if (!$signature)
					throw new Exception("signature null.");
				if (!$user)
					throw new Exception("user null.");
				if (!$pass)
					throw new Exception("pass null.");
				
				$secret = @$this->db->get_Where('user_api', array('uid'=>$uid))->row()->secret;
				$signatureGenerate	= hash('sha256', $uid . $secret . $user . $pass);
				
				if ($signature != $signatureGenerate)
					throw new Exception("Wrong Signature!!!");
				
				if ( $user AND $pass ) {		// Cek apakah user telah menginput username dan password
				$user_cek = $this->Login_m->cek_login($user, $pass);
				if ( $user_cek == 1 ) {
					$data = $this->Login_m->get_data_login($user, $pass);
					foreach ($data->result() as $data_login ) {

						//update lst login
						$paramLogin = array(
							'last_login'	=> date('Y-m-d H:i:s'),
						);
						$this->db->where('user_id',$data_login->user_id);
						$this->db->update('tbl_user', $paramLogin);
						
						$sess_array = array(
							'user_id' 		=> $data_login->user_id, 
							'username' 		=> $data_login->nmuser
						) ;
						$this->session->set_userdata($sess_array);
					
						//insert log ip address
						$this->Tool_model->ipaddress();
						$returnValue = json_encode(
												array(
													'status' => "00", 
													'message'=>'Success',
													'userid'=>$data_login->user_id,
													'username_login'=>$data_login->iduser,
													'username'=>$data_login->nmuser
												));
					}
				} elseif ( $user_cek == 2 ) {
					$returnValue = json_encode(array('status' => "01", 'message'=>'Account Disabled.'));
				} elseif ( $user_cek == 3 ) {
					$returnValue = json_encode(array('status' => "01", 'message'=>'Incorrect Password.'));
				} elseif ( $user_cek == 4 ) {
					$returnValue = json_encode(array('status' => "01", 'message'=>'Incorrect Username.'));
				} else {
					$returnValue = json_encode(array('status' => "01", 'message'=>'Incorrect Login.'));
				}
			} else {
				$returnValue = json_encode(array('status' => "01", 'message'=>'Username, Password Null'));
			}
		
				echo $returnValue;
		
			}
			
			catch(Exception $ex)
			{
				$data = array('status' => "01", "message" => $ex->getMessage());
				echo json_encode($data);
			}
			
	}
	
	
	public function customer()
	{
		$this->load->model('customer/customer_model');
		
			$data = file_get_contents('php://input');
			$result = json_decode($data, true);
		
			header('Content-Type: application/json');

			$uid 			= @$result["uid"];
			$signature 		= @$result["signature"];
			$customer_id	= @$result["customer_id"];
			$reference		= @$result["reference"];
			$time			= @$result["time"];
			
			try
			{
				if (!$result)
					throw new Exception("API KEY DATA");
				if (!$uid)
					throw new Exception("uid null.");
				if (!$signature)
					throw new Exception("signature null.");
				if (!$time)
					throw new Exception("time null.");
				// if ( !isset($customer_id) AND !isset($reference) )
					// throw new Exception("customer_id or Reference is Blank.");
				
				// if ( !empty($reference) )
				// {
					// $key = $reference;
				// } else {
					// $key = $customer_id;
				// }
				
				$secret = @$this->db->get_Where('user_api', array('uid'=>$uid))->row()->secret;
				$signatureGenerate	= hash('sha256', $uid . $secret . $time);
				
				if ($signature != $signatureGenerate)
					throw new Exception("Wrong Signature!!!");
				
					$getCustomer = $this->customer_model->get_customer(array('customer_id' => $customer_id, 'reference' => $reference));
					// var_dump($getCustomer->num_rows());
					if ( $getCustomer->num_rows() != 0 ) {
						
							$returnValue = json_encode(
												array(
													'status' => "00", 
													'message'=>'Success',
													'data'=> $getCustomer->result()
												));
					} else {
						$returnValue = json_encode(array('status' => "01", 'message'=>'Customer is Empty'));
					}

				echo $returnValue;
			
			} catch(Exception $ex)
			{
				$data = array('status' => "01", "message" => $ex->getMessage());
				echo json_encode($data);
			}
			
	}
	
	public function report()
	{
		$this->load->model('reportmeter/reportmeter_model');
		
			$data = file_get_contents('php://input');
			$result = json_decode($data, true);
		
			header('Content-Type: application/json');

			$uid 			= @$result["uid"];
			$signature 		= @$result["signature"];
			$customer_id	= @$result["customer_id"];
			$reference		= @$result["reference"];
			$period_id		= @$result["period_id"];
			$time			= @$result["time"];
			
			try
			{
				if (!$result)
					throw new Exception("API KEY DATA");
				if (!$uid)
					throw new Exception("uid null.");
				if (!$signature)
					throw new Exception("signature null.");
				if (!$time)
					throw new Exception("time null.");
				if (!$period_id)
					throw new Exception("period_id null.");
				// if ( !isset($customer_id) AND !isset($reference) )
					// throw new Exception("customer_id or Reference is Blank.");
				
				// if ( !empty($reference) )
				// {
					// $key = $reference;
				// } else {
					// $key = $customer_id;
				// }
				
				$secret = @$this->db->get_Where('user_api', array('uid'=>$uid))->row()->secret;
				$signatureGenerate	= hash('sha256', $uid . $secret . $time);
				
				if ($signature != $signatureGenerate)
					throw new Exception("Wrong Signature!!!");
				
					$getCustomer = $this->reportmeter_model->get_reportmeter(array('period_id' => $period_id, 'customer_id' => $customer_id, 'reference' => $reference));
					// var_dump($getCustomer->num_rows());
					if ( $getCustomer->num_rows() != 0 ) {
						
						// $count = 0;
						
						foreach ( $getCustomer->result() as $customer ) {
						
							$report = @get_report_meter($customer->customer_id, (int)$customer->period_id);
							$row[] = array(
								'id'					=> $customer->id,
								'reference'				=> $customer->reference,
								'customer_id'			=> $customer->customer_id,
								'customer_name'			=> strtoupper(str_replace("'", "", $customer->customer_name)),
								'kawasan'				=> strtoupper(str_replace("'", "", $customer->kawasan)),
								'area'					=> strtoupper(str_replace("'", "", $customer->area)),
								'address'               => strtoupper(str_replace("'", "", $customer->address)),
								// 'description'           => str_replace("'", "", $customer->description),
								'period_id'				=> (int)$customer->period_id,
								// 'period'				=> period($customer->period_id),
								'prev_initial_meter'    =>  (!$report) ? '0' : $report->initial_meter,
								'prev_final_meter'      => (!$report) ? '0' : $report->final_meter, //get_meter($customer->customer_id, (int)$customer->period_id, 'final_meter'),
								'prev_date_scan'		=> (!$report) ? '0' : $report->tglcreate, //get_meter($customer->customer_id, (int)$customer->period_id, 'tglcreate'),
								
								'initial_meter'         => (int)$customer->initial_meter,
								'final_meter'           => (int)$customer->final_meter,
								'status'				=> $customer->status,
							);
		
							// $count++;
						}
							$returnValue = json_encode(
												array(
													'status' => "00", 
													'message'=>'Success',
													'data'=> ($row),
													// 'row'=> ($count)
												));
					} else {
						$returnValue = json_encode(array('status' => "01", 'message'=>'Report is Empty'));
					}

				
			
			} catch(Exception $ex)
			{
				$returnValue = json_encode(array('status' => "01", "message" => $ex->getMessage()));
			}
			
			echo $returnValue;
			
	}
	
	
	public function period()
	{
		$this->load->model('period/period_model');
		
			$data = file_get_contents('php://input');
			$result = json_decode($data, true);
		
			header('Content-Type: application/json');

			$uid 			= @$result["uid"];
			$signature 		= @$result["signature"];
			$method		    = @$result["method"];
			$time			= @$result["time"];
			
			try
			{
				if (!$result)
					throw new Exception("API KEY DATA");
				if (!$uid)
					throw new Exception("uid null.");
				if (!$signature)
					throw new Exception("signature null.");
				if (!$time)
					throw new Exception("time null.");
				if (!$method)
					throw new Exception("method null.");
				// if ( !isset($customer_id) AND !isset($reference) )
					// throw new Exception("customer_id or Reference is Blank.");
				
				// if ( !empty($reference) )
				// {
					// $key = $reference;
				// } else {
					// $key = $customer_id;
				// }
				
				// $secret = @$this->db->get_Where('user_api', array('uid'=>$uid))->row()->secret;
				// $signatureGenerate	= hash('sha256', $uid . $secret . $time);
				$signatureGenerate	= hash('sha256', "10005" . "2b261a8987c004580e24c2d8137485b425b6a0170257447b6745edaa6c073f8f" . $time);
				if ($signature != $signatureGenerate)
					throw new Exception("Wrong Signature!!!");
            	
            	if ($method == 'active')
					$status = 1;
				else if ($method == 'all')
					$status = "";
				else
					$status = 99;
            		
            		
					$getPeriod = $this->period_model->get_period(array('status' => $status, 'limit' => 5));
					// var_dump($getCustomer->num_rows());
					if ( $getPeriod->num_rows() != 0 ) {
					    
							$returnValue = json_encode(
												array(
													'status' => "00", 
													'message'=>'Success',
													'data'=> $getPeriod->result()
												));
					} else {
						$returnValue = json_encode(array('status' => "01", 'message'=>'Period is Empty'));
					}
			
			} catch(Exception $ex)
			{
				$returnValue = json_encode(array('status' => "01", "message" => $ex->getMessage()));
			}
			
		/*
		$month = date('Y-m');
		
		// create dir logs
		if (!is_dir('logs'))
		  mkdir('logs');
	  
		// create dir logs -> month
		if (!is_dir('logs/' . $month)) 
		  mkdir('logs/' . $month);
	  
		file_put_contents('logs/' .$month. '/LOG_' . date('Ymd') . '.txt', "Date: " . date('Y-m-d H:i:s') .  " \r", FILE_APPEND | LOCK_EX);
		file_put_contents('logs/' .$month. '/LOG_' . date('Ymd') . '.txt', "request period : " . json_encode($result) . " \r", FILE_APPEND | LOCK_EX);
		file_put_contents('logs/' .$month. '/LOG_' . date('Ymd') . '.txt', "response period : " . ($returnValue) . " \r\n\r\n", FILE_APPEND | LOCK_EX);
		*/
		
		echo $returnValue;
			
	}
	
	public function savemeter()
	{
		$this->load->model('reportmeter/reportmeter_model');
		
			$data = file_get_contents('php://input');
			$result = json_decode($data, true);
			$log = "";
		
			header('Content-Type: application/json');

			$uid 			= @$result["uid"];
			$signature 		= @$result["signature"];
			$id	            = @$result["id"];
			$status         = @$result["status"];
			$period_id      = @$result["period_id"];

			$tglcreate      = @$result["tglcreate"];
			$description    = @$result["description"];
			$initial_meter  = @$result["initial_meter"];
			$final_meter    = @$result["final_meter"];
			$imgfile        = @$result["imgfile"];
			$imgfile_2      = @$result["imgfile_2"];
			$userid         = @$result["userid"];
			
			try
			{
				
				if (!$result)
					throw new Exception("API KEY DATA");
				if (!$uid)
					throw new Exception("uid null.");
				if (!$signature)
					throw new Exception("signature null.");
				if ( !isset($id) )
					throw new Exception("id is null.");
				if ( !isset($status) )
					throw new Exception("status is null.");
				if ( $status != 2 AND $status != 3 AND $status != 4 ) //2 = pending/ispending, 3 = open/belum discan	4 = sudah discan ( status di server )
					throw new Exception("status allow is 2, 3 OR 4.");
				if ( !isset($period_id) )
					throw new Exception("period_id is null.");
				if ( !isset($tglcreate) )
					throw new Exception("tglcreate is null.");
				
				if ( !isset($initial_meter) )
					throw new Exception("Initial_meter is null.");
				if ( !isset($final_meter) )
					throw new Exception("Final_meter is null.");
				//if ( $final_meter == 0 )
					//throw new Exception("Final_meter is 0.");
				if ( !isset($userid) )
					throw new Exception("userid is null.");
				
				// if (!$this->validateBase64Image($imgfile)) {
					// throw new Exception("Not a valid base64 string");
				// }
				
				$secret = @$this->db->get_Where('user_api', array('uid'=>$uid))->row()->secret;
				$signatureGenerate	= hash('sha256', $uid . $secret . $id);
				// $signatureGenerate	= hash('sha256', "10005" . "2b261a8987c004580e24c2d8137485b425b6a0170257447b6745edaa6c073f8f" . $id);
				
				if ($signature != $signatureGenerate)
					throw new Exception("Wrong Signature!!!");
				
					$getReport = $this->reportmeter_model->get_reportmeter(array('id' => $id, 'period_id' => $period_id));
					
					if ( $getReport->num_rows() <= 0 )
						throw new Exception("Report is Empty.");
					
					if ( $getReport->row()->status == 1 )
					    throw new Exception("report is approved.");
					    
					// if ($customer_id != "" AND $getReport->row()->customer_id != $customer_id)
						// throw new Exception("customer_id does not match!!!");
					
					
					//$param["customer_id"] 	    = $getReport->row()->customer_id;
					//$param["customer_name"]     = $getReport->row()->customer_name;
					//$param["reference"] 	    = $getReport->row()->reference;
					//$param["area"] 			    = $getReport->row()->area;
					//$param["address"] 		    = $getReport->row()->address;
					$param["id"]	            = $id;
					$param["status"]	        = $status;
					$param["initial_meter"]	    = $initial_meter;
					$param["final_meter"]	    = $final_meter;
					$param["tglcreate"]	        = $tglcreate; //date('Y-m-d H:i:s');
					$param["userid"]	        = $userid;
					
					// $log .= $getReport->row()->reference . ", ";
					$sess_array = array(
							'user_id' 		=> $userid, 
						) ;
					$this->session->set_userdata($sess_array);
					
					if ( isset($description) )
						$param["description"] = $description;
					
					if ( $this->reportmeter_model->APIupdate_reportmeter($param) ) {
									
							if ( isset($imgfile) ) {
								$this->unggah_gambar($id, $userid, "METER", $tglcreate, $imgfile);
							}
							
							if ( isset($imgfile_2) ) {
								$this->unggah_gambar($id, $userid, "UNIT", $tglcreate, $imgfile_2);
							}
							
							$returnValue = json_encode(
													array(
														'status' => "00", 
														'message'=>'Success'
													));
						
					} else {
						$returnValue = json_encode(array('status' => "01", 'message'=>'Failed To Save'));
					}
			
			} catch(Exception $ex)
			{
				$returnValue = json_encode(array('status' => "01", "message" => $ex->getMessage()));
			}
		/*
		$month = date('Y-m');
		
		//create dir logs
		if (!is_dir('logs'))
		  mkdir('logs');
	  
		//create dir logs -> month
		if (!is_dir('logs/' . $month)) 
		  mkdir('logs/' . $month);
	  
		file_put_contents('logs/' .$month. '/LOG_' . date('Ymd') . '.txt', "Date: " . date('Y-m-d H:i:s') . " UserID: " . @$userid . " \r", FILE_APPEND | LOCK_EX);
		file_put_contents('logs/' .$month. '/LOG_' . date('Ymd') . '.txt', "savemeter reference: " . @$log . " \r\n\r\n", FILE_APPEND | LOCK_EX);
		file_put_contents('logs/' .$month. '/LOG_' . date('Ymd') . '.txt', "request savemeter: " . @$data . " \r\n\r\n", FILE_APPEND | LOCK_EX);
		*/
		// $returnValue = json_encode(
													// array(
														// 'status' => "00", 
														// 'message'=>'Success'
													// ));
		echo $returnValue;
			
	}
	
	public function description()
	{
		$this->load->model('description/description_model');
		
			$data = file_get_contents('php://input');
			$result = json_decode($data, true);
		
			header('Content-Type: application/json');

			$uid 			= @$result["uid"];
			$signature 		= @$result["signature"];
			$time			= @$result["time"];
			
			try
			{
				if (!$result)
					throw new Exception("API KEY DATA");
				if (!$uid)
					throw new Exception("uid null.");
				if (!$signature)
					throw new Exception("signature null.");
				if (!$time)
					throw new Exception("time null.");
				// if ( !isset($customer_id) AND !isset($reference) )
					// throw new Exception("customer_id or Reference is Blank.");
				
				// if ( !empty($reference) )
				// {
					// $key = $reference;
				// } else {
					// $key = $customer_id;
				// }
				
				$secret = @$this->db->get_Where('user_api', array('uid'=>$uid))->row()->secret;
				$signatureGenerate	= hash('sha256', $uid . $secret . $time);
				
				if ($signature != $signatureGenerate)
					throw new Exception("Wrong Signature!!!");
				
					$getDescription = $this->description_model->get_description();
					// var_dump($getCustomer->num_rows());
					if ( $getDescription->num_rows() != 0 ) {
						
							$returnValue = json_encode(
												array(
													'status' => "00", 
													'message'=>'Success',
													'data'=> $getDescription->result()
												));
					} else {
						$returnValue = json_encode(array('status' => "01", 'message'=>'Description is Empty'));
					}

				echo $returnValue;
			
			} catch(Exception $ex)
			{
				$data = array('status' => "01", "message" => $ex->getMessage());
				echo json_encode($data);
			}
			
	}
	
	private function validateBase64Image($Base64Image){
		$base64 = str_replace('data:image/png;base64,', '', $Base64Image);
		// $regx = '~^([A-Za-z0-9+/]{4})*([A-Za-z0-9+/]{4}|[A-Za-z0-9+/]{3}=|[A-Za-z0-9+/]{2}==)$~';

		// if ((substr($Base64Image, 0, 22)) !== 'data:image/png;base64,')
		// {
		  ////Obviously fake, doesn't contain the expected first 22 characters.
		  // return false;
		// }

		if ((base64_encode(base64_decode($base64, true))) !== $base64)
		{
		  // Decoding and re-encoding the data fails, something is wrong
		  return false;
		}

		// if ((preg_match($regx, $base64)) !== 1) 
		// {
		  ////The data doesn't match the regular expression, discard
		  // return false;
		// }

		return true;
	}
	
	private function unggah_gambar( $reportId, $userid, $type, $tglcreate, $base64img = "" )
    {
    	$this->load->helper('string');
		$random = strtoupper(random_string('alnum', 6));
		
		try {
			$images = $base64img;
			$time = round(microtime(true) * 1000);
			$name = $reportId . "-" . $type . "-" . $time . "-" . $random . ".png";
			$ImagePath = "./upload/reportmeter/" . $name;
			
			if($base64img != ""){
				file_put_contents($ImagePath,base64_decode($base64img));
				//$this->reportmeter_model->watermark($ImagePath, $tglcreate);
				
				$this->reportmeter_model->delete_imagefile($reportId, $type);
				$database = array(
 						'water_meter_report_id' => $reportId,
						'image_name'	=> $name,
						'image_url' 	=> $ImagePath,
						'image_type' 	=> $type,
						'id_status' 	=> 1,
						'input_by' 		=> $userid,
						'input_date' 	=> date('Y-m-d H:i:s')
					);

				$this->db->insert('image_file', $database);
			}
				
			} catch(Exception $ex)
			{
				return false;
			}
		
		
	}
	
	function set_unggah_gambar($max_width, $max_height, $source_file, $dst_dir, $quality = 80){
	    $imgsize = getimagesize($source_file);
	    $width = $imgsize[0];
	    $height = $imgsize[1];
	    $mime = $imgsize['mime'];
	 
	    switch($mime){
	        case 'image/gif':
	            $image_create = "imagecreatefromgif";
	            $image = "imagegif";
	            break;
	 
	        case 'image/png':
	            $image_create = "imagecreatefrompng";
	            $image = "imagepng";
	            $quality = 7;
	            break;
	 
	        case 'image/jpeg':
	            $image_create = "imagecreatefromjpeg";
	            $image = "imagejpeg";
	            $quality = 80;
	            break;
	 
	        default:
	            return false;
	            break;
	    }
	     
	    $dst_img = imagecreatetruecolor($max_width, $max_height);
	    $src_img = $image_create($source_file);
	     
	    $width_new = $height * $max_width / $max_height;
	    $height_new = $width * $max_height / $max_width;
	    //if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
	    if($width_new > $width){
	        //cut point by height
	        $h_point = (($height - $height_new) / 2);
	        //copy image
	        imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
	    }else{
	        //cut point by width
	        $w_point = (($width - $width_new) / 2);
	        imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
	    }
	     
	    $image($dst_img, $dst_dir, $quality);
	 
	    if($dst_img)imagedestroy($dst_img);
	    if($src_img)imagedestroy($src_img);
	}

	
}
