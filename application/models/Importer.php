<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Importer extends CI_Model
{
    function init_importer($app_id, $data_set, $cursor = '')
    {
        $app = $this->db->where('app_id', $app_id)->get('apps')->row();

        $app_code = $app->app_code;
        $partner_id = $this->config->item($app_code . '_partner_id');
        $app_shopify_id = $this->config->item($app_code . '_app_id');

        if ($app_id == 3 || $app_id == 4 || $app_id == 5) {
            $app_code = 'wod';
            $partner_id = $this->config->item('wod_partner_id');
        }

        return array(
            'App' => $app->app_name,
            'App ID' => $app_id,
            'App Code' => $app_code,
            'Partner' => $partner_id,
            'Shopify ID' => $app_shopify_id
        );
    }

    function send_to_db($app_id, $table, $data)
    {
    }

    private function api_users_data($partner_id, $app_id, $time_start, $time_end, $cursor)
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
}
