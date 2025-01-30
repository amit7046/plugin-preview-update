<?php

if (!defined('ABSPATH')) {
    exit;
}

class Plugin_Updater {

    private $plugin_slug;
    private $plugin_version;
    private $api_url;
    private $license_key;

    public function __construct($plugin_slug, $plugin_version, $api_url, $license_key) {
        $this->plugin_slug = $plugin_slug;
        $this->plugin_version = $plugin_version;
        $this->api_url = $api_url;
        $this->license_key = $license_key;

        add_filter('pre_set_site_transient_update_plugins', [$this, 'check_for_update']);
        add_filter('plugins_api', [$this, 'plugin_api_data'], 10, 3);
        add_action('admin_notices', [$this, 'preview_update_notice']);
    }

    public function check_for_update($transient) {
        if (empty($transient->checked)) {
            return $transient;
        }

        $response = $this->api_request('update_check');

        if ($response && version_compare($this->plugin_version, $response->new_version, '<')) {
            $transient->response[$this->plugin_slug] = (object) [
                'slug'        => $this->plugin_slug,
                'new_version' => $response->new_version,
                'url'         => $response->homepage,
                'package'     => $response->download_url
            ];
        }

        return $transient;
    }

    public function plugin_api_data($result, $action, $args) {
        if ($action !== 'plugin_information' || $args->slug !== $this->plugin_slug) {
            return $result;
        }

        $response = $this->api_request('plugin_info');

        if (!$response) {
            return $result;
        }

        return (object) [
            'name'          => $response->name,
            'slug'          => $this->plugin_slug,
            'version'       => $response->new_version,
            'author'        => $response->author,
            'homepage'      => $response->homepage,
            'sections'      => [
                'description' => $response->description,
                'changelog'   => $response->changelog
            ],
            'download_link' => $response->download_url
        ];
    }

    private function api_request($action) {
        $response = wp_remote_post($this->api_url, [
            'body' => [
                'action'       => $action,
                'license_key'  => $this->license_key,
                'plugin_slug'  => $this->plugin_slug,
                'version'      => $this->plugin_version
            ]
        ]);

        if (is_wp_error($response)) {
            return false;
        }

        return json_decode(wp_remote_retrieve_body($response));
    }

    public function preview_update_notice() {
        if (isset($_GET['ppu_preview_update']) && $_GET['ppu_preview_update'] === 'true') {
            echo '<div class="notice notice-warning"><p>Preview mode enabled. Test the plugin update before finalizing.</p></div>';
        }
    }
}
