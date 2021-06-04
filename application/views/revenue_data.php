<script>
    let revenue_keys = ['a']
    let revenue_labels = ['Revenue']
    let revenue_colors = ['#D05421']

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

    jQuery(document).ready(function($) {
        drawLine('revenue_line', revenue_data, revenue_keys, revenue_labels, revenue_colors)
        drawArea('revenue_area', revenue_data, revenue_keys, revenue_labels, revenue_colors)
        drawBar('revenue_bar', revenue_data, revenue_keys, revenue_labels, revenue_colors)
        // drawPie('revenue_pie', revenue_data, revenue_keys, revenue_labels, revenue_colors)
    })
</script>