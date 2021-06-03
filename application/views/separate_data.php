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
                            $where = "`app_id` = $app_id AND `install_date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                            $installs = $this->db->where($where)->get('installs')->row();
                            $total = (($installs->new + $installs->reopened) - ($installs->uninstalled + $installs->closed));
                            if ($total == '') {
                                echo '0';
                            } else {
                                echo $total;
                            }
                    ?>
            },
        <?php endfor; ?>
    ];

    let installs_data = [<?php for ($m = 30; $m > 0; $m--) :
                                $nowmonth = strtotime(date('d-M-Y', strtotime('-' . $m . ' days')));
                                $lastmonth = strtotime(date('d-M-Y', strtotime('-' . ($m - 1) . ' days'))); ?> {
                y: '<?php echo date('Y-m-d', strtotime('-' . $m . ' days')); ?>',
                a: <?php
                                $where = "`app_id` = $app_id AND `install_date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $installs = $this->db->where($where)->get('installs')->row();
                                $total = ($installs->new + $installs->reopened);
                                if ($total == '') {
                                    echo '0';
                                } else {
                                    echo $total;
                                }
                    ?>
            },
        <?php endfor; ?>
    ];

    let uninstalls_data = [<?php for ($m = 30; $m > 0; $m--) :
                                $nowmonth = strtotime(date('d-M-Y', strtotime('-' . $m . ' days')));
                                $lastmonth = strtotime(date('d-M-Y', strtotime('-' . ($m - 1) . ' days'))); ?> {
                y: '<?php echo date('Y-m-d', strtotime('-' . $m . ' days')); ?>',
                a: <?php
                                $where = "`app_id` = $app_id AND `install_date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";
                                $installs = $this->db->where($where)->get('installs')->row();
                                $total = ($installs->uninstalled + $installs->closed);
                                if ($total == '') {
                                    echo '0';
                                } else {
                                    echo $total;
                                }
                    ?>
            },
        <?php endfor; ?>
    ];

    let reviews_data = [<?php for ($m = 30; $m > 0; $m--) :
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

    let reviews_keys = ['a', 'b', 'c', 'd', 'e']
    let reviews_labels = ['5 star', '4 star', '3 star', '2 star', '1 star']
    let reviews_colors = ['#D05421', '#21D1B1', '#C90100', '#E7C00B', '#1E1E1E']





    jQuery(document).ready(function($) {
        drawLine('revenue_chart', revenue_data, revenue_keys, revenue_labels, revenue_colors)
        drawBar('users_chart', user_data, user_keys, user_labels, user_colors)
        drawLine('installs_chart', installs_data, revenue_keys, install_labels, install_colors)
        drawLine('uninstalls_chart', uninstalls_data, revenue_keys, uninstall_labels, uninstall_colors)
        drawArea('reviews_chart', reviews_data, reviews_keys, reviews_labels, reviews_colors)
    })
</script>

<!-- (`install_id`, `app_id`, `total`, `new`, `reopened`, `install_date`)
('', 2, 50, 11, 46, 25, 1620209972),
('', 2, 34, 7, 38, 18, 1620296372),
('', 2, 47, 18, 31, 27, 1620382772),
('', 2, 43, 12, 34, 19, 1620469172),
('', 2, 30, 6, 29, 12, 1620555572),
('', 2, 51, 6, 34, 21, 1620641972),
('', 2, 51, 7, 52, 22, 1620728372),
('', 2, 45, 15, 41, 31, 1620814772),
('', 2, 41, 10, 38, 28, 1620901172),
('', 2, 58, 10, 36, 32, 1620987572),
('', 2, 40, 9, 28, 18, 1621073972),
('', 2, 47, 9, 31, 24, 1621160372),
('', 2, 60, 6, 48, 23, 1621246772),
('', 2, 45, 12, 42, 34, 1621333172),
('', 2, 59, 15, 49, 27, 1621419572),
('', 2, 48, 6, 38, 21, 1621505972),
('', 2, 32, 5, 37, 25, 1621592372),
('', 2, 25, 6, 21, 26, 1621678772),
('', 2, 35, 4, 24, 24, 1621765172),
('', 2, 52, 14, 34, 27, 1621851572),
('', 2, 60, 8, 38, 26, 1621937972),
('', 2, 77, 7, 45, 13, 1622024372),
('', 2, 51, 6, 52, 22, 1622110772),
('', 2, 44, 13, 40, 26, 1622197172),
('', 2, 33, 6, 36, 26, 1622283572),
('', 2, 30, 7, 29, 24, 1622369972),
('', 2, 31, 17, 32, 38, 1622456372),
('', 2, 41, 11, 50, 31, 1622456372) -->