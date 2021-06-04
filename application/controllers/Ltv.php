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

    public function transactions($app_id)
    {
        $app = $this->db->where('app_id', $app_id)->get('apps')->row();

        $app_code = $app->app_code;
        $time_start = strtotime('-30 days');
        $time_end = time();

        echo $app_code, $time_start, $time_end;
        $response = json_decode($this->install_uninstall($app_code, $time_start, $time_end), TRUE);
        header('Content-Type: application/json');
        $data = json_encode($response);
        // echo $data;

        if (!isset($data['errors'])) {
            $events = $response;
            echo json_encode($events);
        }
    }

    private function install_uninstall($app, $time_start, $time_end)
    {
        $partner_id = $this->config->item($app . '_partner_id');
        $app_id = $this->config->item($app . '_app_id');

        $app_url = "https://partners.shopify.com/$partner_id/api/2021-04/graphql.json";

        $time_start = date('c', $time_start);
        $time_end = date('c', $time_end);
        $postData = '
        query {
            transactions(types: [APP_SUBSCRIPTION_SALE], first: 100) {
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
                hasNextPage,
                hasPreviousPage
              }
            }
          }
          ';

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
