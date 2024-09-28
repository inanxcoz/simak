<?php
// dashboard
function get_total_pay($par=array()){
    $CI = getCI();
    $CI->db->select("SUM(pb_total)");
    return $CI->db->get_where("app_payment_bank",array(
        ))->num_rows();      
}

function get_line_byday($day=15){
    $CI = getCI();
    $m = $CI->db->query("
        SELECT DATE_FORMAT(pb_tgl,'%Y-%m-%d') as tgl, count(pb_id) as jumlah 
        FROM app_payment_bank
        GROUP BY DATE_FORMAT(pb_tgl,'%Y-%m-%d')
        ORDER BY DATE_FORMAT(pb_tgl,'%Y-%m-%d') DESC
        LIMIT ".$day."
    ")->result();
    return $m;
}

function get_total_pajak(){
    $CI = getCI();
    $CI->db->select("SUM(pajak_bayar) as pajak");
    $m = $CI->db->get_where("app_pajak",array(
            "pajak_tahun" => "2024",
            "pajak_status" => "1",
            "is_trash !=" => "1"
        ))->row();
    return isset($m->pajak)?$m->pajak:0;
}

function get_total_petty(){
    $CI = getCI();
    $CI->db->select("SUM(petty_kredit-petty_qty*petty_debet) as petty");
    $m = $CI->db->get_where("app_petty",array(
            "petty_tahun" => "2024",
            "petty_status" => "1",
            "is_trash !=" => "1"
        ))->row();
    return isset($m->petty)?$m->petty:0;
}

function get_total_kredit(){
    $CI = getCI();
    $CI->db->select("SUM(inv_nominal+(inv_nominal*0.11)-(inv_nominal*0.02)) AS kredit");
    //$CI->db->select("SUM(inv_nominal) AS kredit");
    $m = $CI->db->get_where("app_invoice",array(
            "inv_tahun" => "2024",
            "inv_status" => "3",
            "is_trash !=" => "1"
        ))->row();
    return isset($m->kredit)?$m->kredit:0;
}

function get_total_debet(){
    $CI = getCI();
    $CI->db->select("SUM(pb_qty*pb_amount-pb_qty*pb_amount*pb_tax) as debet");
    $m = $CI->db->get_where("app_payment_bank",array(
            "pb_thn" => "2024"
        ))->row();
    return isset($m->debet)?$m->debet:0;
}

function get_user(){
    $CI = getCI();
    return $CI->db->get_where("app_user",array(
            //"user_status" => "1",
            "is_trash !=" => "1"
        ))->num_rows();
}

function dokter(){
    $CI = getCI();
    return $CI->db->get_where("app_dokter",array(
            //"dokter_status" => "1",
            "is_trash !=" => "1"
        ))->num_rows();
}

function produk(){
    $CI = getCI();
    return $CI->db->get_where("app_produk",array(
            //"dokter_status" => "1",
            "is_trash !=" => "1"
        ))->num_rows();
}

function outlet(){
    $CI = getCI();
    return $CI->db->get_where("app_outlet",array(
            //"dokter_status" => "1",
            "is_trash !=" => "1"
        ))->num_rows();
}

function medical(){
    $CI = getCI();
    return $CI->db->get_where("app_medical",array(
            //"dokter_status" => "1",
            "is_trash !=" => "1"
        ))->num_rows();
}

function kunjungan(){
    $CI = getCI();
    return $CI->db->get_where("app_produk_kunj")->num_rows();
}
//
function total_belanja_pegawai(){
	$CI = getCI();

    $CI->db->select(" SUM(peg_jumlah) as total ");
    if($CI->jCfg['user']['is_all'] != 1){

        
        if( trim($CI->jCfg['user']['kabupaten'])== 0 && trim($CI->jCfg['user']['propinsi'])== 0){
            $CI->db->where("peg_cost_type",'PUSAT');
        }
        if( trim($CI->jCfg['user']['kabupaten'])== 0 && trim($CI->jCfg['user']['propinsi'])!= 0){
            $CI->db->where("peg_propinsi",$CI->jCfg['user']['propinsi']);
        }
        if( trim($CI->jCfg['user']['kabupaten'])!= 0 && trim($CI->jCfg['user']['propinsi'])!= 0){
            $CI->db->where("peg_propinsi",$CI->jCfg['user']['propinsi']);
            $CI->db->where("peg_kota",$CI->jCfg['user']['kabupaten']);
        }

    }
    $m = $CI->db->get_where("web_belanja_pegawai",array(
            "peg_status" => 1
        ))->row();
    return isset($m->total)?$m->total:0;
}


function jumlah_usulan_pagu(){
	$CI = getCI();

    if($CI->jCfg['user']['is_all'] != 1){

        
        if( trim($CI->jCfg['user']['kabupaten'])== 0 && trim($CI->jCfg['user']['propinsi'])== 0){
            $CI->db->where("keg_cost_type",'PUSAT');
        }
        if( trim($CI->jCfg['user']['kabupaten'])== 0 && trim($CI->jCfg['user']['propinsi'])!= 0){
            $CI->db->where("keg_propinsi",$CI->jCfg['user']['propinsi']);
        }
        if( trim($CI->jCfg['user']['kabupaten'])!= 0 && trim($CI->jCfg['user']['propinsi'])!= 0){
            $CI->db->where("keg_propinsi",$CI->jCfg['user']['propinsi']);
            $CI->db->where("keg_kabupaten",$CI->jCfg['user']['kabupaten']);
        }

    }

    return $CI->db->get_where("web_komponen_kegiatan",array(
            "keg_id !="    => ""
        ))->num_rows();
}


function jumlah_belanja_operasional(){
    $CI = getCI();

    if($CI->jCfg['user']['is_all'] != 1){

        
        if( trim($CI->jCfg['user']['kabupaten'])== 0 && trim($CI->jCfg['user']['propinsi'])== 0){
            $CI->db->where("opr_cost_type",'PUSAT');
        }
        if( trim($CI->jCfg['user']['kabupaten'])== 0 && trim($CI->jCfg['user']['propinsi'])!= 0){
            $CI->db->where("opr_propinsi",$CI->jCfg['user']['propinsi']);
        }
        if( trim($CI->jCfg['user']['kabupaten'])!= 0 && trim($CI->jCfg['user']['propinsi'])!= 0){
            $CI->db->where("opr_propinsi",$CI->jCfg['user']['propinsi']);
            $CI->db->where("opr_kabupaten",$CI->jCfg['user']['kabupaten']);
        }

    }

    return $CI->db->get_where("web_operasional",array(
            "opr_id !="    => ""
        ))->num_rows();
}


function jumlah_belanja_tanah(){
    $CI = getCI();

    if($CI->jCfg['user']['is_all'] != 1){

        
        if( trim($CI->jCfg['user']['kabupaten'])== 0 && trim($CI->jCfg['user']['propinsi'])== 0){
            $CI->db->where("tanah_cost_type",'PUSAT');
        }
        if( trim($CI->jCfg['user']['kabupaten'])== 0 && trim($CI->jCfg['user']['propinsi'])!= 0){
            $CI->db->where("tanah_propinsi",$CI->jCfg['user']['propinsi']);
        }
        if( trim($CI->jCfg['user']['kabupaten'])!= 0 && trim($CI->jCfg['user']['propinsi'])!= 0){
            $CI->db->where("tanah_propinsi",$CI->jCfg['user']['propinsi']);
            $CI->db->where("tanah_kota",$CI->jCfg['user']['kabupaten']);
        }

    }

    return $CI->db->get_where("web_pengadaan_tanah",array(
            "tanah_id !="    => ""
        ))->num_rows();
}



function current_user_activity($limit=10){
    $CI = getCI();
    $date = date("Y-m-d H:i:s", strtotime("-100 minutes"));
    $CI->db->select('user_id,user_name,user_fullname,user_last_activity,user_last_module,user_photo');
    $CI->db->order_by("user_last_activity","DESC");
    $CI->db->limit($limit);
    return $CI->db->get_where("app_user",array(
            'user_last_activity >=' => $date,
            'is_trash'              => 0
        ))->result();
}

function current_online_user(){
    $CI = getCI();
    $date = date("Y-m-d H:i:s", strtotime("-30 minutes"));
    $CI->db->select('user_id,user_name,user_fullname,user_last_activity,user_last_module,user_photo');
    $CI->db->order_by("user_last_activity","DESC");
    return $CI->db->get_where("app_user",array(
    		'user_last_activity >=' => $date,
    		'is_trash'				=> 0
    	))->result();
}

function line_chart($start,$end){
    $CI = getCI();
    $date = array();
    $end_date = $end; //date("Y-m-d");
    $start_date = $tmp_start_date = $start;//mDate($end_date,"-".$day." day","Y-m-d");

    while ($tmp_start_date <= $end_date) {
        $date[] = $tmp_start_date;
        $tmp_start_date = mDate($tmp_start_date,"+1 day","Y-m-d");
    }


    // Belanja Pegawai
    $CI->db->select('count(peg_id) as jumlah,DATE_FORMAT(time_add,"%Y-%m-%d") as tanggal');
    $CI->db->where('( time_add >="'.$start_date.' 00:00:00" AND time_add <= "'.$end_date.' 23:59:59" )');

    if($CI->jCfg['user']['is_all'] != 1){

        
        if( trim($CI->jCfg['user']['kabupaten'])== 0 && trim($CI->jCfg['user']['propinsi'])== 0){
            $CI->db->where("peg_cost_type",'PUSAT');
        }
        if( trim($CI->jCfg['user']['kabupaten'])== 0 && trim($CI->jCfg['user']['propinsi'])!= 0){
            $CI->db->where("peg_propinsi",$CI->jCfg['user']['propinsi']);
        }
        if( trim($CI->jCfg['user']['kabupaten'])!= 0 && trim($CI->jCfg['user']['propinsi'])!= 0){
            $CI->db->where("peg_propinsi",$CI->jCfg['user']['propinsi']);
            $CI->db->where("peg_kota",$CI->jCfg['user']['kabupaten']);
        }

    }

    $CI->db->order_by("time_add");
    $CI->db->group_by('DATE_FORMAT(time_add,"%Y-%m-%d")');
    $belanja_pegawai = $CI->db->get("web_belanja_pegawai")->result();

    $belanja_pegawai_date = array();
    foreach ((array)$belanja_pegawai as $key => $value) {
        $belanja_pegawai_date[$value->tanggal] = $value->jumlah;
    }

    // Belanja Tanah
    $CI->db->select('count(tanah_id) as jumlah,DATE_FORMAT(time_add,"%Y-%m-%d") as tanggal');
    $CI->db->where('( time_add >="'.$start_date.' 00:00:00" AND time_add <= "'.$end_date.' 23:59:59" )');

    if($CI->jCfg['user']['is_all'] != 1){
        
        if( trim($CI->jCfg['user']['kabupaten'])== 0 && trim($CI->jCfg['user']['propinsi'])== 0){
            $CI->db->where("tanah_cost_type",'PUSAT');
        }
        if( trim($CI->jCfg['user']['kabupaten'])== 0 && trim($CI->jCfg['user']['propinsi'])!= 0){
            $CI->db->where("tanah_propinsi",$CI->jCfg['user']['propinsi']);
        }
        if( trim($CI->jCfg['user']['kabupaten'])!= 0 && trim($CI->jCfg['user']['propinsi'])!= 0){
            $CI->db->where("tanah_propinsi",$CI->jCfg['user']['propinsi']);
            $CI->db->where("tanah_kota",$CI->jCfg['user']['kabupaten']);
        }

    }

    $CI->db->order_by("time_add");
    $CI->db->group_by('DATE_FORMAT(time_add,"%Y-%m-%d")');
    $belanja_tanah = $CI->db->get("web_pengadaan_tanah")->result();

    $belanja_tanah_date = array();
    foreach ((array)$belanja_tanah as $key => $value) {
        $belanja_tanah_date[$value->tanggal] = $value->jumlah;
    }

    // Belanja Operasional
    $CI->db->select('count(opr_id) as jumlah,DATE_FORMAT(time_add,"%Y-%m-%d") as tanggal');
    $CI->db->where('( time_add >="'.$start_date.' 00:00:00" AND time_add <= "'.$end_date.' 23:59:59" )');

    if($CI->jCfg['user']['is_all'] != 1){

        
        if( trim($CI->jCfg['user']['kabupaten'])== 0 && trim($CI->jCfg['user']['propinsi'])== 0){
            $CI->db->where("opr_cost_type",'PUSAT');
        }
        if( trim($CI->jCfg['user']['kabupaten'])== 0 && trim($CI->jCfg['user']['propinsi'])!= 0){
            $CI->db->where("opr_propinsi",$CI->jCfg['user']['propinsi']);
        }
        if( trim($CI->jCfg['user']['kabupaten'])!= 0 && trim($CI->jCfg['user']['propinsi'])!= 0){
            $CI->db->where("opr_propinsi",$CI->jCfg['user']['propinsi']);
            $CI->db->where("opr_kabupaten",$CI->jCfg['user']['kabupaten']);
        }

    }

    $CI->db->order_by("time_add");
    $CI->db->group_by('DATE_FORMAT(time_add,"%Y-%m-%d")');
    $belanja_opr = $CI->db->get("web_operasional")->result();

    $belanja_opr_date = array();
    foreach ((array)$belanja_opr as $key => $value) {
        $belanja_opr_date[$value->tanggal] = $value->jumlah;
    }

    // Belanja Non Operasional
    $CI->db->select('count(keg_id) as jumlah,DATE_FORMAT(time_add,"%Y-%m-%d") as tanggal');
    $CI->db->where('( time_add >="'.$start_date.' 00:00:00" AND time_add <= "'.$end_date.' 23:59:59" )');

    if($CI->jCfg['user']['is_all'] != 1){

        
        if( trim($CI->jCfg['user']['kabupaten'])== 0 && trim($CI->jCfg['user']['propinsi'])== 0){
            $CI->db->where("keg_cost_type",'PUSAT');
        }
        if( trim($CI->jCfg['user']['kabupaten'])== 0 && trim($CI->jCfg['user']['propinsi'])!= 0){
            $CI->db->where("keg_propinsi",$CI->jCfg['user']['propinsi']);
        }
        if( trim($CI->jCfg['user']['kabupaten'])!= 0 && trim($CI->jCfg['user']['propinsi'])!= 0){
            $CI->db->where("keg_propinsi",$CI->jCfg['user']['propinsi']);
            $CI->db->where("keg_kabupaten",$CI->jCfg['user']['kabupaten']);
        }

    }

    $CI->db->order_by("time_add");
    $CI->db->group_by('DATE_FORMAT(time_add,"%Y-%m-%d")');
    $belanja_nonopr = $CI->db->get("web_komponen_kegiatan")->result();

    $belanja_nonopr_date = array();
    foreach ((array)$belanja_nonopr as $key => $value) {
        $belanja_nonopr_date[$value->tanggal] = $value->jumlah;
    }



    return array(
            "date"              => $date,
            "belanja_pegawai"   => $belanja_pegawai_date,
            "belanja_tanah"     => $belanja_tanah_date,
            "belanja_opr"       => $belanja_opr_date,
            "belanja_non_opr"   => $belanja_nonopr_date
        );


}
