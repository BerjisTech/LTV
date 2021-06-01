<script>
    let revenue_data = [<?php for ($m = 30; $m > -1; $m--) :
                            $nowmonth = strtotime(date('d-M-Y', strtotime('-' . $m . ' days')));
                            $lastmonth = strtotime(date('d-M-Y', strtotime('-' . ($m - 1) . ' days'))); ?> {
                y: '<?php echo date('Y-m-d', strtotime('-' . $m . ' days')); ?>',
                a: <?php
                            $where = "`app_id` = $app_id AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                            $shown = $this->db->where($where)->get('quaterly')->row()->value;
                            if ($shown == '') {
                                echo '0';
                            } else {
                                echo $shown;
                            }
                    ?>
            },
        <?php endfor; ?>
    ];

    let user_data = [<?php for ($m = 30; $m > -1; $m--) :
                            $nowmonth = strtotime(date('d-M-Y', strtotime('-' . $m . ' days')));
                            $lastmonth = strtotime(date('d-M-Y', strtotime('-' . ($m - 1) . ' days'))); ?> {
                y: '<?php echo date('Y-m-d', strtotime('-' . $m . ' days')); ?>',
                a: <?php
                            $where = "`app_id` = $app_id AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                            $shown = $this->db->where($where)->get('daily_user_count')->row()->user_number;
                            if ($shown == '') {
                                echo '0';
                            } else {
                                echo $shown;
                            }
                    ?>
            },
        <?php endfor; ?>
    ];

    let installs_data = [<?php for ($m = 30; $m > -1; $m--) :
                                $nowmonth = strtotime(date('d-M-Y', strtotime('-' . $m . ' days')));
                                $lastmonth = strtotime(date('d-M-Y', strtotime('-' . ($m - 1) . ' days'))); ?> {
                y: '<?php echo date('Y-m-d', strtotime('-' . $m . ' days')); ?>',
                a: <?php
                                $where = "`app_id` = $app_id AND `recorded` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $shown = $this->db->where($where)->get('quaterly')->row()->value;
                                if ($shown == '') {
                                    echo '0';
                                } else {
                                    echo $shown;
                                }
                    ?>
            },
        <?php endfor; ?>
    ];

    let reviews_data = [<?php for ($m = 30; $m > -1; $m--) :
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
    let revenue_colors = ['#21D1B1']

    let reviews_keys = ['a', 'b', 'c', 'd', 'e']
    let reviews_labels = ['5 star', '4 star', '3 star', '2 star', '1 star']
    let reviews_colors = ['#D05421', '#21D1B1', '#C90100', '#E7C00B', '#1E1E1E']





    jQuery(document).ready(function($) {
        drawLines('revenue_chart', revenue_data, revenue_keys, revenue_labels, revenue_colors)
        drawLines('users_chart', user_data, revenue_keys, revenue_labels, revenue_colors)
        drawAreas('reviews_chart', reviews_data, reviews_keys, reviews_labels, reviews_colors)
    })
</script>