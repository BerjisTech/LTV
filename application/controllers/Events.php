<?php

class Events extends CI_Controller
{
    public function new($token)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST)) {

            if (!isset($_POST['app_id']) || empty($_POST['app_id'])) {
                $message = array(
                    'status' => 'failed',
                    'message' => 'App ID was not found'
                );
                $this->echo_message($message);
                die();
            }

            $app_id = $_POST['app_id'];

            $app = $this->db->where('app_id', $app_id)->get('apps')->row();

            $app_code = $app->app_code;
            $app_name = $app->app_name;

            $partner_id = $this->config->item($app_code . '_partner_id');
            $app_shopify_id = $this->config->item($app_code . '_app_id');
            $token_primary = $this->config->item($app_code . '_access');
            $token_secondary = $this->config->item($app_code . '_secondary_access');

            $security_token = sha1(md5("$partner_id@$app_shopify_id"));

            if ($token != $security_token) {
                $message = array(
                    'status' => 'failed',
                    'message' => "Invalid token $security_token"
                );
                $this->echo_message($message);
                die();
            }

            if (!isset($_POST['event']) || empty($_POST['event'])) {
                $message = array(
                    'status' => 'failed',
                    'message' => 'Event was not found'
                );
                $this->echo_message($message);
                die();
            }

            if (!isset($_POST['date']) || empty($_POST['date'])) {
                $message = array(
                    'status' => 'failed',
                    'message' => 'Date was not found'
                );
                $this->echo_message($message);
                die();
            }

            if ($this->isTimestamp($_POST['date']) !== true) {
                $message = array(
                    'status' => 'failed',
                    'message' => 'Date must be a unix timestamp'
                );
                $this->echo_message($message);
                die();
            }


            if (!isset($_POST['shop']) || empty($_POST['shop'])) {
                $message = array(
                    'status' => 'failed',
                    'message' => 'Shop cannot be empty'
                );
                $this->echo_message($message);
                die();
            }

            $event_data = array(
                'event_id' => '',
                'app_id' => $_POST['app_id'],
                'event' => $_POST['event'],
                'shop' => $_POST['shop'],
                'date' => $_POST['date'],
                'email' => $_POST['email'],
            );

            $event_data = $this->security->xss_clean($event_data);

            if ($this->db->insert('shop_events', $event_data)) {
                $message = array(
                    'status' => 'success',
                    'message' => 'Event succesfully captured'
                );
                $this->echo_message($message);
                die();
            }
        } else {
            $message = array(
                'status' => 'error',
                'message' => 'No data was sent'
            );
            $this->echo_message($message);
            die();
        }
    }

    private function echo_message($message)
    {
        header('Content-Type: application/json');
        echo json_encode($message);
    }

    private function isTimestamp($timestamp)
    {
        if (
            ctype_digit($timestamp) && 
            strtotime(date('Y-m-d H:i:s', $timestamp)) === (int)$timestamp &&
            $timestamp > strtotime('01-01-2013') &&
            $timestamp <= 2147483647) {
            return true;
        } else {
            return false;
        }
    }
}
