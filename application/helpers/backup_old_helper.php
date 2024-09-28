<?php
// dashboard..
function get_count_section(){
    $CI = getCI();
    return $CI->db->get_where("mdr_section",array(
            'sec_status' => 1
        ))->num_rows();
}

function get_count_data($date=""){
    $CI = getCI();
    $CI->db->join("mdr_daily_item","mdr_daily_item.item_data_id = mdr_daily.data_id");
    $CI->db->where("mdr_daily.data_status",1);
    if( trim($date) != "" ){
        $CI->db->where(" DATE_FORMAT(mdr_daily.data_date,'%Y-%m-%d') = '".$date."' ");
    }
    return $CI->db->get("mdr_daily")->num_rows();
}

function get_info_section($date="",$type="bulanan",$section=""){
    $CI = getCI();
    if( trim($section)=="" ){
        $section = $CI->jCfg['user']['section'];
    }else{
        $section = $section;
    }
    $CI->db->select(" SUM(mdr_daily_item.item_count_target) as permintaan, SUM(mdr_daily_item.item_count) as jml_realisasi ,AVG(mdr_daily_item.item_persen) as realisasi");
    $CI->db->join("mdr_daily_item","mdr_daily_item.item_data_id = mdr_daily.data_id");
    $CI->db->where("mdr_daily.data_status",1);
    $CI->db->where("mdr_daily.data_sec_id",$section);
    $CI->db->where("mdr_daily_item.item_count_target !=",0);
    if( trim($date) != "" && $type=="harian" ){
        $CI->db->where(" DATE_FORMAT(mdr_daily.data_date,'%Y-%m-%d') = '".$date."' ");
    }
    if( trim($date) != "" && $type=="bulanan" ){
        $CI->db->where(" DATE_FORMAT(mdr_daily.data_date,'%Y-%m') = '".myDate($date,"Y-m",false)."' ");
    }
    $data = $CI->db->get("mdr_daily")->row();

    return array(
            "permintaan" => isset($data->permintaan)?$data->permintaan:0,
            "realisasi" => isset($data->realisasi)?round($data->realisasi,2):0,
            "jml_realisasi" => isset($data->jml_realisasi)?$data->jml_realisasi:0,
        );
}


function get_summary_byday_month($sec_id=""){
    $CI = getCI();

    $where = " AND ( mdr_daily.data_date >= '".myDate(cfg('today'),"Y-m-",false)."01' AND mdr_daily.data_date <= '".myDate(cfg('today'),"Y-m-d",false)."' ) ";
    if(trim($sec_id)!=""){
        $where .= " AND mdr_daily.data_sec_id = '".$sec_id."' ";
    }
    $data['data'] = $CI->db->query("
        SELECT data_date as tgl, AVG(item_persen) as target,
        count(item_id) as count_data
        FROM mdr_daily, mdr_daily_item
        WHERE mdr_daily.data_id = mdr_daily_item.item_data_id
        AND mdr_daily.data_status = 1
        AND mdr_daily_item.item_count_target != 0
        ".$where."
        GROUP BY data_date
        ORDER BY data_date DESC
    ")->result();

    return $data;
}
function get_summary_byday($day=30){
    $CI = getCI();

    $data_layanan = $CI->db->query("
        SELECT 
            data_date as tgl,count(item_id) as count_data
        FROM mdr_daily, mdr_daily_item, mdr_services
            WHERE 
            mdr_daily.data_id = mdr_daily_item.item_data_id
            AND mdr_services.srv_id = mdr_daily_item.item_srv_id
            AND mdr_daily.data_status = 1
        GROUP BY data_date
        ORDER BY data_date DESC
        LIMIT ".$day."
    ")->result();

    $layanan = array();
    foreach ((array)$data_layanan as $key => $value) {
       $layanan[$value->tgl] = $value->count_data;
    }
    $data['layanan'] = $layanan;

    $data['data'] = $CI->db->query("
        SELECT data_date as tgl, sum(item_persen_target) as target, 
        sum(item_persen) as realisasi, sum(item_persen/item_persen_target) as pencapaian,
        count(item_id) as count_data
        FROM mdr_daily, mdr_daily_item
        WHERE mdr_daily.data_id = mdr_daily_item.item_data_id
        AND mdr_daily.data_status = 1
        GROUP BY data_date
        ORDER BY data_date DESC
        LIMIT ".$day."
    ")->result();

    return $data;
}

function get_pie_section_last_month(){
    $CI = getCI();
    $wh = '';
    $date = cfg('today');

    $end = mDate($date,"-1 month","Y-m-t");
    $start = myDate($date,"Y",false)."-01-01";

    if( trim($date)!="" ){
        $wh = " AND ( mdr_daily.data_date >=  '".$start."' AND mdr_daily.data_date <=  '".$end."' )";
    }
    $m = $CI->db->query("
        SELECT 
            mdr_section.sec_name as section, 
            SUM(item_count) as jumlah
        FROM mdr_daily, mdr_daily_item, mdr_section
        WHERE mdr_daily.data_id = mdr_daily_item.item_data_id
        AND mdr_section.sec_id = mdr_daily.data_sec_id
        AND mdr_daily.data_status = 1
        AND mdr_section.sec_status = 1
        ".$wh."
        GROUP BY mdr_daily.data_sec_id
        ORDER BY mdr_section.sec_name ASC
    ")->result();

    return $m;
}
function get_pie_section_year(){
    $CI = getCI();
    $wh = '';
    $date = cfg('today');
    if( trim($date)!="" ){
        $wh = " AND DATE_FORMAT(mdr_daily.data_date,'%Y') = '".myDate($date,"Y",false)."'";
    }
    $m = $CI->db->query("
        SELECT 
            mdr_section.sec_name as section, 
            count(item_id) as jumlah
        FROM mdr_daily, mdr_daily_item, mdr_section
        WHERE mdr_daily.data_id = mdr_daily_item.item_data_id
        AND mdr_section.sec_id = mdr_daily.data_sec_id
        AND mdr_daily.data_status = 1
        AND mdr_section.sec_status = 1
        ".$wh."
        GROUP BY mdr_daily.data_sec_id
        ORDER BY mdr_section.sec_name ASC
    ")->result();
    return $m;
}

function get_pie_section_month($date=""){
    $CI = getCI();
    $wh = '';
    if( trim($date)!="" ){
        //$wh = " AND mdr_daily.data_date = '".$date."'";
        $wh = " AND DATE_FORMAT(mdr_daily.data_date,'%Y-%m') = '".myDate($date,"Y-m",false)."' ";
    }
    $m = $CI->db->query("
        SELECT 
            mdr_section.sec_name as section, 
            SUM(item_count) as jumlah
        FROM mdr_daily, mdr_daily_item, mdr_section
        WHERE mdr_daily.data_id = mdr_daily_item.item_data_id
        AND mdr_section.sec_id = mdr_daily.data_sec_id
        AND mdr_daily.data_status = 1
        AND mdr_section.sec_status = 1
        ".$wh."
        GROUP BY mdr_daily.data_sec_id
        ORDER BY mdr_section.sec_name ASC
    ")->result();
    return $m;
}

function get_pie_section_day($date=""){
    $CI = getCI();
    $wh = '';
    if( trim($date)!="" ){
        $wh = " AND mdr_daily.data_date = '".$date."'";
    }
    $m = $CI->db->query("
        SELECT 
            mdr_section.sec_name as section, 
            SUM(item_count) as jumlah
        FROM mdr_daily, mdr_daily_item, mdr_section
        WHERE mdr_daily.data_id = mdr_daily_item.item_data_id
        AND mdr_section.sec_id = mdr_daily.data_sec_id
        AND mdr_daily.data_status = 1
        AND mdr_section.sec_status = 1
        AND mdr_daily_item.item_count_target != 0
        ".$wh."
        GROUP BY mdr_daily.data_sec_id
        ORDER BY mdr_section.sec_name ASC
    ")->result();
    return $m;
}

function get_bar_section_month($date=""){
    $CI = getCI();
    $data = array();
    $data['section'] = $CI->db->query("
            SELECT 
                sec_name,sec_id
            FROM mdr_section
            WHERE 
                sec_status = 1
            ORDER BY mdr_section.sec_id ASC
        ")->result();
    
    $wh = "";
    if( trim($date)!="" ){
        $wh = ' AND DATE_FORMAT(mdr_daily.data_date,"%Y-%m") = "'.myDate($date,"Y-m",false).'" ';
    }   
    $done = $CI->db->query("
        SELECT 
            count(item_id) as jumlah,sec_id
        FROM mdr_daily, mdr_daily_item, mdr_section
        WHERE mdr_daily.data_id = mdr_daily_item.item_data_id
        AND mdr_section.sec_id = mdr_daily.data_sec_id
        AND mdr_daily.data_status = 1
        AND mdr_section.sec_status = 1
        AND mdr_daily_item.item_count_target != 0
        ".$wh."
        GROUP BY mdr_daily.data_sec_id
        ORDER BY mdr_section.sec_id ASC
    ")->result();
    $arr_done = array();
    foreach ((array)$done as $key => $value) {
        $arr_done[$value->sec_id] = round($value->jumlah,2);
    }
    //progress..
    $progress = $CI->db->query("
        SELECT 
            count(item_id) as jumlah,sec_name,sec_id
        FROM mdr_daily, mdr_daily_item, mdr_section
        WHERE mdr_daily.data_id = mdr_daily_item.item_data_id
        AND mdr_section.sec_id = mdr_daily.data_sec_id
        AND mdr_daily.data_status != 1
        AND mdr_section.sec_status = 1
        AND mdr_daily_item.item_count_target != 0
        ".$wh."
        GROUP BY mdr_daily.data_sec_id
        ORDER BY mdr_section.sec_id ASC
    ")->result();
    $arr_progress = array();
    foreach ((array)$progress as $key => $value) {
        $arr_progress[$value->sec_id] = round($value->jumlah,2);
    }

    $data['progress'] = $arr_progress;
    $data['done'] = $arr_done;
    return $data;
}

function get_bar_section($date=""){
    $CI = getCI();
    $data = array();
    $data['section'] = $CI->db->query("
            SELECT 
                sec_name,sec_id
            FROM mdr_section
            ORDER BY mdr_section.sec_id ASC
        ")->result();
    
    $wh = "";
    if( trim($date)!="" ){
        $wh = ' AND mdr_daily.data_date = "'.$date.'" ';
    }   
    $done = $CI->db->query("
        SELECT 
            SUM(item_count) as jumlah,sec_id
        FROM mdr_daily, mdr_daily_item, mdr_section
        WHERE mdr_daily.data_id = mdr_daily_item.item_data_id
        AND mdr_section.sec_id = mdr_daily.data_sec_id
        AND mdr_daily.data_status = 1
        AND mdr_section.sec_status = 1
        AND mdr_daily_item.item_count_target != 0
        ".$wh."
        GROUP BY mdr_daily.data_sec_id
        ORDER BY mdr_section.sec_id ASC
    ")->result();
    $arr_done = array();
    foreach ((array)$done as $key => $value) {
        $arr_done[$value->sec_id] = $value->jumlah;
    }

    //progress..
    $progress = $CI->db->query("
        SELECT 
            SUM(item_count) as jumlah,sec_name
        FROM mdr_daily, mdr_daily_item, mdr_section
        WHERE mdr_daily.data_id = mdr_daily_item.item_data_id
        AND mdr_section.sec_id = mdr_daily.data_sec_id
        AND mdr_daily.data_status != 1
        AND mdr_section.sec_status = 1
        AND mdr_daily_item.item_count_target != 0
        ".$wh."
        GROUP BY mdr_daily.data_sec_id
        ORDER BY mdr_section.sec_id ASC
    ")->result();
    $arr_progress = array();
    foreach ((array)$progress as $key => $value) {
        $arr_progress[$value->sec_id] = $value->jumlah;
    }

    $data['progress'] = $arr_progress;
    $data['done'] = $arr_done;
    return $data;
}

function get_bar_progress_section($date="",$type="bulanan",$section=""){

    $CI = getCI();
    if( trim($section) == "" ){
        $sec_id = $CI->jCfg['user']['section'];
    }else{
        $sec_id = $section;
    }

    $data = array();
    $date = trim($date)==""?cfg('today'):$date;
    if( $type == "bulanan"){
        $where = "AND DATE_FORMAT(mdr_daily.data_date,'%Y-%m') = '".myDate($date,"Y-m",false)."'";
    }else{
        $where = " AND  mdr_daily.data_date = '".$date."'  ";
    }
    $pencapaian = $CI->db->query("
        SELECT 
            SUM(item_persen) as pencapaian,data_status
        FROM mdr_daily, mdr_daily_item
        WHERE mdr_daily.data_id = mdr_daily_item.item_data_id
        AND mdr_daily.data_sec_id = '".$sec_id."'
        AND mdr_daily_item.item_count_target != 0
        ".$where."
        GROUP BY mdr_daily.data_status
        ORDER BY mdr_daily.data_status ASC
    ")->result();

    $arr_pencapaian = array();
    foreach ((array)$pencapaian as $key => $value) {
        $arr_pencapaian[$value->data_status] = $value->pencapaian;
    }

    $data['pencapaian'] = $arr_pencapaian;
    return $data;

}

function get_section_list(){
    $CI = getCI();
    $data = array();
    $section = $CI->db->query("
            SELECT 
                sec_name,sec_id, count(srv_id) as jumlah
            FROM mdr_section,mdr_services
            WHERE
                mdr_services.srv_sec_id = mdr_section.sec_id
                AND mdr_section.sec_status = 1
            GROUP BY mdr_section.sec_id
            ORDER BY mdr_section.sec_id ASC
        ")->result();

    $arr_section = array();
    foreach ((array)$section as $key => $value) {
       $arr_section[$value->sec_id] = $value;
    }

    return $arr_section;
}
function get_bar_pencapaian_section(){
    $CI = getCI();
    $data = array();
    $section = $CI->db->query("
            SELECT 
                sec_name,sec_id, count(srv_id) as jumlah
            FROM mdr_section,mdr_services
            WHERE
                mdr_services.srv_sec_id = mdr_section.sec_id
                AND mdr_section.sec_status = 1
            GROUP BY mdr_section.sec_id
            ORDER BY mdr_section.sec_id ASC
        ")->result();

    $arr_section = array();
    foreach ((array)$section as $key => $value) {
       $arr_section[$value->sec_id] = $value;
    }
    
    $last_month = mDate(cfg('today'),"-1 month","Y-m-t");
    $where = " AND ( mdr_daily.data_date >= '".myDate(cfg('today'),"Y-",false)."01-01' AND mdr_daily.data_date <= '".$last_month."' ) ";

    $pencapaian = $CI->db->query("
        SELECT 
            AVG(item_persen) as pencapaian,sec_id,sec_name
        FROM mdr_daily, mdr_daily_item, mdr_section
        WHERE mdr_daily.data_id = mdr_daily_item.item_data_id
        AND mdr_section.sec_id = mdr_daily.data_sec_id
        AND mdr_daily.data_status = 1
        AND mdr_section.sec_status = 1
        AND mdr_daily_item.item_count_target != 0
        ".$where."
        GROUP BY mdr_daily.data_sec_id
        ORDER BY mdr_section.sec_id ASC
    ")->result();

    $arr_pencapaian = array();
    foreach ((array)$pencapaian as $key => $value) {
        $arr_pencapaian[$value->sec_id] = $value->pencapaian;
    }

    $data['pencapaian'] = $arr_pencapaian;
    $data['section']    = $arr_section;
    return $data;
}

function get_str_last_month($date=""){
    $date = trim($date)!=""?$date:date("Y-m-d");
    $start = date("Y")."-01-01";
    $end   = mDate($date,"-1 month","Y-m-d");
    $arr = array();
    while ( $start <= $end) {
        $arr[] = array(
                "name" => myDate($start,"M",false),
                "key"  => myDate($start,"Y-m",false)
            );
        $start = mDate($start,"+1 month","Y-m-d");
    }

    return $arr;
}
function get_bar_pencapaian_section_month($bulan=""){
    $CI = getCI();
    $data = array();
    
    $where = "";
    if( trim($bulan)!="" ){
        $where = " AND DATE_FORMAT(mdr_daily.data_date,'%Y-%m') = '".$bulan."' ";
    }

    $pencapaian = $CI->db->query("
        SELECT 
            AVG(item_persen) as pencapaian,sec_id,sec_name,
            DATE_FORMAT(mdr_daily.data_date,'%Y-%m')
        FROM mdr_daily, mdr_daily_item, mdr_section
        WHERE mdr_daily.data_id = mdr_daily_item.item_data_id
        AND mdr_section.sec_id = mdr_daily.data_sec_id
        AND mdr_daily.data_status = 1
        AND mdr_daily_item.item_count_target != 0
        AND mdr_section.sec_status = 1
        ".$where."
        GROUP BY mdr_daily.data_sec_id
        ORDER BY mdr_section.sec_id ASC
    ")->result();

    $arr_pencapaian = array();
    foreach ((array)$pencapaian as $key => $value) {
        $arr_pencapaian[$value->sec_id] = $value->pencapaian;
    }

    $data['pencapaian'] = $arr_pencapaian;
    return $data;
}

function get_bar_pencapaian_section_day($date=""){
    $CI = getCI();
    $data = array();
    $section = $CI->db->query("
            SELECT 
                sec_name,sec_id, count(srv_id) as jumlah
            FROM mdr_section,mdr_services
            WHERE
                mdr_services.srv_sec_id = mdr_section.sec_id
                AND mdr_section.sec_status = 1
            GROUP BY mdr_section.sec_id
            ORDER BY mdr_section.sec_id ASC
        ")->result();

    $arr_section = array();
    foreach ((array)$section as $key => $value) {
       $arr_section[$value->sec_id] = $value;
    }
    
    $date = trim($date)==""?cfg('today'):$date;
    $where = " AND  mdr_daily.data_date = '".$date."'  ";

    $pencapaian = $CI->db->query("
        SELECT 
            AVG(item_persen) as pencapaian,sec_id,sec_name
        FROM mdr_daily, mdr_daily_item, mdr_section
        WHERE mdr_daily.data_id = mdr_daily_item.item_data_id
        AND mdr_section.sec_id = mdr_daily.data_sec_id
        AND mdr_daily.data_status = 1
        AND mdr_section.sec_status = 1
        AND mdr_daily_item.item_count_target != 0
        ".$where."
        GROUP BY mdr_daily.data_sec_id
        ORDER BY mdr_section.sec_id ASC
    ")->result();

    $arr_pencapaian = array();
    foreach ((array)$pencapaian as $key => $value) {
        $arr_pencapaian[$value->sec_id] = $value->pencapaian;
    }

    $data['pencapaian'] = $arr_pencapaian;
    $data['section']    = $arr_section;
    return $data;
}

function send_email_review($par=array()){

    $CI = getCI();
    if( count($par) > 0 ){
        $data_id = isset($par['data_id'])?$par['data_id']:'';
        if( trim($data_id)!="" ){
            $dm = $CI->db->get_where("mdr_daily",array(
                    "data_id" => $data_id
                ))->row();
            $sec_id = isset($dm->data_sec_id)?$dm->data_sec_id:'';
            if( trim($sec_id)!=""){
                $CI->db->select("app_user.*");
                $CI->db->join("app_user_group","app_user_group.ug_user_id = app_user.user_id");
                $user = $CI->db->get_where("app_user",array(
                        "user_sec_id" => $sec_id,
                        "ug_group_id" => 27 //approval seksi..
                    ))->result();
                $email_arr = array();
                foreach ((array)$user as $key => $value) {
                    $email_arr[] = $value->user_email;
                }                
                $par_data = array();
                if( count($email_arr)>  0){
                    $par_data['title']   = "[Request Review] Data Report Section ".get_section_name($sec_id)." Tanggal ".myDate($dm->data_date,"d M Y",false);
                    $par_data['sender']  = $CI->jCfg['user']['fullname'];
                    $par_data['email']   = $email_arr;
                    if( trim($CI->jCfg['user']['email'])!="" ){
                        $par_data['cc']  = $CI->jCfg['user']['email'];
                    }
                    send_email_mio($par_data);
                }
            }
        }
    }
}

function send_email_approve($par=array()){
    
    $CI = getCI();
    if( count($par) > 0 ){
        $data_id = isset($par['data_id'])?$par['data_id']:'';
        if( trim($data_id)!="" ){
            $dm = $CI->db->get_where("mdr_daily",array(
                    "data_id" => $data_id
                ))->row();
            $sec_id = isset($dm->data_sec_id)?$dm->data_sec_id:'';
            if( trim($sec_id)!=""){
                
                $CI->db->select("app_user.*");
                $CI->db->join("app_user_group","app_user_group.ug_user_id = app_user.user_id");
                $user = $CI->db->get_where("app_user",array(
                        "user_sec_id" => $sec_id,
                        "ug_group_id" => 28 //approval pusat..
                    ))->result();
                $email_arr = array();
                foreach ((array)$user as $key => $value) {
                    $email_arr[] = $value->user_email;
                }   
                $email_cfg = explode(",", cfg('email_notif_approval'));
                if( count($email_cfg) > 0 ){
                    $xt = array_merge($email_cfg,$email_arr);
                    $email_arr = $xt;
                }
                $par_data = array();
                if( count($email_arr)>  0){
                    $par_data['title']   = "[Request Approve] Data Report Section ".get_section_name($sec_id)." Tanggal ".myDate($dm->data_date,"d M Y",false);
                    $par_data['sender']  = $CI->jCfg['user']['fullname'];
                    $par_data['email']  = $email_arr;
                    if( trim($CI->jCfg['user']['email'])!="" ){
                        $par_data['cc'] = $CI->jCfg['user']['email'];
                    }
                    send_email_mio($par_data);
                }
            }
        }
    }

}

function send_email_reject($par = array()){
    
    $CI = getCI();
    if( count($par) > 0 ){
        $data_id = isset($par['data_id'])?$par['data_id']:'';
        if( trim($data_id)!="" ){
            $dm = $CI->db->get_where("mdr_daily",array(
                    "data_id" => $data_id
                ))->row();
            $sec_id = isset($dm->data_sec_id)?$dm->data_sec_id:'';
            if( trim($sec_id)!=""){
                $CI->db->select("app_user.*");
                $CI->db->join("app_user_group","app_user_group.ug_user_id = app_user.user_id");
                $CI->db->where_in("ug_group_id",array(27,26));
                $user = $CI->db->get_where("app_user",array(
                        "user_sec_id" => $sec_id
                    ))->result();
                $email_arr = array();
                foreach ((array)$user as $key => $value) {
                    $email_arr[] = $value->user_email;
                }                
                $par_data = array();
                if( count($email_arr)>  0){
                    $par_data['title']   = "[Reject] Data Report Section ".get_section_name($sec_id)." Tanggal ".myDate($dm->data_date,"d M Y",false);
                    $par_data['sender']  = $CI->jCfg['user']['fullname'];
                    $par_data['email']   = $email_arr;
                    if( trim($CI->jCfg['user']['email'])!="" ){
                        $par_data['cc']  = $CI->jCfg['user']['email'];
                    }
                    send_email_mio($par_data);
                }
            }
        }
    }

}

function send_email_reminder($par=array()){
    $CI         = getCI();
    $url        = 'http://10.120.201.251:8080/v2/site/mio_email_reminder';
    $url_send   = $url."?email=".urlencode(implode(",", $par['email']))."&cc=".urlencode(implode(",", $par['email_cc']));
    //debugCode($url_send);
    @file_get_contents($url_send);
}
function send_email_mio($par = array()){
    $CI         = getCI();
    $url        = 'http://10.120.201.251:8080/v2/site/mio_email';
    $url_send   = $url."?email=".urlencode(implode(",", $par['email']))."&title=".urlencode($par['title'])."&user=".urlencode($par['sender']);
    //debugCode($url_send);
    @file_get_contents($url_send);
}

function pencapaian_layanan_section($sec_id=""){
    $CI = getCI();
    return $CI->db->query("
            SELECT 
                mdr_services.srv_name,AVG(mdr_daily_item.item_persen) as realisasi,
                SUM(mdr_daily_item.item_count) as jml
            FROM 
                mdr_daily,mdr_services,mdr_daily_item
            WHERE
                mdr_daily.data_id = mdr_daily_item.item_data_id
                AND mdr_daily_item.item_srv_id = mdr_services.srv_id
                AND mdr_daily.data_sec_id = '".$sec_id."'
                AND mdr_daily.data_status = 1
                AND mdr_daily_item.item_count_target != 0
                AND DATE_FORMAT(mdr_daily.data_date,'%m-%Y') = '".myDate(cfg('today'),'m-Y',false)."'
            GROUP BY mdr_services.srv_id
            ORDER BY mdr_services.srv_name ASC
        ")->result();
}

function get_hk_item($type="HK",$limit=5){
    $arr_hk = array();
    for($i=0;$i<=$limit;$i++){
        $vl = "HK/T+".$i;
        if( $i== $limit){
            $vl = "HK/T>".($i-1);
        }
        $arr_hk[$i] = $vl;
    }
    return $arr_hk;
}

function get_sla_layanan_harian($date){
    $CI = getCI();
    $m = $CI->db->query("
            SELECT 
                SUM(sla_value) as jumlah,sla_hk,item_srv_id, 
                data_date as tanggal
            FROM 
                mdr_daily_item,mdr_sla,mdr_daily
            WHERE 
                mdr_daily.data_id = mdr_daily_item.item_data_id
                AND mdr_daily_item.item_id = mdr_sla.sla_item_id
                AND mdr_daily.data_status = 1
                AND data_date = '".$date."'
            GROUP BY mdr_daily_item.item_srv_id,sla_hk,data_date
            ORDER BY data_date,sla_hk ASC
        ")->result();
    $return = array();
    $max_hk = cfg('limit_report_hk');
    foreach ((array)$m as $key => $value) {
        $phrase = $value->item_srv_id;
        if( !isset($return[$phrase][$value->sla_hk]) ){
            if( $value->sla_hk <= $max_hk ){
                $return[$phrase][$value->sla_hk] = 0;
            }
        }
        if( $value->sla_hk < $max_hk ){
            $return[$phrase][$value->sla_hk] = $value->jumlah;
        }else{
            $return[$phrase][$max_hk] += $value->jumlah;
        }
    }
    return $return;
}

function get_sla_layanan_bulanan($start,$end){
    $CI = getCI();
    $m = $CI->db->query("
            SELECT 
                SUM(sla_value) as jumlah,sla_hk,item_srv_id, 
                DATE_FORMAT(data_date,'%Y-%m') as bulan
            FROM 
                mdr_daily_item,mdr_sla,mdr_daily
            WHERE 
                mdr_daily.data_id = mdr_daily_item.item_data_id
                AND mdr_daily_item.item_id = mdr_sla.sla_item_id
                AND mdr_daily.data_status = 1
                AND ( data_date >= '".$start."' AND data_date < '".$end."' )
            GROUP BY mdr_daily_item.item_srv_id,sla_hk,DATE_FORMAT(data_date,'%Y-%m')
            ORDER BY data_date,sla_hk ASC
        ")->result();
    $return = array();
    $max_hk = cfg('limit_report_hk');
    foreach ((array)$m as $key => $value) {
        $phrase = $value->item_srv_id."-".$value->bulan;
        if( !isset($return[$phrase][$value->sla_hk]) ){
            if( $value->sla_hk <= $max_hk ){
                $return[$phrase][$value->sla_hk] = 0;
            }
        }
        if( $value->sla_hk < $max_hk ){
            $return[$phrase][$value->sla_hk] = $value->jumlah;
        }else{
            $return[$phrase][$max_hk] += $value->jumlah;
        }
    }
    return $return;
}
