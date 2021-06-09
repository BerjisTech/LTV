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
        $data['installs'] = $this
            ->db
            ->select("date_format(from_unixtime(date), '%Y-%m') as y, (COUNT(IF(`event` = 'installed', 1, NULL)) + COUNT(IF(`event` = 'reactivated', 1, NULL))) a")
            ->where($this->all_app_speficics($from, $to)->where)
            ->order_by('date', 'ASC')
            ->group_by("date_format(from_unixtime(date), '%m%Y')")
            ->get('shopify_data')
            ->result_array();
        return $data;
    }

    function all_users_month_or_less($from, $to)
    {
        $data['installs'] = $this
            ->db
            ->select("date_format(from_unixtime(date), '%Y-%m-%d') as y, (COUNT(IF(`event` = 'installed', 1, NULL)) + COUNT(IF(`event` = 'reactivated', 1, NULL))) a")
            ->where($this->all_app_speficics($from, $to)->where)->order_by('date', 'ASC')
            ->group_by("date_format(from_unixtime(date), '%d%m%Y')")
            ->get('shopify_data')
            ->result_array();
        return $data;
    }

    function all_revenue_month_or_more($from, $to)
    {
        $data['net_sales'] = $this->db->select("date_format(from_unixtime(date), '%Y-%m') as y, SUM(`amount`) a")->where($this->all_app_speficics($from, $to)->where)->order_by('date', 'ASC')->group_by("date_format(from_unixtime(date), '%m%Y')")->get('app_financials')->result_array();
        return $data;
    }

    function all_revenue_month_or_less($from, $to)
    {
        $data['net_sales'] = $this->db->select("date_format(from_unixtime(date), '%Y-%m-%d') as y, SUM(`amount`) a")->where($this->all_app_speficics($from, $to)->where)->order_by('date', 'ASC')->group_by("date_format(from_unixtime(date), '%d%m%Y')")->get('app_financials')->result_array();
        return $data;
    }

    function all_revenue_month_pie($from, $to)
    {
        $total_apps = $this->db->get('apps')->result_array();

        for ($app = 0; $app <= count($total_apps) - 1; $app++) :
            $app_name = $total_apps[$app]['app_name'];
            $app_id = $total_apps[$app]['app_id'];

            $value = $this->db->select("'$app_name' as y, SUM(`amount`) a")->where($this->full_speficics($app_id, $from, $to)->where)->get('app_financials')->result_array()[0];
            if ($value['a'] == null) {
                $value['a'] = 0;
            }
            $value['a'] = $value['a'] + 0;
            $data[] = $value;
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
}
