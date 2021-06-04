<div class="mainFlex">
    <div class="leftPanel">
        <?php foreach ($apps as $app) : ?>
            <div class="appPane">
                <img src="<?php echo $app['app_logo']; ?>" />
                <div>
                    <span><?php echo $app['app_name']; ?></span>
                    <span><?php echo $app['app_platform']; ?>. Fund <?php echo $app['app_fund']; ?></span>
                    <a target="_BLANK" href="<?php echo $app['app_link']; ?>">App Listing</a>
                </div>
                <a class="app_link" href="<?php echo base_url('app/' . $app['app_id']); ?>">View App</a>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="mainPanel">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-primary" id="charts_env">
                    <div class="panel-heading">
                        <div class="panel-title">
                            Daily MRR Snapshots
                        </div>
                        <div class="panel-options">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#mrr-chart" data-toggle="tab">MRR</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="mrr-chart">
                                <div id="mrr-chart-pane" class="morrischart" style="height: 650px"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(() => {
        var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];

        function loadChart($dom) {
            var line_chart = Morris.Line({
                element: $dom,
                data: [
                    <?php
                    for ($m = 11; $m > 4; $m--) :
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
            $('#' + $dom).parent().attr('style', '');
        }
        loadChart('mrr-chart-pane')
    })
</script>