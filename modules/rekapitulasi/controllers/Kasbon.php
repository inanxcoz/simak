<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH . "libraries/AdminController.php");
class Kasbon extends AdminController
{
    function __construct()
    {
        parent::__construct();
        $this->_set_action();
        $this->_set_action(array("view","edit", "delete"), "ITEM"); //"view"
        $this->_set_title('Data Rekapitulasi Kasbon');
        $this->DATA->table = "app_kasbon";
        $this->folder_view = "rekapitulasi/";
        $this->prefix_view = strtolower($this->_getClass());

        $this->upload_path = cfg('upload_path_kasbon') . "/";

        $this->breadcrumb[] = array(
            "title"     => "Data Bukti Kasbon",
            "url"       => $this->own_link
        );

        $this->is_search_date = true;

        if (!isset($this->jCfg['search']['class']) || $this->jCfg['search']['class'] != $this->_getClass()) {
            $this->_reset();
            redirect($this->own_link);
        }


        $this->cat_search = array(
            ''                  => 'All',
            'karyawan_nama'       => 'Nama'

        );
        $this->load->model("mdl_master", "M");

        //load js..
        $this->js_plugins = array(
            'plugins/bootstrap/bootstrap-datepicker.js',
            'plugins/bootstrap/bootstrap-file-input.js',
            'plugins/bootstrap/bootstrap-select.js',
            'plugins/bootstrap/bootstrap-timepicker.min.js',
            'plugins/summernote/summernote.js'
        );
    }


    function _reset()
    {
        $this->sCfg['search'] = array(
            'class'     => $this->_getClass(),
            'date_start' => '',
            'date_end'  => '',
            'status'    => '',
            'order_by'  => 'kasbon_id',
            'order_dir' => 'DESC',
            'colum'     => '',
            'keyword'   => ''
        );
        $this->_releaseSession();
    }

    function index()
    {

        $this->breadcrumb[] = array(
            "title"     => "List"
        );
        if ($this->input->post('btn_search')) {

            if ($this->input->post('date_start') && trim($this->input->post('date_start')) != "")
                $this->jCfg['search']['date_start'] = $this->input->post('date_start');

            if ($this->input->post('date_end') && trim($this->input->post('date_end')) != "")
                $this->jCfg['search']['date_end'] = $this->input->post('date_end');

            if ($this->input->post('colum') && trim($this->input->post('colum')) != "")
                $this->jCfg['search']['colum'] = $this->sCfg['search']['colum'] = $this->input->post('colum');
            else
                $this->jCfg['search']['colum'] = $this->sCfg['search']['colum'] = "";

            if ($this->input->post('keyword') && trim($this->input->post('keyword')) != "")
                $this->jCfg['search']['keyword'] = $this->sCfg['search']['keyword'] = $this->input->post('keyword');
            else
                $this->jCfg['search']['keyword'] = $this->sCfg['search']['keyword'] = "";

            $this->_releaseSession();
        }

        if ($this->input->post('btn_reset')) {
            $this->_reset();
            redirect($this->own_link);
        }

        $this->db->order_by('app_kasbon.kasbon_id','DESC');
        $this->db->order_by('app_kasbon_detail.kd_cicilan_id','ASC');
        $this->db->order_by('app_kasbon_detail.kd_tgl','ASC');

        $par_filter = array(
            "offset"    => (int) $this->uri->segment($this->uri_segment),
            "limit"     => $this->per_page,
            "param"     => $this->cat_search
        );
        $this->data_table = $this->M->kasbon($par_filter);
        $data = $this->_data(array(
            "base_url"  => $this->own_link . '/index'
        ));
        $this->_v($this->folder_view . $this->prefix_view, $data);
    }

    function add(){ 
        $this->breadcrumb[] = array(
                "title"     => "Add"
            );      
        $this->_v($this->folder_view.$this->prefix_view."_form",array());
    }

    function view(){
        $this->breadcrumb[] = array(
                "title"     => "View"
            );

        $id=_decrypt(dbClean(trim($this->input->get('_id'))));       

        if(trim($id)!=''){
            $this->data_form = $this->DATA->data_id(array(
                    'kasbon_id'    => $id
                ));
            $this->db->order_by("kd_cicilan_id","ASC");
            $this->db->order_by('kd_tgl','ASC');
            $cicilan = $this->db->get_where("app_kasbon_detail",array("kd_kasbon_id"=>$id))->result();

            $par = array();
            if( count($cicilan)){
                $par['cicilan'] = $cicilan;
            }
            $this->_v($this->folder_view.$this->prefix_view."_view",$par);
        }else{
            redirect($this->own_link);
        }
    }

    function export_data(){
        $par_filter = array(
                "param"     => $this->cat_search
            );
        $this->db->order_by('app_kasbon.kasbon_id','ASC');
        $this->db->order_by('app_kasbon_detail.kd_cicilan_id','ASC');
        $this->db->order_by('app_kasbon_detail.kd_tgl','ASC');
        $this->db->where('app_kasbon.kasbon_status !=',2);
        $data = $this->M->kasbon($par_filter);
        $this->_v($this->folder_view.$this->prefix_view."_export",$data,false);
    }

    function edit(){
       
       $this->breadcrumb[] = array(
                "title"     => "Edit"
            );
        $id=_decrypt(dbClean(trim($this->input->get('_id'))));       

        if(trim($id)!=''){
            $this->data_form = $this->DATA->data_id(array(
                    'kasbon_id'    => $id
                ));

            $this->db->order_by("kd_cicilan_id","ASC");
            $this->db->order_by('kd_tgl','ASC');
            $cicilan = $this->db->get_where("app_kasbon_detail",array("kd_kasbon_id"=>$id))->result();

            $par = array();
            if( count($cicilan)){
                $par['cicilan'] = $cicilan;
            }

            $this->_v($this->folder_view.$this->prefix_view."_form",$par);
        }else{
            redirect($this->own_link);
        }
    }

    function delete(){
        $id=_decrypt(dbClean(trim($this->input->get('_id'))));
        if(trim($id) != ''){
            $o = $this->DATA->_delete(
                array("kasbon_id" => idClean($id))
            );            
        }
        
        redirect($this->own_link."?msg=".urldecode('Delete data user success')."&type_msg=success");
    }

    function save(){

        $data = array(
            'kasbon_nama_id'       => $this->input->post('kasbon_nama_id'),
            'kasbon_nominal'       => $this->input->post('kasbon_nominal'),
            'kasbon_uraian'        => $this->input->post('kasbon_uraian'),
            'kasbon_tgl'           => $this->input->post('kasbon_tgl'),
            'kasbon_status'        => $this->input->post('kasbon_status')
        );      

        
        $a = $this->_save_master( 
            $data,
            array(
                'kasbon_id' => dbClean($_POST['kasbon_id'])
            ),
            dbClean($_POST['kasbon_id'])           
        );
        
        $id = $a['id'];
        $this->_uploaded(
        array(
            'id'        => $id ,
            'input'     => 'kasbon_photo',
            'param'     => array(
                            'field' => 'kasbon_photo', 
                            'par'   => array('kasbon_id' => $id)
                        )
        ));

        //save cicilan..
        $this->db->delete("app_kasbon_detail",array("kd_kasbon_id"=>$id));
        if( isset($_POST['cicilan_nama']) && count($_POST['cicilan_nama'])){
            foreach ((array)$this->input->post('cicilan_nama') as $k => $v) {
                $this->db->insert("app_kasbon_detail",array(
                    "kd_kasbon_id"  => $id,
                    "kd_nominal"    => dbClean($_POST['kc_nominal'][$k]),
                    "kd_cicilan_id" => dbClean($v),
                    "kd_tgl"        => dbClean($_POST['kc_tgl'][$k]),
                    "kd_status"     => dbClean($_POST['kc_status'][$k]),
                    "time_update"   => date("Y-m-d H:i:s")
                ));
            }
        }

        redirect($this->own_link."?msg=".urldecode('Save / Update Data Success')."&type_msg=success");
    }
}
