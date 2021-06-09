<script>
    $('.morrischart').html(`<img src="<?php echo base_url('assets/images/loader.gif'); ?>" />`)
    let shopify_user_data;

    let user_data = []
    let installs_data = []
    let uninstalls_data = []
    let revenue_data = []
    let churn_data = []

    let reviews_data = [<?php for ($m = 7; $m > 0; $m--) :
                            $nowmonth = strtotime(date('d-M-Y', strtotime('-' . $m . ' days')));
                            $lastmonth = strtotime(date('d-M-Y', strtotime('-' . ($m - 1) . ' days'))); ?> {
                y: '<?php echo date('Y-m-d', strtotime('-' . $m . ' days')); ?>',
                a: <?php
                            $where = "`app_id` = $app_id AND `rating` = 5 AND `review_date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                            $reviews = $this->db->where($where)->get('reviews')->num_rows();
                            echo $reviews;
                    ?>,
                b: <?php
                            $where = "`app_id` = $app_id AND `rating` = 4 AND `review_date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                            $reviews = $this->db->where($where)->get('reviews')->num_rows();
                            echo $reviews;
                    ?>,
                c: <?php
                            $where = "`app_id` = $app_id AND `rating` = 3 AND `review_date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                            $reviews = $this->db->where($where)->get('reviews')->num_rows();
                            echo $reviews;
                    ?>,
                d: <?php
                            $where = "`app_id` = $app_id AND `rating` = 2 AND `review_date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                            $reviews = $this->db->where($where)->get('reviews')->num_rows();
                            echo $reviews;
                    ?>,
                e: <?php
                            $where = "`app_id` = $app_id AND `rating` = 1 AND `review_date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                            $reviews = $this->db->where($where)->get('reviews')->num_rows();
                            echo $reviews;
                    ?>
            },
        <?php endfor; ?>
    ];

    let revenue_keys = ['a']
    let revenue_labels = ['Revenue']
    let revenue_colors = ['#1D47F1']

    let user_keys = ['a']
    let user_labels = ['User Growth']
    let user_colors = ['#C90100']

    let install_labels = ['Installs']
    let install_colors = ['#E7C00B']

    let uninstall_labels = ['Uninstalls']
    let uninstall_colors = ['#D05421']

    let churn_labels = ['Churn (%)']
    let churn_colors = ['#71DFCC']

    let reviews_keys = ['a', 'b', 'c', 'd', 'e']
    let reviews_labels = ['5 star', '4 star', '3 star', '2 star', '1 star']
    let reviews_colors = ['#D05421', '#21D1B1', '#C90100', '#E7C00B', '#1E1E1E']

    function fetch_quaterly_data(app, from, to) {
        fetch(`${base_url}/get_quaterly/${app}/${from}/${to}`).then((r) => {
            r.text().then((d) => {
                revenue_data = JSON.parse(d)
                $('#revenue_chart').empty()
                drawLine('revenue_chart', revenue_data, revenue_keys, revenue_labels, revenue_colors)
            })
        })
    }

    jQuery(document).ready(function($) {
        $('#reviews_chart').empty()
        drawBar('reviews_chart', reviews_data, reviews_keys, reviews_labels, reviews_colors)

        fetch_revenue_data('<?php echo $app_id ?>', 0, 30)
        fetch_user_data('<?php echo $app_id ?>', 0, 30)
    })

    function fetch_user_data(app, from, to) {
        $.ajax({
            url: `${base_url}/get_shopify_user_data/user/${app}/${from}/${to}`,
            success: (shopify_user_data) => {
                $('#users_chart').empty()
                drawBar('users_chart', shopify_user_data.total_users, user_keys, user_labels, user_colors)
                $('#installs_chart').empty()
                drawLine('installs_chart', shopify_user_data.installs, revenue_keys, install_labels, install_colors)
                $('#uninstalls_chart').empty()
                drawLine('uninstalls_chart', shopify_user_data.uninstalls, revenue_keys, uninstall_labels, uninstall_colors)
                $('#churn_chart').empty()
                drawPercentLine('churn_chart', shopify_user_data.total_users, revenue_keys, churn_labels, churn_colors)
            }
        })
    }

    function fetch_revenue_data(app, from, to) {
        $.ajax({
            url: `${base_url}/get_shopify_user_data/finance/${app}/${from}/${to}`,
            success: (revenue_data) => {
                $('#revenue_chart').empty()
                drawLine('revenue_chart', revenue_data.net_sales, revenue_keys, revenue_labels, revenue_colors)
            }
        })
    }
</script>