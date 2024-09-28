<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH . "libraries/AdminController.php");
class Action extends AdminController
{
	function __construct()
	{
		parent::__construct();
		$this->_set_action();
		$this->_set_action(array("edit", "delete"), "ITEM");
		$this->_set_title('Setting Access Action');
		$this->DATA->table = "app_acl_access_actions";
		$this->folder_view = "meme/";
		$this->prefix_view = strtolower($this->_getClass());

		//$this->upload_path = cfg('upload_path_user') . "/";

		$this->breadcrumb[] = array(
			"title"		=> "Access Action",
			"url"		=> $this->own_link
		);

		$this->is_search_date = false;

		if (!isset($this->jCfg['search']) || !isset($this->jCfg['search']['class']) || $this->jCfg['search']['class'] != $this->_getClass()) {
			$this->_reset();
			redirect($this->own_link);
		}


		$this->cat_search = array(
			''						=> 'All',
			'acc_menu'				=> 'Menu',
			'acc_access_name'		=> 'Akses',
			'acc_description'		=> 'Deskripsi'
		);
		$this->load->model("mdl_meme", "M");
		$this->js_plugins = array(
			'plugins/bootstrap/bootstrap-datepicker.js',
			'plugins/bootstrap/bootstrap-file-input.js',
			'plugins/bootstrap/bootstrap-select.js'
		);
	}

	function _reset()
	{
		$this->sCfg['search'] = array(
			'class'		=> $this->_getClass(),
			'name'		=> 'control',
			'date_start' => '',
			'date_end'	=> '',
			'status'	=> '',
			'order_by'  => 'aca_id',
			'order_dir' => 'DESC',
			'colum'		=> '',
			'keyword'	=> ''
		);
		$this->_releaseSession();
	}

	function index()
	{
		$this->breadcrumb[] = array(
			"title"		=> "List"
		);
		if ($this->input->post('btn_search')) {
			if ($this->input->post('date_start') && trim($this->input->post('date_start')) != "")
				$this->jCfg['search']['date_start'] = $this->input->post('date_start');

			if ($this->input->post('date_end') && trim($this->input->post('date_end')) != "")
				$this->jCfg['search']['date_end'] = $this->input->post('date_end');

			if ($this->input->post('colum') && trim($this->input->post('colum')) != "")
				$this->jCfg['search']['colum'] = $this->input->post('colum');
			else
				$this->jCfg['search']['colum'] = "";

			if ($this->input->post('keyword') && trim($this->input->post('keyword')) != "")
				$this->jCfg['search']['keyword'] = $this->input->post('keyword');
			else
				$this->jCfg['search']['keyword'] = "";

			$this->_releaseSession();
		}

		if ($this->input->post('btn_reset')) {
			$this->_reset();
		}

		$this->db->order_by('app_acl_access_actions.aca_id','DESC');
		$this->db->order_by('app_acl_access_actions.aca_action_id','ASC');
		
		$par_filter = array(
			"offset"	=> (int)$this->uri->segment($this->uri_segment),
			"limit"		=> $this->per_page,
			"param"		=> $this->cat_search
		);
		$this->data_table = $this->M->data_action($par_filter);
		$data = $this->_data(array(
			"base_url"	=> $this->own_link . '/index'
		));
		$this->_v($this->folder_view . $this->prefix_view, $data);
	}

	function export_data()
	{
		$par_filter = array(
			"param"     => $this->cat_search
		);
		$this->db->order_by('acc_menu', 'ASC');
		$data = $this->M->data_action($par_filter);
		$this->_v($this->folder_view . $this->prefix_view . "_export", $data, false);
	}

	function add()
	{
		$this->breadcrumb[] = array(
			"title"     => "Add"
		);
		$this->_v($this->folder_view . $this->prefix_view . "_form", array());
	}

	function edit()
	{

		$this->breadcrumb[] = array(
			"title"     => "Edit"
		);
		$id = _decrypt(dbClean(trim($this->input->get('_id'))));

		if (trim($id) != '') {
			$this->data_form = $this->DATA->data_id(array(
				'aca_id'    => $id
			));

			$this->_v($this->folder_view . $this->prefix_view . "_form", array());
		} else {
			redirect($this->own_link);
		}
	}

	function delete()
	{
		$id = _decrypt(dbClean(trim($this->input->get('_id'))));
		if (trim($id) != '') {
			$this->db->where('aca_id', $id);
	    	$this->db->delete('app_acl_access_actions');
			/*$o = $this->db->delete(
				array("aca_id"	=> idClean($id))
			);*/
		}
		redirect($this->own_link . "?msg=" . urldecode('Delete data access control success') . "&type_msg=success");
	}

	function save()
	{

		$data = array(
			'aca_access_id'     => $this->input->post('aca_access_id'),
			'aca_action_id'     => $this->input->post('aca_action_id'),
			'app_id'  			=> $this->input->post('app_id')
		);

		$a = $this->_save_master(
			$data,
			array(
				'aca_id' => dbClean($_POST['aca_id'])
			),
			dbClean($_POST['aca_id'])
		);

		redirect($this->own_link . "?msg=" . urldecode('Save / Update Data Success') . "&type_msg=success");
	}
}
