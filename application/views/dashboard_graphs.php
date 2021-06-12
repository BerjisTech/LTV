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
    $('.morrischart').html(`<img src="<?php echo base_url('assets/images/loader.gif'); ?>" />`)
    let user_data = []
    let revenue_data = []
    let compare_data = []
    let line_data = [];
    let spark_line = {
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
    };
    let short_spark_bar = {
        type: 'bar',
        barColor: '#ff6264'
    };
    let apps = <?php echo json_encode($apps); ?>;

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

        $('.inlinebar').sparkline('html', {
            type: 'line',
            barColor: '#ff6264'
        });

        loadGraphs(0, 366)

        $('.adjust-stats').change(function() {
            $(".morrischart").empty();
            if ($(this).val() == "0") {
                loadGraphs(0, 1)
            }
            if ($(this).val() == "1") {
                loadGraphs(0, 2)
            }
            if ($(this).val() == "7") {
                loadGraphs(0, 7)
            }
            if ($(this).val() == "30") {
                loadGraphs(0, 30)
            }
            if ($(this).val() == "90") {
                loadGraphs(0, 90)
            }
            if ($(this).val() == "365") {
                loadGraphs(0, 366)
            }
            if ($(this).val() == "31") {
                loadGraphs(30, 60)
            }
            if ($(this).val() == "366") {
                loadGraphs(365, 732)
            }
            if ($(this).val() == "all") {
                loadGraphs(0, 3000)
            }
            if ($(this).val() == "") {
                loadGraphs(0, 30)
            }
        });

    });

    fetchLineData()

    function loadGraphs(from, to) {
        fetch_user_data(from, to);
        fetch_revenue_data(from, to);
        fetch_compare_data(from, to);
    }

    function getRandomInt(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    function fetch_user_data(from, to) {
        $.ajax({
            url: `${base_url}/get_full_shopify_user_data/user/${from}/${to}`,
            success: (r) => {
                user_data = r
                $('#users_chart').empty()
                let range = (to - from);
                let month_count = Math.round((range / 30));
                if (month_count > 3) {
                    drawLongLine('users_chart', user_data.net_sales, user_data.revenue_keys, user_data.revenue_labels, user_data.revenue_colors)
                }
                if (month_count <= 3) {
                    if (range < 7) {
                        drawShortLine('users_chart', user_data.net_sales, user_data.revenue_keys, user_data.revenue_labels, user_data.revenue_colors)
                    } else {
                        drawLine('users_chart', user_data.net_sales, user_data.revenue_keys, user_data.revenue_labels, user_data.revenue_colors)
                    }
                }
            }
        })
    }

    function fetch_revenue_data(from, to) {
        $.ajax({
            url: `${base_url}/get_full_shopify_user_data/finance/${from}/${to}`,
            success: (r) => {
                revenue_data = r
                $('#revenue_chart').empty()
                let range = (to - from);
                let month_count = Math.round((range / 30));
                if (month_count > 3) {
                    drawLongLine('revenue_chart', revenue_data.net_sales, revenue_data.revenue_keys, revenue_data.revenue_labels, revenue_data.revenue_colors)
                }
                if (month_count <= 3) {
                    if (range < 7) {
                        drawShortLine('revenue_chart', revenue_data.net_sales, revenue_data.revenue_keys, revenue_data.revenue_labels, revenue_data.revenue_colors)
                    } else {
                        drawLine('revenue_chart', revenue_data.net_sales, revenue_data.revenue_keys, revenue_data.revenue_labels, revenue_data.revenue_colors)
                    }
                }
            }
        })
    }

    function fetch_compare_data(from, to) {
        $.ajax({
            url: `${base_url}/get_full_shopify_user_data/compare/${from}/${to}`,
            success: (r) => {
                compare_data = r
                $('#comparison_chart').empty()
                drawPie('comparison_chart', compare_data.net_sales, compare_data.revenue_colors)
            }
        })
    }

    function fetchLineData() {
        $.ajax({
            url: `${base_url}/get_line_data`,
            success: (data) => {
                line_data = data

                $(".fund-5").sparkline(line_data.fund_5, spark_line);
                $(".fund-6").sparkline(line_data.fund_6, spark_line);
                $(".fund-7").sparkline(line_data.fund_7, spark_line);
                $(".monthly-sales").sparkline(line_data.all, {
                    type: 'bar',
                    barColor: '#485671',
                    height: '250px',
                    barWidth: 20,
                    barSpacing: 3
                });
                $(".pie-chart").sparkline(line_data.pie, {
                    type: 'pie',
                    width: '95',
                    height: '95',
                    sliceColors: ['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB']
                });

                $(`.pc-bar`).sparkline(line_data.separate.pc, short_spark_bar)
                $(`.icu-bar`).sparkline(line_data.separate.icu, short_spark_bar)
                $(`.pon-bar`).sparkline(line_data.separate.pon, short_spark_bar)
                $(`.bdn-bar`).sparkline(line_data.separate.bdn, short_spark_bar)
                $(`.wpn-bar`).sparkline(line_data.separate.wpn, short_spark_bar)
                $(`.tfx-bar`).sparkline(line_data.separate.tfx, short_spark_bar)
                $(`.t2g-bar`).sparkline(line_data.separate.t2g, short_spark_bar)
                $(`.sk-bar`).sparkline(line_data.separate.sk, short_spark_bar)
            }
        })
    }
</script>