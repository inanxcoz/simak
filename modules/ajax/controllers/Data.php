<?php
include_once(APPPATH."libraries/FrontController.php");
class Data extends FrontController {

	function __construct()  
	{
		parent::__construct(); 		
	}

	
	function faktur_pajak(){
		
		$tahun = $this->input->post('thn');
		$faktur = $this->input->post('fkr');

		$this->db->order_by("nsfp_id");

		$m = $this->db->get_where("app_nsfp",array(
				"nsfp_tahun_id"	=> $tahun,
				"nsfp_status"	=> 1
			))->result();
		$html = "<option value=''> - Pilih - </option>";
		foreach ((array)$m as $k => $v) {
			$s = $v->nsfp_id==$faktur?'selected="selected"':'';
			$html .= "<option value='".$v->nsfp_id."' $s >".$v->nsfp_nomor."</option>";
		}

		die($html);
	}
	
	function kota_ops(){
		
		$prov = $this->input->post('prop');
		$kota = $this->input->post('kab');
		$type = $this->input->post('type');

		$this->db->order_by("kab_nama");
		
		if( $type=='PROPINSI'){
      		$this->db->where("web_profile_kua.profile_type","kanwil");
		}
	    if( $type=='KUA'){
		    $this->db->where("web_profile_kua.profile_type","kua");
	    }
	    if( $type=='KOTA'){
		    $this->db->where("web_profile_kua.profile_type","kota");
	    }
	    $this->db->join("web_profile_kua","web_profile_kua.profile_kabupaten = app_kabupaten.kab_id");
		$this->db->select("app_kabupaten.*");
					
		if( trim($this->jCfg['user']['kabupaten'])!= 0){
				$this->db->where("kab_id",$this->jCfg['user']['kabupaten']);
		}
		$this->db->group_by("app_kabupaten.kab_id");
		$m = $this->db->get_where("app_kabupaten",array(
				"kab_propinsi_id"	=> $prov,
				"kab_status"		=> 1
			))->result();
		$html = "<option value=''> - pilih - </option>";
		foreach ((array)$m as $k => $v) {
			$s = $v->kab_id==$kota?'selected="selected"':'';
			$html .= "<option value='".$v->kab_id."' $s >".$v->kab_nama."</option>";
		}

		die($html);
	}

	function output(){
		
		$keg = $this->input->post('keg');
		$output = $this->input->post('output');

		$this->db->order_by("ref_name");
		$m = $this->db->get_where("web_ref_nonoperasional",array(
				"ref_parent"		=> $keg,
				"ref_type"			=> 'output',
				"ref_status"		=> 1
			))->result();
		$html = "<option value=''> - pilih output - </option>";
		foreach ((array)$m as $k => $v) {
			$s = $v->ref_id==$output?'selected="selected"':'';
			$html .= "<option value='".$v->ref_id."' $s >[".$v->ref_kode."] ".$v->ref_name."</option>";
		}

		die($html);
	}

	
	function kua(){
		
		$prov = $this->input->post('prop');
		$kota = $this->input->post('kab');
		$kua = $this->input->post('kua');

		$this->db->order_by("profile_kua_name");
		$m = $this->db->get_where("web_profile_kua",array(
				"profile_kua_name !="=>"",
				"profile_propinsi"	=> $prov,
				"profile_kabupaten"	=> $kota
				//"profile_status"	=> 1
			))->result();
		//debugCode($this->db->last_query());
		$html = "<option value=''> - pilih - </option>";
		foreach ((array)$m as $k => $v) {
			$s = $v->profile_id==$kua?'selected="selected"':'';
			$html .= "<option value='".$v->profile_id."' $s >".$v->profile_kua_name."</option>";
		}

		die($html);
		
	}
	
	function kua_ops(){
		
		$prov = $this->input->post('prop');
		$kota = $this->input->post('kab');
		$kua = $this->input->post('kua');
		$type = $this->input->post('type');
		
		if( $type=='PROPINSI'){
      		$this->db->where("web_profile_kua.profile_type","kanwil");
		}
	    if( $type=='KUA'){
		    $this->db->where("web_profile_kua.profile_type","kua");
	    }
	    if( $type=='KOTA'){
		    $this->db->where("web_profile_kua.profile_type","kota");
	    }
	    
		$this->db->order_by("profile_kua_name");
		$m = $this->db->get_where("web_profile_kua",array(
				"profile_propinsi"	=> $prov,
				"profile_kabupaten"	=> $kota,
				"profile_status"	=> 1
			))->result();
		$html = "<option value=''> - pilih - </option>";
		foreach ((array)$m as $k => $v) {
			$s = $v->profile_id==$kua?'selected="selected"':'';
			$html .= "<option value='".$v->profile_id."' $s >".$v->profile_kua_name."</option>";
		}

		die($html);
		
	}
	
	function kabupaten(){
		
		$provinsi = $this->input->post('prov');
		$kabupaten = $this->input->post('kab');

		$this->db->order_by("kab_nama");

		$m = $this->db->get_where("app_kabupaten",array(
				"kab_prov_id"	=> $provinsi,
				"kab_status"	=> 1
			))->result();
		$html = "<option value=''> - Pilih - </option>";
		foreach ((array)$m as $k => $v) {
			$s = $v->kab_id==$kabupaten?'selected="selected"':'';
			$html .= "<option value='".$v->kab_id."' $s >".$v->kab_nama."</option>";
		}

		die($html);
	}

	function kecamatan(){
		
		$provinsi = $this->input->post('prov');
		$kabupaten = $this->input->post('kab');
		$kecamatan = $this->input->post('kec');

		$this->db->order_by("kec_nama");

		$m = $this->db->get_where("app_kecamatan",array(
				"kec_prov_id"	=> $provinsi,
				"kec_kab_id"	=> $kabupaten,		
				"kec_status"	=> 1
			))->result();
		$html = "<option value=''> - Pilih - </option>";
		foreach ((array)$m as $k => $v) {
			$s = $v->kec_id==$kecamatan?'selected="selected"':'';
			$html .= "<option value='".$v->kec_id."' $s >".$v->kec_nama."</option>";
		}

		die($html);
	}

	function kelurahan(){
		
		$provinsi = $this->input->post('prov');
		$kabupaten = $this->input->post('kab');
		$kecamatan = $this->input->post('kec');
		$kelurahan = $this->input->post('kel');

		$this->db->order_by("kel_nama");

		$m = $this->db->get_where("app_kelurahan",array(
				"kel_prov_id"	=> $provinsi,
				"kel_kab_id"	=> $kabupaten,		
				"kel_kec_id"	=> $kecamatan,		
				"kel_status"	=> 1
			))->result();
		$html = "<option value=''> - Pilih - </option>";
		foreach ((array)$m as $k => $v) {
			$s = $v->kel_id==$kelurahan?'selected="selected"':'';
			$html .= "<option value='".$v->kel_id."' $s >".$v->kel_nama."</option>";
		}

		die($html);
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */