<?php
class mdl_master extends CI_Model
{

    var $table = '';

    function __construct()
    {
        parent::__construct();
    }

    function kasbon($p = array(), $count = FALSE)
    {

        $total = 0;

        /* table conditions */
        //app_vendor.vendor_kode,app_vendor.vendor_nama,app_vendor.vendor_norek,
        $this->db->select("app_kasbon.*,
            app_karyawan.karyawan_nama,
            app_cicilan.cicilan_nama,
            app_status.status_nama,
            app_kasbon_detail.kd_kasbon_id,app_kasbon_detail.kd_nominal,app_kasbon_detail.kd_cicilan_id,app_kasbon_detail.kd_tgl,app_kasbon_detail.kd_status");
        $this->db->where("app_kasbon.is_trash", 0);

        $this->db->join("app_kasbon_detail", "app_kasbon.kasbon_id=app_kasbon_detail.kd_kasbon_id", 'LEFT');
        $this->db->join("app_karyawan", "app_karyawan.karyawan_id=app_kasbon.kasbon_nama_id", 'LEFT');
        $this->db->join("app_cicilan", "app_cicilan.cicilan_id=app_kasbon_detail.kd_cicilan_id", 'LEFT');
        $this->db->join("app_status", "app_status.status_id=app_kasbon_detail.kd_status", 'LEFT');

        /* where or like conditions */
        if (trim($this->jCfg['search']['date_start']) != "" && trim($this->jCfg['search']['date_end']) != "") {
            $date_start = date("Y-m-d", strtotime($this->jCfg['search']['date_start']));
            $date_end = date("Y-m-d", strtotime($this->jCfg['search']['date_end']));

            $this->db->where("( app_kasbon.kasbon_tgl >= '" . $date_start . "' AND app_kasbon.kasbon_tgl <= '" . $date_end . "' )");
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

        //$this->db->group_by('kasbon_id');
        $qry = $this->db->get("app_kasbon");
        if ($count == FALSE) {
            $total = $this->kasbon($p, TRUE);
            return array(
                "data"  => $qry->result(),
                "total" => $total
            );
        } else {
            return $qry->num_rows();
        }
    }

    function pajak($p = array(), $count = FALSE)
    {

        $total = 0;

        /* table conditions */
        $this->db->select("app_pajak.*,app_tahun.tahun_angka");
        $this->db->where("app_pajak.is_trash", 0);
        $this->db->join("app_tahun", "app_tahun.tahun_angka=app_pajak.pajak_tahun", 'LEFT');

        /* where or like conditions */
        /* where or like conditions */
        if (trim($this->jCfg['search']['date_start']) != "" && trim($this->jCfg['search']['date_end']) != "") {
            $date_start = date("Y-m-d", strtotime($this->jCfg['search']['date_start']));
            $date_end = date("Y-m-d", strtotime($this->jCfg['search']['date_end']));

            $this->db->where("( app_pajak.pajak_tgl >= '" . $date_start . "' AND app_pajak.pajak_tgl <= '" . $date_end . "' )");
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

        $qry = $this->db->get("app_pajak");

        if ($count == FALSE) {
            $total = $this->pajak($p, TRUE);
            return array(
                "data"  => $qry->result(),
                "total" => $total
            );
        } else {
            return $qry->num_rows();
        }
    }
    
    function petty($p = array(), $count = FALSE)
    {

        $total = 0;

        /* table conditions */
        $this->db->select("app_petty.*,app_tahun.tahun_angka");
        $this->db->where("app_petty.is_trash", 0);
        $this->db->join("app_tahun", "app_tahun.tahun_id=app_petty.petty_tahun", 'LEFT');

        /* where or like conditions */
        if (trim($this->jCfg['search']['date_start']) != "" && trim($this->jCfg['search']['date_end']) != "") {
            $date_start = date("Y-m-d", strtotime($this->jCfg['search']['date_start']));
            $date_end = date("Y-m-d", strtotime($this->jCfg['search']['date_end']));

            $this->db->where("( app_petty.petty_tgl >= '" . $date_start . "' AND app_petty.petty_tgl <= '" . $date_end . "' )");
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

        $qry = $this->db->get("app_petty");

        if ($count == FALSE) {
            $total = $this->petty($p, TRUE);
            return array(
                "data"  => $qry->result(),
                "total" => $total
            );
        } else {
            return $qry->num_rows();
        }
    }

    function pph($p = array(), $count = FALSE)
    {

        $total = 0;

        /* table conditions */
        $this->db->select("app_pph.*,app_tahun.tahun_angka");
        $this->db->where("app_pph.is_trash", 0);
        $this->db->join("app_tahun", "app_tahun.tahun_id=app_pph.pajak_tahun", 'LEFT');

        /* where or like conditions */
        if (trim($this->jCfg['search']['date_start']) != "" && trim($this->jCfg['search']['date_end']) != "") {
            $date_start = date("Y-m-d", strtotime($this->jCfg['search']['date_start']));
            $date_end = date("Y-m-d", strtotime($this->jCfg['search']['date_end']));

            $this->db->where("( app_pph.pajak_tgl >= '" . $date_start . "' AND app_pph.pajak_tgl <= '" . $date_end . "' )");
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

        $qry = $this->db->get("app_pph");

        if ($count == FALSE) {
            $total = $this->pph($p, TRUE);
            return array(
                "data"  => $qry->result(),
                "total" => $total
            );
        } else {
            return $qry->num_rows();
        }
    }
}
