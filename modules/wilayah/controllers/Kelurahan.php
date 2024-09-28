<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH . "libraries/AdminController.php");
class Kelurahan extends AdminController
{
    function __construct()
    {
        parent::__construct();
        $this->_set_action();
        $this->_set_action(array("edit", "delete"), "ITEM"); //"view"
        $this->_set_title('Data Wilayah Kelurahan');
        $this->DATA->table = "app_kelurahan";
        $this->folder_view = "wilayah/";
        $this->prefix_view = strtolower($this->_getClass());

        $this->upload_path = cfg('upload_path_kelurahan') . "/";

        $this->breadcrumb[] = array(
            "title"     => "Data Kelurahan",
            "url"       => $this->own_link
        );

        $this->is_search_date = false;

        if (!isset($this->jCfg['search']['class']) || $this->jCfg['search']['class'] != $this->_getClass()) {
            $this->_reset();
            redirect($this->own_link);
        }

        $this->cat_search = array(
            ''                  => 'All',
            'propinsi_nama'     => 'Nama Provinsi',
            'kab_nama'          => 'Nama Kabupaten',
            'kec_nama'          => 'Nama Kecamatan',
            'kel_nama'          => 'Nama Kelurahan',
            'kel_kode'          => 'Kode Kelurahan'

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
            'order_by'  => 'kel_id',
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

        $this->db->order_by('propinsi_nama', 'ASC');
        $this->db->order_by('kab_nama', 'ASC');
        $this->db->order_by('kec_nama', 'ASC');
        $this->db->order_by('kel_nama', 'ASC');
        
        $par_filter = array(
            "offset"    => (int) $this->uri->segment($this->uri_segment),
            "limit"     => $this->per_page,
            "param"     => $this->cat_search
        );
        $this->data_table = $this->M->kelurahan($par_filter);
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
                    'kel_id'    => $id
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

        $this->db->order_by('propinsi_nama', 'ASC');
        $this->db->order_by('kab_nama', 'ASC');
        $this->db->order_by('kec_nama', 'ASC');
        $this->db->order_by('kel_nama', 'ASC');
        
        $data = $this->M->kelurahan($par_filter);
        $this->_v($this->folder_view.$this->prefix_view."_export",$data,false);
    }

    function delete(){
        $id=_decrypt(dbClean(trim($this->input->get('_id'))));
        if(trim($id) != ''){
            $o = $this->DATA->_delete(
                array("kel_id" => idClean($id))
            );            
        }
        
        redirect($this->own_link."?msg=".urldecode('Delete data user success')."&type_msg=success");
    }

    function save(){

        $data = array(
            'kel_nama'     => $this->input->post('kel_nama'),
            'kel_prov_id'  => $this->input->post('kel_prov_id'),
            'kel_kab_id'   => $this->input->post('kel_kab_id'),
            'kel_kec_id'   => $this->input->post('kel_kec_id'),
            'kel_kode'     => $this->input->post('kel_kode'),
            'kel_kode_pos' => $this->input->post('kel_kode_pos'),
            'kel_status'   => $this->input->post('kel_status')
        );      
        
        $a = $this->_save_master( 
            $data,
            array(
                'kel_id' => dbClean($_POST['kel_id'])
            ),
            dbClean($_POST['kel_id'])           
        );
        
        $id = $a['id'];
        $this->_uploaded(
        array(
            'id'        => $id ,
            'input'     => 'kel_photo',
            'param'     => array(
                            'field' => 'kel_photo', 
                            'par'   => array('kel_id' => $id)
                        )
        ));

        redirect($this->own_link."?msg=".urldecode('Save / Update Data Success')."&type_msg=success");
    }
}
