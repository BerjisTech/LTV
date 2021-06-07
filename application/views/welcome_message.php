<!-- let user_data = [<?php for ($m = 30; $m > -1; $m--) :
                            $nowmonth = strtotime(date('d-M-Y', strtotime('-' . $m . ' days')));
                            $lastmonth = strtotime(date('d-M-Y', strtotime('-' . ($m - 1) . ' days'))); ?> {
                y: '<?php echo date('Y-m-d', strtotime('-' . $m . ' days')); ?>',
                a: <?php
                            $where = "`app_id` = $app_id AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";

                            $installed = $this->db->select('count(event) as counted')->where('event', 'installed')->where($where)->get('shopify_data')->row()->counted;
                            $reactivated = $this->db->select('count(event) as counted')->where('event', 'reactivated')->where($where)->get('shopify_data')->row()->counted;
                            $uninstalled = $this->db->select('count(event) as counted')->where('event', 'uninstalled')->where($where)->get('shopify_data')->row()->counted;
                            $deactivated = $this->db->select('count(event) as counted')->where('event', 'deactivated')->where($where)->get('shopify_data')->row()->counted;

                            $total = (($installed + $reactivated) - ($uninstalled + $deactivated));
                            if ($total == '') {
                                echo '0';
                            } else {
                                echo $this->db->last_query();
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
                                $where = "`app_id` = $app_id AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";

                                $installed = $this->db->select('count(event) as counted')->where('event', 'installed')->where($where)->get('shopify_data')->row()->counted;
                                $reactivated = $this->db->select('count(event) as counted')->where('event', 'reactivated')->where($where)->get('shopify_data')->row()->counted;

                                $total = ($installed + $reactivated);
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
                                $where = "`app_id` = $app_id AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";

                                $uninstalled = $this->db->select('count(event) as counted')->where('event', 'uninstalled')->where($where)->get('shopify_data')->row()->counted;
                                $deactivated = $this->db->select('count(event) as counted')->where('event', 'deactivated')->where($where)->get('shopify_data')->row()->counted;

                                $total = ($uninstalled + $deactivated);
                                echo $total;
                    ?>
            },
        <?php endfor; ?>
    ];

    let churn_data = [<?php for ($m = 30; $m > 0; $m--) :
                            $nowmonth = strtotime(date('d-M-Y', strtotime('-' . $m . ' days')));
                            $lastmonth = strtotime(date('d-M-Y', strtotime('-' . ($m - 1) . ' days'))); ?> {
                y: '<?php echo date('Y-m-d', strtotime('-' . $m . ' days')); ?>',
                a: <?php
                            $where = "`app_id` = $app_id AND `date` BETWEEN '" . $nowmonth . "' AND '" . $lastmonth . "'";

                            $installed = $this->db->select('count(event) as counted')->where('event', 'installed')->where($where)->get('shopify_data')->row()->counted;
                            $reactivated = $this->db->select('count(event) as counted')->where('event', 'reactivated')->where($where)->get('shopify_data')->row()->counted;
                            $uninstalled = $this->db->select('count(event) as counted')->where('event', 'uninstalled')->where($where)->get('shopify_data')->row()->counted;
                            $deactivated = $this->db->select('count(event) as counted')->where('event', 'deactivated')->where($where)->get('shopify_data')->row()->counted;

                            $lost = ($uninstalled + $reactivated);
                            $gained = ($installed + $deactivated);

                            if ($lost == '' || $lost == 0 || $gained == '' || $gained == 0) {
                                $total = 0;
                            } else {
                                $total = (($lost / $gained) * 100);
                            }
                            echo number_format($m);
                    ?>
            },
        <?php endfor; ?>
    ]; -->