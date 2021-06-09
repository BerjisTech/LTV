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

        $('.adjust-stats').change(function() {
            $(".morrischart").empty();
            if ($(this).val() == "0") {
                fetch_user_data(0, 1);
                fetch_revenue_data(0, 1);
                fetch_compare_data(0, 1);
            }
            if ($(this).val() == "1") {
                fetch_user_data(0, 2);
                fetch_revenue_data(0, 2);
                fetch_compare_data(0, 2);
            }
            if ($(this).val() == "7") {
                fetch_user_data(0, 7);
                fetch_revenue_data(0, 7);
                fetch_compare_data(0, 7);
            }
            if ($(this).val() == "30") {
                fetch_user_data(0, 30);
                fetch_revenue_data(0, 30);
                fetch_compare_data(0, 30);
            }
            if ($(this).val() == "90") {
                fetch_user_data(0, 90);
                fetch_revenue_data(0, 90);
                fetch_compare_data(0, 90);
            }
            if ($(this).val() == "365") {
                fetch_user_data(0, 366);
                fetch_revenue_data(0, 366);
                fetch_compare_data(0, 366);
            }
            if ($(this).val() == "31") {
                fetch_user_data(30, 60);
                fetch_revenue_data(30, 60);
                fetch_compare_data(30, 60);
            }
            if ($(this).val() == "366") {
                fetch_user_data(365, 732);
                fetch_revenue_data(365, 732);
                fetch_compare_data(365, 732);
            }
            if ($(this).val() == "all") {
                fetch_user_data(0, 3000);
                fetch_revenue_data(0, 3000);
                fetch_compare_data(0, 3000);
            }
            if ($(this).val() == "") {
                fetch_user_data(0, 30);
                fetch_revenue_data(0, 30);
                fetch_compare_data(0, 30);
            }
        });

        function fetch_user_data(from, to) {
            $.ajax({
                url: `${base_url}/get_full_shopify_user_data/user/${from}/${to}`,
                success: (shopify_user_data) => {
                    $('#users_chart').empty()
                    if ($to > 30) {
                        drawLongLine('installs_chart', revenue_data.net_sales, revenue_keys, revenue_labels, revenue_colors)
                    }
                    if ($to <= 30) {
                        drawLine('installs_chart', revenue_data.net_sales, revenue_keys, revenue_labels, revenue_colors)
                    }
                }
            })
        }

        function fetch_revenue_data(from, to) {
            $.ajax({
                url: `${base_url}/get_full_shopify_user_data/finance/${from}/${to}`,
                success: (revenue_data) => {
                    $('#revenue_chart').empty()
                    if ($to > 30) {
                        drawLongLine('revenue_chart', revenue_data.net_sales, revenue_keys, revenue_labels, revenue_colors)
                    }
                    if ($to <= 30) {
                        drawLine('revenue_chart', revenue_data.net_sales, revenue_keys, revenue_labels, revenue_colors)
                    }
                }
            })
        }

        function fetch_compare_data(from, to) {
            $.ajax({
                url: `${base_url}/get_full_shopify_user_data/compare/${from}/${to}`,
                success: (revenue_data) => {
                    $('#comparison_chart').empty()
                    drawPie('comparison_chart', revenue_data.net_sales, revenue_keys, revenue_labels, revenue_colors)
                }
            })
        }

    });

    function getRandomInt(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }
</script>