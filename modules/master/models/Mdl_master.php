<?php
class mdl_master extends CI_Model
{

    var $table = '';

    function __construct()
    {
        parent::__construct();
    }

    function bank($p = array(), $count = FALSE)
    {

        $total = 0;

        /* table conditions */
        $this->db->select('app_bank.*');
        $this->db->where('app_bank.is_trash', 0);

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

        $qry = $this->db->get("app_bank");

        if ($count == FALSE) {
            $total = $this->bank($p, TRUE);
            return array(
                "data"  => $qry->result(),
                "total" => $total
            );
        } else {
            return $qry->num_rows();
        }
    }    

    function client($p = array(), $count = FALSE)
    {

        $total = 0;

        /* table conditions */
        $this->db->select('app_client.*');
        $this->db->where('app_client.is_trash', 0);

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

        $qry = $this->db->get("app_client");

        if ($count == FALSE) {
            $total = $this->client($p, TRUE);
            return array(
                "data"  => $qry->result(),
                "total" => $total
            );
        } else {
            return $qry->num_rows();
        }
    }

    function faktur($p = array(), $count = FALSE)
    {

        $total = 0;

        /* table conditions */
        $this->db->select("app_nsfp.*,app_tahun.tahun_angka");
        $this->db->where("app_nsfp.is_trash", 0);
        $this->db->join("app_tahun", "app_tahun.tahun_id=app_nsfp.nsfp_tahun_id", 'LEFT');

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

        $qry = $this->db->get("app_nsfp");

        if ($count == FALSE) {
            $total = $this->faktur($p, TRUE);
            return array(
                "data"  => $qry->result(),
                "total" => $total
            );
        } else {
            return $qry->num_rows();
        }
    }

    function tahun_aplikasi($p = array(), $count = FALSE)
    {

        $total = 0;

        /* table conditions */
        $this->db->select('app_tahun.*');
        $this->db->where('app_tahun.is_trash', 0);

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

        $qry = $this->db->get("app_tahun");

        if ($count == FALSE) {
            $total = $this->tahun_aplikasi($p, TRUE);
            return array(
                "data"  => $qry->result(),
                "total" => $total
            );
        } else {
            return $qry->num_rows();
        }
    }

    function vendor($p = array(), $count = FALSE)
    {

        $total = 0;

        /* table conditions */
        $this->db->select('app_vendor.*,app_bank.bank_nama');
        $this->db->where('app_vendor.is_trash', 0);

        $this->db->join('app_bank', 'app_bank.bank_id=app_vendor.vendor_bank_id', 'LEFT');

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

        $qry = $this->db->get("app_vendor");

        if ($count == FALSE) {
            $total = $this->vendor($p, TRUE);
            return array(
                "data"  => $qry->result(),
                "total" => $total
            );
        } else {
            return $qry->num_rows();
        }
    }
}
