<?php

if (!defined('ABSPATH')) {
    exit;
}

class License_Handler {

    private $api_url;
    private $license_key;

    public function __construct($api_url, $license_key) {
        $this->api_url = $api_url;
        $this->license_key = $license_key;
    }

    public function activate_license() {
        $response = wp_remote_post($this->api_url, [
            'body' => [
                'action'      => 'activate_license',
                'license_key' => $this->license_key,
                'site_url'    => home_url()
            ]
        ]);

        return json_decode(wp_remote_retrieve_body($response));
    }

    public function check_license() {
        $response = wp_remote_post($this->api_url, [
            'body' => [
                'action'      => 'check_license',
                'license_key' => $this->license_key
            ]
        ]);

        return json_decode(wp_remote_retrieve_body($response));
    }
}
