<?php
function generate_CodePR()
{
  $ci = get_instance();
  $query = "SELECT max(payment_kode) as maxKode FROM app_payment";
  $data = $ci->db->query($query)->row_array();
  $kode = $data['maxKode'];
  $noUrut = (int) substr($kode, 7, 3);
  $noUrut++;
  $char = "PRAMN24";
  $kodeBaru = $char.sprintf("%03s", $noUrut);
  return $kodeBaru;
}

function hitung_jasprof($p = array())
{
  $tipologi   = $p['tipologi'];
  $jumlah     = $p['jumlah'];

  $hasil = 0;
  if (trim($tipologi) == 'A') {
    $hasil = $jumlah * 125000;
  }

  if (trim($tipologi) == 'B') {
    $hasil = $jumlah * 150000;
  }

  if (trim($tipologi) == 'C') {
    $hasil = $jumlah * 175000;
  }

  if (trim($tipologi) == 'D1') {
    $hasil = $jumlah * 400000;
  }

  if (trim($tipologi) == 'D2') {
    $hasil = $jumlah * 400000;
  }

  return $hasil;
}

function getInfo($limit = 3)
{
  $CI = getCI();
  $CI->db->limit($limit);
  $CI->db->order_by("info_id", "DESC");
  return $CI->db->get_where("web_info", array(
    "info_status" => 1
  ))->result();
}

function hitung_pnbp($p = array())
{
  $CI = getCI();

  $CI->db->select("
                web_kua_laporan_pnbp.pnbp_province as pnbp_province,app_propinsi.propinsi_nama as provinsi,
                web_kua_laporan_pnbp.pnbp_city as pnbp_city,app_kabupaten.kab_nama as city,web_kua_laporan_pnbp.pnbp_tahun as pnbp_tahun,
                web_profile_kua.profile_id as profile_id,web_profile_kua.profile_kua_name as kua,
                sum(ppt_jan_jp) as  jp_jan,sum(ppt_feb_jp) as  jp_feb,sum(ppt_mar_jp) as  jp_mar,sum(ppt_apr_jp) as  jp_apr,
                sum(ppt_mei_jp) as  jp_mei,sum(ppt_jun_jp) as  jp_jun,sum(ppt_jul_jp) as  jp_jul,sum(ppt_agst_jp) as  jp_agst,
                sum(ppt_sept_jp) as  jp_sept,sum(ppt_okt_jp) as  jp_okt,sum(ppt_nov_jp) as  jp_nov,sum(ppt_des_jp) as  jp_des,
                sum(ppt_jan_t) as  t_jan,sum(ppt_feb_t) as  t_feb,sum(ppt_mar_t) as  t_mar,sum(ppt_apr_t) as  t_apr,
                sum(ppt_mei_t) as  t_mei,sum(ppt_jun_t) as  t_jun,sum(ppt_jul_t) as  t_jul,sum(ppt_agst_t) as  t_agst,
                sum(ppt_sept_t) as  t_sept,sum(ppt_okt_t) as  t_okt,sum(ppt_nov_t) as  t_nov,sum(ppt_des_t) as  t_des,
                sum(ppt_jan_kantor) as  kantor_jan,sum(ppt_feb_kantor) as  kantor_feb,sum(ppt_mar_kantor) as  kantor_mar,sum(ppt_apr_kantor) as  kantor_apr,
                sum(ppt_mei_kantor) as  kantor_mei,sum(ppt_jun_kantor) as  kantor_jun,sum(ppt_jul_kantor) as  kantor_jul,sum(ppt_agst_kantor) as  kantor_agst,
                sum(ppt_sept_kantor) as  kantor_sept,sum(ppt_okt_kantor) as  kantor_okt,sum(ppt_nov_kantor) as  kantor_nov,sum(ppt_des_kantor) as  kantor_des,
                sum(ppt_jan_luar_kantor) as  luar_kantor_jan,sum(ppt_feb_luar_kantor) as  luar_kantor_feb,sum(ppt_mar_luar_kantor) as  luar_kantor_mar,sum(ppt_apr_luar_kantor) as  luar_kantor_apr,
                sum(ppt_mei_luar_kantor) as  luar_kantor_mei,sum(ppt_jun_luar_kantor) as  luar_kantor_jun,sum(ppt_jul_luar_kantor) as  luar_kantor_jul,sum(ppt_agst_luar_kantor) as  luar_kantor_agst,
                sum(ppt_sept_luar_kantor) as  luar_kantor_sept,sum(ppt_okt_luar_kantor) as  luar_kantor_okt,sum(ppt_nov_luar_kantor) as  luar_kantor_nov,sum(ppt_des_luar_kantor) as  luar_kantor_des
            ");

  $CI->db->join("app_propinsi", "web_kua_laporan_pnbp.pnbp_province = app_propinsi.propinsi_id");
  $CI->db->join("app_kabupaten", "app_kabupaten.kab_id = web_kua_laporan_pnbp.pnbp_city");
  $CI->db->join("web_kua_laporan_pnbp_list", "web_kua_laporan_pnbp_list.ppt_pnbp_id = web_kua_laporan_pnbp.pnbp_id");
  $CI->db->join("web_profile_kua", "web_profile_kua.profile_id = web_kua_laporan_pnbp_list.ppt_profile_id");
  if (isset($p['tahun'])  && trim($p['tahun']) != "") {
    $CI->db->where("web_kua_laporan_pnbp.pnbp_tahun", $p['tahun']);
  }

  if (isset($p['prov'])  && trim($p['prov']) != "" && trim($p['prov']) != "0") {
    $CI->db->where("web_kua_laporan_pnbp.pnbp_province", $p['prov']);
  }

  if (isset($p['city'])  && trim($p['city']) != "" && trim($p['city']) != "0") {
    $CI->db->where("web_kua_laporan_pnbp.pnbp_city", $p['city']);
  }

  if (isset($p['prov'])  && trim($p['prov']) != "" && trim($p['prov']) != "0") {
    if (isset($p['city'])  && trim($p['city']) != "" && trim($p['city']) != "0") {

      $CI->db->group_by("web_kua_laporan_pnbp.pnbp_city");
      $CI->db->order_by('app_kabupaten.kab_nama');
    } else {
      $CI->db->group_by("web_kua_laporan_pnbp.pnbp_province");
      $CI->db->order_by('app_propinsi.propinsi_nama');
    }
  }

  return $CI->db->get("web_kua_laporan_pnbp")->row_array();
}

function hitung_transport($p = array())
{
  $tipologi   = $p['tipologi'];
  $jumlah     = $p['jumlah'];

  $hasil = 0;
  if (trim($tipologi) == 'A' || trim($tipologi) == 'B' || trim($tipologi) == 'C') {
    $hasil = $jumlah * 100000;
  }

  if (trim($tipologi) == 'D1') {
    $hasil = $jumlah * 750000;
  }

  if (trim($tipologi) == 'D2') {
    $hasil = $jumlah * 1000000;
  }

  return $hasil;
}

function get_form_mp($p = array())
{
  $CI = getCI();
  $tahun = isset($p['tahun']) ? $p['tahun'] : '';
  $prov = isset($p['prov']) ? $p['prov'] : '';
  $kab = isset($p['kab']) ? $p['kab'] : '';

  $data = array();
  if (trim($tahun) != "" && trim($prov) != "" && trim($kab) != "") {
    $CI->db->select("pps_id,pps_tahap,pps_bulan,
			sum(ppsd_jan_subsidi) as jan_subsidi,sum(ppsd_feb_subsidi) as feb_subsidi,sum(ppsd_mar_subsidi) as mar_subsidi,
			sum(ppsd_apr_subsidi) as apr_subsidi,sum(ppsd_mei_subsidi) as mei_subsidi,sum(ppsd_jun_subsidi) as jun_subsidi,
			sum(ppsd_jul_subsidi) as jul_subsidi,sum(ppsd_agst_subsidi) as agst_subsidi,sum(ppsd_sept_subsidi) as sept_subsidi,
			sum(ppsd_okt_subsidi) as okt_subsidi,sum(ppsd_nov_subsidi) as nov_subsidi,sum(ppsd_des_subsidi) as des_subsidi
		");
    $CI->db->join("web_kua_pnbp_subsidi_list", "web_kua_pnbp_subsidi_list.ppsd_pps_id = web_kua_pnbp_subsidi.pps_id");
    $CI->db->where(array(
      "pps_tahun"   => $tahun,
      "pps_city"     => $kab,
      "pps_province"   => $prov
    ));
    $CI->db->group_by("pps_id");
    $CI->db->order_by("pps_tahap");
    $CI->db->order_by("pps_bulan");
    $data = $CI->db->get("web_kua_pnbp_subsidi")->result_array();
  }

  return $data;
}

function un_read_notif()
{
  $CI = getCI();
  $CI->db->select("count(msg_id) as jumlah");
  $CI->db->where(" ( msg_to_id ='" . $CI->jCfg['user']['id'] . "' )");
  $CI->db->group_by("msg_to_id");
  return $CI->db->get_where("app_message", array(
    "msg_is_read" => 0
  ))->num_rows();
}
//dashboard....
function get_section()
{
  $CI = getCI();
  $CI->db->order_by("sec_name");
  return $CI->db->get_where("mdr_section", array(
    "sec_status" => 1
  ))->result();
}

function get_user_chat()
{
  $CI = getCI();
  $CI->db->order_by('user_fullname');
  $data = $CI->db->get_where("app_user", array(
    "user_id !=" => $CI->jCfg['user']['id'],
    "user_name !=" => "",
    "user_status" => 1,
    "is_trash" => 0
  ))->result();

  return $data;
}


function get_detail_biaya_pegawai_list($id = "", $tahun = "")
{
  $tahun = trim($tahun) == "" ? date("Y") : $tahun;
  $CI = getCI();
  $sql = '
    select 
      bp_tahun,SUM(bp_jml_pegawai) as jml_pegawai,
      SUM(bp_usul_jml_pegawai) as usul_jml_pegawai
    from web_biaya_pegawai_list 
      where bp_biaya_id = "' . $id . '"
    group by bp_tahun';
  $result = $CI->db->query($sql)->result();
  $data = array();
  foreach ((array)$result as $k => $v) {
    $data[$v->bp_tahun] = array(
      "jml_pegawai"       => $v->jml_pegawai,
      "usul_jml_pegawai"  => $v->usul_jml_pegawai
    );
  }

  return $data;
}


function get_detail_pnbp_list($id = "", $tahun = "")
{
  $tahun = trim($tahun) == "" ? date("Y") : $tahun;
  $CI = getCI();
  $sql = '
    select 
      ppt_tahun,SUM(ppt_luar_kantor) as luar_kantor,
      SUM(ppt_usul_luar_kantor) as usul_luar_kantor,
      SUM(ppt_pagu) as pagu, SUM(ppt_usul_pagu) as usul_pagu 
    from web_kua_target_pnbp_list 
      where ppt_pnbp_id = "' . $id . '"
    group by ppt_tahun';
  $result = $CI->db->query($sql)->result();
  $data = array();
  foreach ((array)$result as $k => $v) {
    $data[$v->ppt_tahun] = array(
      "luar_kantor"       => $v->luar_kantor,
      "usul_luar_kantor"  => $v->usul_luar_kantor,
      "pagu"              => $v->pagu,
      "usul_pagu"         => $v->usul_pagu
    );
  }

  return $data;
}

function get_detail_biaya_usul_pegawai_list($id = "", $tahun = "")
{
  $tahun = trim($tahun) == "" ? date("Y") : $tahun;
  $CI = getCI();
  $sql = '
    select 
      bp_komponen,SUM(bp_jml_pegawai) as jml_pegawai,
      SUM(bp_usul_jml_pegawai) as usul_jml_pegawai
    from web_biaya_pegawai_list 
      where bp_biaya_id = "' . $id . '"
      AND bp_tahun = "' . ($tahun + 1) . '"
    group by bp_komponen';
  $result = $CI->db->query($sql)->result();
  $data = array();
  foreach ((array)$result as $k => $v) {
    $data[$v->bp_komponen] = array(
      //"jml_pegawai"       => $v->jml_pegawai,
      "usul_jml_pegawai"  => $v->usul_jml_pegawai
    );
  }
  return $data;
}

function get_detail_biaya_asn_pegawai_list($id = "", $tahun = "")
{
  $tahun = trim($tahun) == "" ? date("Y") : $tahun;
  $CI = getCI();
  $sql = '
    select 
      asn_type,SUM(asn_jumlah_kota) as jml_kota,
      SUM(asn_jumlah_kua) as jml_kua
    from web_biaya_pegawai_asn 
      where asn_biaya_id = "' . $id . '"
    group by asn_type';
  $result = $CI->db->query($sql)->result();
  $data = array();
  foreach ((array)$result as $k => $v) {
    $data[$v->asn_type] = array(
      "kota"       => $v->jml_kota,
      "kua"        => $v->jml_kua
    );
  }
  return $data;
}

function get_status_data_id($id = "")
{
  $d = cfg('status_data');
  return isset($d[$id]) ? $d[$id] : '-';
}

function get_bulan_data_html($id = "")
{
  $d = cfg('bulan');
  $html = "";
  if ($id == 1) {
    $html = "$d[$id]";
  }
  if ($id == 2) {
    $html = "$d[$id]";
  }
  if ($id == 3) {
    $html = "$d[$id]";
  }
  if ($id == 4) {
    $html = "$d[$id]";
  }
  if ($id == 5) {
    $html = "$d[$id]";
  }
  if ($id == 6) {
    $html = "$d[$id]";
  }
  if ($id == 7) {
    $html = "$d[$id]";
  }
  if ($id == 8) {
    $html = "$d[$id]";
  }
  if ($id == 9) {
    $html = "$d[$id]";
  }
  if ($id == 10) {
    $html = "$d[$id]";
  }
  if ($id == 11) {
    $html = "$d[$id]";
  }
  if ($id == 12) {
    $html = "$d[$id]";
  }
  return $html;
}

function get_pajak_data_html($id = "")
{
  $d = cfg('jenis_pajak');
  $html = "";
  if ($id == 0) {
    $html = "$d[$id]";
  }
  if ($id == 1) {
    $html = "$d[$id]";
  }
  if ($id == 2) {
    $html = "$d[$id]";
  }
  if ($id == 3) {
    $html = "$d[$id]";
  }
  if ($id == 4) {
    $html = "$d[$id]";
  }
  if ($id == 5) {
    $html = "$d[$id]";
  }
  if ($id == 6) {
    $html = "$d[$id]";
  }
  if ($id == 7) {
    $html = "$d[$id]";
  }
  if ($id == 8) {
    $html = "$d[$id]";
  }
  if ($id == 9) {
    $html = "$d[$id]";
  }
  if ($id == 10) {
    $html = "$d[$id]";
  }
  if ($id == 11) {
    $html = "$d[$id]";
  }
  if ($id == 12) {
    $html = "$d[$id]";
  }
  if ($id == 13) {
    $html = "$d[$id]";
  }
  if ($id == 14) {
    $html = "$d[$id]";
  }
  if ($id == 15) {
    $html = "$d[$id]";
  }
  if ($id == 16) {
    $html = "$d[$id]";
  }
  if ($id == 99) {
    $html = "$d[$id]";
  }
  return $html;
}

function get_agama($id = "")
{
  $d = cfg('agama');
  $html = "";
  if ($id == 0) {
    $html = "$d[$id]";
  }

  if ($id == 1) {
    $html = "$d[$id]";
  }

  if ($id == 2) {
    $html = "$d[$id]";
  }

  if ($id == 3) {
    $html = "$d[$id]";
  }

  if ($id == 4) {
    $html = "$d[$id]";
  }

  return $html;
}

function get_jenis_kelamin($id = "")
{
  $d = cfg('jenis_kelamin');
  $html = "";
  if ($id == 1) {
    $html = "$d[$id]";
  }

  if ($id == 2) {
    $html = "$d[$id]";
  }

  return $html;
}

function get_kawin($id = "")
{
  $d = cfg('perkawinan');
  $html = "";
  if ($id == 0) {
    $html = "$d[$id]";
  }

  if ($id == 1) {
    $html = "$d[$id]";
  }

  return $html;
}

function get_nama_data_html($id = "")
{
  $d = cfg('nama');
  $html = "";
  if ($id == 0) {
    $html = "$d[$id]";
  }

  if ($id == 1) {
    $html = "$d[$id]";
  }

  if ($id == 2) {
    $html = "$d[$id]";
  }

  return $html;
}

function get_action_data_html($id = "")
{
  $d = cfg('action');
  $html = "";
  if ($id == 1) {
    $html = "$d[$id]";
  }

  if ($id == 2) {
    $html = "$d[$id]";
  }

  if ($id == 3) {
    $html = "$d[$id]";
  }

  if ($id == 4) {
    $html = "$d[$id]";
  }

  if ($id == 5) {
    $html = "$d[$id]";
  }

  if ($id == 6) {
    $html = "$d[$id]";
  }

  return $html;
}

function get_reference_data_html($id = "")
{
  $d = cfg('reference');
  $html = "";
  if ($id == 0) {
    $html = "$d[$id]";
  }

  if ($id == 1) {
    $html = "$d[$id]";
  }

  if ($id == 2) {
    $html = "$d[$id]";
  }

  if ($id == 3) {
    $html = "$d[$id]";
  }

  if ($id == 4) {
    $html = "$d[$id]";
  }

  if ($id == 5) {
    $html = "$d[$id]";
  }

  if ($id == 6) {
    $html = "$d[$id]";
  }

  if ($id == 7) {
    $html = "$d[$id]";
  }

  return $html;
}

function get_status_data_html($id = "")
{
  $d = cfg('status');
  $html = "";
  if ($id == 0) {
    $html = "<span class='label label-warning'>" . $d[$id] . "</span>";
  }

  if ($id == 1) {
    $html = "<span class='label label-success'>" . $d[$id] . "</span>";
  }

  if ($id == 2) {
    $html = "<span class='label label-danger'>" . $d[$id] . "</span>";
  }

  if ($id == 3) {
    $html = "<span class='label label-info'>" . $d[$id] . "</span>";
  }

  return $html;
}

function get_status_data()
{
  $CI = getCI();
  $d = cfg('status_data');
  if ($CI->jCfg['user']['is_all'] != 1) {

    unset($d[1]);
    unset($d[2]);
  }

  return $d;
}

function get_satker_pusat_id($id = "")
{
  $CI = getCI();
  $CI->db->order_by("sp_name");
  return $CI->db->get_where("web_satker_pusat", array(
    "sp_id" => $id
  ))->row();
}

function get_satker_pusat()
{
  $CI = getCI();
  $CI->db->order_by("sp_name");
  return $CI->db->get_where("web_satker_pusat", array(
    "sp_status" => 1
  ))->result();
}

function get_biaya_operasional_id($id = "")
{
  $CI = getCI();
  return $CI->db->get_where("web_biaya_ops", array(
    "biaya_id" => $id
  ))->row();
}

function get_biaya_operasional()
{
  $CI = getCI();
  $CI->db->order_by("biaya_kode");
  return $CI->db->get_where("web_biaya_ops", array(
    "biaya_status" => 1
  ))->result();
}

function get_peristiwa_nikah($id_profile = "", $tahun = array())
{
  $CI = getCI();
  $m = $CI->db->get_where("web_profile_nikah", array(
    "pn_profile_id" => $id_profile
  ))->result();
  $tmp = array();
  $res = array();
  foreach ((array)$m as $key => $value) {
    $tmp[$value->pn_tahun] = array(
      "kantor"  => $value->pn_dikantor,
      "luar"    => $value->pn_diluar_kantor,
    );
  }

  foreach ((array)$tahun as $kv) {
    $res[$kv] = isset($tmp[$kv]) ? $tmp[$kv] : array();
  }

  return $res;
}


function get_cost_type_id($id = "")
{
  $arr = array(
    "PUSAT"     => "PUSAT",
    "KUA"       => "KUA",
    "KOTA"      => "KABUPATEN/KOTA",
    "PROPINSI"  => "PROPINSI"
  );
  return isset($arr[$id]) ? ucwords(strtolower($arr[$id])) : '';
}

function get_cost_type_non()
{
  $CI = getCI();
  $arr = array(
    "PUSAT"     => "PUSAT",
    "KOTA"      => "KABUPATEN/KOTA",
    "PROPINSI"  => "PROPINSI"
  );

  if ($CI->jCfg['user']['is_all'] != 1) {

    if (trim($CI->jCfg['user']['kabupaten']) != 0 && trim($CI->jCfg['user']['propinsi']) != 0) {
      unset($arr['PUSAT']);
      unset($arr['PROPINSI']);
    }
    if (trim($CI->jCfg['user']['kabupaten']) == 0 && trim($CI->jCfg['user']['propinsi']) != 0) {
      unset($arr['PUSAT']);
    }
    if (trim($CI->jCfg['user']['kabupaten']) == 0 && trim($CI->jCfg['user']['propinsi']) == 0) {
      unset($arr['PROPINSI']);
      unset($arr['KOTA']);
    }
  }

  return $arr;
}

function get_cost_type_ops()
{
  $CI = getCI();
  $arr = array(
    "PUSAT"     => "PUSAT",
    "KUA"       => "KUA",
    "KOTA"      => "KABUPATEN/KOTA",
    "PROPINSI"  => "PROPINSI"
  );

  if ($CI->jCfg['user']['is_all'] != 1) {

    if (trim($CI->jCfg['user']['kabupaten']) != 0 && trim($CI->jCfg['user']['propinsi']) != 0) {
      unset($arr['PUSAT']);
      unset($arr['PROPINSI']);
    }
    if (trim($CI->jCfg['user']['kabupaten']) == 0 && trim($CI->jCfg['user']['propinsi']) != 0) {
      unset($arr['PUSAT']);
    }
    if (trim($CI->jCfg['user']['kabupaten']) == 0 && trim($CI->jCfg['user']['propinsi']) == 0) {
      unset($arr['PROPINSI']);
      unset($arr['KOTA']);
      unset($arr['KUA']);
    }
  }

  return $arr;
}

function jarak($lat1, $lon1, $lat2, $lon2, $unit = "K")
{

  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);

  if ($unit == "K") {
    return ($miles * 1.609344);
  } else if ($unit == "N") {
    return ($miles * 0.8684);
  } else {
    return $miles;
  }
}

function get_komponen_kegiatan()
{
  $CI = getCI();
  $CI->db->order_by("ref_parent", "ASC");
  $CI->db->order_by("ref_parent_output", "ASC");
  $CI->db->order_by("ref_id", "ASC");
  return $CI->db->get_where("web_ref_nonoperasional", array(
    "ref_status" => 1,
    "ref_type"   => "komponen"
  ))->result();
}

function get_ref_kegiatan()
{
  $CI = getCI();
  return $CI->db->get_where("web_ref_nonoperasional", array(
    "ref_status" => 1,
    "ref_type"   => "kegiatan"
  ))->result();
}

function get_ref_kegiatan_id($id = "")
{
  $CI = getCI();
  return $CI->db->get_where("web_ref_nonoperasional", array(
    "ref_id" => $id,
  ))->row();
}

function get_referensi_item($id = "")
{
  $CI = getCI();
  return $CI->db->get_where("web_referensi", array(
    "ref_id" => $id
  ))->row();
}

function get_referensi_item_name($id = "")
{
  $CI = getCI();
  $m =  $CI->db->get_where("web_referensi", array(
    "ref_id" => $id
  ))->row();
  return isset($m->ref_name) ? $m->ref_name : '';
}

function dn($v)
{
  return str_replace(".", "", $v);
}

function get_referensi($type = "profile", $cat = "")
{
  $CI = getCI();
  $CI->db->order_by("ref_name");
  if (trim($cat) != "") {
    $CI->db->where("ref_category", $cat);
  }
  return $CI->db->get_where("web_referensi", array(
    "ref_status" => 1,
    "ref_type"   => $type
  ))->result();
}

function get_tahun()
{
  $m = array();
  for ($i = cfg('tahun_awal'); $i <= date("Y") + 1; $i++) {
    $m[] = $i;
  }
  return $m;
}

function get_kua_id($id)
{
  $CI = getCI();
  return $CI->db->get_where("web_profile_kua", array(
    "profile_id" => $id
  ))->row();
}

function get_propinsi_id($id)
{
  $CI = getCI();
  return $CI->db->get_where("app_propinsi", array(
    "propinsi_id" => $id
  ))->row();
}

function get_kab_id($id)
{
  $CI = getCI();
  return $CI->db->get_where("app_kabupaten", array(
    "kab_id" => $id
  ))->row();
}

function get_propinsi()
{
  $CI = getCI();
  $CI->db->order_by("propinsi_nama");

  if ($CI->jCfg['user']['is_all'] != 1) {
    $CI->db->where("propinsi_id", $CI->jCfg['user']['propinsi']);
  }

  return $CI->db->get_where("app_propinsi", array(
    "is_trash !=" => 1,
    "propinsi_status" => 1
  ))->result();
}

function get_tahun_pajak()
{
  $CI = getCI();
  $CI->db->order_by("tahun_angka", "DESC");
  return $CI->db->get_where("app_tahun", array(
    "is_trash !=" => 1,
    "tahun_status" => 1
  ))->result();
}

function get_provinsi()
{
  $CI = getCI();
  $CI->db->order_by("propinsi_nama", "ASC");
  return $CI->db->get_where("app_propinsi", array(
    "is_trash !=" => 1,
    "propinsi_status" => 1
  ))->result();
}

function get_kabupaten()
{
  $CI = getCI();
  $CI->db->order_by("kab_nama", "ASC");
  return $CI->db->get_where("app_kabupaten", array(
    "is_trash !=" => 1,
    "kab_status" => 1
  ))->result();
}

function get_kecamatan()
{
  $CI = getCI();
  $CI->db->order_by("kec_nama", "ASC");
  return $CI->db->get_where("app_kecamatan", array(
    "is_trash !=" => 1,
    "kec_status" => 1
  ))->result();
}

function get_status()
{
  $CI = getCI();
  $CI->db->order_by("status_id", "ASC");
  return $CI->db->get_where("app_status", array(
    "is_trash !=" => 1,
    "status_status" => 1
  ))->result();
}

function get_payment_tahun($id = "")
{

  $CI = getCI();
  $data = $CI->db->get_where("app_tahun", array(
    "tahun_angka" => $id
  ))->row();
  return isset($data->tahun_angka) ? $data->tahun_angka : '';
}

function get_referensi_ops_biaya($type = "profile", $cat = "", $opr_id = "")
{
  $CI = getCI();
  $ref_id = get_referensi($type, $cat);
  $in_arr = array();
  foreach ((array)$ref_id as $k => $v) {
    $in_arr[] = $v->ref_id;
  }
  $CI->db->select("SUM(oitem_value) as jumlah");
  $CI->db->where_in("oitem_key", $in_arr);
  $m = $CI->db->get_where("web_operasional_item", array(
    "oitem_opr_id" => $opr_id
  ))->row();
  return isset($m->jumlah) ? $m->jumlah : 0;
}

// report non ops..
function get_non_ops_kegiatan()
{
  $CI = getCI();
  $CI->db->order_by("ref_order_by");
  $CI->db->order_by("ref_id");
  return $CI->db->get_where("web_ref_nonoperasional", array(
    "ref_status" => 1,
    "ref_type"   => "kegiatan"
  ))->result();
}

function get_total_ops_kegiatan($in_arr = array(), $keg_id = "")
{
  $CI = getCI();
  $CI->db->select("SUM(kd_jumlah*kd_harga_satuan) as total,kd_kegiatan_id");
  $CI->db->where_in("kd_kegiatan_id", $in_arr);
  $CI->db->group_by("kd_kegiatan_id");
  $m = $CI->db->get_where("web_komponen_kegiatan_list", array(
    "kd_keg_id" => $keg_id
  ))->result();
  $mv = array();
  foreach ((array)$m as $key => $value) {
    $mv[$value->kd_kegiatan_id] = $value->total;
  }
  return $mv;
}

function check_is_approve($status = 0)
{
  $CI = getCI();
  if ($CI->jCfg['user']['is_all'] != 1 && $status == 1) {
?>
    <script type="text/javascript">
      $("input[type='file']").remove();
      $("form").attr("acion", "#");
      $("#keg_status,#tanah_status,#opr_status,#peg_status,#belanja_status").html("<option value=''>Approve</option>");
      $("button[type='submit']").remove();
      $('input,select').each(function() {
        $(this).attr("disabled", "disabled");
        $(this).css("border", "none").css("background-color", "transparent").css("color", "#656D78");
      });
    </script>
<?php
  }
}

function get_cicilan()
{
  $CI = getCI();

  $CI->db->order_by("cicilan_id");
  $CI->db->where("cicilan_status", 1);
  $m = $CI->db->get_where("app_cicilan")->result();

  return $m;
}

function get_bank()
{
  $CI = getCI();

  $CI->db->order_by("bank_nama");
  $CI->db->where("bank_status", 1);
  $m = $CI->db->get_where("app_bank")->result();

  return $m;
}

function get_tax()
{
  $CI = getCI();

  $CI->db->order_by("tax_nama");
  $CI->db->where("tax_status", 1);
  $m = $CI->db->get_where("app_tax")->result();

  return $m;
}

function get_karyawan()
{
  $CI = getCI();

  $CI->db->order_by("karyawan_nama");
  $m = $CI->db->get_where("app_karyawan")->result();

  return $m;
}

function get_vendor()
{
  $CI = getCI();

  $CI->db->select('app_vendor.*,app_bank.bank_nama');
  $CI->db->join('app_bank', 'app_bank.bank_id=app_vendor.vendor_bank_id', 'LEFT');
  $CI->db->order_by("vendor_nama");
  $CI->db->where("vendor_status", 1);
  $m = $CI->db->get_where("app_vendor")->result();

  return $m;
}

function get_faktur()
{
  $CI = getCI();

  $CI->db->order_by("nsfp_id");
  $CI->db->where("nfsp_tahun", 2020);
  //$CI->db->where("nfsp_status",1);
  $m = $CI->db->get_where("app_nsfp")->result();

  return $m;
}

function get_client()
{
  $CI = getCI();

  $CI->db->order_by("client_nama");
  $CI->db->where("client_status", 1);
  $m = $CI->db->get_where("app_client")->result();

  return $m;
}

function get_ntpn()
{
  $CI = getCI();

  $CI->db->order_by("pajak_tahun", "DESC");
  $CI->db->order_by("pajak_masa", "DESC");
  $CI->db->order_by("pajak_jenis", "ASC");
  $CI->db->order_by("pajak_perihal", "DESC");
  $m = $CI->db->get_where("app_pajak")->result();

  return $m;
}

function get_karyawan_name($id = "")
{

  $CI = getCI();
  $data = $CI->db->get_where("app_karyawan", array(
    "karyawan_id" => $id
  ))->row();
  return isset($data->karyawan_nama) ? $data->karyawan_nama : '';
}

function get_vendor_name($id = "")
{

  $CI = getCI();
  $data = $CI->db->get_where("app_vendor", array(
    "vendor_id" => $id
  ))->row();
  return isset($data->vendor_nama) ? $data->vendor_nama : '';
}

function get_vendor_kode($id = "")
{

  $CI = getCI();
  $data = $CI->db->get_where("app_vendor", array(
    "vendor_id" => $id
  ))->row();
  return isset($data->vendor_kode) ? $data->vendor_kode : '';
}

function get_bank_name($id = "")
{

  $CI = getCI();
  $data = $CI->db->get_where("app_bank", array(
    "bank_id" => $id
  ))->row();
  return isset($data->bank_nama) ? $data->bank_nama : '';
}

function get_status_name($id = "")
{

  $CI = getCI();
  $data = $CI->db->get_where("app_status", array(
    "status_id" => $id
  ))->row();
  return isset($data->status_nama) ? $data->status_nama : '';
}

function get_cicilan_name($id = "")
{

  $CI = getCI();
  $data = $CI->db->get_where("app_cicilan", array(
    "cicilan_id" => $id
  ))->row();
  return isset($data->cicilan_nama) ? $data->cicilan_nama : '';
}

function get_bank_kliring($id = "")
{

  $CI = getCI();
  $data = $CI->db->get_where("app_bank", array(
    "bank_id" => $id
  ))->row();
  return isset($data->bank_kliring) ? $data->bank_kliring : '';
}

function konversi($x)
{
  $x = abs($x);
  $angka = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
  $temp = "";
  if ($x < 12) {
    $temp = " " . $angka[$x];
  } else if ($x < 20) {
    $temp = konversi($x - 10) . " belas";
  } else if ($x < 100) {
    $temp = konversi($x / 10) . " puluh" . konversi($x % 10);
  } else if ($x < 200) {
    $temp = " seratus" . konversi($x - 100);
  } else if ($x < 1000) {
    $temp = konversi($x / 100) . " ratus" . konversi($x % 100);
  } else if ($x < 2000) {
    $temp = " seribu" . konversi($x - 1000);
  } else if ($x < 1000000) {
    $temp = konversi($x / 1000) . " ribu" . konversi($x % 1000);
  } else if ($x < 1000000000) {
    $temp = konversi($x / 1000000) . " juta" . konversi($x % 1000000);
  } else if ($x < 1000000000000) {
    $temp = konversi($x / 1000000000) . " milyar" . konversi($x % 1000000000);
  }
  return $temp;
}

function tkoma($x)
{
  $a = "";
  $str = stristr($x, ",");
  $ex = explode(',', $x);
  if (($ex[1] / 10) >= 1) {
    $a = abs($ex[1]);
  }
  $string = array("nol", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan",   "sembilan", "sepuluh", "sebelas");
  $temp = "";
  $a2 = $ex[1] / 10;
  $pjg = strlen($str);
  $i = 1;
  if ($a >= 1 && $a < 12) {
    $temp .= " " . $string[$a];
  } else if ($a > 12 && $a < 20) {
    $temp .= konversi($a - 10) . " belas";
  } else if ($a > 20 && $a < 100) {
    $temp .= konversi($a / 10) . " puluh" . konversi($a % 10);
  } else {
    if ($a2 < 1) {
      while ($i < $pjg) {
        $char = substr($str, $i, 1);
        $i++;
        $temp .= " " . $string[$char];
      }
    }
  }
  return $temp;
}

function penyebut($nilai)
{
  $nilai = abs($nilai);
  $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
  $temp = "";
  if ($nilai < 12) {
    $temp = " " . $huruf[$nilai];
  } else if ($nilai < 20) {
    $temp = penyebut($nilai - 10) . " Belas";
  } else if ($nilai < 100) {
    $temp = penyebut($nilai / 10) . " Puluh" . penyebut($nilai % 10);
  } else if ($nilai < 200) {
    $temp = " Seratus" . penyebut($nilai - 100);
  } else if ($nilai < 1000) {
    $temp = penyebut($nilai / 100) . " Ratus" . penyebut($nilai % 100);
  } else if ($nilai < 2000) {
    $temp = " Seribu" . penyebut($nilai - 1000);
  } else if ($nilai < 1000000) {
    $temp = penyebut($nilai / 1000) . " Ribu" . penyebut($nilai % 1000);
  } else if ($nilai < 1000000000) {
    $temp = penyebut($nilai / 1000000) . " Juta" . penyebut($nilai % 1000000);
  } else if ($nilai < 1000000000000) {
    $temp = penyebut($nilai / 1000000000) . " Milyar" . penyebut(fmod($nilai, 1000000000));
  } else if ($nilai < 1000000000000000) {
    $temp = penyebut($nilai / 1000000000000) . " Trilyun" . penyebut(fmod($nilai, 1000000000000));
  }
  return $temp;
}

function terbilang($nilai)
{
  if ($nilai < 0) {
    $hasil = "minus " . trim(penyebut($nilai));
  } else {
    $hasil = trim(penyebut($nilai));
  }
  return $hasil;
}

/*function terbilang($x){
  if($x<0){
   $hasil = "minus ".trim(konversi(x));
  }else{
   $poin = trim(tkoma($x));
   $hasil = trim(konversi($x));
  }                
if($poin){
   $hasil = $hasil." koma ".$poin;
  }else{
   $hasil = $hasil;
  }
  return $hasil;  
 }*/