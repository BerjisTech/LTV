<script>
    let reviews_keys = ['a', 'b', 'c', 'd', 'e']
    let reviews_labels = ['5 star', '4 star', '3 star', '2 star', '1 star']
    let reviews_colors = ['#D05421', '#21D1B1', '#C90100', '#E7C00B', '#1E1E1E']
    <?php foreach ($all_apps as $app_data) : ?>
        let <?php echo $app_data['app_code']; ?>_reviews_data = [
            <?php for ($m = 30; $m > 0; $m--) :
                $app_id = $app_data['app_id'];
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
    <?php endforeach; ?>

    jQuery(document).ready(function($) {
        drawLine('pc_reviews_chart', pc_reviews_data, reviews_keys, reviews_labels, reviews_colors)
        drawLine('icu_reviews_chart', icu_reviews_data, reviews_keys, reviews_labels, reviews_colors)
        drawLine('pon_reviews_chart', pon_reviews_data, reviews_keys, reviews_labels, reviews_colors)
        drawLine('bdn_reviews_chart', bdn_reviews_data, reviews_keys, reviews_labels, reviews_colors)
        drawLine('wpn_reviews_chart', wpn_reviews_data, reviews_keys, reviews_labels, reviews_colors)
        drawLine('tfx_reviews_chart', tfx_reviews_data, reviews_keys, reviews_labels, reviews_colors)
    })
</script>