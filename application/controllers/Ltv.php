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

    public function import_shopify_users($app_id, $cursor = '')
    {
        $app = $this->db->where('app_id', $app_id)->get('apps')->row();

        $app_code = $app->app_code;

        $last_counter = $this->db->order_by('date', 'DESC')->limit(1)->get('shopify_data');

        $time_start = strtotime('-3000 days');

        if ($last_counter->num_rows() == 1 && isset($last_counter->row()->date)) {
            $time_start = $last_counter->row()->date;
        }
        $time_end = time();

        $response = json_decode($this->api_users_data($app_code, $time_start, $time_end, $cursor), TRUE);

        // header('Content-Type: application/json');
        $data = json_encode($response);
        // echo $data;

        if (!isset($response['data'])) {
            echo json_encode(array(
                'status' => '500',
                'app' => $app_id,
                'cursor' => 'DONE',
                'message' => 'No data received'
            ));
            die();
        }

        if (!isset($data['errors']) && $data !== null) {
            // echo json_encode($response['data']);
            $user_nodes = $response['data']['app']['events']['edges'];
            $next_page = $response['data']['app']['events']['pageInfo']['hasNextPage'];
            $previous_page = $response['data']['app']['events']['pageInfo']['hasPreviousPage'];
            $previous_cursor = '';
            $next_cursor = '';

            if ($previous_page != '') {
                $previous_cursor = $user_nodes[0]['cursor'];
            }
            if ($next_page != '') {
                $next_cursor = $user_nodes[count($user_nodes) - 1]['cursor'];
            }

            $values = '';

            foreach ($user_nodes as $user) {
                $date = strtotime($user['node']['occurredAt']);
                $event = strtolower(str_replace('RELATIONSHIP_', '', $user['node']['type']));
                $shop = str_replace('gid://partners/Shop/', '', $user['node']['shop']['id']);
                $domain = $user['node']['shop']['myshopifyDomain'];
                $cursor = $user['cursor'];
                $reason = '';

                if (isset($user['node']['reason'])) {
                    $reason = str_replace("'", '%27', strtolower($user['node']['reason']));
                }

                $check_existence = $this->db
                    ->where('app_id', $app_id)
                    ->where('date', $date)
                    ->where('event', $event)
                    ->where('details', $reason)
                    ->where('shop', $shop)
                    ->where('domain', $domain)
                    ->get('shopify_data');

                if ($check_existence->num_rows() == 0) {
                    $values .= " ('','$app_id','$date','$event','$reason','','$shop','','','$domain'),";
                }
            }

            if (isset($values) && !empty($values)) {
                $query = "INSERT INTO `shopify_data` (`data_id`, `app_id`, `date`, `event`, `details`, `billing_date`, `shop`, `country`, `email`, `domain`) VALUES " . substr_replace($values, "", -1);

                if ($this->db->query($query) && $next_cursor != '') {
                    echo json_encode(array(
                        'status' => '200',
                        'app' => $app_id,
                        'cursor' => $next_cursor,
                        'total_data' => count($user_nodes)
                    ));
                }
                if ($next_cursor == '') {
                    echo json_encode(array(
                        'status' => '200',
                        'app' => $app_id,
                        'cursor' => 'DONE',
                        'total_data' => count($user_nodes)
                    ));
                }
            } else {
                echo json_encode(array(
                    'status' => '500',
                    'app' => $app_id,
                    'cursor' => 'DONE',
                    'message' => $data
                ));
            }
        } else {
            echo json_encode(array(
                'status' => '500',
                'app' => $app_id,
                'cursor' => 'DONE',
                'message' => $data['errors']
            ));
        }
    }

    public function update_subscription($app_id, $cursor = '')
    {
        $app = $this->db->where('app_id', $app_id)->get('apps')->row();

        $app_code = $app->app_code;
        $time_start = strtotime('-30 days');
        $time_end = time();

        $response = json_decode($this->api_subscriptions_data($app_code, $time_start, $time_end, $cursor), TRUE);

        header('Content-Type: application/json');
        $data = json_encode($response);
        // echo $data;

        if (!isset($data['errors']) && $data !== null) {
            $events = $response;
            echo json_encode($events['data']);
        }
    }

    private function api_users_data($app, $time_start, $time_end, $cursor)
    {
        $partner_id = $this->config->item($app . '_partner_id');
        $app_id = $this->config->item($app . '_app_id');

        $app_url = "https://partners.shopify.com/$partner_id/api/2021-04/graphql.json";

        $time_start = date('c', $time_start);
        $time_end = date('c', $time_end);

        $postData = '
            {
                app(id: "gid://partners/App/' . $app_id . '") {
                    id
                    name
                    events(
                        first: 100,
                        after: "' . $cursor . '"
                        types: [RELATIONSHIP_REACTIVATED RELATIONSHIP_DEACTIVATED RELATIONSHIP_INSTALLED RELATIONSHIP_UNINSTALLED],
                        occurredAtMin: "' . $time_start . '",
                        occurredAtMax: "' . $time_end . '"
                        ) {
                            edges {
                                cursor 
                                node {
                                    type
                                    occurredAt
                                    shop {
                                        id,
                                        myshopifyDomain
                                    }
                                    ... on RelationshipUninstalled {
                                        reason
                                        description
                                    }
                                }
                            }
                            pageInfo { 
                                hasPreviousPage 
                                hasNextPage 
                            } 
                        }
                    }
                }';

        $requestBody = $postData; // json_encode($postData);
        $ch = curl_init($app_url);
        curl_setopt_array($ch, array(
            CURLOPT_POST => TRUE,
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_SSL_VERIFYHOST => FALSE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/graphql',
                'X-Shopify-Access-Token: ' . $this->config->item('icu_access')
            ),
            CURLOPT_POSTFIELDS => $requestBody
        ));

        // Send the request
        $response = curl_exec($ch);

        // echo '<script> console.log(' . $response . ')</script>';
        return $response;
    }

    private function api_subscriptions_data($app, $time_start, $time_end, $cursor)
    {
        $partner_id = $this->config->item($app . '_partner_id');
        $app_id = $this->config->item($app . '_app_id');

        $app_url = "https://partners.shopify.com/$partner_id/api/2021-04/graphql.json";

        $time_start = date('c', $time_start);
        $time_end = date('c', $time_end);
        $postData = '
            {
                transactions (
                    types: [APP_SUBSCRIPTION_SALE ], 
                    after: "' . $cursor . '", 
                    createdAtMin: "' . $time_start . '", 
                    createdAtMax:"' . $time_end . '", 
                    first: 100) { 
                        edges { 
                            cursor 
                            node { 
                                id, 
                                createdAt, 
                                ... on AppSubscriptionSale { 
                                    netAmount { 
                                        amount 
                                    }, 
                                    app { 
                                        name 
                                    }, 
                                    shop {  
                                        myshopifyDomain 
                                    } 
                                }, 
                                ... on ServiceSale { 
                                    netAmount {  
                                        amount 
                                    }, 
                                    shop {  
                                        myshopifyDomain 
                                    } 
                                } 
                            } 
                        }, 
                        pageInfo { 
                            hasPreviousPage 
                            hasNextPage 
                        } 
                    } 
                }';

        $requestBody = $postData; // json_encode($postData);
        $ch = curl_init($app_url);
        curl_setopt_array($ch, array(
            CURLOPT_POST => TRUE,
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_SSL_VERIFYHOST => FALSE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/graphql',
                'X-Shopify-Access-Token: ' . $this->config->item('icu_access')
            ),
            CURLOPT_POSTFIELDS => $requestBody
        ));

        // Send the request
        $response = curl_exec($ch);

        // echo '<script> console.log(' . $response . ')</script>';
        return $response;
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
