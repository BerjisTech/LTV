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

        $data['app'] = $app;
        $data['app_id'] = $app_id;
        $data['all_apps'] = $this->db->get('apps')->result_array();
        $data['plans'] = $this->db->where('app_id', $app_id)->get('plans')->result_array();
        $data['page_name'] = 'users';
        $data['page_title'] = 'Users';
        $this->load->view('index', $data);
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

        $message = $this->Importer->init_importer($app_id, $data_set, 'before', $time_start, $time_end, $cursor);

        $user_message = $message["Processed Data"]["DB Stage"]["message"];

        echo json_encode($user_message);
    }

    public function run_full_importer($app_id, $data_set, $cursor = '')
    {
        header('Content-Type: application/json');
        $this->load->model('Importer');

        if ($data_set == 'users') {
            $last_cursor = $this->db->where('app_id', $app_id)->order_by('date', 'ASC')->limit(1)->get('shopify_data');
        }

        if ($data_set == 'financials') {
            $last_cursor = $this->db->where('app_id', $app_id)->order_by('date', 'ASC')->limit(1)->get('app_financials');
        }

        if ($last_cursor->num_rows() == 1 && isset($last_cursor->row()->cursor)) {
            $cursor = $last_cursor->row()->cursor;
        }

        $time_start = 1350311010; // strtotime('-3500 days');

        $time_end = time();

        $message = $this->Importer->init_importer($app_id, $data_set, 'after', $time_start, $time_end, $cursor);

        $user_message = $message["Processed Data"]["DB Stage"]["message"];

        echo json_encode($message);
    }

    public function get_quaterly($app_id, $from, $to)
    {
        $nowmonth = strtotime(date('d-M-Y', strtotime("-$to days")));
        $lastmonth = strtotime(date('d-M-Y', strtotime("-$from days")));

        $where = "`app_id` = $app_id AND `recorded` <= '" . $lastmonth . "' AND `recorded` >='" . $nowmonth . "'";

        $fetched_data = $this->db->select('date_format(from_unixtime(recorded), "%Y-%m-%d") as y, last_30_days as a')->where($where)->order_by('recorded', 'ASC')->group_by('date_format(from_unixtime(recorded), "%d%m%Y")')->get('quaterly')->result_array();

        echo json_encode($fetched_data);
    }

    public function get_shopify_user_data($data_set, $app_id, $from, $to)
    {
        header('Content-Type: application/json');

        $this->load->model('Graphdata');

        if ($data_set == 'user') {
            if ($to <= 30) {
                $data = $this->Graphdata->users_month_or_less($app_id, $from, $to);
            }
            if ($to > 30) {
                $data = $this->Graphdata->users_month_or_more($app_id, $from, $to);
            }
        }
        if ($data_set == 'finance') {
            if ($to <= 30) {
                $data = $this->Graphdata->revenue_month_or_less($app_id, $from, $to);
            }
            if ($to > 30) {
                $data = $this->Graphdata->revenue_month_or_more($app_id, $from, $to);
            }
        }

        echo json_encode($data);
    }
    public function get_line_data()
    {
        header('Content-Type: application/json');

        $query_5 = "SELECT @amount:=@amount + sum(amount) as a 
                    FROM `app_financials`
                    JOIN(select @amount:=0) as a
                    LEFT OUTER JOIN `apps` ON `app_financials`.`app_id` = `apps`.`app_id`
                    WHERE `app_fund` = 5
                    GROUP BY date_format(from_unixtime(date), '%m%Y')
                    ORDER BY `date` ASC";
        $query_6 = "SELECT @amount:=@amount + sum(amount) as a 
                    FROM `app_financials`
                    JOIN(select @amount:=0) as a
                    LEFT OUTER JOIN `apps` ON `app_financials`.`app_id` = `apps`.`app_id`
                    WHERE `app_fund` = 6
                    GROUP BY date_format(from_unixtime(date), '%m%Y')
                    ORDER BY `date` ASC";
        $query_7 = "SELECT @amount:=@amount + sum(amount) as a 
                    FROM `app_financials`
                    JOIN(select @amount:=0) as a
                    LEFT OUTER JOIN `apps` ON `app_financials`.`app_id` = `apps`.`app_id`
                    WHERE `app_fund` = 7
                    GROUP BY date_format(from_unixtime(date), '%m%Y')
                    ORDER BY `date` ASC";
        $all = "SELECT @amount:=@amount + sum(amount) as a 
                    FROM `app_financials`
                    JOIN(select @amount:=0) as a
                    LEFT OUTER JOIN `apps` ON `app_financials`.`app_id` = `apps`.`app_id`
                    GROUP BY date_format(from_unixtime(date), '%Y')
                    ORDER BY `date` ASC";

        $pie = "SELECT @amount_a:=@amount_a + SUM(IF(`app_id` = 1, `amount`, FALSE)) a, 
                       @amount_b:=@amount_b + SUM(IF(`app_id` = 2, `amount`, FALSE)) b, 
                       @amount_c:=@amount_c + SUM(IF(`app_id` = 3, `amount`, FALSE)) c, 
                       @amount_d:=@amount_d + SUM(IF(`app_id` = 4, `amount`, FALSE)) d, 
                       @amount_e:=@amount_e + SUM(IF(`app_id` = 5, `amount`, FALSE)) e, 
                       @amount_f:=@amount_f + SUM(IF(`app_id` = 6, `amount`, FALSE)) f, 
                       @amount_g:=@amount_g + SUM(IF(`app_id` = 7, `amount`, FALSE)) g, 
                       @amount_h:=@amount_h + SUM(IF(`app_id` = 8, `amount`, FALSE)) h
                    FROM `app_financials`
                    JOIN(select @amount_a:=0) as a 
                    JOIN(select @amount_b:=0) as b 
                    JOIN(select @amount_c:=0) as c 
                    JOIN(select @amount_d:=0) as d 
                    JOIN(select @amount_e:=0) as e 
                    JOIN(select @amount_f:=0) as f 
                    JOIN(select @amount_g:=0) as g 
                    JOIN(select @amount_h:=0) as h
                    ORDER BY `date` ASC ";

        $separate = "SELECT @amount_a:=@amount_a + SUM(IF(`app_id` = 1, `amount`, FALSE)) pc, 
                       @amount_b:=@amount_b + SUM(IF(`app_id` = 2, `amount`, FALSE)) icu, 
                       @amount_c:=@amount_c + SUM(IF(`app_id` = 3, `amount`, FALSE)) pon, 
                       @amount_d:=@amount_d + SUM(IF(`app_id` = 4, `amount`, FALSE)) bdn, 
                       @amount_e:=@amount_e + SUM(IF(`app_id` = 5, `amount`, FALSE)) wpn, 
                       @amount_f:=@amount_f + SUM(IF(`app_id` = 6, `amount`, FALSE)) tfx, 
                       @amount_g:=@amount_g + SUM(IF(`app_id` = 7, `amount`, FALSE)) t2g, 
                       @amount_h:=@amount_h + SUM(IF(`app_id` = 8, `amount`, FALSE)) sk
                    FROM `app_financials`
                    JOIN(select @amount_a:=0) as pc
                    JOIN(select @amount_b:=0) as icu
                    JOIN(select @amount_c:=0) as pon
                    JOIN(select @amount_d:=0) as bdn
                    JOIN(select @amount_e:=0) as wpn
                    JOIN(select @amount_f:=0) as tfx
                    JOIN(select @amount_g:=0) as t2g
                    JOIN(select @amount_h:=0) as sk
                    GROUP BY date_format(from_unixtime(date), '%m%Y')
                    ORDER BY `date` ASC";

        $fund_5 = $this->db->query($query_5)->result_array();
        $fund_6 = $this->db->query($query_6)->result_array();
        $fund_7 = $this->db->query($query_7)->result_array();
        $fund_all = $this->db->query($all)->result_array();
        $line_data['pie'] = $this->db->query($pie)->row();
        $separate = $this->db->query($separate)->result_array();

        foreach ($fund_5 as $fund_5_data) {
            $line_data['fund_5'][] = $fund_5_data['a'];
        }

        foreach ($fund_6 as $fund_6_data) {
            $line_data['fund_6'][] = $fund_6_data['a'];
        }

        foreach ($fund_7 as $fund_7_data) {
            $line_data['fund_7'][] = $fund_7_data['a'];
        }

        foreach ($fund_all as $all_data) {
            $line_data['all'][] = $all_data['a'];
        }

        foreach ($separate as $separate_data) {
            $line_data['separate']['pc'][] = $separate_data['pc'];
            $line_data['separate']['icu'][] = $separate_data['icu'];
            $line_data['separate']['pon'][] = $separate_data['pon'];
            $line_data['separate']['bdn'][] = $separate_data['bdn'];
            $line_data['separate']['wpn'][] = $separate_data['wpn'];
            $line_data['separate']['tfx'][] = $separate_data['tfx'];
            $line_data['separate']['t2g'][] = $separate_data['t2g'];
            $line_data['separate']['sk'][] = $separate_data['sk'];
        }

        echo json_encode($line_data);
    }

    public function get_full_shopify_user_data($data_set, $from, $to)
    {
        header('Content-Type: application/json');

        $this->load->model('Graphdata');
        $data['net_sales'] = array();

        $range = ($to - $from);
        $month_count = number_format(($range / 30));

        if ($data_set == 'user') {
            if ($month_count < 3) {
                $data = $this->Graphdata->all_users_month_or_less($from, $to);
            }
            if ($month_count >= 3) {
                $data = $this->Graphdata->all_users_month_or_more($from, $to);
            }
        }
        if ($data_set == 'finance') {
            if ($month_count < 3) {
                $data = $this->Graphdata->all_revenue_month_or_less($from, $to);
            }
            if ($month_count >= 3) {
                $data = $this->Graphdata->all_revenue_month_or_more($from, $to);
            }
        }
        if ($data_set == 'compare') {
            $data = $this->Graphdata->all_revenue_month_pie($from, $to);
        }

        echo json_encode((object) $data);
    }

    public function filter_shopify_data()
    {
        $query = "delete from `shopify_data` where `data_id` not in (select min(`data_id`) from (select * from `shopify_data`) as x group by `date`)";
        $this->db->query($query);
    }

    public function filter_app_financials()
    {
        $query = "delete from `app_financials` where `finance_id` not in (select min(`finance_id`) from (select * from `app_financials`) as x group by `date`)";
        $this->db->query($query);
    }

    public function get_csv($app_id, $data_set, $cursor = '')
    {
        header('Content-Type: application/json');
        $this->load->model('Csvgen');

        $time_start = strtotime('-3500 days');

        $time_end = time();

        $message = $this->Csvgen->init_importer($app_id, $data_set,  $time_start, $time_end, $cursor);

        echo json_encode($message);
    }

    function logout()
    {
        $this->session->sess_destroy();
        $this->session->set_flashdata('logout_notification', 'logged_out');
        redirect(base_url() . 'login', 'refresh');
    }


    public function csv($data_set, $app_id)
    {
        if (isset($data_set) && isset($app_id)) :

            $app_code = $this->db->where('app_id', $app_id)->get('apps')->row()->app_code;
            $file = $app_code . "_" . $data_set;
            $folder = "processed";

            $csv_file = fopen(base_url("data/raw/$file.csv"), "r");
            $csv_array = array();
            $file_output = array();

            while ($csv_data = fgetcsv($csv_file, 1000, ",")) {
                $csv_array[] = $csv_data;
            }

            fclose($csv_file);

            echo "reached here";

        // if ($data_set == 'users') :

        //     if (count($csv_array[0]) != 8) {
        //         die('<script>window.location.href="' . base_url() . '"</script>');
        //     }

        //     foreach ($csv_array as $key => $row) {
        //         $row[0] = strtotime($row[0]);
        //         $row[3] = strtotime($row[3]);

        //         for ($point = 0; $point < count($row); $point++) {
        //             if ($row[$point] == '') {
        //                 $row[$point] = 'NULL';
        //             } else {
        //                 $row[$point] = str_replace(',', '...', $row[$point]);
        //             }
        //         }

        //         if ($row[1] == 'Installed' || $row[1] == 'Uninstalled' || $row[1] == 'Closed Store' || $row[1] == 'Re-opened Store')
        //             $file_output[] = "NULL,$app_id,$row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7]";
        //     }
        // endif;

        // if ($data_set == 'finance') :

        //     if (count($csv_array[0]) != 14) {
        //         die('<script>window.location.href="' . base_url() . '"</script>');
        //     }

        //     foreach ($csv_array as $key => $row) {
        //         if ($key > 0) :
        //             $row[0] = strtotime($row[0]);
        //             $row[1] = strtotime($row[1]);
        //             $row[2] = strtotime($row[2]);

        //             for ($point = 0; $point < count($row); $point++) {
        //                 if ($row[$point] == '') {
        //                     $row[$point] = 'NULL';
        //                 } else {
        //                     $row[$point] = str_replace(',', '...', $row[$point]);
        //                 }
        //             }

        //             $file_output[] = "NULL,$app_id,$row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$row[9],$row[10],$row[11],$row[12],$row[13]";
        //         endif;
        //     }
        // endif;
        // 

        // $path = $_SERVER['DOCUMENT_ROOT'] . "/data/$folder";

        // // echo $_SERVER['DOCUMENT_ROOT'];

        // $fp = fopen("$path", "wb");

        // foreach ($file_output as $line) {
        //     $val = explode(",", $line);
        //     fputcsv($fp, $val);
        // }

        // fclose($fp);

        else :
            die('<script>window.location.href="' . base_url() . '"</script>');
        endif;
    }

    public function kwengport_from_file($file)
    {
        $sql = "LOAD DATA 
        LOCAL 
        INFILE '/var/www/ltv/data/processed/$file.csv'
        INTO TABLE `app_users` 
        FIELDS TERMINATED BY ','
        LINES TERMINATED BY '\\n'";

        if ($this->db->query($sql)) {
            echo "$file.csv imported";
        } else {
            print_r($this->db->error());
        }
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
