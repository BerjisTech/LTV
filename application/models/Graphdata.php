<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Graphdata extends CI_Model
{

    private $count = "COUNT(IF(`event` = 'installed', 1, NULL)) installed, COUNT(IF(`event` = 'uninstalled', 1, NULL)) uninstalled, COUNT(IF(`event` = 'reactivated', 1, NULL)) reactivated, COUNT(IF(`event` = 'deactivated', 1, NULL)) deactivated";

    function users_month_or_more($app_id, $from, $to)
    {
        $group_by = $this->getGroup($from, $to);
        $where = $this->user_speficics($app_id, $from, $to)->where;

        $sql_install = "SELECT date_format(from_unixtime(date), '%Y-%m') as y, @users:=@users + (COUNT(IF(`event` = 'installed', 1, NULL)) + COUNT(IF(`event` = 'reactivated', 1, NULL))) a
                      FROM `app_users`
                      JOIN(select @users:=0) as a 
                      WHERE $where
                      $group_by
                      ORDER BY `date` ASC";

        $sql_uninstall = "SELECT date_format(from_unixtime(date), '%Y-%m') as y, @users:=@users + (COUNT(IF(`event` = 'uninstalled', 1, NULL)) + COUNT(IF(`event` = 'deactivated', 1, NULL))) a
                      FROM `app_users`
                      JOIN(select @users:=0) as a 
                      WHERE $where
                      $group_by
                      ORDER BY `date` ASC";

        $sql_total = "SELECT date_format(from_unixtime(date), '%Y-%m') as y, @users:=@users + (COUNT(IF(`event` = 'installed', 1, NULL)) + COUNT(IF(`event` = 'reactivated', 1, NULL)))-(COUNT(IF(`event` = 'uninstalled', 1, NULL)) + COUNT(IF(`event` = 'deactivated', 1, NULL))) as a
                      FROM `app_users`
                      JOIN(select @users:=0) as a 
                      WHERE $where
                      $group_by
                      ORDER BY `date` ASC";

        $data['installs'] = $this->db->query($sql_install)->result_array();
        $data['uninstalls'] = $this->db->query($sql_uninstall)->result_array();
        $data['total_users'] = $this->db->query($sql_total)->result_array();

        return $data;
    }

    function users_month_or_less($app_id, $from, $to)
    {
        $where = $this->user_speficics($app_id, $from, $to)->where;

        $sql_install = "SELECT date_format(from_unixtime(date), '%Y-%m-%d %H:%m:%s') as y, @users:=@users + (COUNT(IF(`event` = 'installed', 1, NULL)) + COUNT(IF(`event` = 'reactivated', 1, NULL))) a
                      FROM `app_users`
                      JOIN(select @users:=0) as a 
                      WHERE $where
                      GROUP BY date_format(from_unixtime(date), '%dm%Y')
                      ORDER BY `date` ASC";

        $sql_uninstall = "SELECT date_format(from_unixtime(date), '%Y-%m-%d %H:%m:%s') as y, @users:=@users + (COUNT(IF(`event` = 'uninstalled', 1, NULL)) + COUNT(IF(`event` = 'deactivated', 1, NULL))) a
                      FROM `app_users`
                      JOIN(select @users:=0) as a 
                      WHERE $where
                      GROUP BY date_format(from_unixtime(date), '%dm%Y')
                      ORDER BY `date` ASC";

        $sql_total = "SELECT date_format(from_unixtime(date), '%Y-%m-%d %H:%m:%s') as y, @users:=@users + (COUNT(IF(`event` = 'installed', 1, NULL)) + COUNT(IF(`event` = 'reactivated', 1, NULL)))-(COUNT(IF(`event` = 'uninstalled', 1, NULL)) + COUNT(IF(`event` = 'deactivated', 1, NULL))) as a
                      FROM `app_users`
                      JOIN(select @users:=0) as a 
                      WHERE $where
                      GROUP BY date_format(from_unixtime(date), '%dm%Y')
                      ORDER BY `date` ASC";

        $data['installs'] = $this->db->query($sql_install)->result_array();
        $data['uninstalls'] = $this->db->query($sql_uninstall)->result_array();
        $data['total_users'] = $this->db->query($sql_total)->result_array();
        return $data;
    }

    function revenue_month_or_more($app_id, $from, $to)
    {
        $where = $this->finance_speficics($app_id, $from, $to)->where;
        $group_by = $this->getGroup($from, $to);

        $sql_sales = "SELECT date_format(from_unixtime(date), '%Y-%m') as y, @amount:=@amount + SUM(`amount`) as a
                      FROM `app_finance`
                      JOIN(select @amount:=0) as a 
                      WHERE $where
                      $group_by
                      ORDER BY `date` ASC";

        $data['net_sales'] = $this->db->query($sql_sales)->result_array();
        $data['refunds'] = $this->db->select("date_format(from_unixtime(date), '%Y-%m') as y, SUM(`amount`*-1) a")->where($this->finance_speficics($app_id, $from, $to)->where)->where('amount <', 0)->order_by('date', 'ASC')->group_by("date_format(from_unixtime(date), '%m%Y')")->get('app_finance')->result_array();

        return $data;
    }

    function revenue_month_or_less($app_id, $from, $to)
    {
        $where = $this->finance_speficics($app_id, $from, $to)->where;
        $sql_sales = "SELECT date_format(from_unixtime(date), '%Y-%m-%d') as y, @amount:=@amount + SUM(`amount`) as a
                      FROM `app_finance`
                      JOIN(select @amount:=0) as a 
                      WHERE $where
                      GROUP BY date_format(from_unixtime(date), '%d%m%Y')
                      ORDER BY `date` ASC";

        $data['net_sales'] = $this->db->query($sql_sales)->result_array();
        $data['refunds'] = $this->db->select("date_format(from_unixtime(date), '%Y-%m-%d') as y, SUM(`amount`*-1) a")->where($where)->where('amount <', 0)->order_by('date', 'ASC')->group_by("date_format(from_unixtime(date), '%d%m%Y')")->get('app_finance')->result_array();

        return $data;
    }

    function all_users_month_or_more($from, $to)
    {
        $data = array();

        $data['revenue_keys'] = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'];
        $data['revenue_labels'] = ['PC', 'ICU', 'PON', 'BDN', 'WPN', 'TFX', 'T2G', 'SK'];
        $data['revenue_colors'] = ['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB'];

        $data['net_sales'] = array();

        $group_by = $this->getGroup($from, $to);
        $where = $this->all_app_speficics($from, $to)->where;

        $sql_user = "SELECT 
                                date_format(from_unixtime(date), '%Y-%m') as y, 
                                @users_a:=@users_a + (COUNT(IF(`event` = 'installed' AND `app_id` = 1, 1, NULL)) + COUNT(IF(`event` = 'reactivated' AND `app_id` = 1, 1, NULL))) a, 
                                @users_b:=@users_b + (COUNT(IF(`event` = 'installed' AND `app_id` = 2, 1, NULL)) + COUNT(IF(`event` = 'reactivated' AND `app_id` = 2, 1, NULL))) b, 
                                @users_c:=@users_c + (COUNT(IF(`event` = 'installed' AND `app_id` = 3, 1, NULL)) + COUNT(IF(`event` = 'reactivated' AND `app_id` = 3, 1, NULL))) c, 
                                @users_d:=@users_d + (COUNT(IF(`event` = 'installed' AND `app_id` = 4, 1, NULL)) + COUNT(IF(`event` = 'reactivated' AND `app_id` = 4, 1, NULL))) d, 
                                @users_e:=@users_e + (COUNT(IF(`event` = 'installed' AND `app_id` = 5, 1, NULL)) + COUNT(IF(`event` = 'reactivated' AND `app_id` = 5, 1, NULL))) e, 
                                @users_f:=@users_f + (COUNT(IF(`event` = 'installed' AND `app_id` = 6, 1, NULL)) + COUNT(IF(`event` = 'reactivated' AND `app_id` = 6, 1, NULL))) f, 
                                @users_g:=@users_g + (COUNT(IF(`event` = 'installed' AND `app_id` = 7, 1, NULL)) + COUNT(IF(`event` = 'reactivated' AND `app_id` = 7, 1, NULL))) g, 
                                @users_h:=@users_h + (COUNT(IF(`event` = 'installed' AND `app_id` = 8, 1, NULL)) + COUNT(IF(`event` = 'reactivated' AND `app_id` = 8, 1, NULL))) h
                        FROM `app_users`
                        JOIN(select @users_a:=0) as a 
                        JOIN(select @users_b:=0) as b 
                        JOIN(select @users_c:=0) as c 
                        JOIN(select @users_d:=0) as d 
                        JOIN(select @users_e:=0) as e 
                        JOIN(select @users_f:=0) as f 
                        JOIN(select @users_g:=0) as g 
                        JOIN(select @users_h:=0) as h 
                        WHERE $where
                        $group_by
                        ORDER BY `date` ASC";

        $As = $this->db->query($sql_user)->result_array();

        $data['net_sales'] = $As;
        return $data;
    }

    function all_users_month_or_less($from, $to)
    {
        $data = array();

        $data['revenue_keys'] = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'];
        $data['revenue_labels'] = ['PC', 'ICU', 'PON', 'BDN', 'WPN', 'TFX', 'T2G', 'SK'];
        $data['revenue_colors'] = ['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB'];

        $data['net_sales'] = array();


        $sql_user = "SELECT 
                            date_format(from_unixtime(date), '%Y-%m-%d %H:%m:%s') as y, 
                                @users_a:=@users_a + (COUNT(IF(`event` = 'installed' AND `app_id` = 1, 1, NULL)) + COUNT(IF(`event` = 'reactivated' AND `app_id` = 1, 1, NULL))) a, 
                                @users_b:=@users_b + (COUNT(IF(`event` = 'installed' AND `app_id` = 2, 1, NULL)) + COUNT(IF(`event` = 'reactivated' AND `app_id` = 2, 1, NULL))) b, 
                                @users_c:=@users_c + (COUNT(IF(`event` = 'installed' AND `app_id` = 3, 1, NULL)) + COUNT(IF(`event` = 'reactivated' AND `app_id` = 3, 1, NULL))) c, 
                                @users_d:=@users_d + (COUNT(IF(`event` = 'installed' AND `app_id` = 4, 1, NULL)) + COUNT(IF(`event` = 'reactivated' AND `app_id` = 4, 1, NULL))) d, 
                                @users_e:=@users_e + (COUNT(IF(`event` = 'installed' AND `app_id` = 5, 1, NULL)) + COUNT(IF(`event` = 'reactivated' AND `app_id` = 5, 1, NULL))) e, 
                                @users_f:=@users_f + (COUNT(IF(`event` = 'installed' AND `app_id` = 6, 1, NULL)) + COUNT(IF(`event` = 'reactivated' AND `app_id` = 6, 1, NULL))) f, 
                                @users_g:=@users_g + (COUNT(IF(`event` = 'installed' AND `app_id` = 7, 1, NULL)) + COUNT(IF(`event` = 'reactivated' AND `app_id` = 7, 1, NULL))) g, 
                                @users_h:=@users_h + (COUNT(IF(`event` = 'installed' AND `app_id` = 8, 1, NULL)) + COUNT(IF(`event` = 'reactivated' AND `app_id` = 8, 1, NULL))) h
                        FROM `app_users`
                        JOIN(select @users_a:=0) as a 
                        JOIN(select @users_b:=0) as b 
                        JOIN(select @users_c:=0) as c 
                        JOIN(select @users_d:=0) as d 
                        JOIN(select @users_e:=0) as e 
                        JOIN(select @users_f:=0) as f 
                        JOIN(select @users_g:=0) as g 
                        JOIN(select @users_h:=0) as h 
                      WHERE " . $this->all_app_speficics($from, $to)->where . "
                      GROUP BY date_format(from_unixtime(date), '%d%m%Y')
                      ORDER BY `date` ASC";

        $As = $this->db->query($sql_user)->result_array();

        $data['net_sales'] = $As;
        return $data;
    }

    function all_revenue_month_or_more($from, $to)
    {
        $data = array();

        $data['revenue_keys'] = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'];
        $data['revenue_labels'] = ['PC', 'ICU', 'PON', 'BDN', 'WPN', 'TFX', 'T2G', 'SK'];
        $data['revenue_colors'] = ['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB'];

        $data['net_sales'] = array();

        $group_by = $this->getGroup($from, $to);
        $where = $this->all_app_speficics($from, $to)->where;

        $sql_sales = "SELECT 
                            date_format(from_unixtime(date), '%Y-%m') as y, 
                            @amount_a:=@amount_a + SUM(IF(`app_id` = 1, `amount`, FALSE)) a, 
                            @amount_b:=@amount_b + SUM(IF(`app_id` = 2, `amount`, FALSE)) b, 
                            @amount_c:=@amount_c + SUM(IF(`app_id` = 3, `amount`, FALSE)) c, 
                            @amount_d:=@amount_d + SUM(IF(`app_id` = 4, `amount`, FALSE)) d, 
                            @amount_e:=@amount_e + SUM(IF(`app_id` = 5, `amount`, FALSE)) e, 
                            @amount_f:=@amount_f + SUM(IF(`app_id` = 6, `amount`, FALSE)) f, 
                            @amount_g:=@amount_g + SUM(IF(`app_id` = 7, `amount`, FALSE)) g, 
                            @amount_h:=@amount_h + SUM(IF(`app_id` = 8, `amount`, FALSE)) h
                      FROM `app_finance`
                      JOIN(select @amount_a:=0) as a 
                      JOIN(select @amount_b:=0) as b 
                      JOIN(select @amount_c:=0) as c 
                      JOIN(select @amount_d:=0) as d 
                      JOIN(select @amount_e:=0) as e 
                      JOIN(select @amount_f:=0) as f 
                      JOIN(select @amount_g:=0) as g 
                      JOIN(select @amount_h:=0) as h 
                      WHERE $where
                      $group_by
                      ORDER BY `date` ASC";

        $As = $this->db->query($sql_sales)->result_array();
        $data['net_sales'] = $As;
        return $data;
    }

    function all_revenue_month_or_less($from, $to)
    {
        $data = array();

        $data['revenue_keys'] = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'];
        $data['revenue_labels'] = ['PC', 'ICU', 'PON', 'BDN', 'WPN', 'TFX', 'T2G', 'SK'];
        $data['revenue_colors'] = ['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB'];

        $data['net_sales'] = array();

        $sql_sales = "SELECT 
                            date_format(from_unixtime(date), '%Y-%m-%d %H:%m:%s') as y, 
                            @amount_a:=@amount_a + SUM(IF(`app_id` = 1, `amount`, FALSE)) a, 
                            @amount_b:=@amount_b + SUM(IF(`app_id` = 2, `amount`, FALSE)) b, 
                            @amount_c:=@amount_c + SUM(IF(`app_id` = 3, `amount`, FALSE)) c, 
                            @amount_d:=@amount_d + SUM(IF(`app_id` = 4, `amount`, FALSE)) d, 
                            @amount_e:=@amount_e + SUM(IF(`app_id` = 5, `amount`, FALSE)) e, 
                            @amount_f:=@amount_f + SUM(IF(`app_id` = 6, `amount`, FALSE)) f, 
                            @amount_g:=@amount_g + SUM(IF(`app_id` = 7, `amount`, FALSE)) g, 
                            @amount_h:=@amount_h + SUM(IF(`app_id` = 8, `amount`, FALSE)) h
                      FROM `app_finance`
                      JOIN(select @amount_a:=0) as a 
                      JOIN(select @amount_b:=0) as b 
                      JOIN(select @amount_c:=0) as c 
                      JOIN(select @amount_d:=0) as d 
                      JOIN(select @amount_e:=0) as e 
                      JOIN(select @amount_f:=0) as f 
                      JOIN(select @amount_g:=0) as g 
                      JOIN(select @amount_h:=0) as h 
                      WHERE " . $this->all_app_speficics($from, $to)->where . "
                      GROUP BY date_format(from_unixtime(date), '%d%m%Y')
                      ORDER BY `date` ASC";

        $As = $this->db->query($sql_sales)->result_array();
        $data['net_sales'] = $As;
        return $data;
    }

    function all_revenue_month_pie($from, $to)
    {
        $total_apps = $this->db->get('apps')->result_array();
        $data['revenue_colors'] = ['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB'];

        for ($app = 0; $app <= count($total_apps) - 1; $app++) :
            $app_name = $total_apps[$app]['app_name'];
            $app_id = $total_apps[$app]['app_id'];

            $value = $this->db->select("'$app_name' as label, SUM(`amount`) value")->where($this->full_speficics($app_id, $from, $to)->where)->get('app_finance')->result_array()[0];
            if ($value['value'] == null) {
                $value['value'] = 0;
            }
            $value['value'] = $value['value'] + 0;
            $data['net_sales'][] = $value;
        endfor;

        return $data;
    }

    private function user_speficics($app_id, $from, $to)
    {

        $nowmonth = strtotime(date('d-M-Y', strtotime("-$from days")));
        $lastmonth = strtotime(date('d-M-Y', strtotime("-$to days")));

        $where = "`app_id` = $app_id AND `date` >= '" . $lastmonth . "' AND `date` <='" . $nowmonth . "'";

        return (object) array(
            'form' => $nowmonth,
            'to' => $lastmonth,
            'where' => $where
        );
    }

    private function finance_speficics($app_id, $from, $to)
    {

        $nowmonth = strtotime(date('d-M-Y', strtotime("-$from days")));
        $lastmonth = strtotime(date('d-M-Y', strtotime("-$to days")));

        $where = "`app_id` = $app_id AND `date` >= '" . $lastmonth . "' AND `date` <='" . $nowmonth . "'";

        return (object) array(
            'form' => $nowmonth,
            'to' => $lastmonth,
            'where' => $where
        );
    }

    private function full_speficics($app_id, $from, $to)
    {

        $nowmonth = strtotime(date('d-M-Y', strtotime("-$from days")));
        $lastmonth = strtotime(date('d-M-Y', strtotime("-$to days")));

        $where = "`app_id` = $app_id AND `date` >= '" . $lastmonth . "' AND `date` <='" . $nowmonth . "'";

        return (object) array(
            'form' => $nowmonth,
            'to' => $lastmonth,
            'where' => $where
        );
    }

    private function all_app_speficics($from, $to)
    {

        $nowmonth = strtotime(date('d-M-Y', strtotime("-$from days")));
        $lastmonth = strtotime(date('d-M-Y', strtotime("-$to days")));

        $where = "`date` >= '" . $lastmonth . "' AND `date` <='" . $nowmonth . "'";

        return (object) array(
            'form' => $nowmonth,
            'to' => $lastmonth,
            'where' => $where
        );
    }

    private function getKeys_and_Labels()
    {
        $data['revenue_keys'] = "['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h']";
        $data['revenue_labels'] = "['PC', 'ICU', 'PON', 'BDN', 'WPN', 'TFX', 'T2G', 'SK']";
        $data['revenue_colors'] = "['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB']";

        return $data;
    }

    private function getGroup($from, $to)
    {

        $range = ($to - $from);
        $month_count = number_format(($range / 30));

        $group_by = "GROUP BY date_format(from_unixtime(date), '%m%Y')";

        if ($month_count > 15) {
            $group_by = "GROUP BY date_format(from_unixtime(date), '%Y')";
        }

        return $group_by;
    }

    private function getYs($from, $to)
    {
        $y = array();

        $range = ($to - $from);
        $month_count = number_format(($range / 30));

        echo $from . ' ' . $to . ' ' . $range . ' ' . $month_count;

        if ($month_count < 3) {
            for ($m = $from; $m >= $to; $m--) {
                $y[] = date('Y-m-d', strtotime('-' . $m . ' days'));
            }
        }
        if ($month_count >= 3) {
            for ($m = $month_count; $m >= $to; $m--) {
                $y[] = date('Y-m', strtotime('-' . $m . ' months'));
            }
        }

        return $y;
    }
}


// SELECT `amount`, 
//  @amount:=@amount + SUM(IF(`app_id` = 1, `amount`, TRUE)) net_sales
// FROM `app_finance`
// join ( select @amount:=0 ) as mrr 