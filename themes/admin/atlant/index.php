<?php
$debet = 0;
$kredit = 0;
$pajak = 0;
$petty = 0;
?>
<?php js_hight_chart(); ?>
<div class="row" style="margin-top:5px;">
    <div class="col-md-12">
        <!-- <div class="col-md-8">
            <div class="well alert-danger" style="padding:17px;border:1px solid;border-color:#E8E8E8;background-color: #000;">
              <marquee behavior="scroll" direction="left">
                <h1 style="color: #fff;">Selamat Datang, <span class="fa fa-user"></span> <?php echo $this->jCfg['user']['fullname']; ?> | <?php echo isset($this->jCfg['user']['role'][0]) ? get_role_name($this->jCfg['user']['role'][0]) : 'None'; ?>, di <?php echo cfg('app_aplikasi'); ?> <?php echo cfg('app_name'); ?> <?php echo cfg('app_company'); ?></h1>
              </marquee>
            </div>
        </div> 
        <div class="col-md-4">
            
        </div>-->
    </div>
    <div class="col-md-12">
        <div class="col-md-8">
            <div class="panel" style="height:477px;padding:10px;border:1px solid;border-color:#E8E8E8;" id="cart_line_utama">
                <!-- GRAFIK -->
            </div>
        </div>
        <div class="col-md-4">
            <a class="tile tile-info" href="<?php echo site_url('transaksi/invoice'); ?>" target=_blank style="border-color:#E8E8E8;">
                <h1 style="color: #fff;">Rp. <?php echo myNum(get_total_kredit($kredit)); ?></h1>
                <p>Total Invoice Tahun <?php echo Date("Y"); ?></p>
                <div class="informer informer-default dir-tr"><span class="fa fa-money"></span></div>
            </a>
            <a class="tile tile-warning" href="<?php echo site_url('transaksi/payment'); ?>" target=_blank style="border-color:#E8E8E8;">
                <h1 style="color: #fff;">Rp. <?php echo myNum(get_total_debet($debet)); ?></h1>
                <p>Total Payment Request Tahun <?php echo Date("Y"); ?></p>
                <div class="informer informer-default dir-tr"><span class="fa fa-dollar"></span></div>
            </a>
            <a class="tile tile-success" href="<?php echo site_url('rekapitulasi/pajak'); ?>" target=_blank style="border-color:#E8E8E8;">
                <h1 style="color: #fff;">Rp. <?php echo myNum(get_total_pajak($pajak)); ?></h1>
                <p>Total Pajak Badan Tahun <?php echo Date("Y"); ?></p>
                <div class="informer informer-default dir-tr"><span class="fa fa-money"></span></div>
            </a>
            <a class="tile tile-danger" href="<?php echo site_url('rekapitulasi/petty'); ?>" target=_blank style="border-color:#E8E8E8;">
                <h1 style="color: #fff;">Rp. <?php echo myNum(get_total_petty($petty)); ?></h1>
                <p>Saldo Petty Cash Tahun <?php echo Date("Y"); ?></p>
                <div class="informer informer-default dir-tr"><span class="fa fa-euro"></span></div>
            </a>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#panel-content-wrap').css('background-color', 'transparent')
            .css('box-shadow', 'none')
            .css('margin-top', '0px')
            .css('padding', '0px');
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#panel-content-wrap').removeClass('panel');
        $('#border-header').css('border', 'none');
    });
    $(function() {

        $('#cart_line_utama').highcharts({

            chart: {
                type: 'line'
            },
            title: {
                text: 'DATA GRAFIK'
            },
            subtitle: {
                text: '<b>Payment Request</b>'
            },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: { // don't display the dummy year
                    month: '%e. %b',
                    year: '%b'
                },
                title: {
                    text: 'Tanggal & Bulan'
                }
            },
            credits: {
                enabled: true
            },
            exporting: {
                enabled: true
            },
            yAxis: {
                title: {
                    text: 'Jumlah'
                },
                min: 0
            },
            tooltip: {
                headerFormat: '<b>{series.name}</b><br>',
                pointFormat: '{point.x:%e. %b}: {point.y:.f}'
            },

            plotOptions: {
                area: {
                    marker: {
                        enabled: true
                    },
                    fillOpacity: 0.3
                },
                enableMouseTracking: false
            },
            legend: {
                enabled: false
            },
            series: [{
                name: 'Data PRAMN',
                data: [
                    <?php
                    foreach ((array)get_line_byday() as $k => $v) {
                        $koma = $k < count(get_line_byday()) - 1 ? "," : "";
                        $dm = explode("-", $v->tgl);
                        echo "[Date.UTC(" . $dm[0] . "," . ((int)$dm[1] - 1) . "," . ((int)$dm[2]) . ")," . $v->jumlah . "]" . $koma . "
                   ";
                    } ?>
                ]
            }]

        });

    });
</script>