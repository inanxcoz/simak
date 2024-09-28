<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH . "libraries/AdminController.php");
class Petty extends AdminController
{
    function __construct()
    {
        parent::__construct();
        $this->_set_action();
        $this->_set_action(array("edit", "delete"), "ITEM"); //"view"
        $this->_set_title('Data Rekapitulasi Petty Cash');
        $this->DATA->table = "app_petty";
        $this->folder_view = "rekapitulasi/";
        $this->prefix_view = strtolower($this->_getClass());

        $this->upload_path = cfg('upload_path_petty') . "/";

        $this->breadcrumb[] = array(
            "title"     => "Data Rekap Rekapitulasi Petty Cash",
            "url"       => $this->own_link
        );

        $this->is_search_date = true;

        if (!isset($this->jCfg['search']['class']) || $this->jCfg['search']['class'] != $this->_getClass()) {
            $this->_reset();
            redirect($this->own_link);
        }


        $this->cat_search = array(
            ''               => 'All',
            'petty_tahun'    => 'Tahun',
            'petty_perihal'  => 'Perihal'

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
            'order_by'  => 'petty_id',
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
        $this->db->order_by('petty_tahun', 'DESC');
        $this->db->order_by('petty_tgl', 'DESC');
        $par_filter = array(
            "offset"    => (int) $this->uri->segment($this->uri_segment),
            "limit"     => $this->per_page,
            "param"     => $this->cat_search
        );
        $this->data_table = $this->M->petty($par_filter);
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

    function edit(){

        $this->breadcrumb[] = array(
                "title"     => "Edit"
            );
        $id=_decrypt(dbClean(trim($this->input->get('_id'))));

        if(trim($id)!=''){
            $this->data_form = $this->DATA->data_id(array(
                    'petty_id'    => $id
                )); 

            $this->_v($this->folder_view.$this->prefix_view."_form",array(
                ));
        }else{
            redirect($this->own_link);
        }
    }

    function export_data(){
        $par_filter = array(
                "param"     => $this->cat_search
            );
        $this->db->order_by('petty_tahun', 'ASC');
        $this->db->order_by('petty_tgl', 'ASC');
        $this->db->order_by('petty_id', 'ASC');
        $data = $this->M->petty($par_filter);
        $this->_v($this->folder_view.$this->prefix_view."_export",$data,false);
    }

    function delete(){
        $id=_decrypt(dbClean(trim($this->input->get('_id'))));
        if(trim($id) != ''){
            $o = $this->DATA->_delete(
                array("petty_id" => idClean($id))
            );            
        }
        
        redirect($this->own_link."?msg=".urldecode('Delete data user success')."&type_msg=success");
    }

    function save(){

        $data = array(
            'petty_tahun'           => $this->input->post('petty_tahun'),
            'petty_perihal'         => $this->input->post('petty_perihal'),
            'petty_nota'            => $this->input->post('petty_nota'),
            'petty_tgl'             => $this->input->post('petty_tgl'),
            'petty_qty'             => $this->input->post('petty_qty'),
            'petty_debet'           => $this->input->post('petty_debet'),
            'petty_kredit'          => $this->input->post('petty_kredit'),
            'petty_status'          => $this->input->post('petty_status')
        );      
        
        $a = $this->_save_master( 
            $data,
            array(
                'petty_id' => dbClean($_POST['petty_id'])
            ),
            dbClean($_POST['petty_id'])           
        );
        
        $id = $a['id'];
        $this->_uploaded(
        array(
            'id'        => $id ,
            'input'     => 'petty_file',
            'param'     => array(
                            'field' => 'petty_file', 
                            'par'   => array('petty_id' => $id)
                        )
        ));

        redirect($this->own_link."?msg=".urldecode('Save / Update Data Success')."&type_msg=success");
    }
}
