<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH . "libraries/AdminController.php");
class Karyawan extends AdminController
{
    function __construct()
    {
        parent::__construct();
        $this->_set_action();
        $this->_set_action(array("edit", "delete"), "ITEM"); //"view"
        $this->_set_title('Data Transaksi Karyawan');
        $this->DATA->table = "app_karyawan";
        $this->folder_view = "transaksi/";
        $this->prefix_view = strtolower($this->_getClass());

        $this->upload_path = cfg('upload_path_karyawan') . "/";

        $this->breadcrumb[] = array(
            "title"     => "Data Karyawan",
            "url"       => $this->own_link
        );

        $this->is_search_date = false;

        if (!isset($this->jCfg['search']['class']) || $this->jCfg['search']['class'] != $this->_getClass()) {
            $this->_reset();
            redirect($this->own_link);
        }

        $this->cat_search = array(
            ''                  => 'All',            
            'karyawan_nik'      => 'NIK Karyawan',
            'karyawan_nama'     => 'Nama Karyawan',
            'propinsi_nama'     => 'Nama Provinsi',
            'kab_nama'          => 'Nama Kabupaten',
            'kec_nama'          => 'Nama Kecamatan',
            'kel_nama'          => 'Nama Kelurahan',
            'karyawan_telp'     => 'No. Handphone'

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
            'order_by'  => 'karyawan_id',
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

        $this->db->order_by('karyawan_status', 'DESC');
        $this->db->order_by('karyawan_nama', 'ASC');
        
        $par_filter = array(
            "offset"    => (int) $this->uri->segment($this->uri_segment),
            "limit"     => $this->per_page,
            "param"     => $this->cat_search
        );
        $this->data_table = $this->M->karyawan($par_filter);
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
                    'karyawan_id'    => $id
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

        $this->db->order_by('karyawan_status', 'DESC');
        $this->db->order_by('karyawan_nama', 'ASC');
        
        $data = $this->M->karyawan($par_filter);
        $this->_v($this->folder_view.$this->prefix_view."_export",$data,false);
    }

    function delete(){
        $id=_decrypt(dbClean(trim($this->input->get('_id'))));
        if(trim($id) != ''){
            $o = $this->DATA->_delete(
                array("karyawan_id" => idClean($id))
            );            
        }
        
        redirect($this->own_link."?msg=".urldecode('Delete data user success')."&type_msg=success");
    }

    function save(){

        $data = array(
            'karyawan_nip'           => $this->input->post('karyawan_nip'),
            'karyawan_nik'           => $this->input->post('karyawan_nik'),
            'karyawan_nama'          => $this->input->post('karyawan_nama'),
            'karyawan_tempat_lahir'  => $this->input->post('karyawan_tempat_lahir'),
            'karyawan_tgl_lahir'     => $this->input->post('karyawan_tgl_lahir'),
            'karyawan_gender'        => $this->input->post('karyawan_gender'),
            'karyawan_ibu_kandung'   => $this->input->post('karyawan_ibu_kandung'),
            'karyawan_alamat'        => $this->input->post('karyawan_alamat'),
            'karyawan_domisili'      => $this->input->post('karyawan_domisili'),
            'karyawan_rt'            => $this->input->post('karyawan_rt'),
            'karyawan_rw'            => $this->input->post('karyawan_rw'),
            'karyawan_prov_id'       => $this->input->post('karyawan_prov_id'),
            'karyawan_kab_id'        => $this->input->post('karyawan_kab_id'),
            'karyawan_kec_id'        => $this->input->post('karyawan_kec_id'),
            'karyawan_kel_id'        => $this->input->post('karyawan_kel_id'),
            'karyawan_agama'         => $this->input->post('karyawan_agama'),
            'karyawan_kawin'         => $this->input->post('karyawan_kawin'),
            'karyawan_npwp'          => $this->input->post('karyawan_npwp'),
            'karyawan_bpjs'          => $this->input->post('karyawan_bpjs'),
            'karyawan_bpjstk'        => $this->input->post('karyawan_bpjstk'),
            'karyawan_telp'          => $this->input->post('karyawan_telp'),
            'karyawan_email'         => $this->input->post('karyawan_email'),
            'karyawan_email2'         => $this->input->post('karyawan_email2'),
            'karyawan_status'        => $this->input->post('karyawan_status')
        );      
        
        $a = $this->_save_master( 
            $data,
            array(
                'karyawan_id' => dbClean($_POST['karyawan_id'])
            ),
            dbClean($_POST['karyawan_id'])           
        );
        
        $id = $a['id'];
        $this->_uploaded(
        array(
            'id'        => $id ,
            'input'     => 'karyawan_file_photo',
            'param'     => array(
                            'field' => 'karyawan_file_photo', 
                            'par'   => array('karyawan_id' => $id)
                        )
        ));

        $this->_uploaded(
        array(
            'id'        => $id ,
            'input'     => 'karyawan_file_bjps',
            'param'     => array(
                            'field' => 'karyawan_file_bjps', 
                            'par'   => array('karyawan_id' => $id)
                        )
        ));

        $this->_uploaded(
        array(
            'id'        => $id ,
            'input'     => 'karyawan_file_bjpstk',
            'param'     => array(
                            'field' => 'karyawan_file_bjpstk', 
                            'par'   => array('karyawan_id' => $id)
                        )
        ));

        $this->_uploaded(
        array(
            'id'        => $id ,
            'input'     => 'karyawan_file_npwp',
            'param'     => array(
                            'field' => 'karyawan_file_npwp', 
                            'par'   => array('karyawan_id' => $id)
                        )
        ));

        $this->_uploaded(
        array(
            'id'        => $id ,
            'input'     => 'karyawan_file_ktp',
            'param'     => array(
                            'field' => 'karyawan_file_ktp', 
                            'par'   => array('karyawan_id' => $id)
                        )
        ));

        redirect($this->own_link."?msg=".urldecode('Save / Update Data Success')."&type_msg=success");
    }
}
