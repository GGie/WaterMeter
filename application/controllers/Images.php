<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Images extends MX_Controller
{
 
    // function __construct()
    // {
        // parent::__construct();
    // }

	function index(){
		$this->load->helper('string');
		echo strtoupper(random_string('alnum', 6));
	}
	
	function delete_images(){
		header('Content-Type: application/json');

		$loop = 100;
		$returnValue = json_encode(array('status' => "01", 'message'=>'Failed To Delete'));
		
		$images = $this->db->query("SELECT input_date, image_id, water_meter_report_id, image_url, image_name, id_status, gdrive FROM image_file as a WHERE id_status=0 AND gdrive='' LIMIT " . $loop);
		
		//delete image yg status water_meter_report masih open
		// $images = $this->db->query("SELECT a.input_date, a.image_id, a.water_meter_report_id, a.image_url, a.image_name, a.id_status, a.gdrive FROM image_file as a INNER JOIN water_meter_report as b ON a.water_meter_report_id=b.id WHERE b.status=3 AND a.gdrive='' LIMIT " . $loop);
		
		if ( $images->num_rows() > 0 ) {
			foreach ( $images->result() as $img ) {
			
				$nama = $img->image_name;
				$param = array(
					'id'					=> $img->image_id,
					'water_meter_report_id'	=> $img->water_meter_report_id,
					'image_url'				=> $img->image_url,
					'image_name'			=> $nama,
					'gdrive'				=> $img->gdrive,
					'date'					=> date('Y-m-d H:i:s'),
				);
					
				if ( file_exists($img->image_url) ){
					unlink($img->image_url);
					log_users(json_encode($param));
					$returnValue = json_encode(array('status' => "00", 'message'=>'Image Berhasil Dihapus', 'data' => ($param) ));
				} else {
					$returnValue = json_encode(array('status' => "01", 'message'=>'Image File Not Exist', 'data' => ($param) ));
				}
				

				$update = array(
					'id_status'	=> 99,
				);
				$this->db->where('image_id', $img->image_id);
				$this->db->update('image_file', $update);
			}
		}
		
		echo $returnValue;
	}
	
	function delete_imagesBACKUP(){
		header('Content-Type: application/json');
		// $secret = @$this->db->get_Where('site_options', array('active'=>true, 'option_name'=>'GDRIVE'))->row();
		// $return = json_decode(@$secret->option_value, true);
		
		// echo $return['reportmeter_folder_id'];
		// error_log("No secret active");
		// header('Content-type: image/png');
		
		// $param['client_email']				= $return['client_email'];//'suryamultiabadi@suryamultiabadi.iam.gserviceaccount.com';
		// $param['private_key']				= $return['private_key'];//'suryamultiabadi-bfff54107c03.p12';
		// $this->download($param, "16G_DWjZoUABlPl935PzsTvhuIfu4GYo4");
		$loop = 100;
		$returnValue = json_encode(array('status' => "01", 'message'=>'Failed To Delete'));
		
		// $images = $this->db->query("SELECT input_date, image_id, water_meter_report_id, image_url, image_name, id_status, gdrive FROM image_file as a WHERE id_status=0 AND gdrive='' LIMIT " . $loop);
		
		//delete image yg status water_meter_report masih open
		$images = $this->db->query("SELECT a.input_date, a.image_id, a.water_meter_report_id, a.image_url, a.image_name, a.id_status, a.gdrive FROM image_file as a INNER JOIN water_meter_report as b ON a.water_meter_report_id=b.id WHERE b.status=3 AND a.gdrive='' LIMIT " . $loop);
		
		if ( $images->num_rows() > 0 ) {
			foreach ( $images->result() as $img ) {
			
				$nama = $img->water_meter_report_id . "-" . $img->image_name . ".png";
				$param = array(
					'id'					=> $img->image_id,
					'water_meter_report_id'	=> $img->water_meter_report_id,
					'image_url'				=> $img->image_url,
					'image_name'			=> $nama,
					'gdrive'				=> $img->gdrive,
					'date'					=> date('Y-m-d H:i:s'),
				);
					
				if ( file_exists($img->image_url) ){
					unlink($img->image_url);
					// log_users(json_encode($param));
					$returnValue = json_encode(array('status' => "00", 'message'=>'Image Berhasil Dihapus', 'data' => ($param) ));
				} else {
					$returnValue = json_encode(array('status' => "01", 'message'=>'Image File Not Exist', 'data' => ($param) ));
				}
				
				$this->db->where('image_id', $img->image_id);
				$this->db->delete('image_file');

				// $update = array(
					// 'id_status'	=> 99,
				// );
				// $this->db->where('image_id', $img->image_id);
				// $this->db->update('image_file', $update);
			}
		}
		
		echo $returnValue;
	}
	
	function sync(){
		$returnValue = json_encode(array('status' => "01", 'message'=>'Failed To Sync'));
		
		try
		{
				
			$images = $this->db->query("SELECT image_id, water_meter_report_id, image_url, image_name, id_status FROM image_file as a WHERE id_status=1 LIMIT 1");
			
			if ( $images->num_rows() > 0 ) {
				$file = base_url( str_replace("./", "", $images->row()->image_url) );
				
				if ( file_exists($images->row()->image_url) ){
					// echo $file;
					$nama = $images->row()->image_name;
					
					//config secret
					$secret = @$this->db->get_Where('site_options', array('active'=>true, 'option_name'=>'GDRIVE'))->row();
					$return = json_decode(@$secret->option_value, true);
					
					$param['client_email']				= $return['client_email'];
					$param['private_key']				= $return['private_key'];
					$param['reportmeter_folder_id']		= $return['reportmeter_folder_id'];
					
					//config secret
					$response = $this->upload($param, $nama, $file);
					$result = json_decode($response);
					
					if ( $result->status == "00" ) {
						// update gdrive
						$this->db->trans_begin();
						$update = array(
							'option_id'	=> @$secret->option_id,
							'gdrive'	=> $result->data->id,
							'id_status'	=> 2,
						);
						$this->db->where('image_id', $images->row()->image_id);
						$this->db->update('image_file', $update);
						
						if ($this->db->trans_status() === FALSE){
							$this->db->trans_rollback();
							return false;
						}else{
							$this->db->trans_commit();
							// return true;
							
							$param = array(
								'id'					=> $images->row()->image_id,
								'water_meter_report_id'	=> $images->row()->water_meter_report_id,
								'image_url'				=> $images->row()->image_url,
								'image_name'			=> $nama,
								'gdrive'				=> $result->data->id,
								'date'					=> date('Y-m-d H:i:s'),
							);
							log_users(json_encode($param));
							
							//create dir
							if (!is_dir('upload')) 
							  mkdir('upload');
						  
							if (!is_dir('upload/backup')) 
							  mkdir('upload/backup');
						  
							rename('upload/reportmeter/' . $nama, "./upload/backup/" . $nama);
							$returnValue = json_encode(array('status' => "00", 'message'=>'Success'));
						}
						//update gdrive EOF
					} else {
						$returnValue = json_encode(array('status' => "01", "message" => $result->data));
					}
					
				} else {
					
					// update gdrive
					$this->db->trans_begin();
					$update = array(
						'gdrive'	=> "",
						'id_status'	=> 2,
					);
					$this->db->where('image_id', $images->row()->image_id);
					$this->db->update('image_file', $update);
					
					if ($this->db->trans_status() === FALSE){
						$this->db->trans_rollback();
					}else{
						$this->db->trans_commit();
					}
					$returnValue = json_encode(array('status' => "01", "message" => "image_url File Not Exist"));
				}
				
			} else {
				$returnValue = json_encode(array('status' => "01", "message" => "Not File To Sync"));
			}
		
		} catch(Exception $ex)
		{
			$returnValue = json_encode(array('status' => "01", "message" => $ex->getMessage()));
		}
		
		echo $returnValue;
	}
	
	function getImages($type, $id){
		
		try
		{
			
			header('Content-type: image/png');
			
			$images = $this->db->query("SELECT image_url, option_id, gdrive, id_status FROM image_file as a WHERE water_meter_report_id={$id} AND image_type='{$type}' AND id_status!=0 AND id_status!=99");
			
			if ( $images->num_rows() > 0 ) {
				
				if ( $images->row()->id_status == 1 ) {
					if ( !file_exists($images->row()->image_url) )
						throw new Exception();

					$file = base_url( str_replace("./", "", $images->row()->image_url) );
					$img = imagecreatefromjpeg($file);
					imagejpeg($img);
				} else if ( $images->row()->id_status == 2 AND !empty($images->row()->gdrive) ) {
					// $secret = @$this->db->get_Where('site_options', array('active'=>true, 'option_name'=>'GDRIVE'))->row();
					$secret = @$this->db->get_Where('site_options', array('option_id'=>$images->row()->option_id))->row();
					$return = json_decode(@$secret->option_value, true);
					
					//belum dibenerin
					$param['client_email']				= $return['client_email'];
					$param['private_key']				= $return['private_key'];
		
					$this->download($param, $images->row()->gdrive);
				} else { 
					throw new Exception();
				}
				
			} else {
				throw new Exception();
			}
			
		} catch(Exception $ex)
		{
			$file = base_url("upload/reportmeter/noimage.png");
			$img = imagecreatefrompng($file);
			imagepng($img);
		}
	}
	
	
	function upload($param, $namafile = "", $imgurl = ""){
		// if ( !$this->session->userdata('is_login') )
			// exit;
		
		if ( empty($namafile) )
			exit;
		if ( empty($imgurl) )
			exit;
			
        $this->load->library('google_drive', $param);
        // $this->config->load('google_drive');

        $createFile = $this->google_drive->insertFile(
            $namafile, 
            "image/png", 
            $param['reportmeter_folder_id'],
            $imgurl
            );
			
			return json_encode($createFile);
    }
	
	function download($param, $drive_id = ""){
        $this->load->library('google_drive', $param);
        // $this->config->load('google_drive');
		// $this->load->helper('download');

        $this->google_drive->downloadFile($drive_id);
    }
	
}