<?php

use GuzzleHttp\Client;
use Guzzle\Http\EntityBody;

class OrderControllerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    /** @test **/
    public function stripe_web_hook_receives_data()
    {
        $request = ['json' => [
            'id' => 'evt_83iMlyu9yjpiHl',
            'object' => 'event',
            'api_version' => '2016-02-29',
            'created' => 1457643798,
            'data' => [
                'object' => [
                    'id' => 'cus_80jdLyz4b3Heyy',
                    'object' => 'customer',
                    'account_balance' => 0,
                    'created' => 1456956563,
                    'currency' => NULL,
                    'default_source' => 'card_80jco7MDRPwx7e',
                    'delinquent' => false,
                    'description' => 'sotonin@gmail.com',
                    'discount' => NULL,
                    'email' => 'sotonin@gmail.com',
                    'livemode' => false,
                    'metadata' => [],
                    'shipping' => '',
                    'sources' => [
                        'object' => 'list',
                        'data' => [
                            [
                                'id' => 'card_80jco7MDRPwx7e',
                                'object' => 'card',
                                'address_city' => 'West Palm Beach',
                                'address_country' => 'United States',
                                'address_line1' => '419 50th Street',
                                'address_line1_check' => 'pass',
                                'address_line2' => NULL,
                                'address_state' => 'FL',
                                'address_zip' => '33407',
                                'address_zip_check' => 'pass',
                                'brand' => 'Visa',
                                'country' => 'US',
                                'customer' => 'cus_80jdLyz4b3Heyy',
                                'cvc_check' => 'pass',
                                'dynamic_last4' => NULL,
                                'exp_month' => 12,
                                'exp_year' => 2019,
                                'fingerprint' => 'xJswv8vAmzAbugZr',
                                'funding' => 'credit',
                                'last4' => '4242',
                                'metadata' => [],
                                'name' => 'Kevin Holland',
                                'tokenization_method' => NULL,
                            ]
                        ],
                        'has_more' => false,
                        'total_count' => 1,
                        'url' => '/v1/customers/cus_80jdLyz4b3Heyy/sources',
                    ],
                    'subscriptions' => [
                        'object' => 'list',
                        'data' => [],
                        'has_more' => false,
                        'total_count' => 0,
                        'url' => '/v1/customers/cus_80jdLyz4b3Heyy/subscriptions',
                    ]
                ]
            ],
            'livemode' => false,
            'pending_webhooks' => 1,
            'request' => 'req_83iMWrWZUOdAhQ',
            'type' => 'customer.deleted',
        ]];

        $guzzle = new Client();
        $response = $guzzle->post(url('/stripe-web-hook'), $request);
        $body = collect(json_decode((string)$response->getBody()));
        dd($body);
    }
}
