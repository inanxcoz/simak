<?php
class mdl_meme extends CI_Model{ 
	function __construct(){
		parent::__construct();
	} 
	
	function data_user($p=array(),$count=FALSE){
		$total = 0;

		/* table conditions */
		$this->db->select('app_user.*');
		$this->db->where('app_user.is_trash', 0);

		/* where or like conditions */
		if( trim($this->jCfg['search']['date_end'])!="" && trim($this->jCfg['search']['date_end']) != "" ){
			$this->db->where("( app_user.time_add >= '".$this->jCfg['search']['date_start']." 01:00:00' AND app_user.time_add <= '".$this->jCfg['search']['date_end']." 23:59:00' )");

		}

		// dont modified....
		if( trim($this->jCfg['search']['colum'])=="" && trim($this->jCfg['search']['keyword']) != "" ){
			$str_like = "( ";
			$i=0;
			foreach ($p['param'] as $key => $value) {
				if($key != ""){
					$str_like .= $i!=0?"OR":"";
					$str_like .=" ".$key." LIKE '%".$this->jCfg['search']['keyword']."%' ";			
					$i++;
				}
			}
			$str_like .= " ) ";
			$this->db->where($str_like);
		}

		if( trim($this->jCfg['search']['colum'])!="" && trim($this->jCfg['search']['keyword']) != "" ){
			$this->db->like($this->jCfg['search']['colum'],$this->jCfg['search']['keyword']);
		}

		if($count==FALSE){
			if( isset($p['offset']) && isset($p['limit']) ){
				$p['offset'] = empty($p['offset'])?0:$p['offset'];
				$this->db->limit($p['limit'],$p['offset']);
			}
		}

		if(trim($this->jCfg['search']['order_by'])!="")
			$this->db->order_by('user_id','DESC');
		$qry = $this->db->get('app_user');
		
		if($count==FALSE){
			$total = $this->data_user($p,TRUE);
			return array(
					"data"	=> $qry->result(),
					"total" => $total
				);
		}else{
			return $qry->num_rows();
		}
	}

	function data_log($p=array(),$count=FALSE){
		
		$total = 0;

		/* where or like conditions */
		if( trim($this->jCfg['search']['date_start'])!="" && trim($this->jCfg['search']['date_end']) != "" ){
			$this->db->where("( log_date >= '".$this->jCfg['search']['date_start']." 01:00:00' AND log_date <= '".$this->jCfg['search']['date_end']." 23:59:00' )");
		}



		// dont modified....
		if( trim($this->jCfg['search']['colum'])=="" && trim($this->jCfg['search']['keyword']) != "" ){
			$str_like = "( ";
			$i=0;
			foreach ($p['param'] as $key => $value) {
				if($key != ""){
					$str_like .= $i!=0?"OR":"";
					$str_like .=" ".$key." LIKE '%".$this->jCfg['search']['keyword']."%' ";			
					$i++;
				}
			}
			$str_like .= " ) ";
			$this->db->where($str_like);
		}

		if( trim($this->jCfg['search']['colum'])!="" && trim($this->jCfg['search']['keyword']) != "" ){
			$this->db->like($this->jCfg['search']['colum'],$this->jCfg['search']['keyword']);
		}


		
		if($count==FALSE){
			if( isset($p['offset']) && isset($p['limit']) ){
				$p['offset'] = empty($p['offset'])?0:$p['offset'];
				$this->db->limit($p['limit'],$p['offset']);
			}
		}

		if(trim($this->jCfg['search']['order_by'])!="")
			$this->db->order_by($this->jCfg['search']['order_by'],$this->jCfg['search']['order_dir']);
		
		$qry = $this->db->get('app_log');
		if($count==FALSE){
			$total = $this->data_log($p,TRUE);
			return array(
					"data"	=> $qry->result(),
					"total" => $total
				);
		}else{
			return $qry->num_rows();
		}
		

	}

	function pesan($p=array(),$count=FALSE){
		
		$total = 0;

		$this->db->where(" ( msg_to_id ='".$this->jCfg['user']['id']."' OR msg_from_id ='".$this->jCfg['user']['id']."' )");
		if($count==FALSE){
			if( isset($p['offset']) && isset($p['limit']) ){
				$p['offset'] = empty($p['offset'])?0:$p['offset'];
				$this->db->limit($p['limit'],$p['offset']);
			}
		}

		$this->db->order_by('msg_id','DESC');
		
		$qry = $this->db->get('app_message');
		if($count==FALSE){
			$total = $this->pesan($p,TRUE);
			return array(
					"data"	=> $qry->result(),
					"total" => $total
				);
		}else{
			return $qry->num_rows();
		}
		

	}


	function site($p=array(),$count=FALSE){
		
		$total = 0;

		/* where or like conditions */
		if( trim($this->jCfg['search']['date_start'])!="" && trim($this->jCfg['search']['date_end']) != "" ){
			$this->db->where("( app_site.time_add >= '".$this->jCfg['search']['date_start']." 01:00:00' AND app_site.time_add <= '".$this->jCfg['search']['date_end']." 23:59:00' )");
		}

		if( $this->jCfg['user']['is_all'] != 1 ){
			$this->db->where("app_site.site_id",$this->jCfg['user']['site']['id']);
		}
		
		// dont modified....
		if( trim($this->jCfg['search']['colum'])=="" && trim($this->jCfg['search']['keyword']) != "" ){
			$str_like = "( ";
			$i=0;
			foreach ($p['param'] as $key => $value) {
				if($key != ""){
					$str_like .= $i!=0?"OR":"";
					$str_like .=" ".$key." LIKE '%".$this->jCfg['search']['keyword']."%' ";			
					$i++;
				}
			}
			$str_like .= " ) ";
			$this->db->where($str_like);
		}

		if( trim($this->jCfg['search']['colum'])!="" && trim($this->jCfg['search']['keyword']) != "" ){
			$this->db->like($this->jCfg['search']['colum'],$this->jCfg['search']['keyword']);
		}
	
		if($count==FALSE){
			if( isset($p['offset']) && isset($p['limit']) ){
				$p['offset'] = empty($p['offset'])?0:$p['offset'];
				$this->db->limit($p['limit'],$p['offset']);
			}
		}

		if(trim($this->jCfg['search']['order_by'])!="")
			$this->db->order_by($this->jCfg['search']['order_by'],$this->jCfg['search']['order_dir']);
		
		$qry = $this->db->get("app_site");
		if($count==FALSE){
			$total = $this->site($p,TRUE);
			return array(
					"data"	=> $qry->result(),
					"total" => $total
				);
		}else{
			return $qry->num_rows();
		}	

	}

	function data_control($p=array(),$count=FALSE){
		$total = 0;

		/* table conditions */
		$this->db->select("app_acl_accesses.*");

		//$this->db->where('app_acl_accesses.is_trash', 0);

		/* where or like conditions */
		if( trim($this->jCfg['search']['date_end'])!="" && trim($this->jCfg['search']['date_end']) != "" ){
			$this->db->where("( app_acl_accesses.time_add >= '".$this->jCfg['search']['date_start']." 01:00:00' AND app_acl_accesses.time_add <= '".$this->jCfg['search']['date_end']." 23:59:00' )");

		}

		// dont modified....
		if( trim($this->jCfg['search']['colum'])=="" && trim($this->jCfg['search']['keyword']) != "" ){
			$str_like = "( ";
			$i=0;
			foreach ($p['param'] as $key => $value) {
				if($key != ""){
					$str_like .= $i!=0?"OR":"";
					$str_like .=" ".$key." LIKE '%".$this->jCfg['search']['keyword']."%' ";			
					$i++;
				}
			}
			$str_like .= " ) ";
			$this->db->where($str_like);
		}

		if( trim($this->jCfg['search']['colum'])!="" && trim($this->jCfg['search']['keyword']) != "" ){
			$this->db->like($this->jCfg['search']['colum'],$this->jCfg['search']['keyword']);
		}

		if($count==FALSE){
			if( isset($p['offset']) && isset($p['limit']) ){
				$p['offset'] = empty($p['offset'])?0:$p['offset'];
				$this->db->limit($p['limit'],$p['offset']);
			}
		}

		if(trim($this->jCfg['search']['order_by'])!="")
			$this->db->order_by('acc_id','DESC');
		$qry = $this->db->get('app_acl_accesses');
		
		if($count==FALSE){
			$total = $this->data_control($p,TRUE);
			return array(
					"data"	=> $qry->result(),
					"total" => $total
				);
		}else{
			return $qry->num_rows();
		}
	}

	function data_action($p=array(),$count=FALSE){
		$total = 0;

		/* table conditions */
		$this->db->select('app_acl_access_actions.*,
			app_acl_accesses.acc_menu,');
		$this->db->join("app_acl_accesses", "app_acl_accesses.acc_id=app_acl_access_actions.aca_access_id", 'LEFT');
		//$this->db->where('app_acl_access_actions.is_trash', 0);

		/* where or like conditions */
		if( trim($this->jCfg['search']['date_end'])!="" && trim($this->jCfg['search']['date_end']) != "" ){
			$this->db->where("( app_acl_access_actions.time_add >= '".$this->jCfg['search']['date_start']." 01:00:00' AND app_acl_access_actions.time_add <= '".$this->jCfg['search']['date_end']." 23:59:00' )");

		}

		// dont modified....
		if( trim($this->jCfg['search']['colum'])=="" && trim($this->jCfg['search']['keyword']) != "" ){
			$str_like = "( ";
			$i=0;
			foreach ($p['param'] as $key => $value) {
				if($key != ""){
					$str_like .= $i!=0?"OR":"";
					$str_like .=" ".$key." LIKE '%".$this->jCfg['search']['keyword']."%' ";			
					$i++;
				}
			}
			$str_like .= " ) ";
			$this->db->where($str_like);
		}

		if( trim($this->jCfg['search']['colum'])!="" && trim($this->jCfg['search']['keyword']) != "" ){
			$this->db->like($this->jCfg['search']['colum'],$this->jCfg['search']['keyword']);
		}

		if($count==FALSE){
			if( isset($p['offset']) && isset($p['limit']) ){
				$p['offset'] = empty($p['offset'])?0:$p['offset'];
				$this->db->limit($p['limit'],$p['offset']);
			}
		}

		if(trim($this->jCfg['search']['order_by'])!="")
			/*$this->db->order_by('aca_id','DESC');
			$this->db->order_by('aca_action_id','ASC');*/
		$qry = $this->db->get('app_acl_access_actions');
		
		if($count==FALSE){
			$total = $this->data_action($p,TRUE);
			return array(
					"data"	=> $qry->result(),
					"total" => $total
				);
		}else{
			return $qry->num_rows();
		}
	}
}