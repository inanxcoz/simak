<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH . "libraries/AdminController.php");
class Invoice extends AdminController
{
    function __construct()
    {
        parent::__construct();
        $this->_set_action();
        $this->_set_action(array("edit", "delete"), "ITEM"); //"view"
        $this->_set_title('Data Transaksi Invoice');
        $this->DATA->table = "app_invoice";
        $this->folder_view = "transaksi/";
        $this->prefix_view = strtolower($this->_getClass());

        $this->upload_path = cfg('upload_path_invoice') . "/";

        $this->breadcrumb[] = array(
            "title"     => "Data Invoice",
            "url"       => $this->own_link
        );

        $this->is_search_date = true;

        if (!isset($this->jCfg['search']['class']) || $this->jCfg['search']['class'] != $this->_getClass()) {
            $this->_reset();
            redirect($this->own_link);
        }

        $this->cat_search = array(
            ''               => 'All',
            'inv_tahun'      => 'Tahun',
            'nsfp_nomor'     => 'No. Faktur',
            'inv_spk'        => 'No. Kontrak',
            'inv_nomor'      => 'No. Invoice',
            'client_nama'    => 'Nama Client',
            'pajak_billing'  => 'Kode Billing',
            'inv_perihal'    => 'Perihal'

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
            'order_by'  => 'inv_id',
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

        $data = array();

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
        $this->db->order_by('inv_tahun', 'DESC');
        $this->db->order_by('inv_nsfp', 'DESC');
        $this->db->order_by('inv_tgl', 'DESC');
        $par_filter = array(
            "offset"    => (int) $this->uri->segment($this->uri_segment),
            "limit"     => $this->per_page,
            "param"     => $this->cat_search
        );
        $this->data_table = $this->M->invoice($par_filter);
        $data = $this->_data(array(
            "base_url"  => $this->own_link . '/index'
        ));
        $this->_v($this->folder_view . $this->prefix_view, $data);
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
                'inv_id'    => $id
            ));

            $this->_v($this->folder_view . $this->prefix_view . "_form", array());
        } else {
            redirect($this->own_link);
        }
    }

    function export_data()
    {
        $par_filter = array(
            "param"     => $this->cat_search
        );
        $this->db->order_by('inv_tahun', 'ASC');
        $this->db->order_by('inv_nsfp', 'ASC');
        $this->db->where('app_invoice.inv_status !=', 2);
        $data = $this->M->invoice($par_filter);
        $this->_v($this->folder_view . $this->prefix_view . "_export", $data, false);
    }

    function delete()
    {
        $id = _decrypt(dbClean(trim($this->input->get('_id'))));
        if (trim($id) != '') {
            $o = $this->DATA->_delete(
                array("inv_id" => idClean($id))
            );
        }

        redirect($this->own_link . "?msg=" . urldecode('Delete data user success') . "&type_msg=success");
    }

    function save()
    {

        $data = array(
            'inv_tahun'     => $this->input->post('inv_tahun'),
            'inv_nsfp'      => $this->input->post('inv_nsfp'),
            'inv_spk'       => $this->input->post('inv_spk'),
            'inv_tgl'       => $this->input->post('inv_tgl'),
            'inv_nomor'     => $this->input->post('inv_nomor'),
            'inv_client_id' => $this->input->post('inv_client_id'),
            'inv_perihal'   => $this->input->post('inv_perihal'),
            'inv_nominal'   => $this->input->post('inv_nominal'),
            'inv_tgl_kirim' => $this->input->post('inv_tgl_kirim'),
            'inv_tgl_byr'   => $this->input->post('inv_tgl_byr'),
            'inv_pph'       => $this->input->post('inv_pph'),
            'inv_ntpn'      => $this->input->post('inv_ntpn'),
            'inv_status'    => $this->input->post('inv_status')
        );

        $a = $this->_save_master(
            $data,
            array(
                'inv_id' => dbClean($_POST['inv_id'])
            ),
            dbClean($_POST['inv_id'])
        );

        $id = $a['id'];
        $this->_uploaded(
            array(
                'id'        => $id,
                'input'     => 'inv_file',
                'param'     => array(
                    'field' => 'inv_file',
                    'par'   => array('inv_id' => $id)
                )
            )
        );

        redirect($this->own_link . "?msg=" . urldecode('Save / Update Data Success') . "&type_msg=success");
    }
}
