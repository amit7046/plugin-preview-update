<?php
if (!defined('ABSPATH')) exit;

// Check user capabilities
function ppu_check_permissions() {
    if (!current_user_can('manage_options')) {
        wp_die('Unauthorized access');
    }
}
