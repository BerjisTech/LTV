<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Graphdata extends CI_Model
{

    private $count = "COUNT(IF(`event` = 'installed', 1, NULL)) installed, COUNT(IF(`event` = 'uninstalled', 1, NULL)) uninstalled, COUNT(IF(`event` = 'reactivated', 1, NULL)) reactivated, COUNT(IF(`event` = 'deactivated', 1, NULL)) deactivated";

    function users_month_or_more($app_id, $from, $to)
    {
        $data['installs'] = $this->db->select("date_format(from_unixtime(date), '%Y-%m') as y, (COUNT(IF(`event` = 'installed', 1, NULL)) + COUNT(IF(`event` = 'reactivated', 1, NULL))) a")->where($this->user_speficics($app_id, $from, $to)->where)->order_by('date', 'ASC')->group_by("date_format(from_unixtime(date), '%m%Y')")->get('shopify_data')->result_array();
        $data['uninstalls'] = $this->db->select("date_format(from_unixtime(date), '%Y-%m') as y, (COUNT(IF(`event` = 'uninstalled', 1, NULL)) + COUNT(IF(`event` = 'deactivated', 1, NULL))) a")->where($this->user_speficics($app_id, $from, $to)->where)->order_by('date', 'ASC')->group_by("date_format(from_unixtime(date), '%m%Y')")->get('shopify_data')->result_array();


        $data['total_users'] = $this->db->select("date_format(from_unixtime(date), '%Y-%m') as y, (COUNT(IF(`event` = 'installed', 1, NULL)) + COUNT(IF(`event` = 'reactivated', 1, NULL)))-(COUNT(IF(`event` = 'uninstalled', 1, NULL)) + COUNT(IF(`event` = 'deactivated', 1, NULL))) as a")->where($this->user_speficics($app_id, $from, $to)->where)->order_by('date', 'ASC')->group_by('date_format(from_unixtime(date), "%m%Y")')->get('shopify_data')->result_array();

        return $data;
    }

    function users_month_or_less($app_id, $from, $to)
    {
        $data['installs'] = $this->db->select("date_format(from_unixtime(date), '%Y-%m-%d') as y, (COUNT(IF(`event` = 'installed', 1, NULL)) + COUNT(IF(`event` = 'reactivated', 1, NULL))) a")->where($this->user_speficics($app_id, $from, $to)->where)->order_by('date', 'ASC')->group_by("date_format(from_unixtime(date), '%d%m%Y')")->get('shopify_data')->result_array();
        $data['uninstalls'] = $this->db->select("date_format(from_unixtime(date), '%Y-%m-%d') as y, (COUNT(IF(`event` = 'uninstalled', 1, NULL)) + COUNT(IF(`event` = 'deactivated', 1, NULL))) a")->where($this->user_speficics($app_id, $from, $to)->where)->order_by('date', 'ASC')->group_by("date_format(from_unixtime(date), '%d%m%Y')")->get('shopify_data')->result_array();


        $data['total_users'] = $this->db->select("date_format(from_unixtime(date), '%Y-%m-%d') as y, (COUNT(IF(`event` = 'installed', 1, NULL)) + COUNT(IF(`event` = 'reactivated', 1, NULL)))-(COUNT(IF(`event` = 'uninstalled', 1, NULL)) + COUNT(IF(`event` = 'deactivated', 1, NULL))) as a")->where($this->user_speficics($app_id, $from, $to)->where)->order_by('date', 'ASC')->group_by('date_format(from_unixtime(date), "%d%m%Y")')->get('shopify_data')->result_array();

        return $data;
    }

    function revenue_month_or_more($app_id, $from, $to)
    {
        $data['net_sales'] = $this->db->select("date_format(from_unixtime(date), '%Y-%m') as y, SUM(`amount`) a")->where($this->finance_speficics($app_id, $from, $to)->where)->order_by('date', 'ASC')->group_by("date_format(from_unixtime(date), '%m%Y')")->get('app_financials')->result_array();
        $data['refunds'] = $this->db->select("date_format(from_unixtime(date), '%Y-%m') as y, SUM(`amount`*-1) a")->where($this->finance_speficics($app_id, $from, $to)->where)->where('amount <', 0)->order_by('date', 'ASC')->group_by("date_format(from_unixtime(date), '%m%Y')")->get('app_financials')->result_array();

        return $data;
    }

    function revenue_month_or_less($app_id, $from, $to)
    {
        $data['net_sales'] = $this->db->select("date_format(from_unixtime(date), '%Y-%m-%d') as y, SUM(`amount`) a")->where($this->finance_speficics($app_id, $from, $to)->where)->order_by('date', 'ASC')->group_by("date_format(from_unixtime(date), '%d%m%Y')")->get('app_financials')->result_array();
        $data['refunds'] = $this->db->select("date_format(from_unixtime(date), '%Y-%m-%d') as y, SUM(`amount`*-1) a")->where($this->finance_speficics($app_id, $from, $to)->where)->where('amount <', 0)->order_by('date', 'ASC')->group_by("date_format(from_unixtime(date), '%d%m%Y')")->get('app_financials')->result_array();

        return $data;
    }

    function all_users_month_or_more($from, $to)
    {
        $data = array();

        $data['revenue_keys'] = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'];
        $data['revenue_labels'] = ['PC', 'ICU', 'PON', 'BDN', 'WPN', 'TFX', 'T2G', 'SK'];
        $data['revenue_colors'] = ['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB'];

        $data['net_sales'] = array();

        $As = $this
            ->db
            ->select("
                date_format(from_unixtime(date), '%Y-%m') as y, 
                (COUNT(IF(`event` = 'installed' AND `app_id` = 1, 1, NULL)) + COUNT(IF(`event` = 'reactivated' AND `app_id` = 1, 1, NULL))) a,
                (COUNT(IF(`event` = 'installed' AND `app_id` = 2, 1, NULL)) + COUNT(IF(`event` = 'reactivated' AND `app_id` = 2, 1, NULL))) b,
                (COUNT(IF(`event` = 'installed' AND `app_id` = 3, 1, NULL)) + COUNT(IF(`event` = 'reactivated' AND `app_id` = 3, 1, NULL))) c,
                (COUNT(IF(`event` = 'installed' AND `app_id` = 4, 1, NULL)) + COUNT(IF(`event` = 'reactivated' AND `app_id` = 4, 1, NULL))) d,
                (COUNT(IF(`event` = 'installed' AND `app_id` = 5, 1, NULL)) + COUNT(IF(`event` = 'reactivated' AND `app_id` = 5, 1, NULL))) e,
                (COUNT(IF(`event` = 'installed' AND `app_id` = 6, 1, NULL)) + COUNT(IF(`event` = 'reactivated' AND `app_id` = 6, 1, NULL))) f,
                (COUNT(IF(`event` = 'installed' AND `app_id` = 7, 1, NULL)) + COUNT(IF(`event` = 'reactivated' AND `app_id` = 7, 1, NULL))) g,
                (COUNT(IF(`event` = 'installed' AND `app_id` = 8, 1, NULL)) + COUNT(IF(`event` = 'reactivated' AND `app_id` = 8, 1, NULL))) h
                ")
            ->where($this->all_app_speficics($from, $to)->where)
            ->order_by('date', 'ASC')
            ->group_by("date_format(from_unixtime(date), '%m%Y')")
            ->get('shopify_data')
            ->result_array();

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

        $As = $this
            ->db
            ->select("date_format(from_unixtime(date), '%Y-%m-%d') as y,
            (COUNT(IF(`event` = 'installed' AND `app_id` = 1, 1, NULL)) + COUNT(IF(`event` = 'reactivated' AND `app_id` = 1, 1, NULL))) a,
            (COUNT(IF(`event` = 'installed' AND `app_id` = 2, 1, NULL)) + COUNT(IF(`event` = 'reactivated' AND `app_id` = 2, 1, NULL))) b,
            (COUNT(IF(`event` = 'installed' AND `app_id` = 3, 1, NULL)) + COUNT(IF(`event` = 'reactivated' AND `app_id` = 3, 1, NULL))) c,
            (COUNT(IF(`event` = 'installed' AND `app_id` = 4, 1, NULL)) + COUNT(IF(`event` = 'reactivated' AND `app_id` = 4, 1, NULL))) d,
            (COUNT(IF(`event` = 'installed' AND `app_id` = 5, 1, NULL)) + COUNT(IF(`event` = 'reactivated' AND `app_id` = 5, 1, NULL))) e,
            (COUNT(IF(`event` = 'installed' AND `app_id` = 6, 1, NULL)) + COUNT(IF(`event` = 'reactivated' AND `app_id` = 6, 1, NULL))) f,
            (COUNT(IF(`event` = 'installed' AND `app_id` = 7, 1, NULL)) + COUNT(IF(`event` = 'reactivated' AND `app_id` = 7, 1, NULL))) g,
            (COUNT(IF(`event` = 'installed' AND `app_id` = 8, 1, NULL)) + COUNT(IF(`event` = 'reactivated' AND `app_id` = 8, 1, NULL))) h
            ")
            ->where($this->all_app_speficics($from, $to)->where)->order_by('date', 'ASC')
            ->group_by("date_format(from_unixtime(date), '%d%m%Y')")
            ->get('shopify_data')
            ->result_array();

        $data['net_sales'][] = $As;
        return $data;
    }

    function all_revenue_month_or_more($from, $to)
    {
        $data = array();

        $data['revenue_keys'] = "['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h']";
        $data['revenue_labels'] = "['PC', 'ICU', 'PON', 'BDN', 'WPN', 'TFX', 'T2G', 'SK']";
        $data['revenue_colors'] = "['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB']";

        $data['net_sales'] = array();

        $As = $this->db->select("
            date_format(from_unixtime(date), '%Y-%m') as y, 
            SUM(IF(`amount` != NULL AND `app_id` = 1, 0, FALSE)) a, 
            SUM(IF(`amount` != NULL AND `app_id` = 2, 0, FALSE)) b, 
            SUM(IF(`amount` != NULL AND `app_id` = 3, 0, FALSE)) c, 
            SUM(IF(`amount` != NULL AND `app_id` = 4, 0, FALSE)) d, 
            SUM(IF(`amount` != NULL AND `app_id` = 5, 0, FALSE)) e, 
            SUM(IF(`amount` != NULL AND `app_id` = 6, 0, FALSE)) f, 
            SUM(IF(`amount` != NULL AND `app_id` = 7, 0, FALSE)) g, 
            SUM(IF(`amount` != NULL AND `app_id` = 8, 0, FALSE)) h
            ")->where($this->all_app_speficics($from, $to)->where)->order_by('date', 'ASC')->group_by("date_format(from_unixtime(date), '%m%Y')")->get('app_financials')->result_array();
        $data['net_sales'][] = $As;
        return $data;
    }

    function all_revenue_month_or_less($from, $to)
    {
        $data = array();

        $data['revenue_keys'] = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'];
        $data['revenue_labels'] = ['PC', 'ICU', 'PON', 'BDN', 'WPN', 'TFX', 'T2G', 'SK'];
        $data['revenue_colors'] = ['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB'];

        $data['net_sales'] = array();

        $As = $this->db->select("
            date_format(from_unixtime(date), '%Y-%m-%d') as y,
            SUM(IF(`amount` != NULL AND `app_id` = 1, 0, FALSE)) a, 
            SUM(IF(`amount` != NULL AND `app_id` = 2, 0, FALSE)) b, 
            SUM(IF(`amount` != NULL AND `app_id` = 3, 0, FALSE)) c, 
            SUM(IF(`amount` != NULL AND `app_id` = 4, 0, FALSE)) d, 
            SUM(IF(`amount` != NULL AND `app_id` = 5, 0, FALSE)) e, 
            SUM(IF(`amount` != NULL AND `app_id` = 6, 0, FALSE)) f, 
            SUM(IF(`amount` != NULL AND `app_id` = 7, 0, FALSE)) g, 
            SUM(IF(`amount` != NULL AND `app_id` = 8, 0, FALSE)) h
            ")->where($this->all_app_speficics($from, $to)->where)->order_by('date', 'ASC')->group_by("date_format(from_unixtime(date), '%d%m%Y')")->get('app_financials')->result_array();
        $data['net_sales'][] = $As;
        return $data;
    }

    function all_revenue_month_pie($from, $to)
    {
        $total_apps = $this->db->get('apps')->result_array();
        $data['revenue_colors'] = ['#D05421', '#21D1B1', '#C90100', '#C90100', '#C90100', '#E7C00B', '#1E1E1E', '#3CC2EB'];

        for ($app = 0; $app <= count($total_apps) - 1; $app++) :
            $app_name = $total_apps[$app]['app_name'];
            $app_id = $total_apps[$app]['app_id'];

            $value = $this->db->select("'$app_name' as label, SUM(`amount`) value")->where($this->full_speficics($app_id, $from, $to)->where)->get('app_financials')->result_array()[0];
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
