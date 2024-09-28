<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH . "libraries/AdminController.php");
class Payment extends AdminController
{
    function __construct()
    {
        parent::__construct();
        $this->_set_action();
        $this->_set_action(array("view", "edit", "delete"), "ITEM"); //"view"
        $this->_set_title('Data Transaksi Payment Request');
        $this->DATA->table = "app_payment";
        $this->folder_view = "transaksi/";
        $this->prefix_view = strtolower($this->_getClass());

        $this->upload_path = cfg('upload_path_payment') . "/";

        $this->breadcrumb[] = array(
            "title"     => "Data Bukti Payment Request",
            "url"       => $this->own_link
        );

        $this->is_search_date = true;

        if (!isset($this->jCfg['search']['class']) || $this->jCfg['search']['class'] != $this->_getClass()) {
            $this->_reset();
            redirect($this->own_link);
        }


        $this->cat_search = array(
            ''                  => 'All',
            'tahun_angka'       => 'Tahun',
            'payment_kode'      => 'Doc No',
            'vendor_nama'       => 'Nama Vendor',
            'bank_nama'         => 'Nama Bank',
            'pb_norek'          => 'No. Rekening',
            'pb_text'           => 'Uraian'

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
            'order_by'  => 'payment_id',
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

        $this->db->order_by('app_payment.payment_kode', 'DESC');
        $this->db->order_by('app_payment_bank.pb_tgl', 'ASC');
        //$this->db->order_by('app_bank.bank_nama', 'ASC');
        $this->db->order_by('app_payment_bank.pb_bank_id', 'ASC');
        $this->db->order_by('app_payment_bank.pb_norek', 'ASC');
        $this->db->order_by('app_payment_bank.pb_text', 'ASC');
        //$this->db->where('app_payment.payment_tahun',10);
        $par_filter = array(
            "offset"    => (int) $this->uri->segment($this->uri_segment),
            "limit"     => $this->per_page,
            "param"     => $this->cat_search
        );
        $this->data_table = $this->M->payment($par_filter);
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

    function view()
    {
        $this->breadcrumb[] = array(
            "title"     => "View"
        );

        $id = _decrypt(dbClean(trim($this->input->get('_id'))));

        if (trim($id) != '') {
            $this->data_form = $this->DATA->data_id(array(
                'payment_id'    => $id
            ));

            $this->db->order_by('app_payment_bank.pb_tgl', 'ASC');
            $this->db->order_by('app_payment_bank.pb_bank_id', 'ASC');
            $this->db->order_by('app_payment_bank.pb_norek', 'ASC');
            $this->db->order_by('app_payment_bank.pb_text', 'ASC');
            $this->load->model("mdl_master", "M");
            $bank = $this->db->get_where("app_payment_bank", array("pb_payment_id" => $id))->result();

            $par = array();
            if (count($bank)) {
                $par['bank'] = $bank;
            }
            $this->_v($this->folder_view . $this->prefix_view . "_view", $par);
        } else {
            redirect($this->own_link);
        }
    }

    function export_data()
    {
        $par_filter = array(
            "param"     => $this->cat_search
        );
        $this->db->order_by("app_payment.payment_kode", "ASC");
        $this->db->order_by('app_payment_bank.pb_tgl', 'ASC');
        $this->db->order_by("app_payment_bank.pb_bank_id", "ASC");
        $this->db->order_by("app_payment_bank.pb_norek", "ASC");
        $this->db->order_by("app_payment_bank.pb_text", "ASC");
        $this->db->where("app_payment_bank.pb_status !=", 3);
        //$this->db->where("app_payment.payment_tahun",10);
        $data = $this->M->payment($par_filter);
        $this->_v($this->folder_view . $this->prefix_view . "_export", $data, false);
    }

    function edit()
    {
        $id = _decrypt(dbClean(trim($this->input->get('_id'))));
        $this->breadcrumb[] = array(
            "title"        => "Edit"
        );

        $id = dbClean(trim($id));

        if (trim($id) != '') {
            $this->data_form = $this->DATA->data_id(array(
                'payment_id'    => $id
            ));

            $this->db->order_by("app_payment_bank.pb_tgl", "ASC");
            $this->db->order_by("app_payment_bank.pb_bank_id", "ASC");
            $this->db->order_by("app_payment_bank.pb_norek", "ASC");

            $detail_photo = $this->db->get_where("app_payment_bank", array(
                'pb_payment_id'    => $id
            ))->result();

            $this->_v($this->folder_view . $this->prefix_view . "_form", array(
                "detail_photo" => $detail_photo
            ));
        } else {
            redirect($this->own_link);
        }
    }

    // function edit()
    // {

    //     $this->breadcrumb[] = array(
    //         "title"     => "Edit"
    //     );
    //     $id = _decrypt(dbClean(trim($this->input->get('_id'))));

    //     if (trim($id) != '') {
    //         $this->data_form = $this->DATA->data_id(array(
    //             'payment_id'    => $id
    //         ));

    //         $this->db->order_by("app_payment_bank.pb_tgl", "ASC");
    //         $this->db->order_by("app_payment_bank.pb_bank_id", "ASC");
    //         $this->db->order_by("app_payment_bank.pb_norek", "ASC");
    //         $detail_photo = $this->db->get_where("app_payment_bank", array("pb_payment_id" => $id))->result();

    //         $par = array();
    //         if (count($detail_photo)) {
    //             $par['bank'] = $detail_photo;
    //         }

    //         $this->_v($this->folder_view . $this->prefix_view . "_form", $par);
    //     } else {
    //         redirect($this->own_link);
    //     }
    // }

    function delete()
    {
        $id = _decrypt(dbClean(trim($this->input->get('_id'))));
        if (trim($id) != '') {
            $o = $this->DATA->_delete(
                array("payment_id" => idClean($id))
            );
        }

        redirect($this->own_link . "?msg=" . urldecode('Delete data user success') . "&type_msg=success");
    }

    function save()
    {

        $data = array(
            'payment_kode'          => $this->input->post('payment_kode'),
            'payment_tahun'         => $this->input->post('payment_tahun'),
            'payment_vendor_id'     => $this->input->post('payment_vendor_id'),
            'payment_nama'          => $this->input->post('payment_nama'),
            'payment_reference'     => $this->input->post('payment_reference'),
            'payment_dateentry'     => $this->input->post('payment_dateentry'),
            'payment_datepayment'   => $this->input->post('payment_datepayment'),
            'payment_status'        => $this->input->post('payment_status')
        );

        $a = $this->_save_master(
            $data,
            array(
                'payment_id' => dbClean($_POST['payment_id'])
            ),
            dbClean($_POST['payment_id'])
        );

        $id = $a['id'];
        $this->_uploaded(
            array(
                'id'        => $id,
                'input'     => 'payment_photo',
                'param'     => array(
                    'field' => 'payment_photo',
                    'par'   => array('payment_id' => $id)
                )
            )
        );

        //save bank..
        // $this->db->delete("app_payment_bank", array("pb_payment_id" => $id));
        // if (isset($_POST['bank_nama']) && count($_POST['bank_nama'])) {
        //     foreach ((array)$this->input->post('bank_nama') as $k => $v) {
        //         $this->db->insert("app_payment_bank", array(
        //             "pb_payment_id" => $id,
        //             "pb_norek"      => dbClean($_POST['pc_norek'][$k]),
        //             "pb_bank_id"    => dbClean($v),
        //             "pb_text"       => dbClean($_POST['pc_text'][$k]),
        //             "pb_qty"        => dbClean($_POST['pc_qty'][$k]),
        //             "pb_amount"     => dbClean($_POST['pc_amount'][$k]),
        //             "pb_tax"        => dbClean($_POST['pc_tax'][$k]),
        //             "pb_thn"        => dbClean($_POST['pc_thn'][$k]),
        //             "pb_tgl"        => dbClean($_POST['pc_tgl'][$k]),
        //             "pb_status"     => dbClean($_POST['pc_status'][$k]),
        //             "time_update"   => date("Y-m-d H:i:s")
        //         ));
        //     }
        // }

        if (isset($_POST['bank_nama']) && count($_POST['bank_nama']) > 0) {

            $cek = $this->db->get_where("app_payment_bank", array(
                'pb_payment_id' => $id
            ))->result();

            $id_current_arr = array();
            if (count($cek) > 0) {
                foreach ($cek as $mm => $vv) {
                    $id_current_arr[] = $vv->pb_id;
                }
            }

            $item_del_arr = array();
            foreach ($_POST['bank_nama'] as $kd => $vd) {

                $cek_pd = $this->db->get_where("app_payment_bank", array(
                    'pb_id' => $kd
                ))->row();


                if (count($cek_pd) == 0) {
                    //insert item..			
                    $this->db->insert("app_payment_bank", array(
                        "pb_payment_id"     => $id,
                        "pb_norek"          => dbClean($_POST['pc_norek'][$kd]),
                        "pb_bank_id"        => dbClean($vd),
                        "pb_text"           => dbClean($_POST['pc_text'][$kd]),
                        "pb_qty"            => dbClean($_POST['pc_qty'][$kd]),
                        "pb_amount"         => dbClean($_POST['pc_amount'][$kd]),
                        "pb_tax"            => dbClean($_POST['pc_tax'][$kd]),
                        "pb_thn"            => dbClean($_POST['pc_thn'][$kd]),
                        "pb_tgl"            => dbClean($_POST['pc_tgl'][$kd]),
                        "pb_status"         => dbClean($_POST['pc_status'][$kd]),
                        "user_add"          => $this->jCfg['user']['id'],
                        "time_add"          => date("Y-m-d H:i:s")
                    ));
                    $item_id = $this->db->insert_id();
                } else {
                    $this->db->update("app_payment_bank", array(
                        "pb_payment_id"     => $id,
                        "pb_norek"          => dbClean($_POST['pc_norek'][$kd]),
                        "pb_bank_id"        => dbClean($vd),
                        "pb_text"           => dbClean($_POST['pc_text'][$kd]),
                        "pb_qty"            => dbClean($_POST['pc_qty'][$kd]),
                        "pb_amount"         => dbClean($_POST['pc_amount'][$kd]),
                        "pb_tax"            => dbClean($_POST['pc_tax'][$kd]),
                        "pb_thn"            => dbClean($_POST['pc_thn'][$kd]),
                        "pb_tgl"            => dbClean($_POST['pc_tgl'][$kd]),
                        "pb_status"         => dbClean($_POST['pc_status'][$kd]),
                        "user_update"       => $this->jCfg['user']['id'],
                        "time_update"       => date("Y-m-d H:i:s")
                    ), array(
                        "pb_id"        => $kd
                    ));
                    $item_id = $kd;
                }

                $item_del_arr[] = $item_id;

                //upload item gallery..
                $this->DATA->table = 'app_payment_bank';
                if ($_FILES['file_' . $kd]['error'] != 4) {

                    $this->_uploaded(
                        array(
                            'id'        => $item_id,
                            'input'        => 'file_' . $kd,
                            'param'        => array(
                                'field' => 'pb_file',
                                'par'    => array('pb_id' => $item_id)
                            )
                        )
                    );
                }
            }

            //delete item..
            if (count($id_current_arr) > 0) {
                foreach ($id_current_arr as $ov) {
                    if (!in_array($ov, $item_del_arr)) {

                        $this->db->delete("app_payment_bank", array(
                            'pb_id' => $ov
                        ));
                    }
                }
            }
        }

        redirect($this->own_link . "?msg=" . urldecode('Save / Update Data Success') . "&type_msg=success");
    }
}
