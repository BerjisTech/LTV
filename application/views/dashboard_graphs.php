<?php
#echo $this->db->select('date_format(from_unixtime(date_joined), "%Y") as dateformat')->get('members')->row()->dateformat; 
$time_30 = strtotime('-30 days');
$time_today = time();
$begin = strtotime('05-05-2021');
// $user_growth = $this->db->query("SELECT *, date_format(from_unixtime(install_date), '%Y %m %d') as year, date_format(from_unixtime(install_date), '%m') as month, date_format(from_unixtime(install_date), '%d') as day FROM `installs` RIGHT OUTER JOIN `uninstalls` ON date_format(from_unixtime(uninstall_date), '%Y %m %d') = date_format(from_unixtime(install_date), '%Y %m %d') WHERE `install_date` >= $begin GROUP BY `day` ORDER BY `year` ASC")->result_array();
// echo $this->db->last_query();
// foreach ($user_growth as $fetch) {
//     echo 'New: ' . $fetch['new'] . '. | Reopened: ' . $fetch['reopened'] . '. | Uninstalled: ' . $fetch['uninstalled'] . '. | Closed: ' . $fetch['closed'] . '<br />';
// }
?>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        // Sample Toastr Notification
        setTimeout(function() {
            var opts = {
                "closeButton": true,
                "debug": false,
                "positionClass": rtl() || public_vars.$pageContainer.hasClass('right-sidebar') ? "toast-top-left" : "toast-top-right",
                "toastClass": "success",
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            toastr.success("Date: <?php echo date('d M, Y'); ?><br />Time: <?php echo date('H:i'); ?>", "Morning", opts);
        }, 3000);

        // Sparkline Charts
        $(".top-apps").sparkline('html', {
            type: 'line',
            width: '50px',
            height: '15px',
            lineColor: '#00acd6',
            fillColor: '',
            lineWidth: 2,
            spotColor: '#344e86',
            minSpotColor: '#344e86',
            maxSpotColor: '#344e86',
            highlightSpotColor: '#344e86',
            highlightLineColor: '#30487b',
            spotRadius: 2,
            drawNormalOnTop: true
        });
        $(".fund-5").sparkline([
            <?php
            $fund_5_mrr = $this->db->select('sum(quaterly.last_30_days) as mrr, date_format(from_unixtime(quaterly.recorded), "%d%m%Y") as day,')->where('apps.app_fund', 5)->order_by('recorded', 'ASC')->join('apps', 'quaterly.app_id = apps.app_id')->group_by('day')->get('quaterly')->result_array();
            foreach ($fund_5_mrr as $daily) {
                echo $daily['mrr'] . ',';
            }
            ?>
        ], {
            type: 'line',
            width: '100%',
            height: '55',
            lineColor: '#e8b51b',
            fillColor: '',
            lineWidth: 2,
            spotColor: '#344e86',
            minSpotColor: '#344e86',
            maxSpotColor: '#344e86',
            highlightSpotColor: '#344e86',
            highlightLineColor: '#30487b',
            spotRadius: 2,
            drawNormalOnTop: true
        });


        $(".fund-6").sparkline([
            <?php
            $fund_5_mrr = $this->db->select('sum(quaterly.last_30_days) as mrr, date_format(from_unixtime(quaterly.recorded), "%d%m%Y") as day,')->where('apps.app_fund', 6)->order_by('recorded', 'ASC')->join('apps', 'quaterly.app_id = apps.app_id')->group_by('day')->get('quaterly')->result_array();
            foreach ($fund_5_mrr as $daily) {
                echo $daily['mrr'] . ',';
            }
            ?>
        ], {
            type: 'line',
            width: '100%',
            height: '55',
            lineColor: '#ec3b83',
            fillColor: '',
            lineWidth: 2,
            spotColor: '#344e86',
            minSpotColor: '#344e86',
            maxSpotColor: '#344e86',
            highlightSpotColor: '#344e86',
            highlightLineColor: '#30487b',
            spotRadius: 2,
            drawNormalOnTop: true
        });

        $(".fund-7").sparkline([
            <?php
            $fund_5_mrr = $this->db->select('sum(quaterly.last_30_days) as mrr, date_format(from_unixtime(quaterly.recorded), "%d%m%Y") as day,')->order_by('recorded', 'ASC')->where('apps.app_fund', 7)->join('apps', 'quaterly.app_id = apps.app_id')->group_by('day')->get('quaterly')->result_array();
            foreach ($fund_5_mrr as $daily) {
                echo $daily['mrr'] . ',';
            }
            ?>
        ], {
            type: 'line',
            width: '100%',
            height: '55',
            lineColor: '#00acd6',
            fillColor: '',
            lineWidth: 2,
            spotColor: '#344e86',
            minSpotColor: '#344e86',
            maxSpotColor: '#344e86',
            highlightSpotColor: '#344e86',
            highlightLineColor: '#30487b',
            spotRadius: 2,
            drawNormalOnTop: true
        });

        $(".pie-chart").sparkline([
            <?php echo $this->db->where('app_id', 1)->order_by('record_id', 'DESC')->limit(1)->get('quaterly')->row()->last_30_days; ?>,
            <?php echo $this->db->where('app_id', 2)->order_by('record_id', 'DESC')->limit(1)->get('quaterly')->row()->last_30_days; ?>,
            <?php echo $this->db->where('app_id', 3)->order_by('record_id', 'DESC')->limit(1)->get('quaterly')->row()->last_30_days; ?>,
            <?php echo $this->db->where('app_id', 4)->order_by('record_id', 'DESC')->limit(1)->get('quaterly')->row()->last_30_days; ?>,
            <?php echo $this->db->where('app_id', 5)->order_by('record_id', 'DESC')->limit(1)->get('quaterly')->row()->last_30_days; ?>,
            <?php echo $this->db->where('app_id', 6)->order_by('record_id', 'DESC')->limit(1)->get('quaterly')->row()->last_30_days; ?>,
            <?php echo $this->db->where('app_id', 7)->order_by('record_id', 'DESC')->limit(1)->get('quaterly')->row()->last_30_days; ?>,
            <?php echo $this->db->where('app_id', 8)->order_by('record_id', 'DESC')->limit(1)->get('quaterly')->row()->last_30_days; ?>
        ], {
            type: 'pie',
            width: '95',
            height: '95',
            sliceColors: ['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB']
        });
        // Sparkline Charts
        $('.inlinebar').sparkline('html', {
            type: 'bar',
            barColor: '#ff6264'
        });
        $('.inlinebar-2').sparkline('html', {
            type: 'bar',
            barColor: '#445982'
        });
        $('.inlinebar-3').sparkline('html', {
            type: 'bar',
            barColor: '#00b19d'
        });
        $('.bar').sparkline([
            [1, 4],
            [2, 3],
            [3, 2],
            [4, 1]
        ], {
            type: 'bar'
        });
        $('.pie').sparkline('html', {
            type: 'pie',
            borderWidth: 0,
            sliceColors: ['#3d4554', '#ee4749', '#00b19d']
        });
        $('.linechart').sparkline();
        $('.loanrequest').sparkline('html', {
            type: 'bar',
            height: '30px',
            barColor: '#ff6264'
        });
        $('.approvedloans').sparkline('html', {
            type: 'bar',
            height: '30px',
            barColor: '#00b19d'
        });

        $(".monthly-sales").sparkline([

            <?php
            $all_mrr = $this->db->select('sum(quaterly.last_30_days) as mrr, date_format(from_unixtime(quaterly.recorded), "%Y%m%d") as day,')->order_by('recorded', 'ASC')->where('date_format(from_unixtime(quaterly.recorded), "%Y%m%d") >=', date('Ymd', strtotime('-30 days')))->join('apps', 'quaterly.app_id = apps.app_id')->group_by('day')->get('quaterly')->result_array();
            foreach ($all_mrr as $daily) {
                echo $daily['mrr'] . ',';
            }
            ?>

        ], {
            type: 'bar',
            barColor: '#485671',
            height: '250px',
            barWidth: 20,
            barSpacing: 3
        });

        // JVector Maps
        var map = $("#map");
        map.vectorMap({
            map: 'europe_merc_en',
            zoomMin: '3',
            backgroundColor: '#383f47',
            focusOn: {
                x: 0.5,
                y: 0.8,
                scale: 3
            }
        });


        // Line Chart
        var line_chart_demo = $("#line-chart-demo");
        var area_chart_demo = $("#area-chart-demo");
        line_chart_demo.parent().show();
        area_chart_demo.parent().show();
        var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];
        var weekdays = ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"];

        last_30_days();
        $('.adjust-stats').change(function() {
            $("#line-chart-demo").empty();
            $("#area-chart-demo").empty();
            $("#donut-chart-demo").empty();
            if ($(this).val() == "0") {
                today();
            }
            if ($(this).val() == "1") {
                yesterday();
            }
            if ($(this).val() == "7") {
                last_7_days();
            }
            if ($(this).val() == "30") {
                last_30_days();
            }
            if ($(this).val() == "90") {
                last_90_days();
            }
            if ($(this).val() == "365") {
                last_365_days();
            }
            if ($(this).val() == "31") {
                last_month();
            }
            if ($(this).val() == "366") {
                last_year()
            }
            if ($(this).val() == "all") {
                all_time();
            }
            if ($(this).val() == "") {
                last_30_days();
            }
        });



        function yesterday() {
            var line_chart = Morris.Line({
                element: 'line-chart-demo',
                data: [
                    <?php
                    for ($m = 48; $m > 23; $m--) :
                        $nowmonth = strtotime(date('Y-m-d H:m:s', strtotime('-' . $m . ' hours')));
                        $lastmonth = strtotime(date('Y-m-d H:m:s', strtotime('-' . ($m - 1) . ' hours'))); ?> {

                            y: '<?php echo date('Y-m-d', strtotime('-' . $m . ' days')); ?>',
                            a: <?php
                                $where = "`app_id` = 1 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            b: <?php
                                $where = "`app_id` = 2 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            c: <?php
                                $where = "`app_id` = 3 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            d: <?php
                                $where = "`app_id` = 4 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            e: <?php
                                $where = "`app_id` = 5 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            f: <?php
                                $where = "`app_id` = 6 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            g: <?php
                                $where = "`app_id` = 7 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            h: <?php
                                $where = "`app_id` = 8 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                        },

                    <?php endfor; ?>
                ],
                xkey: 'y',
                ykeys: ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'],
                labels: ['PC', 'ICU', 'PON', 'BDN', 'WPN', 'TFX', 'T2G', 'SK'],
                lineColors: ['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB'],
                resize: true,
                smooth: true,
                xLabelFormat: function(x) {
                    let shit = new Date(x);
                    let date = x.getDate();
                    let monthy = months[x.getMonth()];
                    let hours = x.getHours();
                    let minutes = x.getMinutes();
                    var ampm = hours >= 12 ? 'pm' : 'am';
                    hours = hours % 12;
                    hours = hours ? hours : 12; // the hour '0' should be '12'
                    minutes = minutes < 10 ? '0' + minutes : minutes;
                    var strTime = date + ' ' + monthy + ' ' + hours + ':' + minutes + ' ' + ampm;
                    var douche = strTime;
                    return douche;
                },
                dateFormat: function(x) {
                    let shit = new Date(x);
                    let date = shit.getDate();
                    let monthy = months[shit.getMonth()];
                    let hours = shit.getHours();
                    let minutes = shit.getMinutes();
                    var ampm = hours >= 12 ? 'pm' : 'am';
                    hours = hours % 12;
                    hours = hours ? hours : 12; // the hour '0' should be '12'
                    minutes = minutes < 10 ? '0' + minutes : minutes;
                    var strTime = date + ' ' + monthy + ' ' + hours + ':' + minutes + ' ' + ampm;
                    var douche = strTime;
                    return douche;
                },
                redraw: true
            });
            line_chart_demo.parent().attr('style', 'width: 100% !important;');

            var area_chart = Morris.Area({
                element: 'area-chart-demo',
                data: [
                    <?php
                    for ($m = 48; $m > 23; $m--) :
                        $nowmonth = strtotime(date('Y-m-d H:m:s', strtotime('-' . $m . ' hours')));
                        $lastmonth = strtotime(date('Y-m-d H:m:s', strtotime('-' . ($m - 1) . ' hours'))); ?> {

                            y: '<?php echo date('Y-m-d', strtotime('-' . $m . ' days')); ?>',
                            a: <?php
                                $where = "`app_id` = 1 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            b: <?php
                                $where = "`app_id` = 2 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            c: <?php
                                $where = "`app_id` = 3 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            d: <?php
                                $where = "`app_id` = 4 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            e: <?php
                                $where = "`app_id` = 5 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            f: <?php
                                $where = "`app_id` = 6 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            g: <?php
                                $where = "`app_id` = 7 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            h: <?php
                                $where = "`app_id` = 8 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                        },

                    <?php endfor; ?>
                ],
                xkey: 'y',
                ykeys: ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'],
                labels: ['PC', 'ICU', 'PON', 'BDN', 'WPN', 'TFX', 'T2G', 'SK'],
                lineColors: ['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB'],
                resize: true,
                smooth: true,
                xLabelFormat: function(x) {
                    let shit = new Date(x);
                    let date = x.getDate();
                    let monthy = months[x.getMonth()];
                    let hours = x.getHours();
                    let minutes = x.getMinutes();
                    var ampm = hours >= 12 ? 'pm' : 'am';
                    hours = hours % 12;
                    hours = hours ? hours : 12; // the hour '0' should be '12'
                    minutes = minutes < 10 ? '0' + minutes : minutes;
                    var strTime = date + ' ' + monthy + ' ' + hours + ':' + minutes + ' ' + ampm;
                    var douche = strTime;
                    return douche;
                },
                dateFormat: function(x) {
                    let shit = new Date(x);
                    let date = shit.getDate();
                    let monthy = months[shit.getMonth()];
                    let hours = shit.getHours();
                    let minutes = shit.getMinutes();
                    var ampm = hours >= 12 ? 'pm' : 'am';
                    hours = hours % 12;
                    hours = hours ? hours : 12; // the hour '0' should be '12'
                    minutes = minutes < 10 ? '0' + minutes : minutes;
                    var strTime = date + ' ' + monthy + ' ' + hours + ':' + minutes + ' ' + ampm;
                    var douche = strTime;
                    return douche;
                },
                redraw: true
            });
            area_chart_demo.parent().attr('style', 'width: 100% !important;');

            // Donut Chart
            <?php
            $lastmonth = strtotime(date('Y-m-d H:m:s', strtotime('-23 hours')));
            $nowmonth = strtotime(date('Y-m-d H:m:s', strtotime('-48 hours')));
            ?>
            var donut_chart_demo = $("#donut-chart-demo");
            donut_chart_demo.parent().show();
            var donut_chart = Morris.Donut({
                element: 'donut-chart-demo',
                data: [{
                        label: "Product Customizer",
                        value: <?php
                                $where = "`app_id` = 1 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "In Cart Upsell",
                        value: <?php
                                $where = "`app_id` = 2 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "Pre Order Now",
                        value: <?php
                                $where = "`app_id` = 3 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "Bulk Discount Now",
                        value: <?php
                                $where = "`app_id` = 4 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "Wholesale Pricing Now",
                        value: <?php
                                $where = "`app_id` = 5 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "TrackifyX",
                        value: <?php
                                $where = "`app_id` = 6 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "Text 2 Give",
                        value: <?php
                                $where = "`app_id` = 7 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "SentryKit",
                        value: <?php
                                $where = "`app_id` = 1 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    }
                ],
                colors: ['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB']
            });
            donut_chart_demo.parent().attr('style', 'width: 100% !important;');


        }

        function today() {
            // Line Charts

            var line_chart = Morris.Line({
                element: 'line-chart-demo',
                data: [
                    <?php
                    for ($m = 24; $m > -1; $m--) :
                        $nowmonth = strtotime(date('Y-m-d H:m:s', strtotime('-' . $m . ' hours')));
                        $lastmonth = strtotime(date('Y-m-d H:m:s', strtotime('-' . ($m - 1) . ' hours'))); ?> {

                            y: '<?php echo date('Y-m-d', strtotime('-' . $m . ' days')); ?>',
                            a: <?php
                                $where = "`app_id` = 1 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            b: <?php
                                $where = "`app_id` = 2 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            c: <?php
                                $where = "`app_id` = 3 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            d: <?php
                                $where = "`app_id` = 4 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            e: <?php
                                $where = "`app_id` = 5 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            f: <?php
                                $where = "`app_id` = 6 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            g: <?php
                                $where = "`app_id` = 7 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            h: <?php
                                $where = "`app_id` = 8 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                        },

                    <?php endfor; ?>
                ],
                xkey: 'y',
                ykeys: ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'],
                labels: ['PC', 'ICU', 'PON', 'BDN', 'WPN', 'TFX', 'T2G', 'SK'],
                lineColors: ['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB'],
                resize: true,
                xLabelFormat: function(x) {
                    let shit = new Date(x);
                    let date = x.getDate();
                    let monthy = months[x.getMonth()];
                    let hours = x.getHours();
                    let minutes = x.getMinutes();
                    var ampm = hours >= 12 ? 'pm' : 'am';
                    hours = hours % 12;
                    hours = hours ? hours : 12; // the hour '0' should be '12'
                    minutes = minutes < 10 ? '0' + minutes : minutes;
                    var strTime = date + ' ' + monthy + ' ' + hours + ':' + minutes + ' ' + ampm;
                    var douche = strTime;
                    return douche;
                },
                dateFormat: function(x) {
                    let shit = new Date(x);
                    let date = shit.getDate();
                    let monthy = months[shit.getMonth()];
                    let hours = shit.getHours();
                    let minutes = shit.getMinutes();
                    var ampm = hours >= 12 ? 'pm' : 'am';
                    hours = hours % 12;
                    hours = hours ? hours : 12; // the hour '0' should be '12'
                    minutes = minutes < 10 ? '0' + minutes : minutes;
                    var strTime = date + ' ' + monthy + ' ' + hours + ':' + minutes + ' ' + ampm;
                    var douche = strTime;
                    return douche;
                },
                smooth: true,
                redraw: true
            });
            line_chart_demo.parent().attr('style', 'width: 100% !important;');

            var area_chart = Morris.Area({
                element: 'area-chart-demo',
                data: [
                    <?php
                    for ($m = 24; $m > -1; $m--) :
                        $nowmonth = strtotime(date('Y-m-d H:m:s', strtotime('-' . $m . ' hours')));
                        $lastmonth = strtotime(date('Y-m-d H:m:s', strtotime('-' . ($m - 1) . ' hours'))); ?> {

                            y: '<?php echo date('Y-m-d', strtotime('-' . $m . ' days')); ?>',
                            a: <?php
                                $where = "`app_id` = 1 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            b: <?php
                                $where = "`app_id` = 2 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            c: <?php
                                $where = "`app_id` = 3 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            d: <?php
                                $where = "`app_id` = 4 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            e: <?php
                                $where = "`app_id` = 5 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            f: <?php
                                $where = "`app_id` = 6 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            g: <?php
                                $where = "`app_id` = 7 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            h: <?php
                                $where = "`app_id` = 8 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                        },

                    <?php endfor; ?>
                ],
                xkey: 'y',
                ykeys: ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'],
                labels: ['PC', 'ICU', 'PON', 'BDN', 'WPN', 'TFX', 'T2G', 'SK'],
                lineColors: ['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB'],
                resize: true,
                xLabelFormat: function(x) {
                    let shit = new Date(x);
                    let date = x.getDate();
                    let monthy = months[x.getMonth()];
                    let hours = x.getHours();
                    let minutes = x.getMinutes();
                    var ampm = hours >= 12 ? 'pm' : 'am';
                    hours = hours % 12;
                    hours = hours ? hours : 12; // the hour '0' should be '12'
                    minutes = minutes < 10 ? '0' + minutes : minutes;
                    var strTime = date + ' ' + monthy + ' ' + hours + ':' + minutes + ' ' + ampm;
                    var douche = strTime;
                    return douche;
                },
                dateFormat: function(x) {
                    let shit = new Date(x);
                    let date = shit.getDate();
                    let monthy = months[shit.getMonth()];
                    let hours = shit.getHours();
                    let minutes = shit.getMinutes();
                    var ampm = hours >= 12 ? 'pm' : 'am';
                    hours = hours % 12;
                    hours = hours ? hours : 12; // the hour '0' should be '12'
                    minutes = minutes < 10 ? '0' + minutes : minutes;
                    var strTime = date + ' ' + monthy + ' ' + hours + ':' + minutes + ' ' + ampm;
                    var douche = strTime;
                    return douche;
                },
                smooth: true,
                redraw: true
            });
            area_chart_demo.parent().attr('style', 'width: 100% !important;');


            // Donut Chart
            <?php
            $lastmonth = strtotime(date('Y-m-d H:m:s', strtotime('-0 hours')));
            $nowmonth = strtotime(date('Y-m-d H:m:s', strtotime('-24 hours')));
            ?>
            var donut_chart_demo = $("#donut-chart-demo");
            donut_chart_demo.parent().show();
            var donut_chart = Morris.Donut({
                element: 'donut-chart-demo',
                data: [{
                        label: "Product Customizer",
                        value: <?php
                                $where = "`app_id` = 1 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "In Cart Upsell",
                        value: <?php
                                $where = "`app_id` = 2 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "Pre Order Now",
                        value: <?php
                                $where = "`app_id` = 3 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "Bulk Discount Now",
                        value: <?php
                                $where = "`app_id` = 4 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "Wholesale Pricing Now",
                        value: <?php
                                $where = "`app_id` = 5 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "TrackifyX",
                        value: <?php
                                $where = "`app_id` = 6 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "Text 2 Give",
                        value: <?php
                                $where = "`app_id` = 7 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "SentryKit",
                        value: <?php
                                $where = "`app_id` = 1 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    }
                ],
                colors: ['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB']
            });
            donut_chart_demo.parent().attr('style', 'width: 100% !important;');
        }

        function last_30_days() {
            // Line Charts

            var line_chart = Morris.Line({
                element: 'line-chart-demo',
                data: [
                    <?php
                    for ($m = 30; $m > -1; $m--) :
                        $nowmonth = strtotime(date('d-M-Y', strtotime('-' . $m . ' days')));
                        $lastmonth = strtotime(date('d-M-Y', strtotime('-' . ($m - 1) . ' days'))); ?> {

                            y: '<?php echo date('Y-m-d', strtotime('-' . $m . ' days')); ?>',
                            a: <?php
                                $where = "`app_id` = 1 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            b: <?php
                                $where = "`app_id` = 2 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            c: <?php
                                $where = "`app_id` = 3 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            d: <?php
                                $where = "`app_id` = 4 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            e: <?php
                                $where = "`app_id` = 5 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            f: <?php
                                $where = "`app_id` = 6 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            g: <?php
                                $where = "`app_id` = 7 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            h: <?php
                                $where = "`app_id` = 8 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                        },

                    <?php endfor; ?>
                ],
                xkey: 'y',
                ykeys: ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'],
                labels: ['PC', 'ICU', 'PON', 'BDN', 'WPN', 'TFX', 'T2G', 'SK'],
                lineColors: ['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB'],
                xLabelFormat: function(d) {
                    return d.getDate() + ' ' + months[d.getMonth()];
                },
                dateFormat: function(x) {
                    let shit = new Date(x);
                    var douche = shit.getDate() + ' ' + months[shit.getMonth()];
                    return douche;
                },
                resize: true,
                smooth: true,
                pointSize: 0,
                redraw: true
            });
            line_chart_demo.parent().attr('style', 'width: 100% !important;');


            var area_chart = Morris.Area({
                element: 'area-chart-demo',
                data: [
                    <?php
                    for ($m = 30; $m > -1; $m--) :
                        $nowmonth = strtotime(date('d-M-Y', strtotime('-' . $m . ' days')));
                        $lastmonth = strtotime(date('d-M-Y', strtotime('-' . ($m - 1) . ' days'))); ?> {

                            y: '<?php echo date('Y-m-d', strtotime('-' . $m . ' days')); ?>',
                            a: <?php
                                $where = "`app_id` = 1 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            b: <?php
                                $where = "`app_id` = 2 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            c: <?php
                                $where = "`app_id` = 3 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            d: <?php
                                $where = "`app_id` = 4 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            e: <?php
                                $where = "`app_id` = 5 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            f: <?php
                                $where = "`app_id` = 6 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            g: <?php
                                $where = "`app_id` = 7 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            h: <?php
                                $where = "`app_id` = 8 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                        },

                    <?php endfor; ?>
                ],
                xkey: 'y',
                ykeys: ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'],
                labels: ['PC', 'ICU', 'PON', 'BDN', 'WPN', 'TFX', 'T2G', 'SK'],
                lineColors: ['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB'],
                xLabelFormat: function(d) {
                    return d.getDate() + ' ' + months[d.getMonth()];
                },
                dateFormat: function(x) {
                    let shit = new Date(x);
                    var douche = shit.getDate() + ' ' + months[shit.getMonth()];
                    return douche;
                },
                resize: true,
                smooth: true,
                pointSize: 0,
                redraw: true
            });
            area_chart_demo.parent().attr('style', 'width: 100% !important;');

            // Donut Chart
            <?php
            $lastmonth = strtotime(date('Y-m-d H:m:s', strtotime('-0 days')));
            $nowmonth = strtotime(date('Y-m-d H:m:s', strtotime('-30 days')));
            ?>
            var donut_chart_demo = $("#donut-chart-demo");
            donut_chart_demo.parent().show();
            var donut_chart = Morris.Donut({
                element: 'donut-chart-demo',
                data: [{
                        label: "Product Customizer",
                        value: <?php
                                $where = "`app_id` = 1 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "In Cart Upsell",
                        value: <?php
                                $where = "`app_id` = 2 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "Pre Order Now",
                        value: <?php
                                $where = "`app_id` = 3 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "Bulk Discount Now",
                        value: <?php
                                $where = "`app_id` = 4 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "Wholesale Pricing Now",
                        value: <?php
                                $where = "`app_id` = 5 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "TrackifyX",
                        value: <?php
                                $where = "`app_id` = 6 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "Text 2 Give",
                        value: <?php
                                $where = "`app_id` = 7 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "SentryKit",
                        value: <?php
                                $where = "`app_id` = 1 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    }
                ],
                colors: ['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB']
            });
            donut_chart_demo.parent().attr('style', 'width: 100% !important;');
        }

        function last_7_days() {
            // Line Charts

            var line_chart = Morris.Line({
                element: 'line-chart-demo',
                data: [
                    <?php
                    for ($m = 7; $m > -1; $m--) :
                        $nowmonth = strtotime(date('d-M-Y', strtotime('-' . $m . ' days')));
                        $lastmonth = strtotime(date('d-M-Y', strtotime('-' . ($m - 1) . ' days'))); ?> {

                            y: '<?php echo date('Y-m-d', strtotime('-' . $m . ' days')); ?>',
                            a: <?php
                                $where = "`app_id` = 1 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            b: <?php
                                $where = "`app_id` = 2 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            c: <?php
                                $where = "`app_id` = 3 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            d: <?php
                                $where = "`app_id` = 4 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            e: <?php
                                $where = "`app_id` = 5 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            f: <?php
                                $where = "`app_id` = 6 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            g: <?php
                                $where = "`app_id` = 7 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            h: <?php
                                $where = "`app_id` = 8 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                        },

                    <?php endfor; ?>
                ],
                xkey: 'y',
                ykeys: ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'],
                labels: ['PC', 'ICU', 'PON', 'BDN', 'WPN', 'TFX', 'T2G', 'SK'],
                lineColors: ['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB'],
                xLabelFormat: function(d) {
                    return d.getDate() + ' ' + months[d.getMonth()];
                },
                dateFormat: function(x) {
                    let shit = new Date(x);
                    var douche = shit.getDate() + ' ' + months[shit.getMonth()];
                    return douche;
                },
                resize: true,
                smooth: true,
                redraw: true
            });
            line_chart_demo.parent().attr('style', 'width: 100% !important;');


            var area_chart = Morris.Area({
                element: 'area-chart-demo',
                data: [
                    <?php
                    for ($m = 7; $m > -1; $m--) :
                        $nowmonth = strtotime(date('d-M-Y', strtotime('-' . $m . ' days')));
                        $lastmonth = strtotime(date('d-M-Y', strtotime('-' . ($m - 1) . ' days'))); ?> {

                            y: '<?php echo date('Y-m-d', strtotime('-' . $m . ' days')); ?>',
                            a: <?php
                                $where = "`app_id` = 1 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            b: <?php
                                $where = "`app_id` = 2 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            c: <?php
                                $where = "`app_id` = 3 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            d: <?php
                                $where = "`app_id` = 4 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            e: <?php
                                $where = "`app_id` = 5 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            f: <?php
                                $where = "`app_id` = 6 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            g: <?php
                                $where = "`app_id` = 7 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            h: <?php
                                $where = "`app_id` = 8 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                        },

                    <?php endfor; ?>
                ],
                xkey: 'y',
                ykeys: ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'],
                labels: ['PC', 'ICU', 'PON', 'BDN', 'WPN', 'TFX', 'T2G', 'SK'],
                lineColors: ['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB'],
                xLabelFormat: function(d) {
                    return d.getDate() + ' ' + months[d.getMonth()];
                },
                dateFormat: function(x) {
                    let shit = new Date(x);
                    var douche = shit.getDate() + ' ' + months[shit.getMonth()];
                    return douche;
                },
                resize: true,
                smooth: true,
                redraw: true
            });
            area_chart_demo.parent().attr('style', 'width: 100% !important;');


            // Donut Chart
            <?php
            $lastmonth = strtotime(date('Y-m-d H:m:s', strtotime('-0 days')));
            $nowmonth = strtotime(date('Y-m-d H:m:s', strtotime('-7 days')));
            ?>
            var donut_chart_demo = $("#donut-chart-demo");
            donut_chart_demo.parent().show();
            var donut_chart = Morris.Donut({
                element: 'donut-chart-demo',
                data: [{
                        label: "Product Customizer",
                        value: <?php
                                $where = "`app_id` = 1 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "In Cart Upsell",
                        value: <?php
                                $where = "`app_id` = 2 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "Pre Order Now",
                        value: <?php
                                $where = "`app_id` = 3 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "Bulk Discount Now",
                        value: <?php
                                $where = "`app_id` = 4 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "Wholesale Pricing Now",
                        value: <?php
                                $where = "`app_id` = 5 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "TrackifyX",
                        value: <?php
                                $where = "`app_id` = 6 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "Text 2 Give",
                        value: <?php
                                $where = "`app_id` = 7 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "SentryKit",
                        value: <?php
                                $where = "`app_id` = 1 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    }
                ],
                colors: ['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB']
            });
            donut_chart_demo.parent().attr('style', 'width: 100% !important;');
        }

        function last_90_days() {
            // Line Charts

            var line_chart = Morris.Line({
                element: 'line-chart-demo',
                data: [
                    <?php
                    for ($m = 90; $m > -1; $m--) :
                        $nowmonth = strtotime(date('d-M-Y', strtotime('-' . $m . ' days')));
                        $lastmonth = strtotime(date('d-M-Y', strtotime('-' . ($m - 1) . ' days'))); ?> {

                            y: '<?php echo date('Y-m-d', strtotime('-' . $m . ' days')); ?>',
                            a: <?php
                                $where = "`app_id` = 1 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            b: <?php
                                $where = "`app_id` = 2 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            c: <?php
                                $where = "`app_id` = 3 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            d: <?php
                                $where = "`app_id` = 4 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            e: <?php
                                $where = "`app_id` = 5 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            f: <?php
                                $where = "`app_id` = 6 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            g: <?php
                                $where = "`app_id` = 7 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            h: <?php
                                $where = "`app_id` = 8 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                        },

                    <?php endfor; ?>
                ],
                xkey: 'y',
                ykeys: ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'],
                labels: ['PC', 'ICU', 'PON', 'BDN', 'WPN', 'TFX', 'T2G', 'SK'],
                lineColors: ['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB'],
                xLabelFormat: function(d) {
                    return d.getDate() + ' ' + months[d.getMonth()];
                },
                dateFormat: function(x) {
                    let shit = new Date(x);
                    var douche = shit.getDate() + ' ' + months[shit.getMonth()];
                    return douche;
                },
                resize: true,
                smooth: true,
                pointSize: 0,
                redraw: true
            });
            line_chart_demo.parent().attr('style', 'width: 100% !important;');


            var area_chart = Morris.Area({
                element: 'area-chart-demo',
                data: [
                    <?php
                    for ($m = 90; $m > -1; $m--) :
                        $nowmonth = strtotime(date('d-M-Y', strtotime('-' . $m . ' days')));
                        $lastmonth = strtotime(date('d-M-Y', strtotime('-' . ($m - 1) . ' days'))); ?> {

                            y: '<?php echo date('Y-m-d', strtotime('-' . $m . ' days')); ?>',
                            a: <?php
                                $where = "`app_id` = 1 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            b: <?php
                                $where = "`app_id` = 2 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            c: <?php
                                $where = "`app_id` = 3 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            d: <?php
                                $where = "`app_id` = 4 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            e: <?php
                                $where = "`app_id` = 5 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            f: <?php
                                $where = "`app_id` = 6 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            g: <?php
                                $where = "`app_id` = 7 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            h: <?php
                                $where = "`app_id` = 8 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                        },

                    <?php endfor; ?>
                ],
                xkey: 'y',
                ykeys: ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'],
                labels: ['PC', 'ICU', 'PON', 'BDN', 'WPN', 'TFX', 'T2G', 'SK'],
                lineColors: ['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB'],
                xLabelFormat: function(d) {
                    return d.getDate() + ' ' + months[d.getMonth()];
                },
                dateFormat: function(x) {
                    let shit = new Date(x);
                    var douche = shit.getDate() + ' ' + months[shit.getMonth()];
                    return douche;
                },
                resize: true,
                smooth: true,
                pointSize: 0,
                redraw: true
            });
            area_chart_demo.parent().attr('style', 'width: 100% !important;');


            // Donut Chart
            <?php
            $lastmonth = strtotime(date('Y-m-d H:m:s', strtotime('-0 days')));
            $nowmonth = strtotime(date('Y-m-d H:m:s', strtotime('-90 days')));
            ?>
            var donut_chart_demo = $("#donut-chart-demo");
            donut_chart_demo.parent().show();
            var donut_chart = Morris.Donut({
                element: 'donut-chart-demo',
                data: [{
                        label: "Product Customizer",
                        value: <?php
                                $where = "`app_id` = 1 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "In Cart Upsell",
                        value: <?php
                                $where = "`app_id` = 2 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "Pre Order Now",
                        value: <?php
                                $where = "`app_id` = 3 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "Bulk Discount Now",
                        value: <?php
                                $where = "`app_id` = 4 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "Wholesale Pricing Now",
                        value: <?php
                                $where = "`app_id` = 5 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "TrackifyX",
                        value: <?php
                                $where = "`app_id` = 6 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "Text 2 Give",
                        value: <?php
                                $where = "`app_id` = 7 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "SentryKit",
                        value: <?php
                                $where = "`app_id` = 1 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    }
                ],
                colors: ['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB']
            });
            donut_chart_demo.parent().attr('style', 'width: 100% !important;');
        }

        function last_365_days() {
            // Line Charts

            var line_chart = Morris.Line({
                element: 'line-chart-demo',
                data: [
                    <?php
                    for ($m = 12; $m > -1; $m--) :
                        $nowmonth = strtotime(date('d-M-Y', strtotime('-' . $m . ' months')));
                        $lastmonth = strtotime(date('d-M-Y', strtotime('-' . ($m - 1) . ' months'))); ?> {

                            y: '<?php echo date('Y-m-d', strtotime('-' . $m . ' days')); ?>',
                            a: <?php
                                $where = "`app_id` = 1 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            b: <?php
                                $where = "`app_id` = 2 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            c: <?php
                                $where = "`app_id` = 3 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            d: <?php
                                $where = "`app_id` = 4 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            e: <?php
                                $where = "`app_id` = 5 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            f: <?php
                                $where = "`app_id` = 6 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            g: <?php
                                $where = "`app_id` = 7 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            h: <?php
                                $where = "`app_id` = 8 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                        },

                    <?php endfor; ?>
                ],
                xkey: 'y',
                ykeys: ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'],
                labels: ['PC', 'ICU', 'PON', 'BDN', 'WPN', 'TFX', 'T2G', 'SK'],
                lineColors: ['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB'],
                xLabelFormat: function(x) {
                    var month = months[x.getMonth()] + ' ' + x.getFullYear();
                    return month;
                },
                dateFormat: function(x) {
                    let d = new Date(x)
                    var month = months[d.getMonth()] + ' ' + d.getFullYear();;
                    return month;
                },
                resize: true,
                smooth: true,
                redraw: true
            });
            line_chart_demo.parent().attr('style', 'width: 100% !important;');


            var area_chart = Morris.Area({
                element: 'area-chart-demo',
                data: [
                    <?php
                    for ($m = 12; $m > -1; $m--) :
                        $nowmonth = strtotime(date('d-M-Y', strtotime('-' . $m . ' months')));
                        $lastmonth = strtotime(date('d-M-Y', strtotime('-' . ($m - 1) . ' months'))); ?> {

                            y: '<?php echo date('Y-m-d', strtotime('-' . $m . ' days')); ?>',
                            a: <?php
                                $where = "`app_id` = 1 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            b: <?php
                                $where = "`app_id` = 2 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            c: <?php
                                $where = "`app_id` = 3 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            d: <?php
                                $where = "`app_id` = 4 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            e: <?php
                                $where = "`app_id` = 5 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            f: <?php
                                $where = "`app_id` = 6 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            g: <?php
                                $where = "`app_id` = 7 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            h: <?php
                                $where = "`app_id` = 8 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                        },

                    <?php endfor; ?>
                ],
                xkey: 'y',
                ykeys: ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'],
                labels: ['PC', 'ICU', 'PON', 'BDN', 'WPN', 'TFX', 'T2G', 'SK'],
                lineColors: ['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB'],
                xLabelFormat: function(x) {
                    var month = months[x.getMonth()] + ' ' + x.getFullYear();
                    return month;
                },
                dateFormat: function(x) {
                    let d = new Date(x)
                    var month = months[d.getMonth()] + ' ' + d.getFullYear();;
                    return month;
                },
                resize: true,
                smooth: true,
                redraw: true
            });
            area_chart_demo.parent().attr('style', 'width: 100% !important;');


            // Donut Chart
            <?php
            $lastmonth = strtotime(date('Y-m-d H:m:s', strtotime('-0 months')));
            $nowmonth = strtotime(date('Y-m-d H:m:s', strtotime('-12 months')));
            ?>
            var donut_chart_demo = $("#donut-chart-demo");
            donut_chart_demo.parent().show();
            var donut_chart = Morris.Donut({
                element: 'donut-chart-demo',
                data: [{
                        label: "Product Customizer",
                        value: <?php
                                $where = "`app_id` = 1 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "In Cart Upsell",
                        value: <?php
                                $where = "`app_id` = 2 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "Pre Order Now",
                        value: <?php
                                $where = "`app_id` = 3 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "Bulk Discount Now",
                        value: <?php
                                $where = "`app_id` = 4 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "Wholesale Pricing Now",
                        value: <?php
                                $where = "`app_id` = 5 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "TrackifyX",
                        value: <?php
                                $where = "`app_id` = 6 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "Text 2 Give",
                        value: <?php
                                $where = "`app_id` = 7 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "SentryKit",
                        value: <?php
                                $where = "`app_id` = 1 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    }
                ],
                colors: ['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB']
            });
            donut_chart_demo.parent().attr('style', 'width: 100% !important;');
        }

        function last_month() {
            // Line Charts

            var line_chart = Morris.Line({
                element: 'line-chart-demo',
                data: [
                    <?php
                    for ($m = 60; $m > 29; $m--) :
                        $nowmonth = strtotime(date('d-M-Y', strtotime('-' . $m . ' days')));
                        $lastmonth = strtotime(date('d-M-Y', strtotime('-' . ($m - 1) . ' days'))); ?> {

                            y: '<?php echo date('Y-m-d', strtotime('-' . $m . ' days')); ?>',
                            a: <?php
                                $where = "`app_id` = 1 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            b: <?php
                                $where = "`app_id` = 2 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            c: <?php
                                $where = "`app_id` = 3 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            d: <?php
                                $where = "`app_id` = 4 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            e: <?php
                                $where = "`app_id` = 5 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            f: <?php
                                $where = "`app_id` = 6 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            g: <?php
                                $where = "`app_id` = 7 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            h: <?php
                                $where = "`app_id` = 8 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                        },

                    <?php endfor; ?>
                ],
                xkey: 'y',
                ykeys: ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'],
                labels: ['PC', 'ICU', 'PON', 'BDN', 'WPN', 'TFX', 'T2G', 'SK'],
                lineColors: ['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB'],
                xLabelFormat: function(d) {
                    return d.getDate() + ' ' + months[d.getMonth()];
                },
                dateFormat: function(x) {
                    let shit = new Date(x);
                    var douche = shit.getDate() + ' ' + months[shit.getMonth()];
                    return douche;
                },
                resize: true,
                smooth: true,
                pointSize: 0,
                redraw: true
            });
            line_chart_demo.parent().attr('style', 'width: 100% !important;');


            var area_chart = Morris.Area({
                element: 'area-chart-demo',
                data: [
                    <?php
                    for ($m = 60; $m > 29; $m--) :
                        $nowmonth = strtotime(date('d-M-Y', strtotime('-' . $m . ' days')));
                        $lastmonth = strtotime(date('d-M-Y', strtotime('-' . ($m - 1) . ' days'))); ?> {

                            y: '<?php echo date('Y-m-d', strtotime('-' . $m . ' days')); ?>',
                            a: <?php
                                $where = "`app_id` = 1 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            b: <?php
                                $where = "`app_id` = 2 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            c: <?php
                                $where = "`app_id` = 3 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            d: <?php
                                $where = "`app_id` = 4 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            e: <?php
                                $where = "`app_id` = 5 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            f: <?php
                                $where = "`app_id` = 6 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            g: <?php
                                $where = "`app_id` = 7 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            h: <?php
                                $where = "`app_id` = 8 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                        },

                    <?php endfor; ?>
                ],
                xkey: 'y',
                ykeys: ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'],
                labels: ['PC', 'ICU', 'PON', 'BDN', 'WPN', 'TFX', 'T2G', 'SK'],
                lineColors: ['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB'],
                xLabelFormat: function(d) {
                    return d.getDate() + ' ' + months[d.getMonth()];
                },
                dateFormat: function(x) {
                    let shit = new Date(x);
                    var douche = shit.getDate() + ' ' + months[shit.getMonth()];
                    return douche;
                },
                resize: true,
                smooth: true,
                pointSize: 0,
                redraw: true
            });
            area_chart_demo.parent().attr('style', 'width: 100% !important;');


            // Donut Chart
            <?php
            $lastmonth = strtotime(date('Y-m-d H:m:s', strtotime('-29 days')));
            $nowmonth = strtotime(date('Y-m-d H:m:s', strtotime('-60 days')));
            ?>
            var donut_chart_demo = $("#donut-chart-demo");
            donut_chart_demo.parent().show();
            var donut_chart = Morris.Donut({
                element: 'donut-chart-demo',
                data: [{
                        label: "Product Customizer",
                        value: <?php
                                $where = "`app_id` = 1 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "In Cart Upsell",
                        value: <?php
                                $where = "`app_id` = 2 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "Pre Order Now",
                        value: <?php
                                $where = "`app_id` = 3 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "Bulk Discount Now",
                        value: <?php
                                $where = "`app_id` = 4 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "Wholesale Pricing Now",
                        value: <?php
                                $where = "`app_id` = 5 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "TrackifyX",
                        value: <?php
                                $where = "`app_id` = 6 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "Text 2 Give",
                        value: <?php
                                $where = "`app_id` = 7 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "SentryKit",
                        value: <?php
                                $where = "`app_id` = 1 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    }
                ],
                colors: ['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB']
            });
            donut_chart_demo.parent().attr('style', 'width: 100% !important;');
        }

        function last_year() {
            // Line Charts

            var line_chart = Morris.Line({
                element: 'line-chart-demo',
                data: [
                    <?php
                    for ($m = 24; $m > 11; $m--) :
                        $nowmonth = strtotime(date('d-M-Y', strtotime('-' . $m . ' months')));
                        $lastmonth = strtotime(date('d-M-Y', strtotime('-' . ($m - 1) . ' months'))); ?> {

                            y: '<?php echo date('Y-m-d', strtotime('-' . $m . ' days')); ?>',
                            a: <?php
                                $where = "`app_id` = 1 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            b: <?php
                                $where = "`app_id` = 2 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            c: <?php
                                $where = "`app_id` = 3 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            d: <?php
                                $where = "`app_id` = 4 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            e: <?php
                                $where = "`app_id` = 5 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            f: <?php
                                $where = "`app_id` = 6 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            g: <?php
                                $where = "`app_id` = 7 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            h: <?php
                                $where = "`app_id` = 8 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                        },

                    <?php endfor; ?>
                ],
                xkey: 'y',
                ykeys: ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'],
                labels: ['PC', 'ICU', 'PON', 'BDN', 'WPN', 'TFX', 'T2G', 'SK'],
                lineColors: ['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB'],
                xLabelFormat: function(x) {
                    var month = months[x.getMonth()] + ' ' + x.getFullYear();
                    return month;
                },
                dateFormat: function(x) {
                    let d = new Date(x)
                    var month = months[d.getMonth()] + ' ' + d.getFullYear();;
                    return month;
                },
                resize: true,
                smooth: true,
                redraw: true
            });
            line_chart_demo.parent().attr('style', 'width: 100% !important;');



            var area_chart = Morris.Area({
                element: 'area-chart-demo',
                data: [
                    <?php
                    for ($m = 24; $m > 11; $m--) :
                        $nowmonth = strtotime(date('d-M-Y', strtotime('-' . $m . ' months')));
                        $lastmonth = strtotime(date('d-M-Y', strtotime('-' . ($m - 1) . ' months'))); ?> {

                            y: '<?php echo date('Y-m-d', strtotime('-' . $m . ' days')); ?>',
                            a: <?php
                                $where = "`app_id` = 1 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            b: <?php
                                $where = "`app_id` = 2 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            c: <?php
                                $where = "`app_id` = 3 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            d: <?php
                                $where = "`app_id` = 4 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            e: <?php
                                $where = "`app_id` = 5 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            f: <?php
                                $where = "`app_id` = 6 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            g: <?php
                                $where = "`app_id` = 7 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            h: <?php
                                $where = "`app_id` = 8 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                        },

                    <?php endfor; ?>
                ],
                xkey: 'y',
                ykeys: ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'],
                labels: ['PC', 'ICU', 'PON', 'BDN', 'WPN', 'TFX', 'T2G', 'SK'],
                lineColors: ['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB'],
                xLabelFormat: function(x) {
                    var month = months[x.getMonth()] + ' ' + x.getFullYear();
                    return month;
                },
                dateFormat: function(x) {
                    let d = new Date(x)
                    var month = months[d.getMonth()] + ' ' + d.getFullYear();;
                    return month;
                },
                resize: true,
                smooth: true,
                redraw: true
            });
            area_chart_demo.parent().attr('style', 'width: 100% !important;');



            // Donut Chart
            <?php
            $lastmonth = strtotime(date('Y-m-d H:m:s', strtotime('-11 months')));
            $nowmonth = strtotime(date('Y-m-d H:m:s', strtotime('-24 months')));
            ?>
            var donut_chart_demo = $("#donut-chart-demo");
            donut_chart_demo.parent().show();
            var donut_chart = Morris.Donut({
                element: 'donut-chart-demo',
                data: [{
                        label: "Product Customizer",
                        value: <?php
                                $where = "`app_id` = 1 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "In Cart Upsell",
                        value: <?php
                                $where = "`app_id` = 2 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "Pre Order Now",
                        value: <?php
                                $where = "`app_id` = 3 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "Bulk Discount Now",
                        value: <?php
                                $where = "`app_id` = 4 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "Wholesale Pricing Now",
                        value: <?php
                                $where = "`app_id` = 5 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "TrackifyX",
                        value: <?php
                                $where = "`app_id` = 6 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "Text 2 Give",
                        value: <?php
                                $where = "`app_id` = 7 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "SentryKit",
                        value: <?php
                                $where = "`app_id` = 1 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    }
                ],
                colors: ['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB']
            });
            donut_chart_demo.parent().attr('style', 'width: 100% !important;');
            <?php #echo $this->db->last_query();  
            ?>
        }

        function all_time() {
            // Line Charts
            <?php
            $ts1 = strtotime('01 January 2015');
            $ts2 = time();

            $year1 = '2015';
            $year2 = date('Y', $ts2);

            $month1 = '01';
            $month2 = date('m', $ts2);

            $diff = ((($year2 - $year1) * 12) + ($month2 - $month1));
            ?>
            var line_chart = Morris.Line({
                element: 'line-chart-demo',
                data: [
                    <?php
                    for ($m = $diff; $m > -1; $m--) :
                        $nowmonth = strtotime(date('d-M-Y', strtotime('-' . $m . ' months')));
                        $lastmonth = strtotime(date('d-M-Y', strtotime('-' . ($m - 1) . ' months'))); ?> {

                            y: '<?php echo date('Y-m-d', strtotime('-' . $m . ' days')); ?>',
                            a: <?php
                                $where = "`app_id` = 1 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            b: <?php
                                $where = "`app_id` = 2 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            c: <?php
                                $where = "`app_id` = 3 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            d: <?php
                                $where = "`app_id` = 4 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            e: <?php
                                $where = "`app_id` = 5 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            f: <?php
                                $where = "`app_id` = 6 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            g: <?php
                                $where = "`app_id` = 7 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            h: <?php
                                $where = "`app_id` = 8 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                        },

                    <?php endfor; ?>
                ],
                xkey: 'y',
                ykeys: ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'],
                labels: ['PC', 'ICU', 'PON', 'BDN', 'WPN', 'TFX', 'T2G', 'SK'],
                lineColors: ['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB'],
                xLabelFormat: function(x) {
                    var month = x.getDate() + ' ' + months[x.getMonth()] + ' ' + x.getFullYear();
                    return month;
                },
                dateFormat: function(x) {
                    let d = new Date(x)
                    var month = d.getDate() + ' ' + months[d.getMonth()] + ' ' + d.getFullYear();;
                    return month;
                },
                resize: true,
                smooth: true,
                redraw: true
            });
            line_chart_demo.parent().attr('style', 'width: 100% !important;');

            var area_chart = Morris.Area({
                element: 'area-chart-demo',
                data: [
                    <?php
                    for ($m = $diff; $m > -1; $m--) :
                        $nowmonth = strtotime(date('d-M-Y', strtotime('-' . $m . ' months')));
                        $lastmonth = strtotime(date('d-M-Y', strtotime('-' . ($m - 1) . ' months'))); ?> {

                            y: '<?php echo date('Y-m-d', strtotime('-' . $m . ' days')); ?>',
                            a: <?php
                                $where = "`app_id` = 1 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            b: <?php
                                $where = "`app_id` = 2 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            c: <?php
                                $where = "`app_id` = 3 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            d: <?php
                                $where = "`app_id` = 4 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            e: <?php
                                $where = "`app_id` = 5 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            f: <?php
                                $where = "`app_id` = 6 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            g: <?php
                                $where = "`app_id` = 7 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>,
                            h: <?php
                                $where = "`app_id` = 8 AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                        },

                    <?php endfor; ?>
                ],
                xkey: 'y',
                ykeys: ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'],
                labels: ['PC', 'ICU', 'PON', 'BDN', 'WPN', 'TFX', 'T2G', 'SK'],
                lineColors: ['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB'],
                xLabelFormat: function(x) {
                    var month = x.getDate() + ' ' + months[x.getMonth()] + ' ' + x.getFullYear();
                    return month;
                },
                dateFormat: function(x) {
                    let d = new Date(x)
                    var month = d.getDate() + ' ' + months[d.getMonth()] + ' ' + d.getFullYear();;
                    return month;
                },
                resize: true,
                smooth: true,
                redraw: true
            });
            area_chart_demo.parent().attr('style', 'width: 100% !important;');

            <?php $today = date('dmY', time()); ?>
            // Donut Chart
            var donut_chart_demo = $("#donut-chart-demo");
            donut_chart_demo.parent().show();
            var donut_chart = Morris.Donut({
                element: 'donut-chart-demo',
                data: [{
                        label: "Product Customizer",
                        value: <?php
                                $shown = $this->db->where('app_id', 1)->order_by('record_id', 'DESC')->limit(1)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "In Cart Upsell",
                        value: <?php
                                $shown = $this->db->where('app_id', 2)->order_by('record_id', 'DESC')->limit(1)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "Pre Order Now",
                        value: <?php
                                $shown = $this->db->where('app_id', 3)->order_by('record_id', 'DESC')->limit(1)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "Bulk Discount Now",
                        value: <?php
                                $shown = $this->db->where('app_id', 4)->order_by('record_id', 'DESC')->limit(1)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "Wholesale Pricing Now",
                        value: <?php
                                $shown = $this->db->where('app_id', 5)->order_by('record_id', 'DESC')->limit(1)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "TrackifyX",
                        value: <?php
                                $shown = $this->db->where('app_id', 6)->order_by('record_id', 'DESC')->limit(1)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "Text 2 Give",
                        value: <?php
                                $shown = $this->db->where('app_id', 7)->order_by('record_id', 'DESC')->limit(1)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    },
                    {
                        label: "SentryKit",
                        value: <?php
                                $shown = $this->db->where('app_id', 8)->order_by('record_id', 'DESC')->limit(1)->get('quaterly')->row()->last_30_days;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                                ?>
                    }
                ],
                colors: ['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB']
            });
            donut_chart_demo.parent().attr('style', 'width: 100% !important;');
        }

    });

    function getRandomInt(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }
</script>