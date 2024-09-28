<?php
class mdl_master extends CI_Model
{

    var $table = '';

    function __construct()
    {
        parent::__construct();
    }

    function invoice($p = array(), $count = FALSE)
    {

        $total = 0;

        /* table conditions */
        $this->db->select("app_invoice.*,app_client.client_nama,app_client.client_npwp,app_nsfp.nsfp_nomor,app_tahun.tahun_angka,app_pajak.pajak_ntpn,app_pajak.pajak_billing,app_pajak.pajak_tgl,app_pajak.pajak_bupot,app_pajak.pajak_tgl_bupot");
        $this->db->where("app_invoice.is_trash", 0);
        $this->db->join("app_client", "app_client.client_id=app_invoice.inv_client_id", 'LEFT');
        $this->db->join("app_nsfp", "app_nsfp.nsfp_id=app_invoice.inv_nsfp", 'LEFT');
        $this->db->join("app_tahun", "app_tahun.tahun_angka=app_invoice.inv_tahun", 'LEFT');
        $this->db->join("app_pajak", "app_pajak.pajak_id=app_invoice.inv_ntpn", 'LEFT');

        /* where or like conditions */
        if (trim($this->jCfg['search']['date_start']) != "" && trim($this->jCfg['search']['date_end']) != "") {
            $date_start = date("Y-m-d", strtotime($this->jCfg['search']['date_start']));
            $date_end = date("Y-m-d", strtotime($this->jCfg['search']['date_end']));

            $this->db->where("( app_invoice.inv_tgl >= '" . $date_start . "' AND app_invoice.inv_tgl <= '" . $date_end . "' )");
        }

        // dont modified....
        if (trim($this->jCfg['search']['colum']) == "" && trim($this->jCfg['search']['keyword']) != "") {
            $str_like = "( ";
            $i = 0;
            foreach ($p['param'] as $key => $value) {
                if ($key != "") {
                    $str_like .= $i != 0 ? "OR" : "";
                    $str_like .= " " . $key . " LIKE '%" . $this->jCfg['search']['keyword'] . "%' ";
                    $i++;
                }
            }
            $str_like .= " ) ";
            $this->db->where($str_like);
        }

        if (trim($this->jCfg['search']['colum']) != "" && trim($this->jCfg['search']['keyword']) != "") {
            $this->db->like($this->jCfg['search']['colum'], $this->jCfg['search']['keyword']);
        }

        if ($count == FALSE) {
            if (isset($p['offset']) && isset($p['limit'])) {
                $p['offset'] = empty($p['offset']) ? 0 : $p['offset'];
                $this->db->limit($p['limit'], $p['offset']);
            }
        }

        if (trim($this->jCfg['search']['order_by']) != "")
            $this->db->order_by($this->jCfg['search']['order_by'], $this->jCfg['search']['order_dir']);

        $qry = $this->db->get("app_invoice");

        if ($count == FALSE) {
            $total = $this->invoice($p, TRUE);
            return array(
                "data"  => $qry->result(),
                "total" => $total
            );
        } else {
            return $qry->num_rows();
        }
    }

    function karyawan($p = array(), $count = FALSE)
    {

        $total = 0;

        /* table conditions */
        $this->db->select("app_karyawan.*,app_propinsi.propinsi_nama,app_kabupaten.kab_nama,app_kecamatan.kec_nama,app_kelurahan.kel_nama,,app_kelurahan.kel_kode_pos");
        $this->db->join("app_propinsi", "app_propinsi.propinsi_id=app_karyawan.karyawan_prov_id", 'LEFT');
        $this->db->join("app_kabupaten", "app_kabupaten.kab_id=app_karyawan.karyawan_kab_id", 'LEFT');
        $this->db->join("app_kecamatan", "app_kecamatan.kec_id=app_karyawan.karyawan_kec_id", 'LEFT');
        $this->db->join("app_kelurahan", "app_kelurahan.kel_id=app_karyawan.karyawan_kel_id", 'LEFT');

        /* where or like conditions */
        if (trim($this->jCfg['search']['date_start']) != "" && trim($this->jCfg['search']['date_end']) != "") {
            $this->db->where("( time_date >= '" . $this->jCfg['search']['date_start'] . "' AND time_date <= '" . $this->jCfg['search']['date_end'] . "' )");
        }

        // dont modified....
        if (trim($this->jCfg['search']['colum']) == "" && trim($this->jCfg['search']['keyword']) != "") {
            $str_like = "( ";
            $i = 0;
            foreach ($p['param'] as $key => $value) {
                if ($key != "") {
                    $str_like .= $i != 0 ? "OR" : "";
                    $str_like .= " " . $key . " LIKE '%" . $this->jCfg['search']['keyword'] . "%' ";
                    $i++;
                }
            }
            $str_like .= " ) ";
            $this->db->where($str_like);
        }

        if (trim($this->jCfg['search']['colum']) != "" && trim($this->jCfg['search']['keyword']) != "") {
            $this->db->like($this->jCfg['search']['colum'], $this->jCfg['search']['keyword']);
        }

        if ($count == FALSE) {
            if (isset($p['offset']) && isset($p['limit'])) {
                $p['offset'] = empty($p['offset']) ? 0 : $p['offset'];
                $this->db->limit($p['limit'], $p['offset']);
            }
        }

        if (trim($this->jCfg['search']['order_by']) != "")
            $this->db->order_by($this->jCfg['search']['order_by'], $this->jCfg['search']['order_dir']);

        $qry = $this->db->get("app_karyawan");

        if ($count == FALSE) {
            $total = $this->karyawan($p, TRUE);
            return array(
                "data"  => $qry->result(),
                "total" => $total
            );
        } else {
            return $qry->num_rows();
        }
    }

    function payment($p = array(), $count = FALSE)
    {

        $total = 0;

        /* table conditions */
        $this->db->select("app_payment.*,
            app_vendor.vendor_kode,app_vendor.vendor_nama,app_vendor.vendor_norek,
            app_bank.bank_nama,app_bank.bank_kliring,
            app_tahun.tahun_angka,
            app_status.status_nama,
            app_payment_bank.pb_norek,app_payment_bank.pb_text,app_payment_bank.pb_qty,app_payment_bank.pb_amount,app_payment_bank.pb_tax,app_payment_bank.pb_tgl,app_payment_bank.pb_status,app_payment_bank.pb_file");
        $this->db->where("app_payment.is_trash", 0);

        $this->db->join("app_payment_bank", "app_payment.payment_id=app_payment_bank.pb_payment_id", 'LEFT');
        //$this->db->join("app_payment_bank", "app_payment.payment_id=app_payment_bank.pb_status", 'LEFT');
        $this->db->join("app_bank", "app_bank.bank_id=app_payment_bank.pb_bank_id", 'LEFT');
        $this->db->join("app_vendor", "app_vendor.vendor_id=app_payment.payment_vendor_id", 'LEFT');
        $this->db->join("app_tahun", "app_tahun.tahun_angka=app_payment.payment_tahun", 'LEFT');
        $this->db->join("app_status", "app_status.status_id=app_payment_bank.pb_status", 'LEFT');

        /* where or like conditions */
        if (trim($this->jCfg['search']['date_start']) != "" && trim($this->jCfg['search']['date_end']) != "") {
            $date_start = date("Y-m-d", strtotime($this->jCfg['search']['date_start']));
            $date_end = date("Y-m-d", strtotime($this->jCfg['search']['date_end']));

            $this->db->where("( app_payment.payment_dateentry >= '" . $date_start . "' AND app_payment.payment_dateentry <= '" . $date_end . "' )");
        }

        // dont modified....
        if (trim($this->jCfg['search']['colum']) == "" && trim($this->jCfg['search']['keyword']) != "") {
            $str_like = "( ";
            $i = 0;
            foreach ($p['param'] as $key => $value) {
                if ($key != "") {
                    $str_like .= $i != 0 ? "OR" : "";
                    $str_like .= " " . $key . " LIKE '%" . $this->jCfg['search']['keyword'] . "%' ";
                    $i++;
                }
            }
            $str_like .= " ) ";
            $this->db->where($str_like);
        }

        if (trim($this->jCfg['search']['colum']) != "" && trim($this->jCfg['search']['keyword']) != "") {
            $this->db->like($this->jCfg['search']['colum'], $this->jCfg['search']['keyword']);
        }

        if ($count == FALSE) {
            if (isset($p['offset']) && isset($p['limit'])) {
                $p['offset'] = empty($p['offset']) ? 0 : $p['offset'];
                $this->db->limit($p['limit'], $p['offset']);
            }
        }

        if (trim($this->jCfg['search']['order_by']) != "")
            $this->db->order_by($this->jCfg['search']['order_by'], $this->jCfg['search']['order_dir']);

        //$this->db->group_by('payment_id');
        $qry = $this->db->get("app_payment");
        if ($count == FALSE) {
            $total = $this->payment($p, TRUE);
            return array(
                "data"  => $qry->result(),
                "total" => $total
            );
        } else {
            return $qry->num_rows();
        }
    }
}
