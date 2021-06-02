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

    public function csv()
    {
        header('Content-Type: application/json');
        $file = fopen(base_url('data/ads_keywords.csv'), 'r');
        $data = array();
        while (($line = fgetcsv($file)) !== FALSE) :
            $data[] = $line;
        endwhile;

        fclose($file);
        print_r(json_encode($data));
    }

    public function transactions($app_id)
    {
        $app = $this->db->where('app_id', $app_id)->get('apps')->row();

        $app_code = $app->app_code;
        $time_start = strtotime('-30 days');
        $time_end = time();

        $response = json_decode($this->install_uninstall($app_code, $time_start, $time_end), TRUE);
        header('Content-Type: application/json');
        $data = json_encode($response);
        echo $data;

        // if (!isset($data['errors'])) {
        //     $events = $response['data']['app']['events']['edges'];
        //     echo json_encode($events);
        //     $data = array();
        // }

    }

    private function install_uninstall($app, $time_start, $time_end)
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
                types: [],
                occurredAtMin: "' . $time_start . '",
                occurredAtMax: "' . $time_end . '"
              ) {
                edges {
                  node {
                    type
                    occurredAt
                    shop {
                      id
                    }
                    ... on RelationshipUninstalled {
                      reason
                      description
                    }
                  }
                }
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
}
