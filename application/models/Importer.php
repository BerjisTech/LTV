<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Importer extends CI_Model
{
    function init_importer($app_id, $data_set, $time_start, $time_end, $cursor = '')
    {
        $app = $this->db->where('app_id', $app_id)->get('apps')->row();

        $app_code = $app->app_code;
        $app_name = $app->app_name;

        $partner_id = $this->config->item($app_code . '_partner_id');
        $app_shopify_id = $this->config->item($app_code . '_app_id');
        $token_primary = $this->config->item($app_code . '_access');
        $token_secondary = $this->config->item($app_code . '_secondary_access');

        if ($app_id == 3 || $app_id == 4 || $app_id == 5) {
            $app_code = 'wod';
            $partner_id = $this->config->item('wod_partner_id');
            $token_primary = $this->config->item($app_code . '_access');
            $token_secondary = $this->config->item($app_code . '_secondary_access');
        }

        $extra_data = array();
        $data_table = '';

        if ($data_set == 'users') {
            $extra_data = $this->api_users_data($partner_id, $token_primary, $app_shopify_id, $time_start, $time_end, $cursor);
            $data_table = 'shopify_data';
        }

        if ($data_set == 'financials') {
            $extra_data = $this->api_financial_data($partner_id, $token_primary, $app_shopify_id, $time_start, $time_end, $cursor);
            $data_table = 'app_financials';
        }

        $processed_data = $this->process_user_data($extra_data, $data_table, $app_id, $time_start, $time_end);

        return array(
            'App' => $app_name,
            'App ID' => $app_id,
            'App Code' => $app_code,
            'Partner' => $partner_id,
            'Shopify ID' => $app_shopify_id,
            'Primary Token' => $token_primary,
            'Secondary Token' => $token_secondary,
            'From' => date('c', $time_start),
            'To' => date('c', $time_end),
            'Processed Data' => $processed_data,
            'Fetched Data' => json_decode($extra_data, TRUE)
        );
    }

    function process_user_data($data, $table, $app_id, $time_start, $time_end)
    {
        $received_data = json_decode($data, TRUE);
        $processed_data = array();

        if (!isset($received_data['data'])) {
            $processed_data = json_encode(array(
                'status' => '500',
                'app' => $app_id,
                'cursor' => 'DONE',
                'message' => 'No data received'
            ));
            die();
        }

        if (!isset($received_data['errors']) && $received_data !== null) {
            if ($table == 'shopify_data') {
                $processed_data = $received_data['data']['app']['events'];
            }
            if ($table == 'app_financials') {
                $processed_data = $received_data['data']['transactions'];
            }
        }

        $next_page = $processed_data['pageInfo']['hasNextPage'];
        $back_page = $processed_data['pageInfo']['hasPreviousPage'];

        $required_data =  $processed_data['edges'];

        $back_cursor = '';
        $next_cursor = '';

        if ($next_page != '') {
            $next_cursor = $required_data[count($required_data) - 1]['cursor'];
        }
        if ($back_page != '') {
            $back_cursor = $required_data[0]['cursor'];
        }

        $db_stage = $this->send_to_db($app_id, $table, $required_data, $time_start, $time_end, $next_cursor);

        return array(
            'Next Page' => $next_page,
            'Next Cursor' => $next_cursor,
            'Back Page' => $back_page,
            'Back Cursor' => $back_cursor,
            'DB Stage' => $db_stage
        );
    }

    function send_to_db($app_id, $table, $data, $time_start, $time_end, $next_cursor)
    {
        $rows = '';

        if ($table == 'shopify_data') {
            $rows = $this->get_user_rows($app_id, $data, $time_start, $time_end);
            $table_rows = "`data_id`, `app_id`, `date`, `event`, `details`, `billing_date`, `shop`, `country`, `email`, `domain`, `cursor`";
        }
        if ($table == 'app_financials') {
            $rows = $this->get_finance_rows($app_id, $data, $time_start, $time_end);
            $table_rows = "`finance_id`, `app_id`, `date`, `app_version`, `amount`, `shop`, `domain`, `cursor`";
        }

        $values = $rows['value'];

        if (isset($values) && !empty($values)) {
            $query = "INSERT INTO `$table` ($table_rows) VALUES " . $values;

            if ($this->db->query($query) && $next_cursor != '') {
                $user_message = array(
                    'status' => '200',
                    'app' => $app_id,
                    'cursor' => $next_cursor,
                    'total_data' => count($data)
                );
            }
            if ($next_cursor == '') {
                $user_message = array(
                    'status' => '200',
                    'app' => $app_id,
                    'cursor' => 'DONE',
                    'total_data' => count($data)
                );
            }
        } else {
            $user_message = array(
                'status' => '500',
                'app' => $app_id,
                'cursor' => 'DONE',
                'message' => $values
            );
        }

        return array(
            'rows' => $rows,
            'message' => $user_message
        );
    }

    function get_user_rows($app_id, $data, $time_start, $time_end)
    {
        $values = '';
        $indices = array();
        $founds = array();

        // $where = "`app_id` = $app_id AND `date` >= '" . $time_start . "' AND `date` <='" . $time_end . "'";
        $check_existence = $this->db->select('app_id, date, event, details, shop, domain')->where('app_id', $app_id)->get('shopify_data')->result_array();

        foreach ($data as $user) {
            $cursor = $user['cursor'];
            $date = strtotime($user['node']['occurredAt']);
            $event = strtolower(str_replace('RELATIONSHIP_', '', $user['node']['type']));
            $shop = str_replace('gid://partners/Shop/', '', $user['node']['shop']['id']);
            $domain = $user['node']['shop']['myshopifyDomain'];
            $reason = '';

            if (isset($user['node']['reason'])) {
                $reason = str_replace("'", '%27', strtolower($user['node']['reason']));
            }


            $row_array = array(
                'app_id' => $app_id,
                'date' => $date,
                'event' => $event,
                'details' => $reason,
                'shop' => $shop,
                'domain' => $domain,
                'cursor' => $cursor
            );

            $index = in_array($row_array, $check_existence, TRUE);

            if ($index == false) {
                $values .= " ('','$app_id','$date','$event','$reason','','$shop','','','$domain','$cursor'),";
            } else {
                echo "Hii ya $shop already iko";
            }

            $indices[] = $index;
        }

        return array(
            'formTime' => $time_start,
            'toTime' => $time_end,
            'fount at' => $indices,
            'value' => substr_replace($values, "", -1)
        );
    }

    function get_finance_rows($app_id, $data, $time_start, $time_end)
    {
        $values = '';
        $indices = array();

        // $where = "`app_id` = $app_id AND `date` >= '" . $time_start . "' AND `date` <='" . $time_end . "'";
        $check_existence = $this->db->select('app_id, date, app_version, amount, shop, domain')->where('app_id', $app_id)->get('app_financials')->result_array();

        foreach ($data as $finance) {
            $cursor = $finance['cursor'];
            $date = strtotime($finance['node']['createdAt']);
            $app_version = $finance['node']['app']['name'];
            $amount = $finance['node']['netAmount']['amount'];
            $shop = str_replace('gid://partners/Shop/', '', $finance['node']['shop']['id']);
            $domain = $finance['node']['shop']['myshopifyDomain'];

            $row_array = array(
                'app_id' => $app_id,
                'date' => $date,
                'app_version' => $app_version,
                'amount' => $amount,
                'shop' => $shop,
                'domain' => $domain,
                'cursor' => $cursor
            );

            $index = in_array($row_array, $check_existence, TRUE);

            if ($index == false) {
                $values .= " ('','$app_id','$date','$app_version','$amount','$shop','$domain','$cursor'),";
            }

            $indices[] = $index;
        }

        return array(
            'formTime' => $time_start,
            'toTime' => $time_end,
            'fount at' => $indices,
            'value' => substr_replace($values, "", -1)
        );
    }

    private function api_users_data($partner_id, $token, $app_id, $time_start, $time_end, $cursor = '')
    {

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
                        after: "' . $cursor . '",
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
                'X-Shopify-Access-Token: ' . $token
            ),
            CURLOPT_POSTFIELDS => $requestBody
        ));

        // Send the request
        $response = curl_exec($ch);

        // echo '<script> console.log(' . $response . ')</script>';
        return $response;
    }

    private function api_financial_data($partner_id, $token_primary, $app_id, $time_start, $time_end, $cursor)
    {

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
                                        id,
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
                'X-Shopify-Access-Token: ' . $token_primary
            ),
            CURLOPT_POSTFIELDS => $requestBody
        ));

        // Send the request
        $response = curl_exec($ch);

        // echo '<script> console.log(' . $response . ')</script>';
        return $response;
    }
}
