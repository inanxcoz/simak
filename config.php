<?php
/* database config */
$cfg['db']['hostname'] = "localhost";
$cfg['db']['username'] = "root"; //"asepkosw_user";
$cfg['db']['password'] = ""; //"aslabKOM26041987";
$cfg['db']['database'] = "asepkosw_payment";
$cfg['db']['dbdriver'] = "mysql";
/* module location HMVC */
$config['folder_modules']    = 'modules';
$config['modules_locations'] = array(
    getcwd() . '/' . $config['folder_modules'] . '/' => '../../' . $config['folder_modules'] . '/',
);

$config['template_web']     = 'default';
$config['template_admin']   = 'atlant';

//$config['today']            = "2016-08-20"; //date("Y-m-d");
$config['mycript']          = true;
$config['encryption_key']   = 'r3m4j4Id4m4n';

$config['activeLog']        = false;
$config['activeChat']       = false;

$config['tahun_awal']       = 2013;
$config['start_year']       = 2013;
$config['base_url']         = "http://" . $_SERVER['SERVER_NAME'] . "/payment/";
$config['domain']           = 'payment'; //$_SERVER['SERVER_NAME'];

$config['tahun'] = array(
    '2020'     => '2020',
    '2021'     => '2021',
    '2022'     => '2022'
);

$config['action'] = array(
    '1'   => 'Search',
    '2'   => 'Create',
    '3'   => 'Update',
    '4'   => 'Delete',
    '5'   => 'View',
    '6'   => 'Access'
);

$config['nama'] = array(
    '0'   => 'ASEP KOSWARA',
    '1'   => 'IRWAN DHARMAWAN',
    '2'   => 'PUTRI AMALIANA'
);

$config['agama'] = array(
    '0'   => 'ISLAM',
    '1'   => 'KATOLIK',
    '2'   => 'KRISTEN',
    '3'   => 'BUDHA',
    '4'   => 'HINDU'
);

$config['perkawinan'] = array(
    '0'   => 'BELUM KAWIN',
    '1'   => 'KAWIN'
);

$config['jenis_kelamin'] = array(
    '1' => 'PRIA',
    '2' => 'WANITA'
);

$config['nota'] = array(
    '-'             => '-',
    'ADM'           => 'ADM',
    'BCA'           => 'BCA',
    'BNI'           => 'BNI',
    'BRI'           => 'BRI',
    'MANDIRI'       => 'MANDIRI',
    'DANA'          => 'DANA',
    'FLIP'          => 'FLIP',
    'GOJEK'         => 'GOJEK',
    'GRAB'          => 'GRAB',
    'INVOICE'       => 'INVOICE',
    'KWITANSI'      => 'KWITANSI',
    'NOTA'          => 'NOTA',
    'TOKO'          => 'TOKO',
    'JNE'           => 'JNE',
    'J&T'           => 'J&T',
    'TIKI'          => 'TIKI',
    'MINIMARKET'    => 'MINIMARKET',
    'SHOPEE'        => 'SHOPEE',
    'TOKOPEDIA'     => 'TOKOPEDIA',
    'PRAMN'         => 'PRAMN'
);

$config['bulan'] = array(
    '1'   => '01 Januari',
    '2'   => '02 Februari',
    '3'   => '03 Maret',
    '4'   => '04 April',
    '5'   => '05 Mei',
    '6'   => '06 Juni',
    '7'   => '07 Juli',
    '8'   => '08 Agustus',
    '9'   => '09 September',
    '10'  => '10 Oktober',
    '11'  => '11 November',
    '12'  => '12 Desember'
);

$config['jenis_pajak'] = array(
    '0' => '411121 PPH 21 - 100 Masa',
    '1' => '411122 PPH 22 - 100 Masa',
    '2' => '411124 PPH 23 - 100 Masa',
    '3' => '411126 PPH 25 Badan - 100 Masa',
    '14' => '411126 PPH 29 Badan - 200 Tahunan',
    '4' => '411127 PPH 26 - 100 Masa',
    '5' => '411128 PPH Final - 420 Final',
    '6' => '411211 PPN - 100 Masa',
    '7' => '411121 PPH 21 - 300 STP',
    '8' => '411122 PPH 22 - 300 STP',
    '9' => '411124 PPH 23 - 300 STP',
    '10' => '411126 PPH 25 Badan Masa - 300 STP',
    '15' => '411126 PPH 29 Badan Tahunan - 300 STP',
    '11' => '411127 PPH 26 - 300 STP',
    '12' => '411128 PPH Final - 300 STP',
    '13' => '411211 PPN - 300 STP',
    '16' => '411211 PPN - 900 Pemungut Non Bendaharawan',
    '99' => 'NOT TAX'
);

$config['reference'] = array(
    '0' => 'FEE',
    '1' => 'INVOICE',
    '2' => 'IURAN',
    '3' => 'OPERASIONAL',
    '4' => 'PAYROLL',
    '5' => 'REIMBURS',
    '6' => 'TAX',
    '7' => 'INSENTIF',
    '99' => 'OTHERS'
);

$config['status'] = array(
    '0' => 'Draft',
    '1' => 'Progress',
    '2' => 'Reject',
    '3' => 'Done'
);

// upload path...
$config['upload_path']            = getcwd() . "/assets/collections/";
$config['upload_path_bank']       = $config['upload_path'] . "/bank";
$config['upload_path_client']     = $config['upload_path'] . "/client";
$config['upload_path_faktur']     = $config['upload_path'] . "/faktur";
$config['upload_path_invoice']    = $config['upload_path'] . "/invoice";
$config['upload_path_kasbon']     = $config['upload_path'] . "/kasbon";
$config['upload_path_pajak']      = $config['upload_path'] . "/pajak";
$config['upload_path_payment']    = $config['upload_path'] . "/payment";
$config['upload_path_petty']      = $config['upload_path'] . "/petty";
$config['upload_path_pph']        = $config['upload_path'] . "/pph";
$config['upload_path_user']       = $config['upload_path'] . "/user";
$config['upload_path_vendor']     = $config['upload_path'] . "/vendor";
$config['upload_path_propinsi']   = $config['upload_path'] . "/propinsi";
$config['upload_path_kabupaten']  = $config['upload_path'] . "/kabupaten";
$config['upload_path_kecamatan']  = $config['upload_path'] . "/kecamatan";
$config['upload_path_kelurahan']  = $config['upload_path'] . "/kelurahan";
$config['upload_path_karyawan']   = $config['upload_path'] . "/karyawan";
