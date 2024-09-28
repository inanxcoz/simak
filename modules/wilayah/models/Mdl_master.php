<?php
class mdl_master extends CI_Model
{

    var $table = '';

    function __construct()
    {
        parent::__construct();
    }

    function kabupaten($p = array(), $count = FALSE)
    {

        $total = 0;

        /* table conditions */
        $this->db->select("app_kabupaten.*,app_propinsi.propinsi_nama");
        $this->db->join("app_propinsi", "app_propinsi.propinsi_id = app_kabupaten.kab_prov_id");

        /* where or like conditions */
        if (trim($this->jCfg['search']['date_start']) != "" && trim($this->jCfg['search']['date_end']) != "") {
            $date_start = date("Y-m-d", strtotime($this->jCfg['search']['date_start']));
            $date_end = date("Y-m-d", strtotime($this->jCfg['search']['date_end']));

            $this->db->where("( app_kabupaten.inv_tgl >= '" . $date_start . "' AND app_kabupaten.inv_tgl <= '" . $date_end . "' )");
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

        $qry = $this->db->get("app_kabupaten");

        if ($count == FALSE) {
            $total = $this->kabupaten($p, TRUE);
            return array(
                "data"  => $qry->result(),
                "total" => $total
            );
        } else {
            return $qry->num_rows();
        }
    }

    function kecamatan($p = array(), $count = FALSE)
    {

        $total = 0;

        /* table conditions */
        $this->db->select("app_kecamatan.*,app_propinsi.propinsi_nama,app_kabupaten.kab_nama");
        $this->db->join("app_propinsi", "app_propinsi.propinsi_id=app_kecamatan.kec_prov_id", 'LEFT');
        $this->db->join("app_kabupaten", "app_kabupaten.kab_id=app_kecamatan.kec_kab_id", 'LEFT');

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

        $qry = $this->db->get("app_kecamatan");

        if ($count == FALSE) {
            $total = $this->kecamatan($p, TRUE);
            return array(
                "data"  => $qry->result(),
                "total" => $total
            );
        } else {
            return $qry->num_rows();
        }
    }

    function kelurahan($p = array(), $count = FALSE)
    {

        $total = 0;

        /* table conditions */
        $this->db->select("app_kelurahan.*,app_propinsi.propinsi_nama,app_kabupaten.kab_nama,app_kecamatan.kec_nama");
        $this->db->join("app_propinsi", "app_propinsi.propinsi_id=app_kelurahan.kel_prov_id", 'LEFT');
        $this->db->join("app_kabupaten", "app_kabupaten.kab_id=app_kelurahan.kel_kab_id", 'LEFT');
        $this->db->join("app_kecamatan", "app_kecamatan.kec_id=app_kelurahan.kel_kec_id", 'LEFT');

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

        $qry = $this->db->get("app_kelurahan");

        if ($count == FALSE) {
            $total = $this->kelurahan($p, TRUE);
            return array(
                "data"  => $qry->result(),
                "total" => $total
            );
        } else {
            return $qry->num_rows();
        }
    }

    function propinsi($p = array(), $count = FALSE)
    {

        $total = 0;

        /* table conditions */
        $this->db->select('app_propinsi.*');
        $this->db->where('app_propinsi.is_trash', 0);

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

        $qry = $this->db->get("app_propinsi");
        
        if ($count == FALSE) {
            $total = $this->propinsi($p, TRUE);
            return array(
                "data"  => $qry->result(),
                "total" => $total
            );
        } else {
            return $qry->num_rows();
        }
    }
}
