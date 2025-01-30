<?php
if (!defined('ABSPATH')) {
    exit;
}

class PPU_API_Handler {
    private static $api_url = 'https://yourserver.com/api/verify-license';

    public static function verify_license($license_key) {
        $response = wp_remote_post(self::$api_url, [
            'body' => [
                'license_key' => $license_key,
                'site_url'    => home_url(),
            ]
        ]);

        if (is_wp_error($response)) {
            return false;
        }

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        return isset($data['status']) && $data['status'] === 'valid';
    }
}
?>
