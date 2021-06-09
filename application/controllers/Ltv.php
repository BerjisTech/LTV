<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ltv extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        /* cache control */
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 2025 05:00:00 GMT");
        date_default_timezone_set("Africa/Nairobi");
        header('Access-Control-Allow-Origin: *');

        if (!isset($_SESSION['user_id'])) {
            header("Location: " . base_url() . "login");
        }
    }

    public function index()
    {
        $data['apps'] = $this->db->get('apps')->result_array();
        $data['page_title'] = 'LTV Group SaaS Fund';
        $data['page_name'] = 'dashboard';
        $this->load->view('index', $data);
    }

    public function manageapps()
    {
    }

    public function addapp()
    {
    }

    public function updateapp()
    {
    }

    public function app($app_id)
    {
        $app = $this->db->where('app_id', $app_id)->get('apps')->row();

        $app_code = $app->app_code;

        $data['app'] = $app;
        $data['app_id'] = $app->app_id;
        $data['page_name'] = 'app_2';
        $data['page_title'] = $app->app_name;
        $this->load->view('index', $data);
    }

    public function app_data($app_id)
    {
        $app = $this->db->where('app_id', $app_id)->get('apps')->row();

        $app_code = $app->app_code;

        $data['app'] = $app;
        $data['app_id'] = $app->app_id;
        $data['page_name'] = 'app';
        $data['page_title'] = $app->app_name;
        $this->load->view('index', $data);
    }

    public function reviews($app_id)
    {
        $app = $this->db->where('app_id', $app_id)->get('apps')->row();

        $app_code = $app->app_code;

        $data['app'] = $app;
        $data['app_id'] = $app_id;
        $data['all_apps'] = $this->db->get('apps')->result_array();
        $data['page_name'] = 'reviews';
        $data['page_title'] = 'Add Reviews';
        $this->load->view('index', $data);
    }

    public function revenue($app_id)
    {
        $app = $this->db->where('app_id', $app_id)->get('apps')->row();

        $app_code = $app->app_code;

        $data['app'] = $app;
        $data['app_id'] = $app_id;
        $data['all_apps'] = $this->db->get('apps')->result_array();
        $data['page_name'] = 'revenue';
        $data['page_title'] = 'Add Reviews';
        $this->load->view('index', $data);
    }

    public function add_revenue()
    {
        if ($_SERVER['REQUEST_METHOD'] = 'POST' && isset($_POST)) {
            $recorded = $this->input->post('recorded');
            $existence_check = $this->db->where('date_format(from_unixtime(quaterly.recorded), "%d%m%Y") =', date('dmY', strtotime($recorded)))->where('app_id', $this->input->post('app_id'))->get('quaterly');
            // echo $this->db->last_query();
            echo $existence_check->num_rows();
            if ($existence_check->num_rows() > 0) {
                $existsing_data = $existence_check->row();
                die('A record on ' . date('j\<\s\u\p\>S\<\/\s\u\p\> M, Y', strtotime($recorded)) . ' already exists.
            <br />
            Last 30 Days: $ ' . number_format(floatval($existsing_data->last_30_days)) . '
            <br />
            Gross MRR: $ ' . number_format(floatval($existsing_data->gross_mrr)) . '
            <br />
            Net Sales: $ ' . number_format(floatval($existsing_data->net_sales)));
            }
            $_POST['recorded'] = strtotime($this->input->post('recorded'));
            // echo json_encode($this->input->post());
            $data = $this->security->xss_clean($this->input->post());
            $this->db->insert('quaterly', $data);
        } else {
            die('No data was sent');
        }
    }

    public function users($app_id)
    {
        $app = $this->db->where('app_id', $app_id)->get('apps')->row();

        $app_code = $app->app_code;

        $data['app'] = $app;
        $data['app_id'] = $app_id;
        $data['all_apps'] = $this->db->get('apps')->result_array();
        $data['plans'] = $this->db->where('app_id', $app_id)->get('plans')->result_array();
        $data['page_name'] = 'users';
        $data['page_title'] = 'Users';
        $this->load->view('index', $data);
    }

    public function csv()
    {
        $csv_file = fopen(base_url('data/history.csv'), 'r');
        $csv_array = array();
        while ($csv_data = fgetcsv($csv_file, NULL, ",")) :
            $csv_array[] = $csv_data;
        endwhile;

        $data['countries'] = $this->db->get('countries')->result_array();
        $data['continents'] = $this->db->get('continents')->result_array();

        foreach ($csv_array as $key => $row) {
            if ($key > 0) {
                if ($row[0] != '') {
                    $row[0] = strtotime($row[0]);
                }
                if ($row[3] != '') {
                    $row[3] = strtotime($row[3]);
                }

                if ($row[1] == 'Installed' || $row[1] == 'Uninstalled' || $row[1] == 'Closed Store' || $row[1] == 'Re-opened Store')
                    echo "('', '2' ,'$row[0]','$row[1]','$row[2]','$row[3]','$row[4]','$row[5]','$row[6]','$row[7]'),<br />";

                // $db_data = array(
                //     'icu_id' => '',
                //     'date' => $row[0],
                //     'event' => $row[1],
                //     'details' => $row[2],
                //     'billing_date' => $row[3],
                //     'shop' => $row[4],
                //     'country' => $row[5],
                //     'email' => $row[6],
                //     'domain' => $row[7]
                // );

                // $this->db->insert('icu_daily', $db_data);
            }
        }

        // $data['csv_data'] = $csv_array;
        // $data['page_name'] = 'csv';
        // $data['page_title'] = 'CSV';
        // $this->load->view('index', $data);
    }

    public function add_plan()
    {
        $plan = $this->input->post('plan_name');

        if ($this->db->field_exists($plan, 'installs')) {
            $this->db->insert('plans', $this->security->xss_clean($this->input->post()));
        } else {
            $this->db->query("ALTER TABLE `installs` ADD `$plan` INT NOT NULL");
            $this->db->insert('plans', $this->security->xss_clean($this->input->post()));
        }
    }

    public function recordReviews()
    {
        if ($this->db->where('review_by', $this->input->post('review_by'))->get('reviews')->num_rows() > 0) {
            die('A review by ' . $this->input->post('review_by') . ' already exists');
        }
        $_POST['review_date'] = strtotime($this->input->post('review_date'));
        $data = $this->security->xss_clean($this->input->post());
        $this->db->insert('reviews', $data);
    }

    public function run_importer($app_id, $data_set, $cursor = '')
    {
        header('Content-Type: application/json');
        $this->load->model('Importer');

        if ($data_set == 'users') {
            $last_entry = $this->db->where('app_id', $app_id)->order_by('date', 'DESC')->limit(1)->get('shopify_data');
        }

        if ($data_set == 'financials') {
            $last_entry = $this->db->where('app_id', $app_id)->order_by('date', 'DESC')->limit(1)->get('app_financials');
        }

        $time_start = strtotime('-3000 days');

        if ($last_entry->num_rows() == 1 && isset($last_entry->row()->date)) {
            $time_start = ($last_entry->row()->date + 0);
        }

        $time_end = time();

        $message = $this->Importer->init_importer($app_id, $data_set,  $time_start, $time_end, $cursor);

        $user_message = $message["Processed Data"]["DB Stage"]["message"];

        echo json_encode($user_message);
    }

    public function run_full_importer($app_id, $data_set, $cursor = '')
    {
        header('Content-Type: application/json');
        $this->load->model('Importer');

        $time_start = strtotime('-3000 days');

        $time_end = time();

        $message = $this->Importer->init_importer($app_id, $data_set,  $time_start, $time_end, $cursor);

        $user_message = $message["Processed Data"]["DB Stage"]["message"];

        echo json_encode($message);
    }

    public function get_quaterly($app_id, $from, $to)
    {
        $nowmonth = strtotime(date('d-M-Y', strtotime("-$to days")));
        $lastmonth = strtotime(date('d-M-Y', strtotime("-$from days")));

        $where = "`app_id` = $app_id AND `recorded` <= '" . $lastmonth . "' AND `recorded` >='" . $nowmonth . "'";

        // $this->db->where($where)->get('shopify_data')->result_array();

        $fetched_data = $this->db->select('date_format(from_unixtime(recorded), "%Y-%m-%d") as y, last_30_days as a')->where($where)->order_by('recorded', 'ASC')->group_by('date_format(from_unixtime(recorded), "%d%m%Y")')->get('quaterly')->result_array();

        // echo $this->db->last_query();

        echo json_encode($fetched_data);
    }

    public function get_shopify_user_data($app_id, $from, $to)
    {
        $nowmonth = strtotime(date('d-M-Y', strtotime("-$to days")));
        $lastmonth = strtotime(date('d-M-Y', strtotime("-$from days")));

        $where = "`app_id` = $app_id AND `date` <= '" . $lastmonth . "' AND `date` >='" . $nowmonth . "'";

        // $this->db->where($where)->get('shopify_data')->result_array();

        $data['installs'] = $this->db->select("date_format(from_unixtime(date), '%Y-%m-%d') as y, (COUNT(IF(`event` = 'installed', 1, NULL)) + COUNT(IF(`event` = 'reactivated', 1, NULL))) a")->where($where)->order_by('date', 'ASC')->group_by("date_format(from_unixtime(date), '%d%m%Y')")->get('shopify_data')->result_array();
        $data['uninstalls'] = $this->db->select("date_format(from_unixtime(date), '%Y-%m-%d') as y, (COUNT(IF(`event` = 'uninstalled', 1, NULL)) + COUNT(IF(`event` = 'deactivated', 1, NULL))) a")->where($where)->order_by('date', 'ASC')->group_by("date_format(from_unixtime(date), '%d%m%Y')")->get('shopify_data')->result_array();

        $count = "COUNT(IF(`event` = 'installed', 1, NULL)) installed, 
        COUNT(IF(`event` = 'uninstalled', 1, NULL)) uninstalled, 
        COUNT(IF(`event` = 'reactivated', 1, NULL)) reactivated, 
        COUNT(IF(`event` = 'deactivated', 1, NULL)) deactivated";

        $data['total_users'] = $this->db->select("date_format(from_unixtime(date), '%Y-%m-%d') as y,
            (COUNT(IF(`event` = 'installed', 1, NULL)) + COUNT(IF(`event` = 'reactivated', 1, NULL)))-(COUNT(IF(`event` = 'uninstalled', 1, NULL)) + COUNT(IF(`event` = 'deactivated', 1, NULL))) as a
        ")->where($where)->order_by('date', 'ASC')->group_by('date_format(from_unixtime(date), "%d%m%Y")')->get('shopify_data')->result_array();

        echo json_encode($data);
    }

    function logout()
    {
        $this->session->sess_destroy();
        $this->session->set_flashdata('logout_notification', 'logged_out');
        redirect(base_url() . 'login', 'refresh');
    }

    /*public function csv($days)
    {
        header('Content-Type: application/json');
        $file = fopen(base_url('data/history.csv'), 'r');
        $data = array();
        $rows = array();

        while (($line = fgetcsv($file)) !== FALSE) :
            $data[] = $line;
        endwhile;

        $actual_data = json_encode($data);
        fclose($file);

        $time_start = strtotime("-$days days");
        $time_end = time();

        // echo 'After ' . date('d-m-Y', $time_start) . ' Before ' . date('d-m-Y', $time_end);
        // echo 'On ' . date('m-d-Y', $time_start) . '<br />';
        foreach ($data as $key => $row) {
            if ($key != 0 && $row[1] == 'Installed' && date('m-d-Y', strtotime($row[0])) == date('m-d-Y', $time_start)) {
                $row[0] = strtotime($row[0]);
                if ($row[3] != '') {
                    $row[3] = strtotime($row[3]);
                }

                // $this->db->insert('icu_table', array('icu_id' => '', 'date' => $row[0], 'event' => $row[1], 'details' => $row[2], 'billing_date' => $row[3], 'shop' => $row[4], 'country' => $row[5], 'email' => $row[6], 'domain' => $row[7]));
            }

            $rows[] = $row;
            // $rows[] = $row;
        }
        $data['history'] = $rows;
        echo json_encode($rows);
    }*/
}
