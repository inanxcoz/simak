<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."libraries/AdminController.php");
class Me extends AdminController {

	var $front_menu = '';
	function __construct()
	{
		parent::__construct(); 
		$this->_set_title( 'DASHBOARD' );
		//$this->output->enable_profiler(TRUE);
	}
	
	function set_theme(){
		$menu = $this->jCfg['theme_setting']['menu']=="top"?"left":"top";
		$this->sCfg['theme_setting']['menu'] = $menu;
		$this->_releaseSession();
		$go = isset($_GET['next'])?$this->input->get('next'):site_url('meme/me');
		redirect($go);	
	}

	function index(){ 
		$this->load->helper('dashboard');
		
		$data = array(
			"end" => isset($_GET['start'])?$this->input->get('start'):date("Y-m-d"),
			"start"	=> isset($_GET['end'])?$this->input->get('end'):mDate(date("Y-m-d"),"-30 day","Y-m-d"),
		);	
		$data['zoom'] = 5;
		$data['init_lat'] = -0.9164501;
		$data['init_lng'] = 118.3325173;
		$data['init_name'] = 'Indonesia';
		$data['type_map'] = 'prov';
		$data['init_type_map'] = 'nasional';
		$prop = '';
		$kab = '';
		if( isset($_POST['btn_search']) ){
			$prop = $this->input->post('s_propinsi');
			$kab = $this->input->post('s_kabupaten');
			
			$result = array();

			// KUA
			if( trim($prop)!="" && trim($kab)!="" ){
				$this->db->select("
						profile_id as id,profile_lat as lat,profile_lang as lng,
						concat('KUA : ',profile_kua_name) as name,profile_kode_satker as code");
				$par = array(
						"profile_propinsi" 	=> $prop,
						"profile_kabupaten"	=> $kab,
						"profile_lang !="	=> "",
						"profile_lat !="	=> ""
					);
				
				$result = $this->db->get_where("web_profile_kua",$par)->result();
				$data['zoom'] = count($result)>0?10:5;

				//get position..
				$tmp_position = $this->db->get_where("app_kabupaten",array(
						"kab_propinsi_id" => (int)$prop,
						"kab_id"		  => (int)$kab
					))->row();

				$tmp_position_prop = $this->db->get_where("app_propinsi",array(
						"propinsi_id" => (int)$prop
					))->row();

				//debugCode($tmp_position_prop);
				$data['type_map'] = 'kua';
				$data['tmp_prop'] = $tmp_position_prop;
				$data['init_type_map'] = 'kota';
				$data['init_lng'] = isset($tmp_position->kab_lang)?$tmp_position->kab_lang:$data['init_lng'];
				$data['init_lat'] = isset($tmp_position->kab_lat)?$tmp_position->kab_lat:$data['init_lat'];
				$data['init_name'] = "KAB/KOTA : ".isset($tmp_position->kab_nama)?$tmp_position->kab_nama:$data['init_name'];

			}

			//PROPINSI
			if( trim($prop)!="" && trim($kab)=="" ){
				$this->db->select("
						kab_id as id,kab_lat as lat,kab_lang as lng,
						concat('Kabupaten/Kota : ',kab_nama) as name,kab_kode_satker as code");
				$par = array(
						"kab_propinsi_id" => $prop,
						"kab_lat !="	=> "",
						"kab_lang !="	=> ""
					);
				
				$result = $this->db->get_where("app_kabupaten",$par)->result();

				//get position..
				$tmp_position = $this->db->get_where("app_propinsi",array(
						"propinsi_id" => (int)$prop
					))->row();
				$data['init_lng'] = isset($tmp_position->propinsi_lang)?$tmp_position->propinsi_lang:$data['init_lng'];
				$data['init_lat'] = isset($tmp_position->propinsi_lat)?$tmp_position->propinsi_lat:$data['init_lat'];
				$data['init_name'] = "PROPINSI : ".isset($tmp_position->propinsi_nama)?$tmp_position->propinsi_nama:$data['init_name'];

				$data['type_map'] = 'kota';
				$data['init_type_map'] = 'prov';
				$data['zoom'] = count($result)>0?8:5;
			}

			//NASIONAL
			if( trim($prop)=="" && trim($kab)=="" ){
				$this->db->select("
						propinsi_id as id,propinsi_lat as lat,propinsi_lang as lng,
						concat('Kanwil/Provinsi : ',propinsi_nama) as name,propinsi_kode as code");
				$par = array(
						"propinsi_lat !="	=> "",
						"propinsi_lang !="	=> ""
					);
				
				$result = $this->db->get_where("app_propinsi",$par)->result();
			}

			$data['result'] = $result;
		}
		
		$data['prop'] 	= $prop;
		$data['kab']	= $kab;

		$this->_v("index",$data);
	}

	function locked(){
		$data = array();
		$this->is_dashboard = TRUE;
		$this->_v("lockscreen",$data,false);
	}

	function daftar(){ 
		$data = array();
		$this->is_dashboard = TRUE;

		$this->_set_title( 'PENDAFTARAN KARTU ANGGOTA' );
		$this->_v("daftar",$data);
	}


	function user_guide(){

		$this->_set_title( 'User Guide' );
		$this->_v("user_guide",array());

	}

	function background(){
		$this->is_dashboard = TRUE;
		$this->_set_title( 'Change Background & Color' );

		if( isset($_POST['simpan']) ){
			$color = '';
			$bg = isset($_POST['opt_bg'])?$_POST['opt_bg']:'bg12.png';

			$this->db->update("app_user",array(
					'user_background' 	=> $bg,
					'user_themes'		=> $color
				),array(
					'user_id'		=> $this->jCfg['user']['id']
				));

			//set sesstion...
			$this->sCfg['user']['bg']		= $bg;
			$this->sCfg['user']['color']	= $color;
			$this->_releaseSession();
		
			redirect($this->own_link."/background?msg=".urldecode('Update background & color succes')."&type_msg=success");

		}

		$this->_v("background",array());
	}
	function profile(){
		$this->is_dashboard = FALSE;
		$this->_set_title('Profile of ( You ) '.$this->jCfg['user']['fullname']);
		$this->breadcrumb[] = array(
				"title"		=> "Profile"
			);
		$this->_v("view-profile",array(
			"data"	=> $this->db->get_where("app_user",array(
					"user_id"	=> $this->jCfg['user']['id']
				))->row()
		));

	}

	function edit_profile(){

		$this->js_plugins = array(
			'plugins/bootstrap/bootstrap-datepicker.js',
			'plugins/bootstrap/bootstrap-file-input.js',
			'plugins/bootstrap/bootstrap-select.js'
		);

		$this->is_dashboard = FALSE;
		$this->_set_title('Update Profile For ( You ) '.$this->jCfg['user']['fullname']);
		$this->breadcrumb[] = array(
				"title"		=> "Profile",
				"url"		=> $this->own_link
			);

		$this->breadcrumb[] = array(
				"title"		=> "Update Profile"
			);

		if( isset($_POST['update']) ){
			$this->DATA->table = "app_user";
			$data = array(
				'user_fullname'		=> dbClean($_POST['user_fullname']),
				'user_email'		=> dbClean($_POST['user_email']),
				'user_telp'			=> dbClean($_POST['user_telp'])
			);		
			$a = $this->_save_master( 
				$data,
				array(
					'user_id' => $this->jCfg['user']['id']
				),
				$this->jCfg['user']['id']		
			);

			$this->upload_path="./assets/collections/user/";
			$id = $this->jCfg['user']['id'];
			$this->_uploaded(
			array(
				'id'		=> $id ,
				'input'		=> 'user_photo',
				'param'		=> array(
								'field' => 'user_photo', 
								'par'	=> array('user_id' => $id)
							)
			));
			redirect($this->own_link."/profile?msg=".urldecode('Update data user succes')."&type_msg=success");
		}

		$this->_v("edit_profile",array(
			"val"	=> $this->db->get_where("app_user",array(
					"user_id"	=> $this->jCfg['user']['id']
				))->row()
		));

	}

	function message(){
		$this->load->model("mdl_meme","M");
		$this->uri_segment=4;
		$par_filter = array(
				"offset"	=> (int)$this->uri->segment($this->uri_segment),
				"limit"		=> $this->per_page
			);

		$this->data_table = $this->M->pesan($par_filter);
		$data = $this->_data(array(
				"base_url"	=> $this->own_link.'/message'
			));
 
		$this->_set_title('Pesan '.$this->jCfg['user']['fullname']);
		$this->_v("pesan",$data);
	}

	function message_reply($to=""){
		$this->js_plugins = array(
			'plugins/bootstrap/bootstrap-datepicker.js',
			'plugins/bootstrap/bootstrap-file-input.js',
			'plugins/bootstrap/bootstrap-select.js'
		);
		$usr_list = get_user_chat();
		if( $usr_list == 0 ){
			redirect($own_link);
		}else{
			$to = trim($to)==""?$usr_list[0]->user_id:$to;
		}

		$this->breadcrumb[] = array(
				"title"		=> "Pesan",
				"url"		=> $this->own_link
			);

		$this->is_dashboard = FALSE;
		$pesan="";$mtype = 'success';
		if(isset($_POST['btn_kirim'])){
			$this->db->insert("app_message",array(
					"msg_to_id" 		=> $to,
					"msg_to_name"		=> get_user_name($to,"user_fullname"),
					"msg_from_id" 		=> $this->jCfg['user']['id'],
					"msg_from_name"		=> $this->jCfg['user']['fullname'],
					"msg_text"			=> $this->input->post('isi_pesan'),
					"msg_is_read" 		=> 0,
					"msg_date"			=> date("Y-m-d H:i:s")
				));
			$pesan = "Pesan berhasil dikirim";
			redirect($this->own_link."/message_reply/".$to."?msg=".urldecode($pesan)."&type_msg=".$mtype);
		}

		$this->db->where(" 
				( msg_to_id = '".$to."' AND msg_from_id = '".$this->jCfg['user']['id']."' ) OR 
				( msg_from_id = '".$to."' AND msg_to_id = '".$this->jCfg['user']['id']."' )
			");
		$this->db->order_by("msg_id","DESC");
		$this->db->limit(200);
		$list_pesan = $this->db->get("app_message")->result();

		//update read.
		$this->db->update("app_message",array(
				"msg_is_read" => 1
			),array(
				"msg_to_id" => $this->jCfg['user']['id']
			));

		$this->_set_title('Pesan '.$this->jCfg['user']['fullname']);
		$this->_v("pesan_reply",array(
			"to"	=> $to,
			"list"	=> $list_pesan
		));
	}

	function change_password(){
		$this->breadcrumb[] = array(
				"title"		=> "Change Password",
				"url"		=> $this->own_link
			);

		$this->is_dashboard = FALSE;
		$pesan="";
		if(isset($_POST['btn_simpan'])){
			$pass_lama = md5(dbClean($_POST['old_pass']));
			$this->DATA->table="app_user";
			$m1 = $this->DATA->_getall(array(
				"user_name"		=> $this->jCfg['user']['name'],
				"user_password"	=> $pass_lama
			));

			if(count($m1)>0){
				$pass_baru = md5(dbClean($_POST['new_pass']));
				$mx = $this->DATA->_update(
					array(
						"user_name"		=> $this->jCfg['user']['name']
					),array(
						"user_password" => $pass_baru
					)

				);
				$pesan = ($mx)?"Success update your password":"Success update your password";
				$mtype = ($mx)?"success":"error";
			}else{
				$pesan ="Your old password is not correctly!";
				$mtype = "error";
			}

			redirect($this->own_link."/change_password?msg=".urldecode($pesan)."&type_msg=".$mtype);
		}

		
		$this->_set_title('Change Password For ( You ) '.$this->jCfg['user']['fullname']);
		$this->_v("change-password",array(
			"pesan"	=> $pesan
		));
	}

	function bug(){
		if(isset($_POST['btn_simpan'])){
			$pesan = dbClean($_POST['pesan']);
			$url   = isset($_GET['url'])?$_GET['url']:'';
			$by    = $this->jCfg['user']['name'];
			$tgl   = date("Y-m-d H:i:s");
			$msg   = "Telah Terjadi Error Pada ".$tgl." Dilaporkan Oleh : ".$by."\n";
			$msg  .= "Error Pada ".$url." \n Pesan : ".$pesan."\n";

			$this->sendEmail(array(
				'from'		=> 'web@'.$this->domain,
				'to'		=> array(getCfgApp('bug_email')),
				'subject'	=> 'Bolanews Bug',
				'priority'	=> 1,
				'message'	=> $msg
			));

			echo "<script>parent.location.reload(true);</script>";
		}

		$this->_v("report_bug",array(
			"url"	=> isset($_GET['url'])?$_GET['url']:''
		),FALSE); 
	}	


	function help(){
		if( isset($_GET['page']) && trim($_GET['page'])!="" ){
			$this->_v("help/".$_GET['page'],array());
		}else{
			$this->_v("help/index",array());
		}
	}
}



